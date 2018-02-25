<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mso extends CI_Controller {
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
			$where["`mso` LIKE '%".$this->input->post('keyword')."%' OR `shtname` LIKE '%".$this->input->post('keyword')."%' OR `email` LIKE '%".$this->input->post('keyword')."%'"]=null;
		}
		$data = array();
		$data['isp'] = $this->common_model->get_data_array(CBL_MSO,$where);
		//echo $this->db->last_query();die;
		$data['pageTitle'] = "SCN | CABLE | MSO";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/mso', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			$insert_array = $this->input->post();
			$insert_array['date'] = date('Y-m-d H:i:s');
			$insert_array['status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(CBL_MSO,array('isp_id'=>$id),$insert_array);
			}else{
				$this->common_model->tbl_insert(CBL_MSO,$insert_array);
			}
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('cable/mso'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(CBL_MSO,array('isp_id'=>$id));
		}
		$data['pageTitle'] = "SCN | CABLE | MSO";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/mso_add', $data);
	}
	
	public function delete_isp($id=null){
		if($id==null){
			redirect(base_url('cable/mso'));
		}
		$this->common_model->tbl_record_del(CBL_MSO,array('isp_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('cable/mso'));
	}
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('cable/mso'));
		}
		$status = $this->common_model->get_data_row(CBL_MSO,array('isp_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(CBL_MSO,array('isp_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(CBL_MSO,array('isp_id'=>$id),array('status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('cable/mso'));
	}
}
