@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link rel="stylesheet" href="{{asset('js/orakuploader/orakuploader.css')}}">
<style>
  .container {
      position: relative;
      width: 50%;
  }
  a.BOM {
    background-color: #E4F5F8;
    border: 1px solid #C0DEED;
    text-decoration: none !important;
    }
  .image {
    opacity: 1;
    display: block;
    width: 100%;
    height: 250px;
    transition: .5s ease;
    backface-visibility: hidden;
  }

  .middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%)
  }

  .container .image {
    opacity: 0.3;
  }

  .container .middle {
    opacity: 1;
  }

  .text {
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    padding: 16px 32px;
  }
</style>
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
          <div class="col-12">

          <div class="ajax_BOM">
            @include('admin.Manufacture.ajax_bom')
          </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.conainer-fluid -->
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
      <form id="FormPrimary" method="post" class="form-horizontal" action="">
      {{ csrf_field() }}
        <!-- Start Body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">

                  <div class="form-group row">
                    <label class="col-md-4 control-label">รหัสสินค้า</label>
                    <div class="col-md-8">
                      <input name="ProID" id="ProID" class="form-control form-control-sm" placeholder="รหัสสินค้า" type="text">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 control-label">ชื่อสินค้า</label>
                    <div class="col-md-8">
                      <input name="ProName" class="form-control form-control-sm" placeholder="ชื่อสินค้า" value="" type="text">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 control-label">จำนวนวันที่ผลิต</label>
                    <div class="col-md-8">
                      <input name="DateOfManufacture" class="form-control form-control-sm" placeholder="วัน" value="" type="text">
                    </div>
                  </div>
                  <input name="PushAndSplice" id="PushAndSplice" class="form-control" type="hidden">
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">รูปผลิตภัณฑ์</label>
                    <div id="photo" orakuploader="on"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive" style="max-height:300px; overflow-y:scoll;">
                        <table class="table table-striped table-hover table-sm" id="listMaterial" style="width:100%;">
                            <thead>
                              <tr>
                                  <th class="text-center">เลือก</th>
                                  <th class="text-center">ลำดับ</th>
                                  <th class="text-center">รหัสวัสดุ</th>
                                  <th class="text-center">ชื่อวัสดุ</th>
                              </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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

<img src="" alt="" srcset="">
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
      <form id="FormWarning" class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="editid" id="editid">
        <div class="modal-body">
          <div class="form-group col-md-12">
            <label class="control-label">ชื่อหน่วยนับ(ไทย)</label>
            <input name="name_th" id="name_th" class="form-control" placeholder="ชื่อหน่วยนับ(ไทย)" value="" type="text">
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">ชื่อหน่วยนับ(อังกฤษ)</label>
            <input name="name_en" id="name_en" class="form-control" placeholder="ชื่อหน่วยนับ(อังกฤษ)" value="" type="text">
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">ปรเภทหน่วยนับ</label>
            <select name="unit_type" id="unit_type" class="form-control" type="text">
              <option value="">เลือกประเภทหน่วยนับ</option>
              <option value="1">ผลิตภัณฑ์</option>
              <option value="2">บรรจุภัณฑ์</option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">สถานะ</label>
            <select name="status" id="status" class="form-control" type="text">
              <option value="T">แสดง</option>
              <option value="F">ไม่แสดง</option>
            </select>
          </div>
        </div>
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
<!-- orakuploader -->
<script src="{{asset('js/orakuploader/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/orakuploader/orakuploader.js')}}"></script>
<script>
function photo(){
  $('#photo').parent().html('<div id="photo" orakuploader="on"></div>');
  $('#photo').orakuploader({
      orakuploader_path         : url+'/',
      orakuploader_ckeditor         : true,
      orakuploader_use_dragndrop            : true,
      orakuploader_use_sortable   : false,
      orakuploader_main_path : 'uploads/temp/',
      orakuploader_thumbnail_path : 'uploads/temp/',
      orakuploader_thumbnail_real_path : asset+'uploads/temp/',
      orakuploader_loader_image       : asset+'images/loader.gif',
      orakuploader_no_image       : asset+'images/no-image.jpg',
      orakuploader_add_label       : 'เลือกรูปภาพ',
      orakuploader_use_rotation: true,
      orakuploader_maximum_uploads : 1,
      orakuploader_hide_on_exceed : true,
  });
}
</script>


<!-- DataTables -->
<script>
var info="";
var dataTableList = $('#listMaterial').dataTable({
    "pageLength": 5,
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": url+"/Manufacture/Datatable/listMaterial",
        "data": function (d) {
        }
    },
    "columns": [
        {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false , "className": "text-center" },
        { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
        { "data": "MatCode" , "name":"MatCode"},
        { "data": "MatDescription" , "name":"MatDescription" },
        //{ "data": "MatUnit" , "name":"MatUnit" },
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
        //alert('a');
        putvalue();
        info = dataTableList.api().page.info();
    },
    initComplete: function() {
        //alert('a');
        putvalue();
    }
});
</script>

<!-- Button -->
<script>
  $('body').on('click', '.btn-add',function(){

    document.getElementById("FormPrimary").reset();
    CountCheck=[];
    photo();

    $.ajax({url: url+"/FunctionPrefix/Branch/BOM/5/BOM", success: function(result){
        $("#ProID").val(result);
        $("#primaryModal").modal('show');
    }});

  });//end btn-add
  $('body').on('click', '.btn-edit', function(){
    document.getElementById("FormWarning").reset();
    var id = $(this).data('id');
    //alert(id);
    $.ajax({
      method : "GET",
      url : url+"/Setting/Unit/"+id,
      dataType : 'json'
    }).done(function(rec){
      $('#name_th').val(rec.name_th);
      $('#name_en').val(rec.name_en);
      $('#unit_type').val(rec.unit_type);
      $('#editid').val(rec.unit_id);
      $('#status').val(rec.status);
      $('#warningModal').modal('show');
    });
  });//end btn-edit
  $('body').on('click', '.btn-delete',function(){
    var id = $(this).data('id');
    //alert(id);
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
          url : url+"/Manufacture/BOM/detail/delete/"+id,
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
      ProName: "required",
      DateOfManufacture: {
        //required: true,
        number: true
      }
    },
    messages: {
      ProName: "กรุณาระบุ",
      DateOfManufacture: {
        //required: true,
        number: 'กรอกตัวเลขเท่านั้น'
      }
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
        url : url+"/Manufacture/BOM",
        dataType : 'json',
        data : $(form).serialize()
      }).done(function(rec){
        if(rec.type == 'success'){
          //ajax
          ajax_bom();
          swal({
            confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
          });
          $('#primaryModal').modal('hide');
          dataTableList.api().ajax.reload();
          form.reset();
          location.reload();
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
      department_name: "required",
      department_id: {
        "maxlength": 10,
      }
    },
    messages: {
      department_name: "กรุณาระบุ",
      department_id: {
        "maxlength":"ไม่เกิน 10 ตัวอักษร",
      }
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
        url : url+"/Setting/Unit/update",
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

<!-- START CHOOSE -->
<script>
  var CountCheck = new Array();
  function choose(form,input,value,status,save){
      if(status==true){
        CountCheck.push(value);
        $('#PushAndSplice').val(CountCheck);
      }
      if(status==false){
        CountCheck.splice(CountCheck.indexOf(value));
        $('#PushAndSplice').val(CountCheck);
      }
  }
  function putvalue(){
      var theValue = document.getElementById('PushAndSplice').value;
      var strFor = theValue.split(',');
      if(theValue!==""){
        for (i=0;i<strFor.length;i++){
          if(document.getElementById('select_order_'+strFor[i]+'_')!==null){
            document.getElementById('select_order_'+strFor[i]+'_').checked=true;
          }
        }
      }
  }
</script>
<!-- END CHOOSE -->
<!-- AJAX Product BOM -->
<script>
  function ajax_bom(){
    $.ajax({
      url : url + '/Manufacture/ajax/BOM'
    }).done(function (data){
      $('.ajax_BOM').html(data);
      //location.hash = page;
    });
  }
</script>
<!-- END AJAX Product BOM -->
@endsection
