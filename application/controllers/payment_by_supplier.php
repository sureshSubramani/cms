<?php
class Payment_by_supplier Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Payment_by_supplierModel');			 
	}
	
	public function Payment_to_Supplier(){
		if(isset($_POST['payable_amount'])){			
			//print_r($_POST); exit;
			//unset($_POST['payable_amount']);

			echo $this->Payment_by_supplierModel->InsertPayment($_POST);

			//redirect(base_url().'payment_by_supplier');
		}
	}
	
	public function index(){
		$data = '';
		
		//$data['store'] = $this->Payment_by_supplierModel->GetStoreInfo();
		//$data['supplier'] = $this->Payment_by_supplierModel->GetSupplierInfo();
		//$data['invoice'] = $this->Payment_by_supplierModel->GetInvoice();

		$this->HeaderModel->header(); 	
		$this->load->view('payment_by_supplier', $data);
		$this->FooterModel->footer();
	}
	
	
	public function Get_Invoice(){
		$data = json_decode(file_get_contents('php://input'), true);
		
		$get_supplier_details = $this->Payment_by_supplierModel->GetInvoiceDetails($data);

		print_r(json_encode($get_supplier_details));
	}
	
	public function Get_Supplier(){

		$get_supplier_details = $this->Payment_by_supplierModel->GetSupplierDetails();

		print_r(json_encode($get_supplier_details));
	}

	public function supplier_payment_details(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_payment = $this->Payment_by_supplierModel->view_payment_details($data['store_code'], $data['supplier_id']);

    	print_r(json_encode($get_payment));
    }
	
}

?>