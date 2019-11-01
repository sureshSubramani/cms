<?php
class Stall_products Extends  CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Stall_detailsModel');	
		$this->load->model('Stall_productsModel');	 
	}

	public function index(){
		
		$data = '';
		
 

		$data['get_stores_stall'] = $this->Stall_detailsModel->GetStalls();
		$data['sales_products'] = $this->Stall_productsModel->Getsales_products();

		if(isset($_POST['get_stalls'])){

			$this->Stall_productsModel->InsertSalesproducts($_POST);

			redirect(base_url().'stall_products');

		}

		$this->HeaderModel->header();	
		$this->load->view('stall_products', $data);	
		$this->FooterModel->footer();
	}
	
	public function GetStockSales(){

		$data = json_decode(file_get_contents('php://input'));

		$this->Stall_productsModel->GetStockSales($data->get_stalls);
	}
}


?>