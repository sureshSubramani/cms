<?php

class WastageModel Extends CI_Model{
	
	public function GetStockSales(){

		if($this->session->userdata('store_code')){
			$this->db->where('s.store_code',$this->session->userdata('store_code')); 	
		}
		if($this->session->userdata('stall_code')){
			$this->db->where('s.stall_code',$this->session->userdata('stall_code')); 	
		}	
		$this->db->where('s.status',1);
		$this->db->from(STOCK_OF_STALL.' as s');
		$this->db->join(PRODUCTS.' as p','p.product_code = s.product_code','left');
		$this->db->select('s.product_code,p.product_name,p.product_type,p.brand_name,s.quantity,p.uom,p.conversion_value');
		$this->db->order_by('p.product_name');
		$getStocks = $this->db->get()->result_array();	

		return $getStocks;
	}

	public function add_wastage($data){	

		if($data[0]['wastage_id'] == 0){
			//print_r($data['wastage_id']); exit;
			$add = $this->db->insert_batch(WASTAGE, $data);

			if($add == false){
    		    $this->session->set_flashdata('error', "Insertion error please try again...");
			}else{				
				$this->session->set_flashdata('success', "Successfully wastage items added to store manager..");
			}			
		}
			 
		for($i=0; $i<=count($data); $i++){		
			$waste_id = $data[$i]['wastage_id'];
			if($data[$i]['wastage_id'] != 0){

				if($this->session->userdata('user_id'))
				 $data[$i]['modified_by'] = $this->session->userdata('user_id');

				$data[$i]['approve_status'] = 0;
				

				$this->db->where('wastage_id', $data[$i]['wastage_id']);					
				$update = $this->db->update(WASTAGE, $data[$i]);

				if($update == false){
					$this->session->set_flashdata('error', "Insertion error please try again...");
				}else{				
					$this->session->set_flashdata('success', "Successfully updated wastage to store manager..");
				}						
			}
		}	
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

	public function get_current_stall(){
		$stall = array();	
		if($this->session->userdata('store_code') && $this->session->userdata('stall_code')){
		    
		    $this->db->where('store_code', $this->session->userdata('store_code'));
		    $this->db->where('stall_code', $this->session->userdata('stall_code'));

			//$this->db->where('p.status', 1);	
			$this->db->from(STALL);
			$stall = $this->db->get()->row_array();	 
		}
		return $stall;	
	}

	public function Get_by_id($wastage_id)
    {
        $this->db->from(WASTAGE);
		$this->db->where('wastage_id', $wastage_id);
        $query = $this->db->get();
   
        return $query->row_array();
	}
	
	public function viewWastageProducts($wastage_id){
		if($this->session->userdata('user_type') == STORE_MANAGER)
		 $this->db->where('store_code', $this->session->userdata('store_code'));

		$this->db->where('wastage_id', $wastage_id); 
		$get_wastage = $this->db->get(WASTAGE)->result_array();	 
		return $get_wastage;
	}

	public function GetWastageProducts(){
		if($this->session->userdata('user_type') == STORE_MANAGER)
		$this->db->where('w.store_code', $this->session->userdata('store_code'));

		if($this->session->userdata('user_type') == STALL_OPERATOR)
		$this->db->where('w.stall_code', $this->session->userdata('stall_code'));

		$this->db->where('w.status', 1);		
		$this->db->from(WASTAGE.' as w');
		$this->db->join(PRODUCTS.' as p', 'p.product_code = w.product_code');
		$this->db->join(STORES.' as s', 's.store_code = w.store_code');
		$this->db->join(STALL.' as st', 'st.stall_code = w.stall_code');
		$this->db->select('w.*, p.*, s.store_name, st.stall_name');	
		
		$this->db->order_by('w.status DESC, w.store_code, w.stall_code, w.approve_status, w.created_on DESC');	 
		$get_wastage = $this->db->get()->result_array();	 
		return $get_wastage;
	}	

	public function Edit_wastage_products($wastage_id){
		$this->db->where('status', 1);
		$this->db->where('wastage_id', $wastage_id);
		$get_wastage =  $this->db->get(WASTAGE)->row_array();
		return $get_wastage;
	}

	public function GetProductsDetails(){

		$this->db->where('p.status', 1);		
		$this->db->from(PRODUCTS.' as p');
		$this->db->join(PRODUCT_CATEGORY.' as c', 'p.category_id = c.category_id');
		$this->db->select('p.*, c.product_category');	
		$this->db->order_by('p.status DESC');	 
		$get_products = $this->db->get()->result_array();	 
		return $get_products;
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

	public function Accept_Wastage_Product($wastage_id, $stall_code, $product_code, $quantity_of_waste){

		//print_r($wastage_id." ".$stall_code." ".$product_code." ".$quantity_of_waste." "); exit;
		
		//getting existing-quantity with assign with new-stock quantity variable
		$this->db->where('status', 1);
		$this->db->select('quantity');
		$this->db->where('store_code', $this->session->userdata('store_code'));
		$this->db->where('stall_code', $stall_code);
		$this->db->where('product_code', $product_code);
		$query = $this->db->get(STOCK_OF_STALL)->row();	//$row = $query->row();
		$quantity_in_stock = $query->quantity;

		$new_quantity_in_stock = $quantity_in_stock - $quantity_of_waste;		

		//update stock table with new quanity-stock
		$this->db->where('status', 1);
		$this->db->where('store_code', $this->session->userdata('store_code'));
		$this->db->where('stall_code', $stall_code);
		$this->db->where('product_code', $product_code);
		$this->db->update(STOCK_OF_STALL, array('quantity' => $new_quantity_in_stock, 'modified_by' => $this->session->userdata('user_id') ));	

		if($this->session->userdata('store_code'))
		  $data_array = array('approve_status'=> 1, 'status'=>1, 'approved_by' => $this->session->userdata('user_id'));
		 
	 	$this->db->where('wastage_id', $wastage_id);
		$this->db->update(WASTAGE, $data_array);

		if(false){
			$this->session->set_flashdata('error', "Insertion error please try again...");
		}else{				
			$this->session->set_flashdata('success', "Successfully wastage items added to store manager..");
		}
		 
	}

	public function Reject_Wastage_Products($wastage_id){
		
		// if($this->session->userdata('store_code') && $this->session->userdata('stall_code'))
		//   $data_array = array('approve_status'=> 2, 'status'=>1, 'approved_by' => $this->session->userdata('user_id'));
		if($this->session->userdata('store_code'))
		  $data_array = array('approve_status' => 2, 'status'=>1, 'approved_by' => $this->session->userdata('user_id'));

	 	$this->db->where('wastage_id', $wastage_id);
	 	$this->db->update(WASTAGE, $data_array);
	}

	public function GetSallStock($scode, $stlcode, $pcode){	

		$this->db->where('stk_str.status', 1);	
		$this->db->where('stk_str.store_code', $scode);
		$this->db->where('stk_str.stall_code', $stlcode);
		$this->db->where('stk_str.product_code', $pcode);	
		$this->db->from(STOCK_OF_STALL.' as stk_str');
		//$this->db->join(PRODUCTS.' as p','p.product_code = stk_str.product_code','left');
		$this->db->from(UOM.' as u', 'u.uom = stk_str.uom', 'left');
		
		//$this->db->join(PRODUCT_CATEGORY.' as c', 'stk_stl.category_id = c.category_id');
		$this->db->select('stk_str.quantity, stk_str.uom, u.description');		 
		$get_products = $this->db->get()->row_array();	 
		//return $this->db->last_query(); 
		
		/*$uom = "Enter value in ";
		if(isset($get_products['description']) && $get_products['description'])
			$uom .= $get_products['description'];

		if(isset($get_products['uom']) && $get_products['uom'])
			$uom .= ' ('.$get_products['uom'].')';
		
		$stock = "";
		if(isset($get_products['quantity']) && $get_products['quantity']>0){
			$stock = $get_products['quantity'];
			
			if(isset($get_products['uom']) && $get_products['uom'])
				$stock .= ' ('.$get_products['uom'].')';
		}

		if($stock){
			$ret_val = $uom."<br><span style='color: #09960f'> Available stock is ".$stock."</span>";
		}
		else{
			$ret_val = "No stock available!";
		}*/
		
		$ret['stock'] = ((isset($get_products['quantity']) && $get_products['quantity']))?$get_products['quantity']:"";
		$ret['uom_description'] = ((isset($get_products['description']) && $get_products['description']))?$get_products['description']:"";
		$ret['uom'] = ((isset($get_products['uom']) && $get_products['uom']))?trim($get_products['uom']):"";
		

		return json_encode($ret);
		//return implode("|", $ret);
	}
}

?>