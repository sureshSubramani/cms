<?php

class Product_detailsModel Extends CI_Model{

	public function InsertProducts($product){
			 
			/*echo "<pre>";
			print_r($product);
			echo "</pre>"; //exit;*/

			$error = 1;
			$msg = "";
			if(isset($product['form_type'])){
				
				if(strtolower($product['form_type']) == "add"){ 
					if($this->session->userdata('user_id')){
						$category_id = (isset($product['category_id']) && $product['category_id'])?$product['category_id']:"";
						$product_code = (isset($product['product_code']) && $product['product_code'])?$product['product_code']:"";
						$product_name = (isset($product['product_name']) && $product['product_name'])?$product['product_name']:"";
						$brand_name = (isset($product['brand_name']) && $product['brand_name'])?$product['brand_name']:"";
						$product_type = (isset($product['product_type']) && $product['product_type'])?$product['product_type']:"";
						$description = (isset($product['description']) && $product['description'])?$product['description']:"";
						$uom = (isset($product['uom']) && $product['uom'])?$product['uom']:"";
						//$conversion_value = (isset($product['conversion_value']) && $product['conversion_value']!="")?$product['uom']:"0";
						
						if($product_name && $category_id && $product_code && $uom){
							//Validate product code

							$available_pcode = Product_detailsModel::generate_product_code($category_id); 

							if($product_code==$available_pcode){
								$insert_data['category_id'] = $category_id;
								$insert_data['product_code'] = $product_code;
								$insert_data['product_name'] = $product_name;
								$insert_data['brand_name'] = $brand_name;
								$insert_data['product_type'] = $product_type;
								$insert_data['description'] = $description;
								$insert_data['uom'] = $uom;
								//$insert_data['conversion_value'] = $product['conversion_value'];
								$insert_data['created_by'] = $this->session->userdata('user_id');
								
								$this->db->insert(PRODUCTS, $insert_data);
								$last_id = $this->db->insert_id();

								if($last_id){
									$msg = "Product '".$insert_data['product_name']." (".$product_code.")' added successfully!";
									$error = "0";
								}
								else{
									$msg = $result." Unable to execute!";
								}
							}
				            else {
				                $msg = "Product code already registered. Kindly re-select the category!";
				            }
						}
			            else if($product_name==""){
			                $msg = "Enter product name!";
			            }
			            else if($category_id==""){
			                $msg = "Select a category!";
			            }
			            else if($product_code==""){
			                $msg = "Unable to generate product code!!";
			            }
			            else if($uom==""){
			                $msg = "Select a UOM!";
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
						$product_id = (isset($product['product_id']) && $product['product_id'])?$product['product_id']:"";
						$product_name = (isset($product['product_name']) && $product['product_name'])?$product['product_name']:"";
						$brand_name = (isset($product['brand_name']) && $product['brand_name'])?$product['brand_name']:"";
						$product_type = (isset($product['product_type']) && $product['product_type'])?$product['product_type']:"";
						$description = (isset($product['description']) && $product['description'])?$product['description']:"";
						$uom = (isset($product['uom']) && $product['uom'])?$product['uom']:"";
						//$conversion_value = (isset($product['conversion_value']) && $product['conversion_value']!="")?$product['uom']:"0";
						
						if($product_id && $product_name && $uom){
							$update_data['product_name'] = $product_name;
							$update_data['brand_name'] = $brand_name;
							$update_data['product_type'] = $product_type;
							$update_data['description'] = $description;
							$update_data['uom'] = $uom;
							//$update_data['conversion_value'] = $product['conversion_value'];
							$update_data['modified_by'] = $this->session->userdata('user_id');
							
							$this->db->where('product_id',$product_id);
							$this->db->update(PRODUCTS, $update_data);	

							$afftected_rows = $this->db->affected_rows();

							if($afftected_rows>0){
								$msg = $afftected_rows." record updated successfully!";
								$error = "0";
							}
							else{
								//$msg = $this->db->last_query()." Unable to execute!";
								$msg = (($afftected_rows==0)?$afftected_rows:0)." record updated!";
							}
						}
			            else if($product_name==""){
			                $msg = "Enter product name!";
			            }
			            else if($uom==""){
			                $msg = "Select a UOM!";
			            }
			            else if($product_id=="" || $product_id<1){
			                $msg = "Record ID not found!";
			            }
			            else{
			                $msg = "Unknown error. Unable to edit";
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
	public function addNewCategory($newCat){
		//echo $newCat; exit;

		$msg = "";
		if($newCat!=""){ 
			$cat['product_category'] = $newCat;
			$cat['created_by'] = $this->session->userdata('user_id');
			$this->db->insert(PRODUCT_CATEGORY, $cat);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}
	public function GetProductCategory(){
		$this->db->distinct();			
		$this->db->order_by('product_category');
		$this->db->where('status', 1);
		$get_pro_cat = $this->db->get(PRODUCT_CATEGORY)->result_array();
		//echo $this->db->last_query(); exit;
		return $get_pro_cat;
		// $this->db->order_by('category_id','desc'); 
		// $get_pro_code = $this->db->get(PRODUCTS)->result_array();
		// return array('cat'=>$get_pro_cat,'category_id'=>count($get_pro_code));
	}

	public function GetProductsDetails(){		
		//$this->db->where('p.status', 1);
		if($this->session->userdata('product_details_category_id') && $this->session->userdata('product_details_category_id')!=""){
			$this->db->where('p.category_id', $this->session->userdata('product_details_category_id'));
		}	
		$this->db->from(PRODUCTS.' as p');
		$this->db->join(PRODUCT_CATEGORY.' as c', 'p.category_id = c.category_id');
		$this->db->select('p.*, c.product_category');	
		$this->db->order_by('p.status DESC, p.product_name');	 
		$get_products = $this->db->get()->result_array();	 
		return $get_products;
	} 
	public function generate_product_code($catId){
		$pcode = "";
		if($catId){
			//$this->db->where('status', 1);
			$this->db->where('category_id', $catId);
			//Get Short Name of Category 
			$pro_cat = $this->db->get(PRODUCT_CATEGORY)->row_array();
			
			if($pro_cat['short_name']){
				//$this->db->where('status', 1);
				$this->db->where('category_id', $catId);
				$this->db->select('product_code');
				//Get exist product code under this category
				$exist_pcode = $this->db->get(PRODUCTS)->result_array();

				$temp = $pre_num = array();
				if(!empty($exist_pcode)){					
					foreach($exist_pcode as $k=>$v){
						$pre = substr($v['product_code'],0,strlen($pro_cat['short_name']));
						if($pre == $pro_cat['short_name']){
							$num = $pre_num[] = ltrim(str_replace($pro_cat['short_name'], "", $v['product_code']), '0');
							//$temp[] = $pre." - ".$num;
						}
					}
				}
				$max = 1;
				if(!empty($pre_num)){
					$max = max($pre_num)+1;
				}
				
				$numb = str_pad($max, 4, '0', STR_PAD_LEFT);
				$pcode = $pro_cat['short_name'].$numb;
				
			}

		}
		return $pcode;
		//return $temp;
	}
	public function GetUOM(){		
		//$this->db->distinct();
		//$this->db->select('product_name');
		$uom = $this->db->get(UOM)->result_array();
		return $uom;
	} 
	
	public function Edit_product_details($product_id){
		//$this->db->where('product_status',1);
		$this->db->where('product_id', $product_id);
	 	$get_pro = $this->db->get(PRODUCTS)->row_array();

		return $get_pro;
	}

	public function Add_product_details(){

		//$this->db->where('product_status',1);
		$this->db->where('product_id', $product_id);
	 	$get_pro = $this->db->get(PRODUCTS)->row_array();

		return $get_pro;
	}

	public function DisableProduct($product_id, $status){

		if($status == 1){$status = 0;}else{ $status = 1;}

		$up_array = array('status' => $status);
 		$this->db->where('product_id', $product_id);
		$this->db->update(PRODUCTS, $up_array);
	    
	}
}

?>