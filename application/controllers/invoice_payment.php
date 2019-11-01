<?php
class Invoice_payment Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Invoice_paymentModel');			 
	}
	
	public function Payment_to_Invoice(){
		if(isset($_POST['payable_amount'])){			
			//print_r($_POST); exit;
			//unset($_POST['payable_amount']);

			echo $this->Invoice_paymentModel->InsertPayment($_POST);

			//redirect(base_url().'invoice_payment');
		}
	}
	
	public function index(){
		$data = '';
		
		//$data['store'] = $this->Invoice_paymentModel->GetStoreInfo();
		//$data['supplier'] = $this->Invoice_paymentModel->GetSupplierInfo();
		//$data['invoice'] = $this->Invoice_paymentModel->GetInvoice();
 
		/*if(isset($_POST['payable_amount'])){			
			//print_r($_POST);
			//unset($_POST['payable_amount']);

			$this->Invoice_paymentModel->InsertPayment($_POST);

			redirect(base_url().'invoice_payment');
		}*/

		$this->HeaderModel->header(); 	
		$this->load->view('invoice_payment', $data);
		$this->FooterModel->footer();
	}

	public function Get_Invoice(){

		$get_invoice = $this->Invoice_paymentModel->GetInvoiceDetails();

		print_r(json_encode($get_invoice));
	}

	public function payment_details(){

    	$data = json_decode(file_get_contents('php://input'), true);
    	//print_r(json_encode($data)); exit;
    	$get_payment = $this->Invoice_paymentModel->view_payment_details($data['store_code'], $data['supplier_id'], $data['invoice_number']);

    	print_r(json_encode($get_payment));
    }
	
}

?>