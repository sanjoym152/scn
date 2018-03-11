<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
		$this->load->helper('pdf_helper');
    }

	public function index(){
		$where=array();
		$joins=array();
		$joins[0]=array(
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		if($this->input->post('keyword')){
			$where["(first_name LIKE '%".$this->input->post('keyword')."%' OR last_name LIKE '%".$this->input->post('keyword')."%')"]=null;
		}
		if($this->input->post('status')){
			$customer_type = $this->input->post('status');
			if($customer_type == 1 || $customer_type == 2 || $customer_type == 3){
				$where[CUSTOMERS.'.status'] = $customer_type;
			}else if($customer_type == 4){
				//paid
				$where['last_payment_month'] = date('m'); 
			}else if($customer_type == 5){
				$where['last_payment_month != '] = date('m'); 
			}
		}else{
			$where[CUSTOMERS.'.status'] = 1;// for default active customers.
		}
		
		$data['customers'] = $this->common_model->get_data_array(CUSTOMERS,$where,"*,".CUSTOMERS.'.status as c_status',$joins);
		foreach($data['customers'] as $k=>$v){
			$data['customers'][$k]['ip'] = $this->common_model->get_data_array(CUSTOMER_TO_IP,array('customer_id'=>$v['customer_id']));
		}
		
		$data['total_due'] = $this->common_model->get_data_row(CUSTOMERS,'','sum(balance) as total_due');
		$data['total_payment'] = $this->common_model->get_data_row(PAYMENT,array('type'=>1),'sum(payment_total) as payment');
		$data['package'] = $this->common_model->get_data_array(PACKAGE,array('status'=>1),'','','','','','pakname ASC');
		$data['collector'] = $this->common_model->get_data_array(STAFF);
		$data['pageTitle'] = "SCN | Internet | Customers";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/customers', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			$insert_array = $this->input->post();
			unset($insert_array['ip_address']);
			unset($insert_array['username']);
			$insert_array['due_balance'] = $this->input->post('balance');
			$insert_array['added_date'] = date('Y-m-d H:i:s');
			if(@$id){
				$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$id),$insert_array);
			}else{
				$package = $this->common_model->get_data_row(PACKAGE,array('package_id'=>$this->input->post('package_id')));
				$insert_array['balance'] = ($this->input->post('balance')+$package['tot_amount']);
				if($insert_array['balance']>0){
					$insert_array['payment_status']=2;//unpaid
					$insert_array['last_payment_month'] = date('m');
				}else{
					$insert_array['payment_status']=1;//paid
					$insert_array['last_payment_month'] = date('m');
				}
				$insert_array['status'] = 1;
				$id = $this->common_model->tbl_insert(CUSTOMERS,$insert_array);
				$cust_code = 'CUST00'.$id;
				$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$id),array('cust_code'=>$cust_code));
				//insert into payment table as add topup
				$insert_array=array();
				$insert_array['package_id'] = $this->input->post('package_id');
				$insert_array['customer_id'] = $id;
				$insert_array['pack_amount'] = $package['tot_amount'];
				$insert_array['outstanding'] = $this->input->post('balance');
				$insert_array['net_due'] = $package['tot_amount'];
				$insert_array['is_added_time'] = 1;
				$insert_array['sub_total'] = $package['tot_amount']+$this->input->post('balance');
				$insert_array['payment_total'] = $package['tot_amount']+$this->input->post('balance');
				$insert_array['payment_date'] = date('Y-m-d',strtotime($this->input->post('billing_date')));
				$insert_array['staff_id'] = $this->input->post('staff_id');
				$insert_array['type'] = 2;
				//$insert_array['installation_charge'] = $this->input->post('installation_amount');
				$this->common_model->tbl_insert(PAYMENT,$insert_array);
				/* if($this->input->post('deposite_amount')!=0){
					//insert into payment table for add payment
					$insert_array=array();
					$insert_array['package_id'] = $this->input->post('package_id');
					$insert_array['customer_id'] = $id;
					$insert_array['pack_amount'] = $package['tot_amount'];
					$insert_array['payment_date'] = $this->input->post('connection_date');
					$insert_array['installation_charge'] = $this->input->post('installation_amount');
					$insert_array['type'] = 1;
					$insert_array['payment_total'] = $this->input->post('deposite_amount');
					
					$insert_array['outstanding'] = 0; // Previous due is zero..
					
					$insert_array['net_due'] = ($this->input->post('installation_amount')+$package['tot_amount'])-$this->input->post('deposite_amount'); // After getting payment.
					$this->common_model->tbl_insert(PAYMENT,$insert_array);
					/* echo $this->db->last_query();
					echo "<pre>";
					print_r($insert_array);die; 
				} */
			}
			if($this->input->post('ip_address')){
				$this->common_model->tbl_record_del(CUSTOMER_TO_IP,array('customer_id'=>$id));
				$insert_array2 = $this->input->post();
				foreach($this->input->post('ip_address') as $k=>$v){
					if(@$v && @$insert_array2['username'][$k]){
						$this->common_model->tbl_insert(CUSTOMER_TO_IP,array('customer_id'=>$id,'ip_address'=>$v,'username'=>@$insert_array2['username'][$k]));
					}
				}
			}
			
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('internet/customers'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$id));
			$data['details']['ip'] = $this->common_model->get_data_array(CUSTOMER_TO_IP,array('customer_id'=>$id));
			/* echo "<pre>";
			print_r($data['details']);die; */
		}
		$data['package'] = $this->common_model->get_data_array(PACKAGE,'','','','','','','pakname ASC');
		$data['lco'] = $this->common_model->get_data_array(LCO,'','','','','','','lconame ASC');
		$data['isp'] = $this->common_model->get_data_array(ISP,'','','','','','','mso ASC');
		$data['collector'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['pageTitle'] = "SCN | Internet | Add Customer";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/customer_add', $data);
	}
	
	public function delete_record($id=null){
		if($id==null){
			redirect(base_url('internet/customers'));
		}
		$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$id),array('status'=>3));	
		//$this->common_model->tbl_record_del(CUSTOMERS,array('customer_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('internet/customers'));
	}
	
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('internet/customers'));
		}
		$status = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$id),array('status'=>1));
		}
		/* echo "<pre>";
		print_r($status);
		echo $this->db->last_query();die; */
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('internet/customers'));
	}
	
	public function chk_email(){
		$where=array();
		$where['email'] = $this->input->post('email');
		if($this->input->post('customer_id')){
			$where['customer_id <> '] = $this->input->post('customer_id');
		}
		
		echo $tot = count($this->common_model->get_data_array(CUSTOMERS,array('email'=>$this->input->post('email'),'customer_id <>'=>$this->input->post('customer_id'))));
	}
	
	public function check_other_id(){
		$where=array();
		$where['other_id'] = $this->input->post('other_id');
		if($this->input->post('customer_id')){
			$where['customer_id <> '] = $this->input->post('customer_id');
		}
		$tot = count($this->common_model->get_data_array(CUSTOMERS,$where));
		echo json_encode(array('STATUS'=>($tot>0)?'EXIST':'NOT_EXIST'));
	}
	
	public function check_username(){
		$where=array();
		$where['username'] = $this->input->post('username');
		if($this->input->post('customer_id')){
			$where['customer_id <> '] = $this->input->post('customer_id');
		}
		$tot = count($this->common_model->get_data_array(CUSTOMER_TO_IP,$where));
		echo $tot = count($this->common_model->get_data_array(CUSTOMER_TO_IP,$where));
	}
	
	public function check_ip(){
		$where=array();
		$where['ip_address'] = $this->input->post('ip');
		if($this->input->post('customer_id')){
			$where['customer_id <>'] = $this->input->post('customer_id');
		}
		echo $tot = count($this->common_model->get_data_array(CUSTOMER_TO_IP,$where));
	}
	
	public function get_customer_data(){
		$customer_id = $this->input->post('customer_id');
		$joins = array();
		$joins[0] = array(
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[1] = array(
			'table'=>LCO,
			'condition'=>LCO.'.lco_id = '.CUSTOMERS.'.lco_id',
			'jointype'=>'inner'
		);
		$joins[2] = array(
			'table'=>ISP,
			'condition'=>ISP.'.isp_id = '.CUSTOMERS.'.mso_id',
			'jointype'=>'inner'
		);
		$data['customer'] = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$customer_id),'',$joins);
		$customer_ip = $this->common_model->get_data_array(CUSTOMER_TO_IP,array('customer_id'=>$customer_id));
		$data['ip_data'] = '';
		foreach($customer_ip as $row){
			$data['ip_data'] = '<div class="col-md-6">'.$row['ip_address'].'</div>';
		}
		$data['last_payment'] = $this->common_model->get_data_row(PAYMENT, array('customer_id'=>$customer_id, 'type'=>1),'','','payment_id');
		$data['customer_info'] = $this->load->view('internet/ajax/payment_customer_info',$data,true);
		echo json_encode($data);
	}
	
	public function payment(){
		$insert_array=array();
		$customer_data = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')));
		$insert_array['customer_id'] = $this->input->post('customer_id');
		$insert_array['payment_date'] = date('Y-m-d',strtotime($this->input->post('payment_date')));
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
			$insert_array['month_of'] =$this->input->post('month_of');
		}
		/* echo "<pre>";
		print_r($insert_array);die; */
		$payment_id = $this->common_model->tbl_insert(PAYMENT,$insert_array);
		/*
		@ update customer table
		*/
		$c_array=array();
		$c_array['balance'] = $this->input->post('net_due');
		$c_array['last_payment_month'] = date('m');
		$c_array['payment_status']=2;
		$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')),$c_array);
		/*
		@insert payment commission table
		*/
		$commission = array();
		$staff = $this->common_model->get_data_row(STAFF,array('staff_id'=>$insert_array['staff_id']));
		
		if(@$staff['staff_base']==1){
			//for percentage commission
			$commission['commission'] = ($insert_array['payment_total']*$staff['commission'])/100;
		}else if(@$staff['staff_base']==2){
			//for fixed commission
			$commission['commission'] = $staff['commission'];
		}
		$commission['staff_id'] = $this->input->post('staff_id');
		$commission['payment_id'] = $payment_id;
		$commission['type'] = 1;
		$commission['collection_date'] = date('Y-m-d',strtotime($this->input->post('payment_date')));
		$this->common_model->tbl_insert(PAYMENT_COMMISSION,$commission);
		$this->utilitylib->setMsg(SUCCESS_ICON.' Payment was success!','SUCCESS');
		redirect(base_url('internet/customers/bill_print/'.$payment_id));
	}
	
	public function add_topup(){
		$userdata = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')));
		$insert_array=array();
		$insert_array['customer_id']=	$this->input->post('customer_id');
		$insert_array['payment_date']=	date('Y-m-d',strtotime($this->input->post('month_of')));
		$insert_array['package_id']=	$this->input->post('package_id');
		$insert_array['other_fees']=	$this->input->post('other_fees');
		$insert_array['discount_in']=	$this->input->post('discount_in');
		$insert_array['discount_type']=	$this->input->post('discount_type');
		$insert_array['remark']=		$this->input->post('remark');
		$insert_array['type']=			2;
		
		$package_data = $this->common_model->get_data_row(PACKAGE,array('package_id'=>$this->input->post('package_id')));
		
		$insert_array['pack_amount']=	$package_data['tot_amount'];
		$total_amount = 0;
		$other_fees = 0;
		if(@$this->input->post('other_fees')){
			$other_fees = $this->input->post('other_fees');
		}
		if(@$insert_array['discount_in']){
			if($this->input->post('discount_type')==1){
				$insert_array['payment_total'] = $payment_total = ($other_fees+$package_data['tot_amount']) - (($package_data['tot_amount']*$insert_array['discount_in'])/100)+$userdata['balance'];
				$insert_array['discount_total'] = (($package_data['tot_amount']*$insert_array['discount_in'])/100);
			}else if($this->input->post('discount_type')==2){
				$insert_array['payment_total'] = $payment_total = (($package_data['tot_amount']+$other_fees)-$insert_array['discount_in'])+$userdata['balance'];
				$insert_array['discount_total'] = $insert_array['discount_in'];
			}
		}else{
			$insert_array['payment_total'] = $payment_total = $package_data['tot_amount']+$other_fees+$userdata['balance'];
			$insert_array['discount_total'] = 0;
		}
		$payment_total = (($package_data['tot_amount']+$other_fees)-$insert_array['discount_total']);
		$insert_array['sub_total'] = (($package_data['tot_amount']+$other_fees)-$insert_array['discount_total']);
		$insert_array['net_due']=$insert_array['payment_total'];
		$insert_array['outstanding']=$userdata['balance'];
		/* echo "<pre>";
		print_r($insert_array);die; */
		//insert in to payment table.
		$id = $this->common_model->tbl_insert(PAYMENT,$insert_array);
		
		//update user table.
		
		$insert_array=array();
		$insert_array['payment_status'] = 1;//unpaid
		$insert_array['package_id']=	$this->input->post('package_id');
		$insert_array['balance'] = $userdata['balance']+$payment_total;
		$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')),$insert_array);
		$this->utilitylib->setMsg(SUCCESS_ICON.' Topup successfully added!','SUCCESS');
		redirect(base_url('internet/customers/topup_bill_print/'.$id));
	}
	
	public function bill_print($id=null){
		$joins=array();
		$joins[0]=array(
			'table'=>CUSTOMERS,
			'condition'=>CUSTOMERS.'.customer_id = '.PAYMENT.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$joins[3]=array(
			'table'=>CUSTOMER_TO_IP,
			'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		);
		$data['userdata'] = $this->common_model->get_data_row(PAYMENT,array(PAYMENT.'.payment_id'=>$id),'*,'.PAYMENT.'.discount_total as p_discount',$joins);
		$data['last_payment'] = $this->common_model->get_data_row(PAYMENT, array('customer_id'=>$data['userdata']['customer_id'], 'type'=>1),'','','payment_id');
		/* echo "<pre>";
		print_r($data['userdata']);die; */
		$data['pageTitle'] = "SCN | Internet | Bill Print";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/bill_print', $data);
	}
	
	public function topup_bill_print($id=null){
		$joins=array();
		$joins[0]=array(
			'table'=>CUSTOMERS,
			'condition'=>CUSTOMERS.'.customer_id = '.PAYMENT.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$joins[3]=array(
			'table'=>CUSTOMER_TO_IP,
			'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		);
		$data['userdata'] = $this->common_model->get_data_row(PAYMENT,array(PAYMENT.'.payment_id'=>$id),'*,'.PAYMENT.'.discount_total as p_discount,'.PACKAGE.'.staff_base as package_tax_type',$joins);
		if($data['userdata']['package_tax_type']==2){
			$data['tax'] = $this->common_model->get_data_array(PACKAGE_TO_TAX,array('package_id'=>$data['userdata']['package_id']));
		}
		$data['last_payment'] = $this->common_model->get_data_row(PAYMENT, array('customer_id'=>$data['userdata']['customer_id'], 'type'=>1),'','','payment_id');
		$data['pageTitle'] = "SCN | INTERNET | Top Up Bill Print";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/topup_bill_print', $data);
	}
	
	public function billing(){
		$customer_id = $this->input->post('customer_id');
		$month = $this->input->post('month');
		$joins=array();
		$joins[0]=array(
			'table'=>PAYMENT,
			'condition'=>PAYMENT.'.customer_id = '.CUSTOMERS.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.PAYMENT.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$data['billing'] = $this->common_model->get_data_array(CUSTOMERS,array(PAYMENT.'.customer_id'=>$customer_id),'*,'.PAYMENT.'.discount_total as dis,'.PAYMENT.'.outstanding as p_balance',$joins,'','','','payment_date desc');
		
		$total_payment = $this->common_model->get_data_row(PAYMENT,array('customer_id'=>$customer_id,'type'=>1),'sum(payment.payment_total) as total');// payment
		$bill = $this->common_model->get_data_row(PAYMENT,array('customer_id'=>$customer_id,'type'=>2),'sum(payment.payment_total) as total');// bill
		$bill1 = $this->common_model->get_data_row(PAYMENT,array('customer_id'=>$customer_id,'type'=>2),'sum(payment.outstanding) as total');// bill
		//echo json_encode(array('q'=>$this->db->last_query()));
		$billing_table = $this->load->view('internet/ajax/billing',$data,true);
		echo json_encode(array('status'=>'success','table'=>$billing_table,'payment_total'=>'PAID AMOUNT: '.$total_payment['total'],'bill'=>'BILL AMOUNT: '. ($bill['total']-$bill1['total'])));
	}
	public function ledger(){
		$customer_id = $this->input->post('customer_id');
		$month = $this->input->post('month');
		$joins=array();
		$joins[0]=array(
			'table'=>PAYMENT,
			'condition'=>PAYMENT.'.customer_id = '.CUSTOMERS.'.customer_id',
			'jointype'=>'inner'
		);
		$joins[1]=array(
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.PAYMENT.'.package_id',
			'jointype'=>'inner'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
			'jointype'=>'left'
		);
		$data['billing'] = $this->common_model->get_data_array(CUSTOMERS,array(PAYMENT.'.customer_id'=>$customer_id,'type'=>1),'*,'.PAYMENT.'.discount_total as dis,'.PAYMENT.'.payment_total as p_tot',$joins,'','','','payment_id desc');
		//echo json_encode(array('q'=>$this->db->last_query()));
		$billing_table = $this->load->view('internet/ajax/ledger',$data,true);
		echo json_encode(array('status'=>'success','table'=>$billing_table));
	}
	
	public function export(){
		$customer_type = $this->input->post('status');
		$where=array();
		$filename = '';
		if($customer_type == 1 || $customer_type == 2 || $customer_type == 3){
			$where[CUSTOMERS.'.status'] = $customer_type;
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
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		$joins[1]=array(
			'table'=>ISP,
			'condition'=>ISP.'.isp_id = '.CUSTOMERS.'.mso_id',
			'jointype'=>'left'
		);$joins[2]=array(
			'table'=>LCO,
			'condition'=>LCO.'.lco_id = '.CUSTOMERS.'.lco_id',
			'jointype'=>'left'
		);
		$customer_data = $this->common_model->get_data_array(CUSTOMERS,$where,'',$joins);
		$filename .= 'Customer-list-'.date('d/m/Y');
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$header = "Customer Name \t Mobile \t Address \t Other ID \t Pincode \t Package \t Connection Date \t Balance \t Installation Amount \t ISP \t LCO \t Payment Status \t";
		if(@$customer_data){
			$i=0;
			foreach($customer_data as $row){
				//ip information 
				$ips = $this->common_model->get_data_array(CUSTOMER_TO_IP,array('customer_id'=>$row['customer_id']));
				if(@$ips && $i==0){
					$ip_col = 1;
					foreach($ips as $row1){
						$header .= "IP $ip_col \t Username $ip_col";
						$ip_col +=1;
					}
				}
				$header .="\n";
				$header .= $row['first_name']." ".@$row['last_name']."\t";
				$header .= $row['mobile1']."\t";
				$header .= $row['address1']."\t";
				$header .= $row['other_id']."\t";
				$header .= $row['pincode']."\t";
				$header .= $row['pakname']."\t";
				$header .= $row['connection_date']."\t";
				$header .= $row['balance']."\t";
				$header .= $row['installation_amount']."\t";
				$header .= $row['mso']."\t"; 
				$header .= $row['lconame']."\t"; 
				if($row['payment_status']==1){
					$header .= "Unpaid";
				}if($row['payment_status']==2){
					$header .= "Paid";
				}
				$header .=" \t";
				if(@$ips){
					$ip_col = 0;
					foreach($ips as $row1){
						$header .= $row1['ip_address']."\t".$row1['username'];
						$ip_col +=1;
					}
				}
				$header .="\n";
				$i++;
			}
		}else{
			$header .="No record found.";
		}
		echo $header;
	}
	
	public function delete_billing($bill_id=null){
		$payment_data = $this->common_model->get_data_row(PAYMENT,array('payment_id'=>$bill_id));
		$userdata = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$payment_data['customer_id']));
		if(@$payment_data['type']==1){
			$update_array = array();
			if($payment_data['is_added_time']==1){
				$balance = $userdata['balance']+$payment_data['payment_total'];
			}else{
				$balance = $userdata['balance']+$payment_data['sub_total'];
			}
			$update_array['balance'] = $balance;
			if($balance<=0){
				$update_array['payment_status'] = 1;//unpaid
			}else{
				$update_array['payment_status'] = 2;//paid
			}
			//update customer table
			$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$userdata['customer_id']),$update_array);
		}else if(@$payment_data['type']==2){
			if($payment_data['is_added_time']==1){
				$balance = $userdata['balance']-$payment_data['payment_total'];
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
			$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$userdata['customer_id']),$update_array);
			
		}
		//echo $this->db->last_query();
		$this->common_model->tbl_record_del(PAYMENT,array('payment_id'=>$bill_id));
		
		/* echo "<pre>";
		print_r($update_array);die; */
		$this->utilitylib->setMsg(SUCCESS_ICON.' Record successfully deleted.','SUCCESS');
		redirect(base_url('internet/customers'));
	}
	public function get_customer_details(){
		$customer_id = $this->input->post('customer_id');
		//$customer_id = 1;
		$joins = array();
		$joins[0] = array(
			'table'=>PACKAGE,
			'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[1] = array(
			'table'=>LCO,
			'condition'=>LCO.'.lco_id = '.CUSTOMERS.'.lco_id',
			'jointype'=>'inner'
		);
		$joins[2] = array(
			'table'=>ISP,
			'condition'=>ISP.'.isp_id = '.CUSTOMERS.'.mso_id',
			'jointype'=>'inner'
		);
		$data['customer'] = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$customer_id),'',$joins);
		$data['customer_ip'] = $this->common_model->get_data_array(CUSTOMER_TO_IP,array('customer_id'=>$customer_id));
		
		$data['html'] = $this->load->view('internet/ajax/customer_details',$data,true);
		echo json_encode($data);
	}
	
	public function autocomplete(){
		$keyword = $this->input->post('keyword');
		$data = array();
		$data['html'] = null;
		if(@$keyword){
			$where["cust_code LIKE '%".$keyword."%' OR first_name LIKE '%".$keyword."%' OR mobile1 LIKE '%".$keyword."%' OR `ip_address` LIKE '%".$keyword."%' OR ".CUSTOMER_TO_IP.".`username` LIKE '%".$keyword."%'"] = null;
			$joins = array();
			$joins[0] = array(
				'table' =>CUSTOMER_TO_IP,
				'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$data['customers'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'first_name, cust_code', $joins,'','',CBL_CUSTOMERS.'.customer_id','first_name');
			$data['html'] = $this->load->view('cable/ajax/autocomplete',$data,true);
		}
		$data['q'] = $this->db->last_query();
		echo json_encode($data);
	}
}
