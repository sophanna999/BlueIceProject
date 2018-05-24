@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
@endsection

@section('body')
<div class="col-lg-12">
    <div class="card card-accent-primary">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> ตารางข้อมูลตรวจสอบและรับคืน
            <div class="pull-right">
                <a href="{{url('/Manufacture/VerifyAccrptProduct/CheckProduct')}}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> ตรวจรับงาน</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm datatable" id="ListAccountTypeMaster">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 15%;">เลขใบสั่งผลิต</th>
                        <th style="width: 10%; text-align: center;">รหัสงาน</th>
                        <th style="text-align: center;">ชื่อสินค้า</th>
                        <th style="width: 10%; text-align: center;">จำนวนผลิต</th>
                        <th style="width: 10%; text-align: center;">จำนวนเสียหาย</th>
                        <th style="text-align: center;">วันที่เริ่ม</th>
                        <th style="text-align: center;">สถานะงาน</th>
                        <th style="width:20%; text-align: center;">แก้ไข/ปริ้น</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="save" class="modal fade" role="dialog"> <!-- modal delete -->
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">บันทึกเรียบร้อย</h4></center>
            </div>
            <div class="modal-body">
                <center>
                    <button type="button" class="btn btn" data-dismiss="modal" style="width:90px; height: 40px">ตกลง</button>
                </center>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>

<div id="Delete" class="modal fade" role="dialog"> <!-- modal delete -->
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">คุณต้องการลบหรือไม่</h4></center>
            </div>
            <div class="modal-body">
                <center>
                    <button type="submit" class="btn btn-danger" data-dismiss="modal" style="width:90px; height: 40px">ลบ</button>
                    <button type="button" class="btn btn" data-dismiss="modal" style="width:90px; height: 40px">ยกเลิก</button>
                </center>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script>
var dataTableList = $('#ListAccountTypeMaster').dataTable({
  "focusInvalid": false,
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": url+"/Manufacture/VerifyAccrptProduct/list",
    "data": function ( d ) {
    }
  },
  "columns": [
    { "data": "bom_no" , "name":"bom_no" , "className": "text-center" },
    { "data": "task_no" , "name":"task_no" },
    { "data": "ProName" , "name":"ProName" },
    { "data": "amount" , "name":"amount" },
    { "data": "corrupt_amount" , "name":"corrupt_amount" },
    { "data": "pro_start" , "name":"pro_start" },
    { "data": "status" , "name":"status" },
    { "data": "action" , "name":"action" , "className": "text-center" ,"orderable": false, "searchable": false },
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
  "drawCallback": function( settings ) {
  }
});
$(document).ready(function () {
        $('.datatable').DataTable();
    });
    $("body").on('click', '.save', function () {
        var id = $(this).data('id');
//        alert(id);
        $("#" + id).modal('hide');
        $("#save").modal('show');
    });
    $("body").on('click', '.cloneaddress', function () {
        var id = $(this).data('id');
        $("#collapseExample3").clone().appendTo("#addressall");
    });
    $("body").on('click', '.clone2', function () {
        var id = $(this).data('id');
        $("#collapseExample2").clone().appendTo("#alladres");
    });
    $('body').on('click','.btn-delete',function() {
        var id = $(this).data('id');
        swal({
          title: 'คุณต้องการลบข้อมูลหรือไม่ ?',
          text: "หากต้องการลบ กดปุ่ม 'ยืนยัน'",
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ยืนยัน',
          cancelButtonText: 'ยกเลิก'
        }).then((result) => {
          if (result.value==true) {
            $.ajax({
              method : "GET",
              url : url+"/Manufacture/VerifyAccrptProduct/delete/"+id,
              dataType : 'json'
            }).done(function(rec){
              if(rec.type=='success'){
                swal({
                  confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                });
                dataTableList.api().ajax.reload();
              }else{
                swal(rec.title,rec.text,rec.type);
              }
            });
          }
        });
    });
</script>
@endsection
