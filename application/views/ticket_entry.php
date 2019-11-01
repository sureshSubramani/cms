<!-- <!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap_datepicker.css">
    <script src="<?php echo base_url(); ?>assets/js/angular.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/angular_ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap_datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/validate/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/validate/additional-methods.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js"></script>
</head>
 -->

<style id="TestPrint" type="text/css" media="print" disabled>
			/*#test_print{

            	display: block !important;
            }

            #cart_print{
            	display: none !important;
            }

            .shift_clode_print{

            	display: none !important;
            }*/
            

</style>



<style id="printOne" type="text/css" media="print" disabled>

 @page {  margin-top: -50px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px;  size: auto;} 
	  		body { margin: 0.1cm; }


            #cart_print{
            	display: block !important;
            }

            #body_design{

            	display: none;
            }
             #test_print{

            	display: none !important;
            }

            .user-info{
            	display: none !important;
            }


</style>
<body style="background: #ecf0f5;     height: 25.5cm;">

<div class="container " id="body_design">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info">
			     
			    <div class="panel-heading">
			        <div class="panel-title">Ticket Entry</div>
			    </div> 
			    <div class="panel-body">
	 				<form role="form" method="post" class="store_details_submit "  autocomplete="off" onsubmit="ticket_entry_sub('printOne');">
					   	<div class="row">
					   		<div class="col-sm-6">
						   		<div class="form-group">
							        <label for="field-1" class="control-label">Date</label>				         
							        <input type="text" class="form-control" name="date_field" id="field-1" placeholder="YYYY-MM-DD" readonly value="<?php echo date('Y-m-d') ?>"> 
	 						    	<input type="hidden" class="form-control" value="<?php echo $bill_id; ?>" name="bill_id">
	 						    </div>


	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Ticket Type</label>				         
							        <select class="form-control" name="ticket_type" required onchange="get_Percentage(this.value)">
							        	<option value="">Select</option>
							        	<option value="5D">5% Discount</option>
							        	<option value="50D">50% Discount</option>
							        	<option value="CS">College Student</option>
							        	<option value="E">Evening</option>
							        	<option value="M">Morning</option>
							        	<option value="3rd">Up to III</option>
							        	<option value="8th">Up to VIII</option>
							        	<option value="12th">Up to XII</option>
							        </select>
	 						    </div>

	 						    <!-- <div class="form-group">
							        <label for="field-1" class="control-label">No.of Coupons</label>				         
							        <input type="number" min="0" class="form-control" name="no_counops" id="field-1"    placeholder="No.of Coupons" > 
	 						    </div> -->

	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Adult</label>				         
							        <input type="number" min="0" class="form-control adult" name="adult" value="0"  id="field-1" placeholder="No.of Adults"  required onkeyup="common_amnt_value()" > 
	 						    </div>

	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Child</label>				         
							        <input type="number" min="0" class="form-control child" name="child" value="0"  id="field-1" placeholder="No.of Childs" required  onkeyup="common_amnt_value()"> 
	 						    </div>

	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Amount</label>	

							        <input type="number" min="0" class="form-control total_amnt" name="total_amnt" value="0" placeholder="0" id="field-1"  readonly  required> 
	 						    </div>

	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Payment Mode</label>				         
							        <select class="form-control" name="payment_mode" required>
							        	<option value="">Select</option>
							        	<option value="cash">Cash</option>
							        	<option value="card">Card</option>
							        	 
							        </select>
	 						    </div>


						   	</div>

						     <div class="col-sm-6">
						     	<div class="form-group">
							        <label for="field-1" class="control-label">Offer Amount</label>				         
							        <input type="number" min="0" class="form-control offer_amnt" name="offer_amnt" value="0" placeholder="0" id="field-1"  readonly  required> 
	 						    </div>

	 						    <table class="table table-bordered">
	 						    	<tbody>
	 						    		<tr>
	 						    			<th>Adult</th>
	 						    			<th>Child</th>
	 						    		</tr>

	 						    		<tr>
	 						    			<td ><span class="amount_audlt_txt"><?php echo $ticket_amnt['audult']; ?></span>
	 						    			<input type="hidden" class="from-control adult_amnt" name="adult_amnt" value="<?php echo $ticket_amnt['audult']; ?>">
	 						    			<input type="hidden" class="from-control adult_amnt_change" name="adult_amnt_change" value="<?php echo $ticket_amnt['audult']; ?>">
	 						    			</td>
	 						    			<td ><span class="amount_child_txt"><?php echo $ticket_amnt['child']; ?></span>
	 						    			<input type="hidden" class="from-control child_amnt" name="child_amnt" value="<?php echo $ticket_amnt['child']; ?>">
	 						    			<input type="hidden" class="from-control child_amnt_change" name="child_amnt_change" value="<?php echo $ticket_amnt['child']; ?>">
	 						    			</td>
	 						    		</tr>
	 						    	</tbody>
	 						    </table>

	 						    <h3>Offer Details</h3>
	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Name</label>				         
							        <input type="test"   class="form-control" name="usr_name"   placeholder="Name" id="field-1"   > 
	 						    </div>

	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Position</label>				         
							        <input type="test"   class="form-control" name="usr_posistion"   placeholder="Posistion" id="field-1"   > 
	 						    </div>

	 						    <div class="form-group">
							        <label for="field-1" class="control-label">Recommended by</label>				         
							        <input type="test"   class="form-control" name="usr_recommended"   placeholder="Recommended by" id="field-1"   > 
	 						    </div>
						     </div>
					   	</div>
					    
					    <div class="form-group">
					         
					            <center><button type="submit" class="btn btn-success" >Print</button></center>
					         
					    </div>
					</form>
	 		    </div>
			</div>
		</div>
	</div>
</div>	




<div class="print_page" id="cart_print" style="display: none;">
	
				<center><h2 style="font-size: 20px; margin-bottom: 10px;  font-weight: normal; " >Receipt</h2> </center>
				<h2 style="font-size: 14px; margin-bottom: 10px;  font-weight: normal; " > <span class="pull-left">#<?php echo $bill_id; ?></span> <span class="pull-right"><?php echo date('d-m-Y H:i:s'); ?></span> </h2> 

			<hr style=" border-top: 3px dotted black !important; width: 100%;     margin: 0px !important;">	

	  <!--  <h3 style="font-size: 15px; margin-bottom: 10px;  font-weight: normal; "><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart Details </h3> -->
<table class="table" id="cart_print" style="display:block; width: 100%; border: none;">  
		<thead>
			<tr  >
				<th class="thead_font_size">Sno</th>
				<th class="thead_font_size">Type</th>
				<th class="thead_font_size">Quantity</th>
				<th class="thead_font_size">Amount</th>
			</tr>


		</thead>

		<tbody>
			<tr>
				<td>1</td>
				<td>Adult</td>
				<td class="count_adult_td">5</td>
				<td class="amnt_adult_td">500</td>
			</tr>

			<tr>
				<td>1</td>
				<td>Child</td>
				<td class="count_child_td">5</td>
				<td class="amnt_child_td">500</td>	
			</tr>
		</tbody>
		 
			<tr>
				<th colspan="2" style="text-align: right;"><h2  style="font-size: 20px;">Total :</h2></th>
				<th><h2  style="font-size: 20px;">  <span class="Ovrall_total_td"> 1000</span></h2></th>
			</tr>

			<tr>
				<th colspan="4" style="text-align: center; font-weight: normal;">Thank You Visit Again</th>
			</tr>
	</table>


</div>
</body>
<script type="text/javascript">
	function print_shit_close(pid){
	 
		document.getElementById('printOne').disabled = !(pid === 'printOne');
	    
	    window.print();

	    /*$('#shift_clode_print').hide();


	    window.location.replace("index.php"); */
	    return false;
	}


	
</script>