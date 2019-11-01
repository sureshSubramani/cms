<div class="row" ng-app="Common_app" ng-controller="User_controller">	 
	<div class="col-sm-5">
		<div class="panel panel-info"  >
		     
		    <div class="panel-heading">
		        <div class="panel-title">Add Users </div>
		    </div> 
		    <div class="panel-body">
 				<form role="form"  method="post" name="user_form" id="user_form" class="usr_details_submit" ng-submit="usr_details_submit()" autocomplete="off">
				 	<div class="form-group">
				        <label for="field-1" class="control-label">Name of user <span class="required-field">*</span></label>				         
				        <input type="text" class="form-control name" name="name" id="name" placeholder="Enter full name" > 
				    </div>
 					<div class="form-group">
				        <label for="field-1" class="control-label">Username <span class="required-field">*</span></label>				         
						<input type="text" class="form-control usr_name" name="usr_name" id="usr_name" onBlur="validate_username('<?php echo base_url(); ?>', 'usr_name', this.value)" placeholder="Enter Username" > 
						<span style="font-weight:bold; color:#f60" id="usr_name_error"></span>
				    </div>
					<div class="form-group">
				        <label for="field-1" class="control-label">Password <span class="required-field">*</span></label>				         
				        <input type="password" class="form-control newpassword " name="new_pass" id="new_pass" placeholder="Enter password" > 
				    </div>

				    <div class="form-group">
				        <label for="field-1" class="control-label">Confirm Password <span class="required-field">*</span></label>				         
				        <input type="password" class="form-control confrimpassword" name="confirm_pass" id="confirm_pass" placeholder="Re-enter password"  > 
				    </div>

				    <div class="form-group">
				        <label for="field-1" class="control-label">User type  <span class="required-field">*</span></label>				         
				        <select class="form-control type" name="type" id="type" onchange="get_role(this.value)" >
				        	<option value="">-- Select --</option>
				        	<?php 
							foreach($user_type as $roles){ ?>
				        		<option value="<?php echo $roles['type'] ?>"><?php echo ucfirst(str_replace("_", " ", $roles['type'])) ?></option>
								<?php 
							}?>
				        </select>
				    </div>
				    <div class="form-group">
				        <label for="field-1" class="control-label">Role <span class="required-field">*</span></label>				         
				        <select class="form-control role" name="role" id="role" >
							<option value="">-- Select --</option>
				        </select>
				    </div>		
				    <div class="form-group">
				        <label for="access_type" class="control-label">Access type <span class="required-field">*</span></label> <br>			         
				        <input type="checkbox" name="access_type[]" class="access_type" id="access_type1" style="vertical-align:bottom;" value="canteen" checked> Canteen <br> 
				        <input type="checkbox" name="access_type[]" class="access_type" id="access_type2" style="vertical-align:bottom;" value="locker"> Locker <br> 
				        <input type="checkbox" name="access_type[]" class="access_type" id="access_type3" style="vertical-align:bottom;" value="theme_park"> Theme Park <br>
				    </div>
		 
					<div class="form-group form-error text-center ">
						<?php
						//Error Message
						if($this->session->userdata('user_create_error')){
							echo '<div style="color: #e60b0b">'.$this->session->userdata('user_create_error').'</div>';
							$this->session->unset_userdata('user_create_error');
						}  
						//Success Message
						if($this->session->userdata('user_create_success')){
							echo '<div style="color: #0be63a">'.$this->session->userdata('user_create_success').'</div>';
							$this->session->unset_userdata('user_create_success');
						} 
						//Warning Message	
						if($this->session->userdata('user_create_warning')){
							echo '<div style="color: #e67a0b">'.$this->session->userdata('user_create_warning').'</div>';
							$this->session->unset_userdata('user_create_warning');
						}  ?>
					</div>
				    <div class="form-group">	
				    	<input type="hidden" name="form_type" id="form_type" value="add">
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">   			         
				        <center><button type="submit" class="btn btn-success">Submit</button></center>			         
				    </div>
				</form>
 		    </div>
		</div>
	</div>

	<div class="col-sm-7">
		<div class="panel panel-warning"  >
		     
		    <div class="panel-heading">
		        <div class="panel-title">View Users</div>
		    </div> 
		    <div class="panel-body">
 				<div class="row">
                    <div class="col-md-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name of user</th>                                   
                                    <th>User type</th>  
                                    <th>Role</th>  
                                    <th>Username</th>                                
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (usr_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                    <td>{{(current_grid*25 - 24)+ $index}}</td>                                    
									<td style="text-transform: capitalize">{{data.name}}</td>
                                    <td>{{data.user_type}}</td>
									<td>{{data.role}}</td>
									<td>{{data.user_name}}</td>                                     
                                    <td style="width: 3cm;">
                                        <button type="button" class="btn btn-sm btn-orange waves-effect" title="Remove {{data.name}}"  ng-click="delete_usr_details(data.user_id)"><i class="fa fa-remove" aria-hidden="true"></i></button>
										<?php /* <button type="button" class="btn btn-sm btn-warning waves-effect" style=""  ng-click="enable_usr_details(data.user_id)"><i class="fa fa-trash" aria-hidden="true"></i></button> */ ?>
                                    </td>
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
<script>
function get_role(type){
	if(type){
		$.ajax({
			type: 'post',
			url: "<?php echo base_url('User_details/getRole') ?>",
			data: 'type='+type,
			beforeSend: function(){
				$("#role").html("<option value=''> Loading... </option>");
			},
			success:function(resp){
				$("#role").html(resp);
			}
		});
	}
}
</script>