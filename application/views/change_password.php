<div class="row" ng-app="Common_app" ng-controller="Change_password_controller">
    <div class="col-lg-8 col-xs-offset-2">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="text-center">Password Change Form</h4>
                </div>
                <div class="panel-body">
                    <form>
                        <!-- <div class="errors">
                            <?php //echo validation_errors('<div class="error">', '</div>'); ?>
                        </div> -->
                        <div class="alert alert-danger print-error-msg" style="display:none"></div>
                        <div class="form-group col-lg-4">
                            <label for="email">Old Password</label>
                            <input type="password" class="form-control" id="old_pwd" name="old_pwd" ng-model="old_pwd"
                                ng-keyup="checkPassword()" placeholder="Old Password" required>
                            <div ng-class="addClass(passwordstatus)">{{ passwordstatus }}</div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="pwd">New Password:</label>                           
                            <input type="password" class="form-control" id="new_pwd" name="new_pwd" ng-model="new_pwd" placeholder="New password" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="rpwd">Retype New Password:</label>                            
                            <input type="password" class="form-control" id="rpwd" name="rpwd" ng-model="rpwd" placeholder="Re-type new password" required>
                        </div>
                        <div class="form-group text-center col-lg-4">
                            <input type="submit" value='Change Password' class="btn btn-info btn-submit" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php print_r($this->session->userdata()); ?>

<script>

	$(document).ready(function() {
	    $(".btn-submit").click(function(e){
            e.preventDefault();
            
	    	var old_password = $("input[name='old_pwd']").val();
	    	var new_pwd = $("input[name='new_pwd']").val();
	    	var rpwd = $("input[name='rpwd']").val();

            $.ajax({
	            url: "/Change_Password/changePassword/",
	            type:'POST',
	            dataType: "json",
	            data: {old_pwd:old_pwd, new_pwd:new_pwd, rpwd:rpwd},
	            success: function(data) {
	                if($.isEmptyObject(data.error)){
	                	$(".print-error-msg").css('display','none');
	                	alert(data.success);
	                }else{
						$(".print-error-msg").css('display','block');
	                	$(".print-error-msg").html(data.error);
	                }
	            }
	        });


	    }); 


	});


</script>