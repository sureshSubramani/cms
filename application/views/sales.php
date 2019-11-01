<div class="container-fluid" ng-app="Common_app" ng-controller="Sales_controller" ng-init="loadSalesProducts(); fetchProducts();">
    <?php if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p><strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?></p>
    </div>
    <?php } else if($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p><strong>Warning!</strong> <?php echo $this->session->flashdata('error'); ?></p>
    </div>
    <?php }?>
    <style type="text/css">
        .product_img{
            width: 100%;
            max-height: 100px;
            overflow: hidden;
        }
        .product_img img{
            width: 100%;
            min-height: 100px;
            height: auto;
        }
        .text-info-wrap{
            height: 40px;
            overflow: hidden;
        }
        .text-info{
            line-height: 17px;
            font-weight: bold;
            min-height: 35px;
            overflow: hidden;
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>
    <div class="row">
        <?php if(!$this->session->userdata('stall_code')){?>
        <div class="col-lg-12">
            <?php }?>
            <?php if($this->session->userdata('stall_code')){?>
            <div class="col-lg-8">
                <?php }?>
                <form method="post">
                    <div class="row">
                        <!--{{Sales}}-->
                        <div class="col-md-4 col-lg-2" ng-repeat="data in Sales">
                            <div class="card" title="Add" ng-if="data.available_qty != 0" data-toggle="tooltip" data-placement="top" tooltip
                                ng-click="addItem(data.sales_product_id, data.sales_product_name, data.price)">
                                <div class="product_img">
                                    <img ng-src="assets/images/sales_product/{{data.image}}" class="img-responsive" alt="Product Image" />
                                </div>
                                <div class="box-contant text-center">
                                    <div class="text-info-wrap">
                                        <h5 class="text-info">
                                            <div ng-if="data.sales_product_name!=''" class="text-upperccase">{{data.sales_product_name}}</div>
                                            <div ng-if="data.sales_product_type!=''">{{data.sales_product_type}}</div>
                                        </h5>
                                    </div>
                                    <h3>Rs. {{data.price}}</h3>                                    
                                    <h6>
                                        <span ng-if="data.available_qty > 0" class='text-success'>Available Stock: {{data.available_qty}}</span>
                                        <span ng-if="!data.available_qty" class='text-danger'>Out Of Stock</span>                                                                           
                                    </h6>
                                    <div ng-repeat="stock in stockQty">
                                        <h1>{{stock.quantity}}</h1>
                                    </div>  
                                </div>                                    
                            </div>
                            <div class="card" ng-class="{'disabled-out-of-stock':data.available_qty==0}" ng-if="data.available_qty == 0">
                                <div class="product_img">
                                    <img ng-src="assets/images/sales_product/{{data.image}}" class="img-responsive" alt="Product Image" />
                                </div>
                                <div class="box-contant text-center">
                                    <div class="text-info-wrap">
                                        <h5 class="text-info">
                                            <div ng-if="data.sales_product_name!=''" class="text-upperccase">{{data.sales_product_name}}</div>
                                            <div ng-if="data.sales_product_type!=''">{{data.sales_product_type}}</div>
                                        </h5>
                                    </div>
                                    <h3>Rs. {{data.price}}</h3>                                    
                                    <h6>
                                        <span ng-if="data.available_qty > 0" class='text-success'>Available Stock: {{data.available_qty}}</span>
                                        <span ng-if="!data.available_qty" class='text-danger'>Out Of Stock</span>                                                                           
                                    </h6>
                                    <div ng-repeat="stock in stockQty">
                                        <h1>{{stock.quantity}}</h1>
                                    </div>  
                                </div>                               
                            </div>
                            <br/>  
                            <div class="col-sm-12 text-center " style="cursor: pointer;">
                                <span type="button" class="label label-info" data-toggle="modal" data-target="#view{{data.sales_product_id}}" style="z-index: 100">
                                    Ingredients <i class="fa fa-forward"></i>
                                </span><br> 
                            </div>
                            <!-- Modal -->
                            <div id="view{{data.sales_product_id}}" class="modal modal{{data.sales_product_id}} fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="col-sm-12 modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">
                                                Incredients
                                                <span ng-if="data.sales_product_name!=''"> for {{data.sales_product_name}}</span>
                                                <span ng-if="data.sales_product_type!=''"> - {{data.sales_product_type}}</span>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped incredients-tbl">
                                                <tr>
                                                    <th style="padding: 7px !important;">Product</th>
                                                    <th style="padding: 7px !important;">Stock</th>
                                                    <th style="padding: 7px !important;">Needed for prepare</th>
                                                    <th style="padding: 7px !important;">No.of possible</th>
                                                </tr>
                                                <tr ng-repeat="data2 in data.incredients ">
                                                    <th class="">{{data2.product_name}}</th>
                                                    <td class="">
                                                        <span ng-if="data2.stock_qty">{{data2.stock_qty}} </span>
                                                        <span ng-if="data2.stock_qty" class="text-lowercase">{{data2.uom}}</span>
                                                    </td>
                                                    <td class="">
                                                        
                                                        <span ng-if="data2.incredient_qty" class="text-lowercase">
                                                            <span ng-if="(data2.uom=='KG' || data2.uom=='kg') && data2.incredient_qty!='' && data2.incredient_qty<1">{{data2.incredient_qty * 1000}} g</span> 
                                                            <span ng-if="(data2.uom=='L' || data2.uom=='l') && data2.incredient_qty!='' && data2.incredient_qty<1">{{data2.incredient_qty * 1000}} ml</span> 
                                                            <span ng-if="data2.uom=='NOs' || data2.uom=='nos' || data2.incredient_qty>=1">{{data2.incredient_qty }} {{data2.uom}}</span>
                                                            <!--<span ng-if="">{{data.incredient_qty * 1000}} {{data.uom}}</span>     -->
                                                        </span>
                                                    </td>
                                                    <td class="">
                                                        <span style="">{{data2.available_qty}}</span>
                                                        <span style="font-size: 11px; color: #bbb; " ng-if="data2.available_qty && data.sales_product_name!=''"> {{data.sales_product_name}}</span>
                                                        <span style="font-size: 11px; color: #bbb; " ng-if="data2.available_qty && data.sales_product_type!=''"> - {{data.sales_product_type}}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                  
                        </div>

                    </div>

                </form>
                <div class="col-lg-12" ng-show="searched.length == 0">
                    <div class="col-md-12">
                        <h4 class="is-not-serach">Sales products are empty.</h4>
                    </div>
                </div>
                <!-- <?php print_r($_SESSION['sales_cart']);  ?>
            <?php echo $this->session->userdata('store_code'); echo " ".$this->session->userdata('stall_code'); ?> -->
            </div>
            <?php if($this->session->userdata('stall_code')){?>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Your Cart Details</div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tableData">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                    <th class="actions">Action</th>
                                </tr>
                                <tr ng-repeat="data in salesCarts ">
                                    <td>{{data.sales_product_name}}</td>
                                    <td>
                                        <span class='shape' ng-click="minusQty(data.sales_product_id)"><i
                                                class='fa fa-minus minus-color'></i></span>
                                        {{data.quantity}}
                                        <span class="shape" ng-click="plusQty(data.sales_product_id)"><i
                                                class='fa fa-plus plus-color'></i></span>
                                    </td>
                                    <td>{{data.price}} Rs.</td>
                                    <td>{{data.quantity * data.price}} Rs.</td>
                                    <td class="actions"><button type="button" name="removeItem"
                                            class="btn btn-danger btn-xs"
                                            ng-click="removeItem(data.sales_product_id)"><i
                                                class='fa fa-trash-o'></i></button></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Total</td>
                                    <td colspan="2">{{ setTotals(); }} Rs.</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-lg-12" ng-show="salesCarts.length == 0">
                            <div class="col-md-12">
                                <h4 class="is-not-serach">Cart is empty..</h4>
                            </div>
                        </div>
                        <div class="pull-right"><button class="btn btn-sm btn-success printData"
                                ng-click='print(salesCarts)' ng-if="setTotals()!=0">Print</button> <button
                                class="btn btn-sm btn-danger" ng-click="clearCart()"
                                ng-if="setTotals()!=0">Clear</button></div>
                    </div>
                    <!-- <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"> -->

                    <div class="print_page" id="printTable" style="display: none;">
                        <div class='text-center'>
                            <span style="font-size: 14px; margin-bottom: 10px;  font-weight: normal;">#25821</span>
                            <span
                                style="font-size: 20px; margin-bottom: 10px; text-align:center; font-weight: normal;">RECEIPT</span>
                        </div>
                        <hr />
                        <table class="table table-bordered table-striped" style="border:1px solid #ccc" id="tableData">
                            <tr>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Sub Total</th>
                            </tr>
                            <tr ng-repeat="cart in salesCarts">
                                <td>{{cart.sales_product_name}}</td>
                                <td>{{cart.quantity}}</td>
                                <td>{{cart.price}} Rs.</td>
                                <td>{{cart.quantity * cart.price}} Rs.</td>
                            </tr>
                            <tr style="border-top:1px solid #ccc;">
                                <td colspan="3" class="text-right">Total</td>
                                <td colspan="2">{{ setTotals() }} Rs.</td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align:center; font-weight:300;">Thank You Visit Again..!
                                </th>
                            </tr>
                        </table>
                    </div>
                    <!-- </iframe> -->
                </div>
            </div><?php } ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {

        var base_url = "<?php echo base_url().'sales'; ?>";

        if (base_url) {

            $('.page-container').toggleClass('sidebar-collapsed');

            $('.sidebar-collapse-icon').on('click', function() {
                $('.page-container').toggleClass('');
            })
        }
    });

    function printData() {

        var generator = window.open("");
        var layerText = document.getElementById('printTable');
        generator.document.write(layerText.innerHTML.replace("Print Me"));
        generator.document.close();
        generator.print();
        generator.close();

        /*window.document.body.innerHTML = document.getElementById("printTable").innerHTML;
        window.focus();
        window.print(); */

        //$(win.document.body).find('table').find('.actions').css('display', 'none');
    }

    $('.printData').on('click', function() {
        printData();
    });
    </script>