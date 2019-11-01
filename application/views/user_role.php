<div class="row" ng-app="Common_app" ng-controller="Menu_controller">

    


    <div class="col-sm-12">
      
        <div class="col-sm-4">
            <div class="panel panel-info">

                <div class="panel-heading">
                    <div class="panel-title">Add Role</div>
                </div>
                <div class="panel-body">
                    <form method="post" action="" ng-cloak>
                        <div class="form-group">
                            <label for="field-1" class="control-label">User type</label>				         
                            <select class="form-control" name="type"  onChange="validateAddRole('<?php echo base_url(); ?>')" id="type" required>
                                <option value="">-- Select a type --</option>
                                <?php 
                                if(isset($user_type) && !empty($user_type)){
                                    foreach($user_type as $roles){ ?>
                                        <option value="<?php echo $roles['type'] ?>"><?php echo ucfirst(str_replace("_", " ", $roles['type'])) ?></option>
                                        <?php 
                                    }
                                }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <div class="form-line">
                                <input type="text" name="role" id="role" onBlur="validateAddRole('<?php echo base_url(); ?>')" class="form-control" placeholder="Enter Role" value="" required>
                                <span style="font-weight:bold; color:#f60" id="role_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <div class="form-line">
                                <textarea name="description" class="form-control" placeholder="Enter description" ></textarea>
                            </div>
                        </div>
                        <h5 id="errorAddingRole"></h5>    
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">submit</button>
                    </form>
                </div>
            </div>
        </div> 

        <div class="col-sm-4">
            <div class="panel panel-info">

                <div class="panel-heading">
                    <div class="panel-title">View Role and Type</div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered responsive">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Role</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i=1; foreach($get_Roles as $roles){ ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="opacity:<?php echo ($roles['status']==0)?'.4':''; ?>"><?php echo ucfirst($roles['role']); ?></td>
                                <td style="opacity:<?php echo ($roles['status']==0)?'.4':''; ?>"><?php echo ucfirst(str_replace("_"," ", $roles['type'])); ?></td>
                                <td>
                                    <?php
                                    if($roles['type']!=ROOT_ADMIN && $roles['type']!=SUPER_ADMIN ){
                                        if($roles['status']==1){
                                            echo '<a href="'.base_url().'user_role/remove_role/?id='.$roles['user_type_id'].'" title="Click to Disable" class="btn btn-sm btn-orange waves-effect " >
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>';
                                        }
                                        else{
                                            echo '<a href="'.base_url().'user_role/enable_role/?id='.$roles['user_type_id'].'" title="Click to Enable" class="btn btn-sm btn-success waves-effect " >
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </a>';
                                        } 
                                    }
                                    else{
                                        echo '<a href="javascript:;" title="" class="btn btn-sm btn-default waves-effect " >
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </a>';
                                    }?>

                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade in" id="View_submenus" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">View Submenus</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th>Orderno</th>
                                <th>Icon</th>
                                <th>Menuname</th>
                                <th>Url</th>
                                <th>Action </th>
                            </tr>
                        </thead>

                        <tr ng-cloak ng-repeat="data in Submenu_details">

                            <td>{{data.order_no}}</td>
                            <td><i class="{{data.menu_icon}}"></i></td>
                            <td>{{data.menu_name}}</td>
                            <td>{{data.menu_url}}</td>

                            <td style="    width: 3cm;">

                                <button type="button" class="btn btn-danger waves-effect   "
                                    ng-click="delete_Submenu_details(data.menu_id,1)"><i class="fa fa-trash"
                                        aria-hidden="true"></i></button>

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

                </div>


            </div>
        </div>
    </div>

    <form method="post" action="">
        <div class="modal fade in" id="add_view_menus" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">


                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Menu Preference</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderd1">
                            <tbody>


                                
                                <?php 
                               /* echo "<pre>";
                                print_r($get_all_menus); 
                                echo "</pre>";*/
                                if(count($get_all_menus) != 0){ 
                                    $k=0;  
                                    $j=0;  
                                    $i=0; 
                                    foreach ($get_all_menus as $key => $main_menu) { //print_r($main_menu); ?>
                                        <tr>
                                            <td style="border-top: none;">
                                                <div class="form-group" style="margin:0 ">
                                                    <input type="hidden" class="preference_id" name="preference_id">
                                                    <input onclick="checked_menus(<?php echo $main_menu['menu_id']; ?>)" class="common_all main_menu_all_<?php echo $main_menu['menu_id']; ?>" type="checkbox" id="remember_me_<?php echo $i; ?>" name="main_menus[]" value="<?php echo $main_menu['menu_id']; ?>" class="filled-in">
                                                    
                                                    <label for="remember_me_<?php echo $i; ?>" style="margin:0 "><?php echo $main_menu['menu_name']; ?></label>
                                                </div>
                                           
                                                <?php 
                                                if(count($main_menu['sub_menus']) != 0){  
                                                    foreach ($main_menu['sub_menus'] as $key => $sub_menus) {   ?>
                                                        <div class="form-group" style="margin:0 0 0 10px;border-left: 1px solid #59bae259; padding: 0 0 0 15px;" onclick="check_sub_menus(<?php echo $main_menu['menu_id']; ?>)">

                                                            <input class="common_all sub_menus_all sub_menus_all<?php echo $main_menu['menu_id']; ?> select_sub_menus_all<?php echo $sub_menus['menu_id']; ?>"   type="checkbox" id="remember_me_<?php echo $j; ?>" name="sub_menus_<?php echo $main_menu['menu_id']; ?>[]" value="<?php echo $sub_menus['menu_id']; ?>" class="filled-in">
                                                            
                                                            <label for="remember_me_<?php echo $j; ?>" style="margin:0 "><?php echo $sub_menus['menu_name']; ?></label>
                                                        </div>
                                                        <?php 
                                                        if(isset($main_menu['sub_menus'][$j]['inner_sub_menus']) && count($main_menu['sub_menus'][$j]['inner_sub_menus']) != 0){  
                                                            foreach ($main_menu['sub_menus'][$j]['inner_sub_menus'] as $key => $inner_sub_menus) {   ?>

                                                                <div class="form-group"  style="margin:0 0 0 35px; border-left: 1px solid #59bae259; padding: 0 0 0 15px;" onclick="check_inner_sub_menus(<?php echo $main_menu['menu_id']; ?>)">

                                                                    <input class="common_all inner_sub_menus_all inner_sub_menus_all<?php echo $main_menu['menu_id']; ?> select_inner_sub_menus_all<?php echo $inner_sub_menus['menu_id']; ?>" type="checkbox" id="remember_me_<?php echo $j; ?>" name="inner_sub_menus_<?php echo $main_menu['menu_id']; ?>[]" value="<?php echo $inner_sub_menus['menu_id']; ?>" class="filled-in">
                                                                    
                                                                    <label for="remember_me_<?php echo $j; ?>" style="margin:0 "><?php echo $inner_sub_menus['menu_name']; ?></label>
                                                                </div>

                                                                <?php 
                                                                $j++; 
                                                            } 
                                                        }
                                                        $j++; 
                                                    } 
                                                } ?>
                                            </td>
                                        </tr>
                                        <?php 
                                        $i++; 
                                    }  
                                } ?>

                            </tbody>
                        </table>




                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning waves-effect">Submit</button>

                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

                    </div>


                </div>
            </div>
        </div>
    </form>

    <form method="post" action="">
        <div class="modal fade in AddSubMenuModal" id="AddSubMenuModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">


                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Add submenus</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row clearfix">

                            <div id="submenu_fields">

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" class="form-control menu_id_add" placeholder="Order No"
                                                name="main_menu_id">
                                            <input type="number" class="form-control" placeholder="Order No"
                                                name="sub_order_no[]" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Icon"
                                                name="sub_menu_icon[]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Menu Name"
                                                name="sub_menu_name[]" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="URL"
                                                name="sub_menu_url[]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success  " style="margin-left: 10px;"
                            onclick="add_Submenu_details()"><i class="fa fa-plus"></i></button>
                        <button type="submit" class="btn btn-warning waves-effect">Submit</button>

                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

                    </div>


                </div>
            </div>
        </div>
    </form>
</div>