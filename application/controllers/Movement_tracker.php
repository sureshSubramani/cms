<?php
class Movement_tracker Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Stall_detailsModel');	
		$this->load->model('Movement_trackerModel');	 
	}

	public function index(){
		
		$data = '';
		
 

		$data['get_stores_stall'] = $this->Stall_detailsModel->GetStalls();
		 
		$data['getStocks'] = $this->Movement_trackerModel->GetStockSales();

		if(isset($_POST['get_stalls'])){

			$this->Movement_trackerModel->Insert_MT($_POST);
		 
			 

			redirect(base_url().'movement_tracker');
		}

		$this->HeaderModel->header();	
		$this->load->view('movement_tracker', $data);	
		$this->FooterModel->footer();
	}

	public function GetProduct_details(){

		if($_POST){
			$this->Movement_trackerModel->GetProduct_details($_POST['val']);	
		} 
	}

	public function GetMovement_tracker(){

		$this->Movement_trackerModel->GetMovement_tracker();	
	}
	public function get_current_store(){	
		
		    $this->db->where('store_code', $this->session->userdata('store_code'));

			//$this->db->where('p.status', 1);	
			$this->db->from(STORES);
			$store = $this->db->get()->row_array();	 
			return $store;	
	}
	public function Get_Store_Stock(){

		//print_r($_POST); exit;
		$pcode = (isset($_POST['product_code']) && $_POST['product_code'])?$_POST['product_code']:"";
		$scode = (isset($_POST['store_code']) && $_POST['store_code'])?$_POST['store_code']:"";
		$get_UOM = array();
		if($scode && $pcode){
			$get_UOM = $this->Movement_trackerModel->GetStoreStock($scode, $pcode);
		}

		if($get_UOM)
			echo trim($get_UOM);
	}
}

?>