<?php

class Supplier_model Extends CI_Model{

	public function Validate_SupplierNAme($sname){

		$this->db->where('supplier_name', $sname);
		$get_supplier_anme=  $this->db->get(SUPPLIER)->num_rows();
		print_r($get_supplier_anme);
	}

	public function add_supplier($data){

		if($data['supplier_id'] == 0){

			unset($data['supplier_id']);
			
			if($this->session->userdata('user_id'))
			$data['created_by'] = $this->session->userdata('user_id');

			$this->db->insert(SUPPLIER, $data);  
		}

		else{

			if($this->session->userdata('user_id'))
			$data['modified_by'] = $this->session->userdata('user_id');
				 
			$this->db->where('supplier_id', $data['supplier_id']);
			$this->db->update(SUPPLIER, $data);
		}

	}

	public function GetSupplier(){

	 	//$this->db->where('status', 1);	
		$this->db->order_by('status DESC');
	 	$get_supplier = $this->db->get(SUPPLIER)->result_array();
	 
	 	print_r(json_encode($get_supplier));
	}

	public function Edit_Supplier($supplier_id){
		//$this->db->where('status', 1);
		$this->db->where('supplier_id', $supplier_id);
		$get_supplier=  $this->db->get(SUPPLIER)->row_array();
		return $get_supplier;
	}

	public function Disable_supplier($supplier_id, $status){

		if($status == 1){ $status = 0;}else{ $status = 1;}
		
		$up_array = array('status'=> $status);

	 	$this->db->where('supplier_id', $supplier_id);
	 	$this->db->update(SUPPLIER, $up_array);
	}
}

?>