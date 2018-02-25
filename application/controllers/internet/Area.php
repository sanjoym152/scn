<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
    }

	public function index(){
		$where = array();
		if($this->input->post()){
			if($this->input->post('keyword')){
				$where["(`area_name` LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
		}
		$data = array();
		
		$data['areas'] = $this->common_model->get_data_array(AREA,$where);
		
		$data['pageTitle'] = "SCN | Internet | Area";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/area', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			$insert_array = $this->input->post();
			$insert_array['date'] = date('Y-m-d H:i:s');
			$insert_array['area_status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(AREA,array('area_id'=>$id),$insert_array);
			}else{
				$id = $this->common_model->tbl_insert(AREA,$insert_array);
			}
			$package_code = 'AR000'.$id;
			$this->common_model->tbl_update(AREA,array('area_id'=>$id),array('area_code'=>$package_code));
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('internet/area'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(AREA,array('area_id'=>$id));
		}
		
		$data['pageTitle'] = "SCN | Internet | Add Area";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/area_add', $data);
	}
	
	public function delete_record($id=null){
		if($id==null){
			redirect(base_url('internet/area'));
		}
		$this->common_model->tbl_record_del(AREA,array('area_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('internet/area'));
	}
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('internet/area'));
		}
		$status = $this->common_model->get_data_row(AREA,array('area_id'=>$id));
		/* echo "<pre>";
		print_r($status);die; */
		if($status['area_status']==1){
			$this->common_model->tbl_update(AREA,array('area_id'=>$id),array('area_status'=>2));	
		}else if($status['area_status']==2){
			$this->common_model->tbl_update(AREA,array('area_id'=>$id),array('area_status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('internet/area'));
	}
}
