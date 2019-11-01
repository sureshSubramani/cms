<?php
class Sales_productsModel Extends CI_Model{

	public function insertSalseProduct($Postdata,$image){
			/*echo "<pre>";
			print_r($Postdata);
			echo "</pre>"; //exit;*/
			if(isset($image['product_image']) && $image['product_image']['name'] != '')
			{
				$filename = $image['product_image']['name'];
                $extension = explode('.', $filename);
                $ext = end($extension);
                $tmpName  = $image['product_image']['tmp_name'];
                $fileName = uniqid().".".$ext;  
                $path = 'assets/images/sales_product/'.$fileName; 
                move_uploaded_file($tmpName,$path); 	

			}
			else{
				 $fileName = $Postdata['product_image_edit'];
			}

		 

			$all_incredians = array();  

			if($Postdata['sales_product_id'] == 0){
				$insert_salesProduct = array('sales_product_name'=>$Postdata['sales_product_name'],'sales_product_type'=>$Postdata['sales_product_type'],'min_quantity'=>$Postdata['product_min_quantity'],'image'=>$fileName,'price'=>$Postdata['product_price'],'created_by'=>$this->session->userdata('user_id'));

				$this->db->insert(SALES_PRODUCT,$insert_salesProduct);

				$insert_id = $this->db->insert_id();

				for($i=0; $i<count($Postdata['product_code']); $i++){ 
					$all_incredians[] = array('sales_product_id'=>$insert_id,'product_code'=>$Postdata['product_code'][$i],'quantity'=>$Postdata['quantity'][$i],'uom'=>$Postdata['uom'][$i],'created_by'=>$this->session->userdata('user_id'));
				}	 

				$this->db->insert_batch(INGREDIENTS,$all_incredians);
			}
			else{
				$this->db->where('sales_product_id',$Postdata['sales_product_id']);
				$this->db->delete(INGREDIENTS);

				$insert_salesProduct = array('sales_product_name'=>$Postdata['sales_product_name'],'sales_product_type'=>$Postdata['sales_product_type'],'min_quantity'=>$Postdata['product_min_quantity'],'image'=>$fileName,'price'=>$Postdata['product_price'],'created_by'=>$this->session->userdata('user_id'));

				$this->db->where('sales_product_id',$Postdata['sales_product_id']);
				$this->db->update(SALES_PRODUCT,$insert_salesProduct);

				$insert_id = $Postdata['sales_product_id'];

				for($i=0; $i<count($Postdata['product_code']); $i++){ 
					$all_incredians[] = array('sales_product_id'=>$insert_id,'product_code'=>$Postdata['product_code'][$i],'quantity'=>$Postdata['quantity'][$i],'uom'=>$Postdata['uom'][$i],'created_by'=>$this->session->userdata('user_id'));
				}	 



				$this->db->insert_batch(INGREDIENTS,$all_incredians);

				/*for($i=0; $i<count($Postdata['product_code']); $i++){ 
					$Up_incredians = array('sales_product_id'=>$insert_id,'product_code'=>$Postdata['product_code'][$i],'quantity'=>$Postdata['quantity'][$i],'uom'=>$Postdata['uom'][$i],'created_by'=>$this->session->userdata('user_id'));
						
 

					$this->db->where('sales_product_id',$Postdata['sales_product_id']);
					$this->db->where('ingredients_id',$Postdata['ingredients_id'][$i]);
					$this->db->update(INGREDIENTS,$Up_incredians);
				}	 
*/

			}

			
	}

	public function GetSalesProducts(){

		$this->db->where('status',1);
		$sales_products = $this->db->get(SALES_PRODUCT)->result_array();

		print_r(json_encode($sales_products));
	}

	public function ViewProducts($pro_id){

		$this->db->where('status',1);
		$this->db->where('sales_product_id',$pro_id);
		$sales_products = $this->db->get(SALES_PRODUCT)->row_array();



		$this->db->where('i.status',1);
		$this->db->where('i.sales_product_id',$pro_id);
		$this->db->from(INGREDIENTS.' as i');
		$this->db->join(PRODUCTS.' as p','i.product_code = p.product_code','inner');
		/*$this->db->join(UOM.' as u','i.uom = u.uom_id','inner');*/
		$this->db->order_by('p.product_name');
		$view_inc = $this->db->get()->result_array();	

		$common_array = array('sales_products'=>$sales_products,'view_inc'=>$view_inc);

		print_r(json_encode($common_array));
	}

	public function GetallStalls(){
		$this->db->where('status', 1);
    	//$this->db->where('stall_code',$this->session->userdata('stall_code'));	
	 	$get_stall = $this->db->get(STALL)->row_array(); 

	 	print_r($get_stall);
		return $get_stall;
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
}

?>