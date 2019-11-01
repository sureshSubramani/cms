function search_locker_id(ele) {

    if (event.key === 'Enter') {
        if (ele.value != '') {
            var locker_id = ele.value;

            $.ajax({
                type: 'post',
                url: 'locker/GetLocker',
                data: { 'locker_id': locker_id },
                success: function (data) {
                    //console.log(data);

                    $('.view_datassss').empty();;

                    var json_data = JSON.parse(data);

                    var k = 1;

                    if (json_data.length == 0) {

                        $('.view_datassss').append(

                            '<tr>' +
                            '<td colspan="5"> No Result Found</td>' +
                            '</tr>'
                        );
                    }
                    else {
                        for (var i = 0; i < json_data.length; i++) {
                            $('.view_datassss').append(

                                '<tr>' +
                                '<td>' + k++ + '</td>' +
                                '<td>' + json_data[i]['bill_id'] + '</td>' +
                                '<td>' + json_data[i]['no_of_locker'] + '</td>' +
                                '<td>' + json_data[i]['locker_no'] + '</td>' +
                                '<td><button type="button" class="btn btn-danger" onclick="remover_lockers(' + json_data[i]['locker_id'] + ')">Remove</td>' +
                                '</tr>'

                            );
                        }
                    }



                }
            });
        }
    }
}

function remover_lockers(locker_id) {
    if (confirm('Confirm to delete..!')) {
        $.ajax({

            type: 'post',
            url: 'locker/RemoveLocker',
            data: { 'locker_id': locker_id },
            success: function (data) {
                location.reload();
            }
        });
    }
}

function store_details_submit(pid) {

    document.getElementById('printOne').disabled = !(pid === 'printOne');

    window.print();
}

function ticket_entry_sub(pid) {

    document.getElementById('printOne').disabled = !(pid === 'printOne');

    window.print();
}

$.ajax({
    type: 'get',
    url: 'locker/GetCheckedLocker',
    success: function (data) {

        var json_parse = JSON.parse(data);

        //console.log(json_parse);

        for (var i = 0; i < json_parse.length; i++) {
            $('.edit_check_box' + json_parse[i]).prop("checked");
            $('.seat_disabled' + json_parse[i]).removeAttr("onclick");
            $('.token_design' + json_parse[i]).removeClass('token_design').addClass('checked_token_design');
        }
    }
})


function btn_check_check_box(id) {

    if ($('.edit_check_box' + id).prop("checked") == true) {
        $('.edit_check_box' + id).prop('checked', false);
        $('.token_design' + id).removeClass('checked_token_design').addClass('token_design');
        $('.checked_token' + id).val('');
    } else {
        $('.edit_check_box' + id).prop('checked', true);
        $('.token_design' + id).removeClass('token_design').addClass('checked_token_design');
        $('.checked_token' + id).val(id);
    }

    var token_array = [];
    var token_strig = '';
    $('.checked_token').each(function () {
        if ($(this).val() != '') {
            token_array.push($(this).val());
            if (token_strig == '') {
                token_strig = $(this).val();
            }
            else {
                token_strig = token_strig + ',' + $(this).val();
            }
        }
    });

    $('.locker_no').val(token_strig);
    $('.print_ticket_list').text(token_strig);
    $('.print_no_lockr').text(token_array.length);

    $('.no_of_locker').val(token_array.length);

    add_amnt_locker();

}

function add_amnt_locker() {

    var no_of_locker = $('.no_of_locker').val();
    var rent_amnt = $('.rent_amnt').val();
    var discount_amnt = $('.discount_amnt').val();

    var total_rent = parseInt(rent_amnt) * parseInt(no_of_locker);

    var total_discount = parseInt(discount_amnt) * parseInt(no_of_locker);

    $('.total_rent').val(total_rent);
    $('.print_rent_amnt').text(total_rent);
    $('.total_amnt').val(total_discount);
    $('.print_total_amnt').text(total_discount);

    console.log(no_of_locker, rent_amnt, discount_amnt);
}

$(document).ready(function () {

    // common_date_picker
    var currentDate = new Date();
    //$("#mydate").datepicker("setDate",currentDate);

    $('.common_date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    }, 'setDate', 'today');
    $('.common_date_picker').datepicker("setDate", currentDate);

});

function get_Percentage(val) {

    var adult_amnt = $('.adult_amnt').val();

    var child_amnt = $('.child_amnt').val();

    if (val == '5D' || val == '50D') {

        var percent_val = 0;

        if (val == '5D') {
            percent_val = 5;
        }
        else {
            percent_val = 50;
        }

        var adult_percent = (parseFloat(adult_amnt) * parseFloat(percent_val / 100));

        var child_percent = (parseFloat(child_amnt) * parseFloat(percent_val / 100));

        $('.offer_amnt').val(parseFloat(parseFloat(adult_percent) + parseFloat(child_percent)));

        $('.amount_audlt_txt').text(parseFloat(parseFloat(adult_amnt) - parseFloat(adult_percent)));

        $('.amount_child_txt').text(parseFloat(parseFloat(child_amnt) - parseFloat(child_percent)));

        $('.adult_amnt_change').val(parseFloat(parseFloat(adult_amnt) - parseFloat(adult_percent)));

        $('.child_amnt_change').val(parseFloat(parseFloat(child_amnt) - parseFloat(child_percent)));
    }
    else if (val == '3rd' || val == '8th' || val == '12th') {

        var std_amnt = 0;

        if (val == '3rd') {
            std_amnt = 250;
        }
        else if (val == '8th') {
            std_amnt = 275;
        }
        else {
            std_amnt = 300;
        }

        $('.offer_amnt').val(parseFloat(parseFloat(child_amnt) - parseFloat(std_amnt)));

        $('.amount_audlt_txt').text(parseFloat(parseFloat(adult_amnt)));

        $('.amount_child_txt').text(parseFloat(parseFloat(child_amnt) - parseFloat(std_amnt)));

        $('.adult_amnt_change').val(parseFloat(parseFloat(adult_amnt)));

        $('.child_amnt_change').val(parseFloat(parseFloat(child_amnt) - parseFloat(std_amnt)));


    }
    else {
        $('.offer_amnt').val(0);

        $('.amount_audlt_txt').text(parseFloat(parseFloat(adult_amnt)));

        $('.amount_child_txt').text(parseFloat(parseFloat(child_amnt)));

        $('.adult_amnt_change').val(parseFloat(parseFloat(adult_amnt)));

        $('.child_amnt_change').val(parseFloat(parseFloat(child_amnt)));
    }

    common_amnt_value();

    // console.log(val,child_amnt,adult_amnt,adult_percent,child_percent);
}

function common_amnt_value() {

    var adult = $('.adult').val();

    var child = $('.child').val();

    var adult_amnt_change = $('.adult_amnt_change').val();

    var child_amnt_change = $('.child_amnt_change').val();

    var total_adult = (parseFloat(adult_amnt_change) * parseFloat(adult));

    var total_child = (parseFloat(child_amnt_change) * parseFloat(child));


    $('.count_adult_td').text(adult);
    $('.amnt_adult_td').text(total_adult);

    $('.count_child_td').text(child);
    $('.amnt_child_td').text(total_child);

    $('.Ovrall_total_td').text((parseFloat(total_adult) + parseFloat(total_child)));

    $('.total_amnt').val((parseFloat(total_adult) + parseFloat(total_child)));

}

var mp_id = 0;
function movementTracker() {
    $('.product_code' + mp_id).css("border", "1px solid #ebebeb");
    $('.quantity' + mp_id).css("border", "1px solid #ebebeb");
    var pre_product_code = $('.product_code' + mp_id).val();
    var pre_quantity_of_mp = $('.quantity' + mp_id).val();
    //alert('.product_code' + mp_id);

    //Append if previous dropdown has selected and previous quantity is above 0
    if (pre_product_code != "" && pre_product_code != undefined && pre_quantity_of_mp > 0) {
        mp_id++;
        var objTo = document.getElementById('movementTracker_incredians')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "remove_all form-group removeclass" + mp_id);
        var rdiv = 'removeclass' + mp_id;
        divtest.innerHTML =
            '<div class="row col-sm-12" style="margin-top: 15px;">' +
            '<div class="col-sm-4">' +
            '<div class="form-group" >' +

            '<select required class="form-control edit_form product_code product_code' + mp_id + '" onChange="getStoreStock(\'' + mp_id + '\', this.value)" name="product_code[]" alt="' + mp_id + '" required>' +
            $('.get_products').html() +
            '</select>' +
            '<span class="stock_qty' + mp_id + '" style="color:#0d7711;opacity: .7; font-weight: bold"></span>' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-4">' +
            '<div class="form-group" >' +
            '<input type="hidden" class="form-control stock_quantity stock_quantity' + mp_id + '" name="stock_quantity[]" >' +
            '<input type="hidden"  class="form-control uom uom' + mp_id + '" placeholder="UOM" name="uom[]" readonly>' +
            '<input type="hidden"  class="form-control conversion_val conversion_val' + mp_id + '"   name="conversion_val[]" readonly>' +
            '<input type="number" required placeholder="Quantity" class="form-control edit_form quantity quantity' + mp_id + '" alt="' + mp_id + '" name="quantity[]" onkeyup="check_limited_quant(' + mp_id + ',this.value)"  required>' +
            '<span class="stock_qty_uom' + mp_id + '" style="color:#ff5722;opacity: .7; font-weight: bold"></span>' +
            '</div>' +
            '</div>' +
            /*
            '<div class="col-sm-3">' +
            '<div class="form-group" >' +
            '<input type="text"  class="form-control edit_form get_uom uom uom' + mp_id + '" placeholder="UOM" name="uom[]" readonly>' +
            '<input type="hidden"  class="form-control conversion_val conversion_val' + mp_id + '"   name="conversion_val[]" readonly>'+
            '</div>' +
            '</div>' +    */

            '<div class="col-sm-1">' +
            '<button class="btn btn-danger " type="button" onclick="remove_achive_fields(' + mp_id + ');"> ' +
            '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>' +
            '</button>' +

            '</div>' +
            '</div>'
            ;

        objTo.appendChild(divtest);
        $('.product_code' + mp_id).focus();
    }
    else if (pre_product_code == "" || pre_product_code == undefined) {
        $(".error_movement_tracker").html("<span style='color: #f37'>Select a product!</span>");
        $('.product_code' + mp_id).css("border", "1px solid #f97");
        $('.product_code' + mp_id).focus();
    }
    else if (pre_quantity_of_mp <= 0) {
        $(".error_movement_tracker").html("<span style='color: #f37'>Enter product quantity value!</span>");
        $('.quantity' + mp_id).css("border", "1px solid #f97");
        $('.quantity' + mp_id).focus();
    }
}



function getallStockDetails(val, id) {


    var selected_val = [];

    $('.product_code option:selected').each(function () {

        if ($(this).val() != '') {
            selected_val.push($(this).val());
        }

    });

    $('.product_code option').css('display', 'block');

    for (var i = 0; i < selected_val.length; i++) {

        $('.product_code > option[value="' + selected_val[i] + '"]').css('display', 'none');
    }


    if (val != '') {

        $.ajax({
            type: 'post',
            url: 'movement_tracker/GetProduct_details',
            data: { 'val': val },
            success: function (data) {
                var json_data = JSON.parse(data);
                console.log(json_data);

                $('.stock_quantity' + id).val(json_data['quantity']);
                $('.uom' + id).val(json_data['uom']);
                $('.conversion_val' + id).val(json_data['conversion_value']);

            }
        });
    }

}

function check_limited_quant(id, quantity) {
    var stock_quantity = $('.stock_quantity' + id).val();

    //console.log(id,quantity,stock_quantity);

    if (stock_quantity == '' || stock_quantity == undefined) {
        //$.alert('Please Select Product Code');
        $(".error_movement_tracker").html("<span style='color: #f37'>Select a product!</span>");
        $('.quantity' + id).val("");
    }
    else if (parseFloat(quantity) < 0) {
        $(".error_movement_tracker").html("");
        $('.quantity' + id).val("");
    }
    else if (parseFloat(stock_quantity) < parseFloat(quantity)) {
        $(".error_movement_tracker").html("");
        $('.quantity' + id).val(stock_quantity);
    }
    else {
        $(".error_movement_tracker").html("");
    }
}

var wastage_id = 0;
function wastage_products() {
    $('.product_code' + wastage_id).css("border", "1px solid #ebebeb");
    $('.quantity_of_waste' + wastage_id).css("border", "1px solid #ebebeb");
    var pre_product_code = $('.product_code' + wastage_id).val();
    var pre_quantity_of_waste = $('.quantity_of_waste' + wastage_id).val();
    //alert('.product_code' + pre_wastage_id);

    //Append if previous dropdown has selected and previous quantity is above 0
    if (pre_product_code != "" && pre_product_code != undefined && pre_quantity_of_waste > 0) {
        wastage_id++;

        var objTo = document.getElementById('wastage_products')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "remove_all form-group removeclass" + wastage_id);
        var rdiv = 'removeclass' + wastage_id;
        divtest.innerHTML =
            '<div class="row col-sm-12" style="margin-bottom: 10px;">' +

            '<div class="col-sm-4">' +
            '<div class="form-group" >' +
            '<input type="hidden" class="ingredients_id ingredients_id' + wastage_id + '" name="ingredients_id[]">' +
            '<select required class="form-control edit_form product_code' + wastage_id + '" name="product_code[]" alt="' + wastage_id + '" onChange="getStallStock(\'' + wastage_id + '\', this.value)" required>' +
            $('.get_products').html() +
            '</select>' +
            '<span class="stock_qty' + wastage_id + '" style="color:#0d7711;opacity: .7; font-weight: bold"></span>' +
            '</div>' +
            '</div>' +

            '<div class="col-sm-4">' +
            '<div class="form-group" >' +
            '<input type="hidden" class="form-control stock_quantity stock_quantity' + wastage_id + '" name="stock_quantity[]">' +
            '<input type="hidden"  class="form-control uom uom' + wastage_id + '" placeholder="UOM" name="uom[]" readonly>' +
            '<input type="hidden"  class="form-control conversion_val conversion_val' + wastage_id + '"   name="conversion_val[]" readonly>' +
            '<input type="number" onkeyup="validate_wastage_quantity(' + wastage_id + ',this.value)" required="" min="1" placeholder="Quantity" class="form-control edit_form quantity_of_waste quantity_of_waste' + wastage_id + '" name="quantity_of_waste[]" readonly required>' +
            '<span class="stock_qty_uom' + wastage_id + '" style="color:#ff5722;opacity: .7; font-weight: bold"></span>' +
            '</div>' +
            '</div>' +
            /*
            '<div class="col-sm-3">' +
            '<div class="form-group" >' +
            '<select required class="form-control edit_form GetUOM uom' + wastage_id + '" name="uom[]" alt="' + wastage_id + '" required>' +
            $('.get_uom').html() +
            '</select>' +
            '</div>' +
            '</div>' + */

            '<div class="col-sm-1">' +
            '<button class="btn btn-danger " type="button" onclick="remove_achive_fields(' + wastage_id + ');"> ' +
            '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>' +
            '</button>' +
            '</div>' +

            '</div>'
            ;



        objTo.appendChild(divtest);
        $('.product_code' + wastage_id).focus();
    }
    else if (pre_product_code == "" || pre_product_code == undefined) {
        $(".error_wastage_product").html("<span style='color: #f37'>Select a product!</span>");
        $('.product_code' + wastage_id).css("border", "1px solid #f97");
        $('.product_code' + wastage_id).focus();
    }
    else if (pre_quantity_of_waste <= 0) {
        $(".error_wastage_product").html("<span style='color: #f37'>Enter wastage quantity value!</span>");
        $('.quantity_of_waste' + wastage_id).css("border", "1px solid #f97");
        $('.quantity_of_waste' + wastage_id).focus();
    }
}


var sp_id = 0;
function sales_incredians() {
    $('.product_code' + sp_id).css("border", "1px solid #ebebeb");
    $('.quantity' + sp_id).css("border", "1px solid #ebebeb");
    var pre_product_code = $('.product_code' + sp_id).val();
    var pre_quantity = $('.quantity' + sp_id).val();
    //alert('.product_code' + sp_id);
    //alert(pre_product_code+" "+pre_quantity);

    //Append if previous dropdown has selected and previous quantity is above 0
    if (pre_product_code != "" && pre_product_code != undefined && pre_quantity > 0) {
        sp_id++;
        var objTo = document.getElementById('sales_incredians-wrap')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "remove_all form-group removeclass" + sp_id);
        var rdiv = 'removeclass' + sp_id;
        divtest.innerHTML =
            '<div class="row col-sm-12" style="margin-bottom: 0px;">' +
            '<div class="col-sm-4">' +
            '<div class="form-group" >' +
            '<input type="hidden" class="ingredients_id ingredients_id' + sp_id + '" name="ingredients_id[]">' +
            '<select required class="form-control edit_form product_code product_code' + sp_id + '"  onChange="getPurchaseQtyUOM(\'' + sp_id + '\', this.value)" name="product_code[]" alt="' + sp_id + '" required>' +
            $('.get_products').html() +
            '</select>' +

            '</div>' +
            '</div>' +
            '<div class="col-sm-4">' +
            '<div class="form-group" >' +
            '<input type="text" class="form-control edit_form quantity quantity' + sp_id + '" alt="' + sp_id + '" name="quantity[]" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" placeholder="Quantity" required>' +
            '<span class="product_qty_uom' + sp_id + '" style="color:#cc2424; font-weight: bold"></span>' +
            '<input type="hidden" class="form-control edit_form uom uom' + sp_id + ' product_qty_uom' + sp_id + '" name="uom[]" value="" placeholder="UOM">' +

            '</div>' +
            '</div>' +
            /*
            '<div class="col-sm-3">' +
            '<div class="form-group" >' +
            '<select required class="form-control edit_form GetUOM uom uom' + sp_id + '" name="uom[]" alt="' + sp_id + '" required>' +
            $('.get_uom').html() +
            '</select>' +

            '</div>' +
            '</div>' + */

            '<div class="col-sm-1">' +
            '<button class="btn btn-danger " type="button" onclick="remove_achive_fields(' + sp_id + ');"> ' +
            '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>' +
            '</button>' +

            '</div>' +
            '</div>'
            ;

        objTo.appendChild(divtest);
        $('.product_code' + sp_id).focus();
    }
    else if (pre_product_code == "" || pre_product_code == undefined) {
        $(".error_sales_product").html("<span style='color: #f37'>Select a product!</span>");
        $('.product_code' + sp_id).css("border", "1px solid #f97");
        $('.product_code' + sp_id).focus();
    }
    else if (pre_quantity <= 0) {
        $(".error_sales_product").html("<span style='color: #f37'>Enter wastage quantity value!</span>");
        $('.quantity' + sp_id).css("border", "1px solid #f97");
        $('.quantity' + sp_id).focus();
    }
}


var achive = 0;
function purchase_fields() {
    $('.product_code' + achive).css("border", "1px solid #ebebeb");
    $('.quantity' + achive).css("border", "1px solid #ebebeb");
    $('.amount' + achive).css("border", "1px solid #ebebeb");
    var pre_product_code = $('.product_code' + achive).val();
    var pre_quantity = $('.quantity' + achive).val();
    var pre_amount = $('.amount' + achive).val();
    //alert('.product_code' + achive);

    //Append if previous dropdown has selected and previous quantity is above 0
    if (pre_product_code != "" && pre_product_code != undefined && pre_quantity > 0 && pre_amount > 0) {
        achive++;
        var objTo = document.getElementById('purchase_products')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + achive);
        var rdiv = 'removeclass' + achive;
        divtest.innerHTML =
            '<div class="row col-sm-12" style="margin-top: 7px;">' +
            '<div class="col-sm-3">' +
            '<div class="form-group" >' +
            '<select required  onChange="getPurchaseQtyUOM(\'' + achive + '\', this.value)" class="form-control edit_form product_code product_code' + achive + '" name="product_code[]"  alt="' + achive + '" >' +
            $('.get_products').html() +
            '</select>' +

            '</div>' +
            '</div>' +

            '<div class="col-sm-2">' +
            '<div class="form-group">' +
            '<input type="number" placeholder="Quantity" class="form-control edit_form quantity quantity' + achive + '" alt="' + achive + '" name="quantity[]">' +
            '<span class="product_qty_uom' + achive + '" style="color:#cc2424; font-weight: bold"></span>' +
            '<input type="hidden" class="form-control edit_form uom uom' + achive + ' product_qty_uom' + achive + '" name="uom[]" value="" placeholder="UOM">' +
            '</div>' +
            '</div>' +


            '<div class="col-sm-3">' +
            '<div class="form-group" >' +
            '<input type="number" required step="0.1" min="0" placeholder="Purchase price" class="form-control edit_form amount' + achive + '" alt="' + achive + '" name="amount[]"  > ' +

            '</div>' +
            '</div>' +

            '<div class="col-sm-1">' +
            '<button class="btn btn-sm btn-danger " type="button" onclick="remove_achive_fields(' + achive + ');"> ' +
            '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>' +
            '</button>' +

            '</div>' +
            '</div>'
            ;

        objTo.appendChild(divtest);
        $('.product_code' + achive).focus();
    }
    else if (pre_product_code == "" || pre_product_code == undefined) {
        $(".error_purchase").html("<span style='color: #f37'>Select a product!</span>");
        $('.product_code' + achive).css("border", "1px solid #f97");
        $('.product_code' + achive).focus();
    }
    else if (pre_quantity <= 0) {
        $(".error_purchase").html("<span style='color: #f37'>Enter quantity value!</span>");
        $('.quantity' + achive).css("border", "1px solid #f97");
        $('.quantity' + achive).focus();
    }
    else if (pre_amount <= 0) {
        $(".error_purchase").html("<span style='color: #f37'>Enter price!</span>");
        $('.amount' + achive).css("border", "1px solid #f97");
        $('.amount' + achive).focus();
    }
    else {
        $(".error_purchase").html("<span style='color: #f37'>Unkonwn error!</span>");
    }
}

function remove_achive_fields(rid) {
    console.log(rid);
    $('.removeclass' + rid).remove();
}

$(function () {

    $('.page-loader-wrapper').show();

    setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
});

var common = angular.module('Common_app', ['ui.bootstrap']);
common.filter('beginning_data', function () {
    return function (input, begin) {
        if (input) {
            begin = +begin;
            return input.slice(begin);
        }
        return [];
    }
});

common.directive('tooltip', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            $(element).hover(function () {
                // on mouseenter
                $(element).tooltip('show');
            }, function () {
                // on mouseleave
                $(element).tooltip('hide');
            });
        }
    };
});

common.controller('MovementTracker_controller', function ($scope, $http, $timeout) {

    $scope.movemntTracker_sub = function () {
        $('.movemntTracker_sub').submit();
    }

    $http.post('movement_tracker/GetMovement_tracker')
        .then(function (response) {
            //console.log(response.data);

            $scope.Common_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.Common_details.length;
            $scope.entire_user = $scope.Common_details.length;

        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };
    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };
    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

});

common.controller('salesProduct_controller', function ($scope, $http, $timeout) {
    $scope.getSalesProducts = function (get_stalls) {
        //alert(get_stalls);
        // var get_stalls = $('.get_stalls').val();
        $('.salesProdus').removeAttr('checked');

        $http.post('stall_products/GetStockSales', { 'get_stalls': get_stalls })
            .then(function (res) {

                var stallData = res.data;

                for (var i = 0; i < stallData.length; i++) {
                    $('.salesProdus' + stallData[i]['sales_product_id']).prop('checked', true);
                }
            });
    }

    $scope.sales_product_Stall_sub = function () {
        $('.sales_product_Stall_sub').submit();
    }

    $scope.sales_product_sub = function () {
        $('.sales_product_sub').submit();
    }


    $http.post('sales_products/GetSalesProducts')
        .then(function (response) {
            // console.log(response.data);
            $scope.Common_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.Common_details.length;
            $scope.entire_user = $scope.Common_details.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };
    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };
    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.view_products = function (sales_product_id, pro_name) {

        $http.post('sales_products/ViewProducts', { 'sales_product_id': sales_product_id })
            .then(function (res) {

                $('.view_title_sales_pro').text(pro_name + ' Ingredients');
                $scope.ViewIncredians = res.data['view_inc'];
                //console.log(res.data);
            });
    }

    $scope.edit_salesProductDetails = function (sales_product_id) {
        sp_id = 0;
        $('.remove_all').remove();

        $http.post('sales_products/ViewProducts', { 'sales_product_id': sales_product_id })
            .then(function (res) {

                $('.product_image').removeAttr('required');
                $("input").addClass("focus");
                $("select").addClass("focus");
                $('.sales_product_id').val(res.data['sales_products']['sales_product_id']);
                $('.sales_product_name').val(res.data['sales_products']['sales_product_name']);
                $('.sales_product_type').val(res.data['sales_products']['sales_product_type']);
                $('.product_min_quantity').val(res.data['sales_products']['min_quantity']);
                $('.product_image_edit').val(res.data['sales_products']['image']);
                $('.product_price').val(res.data['sales_products']['price']);

                if (res.data['view_inc'].length > 0) {

                    for (var i = 0; i < res.data['view_inc'].length; i++) {
                        //console.log(i);
                        if (i >= 1) {

                            sales_incredians();
                        }
                        $("input").addClass("focus");
                        $("select").addClass("focus");
                        $('.product_code' + i + ' > option[value="' + res.data['view_inc'][i]['product_code'] + '"]').prop('selected', true);
                        $('.quantity' + i).val(res.data['view_inc'][i]['quantity']);
                        $('.ingredients_id' + i).val(res.data['view_inc'][i]['ingredients_id']);
                        $('.uom' + i).val(res.data['view_inc'][i]['uom']);
                        //$('.uom' + i + ' > option[value="' + res.data['view_inc'][i]['uom'] + '"]').prop('selected', true);
                        //console.log('.product_code'+i+' > option[value="'+res.data['view_inc'][i]['product_code']+'"]');
                        //console.log(res.data['view_inc'][i]);
                    }
                }
                else {
                    $('.product_code0 > option[value=""]').prop('selected', true);
                    $('.quantity0').val('');
                    $('.ingredients_id0').val('');
                    $('.uom0 > option[value=""]').prop('selected', true);
                }

            });
    }


});

common.controller('Purchase_controller', function ($scope, $http, $timeout) {

    $scope.purchase_details_submit = function () {

        $('.purchase_details_submit').submit();
    }

    $http.post('purchase/GetPurchase')
        .then(function (response) {
            // console.log(response.data);
            $scope.Common_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.Common_details.length;
            $scope.entire_user = $scope.Common_details.length;

        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };
    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };
    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.disable_purchase = function (purchase_id, status) {

        if (status == 1)
            $title = "Dissable Purchase";
        else
            $title = "Enable Purchase";

        $.confirm({
            title: $title,
            content: 'Are you sure to ' + $title + '?',

            buttons: {
                Ok: function () {
                    $http.post('purchase/DisablePurchase', { 'purchase_id': purchase_id, 'status': status })
                        .then(function (response) {
                            location.reload();
                        });
                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }


});

common.controller('SupplierDetails', function ($scope, $http, $timeout) {

    $scope.validate_supplier_name = function () {

        var supplier_name = $('.supplier_name').val();

        if (supplier_name != undefined || supplier_name != '') {

            $http.post('supplier_details/ValidateSupplierNAme', { 'supplier_name': supplier_name })
                .then(function (res) {
                    if (res.data == 1) {
                        $('#supplier_name_error').text('You entered username is already exist!')

                        return 0;
                    }
                    else {
                        $('#supplier_name_error').text('')

                        return 1;
                    }


                });
        }
    }

    $scope.supplier_details_submit = function () {

        var supplier_name = $('.supplier_name').val();

        var supplier_id = $('.supplier_id ').val();

        console.log(supplier_id);
        if (supplier_id == 0) {
            if (supplier_name != undefined || supplier_name != '') {

                $http.post('supplier_details/ValidateSupplierNAme', { 'supplier_name': supplier_name })
                    .then(function (res) {
                        if (res.data == 0) {
                            $('.supplier_details_submit').submit();
                        }


                    });
            }
        }
        else {
            $('.supplier_details_submit').submit();
        }


    }

    $http.post('supplier_details/SupplierDetails')
        .then(function (response) {
            //console.log(response.data);

            $scope.Common_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.Common_details.length;
            $scope.entire_user = $scope.Common_details.length;

        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.edit_supplier_details = function (supplier_id) {

        $http.post('supplier_details/supplier_details', { 'supplier_id': supplier_id })
            .then(function (response) {
                //console.log(response.data);               

                if (response.data) {
                    $("input").addClass("focus");
                    $("select").addClass("focus")
                    $('.supplier_name').val(response.data['supplier_name']);
                    $('.supplier_mobile').val(response.data['supplier_mobile']);
                    $('.supplier_address').val(response.data['supplier_address']);
                    $('.supplier_city').val(response.data['supplier_city']);
                    $('.supplier_gst').val(response.data['supplier_gst']);
                    $('.status').val(response.data['status']);
                    $('.supplier_id').val(response.data['supplier_id']);
                }
            });
    }

    $scope.Disable_supplier = function (supplier_id, status) {

        if (status == 1)
            $title = "Dissable Product";
        else
            $title = "Enable Product";

        $.confirm({
            title: $title,
            content: 'Are you sure to ' + $title + '?',

            buttons: {
                Ok: function () {
                    $http.post('supplier_details/Disable_supplier', { 'supplier_id': supplier_id, 'status': status })
                        .then(function (response) {
                            location.reload();
                        });
                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

});

common.controller('Store_conroller', function ($scope, $http, $timeout) {

    $scope.store_details_submit = function () {

        $('.store_details_submit').submit();
    }

    $http.post('store_details/Get_Stores')
        .then(function (response) {
            //console.log(response.data); 

            $scope.store_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.store_details.length;
            $scope.entire_user = $scope.store_details.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.edit_store_details = function (store_id) {

        $http.post('store_details/store_details', { 'store_id': store_id })
            .then(function (response) {

                if (response.data) {

                    if (response.data['store_id'] != '') {
                        $('.remove_pass').hide();
                        $('.newpassword').removeAttr('required');
                        $('.confrimpassword').removeAttr('required');
                    }
                    $("input").addClass("focus");
                    $('.store_id').val(response.data['store_id']);
                    $('.store_name').val(response.data['store_name']);
                    $('.store_code').val(response.data['store_code']).prop('disabled', true);
                    $('.store_loc').val(response.data['store_loc']);
                    $('.store_phone').val(response.data['store_phone']);
                    $('.store_email').val(response.data['store_email']);
                }
            });
    }

    $scope.dissable_store = function (store_id, status) {

        if (status == 1)
            $title = "Dissable Product";
        else
            $title = "Enable Product";

        $.confirm({
            title: $title,
            content: 'Are you sure to ' + $title + '?',

            buttons: {
                Ok: function () {
                    $http.post('store_details/DeleteStores', { 'store_id': store_id, 'status': status })
                        .then(function (responce) {
                            location.reload();
                        });
                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

});

common.controller('Stall_conroller', function ($scope, $http, $timeout) {

    $scope.getStallCode = function (store_code) {

        //console.log(store_code);

        $http.post('stall_details/GetStallCode', { 'store_code': store_code })
            .then(function (res) {

                $('.stall_code').val($.trim(res.data));
                console.log(res.data);
            });
    }

    $scope.stall_details_submit = function () {
        $('.stall_details_submit').submit();
    }

    /*function validate_username(baseurl, id, uname) {
        //alert(baseurl+'User_details/validate_username');
        $.ajax({
            type: 'POST',
            url: baseurl + 'User_details/validate_username',
            data: 'uname=' + uname,
            beforeSend: function () {
    
            },
            success: function (resp) {
                if (resp > 0) {
                    $("#" + id).val("");
                    $("#" + id + "_error").text("You entered username '" + uname + "' is already exist!");
                }
                else {
                    $("#" + id + "_error").text("");
                }
            }
        });
    }*/

    /*$scope.check_stall_code = function (stall_code) {

        $http.post('stall_details/StallCodeValidation', { 'stall_code': stall_code })
            .then(function (res) {
                console.log(res);

            });
    }*/

    $http.post('stall_details/Get_Stalls')
        .then(function (response) {
            console.log(response.data);
            $scope.stall_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.stall_details.length;
            $scope.entire_user = $scope.stall_details.length;

        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.edit_stall_details = function (stall_id) {

        $http.post('stall_details/stall_details', { 'stall_id': stall_id })
            .then(function (response) {
                console.log(response.data);

                //$data = $('.store_code > option[value="' + response.data['store_code'] + '"]').prop('selected', true);

                if (response.data) {
                    $("input").addClass("focus");;
                    //$(".store_code, select").prop('disabled', true);
                    $('.store_code > option[value="' + response.data['store_code'] + '"]').prop('selected', true);
                    $('.stall_code').val(response.data['stall_code']);
                    $('.stall_name').val(response.data['stall_name']);
                    $('.stall_phone').val(response.data['stall_phone']);
                    $('.stall_id').val(response.data['stall_id']);
                }
            });
    }

    $scope.dissable_stall = function (stall_id, status) {

        if (status == 1)
            $title = "Dissable Product";
        else
            $title = "Enable Product";

        $.confirm({
            title: $title,
            content: 'Are you sure to ' + $title + '?',

            buttons: {
                Ok: function () {
                    $http.post('stall_details/DeleteStall', { 'stall_id': stall_id, 'status': status })
                        .then(function (responce) {
                            location.reload();
                        });
                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

});

common.controller('Product_category_controller', function ($scope, $http, $timeout) {

    $scope.reset_form = function () {
        $("").trigger("reset");
    }

    $scope.category_details_submit = function () {
        //$('.product_category_submit').submit();
    }

    $scope.product_category_submit = function (type) {

        var baseurl = $("#base_url").val();

        $("input, select").css("border", "1px solid #ebebeb");
        
        if(type=="add"){
            var category = $("#product_category").val();
            var sname = $("#short_name").val();
            var status = $("#category_status").val();
            //alert(sname);
            if(category && sname && status){

                var data = $( "#addProductCategoryForm" ).serialize();
                $.ajax({
                    type: "post",
                    url: baseurl+'product_category/submit_category',
                    data: data,
                    beforeSend: function(){
                        $("#category_response").html("<span style='color: #cc2424'>Please wait...</span>");
                    },
                    success: function(e){
                        //alert(e);
                        var res = e.split("|");
                        
                        if((res[0]=="" || res[0]==0) && res[1]){ 
                            $("#category_response").html("<span style='color: #008d45'>"+res[1]+"</span>");
                            setTimeout(window.location.reload(), 4000);
                        }
                        else if(res[0]==1 && res[1]){
                            $("#category_response").html("<span style='color: #cc2424'>"+res[1]+"</span>");                            
                        }
                        else{
                            $("#category_response").html("<span style='color: #ff9800'>"+e+"</span>");
                        }
                    }
                });
            }
            else if(!category){
                $("#category_response").html("<span style='color:#cc2424'>Enter a category</span>");
                $("#product_category").css("border", "1px solid #cc2424");
                $("#product_category").focus();
            }
            else if(!sname){
                $("#category_response").html("<span style='color:#cc2424'>Enter short name for selected category</span>");
                $("#short_name").css("border", "1px solid #cc2424");
                $("#short_name").focus();
            }
            else if(!status){
                $("#category_response").html("<span style='color:#cc2424'>Select a status</span>");
                $("#category_status").css("border", "1px solid #cc2424");
                $("#category_status").focus();
            }
        }
        else if(type=="edit"){
            var category = $("#edit_product_category").val();
            var sname = $("#edit_short_name").val();
            var status = $("#edit_category_status").val();
            
            if(category && sname && status){

                var data = $( "#editProductCategoryForm" ).serialize();
                
                $.ajax({
                    type: "post",
                    url: baseurl+'product_category/submit_category',
                    data: data,
                    beforeSend: function(){
                        $("#edit_category_response").html("<span style='color: #cc2424'>Please wait...</span>");
                    },
                    success: function(e){
                        //alert(e);
                        var res = e.split("|");
                        
                        if((res[0]=="" || res[0]==0) && res[1]){ 
                            $("#edit_category_response").html("<span style='color: #008d45'>"+res[1]+"</span>");
                            setTimeout(window.location.reload(), 4000);
                        }
                        else if(res[0]==1 && res[1]){
                            $("#edit_category_response").html("<span style='color: #cc2424'>"+res[1]+"</span>");                            
                        }
                        else{
                            $("#edit_category_response").html("<span style='color: #ff9800'>"+e+"</span>");
                        }
                    }
                });
            }
            else if(!category){
                $("#category_response").html("<span style='color:#cc2424'>Enter a category</span>");
                $("#edit_product_category").css("border", "1px solid #cc2424");
                $("#edit_product_category").focus();
            }
            else if(!sname){
                $("#category_response").html("<span style='color:#cc2424'>Enter short name for selected category</span>");
                $("#edit_short_name").css("border", "1px solid #cc2424");
                $("#edit_short_name").focus();
            }
            else if(!status){
                $("#category_response").html("<span style='color:#cc2424'>Select a status</span>");
                $("#edit_category_status").css("border", "1px solid #cc2424");
                $("#edit_category_status").focus();
            }
        }
    }

    $http.post('product_category/Get_ProductCategory')
        .then(function (response) {
            console.log(response.data);
            $scope.product_category = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.product_category.length;
            $scope.entire_user = $scope.product_cetegory.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.edit_category_details = function (category_id) {

        $http.post('product_category/Get_CategoryByID', { 'category_id': category_id })
            .then(function (response) {
                console.log(response.data);
                if (response.data) {
                    $("input").addClass("focus");
                    $("select").addClass("focus")   
                    $('#edit_category_id').val(response.data['category_id']);                   
                    $('#edit_product_category').val(response.data['product_category']);                   
                    $('#edit_short_name').val(response.data['short_name']);
                    $('#edit_status > option[value="' + response.data['status'] + '"]').prop('selected', true);
                    $('#edit_description').val(response.data['description']);
                    $('#edit_category_status > option[value="' + response.data['status'] + '"]').prop('selected', true);
                }
            });
    }

    $scope.disable_category = function (category_id, status) {

        if (status == 1)
            $title = "Dissable Product";
        else
            $title = "Enable Product";

        $.confirm({
            title: $title,
            content: 'Are you sure to ' + $title + '?',

            buttons: {
                Ok: function () {
                    $http.post('Product_Category/DisableCategory', { 'category_id': category_id, 'status': status })
                        .then(function (response) {
                            location.reload();
                        });
                },
                Cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

});

common.controller('Product_controller', function ($scope, $http, $timeout) {

    $scope.reset_form = function () {

        $("#ProductForm").trigger("reset");
    }

    $('.category_id').on('change', function () {

        var cat_val = $(this).val();

        if (cat_val == 'new') {
            $('.new_category').show();
            $('.new_product_category').attr('required', true);
        }
        else {
            $('.new_category').hide();
            $('.new_product_category').removeAttr('required');
        }
    });

    $scope.product_details_submit = function () {
        var type = $("#form_type").val().toLowerCase();
        $("input, select").css("border", "1px solid #ebebeb");
        var baseurl = $("#base_url").val();
        
        if(type=="add"){
            //Validation for ADD
            var pname = $("#product_name").val();
            var pcid = $("#category_id").val();
            var pcode = $("#product_code").val();
            var puom = $("#uom").val();

            if(pname && pcid && pcode && puom){
                var data = $( "#ProductForm" ).serialize();
                $.ajax({
                    type: "post",
                    url: baseurl+'product_details/submit_products',
                    data: data,
                    beforeSend: function(){
                        $("#response_submit").html("<span style='color: #cc2424'>Please wait...</span>");
                    },
                    success: function(e){
                        //alert(e);
                        var res = e.split("|");
                        
                        if((res[0]=="" || res[0]==0) && res[1]){ 
                            $("#response_submit").html("<span style='color: #008d45'>"+res[1]+"</span>");
                            setTimeout(window.location.reload(), 4000);
                        }
                        else if(res[0]==1 && res[1]){
                            $("#response_submit").html("<span style='color: #cc2424'>"+res[1]+"</span>");                            
                        }
                        else{
                            $("#response_submit").html("<span style='color: #ff9800'>"+e+"</span>");
                        }
                    }
                });
                
            }
            else if(pname=="" || pname==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Enter product name!</span>");
                $("#product_name").css("border", "1px solid #cc2424");
                $("#product_name").focus();
            }
            else if(pcid=="" || pcid==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Select a category!</span>");
                $("#category_id").css("border", "1px solid #cc2424");
                $("#category_id").focus();
            }
            else if(pcode=="" || product_code==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Unable to generate product code!</span>");
                $("#product_code").css("border", "1px solid #cc2424");
                $("#product_code").focus();
            }
            else if(puom=="" || puom==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Select a UOM!</span>");
                $("#uom").css("border", "1px solid #cc2424");
                $("#uom").focus();
            }
            else{
                $("#response_submit").html("<span style='color: #cc2424'>Unknown error. Unable to submit</span>");
            }
        }
        else if(type=="edit"){
            //Validation for EDIT
            var pid = $("#product_id").val();
            var pname = $("#product_name").val();
            var pcode = $("#product_code").val();
            var puom = $("#uom").val();

            if(pid && pname && pcode && puom){
                var data = $( "#ProductForm" ).serialize();
                $.ajax({
                    type: "post",
                    url: baseurl+'product_details/submit_products',
                    data: data,
                    beforeSend: function(){
                        $("#response_submit").html("<span style='color: #cc2424'>Please wait...</span>");
                    },
                    success: function(e){
                        //$("#response_submit").html("<span style='color: #cc2424'>"+e+"</span>"); return;
                        var res = e.split("|");

                        if((res[0]=="" || res[0]==0) && res[1]){ 
                            $("#response_submit").html("<span style='color: #008d45'>"+res[1]+"</span>");
                            setTimeout(window.location.reload(), 4000);
                        }
                        else if(res[0]==1 && res[1]){
                            $("#response_submit").html("<span style='color: #cc2424'>"+res[1]+"</span>");                            
                        }
                        else{
                            $("#response_submit").html("<span style='color: #ff9800'>"+e+"</span>");
                        }
                    }
                });
            }
            else if(pname=="" || pname==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Enter product name!</span>");
                $("#product_name").css("border", "1px solid #cc2424");
                $("#product_name").focus();
            }
            else if(pcode=="" || product_code==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Unable to generate product code!</span>");
                $("#product_code").css("border", "1px solid #cc2424");
                $("#product_code").focus();
            }
            else if(puom=="" || puom==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Select a UOM!</span>");
                $("#uom").css("border", "1px solid #cc2424");
                $("#uom").focus();
            }
            else if(pid=="" || pid==undefined){
                $("#response_submit").html("<span style='color: #cc2424'>Record ID not found!</span>");
            }
            else{
                $("#response_submit").html("<span style='color: #cc2424'>Unknown error. Unable to submit</span>");
            }
        }
        //$('.product_details_submit').submit();
    }

    $http.post('product_details/Get_Products')
        .then(function (response) {
            //console.log(response.data);
            $scope.product_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 15;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.product_details.length;
            $scope.entire_user = $scope.product_details.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.edit_product_details = function (product_id) {
        //Open form modal to edit
        open_form('edit'); // this function written in product_details view page
        $http.post('product_details/product_details', { 'product_id': product_id })
            .then(function (response) {
                console.log(response.data);
                if (response.data) {
                    $("input").addClass("focus");
                    $("select").addClass("focus");

                    $('.product_id').val(response.data['product_id']);
                    $('.product_code').val(response.data['product_code']).prop('disabled', 'true');
                    $('.product_name').val(response.data['product_name']);
                    $('.brand_name').val(response.data['brand_name']);
                    $('.product_type').val(response.data['product_type']);
                    $('.category_id > option[value="' + response.data['category_id'] + '"]').prop('selected', true);
                    $('.category_id').prop("disabled", "true");
                    $('.uom > option[value="' + response.data['uom'] + '"]').prop('selected', true);
                    $('.description').val(response.data['description']);
                    $('.conversion_value').val(response.data['conversion_value']);
                    $('.status > option[value="' + response.data['status'] + '"]').prop('selected', true);
                }
            });
    }

    $scope.disable_products = function (product_id, status) {

        if (status == 1)
            $title = "Dissable Product";
        else
            $title = "Enable Product";

        $.confirm({
            title: $title,
            content: 'Are you sure to ' + $title + '?',

            buttons: {
                Ok: function () {
                    $http.post('Product_details/DisableProduct', { 'product_id': product_id, 'status': status })
                        .then(function (response) {
                            console.log(response.data);
                            //alert("Porduct_id: " + response.data);
                            location.reload();
                        });
                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

});

common.controller('Wastage_controller', function ($scope, $http, $timeout) {

    $scope.wastage_products_submit = function () {
        $('.wastage_products_submit').submit();
    }

    $http.post('Wastage/GetWastageProducts')
        .then(function (response) {
            //console.log(response.data); 
            $scope.Wastage = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.Wastage.length;
            $scope.entire_user = $scope.Wastage.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.getWasteProducts = function (get_stalls) {
        //alert(get_stalls);
        // var get_stalls = $('.get_stalls').val();
        $('.salesProdus').removeAttr('checked');

        $http.get('stall_products/GetStockSales', { 'get_stalls': get_stalls })
            .then(function (res) {

                var stallData = res.data;

                for (var i = 0; i < stallData.length; i++) {
                    $('.salesProdus' + stallData[i]['sales_product_id']).prop('checked', true);
                }
            });
    }

    $scope.sales_product_sub = function () {
        $('.sales_product_sub').submit();
    }

    $scope.view_wastage_products = function (wastage_id, product_name) {

        $http.post('Wastage/GetWastageProducts', { 'wastage_id': wastage_id })
            .then(function (response) {
                console.log(response.data[0]);
                $('.view-wastage-products').text('Wastage ' + product_name + ' Product Details');
                // for(let i=0;i<=response.data.length;i++){
                //     console.log(wastage_id);
                // }
                $scope.viewWastage = response.data;
            });

        /*$http({
          method: 'post',
          url: 'Wastage/GetWastageProducts',
          data: {'wastage_id': wastage_id},
         }).then(function successCallback(response) {
             console.log(response.data[1]);
           $('.view-wastage-products').text('Wastage '+product_name+' Product Details');
           // Assign response to viewWastage object             
           $scope.viewWastage = response.data[wastage_id];               
         }); */
    }

    $scope.edit_wastage_products = function (wastage_id) {

        $http.post('Wastage/Edit_wastage', { 'wastage_id': wastage_id })
            .then(function (response) {

                $("input").addClass("focus");
                $("select").addClass("focus");
                // $('.sales_product_id').val(res.data['sales_products']['sales_product_id']);
                $('.wastage_id').val(response.data['wastage_id']);
                $('.store_code').val(response.data['store_code']);
                $('.stall_code').val(response.data['stall_code']);
                $('.product_code').val(response.data['product_code']);
                $('.quantity_of_waste').val(response.data['quantity_of_waste']);
                $('.quantity_of_waste').removeAttr("readonly");
                $('.approve_status').val(response.data['approve_status']);
                $('.uom').val(response.data['uom']);

            });
    }

    $scope.accept_wastage_product = function (wastage_id, stall_code, product_code, quantity_of_waste) {
        $.confirm({
            title: 'Accept Wastage Product',
            content: 'Are you sure to accept the wastage product!',

            buttons: {
                Ok: function () {

                    $http.post('Wastage/AcceptWastage', { 'wastage_id': wastage_id, 'stall_code': stall_code, 'product_code': product_code, 'quantity_of_waste': quantity_of_waste })
                        .then(function (response) {
                            //console.log(response.data);
                            //alert(response.data);

                            location.reload();
                        });

                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

    $scope.reject_wastage_product = function (wastage_id) {
        $.confirm({
            title: 'Reject Wastage Product',
            content: 'Are you sure to accept the wastage product!',

            buttons: {
                Ok: function () {

                    $http.post('Wastage/RejectWastage', { 'wastage_id': wastage_id })
                        .then(function (response) {
                            location.reload();
                        });

                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

});

common.filter('custom', function() {
    return function(input, search) {
      if (!input) return input;
      if (!search) return input;
      var expected = ('' + search).toLowerCase();
      var result = {};
      angular.forEach(input, function(value, key) {
        var actual = ('' + value).toLowerCase();
        if (actual.indexOf(expected) !== -1) {
          result[key] = value;
        }
      });
      return result;
    }
});

common.controller('stock_sales_controller', function ($scope, $http) {     
    
    $http.post('Stock_Sales/GetSalesStock')
        .then(function (response) {
            console.log(response.data);          

            $scope.stock_of_sales = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.stock_of_sales.length;
            $scope.entire_user = $scope.stock_of_sales.length;

        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };
    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };
    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    

}); 

common.controller('Change_password_controller', function($scope, $http) {

    $scope.message = "";
    $scope.formData = {}

    $scope.change_password = function(){
    var regdata = {
        url:"Change_Password/changePassword",
        method: "POST",
        data: { 
            old_pwd: $scope.old_pwd,
            new_pwd: $scope.new_pwd,
            rpwd: $scope.rpwd 
        },
        headers: {'Content-Type': 'application/json'},
    }

    $http(regdata).then(function success(response) {
            $scope.message = response.data;
            console.log($scope.message);
            alert($scope.message)

      }, function error(response) {
        alert('Something Went Wrong! :( ');
      });
   }

    $scope.checkPassword12 = function() {

        $http({
            method: 'post',
            url: 'Change_Password/checkExitPassword',
            data: {
                password: $scope.old_pwd
            }
        }).then(function(response) {
            alert(response.data)
            console.log(response.data);
            $scope.passwordstatus = response.data;
        });
    };

    $scope.change_password22 = function () {
        $('.change_password').submit();
    }

    // Set class
    $scope.addClass = function(passwordstatus) {
        if (passwordstatus == 'Available') {
            return 'response exists';
        } else if (passwordstatus == 'Not available') {
            return 'response not-exists';
        } else {
            return 'hide';
        }
    }
});

common.controller('Sales_controller', function ($scope, $http) {

    $scope.salesCarts = [];

    $scope.loadSalesProducts = function () {
        $http.get('Sales/LoadSalesProducts')
            .then(function (response) {
                console.log(response.data); 
                $scope.Sales = response.data;                
            });
    };

    $scope.fetchProducts = function () {
        $http.post('Sales/fetchProducts').then(function (response) {
            //console.log(response.data);
            $scope.salesCarts = response.data;
        })
    };

    $scope.setTotals = function () {
        var total = 0;
        for (var count = 0; count < $scope.salesCarts.length; count++) {
            var item = $scope.salesCarts[count];
            total = total + (item.quantity * item.price);
        }

        if (isNaN(total)) { total = !isNaN(item.quantity * item.price) ? (item.quantity * item.price) : '0'; }
        
        return total;
    };

    $scope.addItem = function (id, name, price) {
        $http.post('Sales/addItem', { 'sales_product_id': id, 'sales_product_name': name, 'price': price }).then(function (response) {
            $scope.fetchProducts();
        })
    };

    
    $scope.plusQty = function (id) {
        $http.post('Sales/plusQty', { 'sales_product_id': id}).then(function (response) {
            $scope.fetchProducts();
        })
    };

    $scope.minusQty = function (id) {
        $http.post('Sales/minusQty', { 'sales_product_id': id}).then(function (response) {
            $scope.fetchProducts();
        })
    };

    $scope.removeItem = function (id) {
        $http({
            method: "DELETE",
            url: "Sales/removeItem",
            data: id,
            dataType: JSON,
        }).then(function (response) {
            $scope.fetchProducts();
        });
    };

    $scope.clearCart = function () {
        $.confirm({
            title: 'Clear Cart',
            content: 'Are you sure to clear cart ?',

            buttons: {
                Ok: function () {

                    $http.post('Sales/clearItem')
                        .then(function (response) {
                            location.reload();
                        });
                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

    $scope.clearAfterPrint = function () {
        $http.post('Sales/clearAfterPrint')
                        .then(function (response) {
                            location.reload();
                        });
    }


    $scope.print = function(products){
        $http({
            method: "POST",
            url: "Sales/printData",
            data: products,
            dataType: JSON,
        }).then(function (response) {
            //console.log(response.data);
            //alert(response.data);
            $scope.clearAfterPrint();
        });
    }

    $('.print').on('click', function() {
        print();
    });

});

common.controller('Invoice_controller', function ($scope, $http, $timeout) {

    /*$scope.reset_form = function(){

        $("#payment_form").trigger("reset");
    }*/

    $scope.payment_submit = function () {

        var amount = $("#payable_amount").val();
        if (amount > 0) {
            $.ajax({
                type: 'post',
                url: 'invoice_payment/Payment_to_Invoice',
                data: $(".payment_submit").serialize(),
                beforeSend: function () {
                    $("#error_amount").html("Please wait...");
                },
                success: function (e) {
                    //alert(e);
                    if (e == 1) {
                        $("#error_amount").html("<span style='color:#118a16'>Success!</span>");
                        window.location.reload();
                    }
                    else {
                        $("#error_amount").html("<span style='color:#ff5722'>" + e + "</span>");
                    }
                },
                error: function (e) {
                    $("#error_amount").html("<span style='color:#cc1a0d'>" + e + "</span>");
                }
            });
        }
        //$('.payment_submit').submit();		
    }

    $http.post('invoice_payment/Get_Invoice')
        .then(function (response) {
            //console.log(response.data);
            $scope.invoice_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.invoice_details.length;
            $scope.entire_user = $scope.invoice_details.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.view_payment_details = function (data) {

        $http.post('invoice_payment/payment_details', { 'store_code': data.store_code, 'supplier_id': data.supplier_id, 'invoice_number': data.invoice_number })
            .then(function (response2) {
                console.log(response2.data);
                $('#view_store_info').html(data.store_name + ' (' + data.store_code + ')');
                $('#view_supplier_info').html(data.supplier_name);
                $('#view_invoice_number').html(data.invoice_number);
                $('#view_invoice_date').html(data.invoice_date);
                $('#view_invoice_amount').html(data.total_amount + ' ' + data.currency);
                $('#view_purchased_by').html(data.name + ' (' + data.role + ')');
                $('#total_paid_amount').html(data.paid_amount);
                if (response2.data.length) {
                    /*$("input").addClass("focus");
                    $("select").addClass("focus")   
                    $('.product_code').val(response.data['product_code']).prop('disabled', 'true');                   
                    $('.category_id > option[value="' + response.data['category_id'] + '"]').prop('selected', true);
                    $('.status > option[value="' + response.data['status'] + '"]').prop('selected', true); */
                    $scope.payment_details = response2.data;
                }
                else {
                    $scope.payment_details = 0;
                }
            });
    }
    $scope.view_payment_form = function (data) {
        //alert(data.store_name);
        $('#add_store_info').html(data.store_name + ' (' + data.store_code + ')');
        $('#add_supplier_info').html(data.supplier_name);
        $('#add_invoice_number').html(data.invoice_number);
        $('#add_invoice_date').html(data.invoice_date);
        $('#add_invoice_amount').html(data.total_amount + ' ' + data.currency);
        $('#add_purchased_by').html(data.name + ' (' + data.role + ')');
        $('#payable_amount').val(data.total_amount - data.paid_amount);
        $('#payment_store_code').val(data.store_code);
        $('#payment_supplier_id').val(data.supplier_id);
        $('#payment_invoice_number').val(data.invoice_number);
    }

});

common.controller('Payment_by_supplier', function ($scope, $http, $timeout) {

    /*$scope.reset_form = function(){

        $("#payment_form").trigger("reset");
    }*/

    $scope.payment_submit = function () {
        //var total = 0;
        //alert($(".payment_submit").serialize());
        var amount = $("#tot_payable_amount").val();
        if (amount > 0) {
            $.ajax({
                type: 'post',
                url: 'Payment_by_supplier/Payment_to_Supplier',
                data: $(".payment_submit").serialize(),
                beforeSend: function () {
                    $("#error_amount").html("Please wait...");
                },
                success: function (e) {
                    $("#error_amount").html("<span style='color:#118a16'>" + e + "</span>");
                    if (e == 1) {
                        $("#error_amount").html("<span style='color:#118a16'>Success!</span>");
                        window.location.reload();
                    }
                    else {
                        $("#error_amount").html("<span style='color:#ff5722'>" + e + "</span>");
                    }
                },
                error: function (e) {
                    $("#error_amount").html("<span style='color:#cc1a0d'>" + e + "</span>");
                }
            });
        }
        //$('.payment_submit').submit();		
    }

    $http.post('payment_by_supplier/Get_Supplier')
        .then(function (response) {
            console.log(response.data);
            $scope.supplier_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.supplier_details.length;
            $scope.entire_user = $scope.supplier_details.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };


    /*$scope.view_supplier_payment_details = function (data) {

        $http.post('payment_by_supplier/supplier_payment_details', { 'store_code': data.store_code, 'supplier_id': data.supplier_id })
            .then(function (response2) {
                console.log(response2.data);
				$('#view_store_info').html(data.store_name+' ('+data.store_code+')');
				$('#view_supplier_info').html(data.supplier_name);
				$('#view_invoice_number').html(data.invoice_number);
				$('#view_invoice_date').html(data.invoice_date);
				$('#view_invoice_amount').html(data.total_amount+' '+data.currency);
				$('#total_paid_amount').html(data.paid_amount);
                if (response2.data.length) {
                    /*$("input").addClass("focus");
                    $("select").addClass("focus")   
                    $('.product_code').val(response.data['product_code']).prop('disabled', 'true');                   
                    $('.category_id > option[value="' + response.data['category_id'] + '"]').prop('selected', true);
                    $('.status > option[value="' + response.data['status'] + '"]').prop('selected', true); */
    /*$scope.payment_details = response2.data;
}
else{
    $scope.payment_details = 0;
}
});
}*/
    $scope.view_supplier_payment_form = function (data) {
        $("#error_amount").html("");
        //alert(data.store_name);
        $('#add_store_info').html(data.store_name + ' (' + data.store_code + ')');
        $('#add_supplier_info').html(data.supplier_name);
        $('#add_total_amount').html(data.total_amount);
        $('#add_pending_amount').html(data.pending_amount);

        $('#tot_pending_amount').val(data.pending_amount);
        $('#tot_payable_amount').val(data.pending_amount);
        //$('#payable_amount').val(data.pending_amount);
        $('#total_payable_amount').html(data.pending_amount);

        $('#payment_store_code').val(data.store_code);
        $('#payment_supplier_id').val(data.supplier_id);

        $http.post('payment_by_supplier/Get_Invoice', { 'store_code': data.store_code, 'supplier_id': data.supplier_id })
            .then(function (response3) {
                console.log(response3.data);
                if (response3.data.length) {
                    $scope.pending_invoice_details = response3.data;
                }
                else {
                    $scope.pending_invoice_details = 0;
                }
            });

		/*if(data.store_code!="" && data.supplier_id!=""){
			$.ajax({
				type: 'post',
				url: 'Payment_by_supplier/Get_Invoice',
				data:"store_code="+data.store_code+"&supplier_id="+data.supplier_id,
				beforeSend: function(){
					//$("#error_amount").html("Please wait...");
				}, 
				success: function(e){
					console.log(e);
					if (e.length) {				
						$scope.pending_invoice_details = e;
					}
					else{
						$scope.pending_invoice_details = 0;
					}
				}, 
				error: function(e){
					//$("#error_amount").html("<span style='color:#cc1a0d'>"+e+"</span>");
				}
			});
		}*/

    }

    $scope.update_total = function (data) {
        var id = "#payable_amount_" + data.invoice_number;
        var tot = Number(data.total_amount);
        var paid = Number(data.paid_amount);
        var pending = tot - paid;
        var payment = $(id).val();

        if (pending >= payment) {
            $(id).css("border-bottom", "1px solid #ff9800");
            $(id).attr("placeholder", "");
        }
        else {
            $("#error_amount").html("<p style='color:#f57; text-align:center'>Payment should less or equal to pending!</p>");
            $(id).css("border-bottom", "2px solid #f57");
            $(id).val("");
            $(id).attr("placeholder", payment);
        }

        var total = 0;
        $('.payable_amount').each(function () {
            total = Number(total) + Number(this.value);
        });
        $('#total_payable_amount').text(total);
        $('#tot_payable_amount').val(total);
    }
});

common.controller('Stock_of_store_controller', function ($scope, $http, $timeout) {
    $http.post('stock_of_store/GetStoresStock')
        .then(function (response) {
            //console.log(response.data);
            $scope.stock_of_store = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.stock_of_store.length;
            $scope.entire_user = $scope.stock_of_store.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };
});
common.controller('Stock_of_stall_controller', function ($scope, $http, $timeout) {
    $http.post('stock_of_stall/GetStallStock')
        .then(function (response) {
            console.log(response.data);
            $scope.stock_of_stall = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.stock_of_stall.length;
            $scope.entire_user = $scope.stock_of_stall.length;
        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };
});
common.controller('User_controller', function ($scope, $http, $timeout) {

    $scope.usr_details_submit = function () {
        var form_type = $("#form_type").val().toLowerCase();
        $("input, select").css("border", "1px solid #ebebeb");
        var baseurl = $("#base_url").val();

        var name = $('.name').val();
        var usr_name = $('.usr_name').val();
        var type = $('.type').val();
        var role = $('.role').val();
        var pass = $('.newpassword').val();
        var cn_pass = $('.confrimpassword').val();
        var access_len = $(".access_type:checked").length;
        //alert(access_len);
        
        if(name && usr_name && type && pass.length > 7 && pass == cn_pass && access_len>0){
        //if(1){
            var data = $( "#user_form" ).serialize();
            $.ajax({
                type: "post",
                url: baseurl+'User_details/submit_user',
                data: data,
                beforeSend: function(){
                    $(".form-error").html("<span style='color: #cc2424'>Please wait...</span>");
                },
                success: function(e){
                    //alert(e);
                    var res = e.split("|");
                    
                    if((res[0]=="" || res[0]==0) && res[1]){ 
                        $(".form-error").html("<span style='color: #008d45'>"+res[1]+"</span>");
                        //$( "#user_form" )[0].reset();
                        setTimeout(window.location.reload(), 4000);
                    }
                    else if(res[0]==1 && res[1]){
                        $(".form-error").html("<span style='color: #cc2424'>"+res[1]+"</span>");                            
                    }
                    else{
                        $(".form-error").html("<span style='color: #ff9800'>"+e+"</span>");
                    }
                }
            });
            
        }
        else if(name=="" || name==undefined){
            $(".form-error").html("<span style='color: #cc2424'>Enter full name!</span>");
            $(".name").css("border", "1px solid #cc2424");
            $(".name").focus();
        }
        else if(usr_name=="" || usr_name==undefined){
            $(".form-error").html("<span style='color: #cc2424'>Enter username!</span>");
            $(".usr_name").css("border", "1px solid #cc2424");
            $(".usr_name").focus();
        }
        else if (pass.length <= 7) {
            $(".form-error").html("<span style='color: #cc2424'>New Password should contain at least 8 characters</span>");
            $(".newpassword").css("border", "1px solid #cc2424");
            $(".newpassword").focus();
        }
        else if (cn_pass.length <= 7) {
            $(".form-error").html("<span style='color: #cc2424'>Confirm Password should contain at least 8 characters</span>");
            $(".confrimpassword").css("border", "1px solid #cc2424");
            $(".confrimpassword").focus();

        }
        else if (pass != cn_pass) {
            $(".form-error").html("<span style='color: #cc2424'>Password Not Matched</span>");
            $(".confrimpassword").css("border", "1px solid #cc2424");
            $(".confrimpassword").focus();
        }
        else if(type=="" || type==undefined){
            $(".form-error").html("<span style='color: #cc2424'>Select user type!</span>");
            $(".type").css("border", "1px solid #cc2424");
            $(".type").focus();
        }
        else if(role=="" || role==undefined){
            $(".form-error").html("<span style='color: #cc2424'>Select user role!</span>");
            $(".role").css("border", "1px solid #cc2424");
            $(".role").focus();
        }
        else if (access_len<=0) {
            $(".form-error").html("<span style='color: #cc2424'>Select access type.</span>");
        }
        else {
            $(".form-error").html("<span style='color: #cc2424'>Unknown error. Unable to submit</span>");
        }

    }

    $http.post('user_details/Get_users')
        .then(function (response) {
            console.log(response.data);

            $scope.usr_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.usr_details.length;
            $scope.entire_user = $scope.usr_details.length;

        });

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.delete_usr_details = function (usr_id) {
        $.confirm({
            title: 'User Details',
            content: 'Are you sure to Delete!',

            buttons: {
                Ok: function () {

                    $http.post('user_details/DeleteUsr', { 'usr_id': usr_id })
                        .then(function (responce) {
                            location.reload();
                        });

                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }

    $scope.enable_usr_details = function (usr_id) {
        $.confirm({
            title: 'User Details',
            content: 'Are you sure to enable this user!',

            buttons: {
                Ok: function () {

                    $http.post('user_details/enableUsr', { 'usr_id': usr_id })
                        .then(function (responce) {
                            location.reload();
                        });

                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });
    }
});

function fixit(selector) {
    selector.each(function () {
        var values = $(this).find("tr>td:first-of-type")
        var run = 1
        for (var i = values.length - 1; i > -1; i--) {
            if (values.eq(i).text() === values.eq(i - 1).text()) {
                values.eq(i).remove()
                run++
            } else {
                values.eq(i).attr("rowspan", run)
                run = 1
            }
        }
    })
}

common.controller('Menu_controller', function ($scope, $http, $timeout) {

    $http.post('menu_details/Get_Mainmenus')
        .then(function (response) {

            //console.log(response.data);

            //return;

            /*console.log(response.data);
    
            var sss = response.data;   
            var j=0;
            var html = '';
            var tt= 1;
            var count_order_id = 0;
    
            var dp = [];
    
             for(var i=0; i<sss.length; i++){  
    
                dp.push(sss[i].tst_date+'-'+sss[i].order_no);
             }        
            
             var  count = [];
    
             dp.forEach(function(i) { count[i] = (count[i]||0) + 1;});         
    
            for(var i=0; i<sss.length; i++){
                
            var rows = count[sss[i].tst_date+'-'+sss[i].order_no]; 
                count_order_id+=parseFloat(sss[i].order_no);
    
                html += '<tr>';
                if (j == 0) { // render for first row of user data only
                    html += '<td rowspan="'+rows+'">'+tt+'</td>';
                    html += '<td>'+sss[i].menu_name+'</td>';
                }else{
                    html += '<td>'+sss[i].menu_name+'</td>';
                }
                
                html += '<td>'+sss[i].tst_date+'</td>';
                html += '<td>'+sss[i].menu_icon+'</td>';
               
                html += '</tr>';  
                if (j == (rows - 1)) {                  
                    html += '<tr>';
                    html += '<td colspan="3">Total</td>';
                    html += '<td >'+count_order_id+'</td>';
                    html += '</tr>';                 
                }    
                      
                j+=1;
               
               if(j == rows){
                    j=0;
                    tt++;
                    count_order_id = 0;
    
               }
    
            }
                    
            $('.append_table').append(html);*/

            $scope.menu_details = response.data;
            $scope.current_grid = 1;
            $scope.data_limit = 10;
            $scope.CollegemaxSize = 5;
            $scope.filter_data = $scope.menu_details.length;
            $scope.entire_user = $scope.menu_details.length;

        })

    $scope.page_position = function (page_number) {
        $scope.current_grid = page_number;
    };

    $scope.filter = function () {
        $timeout(function () {
            $scope.filter_data = $scope.searched.length;
        }, 20);
    };

    $scope.sort_with = function (base) {
        $scope.base = base;
        $scope.reverse = !$scope.reverse;
    };

    $scope.edit_menu_details = function (menu_id, menu_type) {
        $http.post('menu_details/GetMenus', { 'menu_id': menu_id, 'menu_type': menu_type })
            .then(function (response) {

                console.log(response.data);

                $('.menu_type > option[value="' + response.data['menu_type'] + '"]').prop('selected', true);

                show_hide_parent_edit(response.data['menu_type']);

                setTimeout(function () { $('#edit_parent_id > option[value="' + response.data['parent_id'] + '"]').prop('selected', true); }, 500);



                if (menu_type == 1) {
                    $scope.menu_details = response.data;
                }
                else {
                    $scope.Submenu_details = response.data;
                }

            });

    }

    $scope.add_menu_details = function (menu_id) {
        $('.menu_id_add').val(menu_id);
    }

    $scope.add_menu_pre = function (role, type) {
        // $('.preference_id').val(pre_id);
        $('.preference_type').val(type);
        $('.preference_role').val(role);
        $('.modal-header .preference_title_of_role').html("Menu Preference -  " + role + "  (" + type + ')');
        $http.post('Menu_preference/get_role_menu', { 'role': role, 'type': type })
            .then(function (response) {
                // console.log(response.data);

                $('.common_all').removeAttr('checked');
                var json_data = response.data;

                var mainkeys = Object.keys(json_data['menu_preference']);
                //console.log($mainkeys.length);
                if (json_data['menu_preference'] != null) {
                    $('.preference_id').val(json_data['menu_preference']['preference_id']);
                    for (var key in json_data['menu_preference']) {
                        //console.log(json_data['menu_preference'][key].length);
                        if (json_data['menu_preference'][key].length == undefined) {

                            for (var key_s in json_data['menu_preference'][key]) {

                                $('.select_sub_menus_all' + key_s).prop('checked', true);
                                if (json_data['menu_preference'][key][key_s].length == undefined) {
                                    for (var key_ss in json_data['menu_preference'][key][key_s]) {
                                        //console.log(json_data['menu_preference'][key][key_s][key_ss]);
                                        $('.select_inner_sub_menus_all' + key_ss).prop('checked', true);
                                    }
                                }
                            }


                        }

                        $('.main_menu_all' + key).prop('checked', true);
                    }

                    /*for(var i=0; i<json_data['menu_preference'].length; i++){
                        if(json_data['menu_preference'][i]['sub_menu'].length != 0){
                    
                            for(var j=0; j<json_data['menu_preference'][i]['sub_menu'].length; j++){
                                $('.select_sub_menus_all'+json_data['menu_preference'][i]['sub_menu'][j]).prop('checked',true); 
                            }
                        }
                        console.log(json_data['menu_preference'][i]);
                        $('.main_menu_all'+json_data['menu_preference'][i]['main_menu']).prop('checked',true); 
                    }*/
                }
            });
    }


    $scope.delete_Submenu_details = function (menu_id) {

        $.confirm({
            title: 'Menu Details',
            content: 'Are you sure to Delete!',

            buttons: {
                Ok: function () {

                    $http.post('menu_details/DeleteMenus', { 'menu_id': menu_id })
                        .then(function (responce) {
                            location.reload();
                        });

                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
        });

    }

});

var sub_menu = 1;

function add_Submenu_details() {
    if (sub_menu) {
        sub_menu++;
        var objTo = document.getElementById('submenu_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "removeclass" + sub_menu);
        var rdiv = 'removeclass' + sub_menu;
        divtest.innerHTML =


            '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">' +
            '<div class="form-group">' +
            '<div class="form-line">' +
            '<input type="number" class="form-control" name="sub_order_no[]" placeholder="Order No" required>' +
            '</div>' +
            '</div>' +
            '</div>' +
            ' <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">' +
            '<div class="form-group">' +
            '<div class="form-line">' +
            '<input type="text" class="form-control" placeholder="Icon" name="sub_menu_icon[]" >' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">' +
            '<div class="form-group">' +
            '<div class="form-line">' +
            '<input type="text" class="form-control" placeholder="Menu Name" name="sub_menu_name[]" required>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">' +
            '<div class="form-group">' +
            '<div class="form-line">' +
            '<input type="text" class="form-control" placeholder="URL" name="sub_menu_url[]" required>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="col-sm-1">' +
            '<button class="btn btn-danger " type="button" onclick="remove_add_more_exp(' + sub_menu + ');" >  <i class="fa fa-minus" aria-hidden="true"></i></button>' +
            '</div>';

        objTo.appendChild(divtest)
    }
}

function remove_add_more_exp(rid) {
    $('.removeclass' + rid).remove();
}

function checked_main_menus(menu_id) {

    if ($('.main_menu_all' + menu_id).prop("checked") == true) {

        $('.sub_menus_all' + menu_id).prop('checked', true);
        $('.inner_sub_menus_all' + menu_id).prop('checked', true);
        //$('.main_hav_sub'+menu_id).prop("indeterminate", true);   
        //$('.sub_hav_inner_sub'+menu_id).prop("indeterminate", true);
    }
    else {
        $('.sub_menus_all' + menu_id).removeAttr('checked');
        $('.inner_sub_menus_all' + menu_id).removeAttr('checked');
        //$('.main_hav_sub'+menu_id).prop("indeterminate", false);
        //$('.sub_hav_inner_sub'+menu_id).prop("indeterminate", false);

    }
}
function checked_sub_menus(menu_id) {
    if (menu_id) {
        if ($('.sub_menus_all' + menu_id).prop("checked") == true) {
            $('.main_menu_all' + menu_id).prop("checked", true);
            $('.sub_menus_all' + menu_id).prop('checked', true);
            $('.inner_sub_menus_all' + menu_id).prop('checked', true);
            // $('.sub_hav_inner_sub'+menu_id).prop("indeterminate", true);
        }
        else {
            $('.main_menu_all' + menu_id).removeAttr("checked");
            $('.sub_menus_all' + menu_id).removeAttr('checked');
            $('.inner_sub_menus_all' + menu_id).removeAttr('checked');
            //$('.sub_hav_inner_sub'+menu_id).prop("indeterminate", false);

        }
    }
}
function checked_sub_menus2(menu_id) {
    if (menu_id) {
        if ($('.sub_menus_all' + menu_id).prop("checked") == true) {
            $('.main_menu_all' + menu_id).prop("checked", true);
        }
        else {
            //$('.main_menu_all'+menu_id).removeAttr("checked");
        }
    }

}

function check_inner_sub_menus(menu_id) {
    if (menu_id) {
        if ($('.inner_sub_menus_all' + menu_id).prop("checked") == true) {
            $('.main_menu_all' + menu_id).prop("checked", true);
            $('.sub_menus_all' + menu_id).prop("checked", true);
        }
        else {
            //$('.main_menu_all'+menu_id).removeAttr("checked");
        }
    }

}

// ===== Scroll to Top ==== 
$('#totop').hide();
$(window).scroll(function () {
    "use strict";
    if ($(this).scrollTop() >= 100) {        // If page is scrolled more than 50px
        $('#totop').fadeIn(200);    // Fade in the arrow
        $('#totop').addClass('top-visible');
    } else {
        $('#totop').fadeOut(200);   // Else fade out the arrow
        $('#totop').removeClass('top-visible');
    }
});


$('#totop').click(function () {      // When arrow is clicked
    $('body,html').animate({
        scrollTop: 0                       // Scroll to top of body
    }, 500);
    return false;
});

function validate_username(baseurl, id, uname) {
    //alert(baseurl+'User_details/validate_username');
    $.ajax({
        type: 'POST',
        url: baseurl + 'User_details/validate_username',
        data: 'uname=' + uname,
        beforeSend: function () {

        },
        success: function (resp) {
            if (resp > 0) {
                $("#" + id).val("");
                $("#" + id + "_error").text("You entered username '" + uname + "' is already exist!");
            }
            else {
                $("#" + id + "_error").text("");
            }
        }
    });
}

function validate_menu(baseurl, id, menu) {
    //alert(baseurl+'User_details/validate_username');
    var type = $("#menu_type").val();

    if (type != "" && menu != "") {
        $.ajax({
            type: 'POST',
            url: baseurl + 'Menu_details/validate_menu',
            data: 'type=' + type + "&menu=" + menu,
            beforeSend: function () {

            },
            success: function (resp) {
                //alert(resp);
                if (resp > 0) {
                    $("#" + id).val("");
                    $("#" + id + "_error").text("'" + menu + "' is already exist in '" + type + "'");
                }
                else {
                    $("#" + id + "_error").text("");
                }
            },
            error: function (resp) {
                console.log(resp.responseText);
            }
        });
    }
}
//This function called for menu adding form in Menu_details
function show_hide_parent_add(baseurl, val) {
    if (val > 0) {
        var parent_menu = (val - 1);
        $.ajax({
            type: 'POST',
            url: baseurl + 'Menu_details/GetParentMenus',
            data: 'parent_menu=' + parent_menu,
            beforeSend: function () {

            },
            success: function (resp) {
                //alert(val);
                //Add form
                $("#parent_id").html(resp);
                $("#parent_id_div").css("display", "block");
            }
        });

    }
    else {
        $("#parent_id").html("<option value=''>-- Select a parent --</option>");
        $("#parent_id_div").css("display", "none");
    }
}
//This function called for menu editing form in Menu_details
function show_hide_parent_edit(val) {
    console.log(val);
    if (val > 0) {
        var parent_menu = (val - 1);
        $.ajax({
            type: 'POST',
            url: 'menu_details/GetParentMenus',
            data: 'parent_menu=' + parent_menu,
            beforeSend: function () {

            },
            success: function (resp) {

                console.log(resp);

                $("#edit_parent_id").html(resp);
                $("#edit_parent_id_div").css("display", "block");
            }
        });

    }
    else {
        $("#edit_parent_id").html("<option value=''>-- Select a parent --</option>");
        $("#edit_parent_id_div").css("display", "none");
    }
}

function validateAddRole(baseurl) {
    var role = $("#role").val();
    var type = $("#type").val();
    //alert(role);
    $("#errorAddingRole").html("");
    if (role && type) {
        $.ajax({
            type: 'POST',
            url: baseurl + 'User_role/isExistRole',
            data: 'role=' + role + '&type=' + type,
            beforeSend: function () {
                $("#role_error").html("<span style='color: #ff9600'>Validating...</span>");
            },
            success: function (resp) {
                //alert(resp);
                if (resp > 0) {
                    $("#role").val("");
                    $("#role_error").html("'" + role + "' is already exist  in '" + type + "'");
                }
                else {
                    $("#role_error").html("");
                }
            }
        });
    }
    else if (!type && !role) {
        $("#errorAddingRole").html("<span style='color: #ff0000eb'>Enter role name</span>");
    }
    else if (!type) {
        $("#errorAddingRole").html("<span style='color: #ff0000eb'>Select a type</span>");
    }
    else {
        $("#errorAddingRole").html("");
    }
}
function isEmail(id, email) {
    var re = /\S+@\S+\.\S+/;
    if (re.test(email) == false) {
        $("#" + id).val("");
        $("#" + id).attr("placeholder", "Enter valid email");
    }
}

function isOthers(id, catId) {
    if (catId == 'Others') {
        $("." + id + "_new_category").slideDown("fast");

    }
    else {
        $("." + id + "_new_category").slideUp("fast");
    }
}

function getProductQtyUOM(id, pcode) {
    if (pcode) {
        $.ajax({
            type: 'post',
            url: 'Purchase/Get_Product_UOM',
            data: 'product_code=' + pcode,
            success: function (data) {
                //alert("."+id+' '+data);
                $("." + id).html("<span style='color:#cc2424; font-weight: bold'>Enter value in " + data + "</span>");
                $("." + id).val(data);
            }
        });
    }
    //$("."+id).html(pcode);
}

/*$(".alert").fadeOut(5000).first().fadeOut(5000);
setTimeout(showNotifications, 4000);
function showNotifications() {
    $(".alert:visible").remove();
    $(".alert:first").fadeOut(5000);
    if ($(".alert").length > 0) {
        setTimeout(showNotifications, 4000);
    }
} */     