<div class="row" ng-app="Common_app" ng-controller="Purchase_controller">  
    <div class="col-lg-10 col-xs-offset-1 view" style="display:none">
        <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?></p>
        </div>
        <?php } else if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <p><?php echo $this->session->flashdata('error'); ?></p>
        </div>
        <?php }?>

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">View Purchase 
                <span class="store-code"> 
                    <?php 
                    if($this->session->userdata('store_code')){ 
                        $thisStore = $this->PurchaseModel->get_current_store();
                        $this_store_name = array();
                        if(isset($thisStore['store_name']) && $thisStore['store_name'])
                            $this_store_name[] = $thisStore['store_name'];

                        if(isset($thisStore['store_code']) && $thisStore['store_code'])
                            $this_store_name[] = " (".$thisStore['store_code'].")";


                        echo " - ".implode(" ", $this_store_name);
                    }?>
                    
                </span></div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    if($this->session->userdata('user_type')==STORE_MANAGER){ ?> 
                        <div class="col-lg-6 menu-bottom"><button type="button" class="btn btn-primary btn-md" id="add">Add Purchases</button>
                        </div>
                    <?php } ?>
                   
                    <div class="menu-bottom input-group col-lg-4 pull-right">
                        <input class="form-control search" ng-model="search" placeholder="Search" type="search" /> <span
                            class="btn btn-primary input-group-addon">
                            <span class="glyphicon glyphicon-search"></span></span>
                    </div>
                    <div class="col-md-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No.</th> 
                                    <th>Purchase Date</th>
                                    <?php
                                    if(!$this->session->userdata('store_code')){
                                        echo '<th>Store Details</th>';
                                    } ?>
                                    <th>Invoice No.</th>
                                    <th>Product Info.</th> 
                                    <th>Product Code</th>
                                    <th>Quantity</th> 
                                    <th>UOM <i class="fa fa-info icon-shape" title="" data-toggle="tooltip" data-original-title="Unit of Measurement"></i></th>
                                    <th>Amount (in Rs.)</th>
                                    <th>Supplier Name</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (Common_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                    <td>{{(current_grid*10 - 9) + $index}}</td>
                                    <td>{{data.purchase_date}}</td>
                                    <?php
                                    if(!$this->session->userdata('store_code')){ ?>                                 
                                        <td>{{data.store_name+' ('+data.store_code+')'}}</td>                              
                                        <?php 
                                    } ?>
                                    <td>{{data.invoice_number}}</td> 
                                    <td>
                                        <span ng-if="data.product_name!=''">{{data.product_name}} </span>
                                        <span ng-if="data.brand_name!=''">{{data.brand_name}} </span>
                                        <span ng-if="data.product_type!=''">{{data.product_type}} </span>
                                    </td>
                                    <td>{{data.product_code}} </td>                                 
                                    <td>{{data.quantity}}</td>  
                                    <td><span style="text-transform: lowercase;">{{data.uom}}</span></td>
                                    <td>{{data.amount}}</td>
                                    <td>{{data.supplier_name}}</td>  
                                    <td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
                                    <td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
                                    <!-- <td style="width: 3cm;">
                                        <button type="button" class="btn btn-sm btn-danger waves-effect" ng-if="data.status == 1"
                                            ng-click="disable_purchase(data.purchase_id, data.status)">
                                            <i class="fa fa-close pro-active" aria-hidden="true"></i>                                            
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success waves-effect" ng-if="data.status == 0"
                                            ng-click="disable_purchase(data.purchase_id, data.status)">                                            
                                            <i class="fa fa-check pro-deactive" aria-hidden="true"></i>
                                        </button>                                        
                                    </td> -->
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

    <div class="col-lg-10 col-xs-offset-1 add" style="display:none">
        <div class="panel panel-success">

            <div class="panel-heading">
                <div class="panel-title">Add Purchase</div>
            </div>
            <div class="panel-body">
                <div class="col-lg-12" style="margin-top: 10px;">

                    <form role="form" method="post" class="purchase_details_submit" ng-submit="purchase_details_submit()" autocomplete="off">

                       <span class="text-color text-capitalize">Invoice Details:</span>
                       <div class="text-line"></div>
                        <div class="form-group ">

                            <div class="col-sm-4 required">
                                <label class="control-label">Invoice Number </label>
                                <input type="text" class="form-control edit_form invoice_number" required name="invoice_number" placeholder="Invoice Number">
                            </div>                           

                             <div class="col-sm-4 required">
                                <label class="control-label">Invoice Date </label>
                                <input type="text" class="form-control edit_form purchase_date common_date_picker" id="mydate" value="purchase_date" name="purchase_date" placeholder="Purchase date" required readonly>
                            </div>

                            <!-- <div class="col-sm-3 required">
                                <label class="control-label">Select Store </label>
                                <select class="form-control edit_form srore_id" required name="store_code">
                                    <option value="">----- Select -----</option>
                                    <?php foreach($GetStore as $store){ print_r($GetStore); ?>
                                    <option value="<?php echo $store['store_code'] ?>">
                                        <?php echo $store['store_name'] ?></option>
                                    <?php }?>
                                </select>
                            </div> -->

                            <div class="col-sm-4 required">
                                <label class="control-label">Supplier Name</label>
                                <select class="form-control edit_form supplier_id supplier_id0" required name="supplier_id">
                                    <option value="">----- Select -----</option>
                                    <?php foreach($GetSupplier as $supplier){ print_r($GetSupplier); ?>
                                    <option value="<?php echo $supplier['supplier_id'] ?>">
                                        <?php echo $supplier['supplier_name'] ?></option>
                                    <?php }?>
                                </select>
                            </div>                            
                        </div>
                        <div id="purchase_products">                        
                            <div class="row col-sm-12" style="margin-top: 25px;">
                            <span class="text-color text-capitalize">Product Details:</span>
                             <div class="text-line"></div>
                                <div class="col-sm-3 required">
                                    <label class="control-label ">Product</label>
                                    <div class="form-group">
                                        <select required class="form-control edit_form get_products product_code product_code0" onChange="getPurchaseQtyUOM('0', this.value)" name="product_code[]">
                                            <option value="">----- Select -----</option>
                                            <?php 
                                            foreach($GetProducts as $product){  
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
                                            }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2 required">
                                    <label class="control-label ">
                                        Quantity
                                    </label>
                                    <div class="form-group">
                                        <input type="number" required min="1" placeholder="Quantity" class="form-control edit_form quantity quantity0" name="quantity[]" readonly>
                                        <span class="product_qty_uom0" style="color:#cc2424; font-weight: bold"></span>
                                        <input type="hidden" class="form-control edit_form uom uom0 product_qty_uom0" name="uom[]" value="" placeholder="UOM">
                                    </div>
                                </div>
                                <?php /*
                                <div class="col-sm-2 required">
                                    <label class="control-label">UOM <i class="fa fa-info icon-shape" title="Unit Of Measurement" data-toggle="tooltip"></i></label>
                                    <div class="form-group">
                                    <select required class="form-control edit_form get_uom uom uom0" name="uom[]">
                                            <option value="">----- Select -----</option>
                                            <?php foreach($GetUOM as $uom){  ?>
                                            <option value="<?php echo $uom['uom'] ?>">
                                                <?php echo $uom['uom'] ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div> 

                                <div class="col-sm-2 required" style="display:none">
                                    <label class="control-label ">Currency</label>
                                    <div class="form-group edit_form currency currency0">
                                        <input type="text" required readonly placeholder="Purchase currency" class="form-control edit_form currency currency0" value="INR" name="currency[]">
                                    </div>
                                </div>*/ ?>

                                <div class="col-sm-3 required">
                                    <label class="control-label ">Price</label>
                                    <div class="form-group">
                                        <input type="number" required placeholder="Purchase Price" class="form-control edit_form amount amount0" step="0.1" min="0" name="amount[]" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-3 required" style="display:none">
                                    <label for="field-12" class="control-label">Status</label>
                                    <select class="form-control product_status" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">DeActive</option>
                                    </select>
                                </div>

                                <div class="col-sm-1" style="display:none">
                                    <label class="control-label">Remove</label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 row" style="margin-top: 20px;">
                                <div class="text-center">
                                    <p class="error_purchase"></p>
                                    <button type="button" class="btn btn-danger" id="view"> <span class="glyphicon glyphicon-backward"></span> Cancel</button>
                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-forward"></span> Submit</button>

                                    <button class="btn btn-success" type="button" onclick="purchase_fields();">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {   
    
    $('[data-toggle="tooltip"]').tooltip();

    $(".view").show();
    $(".add").hide();

    $("#add").click(function() {
        $(".view").hide();
        $(".add").show();
    });
    $("#view").click(function() {
        $(".view").show();
        $(".add").hide();
    });
});

function getPurchaseQtyUOM(id, pcode) {
    $.ajax({
        type:'post',
        url:'Purchase/Get_Product_UOM',
        data:'product_code='+pcode,
        success:function(data){
            var e = JSON.parse(data);
            //alert(e.uom);
            if(e.uom){
                //UOM AVAILABLE
                $(".quantity"+id).removeAttr("readonly");
                $(".amount"+id).removeAttr("readonly");
                $(".quantity"+id).val("");
                $(".amount"+id).val("");
                $(".uom"+id).val(e.uom);
                $(".error_purchase").html("");

                if(e.uom_description){
                    $(".product_qty_uom"+id).html("Enter value in "+e.uom_description); 
                    $(".product_qty_uom"+id).append(" ("+e.uom+")"); 
                }
                else{
                    $(".product_qty_uom"+id).html("Enter value in "+e.uom); 
                }

                if(e.uom=="KG" || e.uom=="kg"){
                    $(".product_qty_uom"+id).append("<div style='font-size: 11px; color: #aaa'>Ex: 1g = 0.001 "+e.uom+", 300g = 0.3 "+e.uom+"</div>"); 
                }
                else if(e.uom=="L" || e.uom=="l"){
                    $(".product_qty_uom"+id).append("<div style='font-size: 11px; color: #aaa'>Ex: 1ml = 0.001 "+e.uom+", 160ml = 0.16 "+e.uom+"</div>"); 
                }
            }
            else{
                //NO UOM AVAILABLE
                $(".quantity"+id).attr("readonly", "true");
                $(".amount"+id).attr("readonly", "true");
                $(".quantity"+id).val("");
                $(".amount"+id).val("");
                $(".uom"+id).val("");
                $(".error_purchase").html("");

                $(".product_qty_uom"+id).html("");
            }
        }
    });
}

</script>

