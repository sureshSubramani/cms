<?php
class Logout Extends CI_Controller{


	public function index(){

		$this->session->sess_destroy();

		redirect(base_url().'login');
	}
}


?>