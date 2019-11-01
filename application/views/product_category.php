<div class="row" ng-app="Common_app" ng-controller="Product_category_controller">
    <div class="col-lg-10 col-xs-offset-1">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title">Product Category</div>
            </div>
            <div class="panel-body">
                <div class="row">   
                    <?php
                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>  
                        <div class="col-lg-4 mentu-bottom">
                            <button type="button" class="btn btn-primary btn-md"  onclick="open_form('add')">Add New</button>
                        </div>  <?php
                    }?>             
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
                                    <th>Product category</th>
                                    <th>Cateogry Description</th>
                                    <th>Status</th>
                                    <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>   
                                        <th>Action</th>
                                        <?php
                                    }?> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in searched = (product_category | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit" ng-class="{'disable':data.status==0}">
                                    <td>{{(current_grid*10 - 9) + $index}}</td> 
                                    <td>{{data.product_category}}</td>
                                    <td ><span ng-if="data.product_details==null">-</span> <span ng-if="data.product_details!=null" >{{data.product_details}}</span></td>                                  
                                    <td ng-if="data.status == 0"><span class="label label-danger">Deactive</span></td>
                                    <td ng-if="data.status == 1"><span class="label label-success">Active</span></td>
                                     <?php
                                    if($this->session->userdata('user_type')==ROOT_ADMIN || $this->session->userdata('user_type')==SUPER_ADMIN){ ?>
                                        <td style="width:3cm;">
                                            <button type="button" class="btn btn-sm btn-primary waves-effect" data-toggle="modal" data-target="#edit" ng-click="edit_category_details(data.category_id)">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>                                       
                                            <button type="button" class="btn btn-sm btn-danger waves-effect" ng-if="data.status == 1"
                                                ng-click="disable_category(data.category_id, data.status)">
                                                <i class="fa fa-close pro-active" aria-hidden="true"></i>                                            
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success waves-effect" ng-if="data.status == 0"
                                                ng-click="disable_category(data.category_id, data.status)">                                            
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
                            items-per-page="data_limit" class="pagination-small pull-right" previous-text="&laquo;"
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
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Category</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="addProductCategoryForm" method="post" class="addproduct_category_submit" ng-submit="product_category_submit('add')"
                        autocomplete="off">

                        <div class="form-group">
                            <label for="product_category" class="control-label">Category Name</label>
                            <input type="text" class="form-control product_category"  value="" name="product_category" id="product_category" placeholder="Enter name of category" >                            
                        </div>

                        <div class="form-group">
                            <label for="short_name" class="control-label">Short Name</label>
                            <input type="text" class="form-control short_name" name="short_name" id="short_name" onkeyup="this.value = this.value.toUpperCase();" placeholder="Short name of category" >
                        </div>
                        
                        <div class="form-group">
                            <label for="category_details" class="control-label">Description</label>
                            <textarea type="text" class="form-control category_details" name="category_details" rows="3"> </textarea>
                        </div>

                        <div class="form-group">
                            <label for="field-12" class="control-label">Status</label>
                            <select class="form-control status" name="status" id="category_status">
                                <option value="">Select</option>
                                <option value="1" selected>Active</option>
                                <option value="0">DeActive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <p style="text-align: center;" id="category_response">&nbsp</p>
                            <input type="hidden" name="form_type" value="add">
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
                            <div class="text-center"><button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-success">Reset</button>
                        </div>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#edit" id="edit_modal_btn" style="display: none;"></button>
    <!-- Modal -->
    <div id="edit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit New Product</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="editProductCategoryForm" method="post" class="addproduct_category_submit" ng-submit="product_category_submit('edit')"
                        autocomplete="off">

                        <div class="form-group">
                            <label for="product_category" class="control-label">Category Name</label>
                            <input type="text" class="form-control product_category"  value="" name="product_category" id="edit_product_category" placeholder="Enter name of category" >                            
                        </div>

                        <div class="form-group">
                            <label for="short_name" class="control-label">Short Name</label>
                            <input type="text" class="form-control short_name" name="short_name" id="edit_short_name" onkeyup="this.value = this.value.toUpperCase();" placeholder="Short name of category" >
                        </div>
                        
                        <div class="form-group">
                            <label for="category_details" class="control-label">Description</label>
                            <textarea type="text" class="form-control category_details" name="category_details" id="edit_category_details" rows="3"> </textarea>
                        </div>

                        <div class="form-group">
                            <label for="field-12" class="control-label">Status</label>
                            <select class="form-control status" name="status" id="edit_category_status">
                                <option value="">Select</option>
                                <option value="1" selected>Active</option>
                                <option value="0">DeActive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <p style="text-align: center;" id="edit_category_response">&nbsp</p>
                            <input type="hidden" name="category_id" id="edit_category_id" value="">
                            <input type="hidden" name="form_type" value="edit">
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
                            <div class="text-center"><button type="submit" class="btn btn-success">Submit</button>
                            <!--<button type="reset" class="btn btn-success">Reset</button>-->
                        </div>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
$("input").keypress(function(){
    $(this).css("border", "1px solid #ebebeb");
});
$("select").change(function(){
    $(this).css("border", "1px solid #ebebeb");
});
function open_form(type){
    if(type){
        if(type.toLowerCase()=="add"){
            $("#addProductCategoryForm")[0].reset();
            $("#form_type").val("add");
            $("#add_modal_btn").click();
        }
        else if(type.toLowerCase()=="edit"){
            $("#ProductForm")[0].reset();
            $("#form_type").val("edit");
            $("#edit_modal_btn").click();
        }
    }
}
</script>