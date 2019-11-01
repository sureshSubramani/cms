<div class="row" ng-app="Common_app" ng-controller="Product_controller">
    <div class="col-lg-10 col-xs-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Products</div>
            </div>
            <div class="panel-body">
                <div class="row">  
                    <?php
                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>
                        <div class="col-lg-1 mentu-bottom pull-right" style="width: 126px !important;">
                            <button type="button" class="btn btn-primary btn-md" onclick="open_form('add')">
                                Add New &nbsp;<span class="glyphicon glyphicon-forward"></span>
                            </button>
                        </div> <?php
                    }?> 
                    <div class="col-lg-3">
                        <div class="input-group">

                            <select class="form-control filter_category" name="filter_category" id="filter_category" onChange="set_filter()" style="font-weight: bold; color:  #131714" title="" data-toggle="tooltip" data-original-title="Filter by Category">
                                <option value="">-- Search by Category --</option>
                                <?php 
                                foreach($get_product_category as $cat){ 
                                    if($cat['status']){
                                        $selected = "";
                                        if($this->session->userdata('product_details_category_id')){
                                            $c_id = $this->session->userdata('product_details_category_id');
                                            $selected = ($cat['category_id']==$c_id)?"selected":"";
                                        }
                                        echo '<option '.$selected.' value="'.$cat['category_id'].'">'.$cat['product_category'].'</option>';
                                    } 
                                }?>
                            </select>
                            <?php
                            if($this->session->userdata('product_details_category_id')){ ?>
                                <span class="btn btn-danger input-group-addon" onclick="clear_filter()" title="" data-toggle="tooltip" data-original-title="Clear">
                                    <span class="glyphicon glyphicon-remove"></span> 
                                </span>
                                <?php
                            }?>
                            <!--<span class="btn btn-primary input-group-addon" onclick="set_filter()" title="" data-toggle="tooltip" data-original-title="Click to Filter">
                                <span class="glyphicon glyphicon-search"></span> 
                            </span>-->
                        </div>
                    </div>
                    <div class="menu-bottom input-group col-lg-4 pull-right">
                        <input class="form-control search" ng-model="search" placeholder="Search by name and keywords" type="search" /> 
                        <span class="btn btn-primary input-group-addon">
                            <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                    <div class="col-lg-12" ng-show="filter_data > 0">
                        <table class="table table-striped table-bordered" datatable="ng">
                            <thead>
                                <tr>
                                    <th>S.No.</th> 
                                    <th>Product Info</th>
                                    <th>Product Code</th>
                                    <th>Category</th>
                                    <th>UOM <i class="fa fa-info icon-shape" title="" data-toggle="tooltip" data-original-title="Unit of Measurement"></i></th>
                                    <th>Conversion Value</th>
                                    <th>Status</th>
                                    <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>   
                                        <th>Action</th>
                                        <?php
                                    }?> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (product_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                    <td>{{(current_grid*15 - 14) + $index}}</td> 
                                    <td>
                                        <span ng-if="data.product_name!=''">{{data.product_name}} </span>
                                        <span ng-if="data.brand_name!=''">{{data.brand_name}} </span>
                                        <span ng-if="data.product_type!=''">{{data.product_type}} </span>
                                    </td>
                                    <td>{{data.product_code}} </td>  
                                    <td style="text-transform: capitalize;">{{data.product_category}} </td>   
                                    <td> <span ng-if="data.uom !=''">in {{data.uom}}</span> </td>    
                                    <td >
                                        <span ng-if="data.conversion_value > 0" >{{data.conversion_value}}</span>
                                    </td>                           
                                    <td>
                                        <span ng-if="data.status == 0" class="label label-danger">Deactive</span>
                                        <span ng-if="data.status == 1" class="label label-success">Active</span>
                                    </td>
                                    <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?> 
                                        <td style="width:3cm;">
                                            <button type="button" class="btn btn-sm btn-info waves-effect" ng-click="edit_product_details(data.product_id)">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>                                       
                                            <button type="button" class="btn btn-sm btn-danger waves-effect" ng-if="data.status == 1"
                                                ng-click="disable_products(data.product_id, data.status)">
                                                <i class="fa fa-close pro-active" aria-hidden="true"></i>                                            
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success waves-effect" ng-if="data.status == 0"
                                                ng-click="disable_products(data.product_id, data.status)">                                            
                                                <i class="fa fa-check pro-deactive" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        <?php
                                    }?> 
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
    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#add" id="add_modal_btn" style="display: none;"></button>
    <!-- Modal -->
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="col-sm-12 modal-content">
                <div class="modal-header">
                    <a href="<?php echo base_url() ?>product_details">
                    <button type="button" class="close"  >&times;</button>
                    </a>
                    <h4 class="modal-title">Add New Product</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="ProductForm" method="post" class="product_details_submit" ng-submit="product_details_submit('add')"
                        autocomplete="off">

                        <div class="col-sm-12 form-group">
                            <label for="field-2" class="control-label">Product Name <span class="required-field">*</span></label>
                            <input type="text" class="form-control product_name" name="product_name" id="product_name" placeholder="Product Name" >
                        </div>

                        <div class="col-sm-6 form-group">
                            <label for="category_id" class="control-label">Category <span class="required-field">*</span></label>
                            <select class="form-control category_id" name="category_id" id="category_id" onChange="isOthersCategory('add',this.value)" >
                                <option value="">Select</option>
                                <?php 
                                foreach($get_product_category as $cat){ 
                                    if($cat['status']){?>
                                        <option value="<?php echo $cat['category_id']; ?>">
                                            <?php echo $cat['product_category']; ?>
                                        </option>
                                        <?php
                                    } 
                                }?>
                                <?php /*<option value="Others" style="background:#fff">Others</option> */?>
                            </select>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label for="field-1" class="control-label">Product Code <span class="required-field">*</span></label>
                            <input type="text" class="form-control product_code"  value="" name="product_code" id="product_code" placeholder="Prodcut Code" readonly >  
                            <input type="hidden" class="form-control product_id" value="0" name="product_id" id="product_id" placeholder="Storecode" readonly > 
                            <span style="font-style: italic; color: #aaa; font-size: 11px">Code will generate automatically by category</span>                         
                        </div>
                        <?php /*
                        <div class="col-sm-6 form-group add_new_category" style="display:none;">
                            <label for="" class="control-label">Enter Category</label>
                            <input type="text" class="form-control new_product_category" name="new_product_category" id="new_product_category"  placeholder="Product Category">
                        </div> */ ?>
                        <div class="col-sm-6 form-group product_brand">
                            <label for="product-brand" class="control-label">Product Brand</label>
                            <input type="text" class="form-control brand_name" name="brand_name" id="brand_name" placeholder="Product Brand">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="product-type" class="control-label">Product Type</label>
                            <input type="text" class="form-control product_type" name="product_type" id="product_type" placeholder="Product Type">
                        </div>
                        
                        <!--
                         <div class="form-group " >
                            <label for="field-4" class="control-label">Conversion value (Optional)</label>
                            <input type="text" class="form-control conversion" name="conversion_value"
                                placeholder="Conversion value">
                        </div> -->
                        <div class="col-sm-6 form-group">
                            <label for="uom" class="control-label">Unit of measurement (UOM) <span class="required-field">*</span></label>
                            <select class="form-control uom" name="uom" id="uom" >
                                <option value="">--Select--</option>
                                <?php 
                                if(!empty($uom)){
                                    foreach($uom as $cat){ 
                                        if($cat['status']){?>
                                            <option value="<?php echo $cat['uom']; ?>"><?php echo $cat['uom'].($cat['description']?' ('.$cat['description'].')':''); ?></option>
                                            <?php
                                        } 
                                    }
                                }
                                else{
                                    echo '<option value="KG">KG (Kilogram)</option>';
                                    echo '<option value="L">L (Litter)</option>';
                                    echo '<option value="NO\'s">NO\'s (Numbers)</option>';
                                }?>
                            </select>
                        </div>
                         <!--
                        <div class="form-group product_brand">
                            <label for="conversion_value" class="control-label">Conversion Value</label>
                            <input type="text" class="form-control conversion_value" name="conversion_value" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" placeholder="Enter value in numbers." value="0">
                        </div> -->
                        <div class="col-sm-12 form-group">
                            <label for="product_description" class="control-label">Product Description</label>
                            <textarea class="form-control description" name="description" id="description" rows="3" style=""> </textarea>
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="conversion" class="control-label">Measurements(Conversion to Unit)</label>
                            <select class="form-control conversion_value" name="conversion_value">
                                <option value="">Select</option>
                                <?php 
                                /*foreach($uom as $uomk=>$uomv){ 
                                    if($cat['status']){?>
                                        <option value="<?php echo $uomv['uom']; ?>" title="">
                                            <?php echo strtoupper($uomv['uom']).(($uomv['description'])?" - ".$uomv['description']:""); ?>
                                        </option>
                                        <?php
                                    } 
                                }*/?>
                            </select>
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="field-7" class="control-label">Purchase Price</label>
                            <input type="number" min="0" class="form-control purch_price" name="purch_price"
                                placeholder="Purchase Price">
                        </div>

                        <div class="form-group">
                            <label for="field-8" class="control-label">Selling Price</label>
                            <input type="number" min="0" class="form-control selling_price" name="selling_price"
                                placeholder="Selling Price">
                        </div>

                        <div class="form-group">
                            <label for="field-10" class="control-label">MRP</label>
                            <input type="number" min="0" class="form-control product_mrp" name="product_mrp"
                                placeholder="MRP">
                        </div>

                        <div class="form-group">
                            <label for="field-11" class="control-label">Minimum Stocks</label>
                            <input type="number" min="0" class="form-control product_min_stock" name="product_min_stock"
                                placeholder="Minimum Stocks">
                        </div> 

                        <div class="form-group">
                            <label for="field-12" class="control-label">Status</label>
                            <select class="form-control status" name="status">
                                <option value="">Select</option>
                                <option value="1" selected>Active</option>
                                <option value="0">De-Active</option>
                            </select>
                        </div>-->
                        <div class="col-sm-12 form-group">
                            <p style="text-align: right;"> <span class="required-field">*</span> Required field</p>
                            <p style="text-align: center;" id="response_submit">&nbsp</p>
                            <div class="text-center">        
                                <input type="hidden" name="form_type" id="form_type" value="add">
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">                       
                                <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>                            
                                <a href="<?php echo base_url() ?>product_details"> <button type="button" class="btn btn-info">Reset</button></a>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    

</div>
<script>
/*$("#add").on("shown.bs.modal", function () {
    //$("#ProductForm")[0].reset();
});
$("#add").on("hide.bs.modal", function () {
    //Action while closing
});*/
$("input").keypress(function(){
    $(this).css("border", "1px solid #ebebeb");
});
$("select").change(function(){
    $(this).css("border", "1px solid #ebebeb");
});
function open_form(type){    
    if(type){
        if(type.toLowerCase()=="add"){
            $("#ProductForm")[0].reset();
            $("#form_type").val("add");
            $('#category_id').removeAttr('disabled');
            $("#add_modal_btn").click();
        }
        else if(type.toLowerCase()=="edit"){
            $("#ProductForm")[0].reset();
            $("#form_type").val("edit");
            $("#add_modal_btn").click();
        }
    }
}
function set_filter(){
    var base_url = '<?php echo base_url(); ?>';
    var category_id = $("#filter_category").val();

    if(base_url){
        var path=base_url+'product_details/set_filter';
        //alert(path);
        $.ajax({
            type: "POST",
            url: path,
            data: "category_id="+category_id+'&action=set_filter',
            success: function(e){
                //alert(e);
                if(e==1){
                    window.location.reload();
                }
            }
        });
    }
}
function clear_filter(){
    var base_url = '<?php echo base_url(); ?>';
    if(base_url){
        var path=base_url+'product_details/clear_filter';
        //alert(path);
        $.ajax({
            type: "POST",
            url: path,
            data: 'action=clear_filter',
            success: function(e){
                //alert(e);
                if(e==1){
                    window.location.reload();
                }
            }
        });
    }
}
function isOthersCategory(id, catId) {
    if (catId == 'Others') {
        $("." + id + "_new_category").slideDown("fast");

    }
    else {
        $("." + id + "_new_category").slideUp("fast");

        generate_product_code(catId);
    }
}

function generate_product_code(catId) {
    
    var base_url = '<?php echo base_url(); ?>';
    if(base_url){
        var path=base_url+'product_details/generate_product_code';
        $.ajax({
            type: "POST",
            url: path,
            data: 'category_id='+catId,
            success: function(e){
                //alert(e);
                var res = ($.trim(e));
                $(".product_code").val(res);
            }
        });
    }
}

</script>