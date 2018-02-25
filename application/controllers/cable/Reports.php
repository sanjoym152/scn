<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect(base_url());
		}
    }

	public function index(){
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | ACTIVE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_report', $data);
	}
	public function preview($customer_id='')
	{
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		$joins[1]=array(
			'table'=>CUSTOMER_TO_IP,
			'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
			'jointype'=>'left'
		);
		$data['customer_preview'] = $this->common_model->get_data_row(CBL_CUSTOMERS,array(CBL_CUSTOMERS.'.customer_id'=>$customer_id),'',$joins);
		$customer_preview_ip = $this->common_model->get_data_array(CUSTOMER_TO_IP,array('customer_id'=>$customer_id));
		/* print "<pre>";
		print_r($data['customer_preview']);die; */
		$this->load->view('cable/customer_preview', $data);
	}
	public function export(){
		$customer_type = $this->input->post('status');
		$where=array();
		$filename = '';
		if($customer_type == 1 || $customer_type == 2 || $customer_type == 3){
			$where[CBL_CUSTOMERS.'.status'] = $customer_type;
			if($customer_type == 1){
				$filename = 'Active_';
			}else if($customer_type == 2){
				$filename = 'Inactive_';
			} else if($customer_type == 3){
				$filename = 'Deleted_';
			}
		}else if($customer_type == 4){
			$where['payment_status']=2;
			$filename = 'Paid_';
		}else if($customer_type == 5){
			$where['payment_status']=1;
			$filename = 'Unpaid_';
		}
		
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		/* $joins[1]=array(
			'table'=>CBL_MSO,
			'condition'=>CBL_MSO.'.isp_id = '.CBL_CUSTOMERS.'.mso_id',
			'jointype'=>'left'
		);$joins[2]=array(
			'table'=>CBL_LCO,
			'condition'=>CBL_LCO.'.lco_id = '.CBL_CUSTOMERS.'.lco_id',
			'jointype'=>'left'
		); */
		$customer_data = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'',$joins);
		$filename .= 'Active-Customer-list-'.date('d/m/Y');
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		/* $header = "Customer Name \t Mobile \t Address \t Other ID \t Pincode \t Package \t Connection Date \t Balance \t Installation Amount \t CBL_MSO \t CBL_LCO \t  Payment Status \t"; */
		$header = "Customer Name \t Mobile \t Address \t Other ID \t Pincode \t Package \t Connection Date \t Balance \t Payment Status \t";
		if(@$customer_data){
			$i=0;
			foreach($customer_data as $row){
				//ip information 
				$ips = $this->common_model->get_data_array(CBL_CUSTOMER_TO_STB,array('customer_id'=>$row['customer_id']));
				if(@$ips && $i==0){
					$ip_col = 1;
					foreach($ips as $row1){
						$header .= "IP $ip_col \t Username $ip_col";
						$ip_col +=1;
					}
				}
				$header .="\n";
				$header .= $row['first_name']." ".@$row['last_name']."\t";
				$header .= $row['mobile1']."\t";
				$header .= $row['address1']."\t";
				$header .= $row['other_id']."\t";
				$header .= $row['pincode']."\t";
				$header .= $row['pakname']."\t";
				$header .= $row['connection_date']."\t";
				$header .= $row['due_balance']."\t";
				/* $header .= $row['installation_amount']."\t";
				$header .= $row['mso']."\t"; 
				$header .= $row['lconame']."\t"; 
				if($row['payment_status']==1){
					$header .= "Unpaid";
				}if($row['payment_status']==2){
					$header .= "Paid";
				} */
				$header .=" \t";
				/* if(@$ips){
					$ip_col = 0;
					foreach($ips as $row1){
						$header .= $row1['ip_address']."\t".$row1['username'];
						$ip_col +=1;
					}
				} */
				$header .="\n";
				$i++;
			}
		}else{
			$header .="No record found.";
		}
		echo $header;
	}
	public function get_all_customers_details(){
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		//echo $this->db->last_query();die;
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | All CUSTOMERS";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/all_customers_report', $data);
	}
	
	public function collector_due()
	{
		$data = array();
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date')){
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date')){
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
			$joins=array();
			
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,array(CBL_PAYMENT.'.type'=>1),'*,SUM('.CBL_CUSTOMERS.'.balance) AS tot_due,SUM('.CBL_PAYMENT.'.payment_total) AS tot_payment ',$joins,'','',CBL_PAYMENT.'.customer_id',CBL_CUSTOMERS.'.customer_id ASC');
		}		
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');		
		$data['pageTitle'] = "SCN | CABLE | COLLECTOR WISE DUE";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/collector_due_report', $data);
	}
	
	public function customer_payment()
	{
		$data = array();
		if($this->input->post())
		{ 
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			if($this->input->post('keywords')){
				$keyword=$this->input->post('keywords');
				$where["(stb_no LIKE '%".$this->input->post('keywords')."%' OR account LIKE '%".$this->input->post('keywords')."%' OR mobile1 LIKE '%".$this->input->post('keywords')."%' OR first_name LIKE '%".$this->input->post('keywords')."%' OR last_name LIKE '%".$this->input->post('keywords')."%')"]=null;
			}
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id')){
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,array(CBL_PAYMENT.'.type'=>1),'*',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | CUSTOMER WISE PAYMENT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/customer_payment_report', $data);
	}
	
	public function daily_collection(){
		$data = array();
		if($this->input->post())
		{
			$where=array();
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_CUSTOMERS,
				'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_CUSTOMER_TO_STB,
				'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_PAYMENT.".`payment_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_PAYMENT.".`payment_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			$where[CBL_PAYMENT.'.type'] = 1;
			$data['daily_collection'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,'',$joins);
			/* echo $this->db->last_query(); 
			print "<pre>";
			print_r($data['daily_collection']);die; */
		}
		
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | DAILY COLLECTION";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/daily_collection', $data);
	}
	
	public function package_wise_customer()
	{
		$where=array();
		$data = array();	
		if($this->input->post())
		{ 
			if($this->input->post('mso_id')){
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id')){
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('package_id')){
				$where[CBL_CUSTOMERS.".`package_id` = '".$this->input->post('package_id')."'"]=null;
			}
			$joins=array();
			$joins[0]=array(
			'table'=>CBL_CUSTOMER_TO_STB,
			'condition'=>CBL_CUSTOMER_TO_STB.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
			);
			$joins[1]=array(
				'table'=>CBL_PAYMENT,
				'condition'=>CBL_PAYMENT.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			$joins[2]=array(
				'table'=>STAFF,
				'condition'=>STAFF.'.staff_id = '.CBL_PAYMENT.'.staff_id',
				'jointype'=>'left'
			);
			$joins[3]=array(
				'table'=>CBL_PACKAGE,
				'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
				'jointype'=>'left'
			);		
			$data['package_details']=$this->common_model->get_data_array(CBL_CUSTOMERS,$where,'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');	 
		}
		$data['package'] = $this->common_model->get_data_array(CBL_PACKAGE);
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | PACKAGE WISE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/package_wise_customer', $data); 
	}
	
	
	/* public function deactive_customer(){
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$where[CBL_CUSTOMERS.'.status']=2;
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_PACKAGE,
			'condition'=>CBL_PACKAGE.'.package_id = '.CBL_CUSTOMERS.'.package_id',
			'jointype'=>'left'
		);
		$joins[1]=array(
			'table'=>CUSTOMER_TO_IP,
			'condition'=>CUSTOMER_TO_IP.'.customer_id = '.CBL_CUSTOMERS.'.customer_id',
			'jointype'=>'left'
		);
		$joins[2]=array(
			'table'=>STAFF,
			'condition'=>STAFF.'.staff_id = '.CBL_CUSTOMERS.'.staff_id',
			'jointype'=>'left'
		);
		$data['collecter'] = $this->common_model->get_data_array(STAFF,'','','','','','','staff_name ASC');
		if($this->input->post())
		{
			$data['customer_details'] = $this->common_model->get_data_array(CBL_CUSTOMERS,$where,'',$joins,'','','',CBL_CUSTOMERS.'.customer_id ASC');
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | ACTIVE CUSTOMER";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/deactive_customer_report', $data);
	}
	
	
	public function date_wise_payment()
	{
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
			if($this->input->post('staff_id'))
			{
				$where[CBL_CUSTOMERS.".`staff_id` = '".$this->input->post('staff_id')."'"]=null;
			}
		}
		$data = array();
		if($this->input->post())
		{ 
			$join=array();
			$join[0]=array(
				'table'=>CBL_CUSTOMERS,
				'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
				'jointype'=>'left'
			);
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,SUM('.CBL_PAYMENT.'.payment_total) AS tot_payment',$join,'','',CBL_PAYMENT.'.payment_date',CBL_PAYMENT.'.payment_date ASC');
			//echo $this->db->last_query();die;
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			} 
		}
		//echo "<pre>"; print_r($data['payment_details']);die;
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | DATE WISE PAYMENT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/date_wise_payment_report', $data);
	}
	
	
	
	public function month_wise_payment(){
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`payment_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`payment_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$where=array('type'=>1);
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'left'
		);
		if($this->input->post())
		{
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,sum(`payment_total`) as tot_payment,monthname(payment_date) AS month',$joins,'','','MONTH(payment_date)',CBL_PAYMENT.'.payment_date ASC');
			
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			} 
		}
		//print_r($this->db->last_query());die;
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | MONTH WISE PAYMENT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/month_wise_payment', $data);
	}
	
	public function monthly_billing_report()
	{
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$where=array('type'=>2);
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'left'
		);
		if($this->input->post())
		{
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,sum(`payment_total`) as tot_payment,monthname(payment_date) AS month','','','','MONTH(payment_date)',CBL_PAYMENT.'.payment_date ASC');
			
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			}
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');		
		$data['pageTitle'] = "SCN | CABLE | MONTHLY BILLING REPORT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/monthly_billing_report', $data);
	}
	
	
	public function yearly_payment_report()
	{
		$where=array();
		if($this->input->post())
		{ 
			if($this->input->post('f_date'))
			{
				$f_date=date("Y-m-d", strtotime($this->input->post('f_date')));
				$where[CBL_CUSTOMERS.".`billing_date` >= '".$f_date."'"]=null;
			}
			if($this->input->post('t_date'))
			{
				$t_date=date("Y-m-d", strtotime($this->input->post('t_date')));
				$where[CBL_CUSTOMERS.".`billing_date` <= '".$t_date."'"]=null;
			}
			if($this->input->post('mso_id'))
			{
				$where[CBL_CUSTOMERS.".`mso_id` = '".$this->input->post('mso_id')."'"]=null;
			}
			if($this->input->post('lco_id'))
			{
				$where[CBL_CUSTOMERS.".`lco_id` = '".$this->input->post('lco_id')."'"]=null;
			}
		}
		$data = array();
		$joins=array();
		$joins[0]=array(
			'table'=>CBL_CUSTOMERS,
			'condition'=>CBL_CUSTOMERS.'.customer_id = '.CBL_PAYMENT.'.customer_id',
			'jointype'=>'left'
		);
		if($this->input->post())
		{
			$data['payment_details'] = $this->common_model->get_data_array(CBL_PAYMENT,$where,CBL_PAYMENT.'.*,sum(`payment_total`) as tot_payment,YEAR(payment_date) AS year',$joins,'','','YEAR(payment_date)',CBL_PAYMENT.'.payment_date ASC');
			
			$joins=array();
			$joins[0]=array(
				'table'=>CBL_PAYMENT.' as cbl_payment1',
				'condition'=>'cbl_payment1.customer_id = '.CBL_CUSTOMERS.'.customer_id',
				'jointype'=>'left'
			);
			foreach($data['payment_details'] as $key=>$val)
			{		
				$data['payment_details'][$key]['customers']=$this->common_model->get_data_array(CBL_CUSTOMERS,array('cbl_payment1.payment_date'=>$val['payment_date']),'*',$joins,'','',CBL_CUSTOMERS.'.customer_id','');
			} 
		}
		$data['mso'] = $this->common_model->get_data_array(CBL_MSO,'','','','','','','mso ASC');
		$data['lco'] = $this->common_model->get_data_array(CBL_LCO,'','','','','','','lconame ASC');
		$data['pageTitle'] = "SCN | CABLE | YEARLY PAYMENT REPORT";
		$data['header_links'] = $this->load->view('cable/includes/header_links',$data,true);
		$data['topbar'] = $this->load->view('cable/includes/topbar','',true);
		$data['left_menu'] = $this->load->view('cable/includes/left_menu','',true);
		$data['footer'] = $this->load->view('cable/includes/footer','',true);
		$data['footer_scripts'] = $this->load->view('cable/includes/footer_scripts','',true);
		$this->load->view('cable/yearly_payment_report', $data);
	} */
}
