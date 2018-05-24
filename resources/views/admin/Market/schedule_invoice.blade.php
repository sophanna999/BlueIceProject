@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<title>{{$title}} | BlueIce</title>
@endsection

@section('body')
<div class="col-lg-12">
  <div class="card">
    <div class="card-header" style="width: 100%">
      <i class="fa fa-align-justify"></i><strong>ตารางการออก INVOICE</strong>
      <div class="row pull-center">
        <div class="col-sm-4" style="width: 100%"></div>
        <form id="SearchDate" class="form-inline">
          {{csrf_field()}}
          <br>
          <div class="form-group date">
            <label for="datedoc"></label>
            <input type="text" id="fromDate" name="fromDate" class="form-control datecalendar" placeholder="dd/mm/yyyy">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>
          <div class="form-group date">
            <label for="datedoc">&nbsp; ถึง &nbsp;</label>
            <input type="text" id="toDate" name="toDate" class="form-control datecalendar" placeholder="dd/mm/yyyy">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" style="margin-top:-1px">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>
          <div class="form-group">
            <!-- <button type="button" class="btn btn-primary btn-lg" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order">Search</button> -->
            <button type="submit" class="btn btn-warning" style="margin-top: 0px;">Search</button>
          </div>
        </form>
      </div>
      <div class="pull-right" style="margin-top:-35px;">
        <a href="{{url('Market/Invoice')}}"><button type="button" class="btn btn-info btn-lg fa fa-plus" style="width:90px; height: 40px"> เพิ่ม</button>
        </a></div>
      </div>
      <center>
        <div class="card-body" style="width: 100%">

          <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped table-sm TableListInvoice">

              <thead class="table-info">
                <tr height="19" style="height:14.25pt">
                  <th rowspan="2" height="38" class="xl65" width="91" style="height:28.5pt;width:68pt" align="center"><br><b>วันที่</b></th>
                  <th colspan="9" class="xl66" width="615" style="border-left:none;width:461pt" align="center"><b>ตารางการออก INVOICE</b><span style="mso-spacerun:yes">&nbsp;</span></th>
                  <th rowspan="2" class="xl65" width="118" style="vertical-align:middle;width:89pt" align="center"><br><b>บันทึก</b></th>
                </tr>
                <tr height="19" style="height:14.25pt">
                  <th height="19" class="xl65" style="height:14.25pt;border-top:none;border-left:none" align="center"><b>เลขที่ INVOICE</b></th>
                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>ชื่อลูกค้า</b></th>
                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>จำนวนเงิน<br>บาท</b></th>
                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>จำนวนเงิน<br>(ริงกิต)</b></th>
                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>ชำระแล้ว<br>(บาท)</b></th>

                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>ชำระแล้ว<br>(ริงกิต)</b></th>
                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>เครดิต</b></th>
                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>ค้างชำระ<br>(บาท)</b></th>
                  <th class="xl65" style="border-top:none;border-left:none" align="center"><b>ค้างชำระ<br>(ริงกิต)</b></th>
                </tr>
              </thead>
              <tbody class="TableListInvoice_body">
                  <!-- <tr height="19" style="height:14.25pt">
                    <td align="center"><b>รวม</b></td>
                    <td></td>
                    <td></td>
                    <td align="right"><b>3,000.00</b></td>
                    <td align="right"><b></b></td>
                    <td align="right"><b>2,100.00</b></td>
                    <td align="right"><b></b></td>
                    <td align="right"></td>
                    <td align="right"><b>300.00</b></td>
                    <td align="right"></td>
                    <td align="right"><b></b></td>
                  </tr> -->
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
      <!-- DataTables -->
      <script>
var TableListInvoice = $('.TableListInvoice').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url + "/Market/Invoice/listCusInvoice",
      "data": function (d) {
      }
},
"columns": [
  {"data": "InvDate","name": "InvDate", "className": "text-center"},
  {"data": "InvID", "name": "InvID", "className": "text-center"},
  {"data": "CusNO", "name": "CusNO", "className": "text-center"},
  {"data": "SubToTal", "name": "SubToTal", "className": "text-center"},
  {"data": "SubToTal", "name": "SubToTal", "className": "text-center"},
  {"data": "Pay", "name": "Pay", "className": "text-center"},
  {"data": "Pay", "name": "Pay", "className": "text-center"},
  {"data": "Pay", "name": "Pay", "className": "text-center"},
  {"data": "Accured", "name": "Accured", "className": "text-center"},
  {"data": "Accured", "name": "Accured", "className": "text-center"},
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
  }
});

$('.datecalendar').daterangepicker({
  singleDatePicker: true,
  locale: {
    format: 'YYYY-MM-DD'
  }
});

$('document').ready(function(){
  $('#example').DataTable();
});

$('body').on('click', '.btn-add',function(){
  $( "#primaryModal" ).modal('show');
  });//end btn-add

// $('body').on('submit','#SearchDate', function(e){
//   e.preventDefault();
//   var fromDate = $('#fromDate').val();
//   var toDate   = $('#toDate').val();
//   $.ajax({
//     method: "GET",
//     url: url + "/Market/ScheduleInvoice/GetDate/"+fromDate+"/"+toDate,
//     dataType: "json"
//   }).done(function (rec) {
//     $('.TableListInvoice_body').empty();
//     $.each(rec, function(k,v) {
//       $('.TableListInvoice_body').append('<tr>'+
//           '<td>'+v.InvDate+'</td>'+
//           '<td>'+v.CusInv+'</td>'+
//           '<td>'+v.CusName+'</td>'+
//           '<td>'+v.SubToTal+'</td>'+
//           '<td>'+v.SubToTal+'</td>'+
//           '<td>'+v.Pay+'</td>'+
//           '<td>'+v.Pay+'</td>'+
//           '<td>'+v.Pay+'</td>'+
//           '<td>'+v.Accured+'</td>'+
//           '<td>'+v.Accured+'</td>'+
//           '<td><a href='+url+'/Market/ScheduleInvoice/Edit/'+v.InvID+' class="btn  btn-warning btn-sm btn-edit" data-id="" style="color:white;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข </a></td>'+
//         '</tr>');
//     });
//   });
// });
$('body').on('submit','#SearchDate', function(e){
  e.preventDefault();
  var fromDate = $('#fromDate').val();
  var toDate   = $('#toDate').val();
  $.ajax({
    method: "POST",
    url: url + "/Market/ScheduleInvoice/GetDate",
    dataType: "json",
    data: $(this).serialize()
  }).done(function (rec) {
    $('.TableListInvoice_body').empty();
    $.each(rec, function(k,v) {
      $('.TableListInvoice_body').append('<tr>'+
          '<td>'+v.InvDate+'</td>'+
          '<td>'+v.CusInv+'</td>'+
          '<td>'+v.CusName+'</td>'+
          '<td>'+v.SubToTal+'</td>'+
          '<td>'+v.SubToTal+'</td>'+
          '<td>'+v.Pay+'</td>'+
          '<td>'+v.Pay+'</td>'+
          '<td>'+v.Pay+'</td>'+
          '<td>'+v.Accured+'</td>'+
          '<td>'+v.Accured+'</td>'+
          '<td  class="text-center"><a href='+url+'/Market/ScheduleInvoice/Edit/'+v.InvID+' class="btn  btn-warning btn-sm btn-edit" data-id="" style="color:white;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข </a></td>'+
        '</tr>');
    });
  });
});

$('body').on('click','.btn-print', function(e){
    e.preventDefault();
    // console.log($(this).data('id'));
    window.location.href = url+"/Market/ScheduleInvoice/PrintScheduleInvoice/"+$(this).data('id');
});


</script>
@endsection
