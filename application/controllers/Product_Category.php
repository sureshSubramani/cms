<?php
class Product_Category Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('ProductCategory_model');		 
	}

	function submit_category(){
		if(isset($_REQUEST['form_type']) && $_REQUEST['form_type']!=""){
			/*echo "<pre>";
			print_r($_REQUEST);
			echo "</pre>"; exit; */

			echo $res  = $this->ProductCategory_model->InsertCategory($_REQUEST); 
		}
	}

    public function index(){
		
		//$data['title'] = 'Product Category';
		
		//$data['store_details'] = $this->Store_detailsModel->GetStores(); //$data['store_details'] = $this->common_details->GetStoreDetails();

		if(isset($_POST['category_id'])){ 

			$this->ProductCategory_model->Get_ProductCategory($_POST);
		}

		//$this->load->view('common/header');
		$this->HeaderModel->header();
		$this->load->view('product_category');
		$this->FooterModel->footer();
	}
    
	public function Get_ProductCategory(){

		$get_pro_catogory = $this->ProductCategory_model->Get_ProductCategory();

		print_r(json_encode($get_pro_catogory));
	}
	public function Get_CategoryByID(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_pro = $this->ProductCategory_model->Edit_Category_details($data['category_id']);

    	print_r(json_encode($get_pro));
    }
    public function DisableCategory(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_stores = $this->ProductCategory_model->Disable_Category($data['category_id'], $data['status']);
    }
}

?>