<div class="row" ng-app="Common_app" ng-controller="salesProduct_controller">
    <div class="col-lg-12 col-xs-offset-0">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Sales Product</div>
            </div>
            <div class="panel-body"><br>
                <form method="post" class="sales_product_Stall_sub" ng-submit="sales_product_Stall_sub()" enctype="multipart/form-data">
                    <div class="form-group">
                        <label style="text-transform: uppercase">Select a Stall</label>
                        <input type="hidden" class="sales_stock_id" name="sales_stock_id" value="0">
                        <select class="form-control edit_form get_stalls  input-lg" name="get_stalls" ng-model="get_stalls" required  ng-change="getSalesProducts(get_stalls)" style="width:auto; color: #777; font-weight: bold" required>
                            <option value="">---- Select  ----</option>
                            <?php 
                            foreach($get_stores_stall as $stall){ 
                                if(!$this->session->userdata('store_code')){ ?>
                                    <option value="<?php echo $stall['stall_code']; ?>">
                                        <?php echo $stall['store_name']." - ".$stall['stall_name']." (".$stall['stall_code'].")"; ?></option> <?php
                                }
                                else {?>
                                    <option value="<?php echo $stall['stall_code']; ?>">
                                        <?php echo $stall['stall_name']." (".$stall['stall_code'].")"; ?></option> <?php 
                                }
                            }?>
                        </select>
                    </div>
                    <br>
                    <div class="row ">
                        <?php foreach($sales_products as $products){?>
                            <div class="col-sm-2 ">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label><input type="checkbox" class="salesProdus salesProdus<?php echo $products['sales_product_id'] ?>" name="salesProdus[]" value="<?php echo $products['sales_product_id'] ?>"><span style="position: relative; top: 9px;"><?php echo $products['sales_product_name']." (".$products['sales_product_type'].")"; ?></span></label>
                                    </div>
                                </div>
                            </div>
                        <?php  }?>
                    </div>

                    <br>
                    <br>
                    <center>
                       <?php
                        if($this->session->userdata('user_type')==STORE_MANAGER) {?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <?php
                        } 
                        else{
                            echo '<h4 style="color: #ccc; text-align: center; margin: 20px auto;">Select a stall and see their sales product which are assigned by their Store manager</h4>';
                        }?>
                       
                    </center>                           
                </form>             
            </div>
        </div>
    </div>

     
</div>  

