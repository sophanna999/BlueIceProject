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
        การออก INVOICE
    </div>
    <div class="card-body a4" style="margin: auto;">
      <form id="UpdateCustomerInvoice">
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
                  <input type="text" id="datedoc" name="" class="datecalendar form-control" value="{{$invoice_data->InvDate}}" disabled readonly='true' />
                  <input type="hidden" id="datedoc" name="datedoc" class="form-control" value="{{$invoice_data->InvDate}}" />
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
                  <input type="text" class="form-control invice_id" data-id="{{base64_encode($invoice_data->CusInv)}}" name="invoice_id" value="{{$invoice_data->CusInv}}" readonly/>
                </div>
              </div>
              <div class="form-group" style="margin-top: 5px;">
                <div class="input-group">
                  <span class="input-group-addon">Customer ID#</span>
                  <input type="text" class="form-control customer_id" name="customer_id" id="customer_id" value="{{$invoice_data->CusNO}}" readonly/>
                </div>
              </div>
              <div class="form-group" style="margin-top: 5px;">
              <select class="form-control currency" name="currency" id="currency">
                    <option value="" disabled>กรุณาเลือกสกุลเงิน</option>
                    @foreach($currency as $currencys)
                        <option value="{{$currencys->id}}" {{($invoice_data->CurrencyID == $currencys->id)?'selected':'disabled'}}>{{$currencys->currency_name}}</option>
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
                    <option value="" disabled>กรุณาเลือกลูกค้า</option>
                    @foreach($customer_payment as $customer_payments)
                        <option value="{{$customer_payments->CusNO}}" {{($invoice_data->CusNO == $customer_payments->CusNO)?'selected':'disabled'}}>{{$customer_payments->CusName}}</option>
                    @endforeach
                </select>
              </div>
              <div class="supplier_address">
                {{($bill_address[0]->CusNum!='')? $bill_address[0]->CusNum:''}}
                {{($bill_address[0]->CusRoad!='')?'ถนน'.$bill_address[0]->CusRoad:''}}<br>
                {{($bill_address[0]->CusTambon!='')?'ตำบล '.$bill_address[0]->district_name:''}}
                {{($bill_address[0]->CusCity!='')?'อำเภอ '.$bill_address[0]->amphur_name:''}}<br>
                {{($bill_address[0]->CusState!='')?'จังหวัด '.$bill_address[0]->province_name:''}}
                {{($bill_address[0]->CusCountry!='')?'ประเทศ '.$bill_address[0]->name_th:''}}<br>
                {{($bill_address[0]->CusZipcode!='')?'รหัสไปรษณีย์ '.$bill_address[0]->CusZipcode:''}}<br>
                {{($bill_address[0]->CusPhone!='')?'เบอร์โทร '.$bill_address[0]->CusPhone:($bill_address[0]->CusMobile!='')?'เบอร์โทร'.$bill_address[0]->CusMobile:''}}<br>
                {{($bill_address[0]->CusFax!='')?'แฟ็กซ์ '.$bill_address[0]->CusFax:''}}

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
                  <option value="" disabled>กรุณาเลือกที่อยู่ส่ง</option>
                  @foreach($delivery_address as $deliverys)
                    <option value="{{$deliverys->AodID}}" data-id='{{$deliverys->CusID}}' {{($invoice_data->InvAdd2 == $deliverys->AodID)?"selected":""}}>{{$deliverys->CusName}}</option>
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
                      @foreach($payment as $key => $value)
                        <tr>
                           <td style="text-align: center;">{{$no++}}</td>
                           <td style="text-align: center;">{{$value->ProName}}</td>
                           <td style="text-align: center;"><input type="text" class="form-control qty" name="qty[{{$key}}]" id="qty" value="{{$value->ProSales}}" readonly></td>
                           <td style="text-align: center;"><input type="text" class="form-control unit_price" name="unit_price[{{$key}}]" id="unit_price" value="{{$value->UnitPrice}}"></td>
                           <td style="text-align: center;"><input type="text" class="form-control total" name="total[{{$key}}]" id="total" value="{{$value->ProSales*$value->UnitPrice}}" readonly></td>
                           <td style="text-align: center;"><input type="checkbox" class="confirm_price" name="PayID[{{$key}}]" value="{{$value->PayID}}" checked></td>
                        </tr>
                      @endforeach()

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
                        <textarea class="form-control" rows="10" name="detail" id="detail">{{$invoice_data->detail}}</textarea>
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
                          <input style="text-align: right;" value="{{$invoice_data->SubToTal}}" type="text" id="subtotal" name="subtotal" class="input-group-addon subtotal" readonly="" onfocus="if(this.value==0){this.value=''}"/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group rownopad">
                      <div class="col-md-4">
                        <label class="form-control-label" for="hf-text">TAX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                      </div>
                      <div class="col-md-8">
                        <div class="input-group">
                          <input style="text-align: right;" value="{{($invoice_data->InvTax/$invoice_data->SubToTal)*100}}" type="text" id="tax_all" name="tax_all" class="form-control tax_all" onfocus="if(this.value==0){this.value=''}"/>
                          <input style="text-align: right;" type="hidden" id="res_tax_all" name="res_tax_all" class="form-control res_tax_all" value="{{$invoice_data->InvTax}}"/>
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
                          <input style="text-align: right;" type="text" id="other_all" name="other_all" class="form-control other_all" value="{{($invoice_data->Other/$invoice_data->SubToTal)*100}}" onfocus="if(this.value==0){this.value=''}"/>
                          <input style="text-align: right;" type="hidden" id="res_other_all" name="res_other_all" class="form-control res_other_all" value="{{$invoice_data->Other}}"/>
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
                        <input style="text-align: right;" value="{{$invoice_data->SubToTal + $invoice_data->InvTax - $invoice_data->Other}}" id="total_count" name="total_count" class="input-group-addon total_count" readonly="" onfocus="if(this.value==0){this.value=''}"/>
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
                    <button type="submit" class="btn btn-primary save" ><i class="fa fa-check-square" aria-hidden="true" style="margin-top: 1px; "></i> อัปเดด</button>
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
  $('.ship').select2();
});
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

$(function() {
  var ship = $('.ship').val();
  $.ajax({
    method: "GET",
    url: url + "/Market/ScheduleInvoice/GetCusDelivery/"+ship,
    dataType:'html'
  }).done(function (rec) {
    $('.ship_to').append(rec);
  });

});
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
// $( document ).ready(function() {
//     ShipAddress();
// });
$('body').on('change','.bill_id', function(){
    ShipAddress();
    // GetProduct();
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
  });
function ShipAddress() {
    $.each($('.ship').find('option'),function() {
        if($(this)[0]['dataset']['id'] == $('.bill_id').val() || $(this)[0]['value']=="") {
            // $(this).show();
        } else {
            // $(this).hide();
        }
    });
}
var i = 0;

$('body').on('keyup','#unit_price', function(){
  var qty        = $(this).closest('tr').find('.qty').val();
  var unit_price = $(this).val();
  $(this).closest('tr').find('.unit_price').removeAttr('value');
  $(this).closest('tr').find('.unit_price').attr('value',unit_price);
  $(this).closest('tr').find('.total').removeAttr('value');
  $(this).closest('tr').find('.total').attr('value',qty*unit_price);
  CalculatePrice();

});
$('body').on('click','.confirm_price',function(){
      CalculatePrice();
});
$('body').on('input','.tax_all,.shipping_all,.other_all', function(){
    CalculatePrice();
  });
$('body').on('keyup','.tax_all,.other_all', function(){

  var subtotal = $('.subtotal').val();
  var tax      = $('.tax_all').val();
  var other    = $('.other_all').val();
  $(this).find('.res_tax_all').removeAttr('value');
  $(this).find('.res_tax_all').attr('value',subtotal*(tax/100));
  $(this).find('.res_other_all').removeAttr('value');
  $(this).find('.res_other_all').attr('value',subtotal*(other/100));

});

function CalculatePrice() {
    var subtotal = 0;
    $.each($('.total'), function(){
      if ($(this).closest('tr').find('input:checkbox').is(':checked')) {
        subtotal += parseFloat($(this).val());
      }
    });

    $('.subtotal').val(subtotal);

    if(!$.isNumeric($('.shipping_all').val())) {
    $('.shipping_all').val(0);
    }
    if(!$.isNumeric($('.other_all').val())) {
      $('.other_all').val(0);
    }

    var tax_all      = $('.tax_all').val();
    var other_all    = ($('.other_all').val() != '')? parseFloat($('.other_all').val()) : 0;
    var res_tax_all  = $('.res_tax_all').val(subtotal*(tax_all/100));
    var res_other_all  = $('.res_other_all').val(subtotal*(other_all/100));
    $('.total_count').val(parseFloat(subtotal+(subtotal*(tax_all/100))-(subtotal*(other_all/100))));
}

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

$( "#UpdateCustomerInvoice" ).validate({
  rules: {
    subtotal:"required",
    total_count:"required",
  },
  messages: {
    subtotal:"กรุณาเลือกเงินรวม",
    total_count:"กรุณาเลือกเงินรวม",
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
    var id  = $('.invice_id').data('id');
    // console.log(id);
    $.ajax({
      method : "POST",
      url : url+"/Market/ScheduleInvoice/Update/"+id,
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
