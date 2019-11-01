<?php

class Stock_of_stallModel Extends CI_Model{

	public function GetStallStock(){		
	   //$this->db->where('status',1);	
		if($this->session->userdata('store_code')){
			$this->db->where('st.store_code', $this->session->userdata('store_code'));
		}
		else if($this->input->get_post('store')){
			$this->db->where('st.store_code', $this->input->get_post('store'));
		}
		
		if($this->session->userdata('stall_code')){
			$this->db->where('st.stall_code', $this->session->userdata('stall_code'));
		}
		else if($this->input->get_post('stall')){
			$this->db->where('st.stall_code', $this->input->get_post('stall'));
		}
		$this->db->order_by('st.status DESC, st.store_code, st.stall_code');
		$this->db->from(STOCK_OF_STALL.' as st');
		$this->db->join(STALL.' as stl','stl.stall_code = st.stall_code', 'left');
		$this->db->join(STORES.' as str','str.store_code = st.store_code', 'left');
		$this->db->join(PRODUCTS.' as p','p.product_code = st.product_code', 'left');
		$get_stall = $this->db->get()->result_array();	
		//echo $this->db->last_query(); exit;
        return $get_stall; 
	} 
	public function GetStall(){		
	    $this->db->where('status',1);		
		//$this->db->order_by('status DESC');
		if($this->session->userdata('store_code')){
			$this->db->where('store_code', $this->session->userdata('store_code'));
		}
		if($this->session->userdata('stall_code')){
			$this->db->where('stall_code', $this->session->userdata('stall_code'));
		}
		$get_stores = $this->db->get(STALL)->result_array();	 
        return $get_stores;
	} 

}

?>