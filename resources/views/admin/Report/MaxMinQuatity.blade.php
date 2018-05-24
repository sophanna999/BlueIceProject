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
                            <th style="width:10%;">กลุ่มสินค้า</th>
                            <th style="width:15%">รายงาน</th>
                            <th style="width:15%">คลังสินค้า</th>
                            <th style="width:15%">หน่วย</th>
                            <th style="width:15%">จํานวนคงเหลือ</th>
                            <th style="width:15%">ปริมาณตํ่าสุด</th>
                            <th style="width:15%">ปริมาณสูงสุด</th>
                        </tr>
                    </thead> <hr>
                    <tbody>
                        @php 
                            $i = 0;
                        @endphp
                        @foreach($result as $val)
                        @if($i!=$val->id)
                            <tr><td colspan="7"><b>กลุ่มสินค้า : {{$val->ProGroupName}}</b></td></tr>
                        @php $i = $val->id; @endphp
                        @endif
                            <tr>
                                <td>{{$val->id}}</td>
                                <td>{{($val->pro_group_type==1)?$val->ProName:$val->MatDescription}}</td>
                                <td align="center">{{($val->pro_group_type==1)?$val->p_warehouse:$val->m_warehouse}}</td>
                                <td align="center">{{($val->pro_group_type==1)?$val->p_unit:$val->m_unit}}</td>
                                <td align="right">{{($val->pro_group_type==1)?number_format($val->ProBalance,2):number_format($val->MatBalance,2)}}</td>
                                <td align="right">{{($val->pro_group_type==1)? number_format(0,2) : number_format(0,2) }}</td>
                                <td align="right">{{($val->pro_group_type==1)? number_format(0,2) : number_format(0,2) }}</td>
                            </tr>
                        @endforeach()
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

</script>
@endsection
