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
                            <th style="width:10%;">วัน/เดือน/ปี</th>
                            <th style="width:15%">รายการวัตถุดิบ</th>
                            <th style="width:15%">จำนวนสั่งซื้อ</th>
                            <th style="width:15%">จำนวนคงคลัง</th>
                            <th style="width:15%">วัตถุดิบสูญเสีย</th>
                            <th style="width:15%">หน่วย</th>
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
            "url": url+"/Report/MaterialReport/List",
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
            {"data" : "description","className":"text-center"},
            {"data" : "qty","className":"text-right"},
            {"data" : "balance","className":"text-right"},
            {"data" : "restore","className":"text-right"},
            {"data" : "unit","className":"text-right"}

        ]
    });


    $('body').on('change', '.datecalendar',function(){
        TableList.api().ajax.reload();
    })

</script>
@endsection
