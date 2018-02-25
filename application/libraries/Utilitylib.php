<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Utilitylib {
 
 	protected $CI;
	
 	public function __construct($rules = array())
	{
		$this->CI =& get_instance();
	}
	function setMsg($str,$type){
        $this->CI->session->set_userdata('msg',$str);
        if($type=='SUCCESS'){
			$this->CI->session->set_userdata('class','success');
        }
        if($type=='ERROR'){
            $this->CI->session->set_userdata('class','error');
        }
    }
	function showMsg()
	{
		if($this->CI->session->userdata('msg'))
		{
			echo '<div class=" alert alert-'.$this->CI->session->userdata('class').' fade in ">';
			echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
			echo $this->CI->session->userdata('msg'); 
			echo "</div>";	
			$this->CI->session->unset_userdata('msg');
			$this->CI->session->unset_userdata('class');
		}
	}
	
	function sendMail($to,$sub,$body,$cc='')
	{
		$this->CI->load->library('email');
		$this->CI->email->set_mailtype('html');
		$this->CI->email->from('info@oxboll.com', 'OxBoll');
		if(@$cc){
			$this->CI->email->cc($cc);
		}
		$this->CI->email->to($to);
		$this->CI->email->subject($sub);
		$html='<div style="max-width:500px; float:left; background:#fff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
			<div style="text-align:center;padding:10px; font-weight:normal; background:#d9d9d9;">
				<a href="'.base_url().'">
					<img src="'.base_url().'/images/logo.png" border="0" align="middle" />
				</a>
			</div>
			<div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333;">
				<div style="color:#565656;">'.$body.'</div>
			</div>
			<div style="clear:both"></div>
			<p style="width:440px; background:#f2f2f2; padding:8px 30px;font-family:Arial, Helvetica, sans-serif; font-size:14px; margin:0;">Thank you. <br>OxBoll Team </p>
		</div>';
		$this->CI->email->message($html);
		return $this->CI->email->send();
	}
	
	 //pagination used in admin
	function pagination($target,$total_rows,$per_page,$uri=3,$search=null)
	{
	    $this->CI->load->library('pagination');
	    $config['base_url'] = $target;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page; 
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active"><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['last_tag_open'] = '<li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Previous';
		$config['next_link'] = 'Next';
		$config['uri_segment'] = $uri;
		$this->CI->pagination->initialize($config);
		return $this->CI->pagination->create_links($search);
	 }
 }