@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link href="{{asset('js/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('body')
<div class="col-lg-12">
  <div class="card">
    <div class="card-header" style="width: 100%">
      <i class="fa fa-align-justify"></i><strong>การจัดการลูกหนี้</strong>
      <div class="row pull-center">
        <div class="col-sm-4" style="width: 100%"></div>
        <form action="" id="SearchDate" method="post" class="form-inline">
          <br>
          <div class="form-group date">
            <label for="datedoc"></label>
            <input type="text" name="fromDate" id="fromDate" class="form-control datecalendar" placeholder="dd/mm/yyyy" onKeyPress="CheckNum()">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>
          <div class="form-group date">
            <label for="datedoc">&nbsp; ถึง &nbsp;</label>
            <input type="text" name="toDate" id="toDate" class="form-control datecalendar" placeholder="dd/mm/yyyy" onKeyPress="CheckNum()">
            <span class="input-group-btn">
              <button type="buttton" class="btn btn-primary" style="margin-top:-1px">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>

      </div>
      <div class="pull-right" style="margin-top:-35px;">
        <!-- <button type="submit" class="btn btn-primary fa fa-search" data-toggle="modal" data-target="" style="width:90px; height: 40px"> ค้นหา</button> -->
      </div>
    </div>
    </form>
      <div class="card-body" style="width: 100%">
        <div class="table-responsive">
          <table id="report_rawmaterial" class="table table-bordered table-striped table-sm TableListPayment">
            <thead class="table-info">
              <tr height="19" style="height:14.25pt">
                <th rowspan="2" height="38" class="xl66" width="88" style="height:28.5pt;width:66pt;vertical-align:middle;"><br><b>วันที่</b></th>
                <th colspan="12" class="xl66" width="374" style="border-left:none;width:280pt;text-align:center;"><b>การจัดการลูกหนี้</b></th>
                <!-- <th rowspan="2" class="xl66" width="138" style="width:104pt" align="center"><br><b>บันทึก</b></th> -->
              </tr>
              <tr height="19" style="height:14.25pt">
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ชื่อรถ</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ชื่อลูกหนี้</b></th>
                <th height="19" class="xl67" align="center" style="height:14.25pt;border-top:none;border-left:none" ><b>สินค้า</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>จำนวน</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>หน่วย</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ราคาทั้งหมด(บาท)</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ราคาทั้งหมด(ริงกิต)</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ยอดที่ชำระแล้ว(บาท)</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ยอดที่ชำระแล้ว(ริงกิต)</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ยอดที่ยังไม่ชำระ(บาท)</b></th>
                <th class="xl67" align="center" style="border-top:none;border-left:none"><b>ยอดที่ยังไม่ชำระ(ริงกิต)</b></th>
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
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
              </tr>
            </tfoot>
            <tbody id="TableListPayment_body">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>

<script type="text/javascript">
  $('document').ready(function(){
   $('#report_rawmaterial').DataTable();
 });
  $('.datecalendar').daterangepicker({
    singleDatePicker: true,
    locale: {
      format: 'YYYY-MM-DD'
    }
  });
  var TableListPayment = $('.TableListPayment').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url + "/Accounting/Debtor/DataLists",
      "data": function (d) {
        d.fromDate = $('#fromDate').val();
        d.toDate = $('#toDate').val();
      }
    },
    "scrollY":  450,
    "columns": [
    {"data": "PayDate","name": "PayDate", "className": "text-center"},
    {"data": "TruckNumber", "name": "TruckNumber", "className": "text-center"},
    {"data": "CusName", "name": "CusName", "className": "text-center"},
    {"data": "ProName", "name": "ProName", "className": "text-center"},
    {"data": "ProSales", "name": "ProSales", "className": "text-right"},
    {"data": "name_th", "name": "name_th", "className": "text-right"},
    {"data": "TotalPrice_TH", "name": "TotalPrice_TH", "className": "text-right"},
    {"data": "TotalPrice_RG", "name": "TotalPrice_RG", "className": "text-right"},
    {"data": "Pay_TH", "name": "Pay_TH", "className": "text-right"},
    {"data": "Pay_RG", "name": "Pay_RG", "className": "text-right"},
    {"data": "Total_TH", "name": "Total_TH", "className": "text-right"},
    {"data": "Total_RG", "name": "Total_RG", "className": "text-right"}
    // {"data": "action", "name": "action", "className": "text-center", "orderable": false, "searchable": false},
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
    "footerCallback": function (tfoot,row, data, start, end, display) {
        var api = this.api(), data;
        var intVal = function (i) {
            return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
        };
        // $.fn.dataTable.render.number(',','.','2','$').display(total)
        // Total over this page
        pageTotal6 = api.column(6, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal7 = api.column(7, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal8 = api.column(8, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal9 = api.column(9, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal10 = api.column(10, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        pageTotal11 = api.column(11, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        // Update footer
        var numFormat_th = $.fn.dataTable.render.number( '\,', '.', 2, '฿' ).display;
        var numFormat_rm = $.fn.dataTable.render.number( '\,', '.', 2, 'RM' ).display;
        $( api.column( 6 ).footer() ).html(
          numFormat_th(pageTotal6)
        );
        $( api.column( 7 ).footer() ).html(
          numFormat_rm(pageTotal7)
        );
        $( api.column( 8 ).footer() ).html(
          numFormat_th(pageTotal8)
        );
        $( api.column( 9 ).footer() ).html(
          numFormat_rm(pageTotal9)
        ); 
        $( api.column( 10 ).footer() ).html(
          numFormat_th(pageTotal10)
        );
        $( api.column( 11 ).footer() ).html(
          numFormat_rm(pageTotal11)
        );  
        // $(api.column(6).footer()).html(pageTotal6);
        // $(api.column(7).footer()).html(pageTotal7);
        // $(api.column(8).footer()).html(pageTotal8);
        // $(api.column(9).footer()).html(pageTotal9);
        // $(api.column(10).footer()).html(pageTotal10);
        // $(api.column(11).footer()).html(pageTotal11);
    }
  });
  // $('body').on('submit','#SearchDate', function(e){
  //     e.preventDefault();
  //     var fromDate = $('#fromDate').val();
  //     var toDate   = $('#toDate').val();
  //     $.ajax({
  //       method: "POST",
  //       url: url + "/Accounting/Debtor/SearchDate",
  //       dataType: "json",
  //       data: $(this).serialize()
  //     }).done(function (rec) {
  //       // console.log(rec);
  //       $('#TableListPayment_body').empty();

  //       $.each(rec, function(k,v) {
  //         var TotalPrice_TH = (this.CurrencyID==1)?this.TotalPrice:'0';
  //         var TotalPrice_RG = (this.CurrencyID==2)?this.TotalPrice:'0';
  //         var Pay_TH = (this.CurrencyID==1)?this.Pay:'0';
  //         var Pay_RG = (this.CurrencyID==2)?this.Pay:'0';
  //         var Total_TH = (this.CurrencyID==1)?this.Total:'0';
  //         var Total_RG = (this.CurrencyID==2)?this.Total:'0';

  //         $('#TableListPayment_body').append('<tr>'+
  //           '<td style="text-align:center;">'+v.PayDate+'</td>'+
  //           '<td style="text-align:center">'+v.TruckNumber+'</td>'+
  //           '<td style="text-align:center">'+v.CusName+'</td>'+
  //           '<td style="text-align:center">'+v.ProName+'</td>'+
  //           '<td style="text-align:center">'+v.ProSales+'</td>'+
  //           '<td style="text-align:center">'+v.name_th+'</td>'+
  //           '<td style="text-align:center">'+TotalPrice_TH+'</td>'+
  //           '<td style="text-align:center">'+TotalPrice_RG+'</td>'+
  //           '<td style="text-align:center">'+Pay_TH+'</td>'+
  //           '<td style="text-align:center">'+Pay_RG+'</td>'+
  //           '<td style="text-align:center">'+Total_TH+'</td>'+
  //           '<td style="text-align:center">'+Total_RG+'</td>'+
  //           '</tr>');
  //       });
  //     });
  //   });
    $('.datecalendar').change(function() {
        // $('#SearchDate').submit();
        TableListPayment.api().ajax.reload();
    });
</script>
@endsection
