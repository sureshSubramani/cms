<?php

class Stock_of_storeModel Extends CI_Model{

	public function GetStoresStock(){		
	    //$this->db->where('status',1);	
		
		if($this->session->userdata('store_code')){
			$this->db->where('st.store_code', $this->session->userdata('store_code'));
		}
		else if($this->input->get_post('store')){
			$this->db->where('st.store_code', $this->input->get_post('store'));
		}
		$this->db->order_by('st.status DESC');
		$this->db->from(STOCK_OF_STORE.' as st');
		$this->db->join(STORES.' as str','str.store_code = st.store_code', 'left');
		$this->db->join(PRODUCTS.' as p','p.product_code = st.product_code', 'left');
		$get_stock = $this->db->get()->result_array();	
		//echo $this->db->last_query(); exit;
        return $get_stock;
	} 
	public function GetStores(){		
	    $this->db->where('status',1);		
		//$this->db->order_by('status DESC');
		if($this->session->userdata('store_code')){
			$this->db->where('store_code', $this->session->userdata('store_code'));
		}
		$get_stores = $this->db->get(STORES)->result_array();	 
        return $get_stores;
	} 
	
}

?>