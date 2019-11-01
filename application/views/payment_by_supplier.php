<div class="row" ng-app="Common_app" ng-controller="Payment_by_supplier">
    <div class="col-lg-10 col-xs-offset-1">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title">Supplier and Payment Details</div>
            </div>
            <div class="panel-body">
                <div class="row">                   
                    <div class="menu-bottom input-group col-lg-4 pull-right">
                        <input class="form-control search" ng-model="search" placeholder="Search" type="search" /> 
                        <span class="btn btn-primary input-group-addon">
                            <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                    <div class="col-lg-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered" datatable="ng">
                            <thead>
                                <tr>
                                   <th>Sl No</th> 
                                    <th>Supplier Info</th>
									<?php
									if(!$this->session->userdata('store_code')){?>
										<th>Purchased Store Info</th>
										<?php 
									}?>
                                    <th>Total Amount (in Rs.)</th>
                                    <th>Pending Amount (in Rs.)</th>
                                    <?php 
                                     /* <th>Status</th> */
									if($this->session->userdata('user_type')==STORE_MANAGER){?>
                                    	<th>Payment</th>
                                    	<?php 
									}?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (supplier_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit" title="{{data.description}}">
                                    <td>{{(current_grid*10 - 9) + $index}}</td>                               
                                    <td style="text-transform: capitalize;">{{data.supplier_name}}</td>  
									<?php
									if(!$this->session->userdata('store_code')){?>
										<td>{{data.store_name+' ('+data.store_code+')'}}</td>
										<?php 
									}?> 
                                    <td style="text-transform: capitalize;">{{data.total_amount}} </td>                                
                                    <td style="text-transform: capitalize;">{{data.pending_amount}} </td>                                
                                    <?php /*
									<td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
                                    <td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
									*/ 
									if($this->session->userdata('user_type')==STORE_MANAGER){?>
	                                    <td style="width:3cm;">
											<!--If payment is pending then show payment button-->
	                                        <button type="button" ng-if="(data.total_amount-data.paid_amount)>0" class="btn btn-sm btn-info waves-effect" data-toggle="modal" data-target="#pay" ng-click="view_supplier_payment_form(data)">
	                                            <i class="fa fa-forward" aria-hidden="true"></i>
	                                        </button> 
											
											<!--If total amount is paid then show dummy button-->
											<button type="button" ng-if="(data.total_amount-data.paid_amount)<=0" class="btn btn-sm btn-default waves-effect">
	                                            <i class="fa fa-check" aria-hidden="true"></i>
	                                        </button>
											
											<!--View--> 
											<?php /*
											<button type="button" class="btn btn-sm btn-success waves-effect" data-toggle="modal" data-target="#view" ng-click="view_supplier_payment_details(data)">
	                                            <i class="fa fa-search" aria-hidden="true"></i>
	                                        </button>
											
	                                        <button type="button" class="btn btn-sm btn-danger waves-effect" ng-if="data.status == 1"
	                                            ng-click="disable_products(data.product_id, data.status)">
	                                            <i class="fa fa-close pro-active" aria-hidden="true"></i>                                            
	                                        </button>
	                                        <button type="button" class="btn btn-sm btn-success waves-effect" ng-if="data.status == 0"
	                                            ng-click="disable_products(data.product_id, data.status)">                                            
	                                            <i class="fa fa-check pro-deactive" aria-hidden="true"></i>
	                                        </button> */ ?>
	                                    </td>
	                                    <?php 
									}?> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" ng-show="searched == ''">
                        <div class="col-md-12">
                            <h4 class="is-not-serach">No records found..</h4>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div pagination="" page="current_grid" on-select-page="page_position(page)"
                            max-size="CollegemaxSize" boundary-links="true" total-items="filter_data"
                            items-per-page="data_limit" class="pagination-small pull-right"previous-text="&laquo;"
                            next-text="&raquo;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="pay" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment Form</h4>
                </div>
                <div class="modal-body">
					<table class="">
						<tr>
							<th>Store</th>
							<td>: </td>
							<td span id="add_store_info"></td>
						</tr>
						<tr>
							<th>Supplier</th>
							<td>: </td>
							<td span id="add_supplier_info"></td>
						</tr>
						<tr>
							<th>Total Amount</th>
							<td>: </td>
							<td span id="add_total_amount"></td>
						</tr>
						<tr>
							<th>Pending Amount</th>
							<td>: </td>
							<td span id="add_pending_amount"></td>
						</tr>
					</table><br>
					
                    <form role="form" id="payment_form" method="post" class="payment_submit" ng-submit="payment_submit()"
                        autocomplete="off">						
						<input type="hidden" class="form-control" id="payment_store_code" value="" name="store_code" readonly>
						<input type="hidden" class="form-control" id="payment_supplier_id" value="" name="supplier_id" readonly>
						
                        <div class="form-group">
                            
							<table class="table table-striped table-bordered" datatable="ng">
								<thead>
									<tr>
										<th>SNo</th>
										<th>Date</th>
										<th>Invoice No.</th>
										<th>Total (Rs.)</th>
										<th>Pending (Rs.)</th>
										<?php /*<th>Paid (Rs.)</th>*/?>
										<th>Payment (Rs.)</th>
										 <?php /*<th>Status</th> */?>
									</tr>
								</thead>
								<tbody id="view_body_invoice">
									<tr ng-if="0 != (pending_invoice_details)" ng-repeat="invoice in searched = (pending_invoice_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit track by invoice.invoice_number" title="Invoice Number: {{invoice.invoice_number}}">
										<td>{{(current_grid*10 - 9) + $index}}</td>  
										<td style="text-transform: capitalize;">{{invoice.invoice_date}}</td> 
										<td style="text-transform: capitalize;">{{invoice.invoice_number}}</td>
										<td style="text-transform: capitalize;">{{invoice.total_amount}} </td>
										<td style="text-transform: capitalize;">{{invoice.total_amount - invoice.paid_amount}} </td> 
										<?php /*<td style="text-transform: capitalize;">{{invoice.paid_amount}} </td>*/ ?> 
										<td style="text-transform: capitalize;">
											<input type="text" class="form-control payable_amount"  value="{{invoice.total_amount - invoice.paid_amount}}" id="payable_amount_{{invoice.invoice_number}}" name="payable_amount[{{invoice.invoice_number}}]" ng-keyup="update_total(invoice, this.value)" title="Amount should less or equal to {{invoice.total_amount - invoice.paid_amount}}"  onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" style="width: 100px; color: #009688; font-weight: 800; border: 1px solid #ccc;">  
										</td> 
									</tr>
									<tr ng-if="0 != (pending_invoice_details)">
										<td colspan="6" >
											<input type="hidden" class="form-control payment_date"  value="<?php echo date("Y-m-d"); ?>" id="payment_date" name="payment_date" placeholder="" required readonly> 
											<input type="hidden" class="form-control tot_pending_amount"  value="" id="tot_pending_amount" name="tot_pending_amount" placeholder="" required readonly> 
											<input type="hidden" class="form-control tot_payable_amount"  value="" id="tot_payable_amount" name="tot_payable_amount" placeholder="" required readonly> 
											<p style="text-align: center;color: #009688; font-size:20px">
												Total Rs.
												<span id="total_payable_amount" style="font-size:25px"></span> 
											</p>
											<div id="error_amount"></div>
											
										</td>
									</tr>
									<tr ng-if="0 == (pending_invoice_details)">
										<td colspan="6">No Pending found</td>
									</tr>
								</tbody>
							</table>
                        </div>
						<?php /*
						<div class="form-group">
                            <label for="field-1" class="control-label">Payment Date</label>                            
                            <input type="text" class="form-control payment_date"  value="<?php echo date("Y-m-d"); ?>" id="payment_date" name="payment_date" placeholder="Select Date" required readonly> 
							<div class="error_amount"></div>
                        </div> 
						<div class="form-group">
                            <label for="field-2" class="control-label">Amount to Pay (in Rs.)</label> 
							<input type="hidden" class="form-control payment_date"  value="<?php echo date("Y-m-d"); ?>" id="payment_date" name="payment_date" placeholder="Select Date" required readonly> 
                            <input type="text" class="form-control payable_amount"  value="" id="payable_amount" name="payable_amount" placeholder="Enter amount to pay" style="background-color:#fff; font-size:25px" readonly required> 
							<div id="error_amount"></div>
						</div>*/ ?>
                        <div class="form-group">
                            <div class="text-center">
								<button type="submit" class="btn btn-success">Pay Now</button>
								<button type="reset" class="btn btn-orange">Reset</button>
							</div>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php /*
    <!-- Modal -->
    <div id="view" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title view-modal-title">Payment Details</h4>
                </div>
                <div class="modal-body view-modal-body">
					<table class="">
						<tr>
							<th>Store</th>
							<td>: </td>
							<td span id="view_store_info"></td>
						</tr>
						<tr>
							<th>Supplier</th>
							<td>: </td>
							<td span id="view_supplier_info"></td>
						</tr>
					</table><br>
					<h4 class="text-center" ng-if="0 == (payment_details)">Payment is pending!</h4>
                    <table ng-if="0 != (payment_details)" class="table table-striped table-bordered" datatable="ng">
						<thead>
							<tr>
								<th>Sl No</th> 
								<th>Invoice Number</th> 
								<th>Date of Payment</th>
								<th>Received by</th>
								<th>Amount (in Rs.)</th>
							</tr>
						</thead>
						<tbody id="view_body_invoice">
							<tr ng-repeat="data2 in searched = (payment_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit track by (data2.invoice_number+data2.supplier_id)" title="{{data2.description}}">
								<td>{{(current_grid*10 - 9) + $index}}</td> 
								<td style="text-transform: capitalize;">{{data2.invoice_number}}</td> 
								<td style="text-transform: capitalize;">{{data2.payment_date}}</td> 
								<td style="text-transform: capitalize;">{{data2.user_name+' ('+data2.role+')'}}</td>
								<td style="text-transform: capitalize;">{{data2.amount}} </td>  
							</tr>
							<tr>
								<th colspan="4" class="text-center">TOTAL AMOUNT</th>
								<th colspan="" id="total_paid_amount"></th>
							</tr>
						</tbody>
					</table>
                </div>
            </div>
        </div>
    </div> */ ?>

</div>
<script>
function validate_pending(data){
	var total = $(".payable_amount_"+data.total_amount);
	var paid = $(".payable_amount_"+data.paid_amount);
	var pending = total-paid;
	var pay = $(this).val();
	alert(total+'-'+total+'='+pending+', Payment: '+pay);
}
</script>