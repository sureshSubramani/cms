<div class="row" ng-app="Common_app" ng-controller="MovementTracker_controller">
     <?php 
     if($this->session->userdata('user_type')==STORE_MANAGER){ ?>
        <div class="col-lg-6 col-xs-offset-0">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Movement Tracker</div>
                </div>
                <div class="panel-body">
                    <form method="post" class="movemntTracker_sub" ng-submit="movemntTracker_sub()" enctype="multipart/form-data">
                        <div class="row">    
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="hidden" class="store_code" name="store_code" id="store_code" value="<?php echo $this->session->userdata('store_code'); ?>">
                                    <input type="hidden" class="sales_stock_id" name="sales_stock_id" value="0">
                                    <select required="" class="form-control edit_form get_stalls   " name="get_stalls" ng-model="get_stalls" required  ng-change="getStockSales(get_stalls)">
                                        <option value="">----- Select -----</option>
                                        <?php foreach($get_stores_stall as $stall){ ?>
                                            <option value="<?php echo $stall['stall_code']; ?>"><?php echo $stall['stall_name']; ?></option>
                                        <?php }?>
                                    </select>
                                </div> 
                            </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="movement_date" value="<?php echo date('Y-m-d'); ?>" readonly>
                                    </div>
                                </div>
                        </div>    

                    
                            <div id="movementTracker_incredians">
                            <span class="text-capitalize">Incredians Details:</span>
                            <hr>
                                <div class="row col-sm-12" style="margin-top: 15px;">
                                    <div class="col-sm-4 required">
                                        <label class="control-label ">Product</label>
                                        <div class="form-group">                                     
                                            <?php /*
                                            <select required="" class="form-control edit_form get_products product_code product_code0" onChange="getStoreStock('0', this.value)" name="product_code[]" onchange="getallStockDetails(this.value,0)"> */ ?>
                                            <select required="" class="form-control edit_form get_products product_code product_code0" onChange="getStoreStock('0', this.value)" name="product_code[]" >
                                                <option value="">----- Select -----</option> 
                                                <?php 
                                                foreach ($getStocks as $key => $stocks) { 
                                                    $prod = array();
                                                    if(isset($stocks['product_name']) && $stocks['product_name']!="")
                                                        $prod[] = $stocks['product_name'] ;

                                                    if(isset($stocks['brand_name']) && $stocks['brand_name']!="")
                                                        $prod[] = $stocks['brand_name'] ;

                                                    if(isset($stocks['product_type']) && $stocks['product_type']!="")
                                                        $prod[] = $stocks['product_type'];

                                                    if(isset($stocks['product_code']) && $stocks['product_code']!="")
                                                        $prod[] = "(".$stocks['product_code'].")";

                                                    if(!empty($prod)){
                                                        echo '<option value="'.$stocks['product_code'].'">'.implode(" ", $prod).'</option>';
                                                    } 
                                                }?>                                                
                                            </select>
                                            <span class="stock_qty0" style="color:#0d7711;opacity: .7; font-weight: bold"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 required">
                                        <label class="control-label ">Quantity</label>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control stock_quantity stock_quantity0" name="stock_quantity[]">
                                            <input type="hidden"  class="form-control uom uom0" placeholder="UOM" name="uom[]" readonly>
                                            <input type="hidden"  class="form-control conversion_val conversion_val0"   name="conversion_val[]" readonly>
                                            <input type="number" onkeyup="check_limited_quant(0,this.value)" required="" min="1" placeholder="Quantity" class="form-control edit_form quantity quantity0" name="quantity[]" readonly>
                                            <span class="stock_qty_uom0" style="color:#ff5722;opacity: .7; font-weight: bold"></span>
                                            
                                        </div>
                                    </div>
                                    <?php /*
                                    <div class="col-sm-3 required">
                                        <label class="control-label" title="Unit Of Measurement">UOM</label>
                                        <div class="form-group">
                                        <input type="hidden"  class="form-control conversion_val conversion_val0"   name="conversion_val[]" readonly>
                                        <input type="text"  class="form-control edit_form get_uom uom uom0" placeholder="UOM" name="uom[]" readonly>
                                        </div>
                                    </div> 

                                 

                                    <div class="col-sm-1">
                                        <label class="control-label">Remove</label>
                                    </div>*/ ?>

                                </div>
                            </div>
                        
                        

                        <center>
                            <p class="col-sm-12 error_movement_tracker"></p>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                            <button class="btn btn-success" type="button" onclick="movementTracker();">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            Add</button>
                        </center>                           
                    </form>             
                </div>
            </div>
        </div> 
        <?php
    }?>

    <?php
    if($this->session->userdata('user_type')==STORE_MANAGER){
        echo '<div class="col-lg-6 col-xs-offset-0">';
    }
    else {
        echo '<div class="col-lg-12 col-xs-offset-0">';
    }
    ?>
    <!--<div class="col-lg-6 col-xs-offset-0">-->
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-title">View Movement tracker</div>
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
                                <tr>
                                    <th>S.No.</th> 
                                    <th>Date of moved</th>
                                    <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){
                                        echo '<th>Store Info.</th>';
                                        echo '<th>Stall Info.</th>';                    
                                    }
                                    else  if($this->session->userdata('user_type')==STORE_MANAGER){
                                        echo '<th>Stall Info.</th>';
                                    } ?>
                                    <th>Product Info.</th>
                                    <th>Qty <i class="fa fa-info icon-shape" title="Quantity of moved" data-toggle="tooltip"></i></th>
                                    <th>UOM <i class="fa fa-info icon-shape" title="Unit of Measurement" data-toggle="tooltip"></i></th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (Common_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit" title="{{data.description}}">
                                    <td>{{(current_grid*10 - 9) + $index}}</td> 
                                    <td >{{data.movement_date}}</td>
                                    
                                    <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>
                                       <td>{{data.store_name+' ('+data.store_code+')'}}</td>
                                       <td>{{data.stall_name+' ('+data.stall_code+')'}}</td>
                                       <?php                    
                                    }
                                    else if($this->session->userdata('user_type')==STORE_MANAGER){?>
                                       <td>{{data.stall_name+' ('+data.stall_code+')'}}</td>
                                       <?php                    
                                    } ?>
                                    <td>
                                        <span ng-if="data.product_name!=''">{{data.product_name}} </span>
                                        <span ng-if="data.brand_name!=''">{{data.brand_name}} </span>
                                        <span ng-if="data.product_type!=''">{{data.product_type}} </span>
                                        <span ng-if="data.product_code!=''">({{data.product_code}})</span>
                                    </td>
                                    <td >{{data.quantity}}</td>  
                                     <td><span style="text-transform: lowercase;"><?php echo ucfirst('{{data.uom}}') ?></span></td>
                                     
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
                            items-per-page="data_limit" class="pagination-small pull-right"previous-text="&laquo;"
                            next-text="&raquo;"></div>
                    </div>
                </div>
            </div>
        </div>    
    </div>  
</div>  

<script>
function getStoreStock(id, pcode) {
    var scode = $("#store_code").val();
    if(id && scode && pcode){
        $(".quantity"+id).val("");
        $.ajax({
            type:'post',
            url:'Movement_tracker/Get_Store_Stock',
            data:'store_code='+scode+'&product_code='+pcode,
            success:function(data){
                var e = JSON.parse(data);
                //alert(e.uom);
                if(e.stock && e.uom){
                    //STOCK AVAILABLE
                    $(".quantity"+id).removeAttr("readonly");
                    $(".quantity"+id).attr("placeholder", "Maximum "+e.stock);
                    $(".quantity"+id).focus();
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
                    $(".quantity"+id).attr("readonly", "true");
                    $(".quantity"+id).attr("placeholder", "");
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
         //NO STOCK AVAILABLE
        $(".quantity"+id).attr("readonly", "true");
        $(".quantity"+id).attr("placeholder", "");
        $(".stock_qty"+id).html("");
        $(".stock_quantity"+id).val("");
        $(".uom"+id).val("");
        $(".error_movement_tracker").html('<span style="color: #f37">Select a product!</span>');

        $(".stock_qty_uom"+id).html("");
    }
}
</script>