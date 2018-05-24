@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
@endsection

@section('body')
<div class="container-fluid">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{$title}}
        <button class="btn btn-primary btn-sm pull-right btn-add">
          <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover table-sm" id="ListCurrency">
            <thead>
              <tr>
                <th class="text-center">รหัสสกุลเงิน</th>
                <th class="text-center">สกุลเงิน</th>
                <th class="text-center">การกระทำ</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.conainer-fluid -->

<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-primary modal-md" role="document" style="overflow-x:hidden;">
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
      <form id="FormPrimary" method="post" class="form-horizontal" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- Start Body -->
        <div class="modal-body">
          <div class="form-group col-md-12">
            <label class="control-label">สกุลเงิน</label>
            <input name="currency_name" class="form-control" placeholder="Currency Name" value="" type="text">
          </div>
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

<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-warning modal-md" role="document" style="overflow-x:hidden;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{$title}}
          <i class="fa fa-angle-right" aria-hidden="true"></i>
          อัพเดทข้อมูล
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="FormWarning" method="post" class="form-horizontal" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id='editid' name="editid">
        <!-- Start Body -->
        <div class="modal-body">
          <div class="form-group col-md-12">
            <label class="control-label">สกุลเงิน</label>
            <input name="currency_name" id="currency_name" class="form-control" placeholder="Currency Name" type="text">
          </div>
        </div>
        <!-- End Body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          <button type="submit" class="btn btn-warning">บันทึก</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('jsbottom')
<!-- DataTables -->
<script>
var dataTableList = $('#ListCurrency').dataTable({
  "focusInvalid": false,
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": url+"/Setting/listCurrency",
    "data": function ( d ) {
    }
  },
  "columns": [
    { "data": "id" , "name":"id" , "className": "text-center" },
    { "data": "currency_name" , "name":"currency_name" },
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

$('body').on('click', '.btn-edit', function(){
  document.getElementById("FormWarning").reset();
  var id = $(this).data('id');
  //alert(id);
  $.ajax({
    method : "GET",
    url : url+"/Setting/Currency/"+id,
    dataType : 'json'
  }).done(function(rec){
    $('#editid').val(rec.id);
    $('#currency_name').val(rec.currency_name);
    $('#warningModal').modal('show');
  });
});//end btn-edit

$('body').on('click', '.btn-delete',function(){
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
        url : url+"/Setting/Currency/delete/"+id,
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
});//end btn-delete
</script>

<!-- Form -->
<script type="text/javascript">
$( "#FormPrimary" ).validate({
  rules: {
    currency_name: "required",
  },
  messages: {
    currency_name: "กรุณาระบุ",
  },
  errorElement: "span",
  errorPlacement: function ( error, element ) {
    // Add the `help-block` class to the error element
    error.addClass( "help-block" );
    if ( element.prop( "type" ) === "checkbox" ) {
      error.insertAfter( element.parent( "label" ) );
    } else {
      error.insertAfter( element );
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents('.form-group').addClass( "has-error" ).removeClass( "has-success" );
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents('.form-group').addClass( "has-success" ).removeClass( "has-error" );
  },
  submitHandler: function(form){
    var btn = $(form).find('[type="submit"]');
    $.ajax({
      method : "POST",
      url : url+"/Setting/Currency",
      dataType : 'json',
      data : $(form).serialize()
    }).done(function(rec){
      if(rec.type == 'success'){
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        });
        $('#primaryModal').modal('hide');
        dataTableList.api().ajax.reload();
        form.reset();
      }else{
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        });
      }
    });
  }
});

$( "#FormWarning" ).validate({
  rules: {
    currency_name: "required",
  },
  messages: {
    currency_name: "กรุณาระบุ",
  },
  errorElement: "span",
  errorPlacement: function ( error, element ) {
    // Add the `help-block` class to the error element
    error.addClass( "help-block" );
    if ( element.prop( "type" ) === "checkbox" ) {
      error.insertAfter( element.parent( "label" ) );
    } else {
      error.insertAfter( element );
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents('.form-group').addClass( "has-error" ).removeClass( "has-success" );
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents('.form-group').addClass( "has-success" ).removeClass( "has-error" );
  },
  submitHandler: function(form){
    var btn = $(form).find('[type="submit"]');
    $.ajax({
      method : "POST",
      url : url+"/Setting/Currency/update",
      dataType : 'json',
      data : $(form).serialize()
    }).done(function(rec){
      if(rec.type == 'success'){
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        });
        $('#warningModal').modal('hide');
        dataTableList.api().ajax.reload();
        form.reset();
      }else{
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        });
      }
    });
  }
});

</script>
@endsection
