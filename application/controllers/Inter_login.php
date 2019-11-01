<?php
class Inter_login Extends CI_Controller{
 
	function __construct(){
		parent:: __construct();		 
		$this->load->model('LoginModel');
	}
	public function set_session(){
		if(isset($_REQUEST['name']) && $_REQUEST['name'] && isset($_REQUEST['val']) && $_REQUEST['val']){
			$this->session->set_userdata($_REQUEST['name'],$_REQUEST['val']);
		}
	}
	public function set_locker(){
		//print_r($_REQUEST); exit;
		if(isset($_REQUEST['locker']) && $_REQUEST['locker']){
			$this->session->set_userdata('locker', $_REQUEST['locker']);
			header("Location: ".base_url().'locker');
		}
	}
	public function set_theme_park(){
		//print_r($_REQUEST); exit;
		if(isset($_REQUEST['theme_park']) && $_REQUEST['theme_park']){
			$this->session->set_userdata('theme_park', $_REQUEST['theme_park']);
			header("Location: ".base_url().'ticket_entry');
		}
	}
	public function index(){
		//Allow this page for Store user/ Stall user
		if(!$this->session->userdata('user_name') || ($this->session->userdata('user_type')!=STORE_MANAGER && $this->session->userdata('user_type')!=STALL_OPERATOR)){
			redirect(base_url().'login'); exit;
		} 
		
		
		//Create session for store code and stall code if selected store (and stall)
		if(isset($_POST['store_code']) && $_POST['store_code']){		
			
			$page = "index";
			$store_id = $stall_id = "";

			if(isset($_POST['store_code'])){

				$thisStore = $this->LoginModel->get_current_store($_POST['store_code']);

				//Create session for store code and name if selected a store
				if(isset($thisStore['store_code']) && $thisStore['store_code']){
					$store_code = $thisStore['store_code'];
					$store_name = $thisStore['store_name'];
					//Set store to this user
					$this->session->set_userdata('store_code',$store_code);
					$this->session->set_userdata('store_name',$store_name);
				}

				//Create session for stall code and name if selected a stall
				if(isset($_POST['stall_code'])){

					$thisStall = $this->LoginModel->get_current_stall($_POST['store_code'], $_POST['stall_code']);

					if(isset($thisStall['stall_code']) && $thisStall['stall_code']){
						$stall_code = $thisStall['stall_code'];
						$stall_name = $thisStall['stall_name'];
						//Set store to this user
						$this->session->set_userdata('stall_code',$stall_code);
						$this->session->set_userdata('stall_name',$stall_name);
						$page = "sales";
					}
				}			
			}

			if($this->session->userdata('store_code')){
				// Allow if session created for store code
				redirect(base_url().$page); exit; 
			}
			else {
				redirect(base_url().inter_login); exit;
			}
		} 
		
		$data['get_store_details'] = $this->LoginModel->get_store_details(); 		
		$this->load->view('inter_login',$data);
		 
	}

	public function getStalldetails(){
		if($_POST['store_code']){			
			$this->LoginModel->getStalldetails($_POST['store_code']);
		}
	}
 
}

?>