<?php 
/*
* @ class: Payment
* @ file: Payment.php
* @ Description: This class is used for payment related purpose only.
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
	public function make_payment(){
		$insert_array=array();
		$customer_data = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')));
		$payment_data = $this->common_model->get_data_row(PAYMENT,array('payment_id'=>$this->input->post('payment_id')));
		
		if($payment_data['billing_total']==$this->input->post('payment_total')){
			$insert_array['status'] = 1;
		} else{
			$insert_array['status'] = 2;
		}
		
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
		$insert_array['remark'] = $this->input->post('remark');
		
		$payment_id = $this->common_model->tbl_insert(PAYMENT, $insert_array);
		
		$c_array=array();
		$c_array['balance'] = $this->input->post('net_due');
		$c_array['payment_status']=2;
		$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')),$c_array);
		$this->utilitylib->setMsg(SUCCESS_ICON.' Payment was success!','SUCCESS');
		redirect(base_url('internet/customers/bill_print/'.$payment_id));
	}
	// This function is used for add payment
	public function add_payment(){
		$insert_array=array();
		$customer_data = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')));
		$payment_data = $this->common_model->get_data_row(PAYMENT,array('payment_id'=>$this->input->post('payment_id')));
		
		if($payment_data['billing_total']==$this->input->post('payment_total')){
			$insert_array['status'] = 1;
		} else{
			$insert_array['status'] = 2;
		}
		
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
		$insert_array['remark'] = $this->input->post('remark');
		
		$payment_id = $this->common_model->tbl_update(PAYMENT, array('payment_id'=>$this->input->post('payment_id')), $insert_array);
		
		$c_array=array();
		$c_array['balance'] = $this->input->post('net_due');
		$c_array['payment_status']=2;
		$this->common_model->tbl_update(CUSTOMERS,array('customer_id'=>$this->input->post('customer_id')),$c_array);
		$this->utilitylib->setMsg(SUCCESS_ICON.' Payment was success!','SUCCESS');
		redirect(base_url('internet/customers/bill_print/'.$this->input->post('payment_id')));
	}
	
	
	// This function is used for edit a particular payment.
	public function edit_payment(){
		if($this->input->post()){
			/* echo "<pre>";
			print_r($this->input->post());die; */
			$insert_array = array();
			$insert_array = $this->input->post();
			$this->common_model->tbl_update(PAYMENT,array('payment_id'=>$this->input->post('payment_id')), $insert_array);
			//echo $this->db->last_query();die;
			$payment_data = $this->common_model->get_data_row(PAYMENT, array('customer_id'=>$this->input->post('customer_id')), 'sum(payment_total) as payment_tot, sum(billing_total) as billing_tot');
			
			$this->common_model->tbl_update(CUSTOMERS, array('customer_id'=>$this->input->post('customer_id')), array('balance'=>$payment_data['billing_tot']-($payment_data['payment_tot'])));
			redirect(base_url('internet'));
		}
	}
	
	/*
	@ This function is used for delete a particular payment.
	@ desc: billing date will be decrese 30 days.
	@ there is a problem to delete a payment. billing date cannot be modified right way.
	*/
	public function delete_payment(){
		if($this->input->post()){
			$payment_data = $this->common_model->get_data_row(PAYMENT, array('customer_id'=>$this->input->post('customer_id'), 'payment_id !='=>$this->input->post('payment_id')), 'sum(payment_total) as payment_tot, sum(billing_total) as billing_tot');
			
			$customer_data = $this->common_model->get_data_row(CUSTOMERS, array('customer_id'=>$this->input->post('customer_id'), 'status'=>1));
			
			$this->common_model->tbl_update(CUSTOMERS, array('customer_id'=>$this->input->post('customer_id')), array('balance'=>$payment_data['billing_tot']-$payment_data['payment_tot'], 'billing_date'=> date('Y-m-d', strtotime($customer_data['billing_date']. ' - 30 days'))));
			
			// Delete a row according to payment_id
			$this->common_model->tbl_record_del(PAYMENT, array('payment_id'=>$this->input->post('payment_id')));
			
			// Fetch updated payment info to display.
			$data = array();
			$result = array();
			if($this->input->post()){
				$customer_id = $this->input->post('customer_id');
				$year = $this->input->post('year');
				$joins = array();
				$joins[0] = array(
					'table'=>STAFF,
					'condition'=>STAFF.'.staff_id = '.PAYMENT.'.staff_id',
					'jointype'=>'left'
				);
				
				$data['payment_info'] = $this->common_model->get_data_array(PAYMENT, array('customer_id'=>$customer_id, 'YEAR('.PAYMENT.'.pack_start_date)'=>$year, 'type'=>2), '', $joins);
				
				$data['payment_total_info'] = $this->common_model->get_data_row(PAYMENT, array('customer_id'=>$customer_id, 'YEAR('.PAYMENT.'.pack_start_date)'=>$year, 'type'=>2), '*, sum(billing_total) as billing_tot, sum(payment_total) as payment_tot, sum(discount_total) as discount_tot', $joins);
				$result['q'] = $this->db->last_query();
				$data['customer_info'] = $this->common_model->get_data_row(CUSTOMERS,array('customer_id'=>$customer_id));
				
				$result['template'] = $this->load->view('internet/ajax/customer_payment_info', $data, true);
			} else{
				$result['error']['message'] = "Please select a month";
			}
			echo json_encode($result);
		}
	}
}