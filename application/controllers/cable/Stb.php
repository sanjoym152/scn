<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stb extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
    }

	public function index()
	{
		$where = array();
		if($this->input->post()){
			$where["`stb_model_no` LIKE '%".$this->input->post('keyword')."%'"]=null;
		}
		$data = array();
		$data['stb'] = $this->common_model->get_data_array(CBL_STB_MODEL,$where);
		//echo $this->db->last_query();die;
		$data['pageTitle'] = "SCN | CABLE | STB";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/stb', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			$insert_array = $this->input->post();
			$insert_array['status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(CBL_STB_MODEL,array('stb_model_id'=>$id),$insert_array);
			}else{
				$this->common_model->tbl_insert(CBL_STB_MODEL,$insert_array);
			}
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('cable/stb'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(CBL_STB_MODEL,array('stb_model_id'=>$id));
		}
		$data['pageTitle'] = "SCN | CABLE | Add STB";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/stb_add', $data);
	}
	
	public function delete_isp($id=null){
		if($id==null){
			redirect(base_url('cable/stb'));
		}
		$this->common_model->tbl_record_del(CBL_STB_MODEL,array('stb_model_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('cable/stb'));
	}
	
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('cable/stb'));
		}
		$status = $this->common_model->get_data_row(CBL_STB_MODEL,array('stb_model_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(CBL_STB_MODEL,array('stb_model_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(CBL_STB_MODEL,array('stb_model_id'=>$id),array('status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('cable/stb'));
	}
}
