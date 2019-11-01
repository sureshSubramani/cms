<?php

class SalesModel Extends CI_Model{

  public function insert_sales($sales_data){      
          
    $this->db->insert_batch(SALES, $sales_data); 
                      
  }

  public function deduct_stall_stock($sales_data){      
          
    $sales_product = $this->db
      ->select('sales_product_id')
      ->from(SALES_PRODUCT)
      ->where('status', 1)
      ->get(); 

      foreach($sales_product->result() as $key => $sales_value) {        

        $inc_qty = $this->db
                ->select('product_code, quantity, uom', 'count('.$sales_value->sales_product_id.') as num_of_time')
                ->from(INGREDIENTS)
                ->where('status', 1)                
                ->where('sales_product_id', $sales_value->sales_product_id)
                ->get();
                foreach ($inc_qty->result() as $key => $inc_value) {
                  $stock_qty = $this->db
                          ->select_min('quantity')
                          ->select('product_code, uom')
                          ->from(STOCK_OF_STALL)
                          ->where('status', 1)
                          ->where('store_code', $this->session->userdata('store_code'))
                          ->where('stall_code', $this->session->userdata('stall_code'))
                          ->where('product_code', $inc_value->product_code)
                          ->get()->row();
                          
                          $conversion_quantity = 1000 * $inc_value->quantity;
                          $tot_stock_quantity = $stock_qty->quantity * 1000 / $conversion_quantity;
                          
                          //foreach ($stock_qty->result() as $key => $st_value) {                 
                            switch ($inc_value->uom) {
                              case 'KG':
                                    if($stock_qty->quantity > 0){ 
                                      //print_r('Sales Id: '.$sales_value->sales_product_id.'<br/>');                       
                                      //print_r('Quantity: '.$tot_stock_quantity.' '.$stock_qty->uom.'<br/>');
                                      $this->db
                                      ->where('status', 1)
                                      ->where('store_code', $this->session->userdata('store_code'))
                                      ->where('stall_code', $this->session->userdata('stall_code'))
                                      ->where('sales_product_id', $sales_value->sales_product_id)
                                      ->update(STOCK_OF_SALES, array('quantity'=> $tot_stock_quantity));      
                                    }                  
                                break;
                              case 'L':
                                  if($stock_qty->quantity > 0){                        
                                  // print_r('Quantity: '.$tot_stock_quantity.' '.$stock_qty->uom.'<br/>');
                                    $this->db
                                    ->where('status', 1)
                                    ->where('store_code', $this->session->userdata('store_code'))
                                    ->where('stall_code', $this->session->userdata('stall_code'))
                                    ->where('sales_product_id', $sales_value->sales_product_id)
                                    ->update(STOCK_OF_SALES, array('quantity'=> $tot_stock_quantity));      
                                  }
                                break;
                              case 'NOs':
                                  if($stock_qty->quantity > 0){                        
                                  // print_r('Quantity: '.$tot_stock_quantity.' '.$stock_qty->uom.'<br/>');
                                    $this->db
                                    ->where('status', 1)
                                    ->where('store_code', $this->session->userdata('store_code'))
                                    ->where('stall_code', $this->session->userdata('stall_code'))
                                    ->where('sales_product_id', $sales_value->sales_product_id)
                                    ->update(STOCK_OF_SALES, array('quantity'=> $tot_stock_quantity));      
                                  }
                                break;
                              default:
                                # code...
                                break;
                            }
                        // }   
                  
                }                                          
      }
                      
  }

  public function deduct_sales_stock($id, $quantity){   

        $this->db->where('status', 1)      
            ->where('store_code', $this->session->userdata('store_code'))
            ->where('stall_code', $this->session->userdata('stall_code'))
            ->where('sales_product_id', $id)
            ->select('quantity');
            $query = $this->db->get(STOCK_OF_SALES)->row();	//$row = $query->row();           
            $quantity_in_stock = $query->quantity;

            $new_quantity_in_stock = $quantity_in_stock - $quantity;

            $this->db->where('status', 1)      
            ->where('store_code', $this->session->userdata('store_code'))
            ->where('stall_code', $this->session->userdata('stall_code'))
            ->where('sales_product_id', $id)
            ->select('quantity')
            ->update(STOCK_OF_SALES, array('quantity' => $new_quantity_in_stock, 'modified_by' => $this->session->userdata('user_id') ));                        
  }

  public function getSalesProducts(){
    
        if($this->session->userdata('store_code')){

          $this->db->where('a.store_code', $this->session->userdata('store_code'));
          if($this->session->userdata('stall_code')){
            $this->db->where('a.stall_code', $this->session->userdata('stall_code'));     
          }

         /*$get_sales = $this->db
                      ->select('sp.*, ss.sales_product_id, ss.quantity')
                      ->from(SALES_PRODUCT.' as sp')
                      ->where('sp.status', 1)
                      ->join(STOCK_OF_SALES.' as ss', 'sp.sales_product_id = ss.sales_product_id', 'LEFT')
                      ->order_by('sp.status DESC')
                      ->get()->result_array();

          return $get_sales; */  
          
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
          
          $get_sales= array();
          
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
          return $get_sales;          
           
        }
              
    }

    public function plusQty($product_data){
      $product_data  = $product_data;
          
      $sales_product_id = $product_data->sales_product_id;
      $sales_product_name = $product_data->sales_product_name;
      $price = $product_data->price;
      
        if(isset($_SESSION["sales_cart"])){
  
          $is_available = 0;
  
            foreach($_SESSION["sales_cart"] as $keys => $values){
                if($_SESSION["sales_cart"][$keys]['sales_product_id'] == $sales_product_id)
                {
                  $is_available++;
                    $_SESSION["sales_cart"][$keys]['quantity'] = $_SESSION["sales_cart"][$keys]['quantity'] + 1;
                }
            }
            
    }            
}
  public function minusQty($product_data){
        $product_data  = $product_data;
            
        $sales_product_id = $product_data->sales_product_id;
        $sales_product_name = $product_data->sales_product_name;
        $price = $product_data->price;
        
          if(isset($_SESSION["sales_cart"])){
    
            $is_available = 0;
    
              foreach($_SESSION["sales_cart"] as $keys => $values){
                  if($_SESSION["sales_cart"][$keys]['sales_product_id'] == $sales_product_id)
                  {
                    $is_available++;

                    if($_SESSION["sales_cart"][$keys]['quantity'] == 1){
                      //unset($_SESSION["sales_cart"][$keys]);
                      $_SESSION["sales_cart"][$keys]['quantity'] = $_SESSION["sales_cart"][$keys]['quantity'];
                    }else
                      $_SESSION["sales_cart"][$keys]['quantity'] = $_SESSION["sales_cart"][$keys]['quantity'] - 1;
                  }
              }
              
          }            
  }

  public function add_item($product_data){

      $product_data  = $product_data;
      
      $sales_product_id = $product_data->sales_product_id;
      $sales_product_name = $product_data->sales_product_name;
      $price = $product_data->price;

        if(isset($_SESSION["sales_cart"])){

          $is_available = 0;

            foreach($_SESSION["sales_cart"] as $keys => $values){
                if($_SESSION["sales_cart"][$keys]['sales_product_id'] == $sales_product_id)
                {
                  $is_available++;
                  $_SESSION["sales_cart"][$keys]['quantity'] = $_SESSION["sales_cart"][$keys]['quantity'] + 1;
                }
            }
                if($is_available == 0){
                  $item_array = array(
                  'sales_product_id'=>$sales_product_id,  
                  'sales_product_name'=>$sales_product_name,  
                  'price'=>$price,  
                  'quantity'=>1
                  );
                  
                  $_SESSION["sales_cart"][] = $item_array;
                }
        }
        else
        {
                $item_array = array(
                  'sales_product_id'=>$sales_product_id,  
                  'sales_product_name'=>$sales_product_name,  
                  'price'=>$price,  
                  'quantity'=>1
                  );

                $_SESSION["sales_cart"][] = $item_array;              
        }
        
    }

  public function remove_item($product_data){
      
      $sales_product_id = $product_data;

          foreach($_SESSION["sales_cart"] as $keys => $values){
            if($values["sales_product_id"] == $sales_product_id){			 
              unset($_SESSION["sales_cart"][$keys]);				
            }
          }
          Sort($_SESSION["sales_cart"]);
  }

}

?>