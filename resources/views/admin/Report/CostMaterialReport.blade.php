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
                        <input type="text" class='form-control datecalendar' name="startDate" id="start">
                    </div>
                    ถึง : 
                    <div class="col-md-3 date">
                        <input type="text" class='form-control datecalendar' name="endDate" id="end">
                    </div>
                </div>
                <br>
                <table id="report" class="table table-bordered table-striped table-sm">
                    <thead class="table-info">
                        <tr class='text-center'>
                            <th style="width:10%;"><strong>SIZE</strong></th>
                            <th style="width:9%"><strong>สินค้า</strong></th>
                            <th style="width:9%"><strong>จํานวน</strong></th>
                            <th style="width:9%"><strong>ต้นทุน</strong></th>
                            <th style="width:9%"><strong>รวม</strong></th>
                            <th style="width:9%"><strong>หมายเหตุ</strong></th>
                        </tr>
                    </thead>
                        @php 
                            $i = '';
                            $j = 0;
                            $total = 0;
                        @endphp
                    <tbody>
                            @php
                            $a = sizeof($cost_list);
                            @endphp
                            @foreach($cost_list as $k => $val)
                            @php
                                $total+=$val->sumAll;
                            @endphp
                            @if($i != $val->ProName)
                            @if($k!=0)
                            <tr style="background-color: #a4b7c1;">
                            <td colspan="4" align="center"><strong>รวม</strong></td>
                            <td align="right">{{number_format($total,2)}}</td>
                            <td></td>
                            </tr>
                            @endif
                                <tr><td><b>{{$val->ProName}}</b></td>
                            @php 
                                $i=$val->ProName;
                            @endphp
                            @else
                            @php
                                if($k!=0) {
                                $j=0;
                            }
                            @endphp
                                <tr><td></td>
                            @endif
                                <td>{{$val->MatDescription}} {{$i}} {{$val->ProName}}</td>
                                <td align="right">{{number_format($val->amount,2)}}</td>
                                <td align="right">{{number_format($val->MatPricePerUnit,2)}}</td>
                                <td align="right">{{number_format($val->sumAll,2)}}</td>
                                <td></td>
                        </tr>
                            @if(($k+1)==$a)
                            <tr style="background-color: #a4b7c1;">
                            <td colspan="4" align="center"><strong>รวม</strong></td>
                            <td align="right">{{number_format($total,2)}}</td>
                            <td></td>
                            </tr>
                            @endif
                        @if($j == 1)
                        <tr style="background-color: #a4b7c1;">
                            <td colspan="4" align="center"><strong>รวม</strong></td>
                            <td align="right">{{number_format($total,2)}}</td>
                            <td></td>
                        </tr>
                        @php
                        $total = 0;
                        $j = 0;
                        @endphp
                        @endif
                        @endforeach
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
            format: 'YYYY-MM-DD',
        }
    });
    $(function() {
        getdata($('#start').val(),$('#end').val());
    });
    $('#start, #end').change(function(){
        getdata($('#start').val(),$('#end').val());
    });
    function getdata(start, end) {
        $.ajax({
            url: url + "/Report/CostMaterialReport/SearchCostMaterialReport/"+start+"/"+end,
            dataType: "html",
            method: "GET",
            success: function(rec) {
                $('tbody').html(rec);
            }
        });
    }
</script>
@endsection
