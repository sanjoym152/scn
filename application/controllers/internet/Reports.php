<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
		$this->load->helper('pdf_helper');
        $this->load->library('upload');
    }

	public function index(){
		$data = array();
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['pageTitle'] = "SCN | INTERNET | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/customers_report', $data);
	}
	
	/* public function daily_collection(){
		$data = array();
		$data['daily_collection'] = $this->common_model->get_data_array(PAYMENT,array('type'=>1),'*,sum(`payment_total`) as daily_total','','','','payment_date');
		$data['pageTitle'] = "SCN | INTERNET | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/daily_collection', $data);
	} */
	public function daily_collection(){
		$data = array();
		if($this->input->post())
		{
			$where=array();
			$joins=array();
			$joins[0]=array(
				'table'=>CUSTOMERS,
				'condition'=>CUSTOMERS.'.customer_id = '.PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CUSTOMER_TO_IP,
				'condition'=>CUSTOMER_TO_IP.'.customer_id = '.PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>PACKAGE,
				'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
				'jointype'=>'left'
			);
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(ip_address LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[PAYMENT.".`payment_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[PAYMENT.".`payment_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$where[PAYMENT.'.type'] = 2;
			$data['daily_collection'] = $this->common_model->get_data_array(PAYMENT,$where,'',$joins);
			/* echo $this->db->last_query(); 
			print "<pre>";
			print_r($data['daily_collection']);die; */
		}
		$data['mso'] = $this->common_model->get_data_array(ISP,'','','','','','','mso ASC');
		//print_r($data['mso']);die;
		$data['lco'] = $this->common_model->get_data_array(LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | INTERNET | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/daily_collection', $data);
	}
	public function daily_collection_print(){
		$data = array();
		if($this->input->post())
		{
			$where=array();
			$joins=array();
			$joins[0]=array(
				'table'=>CUSTOMERS,
				'condition'=>CUSTOMERS.'.customer_id = '.PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CUSTOMER_TO_IP,
				'condition'=>CUSTOMER_TO_IP.'.customer_id = '.PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>PACKAGE,
				'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
				'jointype'=>'left'
			);
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(ip_address LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[PAYMENT.".`payment_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[PAYMENT.".`payment_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$where[PAYMENT.'.type'] = 2;
			$data['daily_collection'] = $this->common_model->get_data_array(PAYMENT,$where,'',$joins);
			/* echo $this->db->last_query(); 
			print "<pre>";
			print_r($data['daily_collection']);die; */
		}
		$data['mso'] = $this->common_model->get_data_array(ISP,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | INTERNET | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/daily_collection_print', $data);
	}
	public function collector_due()
	{
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(ip_address LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
			$joins=array();
			
			$joins[0]=array(
				'table'=>CUSTOMER_TO_IP,
				'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>PAYMENT,
				'condition'=>PAYMENT.'.customer_id = '.CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>PACKAGE,
				'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$where[PAYMENT.'.type']=2;
			$data['customer_details'] = $this->common_model->get_data_array(CUSTOMERS,$where,'*,SUM('.CUSTOMERS.'.balance) AS tot_due,SUM('.PAYMENT.'.payment_total) AS tot_payment,'.CUSTOMERS.'.status',$joins,'','',PAYMENT.'.customer_id',CUSTOMERS.'.customer_id ASC');
			/* echo $this->db->last_query();
			print "<pre>";print_r($data['customer_details']);die; */
		}		
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['mso'] = $this->common_model->get_data_array(ISP,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | INTERNET | COLLECTOR DUE REPORT";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/collector_due_report', $data);
	}
	
	public function collector_due_report_print()
	{
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(ip_address LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
			$joins=array();
			
			$joins[0]=array(
				'table'=>CUSTOMER_TO_IP,
				'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>PAYMENT,
				'condition'=>PAYMENT.'.customer_id = '.CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>PACKAGE,
				'condition'=>PACKAGE.'.package_id = '.CUSTOMERS.'.package_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$where[PAYMENT.'.type']=2;
			$data['customer_details'] = $this->common_model->get_data_array(CUSTOMERS,$where,'*,SUM('.CUSTOMERS.'.balance) AS tot_due,SUM('.PAYMENT.'.payment_total) AS tot_payment,'.CUSTOMERS.'.status',$joins,'','',PAYMENT.'.customer_id',CUSTOMERS.'.customer_id ASC');
			/* echo $this->db->last_query();
			print "<pre>";print_r($data['customer_details']);die; */
		}		
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['mso'] = $this->common_model->get_data_array(ISP,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | INTERNET | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/collector_due_report_print', $data);
	}
	public function autocomplete(){
		$keyword = $this->input->post('keyword');
		$data = array();
		$data['html'] = null;
		if(@$keyword){
			$where["cust_code LIKE '%".$keyword."%' OR first_name LIKE '%".$keyword."%' OR mobile1 LIKE '%".$keyword."%' OR `ip_address` LIKE '%".$keyword."%'"] = null;
			$joins = array();
			$joins[0] = array(
				'table' =>CUSTOMER_TO_IP,
				'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$data['customers'] = $this->common_model->get_data_array(CUSTOMERS,$where,'first_name,cust_code', $joins,'','',CUSTOMERS.'.customer_id','first_name');
			$data['html'] = $this->load->view('internet/ajax/autocomplete',$data,true);
		}
		$data['q'] = $this->db->last_query();
		echo json_encode($data);
	}
}
