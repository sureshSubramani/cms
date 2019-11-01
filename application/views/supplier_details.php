<div class="row" ng-app="Common_app" ng-controller="SupplierDetails">
    <?php
    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN){ ?>
        <div class="col-sm-6">
            <div class="panel panel-info">

                <div class="panel-heading">
                    <div class="panel-title">Add Supplier </div>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" class="supplier_details_submit" ng-submit="supplier_details_submit()"
                        autocomplete="off">

                        <div class="form-group">
                            <label for="field-1" class="control-label">Supplier Name : </label>
                            <input type="hidden" class="form-control supplier_id" name="supplier_id" value="0" readonly required>                        
                            <input type="text" class="form-control edit_form supplier_name" name="supplier_name"
                                placeholder="Enter Supplier Name" ng-keyup="validate_supplier_name()" required/>

                                <span style="font-weight:bold; color:#f60" id="supplier_name_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="control-label">Mobile : </label>
                            <input type="text" class="form-control edit_form supplier_mobile" maxlength="10" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" name="supplier_mobile"
                                placeholder="Enter 10 digits Mobile Number" required/>

                        </div>

                        <div class="form-group">
                            <label for="field-1" class="control-label">Address</label>
                            <input type="text" class="form-control edit_form supplier_address" name="supplier_address"
                                placeholder="Enter Addresss" required/>

                        </div>

                        <div class="form-group">
                            <label for="field-1" class="control-label">City </label>
                            <input type="text" class="form-control edit_form supplier_city" name="supplier_city"
                                placeholder="Enter City" required/>

                        </div>

                        <div class="form-group">
                            <label for="field-1" class="control-label">GST No </label>
                            <input type="text" class="form-control edit_form supplier_gst" name="supplier_gst"
                                placeholder="Enter GST Number" required/>

                        </div>

                        <div class="form-group">
                            <label for="field-1" class="control-label">Status </label>
                            <select class="form-control status" name="status" required>
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <div class="test-cenetr"><button type="submit" class="btn btn-success">Submit</button></div>
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
        <div class="panel panel-warning">

            <div class="panel-heading">
                <div class="panel-title">View Supplier</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Supplier Name</th>
                                    <th>Mobile No</th>
                                    <th>GSTN</th>
                                    <th>Place</th>
                                    <th>Status</th>
                                    <?php 
                                    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN ){ ?>
                                        <th>Action</th>
                                        <?php
                                    }?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (Common_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                    <td>{{(current_grid*10 - 9)+ $index}}</td>
                                    <td>{{data.supplier_name}}</td>
                                    <td>{{data.supplier_mobile}}</td>
                                    <td>{{data.supplier_gst}}</td>
                                    <td>{{data.supplier_city}} </td>
                                    <td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
                                    <td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
                                    <?php 
                                    //Only allowed for root_admin, super_admin, store
                                    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN ){ ?>
                                        <td style="width:3cm;">
                                            <button type="button" class="btn btn-primary waves-effect" ng-click="edit_supplier_details(data.supplier_id)" title="Edit Supplier">
                                                <i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            
                                             <button type="button" class="btn btn-sm btn-danger waves-effect" ng-if="data.status==1" ng-click="Disable_supplier(data.supplier_id, data.status)">
    										    <i class="fa fa-close pro-active" ng-if="data.status==1" aria-hidden="true"></i>                                            
    										 </button>
                                             <button type="button" class="btn btn-sm btn-success waves-effect" ng-if="data.status==0" ng-click="Disable_supplier(data.supplier_id, data.status)">										    
                                                <i class="fa fa-check pro-deactive" ng-if="data.status==0" aria-hidden="true"></i>
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