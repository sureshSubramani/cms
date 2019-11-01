<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class common_details{ 

	private $CI;
 
    function __construct()
    {
        $this->CI = get_instance();	

        $this->CI->load->database();
	}
	
	public function GetParentMenus(){

    	$parent_menu = $this->CI->input->post('parent_menu');
    	$this->CI->db->where('menu_type',$parent_menu);
    	$this->CI->db->where('status',1);
    	$this->CI->db->order_by('order_no','ASC');
		$parent = $this->CI->db->get(MENU_DETAILS);
		$parent_count = $parent->num_rows();
		$parent_rec = $parent->result_array();
		if($parent_count>0){
			return $parent_rec;
		}
		else{
			return array();
		}
	}

    public function GetMenus(){

    	$user_type = $this->CI->session->userdata('user_type');
    	$user_role = $this->CI->session->userdata('user_role');
		if($user_type==ROOT_ADMIN){			 
			$this->CI->db->where('menu_type', 0);
			$this->CI->db->where('status', 1);
			$this->CI->db->order_by('order_no','asc');
			$get_menus = $this->CI->db->get(MENU_DETAILS)->result_array();
			/*echo "<pre>";
			print_r($get_menus);
			echo "</pre>";*/
			foreach($get_menus as $main_menu){
				
				$this->CI->db->where('status',1);	 	 
				$this->CI->db->where('menu_type',1);
				$this->CI->db->where('parent_id',$main_menu['menu_id']);
				$this->CI->db->order_by('order_no','asc');
				$get_sub_menus = $this->CI->db->get(MENU_DETAILS)->result_array();
				
				/*echo "<pre>";
				print_r($get_sub_menus);
				echo "</pre>";*/
				$all_sub_menus = array();

				foreach($get_sub_menus as $sub_menus){
					$this->CI->db->where('status',1);	 	 
					$this->CI->db->where('menu_type',2);
					$this->CI->db->where('parent_id',$sub_menus['menu_id']);
					$this->CI->db->order_by('order_no','asc');
					$get_inner_sub_menus = $this->CI->db->get(MENU_DETAILS)->result_array();
					//echo $this->CI->db->last_query()."<br>";
					$all_sub_menus[] = $sub_menus + array('inner_sub_menus'=>$get_inner_sub_menus);
					
				}
				
				$menu_array[] = $main_menu + array('sub_menus'=>$all_sub_menus);				
			}			
		}
		else{
			$this->CI->db->where('user_type',$user_type);
			$this->CI->db->where('user_role',$user_role);
			$this->CI->db->where('status',1);
			$this->CI->db->select('menu_preference');
			$menus = $this->CI->db->get(MENU_PREFERENCE);
			$rec_count = $menus->num_rows();
			
			$menu_array = array();
			
			if($rec_count>0){
				$menu_usrs = $menus->row_array();


				$decode = json_decode($menu_usrs['menu_preference'],true);
			  
				foreach ($decode as $key => $menu_id) {	 
					$this->CI->db->where('menu_id', $key);
					$this->CI->db->where('menu_type', 0);
					$this->CI->db->where('status', 1);
					$this->CI->db->order_by('order_no','asc');
					$get_menus = $this->CI->db->get(MENU_DETAILS)->result_array();

					 
				 	
				 	$sub_menus_get = array();

				 	if(count($get_menus) > 0){ 

						if(is_array($menu_id)){ 

							foreach($menu_id as $key_sub => $sub_menus){ 
								$this->CI->db->where('status', 1);	 	 
								$this->CI->db->where('menu_type', 1);
								$this->CI->db->where('menu_id', $key_sub);								 
								$this->CI->db->order_by('order_no','asc');
								$get_sub_menus = $this->CI->db->get(MENU_DETAILS)->row_array();

								

								if(is_array($sub_menus)){ 

									$inner_sub_menus_get = array();

									foreach($sub_menus as $key_inner => $inner_sub_menus){ 
										$this->CI->db->where('status', 1);	 	 
										$this->CI->db->where('menu_type', 2);
										$this->CI->db->where('menu_id', $key_inner);								 
										$this->CI->db->order_by('order_no','asc');
										$get_inner_sub_menus = $this->CI->db->get(MENU_DETAILS)->row_array();

										 $inner_sub_menus_get[] = $get_inner_sub_menus;
									}

									 
									$sub_menus_get[] = $get_sub_menus + array('inner_sub_menus'=>$inner_sub_menus_get);
								}
								else{
									$sub_menus_get[] = $get_sub_menus + array('inner_sub_menus'=>'');
								}

							}

							$menu_array[] = $get_menus[0] + array('sub_menus'=>$sub_menus_get);
						}
						else{
							$menu_array[] = $get_menus[0] + array('sub_menus'=>$sub_menus_get);
							//print_r($get_menus);
						}
				 	} 
				} 
			}
		}
    	return $menu_array;

    }

    public function GetStoreDetails(){

    	$this->CI->db->where('status', 1);
    	$this->CI->db->where('store_code', $this->CI->session->userdata('store_code'));
	 	$get_stores = $this->CI->db->get(STORES)->row_array();
	  
		return $get_stores;
	}
	public function GetAllStoreDetails(){

	 	$get_stores = $this->CI->db->get(STORES)->result_array();
	  
		return $get_stores;
	}
	public function GetAllStallDetails(){
    	$this->CI->db->where('status', 1);
    	//$this->CI->db->where('stall_code',$this->CI->session->userdata('stall_code'));	
	 	$get_stall = $this->CI->db->get(STALL)->result_array(); 
		return $get_stall;
	}

    public function GetStallDetails(){
    	$this->CI->db->where('status',1);
    	$this->CI->db->where('stall_code',$this->CI->session->userdata('stall_code'));	
		$get_stall = $this->CI->db->get(STALL)->row_array();
		//$this->CI->db->last_query();
		return $get_stall;
	}

	public function GetAllUserType(){
    	$type = array(ROOT_ADMIN);
		$this->CI->db->where_not_in('type', $type);
		$this->CI->db->group_by('type');
		$get_type = $this->CI->db->get(USERS_TYPE)->result_array();
		return $get_type;
	}		

	public function GetUserRole($type){
		$get_type = array();
		if($type){
			$this->CI->db->where('type', $type);
			$this->CI->db->group_by('role');
			$get_type = $this->CI->db->get(USERS_TYPE)->result_array();
		}
		return print_r($get_type);
	}
	
	public function existRecordCount($table, $data){
		$retVal = array();

		if($table && !empty($data)){
			
			foreach($data as $key => $val){
				$this->CI->db->where($key, $val);
				//$retVal[] = $key."=".$val."<br>";
			}			
			$this->CI->db->from($table);
			$retVal = $this->CI->db->count_all_results();
			
		}
		//$this->CI->db->last_query();
		return $retVal;
		//return $this->CI->db->last_query();
	}
	
	public function existRecords($table, $data){
		$retVal = array();
		if($table && !empty($data)){
			
			foreach($data as $key => $val){
				$this->CI->db->where($key, $val);
				//$retVal[] = $key."=".$val."<br>";
			}			

			$retVal = $this->CI->db->get($table)->result_array();
		}
		return $retVal;
	}

	public function array_find_deep($array, $search, $keys = array()){
		foreach($array as $key => $value) {
			if (is_array($value)) {
				$sub = $this->array_find_deep($value, $search, array_merge($keys, array($key)));
				if (count($sub)) {
					return $sub;
				}
			} elseif ($value === $search) {
				return array_merge($keys, array($key));
			}
		}

		return array();
	}
}
?>    