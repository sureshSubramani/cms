<?php

class ProductCategory_model Extends CI_Model{

	public function Get_ProductCategory(){		
	    //$this->db->where('product_status',1);	
		$this->db->order_by('status DESC');
		$get_pro_category = $this->db->get(PRODUCT_CATEGORY)->result_array();	 
        return $get_pro_category;
	} 
	
	public function Edit_category_details($cat_id){
		//$this->db->where('product_status',1);
		$this->db->where('category_id', $cat_id);
	 	$get_cat = $this->db->get(PRODUCT_CATEGORY)->row_array();
	 	//return $this->db->last_query();
		return $get_cat;
	}
	public function InsertCategory($product){
			 
			/*echo "<pre>SS";
			print_r($product);
			echo "</pre>"; exit;*/

			$error = 1;
			$msg = "";
			if(isset($product['form_type'])){
				
				if(strtolower($product['form_type']) == "add"){ 
					if($this->session->userdata('user_id')){
						$product_category = (isset($product['product_category']) && $product['product_category'])?$product['product_category']:"";
						$short_name = (isset($product['short_name']) && $product['short_name'])?$product['short_name']:"";
						$category_details = (isset($product['category_details']) && $product['category_details'])?$product['category_details']:"";
						$status = (isset($product['status']) && $product['status'])?$product['status']:"0";
						
						if($product_category && $short_name){
							//Validate product code

							$exist_cat = 0; 
							$exist_sname = 0;
							//$exist_cat = ProductCategory_model::is_exist_category($product_category); 
							//$exist_sname = ProductCategory_model::is_exist_short_name($short_name); 
 

							if(!$exist_cat && !$exist_sname){
								$insert_data['product_category'] = $product_category;
								$insert_data['short_name'] = $short_name;
								$insert_data['category_details'] = $category_details;
								$insert_data['status'] = $status;
								$insert_data['created_by'] = $this->session->userdata('user_id');
								
								$this->db->insert(PRODUCT_CATEGORY, $insert_data);
								$last_id = $this->db->insert_id();

								if($last_id){
									$msg = "Category '".$insert_data['product_category']." (".$short_name.")' added successfully!";
									$error = "0";
								}
								else{
									$msg = $result." Unable to execute!";
								}
							}
				            else if(!$exist_cat){
				                $msg = "Category already registered. Enter another one!";
				            }
				            else if(!$exist_sname){
				                $msg = "Short name already exist. Use another one!";
				            }
				            else{
				            	$msg = "Error";
				            }
						}
			            else if($product_category==""){
			                $msg = "Enter category name!";
			            }
			            else if($short_name==""){
			                $msg = "Enter short name!";
			            }
			            else{
			                $msg = "Unknown error. Unable to add";
			            }

					}
					else{
						$msg = "No user logged in!";
					}
				}
				else if(strtolower($product['form_type']) == "edit"){ 
					
					if($this->session->userdata('user_id')){
						$category_id = (isset($product['category_id']) && $product['category_id'])?$product['category_id']:"";
						$product_category = (isset($product['product_category']) && $product['product_category'])?$product['product_category']:"";
						$short_name = (isset($product['short_name']) && $product['short_name'])?$product['short_name']:"";
						$category_details = (isset($product['category_details']) && $product['category_details'])?$product['category_details']:"";
						$status = (isset($product['status']) && $product['status'])?$product['status']:"0";
						
						if($category_id && $product_category && $short_name){
							//Validate product code

							$exist_cat = 0; 
							$exist_sname = 0; 
							//Check that category and short name is already exist or not
							//$exist_cat = ProductCategory_model::is_exist_category($product_category); 
							//$exist_sname = ProductCategory_model::is_exist_short_name($short_name); 
 
							//Allow category and short name if not existing
							if(!$exist_cat && !$exist_sname){

								$update_data['product_category'] = $product_category;
								$update_data['category_details'] = $category_details;
								$update_data['short_name'] = $short_name;
								$update_data['status'] = $status;
								$update_data['modified_by'] = $this->session->userdata('user_id');
								
								$this->db->where('category_id',$category_id);
								$this->db->update(PRODUCT_CATEGORY, $update_data);  
								//echo $this->db->last_query(); exit;

	                            $msg = $afftected_rows = $this->db->affected_rows();

	                            if($afftected_rows>0){
	                                $msg = $afftected_rows." record updated successfully!";
	                                $error = "0";
	                            }
	                            else{
	                                //$msg = $this->db->last_query()." Unable to execute!";
	                                $msg = (($afftected_rows==0)?$afftected_rows:0)." record updated!";
	                            }
							}
				            else if(!$exist_cat){
				                $msg = "Category already registered. Enter another one!";
				            }
				            else{
				            	$msg = "Error";
				            }
						}
			            else if($product_category==""){
			                $msg = "Enter category name!";
			            }
			            else if($short_name==""){
			                $msg = "Enter short name!";
			            }
			            else if($short_name==""){
			                $msg = "Enter short name!";
			            }
			            else{
			                $msg = "Unknown error. Unable to add";
			            }

					}
					else{
						$msg = "No user logged in!";
					}	
				}
				else{
					$msg = "Unknown operation!";
				} 
			}

			return $error."|".$msg;
	}

	public function Disable_Category($category_id, $status){

		if($status == 1){$status = 0;}else{ $status = 1;}

		$up_array = array('status' => $status);
 		$this->db->where('category_id', $category_id);
		$this->db->update(PRODUCT_CATEGORY, $up_array);
	    
	}
}

?>