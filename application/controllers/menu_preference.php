<?php
class Menu_preference Extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('common/HeaderModel');
		$this->load->model('common/FooterModel'); 
		$this->load->model('Menu_preferenceModel');	 
		 
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

	 	$data['get_Roles'] = $this->Menu_preferenceModel->Get_allRoles();

		 //$data['get_all_menus'] = $this->Menu_preferenceModel->get_all_menus();
		 $data['get_all_menus'] = $this->common_details->GetMenus();
		/*echo "<pre>";
		print_r($this->session->userdata()); 
		echo "</pre>";*/
		
		if(isset($_POST['order_no'])){ 


			if(isset($_POST['menu_id']) && $_POST['menu_id'] == ''){
				$_POST['menu_id'] = 0;
			} 
			else{
				$_POST['menu_id'] = $_POST['menu_id'];
			}

			if(isset($_POST['menu_icon']) && $_POST['menu_icon'] == ''){
				$_POST['menu_icon'] = 'fa fa-bars';
			}
			else{
				$_POST['menu_icon'] = $_POST['menu_icon'];
			}

			$_POST = $_POST + array('menu_type'=>0);
 
			$this->Menu_preferenceModel->Mainmenus($_POST);

			redirect(base_url().'Menu_preference');
		}

		if(isset($_POST['main_menu_id'])){

			$insert_array = array();

			for($i=0; $i<count($_POST['sub_order_no']); $i++){

				if(isset($_POST['sub_menu_icon'][$i]) && $_POST['sub_menu_icon'][$i] == ''){
					$_POST['sub_menu_icon'][$i] = 'fa fa-bars';
				}
				else{
					$_POST['sub_menu_icon'] = $_POST['sub_menu_icon'][$i];
				}

				$insert_array[] = array('order_no'=>$_POST['sub_order_no'][$i],'menu_type'=>1,'menu_icon'=>$_POST['sub_menu_icon'][$i],'menu_url'=>$_POST['sub_menu_url'][$i],'menu_name'=>$_POST['sub_menu_name'][$i],'parent_id'=>$_POST['main_menu_id']);
 
			}
		 
			$this->Menu_preferenceModel->Submenus($insert_array);

			redirect(base_url().'Menu_preference');
 
		}

		if(isset($_POST['preference_type']) && isset($_POST['preference_role'])){ 
			/*echo "<pre>";
			print_r($_POST);
			echo json_encode($_POST['menus']);
			echo "</pre>"; //exit;*/
			$menus = $_POST['menus'];
			
			$insert_menus = "";
			
			if(!empty($menus)){
				$i=0;
				//echo '<ul style="list-style:none;">';
				foreach($menus as $main_menu_id=>$main_menu_val){
					
					if(is_array($main_menu_val)){
						//echo "<li>".$main_menu_id." have an Array</li>";
						//echo '<ul style="list-style:none;">';
						$j=0;
						foreach($main_menu_val as $sub_menu_id=>$sub_menu_val){
							if(is_array($sub_menu_val)){
								//echo "<li>".$sub_menu_id." have an Array</li>";
								//echo '<ul style="list-style:none;">';
								foreach($sub_menu_val as $inner_sub_menu_id=>$inner_sub_menu_val){
									if($inner_sub_menu_val){
										$insert_menus[$main_menu_id][$sub_menu_id][$inner_sub_menu_id] = $inner_sub_menu_val;
									}
									//echo "<li>".$inner_sub_menu_id." have a value '".$inner_sub_menu_val."'</li>";
								}
								//echo '</ul>';
							}
							else{
								if($sub_menu_val){
									$insert_menus[$main_menu_id][$sub_menu_id] = $sub_menu_val;
								}
								//echo "<li>".$sub_menu_id." have a value '".$sub_menu_val."'</li>";
							}
							$j++;
						}
						//echo '</ul>';
					}
					else{
						if($main_menu_val){
							$insert_menus[$main_menu_id] = $main_menu_val;
						}
						//echo "<li>".$main_menu_id." have a value '".$main_menu_val."'</li>";
					}
					
					$i++;
				}
				//echo '</ul>';
			}
			/*echo "<pre>";
			//print_r($insert_menus);
			//echo json_encode($insert_menus);				
			print_r($_POST);
			echo "</pre>"; 
			exit; */
			
			$existCount = $this->Menu_preferenceModel->existPreferenceCount($_POST); 

			$up_array = array('menu_preference'=>json_encode($insert_menus));

			if($existCount>0){
				$this->Menu_preferenceModel->update_Details($up_array,$_POST['preference_type'],$_POST['preference_role']);
			}
			else{
				$this->Menu_preferenceModel->insert_Details($up_array,$_POST['preference_type'],$_POST['preference_role']);
			}

			redirect(base_url().'Menu_preference'); 
		}

		$this->HeaderModel->header();
		$this->load->view('Menu_preference',$data);	
		$this->FooterModel->footer();
	}

	public function Get_Mainmenus(){

		$Get_menus = $this->Menu_preferenceModel->Get_Mainmenus();

		print_r(json_encode($Get_menus));
	}

	public function GetMenus(){

		$data = json_decode(file_get_contents('php://input'),true);

		$Menu_preference = $this->Menu_preferenceModel->GetaAll_menus($data); 

		print_r(json_encode($Menu_preference));
	}

	public function DeleteMenus(){

		$data = json_decode(file_get_contents('php://input'),true);

		$this->Menu_preferenceModel->DeleteMenus($data); 
	}
	public function get_role_menu(){

		$data = json_decode(file_get_contents('php://input'),true);
		
		$this->Menu_preferenceModel->get_role_menu($data);		
	}
}

?>