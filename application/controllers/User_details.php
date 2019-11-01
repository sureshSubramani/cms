<?php
class User_details Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('User_detailsModel');	 
		$this->load->model('Menu_detailsModel');
		$this->load->library('session');
	}
	public function submit_user(){
		if(isset($_REQUEST['form_type']) && $_REQUEST['form_type']!=""){
			/*echo "<pre>";
			print_r($_REQUEST);
			echo "</pre>"; exit; */
			echo $res  = $this->User_detailsModel->InsertUsrs($_REQUEST); //exit;		
		}
	}
	public function index(){

		$data = '';

		$data['store_details'] = $this->common_details->GetStoreDetails();
	 	$data['user_type'] = $this->common_details->GetAllUserType();

		

		$this->HeaderModel->header();
		$this->load->view('user_details',$data);
		$this->FooterModel->footer();
	}

	public function getRole(){
		$get_type = array();
		$type = $this->input->post('type');
        if($type){
			$get_type = $this->User_detailsModel->Get_userRole($type);
		}
		if(!empty($get_type)){
			foreach($get_type as $key=>$val){
				echo '<option value="'.$val['role'].'">'.ucfirst($val['role']).'</option>';
			}
		}
		else{
			echo '<option value="">-- No role found --</option>';
		}
	}
	public function validate_username(){
        $uname = $this->input->post('uname');
        if(!empty($uname)){
			$arg['user_name'] = $uname;
           //Return matching record count
			echo $this->common_details->existRecordCount(USERS, $arg);
        }
    }

	public function Get_users(){

		$Get_users = $this->User_detailsModel->Get_users();;

		print_r(json_encode($Get_users));
	}

	/* public function User_details(){

    	$data = json_decode(file_get_contents('php://input'),true);

    	$get_pro = $this->User_detailsModel->Edit_User_details($data['product_id']);

    	print_r(json_encode($get_pro));
    }*/

    public function DeleteUsr(){		

    	$data = json_decode(file_get_contents('php://input'),true);

    	$get_stores = $this->User_detailsModel->DeleteUsr($data['usr_id']);
	}
	
	public function enableUsr(){
		$data = json_decode(file_get_contents('php://input'),true);
    	$get_stores = $this->User_detailsModel->enableUsr($data['usr_id']);
	}
}

?>