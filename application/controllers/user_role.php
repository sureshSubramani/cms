<?php
class User_role Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('User_roleModel');	 
		 
	}

	
	public function remove_role(){
		$data['user_type_id'] = isset($_REQUEST['id'])?$_REQUEST['id']:"";
		if($data['user_type_id']>1){
			$this->User_roleModel->remove_role($data); 
		}
		redirect(base_url()."user_role");
	}
	
	public function enable_role(){
		$data['user_type_id'] = isset($_REQUEST['id'])?$_REQUEST['id']:"";
		if($data['user_type_id']>1){
			$this->User_roleModel->enable_role($data); 
		}
		redirect(base_url()."user_role");
	}
	public function isExistRole(){
		if(isset($_POST['role']) && isset($_POST['type'])){
			echo $this->User_roleModel->isExistRole($_POST);			 
		}
	}
	public function index(){

		$data = '';

		$data['store_details'] = $this->common_details->GetStoreDetails();

	 	$data['get_Roles'] = $this->User_roleModel->Get_allRoles();
		$data['user_type'] = $this->common_details->GetAllUserType();
	 	

		if(isset($_POST['role']) && isset($_POST['type'])){

			$this->User_roleModel->add_user_role($_POST);

			redirect(base_url().'User_role');

			 
		}

		$this->HeaderModel->header();
		$this->load->view('User_role',$data);	
		$this->FooterModel->footer();
	}

}

?>