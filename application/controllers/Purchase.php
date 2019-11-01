<?php
class Purchase Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Store_detailsModel'); 
		$this->load->model('PurchaseModel');
		$this->load->model('Product_detailsModel');		  
	}

	public function index(){

		$data = '';

		$data['GetProducts'] = $this->PurchaseModel->GetProductsDetails(); 

		$data['GetSupplier'] = $this->PurchaseModel->GetSupplier();		
 
		$data['GetStore'] = $this->PurchaseModel->GetStore();

		$data['GetUOM'] = $this->PurchaseModel->GetUOM();

		$purchase_data = array();
		$invoice_data = array();
		$stock_data = array();
		$temp_total_amount = 0;
		
		if(isset($_POST['supplier_id'])){ 		

			for($i=0; $i<count($_POST['product_code']); $i++){

				if($_POST['quantity'][$i]>0){
					$purchase_data[] = array('invoice_number'=>$_POST['invoice_number'],'purchase_date'=>$_POST['purchase_date'],'store_code'=>$this->session->userdata()['store_code'],'supplier_id'=>$_POST['supplier_id'],'product_code'=>$_POST['product_code'][$i],'quantity'=>$_POST['quantity'][$i],'uom'=>$_POST['uom'][$i],'amount'=>$_POST['amount'][$i],'status'=>$_POST['status'],'created_by'=>$this->session->userdata()['user_id']);								
				}
			}	

			if(!empty($purchase_data)){

				$res = $this->PurchaseModel->Add_purchase($purchase_data);

				if($res == true){
	    		    $this->session->set_flashdata('error', "Insertion error please try again...");
				}else{				
					$this->session->set_flashdata('success', "Successfully products purchase added into store...");
				}	
				
			    for($i=0; $i<count($_POST['product_code']); $i++){

						$temp_total_amount = $temp_total_amount + $_POST['amount'][$i];                    
			    }
				
				for($i=0; $i<count($_POST['invoice_number']); $i++){

						$invoice_data[] = array('invoice_number'=>$_POST['invoice_number'],'invoice_date'=>$_POST['purchase_date'],'store_code'=>$this->session->userdata('store_code'),'supplier_id'=>$_POST['supplier_id'],'total_amount'=>$temp_total_amount,'status'=>$_POST['status'],'created_by'=>$this->session->userdata()['user_id']);
				}

				$this->PurchaseModel->Add_invoice($invoice_data);			
				
				for($i=0; $i<count($_POST['product_code']); $i++){

					$stock_data[] = array('store_code'=>$this->session->userdata('store_code'),'product_code'=>$_POST['product_code'][$i],'quantity'=>$_POST['quantity'][$i],'uom'=>$_POST['uom'][$i],'status'=>$_POST['status'],'created_by'=>$this->session->userdata()['user_id']);
					
				    	$this->db->where('store_code', $this->session->userdata('store_code'));
					$this->db->where('product_code', $_POST['product_code'][$i]);
					$q = $this->db->get(STOCK_OF_STORE); 
					//print_r($_POST['quantity'][$i]); die;				
					
					if ( $q->num_rows() > 0 ){		
							
						//getting existing-quantity with assign with new-stock quantity variable
						$this->db->select('quantity');
						$this->db->where('store_code', $this->session->userdata('store_code'));
						$this->db->where('product_code', $_POST['product_code'][$i]);
						$query = $this->db->get(STOCK_OF_STORE);
						$row = $query->row();
						$quantity_in_stock = $row->quantity;

						$new_quantity_in_stock = $quantity_in_stock + $_POST['quantity'][$i];

						//update stock table with new quanity-stock
						$this->db->where('store_code', $this->session->userdata('store_code'));
						$this->db->where('product_code', $_POST['product_code'][$i]);
						$this->db->update(STOCK_OF_STORE, array('quantity' => $new_quantity_in_stock ));
					} else {
						//$this->db->set('product_code', $_POST['product_code'][$i]);
						$this->db->insert(STOCK_OF_STORE, $stock_data[$i]);					
				    } 
				}			
			}
			else{
				$this->session->set_flashdata('error', "Unable update with ZERO quantity!");
			}
			redirect(base_url().'purchase');					
		}			

		$this->HeaderModel->header();
		$this->load->view('purchase', $data);
		$this->FooterModel->footer();		
	}

	public function GetPurchase(){

		$get_purchase = $this->PurchaseModel->get_purchase_details();
		print_r(json_encode($get_purchase));
	}	
	
	public function DisablePurchase(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_stores = $this->PurchaseModel->DisablePurchase($data['purchase_id'], $data['status']);
    }
    public function Get_Product_UOM(){

		//print_r($_POST); exit;
		$pcode = (isset($_POST['product_code']) && $_POST['product_code'])?$_POST['product_code']:"";
		
		$get_UOM = $this->PurchaseModel->GetProductsUOM($pcode);

		if($get_UOM)
			echo trim($get_UOM);
	}
}

?>