<?php
class Index Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel');
		$this->load->model('IndexModel');		 
	}


	public function index(){
		$data = '';
		if($this->session->userdata('store_code'))
			$data['wastage'] = $this->IndexModel->get_pending_wastage_approval();
		
		/*echo "<pre>";
		print_r($data);
		echo "</pre>"; exit;*/
		$data['total_sales_products'] = $this->IndexModel->get_total_sales_products();
		$this->HeaderModel->header();
		$this->load->view('index', $data);
		$this->FooterModel->footer();
	}
}

?>