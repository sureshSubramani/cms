<?php

class Invoice_paymentModel Extends CI_Model{

	public function InsertPayment($data){
		/*echo "<Pre>";
		print_r($data);
		echo "</Pre>"; */

		$msg = "";
		if($data['payable_amount'] > 0){ 
			//Get Pending Amount
			$this->db->where('store_code', $data['store_code']);
			$this->db->where('supplier_id', $data['supplier_id']);
			$this->db->where('invoice_number', $data['invoice_number']);
			//$this->db->select('paid_amount');
			$invoice_amount = $this->db->get(INVOICE)->row_array();
			//$msg = $this->db->last_query();  
			$pendingAmount = $invoice_amount['total_amount']-$invoice_amount['paid_amount'];
			
			if($data['payable_amount']<=$pendingAmount){
				//Insert into Payment
				//unset($product['product_id']);
				$payment['store_code'] = $data['store_code'];
				$payment['supplier_id'] = $data['supplier_id'];
				$payment['invoice_number'] = $data['invoice_number'];
				$payment['payment_date'] = $data['payment_date'];
				$payment['amount'] = $data['payable_amount'];
				$payment['created_by'] = $this->session->userdata('user_id');				
				$this->db->insert(PAYMENT, $payment);
				
				
				// Update in Invoice
				$invoice['paid_amount'] = $invoice_amount['paid_amount']+$data['payable_amount'];
				
				$this->db->where('store_code', $data['store_code']);
				$this->db->where('supplier_id', $data['supplier_id']);
				$this->db->where('invoice_number', $data['invoice_number']);
				$this->db->update(INVOICE, $invoice);
				//echo $this->db->last_query(); exit;
				
				$msg = "1";
			}
			else{
				$msg = "Payable amount shouldn't be below or equal to pending amount!";
			}
		}
		else{
			$msg = "Enter valid amount!";
		}
		return $msg;
	}

	public function GetProductCategory(){
		$this->db->distinct();			
		//$this->db->order_by('status DESC');
		$get_pro_cat = $this->db->get(PRODUCT_CATEGORY)->result_array();
		return $get_pro_cat;
		// $this->db->order_by('category_id','desc'); 
		// $get_pro_code = $this->db->get(PRODUCTS)->result_array();
		// return array('cat'=>$get_pro_cat,'category_id'=>count($get_pro_code));
	}

	public function GetInvoiceDetails(){		
		//$this->db->where('p.status', 1);
		if($this->session->userdata('store_code'))
			$this->db->where('i.store_code', $this->session->userdata('store_code'));
		$this->db->from(INVOICE.' as i');
		$this->db->join(STORES.' as str', 'str.store_code = i.store_code', 'left');
		$this->db->join(SUPPLIER.' as sp', 'sp.supplier_id = i.supplier_id', 'left');
		$this->db->join(USERS.' as u', 'u.user_id = i.created_by', 'left');
		//$this->db->select('p.*, c.product_category');	
		$this->db->order_by('i.status DESC, i.invoice_date DESC, i.invoice_number DESC');	 
		$get_invoice = $this->db->get()->result_array();	 
		return $get_invoice;
	} 

	public function view_payment_details($store_code, $supplier_id, $invoice_number){
		//$this->db->where('i.status', 1);	
		if($this->session->userdata('store_code'))
			$this->db->where('i.store_code', $this->session->userdata('store_code'));
		$this->db->where('i.store_code', $store_code);
		$this->db->where('i.supplier_id', $supplier_id);
		$this->db->where('i.invoice_number', $invoice_number);	 	
		$this->db->from(PAYMENT.' as i');
		$this->db->join(STORES.' as str', 'str.store_code = i.store_code', 'left');
		$this->db->join(SUPPLIER.' as sp', 'sp.supplier_id = i.supplier_id', 'left');
		$this->db->join(USERS.' as u', 'u.user_id = i.created_by', 'left');
		$this->db->order_by('i.status DESC, i.payment_date');	
		$this->db->select('i.*, str.store_name, sp.supplier_name, u.name, u.role');	
		$get_payment = $this->db->get()->result_array();	 
		
		//echo $this->db->last_query(); exit;
		//print_r($get_payment);
		return $get_payment;
	}

}

?>