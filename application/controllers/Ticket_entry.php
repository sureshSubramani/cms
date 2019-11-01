<?php
class Ticket_entry Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Ticket_entryModel');
		 
	}

	public function index(){

		$data = '';

		$data['ticket_amnt'] = $this->Ticket_entryModel->getTicketAmnt();

		$data['bill_id'] = $this->Ticket_entryModel->generateBiiId();

			if(isset($_POST['date_field'])){
				//print_r($_POST);

					$insert_array = array('bill_id'=>$_POST['bill_id'],'print_date'=>$_POST['date_field'],'ticket_type'=>$_POST['ticket_type'],'adult'=>$_POST['adult'],'child'=>$_POST['child'],
						'adult_amnt'=>$_POST['adult_amnt_change'],'child_amnt'=>$_POST['child_amnt_change'],'offer_amnt'=>$_POST['offer_amnt'],'total_amnt'=>$_POST['total_amnt'],'payment_mode'=>$_POST['payment_mode'],
				'offeer_position'=>$_POST['usr_posistion'],'remanded_by'=>$_POST['usr_recommended'],'offer_usr_name'=>$_POST['usr_name']);	
				
			 	$this->Ticket_entryModel->insertData($insert_array);

			 	redirect(base_url().'ticket_entry');
			}
		 
		$this->HeaderModel->header();
		$this->load->view('ticket_entry',$data);
		$this->FooterModel->footer();
	}
}

?>