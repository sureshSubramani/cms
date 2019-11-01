<?php
class Sales_products Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('PurchaseModel');
		$this->load->model('Sales_productsModel');
		 
	}

	public function index(){

		$data = '';


		$data['GetProducts'] = $this->PurchaseModel->GetProductsDetails(); 
		$data['GetUOM'] = $this->PurchaseModel->GetUOM();
		//$data['no_of_stalls'] = $this->Sales_productsModel->GetallStalls();

		if(isset($_POST['sales_product_name'])){  

			if(isset($_FILES['product_image']) && $_FILES['product_image']['name'] != ''){
				$_FILES = $_FILES;
			}
			else{
				$_FILES = '';
			}
			
			$this->Sales_productsModel->insertSalseProduct($_POST,$_FILES);
			redirect(base_url().'sales_products');
		}

		$this->HeaderModel->header();
		$this->load->view('sales_products',$data);	
		$this->FooterModel->footer();
	}

	public function GetSalesProducts(){

		$this->Sales_productsModel->GetSalesProducts();
	}

	public function ViewProducts(){	

		$data = json_decode(file_get_contents('php://input'),true);
		$this->Sales_productsModel->ViewProducts($data['sales_product_id']);
	}
	public function Get_Product_UOM(){

		//print_r($_POST); exit;
		$pcode = (isset($_POST['product_code']) && $_POST['product_code'])?$_POST['product_code']:"";
		
		$get_UOM = $this->Sales_productsModel->GetProductsUOM($pcode);

		if($get_UOM)
			echo trim($get_UOM);
	}
}
?>