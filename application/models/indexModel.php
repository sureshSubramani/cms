<?php
class IndexModel Extends CI_Model{

	public function get_pending_wastage_approval(){
		$this->db->where('status',1);
		$this->db->where('approve_status',0);
		$this->db->where('store_code',$this->session->userdata('store_code'));
		$this->db->select('COUNT(*) as count');
	 	$get_stall = $this->db->get(WASTAGE)->row_array();
		//return $this->db->last_query();
		return $get_stall;
	}

	public function get_total_sales_products(){

		  $get_sales = $this->db
							->where('status', 1)
							->select('count(sales_product_id) as tsp')
							->select('count(quantity) as out_of_stock')
							->get(STOCK_OF_SALES)->row_array();
	
		return $get_sales;
	  }

	  
}

?>