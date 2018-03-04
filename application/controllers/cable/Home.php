<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
    }
	
	public function index()
	{
		$data = array();
		$data['customers'] = count($this->common_model->get_data_array(CBL_CUSTOMERS));
		$data['daily_collection'] = $this->common_model->get_data_row(CBL_PAYMENT,array('type'=>1, 'payment_date'=>date('Y-m-d')),'sum(`payment_total`) as daily_total');
		$data['total_collection'] = $this->common_model->get_data_row(CBL_PAYMENT,array('type'=>1),'sum(`payment_total`) as total');
		$data['due'] = $this->common_model->get_data_row(CBL_CUSTOMERS,'','sum(balance) as total_due');
		
		$data['daily_collection_graph'] = $this->common_model->get_data_array(CBL_PAYMENT,array('type'=>1),'sum(`payment_total`) as daily_total, payment_date','','','','payment_date');
		/* echo $this->db->last_query();
		echo "<pre>";
		print_r($data['daily_collection_graph']);die; */
		$data['pageTitle'] = "SCN | CABLE";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/home', $data);
	}
	
}
