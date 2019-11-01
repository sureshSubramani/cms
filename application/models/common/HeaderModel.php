<?php
class HeaderModel Extends CI_Model{


	public function header(){

		if(!$this->session->userdata('user_name')){
			redirect(base_url().'login')	;
		} 

		$menus = $this->common_details->GetMenus();
		if(!empty($menus)){
			$this->Check_url(uri_string(),$menus);
		}
		
		$this->load->view('common/header');
	}

	public function Check_url($url,$menu_details)
	{
		 
		if(!$url){
			$url = "index";
		}
		$urls = array();
		//echo $url; exit;
		foreach($menu_details as $main_menu){

			if($main_menu['menu_id'] != ''){
				$urls[] = $main_menu['menu_id'];
			}				

			foreach($main_menu['sub_menus'] as $submenu){
				if($submenu['menu_id'] != ''){
					$urls[] = $submenu['menu_id'];
				}
				
			}
		}

		$this->db->where('status',1);
		$this->db->where ("menu_id IN (".implode(',', $urls).")");
		$this->db->where('menu_url',$url);
		$all_menus = $this->db->get(MENU_DETAILS)->num_rows();


		
		//print_r($all_menus); exit;

		if($all_menus != 1){
			//redirect(base_url().'access_denied');
			
		}

	}

}
?>