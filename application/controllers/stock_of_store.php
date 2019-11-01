<?php
class Stock_of_store Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Stock_of_storeModel');		 
	}
	public function GetStoresStock(){	
		$get_stock = $this->Stock_of_storeModel->GetStoresStock();
		print_r(json_encode($get_stock)); 
	}
    public function index(){
		
		//$data['title'] = 'Product Category';
		
		$data['stores'] = $this->Stock_of_storeModel->GetStores(); 
		$data['stock'] = $this->Stock_of_storeModel->GetStoresStock(); 
		
		//$this->load->view('common/header');
		$this->HeaderModel->header();
		$this->load->view('stock_of_store', $data);
		$this->FooterModel->footer();
	}    
}
?>