<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends CI_Controller {
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
				$where["(`taxname` LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('lco_id')){
				$where[LCO_TAX.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>LCO,
			'condition'=>LCO.'.lco_id = '.LCO_TAX.'.lco_id',
			'jointype'=>'inner'
		);
		$data['tax'] = $this->common_model->get_data_array(LCO_TAX,$where,'*,'.LCO_TAX.'.status as tax_status',$joins);
		$data['lco'] = $this->common_model->get_data_array(LCO,'','','','','','','lconame ASC');
		//echo $this->db->last_query();die;
		$data['pageTitle'] = "SCN | Internet | LCO TAX";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/tax', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			$insert_array = $this->input->post();
			$insert_array['date'] = date('Y-m-d H:i:s');
			$insert_array['status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(LCO_TAX,array('tax_id'=>$id),$insert_array);
			}else{
				$id = $this->common_model->tbl_insert(LCO_TAX,$insert_array);
			}
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('internet/tax'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(LCO_TAX,array('tax_id'=>$id));
		}
		$data['lco'] = $this->common_model->get_data_array(LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | Internet | Add LCO TAX";
		$data['header_links'] = $this->load->view('internet/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('internet/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('internet/includes/left_menu','',true);
		$data['footer'] = $this->load->view('internet/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('internet/includes/footer_scripts','',true);
		$this->load->view('internet/tax_add', $data);
	}
	
	public function delete_record($id=null){
		if($id==null){
			redirect(base_url('internet/tax'));
		}
		$this->common_model->tbl_record_del(LCO_TAX,array('tax_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('internet/tax'));
	}
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('internet/tax'));
		}
		$status = $this->common_model->get_data_row(LCO_TAX,array('tax_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(LCO_TAX,array('tax_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(LCO_TAX,array('tax_id'=>$id),array('status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('internet/tax'));
	}
}
