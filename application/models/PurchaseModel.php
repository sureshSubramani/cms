<?php

class PurchaseModel Extends CI_Model{

	public function Add_purchase($data){
		/*echo "<pre>";
		print_r($data);
		echo "<pre>"; exit;*/
		$this->db->insert_batch(PURCHASE, $data);	
	}

	public function Add_invoice($data){

		$this->db->insert_batch(INVOICE, $data);	
	}
	public function get_current_store(){	
		$store = array();	
		if($this->session->userdata('store_code')){
		    $this->db->where('store_code', $this->session->userdata('store_code'));

			//$this->db->where('p.status', 1);	
			$this->db->from(STORES);
			$store = $this->db->get()->row_array();	 
		}
		return $store;	
	}
	public function get_purchase_details(){	

		if($this->session->userdata('user_type') == STORE_MANAGER)
		    $this->db->where('p.store_code', $this->session->userdata('store_code'));

			//$this->db->where('p.status', 1);	
			$this->db->from(PURCHASE.' as p');
			$this->db->join(STORES.' as s', 's.store_code = p.store_code', 'left');
			$this->db->join(SUPPLIER.' as sp', 'sp.supplier_id = p.supplier_id', 'left');
			$this->db->join(PRODUCTS.' as pr', 'pr.product_code = p.product_code', 'left');
			$this->db->order_by('p.status DESC, p.purchase_date DESC, p.created_on DESC, p.invoice_number DESC');	 
			$this->db->select('p.*, s.store_name, sp.supplier_name, pr.product_name, pr.product_type, pr.product_code, pr.brand_name');	
			$get_purchase = $this->db->get()->result_array();
			
			//print_r($get_purchase); exit;
			return $get_purchase;	
	}

	public function GetProductsDetails(){		
		$this->db->where('p.status', 1);	
		$this->db->from(PRODUCTS.' as p');
		$this->db->join(PRODUCT_CATEGORY.' as c', 'p.category_id = c.category_id');
		$this->db->select('p.*, c.product_category');	
		$this->db->order_by('p.status DESC, p.product_name');	 
		$get_products = $this->db->get()->result_array();	 
		return $get_products;
	} 

	public function GetProductsUOM($pcode){	

		$this->db->where('p.status', 1);	
		$this->db->where('p.product_code', $pcode);	
		$this->db->from(PRODUCTS.' as p');
		$this->db->join(UOM.' as c', 'p.uom = c.uom', 'left');
		//$this->db->join(STOCK_OF_STALL.' as stk_stl', 'stk_stl.product_code = p.product_code', 'left');
		//$this->db->join(PRODUCT_CATEGORY.' as c', 'p.category_id = c.category_id');
		$this->db->select('p.uom, c.description');		 
		$get_products = $this->db->get()->row_array();	 
		//return $this->db->last_query(); 
		
		
		$ret['uom_description'] = ((isset($get_products['description']) && $get_products['description']))?$get_products['description']:"";
		$ret['uom'] = ((isset($get_products['uom']) && $get_products['uom']))?trim($get_products['uom']):"";

		return json_encode($ret);
	}

	public function GetSupplier(){

	 	$this->db->where('status', 1);
	 	$get_supplier = $this->db->get(SUPPLIER)->result_array();
	 
	 	return $get_supplier;
	}

	public function GetStore(){

		$this->db->where('status', 1);
		$get_stores = $this->db->get(STORES)->result_array();
	
		return $get_stores;
    }

	public function GetUOM(){

		$this->db->where('status', 1);
		$get_uom = $this->db->get(UOM)->result_array();
	
		return $get_uom;
	} 
	
	public function DisablePurchase($purchase_id, $status){

		if($status == 1){$status = 0;}else{ $status = 1;}

		$up_array = array('status' => $status);
 		$this->db->where('purchase_id', $purchase_id);
		$this->db->update(PURCHASE, $up_array);	    
	}
}

?>