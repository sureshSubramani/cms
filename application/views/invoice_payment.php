<div class="row" ng-app="Common_app" ng-controller="Invoice_controller">
    <div class="col-lg-10 col-xs-offset-1">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title">Invoice and Payment Details <span class="store-code">
				<?php if($this->session->userdata('store_code')){ echo "- "; echo $this->session->userdata('store_code');} ?></div>
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
                                   	<th>S.No.</th> 
                                    <th>Invoice No.</th>
                                    <th>Invoice Date</th>
									<?php
									if($this->session->userdata('user_type')!=STORE_MANAGER){?>
										<th>Store Info.</th>
										<?php 
									}?>
                                    <th>Supplier Info.</th>
                                    <th>Total Amount (in Rs.)</th>
                                    <th>Paid Amount (in Rs.)</th>
                                    <th>Balance Amount (in Rs.)</th>
                                     <?php /* <th>Status</th> */?>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (invoice_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit" title="{{data.description}}">
                                    <td>{{(current_grid*10 - 9) + $index}}</td>
                                    <td style="text-transform: capitalize;">{{data.invoice_number}}</td>
                                    <td style="text-transform: capitalize;">{{data.invoice_date}}</td> 
									<?php
									if($this->session->userdata('user_type')!=STORE_MANAGER){?>
										<td>{{data.store_name+' ('+data.store_code+')'}}</td>
										<?php 
									}?> 
                                    <td style="text-transform: capitalize;">{{data.supplier_name}}</td>                                  
                                    <td style="text-transform: capitalize;">{{data.total_amount}} </td>                                   
                                    <td style="text-transform: capitalize;">{{data.paid_amount}} </td>                                   
                                    <td style="text-transform: capitalize;">{{data.total_amount-data.paid_amount}} </td>                                  
                                    <?php /*
									<td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
                                    <td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
									*/ ?>
                                    <td style="width:3cm;">
                                    	<?php
										if($this->session->userdata('user_type')==STORE_MANAGER){?>
											<!--If payment is pending then show payment button-->
	                                        <button type="button" ng-if="(data.total_amount-data.paid_amount)>0" class="btn btn-sm btn-info waves-effect" data-toggle="modal" data-target="#pay" ng-click="view_payment_form(data)">
	                                            <i class="fa fa-forward" aria-hidden="true"></i>
	                                        </button> 
											
											<!--If total amount is paid then show dummy button-->
											<button type="button" ng-if="(data.total_amount-data.paid_amount)<=0" class="btn btn-sm btn-default waves-effect">
	                                            <i class="fa fa-check" aria-hidden="true"></i>
	                                        </button>
	                                        <?php 
										}?> 
										
										<!--View--> 
										<button type="button" class="btn btn-sm btn-success waves-effect" data-toggle="modal" data-target="#view" ng-click="view_payment_details(data)">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
										<?php /*
                                        <button type="button" class="btn btn-sm btn-danger waves-effect" ng-if="data.status == 1"
                                            ng-click="disable_products(data.product_id, data.status)">
                                            <i class="fa fa-close pro-active" aria-hidden="true"></i>                                            
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success waves-effect" ng-if="data.status == 0"
                                            ng-click="disable_products(data.product_id, data.status)">                                            
                                            <i class="fa fa-check pro-deactive" aria-hidden="true"></i>
                                        </button> */ ?>
                                    </td>
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
							<th>Invoice Number</th>
							<td>: </td>
							<td span id="add_invoice_number"></td>
						</tr>
						<tr>
							<th>Invoice Date</th>
							<td>: </td>
							<td span id="add_invoice_date"></td>
						</tr>
						<tr>
							<th>Invoice Amount</th>
							<td>: </td>
							<td span id="add_invoice_amount"></td>
						</tr>
						<tr>
							<th>Purchased by</th>
							<td>: </td>
							<td span id="add_purchased_by"></td>
						</tr>
					</table><br>
                    <form role="form" id="payment_form" method="post" class="payment_submit" ng-submit="payment_submit()"
                        autocomplete="off">						
						<input type="hidden" class="form-control" id="payment_store_code" value="" name="store_code" readonly>
						<input type="hidden" class="form-control" id="payment_supplier_id" value="" name="supplier_id" readonly>
						<input type="hidden" class="form-control" id="payment_invoice_number" value="" name="invoice_number" readonly>
						<div class="form-group">
                            <label for="field-1" class="control-label">Payment Date</label>                            
                            <input type="text" class="form-control payment_date"  value="<?php echo date("Y-m-d"); ?>" id="payment_date" name="payment_date" placeholder="Select Date" required readonly> 
							<div class="error_amount"></div>
                        </div>
                        <div class="form-group">
                            <label for="field-2" class="control-label">Amount to Pay (in Rs.)</label>                            
                            <input type="text" class="form-control payable_amount"  value="" id="payable_amount" name="payable_amount" placeholder="Enter amount to pay" style="color: #f70303; font-weight: 800; border: 1px solid #009688;" required> 
							<div id="error_amount"></div>
                        </div>
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
						<tr>
							<th>Invoice Number</th>
							<td>: </td>
							<td span id="view_invoice_number"></td>
						</tr>
						<tr>
							<th>Invoice Date</th>
							<td>: </td>
							<td span id="view_invoice_date"></td>
						</tr>
						<tr>
							<th>Invoice Amount</th>
							<td>: </td>
							<td span id="view_invoice_amount"></td>
						</tr>
						<tr>
							<th>Purchased by</th>
							<td>: </td>
							<td span id="view_purchased_by"></td>
						</tr>
					</table><br>
					<h4 class="text-center" ng-if="0 == (payment_details)">Payment is pending!</h4>
                    <table ng-if="0 != (payment_details)" class="table table-striped table-bordered" datatable="ng">
						<thead>
							<tr>
								<th>Sl No</th> 
								 <?php /*
								<th>Store Info</th>
								<th>Supplier Info</th>
								<th>Invoice Number</th> */?>
								<th>Date of Payment</th>
								<th>Received by</th>
								<th>Amount (in Rs.)</th>
								 <?php /*<th>Status</th> */?>
							</tr>
						</thead>
						<tbody id="view_body_invoice">
							<tr ng-repeat="data in searched = (payment_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit" title="{{data.description}}">
								<td>{{(current_grid*10 - 9) + $index}}</td> 
								<?php /*
								<td>{{data.store_name+' ('+data.store_code+')'}}</td>
								<td style="text-transform: capitalize;">{{data.supplier_name}}</td>
								<td style="text-transform: capitalize;">{{data.invoice_number}}</td> */?>
								<td style="text-transform: capitalize;">{{data.payment_date}}</td> 
								<td style="text-transform: capitalize;">{{data.name+' ('+data.role+')'}}</td>
								<td style="text-transform: capitalize;">{{data.amount}} </td>                                 
								<?php /*
								<td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
								<td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
								*/ ?>
							</tr>
							<tr>
								<th colspan="3" class="text-center">TOTAL AMOUNT</th>
								<th colspan="" id="total_paid_amount"></th>
							</tr>
						</tbody>
					</table>
                </div>
            </div>
        </div>
    </div>

</div>
