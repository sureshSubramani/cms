<!-- <!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap_datepicker.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/seat_booking.css">
    
    <script src="<?php echo base_url(); ?>assets/js/angular.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/angular_ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap_datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/validate/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/validate/additional-methods.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js"></script>
</head>
 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/seat_booking.css">
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


            @media print {

			@page {  margin-top: -50px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px;  size: auto;} 
	  		body { margin: 0.1cm; }
  
			
		}
            

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
	<div class="container-fluid" id="body_design" style="margin-top:20px;">
		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-info">
				     
				    <div class="panel-heading">
				        <div class="panel-title">Ticket Entry</div>
				    </div> 
				    <div class="panel-body">
		 				<form role="form" method="post" class="store_details_submit " onsubmit="store_details_submit('printOne')"  autocomplete="off">
						   	<div class="row">
						   		<div class="col-sm-4">
							   		<div class="form-group">
								        <label for="field-1" class="control-label">Date</label>				         
								        <input type="text" class="form-control" name="date_field" id="field-1" placeholder="YYYY-MM-DD" readonly value="<?php echo date('Y-m-d') ?>"> 
		 						    	<input type="hidden" class="form-control" value="<?php echo $bill_id; ?>" name="bill_id">
		 						    </div>


		 						    <!-- <div class="form-group">
								        <label for="field-1" class="control-label">Scheme</label>				         
								        <select class="form-control" name="locker_scheme" required  >
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
		 						    </div> -->

		 						   

		 						    <div class="form-group">
								        <label for="field-1" class="control-label">No of Locker</label>				         
								        <input type="number" readonly min="0" class="form-control no_of_locker" name="no_of_locker" value="0"  id="field-1" placeholder="No of Locker"  required onkeyup="common_amnt_value()" > 
		 						    </div>

		 						    <div class="form-group">
								        <label for="field-1" class="control-label">Rent</label>				         
								        <input type="number" min="0" class="form-control total_rent" name="rent" value="0"  id="field-1" placeholder="Rent" required  onkeyup="common_amnt_value()"> 
		 						    </div>

		 						     

		 						    <div class="form-group">
								        <label for="field-1" class="control-label">Total Amount</label>				         
								        <input type="number" min="0" class="form-control total_amnt" name="total_amnt" value="0" placeholder="0" id="field-1"    required> 
		 						    </div>

		 						    <div class="form-group">
								        <label for="field-1" class="control-label">Payment Mode</label>				         
								        <select class="form-control" name="payment_mode" required>
								        	<option value="">Select</option>
								        	<option value="cash">Cash</option>
								        	<option value="card">Card</option>
								        	 
								        </select>
		 						    </div>


		 						    <div class="form-group">
								        <label for="field-1" class="control-label">Locker No</label>				         
								        <textarea type="test" rows="3" class="form-control locker_no" name="locker_no" value="0" placeholder="0" id="field-1"    required></textarea>
		 						    </div>

							   	</div>

							     <div class="col-sm-8">
								     	<!-- <div class="form-group">
									        <label for="field-1" class="control-label">Offer Amount</label>				         
									        <input type="number" min="0" class="form-control offer_amnt" name="offer_amnt" value="0" placeholder="0" id="field-1"    required> 
			 						    </div> -->

		 						    <table class="table table-bordered">
		 						    	<tbody>
		 						    		<tr>
		 						    			<th>Rent </th>
		 						    			<th>Deposit</th>
		 						    		</tr>

		 						    		<tr>
		 						    			<td >
			 						    			<span  ><?php echo $ticket_amnt['audult']; ?></span>
			 						    			<input type="hidden" class="from-control rent_amnt" name="rent_amnt" value="<?php echo $ticket_amnt['audult']; ?>">
		 						    			</td>
		 						    			<td >
			 						    			<span  ><?php echo $ticket_amnt['child']; ?></span>
			 						    			<input type="hidden" class="from-control discount_amnt" name="discount_amnt" value="<?php echo $ticket_amnt['child']; ?>">
		 						    			</td>
		 						    		</tr>
		 						    	</tbody>
		 						    </table>


		 						    <?php
		 						    	$rows = 10;
		 						    	$columns= 50;
		 						    	$strt_no = 301;
		 						    	$total_lockers = $rows * $columns;
		 						    ?>


		 						    <div class="seats" id="seats" style="">
									    <div class="seat_wrap  ">
									      	<center><h3 >Locker</h3></center>
									        <table id="seat-table">	
									            <tbody>

									                <tr>
									                	<?php $j=1; for($i=0; $i<$total_lockers; $i++){ ?>
									                	 
									                	<td>
									                        <div style="display:flex">  
									                           <!--  <div class="seat noborder">&nbsp;</div> -->
									                         
									                            <div class="seat seat_disabled<?php echo $strt_no; ?>" onclick="btn_check_check_box(<?php echo $strt_no; ?>)">
									                                <p class="token_design token_design<?php echo $strt_no; ?>" title="Counter Booking Only"><?php echo $strt_no; ?></p>
									                                <input disabled="" type="checkbox" class="edit_check_box edit_check_box<?php echo $strt_no; ?>" style="display:none;" >
									                                <input type="hidden" name="checked_token[]" class="form-control checked_token checked_token<?php echo $strt_no; ?>">	
									                            </div>
									                            
									                             
									                        </div>	
									                    </td>
									                	<?php  if($j>=25){ echo '</tr><tr>'; $j=0; } $j++; $strt_no++; } ?>
									                    
									                </tr>
									                
									            </tbody>
									        </table>
									    </div>
									</div>




		 						     
							     </div>





						   	</div>
						    
						    <div class="form-group">
						         
						            <center><button type="submit" class="btn btn-success"  >Print</button></center>
						         
						    </div>
						</form>
		 		    </div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Ticket remove
							<div class="col-sm-6 pull-right" style="margin-top: -6px;">
								<input type="text" class="form-control" name="remove_id" placeholder="Enter Locker ID" onkeydown="search_locker_id(this)">
							</div>
						</div>
					</div>

					<div class="panel-body table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Bill ID</th>
									<th>No.of Lockers</th>
									<th>Locker No</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody class="view_datassss">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	




<div class="print_page" id="cart_print" style="display: none;">
	
				<center><h2 style="font-size: 20px; margin-bottom: 10px;  font-weight: normal; " >Receipt</h2> </center>
				<h2 style="font-size: 12px; margin-bottom: 10px;  font-weight: normal; " > <span class="pull-left">#<?php echo $bill_id; ?></span> <span class="pull-right"><?php echo date('d-m-Y H:i:s'); ?></span> </h2> 

			<hr style=" border-top: 3px dotted black !important; width: 100%;     margin: 0px !important;">	

			<h2 style="font-size: 14px; margin-bottom: 10px;  font-weight: normal; " >No Lockers : <span class="print_no_lockr"></span></h2>
			<h2 style="font-size: 14px; margin-bottom: 10px;  font-weight: normal; " >Locker No : <span class="print_ticket_list"></span></h2>
			<h2 style="font-size: 14px; margin-bottom: 10px;  font-weight: normal; " >Rent Amount : <span class="print_rent_amnt"></span></h2>
			<h2 style="font-size: 14px; margin-bottom: 10px;  font-weight: normal; " >Total Amount : <span class="print_total_amnt"></span></h2>
	  <!--  <h3 style="font-size: 15px; margin-bottom: 10px;  font-weight: normal; "><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart Details </h3> -->
<!-- <table class="table" id="cart_print" style="display:block; width: 100%; border: none;">  
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
	</table> -->


</div>
</body>
<script type="text/javascript">
	/*function print_shit_close(pid){
	 
		document.getElementById('printOne').disabled = !(pid === 'printOne');
	    
	    window.print();

	    
	    return false;
	}*/
</script>