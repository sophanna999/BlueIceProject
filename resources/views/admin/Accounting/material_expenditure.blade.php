@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
@endsection

@section('body')
<div class="col-lg-12">
  <div class="card">
    <div class="card-header" style="width: 100%">
      <i class="fa fa-align-justify"></i><strong>การจัดการรายจ่ายซื้อวัตถุดิบ</strong>
      <div class="row pull-center">
    		<div class="col-sm-4" style="width: 100%"></div>
        <form action="" id="SearchDate" method="post" class="form-inline">
        <br>
         <div class="form-group date">
          <label for="datedoc"></label>
          <input type="text" id="fromDate" name="fromDate" class="form-control datecalendar" placeholder="dd/mm/yyyy" onKeyPress="CheckNum()">
          <span class="input-group-btn">
          <button type="button" class="btn btn-primary" style="margin-top:-1px">
          <i class="fa fa-calendar"></i>
          </button>
           </span>
        </div>
        <div class="form-group date">
          <label for="datedoc">&nbsp; ถึง &nbsp;</label>
          <input type="text" id="toDate" name="toDate" class="form-control datecalendar" placeholder="dd/mm/yyyy" onKeyPress="CheckNum()">
          <span class="input-group-btn">
          <button type="button" class="btn btn-primary" style="margin-top:-1px">
          <i class="fa fa-calendar"></i>
          </button>
           </span>
        </div>
      </div>
      <div class="pull-right" style="margin-top:-35px;margin-right: 114px;">
      </div>
      </form>
    </div>
    <div class="card-body" style="width: 100%">
      <div class="table-responsive">
        <table id="report_material" class="table table-bordered table-striped table-sm">
          <thead class="table-info">
            <!-- <tr height="19" style="height:14.25pt">
              <th rowspan="2" height="38" class="xl68" width="87" style="height:28.5pt;width:65pt;vertical-align:middle;" align="center"><br><b>วันที่สั่งซื้อ</b></th>
              <th colspan="10" class="xl68" width="392" style="border-left:none;width:294pt;text-align:center;"><b>การจัดการรายจ่ายซื้อวัตถุดิบ</b></th>
            </tr> -->
            <tr height="19" style="height:14.25pt">
              <th height="19" class="xl68" style="height:14.25pt;border-top:none;border-left:none" align="center"><b>วันที่สั่งซื้อ</b></th>
              <th height="19" class="xl68" style="height:14.25pt;border-top:none;border-left:none" align="center"><b>รายการวัตถุดิบ</b></th>
              <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ชื่อร้านค้า</b></th>
              <th class="xl68" style="border-top:none;border-left:none" align="center"><b>จำนวน</b></th>
              <th class="xl68" style="border-top:none;border-left:none" align="center"><b>หน่วย</b></th>
              <th class="xl68" style="border-top:none;border-left:none" align="center"><b>จํานวนค้างส่ง</b></th>
              <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ราคารวม(บาท)</b></th>
              <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ราคารวม(ริงกิต)</b></th>
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
              </tr>
            </tfoot>
          <tbody id="TableListMaterial_body">
          </tbody>
         </table>
        </div>
      </div>
        <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-info">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">การจัดการรายจ่ายซื้อวัตถุดิบ</h4>
          </div>
          <div class="modal-body">
           <div class="row">
            <div class="form-group col-sm-6">
             <label for="date">วันที่สั้งซื้อ</label>
             <div class="input-group date datecalendar">
              <input type="text" id="datedoc" name="datedoc" class="form-control" placeholder="dd/mm/yyyy"><span class="input-group-btn">
               <button type="button" class="btn btn-primary ">
                <i class="fa fa-calendar"></i></button>
              </span>
            </div>
          </div>
          <div class="form-group col-sm-6">
            <label for="product">รายการวัตถุดิบ</label>
            <select class="form-control" id="product">
              <option>ขวดน้ำ</option>
              <option>กระสอบ</option>
              <option>ลังใส่ขวดน้ำ</option>
            </select>
          </div>
          <div class="form-group col-sm-12">
            <label for="num">ร้านค้า</label>
            <input type="text" class="form-control" name="store" id="store" placeholder="ร้านค้า">
          </div>
          <div class="form-group col-sm-6">
            <label for="price">ราคารวม</label>
            <div class="input-group">
              <input type="number" id="price" name="price" class="form-control" placeholder="ราคารวม"><span class="input-group-btn">
                <select class="form-control form-info" id="ccmonth">
                  <option>บาท</option>
                  <option>ริงกิต</option>
                </select>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <label for="ProID">จำนวน</label>
              <input type="number" class="form-control" name="ProID" id="ProID" min="0" max="100" placeholder="จำนวน">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" data-dismiss="modal" style="width:60px; height: 40px">บันทึก</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>
  <!-- Modal -->
  <div id="MyDelete" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <center><h4 class="modal-title">คุณต้องการลบหรือไม่</h4></center>
        </div>
        <div class="modal-body">
          <center>
            <button type="submit" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ลบ</button>
            <button type="button" class="btn btn" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
          </center>
        </div>
        <!-- /.modal-content -->
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
  $('document').ready(function(){
     $('#report_material').DataTable();
  });

  $('.datecalendar').daterangepicker({
    singleDatePicker: true,
    locale: {
      format: 'YYYY-MM-DD'
    }
  });

  var report_material = $('#report_material').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url + "/Accounting/MaterialExpenditure/MeterialLists",
      "data": function (d) {
        d.fromDate = $('#fromDate').val();
        d.toDate   = $('#toDate').val();
      }
    },
    "columns": [
    {"data": "PoDate","name": "PoDate", "className": "text-center"},
    {"data": "PoDescription", "name": "PoDescription", "className": "text-center"},
    {"data": "SupName", "name": "SupName", "className": "text-center"},
    {"data": "PoQTY", "name": "PoQTY", "className": "text-right"},
    {"data": "PoQTY", "name": "PoQTY", "className": "text-right","visible":false},
    {"data": "Accrual", "name": "Accrual", "className": "text-right"},
    {"data": "TotalPrice_TH", "name": "TotalPrice_TH", "className": "text-right"},
    {"data": "TotalPrice_RG", "name": "TotalPrice_RG", "className": "text-right"},
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
        var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;
        var numFormat_th = $.fn.dataTable.render.number( '\,', '.', 2, '฿' ).display;
        var numFormat_rm = $.fn.dataTable.render.number( '\,', '.', 2, 'RM' ).display;
        $( api.column( 3 ).footer() ).html(
          numFormat(pageTotal3)
        );
        $( api.column( 4 ).footer() ).html(
          numFormat(pageTotal4)
        );
        $( api.column( 5 ).footer() ).html(
          numFormat(pageTotal5)
        );
        $( api.column( 6 ).footer() ).html(
          numFormat_th(pageTotal6)
        );
        $( api.column( 7 ).footer() ).html(
          numFormat_rm(pageTotal7)
        );
        // $(api.column(6).footer()).html(pageTotal6);
        // $(api.column(7).footer()).html(pageTotal7);
    }
  });

  // $('body').on('submit','#SearchDate', function(e){
  //     e.preventDefault();
  //     var fromDate = $('#fromDate').val();
  //     var toDate   = $('#toDate').val();
  //     $.ajax({
  //       method: "POST",
  //       url: url + "/Accounting/MaterialExpenditure/SearchDate",
  //       dataType: "json",
  //       data: $(this).serialize()
  //     }).done(function (rec) {
  //       // console.log(rec);
  //       $('#TableListMaterial_body').empty();
  //       $.each(rec, function(k,v) {
  //         var TotalPrice_TH = (this.PriceType==1)?this.TotalPrice:'0';
  //         var TotalPrice_RG = (this.PriceType==2)?this.TotalPrice:'0';
  //         $('#TableListMaterial_body').append('<tr>'+
  //           '<td style="text-align: center;">'+v.PoDate+'</td>'+
  //           '<td style="text-align: center">'+v.PoDescription+'</td>'+
  //           '<td style="text-align: center">'+v.SupName+'</td>'+
  //           '<td style="text-align: right">'+v.PoQTY+'</td>'+
  //           '<td style="text-align: right">'+v.PoQTY+'</td>'+
  //           '<td style="text-align: right">'+v.Accrual+'</td>'+
  //           '<td style="text-align: right">'+TotalPrice_TH+'</td>'+
  //           '<td style="text-align: righr">'+TotalPrice_RG+'</td>'+
  //           '</tr>');
  //       });
  //     });
  //   });
    $('.datecalendar').change(function() {
        // $('#SearchDate').submit();
        report_material.api().ajax.reload();
    });
 </script>
 @endsection
