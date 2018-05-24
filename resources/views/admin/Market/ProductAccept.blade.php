@extends('layouts.admin')
@section('csstop')
<link href="{{asset('/js/select2/select2.min.css')}}" rel="stylesheet"/>
<title>{{$title}} | BlueIce</title>
@endsection
@section('body')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <strong class="pull-left">การยืนยันการรับสินค้า</strong>
            <div class="pull-right">{{ ($user!=='') ? "ทะเบียนรถ : ".$user->TruckNumber : '' }}</div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- tabs -->
                @if($user=='')
                    <div class='col-md-12'>
                        <center><h2>ไม่มีข้อมูลรถ กรุณาติดต่อผู้ดูแลระบบ</h2></center>
                    </div>
                @else
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="false">QR Code</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-expanded="false">รายจ่าย</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <form id="FormScan">
                                    <div class="col-sm-4">
                                        <input type="text" name="scan" class="form-control scan" placeholder="Scan barcode or QR code">
                                        <!-- onkeydown="return false;"> -->
                                    </div>
                                    <!-- </form> -->
                                    <div class="col-sm-12 nonCus" style="display: none;">
                                        <center>
                                            <p class="text-danger">ไม่มีรหัสลูกค้า</p>
                                        </center>
                                    </div>
                                    <div class="col-sm-12 list table-responsive" style="display: none;">
                                    <!-- <form id="FormScan" method="post" class="form-horizontal" action=""> -->
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" class="truck" name="truckid">
                                        <input type="hidden" class="number" value='0'>
                                        <center>
                                            <h2 class="store-unpaid">
                                                <i class="store"></i>
                                            </h2>
                                        </center>
                                        <br>
                                        <button type="button" class="btn-success fa fa-plus pull-right" onclick="clone()"></button>
                                        <table id="nameCustomer" align="center" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th style="width:  54px;"><center>ลำดับ</center></th>
                                                    <th style="width: 200px;"><center>รายการสินค้า</center></th>
                                                    <th style="width: 112px;"><center>จำนวนส่ง</center></th>
                                                    <th style="width: 112px;"><center>จำนวนเติม</center></th>
                                                    <th style="width: 112px;"><center>จำนวนแถม</center></th>
                                                    <th style="width: 120px;"><center>คืนกระสอบ</center></th>
                                                    <th style="width: 115px;"><center>หน่วย</center></th>
                                                    <th style="width: 112px;"><center>ชำระเงิน</center></th>
                                                    <th style="width: 112px;"><center>ค้างชำระ</center></th>
                                                    <th style="width: 112px;"><center>ชำระหนี้</center></th>
                                                    <th style="width: 120px;"><center>หน่วย</center></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbloop">

                                            </tbody>
                                            <tfoot>
                                                <tr class="text-right">
                                                    <input type="hidden" class="form-control location" name="location" value="">
                                                    <!-- <input type="hidden" class="form-control longitude" value=""> -->
                                                    <td colspan="11"><button type="button" class="btn btn-sm btn-primary btn-submit" data-toggle="modal" data-target="#mapModal" style="width:90px; height: 40px"><i class="fa fa-save"></i> บันทึก</button></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    <!-- </div> -->
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="messages" role="tabpanel" aria-expanded="false">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class=" btn-success fa fa-plus pull-right" onclick="clone_expenses()"></button>
                                    <form id="FormExpenses" method="post" class="form-horizontal" action="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" class="truck_id" name="truckid" value={{($user) ? $user->TruckID : ''}}>
                                        <table id="nameCustomer" align="center" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="table-danger" width="50%"><center>รายจ่าย</center></th>
                                                    <th class="table-danger" width="15%"><center>หน่วยนับ</center></th>
                                                    <th class="table-danger" width="15%"><center>จำนวน</center></th>
                                                    <th class="table-danger" width="25%"><center>ราคา</center></th>
                                                </tr>
                                            </thead>
                                            <tbody class='tbloop_expenses'>

                                            </tbody>
                                            <tfoot>
                                                <tr class="text-right">
                                                    <td colspan="10"><button type="button" class="btn btn-sm btn-primary btn-submit-expenses" style="width:90px; height: 40px"><i class="fa fa-save"></i> บันทึก</button></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        <!-- !tabs!-->
        </div>
    </div>
</div>
<table style="display: none;">
    <tr id="collapseExample2">
        <td style="vertical-align: middle;" class="text-center number"><span class='count'>1</span></td>
        <td style="vertical-align: middle;">
            <input type="hidden" name="status[]" value="0">
            <input type="hidden" name="PayID[]" value="0">
            <input type="hidden" class="price" value="0">
            <select class="form-control form-info product" name="product[]">
                <option value="">Select product</option>

            </select>
        </td>
        <td><input type="number" name="pro_send[]" class="form-control compute amount" placeholder="0" min="0"></td>
        <td><input type="number" name="pro_add[]" class="form-control" placeholder="0" min="0"></td>
        <td><input type="number" name="pro_free[]" class="form-control" placeholder="0" min="0"></td>
        <td><input type="number" name="pro_resend[]" class="form-control" id="resend" placeholder="0" min="0"></td>
        <td style="vertical-align: middle;" class="text-center">
            <select class="form-control form-info" name="unit[]">
                <option value="">Please select</option>
                @foreach($units as $unit)
                <option value="{{ $unit->unit_id }}">{{ $unit->name_th }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="price_pay[]" class="form-control compute pay" placeholder="0" min="0"></td>
        <td><input type="number" name="price_owe[]" class="form-control price_owe" placeholder="0" min="0" readonly></td>
        <td><input type="number" name="price_debt[]" class="form-control" placeholder="0" min="0"></td>
        <td>
            <span class="input-group-btn">
                <select class="form-control form-info" name="currency[]">
                    <!-- <option value="">Please select</option> -->
                    @foreach($currencys as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                    @endforeach
                </select>
            </span>
        </td>
    </tr>
</table>
<table style="display: none;">
    <tr class="tr_expense">
        <td>
            <select class="form-control form-info select_expense" name="atexpenses[]" style="width: 100%;">
                @foreach($ExpList as $list)
                    <option>{{ $list->ExpList }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="AccUnit[]" class='form-control' placeholder="หน่วยนับ">
        </td>
        <td>
            <input type="hidden" name="status[]" value="0">
            <input type="hidden" name="ExpID[]" id="ExpID" value="0">
            <input type="number" name="amount[]" id="amount" class='form-control' placeholder="จำนวน">
        </td>
        <td>
           <div class="input-group">
                <input type="number" name="pexpenses[]" id="pexpenses" class="form-control" placeholder="ราคารวม">
                <span class="input-group-btn">
                    <select class="form-control form-info" name="crexpenses[]" id="crexpenses">
                        @foreach($currencys as $currency)
                        <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                        @endforeach
                    </select>
                </span>
            </div>
        </td>
    </tr>
</table>

<!-- Modal -->
<!-- <div id="mapModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-info">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left">การตรวจสอบการขนส่ง</h4>
            </div>
            <div class="modal-body">
                <center>
                    <div id="map" style="width:700px;height:400px;background:yellow;width: 100%"></div>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->
@endsection
@section('jsbottom')
<script src="{{asset('/js/select2/select2.min.js')}}"></script>
<script>

    $(document).ready(function(){
        var truckId = $('.truck_id').val();
        $.ajax({
            method : "get",
            url : url+"/Market/ProductAccept/getExpenseToday/"+truckId,
            dataType : 'json'
        }).done(function(rec){
            if(rec.expToday.length>0){
                $.each(rec.expToday, function(i, today){
                    var html = '';
                    html +=
                        '<tr class="tr_expense">\
                            <td>\
                                <select class="form-control form-info select_expense" id="select_expense'+(i+1)+'" name="atexpenses[]" style="width: 100%;">';
                                    $.each(rec.expList, function(j, list){
                                        var check_list = (today.ExpList==list.ExpList) ? 'selected' : '';
                                        html += '<option '+check_list+' >' + list.ExpList + '</option>';
                                    })
                    html +=     '</select>\
                            </td>\
                            <td>\
                                <input type="text" name="AccUnit[]" class="form-control accunit" id="accunit" value="'+today.AccUnit+'">\
                            </td>\
                            <td>\
                                <input type="hidden" name="status[]" value="1">\
                                <input type="hidden" name="ExpID[]" value="'+today.ExpID+'">\
                                <input type="number" name="amount[]" class="form-control expamount" id="expamount" value="'+today.ExpAmount+'">\
                            </td>\
                            <td>\
                                <div class="input-group">\
                                <input type="number" name="pexpenses[]" class="form-control expprice" id="expprice" value="'+today.ExpPrice+'">\
                                <span class="input-group-btn">\
                                    <select class="form-control form-info" name="crexpenses[]">';
                                        $.each(rec.currency,function(k, currency){
                                            var check_currency = (today.ExpUnit==currency.id) ? 'selected' : '';
                                            html += '<option value="'+currency.id+'" '+check_currency+'>'+currency.currency_name+'</option>';
                                        })
                    html +=         '</select>\
                                </span>\
                            </td>\
                        </tr>';
                    $(".tbloop_expenses").append(html);
                    $('#select_expense'+(i+1)).select2({ tags: true});
                });
            }else{
                $(".tr_expense").clone().appendTo(".tbloop_expenses").find('.select_expense').attr('id','select_expense1');
                $('#select_expense1').select2({ tags: true});
            }
        })
    });

    var sumpo = [];
    $(".scan").focus();

    function geoFindMe() {
        function success(position) {
            var latitude  = position.coords.latitude;
            var longitude = position.coords.longitude;

            $(".location").val(latitude + ' ' + longitude);
            // $(".longitude").val(longitude);
        }

        function error() {
            console.log("Unable to retrieve your location");
        }

        navigator.geolocation.getCurrentPosition(success, error);
    }

    $(".scan").on('input', function(e) {
        if($(".scan").val().length>=4) {
            getSearch();
        }
    });

    $("body").on('keyup', '.compute', function () {
        var amount = ($(this).closest('tr').find('td .amount').val()) ? parseFloat($(this).closest('tr').find('td .amount').val()) : 0;
        var pay = ($(this).closest('tr').find('td .pay').val()) ? parseFloat($(this).closest('tr').find('td .pay').val()) : 0;
        var price = ($(this).closest('tr').find('td .price').val()) ? parseFloat($(this).closest('tr').find('td .price').val()) : 0;
        var debt = (amount==0 || pay==0 || price==0) ? 0 : (price*amount)-pay;
        if(debt>0){
            $(this).closest('tr').find('td .price_owe').val(debt);
        }else{
            $(this).closest('tr').find('td .price_owe').val(0);
        }
        countSum();
    });

    $("body").on('change', '.product', function() {
        var id = $(this).val();
        var data = $(this);
        $.ajax({
            method : "GET",
            url : url+"/Market/ProductAccept/product_detail/"+id,
            dataType : 'json'
        }).done(function(res){
            data.closest('tr').find('td .price').val(res.price.ProPrice);
            countSum();
        });
    })
    var unoaid = 0;
    function getSearch() {
        $(".list").hide();
        $(".nonCus").hide();
        geoFindMe();
        $.ajax({
            method : "POST",
            url : url+"/Market/ProductAccept/search",
            dataType : 'json',
            data : $("#FormScan").serialize()
        }).done(function(rec){
            if(rec.cus!=null&&rec.cus!="") {
                $(".list").show();
                $(".truck").val(rec.cus.TruckID);
                $(".truck_id").val(rec.cus.TruckID);
                $(".store").text(rec.cus.CusName);
                $(".text-unpaid").remove();
                unpaid = rec.unpaid;
                if(rec.unpaid>0) {
                    $(".store-unpaid").append('<i class="text-danger text-unpaid">ค้างจ่าย ' + rec.unpaid.toFixed(2) + '<span></span></i>');
                }else{
                    $(".store-unpaid").append('<i class="text-danger text-unpaid">ค้างจ่าย 0 <span></span></i>');
                }
                if(rec.today.length>0){
                    $('.tbloop').empty();
                    $('.number').val(rec.today.length);
                    $("#collapseExample2 .count").text(rec.today.length+1);
                    $.each(rec.today, function(i, item) {
                        var html = '';
                        html +=
                            '<tr>\
                                <td style="vertical-align: middle;" class="text-center number"><span class="count">'+(i+1)+'</span></td>\
                                <td style="vertical-align: middle;">\
                                    <input type="hidden" name="status[]" value="1">\
                                    <input type="hidden" name="PayID[]" value="'+item.PayID+'" readonly>\
                                    <select class="form-control form-info products" name="product[]" id="product'+i+'" onchange="assignOwe(this)" required readonly="readonly">';

                                        $("#product"+i).empty();
                                        html += '<option value="">Select product</option>';
                                        $.each(rec.truck_pro, function(j, product) {
                                            var check_product = (item.ProID==product.ProID) ? 'selected' : '';
                                            html += '<option value="' + product.ProID + '" data-price="'+product.ProPrice+'" '+check_product+' >' + product.ProName + '</option>';
                                        });

                        html +=     '</select>\
                                </td>\
                                <td><input type="number" name="pro_send[]" class="form-control" value="'+item.ProSales+'" min="0" readonly="readonly"></td>\
                                <td><input type="number" name="pro_add[]" class="form-control" value="'+item.ProAdd+'" min="0" readonly="readonly"></td>\
                                <td><input type="number" name="pro_free[]" class="form-control" value="'+item.ProFree+'" min="0" readonly="readonly"></td>\
                                <td><input type="number" name="pro_resend[]" class="form-control" value="'+item.BagReturn+'" min="0" readonly="readonly"></td>\
                                <td style="vertical-align: middle;" class="text-center">\
                                    <select class="form-control form-info" id="unit'+i+'" name="unit[]" readonly="readonly">';

                                        $("#unit"+i).empty();
                                        html += '<option value="">Select unit</option>';
                                        $.each(rec.units, function(j, unit) {
                                            var check_unit = (item.UnitID==unit.unit_id) ? 'selected' : '';
                                            html += '<option value="' + unit.unit_id + '" '+check_unit+' >' + unit.name_th + '</option>';
                                        });

                        html +=     '</select>\
                                </td>\
                                <td><input type="number" name="price_pay[]" class="form-control" value="'+item.Pay+'" min="0" readonly="readonly"></td>\
                                <td><input type="number" name="price_owe[]" class="form-control" value="'+item.Accured+'" min="0" readonly="readonly"></td>\
                                <td><input type="number" name="price_debt[]" class="form-control" value="'+item.PayDebt+'" min="0" readonly="readonly"></td>\
                                <td>\
                                    <span class="input-group-btn">\
                                        <select class="form-control form-info" id="currency'+i+'" name="currency[]" readonly>';

                                        $("#currency"+i).empty();
                                        html += '<option value="">Select currency</option>';
                                        $.each(rec.currencys, function(k, currency) {
                                            var check_currency = (item.CurrencyID==currency.id) ? 'selected' : '';
                                            html += '<option value="' + currency.id + '" '+check_currency+' >' + currency.currency_name + '</option>';
                                        });

                        html +=         '</select>\
                                    </span>\
                                </td>\
                            </tr>\
                        ';
                        $(".tbloop").append(html);
                    });
                }else{
                    $('.tbloop').empty();
                    $('.number').val(0);
                    clone();
                }

                $(".product").empty();
                $(".product").append('<option value="">Select product</option>');
                $.each(rec.truck_pro, function(i, item) {
                    $(".product").append('<option value="' + item.ProID + '" data-price="'+item.ProPrice+'">' + item.ProName + '</option>');
                });

                $.each(rec.list_unpaid, function(i, item) {
                    sumpo.push([item.sum, item.ProID]);
                });
                // console.log($('body').find('#nameCustomer').find('tbody > tr').find('#product0').val());
                countSum();
            } else {
                $(".nonCus").show();
            }
        });
    }
    function countSum() {
        var all_accept = 0;
        var all = 0;
        var price_pay = 0;
        $.each($('body').find('#nameCustomer').find('tbody > tr'),function(k,v) {
            // console.log(parseFloat($(v).find('select[name*="product"]').find('option[value="'+$(this).find('select[name*="product"]').val()+'"]').data('price')));
            // all += (parseFloat($(v).find('select[name*="product"]').find('option[value="'+$(this).find('select[name*="product"]').val()+'"]').data('price')) * $(v).find('input[name*="pro_send"]').val()) + (parseFloat($(v).find('select[name*="product"]').find('option[value="'+$(this).find('select[name*="product"]').val()+'"]').data('price')) * $(v).find('input[name*="pro_add"]').val());
            if($(v).find('select[name*="product"]').attr('readonly')!="readonly") {
                all += (parseFloat($(v).find('select[name*="product"]').find('option[value="'+$(this).find('select[name*="product"]').val()+'"]').data('price')) * $(v).find('input[name*="pro_send"]').val());
            } else {
                all_accept += (parseFloat($(v).find('select[name*="product"]').find('option[value="'+$(this).find('select[name*="product"]').val()+'"]').data('price')) * $(v).find('input[name*="pro_send"]').val());
                price_pay += parseFloat($(v).find('input[name*="price_pay"]').val());
            }
        });
        all = $.isNumeric(all) ? all : 0;
        // all_accept = $.isNumeric(all_accept) ? all_accept : 0;
        // unpaid = $.isNumeric(unpaid) ? unpaid : 0;
        // console.log(all_accept);
        // if(unpaid<all_accept) {
        //     console.log(123);
        //     unpaid = all_accept - price_pay;
        //     console.log(unpaid);
        //     $(".store-unpaid").empty();
        //     $(".store-unpaid").append('<i class="text-danger text-unpaid">ค้างจ่าย ' + unpaid.toFixed(2) + '<span></span></i>');
        // }else{
        //     unpaid = 0;
        //     $(".store-unpaid").empty();
        //     $(".store-unpaid").append('<i class="text-danger text-unpaid">ค้างจ่าย 0 <span></span></i>');
        // }
        console.log(unpaid);
        if(all+unpaid>=0) {
            var text = ' รวมชำระ '+(all+unpaid).toFixed(2);
        } else {
            var text = ' เครดิตคงเหลือ '+(-(all+unpaid)).toFixed(2);
        }
        $('body').find('.store-unpaid').find('span').html(' ราคาส่ง '+all.toFixed(2)+text);
    }
    function clone(){
        $("#collapseExample2").clone().appendTo(".tbloop").find("input").val("0");
        $.each($('.tbloop').find('tr'),function(i,v){
            $(this).find('td:first').text(i+1);
        })
    }

    function clone_expenses(){
        var row_expense = ($('.select_expense').length);
        $(".tr_expense:last").clone().appendTo(".tbloop_expenses").find('.select_expense').attr('id','select_expense'+row_expense);
        $('#select_expense'+row_expense).select2({ tags: true});
    }

    function assignOwe(me){
        console.log($(me).parent().parent().find(".price_owe").val());

        var check=false;
        $.each(sumpo, function(i, item) {
            if(item[1]==me.value) {
                $(me).parent().parent().find(".price_owe").val(item[0]);
                check=true;
            } else {
                if(check!=true) {
                    $(me).parent().parent().find(".price_owe").val(0);
                }
            }
        });
        countSum();
    }
    $('body').on('keyup, change','input[type="number"]',function() {
        countSum();
    });
</script>

<!-- Form -->
<script type="text/javascript">
    $('body').on('click', '.btn-submit', function(){
        $.ajax({
            method : "POST",
            url : url+"/Market/ProductAccept",
            dataType : 'json',
            data : $("#FormScan").serialize()
        }).done(function(rec){
            if(rec.type == 'success'){
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                }).then((result) => {
                  if (result.value) {
                    location.reload();
                  }
                });
            }else{
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                });
            }
        });
    });

    $('body').on('click', '.btn-submit-expenses', function(){

        // $( "#pexpenses" ).rules( "add", {
        //       required: true,
        //       messages: {
        //         required: "Required input"
        //       }
        //     });
        // $( "#amount" ).rules( "add", {
        //       required: true,
        //       messages: {
        //         required: "Required input"
        //       }
        //     });
        $.ajax({
            method : "POST",
            url : url+"/Market/ProductAccept/expenses",
            dataType : 'json',
            data : $("#FormExpenses").serialize()
        }).done(function(rec){
            if(rec.type == 'success'){
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                }).then((result) => {
                  if (result.value) {
                    location.reload();
                  }
                });
            }else{
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                });
            }
        });
    });
</script>
@endsection
