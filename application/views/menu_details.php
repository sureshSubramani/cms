<div class="row" ng-app="Common_app" ng-controller="Menu_controller">

<div id="add-menu" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Menu</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <form method="post" action="" id="myform" ng-cloak>
                       <div class="form-group required">
                            <label for="menu_type">Menu Type</label>
                            <div class="form-line" id="menu_type_div">
                                <select class="form-control" name="menu_type"
                                    onChange="show_hide_parent_add('<?php echo base_url(); ?>', this.value)" id="menu_type"
                                    required>                                    
                                    <option value="0">Main menu</option>
                                    <option value="1">Sub menu</option>
                                    <option value="2">Inner sub menu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group required" id="parent_id_div" style="display:none">
                            <label for="parent_id">Parent menu</label>
                            <div class="form-line">
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="">-- Select a parent --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group required" id="menu_name_div">
                            <label for="menu_name">Menu name</label>
                            <div class="form-line">
                                <input type="text" value="" id="menu_name" name="menu_name"
                                    class="form-control" placeholder="Enter name of the menu" onblur="validate_menu('<?php echo base_url(); ?>', 'menu_name', this.value)" required>
                                <span style="font-weight:bold; color:#f60" id="menu_name_error"></span>
                            </div>
                        </div>
                        <div class="form-group required" id="order_no_div">
                            <label for="order_no">Orderno</label>
                            <div class="form-line">
                                <input type="text" value="" id="order_no"
                                    name="order_no" class="form-control" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" placeholder="Enter order no" required>
                            </div>
                        </div>
                        <div class="form-group" id="menu_icon_div">
                            <label for="password">Menu Icon</label>
                            <div class="form-line">
                                <input type="text" value="" name="menu_icon"
                                    class="form-control" placeholder="Enter Menu Icon">
                            </div>
                        </div>
                        <div class="form-group" id="menu_url_div">
                            <label for="password">Url</label>
                            <div class="form-line">
                                <input type="text" value="" name="menu_url"
                                    class="form-control" placeholder="Enter Url">
                            </div>
                        </div>
						<input type="hidden" name="action" value="add">
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                    </form>

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Modal -->
    <div id="edit-menu" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Menu</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <form method="post" action="" ng-cloak>
                            
							<div class="form-group required" id="edit_menu_type_div">
                                <label for="menu_type">Menu Type</label>
                                <div class="form-line">
                                    <select class="form-control menu_type" name="menu_type" onChange="show_hide_parent_edit(this.value)"
                                        id="menu_type" required>
                                        <option value="">-- Select --</option>
                                        <option value="0">Main menu</option>
                                        <option value="1">Sub menu</option>
                                        <option value="2">Inner sub menu</option>
                                    </select>
                                </div>
                            </div> 							
                            <div class="form-group required" id="edit_parent_id_div">
                                <label for="parent_id">Parent menu</label>
                                <div class="form-line">
                                    <select class="form-control edit_parent_id" name="parent_id" id="edit_parent_id" >
                                        <option value="">-- Select a parent --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required" id="edit_menu_name_div">
                                <label for="menu_name">Menu name</label>
                                <div class="form-line">
                                    <input type="text" value="{{menu_details.menu_name}}" id="edit_menu_name"
                                        name="menu_name" class="form-control" placeholder="Enter name of menu" required>
                                </div>
                            </div>
                            <div class="form-group required" id="edit_menu_id_div">
                                <label for="order_no">Orderno</label>
                                <div class="form-line">
                                    <input type="hidden" value="{{menu_details.menu_id}}" name="menu_id"
                                        class="form-control" placeholder="Enter order no" required>
                                    <input type="text" value="{{menu_details.order_no}}" id="edit_order_no"
                                        name="order_no" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" class="form-control" placeholder="Enter order no" required>
                                </div>
                            </div>
                            <div class="form-group" id="edit_menu_icon_div">
                                <label for="menu_icon">Menu Icon</label>
                                <div class="form-line">
                                    <input type="text" value="{{menu_details.menu_icon}}" id="edit_menu_icon" name="menu_icon"
                                        class="form-control" placeholder="Enter Menu Icon">
                                </div>
                            </div>
                            <div class="form-group" id="edit_menu_url_div">
                                <label for="menu_url">Url</label>
                                <div class="form-line">
                                    <input type="text" value="{{menu_details.menu_url}}" id="edit_menu_url" name="menu_url"
                                        class="form-control" placeholder="Enter Url">
                                </div>
                            </div>
							<input type="hidden" name="action" value="edit">
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">submit</button>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8 col-md-8 col-lg-8 col-xs-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="panel-title">View Menu Details</div>
                </div>
                <div class="panel-body">                   
                    <div class="row">
                        <div class="col-lg-12" ng-show="filter_data > 0">
                            <?php
                            //print_r($get_all_menus);
                            if($this->session->userdata('user_type')==ROOT_ADMIN){?>
                                <div class="mentu-bottom" style="margin-bottom: 10px;text-align: right;">
                                    <input type="reset" class="btn btn-primary btn-md" data-toggle="modal" data-target="#add-menu" value="Add New" onclick="document.getElementById('myform').reset();" >
                                </div>
                                <?php
                            }?>
                            <table class="table table-bordered responsive">
                                <thead>
                                    <tr>
                                        <th style="width:50px">Sl No</th>
                                        <th style="width:40px">Icon</th>
                                        <th>Menu Name</th>
                                        <th>Url</th>
                                        <!--<th>Order No</th>-->
                                        <th>Status</th>
                                        <th style="width: 5cm;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									
                                    <tr ng-cloak ng-repeat="data in searched = (menu_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                        <td style="text-align:center">{{(current_grid*10 - 9) + $index}}</td>
                                        <td style="text-align:center"><i class="{{data.menu_icon}}"></i></td>
                                        <td>{{data.menu_name}}</td>
                                        <td>{{data.menu_url}}</td>
                                        <!--<td>{{data.order_no}}</td>-->
                                        <td >
                                            <span ng-if="data.status == 1" class="label label-success">Active</span>
                                            <span ng-if="data.status != 1" class="label label-danger">De-active</span>
                                        </td>
                                        <td style="">
                                            <button type="button" class="btn btn-sm btn-info waves-effect"
                                                data-toggle="modal" data-target="#edit-menu"
                                                ng-click="edit_menu_details(data.menu_id, 1)"><i class="fa fa-pencil"
                                                    aria-hidden="true"></i></button>
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
                                items-per-page="data_limit" class="pagination-small pull-right" previous-text="&laquo;"
                                next-text="&raquo;"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>