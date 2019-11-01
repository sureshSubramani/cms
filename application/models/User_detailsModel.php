<?php
class User_detailsModel Extends CI_Model{

	public function InsertUsrs($usrs){
		/*echo "<pre>";
		print_r($usrs);
		echo "</pre>"; //exit;*/

		$error = 1;
		$msg = "";
		if(isset($usrs['form_type'])){			
			if(strtolower($usrs['form_type']) == "add"){ 

				if($this->session->userdata('user_id')){
					$name = (isset($usrs['name']) && $usrs['name'])?$usrs['name']:"";
					$usr_name = (isset($usrs['usr_name']) && $usrs['usr_name'])?$usrs['usr_name']:"";
					$type = (isset($usrs['type']) && $usrs['type'])?$usrs['type']:"";
					$role = (isset($usrs['role']) && $usrs['role'])?$usrs['role']:"";
					$pass = (isset($usrs['new_pass']) && $usrs['new_pass'])?$usrs['new_pass']:"";
					$cn_pass = (isset($usrs['confirm_pass']) && $usrs['confirm_pass'])?$usrs['confirm_pass']:"";
					$access_type = (isset($usrs['access_type']) && !empty($usrs['name']))?$usrs['access_type']:"";
					
					//Validate user details
					if($name && $usr_name && $type && $role && strlen($pass)>7 && $pass == $cn_pass && count($access_type)>0){
						
						$arg['user_name'] = $usr_name;
						$arg['user_type'] = $type;
						$arg['role'] = $role;
						//Return existing record count

						$existCount = $this->common_details->existRecordCount(USERS, $arg);

						if($existCount>0){
							$existRecord = $this->common_details->existRecords(USERS, $arg);
							if($existRecord[0]['status']==1){
								$msg = 'User already exist!';
							}
							else{
								$msg = 'User already in disabled!'; 
							}
						}
						else{

							$insert_data['name'] = $name;
							$insert_data['user_name'] = $usr_name;
							$insert_data['password'] = md5($pass);
							$insert_data['user_type'] = $type;
							$insert_data['role'] = $role;
							$insert_data['access_type'] = implode(",",$access_type);
							$insert_data['created_by'] = $this->session->userdata('user_id');
							
							$this->db->insert(USERS, $insert_data);

							$last_id = $this->db->insert_id();

							if($last_id){
								$this->session->set_userdata('user_create_success', 'User created success!');
								$msg = "User '".$insert_data['name']."' added successfully!";
								$error = "0";
							}
							else{
								$this->session->set_userdata('user_create_warning', 'Unable to execute!');
								$msg = $result."Unable to execute!";
							}
						}
					}
		            else if($name==""){
		                $msg = "Name required!";
		            }
		            else if($usr_name==""){
		                $msg = "Username required!";
		            }
		            else if($pass=="" || strlen($pass)<=7){
		                $msg = "Enter valid password!";
		            }
		            else if($cn_pass=="" || strlen($cn_pass)<=7){
		                $msg = "Enter valid confirm password!";
		            }
		            else if($pass!=$cn_pass){
		                $msg = "Password not matched!";
		            }
		            else if($type==""){
		                $msg = "Select a type!";
		            }
		            else if($role==""){
		                $msg = "Select a role!";
		            }
		            else{
		                $msg = "Unknown error. Unable to add";
		            }

				}
				else{
					$msg = "No user logged in!";
				}
			}				
			else{
				$msg = "Unknown operation!";
			} 
		}

		return $error."|".$msg;
	}


	public function Get_users(){
		$type = array(ROOT_ADMIN);
		$me = $this->session->userdata('user_id');
		$this->db->where_not_in('user_type', $type); // Don't fet the root admin user
		$this->db->where('user_id !=',$me); // Don't fetch current looged in user
		$this->db->where('status',1); 
	 	$get_usr = $this->db->get(USERS)->result_array();

	 	return $get_usr;
	}

	public function Get_usertype($type){
		$get_usr = array();
		if($type){
			$this->db->where('type', $type);
			$get_usr = $this->db->get(USERS_TYPE)->result_array();
		}
	 	return $get_usr;
	}
	public function Get_userRole($type){
		$get_usr = array();
		if($type){
			$this->db->where('type', $type);
			$this->db->group_by('role');
			$get_usr = $this->db->get(USERS_TYPE)->result_array();
		}
	 	return $get_usr;
	}
	/*public function GetProductsDetails(){	
		//$this->db->where('product_status',1);
		$get_pro_cat = $this->db->get(PRODUCTS)->result_array();
		return $get_pro_cat;
	}
 

	public function Edit_product_details($product_id){


		$this->db->where('product_status',1);
		$this->db->where('product_id',$product_id);
	 	$get_pro = $this->db->get(PRODUCTS)->row_array();

		return $get_pro;

	}*/

	public function DeleteUsr($usrs_id){

		$up_array = array('status'=>0);

 		$this->db->where('user_id',$usrs_id);
		$this->db->update(USERS,$up_array);
 

	} 
	
	public function enableUsr($usrs_id){

		$up_array = array('status'=>1);

 		$this->db->where('user_id',$usrs_id);
		$this->db->update(USERS,$up_array);
 

	} 
}

?>