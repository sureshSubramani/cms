<?php
class Change_Password Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel');
		$this->load->model('Change_PasswordModel', 'CP');		 
	}

	public function index(){
        $data = '';		
		/*echo "<pre>";
		print_r($data);
		echo "</pre>"; exit;*/
		$this->HeaderModel->header();
		$this->load->view('Change_Password', $data);
		$this->FooterModel->footer();
	}

    public function checkExitPassword($old_password){
		$old_password = $old_password;
		$data = $this->CP->checkOldPassword($old_password);	 
		echo json_encode($data);
	}

	public function changePassword(){
		$obj = json_decode(file_get_contents('php://input'));
		$_POST = json_decode(file_get_contents('php://input'),true);
		$this->form_validation->set_rules('old_password','Old Password','required|is_unique[users.name]');
		$this->form_validation->set_rules('new_password','New Password','required');
		$this->form_validation->set_rules('cpassword','Retype New Password','required');

		if ($this->form_validation->run() == FALSE){
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        }else{
           echo json_encode(['success'=>'Record added successfully.']);
        }
		
		/*if($this->form_validation->run() == FALSE){
		    
			$sessionData = $this->session->userdata('logged_store_stall');
			$this->data['id'] = $sessionData['id'];
			$this->data['user_name'] = $sessionData['user_name'];
			$this->data['user_type'] = $sessionData['user_type'];
	
			$this->HeaderModel->header();
			$this->load->view('Change_Password', $data);
			$this->FooterModel->footer();
			
		}else{
		    $query = $this->CP->checkOldPassword($this->input->post('old_password'));
		  if($query){
			$query = $this->CP->updateNewPassword($this->input->post('newpassword'));
			if($query){
			  redirect('change_password', refresh);
			}else{
			  redirect('change_password', refresh);
			}
		  }
	
		}*/
	}

}

?>