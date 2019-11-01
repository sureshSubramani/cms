<div class="row" ng-app="Common_app" ng-controller="salesProduct_controller">
     <?php
       if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>  
        <div class="col-lg-6 col-xs-offset-0">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Sales Product</div>
                </div>
                <div class="panel-body">
                    
                	<form method="post" class="sales_product_sub" ng-submit="sales_product_sub()" enctype="multipart/form-data">
                        <div class="col-sm-12" id="sales_product-wrap">
                            <h5 class="text-uppercase text-centser" style="opacity: .6; font-weight: bold;color: #e91e63;">Product Details:</h5><hr>
                        </div>
                        <div class="" id="sales_product-wrap">
        					<div class="col-sm-12 form-group">
        	                    <label for="field-1" class="control-label">Sales product name <span class="required-field">*</span></label>
        	                    <input type="hidden" class="form-control sales_product_id" value="0" name="sales_product_id" placeholder="Prodcut Name" required="">                            
        	                    <input type="text" class="form-control sales_product_name" value="" name="sales_product_name" placeholder="Prodcut Name" required="">                            
        	                </div>
        	                <div class="col-sm-6 form-group">
        	                    <label for="field-1" class="control-label">Sales product type</label>
        	                    <input type="text" class="form-control sales_product_type" value="" name="sales_product_type" placeholder="Prodcut Type" >                            
        	                </div> 
        	                <div class="col-sm-6 form-group">
        	                    <label for="field-1" class="control-label">Min Quantity <span class="required-field">*</span></label>
        	                    <input type="text"  min="0" class="form-control product_min_quantity" step="1" value="" name="product_min_quantity" placeholder="Minimum Quantity" required="">                            
        	                </div>    

        	                <div class="col-sm-6 form-group">
        	                    <label for="field-1" class="control-label">Product image</label>	       
        	                    <input type="hidden" class="form-control product_image_edit"   value="" name="product_image_edit"   required="">          
        	                    <input type="file" class="form-control product_image" accept="image/*" value="" name="product_image" placeholder="Prodcut Code" >                            
        	                </div>   

        					<div class="col-sm-6 form-group">
        	                    <label for="field-1" class="control-label">Price <span class="required-field">*</span></label>	                 
        	                    <input type="text" min="0" class="form-control product_price" value="" name="product_price" placeholder="Price" required="">                            
        	                </div>
                        </div>
                        <br>
    	                <div class="" id="sales_incredians-wrap">
                            <div class="col-sm-12" >
                                <h5 class="text-uppercase text-centxer" style="opacity: .6; font-weight: bold;color: #e91e63;">Incredians Details:</h5><hr>
                            </div>
                            <div class="row col-sm-12  removeclass0" style="margin-bottom: 0px;">
                                <div class="col-sm-4 required">
                                    <label class="control-label ">Product </label>
                                    <div class="form-group">
                                    	<input type="hidden" class="ingredients_id ingredients_id0" name="ingredients_id[]">
                                        <select required="" class="form-control edit_form get_products product_code product_code0" onChange="getPurchaseQtyUOM('0', this.value)" name="product_code[]" required>
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
                                            <?php 
                                            /*foreach($GetProducts as $products){ ?>
                                            	<option value="<?php echo $products['product_code']; ?>"><?php echo $products['product_name']; ?></option>
                                                <?php 
                                            }*/?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 required">
                                    <label class="control-label ">Quantity</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control edit_form quantity quantity0" name="quantity[]" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" placeholder="Quantity" required>
                                        <span class="product_qty_uom0" style="color:#cc2424; font-weight: bold"></span>
                                        <input type="hidden" class="form-control edit_form uom uom0 product_qty_uom0" name="uom[]" value="" placeholder="UOM">
                                    </div>
                                </div>

                                <?php /*
                                <div class="col-sm-3 required">
                                    <label class="control-label" title="Unit Of Measurement">UOM</label>
                                    <div class="form-group">
                                    <select required="" class="form-control edit_form get_uom uom uom0" name="uom[]" required>
                                           <option value="">----- Select -----</option>         
                                           <?php foreach($GetUOM as $uom){ ?>
                                            	<option value="<?php echo $uom['uom']; ?>"><?php echo $uom['uom']; ?></option>
                                            <?php }?>                                       
                                     </select>
                                    </div>
                                </div>

                             

                                <div class="col-sm-1">
                                    <label class="control-label">Remove</label>
                                    <!-- <button class="btn btn-danger " type="button" onclick="remove_achive_fields(0);"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button> -->
                                </div> */ ?>

                            </div>
                        </div>

    	                <div class="col-sm-12 text-center">
                            <p class="error_sales_product"></p>
                            <button class="btn btn-success" type="button" onclick="sales_incredians();">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
                            </button>
                            <a href="<?php echo base_url() ?>sales_products"> <button type="button" class="btn btn-danger">
                                <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
                            </a>
    	                	<button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-forward" aria-hidden="true"></span> Submit
                            </button>


                           
    	                </div>   	                    
                    </form>           	
                </div>
            </div>
        </div>
         <?php
    }

    if($this->session->userdata('user_type') == ROOT_ADMIN || $this->session->userdata('user_type') == SUPER_ADMIN) { 
        echo '<div class="col-sm-6 col-xs-offset-0">'; 
    }
    else{
        echo '<div class="col-sm-12">';
    } ?>

    
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-title">View Sales Product</div>
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
                                   <th>Sl No</th> 
                                    <th>Product Name</th>
                                    <th>Minimum Quantity</th>
                                    <th>Price (in Rs).</th>
                                    <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>  
                                        <th>Action</th>
                                        <?php 
                                    }?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (Common_details | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit" title="{{data.description}}">
                                    <td>{{(current_grid*10 - 9) + $index}}</td> 
                                    <td>
                                        <span ng-if="data.sales_product_name!=''">{{data.sales_product_name}} </span>
                                        <span ng-if="data.sales_product_type!=''">({{data.sales_product_type}}) </span>
                                    </td>
                                    <td >{{data.min_quantity}}</td>
                                    <td >{{data.price}}</td> 
                                    <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>    
                                        <td style="width:3cm;">
                                            <button type="button" class="btn btn-sm btn-primary waves-effect"   ng-click="edit_salesProductDetails(data.sales_product_id)">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>                                       
                                            <button type="button" class="btn btn-sm btn-info waves-effect" ng-if="data.status == 1"
                                                ng-click="view_products(data.sales_product_id,data.sales_product_name)" data-toggle="modal" data-target="#ViewSalesProInc" >
                                                <i class="fa fa-eye pro-active" aria-hidden="true"></i>                                            
                                            </button>
                                             
                                        </td> <?php
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

<div id="AddStallsInSalesProducts" class="modal fade in" role="dialog" style="display: none; padding-left: 17px;">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Stalls with Sales Product</h4>
            </div>
            <div class="modal-body">
               	<form role="form" id="ProductForm" method="post" class="product_details_submit ng-pristine ng-valid" ng-submit="product_details_submit()" autocomplete="off">
 
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

<div id="ViewSalesProInc" class="modal fade in" role="dialog" style="display: none; padding-left: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title view_title_sales_pro"> </h4>
            </div>
            <div class="modal-body">
               <table class="table table-bordered">
               		<thead>
               			<tr>
               				<th>Sl No</th>
                            <th>Product Name</th>
               				<th>Product Code</th>
               				<th>Quantity</th>
               			</tr>
               		</thead>

               		<tbody>
               			<tr ng-if="ViewIncredians.length !=0" ng-repeat="data in ViewIncredians">
               				<td>{{$index + 1}}</td>
               				<td>
                                <span ng-if="data.product_name!=''">{{data.product_name}} </span>
                                <span ng-if="data.brand_name!=''">{{data.brand_name}} </span>
                                <span ng-if="data.product_type!=''">{{data.product_type}} </span>
                            </td>
                            <td>{{data.product_code}}</td>
                            <td>
                                <span ng-if="(data.uom=='KG' || data.uom=='kg') && data.quantity!='' && data.quantity<1">{{data.quantity * 1000}} g</span> 
                                <span ng-if="(data.uom=='L' || data.uom=='l') && data.quantity!='' && data.quantity<1">{{data.quantity * 1000}} ml</span> 
                                <span ng-if="data.uom=='NOs' || data.uom=='nos' || data.incredient_qty>=1">{{data.incredient_qty }} {{data.uom}}</span>
                                <!--<span ng-if="">{{data.quantity * 1000}} {{data.uom}}</span> 	-->
                            </td> 
               			</tr>

               			<tr ng-if="ViewIncredians.length == 0"  >
               				<td colspan="4">No result found </td> 	
               			</tr>
               		</tbody>
               </table>
            </div>
        </div>
    </div>
</div>
 

<script>
function getPurchaseQtyUOM(id, pcode) {
    $.ajax({
        type:'post',
        url:'sales_products/Get_Product_UOM',
        data:'product_code='+pcode,
        success:function(data){
            var e = JSON.parse(data);
            //alert(e.uom);
            if(e.uom){
                //STOCK AVAILABLE
                $(".quantity"+id).removeAttr("readonly");
                $(".amount"+id).removeAttr("readonly");
                $(".quantity"+id).val("");
                $(".amount"+id).val("");
                $(".uom"+id).val(e.uom);
                $(".error_sales_product").html("");

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
                //NO STOCK AVAILABLE
                $(".quantity"+id).attr("readonly", "true");
                $(".amount"+id).attr("readonly", "true");
                $(".quantity"+id).val("");
                $(".amount"+id).val("");
                $(".uom"+id).val("");
                $(".error_sales_product").html("");

                $(".product_qty_uom"+id).html("");
            }
        }
    });
}
</script>