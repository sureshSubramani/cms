<div class="row" ng-app="Common_app" ng-controller="Menu_controller">

    


    <div class="col-sm-12">
       <?php /*
        <div class="col-sm-4">
            <div class="panel panel-info">

                <div class="panel-heading">
                    <div class="panel-title">User Preference</div>
                </div>
                <div class="panel-body">
                    <form method="post" action="" ng-cloak>


                        <div class="form-group">
                            <label for="password">Role</label>
                            <div class="form-line">
                                <input type="text" name="role_name" class="form-control" placeholder="Enter Role"
                                    required>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">submit</button>
                    </form>
                </div>
            </div>
        </div> */ ?>

        <div class="col-sm-4">
            <div class="panel panel-info">

                <div class="panel-heading">
                    <div class="panel-title ">Menu Preference</div>
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
                                <td><?php echo ucfirst($roles['role']); ?></td>
                                <td><?php echo ucfirst(str_replace("_"," ", $roles['type'])); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success waves-effect " title="Click to edit preference of <?php echo ucfirst($roles['role']); ?> " data-toggle="modal" data-target="#add_view_menus " ng-click="add_menu_pre('<?php echo $roles['role']; ?>', '<?php echo $roles['type']; ?>')"><i class="fa fa-edit" aria-hidden="true"></i></button>

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
                    <h4 class="modal-title " id="defaultModalLabel">View Submenus</h4>
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
                        <h4 class="modal-title preference_title_of_role" style="text-transform: capitalize" id="defaultModalLabel">Menu Preference</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderd1">
                            <tbody>                                
                                <?php 
                                /*echo "<pre>";
                                print_r($get_all_menus); 
                                echo "</pre>";*/
                                if(count($get_all_menus) != 0){ 
                                    $k=0;  
                                     
                                    $i=0; 
                                    foreach ($get_all_menus as $key => $main_menu) { //print_r($main_menu); 
                                         //add class 'hav_sub' if sub menu is
                                         $main_hav_sub = (count($main_menu['sub_menus']) != 0 )?"main_hav_sub".$main_menu['menu_id']:""; ?>
                                        <tr>
                                            <td style="border-top: none;">
                                                <div class="form-group" style="margin:0 ">
                                                    <!--<input type="hidden" class="preference_id" name="preference_id">-->
                                                    <input type="hidden" class="preference_type" name="preference_type">
                                                    <input type="hidden" class="preference_role" name="preference_role">
                                                    <input onclick="checked_main_menus(<?php echo $main_menu['menu_id']; ?>)" class="common_all <?php echo $main_hav_sub; ?> main_menu_all<?php echo $main_menu['menu_id']; ?>" type="checkbox" id="remember_me_<?php echo $i; ?>" name="menus[<?php echo $main_menu['menu_id']; ?>]" value="<?php echo $main_menu['menu_url']; ?>" class="filled-in">
                                                    
                                                    <label for="remember_me_<?php echo $i; ?>" style="margin:0 "><?php echo $main_menu['menu_name']; ?></label>
                                                </div>
                                           
                                                <?php 
                                                if(count($main_menu['sub_menus']) != 0){  
                                                    $j=0; 
                                                    foreach ($main_menu['sub_menus'] as $key => $sub_menus) {   
                                                        //add class 'hav_sub' if sub menu is
                                                        $sub_hav_inner_sub = (count($main_menu['sub_menus'][$j]['inner_sub_menus']) != 0 )?"sub_hav_inner_sub".$main_menu['menu_id']:""; ?>
                                                        
                                                        <div class="form-group" style="margin:0 0 0 10px;border-left: 1px solid #59bae259; padding: 0 0 0 15px;" >
                                                            <?php 
                                                            if($sub_hav_inner_sub!=""){ ?>
                                                                <input onclick="checked_sub_menus(<?php echo $main_menu['menu_id']; ?>)" class="common_all <?php echo $sub_hav_inner_sub; ?> sub_menus_all sub_menus_all<?php echo $main_menu['menu_id']; ?> select_sub_menus_all<?php echo $sub_menus['menu_id']; ?>"   type="checkbox" name="menus[<?php echo $main_menu['menu_id']; ?>][<?php echo $sub_menus['menu_id']; ?>]" value="<?php echo $sub_menus['menu_url']; ?>" class="filled-in">
                                                                <?php
                                                            }
                                                            else{ ?>
                                                                <input onclick="checked_sub_menus2(<?php echo $main_menu['menu_id']; ?>)" class="common_all <?php echo $sub_hav_inner_sub; ?> sub_menus_all sub_menus_all<?php echo $main_menu['menu_id']; ?> select_sub_menus_all<?php echo $sub_menus['menu_id']; ?>"   type="checkbox" name="menus[<?php echo $main_menu['menu_id']; ?>][<?php echo $sub_menus['menu_id']; ?>]" value="<?php echo $sub_menus['menu_url']; ?>" class="filled-in">
                                                                <?php
                                                            }?>
                                                            <label for="remember_me_<?php echo $j; ?>" style="margin:0 "><?php echo $sub_menus['menu_name']; ?></label>
                                                        </div>
                                                        <?php 
                                                        /*echo "<pre>";
                                                        print_r($main_menu['sub_menus'][$j]['inner_sub_menus']);
                                                        echo "</pre>";*/
                                                        if(isset($main_menu['sub_menus'][$j]['inner_sub_menus']) && count($main_menu['sub_menus'][$j]['inner_sub_menus']) != 0){ 
                                                            /*echo "<pre>";
                                                            print_r($main_menu['sub_menus'][$j]['inner_sub_menus']);
                                                            echo "</pre>";*/
                                                            if(is_array($main_menu['sub_menus'][$j]['inner_sub_menus'])){
                                                                foreach ($main_menu['sub_menus'][$j]['inner_sub_menus'] as $key => $inner_sub_menus) {   ?>

                                                                    <div class="form-group"  style="margin:0 0 0 35px; border-left: 1px solid #59bae259; padding: 0 0 0 15px;" >
                                                                        <input onclick="check_inner_sub_menus(<?php echo $main_menu['menu_id']; ?>)" class="common_all inner_sub_menus_all inner_sub_menus_all<?php echo $main_menu['menu_id']; ?> select_inner_sub_menus_all<?php echo $inner_sub_menus['menu_id']; ?>" type="checkbox" name="menus[<?php echo $main_menu['menu_id']; ?>][<?php echo $sub_menus['menu_id']; ?>][<?php echo $inner_sub_menus['menu_id']; ?>]" value="<?php echo $inner_sub_menus['menu_url']; ?>" class="filled-in">
                                                                        
                                                                        <label for="remember_me_<?php echo $j; ?>" style="margin:0 "><?php echo $inner_sub_menus['menu_name']; ?></label>
                                                                    </div>

                                                                    <?php 
                                                                    //$j++; 
                                                                } 
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