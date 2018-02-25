<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends CI_Controller {
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
				$where["(`pakname` LIKE '%".$this->input->post('keyword')."%')"]=null;
			}
			if($this->input->post('pkg_mode')){
				$where["`pkg_mode` = '".$this->input->post('pkg_mode')."'"]=null;
			}
		}
		$data = array();
		$data['package'] = $this->common_model->get_data_array(CBL_PACKAGE,$where);
		if(@$data['package']){ foreach($data['package'] as $k=>$v){
			$data['package'][$k]['ex_tax'] = $this->common_model->get_data_array(CBL_PACKAGE_TO_TAX,array('package_id'=>$v['package_id']));
		}}
		//echo $this->db->last_query();die;
		$data['pageTitle'] = "SCN | CABLE | PACKAGE";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/package', $data);
	}
	
	public function add($id = null){
		if($this->input->post()){
			/* echo "<pre>";
			print_r($this->input->post());die; */
			$insert_array = array();
			$insert_array['pakname'] = $this->input->post('pakname');
			$insert_array['pkg_mode'] = $this->input->post('pkg_mode');
			$insert_array['pakren'] = $this->input->post('pakren');
			$insert_array['including_amount'] = $this->input->post('including_amount');
			$insert_array['dis_amount'] = $this->input->post('dis_amount');
			$insert_array['dis_type'] = $this->input->post('dis_type');
			$insert_array['discount_total'] = $this->input->post('discount_total');
			$insert_array['tot_amount'] = $this->input->post('tot_amount');
			$insert_array['date'] = date('Y-m-d H:i:s');
			$insert_array['status'] = 1;
			if(@$id){
				$this->common_model->tbl_update(CBL_PACKAGE,array('package_id'=>$id),$insert_array);
			}else{
				$id = $this->common_model->tbl_insert(CBL_PACKAGE,$insert_array);
			}
			$package_code = 'PAC000'.$id;
			$this->common_model->tbl_update(CBL_PACKAGE,array('package_id'=>$id),array('pakcode'=>$package_code));//DIE;
			//insert to package_to_tax table
			$this->common_model->tbl_record_del(CBL_PACKAGE_TO_TAX,array('package_id'=>$id));
			if(@$this->input->post('tax_name') && @$this->input->post('tax_no') && @$this->input->post('tax_type') && @$this->input->post('tax_price')){
				$insert_array2 = $this->input->post();
				foreach($this->input->post('tax_name') as $k=>$v){
					$insert_array1=array();
					$insert_array1['tax_name'] = $insert_array2['tax_name'][$k];
					$insert_array1['tax_no'] = $insert_array2['tax_no'][$k];
					$insert_array1['tax_type'] = $insert_array2['tax_type'][$k];
					$insert_array1['tax_price'] = $insert_array2['tax_price'][$k];
					$insert_array1['package_id'] = $id;
					$this->common_model->tbl_insert(CBL_PACKAGE_TO_TAX,$insert_array1);
				}
			}
			$this->utilitylib->setMsg(SUCCESS_ICON.'Data successfully saved.','SUCCESS');
			redirect(base_url('cable/package'));
		}
		if(@$id){
			$data['details'] = $this->common_model->get_data_row(CBL_PACKAGE,array('package_id'=>$id));
			$data['package_tax'] = $this->common_model->get_data_array(CBL_PACKAGE_TO_TAX,array('package_id'=>$id));
		}
		$data['pageTitle'] = "SCN | cable | Add Package";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar',$data,true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/package_add', $data);
	}
	
	public function delete_record($id=null){
		if($id==null){
			redirect(base_url('cable/package'));
		}
		$this->common_model->tbl_record_del(CBL_PACKAGE,array('package_id'=>$id));
		$this->utilitylib->setMsg(SUCCESS_ICON.'Record successfully deleted.','SUCCESS');
		redirect(base_url('cable/package'));
	}
	public function change_status($id=null){
		if($id==null){
			redirect(base_url('cable/package'));
		}
		$status = $this->common_model->get_data_row(CBL_PACKAGE,array('package_id'=>$id));
		if($status['status']==1){
			$this->common_model->tbl_update(CBL_PACKAGE,array('package_id'=>$id),array('status'=>2));	
		}else if($status['status']==2){
			$this->common_model->tbl_update(CBL_PACKAGE,array('package_id'=>$id),array('status'=>1));
		}
		$this->utilitylib->setMsg(SUCCESS_ICON.'Successfully changed status.','SUCCESS');
		redirect(base_url('cable/package'));
	}
}
