<?php

class Stall_detailsModel Extends CI_Model{

	public function GetStallCode($store_code){

		$this->db->where('store_code', $store_code);
		$stallDetails = $this->db->get(STALL)->num_rows();


		$prefix = $store_code.'STL'; 
               
        if($stallDetails == 0){
        	
        	$number = 1;
        }
        else{
        	$number = $stallDetails + 1;
        }
		   
		$unique = str_pad($number, 3, "0", STR_PAD_LEFT);
		$stallcode = $prefix . $unique;

		print_r($stallcode);

	}

	public function StallDatas($stall){
		
		if($stall['stall_id'] == 0){

			unset($stall['stall_id']);
			
			if($this->session->userdata('user_id'))
			$stall['created_by'] = $this->session->userdata('user_id');

			$this->db->insert(STALL, $stall);  
		}
		else{
			unset($stall['store_code']);
			if($this->session->userdata('user_id'))
			$stall['modified_by'] = $this->session->userdata('user_id');
				 
			$this->db->where('stall_id', $stall['stall_id']);
			$this->db->update(STALL, $stall);
		}
	}

	public function Validate_Exists($stall_code){

		$this->db->where('stall_code', $stall_code);
		$data = $this->db->get(STALL)->num_rows();

		print_r($data);
	}

	public function GetStalls(){		

		/*if($this->session->userdata('user_role') == 'manager'){
			$this->db->where('st1.store_code',$this->session->userdata('store_code')); 	
		}*/	
		if($this->session->userdata('store_code')){
			$this->db->where('st1.store_code',$this->session->userdata('store_code')); 
		}
		if($this->session->userdata('stall_code')){
			$this->db->where('st1.stall_code',$this->session->userdata('stall_code')); 
		}	
		$this->db->from(STALL.' as st1');
		$this->db->join(STORES.' as st2','st2.store_code = st1.store_code'); 
		$this->db->select('st1.*, st2.store_name');		
		$this->db->order_by('status DESC, store_code, stall_code');
		$get_stall = $this->db->get()->result_array();		 
		return $get_stall;	 	
	}

	public function Edit_stall($stall_id){

		//$this->db->where('status', 1);
		$this->db->where('stall_id', $stall_id);
	 	$get_stall = $this->db->get(STALL)->row_array();

		return $get_stall;
	}

	public function DeleteStall($stall_id, $status){

		if($status == 1){ $status = 0;}else{ $status = 1;}
		if($this->session->userdata('user_id'))
			$user = $stall['modified_by'] = $this->session->userdata('user_id');
		
		$up_array = array(
			               'status'=> $status,
						   'modified_by' => $user
						);		

 		$this->db->where('stall_id', $stall_id);
		$this->db->update(STALL, $up_array); 
	}
}

?>