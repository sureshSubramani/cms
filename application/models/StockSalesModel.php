<?php

class StockSalesModel Extends CI_Model{

	public function GetSalesStock(){
	   	
    if($this->session->userdata('store_code')){

      $this->db->where('a.store_code', $this->session->userdata('store_code'));
      if($this->session->userdata('stall_code')){
        $this->db->where('a.stall_code', $this->session->userdata('stall_code'));     
      }  
      
      /*$get_sales = $this->db
                ->where('sp.status', 1)
                ->select('sp.*, sp.sales_product_id, ss.quantity, count(sp.sales_product_id) as num_of_times')
                ->from(SALES_PRODUCT.' as sp')
                ->join(STOCK_OF_SALES.' as ss', 'sp.sales_product_id = ss.sales_product_id', 'left')
                ->join(INGREDIENTS.' as in', 'in.sales_product_id = sp.sales_product_id', 'left')                      
                ->group_by('sp.sales_product_id')
                ->order_by('sp.sales_product_id')
                ->get()->result(); */ 

      $get_sales_product = $this->db
                ->where('a.status', 1)
                ->from(STOCK_OF_SALES.' as a')
                ->join(SALES_PRODUCT.' as b', 'b.sales_product_id = a.sales_product_id', 'left')
                ->join(INGREDIENTS.' as d', 'd.sales_product_id = a.sales_product_id', 'full') 
                ->join(PRODUCTS.' as p', 'p.product_code = d.product_code', 'left')  
                ->join(STOCK_OF_STALL.' as ss', 'ss.product_code = d.product_code', 'left')    
                ->select('a.`sales_product_id`, 
                          b.`sales_product_name`, 
                          b.`sales_product_type`, 
                          b.`min_quantity`, 
                          b.`image`, 
                          b.`price`, 
                          b.`currency`, 
                          a.`quantity` as sales_stock_qty,
                          d.`ingredients_id`,
                          d.`product_code`,
                          p.`product_name`, 
                          ss.`quantity` as stock_qty,
                          d.`quantity` as incredient_qty, 
                          d.`uom`,
                          FLOOR(ss.`quantity` / d.`quantity`) as available_qty')               
                ->order_by('b.`sales_product_name`, p.`product_name`')
                ->get()->result_array();
                //echo $get_sales; exit;
      
      $get_sales = array();
      
      if(!empty($get_sales_product)){
        
        foreach ($get_sales_product as $key => $value) {

          $get_sales[$value['sales_product_id']]['sales_product_id'] = $value['sales_product_id'];
          $get_sales[$value['sales_product_id']]['sales_product_name'] = $value['sales_product_name'];
          $get_sales[$value['sales_product_id']]['sales_product_type'] = $value['sales_product_type'];
          $get_sales[$value['sales_product_id']]['min_quantity'] = $value['min_quantity'];
          $get_sales[$value['sales_product_id']]['image'] = $value['image'];
          $get_sales[$value['sales_product_id']]['price'] = $value['price'];
          $get_sales[$value['sales_product_id']]['currency'] = $value['currency'];
          $get_sales[$value['sales_product_id']]['sales_stock_qty'] = $value['sales_stock_qty'];
          
          //Set empty if available qty is null
          $value['available_qty'] = ($value['available_qty']>0)?$value['available_qty']:"";
          if(!isset($get_sales[$value['sales_product_id']]['available_qty']) || $get_sales[$value['sales_product_id']]['available_qty']>$value['available_qty']){
            //Assign small quantity as avaialable quantity
            $get_sales[$value['sales_product_id']]['available_qty'] = $value['available_qty'];
          }

          $get_sales[$value['sales_product_id']]['incredients'][$value['ingredients_id']]['ingredients_id'] = $value['ingredients_id'];
          $get_sales[$value['sales_product_id']]['incredients'][$value['ingredients_id']]['product_code'] = $value['product_code'];
          $get_sales[$value['sales_product_id']]['incredients'][$value['ingredients_id']]['product_name'] = $value['product_name'];
          $get_sales[$value['sales_product_id']]['incredients'][$value['ingredients_id']]['stock_qty'] = $value['stock_qty'];
          $get_sales[$value['sales_product_id']]['incredients'][$value['ingredients_id']]['incredient_qty'] = $value['incredient_qty'];
          $get_sales[$value['sales_product_id']]['incredients'][$value['ingredients_id']]['uom'] = $value['uom'];
          $get_sales[$value['sales_product_id']]['incredients'][$value['ingredients_id']]['available_qty'] = $value['available_qty'];
        }
      }
      //$get_sales = $get_sales_product;

      /*foreach($get_sales as $key=>$item){
        $get_sales[$key] = (array)$item;
       }*/
      return $get_sales;          
       
    }
	}

	public function get_list_id($id){
		
		//$this->db->select('sales_product_id, quantity');
		$this->db->where('status', 1);
		$this->db->where('store_code', $this->session->userdata('store_code'));
		$this->db->where('stall_code', $this->session->userdata('stall_code'));
		$this->db->where('sales_product_id', $id);
		$query = $this->db->get(STOCK_OF_SALES);

		if ($query->num_rows() > 0)
		{
		   echo json_encode($query->row());
		}
		//return $get_sales_product;
  }
  
  

}

?>