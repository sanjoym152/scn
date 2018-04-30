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
		$data['customers'] = count($this->common_model->get_data_array(CBL_CUSTOMERS));
		$data['daily_collection'] = $this->common_model->get_data_row(CBL_PAYMENT,array('type'=>1, 'payment_date'=>date('Y-m-d')),'sum(`payment_total`) as daily_total');
		$data['total_collection'] = $this->common_model->get_data_row(CBL_PAYMENT,array('type'=>1),'sum(`payment_total`) as total');
		$data['due'] = $this->common_model->get_data_row(CBL_CUSTOMERS,'','sum(balance) as total_due');
		$data['daily_collection_graph'] = $this->common_model->get_data_array(CBL_PAYMENT,array('type'=>1),'sum(`payment_total`) as daily_total, payment_date','','','','payment_date');
		$data['pageTitle'] = "SCN | CABLE";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/home', $data);
	} */
	
	public function index()
	{
		$data = array();
		$data['collector'] = $this->common_model->get_data_array(STAFF,array('status'=>1));
		$data['pageTitle'] = "SCN | CABLE | DASHBOARD";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/dashboard', $data);
	}
	
	public function get_customer_details(){
		$customer_id = $this->input->post('customer_id');
		$data = array();
		$result = array();
		$joins = array();
		$joins[0] = array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'inner'
		);
		$joins[1] = array(
			'table'=>AREA,
			'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
			'jointype'=>'left'
		);
		$joins[2] = array(
			'table'=>CBL_LCO,
			'condition'=>CBL_LCO.'.lco_id = '.CBL_CUSTOMERS.'.lco_id',
			'jointype'=>'inner'
		);
		$joins[3] = array(
			'table'=>CBL_MSO,
			'condition'=>CBL_MSO.'.isp_id = '.CBL_CUSTOMERS.'.mso_id',
			'jointype'=>'inner'
		);
		$data['customer_details'] = $this->common_model->get_data_row(CBL_CUSTOMERS, array('customer_id'=>$customer_id),'',$joins);
		/* echo $this->db->last_query();
		echo "<pre>";
		print_r($data['customer_details']); */
		$joins = array();
		$joins[0] = array(
			'table'=>CBL_STB_MODEL,
			'condition'=>CBL_STB_MODEL.'.stb_model_id = '.CBL_CUSTOMER_TO_STB.'.stb_model_id',
			'jointype'=>'left'
		);
		
		foreach($data['customer_details'] as $k=>$v){
			$data['customer_details']['stb'] = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$customer_id),'',$joins);
		}
		$result['template'] = $this->load->view('cable/ajax/dashboard_cust_details', $data, true);
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
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			
			$data['payment_info'] = $this->common_model->get_data_array(CBL_PAYMENT, array('customer_id'=>$customer_id, 'YEAR('.CBL_PAYMENT.'.billing_date)'=>$year, 'type'=>2), '', $joins);
			
			$data['payment_total_info'] = $this->common_model->get_data_row(CBL_PAYMENT, array('customer_id'=>$customer_id, 'YEAR('.CBL_PAYMENT.'.billing_date)'=>$year, 'type'=>2), '*, sum(billing_total) as billing_tot, sum(payment_total) as payment_tot, sum(discount_total) as discount_tot', $joins);
			$result['q'] = $this->db->last_query();
			$data['customer_info'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$customer_id));
			
			$result['template'] = $this->load->view('cable/ajax/customer_payment_info', $data, true);
		} else{
			$result['error']['message'] = "Please select a month";
		}
		echo json_encode($result);
	}
	
	public function autocomplete(){
		$keyword = $this->input->post('keyword');
		//$data = array();
		if(@$keyword){
			//$where["cust_code LIKE '%".$keyword."%' OR first_name LIKE '%".$keyword."%' OR mobile1 LIKE '%".$keyword."%' OR `stb_no` LIKE '%".$keyword."%' OR `account` LIKE '%".$keyword."%' OR `area_other_id` LIKE '%".$keyword."%'"] = null;
			$where["(first_name LIKE '%".$this->input->post('keyword')."%' OR area_other_id LIKE '%".$this->input->post('keyword')."' OR cust_code LIKE '%".$keyword."%' OR mobile1 LIKE '%".$keyword."%' OR `stb_no` LIKE '%".$keyword."%' OR `account` LIKE '%".$keyword."%')"]=null;
			$joins = array();
			$joins[0] = array(
				'table' =>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$joins[1]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			$result = $this->common_model->get_data_array(CBL_CUSTOMERS,'',CBL_CUSTOMERS.".customer_id, first_name, mobile1, stb_no, account, cust_code, CONCAT_WS('-', area_name, other_id) as area_other_id", $joins,'','',CBL_CUSTOMERS.'.customer_id','first_name',$where);
			
			$output = array();
			foreach($result as $k=>$v){
				$output[$k]['value'] = $v['customer_id'];
				$output[$k]['label'] = $v['first_name'];
			}
		}
		echo json_encode($output);
	}
	
}
