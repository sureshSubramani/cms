<?php
class Ticket_entryModel Extends CI_Model{

	public function getTicketAmnt(){

		$this->db->where('status',1);
		$this->db->where('type','themepark');
		$get_tickets = $this->db->get(TICKET_AMOUNT)->row_array();

		return $get_tickets;

	}

	public function generateBiiId(){
		$bill_id = $this->db->get(TICKET_ENTRY)->num_rows();

		$bill_id = $bill_id + 1;

		$prefix = 'MAHTHEME';

		$unique = str_pad($bill_id, 4, "0", STR_PAD_LEFT);

		$gen_billId = $prefix.''.$unique;

		return $gen_billId;

	}

	public function insertData($data){

		 
		$this->db->insert(TICKET_ENTRY,$data);
		
		/*print_r($data); 

		die();*/
	}
}

?>