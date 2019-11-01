<?php
class Menu_detailsModel Extends CI_Model{

	public function Mainmenus($menus){

		if($menus['action'] == 'add' && !isset($menus['menu_id'])){
			unset($menus['action']);
			if($this->session->userdata('user_id'))
				$menus['created_by'] = $this->session->userdata('user_id');
			$this->db->insert(MENU_DETAILS,$menus); 
		}
		else if($menus['action'] == 'edit' && isset($menus['menu_id']) && $menus['menu_id']>0){
			unset($menus['action']);
			if($this->session->userdata('user_id'))
				$menus['modified_by'] = $this->session->userdata('user_id');
			$this->db->where('menu_id', $menus['menu_id']);
			
			//Update Menu Details
			$res = $this->db->update(MENU_DETAILS,$menus);
			
			//Update Menu Type
			if($res){
				$mtype['menu_type']= $menus['menu_type']+1;
				$this->db->where('parent_id', $menus['menu_id']);
				$this->db->update(MENU_DETAILS,$mtype);
			}
		}

		
	}

	public function Submenus($submenu){

		$this->db->insert_batch(MENU_DETAILS,$submenu);

	}

	public function usr_pre($role){

		$this->db->insert(MENU_PREFERENCE,$role);
	}

	public function Get_Mainmenus(){

		//$this->db->where('status',1);
		$this->db->where('menu_type',0);
		$this->db->order_by('order_no');
		$get_all_menus = $this->db->get(MENU_DETAILS)->result_array();

		$all_menus = array();
		
		foreach($get_all_menus as $main_menu){
			
			$this->db->where('parent_id', $main_menu['menu_id']);
			$this->db->where('menu_type',1);
			$this->db->order_by('order_no');
			$get_all_Sub_menus = $this->db->get(MENU_DETAILS)->result_array();

			$all_menus[] = $main_menu;
			
            foreach($get_all_Sub_menus as $sub_menu){
				$this->db->where('parent_id', $sub_menu['menu_id']);
				$this->db->where('menu_type',2);
				$this->db->order_by('order_no');
				$get_all_inner_menus = $this->db->get(MENU_DETAILS)->result_array();

				$all_menus[] = $sub_menu;
				
				foreach($get_all_inner_menus as $inner_menu){
					$all_menus[] = $inner_menu;					
				}	
			}			

		}

	 

		return $all_menus;
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

	public function DeleteMenus($menu){
		$up_array = array('status'=>0);

		$this->db->where('menu_id',$menu['menu_id']); 
		$menus = $this->db->update(MENU_DETAILS,$up_array);

	}


	public function Get_allRoles(){

		$this->db->where('status',1);
		$get_roles = $this->db->get(MENU_PREFERENCE)->result_array();

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

	public function update_Details($up_array,$id){

		$this->db->where('preference_id',$id);
		$this->db->update(MENU_PREFERENCE,$up_array);
	}

	public function get_role_menu($preference_id){
		$this->db->where('preference_id',$preference_id);

		$role_menus = $this->db->get(MENU_PREFERENCE)->row_array();

		$role_menus['menu_preference'] = json_decode($role_menus['menu_preference']);

		print_r(json_encode($role_menus)); 
	}
}

?>