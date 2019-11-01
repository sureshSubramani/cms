<?php
class Stall_productsModel Extends  CI_Model{

	public function Getsales_products(){
		$this->db->where('status',1);
		$sales_products = $this->db->get(SALES_PRODUCT)->result_array();

		return $sales_products;
	}
	
	public function InsertSalesproducts($data){
 
			$insert_array = array();

			if(count($data['salesProdus']) > 0){
				for($i=0; $i<count($data['salesProdus']); $i++){ 
					$insert_array[] = array('created_by'=>$this->session->userdata('user_id'),'store_code'=>$this->session->userdata('store_code'),'stall_code'=>$data['get_stalls'],'sales_product_id'=>$data['salesProdus'][$i]);
				}

				$this->db->where('stall_code',$data['get_stalls']);
				$this->db->delete(STOCK_OF_SALES);

				$this->db->insert_batch(STOCK_OF_SALES,$insert_array); 
			}
	 
			
		
	}

	public function GetStockSales($stall_id){

		$this->db->where('stall_code',$stall_id);
		$stock_sales = $this->db->get(STOCK_OF_SALES)->result_array();

		print_r(json_encode($stock_sales));

	}

}


?>