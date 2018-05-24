@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link href="{{asset('js/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('body')
<div class="col-lg-12 set-bg">
  <div class="card">
    <div class="card-header" style="width: 100%">
      <i class="fa fa-align-justify"></i><strong>สรุปรายรับ - รายจ่าย</strong>
      <div class="row pull-center">
        <div class="col-sm-4" style="width: 100%"></div>
        <form action="" id="FormSearch" method="post" class="form-inline">
          <br>
          <div class="form-group">
            <label for="exampleInputName2"></label>
            <div class="form-group date">
              <label for="fromDate"></label>
              <input type="text" id="fromDate" name="fromDate" class="form-control datecalendar" placeholder="dd/mm/yyyy">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" style="margin-top:-1px">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
          </div>
          <div class="form-group date">
            <label for="toDate">&nbsp; ถึง &nbsp;</label>
            <input type="text" id="toDate" name="toDate" class="form-control datecalendar" placeholder="dd/mm/yyyy" onKeyPress="CheckNum()">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>
      </div>
      <div class="pull-right btn-search">
        <!-- <button type="submit" class="btn btn-primary fa fa-search" data-toggle="modal"  style="width:90px; height: 40px"> ค้นหา</button> -->
      </div>
    </form>
    </div>
    <div class="card-body" style="width: 100%">
      <div class="table-responsive">
<!--         <table id="report_rawmaterial" class="table table-bordered table-striped table-sm" style="width: 100%">
                    <thead class="table-info">
                        <th style="width: 35px;" align="center"><center>ลำดับ</center></th>
                        <th><center>เลขที่ใบเบิก</center></th>
                        <th><center>รถบรรทุก</center></th>
                        <th><center>วันที่/เวลา</center></th>
                        <th style="width: 200px;"><center>การกระทำ</center></th>
                    </thead>

                  </table> -->

                  <table id="report_rawmaterial" class="table table-bordered table-striped table-sm TableListRecieve" style="width:100%;">
                    <thead class="table-info">
                      <tr>

                        <th colspan="10" class="TruckID"><b><center>สรุปรายรับ- รายจ่าย</center></b></th>

                      </tr>
                      <tr>
                        <th><b><center>วัน/เดือน/ปี</center></b></th>
                        <th><b><center>ชื่อรถ</center></b></th>
                        <th><b><center>รายรับ(บาท)</center></b></th>
                        <th><b><center>รายรับ(ริงกิต)</center></b></th>
                        <th><b><center>รายจ่าย(บาท)</center></b></th>
                        <th><b><center>รายจ่าย(ริงกิต)</center></b></th>
                        <th><b><center>ส่วนต่าง(บาท)</center></b></th>
                        <th><b><center>ส่วนต่าง(ริงกิต)</center></b></th>
                        <th><b><center>ข้อมูล</center></b></th>
                      </tr>
                    </thead>
                    <tfoot>
                        <tr style="background-color:#d3eef6;">
                            <th>รวม</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    <tbody class="Recievable_Detail">

                    </tbody>
        </table>
      </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg modal-primary" style="">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">ข้อมูลสรุปบัญชีรายรับ - รายจ่าย </h4>
          </div>
          <div class="modal-body">
            <table id="" class="table table-bordered table-striped table-sm">
              <thead class="table-info">
                <tr>
                  <td rowspan="2"><b><center><br>วันที่</center></b></td>
                  <td rowspan="2"><b><center><br>รายการ</center></b></td>
                  <td colspan="4"><b><center>รายรับ</center></b></td>
                  <td colspan="4"><b><center>รายจ่าย</center></b></td>
                </tr>
                <tr>
                  <td><b><center>จำนวน</center></b></td>
                  <td><b><center>หน่วย</center></b></td>
                  <td><b><center>จำนวนเงิน<br>(บาท)</center></b></td>
                  <td><b><center>จำนวนเงิน<br>(ริงกิต)</center></b></td>
                  <td><b><center>จำนวน</center></b></td>
                  <td><b><center>หน่วย</center></b></td>
                  <td><b><center>จำนวนเงิน<br>(บาท)</center></b></td>
                  <td><b><center>จำนวนเงิน<br>(ริงกิต)</center></b></td>
                </tr>
              </thead>
              <tbody class="RecieveExpenseDetail" id="RecieveExpenseDetail">
                <!-- <tr border="2" >
                  <td align="center">1/11/2560</td>
                  <td>จ่ายค่าน้ำมันรถ</td>
                  <td align="right">-</td>
                  <td align="center">-</td>
                  <td align="right">-</td>
                  <td align="right">-</td>
                  <td align="right">-</td>
                  <td align="right">5</td>
                  <td align="center">คัน</td>
                  <td align="right">5,000.00</td>
                </tr> -->
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>

<script type="text/javascript">

    $('.datecalendar').daterangepicker({
      singleDatePicker: true,
      locale: {
        format: 'YYYY-MM-DD'
      }
    });

  var dataTableList = $('#report_rawmaterial').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url + "/Accounting/ReceivableExpensable/DataLists",
      "data": function (d) {
        d.fromDate = $('#fromDate').val();
        d.toDate   = $('#toDate').val();
      }
    },
    "scrollY":  450,
    "columns": [
    {"data": "PayDate", "name": "PayDate", "className": "text-center"},
    {"data": "TruckNumber", "name": "TruckNumber", "className": "text-center"},
    {"data": "Pay_TH", "name": "Pay_TH", "className": "text-right"},
    {"data": "Pay_RG", "name": "Pay_RG", "className": "text-right"},
    {"data": "ExpPrice_TH", "name": "ExpPrice_TH", "className": "text-right"},
    {"data": "ExpPrice_RG", "name": "ExpPrice_RG", "className": "text-right"},
    {"data": "Difference_TH", "name": "Difference_TH", "className": "text-right"},
    {"data": "Difference_RG", "name": "Difference_RG", "className": "text-right"},
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
        pageTotal1 = api.column(1, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal2 = api.column(2, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal3 = api.column(3, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal4 = api.column(4, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal5 = api.column(5, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal6 = api.column(6, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal7 = api.column(7, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        // Update footer
        var numFormat_th = $.fn.dataTable.render.number( '\,', '.', 2, '฿' ).display;
        var numFormat_rm = $.fn.dataTable.render.number( '\,', '.', 2, 'RM' ).display;
        $( api.column( 2 ).footer() ).html(
          numFormat_th(pageTotal2)
        );
        $( api.column( 3 ).footer() ).html(
          numFormat_rm(pageTotal3)
        );
        $( api.column( 4 ).footer() ).html(
          numFormat_th(pageTotal4)
        );
        $( api.column( 5 ).footer() ).html(
          numFormat_rm(pageTotal5)
        );
        $( api.column( 6 ).footer() ).html(
          numFormat_th(pageTotal6)
        );
        $( api.column( 7 ).footer() ).html(
          numFormat_rm(pageTotal7)
        );
    }
  });

  $('body').on('click','.btn-select',function(e){
    e.preventDefault();
    var TruckID = $(this).data()['id'];
    var date = $(this).data()['date'];

    $.ajax({
      method: "GET",
      url: url + "/Accounting/ReceivableExpensable/RecievedExpenseLists/"+TruckID+'/'+date,
      dataType: 'json',
    }).done(function (rec) {
      $('.RecieveExpenseDetail').empty();
      $.each(rec.Expenses, function() {
        var Price_TH = (this.ExpUnit==1)?this.ExpPrice:'0';
        var Price_RG = (this.ExpUnit==2)?this.ExpPrice:'0';
              // console.log(ExpAmount_TH);
              $('.RecieveExpenseDetail').append('<tr>'+
                '<td>'+this.ExpDate+'</td>'+
                '<td>'+this.ExpList+'</td>'+
                '<td align="right">0</td>'+
                '<td align="right">-</td>'+
                '<td align="right">0</td>'+
                '<td align="right">0</td>'+
                '<td align="right">'+this.ExpAmount+'</td>'+
                '<td align="center">-</td>'+
                '<td align="right">'+Price_TH+'</td>'+
                '<td align="right">'+Price_RG+'</td>'+
                '</tr>');
            });

      $.each(rec.payment, function() {
        var Price_TH = (this.CurrencyID==1)?this.Pay:'0';
        var Price_RG = (this.CurrencyID==2)?this.Pay:'0';
        $('.RecieveExpenseDetail').append('<tr>'+
          '<td align="center">'+this.PayDate+'</td>'+
          '<td>'+this.ProName+'</td>'+
          '<td align="right">'+this.ProSales+'</td>'+
          '<td align="right">-</td>'+
          '<td align="right">'+Price_TH+'</td>'+
          '<td align="right">'+Price_RG+'</td>'+
          '<td align="right">0</td>'+
          '<td align="center">-</td>'+
          '<td align="right">0</td>'+
          '<td align="right">0</td>'+
          '</tr>');
      });
      var a = b = c = d = e = f = 0;
            // console.log($('#RecieveExpenseDetail').find('tr'));
            $.each($('.RecieveExpenseDetail').find('tr'),function() {
              $.each($(this).find('td'),function(k,v) {
                if(k==2) {
                  a+= parseFloat($(this).text());
                }if(k==4) {
                  b+= parseFloat($(this).text());
                }if(k==5) {
                  c+= parseFloat($(this).text());
                }if(k==6) {
                  d+= parseFloat($(this).text());
                }if(k==8) {
                  e+= parseFloat($(this).text());
                }if(k==9) {
                  f+= parseFloat($(this).text());
                }
              });
              // console.log(a+' '+b+' '+c+' '+d+' '+e+' '+f);
            });
            $('.RecieveExpenseDetail').append('<tr>'+
                '<td align="center">รวม</td>'+
                '<td></td>'+
                '<td align="right">'+a+'</td>'+
                '<td align="center"></td>'+
                '<td align="right">'+b+'</td>'+
                '<td align="right">'+c+'</td>'+
                '<td align="right">'+d+'</td>'+
                '<td align="right"></td>'+
                '<td align="right">'+e+'</td>'+
                '<td align="right">'+f+'</td>'+
                '</tr>');
            $('#myModal').modal('show');
          });
  });
  $('body').on('click', '.btn-show', function () {
    var id = $(this).data('id');
    $.ajax({
      method: "GET",
      url: url + "/Market/Pickup/show/"+id,
      dataType: 'json',
    }).done(function (rec) {
      $('.TruckDetail').empty();
      $.each(rec, function( key, value ) {
        $('.TruckDetail').append('<tr>'+
          '<td>'+value.ProName+'</td>'+
          '<td>'+value.ProNumber+'</td>'+
          '</tr>');
        $('.driver').val(value.driver);
        $('.D_TruckProID').val(value.TruckProID);
        $('.D_TruckID').val(value.TruckID);
        $('.D_TruckID').prop('disabled',true);
        $('.ProID').val(value.ProID);
        $('.ProNumber').val(value.ProNumber);
        $('.D_TruckDate').val(value.TruckDate);
        $('.D_TruckDate').prop('disabled',true);
        $('.RoundAmount').val(value.RoundAmount);
        $('.notation').val(value.notation);
      });

      $('#DetailModal').modal('show');

    });
  });

// $('body').on('submit','#FormSearch', function(e){
//   e.preventDefault();
//   var fromDate = $('#fromDate').val();
//   var toDate   = $('#toDate').val();
// $.ajax({
//     method: "POST",
//     url: url + "/Accounting/ReceivableExpensable/SearchDate",
//     dataType: "json",
//     data: $(this).serialize()
//   }).done(function (rec) {
//     // console.log(rec);
//     $('.Recievable_Detail').empty();
//     $.each(rec, function(k,v) {
//       var Pay_TH = (this.CurrencyID==1)?(this.Pay != null)?this.Pay:'0':'0';
//       var Pay_RG = (this.CurrencyID==2)?this.Pay:'0';
//       var ExpPrice_TH = (this.CurrencyID!=1)?'0':(this.ExpPrice == null)?'0':this.ExpPrice;
//       var ExpPrice_RG = (this.CurrencyID==2)?this.ExpPrice:'0';
//       var Difference_TH = (this.CurrencyID==1)?this.Difference:'0';
//       var Difference_RG = (this.CurrencyID==2)?this.Difference:'0';
//       $('.Recievable_Detail').append('<tr>'+
//         '<td style="text-align:center;">'+v.PayDate+'</td>'+
//         '<td style="text-align:center">'+v.TruckNumber+'</td>'+
//         '<td style="text-align:right">'+Pay_TH+'</td>'+
//         '<td style="text-align:right">'+Pay_RG+'</td>'+
//         '<td style="text-align:right">'+ExpPrice_TH+'</td>'+
//         '<td style="text-align:right">'+ExpPrice_TH+'</td>'+
//         '<td style="text-alig:right">'+Difference_TH+'</td>'+
//         '<td style="text-alig:right">'+Difference_RG+'</td>'+
//         '<td><button type="button" class="btn btn-success fa fa-plus-square btn-select" data-toggle="modal" data-date="'+v.PayDate+'" data-id="'+v.TruckID+'" style="width: 80px;"> เพิ่มเติม</button></td>'+
//         '</tr>');
//     });
//   });
// });
$('.datecalendar').change(function() {
    // $('#FormSearch').submit();
    dataTableList.api().ajax.reload();
});
</script>

@endsection
