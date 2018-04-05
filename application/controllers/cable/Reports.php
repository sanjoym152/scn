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
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$where[CBL_CUSTOMERS.'.status']=1;
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,'.CBL_CUSTOMERS.'.status',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		//print "<pre>";print_r($data['customer_details']);die;
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | ACTIVE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_report', $data);
	}
	
	public function customer_report_print(){
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$where[CBL_CUSTOMERS.'.status']=1;
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,'.CBL_CUSTOMERS.'.status',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		$data['pageTitle'] = "SCN | CABLE | ACTIVE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_report_print', $data);
	}
	
	public function get_all_customers_details(){
		$data = array();
		$where=array();
		if($this->input->post())
		{ 	
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,'.CBL_CUSTOMERS.'.status',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		//echo $this->db->last_query();die;
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | All CUSTOMERS";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/all_customers_report', $data);
	}
	
		public function all_customer_report_print(){
		$data = array();
		$where=array();
		if($this->input->post())
		{ 	
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'inner'
			);
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,'.CBL_CUSTOMERS.'.status',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		//echo $this->db->last_query();die;
		$data['pageTitle'] = "SCN | CABLE | All CUSTOMERS";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/all_customer_report_print', $data);
	}
	public function collector_due()
	{
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
		
			$joins=array();

			$joins[0]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			//$where[CBL_PAYMENT.'.type']=1;
			//$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,SUM('.CBL_CUSTOMERS.'.balance) AS tot_due,SUM('.CBL_PAYMENT.'.payment_total) AS tot_payment,'.CBL_CUSTOMERS.'.status',$joins,'','',/* CBL_PAYMENT.'.staff_id' */'',CBL_CUSTOMERS.'.customer_id ASC');
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,'.CBL_CUSTOMERS.'.balance AS tot_due,'.CBL_PAYMENT.'.payment_total AS tot_payment,'.CBL_CUSTOMERS.'.status',$joins,'','',/* CBL_PAYMENT.'.staff_id' */'',CBL_CUSTOMERS.'.customer_id ASC');
			//$data['customer_details']=$this->common_model->get_data_array(CBL_CUSTOMERS,$where,'count(*)',$joins);
			//echo $this->db->last_query();
			//print "<pre>";print_r($data['customer_details']);die;
		}		
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');		
		$data['pageTitle'] = "SCN | CABLE | COLLECTOR WISE DUE";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/collector_due_report', $data);
	}
	
	public function collector_due_report_print()
	{
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
			$joins=array();
			
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			$where[CBL_PAYMENT.'.type']=1;
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*,SUM('.CBL_CUSTOMERS.'.balance) AS tot_due,SUM('.CBL_PAYMENT.'.payment_total) AS tot_payment,'.CBL_CUSTOMERS.'.status',$joins,'','',CBL_PAYMENT.'.customer_id',CBL_CUSTOMERS.'.customer_id ASC');
		}		
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');		
		$data['pageTitle'] = "SCN | CABLE | COLLECTOR WISE DUE";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/collector_due_report_print', $data);
	}
	public function customer_payment()
	{
		$data = array();
		if($this->input->post())
		{ 
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
			$where[CBL_PAYMENT.'.type']=1;
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | CUSTOMER WISE PAYMENT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_payment_report', $data);
	}
	
	public function customer_payment_report_print()
	{
		$data = array();
		if($this->input->post())
		{ 
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
			$where[CBL_PAYMENT.'.type']=1;
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | CUSTOMER WISE PAYMENT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_payment_report_print', $data);
	}
	
	public function daily_collection(){
		$data = array();
		if($this->input->post())
		{
			$where=array();
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMERS,
				'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'inner'
			);
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_PAYMENT.".`payment_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_PAYMENT.".`payment_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$where[CBL_PAYMENT.'.type'] = 1;
			$data['daily_collection'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,'*,'.CBL_CUSTOMERS.'.other_id',$joins);
			/* echo $this->db->last_query(); 
			print "<pre>";
			print_r($data['daily_collection']);die; */
		}
		
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/daily_collection', $data);
	}
	public function daily_collection_print(){
		$data = array();
		if($this->input->post())
		{
			$where=array();
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMERS,
				'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'inner'
			);
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_PAYMENT.".`payment_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_PAYMENT.".`payment_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$where[CBL_PAYMENT.'.type'] = 1;
			$data['daily_collection'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,'*,'.CBL_CUSTOMERS.'.other_id',$joins);
			/* echo $this->db->last_query(); 
			print "<pre>";
			print_r($data['daily_collection']);die; */
		}
		
		$data['pageTitle'] = "SCN | CABLE | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/daily_collection_print', $data);
	}
	
	public function package_wise_customer()
	{
		$where=array();
		$data = array();	
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('package_id')){
				$where[CBL_CUSTOMERS.".`package_id` = '".$this->input->post('package_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
			'table'=>CBL_CUSTOMER_TO_STB,
			'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'inner'
			);
			$joins[3]=array(
				'table'=>CBL_PACKAGE,
				'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
				'jointype'=>'left'
			);	
			$joins[4]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);			
			$data['package_details']=$this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');	 
		//echo "<pre>";print_r($data['package_details']);die;
		}
		$data['package'] = $this->common_model->get_data_array(CBL_PACKAGE);
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | PACKAGE WISE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/package_wise_customer', $data); 
	}
	public function package_wise_customer_print()
	{
		$where=array();
		$data = array();	
		if($this->input->post())
		{ 
			if($this->input->post('keyword')){
				$keyword=$this->input->post('keyword');
				$where["(stb_no LIKE '%".$this->input->post('keyword')."%' OR account LIKE '%".$this->input->post('keyword')."%' OR mobile1 LIKE '%".$this->input->post('keyword')."%' OR first_name LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('package_id')){
				$where[CBL_CUSTOMERS.".`package_id` = '".$this->input->post('package_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
			'table'=>CBL_CUSTOMER_TO_STB,
			'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>CBL_PACKAGE,
				'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
				'jointype'=>'left'
			);	
			$joins[4]=array(
				'table'=>AREA,
				'condition'=>AREA.'.area_id = '.CBL_CUSTOMERS.'.area_id',
				'jointype'=>'left'
			);			
			$data['package_details']=$this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');	 
		}
		$data['package'] = $this->common_model->get_data_array(CBL_PACKAGE);
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | PACKAGE WISE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/package_wise_customer_print', $data); 
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
			$data['customers'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'first_name,cust_code', $joins,'','',CBL_CUSTOMERS.'.customer_id','first_name');
			$data['html'] = $this->load->view('cable/ajax/autocomplete',$data,true);
		}
		$data['q'] = $this->db->last_query();
		echo json_encode($data);
	}
	
	/* public function deactive_customer(){
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$where[CBL_CUSTOMERS.'.status']=2;
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		$joins[1]=array(
			'table'=>CUSTOMER_TO_IP,
			'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
			'jointype'=>'left'
		);
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		if($this->input->post())
		{
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | ACTIVE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/deactive_customer_report', $data);
	}
	
	
	public function date_wise_payment()
	{
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id'))
			{
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
		}
		$data = array();
		if($this->input->post())
		{ 
			$join=array();
			$join[0]=array(
				'table'=>CBL_CUSTOMERS,
				'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,SUM('.CBL_PAYMENT.'.payment_total) AS tot_payment',$join,'','',CBL_PAYMENT.'.payment_date',CBL_PAYMENT.'.payment_date ASC');
			//echo $this->db->last_query();die;
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			} 
		}
		//echo "<pre>"; print_r($data['payment_details']);die;
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | DATE WISE PAYMENT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/date_wise_payment_report', $data);
	}
	
	
	
	public function month_wise_payment(){
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`payment_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`payment_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$where=array('type'=>1);
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'left'
		);
		if($this->input->post())
		{
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,sum(`payment_total`) as tot_payment,monthname(payment_date) AS month',$joins,'','','MONTH(payment_date)',CBL_PAYMENT.'.payment_date ASC');
			
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			} 
		}
		//print_r($this->db->last_query());die;
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | MONTH WISE PAYMENT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/month_wise_payment', $data);
	}
	
	public function monthly_billing_report()
	{
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$where=array('type'=>2);
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'left'
		);
		if($this->input->post())
		{
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,sum(`payment_total`) as tot_payment,monthname(payment_date) AS month','','','','MONTH(payment_date)',CBL_PAYMENT.'.payment_date ASC');
			
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			}
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');		
		$data['pageTitle'] = "SCN | CABLE | MONTHLY BILLING REPORT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/monthly_billing_report', $data);
	}
	
	
	public function yearly_payment_report()
	{
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'left'
		);
		if($this->input->post())
		{
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,sum(`payment_total`) as tot_payment,YEAR(payment_date) AS year',$joins,'','','YEAR(payment_date)',CBL_PAYMENT.'.payment_date ASC');
			
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			} 
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | YEARLY PAYMENT REPORT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/yearly_payment_report', $data);
	} */
}
