<?php class Common_model extends CI_Model {
    public function __construct(){
		parent::__construct();
    }
	
    public function tbl_insert($tablename,$Insertarr){
        $this->db->insert($tablename, $Insertarr);
        return $this->db->insert_id();
    }
	
    public function tbl_update($tbl,$con,$data){
        $this->db->where($con);
        //$this->db->update($tbl,$this->db->escape_str($data));
        $this->db->update($tbl,$data);
		//echo $this->db->last_query();exit;
        return $this->db->affected_rows();
    }
	
    public function tbl_record_del($tbl,$con){
        $this->db->where($con);
        $this->db->delete($tbl);
        return $this->db->affected_rows();
    }
    
    public function increase($tbl,$con,$field,$val){
        $this->db->set($field,'`'.$field.'`+'.$val,FALSE);
        $this->db->where($con);
        $this->db->update($tbl);
        return true;
    }
    
    public function decrease($tbl,$con,$field,$val){
        $this->db->set($field,'`'.$field.'`-'.$val,FALSE);
        $this->db->where($con);
        $this->db->update($tbl);
        return true;
    }
	
	public function get_result_array($table,$con=array()){
		if(!empty($con['select'])){
			$this->db->select($con['select']);
		}
		else{
			$this->db->select('*');
		}
		if(!empty($con['where'])){
			$this->db->where($con['where']);
		}
		if(!empty($con['or_where'])){
			foreach($con['or_where'] as $i=>$v){
				$this->db->or_where($v['key'],$v['val']);
			}
		}
		if(!empty($con['where_in'])){
			foreach($con['where_in'] as $i=>$v){
				$this->db->where_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['or_where_in'])){
			foreach($con['or_where_in'] as $i=>$v){
				$this->db->or_where_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['where_not_in'])){
			foreach($con['where_not_in'] as $i=>$v){
				$this->db->where_not_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['or_where_not_in'])){
			foreach($con['or_where_not_in'] as $i=>$v){
				$this->db->or_where_not_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['like'])){
			$this->db->like($con['like']);
		}
		if(!empty($con['or_like'])){
			foreach($con['or_like'] as $i=>$v){
				$this->db->or_like($v['key'],$v['val']);
			}
		}
		if(!empty($con['not_like'])){
			foreach($con['not_like'] as $i=>$v){
				$this->db->not_like($v['key'],$v['val']);
			}
		}
		if(!empty($con['or_not_like'])){
			foreach($con['or_not_like'] as $i=>$v){
				$this->db->or_not_like($v['key'],$v['val']);
			}
		}
		if(!empty($con['join'])){
			foreach($con['join'] as $i=>$v){
				$this->db->join($v['table'],$v['condition'],$v['type']);
			}
		}
		if(!empty($con['limit'])){
			$this->db->limit($con['limit']['per_page'],$con['limit']['offset']);
		}
		if(!empty($con['group_by'])){
			$this->db->group_by($con['group_by']);
		}
		if(!empty($con['having'])){
			$this->db->having($con['having']);
		}
		if(!empty($con['order_by'])){
			$this->db->order_by($con['order_by']);
		}
		return $this->db->get($table)->result_array();
	}
	
	public function get_row_array($table,$con=array()){
		if(!empty($con['select'])){
			$this->db->select($con['select']);
		}
		else{
			$this->db->select('*');
		}
		if(!empty($con['where'])){
			$this->db->where($con['where']);
		}
		if(!empty($con['or_where'])){
			foreach($con['or_where'] as $i=>$v){
				$this->db->or_where($v['key'],$v['val']);
			}
		}
		if(!empty($con['where_in'])){
			foreach($con['where_in'] as $i=>$v){
				$this->db->where_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['or_where_in'])){
			foreach($con['or_where_in'] as $i=>$v){
				$this->db->or_where_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['where_not_in'])){
			foreach($con['where_not_in'] as $i=>$v){
				$this->db->where_not_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['or_where_not_in'])){
			foreach($con['or_where_not_in'] as $i=>$v){
				$this->db->or_where_not_in($v['key'],$v['arr']);
			}
		}
		if(!empty($con['like'])){
			$this->db->like($con['like']);
		}
		if(!empty($con['or_like'])){
			foreach($con['or_like'] as $i=>$v){
				$this->db->or_like($v['key'],$v['val']);
			}
		}
		if(!empty($con['not_like'])){
			foreach($con['not_like'] as $i=>$v){
				$this->db->not_like($v['key'],$v['val']);
			}
		}
		if(!empty($con['or_not_like'])){
			foreach($con['or_not_like'] as $i=>$v){
				$this->db->or_not_like($v['key'],$v['val']);
			}
		}
		if(!empty($con['join'])){
			foreach($con['join'] as $i=>$v){
				$this->db->join($v['table'],$v['condition'],$v['type']);
			}
		}
		if(!empty($con['group_by'])){
			$this->db->group_by($con['group_by']);
		}
		if(!empty($con['having'])){
			$this->db->having($con['having']);
		}
		if(!empty($con['order_by'])){
			$this->db->order_by($con['order_by']);
		}
		return $this->db->get($table)->row_array();
	}
    
    public function get_data_array($tbl,$con=array(),$select='*',$joins=array(),$limit='',$page='',$group_by='',$order=''){
        $this->db->select($select);
        $this->db->from($tbl);
        if(!empty($joins)){
            foreach($joins as $k=>$v){
                $this->db->join($v['table'], $v['condition'], $v['jointype']);
            }
        }
        if($con!=NULL){
            $this->db->where($con);
        }
        if($order!=''){
            $this->db->order_by($order);
        }
        if($group_by!=''){
            $this->db->group_by($group_by);
        }
		if($limit!=''){
            $this->db->limit($limit,$page);
        }
        $res=$this->db->get();
		//echo $this->db->last_query();exit;
        return $res->result_array();
    }
	
    public function get_data_row($tbl,$con=array(),$select='*',$joins=array(),$order_by=''){
        $this->db->select($select);
        $this->db->from($tbl);
        if(!empty($joins)){
            foreach($joins as $k=>$v){
                $this->db->join($v['table'], $v['condition'], $v['jointype']);
            }
        }
        if($con!=NULL){
            $this->db->where($con);
        }
		if($order_by!=''){
			$this->db->order_by($order_by,'DESC');
		}
        $res=$this->db->get();
        return $res->row_array();
    }
	
    public function get_data($tbl,$con=array(),$order_con='',$select='*'){
        $this->db->select($select);
        $this->db->from($tbl);
        if($con!=NULL){
            $this->db->where($con);
        }
        if($order_con!=''){
            $this->db->order_by($order_con);
        }
        $res=$this->db->get();
		//echo $this->db->last_query();exit;
        return $res->result_array();
    }
	
}