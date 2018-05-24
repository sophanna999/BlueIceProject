@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
@endsection

@section('body')
<div class="col-lg-12">
  <div class="card card-accent-primary">
    <div class="card-header">
      <i class="fa fa-align-justify"></i> ตารางข้อมูลใบสั่งผลิต
      <div class="pull-right">
        <a href="#" class="btn btn-primary btn-sm pull-right btn-add" >
          <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
        </a>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped table-sm datatable" id="List">
        <thead>
          <tr>
            <th>ลำดับ</th>
            <th style="width: 15%; text-align: center;">เลขที่ใบสั่งผลิต</th>
            <th style="width: 15%; text-align: center;">แผนก</th>
            <th style="text-align: center;">วันที่เริ่ม</th>
            <th style="text-align: center;">วันที่สิ้นสุด</th>
            <th style="width: 25%; text-align: center;">การกระทำ</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-primary modal-lg" role="document" style="overflow-x:hidden;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{$title}}
          <i class="fa fa-angle-right" aria-hidden="true"></i>
          เพิ่มข้อมูล
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="FormPrimary" method="post" class="form-horizontal" action="{{url('/Manufacture/ProductOrdering/Order')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- Start Body -->
        <div class="modal-body">
          <div id="table">
            <table class="datatable table table-bordered table-striped table-sm">
              <thead>
                <th style="text-align: center; width:50%;">รหัสสินค้า</th>
                <th style="text-align: center;">ชื่อสินค้า</th>
                <th style="text-align: center; width:20%;">เลือก</th>
              </thead>
              <tbody>
                 @foreach($bom as $val)
                 <tr>
                   <td>{{$val->ProID}}</td>
                   <td>{{$val->ProName}}</td>
                   <td><center><input value="{{$val->ProID}}" type="checkbox" name="ProID[]" /></center></td>
                 </tr>
                 @endforeach
              </tbody>
            </table>
          </div>
          <!-- End Body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-primary">บันทึก</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
  <!-- ./modal add -->
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
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-primary modal-lg" role="document" style="overflow-x:hidden;">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">{{$title}}
                      <i class="fa fa-angle-right" aria-hidden="true"></i> ดูรายละเอียด
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                          <table class="table table-striped table-hover table-sm">
                              <thead>
                                  <tr>
                                      <th class="text-center">ลำดับ</th>
                                      <th class="text-center">เลขที่ใบสั่งผลิต</th>
                                      <th class="text-center">รหัสงาน</th>
                                      <th class="text-center">สินค้า</th>
                                      <!-- <th class="text-center">ผลิต(ขวด)</th> -->
                                      <th class="text-center">หน่วยผลิต</th>
                                      <th class="text-center">ไลน์ผลิต</th>
                                  </tr>
                              </thead>
                              <tbody id='DetailList'>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
              </div>
          </div>
      </div>
  </div>
  @endsection

  @section('jsbottom')
  <script src="{{asset('js/daterangepicker/moment.js')}}"></script>
  <script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
  <script>
  var dataTableList = $('#List').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url+"/Manufacture/ProductOrdering/list",
      "data": function ( d ) {
        // d.MatNoDoc = $('#num_doc').val();
      }
    },
    "columns": [
      { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
      { "data": "bom_no" , "name":"bom_no"},
      { "data": "department_id" , "name":"department_id"},
      { "data": "bom_date_start" , "name":"bom_date_start" },
      { "data": "bom_date_end" , "name":"bom_date_end" , "className": "text-center" },
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

  $('body').on('click', '.btn-add',function(){
    document.getElementById("FormPrimary").reset();

    $( "#primaryModal" ).modal('show');
  });//end btn-add

  $("body").on('click', '.save', function () {
    var id = $(this).data('id');
    //        alert(id);
    $("#" + id).modal('hide');
    $("#save").modal('show');
  });

  $('body').on('click', '.btn-delete',function(){
      var id = $(this).data('id');
      swal({
          title:'คุณต้องการลบข้อมูลหรือไม่ ?',
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
                  method : "POST",
                  url : url+"/Manufacture/ProductOrdering/delete",
                  dataType : 'json',
                  data : {id:id}
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

  $("body").on('click', '.cloneaddress', function () {
    var id = $(this).data('id');
    $("#collapseExample3").clone().appendTo("#addressall");
  });

  $("body").on('click', '.clone2', function () {
    var id = $(this).data('id');
    $("#collapseExample2").clone().appendTo("#alladres");
  });

  $('body').on('click', '.btn-detail', function(){
      var id = $(this).data('id');
      // $('#detailModal').modal('show');
      $.ajax({
          method : "POST",
          url : url+"/Manufacture/ProductOrdering/show",
          dataType : 'json',
          data : {id:id}
      }).done(function(rec){
          $('#DetailList').empty();
          $.each( rec, function( key, value ) {
              $('#DetailList').append(
                  '<tr class="text-center">\
                      <td>'+(key+1)+'</td>\
                      <td>'+value.bom_no+'</td>\
                      <td>'+value.task_no+'</td>\
                      <td>'+value.ProName+'</td>\
                      <!--<td>'+value.amount+'</td>-->\
                      <td>'+value.package_amount+'</td>\
                      <td>'+value.MachName+'</td>\
                  </tr>'
                  );
              // $("#DetailList").append(html);
          });
          $('#detailModal').modal('show');
      });
  });
  </script>
  @endsection
