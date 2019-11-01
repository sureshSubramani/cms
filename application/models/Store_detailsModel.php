<?php
class Store_detailsModel Extends CI_Model{

	public function getStoreCode(){

		$storeDetails = $this->db->get(STORES)->num_rows();


		$prefix = 'STR'; 
               
        if($storeDetails == 0){
        	
        	$number = 1;
        }
        else{
        	$number = $storeDetails + 1;
        }
		   
		$unique = str_pad($number, 3, "0", STR_PAD_LEFT);
		$storecode = $prefix . $unique;

		return $storecode;
	}

	public function StoreDatas($store){			

		if($store['store_id'] == 0){
 
			unset($store['store_id']);
			if($this->session->userdata('user_id'))
				$store['created_by'] = $this->session->userdata('user_id');
				$this->db->insert(STORES, $store);
				/* $insrt_store_id = $this->db->insert_id();
			    $usrs = $usrs + array('usr_type_id'=>$insrt_store_id);

				$this->db->insert(USERS,$usrs); */
		}
		else{		

			/*$up_array = array('user_name'=>$store['store_email']);
			$this->db->where('usr_type_id',$store['store_id']);
			$this->db->update(USERS,$up_array);*/
			
			if($this->session->userdata('user_id'))
				$store['modified_by'] = $this->session->userdata('user_id');
				$this->db->where('store_id', $store['store_id']);
				$this->db->update(STORES,$store);
		} 

	}

	public function GetStores(){
		if($this->session->userdata('store_code')){
			$this->db->where('store_code', $this->session->userdata('store_code'));
		}
		//$this->db->where('status', 1);		
		$this->db->order_by('status DESC');	
	 	$get_stores = $this->db->get(STORES)->result_array();
	 	//echo $this->db->last_query(); exit;

		return $get_stores;
	}

	public function Edit_store($store_code){

		$this->db->where('store_id', $store_code);
		$get_store = $this->db->get(STORES)->row_array();

		/*print_r($store_code);

		die();


		$get_store = array();
		$logged_store_code = "";
		if($this->session->userdata('store_code')){
			$logged_store_code = $this->session->userdata('store_code');
		}

		if($logged_store_code=="" || $logged_store_code == $store_code){
			//$this->db->where('status',1);
			$this->db->where('store_id', $store_id);
		 	$get_store = $this->db->get(STORES)->row_array();
		 }*/
		return $get_store;
	}

	public function DeleteStores($store_id, $status){

		if($status == 1){ $status = 0;}else{ $status = 1;}

		$up_array = array('status'=> $status);

 		$this->db->where('store_id', $store_id);
		$this->db->update(STORES,$up_array);	

	}
}

?>