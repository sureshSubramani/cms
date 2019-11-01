<?php
class Wastage Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Store_detailsModel'); 
		$this->load->model('WastageModel');
		$this->load->model('Product_detailsModel');
	}

	public function index(){ 

		$data = '';
		
		$data['getStocks'] = $this->WastageModel->GetStockSales();

		$data['GetProducts'] = $this->WastageModel->GetProductsDetails(); 		
 
		$data['GetStore'] = $this->WastageModel->GetStore();

		$data['GetUOM'] = $this->WastageModel->GetUOM();

		$wastage_data = array();

		//print_r($this->session->userdata());

		if(isset($_POST['wastage_id'])){  

			for($i=0; $i<count($_POST['product_code']); $i++){

				$wastage_data[] = array('wastage_id'=>$_POST['wastage_id'],'store_code'=>$this->session->userdata()['store_code'],'stall_code'=>$this->session->userdata()['stall_code'],'product_code'=>$_POST['product_code'][$i],'quantity_of_waste'=>$_POST['quantity_of_waste'][$i],'uom'=>$_POST['uom'][$i],'approve_status'=>$_POST['approve_status'], 'status'=>$_POST['status'], 'created_by'=>$this->session->userdata()['user_id']);								
			}

			//$wastage_data  = array('wastage_id'=>$_POST['wastage_id'],'store_code'=>$this->session->userdata()['store_code'],'stall_code'=>$this->session->userdata()['stall_code'],'product_code'=>$_POST['product_code'],'quantity_of_waste'=>$_POST['quantity_of_waste'],'uom'=>$_POST['uom'],'approve_status'=>$_POST['approve_status'], 'status'=>$_POST['status'], 'created_by'=>$this->session->userdata()['user_id']);								
			$this->WastageModel->Add_wastage($wastage_data);			
			
			redirect(base_url().'wastage');
		}

		$this->HeaderModel->header();
		$this->load->view('wastage', $data);
		$this->FooterModel->footer();
	}

	public function viewWastageProducts($wastage_id){
		$wastage_id = $wastage_id;
		$get_wastage = $this->WastageModel->viewWastageProducts($wastage_id);
		print_r(json_encode($get_wastage));
	}

	public function GetWastageProducts(){

		$get_wastage = $this->WastageModel->GetWastageProducts();
		print_r(json_encode($get_wastage));
		
	}

	public function Get_wastage_by_id($wastage_id){		
		$this->db->from(WASTAGE);
		$this->db->where('wastage_id', $wastage_id);
        $query = $this->db->get();
		print_r(json_encode($query));		
	}
	
	public function Edit_wastage(){

    	$data = json_decode(file_get_contents('php://input'), true);

    	$get_wastage = $this->WastageModel->Edit_wastage_products($data['wastage_id']);

    	print_r(json_encode($get_wastage));
    }

	public function AcceptWastage(){
		
		$data = json_decode(file_get_contents('php://input'), TRUE);

		$this->WastageModel->Accept_Wastage_Product($data['wastage_id'], $data['stall_code'], $data['product_code'], $data['quantity_of_waste']);
		
	}

	public function RejectWastage(){		

		$data = json_decode(file_get_contents('php://input'), TRUE);

		$this->WastageModel->Reject_Wastage_Products($data['wastage_id']);
	}
	public function Get_Stall_Stock(){

		//print_r($_POST); exit;
		$pcode = (isset($_POST['product_code']) && $_POST['product_code'])?$_POST['product_code']:"";
		$scode = (isset($_POST['store_code']) && $_POST['store_code'])?$_POST['store_code']:"";
		$stlcode = (isset($_POST['stall_code']) && $_POST['stall_code'])?$_POST['stall_code']:"";
		$get_UOM = array();
		if($scode && $stlcode && $pcode){
			$get_UOM = $this->WastageModel->GetSallStock($scode, $stlcode, $pcode);
		}

		if($get_UOM)
			echo trim($get_UOM);
	}
}

?>