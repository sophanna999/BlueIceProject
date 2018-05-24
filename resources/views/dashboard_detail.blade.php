@extends('layouts.admin')
@section('csstop')

@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify"></i> {{$title}} ({{$result[0]->agency_name}})
        </div>
        <div class="card-body">
            <h3 style="font-weight: bold; text-align: center;">รายการขายนํ้าแข็งรายวัน ({{$result[0]->agency_name}})</h3><br>
            <h4 style="font-weight: bold; text-align: center;">วันที่ {{date('d-m-Y')}}</h4><br>
            <div class="table-responsive">
              <table class="table">
                <thead class="thead-light">
                  <tr class='text-center'>
                    <th style="width:5%; text-align: center;">ที่</th>
                    <th style="width:15%; text-align: center;">ชื่อลูกค้า</th>
                    <th style="width:10%; text-align: center;">จํานวนเบิก</th>
                    <th style="width:10%; text-align: center;">แถม</th>
                    <th style="width:10%; text-align: center;">เติม</th>
                    <th style="width:10%; text-align: center;">รวม</th>
                    <th style="width:10%; text-align: center;">ราคา</th>
                    <th style="width:10%; text-align: center;">เป็นเงิน</th>
                    <th style="width:10%; text-align: center;">ค้าง</th>
                    <th style="width:10%; text-align: center;">จ่าย</th>
                </tr>
            </thead>
        </thead>
        <tbody>
            @php
             $prosale = 0;
             $proadd  = 0;
             $sumpro  = 0;
             $price   = 0;
             $sumpay  = 0;
             $accured = 0;
             $pay     = 0;
            @endphp
            @foreach($result as $val)
            @php
                $prosale += $val->proSale;
                $proadd  += $val->proAdd;
                $sumpro  += $val->sumPro;
                $price   += $val->price;
                $sumpay  += $val->sumPay;
                $accured += $val->accured;
                $pay     += $val->pay;
            @endphp
              <tr>
                  <td align="center">{{$no++}}</td>
                  <td align="center">{{$val->CusName}}</td>
                  <td align="center">{{number_format($val->proSale,2)}}</td>
                  <td align="center">{{number_format($val->proAdd,2)}}</td>
                  <td align="center">{{number_format(0,2)}}</td>
                  <td align="center">{{number_format($val->sumPro,2)}}</td>
                  <td align="center">{{number_format($val->price,2)}}</td>
                  <td align="center">{{number_format($val->sumPay,2)}}</td>
                  <td align="center">{{number_format($val->accured,2)}}</td>
                  <td align="center">{{number_format($val->pay,2)}}</td>
              </tr>
            @endforeach
      </tbody>
      <tfoot>
        <tr>
            <td colspan="2" align="center"><strong>สรุปรายการขาย</strong></td>
            <td align="center" style="font-weight: bold;">{{number_format($prosale,2)}}</td>
            <td align="center" style="font-weight: bold;">{{number_format($proadd,2)}}</td>
            <td align="center" style="font-weight: bold;">{{number_format(0,2)}}</td>
            <td align="center" style="font-weight: bold;">{{number_format($sumpro,2)}}</td>
            <td align="center" style="font-weight: bold;">{{number_format($price,2)}}</td>
            <td align="center" style="font-weight: bold;">{{number_format($sumpay,2)}}</td>
            <td align="center" style="font-weight: bold;">{{number_format($accured,2)}}</td>
            <td align="center" style="font-weight: bold;">{{number_format($pay,2)}}</td>
        </tr>
    </tfoot>
</table>
</div>
</div>
</div>
</div>
</div>

@endsection

@section('jsbottom')
<script type="text/javascript">
  //   var id = {{$id}};
  //   var dashboard_detail = $('#dashboard_detail').dataTable({
  //   "focusInvalid": false,
  //   "processing": true,
  //   "serverSide": true,
  //   "ajax": {
  //     "url": url + "/detail_lists/"+id,
  //     "method" : "GET",
  //     "data": function (d) {
  //       // d.id = id;
  //     }
  //   },
  //   "columns": [
  //   // {"data": "id","name": "id", "className": "text-center"},
  //   { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
  //   {"data": "CusName", "name": "CusName", "className": "text-center"},
  //   {"data": "proSale", "name": "proSale", "className": "text-center"},
  //   {"data": "proAdd", "name": "proAdd", "className": "text-center"},
  //   {"data": "valible_value1", "name": "valible_value1", "className": "text-center"},
  //   {"data": "valible_value2", "name": "valible_value2", "className": "text-center"},
  //   {"data": "sumPro", "name": "sumPro", "className": "text-center"},
  //   {"data": "price", "name": "price", "className": "text-center"},
  //   {"data": "sumPay", "name": "sumPay", "className": "text-center"},
  //   {"data": "accured", "name": "accured", "className": "text-center"},
  //   {"data": "pay", "name": "pay", "className": "text-center"},
  //   ],
  //   "language": {
  //     "paginate": {
  //       "previous": "ก่อน",
  //       "next": "ต่อไป"
  //     },
  //     "lengthMenu": "แสดง _MENU_ รายการ ต่อ หน้า",
  //     "search": "ค้นหา",
  //     "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
  //     "info": "แสดง หน้า _PAGE_ จาก _PAGES_",
  //     "infoEmpty": "ไม่มีข้อมูลบันทึก",
  //     "infoFiltered": "(ค้นหา จากทั้งหมด _MAX_ รายการ)",
  //   },
  //   responsive: true,
  //   "drawCallback": function (settings) {
  //   },
  //   "footerCallback": function (row, data, start, end, display) {
  //       var api = this.api(), data;
  //       var intVal = function (i) {
  //           return typeof i === 'string' ?
  //                   i.replace(/[\$,]/g, '') * 1 :
  //                   typeof i === 'number' ?
  //                   i : 0;
  //       };
  //       // Total over this page

  //       pageTotal2 = api.column(2, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal3 = api.column(3, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal4 = api.column(4, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal5 = api.column(5, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal6 = api.column(6, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal7 = api.column(7, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal8 = api.column(8, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal9 = api.column(9, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       pageTotal10 = api.column(10, {page: 'current'}).data().reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //       }, 0)
  //       // Update footer
  //       // $(api.column(1).footer()).html(pageTotal1);
  //       $(api.column(2).footer()).html(pageTotal2);
  //       $(api.column(3).footer()).html(pageTotal3);
  //       $(api.column(4).footer()).html(pageTotal4);
  //       $(api.column(5).footer()).html(pageTotal5);
  //       $(api.column(6).footer()).html(pageTotal6);
  //       $(api.column(7).footer()).html(pageTotal7);
  //       $(api.column(8).footer()).html(pageTotal8);
  //       $(api.column(9).footer()).html(pageTotal9);
  //       $(api.column(10).footer()).html(pageTotal10);
  //   }
  // });

</script>
@endsection
