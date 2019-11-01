<?php
class Locker Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('LockerModel');
		 
	}

	public function index(){

		$data = '';

		$data['ticket_amnt'] = $this->LockerModel->getTicketAmnt();

		$data['bill_id'] = $this->LockerModel->generateBiiId();

		//$menus = $this->LockerModel->GetMenus();

			if(isset($_POST['date_field'])){

				$no_tokens = array();
				
				for($i=0; $i<count($_POST['checked_token']); $i++){

					if($_POST['checked_token'][$i] != ''){
						$no_tokens[] = $_POST['checked_token'][$i];
					} 
				}

				$json_data = json_encode($no_tokens);


					$insert_array = array('date_field'=>$_POST['date_field'],'bill_id'=>$_POST['bill_id'],'no_of_locker'=>$_POST['no_of_locker'],'rent'=>$_POST['rent'],'total_amnt'=>$_POST['total_amnt'],
						'payment_mode'=>$_POST['payment_mode'],'locker_no'=>$_POST['locker_no'],'rent_amnt'=>$_POST['rent_amnt'],'discount_amnt'=>$_POST['discount_amnt'],'payment_mode'=>$_POST['payment_mode'],
				'checked_token'=>$json_data);	


			 	$this->LockerModel->insertData($insert_array);

			 	redirect(base_url().'locker');
			}
		 
		$this->HeaderModel->header();
		$this->load->view('locker',$data);
		$this->FooterModel->footer();
	}

	public function GetCheckedLocker(){

		$this->LockerModel->GetCheckedLocker();
	}

	public function GetLocker(){

		if($_POST){
			$this->LockerModel->GetSelectedLocker($_POST['locker_id']);
		}
	}

	public function RemoveLocker(){

		if($_POST){
			$this->LockerModel->RemoveLocker($_POST['locker_id']);
		}
	}
}

?>