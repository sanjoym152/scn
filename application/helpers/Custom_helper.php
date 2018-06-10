<?php 
function get_total_cust_cbl(){
	$CI=& get_instance();
    $CI->load->model('common_model'); 
	
	$tot_balance = $CI->common_model->get_data_row(CBL_CUSTOMERS, array('status <>' => 3), 'sum(balance) as tot_balance');
	
	$tot_customers = $CI->common_model->get_data_row(CBL_CUSTOMERS, array('status <>' => 3), ' count(customer_id) as tot_customer');
	
	return $result = array(
		'tot_customers' => $tot_customers['tot_customer'],
		'tot_balance' => $tot_balance['tot_balance']
	);
}

function get_total_cust_internet(){
	$CI=& get_instance();
    $CI->load->model('common_model'); 
	
	$tot_balance = $CI->common_model->get_data_row(CUSTOMERS, array('status <>' => 3), 'sum(balance) as tot_balance');
	
	$tot_customers = $CI->common_model->get_data_row(CUSTOMERS, array('status <>' => 3), ' count(customer_id) as tot_customer');
	
	return $result = array(
		'tot_customers' => $tot_customers['tot_customer'],
		'tot_balance' => $tot_balance['tot_balance']
	);
}