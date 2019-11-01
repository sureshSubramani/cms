<?php
class Sales Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Store_detailsModel'); 
		$this->load->model('SalesModel');
		$this->load->model('Sales_productsModel');
		$this->load->model('Product_detailsModel');		  
	}

	public function index(){

		$data = '';

        $this->HeaderModel->header();
		$this->load->view('sales', $data);
		$this->FooterModel->footer();
	}
	
	public function LoadSalesProducts(){
		$data = $this->SalesModel->GetSalesProducts();			
		echo json_encode($data);
	}

	public function setStockQty(){
		//$product_data = json_decode(file_get_contents("php://input"));
        $this->SalesModel->stock_quantity($product_data);	
	}

	public function fetchProducts(){

		if(isset($_SESSION["sales_cart"]))
		{
		 echo json_encode($_SESSION["sales_cart"]); 
		}
	}

	public function addItem(){

		$product_data = json_decode(file_get_contents("php://input"));
        $this->SalesModel->add_item($product_data);		
	}

	public function removeItem(){
		$product_data = json_decode(file_get_contents("php://input"));
		//print_r($product_data); exit;
		$this->SalesModel->remove_item($product_data);
		
	}

	public function clearItem(){
		$product_data = json_decode(file_get_contents("php://input"));
		foreach($_SESSION["sales_cart"] as $keys => $values){			
			 unset($_SESSION["sales_cart"][$keys]);			
		}
	}

	public function clearAfterPrint(){
		$product_data = json_decode(file_get_contents("php://input"));
		foreach($_SESSION["sales_cart"] as $keys => $values){			
			unset($_SESSION["sales_cart"][$keys]);			
		}	
	}

	public function plusQty(){

		$product_data = json_decode(file_get_contents("php://input"));

		$this->SalesModel->plusQty($product_data);

	}

	public function minusQty(){

		$product_data = json_decode(file_get_contents("php://input"));

		$this->SalesModel->minusQty($product_data);

	}

	public function printData(){
		$product_data = json_decode(file_get_contents("php://input"));
		
		$sales_product_id = $product_data->sales_product_id;  
        $sales_data = array();

              $order_date = date("d/m/Y");
              $order_number ='#'.date("YmdHis");

              foreach($_SESSION["sales_cart"] as $keys => $values){
                
                    if($_SESSION["sales_cart"][$keys]['quantity'] > 0){

                      $is_available = TRUE;

                      $sales_data[] = array(
                        'order_number'=>$order_number,
                        'order_date'=> $order_date,
                        'sales_product_id'=>$_SESSION["sales_cart"][$keys]['sales_product_id'],
                        'unit_price'=>$_SESSION["sales_cart"][$keys]['price'],
                        'quantity'=>$_SESSION["sales_cart"][$keys]['quantity'],
                        'amount'=>$_SESSION["sales_cart"][$keys]['price'] * $_SESSION["sales_cart"][$keys]['quantity'],                    
                        'status'=>1, 
                        'created_by'=>$this->session->userdata()['user_id']);								
                    }                
              }

              if($is_available){
				$res = $this->SalesModel->insert_sales($sales_data); 
				
				if($res == true){
					$this->session->set_flashdata('error', "Insertion error please try again...");
				}else{				
					$this->session->set_flashdata('success', "Successfully sold order..");
				}	
			  }

            foreach($_SESSION["sales_cart"] as $keys => $values){
                
				if($_SESSION["sales_cart"][$keys]['quantity'] > 0){

					$id = $_SESSION["sales_cart"][$keys]['sales_product_id'];
					$quantity = $_SESSION["sales_cart"][$keys]['quantity'];				
				}  
				$this->SalesModel->deduct_sales_stock($id, $quantity);
			}

			//$this->SalesModel->deduct_sales_stock($id, $quantity);		  
 
		redirect(base_url().'sales', 'refresh'); 
		
	}

	

}

?>