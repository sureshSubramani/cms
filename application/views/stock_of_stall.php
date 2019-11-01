<div class="row" ng-app="Common_app" ng-controller="Stock_of_stall_controller">
    <div class="col-lg-10 col-xs-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">
					Product Stock of Stalls
				</div>
            </div>
            <div class="panel-body">
                <div class="row">   
					<?php /*
                    <div class="col-lg-4 mentu-bottom">
						  <select class="form-control category_id" onChange="window.location='<?php echo base_url(); ?>stock_of_store?store='+this.value" name="store_code" required>
							<option value="">Select</option>
							<?php 							
							foreach($stores as $kStore=>$vStore){ 
								if($vStore['status']){
									$selected = "";
									if($this->session->userdata('store_code'))
										$selected = ($this->session->userdata('store_code')==$vStore['store_code'])?"selected":""; 
									else if($this->input->get_post('store'))
										$selected = ($this->input->get_post('store')==$vStore['store_code'])?"selected":""; ?>
									
									<option value="<?php echo $vStore['store_code'];?>" <?php echo $selected; ?>>
										<?php echo $vStore['store_code'].' - '.$vStore['store_name']; ?>
									</option>
									<?php
								} 
							}?>
						</select>                        
                    </div>  */?>
                    <div class="menu-bottom input-group pull-right col-lg-4">
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
									<?php
									if(!$this->session->userdata('store_code')){
										echo '<th>Store Details</th>';
									}
									if(!$this->session->userdata('stall_code')){
										echo '<th>Stall Details</th>';
									} ?>
                                    <th>Product Info.</th>  
                                    <th>Product Code</th>                                  
                                    <th>Quantity <i class="fa fa-info icon-shape" title="Available Stock" data-toggle="tooltip"></i></th>
                                    <th>UOM <i class="fa fa-info icon-shape" title="Unit of Measurement" data-toggle="tooltip"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (stock_of_stall | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit" ng-class="{'disable':data.status==0}">
                                    <td>{{(current_grid*10 - 9) + $index}}</td>  
									<?php
									if(!$this->session->userdata('store_code')){ ?>									
										<td>{{data.store_name+' ('+data.store_code+')'}}</td>                              
										<?php 
									} 
									if(!$this->session->userdata('stall_code')){ ?>									
										<td>{{data.stall_name+' ('+data.stall_code+')'}}</td>                              
										<?php 
									} ?> 
                                    <td>
                                        <span ng-if="data.product_name!=''">{{data.product_name}} </span>
                                        <span ng-if="data.brand_name!=''">{{data.brand_name}} </span>
                                        <span ng-if="data.product_type!=''">{{data.product_type}} </span>
                                    </td>
                                    <td>{{data.product_code}} </td> 
                                     <td >
										<span ng-if="data.quantity<=0">0</span> 
										<span ng-if="data.quantity>0" >{{data.quantity}}
									</td>  
                                    <td><span style="text-transform: lowercase;">{{data.uom}}</span></td>  
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
                            items-per-page="data_limit" class="pagination-small pull-right" previous-text="&laquo;"
                            next-text="&raquo;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>