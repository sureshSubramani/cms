<?php
class Stall_details Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Stall_detailsModel');	
		$this->load->model('Store_detailsModel');	 
	}

	public function index(){
		
		$data = '';
		
 		$data['store_details'] = $this->Store_detailsModel->GetStores(); //$data['store_details'] = $this->common_details->GetStoreDetails();

		if(isset($_POST['stall_name'])){ 

		 

			$this->Stall_detailsModel->StallDatas($_POST);
			redirect(base_url().'stall_details');
		}

		$this->HeaderModel->header();
		$this->load->view('stall_details', $data);
		$this->FooterModel->footer();
	}

	/*public function Get_Stalls(){
		$get_stall = $this->common_details->GetAllStallDetails();
		print_r(json_encode($get_stall));
	}*/
	

	public function StallCodeValidation()
	{
		$request= json_decode(file_get_contents('php://input'),true);

		$this->Stall_detailsModel->Validate($request['stall_code']);

		/*$data=$this->Stall_detailsModel->StallDatas($request);
		
		if($data)
		{
			echo "success";
		}else{
			echo "failure";
		}*/
		
	}

	public function GetStallCode(){
		$data = json_decode(file_get_contents('php://input'),true);

		$this->Stall_detailsModel->GetStallCode($data['store_code']);

	 
	}

	public function Get_Stalls(){

		$get_stores = $this->Stall_detailsModel->GetStalls();

		print_r(json_encode($get_stores));
	}

	public function Stall_details(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_stalls = $this->Stall_detailsModel->Edit_stall($data['stall_id']);

    	print_r(json_encode($get_stalls));
    }

    public function DeleteStall(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_stores = $this->Stall_detailsModel->DeleteStall($data['stall_id'], $data['status']);
    }
}

?>