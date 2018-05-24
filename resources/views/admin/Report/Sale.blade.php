@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<title>{{$title}} | BlueIce</title>
@endsection

@section('body')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header" style="width: 100%">
            <i class="fa fa-align-justify"></i><strong>{{$title}}</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class='row justify-content-md-center'>
                    <div class="col-md-3 date">
                        <input type="text" class='form-control datecalendar' id="start">
                    </div>
                    ถึง : 
                    <div class="col-md-3 date">
                        <input type="text" class='form-control datecalendar' id="end">
                    </div>
                </div>
                <br>
                <table id="report" class="table table-bordered table-striped table-sm">
                    <thead class="table-info">
                        <tr class='text-center'>
                            <th style="width:11%">วัน/เดือน/ปี</th>
                            <th style="width:11%">รถบรรทุก</th>
                            <th style="width:11%">ลูกค้า</th>
                            <th style="width:11%">สินค้า</th>
                            <th style="width:11%">จำนวนส่งสินค้า</th>
                            <th style="width:11%">หน่วย</th>
                            <th style="width:11%">ยอดชําระ</th>
                            <th style="width:11%">หน่วยเงิน</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script>

    $('.datecalendar').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD-MM-YYYY',
        }
    });

    var TableList = $('#report').dataTable({
        "ajax": {
            "url": url+"/Report/SaleReport/List",
            "data": function ( d ) {
                d.start = $('#start').val();
                d.end = $('#end').val();
                //d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {"data" : "date","className":"text-center"},
            {"data" : "truck","className":"text-center"},
            {"data" : "customer","className":"text-center"},
            {"data" : "product","className":"text-center"},
            {"data" : "count","className":"text-right"},
            {"data" : "unit","className":"text-center"},
            {"data" : "sum","className":"text-right"},
            {"data" : "currency","className":"text-center"}
        ]
    });


    $('body').on('change', '.datecalendar',function(){
        TableList.api().ajax.reload();
    })

</script>
@endsection
