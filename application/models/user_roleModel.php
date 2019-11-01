<?php
class User_roleModel Extends CI_Model{

	public function add_user_role($arg){

		$this->db->where('type',$arg['type']);
		$this->db->where('role',$arg['role']);
		$exist = $this->db->get(USERS_TYPE); // Get exist role and type
		$existCount = $exist->num_rows();
		//echo $this->db->last_query(); exit;
		if($existCount==0){
			$this->db->insert(USERS_TYPE,$arg);
		}
	}
	public function isExistRole($arg){

		$this->db->where('type',$arg['type']);
		$this->db->where('role',$arg['role']);
		$exist = $this->db->get(USERS_TYPE); // Get exist role and type
		return $exist->num_rows();
		
	}
	public function remove_role($role){
		$status = array('status'=>0);

		$this->db->where('user_type_id',$role['user_type_id']); 
		$this->db->update(USERS_TYPE,$status);
		return 1;
	}
	public function enable_role($role){
		$status = array('status'=>1);

		$this->db->where('user_type_id',$role['user_type_id']); 
		$this->db->update(USERS_TYPE,$status);
		//echo $this->db->last_query(); exit;
		return 1;

	}
	public function Get_allRoles(){
		
		$type = array(ROOT_ADMIN);
		//$me = $this->session->userdata('user_id'); // Don't fetch the this user
		$this->db->where_not_in('type', $type); // Don't fetch the root admin user
		//$this->db->where('status',1);
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('type', 'DESC');
		$get_roles = $this->db->get(USERS_TYPE)->result_array();
		//echo $this->db->last_query();
		return $get_roles;
	}

}

?>