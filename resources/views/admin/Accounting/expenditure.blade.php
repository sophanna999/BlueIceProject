@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link href="{{asset('js/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('body')
<div class="col-lg-12">
  <div class="card">
    <div class="card-header" style="width: 100%">
      <i class="fa fa-align-justify"></i><strong>การจัดการรายจ่ายทั่วไป</strong>
      <div class="row pull-center">
        <div class="col-sm-4" style="width: 100%"></div>
        <form id="SearchDate" method="post" class="form-inline">
          {{csrf_field()}}
          <br>
          <div class="form-group date">
            <label for="SearchDate"></label>
            <input type="text" id="fromDate" name="fromDate" class="form-control datecalendar" placeholder="dd/mm/yyyy">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>
          <div class="form-group date">
            <label for="datedoc">&nbsp; ถึง &nbsp;</label>
            <input type="text" id="toDate" name="toDate" class="form-control datecalendar" placeholder="dd/mm/yyyy">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>
      </div>
        <div class="pull-right" style="margin-top:-35px;margin-right: 114px;">
          <!-- <button type="submit" class="btn btn-primary fa fa-search" style="width:90px; height: 40px">&nbsp; ค้นหา</button> -->
        </div>
      </form>
      <div class="pull-right" style="margin-top:-35px;">
        <button type="button" class="btn btn-primary fa fa-plus AddForm" id="AddForm" data-toggle="modal" data-target="" style="width:90px; height: 40px"> เพิ่ม</button>
      </div>
    </div>
    <div class="card-body" style="width: 100%">
      <div class="table-responsive-">
        <table id="report_rawmaterial" class="table table-bordered table-striped table-sm TableListEmpense">
          <thead class="table-info">
            <tr height="19" style="height:14.25pt">
              <td rowspan="2" height="38" class="xl72" width="72" style="border-bottom:.5pt solid black;height:28.5pt;width:60pt;border-image: initial" align="center"><br><b>วัน/เดือน/ปี</b></td>
              <td colspan="7" class="xl75" width="288" style="border-right:.5pt solid black;border-left:none;width:216pt;border-image: initial" align="center"><b>การจัดการรายจ่ายทั่วไป</b></td>
              <td rowspan="2" class="xl72" width="119" style="border-bottom:.5pt solid black;width:232px" align="center"><br><b>หมายเหตุ</b></td>
              <td rowspan="2" class="xl69" style="vertical-align:middle;border-image: initial" align="center"><b>แก้ไข | ลบ</b></td>
            </tr>
            <tr height="19" style="height:14.25pt">
              <td height="19" class="xl69" style="height:14.25pt;border-image: initial" align="center"><b>รายการ</b></td>
              <td class="xl69" style="border-image: initial" align="center"><b>ชื่อร้านค้า</b></td>
              <td class="xl69" style="border-image: initial" align="center"><b>จำนวน</b></td>
              <td class="xl69" style="border-image: initial" align="center"><b>หน่วย</b></td>
              <td class="xl69" style="border-image: initial" align="center"><b>ราคา(บาท)</b></td>
              <td class="xl69" style="border-image: initial" align="center"><b>ราคา(ริงกิต)</b></td>
              <td class="xl69" style="border-image: initial" align="center"><b>เลขที่ / เล่มที่ใบเสร็จ</b></td>
            </tr>
          </thead>
          <tfoot class="">
              <tr style="background-color:#d3eef6;">
                  <th>รวม</th>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
              </tr>
            </tfoot>
          <tbody id="TableListEmpense_body">
          </tbody>
        </table>
      </div>  <!-- Responsive content-->
    </div>  <!-- Card body-->
  </div>
</div>
<!-- Modal -->
<div id="AddModal" class="modal fade" role="dialog">
  <form id="FormInsert">
    <div class="modal-dialog modal-info">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">การจัดการรายจ่ายทั่วไป</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="date">วันที่</label>
              <div class="input-group date datecalendar">
                <input type="text" id="ExpDate" name="ExpDate" class="form-control ExpDate" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                 <button type="button" class="btn btn-primary ">
                  <i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
            <div class="form-group col-sm-6">
             <label for="product">รายการ</label>
             <select class="form-control" id="account_type" name="account_type">
              <option value="">เลือกประเภทบัญชี</option>
              @foreach($accout_type as $types)
              <option value="{{$types->ChaID}}">{{$types->ChaGroup}}</option>
              @endforeach()
            </select>
          </div>
          <div class="form-group col-sm-6">
            <label for="store">ชื่อร้านค้า</label>
            <input type="text" class="form-control" name="store" id="store" placeholder="ชื่อร้านค้า">
          </div>
            <div class="form-group col-sm-6">
              <label for="price">จำนวน</label>
              <div class="input-group">
                <input type="number" class="form-control" name="ExpAmount" id="ExpAmount" min="0" placeholder="0">
                <input type="text" class="form-control" name="AccNO" id="AccNO" placeholder="หน่วยการจ่าย">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <label for="price">ราคารวม</label>
              <div class="input-group">
                <input type="number" id="ExpPrice" name="ExpPrice" class="form-control" placeholder="0" min=0>
                <select class="form-control form-info" id="currency" name="currency">
                  <option value="">สกุลเงิน</option>
                  @foreach($currency as $currencys)
                  <option value="{{$currencys->id}}">{{$currencys->currency_name}}</option>
                  @endforeach()
                </select>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <label for="ReceiptNo">เลขที่ / ใบเสร็จ</label>
              <input type="text" class="form-control" name="ReceiptNo" id="ReceiptNo" placeholder="06022018/001">
            </div>
            <div class="form-group col-sm-12">
              <label for="Remark">หมายเหตุ</label>
              <textarea class="form-control" id="Remark" name="Remark" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" style="width:60px; height: 40px">บันทึก</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
          </div>
        </div> <!-- /.modal-body -->
        <!-- /.modal-content -->
      </div>
    </div>
  </form>
</div>

<!-- Modal -->
<div id="EditModal" class="modal fade" role="dialog">
  <form id="EditForm">
    {{ csrf_field() }}
    <input type="text" id="ExpID" value="">
    <div class="modal-dialog modal-info">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">การจัดการรายจ่ายทั่วไป</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="date">วันที่</label>
              <div class="input-group date datecalendar">
                <input type="text" id="EditExpDate" name="EditExpDate" class="form-control EditExpDate" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                 <button type="button" class="btn btn-primary ">
                  <i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
            <div class="form-group col-sm-6">
             <label for="product">รายการ</label>
             <select class="form-control" id="edit_account_type" name="edit_account_type">
              <option value="">เลือกประเภทปัญชี</option>
              @foreach($accout_type as $types)
              <option value="{{$types->ChaID}}">{{$types->ChaGroup}}</option>
              @endforeach()
            </select>
          </div>
          <div class="form-group col-sm-6">
            <label for="store">ชื่อร้านค้า</label>
            <input type="text" class="form-control" name="EditStore" id="EditStore" placeholder="ชื่อร้านค้า">
          </div>
          <!-- <div class="form-group col-sm-6">
            <label for="ExpAmount">จำนวน</label>
            <input type="number" class="form-control" name="EditExpAmount" id="EditExpAmount" min="0" placeholder="0">
          </div> -->
          <div class="form-group col-sm-6">
              <label for="price">จำนวน</label>
              <div class="input-group">
                <input type="number" class="form-control" name="EditExpAmount" id="EditExpAmount" min="0" placeholder="0">
                <input type="text" class="form-control" name="EditAccNO" id="EditAccNO" placeholder="หน่วยการจ่าย">
              </div>
            </div>
          <div class="form-group col-sm-6">
            <label for="price">ราคารวม</label>
            <div class="input-group">
              <input type="number" id="EditExpPrice" name="EditExpPrice" class="form-control" placeholder="0" min=0>
              <select class="form-control form-info" id="Editcurrency" name="Editcurrency">
                <option value="">สกุลเงิน</option>
                @foreach($currency as $currencys)
                <option value="{{$currencys->id}}">{{$currencys->currency_name}}</option>
                @endforeach()
              </select>
            </div>
          </div>
          <div class="form-group col-sm-6">
            <label for="ReceiptNo">เลขที่ / ใบเสร็จ</label>
            <input type="text" class="form-control" name="EditReceiptNo" id="EditReceiptNo" placeholder="06022018/001">
          </div>
          <div class="form-group col-sm-12">
            <label for="Remark">หมายเหตุ</label>
            <textarea class="form-control" id="EditRemark" name="EditRemark" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" style="width:60px; height: 40px">อัพเดท</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
        </div>
      </div> <!-- /.modal-body -->
      <!-- /.modal-content -->
    </div>
  </div>
</form>
</div>

@endsection

@section('jsbottom')
<!-- DataTables -->
<script src="{{asset('js/daterangepicker/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript">

  $('.datecalendar').daterangepicker({
    singleDatePicker: true,
    locale: {
      format: 'YYYY-MM-DD'
    }
  });


  var TableListEmpense = $('.TableListEmpense').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url + "/Accounting/Expenditure/listExpense",
      "data": function (d) {
        d.fromDate = $('#fromDate').val();
        d.toDate   = $('#toDate').val();
      }
    },
    "scrollY":  450,
    "columns": [
    {"data": "ExpDate","name": "ExpDate", "className": "text-center"},
    {"data": "ChaGroup", "name": "ChaGroup", "className": "text-center"},
    {"data": "ShopName", "name": "ShopName", "className": "text-center"},
    {"data": "ExpAmount", "name": "ExpAmount", "className": "text-right"},
    {"data": "ExpUnit", "name": "ExpUnit", "className": "text-right"},
    {"data": "ExpPrice_TH", "name": "ExpPrice_TH", "className": "text-right"},
    {"data": "ExpPrice_RM", "name": "ExpPrice_RM", "className": "text-right"},
    {"data": "ReceiptNo", "name": "ReceiptNo", "className": "text-right"},
    {"data": "Remark", "name": "Remark", "className": "text-center"},
    {"data": "action", "name": "action", "className": "text-center", "orderable": false, "searchable": false},
    ],
    "language": {
      "paginate": {
        "previous": "ก่อน",
        "next": "ต่อไป"
      },
      "lengthMenu": "แสดง _MENU_ รายการ ต่อ หน้า",
      "search": "ค้นหา",
      "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
      "info": "แสดง หน้า _PAGE_ จาก _PAGES_",
      "infoEmpty": "ไม่มีข้อมูลบันทึก",
      "infoFiltered": "(ค้นหา จากทั้งหมด _MAX_ รายการ)",
    },
    responsive: true,
    "drawCallback": function (settings) {
    },
    "footerCallback": function (row, data, start, end, display) {
        var api = this.api(), data;
        var intVal = function (i) {
            return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
        };

        // Total over this page
        pageTotal5 = api.column(5, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal6 = api.column(6, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        // Update footer
        var numFormat_th = $.fn.dataTable.render.number( '\,', '.', 2, '฿' ).display;
        var numFormat_rm = $.fn.dataTable.render.number( '\,', '.', 2, 'RM' ).display;
        $( api.column( 5 ).footer() ).html(
          numFormat_th(pageTotal5)
        );
        $( api.column( 6 ).footer() ).html(
          numFormat_rm(pageTotal6)
        );
    }
  });

  $('.ExpDate').daterangepicker({
    timePicker: true,
    singleDatePicker: true,
    locale: {
      format: 'YYYY-MM-DD'
    }
  });
  $('body').on('click','#AddForm', function(){
    $("#AddModal").modal('show');
  });

  $("#FormInsert").validate({
    rules: {
      ExpDate: "required",
      account_type: "required",
      store: "required",
      ExpAmount: "required",
      ExpPrice: "required",
      currency: "required",
      ReceiptNo: "required",
    },
    messages: {
      ExpDate: "กรุณาระบุ",
      account_type: "กรุณาระบุ",
      store: "กรุณาระบุ",
      ExpAmount: "กรุณาระบุ",
      ExpPrice: "กรุณาระบุ",
      currency: "กรุณาระบุ",
      ReceiptNo: "กรุณาระบุ",
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
        // Add the `help-block` class to the error element
        error.addClass("help-block");
        if (element.prop("type") === "checkbox") {
          error.insertAfter(element.parent("label"));
        } else {
          error.insertAfter(element);
        }
      },
      highlight: function (element, errorClass, validClass) {
        $(element).parents('.form-group').addClass("has-error").removeClass("has-success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parents('.form-group').addClass("has-success").removeClass("has-error");
      },
      submitHandler: function (form) {
        var btn = $(form).find('[type="submit"]');
        $.ajax({
          method: "POST",
          url: url + "/Accounting/Expenditure/Store",
          dataType: 'json',
          data: $(form).serialize()
        }).done(function (rec) {
          if(rec.type=='success'){
            swal({
              confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: "success"
            }).then((rec) => {
              window.location.href = "{{url('Accounting/Expenditure')}}";
            });
            form.reset();
          }else{
            swal({
              confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: "error"
            });
          }
        });
      }
    });
  $('body').on('click','.btn-edit', function(){
    var id = $(this).data(id)['id'];
    $.ajax({
      method : "GET",
      url : url+"/Accounting/Expenditure/edit/"+id,
      dataType: "json"
    }).done(function(rec){
      $('#ExpID').val(rec.ExpID);
      $('#EditExpDate').val(rec.ExpDate);
      $('#EditStore').val(rec.ShopName);
      $('#edit_account_type').val(rec.ChaID);
      $('#Editcurrency').val(rec.CurrencyID);
      $('#EditExpPrice').val(rec.ExpPrice);
      $('#EditExpAmount').val(rec.ExpAmount);
      $('#EditAccNO').val(rec.AccUnit);
      $('#EditReceiptNo').val(rec.ExpPrice);
      $('#EditReceiptNo').val(rec.ReceiptNo);
      $('#EditRemark').val(rec.Remark);
      $("#EditModal").modal('show');
    });
  });
  $("#EditForm").validate({
    rules: {
      EditExpDate: {
        required: true,
      },
      edit_account_type: {
        required: true,
      },
      EditStore: {
        required: true,
      },
      EditExpAmount: {
        required: true,
      },
      EditExpPrice: {
        required: true,
      },
      Editcurrency: {
        required: true,
      },
      EditReceiptNo: {
        required: true,
      }
    },
    messages: {
      EditExpDate: {
        required: 'กรุณาระบุ',
      },
      edit_account_type: {
        required: 'กรุณาระบุ',
      },
      EditStore: {
        required: 'กรุณาระบุ',
      },
      EditExpAmount: {
        required: 'กรุณาระบุ',
      },
      EditExpPrice: {
        required: 'กรุณาระบุ',
      },
      Editcurrency: {
        required: 'กรุณาระบุ',
      },
      EditReceiptNo: {
        required: 'กรุณาระบุ',
      }
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
        // Add the `help-block` class to the error element
        error.addClass("help-block");
        if (element.prop("type") === "checkbox") {
          error.insertAfter(element.parent("label"));
        } else {
          error.insertAfter(element);
        }
      },
      highlight: function (element, errorClass, validClass) {
        $(element).parents('.form-group').addClass("has-error").removeClass("has-success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parents('.form-group').addClass("has-success").removeClass("has-error");
      },
      submitHandler: function (form) {
        var id  = $('#ExpID').val();
        var btn = $(form).find('[type="submit"]');
        $.ajax({
          method: "POST",
          url: url + "/Accounting/Expenditure/Update/"+id,
          dataType: 'json',
          data : $(form).serialize()
        }).done(function (rec) {
          if(rec.type=='success'){
            swal({
              confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: "success"
            }).then((rec) => {
              window.location.href = "{{url('Accounting/Expenditure')}}";
            });
            form.reset();
          }else{
            swal({
              confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: "error"
            });
          }
        });
      }
    });
  // $('body').on('submit','#SearchDate', function(e){
  //     e.preventDefault();
  //     var fromDate = $('#fromDate').val();
  //     var toDate   = $('#toDate').val();
  //     $.ajax({
  //       method: "POST",
  //       url: url + "/Accounting/Expenditure/GetDate",
  //       dataType: "json",
  //       data: $(this).serialize()
  //     }).done(function (rec) {
  //       $('#TableListEmpense_body').empty();
  //       $.each(rec, function(k,v) {
  //         $('#TableListEmpense_body').append('<tr>'+
  //           '<td style="text-align: center;">'+v.ExpDate+'</td>'+
  //           '<td style="text-align: center;">'+v.ChaGroup+'</td>'+
  //           '<td style="text-align: center;">'+v.ShopName+'</td>'+
  //           '<td style="text-align: right;">'+v.ExpAmount+'</td>'+
  //           '<td style="text-align: right;">'+v.ExpAmount+'</td>'+
  //           '<td style="text-align: right;">'+v.ExpPrice+'</td>'+
  //           '<td style="text-align: right;">'+v.ExpPrice+'</td>'+
  //           '<td style="text-align: center;">'+v.ReceiptNo+'</td>'+
  //           '<td style="text-align: center;">'+v.Remark+'</td>'+
  //           '<td  class="text-center"><button type="button" class="btn btn-warning btn-sm btn-edit" data-id="'+v.ExpID+'"><i class="fa fa-pencil-square-o"></i>แก้ไข</button>'+
  //           '<button type="button" class="btn  btn-danger btn-sm btn-delete" data-id="'+v.ExpID+'"><i class="fa fa-trash"></i> ลบ</button></td>'+
  //           '</tr>');
  //       });
  //     });
  //   });

    $('body').on('click', '.btn-delete', function () {
      var id = $(this).data('id');
      swal({
        title: 'คุณต้องการลบข้อมูลหรือไม่ ?',
        text: "หากต้องการลบ กดปุ่ม 'ยืนยัน'",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.value == true) {
          $.ajax({
            method: "POST",
            url: url + "/Accounting/Expenditure/delete/"+id,
            dataType: 'json',
          }).done(function (rec) {
            if (rec.type == 'success') {
              swal({
                confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
              });
              TableListEmpense.api().ajax.reload();
            } else {
              swal(rec.title, rec.text, rec.type);
            }
          });
        }
      });
}); //end btn-delete
$('.datecalendar').change(function() {
    // $('#SearchDate').submit();
    TableListEmpense.api().ajax.reload();
});
</script>
@endsection
