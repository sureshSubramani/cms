<div class="row" ng-app="Common_app" ng-controller="stock_sales_controller">
    <div class="col-lg-10 col-xs-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">
					Stock of Sales Products
				</div>
            </div>
            <div class="panel-body">
                <div class="row">				
                    <div class="menu-bottom input-group pull-right col-lg-4">
						<input class="form-control search" ng-model="search" placeholder="Search" type="search" /> 
						<span class="btn btn-primary input-group-addon">
							<span class="glyphicon glyphicon-search"></span>
						</span>
					</div>
                   
                    <div class="col-lg-12"><!--ng-show="filter_data1 > 0"-->
                        <table class="table table-striped table-bordered" datatable="ng">                        
                            <thead>
                                <tr>
									<th>S.No.</th> 									                                  
                                    <th>Product Name</th>                                  
                                    <th>Quantity <i class="fa fa-info icon-shape" title="Available Stock" data-toggle="tooltip"></i></th>
                                    <th>Veiw</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr ng-repeat="d in searched = (stock_of_sales | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit"> -->
                                <tr ng-repeat="data in stock_of_sales | custom:search" ng-class="{'disable':data.status==0}">
                                    <td>{{(current_grid*10 - 9) + $index}}</td>  									
                                    <td>{{data.sales_product_name}}</td> 
                                    <td>{{data.available_qty}}</td> 
                                    <td>
                                        <!-- <span class="btn btn-xs btn-info" data-toggle="modal" data-target="#view" ng-click="salesProductInfo(data.sales_product_id)"><i class='fa fa-eye'></i></span> -->
                                        <span type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#view{{data.sales_product_id}}" style="z-index: 100">
                                        <i class='fa fa-eye'></i></span>
                                          <!-- Modal -->
                                        <div id="view{{data.sales_product_id}}" class="modal modal{{data.sales_product_id}} fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="col-sm-12 modal-content">
                                                    <div class="modal-header">                                                        
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>                                                    
                                                        <h4 class="modal-title">
                                                            Incredients
                                                            <span ng-if="data.sales_product_name!=''"> for {{data.sales_product_name}}</span>
                                                            <span ng-if="data.sales_product_type!=''"> - {{data.sales_product_type}}</span>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped table-bordered incredients-tbl">
                                                            <tr>
                                                                <th style="padding: 7px !important;">Product</th>
                                                                <th style="padding: 7px !important;">Stock of Qty</th>
                                                                <th style="padding: 7px !important;">Required Qty</th>
                                                                <th style="padding: 7px !important;">No.of possible</th>
                                                            </tr>
                                                            <tr ng-repeat="data2 in data.incredients ">
                                                                <th class="">{{data2.product_name}}</th>
                                                                <td class="">
                                                                    <span ng-if="data2.stock_qty">{{data2.stock_qty}} </span>
                                                                    <span ng-if="data2.stock_qty" class="text-lowercase">{{data2.uom}}</span>
                                                                </td>
                                                                <td class="">
                                                                    
                                                                    <span ng-if="data2.incredient_qty" class="text-lowercase">
                                                                        <span ng-if="(data2.uom=='KG' || data2.uom=='kg') && data2.incredient_qty!='' && data2.incredient_qty<1">{{data2.incredient_qty * 1000}} g</span> 
                                                                        <span ng-if="(data2.uom=='L' || data2.uom=='l') && data2.incredient_qty!='' && data2.incredient_qty<1">{{data2.incredient_qty * 1000}} ml</span> 
                                                                        </span><span ng-if="data2.uom=='NOs' || data2.uom=='nos' || data2.incredient_qty>=1">{{data2.incredient_qty }} {{data2.uom}}</span>
                                                                        <!--<span ng-if="">{{data.incredient_qty * 1000}} {{data.uom}}</span>     -->
                                                                    </span>
                                                                </td>
                                                                <td class="">
                                                                    <span style="">{{data2.available_qty}}</span>
                                                                    <span style="font-size: 11px; color: #bbb; " ng-if="data2.available_qty && data.sales_product_name!=''"> {{data.sales_product_name}}</span>
                                                                    <span style="font-size: 11px; color: #bbb; " ng-if="data2.available_qty && data.sales_product_type!=''"> - {{data.sales_product_type}}</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                    <div class="col-md-12" ng-show="stock_of_sales == ''">
                        <div class="col-md-12">
                            <h4 class="is-not-serach">No records found..</h4>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div pagination="" page="current_grid" on-select-page="page_position(page)"
                            max-size="CollegemaxSize" boundary-links="true" total-items="filter_data"
                            items-per-page="data_limit" class="pagination-small pull-right" previous-text="&laquo;"
                            next-text="&raquo;"></div>
                    </div>
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
                        <h4 class="modal-title"></h4>
                    </div>
                <div class="modal-body">
                <div ng-repeat="pro in salesStock">
                 <h6> Product Id:{{pro.sales_product_id}} <h6>
                 <h6> Quantity:{{pro.quantity}} <h6>
                 </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

        </div>
    </div>

</div>