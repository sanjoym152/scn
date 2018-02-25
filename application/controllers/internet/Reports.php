<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
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
	
	public function daily_collection(){
		$data = array();
		$data['daily_collection'] = $this->common_model->get_data_array(PAYMENT,array('type'=>1),'*,sum(`payment_total`) as daily_total','','','','payment_date');
		$data['pageTitle'] = "SCN | INTERNET | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/daily_collection', $data);
	}
	
	public function staff_commission(){
		$data = array();
		$joins = array();
		$joins[0] = array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.PAYMENT_COMMISSION.'.staff_id',
			'jointype'=>'inner'
		);
		$data['staff'] = $this->common_model->get_data_array(PAYMENT_COMMISSION,array('type'=>1),'*,sum('.PAYMENT_COMMISSION.'.commission) as total_commission',$joins,'','',PAYMENT_COMMISSION.'.staff_id');
		$data['pageTitle'] = "SCN | INTERNET | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/staff_commission', $data);
	}
}
