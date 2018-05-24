@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link href="{{asset('js/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('body')
<div class="col-lg-12">
      <div class="card">
        <div class="card-header" style="width: 100%">
          <i class="fa fa-align-justify"></i><strong>การจัดการเก็บรายได้</strong>
          <div class="row pull-center">
        		<div class="col-sm-4" style="width: 100%"></div>
            <form action="" method="post" class="form-inline">
            <br>
             <div class="form-group date datecalendar">
              <label for="datedoc"></label>
              <input type="text" id="datedoc" name="datedoc" class="form-control" placeholder="dd/mm/yyyy">
              <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
              <i class="fa fa-calendar"></i>
              </button>
               </span>
            </div>
            <div class="form-group date datecalendar">
              <label for="datedoc">&nbsp; ถึง &nbsp;</label>
              <input type="text" id="datedoc" name="datedoc" class="form-control" placeholder="dd/mm/yyyy">
              <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
              <i class="fa fa-calendar"></i>
              </button>
               </span>
            </div>
          </form>
          </div>
          <div class="pull-right" style="margin-top:-35px;margin-right: 114px;"> 
        <button type="button" class="btn btn-primary fa fa-search" style="width:90px; height: 40px">&nbsp; ค้นหา</button>
            </div>
                 <div class="pull-right" style="margin-top:-35px;"> 
                  <a href="">
        <button type="button" class="btn btn-primary fa fa-plus" style="width:90px; height: 40px">&nbsp;เพิ่ม</button></a>
            </div>
        </div>
        <center>
        <div class="card-body" style="width: 100%">    	
          <div class="table-responsive-">
          <table id="report_rawmaterial" class="table table-bordered table-striped table-sm">
    	
	<thead class="table-info">
   <tr height="19" style="height:14.25pt">
      <th rowspan="2" height="38" class="xl68" width="87" style="height:28.5pt;width:65pt" align="center"><br><b>วัน/เดือน/ปี</b></th>
      <th colspan="10" class="xl68" width="387" style="border-left:none;width:291pt" align="center"><b>การจัดการเก็บรายได้</b></th>
      <th rowspan="2" class="xl68" width="129" style="width:97pt" align="center"><br><b>บันทึก</b></th>
  </tr>
   <tr height="19" style="height:14.25pt">
      <th height="19" class="xl68" style="height:14.25pt;border-top:none;border-left:none" align="center"><b>สินค้า</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ชื่อร้านค้า</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>จำนวน</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>หน่วย</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ราคารวม(บาท)</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ราคารวม(ริงกิต)</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ยอดที่ชำระ(บาท)</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ยอดที่ชำระ(ริงกิต)</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ค้างชำระ(บาท)</b></th>
      <th class="xl68" style="border-top:none;border-left:none" align="center"><b>ค้างชำระ(ริงกิต)</b></th>
   </tr>
</thead>
<tbody>
 <tr height="19" style="height:14.25pt">
  <td align="center">1/11/60</td>
  <td align="">น้ำดื่ม</td>
  <td align="left">ร้านป้าชวน</td>
  <td align="right">10.00</td>
  <td align="center">กระสอบ</td>
  <td align="right">250.00</td>
  <td align="right">-</td>
  <td align="right">250.00</td>
  <td align="right">-</td>
  <td align="right">0.00</td>
  <td align="right">-</td>
  <td align="center">OK</td>
 </tr>
 <tr height="19" style="height:14.25pt">
  <td align="center">1/11/60</td>
  <td align="">น้ำดื่ม</td>
  <td align="left">ร้านป้าชวน</td>
  <td align="right">10.00</td>
  <td align="center">กระสอบ</td>
  <td align="right">250.00</td>
  <td align="right">-</td>
  <td align="right">250.00</td>
  <td align="right">-</td>
  <td align="right">0.00</td>
  <td align="right">-</td>
  <td align="center">OK</td>
 </tr>
</tbody>
<tbody class="table-success">
  
  <tr height="19" style="height:14.25pt">
   <td align="center"><b>รวม</b></td>
   <td><b></b></td>
   <td><b></b></td>
   <td align="right"><b>30.00</b></td>
   <td align="center"><b></b></td>
   <td align="right"><b>650.00</b></td>
   <td align="ready"><b>-</b></td>
   <td align="right"><b>650.00</b></td>
   <td align="right"><b>-</b></td>
   <td align="right"><b>0.00</b></td>
   <td align="right"><b>-</b></td>
   <td align="center"><b></b></td>
 </tr>

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
  $('.datecalendar').datepicker({
        format: 'dd/mm/yyyy'
    });
 </script>
 @endsection   