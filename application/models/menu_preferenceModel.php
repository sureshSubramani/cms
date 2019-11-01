<?php
class Menu_preferenceModel Extends CI_Model{

	public function Mainmenus($menus){

		if($menus['menu_id'] == 0){
			unset($menus['menu_id']);
			$this->db->insert(MENU_DETAILS,$menus); 
		}
		else{
			$this->db->where('menu_id',$menus['menu_id']);
			$this->db->update(MENU_DETAILS,$menus);
		}

		
	}

	public function Submenus($submenu){

		$this->db->insert_batch(MENU_DETAILS,$submenu);

	}

	
	public function existPreferenceCount($arg){
		$type = $arg['preference_type'];
		$role = $arg['preference_role'];

		$this->db->where('user_type',$type);
		$this->db->where('user_role',$role);

		$menus_pre = $this->db->get(MENU_PREFERENCE);
		
		return $menus_pre->num_rows();	
	}
	
	public function Get_Mainmenus(){

		$this->db->where('status',1);
		$this->db->where('menu_type',0);
		$this->db->order_by('tst_date,order_no');
		$get_all_menus = $this->db->get(MENU_DETAILS)->result_array();

		return $get_all_menus;
	}

	public function GetaAll_menus($menu){

		if($menu['menu_type'] == 1){

			$this->db->where('menu_id',$menu['menu_id']);
			$this->db->where('status',1);
			$menus = $this->db->get(MENU_DETAILS)->row_array();


		}
		else{
			$this->db->where('parent_id',$menu['menu_id']);
			$this->db->where('status',1);
			$menus = $this->db->get(MENU_DETAILS)->result_array();
		}


		return $menus;
	}
	
	public function Get_allRoles(){
		$me = $this->session->userdata('user_type'); // Don't fetch the this user
		//if($this->session->userdata('user_type')!=ROOT_ADMIN)
			$type = array(ROOT_ADMIN, $me);
		//else
		//	$type = "";
		
		$this->db->where_not_in('type', $type); // Don't fetch the root admin user
		//$this->db->where('status',1);
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('type', 'DESC');
		$get_roles = $this->db->get(USERS_TYPE)->result_array();

		return $get_roles;
	}

	public function get_all_menus(){

	 
		$this->db->where('menu_type',0);
		$this->db->where('status',1);
		$this->db->order_by('order_no','asc');
		$get_menus = $this->db->get(MENU_DETAILS)->result_array();

		$all_menus = array();
		
		
		foreach($get_menus as $main_menu){
			 
			$this->db->where('status',1);	 	 
			$this->db->where('menu_type',1);
			$this->db->where('parent_id',$main_menu['menu_id']);
			$this->db->order_by('order_no','asc');
			$get_sub_menus = $this->db->get(MENU_DETAILS)->result_array();
			
			$all_sub_menus = array();

			foreach($get_sub_menus as $sub_menus){
				$this->db->where('status',1);	 	 
				$this->db->where('menu_type',2);
				$this->db->where('parent_id',$sub_menus['menu_id']);
				$this->db->order_by('order_no','asc');
				$get_inner_sub_menus = $this->db->get(MENU_DETAILS)->result_array();
				//echo $this->db->last_query();
				$all_sub_menus[] = $sub_menus + array('inner_sub_menus'=>$get_inner_sub_menus);
				
			}
			
			$all_menus[] = $main_menu + array('sub_menus'=>$all_sub_menus);
			
		}
		//echo "<pre>";
		//print_r($all_menus); exit;
		
		return $all_menus;

	}
	
	public function insert_Details($up_array,$type, $role){
		//echo $id; exit;
		$up_array['user_type'] = $type;
		$up_array['user_role'] = $role;
		$this->db->insert(MENU_PREFERENCE,$up_array);
		//echo $this->db->last_query(); exit;
	}

	public function update_Details($up_array,$type, $role){
		//echo $id; exit;
		$this->db->where('user_type',$type);
		$this->db->where('user_role',$role);
		$this->db->update(MENU_PREFERENCE,$up_array);
		//echo $this->db->last_query(); exit;
	}

	public function get_role_menu($arg){
		$role = $arg['role'];
		$type = $arg['type'];

		$this->db->where('user_type',$type);
		$this->db->where('user_role',$role);

		$role_menus = $this->db->get(MENU_PREFERENCE)->row_array();
		
		$role_menus['menu_preference'] = json_decode($role_menus['menu_preference'],true);
		//print_r($role_menus['menu_preference']);

 
		print_r(json_encode($role_menus)); 
	}
}

?>