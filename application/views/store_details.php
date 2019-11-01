<div class="row" ng-app="Common_app" ng-controller="Store_conroller">
	<?php
	if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN){ ?>
		<div class="col-sm-6">
			<div class="panel panel-info"  >
			     
			    <div class="panel-heading">
			        <div class="panel-title">Add Stores </div>
			    </div> 
			    <div class="panel-body">
	 				<form role="form"  method="post" class="store_details_submit" ng-submit="store_details_submit()" autocomplete="off">
					    <div class="form-group">
					        <label for="field-1" class="control-label">Store Code</label>	
					        <span class="required-field">*</span>			         
					        <input type="text" class="form-control store_code" value="<?php echo $getStoreCode; ?>" name="store_code" placeholder="Store code" readonly required> 
						</div>
						
					    <div class="form-group">
					        <label for="field-1" class="control-label">Store Name</label>	
					        <span class="required-field">*</span>			         
					        <input type="text" class="form-control store_name" name="store_name" placeholder="Store name" required> 
					        <input type="hidden" class="form-control store_id" name="store_id" value="0" required> 
					    </div>		    

					    <div class="form-group">
					        <label for="field-1" class="control-label">Location</label>	
					        <span class="required-field">*</span>			         
					        <input type="text" class="form-control store_loc" name="store_loc" placeholder="Location" required> 
					    </div>
	 
					    <div class="form-group">
					        <label for="field-1" class="control-label">Phone No</label>				         
					        <input type="number" class="form-control store_phone"  maxlength="10" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" name="store_phone" placeholder="Phone No" > 
					    </div>

					    <div class="form-group">
					        <label for="field-1" class="control-label">Email</label>	
					        <span class="required-field">*</span>			         
					        <input type="email" class="form-control store_email" onBlur="isEmail('store_email', this.value)" name="store_email" id="store_email" placeholder="Email" required> 
					    </div>

					    <div class="form-group">										
					     <div class="text-center"><button type="submit" class="btn btn-success">Submit</button></div>				         
					    </div>
					</form>
	 		    </div>
			</div>
		</div>
		<?php
	}

	if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN) { 
		echo '<div class="col-sm-6">'; 
	}
	else{
		echo '<div class="col-sm-12">';
	} ?>
		<div class="panel panel-warning"  >
		     
		    <div class="panel-heading">
		        <div class="panel-title">View Stores </div>
		    </div> 
		    <div class="panel-body">
 				<div class="row">
                    <div class="col-md-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Store Name(CODE)</th>
                                    <th>Location</th>
                                    <th>Phone</th>
									<th>MailID</th>
									<th>Status</th>
									<?php 
									if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN){ ?>
	                                    <th>Action</th>
	                                    <?php
	                                }?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (store_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                    <td>{{(current_grid*25 - 24)+ $index}}</td>
                                    
                                    <td>{{data.store_name}} ({{data.store_code}})</td>                                   
                                    <td>{{data.store_loc}} </td>
                                    <td ng-if="data.store_phone != null">{{data.store_phone}}</td>
                                     <td ng-if="data.store_phone == null">-</td>
                                    <td>{{data.store_email}}</td>
                                    <td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
                                    <td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
									
									<?php 
									//Only allowed for root_admin, super_admin, store
									if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN){ ?>
	                                    <td style="width:3cm;">
										<button type="button" class="btn btn-sm btn-primary waves-effect" ng-click="edit_store_details(data.store_id)"><i class="fa fa-pencil" aria-hidden="true"></i></button> 
											<button type="button" ng-if="data.status == 1" class="btn btn-sm btn-danger waves-effect"
	                                            ng-click="dissable_store(data.store_id, data.status)">                                            
	                                            <i class="fa fa-close pro-active" ng-if="data.status == 1" aria-hidden="true"></i>
											</button>	
											<button type="button" ng-if="data.status == 0" class="btn btn-sm btn-success waves-effect"
	                                            ng-click="dissable_store(data.store_id, data.status)">                                            
	                                            <i class="fa fa-check pro-deactive" ng-if="data.status == 0" aria-hidden="true"></i>
	                                        </button> 
										</td> <?php
									}?>
										
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" ng-show="filter_data == 0">
                        <div class="col-md-12">
                            <h4>No records found..</h4>
                        </div>
                    </div>
                  
                        
                    <div class="col-md-12"  > 
                        <div pagination="" page="current_grid" on-select-page="page_position(page)" max-size="CollegemaxSize" boundary-links="true" total-items="filter_data" items-per-page="data_limit" class="pagination-small pull-right" previous-text="&laquo;" next-text="&raquo;"></div>
                    </div>
                   
                </div>
 		    </div>
		</div>
	</div>
</div>