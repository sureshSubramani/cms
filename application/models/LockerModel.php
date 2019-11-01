<?php
class LockerModel Extends CI_Model{

	/*public function GetMenus(){

    	$user_type = $this->session->userdata('user_type');
    	$user_role = $this->session->userdata('user_role');


		 
			$this->db->where('user_type',$user_type);
			$this->db->where('user_role',$user_role);
			$this->db->where('status',1);
			$this->db->select('menu_preference');
			$menus = $this->db->get(MENU_PREFERENCE);
			$rec_count = $menus->num_rows();
			
			$menu_array = array();
			
			if($rec_count>0){
				$menu_usrs = $menus->row_array();


				$decode = json_decode($menu_usrs['menu_preference'],true);
			 
				 
				$all_menus = array();

				foreach ($decode as $key => $menu_id) {	 
					$this->db->where('menu_id', $key);
					$this->db->where('menu_type', 0);
					$this->db->where('status', 1);
					$this->db->order_by('order_no','asc');
					$get_menus = $this->db->get(MENU_DETAILS)->result_array();

					 
				 	
				 	$sub_menus_get = array();

				 	if(count($get_menus) > 0){ 

						if(is_array($menu_id)){ 

							foreach($menu_id as $key_sub => $sub_menus){ 
								$this->db->where('status', 1);	 	 
								$this->db->where('menu_type', 1);
								$this->db->where('menu_id', $key_sub);								 
								$this->db->order_by('order_no','asc');
								$get_sub_menus = $this->db->get(MENU_DETAILS)->row_array();

								

								if(is_array($sub_menus)){ 

									$inner_sub_menus_get = array();

									foreach($sub_menus as $key_inner => $inner_sub_menus){ 
										$this->db->where('status', 1);	 	 
										$this->db->where('menu_type', 2);
										$this->db->where('menu_id', $key_inner);								 
										$this->db->order_by('order_no','asc');
										$get_inner_sub_menus = $this->db->get(MENU_DETAILS)->row_array();

										 $inner_sub_menus_get[] = $get_inner_sub_menus;
									}

									 
									$sub_menus_get[] = $get_sub_menus + array('inner_sub_menus'=>$inner_sub_menus_get);
								}
								else{
									$sub_menus_get[] = $get_sub_menus + array('inner_sub_menus'=>'');
								}

							}

							$all_menus[] = $get_menus[0] + array('sub_menus'=>$sub_menus_get);
						}
						else{
							$all_menus[] = $get_menus[0] + array('sub_menus'=>$sub_menus_get);
							//print_r($get_menus);
						}
				 	} 
				} 
			}
		 
    	return $menu_array;

    }*/

	public function GetCheckedLocker(){

		$getlocker = $this->db->where('status',1)->select('checked_token')->get(LOCKER)->result_array();

		$array_checked = array();

		foreach($getlocker as $locker){
			$json = json_decode($locker['checked_token'],true);

			foreach ($json as $key => $tickets) {
				 
				$array_checked[] = $tickets;
			}
 
		}

		print_r(json_encode($array_checked));
	}

	public function getTicketAmnt(){

		$this->db->where('status',1);
		$this->db->where('type','locker');
		$get_tickets = $this->db->get(TICKET_AMOUNT)->row_array();

		return $get_tickets;

	}

	public function generateBiiId(){
		$bill_id = $this->db->get(LOCKER)->num_rows();

		$bill_id = $bill_id + 1;

		$prefix = 'MAHLOCKER';

		$unique = str_pad($bill_id, 4, "0", STR_PAD_LEFT);

		$gen_billId = $prefix.''.$unique;

		return $gen_billId;

	}

	public function insertData($data){ 
		 
		$this->db->insert(LOCKER,$data); 
	}

	public function GetSelectedLocker($locker_id){

		/*$this->db->group_start();*/
		$this->db->where('bill_id',$locker_id);
		/*$this->db->group_end();*/
		$this->db->where('status',1);
		$get_locker = $this->db->get(LOCKER)->result_array();

		print_r(json_encode($get_locker));

	}

	public function RemoveLocker($locker_id){
		$up_array = array('status'=>0);

		$this->db->where('locker_id',$locker_id);
		$this->db->update(LOCKER,$up_array);

		//print_r($this->db->last_query());

	}
}

?>