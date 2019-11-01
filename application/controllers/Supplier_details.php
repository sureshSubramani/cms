<?php
class Supplier_details Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Supplier_model');		 
	}

	public function index(){ 

		if(isset($_POST['supplier_name'])){  

			//$insert_array = array('supplier_gst'=>$_POST['supplier_gst'],'supplier_name'=>strtoupper($_POST['supplier_name']),'supplier_mobile'=>$_POST['supplier_mobile'],'supplier_address'=>$_POST['supplier_address'],'supplier_city'=>$_POST['supplier_city'],'status'=>$_POST['status']);			
			 
			if(isset($_POST['supplier_id'])){ 
				$this->Supplier_model->add_supplier($_POST);

				redirect(base_url().'supplier_details');
			}					 
		}

		$this->HeaderModel->header();
		$this->load->view('supplier_details');
		$this->FooterModel->footer();
	}

	public function SupplierDetails(){

       $this->Supplier_model->GetSupplier();
		//print_r(json_encode($get_supplier));
		
	}

	public function Supplier_details(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_supplier = $this->Supplier_model->Edit_Supplier($data['supplier_id']);

    	print_r(json_encode($get_supplier));
    }

	public function Disable_supplier(){

		$data = json_decode(file_get_contents('php://input'), true);

		$this->Supplier_model->Disable_supplier($data['supplier_id'], $data['status']);
	}

	public function ValidateSupplierNAme(){
		$data = json_decode(file_get_contents('php://input'),true);

		$this->Supplier_model->Validate_SupplierNAme($data['supplier_name']);
	}
}

?>