<?php
class Store_details Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Store_detailsModel');		 
	}

	public function index(){

		$data = '';

		if(isset($_POST['store_name'])){

			/*if($_POST['store_id'] == 0){

				$insert_usr = array('user_name'=>$_POST['store_email'],'password'=>md5($_POST['confirm_pass']),'user_type'=>'stores');					
			}
			else{
				$insert_usr = array();
			}

			unset($_POST['confirm_pass']);
			unset($_POST['new_pass']); 

			//print_r($_POST);*/

			$this->Store_detailsModel->StoreDatas($_POST);

			redirect(base_url().'store_details');
		}

		$data['getStoreCode'] = $this->Store_detailsModel->getStoreCode();

		$this->HeaderModel->header();
		$this->load->view('store_details', $data);
		$this->FooterModel->footer();
	}

	public function Get_Stores(){

		$get_stores = $this->Store_detailsModel->GetStores();

		print_r(json_encode($get_stores));
	}

	 public function store_details(){

    	$data = json_decode(file_get_contents('php://input'), true);        
    	$get_stores = $this->Store_detailsModel->Edit_store($data['store_id']);

    	print_r(json_encode($get_stores));
    }

    public function DeleteStores(){

    	$data = json_decode(file_get_contents('php://input'),true);

    	$get_stores = $this->Store_detailsModel->DeleteStores($data['store_id'], $data['status']);
    }
}

?>