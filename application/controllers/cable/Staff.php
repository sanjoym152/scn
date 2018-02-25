<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
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
			
			if($this->input->post('keyword')){
				$where["(`staff_code` LIKE '%".$this->input->post('keyword')."%' OR `staff_name` LIKE '%".$this->input->post('keyword')."%' OR `designation` LIKE '%".$this->input->post('keyword')."%' OR `staff_type` LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
		}
		$data = array();
		$data['staff'] = $this->common_model->get_data_array(STAFF,$where);
		$data['pageTitle'] = "SCN | cable | Staff";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/staff', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			$insert_array = $this->input->post();
			$insert_array['mobile'] = nl2br($this->input->post('mobile'));
			$insert_array['date'] = date('Y-m-d H:i:s');
			$insert_array['status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(STAFF,array('staff_id'=>$id),$insert_array);
			}else{
				$id = $this->common_model->tbl_insert(STAFF,$insert_array);
			}
			$package_code = 'SCNS000'.$id;
			$this->common_model->tbl_update(STAFF,array('staff_id'=>$id),array('staff_code'=>$package_code));
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('cable/staff'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(STAFF,array('staff_id'=>$id));
		}
		$data['pageTitle'] = "SCN | cable | Add Staff";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/staff_add', $data);
	}
	
	public function delete_record($id=null){
		if($id==null){
			redirect(base_url('cable/staff'));
		}
		$this->common_model->tbl_record_del(STAFF,array('staff_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('cable/staff'));
	}
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('cable/staff'));
		}
		$status = $this->common_model->get_data_row(STAFF,array('staff_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(STAFF,array('staff_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(STAFF,array('staff_id'=>$id),array('status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('cable/staff'));
	}
}
