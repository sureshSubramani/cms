<?php
class LoginModel Extends CI_Model{

	public function GetUsrs($login_data){

		//echo md5($login_data['usr_password']);

		$this->db->where('status',1);
		$this->db->where('user_name',$login_data['usr_name']);	
		$this->db->where('password',md5($login_data['usr_password']));
		$get_usrs = $this->db->get(USERS)->result_array();	
 		//echo $this->db->last_query(); exit;
 		return $get_usrs;
	}

	public function get_store_details(){

		$this->db->where('status',1);
	 	$get_stores = $this->db->get(STORES)->result_array();

		return $get_stores;
 
	}

	public function getStalldetails($store_code){
		$this->db->where('status',1);
		$this->db->where('store_code',$store_code);
		$this->db->order_by('stall_code');
	 	$get_stall = $this->db->get(STALL)->result_array();
		//return $this->db->last_query();
		//return $get_stall;
		print_r(json_encode($get_stall));
	}
	public function get_current_store($strcode){
		$store = array();	
		if($strcode){
		    $this->db->where('store_code', $strcode);
			$this->db->where('status', 1);	
			$this->db->from(STORES);
			$store = $this->db->get()->row_array();	 
		}
		return $store;	
	}
	public function get_current_stall($strcode, $stlcode){
		$stall = array();	
		if($strcode && $stlcode){
		    $this->db->where('store_code', $strcode);
		    $this->db->where('stall_code', $stlcode);

			$this->db->where('status', 1);	
			$this->db->from(STALL);
			$stall = $this->db->get()->row_array();	 
		}
		return $stall;	
	}
}

?>