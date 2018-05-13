<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
    }
	
	/* public function index()
	{
		$data = array();
		$data['customers'] = count($this->common_model->get_data_array(CUSTOMERS));
		$data['daily_collection'] = $this->common_model->get_data_row(CBL_PAYMENT,array('type'=>1, 'payment_date'=>date('Y-m-d')),'sum(`payment_total`) as daily_total');
		$data['total_collection'] = $this->common_model->get_data_row(CBL_PAYMENT,array('type'=>1),'sum(`payment_total`) as total');
		$data['due'] = $this->common_model->get_data_row(CUSTOMERS,'','sum(balance) as total_due');
		$data['daily_collection_graph'] = $this->common_model->get_data_array(CBL_PAYMENT,array('type'=>1),'sum(`payment_total`) as daily_total, payment_date','','','','payment_date');
		$data['pageTitle'] = "SCN | CABLE";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/home', $data);
	} */
	
	public function index()
	{
		$data = array();
		$data['collector'] = $this->common_model->get_data_array(STAFF,array('status'=>1));
		$data['pageTitle'] = "SCN | INTERNET | DASHBOARD";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/dashboard', $data);
	}
	
	public function get_customer_details(){
		$customer_id = $this->input->post('customer_id');
		$data = array();
		$result = array();
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
		$joins[2 ] = array(
			'table'=>ISP,
			'condition'=>ISP.'.isp_id = '.CUSTOMERS.'.mso_id',
			'jointype'=>'inner'
		);
		$data['customer_details'] = $this->common_model->get_data_row(CUSTOMERS, array('customer_id'=>$customer_id),'',$joins);

		foreach($data['customer_details'] as $k=>$v){
			$data['customer_details']['stb'] = $this->common_model->get_data_array(CUSTOMER_TO_IP,array('customer_id'=>$customer_id));
		}
		 /*echo $this->db->last_query();
		echo "<pre>";
		print_r($data['customer_details']); */
		$result['template'] = $this->load->view('internet/ajax/dashboard_cust_details', $data, true);
		echo json_encode($result);
	}
	
	// This fucntion is used for get_payment_info
	public function get_payment_info(){
		$data = array();
		$result = array();
		if($this->input->post()){
			$customer_id = $this->input->post('customer_id');
			$year = $this->input->post('year');
			$joins = array();
			$joins[0] = array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			
			$data['payment_info'] = $this->common_model->get_data_array(PAYMENT, array('customer_id'=>$customer_id, 'YEAR('.PAYMENT.'.pack_start_date)'=>$year), '', $joins);
			
			$data['payment_total_info'] = $this->common_model->get_data_row(PAYMENT, array('customer_id'=>$customer_id, 'YEAR('.PAYMENT.'.pack_start_date)'=>$year), '*, sum(billing_total) as billing_tot, sum(payment_total) as payment_tot, sum(discount_total) as discount_tot', $joins);
			$result['q'] = $this->db->last_query();
			$data['customer_info'] = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$customer_id));
			
			$result['template'] = $this->load->view('internet/ajax/customer_payment_info', $data, true);
		} else{
			$result['error']['message'] = "Please select a month";
		}
		echo json_encode($result);
	}
	
	public function autocomplete(){
		$keyword = $this->input->post('keyword');
		$output = array();
		//$data = array();
		if(@$keyword){
			//$where["cust_code LIKE '%".$keyword."%' OR first_name LIKE '%".$keyword."%' OR mobile1 LIKE '%".$keyword."%' OR `stb_no` LIKE '%".$keyword."%' OR `account` LIKE '%".$keyword."%' OR `area_other_id` LIKE '%".$keyword."%'"] = null;
			$where["(first_name LIKE '%".$this->input->post('keyword')."%' OR cust_code LIKE '%".$keyword."%' OR mobile1 LIKE '%".$keyword."%' OR `ip_address` LIKE '%".$keyword."%' OR ".CUSTOMER_TO_IP.".username LIKE '%".$keyword."%')"]=null;
			$joins = array();
			$joins[0] = array(
				'table' =>CUSTOMER_TO_IP,
				'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			
			$result = $this->common_model->get_data_array(CUSTOMERS,$where,CUSTOMERS.".customer_id, first_name, mobile1, ip_address, ".CUSTOMER_TO_IP.".username", $joins,'','',CUSTOMERS.'.customer_id','first_name');
			
			
			foreach($result as $k=>$v){
				$output[$k]['value'] = $v['customer_id'];
				$output[$k]['label'] = $v['first_name'];
			}
		}
		echo json_encode($output);
	}
	
	public function get_payment_data(){
		$data = array();
		$payment_id = $this->input->post('payment_id');
		$customer_id = $this->input->post('customer_id');
		$data['payment_data'] = $this->common_model->get_data_row(PAYMENT, array('payment_id'=>$payment_id));
		$data['customer_data'] = $this->common_model->get_data_row(CUSTOMERS, array('customer_id'=>$customer_id));
		echo json_encode($data);
	}
	
	public function get_customer_info(){
		ini_set('max_execution_time',0);
		$data= array();
		$insert=array();
		$get_customer_data=$this->common_model->get_data_array(CUSTOMERS);
		//echo "<pre>";print_r($get_customer_data);die;
		foreach($get_customer_data as $row){
			// update to customer table
			$insert['customer_id']=$row['customer_id'];
			$insert['package_id']=$row['package_id'];
			$insert['pack_amount']=$row['pack_amount'];
			$insert['billing_total']=$row['pack_amount'];
			$insert['outstanding']=$insert['billing_total'];
			$insert['billing_date']="2018-01-01";
			$insert['type']=2;
			
			$this->common_model->tbl_insert(PAYMENT,$insert);
			
			$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$row['customer_id']), array('balance'=>$row['pack_amount'], 'billing_date'=>"2018-01-01"));
		}
	}
}
