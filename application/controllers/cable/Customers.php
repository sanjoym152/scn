<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
		$this->load->helper('pdf_helper');
        $this->load->library('upload');
    }

	public function index(){
		$where=array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		$joins[1]=array(
			'table'=>AREA,
			'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
			'jointype'=>'left'
		);
		
		if($this->input->post('keyword')){
			$where["(first_name LIKE '%".$this->input->post('keyword')."%' OR last_name LIKE '%".$this->input->post('keyword')."%')"]=null;
		}
		if($this->input->post('status')){
			$customer_type = $this->input->post('status');
			if($customer_type == 1 || $customer_type == 2 || $customer_type == 3){
				$where[CBL_CUSTOMERS.'.status'] = $customer_type;
			}else if($customer_type == 4){
				//paid
				$where['last_payment_month'] = date('m'); 
			}else if($customer_type == 5){
				$where['last_payment_month != '] = date('m'); 
			}
		}else{
			$where[CBL_CUSTOMERS.'.status'] = 1;// for default active customers.
		}
		$total_rows = count($this->common_model->get_data_array(CBL_CUSTOMERS,$where,"*,".CBL_CUSTOMERS.'.status as c_status',$joins));
		$page = ($this->uri->segment(4)?$this->uri->segment(4):'');
		$data['customers'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,"*,".CBL_CUSTOMERS.'.status as c_status', $joins, PAGE_LIMIT, $page);
		$data['paginationLink'] = $this->utilitylib->pagination(base_url('cable/customers/index/'),$total_rows, PAGE_LIMIT, 4);
		//echo $this->db->last_query();die;
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_STB_MODEL,
			'condition'=>CBL_STB_MODEL.'.stb_model_id = '.CBL_CUSTOMER_TO_STB.'.stb_model_id',
			'jointype'=>'inner'
		);
		foreach($data['customers'] as $k=>$v){
			$data['customers'][$k]['ip'] = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$v['customer_id']),'',$joins);
		}
		/* echo "<pre>";
		print_r($data['customers']);die; */
		$data['total_due_active'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array('status'=>1),'sum(balance) as total_due');
		$data['total_due_inactive'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array('status'=>2),'sum(balance) as total_due');
		$data['total_due_delete'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array('status'=>3),'sum(balance) as total_due');
		$data['total_payment'] = $this->common_model->get_data_row(CBL_PAYMENT,array('type'=>1),'sum(payment_total) as payment');
		$data['package'] = $this->common_model->get_data_array(CBL_PACKAGE,array('status'=>1),'','','','','','pakname ASC');
		$data['collector'] = $this->common_model->get_data_array(STAFF);
		$data['pageTitle'] = "SCN | CABLE | CUSTOMERS";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customers', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			/* echo "<pre>";
			print_r($this->input->post());die; */
			$insert_array = $this->input->post();
			unset($insert_array['stb_no']);
			unset($insert_array['account']);
			unset($insert_array['stb_model']);
			
			$insert_array['added_date'] = date('Y-m-d H:i:s');
			if(@$id){
				$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$id),$insert_array);
			}else{
				$package = $this->common_model->get_data_row(CBL_PACKAGE,array('package_id'=>$this->input->post('package_id')));
				$insert_array['balance'] = $insert_array['pack_amount'] + $insert_array['stb_amount'] + $this->input->post('balance');
				$insert_array['status'] = 1;
				/* echo "<pre>";
				print_r($insert_array);die; */
				$id = $this->common_model->tbl_insert(CBL_CUSTOMERS,$insert_array);
				
				$cust_code = 'CUST00'.$id;
				$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$id),array('cust_code'=>$cust_code));
				/*
				@ upload address proof
				*/
				$insert_array = array();
				if($_FILES['address_proof']){
                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['file_name']             = time().rand(11111,99999);
                    $config['max_size']             = 10000;
                    $config['max_width']            = 1024;
                    $config['max_height']           = 768;

                    $this->upload->initialize($config);
                    if ( ! $this->upload->do_upload('address_proof')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->utilitylib->setMsg(SUCCESS_ICON.' '.$this->upload->display_errors(),'ERROR');
                    }
                    else {
                        $insert_array['address_attachment'] = $this->upload->data('file_name');
                    }
                }
                if($_FILES['caf_page1']){
                    $config = array();
                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['file_name']             = time().rand(11111,99999);
                    $config['max_size']             = 10000;
                    $config['max_width']            = 1024;
                    $config['max_height']           = 768;
                    $this->upload->initialize($config);
                    if ( ! $this->upload->do_upload('caf_page1')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->utilitylib->setMsg(SUCCESS_ICON.' '.$this->upload->display_errors(),'ERROR');
                    }
                    else {
                        $insert_array['caf_page1'] = $this->upload->data('file_name');
                    }
                }
                if($_FILES['caf_page2']){
                    $config = array();
                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['file_name']             = time().'saf2'.rand(11111,99999);
                    $config['max_size']             = 10000;
                    $config['max_width']            = 1024;
                    $config['max_height']           = 768;

                    $this->upload->initialize($config);
                    if ( ! $this->upload->do_upload('caf_page2')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->utilitylib->setMsg(SUCCESS_ICON.' '.$this->upload->display_errors(),'ERROR');
                    }
                    else {
						/* echo "<pre>";
						print_r($this->upload->data());die; */
                        $insert_array['caf_page2'] = $this->upload->data('file_name');
                    }
                }
				if(@$insert_array['address_attachment'] || @$insert_array['caf_page2'] || @$insert_array['caf_page1']) {
					$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$id),$insert_array);
				}
                
				//insert into payment table as add topup
				$insert_array=array();
				$insert_array['package_id'] = $this->input->post('package_id');
				$insert_array['customer_id'] = $id;
				$insert_array['pack_amount'] = $package['tot_amount'];
				$insert_array['outstanding'] = $this->input->post('balance');
				$insert_array['net_due'] = $package['tot_amount'];
				$insert_array['is_added_time'] = 1;
				$insert_array['payment_total'] = $package['tot_amount']+$this->input->post('balance');
				$insert_array['payment_date'] = $this->input->post('billing_date');
				$insert_array['staff_id'] = $this->input->post('staff_id');
				$insert_array['type'] = 2;
				//$insert_array['installation_charge'] = $this->input->post('installation_amount');
				//$this->common_model->tbl_insert(PAYMENT,$insert_array);
				
			}
			if($this->input->post('stb_no')){
				$this->common_model->tbl_record_del(CBL_CUSTOMER_TO_STB,array('customer_id'=>$id));
				$insert_array2 = $this->input->post();
				foreach($this->input->post('stb_no') as $k=>$v){
					if(@$v && @$insert_array2['account'][$k]){
						$this->common_model->tbl_insert(CBL_CUSTOMER_TO_STB,array('customer_id'=>$id,'stb_no'=>$v,'account'=>@$insert_array2['account'][$k],'stb_model_id'=>@$insert_array2['stb_model'][$k]));
					}
				}
			}
			
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('cable/customers'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$id));
			$data['details']['ip'] = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$id));
		}
		$data['area'] = $this->common_model->get_data_array(AREA,'','','','','','','area_name ASC');
		$data['package'] = $this->common_model->get_data_array(CBL_PACKAGE,'','','','','','','pakname ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['isp'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['collector'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['stb'] = $this->common_model->get_data_array(CBL_STB_MODEL,array('status'=>1),'','','','','','stb_model_no ASC');
		$data['pageTitle'] = "SCN | CABLE | ADD CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_add', $data);
	}
	
	public function delete_record($id=null){
		if($id==null){
			redirect(base_url('cable/customers'));
		}
		$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$id),array('status'=>3));	
		//$this->common_model->tbl_record_del(CBL_CUSTOMERS,array('customer_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('cable/customers'));
	}
	
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('cable/customers'));
		}
		$status = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$id),array('status'=>1));
		}
		
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('cable/customers'));
	}
	
	public function chk_email(){
		$where=array();
		$where['email'] = $this->input->post('email');
		if($this->input->post('customer_id')){
			$where['customer_id <> '] = $this->input->post('customer_id');
		}
		
		echo $tot = count($this->common_model->get_data_array(CBL_CUSTOMERS,array('email'=>$this->input->post('email'),'customer_id <>'=>$this->input->post('customer_id'))));
	}
	
	public function check_other_id(){
		$where=array();
		$where['other_id'] = $this->input->post('other_id');
		$where['area_id'] = $this->input->post('area_id');
		//$where["(other_id = '".$this->input->post('other_id')."' OR area_id = '".$this->input->post('area_id')."')"]=null;
		$where['status <>'] = 3;
		if($this->input->post('customer_id')){
			$where['customer_id <> '] = $this->input->post('customer_id');
		}
		$tot = count($this->common_model->get_data_array(CBL_CUSTOMERS,$where));
		//echo $this->db->last_query();
		//print_r($tot);
		echo json_encode(array('STATUS'=>($tot>0)?'EXIST':'NOT_EXIST'));
	}
	
	public function check_username(){
		$where=array();
		$where['username'] = $this->input->post('username');
		if($this->input->post('customer_id')){
			$where['customer_id <> '] = $this->input->post('customer_id');
		}
		$tot = count($this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,$where));
		echo $tot = count($this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,$where));
	}
	
	public function check_ip(){
		$where=array();
		$where['ip_address'] = $this->input->post('ip');
		if($this->input->post('customer_id')){
			$where['customer_id <>'] = $this->input->post('customer_id');
		}
		echo $tot = count($this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,$where));
	}
	
	public function get_customer_data(){
		$customer_id = $this->input->post('customer_id');
		$joins = array();
		$joins[0] = array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[1] = array(
			'table'=>CBL_LCO,
			'condition'=>CBL_LCO.'.lco_id = '.CBL_CUSTOMERS.'.lco_id',
			'jointype'=>'inner'
		);
		$joins[2] = array(
			'table'=>CBL_MSO,
			'condition'=>CBL_MSO.'.isp_id = '.CBL_CUSTOMERS.'.mso_id',
			'jointype'=>'inner'
		);
		$data['customer'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$customer_id),'',$joins);
		$customer_ip = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$customer_id));
		$data['ip_data'] = '';
		foreach($customer_ip as $row){
			$data['ip_data'] = '<div class="col-md-6">'.$row['stb_no'].'</div>';
		}
		$data['last_payment'] = $this->common_model->get_data_row(CBL_PAYMENT, array('customer_id'=>$customer_id, 'type'=>1),'','','payment_id');
		$data['customer_info'] = $this->load->view('cable/ajax/payment_customer_info',$data,true);
		echo json_encode($data);
	}
	
	public function payment(){
		
		$insert_array=array();
		$customer_data = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')));
		$insert_array['customer_id'] = $this->input->post('customer_id');
		$insert_array['payment_date'] = $this->input->post('payment_date');
		$insert_array['payment_total'] = $this->input->post('payment_total');
		$insert_array['sub_total'] = $this->input->post('payment_total')+$this->input->post('discount_total');
		$insert_array['outstanding'] = $customer_data['balance'];
		$insert_array['net_due'] = $this->input->post('net_due');
		$insert_array['pack_amount'] = $this->input->post('pack_amount');
		$insert_array['package_id'] = $this->input->post('package_id');
		$insert_array['staff_id'] = $this->input->post('staff_id');
		$insert_array['discount_in'] = $this->input->post('discount_in');
		$insert_array['discount_type'] = $this->input->post('discount_type');
		$insert_array['discount_total'] = $this->input->post('discount_total');
		$insert_array['type']=			1;
		if($this->input->post('month_of')){
			$insert_array['month_of'] = $this->input->post('month_of');
		}
		$payment_id = $this->common_model->tbl_insert(CBL_PAYMENT,$insert_array);
		$c_array=array();
		$c_array['balance'] = $this->input->post('net_due');
		
		$c_array['payment_status']=2;
		$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')),$c_array);
		$this->utilitylib->setMsg(SUCCESS_ICON.' Payment was success!','SUCCESS');
		redirect(base_url('cable/customers/bill_print/'.$payment_id));
	}
	
	public function bill_print($id=null){
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$joins[3]=array(
			'table'=>CBL_CUSTOMER_TO_STB,
			'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		);
		$data['userdata'] = $this->common_model->get_data_row(CBL_PAYMENT,array(CBL_PAYMENT.'.payment_id'=>$id),'*,'.CBL_PAYMENT.'.discount_total as p_discount',$joins);
		/* echo "<pre>";
		print_r($data['userdata']);die; */
		$data['pageTitle'] = "SCN | Internet | Bill Print";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/bill_print', $data);
	}
	
	public function topup_bill_print($id=null){
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$joins[3]=array(
			'table'=>CBL_CUSTOMER_TO_STB,
			'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		);
		$data['userdata'] = $this->common_model->get_data_row(CBL_PAYMENT,array(CBL_PAYMENT.'.payment_id'=>$id),'*,'.CBL_PAYMENT.'.discount_total as p_discount',$joins);
		/* if($data['userdata']['package_tax_type']==2){
			$data['tax'] = $this->common_model->get_data_array(CBL_PACKAGE_TO_TAX,array('package_id'=>$data['userdata']['package_id']));
		} */
		//echo $this->db->last_query();die;
		/* echo "<pre>";
		print_r($data);die; */
		$data['pageTitle'] = "SCN | CABLE | Top Up Bill Print";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/topup_bill_print', $data);
	}
	
	public function billing(){
		$customer_id = $this->input->post('customer_id');
		$month = $this->input->post('month');
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_PAYMENT,
			'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_PAYMENT.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$data['billing'] = $this->common_model->get_data_array(CBL_CUSTOMERS,array(CBL_PAYMENT.'.customer_id'=>$customer_id),'*,'.CBL_PAYMENT.'.discount_total as dis,'.CBL_PAYMENT.'.outstanding as p_balance',$joins,'','','','payment_id desc');
		
		$total_payment = $this->common_model->get_data_row(CBL_PAYMENT,array('customer_id'=>$customer_id,'type'=>1),'sum('.CBL_PAYMENT.'.payment_total) as total');// payment
		$bill = $this->common_model->get_data_row(CBL_PAYMENT,array('customer_id'=>$customer_id,'type'=>2),'sum('.CBL_PAYMENT.'.payment_total) as total');// bill
		//echo json_encode(array('q'=>$this->db->last_query()));
		$billing_table = $this->load->view('cable/ajax/billing',$data,true);
		echo json_encode(array('status'=>'success','table'=>$billing_table,'payment_total'=>'PAID AMOUNT: '.$total_payment['total'],'bill'=>'BILL AMOUNT: '.$bill['total']));
	}
	public function ledger(){
		$customer_id = $this->input->post('customer_id');
		$month = $this->input->post('month');
		$joins=array();
		$joins[0]=array(
			'table'=>PAYMENT,
			'condition'=>PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.PAYMENT.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$data['billing'] = $this->common_model->get_data_array(CBL_CUSTOMERS,array(PAYMENT.'.customer_id'=>$customer_id,'type'=>1),'*,'.PAYMENT.'.discount_total as dis,'.PAYMENT.'.payment_total as p_tot',$joins,'','','','payment_id desc');
		//echo json_encode(array('q'=>$this->db->last_query()));
		$billing_table = $this->load->view('cable/ajax/ledger',$data,true);
		echo json_encode(array('status'=>'success','table'=>$billing_table));
	}
	
	public function export(){
		$customer_type = $this->input->post('status');
		$where=array();
		$filename = '';
		if($customer_type == 1 || $customer_type == 2 || $customer_type == 3){
			$where[CBL_CUSTOMERS.'.status'] = $customer_type;
			if($customer_type == 1){
				$filename = 'Active_';
			}else if($customer_type == 2){
				$filename = 'Inactive_';
			} else if($customer_type == 3){
				$filename = 'Deleted_';
			}
		}else if($customer_type == 4){
			$where['payment_status']=2;
			$filename = 'Paid_';
		}else if($customer_type == 5){
			$where['payment_status']=1;
			$filename = 'Unpaid_';
		}
		
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		$joins[1]=array(
			'table'=>CBL_MSO,
			'condition'=>CBL_MSO.'.isp_id = '.CBL_CUSTOMERS.'.mso_id',
			'jointype'=>'left'
		);$joins[2]=array(
			'table'=>CBL_LCO,
			'condition'=>CBL_LCO.'.lco_id = '.CBL_CUSTOMERS.'.lco_id',
			'jointype'=>'left'
		);$joins[3]=array(
			'table'=>AREA,
			'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
			'jointype'=>'left'
		); $joins[4]=array(
			'table'=>CBL_PAYMENT,
			'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		); 
		$customer_data = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,'.CBL_CUSTOMERS.'.customer_id as c_id',$joins,'','',CBL_PAYMENT.'.customer_id','');
		//echo "<pre>";print_r($customer_data);die;
		$filename .= 'Customer-list-'.date('d/m/Y');
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$header = "Customer Name \t Mobile \t Address \t Other ID \t Pincode \t Package \t Connection Date \t Balance \t MSO \t LCO \t";
		if(@$customer_data){
			$i=0;
			foreach($customer_data as $row){
				//ip information 
				$ips = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$row['c_id']));
				if(@$ips && $i==0){
					$ip_col = 1;
					foreach($ips as $row1){
						$header .= "STB No. $ip_col \t ACCOUNT $ip_col";
						$ip_col +=1;
					}
				}
				$header .="\n";
				$header .= $row['first_name']." ".@$row['last_name']."\t";
				$header .= $row['mobile1']."\t";
				$header .= $row['address1']."\t";
				$header .= $row['area_name'].' - '.$row['other_id']."\t";
				$header .= $row['pincode']."\t";
				$header .= $row['pakname']."\t";
				$header .= $row['connection_date']."\t";
				$header .= $row['balance']."\t";
				$header .= $row['mso']."\t"; 
				$header .= $row['lconame']."\t"; 
				if(@$ips){
					$ip_col = 0;
					foreach($ips as $row1){
						$header .= $row1['stb_no']."\t".$row1['account'];
						$ip_col +=1;
					}
				}
				$i++;
			}
		}else{
			$header .="No record found.";
		}
		echo $header;
	}
	
	public function delete_billing($bill_id=null){
		$payment_data = $this->common_model->get_data_row(CBL_PAYMENT,array('payment_id'=>$bill_id));
		$userdata = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$payment_data['customer_id']));
		if(@$payment_data['type']==1){
			
			$update_array = array();
			if($payment_data['is_added_time']==1){
				$balance = $userdata['balance']+$payment_data['payment_total'];
			}else{
				$balance = $userdata['balance']+$payment_data['payment_total'];
			}
			$update_array['balance'] = $balance;
			if($balance<=0){
				$update_array['payment_status'] = 1;//unpaid
			}else{
				$update_array['payment_status'] = 2;//paid
			}
			//update customer table
			$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$userdata['customer_id']),$update_array);
		}else if(@$payment_data['type']==2){
			if($payment_data['is_added_time']==1){
				$balance = $userdata['balance']-$payment_data['sub_total'];
			}else{
				$balance = $userdata['balance']-$payment_data['sub_total'];
			}
			$update_array = array();
			$update_array['balance'] = $balance;
			if($balance<=0){
				$update_array['payment_status'] = 1;//unpaid
			}else{
				$update_array['payment_status'] = 2;//paid
			}
			//update customer table
			$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$userdata['customer_id']),$update_array);
			
		}
		//echo $this->db->last_query();
		$this->common_model->tbl_record_del(CBL_PAYMENT,array('payment_id'=>$bill_id));
		$this->utilitylib->setMsg(SUCCESS_ICON.' Record successfully deleted.','SUCCESS');
		redirect(base_url('cable/customers'));
	}
	public function get_customer_details(){
		$customer_id = $this->input->post('customer_id');
		//$customer_id = 1;
		$joins = array();
		$joins[0] = array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[1] = array(
			'table'=>CBL_LCO,
			'condition'=>CBL_LCO.'.lco_id = '.CBL_CUSTOMERS.'.lco_id',
			'jointype'=>'inner'
		);
		$joins[2] = array(
			'table'=>CBL_MSO,
			'condition'=>CBL_MSO.'.isp_id = '.CBL_CUSTOMERS.'.mso_id',
			'jointype'=>'inner'
		);
		$data['customer'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$customer_id),'',$joins);
		$joins = array();
		$joins[0] = array(
			'table'=>CBL_STB_MODEL,
			'condition'=>CBL_STB_MODEL.'.stb_model_id = '.CBL_CUSTOMER_TO_STB.'.stb_model_id',
			'jointype'=>'inner'
		);
		$data['customer_ip'] = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$customer_id),'',$joins);
		
		$data['html'] = $this->load->view('cable/ajax/customer_details',$data,true);
		$data['documents'] = $this->load->view('cable/ajax/customer_documents',$data,true);
		echo json_encode($data);
	}
	public function autocomplete(){
		$keyword = $this->input->post('keyword');
		$data = array();
		$data['html'] = null;
		if(@$keyword){
			$where["cust_code LIKE '%".$keyword."%' OR first_name LIKE '%".$keyword."%' OR mobile1 LIKE '%".$keyword."%' OR `stb_no` LIKE '%".$keyword."%' OR `account` LIKE '%".$keyword."%'"] = null;
			$joins = array();
			$joins[0] = array(
				'table' =>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$data['customers'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'first_name, cust_code', $joins,'','',CBL_CUSTOMERS.'.customer_id','first_name');
			$data['html'] = $this->load->view('cable/ajax/autocomplete',$data,true);
		}
		$data['q'] = $this->db->last_query();
		echo json_encode($data);
	}
	public function get_pack_amount(){
		$package_id = $this->input->post('package_id');
		$including = $this->common_model->get_data_row(CBL_PACKAGE,array('package_id'=>$package_id));
		$excluding = $this->common_model->get_data_array(CBL_PACKAGE_TO_TAX,array('package_id'=>$package_id));
		$excluding_amount = $including['pakren'];
		foreach($excluding as $row){
			if($row['tax_type']==1){
				$excluding_amount += ($including['pakren']*$row['tax_price'])/100;
			}else if($row['tax_type']==2){
				$excluding_amount += $row['tax_price'];
			}
		}
		echo json_encode(array('including'=>$including['including_amount'],'excluding'=>number_format($excluding_amount,2)));
	}
	
	public function channel(){
		$data['customer_id'] = $customer_id = $this->input->post('customer_id');
		$joins = array();
		$joins[0]=array(
			'table'=>CUSTOMER_TO_CHANNEL,
			'condition'=>CUSTOMER_TO_CHANNEL.'.channel_id = '.CBL_CHANNEL.'.channel_id',
			'jointype'=>'left'
		);
		$data['all_channel'] = $this->common_model->get_data_array(CBL_CHANNEL,'',CBL_CHANNEL.'.*',$joins,'','',CBL_CHANNEL.'.channel_id','channel_name');
	
		$joins = array();
		$joins[0]=array(
			'table'=>CBL_CHANNEL,
			'condition'=>CBL_CHANNEL.'.channel_id = '.CUSTOMER_TO_CHANNEL.'.channel_id',
			'jointype'=>'inner'
		);
		//get customer channel
		$data['c_channel'] = $this->common_model->get_data_array(CUSTOMER_TO_CHANNEL, array('customer_id'=>$customer_id),CUSTOMER_TO_CHANNEL.'.channel_id',$joins,'','','','');
		$data['c_chnl_id'] = array();
		foreach($data['c_channel'] as $row){
			array_push($data['c_chnl_id'], $row['channel_id']);
		}
		$html = $this->load->view('cable/ajax/channel',$data,true);
		echo json_encode(array('html'=>$html, 'q'=>$data['c_channel']));
	}
	public function add_channel(){
		if($this->input->post()){
			
			//$this->common_model->tbl_record_del(CUSTOMER_TO_CHANNEL, array('customer_id'=>$this->input->post('customer_id')));
			$insert_array = array();
			$insert_array['customer_id'] = $this->input->post('customer_id');
			$channel_total_price = 0;
			foreach($this->input->post('channel') as $key=>$val){
				$channel_id = $this->input->post('channel');
				$insert_array['channel_id'] = $channel_id[$key];
				$insert_array['added_date'] = date('Y-m-d H:i:s');
				
				$this->common_model->tbl_insert(CUSTOMER_TO_CHANNEL, $insert_array);
				
				$channel_data = $this->common_model->get_data_row(CBL_CHANNEL, array('channel_id'=>$channel_id[$key]));
				
				$channel_total_price += $channel_data['tot_amount'];
			}
			/* echo "<pre>";
			print_r($this->input->post());die; */
			
			$customer_data = $this->common_model->get_data_row(CBL_CUSTOMERS, array('customer_id'=>$insert_array['customer_id']));
			
			$balance = $customer_data['balance'] +  $channel_total_price;
			
			$this->common_model->tbl_update(CBL_CUSTOMERS, array('customer_id'=>$insert_array['customer_id']), array('balance'=>$balance));
			redirect(base_url('cable/customers'));
		}
	}
	public function import(){
		$this->load->library('excel');
        if ($this->input->post()) {
			//echo "hi";die;
            $path = ROOT_UPLOAD_IMPORT_PATH;
 
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|jpg|png';
            $config['remove_spaces'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('import')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            
            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path .'/'. $import_xls_file;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            
			/* echo "<pre>";
			print_r($allDataInSheet);die; */
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('Other_ID',  'Customer_Name', 'ADDRESS1', 'MOBILE_PHONE', 'CAF_NO', 'STB_Model', 'STB_NUMBER', 'ACCOUNT');
            $makeArray = array('Other_ID' => 'Other_ID', 'Customer_Name' => 'Customer_Name', 'ADDRESS1' => 'ADDRESS1', 'MOBILE_PHONE' => 'MOBILE_PHONE', 'CAF_NO' => 'CAF_NO', 'STB_NUMBER' => 'STB_NUMBER', 'ACCOUNT' => 'ACCOUNT', 'STB_Model' => 'STB_Model');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } 
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);
           
            if (empty($data)) {
                $flag = 1;
            }
            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {
                    
					$insert_array = array();
					$insert_array['first_name']	= filter_var(trim($allDataInSheet[$i][$SheetDataKey['Customer_Name']]), FILTER_SANITIZE_STRING);
					$insert_array['caf_no']	= filter_var(trim($allDataInSheet[$i][$SheetDataKey['CAF_NO']]), FILTER_SANITIZE_STRING);
					$insert_array['address1']	= filter_var(trim($allDataInSheet[$i][$SheetDataKey['ADDRESS1']]), FILTER_SANITIZE_STRING);
					$insert_array['mobile1']	= filter_var(trim($allDataInSheet[$i][$SheetDataKey['MOBILE_PHONE']]), FILTER_SANITIZE_STRING);
					$insert_array['other_id']	= filter_var(trim($allDataInSheet[$i][$SheetDataKey['Other_ID']]), FILTER_SANITIZE_STRING);
					$insert_array['billing_date'] = '2018-01-01';
					$customer_id = $this->common_model->tbl_insert(CBL_CUSTOMERS, $insert_array);
					$cust_code = 'CUST00'.$customer_id;
					$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$customer_id),array('cust_code'=>$cust_code));
					
					$insert_array = array();
					$insert_array['customer_id'] = $customer_id;
					$insert_array['stb_no'] = filter_var(trim($allDataInSheet[$i][$SheetDataKey['STB_NUMBER']]), FILTER_SANITIZE_STRING);
					$insert_array['account'] = filter_var(trim($allDataInSheet[$i][$SheetDataKey['ACCOUNT']]), FILTER_SANITIZE_STRING);
					$insert_array['stb_model_id'] = filter_var(trim($allDataInSheet[$i][$SheetDataKey['STB_Model']]), FILTER_SANITIZE_STRING);
					
					$customer_id = $this->common_model->tbl_insert(CBL_CUSTOMER_TO_STB,$insert_array);
                }
            } else {
                echo "Please import correct file";
            }
        }
		$data['pageTitle'] = "SCN | CABLE | Top Up Bill Print";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/import_customers', $data);
	}
	
	public function top_up(){
		if($this->input->post()){
			$where = array();
			$where['lco_id'] = $this->input->post('lco');
			$where['billing_date < '] = date('Y-m-d', strtotime('-30 days'));
			$joins = array();
			$joins[0] = array(
				'table'=>CBL_PACKAGE,
				'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
				'jointype'=>'inner'
			);
			
			$data['customers'] = $this->common_model->get_data_array(CBL_CUSTOMERS, $where, '', $joins);
			//echo $this->db->last_query();die;
			foreach($data['customers'] as $key=>$val){
				$data['customers'][$key]['accounts'] = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$val['customer_id']));
			}
			/* echo "<pre>";
			print_r($data['customers']);die; */
		}
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | Multi Top Up";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_topup', $data);
	}
	
	public function add_topup(){
		if($this->input->post()){
			$customer_id = $this->input->post('customer_id');
			foreach($customer_id as $row){
				$customer_data = $this->common_model->get_data_row(CBL_CUSTOMERS, array('customer_id'=>$row, 'status'=>1));
				//echo "<pre>"; print_r($customer_data);
				//update customer table.
				$this->common_model->tbl_update(CBL_CUSTOMERS, array('customer_id'=>$row), array('billing_date'=> date('Y-m-d', strtotime($customer_data['billing_date']. ' + 30 days')), 'balance'=>$customer_data['balance'] + $customer_data['pack_amount']));
				//echo $this->db->last_query();die;
				//insert to payment table as top up.
				$insert_array = array();
				$insert_array['payment_date'] = date('Y-m-d H:i:s');
				$insert_array['customer_id'] = $row;
				$insert_array['package_id'] = $customer_data['package_id'];
				$insert_array['pack_amount'] = $customer_data['pack_amount'];
				$insert_array['outstanding'] = $customer_data['balance'];
				$insert_array['staff_id'] = 1;// as admin
				$insert_array['sub_total'] = $customer_data['pack_amount'];
				$insert_array['net_due'] = $customer_data['balance'] + $customer_data['pack_amount'];
				$insert_array['type'] = 2;//for top up
				$this->common_model->tbl_insert(CBL_PAYMENT, $insert_array);
			}
			$this->utilitylib->setMsg(SUCCESS_ICON.' '.count($customer_id) . ' Customer(s) top up has been successfully added.','SUCCESS');
			redirect(base_url('cable/customers/top_up'));
		}
	}
}
