<div class="row" ng-app="Common_app" ng-controller="Stall_conroller">
    <?php
    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN || $this->session->userdata('user_type') == STORE_MANAGER){ ?>
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Add Stall </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger alert-dismissible" style="display:none">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                    <form role="form" method="post" class="stall_details_submit" ng-submit="stall_details_submit()" autocomplete="off" >
                        <p ng-model="message"></p>
                        <div class="form-group">
                            <label for="category_id" class="control-label">Store Code</label>
                            <!-- <p class="hide_code"></p> -->
                            <span class="required-field">*</span>   
                            <select class="form-control store_code" name="store_code" ng-model="store_code" ng-change="getStallCode(store_code)" required>
                                <option value="">----- Select -----</option>
                                <?php foreach($store_details as $store){ 
                                        if($store['status']==1){?>
                                        <option value="<?php echo $store['store_code']; ?>">
                                            <?php echo $store['store_name'].' ('.$store['store_code'].')'; ?>
                                        </option>
                                        <?php
                                        } 
                                    }?>
                            </select>
                          <!-- <span class="error" ng-show="myForm.$dirty && myForm.store_code.$error.required"> Store code required! </span> -->
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="control-label">Stall code</label>
                            <span class="required-field">*</span>   
                            <input type="hidden" class="form-control stall_id" name="stall_id" value="0" readonly required> 
                            <input type="text" class="form-control stall_code" name="stall_code"  placeholder="Stall code" readonly  required>                        
                           <!--  <span class="error" ng-show="myForm.$dirty && myForm.stall_code.$error.required"> Stall code required! </span> -->
                        </div>                  

                        <div class="form-group">
                            <label for="field-1" class="control-label">Stallname</label>
                            <span class="required-field">*</span>   
                            <input type="text" class="form-control stall_name" name="stall_name"  placeholder="Stallname"
                                required>                        
                            <!-- <span class="error" ng-show="myForm.$dirty && myForm.stall_name.$error.required"> Stall name required! </span> -->
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="control-label">Phone No</label>
                            <span class="required-field">*</span>   
                            <input type="text" class="form-control stall_phone" name="stall_phone"  maxlength="10" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"  placeholder="Phone No"
                                required/>
                                <!-- <span class="error" ng-show="myForm.$dirty && myForm.stall_phone.$error.required"> Stall phone required! </span> -->
                        </div>
                        <div class="form-group">
                            <div class="text-center"><button type="submit" class="btn btn-success btn-submit" id="btn-submit">Submit</button></div>
                        </div>
                    </form>
                    <div class="ajax_success"></div>
                </div>
            </div>
        </div>
        <?php
    }

    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN || $this->session->userdata('user_type') == STORE_MANAGER) { 
        echo '<div class="col-sm-6">'; 
    }
    else{
        echo '<div class="col-sm-12">';
    } ?>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-title">View Stall </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No</th>

                                    <th>Store Name(CODE)</th>
                                    <th>Stall Name(CODE)</th>                                   
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <?php 
                                    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN  || $this->session->userdata('user_type') == STORE_MANAGER){ ?>
                                        <th>Action</th>
                                        <?php
                                    }?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    ng-repeat="data in searched = (stall_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                    <td>{{(current_grid*25 - 24) + $index}}</td>

                                    <td>{{data.store_name}} ({{data.store_code}})</td>
                                    <td>{{data.stall_name}} ({{data.stall_code}})</td>
                                    <td ng-if="data.stall_phone != ''">{{data.stall_phone}}</td>
                                    <td ng-if="data.stall_phone == ''">-</td>
                                    <td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
                                    <td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
                                    <?php 
                                    //Only allowed for root_admin, super_admin, store
                                    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN || $this->session->userdata('user_type') == STORE_MANAGER){ ?>
                                        <td style="width:3cm;">
                                            <button type="button" class="btn btn-primary waves-effect"
                                                ng-click="edit_stall_details(data.stall_id)" title="Edit">
                                                <i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            
                                            <button type="button" ng-if="data.status == 1" class="btn btn-sm btn-danger waves-effect"
                                                ng-click="dissable_stall(data.stall_id, data.status)">                                            
                                                <i class="fa fa-close pro-active" ng-if="data.status == 1" aria-hidden="true"></i>
    										</button>	
    										<button type="button" ng-if="data.status == 0" class="btn btn-sm btn-success waves-effect"
                                                ng-click="dissable_stall(data.stall_id, data.status)">                                            
                                                <i class="fa fa-check pro-deactive" ng-if="data.status == 0" aria-hidden="true"></i>
                                            </button>
                                           
                                        </td><?php
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

<script type="text/javascript">
/*$(document).ready(function() {
    var $validator = $(".btn-submit").validate({
        rules: {
            store_code: {
                required: true               
            },
            stall_code: {
                required: true,
                minlength: 3,
                maxlength: 25
            },
            stall_name: {
                required: true,
                email: true,
                minlength: 3,
                maxlength: 100,
                regex: /^[A-Za-z0-9_]+\@[A-Za-z0-9_]+\.[A-Za-z0-9_]+/
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 12,
                number: true
            }
        },
        messages: {
            email: {
                required: "Please enter valid Email Address"
            },
            mobile: {
                required: "Please provide valid Phone or Mobile number!"
            }
        }
    });
    jQuery.validator.addMethod("regex", function(value, element, regexp) {
        if (regexp.constructor != RegExp)
            regexp = new RegExp(regexp);
        else if (regexp.global)
            regexp.lastIndex = 0;
        return this.optional(element) || regexp.test(value);
    }, "Please provide valid email address.");

    $('#btn-submit').click(function(e) {
        e.preventDefault();

        var $valid = $("#myForm").valid();
        if (!$valid) {
            $validator.focusInvalid();
            return false;
        } else {
            var url = '<?php echo base_url('Stall_details/') ?>';
            var data = $("#myForm").serialize();
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    console.log(data);
                },

                success: function(returnData) {
                    if (returnData.status) {
                        $('.ajax_success').html('Stall added into database Successfully..!');
                    }
                }
            });
        }
    });
});
$(document).ready(function() {

    $(".stall_details_submit").click(function(e) {

        e.preventDefault();

        // var store_code = $("select[name='store_code']").val();

        // var stall_code = $("input[name='stall_code']").val();

        // var stall_name = $("input[name='stall_name']").val();

        // var phone = $("input[name='phone']").val();

        $.ajax({

            url: '<?php echo base_url('Stall_details/Get_Stalls') ?>',

            type: $(this).closest('form').attr('method'),

            dataType: "json",

            data: $('form[name="myForm"]').serialize(),
            // {
            //     store_code: store_code,
            //     stall_code: stall_code,
            //     stall_name: stall_name,
            //     phone: phone
            // },

            success: function(data) {

                if ($.isEmptyObject(data.error)) {

                    $(".alert-danger").css('display', 'none');

                    alert(data.success);

                } else {

                    $(".alert-danger").css('display', 'block');

                    $(".alert-danger").html(data.error);

                }

            }

        });

    });

});*/
</script>
