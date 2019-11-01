<?php
class Menu_details Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Menu_detailsModel');	 
		 
	}
	
	public function validate_menu(){
        $type = $this->input->post('type');
		$menu = $this->input->post('menu');
		//echo $type."-".$menu;
        if($type!="" && $menu!=""){
			$arg['menu_type'] = $type;
			$arg['menu_name'] = $menu;
           //Return matching record count
			echo $this->common_details->existRecordCount(MENU_DETAILS, $arg);
        }
	}
	
	public function GetParentMenus(){
		$parent = array();
		$parent_menu = $this->input->post('parent_menu');
		if($parent_menu!=""){
			$parent['option'] = $this->common_details->GetParentMenus();
		}
		$this->load->view('select_parent_menu', $parent);
	}
	
	public function index(){

		$data = '';

		$data['store_details'] = $this->common_details->GetStoreDetails();

	 	$data['get_Roles'] = $this->Menu_detailsModel->Get_allRoles();

	 	$data['get_all_menus'] = $this->Menu_detailsModel->get_all_menus();
		/*echo "<pre>";
		print_r($data['get_all_menus']); 
		echo "</pre>";*/
		if(isset($_POST) && !empty($_POST)){ 
			
			if(!isset($_POST['menu_type']) || $_POST['menu_type'] == ''){
				$_POST['menu_type'] = 0;
			}
			
			if($_POST['menu_type']==0){
				if(!isset($_POST['menu_icon']) || $_POST['menu_icon'] == ''){
					$_POST['menu_icon'] = 'fa fa-bars';
				}
			}
			else{
				$_POST['menu_icon'] = '';
			}
			
			/*echo "<pre>";
			print_r($_POST); 
			echo "</pre>"; exit;*/
			$this->Menu_detailsModel->Mainmenus($_POST);

			redirect(base_url().'menu_details');
		}

		

		$this->HeaderModel->header();
		$this->load->view('menu_details',$data);	
		$this->FooterModel->footer();
	}

	public function Get_Mainmenus(){

		$Get_menus = $this->Menu_detailsModel->Get_Mainmenus();

		print_r(json_encode($Get_menus));
	}

	public function GetMenus(){

		$data = json_decode(file_get_contents('php://input'),true);

		$menu_details = $this->Menu_detailsModel->GetaAll_menus($data); 

		print_r(json_encode($menu_details));
	}

	public function DeleteMenus(){

		$data = json_decode(file_get_contents('php://input'),true);

		$this->Menu_detailsModel->DeleteMenus($data); 
	}
	public function get_role_menu(){
	 	$data = json_decode(file_get_contents('php://input'),true);
		$this->Menu_detailsModel->get_role_menu($data['preference_id']);
		
	}
}

?>