@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<style>
.a4{
    width: 23cm;
    height: 29.7cm;
    padding: 1cm;
}
.card-body, .card-block {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1rem;
}
.form-control {
    padding: 0rem 0rem;
}
.form-group {
    margin-bottom: 0rem;
}
</style>
<title>{{$title}} | BlueIce</title>
@endsection

@section('body')
<div class="card card-accent-primary col-sm-12">
    <div class="card-header">
        สร้าง INVOICE
    </div>
    <div class="card-body a4" style="margin: auto;">
      <form id="FormCustomerInvoice">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <section class="invoice">

            <!-- title rownopad -->
        <div class="rownopad">
          <div class="card card-accent-primary col-sm-5">
            <div class="card-body col-sm-12">
            <address>
              <div class="row">
              </div>
              <div class="branch-detail">
                {{$branch_address[0]->BraNum}}
                {{($branch_address[0]->BraRoad !='')?'ถนน'.$branch_address[0]->BraRoad:''}}<br>
                {{($branch_address[0]->BraTambon!='')?'ตำบล '.$branch_address[0]->district_name:''}}
                {{($branch_address[0]->BraCity!='')?'อำเภอ '.$branch_address[0]->amphur_name:''}}<br>
                {{($branch_address[0]->BraState!='')?'จังหวัด '.$branch_address[0]->province_name:''}}
                {{($branch_address[0]->BraCountry!='')?'ประเทศ '.$branch_address[0]->name_th:''}}<br>
                {{($branch_address[0]->BraZipcode!='')?'รหัสไปรษณีย์ '.$branch_address[0]->BraZipcode:''}}<br>
                {{($branch_address[0]->BraPhone!='')?'เบอร์โทร '.$branch_address[0]->BraPhone:($branch_address[0]->BraMobile!='')?'เบอร์โทร'.$branch_address[0]->BraMobile:''}}<br>
                {{($branch_address[0]->BraFax!='')?'แฟ็กซ์ '.$branch_address[0]->BraFax:''}}

              </div>
            </address>
            </div>
          </div>

          <div class="col-sm-1"></div>
          <div class="col-sm-6" style="padding: 1px;">
            <h2 class="page-header">
              <div class="form-group" style="margin-top: 5px;">
                <div class="input-group date">
                  <span class="input-group-addon">Date: </span>
                  <input type="text" id="datedoc" name="datedoc" class="datecalendar form-control"/>
                  <span class="input-group-addon btn-primary"><i class="fa fa-calendar"></i></span>
                </div>
              </div>
              <!-- <div class="form-group" style="margin-top: 5px;">
                <div class="input-group">
                  <span class="input-group-addon">PO#</span>
                  <input type="text" class="form-control" name="po_ref" value=""/>
                </div>
              </div> -->
              <div class="form-group" style="margin-top: 5px;">
                <div class="input-group">
                  <span class="input-group-addon">Invoice#</span>
                  <input type="text" class="form-control invice_id" name="invice_id" value="{{$ref_id}}" readonly/>
                </div>
              </div>
              <div class="form-group" style="margin-top: 5px;">
                <div class="input-group">
                  <span class="input-group-addon">Customer ID#</span>
                  <input type="text" class="form-control customer_id" name="customer_id" id="customer_id" value="" readonly/>
                </div>
              </div>
              <div class="form-group" style="margin-top: 5px;">
              <select class="form-control currency" name="currency" id="currency">
                    <option value="">กรุณาเลือกสกุลเงิน</option>
                    @foreach($currency as $currencys)
                        <option value="{{$currencys->id}}">{{$currencys->currency_name}}</option>
                    @endforeach
                </select>
              </div>
            </h2>
          </div>
        </div>
        <!-- info rownopad -->
                <!-- Table rownopad -->
        <div class="rownopad">
          <div class="card card-accent-primary col-sm-5">
            <div class="card-header">
              <strong>BILL TO</strong>
            </div>
            <div class="card-body col-sm-12">
              <div class="row">
                <select class="form-control bill_id" name="bill_id" id="bill_id">
                    <option value="">กรุณาเลือกลูกค้า</option>
                    @foreach($customer_payment as $customer_payments)
                        <option value="{{$customer_payments->CusNO}}">{{$customer_payments->CusName}}</option>
                    @endforeach
                </select>
              </div>
              <div class="supplier_address">

              </div>
            </div>
          </div>
          <!-- /.card -->
          <div class="col-sm-1"></div>
          <div class="card card-accent-primary col-sm-6">
            <div class="card-header">
              <strong>SHIP TO</strong>
            </div>
            <div class="card-body col-sm-12">
              <div class="row">
                <select class="form-control ship" name="ship" id="ship">
                  <option value="">กรุณาเลือกที่อยู่ส่ง</option>
                  @foreach($delivery_address as $deliverys)
                    <option value="{{$deliverys->AodID}}" data-id='{{$deliverys->CusID}}'>{{$deliverys->CusName}}</option>
                  @endforeach
                </select>
              </div>
              <div class="row ship_to">

              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
            <!-- /.rownopad -->
            <div class="rownopad">
                <table class="table table-bordered table-striped table-sm datatable">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">ITEM#</th>
                            <th style="width: 25%;text-align: center;">PRODUCTNAME</th>
                            <th style="width: 15%; text-align: center;">QTY</th>
                            <th style="width: 15%; text-align: center;">UNIT PRICE</th>
                            <!-- <th style="width: 15%; text-align: center;">TAX</th> -->
                            <th style="width: 15%; text-align: center;">TOTAL</th>
                            <th style="width: 10%; text-align: center;">Check</th>
                        </tr>
                    </thead>
                    <tbody class="product">
                        <!-- <tr>
                            <td style="text-align: center;"></td>
                            <td><div class="product_name"></div></td>
                            <td style="text-align: right;"><input type="text" class="form-control" name="qty" id="qty" value="" readonly></td>
                            <td style="text-align: right;"><input type="text" class="form-control" name="unit_price" id="unit_price" value=""></td>
                            <td style="text-align: right;"><input type="text" class="form-control" name="total" id="total" value="" readonly></td>
                            <td style="text-align: center;"><input type="checkbox" value=""></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <!-- /.rownopad -->
            <div class="rownopad">
                <div class="card card-accent-primary col-sm-5">
                    <div class="card-header">
                        <strong>Comments or Special Instructions</strong>
                    </div>
                    <div class="card-body col-sm-12">
                        <textarea class="form-control" rows="10" name="detail" id="detail"></textarea>
                    </div>
                </div>
                <!-- /.card -->
              <div class="col-sm-1"></div>
              <div class="card card-accent-primary col-sm-6">
                <div class="card-body rownopad col-sm-12">
                  <div class="col-sm-12 rownopad">
                    <div style="text-align: right;" class="col-sm-4"></div>
                    <div style="text-align: right;" class="col-sm-8"><center>PRICE</center></div>
                    <div class="form-group rownopad">
                      <div class="col-md-4">
                        <label class="form-control-label" for="hf-text">SUBTOTAL</label>
                      </div>
                      <div class="col-md-8">
                        <div class="input-group">
                          <input style="text-align: right;" type="text" id="subtotal" name="subtotal" class="input-group-addon subtotal" readonly="" value=0 onfocus="if(this.value==0){this.value=''}" value=""/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group rownopad">
                      <div class="col-md-4">
                        <label class="form-control-label" for="hf-text">TAX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                      </div>
                      <div class="col-md-8">
                        <div class="input-group">
                          <input style="text-align: right;" type="text" id="tax_all" name="tax_all" class="form-control tax_all" value=0 onfocus="if(this.value==0){this.value=''}" value=""/>
                          <input style="text-align: right;" type="hidden" id="res_tax_all" name="res_tax_all" class="form-control res_tax_all" value=""/>
                          <span class="input-group-addon">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group rownopad">
                      <div class="col-md-4">
                        <label class="form-control-label" for="hf-text">OTHER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                      </div>
                      <div class="col-md-8">
                        <div class="input-group">
                          <input style="text-align: right;" type="text" id="other_all" name="other_all" class="form-control other_all" value=0 onfocus="if(this.value==0){this.value=''}" value=""/>
                          <input style="text-align: right;" type="hidden" id="res_other_all" name="res_other_all" class="form-control res_other_all" value=""/>
                          <span class="input-group-addon">%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="form-group rownopad">
                    <div class="col-md-4">
                      <label class="form-control-label" for="hf-email">TOTAL</label>
                    </div>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input style="text-align: right;" id="total_count" name="total_count" class="input-group-addon total_count" readonly="" value=0 onfocus="if(this.value==0){this.value=''}" value=""/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <!-- /.card -->
            </div>
            <!-- this rownopad will not appear when printing -->
            <div class="rownopad no-print ">
                <div class="col-xs-12" style="margin: auto;">
                    <!-- <a href="" class="btn btn-success save"><i class="fa fa-check-square" aria-hidden="true" style="margin-top: 1px; "></i>  บันทึก</a> -->
                    <button type="submit" class="btn btn-primary save"> <i class="fa fa-check-square" aria-hidden="true" style="margin-top: 1px; "></i> บันทึก</button>
                    <button type="button" class="btn btn-danger cancel" ><i class="fa fa-times-rectangle" aria-hidden="true" style="margin-top: 1px;"></i> ยกเลิก</button>
                    <!-- <a href="#" class="btn btn-danger "><i class="fa fa-times-rectangle" aria-hidden="true" style="margin-top: 1px;"></i> ยกเลิก</a> -->
                    <!-- <a href="#" class="btn btn-outline-warning active "><i class="fa fa-print" aria-hidden="true"></i> พิมพ์</a> -->
                </div>
            </div>
        </section>
    </form>
    </div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<!-- DataTables -->
<script>
  // console.log(url);
$('.datecalendar').daterangepicker({
  singleDatePicker: true,
  locale: {
    format: 'YYYY-MM-DD'
}
});

$(function(){
  $('.bill_id').select2();
});

// $(document).ready(function() {
//     $('.js-example-basic-multiple').select2();
// });


function GetAddress() {
    var branch  = $('select[name="branch"]').val();

    $('.branch-detail').empty();
    if (branch != '') {
        $.ajax({
            method: "GET",
            url: url + "/Market/Invoice/GetAddress/"+branch,
            dataType:'html'
        }).done(function (rec) {
            $('.branch-detail').append(rec);
        });
    }

}

function GetBill() {
    var bill_id   = $('select[name="bill_id"]').val();
    $('.supplier_address').empty();
    if (bill_id != '') {
        $.ajax({
            method: "GET",
            url: url + "/Market/Invoice/GetBillAddress/"+bill_id,
            dataType:'html'
        }).done(function (rec) {
            $('.supplier_address').append(rec);
        });
    }

}
function GetShip() {
    var branch_id   = $('.ship').val();
    $('.ship_to').empty();
    if (branch_id != '') {
        $.ajax({
            method: "GET",
            url: url + "/Market/Invoice/GetShipAddress/"+branch_id,
            dataType:'html'
        }).done(function (rec) {
            $('.ship_to').append(rec);
        });
    }

}

$('body').on('change','.branch', function(){
    GetAddress();
});

$('body').on('change','.ship', function(){
    GetShip();
});
$( document ).ready(function() {
    ShipAddress();
});
// $('body').on('change','.bill_id', function(){
//     // console.log($(this)[0].value);
//     var branch_id   = $('.ship').val();
//     $('.ship_to').empty();
//         $.ajax({
//             method: "GET",
//             url: url + "/Market/Invoice/GetShipAddress/"+branch_id,
//             dataType:'html'
//         }).done(function (rec) {
//             $('.ship_to').append(rec);
//         });

// });

$('body').on('change','.bill_id', function(){
    ShipAddress();
    GetProduct();
    var customer_id = $(this).val();
    $('.customer_id').val(customer_id);
    $('.ship').val('');
    $('.ship_to').html('');
    $('.product').empty();
    if ($(this).val() == '') {
        $('.supplier_address').html('');
    }else{
      GetBill();
    }
    // $('.ship').select2();
    // var text = $(this).find('option[value="'+$(this).val()+'"]').text();
    // var abc = $('.select2-container:not(:first)');
    // $.each($('.select2-container:not(:first)').find('li:not(:first)'),function() {
      // if($(this)[0].innerHTML != text) {
      //   $('body').find('#'+$(this)[0].id).remove();
      // }
    // });
    // $('.select2-container:first)').remove();
  });
function ShipAddress() {
  // var test = $('.ship').find('option')[1];
  // console.log(test);

    $.each($('.ship').find('option'),function(k,v) {
       // console.log(k);
       // console.log('/');
       // console.log(v);
       // console.log($(this)[0]['dataset']['id']);
       // console.log($(v).data('id'));
       // console.log($('.bill_id').val());
        if(( $(v).data('id') == $( '.bill_id').val() )){
          // console.log($('#ship').select2());
            $(this).show();
        } else {
            $(this).hide();
        }
        $('.bill_id').val()
    });
}
var i = 0;
function GetProduct() {
    var CusNO   = $('select[name="bill_id"]').val();
    if (CusNO != '') {
            $.ajax({
              method: "GET",
              url: url + "/Market/Invoice/GetProduct/"+CusNO,
              dataType: 'json',
            }).done(function (rec) {
              $('.product').empty();
              var no = 1;
              $.each(rec, function( key, value ) {
                $('.product').append('<tr>'+
                    '<td style="text-align: center;">'+no+'</td>'+
                    '<td style="text-align: center;">'+value.ProName+'</td>'+
                    '<td style="text-align: center;"><input type="text" class="form-control qty" name="qty['+key+']" id="qty" value="'+value.ProSales+'" readonly></td>'+
                    '<td style="text-align: center;"><input type="text" class="form-control unit_price" name="unit_price['+key+']" id="unit_price" value="'+value.ProPrice+'"></td>'+
                    '<td style="text-align: center;"><input type="text" class="form-control total" name="total['+key+']" id="unit_price" value="'+value.ProSales*value.ProPrice+'" readonly></td>'+
                    '<td style="text-align: center;"><input type="checkbox" class="confirm_price" name="PayID['+key+']" value="'+value.PayID+'"></td>'+
                    '</tr>');
                no++;
              });
          });
    }
}
//  var i = 0;
// $('body').on('click','.AddProduct', function(){
//     var read = ($('#tax_all').val()!=0 && $('#tax_all').val()!='') ? 'readonly' : '';
//     $('.product').append('<tr>'+
//         '<td style="text-align: center;">'+ i + '</td>'+
//         '<td style="text-align: right;"><input type="text" class="form-control description" name="description['+i+']" id="description"></td>'+
//         '<td style="text-align: right;"><input type="text" class="form-control qty" name="qty['+i+']" id="qty" onfocus="if(this.value==0){this.value=\'\'}" value="0"></td>'+
//         '<td style="text-align: right;"><input type="text" class="form-control unit_price" name="unit_price['+i+']" id="unit_price" onfocus="if(this.value==0){this.value=\'\'}" value="0"></td>'+
//         // '<td style="text-align: right;"><input type="text" class="form-control tax" name="tax['+i+']" id="tax" onfocus="if(this.value==0){this.value=\'\'}" value="0" '+read+'></td>'+
//         '<td style="text-align: right;"><input type="text" class="form-control total" name="total['+i+']" id="total" readonly onfocus="if(this.value==0){this.value=\'\'}" value="0"></td>'+
//         '<td style="text-align: center;"><input type="checkbox" value=""></td>'+
//         // '<td style="text-align: center;"><button type="button" class="btn btn-danger delete-row">ลบ</button></td>'+
//         '</tr>'
//         );
//         i++;
//         $('.description[name="description['+i+']"]').rules("add", {
//         required:true,
//         messages: {
//           required: "กรุณาระบุ",
//         }
//   });
//     index();

// });

$('body').on('keyup','#unit_price', function(){
  var qty        = $(this).closest('tr').find('.qty').val();
  var unit_price = $(this).val();
  $(this).closest('tr').find('.total').removeAttr('value');
  $(this).closest('tr').find('.total').attr('value',qty*unit_price);
  CalculatePrice();
});
$('body').on('click','.confirm_price',function(){
      CalculatePrice();
});

// $('body').on('click','.delete-row',function(){
//     $(this).closest('tr').remove();
//     index();
//     CalculatePrice();
// });
// function index() {
//     var index=1;
//     $.each($('body').find('tbody > tr'), function(){
//         $(this).find('td:first').text(index);
//         index++;
//     });
// }
// var check_tax = 0;
$('body').on('input','.tax_all,.shipping_all,.other_all', function(){
    CalculatePrice();
  });

function CalculatePrice() {
    var subtotal = 0;
    $.each($('.total'), function(){
      if ($(this).closest('tr').find('input:checkbox').is(':checked')) {
        subtotal += parseFloat($(this).val());
      }
    });

    $('#subtotal').val(subtotal);

    if(!$.isNumeric($('.shipping_all').val())) {
    $('.shipping_all').val(0);
    }
    if(!$.isNumeric($('.other_all').val())) {
      $('.other_all').val(0);
    }
    // console.log(subtotal);
    // var shipping_all = ($('.shipping_all').val() !='')? parseFloat($('.shipping_all').val()) : 0;

    var tax_all      = $('.tax_all').val();
    var other_all    = ($('.other_all').val() != '')? parseFloat($('.other_all').val()) : 0;
    var res_tax_all  = $('.res_tax_all').val(subtotal*(tax_all/100));
    var res_other_all  = $('.res_other_all').val(subtotal*(other_all/100));
    $('.total_count').val(parseFloat(subtotal+(subtotal*(tax_all/100))-(subtotal*(other_all/100))));
}

// function CalculatePrice() {
//     check_tax = 0;
//     var subtotal = 0;
//     $.each($('.total'), function(){
//       subtotal += parseFloat($(this).val());
//       if (check_tax == 0) {
//       if($(this).closest('tr').find('.tax').val() != 0) {
//         $('#tax_all').attr('readonly','readonly');
//         check_tax = 1;
//       }else{
//         $('#tax_all').removeAttr('readonly');
//       }
//      }
//     });
//     $('#subtotal').val(subtotal);
//     if(!$.isNumeric($('.shipping_all').val())) {
//     $('.shipping_all').val(0);
//     }
//     if(!$.isNumeric($('.other_all').val())) {
//       $('.other_all').val(0);
//     }
//     var tax_all      = $('.tax_all').val();
//     var shipping_all = ($('.shipping_all').val() !='')? parseFloat($('.shipping_all').val()) : 0;
//     var other_all    = ($('.other_all').val() != '')? parseFloat($('.other_all').val()) : 0;
//     $('.total_count').val(parseFloat(subtotal+(subtotal*(tax_all/100))+shipping_all+other_all));
// }

$('body').on('blur', '#subtotal,#tax_all, #shipping_all, #other_all, #total_count,#unit_price,#qty,#tax,#total', function() {
  if($(this).val()=="") {
      $(this).val(0);
  }
});
$('body').on('keyup','#tax_all', function(){
  var tax = $(this).val();
  if (tax != 0 || tax != '') {
      $('.tax').attr('readonly','readonly');
  }else{
      $('.tax').removeAttr('readonly');
  }

});
$('body').on('change', '.bill_id', function () {
    var CusNO = $(this).val();
});

$( "#FormCustomerInvoice" ).validate({
  rules: {
    datedoc: "required",
    currency:"required",
    bill_id: "required",
    // ship:    "required",
    subtotal:"required",
  },
  messages: {
    datedoc: "กรุณาระบุวันที่",
    currency:"กรุณาเลือกสกุลเงิน",
    bill_id: "กรุณาเลือกลูกค้า",
    // ship:    "กรุณาเลือกที่อยู่ลูกค้า",
    subtotal:"กรุณาเลือกเงินรวม",
  },
  errorElement: "span",
  errorPlacement: function ( error, element ) {
    // Add the `help-block` class to the error element
    error.addClass( "help-block" );
    if ( element.prop( "type" ) === "checkbox" ) {
      error.insertAfter( element.parent( "label" ) );
    } else {
      error.insertAfter( element );
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents('.form-group').addClass( "has-error" ).removeClass( "has-success" );
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents('.form-group').addClass( "has-success" ).removeClass( "has-error" );
  },
  submitHandler: function(form){
    var btn = $(form).find('[type="submit"]');
    $.ajax({
      method : "POST",
      url : url+"/Market/Invoice/InsertInvoice",
      dataType : 'json',
      data : $(form).serialize()
    }).done(function(rec){
      if(rec.status==1){
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.content,type: "success"
        }).then((rec) => {
          window.location.href = "{{url('Market/ScheduleInvoice')}}";
        });
        form.reset();
      }else{
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.content,type: "error"
        });
      }
    });
  }
});

</script>
@endsection
