<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lco extends CI_Controller {
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
			$where["`lconame` LIKE '%".$this->input->post('keyword')."%' OR `shtname` LIKE '%".$this->input->post('keyword')."%' OR `email` LIKE '%".$this->input->post('keyword')."%'"]=null;
		}
		$data = array();
		$data['lco'] = $this->common_model->get_data_array(LCO,$where);
		//echo $this->db->last_query();die;
		$data['pageTitle'] = "SCN | Internet | LCO";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/lco', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			$insert_array = $this->input->post();
			$insert_array['phone'] = nl2br($this->input->post('phone'));
			$insert_array['date'] = date('Y-m-d H:i:s');
			$insert_array['status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(LCO,array('lco_id'=>$id),$insert_array);
			}else{
				$this->common_model->tbl_insert(LCO,$insert_array);
			}
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('internet/lco'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(LCO,array('lco_id'=>$id));
		}
		$data['pageTitle'] = "SCN | Internet | Add LCO";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/lco_add', $data);
	}
	
	public function delete_isp($id=null){
		if($id==null){
			redirect(base_url('internet/lco'));
		}
		$this->common_model->tbl_record_del(LCO,array('lco_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('internet/lco'));
	}
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('internet/lco'));
		}
		$status = $this->common_model->get_data_row(LCO,array('lco_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(LCO,array('lco_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(LCO,array('lco_id'=>$id),array('status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('internet/lco'));
	}
}
