<?php
class Product_details Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Product_detailsModel');			 
	}
	function submit_products(){
		if(isset($_REQUEST['form_type']) && $_REQUEST['form_type']!=""){
			/*echo "<pre>";
			print_r($_REQUEST);
			echo "</pre>"; exit; */

			if(isset($_REQUEST['category_id']) && strtolower($_REQUEST['category_id']) == 'others'){
				if($_REQUEST['new_product_category']!=""){
					$_REQUEST['category_id'] = $this->Product_detailsModel->addNewCategory($_REQUEST['new_product_category']);
				}
				else{
					$_REQUEST['category_id'] = 0;
				}
				unset($_REQUEST['new_product_category']);
			}

			echo $res  = $this->Product_detailsModel->InsertProducts($_REQUEST); //exit;

			/*if($res){
				$this->session->set_userdata("alert", $res);
			}*/			

		}
	}
	public function index(){
		$data = '';

		$data['store_details'] = $this->common_details->GetStoreDetails();

		$data['get_product_category'] = $this->Product_detailsModel->GetProductCategory();
			
		$data['uom'] = $this->Product_detailsModel->GetUOM();	
 
		if(isset($_POST['form-type'])){	

		 		

			/*if($_POST['category_id'] == 'new'){
				$_POST['category_id'] = strtoupper($_POST['new_product_category']);
			}
			else{
				$_POST['category_id'] = strtoupper($_POST['product_name']);
			}*/
			 
			if(strtolower($_POST['category_id']) == 'others'){
				if($_POST['new_product_category']!=""){
					$_POST['category_id'] = $this->Product_detailsModel->addNewCategory($_POST['new_product_category']);
				}
				else{
					$_POST['category_id'] = 0;
				}
			}
			unset($_POST['new_product_category']);

			$res  = $this->Product_detailsModel->InsertProducts($_POST);
			if($res){
				$this->session->set_userdata("alert", $res);
			}

			redirect(base_url().'Product_details');
		}

		$this->HeaderModel->header(); 	
		$this->load->view('product_details', $data);
		$this->FooterModel->footer();
	}
	public function set_filter(){
		$res = 0;
		//print_r($_REQUEST); exit;
		if(isset($_REQUEST['action']) && $_REQUEST['action']=="set_filter"){
			if(isset($_REQUEST['category_id'])){
				$category_id = $_REQUEST['category_id'];
				//Create session for set filter
				$this->session->set_userdata("product_details_category_id", $category_id);
				$res = 1;
			}
		}
		echo $res;
	}
	public function clear_filter(){
		if(isset($_REQUEST['action']) && $_REQUEST['action']=="clear_filter"){
			if($this->session->userdata("product_details_category_id")){
				$this->session->unset_userdata("product_details_category_id");
				echo 1;
			}
		}
	}
	public function Get_Products(){

		$get_products = $this->Product_detailsModel->GetProductsDetails();

		print_r(json_encode($get_products));
	}
	
	public function product_details(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_pro = $this->Product_detailsModel->Edit_product_details($data['product_id']);

    	print_r(json_encode($get_pro));
    }

	public function generate_product_code(){

    	if(isset($_REQUEST['category_id']) && $_REQUEST['category_id']!=""){
    		$catId = $_REQUEST['category_id'];
    		$pcode = $this->Product_detailsModel->generate_product_code($catId);
    		print_r($pcode);
    	}

    }

	public function DisableProduct(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_stores = $this->Product_detailsModel->DisableProduct($data['product_id'], $data['status']);
    }
}

?>