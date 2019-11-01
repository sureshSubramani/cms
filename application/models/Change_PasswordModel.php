<?php
class Change_PasswordModel Extends CI_Model{

	public function checkOldPass($old_password){

            $id = $this->input->post('id');
                    $this->db->where('username', $this->session->userdata('user_type'));
                    $this->db->where('user_type', $this->session->userdata('user_name'));
                    $this->db->where('password', $old_password);
                    $query = $this->db->get('USERS');
            if($query->num_rows() > 0)
                return 1;
            else
                return 0;
    }

    public function checkOldPassword($old_password){
      $this->db->where('username', $this->session->userdata('user_name'))->where('user_type', $this->session->userdata('user_type'));
      $query = $this->db->get(USERS);
      $row    = $query->row();
      echo "Old Password : ".$old_password."<br>";
      echo "From DB : ".$row->password."<br>";
      die;
  
      if($query->num_rows > 0){
        $row = $query->row();
        if($old_password == $row->password){
          return true;
        }else{
          return false;
        }
      }
    }
   
    public function saveNewPass($new_pass){
        $array = array(
                'password'=>$new_pass
                );
        $this->db->where('username', $this->session->userdata('user_name'));
        $query = $this->db->update('users');
        if($query){
          return true;
        }else{
          return false;
        }
    }  
}

?>