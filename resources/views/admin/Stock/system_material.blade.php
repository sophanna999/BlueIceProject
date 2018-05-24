@extends('layouts.admin')

@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
.a4{
  width: 21cm;
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
@endsection

@section('body')
<div class="card card-accent-primary">
  <div class="card-header">
    PURCHASE ORDER
  </div>
  <div class="card-body a4" style="margin: auto;">

    <form id="FormPrimary">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <section class="invoice">
        <!-- title rownopad -->
        <div class="rownopad" style="margin-right: -15px;">
          <div class="col-sm-5 invoice-info">
            <div class="invoice-col">
              <address>
                <div class="row">
                  <select class="form-control" name="branch" id="branch">
                    <option value="">กรุณาเลือก</option>
                    @foreach($branch as $val)
                    <option value="{{$val->BraID}}" data-address="{{($val->BraNum!='')?$val->BraNum:''}}{{($val->BraRoad!='')?' ถนน '.$val->BraRoad:''}}<br>
                      {{($val->BraTambon!='')?' ตำบล '.$val->district_name:''}}{{($val->BraCity!='')?' อำเภอ '.$val->amphur_name:''}}<br>
                      {{($val->BraState!='')?' จังหวัด '.$val->province_name:''}}{{($val->BraCountry!='')?' ประเทศ'.$val->name_th:''}}{{($val->BraZipcode!='')?'<br>รหัสไปรษณีย์ '.$val->BraZipcode:''}}<br>
                      {{($val->BraPhone!="")?' เบอร์โทร '.$val->BraPhone:($val->BraMobile!="")?' เบอร์โทร '.$val->BraMobile:''}}<br>
                      {{($val->BraFax!="")?' แฟ็กซ์ '.$val->BraFax:''}}">
                      {{$val->BraName}}
                    </option>
                    @endforeach
                  </select>
                </div>
                <div class="row" id="address-default">

                </div>
              </address>
            </div>
            <!-- /.col -->
          </div>
          <div class="col"></div>
          <div class="col-sm-6">
            <h2 class="page-header">
              <div class="form-group" style="margin-bottom: 10px;">
                <div class="input-group date">
                  <span class="input-group-addon">Date: </span>
                  <input type="text" id="datedoc" name="datedoc" class="datecalendar form-control"/>
                  <span class="input-group-addon btn-primary"><i class="fa fa-calendar"></i></span>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">{{$ref_format}}# </span>
                  <input type="text" class="form-control" name="po_ref" value="{{$po_ref}}" readonly/>
                </div>
              </div>
            </h2>
          </div>
        </div>
        <!-- info rownopad -->

        <!-- /.rownopad -->
        <!-- Table rownopad -->
        <div class="rownopad">
          <div class="card card-accent-primary col-sm-5">
            <div class="card-header">
              <strong>VENDOR</strong>
            </div>
            <div class="card-body col-sm-12">
              <div class="row">
                <select class="form-control" name="supplier" id="supplier">
                  <option value="">กรุณาเลือก</option>
                  @foreach($supplier as $val)
                  <option value="{{$val->SupID}}" data-address="{{($val->SupNum!='')?$val->SupNum:''}}{{($val->SupRoad!='')?' ถนน '.$val->SupRoad:''}}<br>
                    {{($val->SupTambon!='')?' ตำบล '.$val->district_name:''}}{{($val->SupCity!='')?' อำเภอ '.$val->amphur_name:''}}<br>
                    {{($val->SupState!='')?' จังหวัด '.$val->province_name:''}}{{($val->SupCountry!='')?' ประเทศ'.$val->name_th:''}}{{($val->SupZipcode!='')?'<br>รหัสไปรษณีย์ '.$val->SupZipcode:''}}<br>
                    {{($val->SupPhone!="")?' เบอร์โทร '.$val->SupPhone:($val->SupMobile!="")?' เบอร์โทร '.$val->SupMobile:''}}<br>
                    {{($val->SupFax!="")?' แฟ็กซ์ '.$val->SupFax:''}}">
                    {{$val->SupName}}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="supplier" id="vendor">

              </div>
            </div>
          </div>
          <!-- /.card -->
          <div class="col-sm-2"></div>
          <div class="card card-accent-primary col-sm-5">
            <div class="card-header">
              <strong>SHIP TO</strong>
            </div>
            <div class="card-body col-sm-12">
              <div class="row">
                <select class="form-control" name="ship" id="ship">
                  <option value="">กรุณาเลือก</option>
                  @foreach($branch as $val)
                  <option value="{{$val->BraID}}" data-address="{{($val->BraNum!='')?$val->BraNum:''}}{{($val->BraRoad!='')?' ถนน '.$val->BraRoad:''}}<br>
                    {{($val->BraTambon!='')?' ตำบล '.$val->district_name:''}}{{($val->BraCity!='')?' อำเภอ '.$val->amphur_name:''}}<br>
                    {{($val->BraState!='')?' จังหวัด '.$val->province_name:''}}{{($val->BraCountry!='')?' ประเทศ'.$val->name_th:''}}{{($val->BraZipcode!='')?'<br>รหัสไปรษณีย์ '.$val->BraZipcode:''}}<br>
                    {{($val->BraPhone!="")?' เบอร์โทร '.$val->BraPhone:($val->BraMobile!="")?' เบอร์โทร '.$val->BraMobile:''}}<br>
                    {{($val->BraFax!="")?' แฟ็กซ์ '.$val->BraFax:''}}">
                    {{$val->BraName}}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="row" id="ship_to">

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
                <th style="width: 20%">REQUISITIONER</th>
                <th style="width: 20%">SHIP VIA</th>
                <th style="width: 20%">F.O.B.</th>
                <th>SHIPPING TERMS</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>.</td>
                <td>.</td>
                <td>.</td>
                <td>.</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.rownopad -->
        <div class="row">
          <div class="col-md-4">
            <select id='currency' name='currency' class="form-control">
              <option value="">กรุณาเลือกสกุลเงิน</option>
              @foreach($currency as $val)
              <option value="{{$val->id}}">{{$val->currency_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col"></div>
          <div class="col-md-2">
            <a type="button" class="addMaterial btn btn-primary" style="color:#fff">เพิ่มวัสดุสั่งซื้อ</a>
          </div>
        </div><br>
        <div class="rownopad">
          <table class="table table-bordered table-striped table-sm datatable">
            <thead>
              <tr>
                <th style="width: 10%; text-align: center; vertical-align: middle;">ITEM#</th>
                <th style="text-align: center; vertical-align: middle;">DESCRIPTION</th>
                <th style="width: 10%; text-align: center; vertical-align: middle;">QTY</th>
                <th style="width: 10%; text-align: center; vertical-align: middle;">UNIT PRICE</th>
                <th style="width: 10%; text-align: center; vertical-align: middle;">TAX</th>
                <th style="width: 15%; text-align: center; vertical-align: middle;">TOTAL</th>
                <th style="width: 15%; text-align: center; vertical-align: middle;">ACTION</th>
              </tr>
            </thead>
            <tbody class="material">
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
              <textarea name="comment" class="form-control" rows="10"></textarea>
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
                    <input style="text-align: right;" value=0 type="text"  type="text" id="total" name="total" class="form-control" readonly="" value="">
                  </div>
                </div>
                <div class="form-group rownopad">
                  <div class="col-md-4">
                    <label class="form-control-label" for="hf-text">TAX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  </div>
                  <div class="col-md-8">
                    <input style="text-align: right;" value=0 type="text" id="tax_all" name="tax_all" class="form-control" value="">
                  </div>
                </div>
                <div class="form-group rownopad">
                  <div class="col-md-4">
                    <label class="form-control-label" for="hf-text">SHIPPING</label>
                  </div>
                  <div class="col-md-8">
                    <input style="text-align: right;" value=0 type="text" onfocus="if(this.value==0){this.value=''}" type="text" id="shipping" name="shipping" class="form-control" value="">
                  </div>
                </div>
                <div class="form-group rownopad">
                  <div class="col-md-4">
                    <label class="form-control-label" for="hf-text">OTHER</label>
                  </div>
                  <div class="col-md-8">
                    <input style="text-align: right;" value=0 type="text" onfocus="if(this.value==0){this.value=''}" type="text" id="other" name="other" class="form-control" value="">
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
                  <input style="text-align: right;" value=0 type="text" id="total_count" name="total_count" class="form-control" readonly="" value="">
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- this rownopad will not appear when printing -->
        <div class="rownopad no-print ">
          <div class="col-xs-12" style="margin: auto;">
            <a href="#" class="btn btn-success save"><i class="fa fa-check-square" aria-hidden="true" style="margin-top: 1px; "></i>  บันทึก</a>
            <a href="#" class="btn btn-danger cancel"><i class="fa fa-times-rectangle" aria-hidden="true" style="margin-top: 1px;"></i> ยกเลิก</a>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

$('body').on('input','input[name*="MatDescription"]',function() {
  var data = $(this);
  var name = $(this).val();
  $.ajax({
    method: "GET",
    url: url+"/Stock/SystemMaterial/getDescription/"+name,
    dataType: "json"
  }).done(function(rec){
    data.autocomplete({
      source: rec
    });
  });
});

var tax = "";
var index = 1;
var r = 1;
$('body').on('change', '#branch', function () {
  if ($(this).val() == "") {
    $('#address-default').html("");
  } else {
    $('#address-default').html($(this).find('option[value="' + $(this).val() + '"]').data('address'));
    if ($('#ship').val() == "") {
      $('#ship_to').html($(this).find('option[value="' + $(this).val() + '"]').data('address'));
      $('#ship').val($(this).val());
    }
  }
});

$('body').on('change', '#ship', function () {
  if ($(this).val() == "") {
    $('#ship_to').html('');
  } else {
    $('#ship_to').html($(this).find('option[value="' + $(this).val() + '"]').data('address'));
  }
});

$('body').on('change', '#supplier', function () {
  if ($(this).val() == "") {
    $('#vendor').html('');
  } else {
    $('#vendor').html($(this).find('option[value="' + $(this).val() + '"]').data('address'));
  }
});

function countPrice() {
  if(index==1) {
    $('#total_count').val(0);
    $('#total').val(0);
  }
  if(!$.isNumeric($('#shipping').val())) {
    $('#shipping').val(0);
  }
  if(!$.isNumeric($('#other').val())) {
    $('#other').val(0);
  }
  var shipping = ($('#shipping').val()!='') ? parseFloat($('#shipping').val()) : 0;
  var other = ($('#other').val()!='') ? parseFloat($('#other').val()) : 0;
  if($('#total').val()!="" && $('#tax_all').val()!="") {
    var total_count = parseFloat($('#total').val())+(parseFloat($('#total').val())*(parseFloat($('#tax_all').val())/100));
    $('#total_count').val(total_count+other+shipping);
  } else {
    $('#total_count').val($('#total').val()+other+shipping);
  }
}

$('.addMaterial').click(function() {
  if(index==1) {
    $('#total_count').val(0);
    $('#total').val(0);
  }
  var read = ($('#tax_all').val()!=0 && $('#tax_all').val()!='') ? 'readonly' : '';
  $('.material').append('<tr class="index index-'+index+'">\n\
  <td style="text-align: center; vertical-align: middle;">'+index+'</td>\n\
  <td style="text-align: center; vertical-align: middle;">\n\
  <input type="text" name="MatDescription['+index+']" class="mat_description-'+index+' form-control" placeholder="Description">\n\
  </td>\n\
  <td style="text-align: center; vertical-align: middle;"><input type="text" name="Qty['+index+']" value=0  class="qty-'+index+' form-control" placeholder="Qty"></td>\n\
  <td style="text-align: center; vertical-align: middle;"><input type="text" name="Unit_price['+index+']" value=0  class="unit_price-'+index+' form-control" placeholder="Unit Price"></td></td>\n\
  <td style="text-align: center; vertical-align: middle;"><input type="text" name="tax['+index+']" class="input-tax tax-'+index+' form-control" value=0  value="0" placeholder="Tax" '+read+'></td>\n\
  <td style="text-align: center; vertical-align: middle;"><input  class="form-control total-'+index+'" name="total_price['+index+']" value="0" value="" readonly></td>\n\
  <td style="text-align: center; vertical-align: middle;"><center><button type="button" data-input="'+index+'" class="delete-row btn btn-danger">ลบ</button></center></td>\n\
  </tr>');
  $('.mat_description-'+index+'[name="MatDescription['+index+']"]').rules("add", {
    required:true,
    messages: {
      required: "กรุณาระบุ",
    }
  });
  $('.unit_price-'+index+'[name="Unit_price['+index+']"]').rules("add", {
    required:true,
    number: true,
    messages: {
      required: "กรุณาระบุ",
      number: "ตัวเลขเท่านั้น"
    }
  });
  $('.qty-'+index+'[name="Qty['+index+']"]').rules("add", {
    required:true,
    number: true,
    messages: {
      required: "กรุณาระบุ",
      number: "ตัวเลขเท่านั้น"
    }
  });
  $('.tax-'+index+'[name="tax['+index+']"]').rules("add", {
    required:true,
    number: true,
    messages: {
      required: "กรุณาระบุ",
      number: "ตัวเลขเท่านั้น"
    }
  });
  $('.total_price-'+index+'[name="total_price['+index+']"]').rules("add", {
    required:true,
    number: true,
    messages: {
      required: "กรุณาระบุ",
      number: "ตัวเลขเท่านั้น"
    }
  });
  index++;
  countPrice();
});

$('body').on('click', '.delete-row', function() {
  var data = $(this).data('input');
  r = 1;
  $('body').find('tr.index').each (function() {
    var i =  $('tr.index-'+r+' td:first').text();
    if(i>data && i!=1) {
      // Change Index of Table Row
      $('tr.index-'+r+' td:first').text(i-1);
      // ./ Change Index of Table Row

      // Add New Class index-1
      $('tr.index-'+r).addClass('index-'+(i-1));
      $('.mat_description-'+r).addClass('mat_description-'+(i-1));
      $('.qty-'+r).addClass('qty-'+(i-1));
      $('.unit_price-'+r).addClass('unit_price-'+(i-1));
      $('.tax-'+r).addClass('tax-'+(i-1));
      $('.total-'+r).addClass('total-'+(i-1));
      // ./ Add New Class index-1

      // Remove Default Name
      $('.mat_description-'+r).removeAttr('name');
      $('.qty-'+r).removeAttr('name');
      $('.unit_price-'+r).removeAttr('name');
      $('.tax-'+r).removeAttr('name');
      $('.total-'+r).removeAttr('name');
      // ./ Remove Default Name

      // Add New Name for Form Valadete
      $('.mat_description-'+r).attr('name', 'MatDescription['+(i-1)+']');
      $('.qty-'+r).attr('name', 'Qty['+(i-1)+']');
      $('.unit_price-'+r).attr('name', 'Unit_price['+(i-1)+']');
      $('.tax-'+r).attr('name', 'tax['+(i-1)+']');
      $('.total-'+r).attr('name', 'total_price['+(i-1)+']');
      // ./ Add New Name for Form validate

      // Remove Default Class
      $('.mat_description-'+r).removeClass('mat_description-'+i);
      $('.qty-'+r).removeClass('qty-'+i);
      $('.unit_price-'+r).removeClass('unit_price-'+i);
      $('.tax-'+r).removeClass('tax-'+i);
      $('.total-'+r).removeClass('total-'+i);
      // ./ Remove Defaulr Class

      // Change And Remove Class for Table Row
      $('tr.index-'+r).children('td:last').children('center').children('button').attr('data-input', i-1);
      $('tr.index-'+r).removeClass('index-'+r);
      // ./ Change And Remove Class for Table Row
    }
    r++;
  });
  $(this).parent().parent().parent().remove();

  // Remove Last Rules
  $('.mat_description-'+(index-1)+'[name="MatDescription['+(index-1)+']"]').rules("remove");
  $('.unit_price-'+(index-1)+'[name="Unit_price['+(index-1)+']"]').rules("remove");
  $('.qty-'+(index-1)+'[name="Qty['+(index-1)+']"]').rules("remove");
  $('.tax-'+(index-1)+'[name="tax['+(index-1)+']"]').rules("remove");
  $('.total_price-'+(index-1)+'[name="total_price['+(index-1)+']"]').rules("remove");
  // ./ Remove Last Rules
  // $("#FormPrimary").submit();
  index--;
  var total = 0;
  for(i=1;i<index;i++) {
    if($('.unit_price-'+i).val()!=='') {
      total += parseFloat($('.total-'+i).val());
    }
    $('#total').val(total);
  }
  countPrice();
});

$('.datecalendar').daterangepicker({
  singleDatePicker: true,
  locale: {
    format: 'YYYY-MM-DD'
  }
});

$("body").on('click', '.save', function () {
  var id = $(this).data('id');
  //        alert(id);
  $("#FormPrimary").submit();
});

$('body').on('input', 'input[name*="Unit_price"], input[name*="Qty"], input[name*="tax"], #tax_all', function() {
  var check = 0;
  $('body').find('td > input[name*="tax"]').each (function() {
    if($(this).val()!=0 && $(this).val()!='') {
      check = 1;
      $('#tax').val(0);
      return false;
    }
  });
  if(check==1) {
    $('#tax_all').prop('readonly', true);
  } else {
    if($('#tax_all').val()==0) {
      $('#tax_all').prop('readonly', false);
    }
  }
  id = $(this).parent().parent().children('td:first').text();
  if($('input[name*="Unit_price"]').val()!='' && $('input[name*="Qty"]').val()) {
    if($('.tax-'+id).val()!='' && $('.tax-'+id).val()!=0) {
      var price = $('.unit_price-'+id).val()*$('.qty-'+id).val();
      $('.total-'+id).val(price+(price*($('.tax-'+id).val()/100)));
    } else {
      $('.total-'+id).val($('.unit_price-'+id).val()*$('.qty-'+id).val());
    }
    var total = 0;
    for(i=1;i<index;i++) {
      if($('.unit_price-'+i).val()!=='') {
        total += parseFloat($('.total-'+i).val());
      }
      $('#total').val(total);
    }
  }
});

$('body').on('input', '#tax_all', function() {
    tax = $('#tax_all').val();
    if(tax==0 || tax=='' && $(this).attr('readonly')=='') {
        for(var i=0;i<index;i++) {
            $('.tax-'+i).prop('readonly', false);
            $('.tax-'+i).val(0);
            $('#tax_all').val(0);
        }
    } else {
        for(var i=0;i<index;i++) {
            $('.tax-'+i).val(0);
            $('.tax-'+i).prop('readonly', true);
            var price = $('.unit_price-'+i).val()*$('.qty-'+i).val();
            $('.total-'+i).val(price+(price*($('.tax-'+i).val()/100)));
        }
    }

});

$('body').on('keyup', 'input', function() {
  countPrice();
});

$( "#FormPrimary" ).validate({
  rules: {
    branch: "required",
    ship: "required",
    supplier: "required",
    currency: "required",
    total: "required",
    tax_all: "required",
    tax_all: "number",
    shipping: "number",
    other: "number",
  },
  messages: {
    branch: "กรุณาเลือก",
    ship: "กรุณาเลือก",
    supplier: "กรุณาเลือก",
    currency: "กรุณาเลือก",
    total: "กรุณากรอกข้อมูลให้ครบถ้วน",
    tax_all: "กรุณาระบุ",
    tax_all: "ตัวเลขเท่านั้น",
    shipping: "ตัวเลขเท่านั้น",
    other: "ตัวเลขเท่านั้น",
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
      url : url+"/Stock/SystemMaterial/store",
      dataType : 'json',
      data : $(form).serialize()+ "&index="+index
    }).done(function(rec){
      if(rec.type == 'success'){
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        }).then((rec) => {
          window.location.href = "{{url('Stock/SystemMaterial')}}";
        });
        $('#primaryModal').modal('hide');
        form.reset();
      }else{
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        });
      }
    });
  }
});

$(".cancel").click(function() {
  swal({
    title: 'คุณต้องการยกเลิกและลบข้อมูลหรือไม่ ?',
    text: "หากต้องการยกเลิกและลบ กดปุ่ม 'ยืนยัน'",
    type: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ยืนยัน',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if(result.value){
      window.location.href = "{{url('Stock/SystemMaterial')}}";
    }
  });
});

$('body').on('focus', 'input[name*="Unit_price"], input[name*="Qty"], input[name*="tax"], #input[name="tax_all"], #shipping, #other', function() {
    if($(this).attr('readonly')!="") {
        if($(this).val()==0) {
            $(this).val("");
        }
    }
});
$('body').on('blur', 'input[name*="Unit_price"], input[name*="Qty"], input[name*="tax"], #tax_all, #shipping, #other', function() {
    if($(this).attr('readonly')!="") {
      if($(this).val()=="") {
          $(this).parent().find('.error').remove();
          $(this).val(0);
      }
  }
});
// alert("\n\
// laravel มีเมนูไรบ้าง\n\
// bootstrap 4 มีเมนูไรบ้าง\n\
// lightblue มีเมนูไรบ้าง\n\
// ");
</script>
@endsection
