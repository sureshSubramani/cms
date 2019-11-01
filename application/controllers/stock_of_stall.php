<?php
class Stock_of_stall Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Stock_of_stallModel');		 
	}
	public function GetStallStock(){	
		$get_stall = $this->Stock_of_stallModel->GetStallStock();
		print_r(json_encode($get_stall)); 
	}
    public function index(){
		
		//$data['title'] = 'Product Category';
		
		$data['stall'] = $this->Stock_of_stallModel->GetStall(); 
		$data['stock'] = $this->Stock_of_stallModel->GetStallStock();

		//$this->load->view('common/header');
		$this->HeaderModel->header();
		$this->load->view('stock_of_stall', $data);
		$this->FooterModel->footer();
	}
}
?>