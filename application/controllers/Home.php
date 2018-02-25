<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->session->userdata('user_id')){
			if($this->session->userdata('visit_type')==1){
				redirect(base_url('cable'));
			}else if($this->session->userdata('visit_type')==2){
				redirect(base_url('internet'));
			} 
		}
		if($this->input->post()){
			$insert_array = array();
			$insert_array['email'] = $this->input->post('email');
			$insert_array['password'] = md5($this->input->post('password'));
			$userdata = $this->common_model->get_data_row(USERS,$insert_array);
			
			if(@$userdata){
				//
				if($userdata['status']==2){
					$this->utilitylib->setMsg('SUCCESS','Your account is currently inactive.');
					redirect(base_url());
				}else if($userdata['status']==1){
					$session_array = array(
						'user_id'=>$userdata['user_id'],
						'name'=>$userdata['fname'].' '.$userdata['lname'],
						'user_type'=>$userdata['user_type'],
					);
					$this->session->set_userdata($session_array);
					$this->session->set_userdata('visit_type',$this->input->post('visit_type'));
					if($this->input->post('visit_type')=='1'){
						redirect(base_url('cable'));
					}else if($this->input->post('visit_type')=='2'){
						redirect(base_url('internet'));
					}
				}
			}else{
				$this->utilitylib->setMsg(ERROR_ICON.'Invalid email or password','ERROR');
				//echo base_url('');die;
				redirect(base_url());
				exit();
			}
		}
		$this->load->view('home');
	}
	
	public function logout(){
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('user_type');
		$this->utilitylib->setMsg(SUCCESS_ICON.'You have successfully logged out.','SUCCESS');
		redirect(base_url());
	}
}
