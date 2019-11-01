<?php
class Movement_trackerModel Extends CI_Model{

	public function GetStockSales(){

		if($this->session->userdata('store_code')){
			$this->db->where('s.store_code',$this->session->userdata('store_code')); 	
		}	
		$this->db->where('s.status',1);
		$this->db->from(STOCK_OF_STORE.' as s');
		$this->db->join(PRODUCTS.' as p','p.product_code = s.product_code','inner');
		$this->db->select('s.product_code,p.product_name,p.product_type,p.brand_name,s.quantity,p.uom,p.conversion_value');
		$this->db->order_by('p.product_name');
		$getStocks = $this->db->get()->result_array();	

		return $getStocks;
	}

	public function GetProduct_details($product_code){

		if($this->session->userdata('user_role') == 'manager'){
			$this->db->where('s.store_code',$this->session->userdata('store_code')); 	
		}
		$this->db->where('s.product_code',$product_code);
		$this->db->where('s.status',1);
		$this->db->from(STOCK_OF_STORE.' as s');
		$this->db->join(PRODUCTS.' as p','p.product_code = s.product_code','inner');
		$this->db->select('s.quantity,s.uom,p.conversion_value');
		$getStocks = $this->db->get()->row_array();	

		print_r(json_encode($getStocks));
	}

	public function Insert_MT($data){

		/*echo "<pre>";
		print_r($data); 
		echo "</pre>"; exit; */
		$count_of_product = count($data['product_code']);
		$count_of_stock_quantity = count($data['stock_quantity']);
		$count_of_quantity = count($data['quantity']);

		$insertMT_array = $last = array();

		if($count_of_stock_quantity == $count_of_quantity){
			for($i=0; $i<count($data['product_code']);$i++){
				$insertMT_array[] = array('store_code'=>$this->session->userdata('store_code'),'stall_code'=>$data['get_stalls'],'product_code'=>$data['product_code'][$i],'quantity'=>$data['quantity'][$i],'uom'=>$data['uom'][$i],'movement_date'=>$data['movement_date'],'created_by'=>$this->session->userdata('user_id'));
			
				$this->db->where('store_code',$this->session->userdata('store_code'));
				$this->db->where('stall_code',$data['get_stalls']);
				$this->db->where('product_code',$data['product_code'][$i]);
				$stock_datas = $this->db->get(STOCK_OF_STALL);

				$stock_count = $stock_datas->num_rows();

				$stock_of_stall_afftected_rows = $stock_of_stall_last_id = "";

				if($stock_count == 1){
					// IF PRODUCT ALREADY EXIST THEN UPDATE AND ADD QUANTITY OF MOVED PRODUCT TO CURRENT STOCK OF THE PRODUCT
					$stock_row = $stock_datas->row_array();

					$total_quantity = ($data['quantity'][$i] + $stock_row['quantity']);

					$conversed_quantity = (($data['quantity'][$i] * $data['conversion_val'][$i]) + $stock_row['conversed_quantity']);

					$up_array = array('quantity'=>$total_quantity,'conversed_quantity'=>$conversed_quantity);

					if($this->session->userdata('user_id')){
						$this->db->set('modified_by',$this->session->userdata('user_id'));
					}
					$this->db->where('store_code',$this->session->userdata('store_code'));
					$this->db->where('stall_code',$data['get_stalls']);
					$this->db->where('product_code',$data['product_code'][$i]);
					$this->db->update(STOCK_OF_STALL,$up_array);
					$stock_of_stall_afftected_rows = $this->db->affected_rows();
					 
				}
				else{
					// INSERT MOVED PRODUCT IF IT IS NOT IN STOCK OF STALL
					$insert_array = array('store_code'=>$this->session->userdata('store_code'),'stall_code'=>$data['get_stalls'],'product_code'=>$data['product_code'][$i],'quantity'=>$data['quantity'][$i],'uom'=>$data['uom'][$i],'conversed_quantity'=>($data['quantity'][$i] * $data['conversion_val'][$i]),'created_by'=>$this->session->userdata('user_id'));

					$this->db->insert(STOCK_OF_STALL,$insert_array);
					$stock_of_stall_last_id = $this->db->insert_id();
				}
				//echo $this->db->last_query();
				//echo "<br>Rows: ".$stock_of_stall_afftected_rows."<br>ID: ".$stock_of_stall_last_id."<br>";
				echo "<br>Stk: ".$data['stock_quantity'][$i]."<br>Qty: ".$data['quantity'][$i]."<br>";

				//SUBTRACT QUANTITY IN STOCK OF STORE IF PRODUCT MOVED SUCCESSFULLY
				if($stock_of_stall_afftected_rows>0 || $stock_of_stall_last_id>0){				
					
					$stock_current_quantity = $data['stock_quantity'][$i] - $data['quantity'][$i]; // Reduce stock in store

					if($this->session->userdata('user_id')){
						$this->db->set('modified_by',$this->session->userdata('user_id'));
					}
					$this->db->set('quantity', $stock_current_quantity);
					$this->db->where('store_code',$this->session->userdata('store_code'));
					$this->db->where('product_code',$data['product_code'][$i]);
					$this->db->update(STOCK_OF_STORE); 
					$stock_of_afftected_rows = $this->db->affected_rows();
				} 
			}
			$this->db->insert_batch(MOVEMENT_TRACKER,$insertMT_array);
			$movement_afftected_rows = $this->db->affected_rows();
			$this->session->set_userdata('alert', 'Product moved Success');
		}
		else{
			$this->session->set_userdata('alert', 'Unable to move the selected product');
		}
		//exit;

	}

	public function GetMovement_tracker(){

		if($this->session->userdata('user_type') == STORE_MANAGER){
			$this->db->where('m.store_code',$this->session->userdata('store_code')); 	
		}
		else if($this->session->userdata('user_type') == STALL_OPERATOR){
			$this->db->where('m.store_code',$this->session->userdata('store_code')); 
			$this->db->where('m.stall_code',$this->session->userdata('stall_code')); 	
		}
		$this->db->where('m.status',1);
		$this->db->from(MOVEMENT_TRACKER.' as m');
		$this->db->join(PRODUCTS.' as p','p.product_code = m.product_code','inner');
		$this->db->join(STALL.' as stl','stl.stall_code = m.stall_code', 'left');
		$this->db->join(STORES.' as str','str.store_code = m.store_code', 'left');
		
		$this->db->group_by('m.movement_date, m.product_code');
		$this->db->order_by('m.movement_date DESC, m.product_code');
		$this->db->select('sum(m.quantity) as quantity,m.product_code,m.movement_date,p.product_name,p.*, str.store_name, str.store_code, stl.stall_name, stl.stall_code');

		$getStocks = $this->db->get()->result_array();
 
		print_r(json_encode($getStocks));	
	}

	public function GetStallStock($pcode){	

		$this->db->where('stk_stl.status', 1);	
		$this->db->where('stk_stl.product_code', $pcode);	
		$this->db->from(STOCK_OF_STALL.' as stk_stl');
		$this->db->join(PRODUCTS.' as p','p.product_code = stk_stl.product_code','left');
		$this->db->join(UOM.' as c', 'stk_stl.uom = c.uom', 'left');
		
		//$this->db->join(PRODUCT_CATEGORY.' as c', 'stk_stl.category_id = c.category_id');
		$this->db->select('p.uom, c.description, stk_stl.quantity');		 
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
		$ret['uom'] = ((isset($get_products['uom']) && $get_products['uom']))?$get_products['uom']:"";
		

		return json_encode($ret);
		//return implode("|", $ret);
	}
	public function GetStoreStock($scode, $pcode){	

		$this->db->where('stk_str.status', 1);	
		$this->db->where('stk_str.store_code', $scode);
		$this->db->where('stk_str.product_code', $pcode);	
		$this->db->from(STOCK_OF_STORE.' as stk_str');
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