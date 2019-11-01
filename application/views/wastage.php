<div class="row" ng-app="Common_app" ng-controller="Wastage_controller">

<?php if($this->session->userdata('user_type') == STALL_OPERATOR){  ?>
    <div class="col-lg-6 col-xs-offset-0">
    <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-danger alert-absolute alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?></p>
        </div>
        <?php } else if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-absolute alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><strong>Warning!</strong> <?php echo $this->session->flashdata('error'); ?></p>
        </div>
        <?php }?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Wastage Product Form 
                <span class="store-code"> 
                    <?php //echo $this->session->userdata('logged_store_stall'); ?>
                </span>
                </div>
            </div>
            <div class="panel-body">
                <form method="post" class="wastage_products_submit" ng-submit="wastage_products_submit()" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="control-label">Store Info</label>
                        <input type="hidden" class="form-control wastage_id" value="0" name="wastage_id" required/>
                        <?php
                        if($this->session->userdata('store_code')){  ?>                    
                            <input type="hidden" class="form-control store_code" value="<?php echo $this->session->userdata('store_code') ?>" name="store_code" id="store_code"
                                placeholder="Prodcut store" required />
                            <input type="text" class="form-control store_code" value="<?php echo $this->session->userdata('store_name')." (".$this->session->userdata('store_code').")" ?>" disabled readonly required />   
                            <?php
                        }
                        else{ 
                            $all_store = $this->common_details->GetAllStoreDetails();  ?>                           
                            <select class="form-control stall_code" name="stall_code" id="store_code">
                                <option value="">-- Select --</option>
                                <?php
                                if(!empty($all_store)){
                                    foreach($all_store as $kStore=>$vStore){
                                        echo '<option value="'.$vStore['store_code'].'">'.$vStore['store_name'].' ('.$vStore['store_code'].')</option>';
                                    }
                                }
                                ?>
                            </select>  <?php
                        } ?>  
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="control-label">Stall Info.</label>
                        <?php
                        if($this->session->userdata('stall_code')){  ?>                            
                            <input type="hidden" class="form-control stall_code" value="<?php echo $this->session->userdata('stall_code') ?>" name="stall_code" id="stall_code" placeholder="Prodcut stall" disabled readonly required/>  
                            <input type="text" class="form-control store_code" value="<?php echo $this->session->userdata('stall_name')." (".$this->session->userdata('stall_code').")" ?>" disabled readonly required />  <?php
                        }
                        else{ 
                            $all_stall = $this->common_details->GetAllStallDetails();  ?>                           
                            <select class="form-control stall_code" name="stall_code" id="stall_code">
                                <option value="">-- Select --</option>
                                <?php
                                if(!empty($all_stall)){
                                    foreach($all_stall as $kStall=>$vStall){
                                        if($vStall['stall_code']!=""){
                                            echo '<option value="'.$vStall['stall_code'].'">'.$vStall['stall_name'].' ('.$vStall['stall_code'].')</option>';
                                        }
                                    }
                                } ?>
                            </select> <?php
                        } ?>     
                    </div>
                    <?php //echo str_replace(",","<br>",$this->session->userdata('logged_store_stall')); ?>
                   
                    <div class="form-group" style="display:none">
                        <label for="field-12" class="control-label">Approve Status</label>
                        <select class="form-control approve_status" name="approve_status">
                            <option value="0">Pending</option>
                            <option value="1">Accepted</option>
                            <option value="2">Rejected</option>
                        </select>
                    </div>

                    <div class="form-group" style="display:none">
                        <label for="field-12" class="control-label">Status</label>
                        <select class="form-control status" name="status">
                            <option value="1">Active</option>
                            <option value="0">DeActive</option>
                        </select>
                    </div>
                    <br>
                    <div id="wastage_products" style="">
                        <!--<h4 class="text-capitalize">Products Details:</h4>-->
                        <div class="text-line"></div>
                        <div class="row col-sm-12" style="margin-bottom: 10px;">
                            <div class="col-sm-4 required">
                                <label class="control-label ">Product Code</label>
                                <div class="form-group">
                                    <select required  class="form-control edit_form get_products product_code product_code0" onChange="getStallStock('0', this.value)" name="product_code[]">
                                        <option value="">----- Select -----</option>
                                        <?php 
                                        foreach($getStocks as $product){  
                                            $prod = array();
                                            if(isset($product['product_name']) && $product['product_name']!="")
                                                $prod[] = $product['product_name'] ;

                                            if(isset($product['brand_name']) && $product['brand_name']!="")
                                                $prod[] = $product['brand_name'] ;

                                            if(isset($product['product_type']) && $product['product_type']!="")
                                                $prod[] = $product['product_type'];

                                            if(isset($product['product_code']) && $product['product_code']!="")
                                                $prod[] = "(".$product['product_code'].")";

                                            if(!empty($prod)){
                                                echo '<option value="'.$product['product_code'].'">'.implode(" ", $prod).'</option>';
                                            } 

                                        }
                                        /*?>
                                            <option value="<?php echo $product['product_code'] ?>">
                                                <?php echo $product['product_name']. " (" . $product['product_code'] .")" ?>
                                            </option>
                                        <?php }*/?>
                                    </select>
                                    <span class="stock_qty0" style="color:#0d7711;opacity: .7; font-weight: bold"></span>
                                </div>
                            </div>
                            <div class="col-sm-4 required">
                                <label class="control-label ">Quantity of Waste</label>
                                <div class="form-group">
                                    <input type="hidden" class="form-control stock_quantity stock_quantity0" name="stock_quantity[]">
                                    <input type="hidden"  class="form-control uom uom0" placeholder="UOM" name="uom[]" readonly>
                                    <input type="hidden"  class="form-control conversion_val conversion_val0"   name="conversion_val[]" readonly>
                                    <input type="text" onkeyup="validate_wastage_quantity(0,this.value)" required="" min="1" placeholder="Quantity" class="form-control edit_form quantity_of_waste quantity_of_waste0" name="quantity_of_waste[]" readonly required>
                                    <span class="stock_qty_uom0" style="color:#ff5722;opacity: .7; font-weight: bold"></span>
                                    
                                </div>
                            </div>
                            <?php /*
                            <div class="col-sm-4 required">
                                <label class="control-label ">Total Quantity</label>
                                <div class="form-group">
                                    <input type="number" min="0" placeholder="Quantity"
                                        class="form-control edit_form quantity_of_waste quantity_of_waste0" name="quantity_of_waste[]" required>
                                </div>
                            </div> 

                            <div class="col-sm-3 required">
                                <label class="control-label">UOM <i class="fa fa-info icon-shape"
                                        title="Unit Of Measurement" data-toggle="tooltip"></i></label>
                                <div class="form-group">
                                    <select required="" class="form-control edit_form get_uom uom uom0" name="uom[]"
                                        required>
                                        <option value="">----- Select -----</option>
                                        <?php foreach($GetUOM as $uom){ ?>
                                        <option value="<?php echo $uom['uom']; ?>"><?php echo $uom['uom']; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <label class="control-label">Remove</label>
                            </div> */?>

                        </div>
                    </div>
                    
                    <div class="text-center" style="">
                        <p class="text-center col-sm-12 error_wastage_product"></p>
                        

                        <button class="btn btn-success" type="button" onclick="wastage_products()">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
                        </button>

                         <button type="reset" class="btn btn-danger">
                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset
                        </button>
                         <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-forward" aria-hidden="true"></span> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> <?php }

    if($this->session->userdata('user_type') == STALL_OPERATOR){ ?>
        <div class="col-lg-6 col-xs-offset-0"> <?php
    }
    else{ ?>
        <div class="col-lg-12 col-xs-offset-0"> <?php
    } ?>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-title">Wastage Products List  </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="menu-bottom input-group col-lg-4 pull-right">
                        <input class="form-control search" ng-model="search" placeholder="Search" type="search" />
                        <span class="btn btn-primary input-group-addon">
                            <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                    <div class="col-lg-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered" datatable="ng">
                            <thead>
                                    <th>Sl No</th>
                                    <th>Date of entry</th>
                                    <?php if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){
                                        echo '<th>Store Info.</th>';
                                        echo '<th>Stall Info.</th>';                    
                                    }
                                    else  if($this->session->userdata('user_type')==STORE_MANAGER){
                                        echo '<th>Stall Info.</th>';
                                    } ?>                  
                                    <th>Product Info</th>                  
                                    <th>Product Code</th>
                                    <th>Qty <i class="fa fa-info icon-shape" title="Quantity Of Waste" data-toggle="tooltip"></i></th>
                                    <th>Approval</th>
                                    <th>Status</th>
                                    <?php 
                                    if($this->session->userdata('user_type') == STALL_OPERATOR){ ?>
                                        <th>Action</th>
                                        <?php 
                                    }?>
                                </tr>
                            </thead>
                            <tbody>
                               <tr ng-repeat="data in searched = (Wastage | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                    <td>{{(current_grid*10 - 9) + $index}}</td>
                                    <td>{{data.created_on}}</td>
                                    <?php
                                    if(!$this->session->userdata('store_code')){ ?>                                 
                                        <td>{{data.store_name+' ('+data.store_code+')'}}</td>                              
                                        <?php 
                                    } 
                                    if($this->session->userdata('user_type') != STALL_OPERATOR){ ?>
                                        <td>{{data.stall_name}} ({{data.stall_code}})</td><?php
                                    } ?>  
                                    <td title="{{data.description}}">
                                        <span ng-if="data.product_name!=''">{{data.product_name}} </span>
                                        <span ng-if="data.brand_name!=''">{{data.brand_name}} </span>
                                        <span ng-if="data.product_type!=''">{{data.product_type}} </span>
                                    </td>
                                    <td>{{data.product_code}} </td>
                                    <td>{{data.quantity_of_waste}} <span style="text-transform: lowercase;">{{data.uom}}</span></td> 
                                    <td>                                   
                                        <?php 
                                        if($this->session->userdata('user_type') == STORE_MANAGER){ ?>
                                            
                                            <button type="button" class="btn btn-sm btn-info waves-effect"  ng-if="data.approve_status == 0" ng-click="accept_wastage_product(data.wastage_id, data.stall_code, data.product_code, data.quantity_of_waste)" title="Accept" data-toggle="tooltip" data-placement="left" tooltip>
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button> 
                                            <button type="button" class="btn btn-sm btn-danger waves-effect" ng-if="data.approve_status == 0" ng-click="reject_wastage_product(data.wastage_id)" title="Reject" data-toggle="tooltip" data-placement="right" tooltip>
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button> 
                                            <?php 
                                        }
                                        else if($this->session->userdata('user_type') == STALL_OPERATOR){ ?>                                            
                                                <span ng-if="data.approve_status == 0" class="label label-info">Pending</span>                                     
                                            <?php 
                                        } ?>                                         
                                        <?php if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>                                            
                                                <span ng-if="data.approve_status == 0" class="label label-info">Pending</span>                                     
                                            <?php 
                                        } ?>                                     
                                        <span ng-if="data.approve_status == 1" class="label label-success">Accepted</span>
                                        <span ng-if="data.approve_status == 2" class="label label-danger">Rejected</span> 
                                    </td>                                    
                                    <td>
                                        <span ng-if="data.status == 0" class="label label-danger">Deactive</span>
                                        <span ng-if="data.status == 1" class="label label-success">Active</span>
                                    </td>                                  
                                    <?php 
                                    if($this->session->userdata('user_type') == STALL_OPERATOR){ ?>
                                        <td style="width:3cm;">                                          
                                            <button type="button" class="btn btn-sm btn-primary waves-effect" ng-if="data.approve_status == 2" ng-click="edit_wastage_products(data.wastage_id)" data-toggle="tooltip" data-placement="left" title="Modify" tooltip>
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary waves-effect" ng-if="data.approve_status == 0 || data.approve_status == 1" title="Modify" ng-click="edit_wastage_products(data.wastage_id)" data-toggle="tooltip" disabled>
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info waves-effect" ng-if="data.status == 1" ng-click="view_wastage_products(data.wastage_id, data.product_name)" data-toggle="modal" data-target="#view-wastage" title="View" data-placement="right" tooltip>
                                                <i class="fa fa fa-eye pro-active" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        <?php 
                                    } ?>                                                                      
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

    <div id="AddStallsInSalesProducts" class="modal fade" role="dialog" style="display: none; padding-left: 17px;">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Add Stalls with Sales Product</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="ProductForm" method="post" class="product_details_submit ng-pristine ng-valid"
                        ng-submit="product_details_submit()" autocomplete="off">

                        <div class="form-group">
                            <label for="category_id" class="control-label">Product Category</label>
                            <select class="form-control no_of_stalls" name="no_of_stalls" required="">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="view-wastage" class="modal fade" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header panel-default">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title view-wastage-products"> </h4>
                </div>
                <div class="modal-body">                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Product Name</th>
                                <th>QTY <i class="fa fa-info icon-shape" title="Quantity Of Waste" data-toggle="tooltip"></i></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr ng-if="viewWastage.length !=0" ng-repeat="data in viewWastage">
                                <td>{{$index + 1}}</td>
                                <td>{{data.product_code}} - {{data.product_name}}</td>
                                <td>{{data.quantity_of_waste}} {{data.uom}}</td>                              
                            </tr>                          

                            <tr ng-if="viewWastage.length == 0">
                                <td colspan="4">No result found </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script>
function getStallStock(id, pcode) {
    var scode = $("#store_code").val();
    var stlcode = $("#stall_code").val();
        
    if(id && scode && stlcode && pcode){
        $(".quantity_of_waste"+id).val("");
        $.ajax({
            type:'post',
            url:'Wastage/Get_Stall_Stock',
            data:'store_code='+scode+'&stall_code='+stlcode+'&product_code='+pcode,
            success:function(data){
                //alert(data);
                var e = JSON.parse(data);
                //alert(e.uom);
                if(e.stock){
                    //STOCK AVAILABLE
                    $(".quantity_of_waste"+id).removeAttr("readonly");
                    $(".quantity_of_waste"+id).attr("placeholder", "Maximum "+e.stock);
                    $(".quantity_of_waste"+id).focus();
                    $(".stock_qty"+id).html("Available stock is  "+e.stock+" "+e.uom); 
                    $(".stock_quantity"+id).val(e.stock);
                    $(".uom"+id).val(e.uom);
                    $(".error_movement_tracker").html("");

                    if(e.uom_description){
                        $(".stock_qty_uom"+id).html("Enter value in "+e.uom_description); 
                        $(".stock_qty_uom"+id).append(" ("+e.uom+")"); 
                    }
                    else{
                        $(".stock_qty_uom"+id).html("Enter value in "+e.uom); 
                    }

                    if(e.uom=="KG" || e.uom=="kg"){
                        $(".stock_qty_uom"+id).append("<div style='font-size: 11px; color: #aaa'>Ex: 1g = 0.001 "+e.uom+", 300g = 0.3 "+e.uom+"</div>"); 
                    }
                    else if(e.uom=="L" || e.uom=="l"){
                        $(".stock_qty_uom"+id).append("<div style='font-size: 11px; color: #aaa'>Ex: 1ml = 0.001 "+e.uom+", 160ml = 0.16 "+e.uom+"</div>"); 
                    }
                }
                else{
                    //NO STOCK AVAILABLE
                    $(".quantity_of_waste"+id).attr("readonly", "true");
                    $(".quantity_of_waste"+id).attr("placeholder", "");
                    $(".stock_qty"+id).html("<span style='color:#f30404;opacity: .7;'>No stock available!</span>");
                    $(".stock_quantity"+id).val("");
                    $(".uom"+id).val("");
                    $(".error_movement_tracker").html("");

                    if(!e.uom){
                        $(".stock_qty_uom"+id).html("Unknown Measurement");
                    }
                    else{
                        $(".stock_qty_uom"+id).html("");
                    }
                }                
            }
        });
        //$("."+id).html(pcode);
    }
    else{
        //NO PRODUCT SELECTED
        $(".quantity_of_waste"+id).attr("readonly", "true");
        $(".quantity_of_waste"+id).attr("placeholder", "");
        $(".stock_qty"+id).html("");
        $(".stock_quantity"+id).val("");
        $(".uom"+id).val("");
        $(".error_movement_tracker").html('<span style="color: #f37">Select a product!</span>');

        $(".stock_qty_uom"+id).html("");
    }
}

function validate_wastage_quantity(id, quantity) {
    var stock_quantity = $('.stock_quantity' + id).val();

    //console.log(id,quantity,stock_quantity);

    if (stock_quantity == '' || stock_quantity == undefined) {
        //$.alert('Please Select Product Code');

        $(".error_wastage_product").html("<span style='color: #f37'>Select a product!</span>");
        $('.quantity_of_waste' + id).val("");
    }
    else if (parseFloat(quantity) < 0) {
        $(".error_wastage_product").html("");
        $('.quantity_of_waste' + id).val("");
    }
    else if (parseFloat(stock_quantity) < parseFloat(quantity)) {
        $(".error_wastage_product").html("");
        $('.quantity_of_waste' + id).val(stock_quantity);
    }
    else {
        $(".error_wastage_product").html("");
    }
}
</script>