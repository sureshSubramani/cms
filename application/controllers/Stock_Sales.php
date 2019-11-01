<?php

class Stock_Sales Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Store_detailsModel'); 
		$this->load->model('StockSalesModel');
		$this->load->model('SalesModel');
		$this->load->model('Sales_productsModel');
		$this->load->model('Product_detailsModel');		
	}

	public function index(){

		$data = '';

        $this->HeaderModel->header();
		$this->load->view('stock_sales', $data);
		$this->FooterModel->footer();
	}

	public function GetSalesStock(){
		$data = $this->StockSalesModel->GetSalesStock();	 
		echo json_encode($data);
	}

	public function GetSalesProduct($id){

		//$this->db->select('sales_product_id');
		$this->db->where('status', 1);
		$this->db->where('store_code', $this->session->userdata('store_code'));
		$this->db->where('stall_code', $this->session->userdata('stall_code'));
		$this->db->where('sales_product_id', $id);
		$query = $this->db->get(STOCK_OF_SALES);

		if ($query->num_rows() > 0)
		{
		   echo json_encode($query->row_array());
		}
	}
}

?>