@extends('layouts.admin')
@section('csstop')

@endsection

@section('body')
<div class="container-fluid">
  <div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{$acountant_title}}
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">สรุปรายการเงิน</th>
                <th scope="col">ไทย</th>
                <th scope="col">มาเล</th>
                <th scope="col">รวม</th>
              </tr>
            </thead>
            <tbody>
              @php
                $thai    = 0;
                $ringkit = 0;
                $sum     = 0;
              @endphp
              @foreach($result as $val)
              @php
                $thai    += $val->thai;
                $ringkit += $val->ringkit;
                $sum     += $val->sum_all;
              @endphp
                <tr>
                  <td><a href="{{url('/dashboard_detail/'.$val->id)}}" target="_blank">{{$val->agency_name}}</a></td>
                  <td>{{number_format($val->thai,2)}}</td>
                  <td>{{number_format($val->ringkit,2)}}</td>
                  <td>{{number_format($val->sum_all,2)}}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>รวมทั้งหมด</th>
                <th>{{number_format($thai,2)}}</th>
                <th>{{number_format($ringkit,2)}}</th>
                <th>{{number_format($sum,2)}}</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{$giveaway_title}}
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">รายชื่อ</th>
                <th scope="col">แถม</th>
                <th scope="col">เติม</th>
                <th scope="col">รวม</th>
              </tr>
            </thead>
            <tbody>
              @php
                $sum_all = 0;
              @endphp
              @foreach($getAwayAndAdd as $key => $value)
              @php 
                $sum_all += $value->sumall;
              @endphp
              <tr>
                <td>{{$value->agency_name}}</td>
                <td>{{number_format($value->profree,2)}}</td>
                <td>{{number_format($value->ProAdd,2)}}</td>
                <td>{{number_format($value->sumall,2)}}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3" style="text-align: center;">ยอดรวม</th>
                <th>{{number_format($sum_all,2)}}</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection

@section('jsbottom')

<script type="text/javascript">
    var dashboardlist = $('#dashboardlist').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url + "/list",
      "method" : "GET",
      "data": function (d) {
        // d.id = id;
      }
    },
    "columns": [
    // { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
    {"data": "agency_name", "name": "agency_name", "className": "text-center"},
    {"data": "thai", "name": "thai", "className": "text-center"},
    {"data": "ringkit", "name": "ringkit", "className": "text-center"},
    {"data": "sum_all", "name": "sum_all", "className": "text-center"},
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
        // Update footer
        // $(api.column(1).footer()).html(pageTotal1);
        $(api.column(1).footer()).html(pageTotal1);
        $(api.column(2).footer()).html(pageTotal2);
        $(api.column(3).footer()).html(pageTotal3);
    }
  });
</script>

@endsection
