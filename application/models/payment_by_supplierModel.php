<?php

class Payment_by_supplierModel Extends CI_Model{

	public function InsertPayment($data){
		$msg = "";
		$payment = $invoice = array();
		if($data['tot_payable_amount'] > 0){ 
			$arr = array();
			if(isset($data['payable_amount']) && !empty($data['payable_amount'])){
				$temp = array();
				$error = array();
				$i=0;
				foreach($data['payable_amount'] as $kPay=>$vPay){
					//echo $kPay."=".$vPay."<br>";
					//Get Paid Amount
					$this->db->where('store_code', $data['store_code']);
					$this->db->where('supplier_id', $data['supplier_id']);
					$this->db->where('invoice_number', $kPay);
					//$this->db->select('paid_amount');
					$invoice_amount = $this->db->get(INVOICE)->row_array();
					//$msg = $this->db->last_query();  
					$pendingAmount = $invoice_amount['total_amount']-$invoice_amount['paid_amount'];
					//echo "<br>".$vPay."<=".$pendingAmount."<br>";
					
					if($vPay<=$pendingAmount){
						//Insert into Payment
						//unset($product['product_id']);
						$payment['store_code'] = $data['store_code'];
						$payment['supplier_id'] = $data['supplier_id'];
						$payment['invoice_number'] = $kPay;
						$payment['payment_date'] = $data['payment_date'];
						$payment['amount'] = $vPay;
						$payment['created_by'] = $this->session->userdata('user_id');				
						$this->db->insert(PAYMENT, $payment);
						$last_id = $this->db->insert_id();
						if(!$last_id){
							$error[] = $kPay." - Unable to add in payment!";
						}
						//echo $invoice_amount['paid_amount']." + ".$vPay."<br>";
						// Update in Invoice
						$invoice['paid_amount'] = $invoice_amount['paid_amount']+$vPay;

						$this->db->where('store_code', $data['store_code']);
						$this->db->where('supplier_id', $data['supplier_id']);
						$this->db->where('invoice_number', $kPay);
						$this->db->update(INVOICE, $invoice);
						$affected = $this->db->affected_rows();
						if(!$affected){
							$error[] = $kPay." - Unable to update in invoice!";
						}

						//$arr[] = array($payment, $invoice);
					}
					else{
						$error[] = $kPay." - Payable amount shouldn't be below or equal to pending amount!";
					}
					$i++;
				}
			}
			
			/*echo "<pre>";
			print_r($arr);
			print_r($data);
			echo "<pre>";
			exit;*/
			if(empty($error)){
				$msg = "1";
			}
			else{
				$msg = implode("<br>", $error);
			}
		}
		else{
			$msg = "Enter valid amount!";
		}
		return $msg;
	}

	
	public function GetInvoiceDetails($data){
		
		$this->db->where('i.status', 1);
		$this->db->where('i.store_code', $data['store_code']);
		$this->db->where('i.supplier_id', $data['supplier_id']);
		$this->db->where('i.total_amount>i.paid_amount');
		
		$this->db->from(INVOICE.' as i');
		$this->db->join(STORES.' as str', 'str.store_code = i.store_code', 'left');
		$this->db->join(SUPPLIER.' as sp', 'sp.supplier_id = i.supplier_id', 'left');
		$this->db->join(USERS.' as u', 'u.user_id = i.created_by', 'left');
		//$this->db->select('p.*, c.product_category');	
		$this->db->select('i.*, str.store_name, str.store_code, sp.supplier_name, sp.supplier_city, u.name, u.role, ');
		$this->db->order_by('i.invoice_date DESC, i.invoice_number DESC');	 
		$get_invoice = $this->db->get()->result_array();	 
		return $get_invoice;
	}

	public function GetSupplierDetails(){		
		//$this->db->where('p.status', 1);
		if($this->session->userdata('store_code'))
			$this->db->where('i.store_code', $this->session->userdata('store_code'));
		$this->db->from(INVOICE.' as i');
		if($this->session->userdata('user_type')==STORES){
			$this->db->join(SUPPLIER.' as sp', 'sp.supplier_id = i.supplier_id', 'left');
			$this->db->select('sp.supplier_name, sp.supplier_mobile, sp.supplier_city, sp.supplier_gst, SUM(i.total_amount) as total_amount, SUM(i.total_amount - i.paid_amount) as pending_amount');	
			$this->db->group_by('i.supplier_id');	 
			$this->db->order_by('sp.status DESC, SUM(i.total_amount-i.paid_amount) DESC, sp.supplier_name');
		}
		else{
			$this->db->join(STORES.' as str', 'str.store_code = i.store_code', 'left');
			$this->db->join(SUPPLIER.' as sp', 'sp.supplier_id = i.supplier_id', 'left');
			$this->db->select('sp.supplier_id, sp.supplier_name, sp.supplier_mobile, sp.supplier_city, sp.supplier_gst, str.store_code, str.store_name, SUM(i.total_amount) as total_amount, SUM(i.total_amount - i.paid_amount) as pending_amount');	
			$this->db->group_by('i.store_code, i.supplier_id');	 
			$this->db->order_by('sp.status DESC, sp.supplier_name, i.store_code');
		}
		$get_supplier = $this->db->get()->result_array();	 
		return $get_supplier;
	} 

	public function view_payment_details($store_code, $supplier_id){
		//$this->db->where('i.status', 1);	
		if($this->session->userdata('store_code'))
			$this->db->where('i.store_code', $this->session->userdata('store_code'));
		$this->db->where('i.store_code', $store_code);
		$this->db->where('i.supplier_id', $supplier_id);	 	
		$this->db->from(PAYMENT.' as i');
		$this->db->join(STORES.' as str', 'str.store_code = i.store_code', 'left');
		$this->db->join(SUPPLIER.' as sp', 'sp.supplier_id = i.supplier_id', 'left');
		$this->db->join(USERS.' as u', 'u.user_id = i.created_by', 'left');
		$this->db->order_by('i.status DESC, i.payment_date');
		$this->db->select('str.store_name, i.store_code, sp.supplier_name, sp.supplier_city, i.invoice_number, i.payment_date, i.amount, u.name, u.role, ');
		$get_payment = $this->db->get()->result_array();	 
		
		//echo $this->db->last_query(); exit;
		//print_r($get_payment);
		return $get_payment;
	}

}

?>