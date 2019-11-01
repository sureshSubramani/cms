<?php
class Login Extends CI_Controller{
 
	function __construct(){
		parent:: __construct();		 
		$this->load->model('LoginModel');
	}


	public function index(){

		if($this->session->userdata('user_type')){
			redirect(base_url().'index');
		}

		$data = '';
		
		if(isset($_POST['usr_name'])){

			$data['usr_name'] = $_POST['usr_name'];
			$data['usr_password'] = $_POST['usr_password'];

			$usr_details = $this->LoginModel->GetUsrs($_POST);			 
			
			if(count($usr_details) > 0){
				$this->session->set_userdata('user_id',$usr_details[0]['user_id']);
				$this->session->set_userdata('user_name',$usr_details[0]['name']);
				$this->session->set_userdata('user_type',$usr_details[0]['user_type']);
				$this->session->set_userdata('user_role',$usr_details[0]['role']);
				$access_type = explode(",",$usr_details[0]['access_type']);
				$this->session->set_userdata('access_type',$access_type);
				
				if($usr_details[0]['user_type'] == STALL_OPERATOR || $usr_details[0]['user_type'] == STORE_MANAGER){
					redirect(base_url().'inter_login');
				}
				else {
					redirect(base_url().'index');
				}
			}
			else{
				$data['error'] = 'Username or Password is incorrect';
			}
		} 
		$this->load->view('login',$data);
	}
 
}


?>