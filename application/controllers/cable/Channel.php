<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
    }

	public function index() {
		$where = array();
		if($this->input->post()){
			if($this->input->post('keyword')){
				$where["(`channel_name` LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('channel_mode')){
				$where["`channel_mode` = '".$this->input->post('channel_mode')."'"]=null;
			}
		}
		$data = array();
		$data['channel'] = $this->common_model->get_data_array(CBL_CHANNEL,$where);
		//echo $this->db->last_query();die;
		$data['pageTitle'] = "SCN | CABLE | CHANNEL";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/channel', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			/* echo "<pre>";
			print_r($this->input->post());die; */
			$insert_array = array();
			$insert_array['channel_name'] = $this->input->post('channel_name');
			$insert_array['channel_mode'] = $this->input->post('channel_mode');
			$insert_array['tot_amount'] = $this->input->post('tot_amount');
			$insert_array['status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(CBL_CHANNEL,array('channel_id'=>$id),$insert_array);
			}else{
				$id = $this->common_model->tbl_insert(CBL_CHANNEL,$insert_array);
			}
			$channel_code = 'CHNL000'.$id;
			$this->common_model->tbl_update(CBL_CHANNEL,array('channel_id'=>$id),array('channel_code'=>$channel_code));
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('cable/channel'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(CBL_CHANNEL,array('channel_id'=>$id));
		}
		$data['pageTitle'] = "SCN | CABLE | Add Channel";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/channel_add', $data);
	}
	
	public function delete_record($id=null){
		if($id==null){
			redirect(base_url('cable/channel'));
		}
		$this->common_model->tbl_record_del(CBL_PACKAGE,array('package_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('cable/channel'));
	}
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('cable/channel'));
		}
		$status = $this->common_model->get_data_row(CBL_PACKAGE,array('package_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(CBL_PACKAGE,array('package_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(CBL_PACKAGE,array('package_id'=>$id),array('status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('cable/channel'));
	}
}
