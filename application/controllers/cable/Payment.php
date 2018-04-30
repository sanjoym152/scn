<?php 
/*
* @ class: Payment
* @ file: Payment.php
* @ Description: This class is used for payment related purpose.
* @ created on: 30-apr-2018
* @ author: Sanjoy Mandal
*/

class payment extends CI_Controller{
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
    }
	
	// This function is used for add payment
	public function add_payment(){
		if($this->input->post()){
			echo "<pre>";
			print_r($this->input->post());die;
		}
		$insert_array=array();
		$customer_data = $this->common_model->get_data_row(CBL_CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')));
		$insert_array['customer_id'] = $this->input->post('customer_id');
		$insert_array['payment_date'] = $this->input->post('payment_date');
		$insert_array['payment_total'] = $this->input->post('payment_total');
		$insert_array['sub_total'] = $this->input->post('payment_total')+$this->input->post('discount_total');
		$insert_array['outstanding'] = $customer_data['balance'];
		$insert_array['net_due'] = $this->input->post('net_due');
		$insert_array['staff_id'] = $this->input->post('staff_id');
		$insert_array['discount_in'] = $this->input->post('discount_in');
		$insert_array['discount_type'] = $this->input->post('discount_type');
		$insert_array['discount_total'] = $this->input->post('discount_total');
		$insert_array['type']=			1;
		$insert_array['month_of'] = $this->input->post('month_of');
		
		$payment_id = $this->common_model->tbl_insert(CBL_PAYMENT,$insert_array);
		
		$c_array=array();
		$c_array['balance'] = $this->input->post('net_due');
		$c_array['payment_status']=2;
		$this->common_model->tbl_update(CBL_CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')),$c_array);
		$this->utilitylib->setMsg(SUCCESS_ICON.' Payment was success!','SUCCESS');
		redirect(base_url('cable/customers/bill_print/'.$payment_id));
	}
}