@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link rel="stylesheet" href="{{asset('js/orakuploader/orakuploader.css')}}">
@endsection

@section('body')
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
      <form id="FormPrimary" method="post" class="form-horizontal">
      {{ csrf_field() }}
      <input type="hidden" name="ProID" value="{{$ProductBOM->ProID}}">
        <!-- Start Body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive" style="max-height:450px; overflow-y:scoll;">
                        <table class="table table-striped table-hover table-sm" id="listNewMaterial" style="width:100%">
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
<div class="modal fade" id="primaryModalUnit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
      <form id="FormPrimaryUnit" method="post" class="form-horizontal" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- Start Body -->
        <div class="modal-body">
          <div class="form-group col-md-12">
            <label class="control-label">ชื่อหน่วยนับ(ไทย)</label>
            <input name="name_th" class="form-control" placeholder="ชื่อหน่วยนับ(ไทย)" value="" type="text">
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">ชื่อหน่วยนับ(อังกฤษ)</label>
            <input name="name_en" class="form-control" placeholder="ชื่อหน่วยนับ(อังกฤษ)" value="" type="text">
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">ประเภทหน่วยนับ</label>
            <select name="unit_type" class="form-control">
              <option value="">เลือกประเภทหน่วยนับ</option>
              @foreach($UnitType as $UT)
                <option value="{{$UT->id}}">{{$UT->unitType_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">ปริมาณ</label>
            <input name="amount" class="form-control" placeholder="ปริมาณ" type="text">
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">สถานะ</label>
            <select name="status" class="form-control">
              <option value="T">แสดง</option>
              <option value="F">ไม่แสดง</option>
            </select>
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
<div class="container-fluid">
    <div class="col-md-12">
            <div class=" card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    <b class="text_head">{{$title}}</b>
                    <button class="btn btn-primary btn-sm pull-right btn-add">
                        <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
                    </button>
                </div>
                <form class="form-horizontal" role="form" id="FormWarning">
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label">รูปผลิตภัณฑ์</label>
                                        <div id="editphoto" orakuploader="on"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card-body" style="padding: 14px;">
                                    <div class="col-md-12">
                                        <div class="form-group row col-md-12">
                                            <label class="col-md-5"><b>รหัสสินค้า</b></label>
                                            <div class="col-md-7">
                                                <input name="ProID" class="form-control" value="{{$ProductBOM->ProID}}" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                            <label class="col-md-5"><b>ชื่อสินค้า</b></label>
                                            <div class="col-md-7">
                                                <input name="ProName" class="form-control" value="{{$ProductBOM->ProName}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group row col-md-12">
                                            <label class="col-md-5"><b>หน่วยนับ</b></label>
                                            <div class="col-md-5">
                                                <select name="ProUnit" id="ProUnit" class="form-control">
                                                    <option value="">เลือกหน่วยนับ</option>
                                                    @foreach($Units as $Unit)
                                                        <option value="{{$Unit->unit_id}}" {{$Unit->unit_id==$ProductBOM->ProUnit ? 'selected' : ''}}>{{$Unit->name_th}} {{$Unit->name_th ? '('.$Unit->amount.')' : ''}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary btn-sm pull-right btn-unit" type="button">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> หน่วยนับ
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row col-md-12">
                                            <label class="col-md-5"><b>ราคาขาย</b></label>
                                            <div class="col-md-7">
                                                <input name="ProPrice" class="form-control" value="{{$ProductBOM->ProPrice}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group row col-md-12">
                                            <label class="col-md-5"><b>จำนวนวันที่ผลิต</b></label>
                                            <div class="col-md-7">
                                                <input name="DateOfManufacture" class="form-control" value="{{$ProductBOM->DateOfManufacture}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                            <label class="col-md-5"><b>ประเภทหน่วยนับ</b></label>
                                            <div class="col-md-7">
                                                <select name="ProType" class="form-control">
                                                    <option value="">เลือกประเภทสินค้า</option>
                                                    <option value="1" {{($ProductBOM->ProType =="1") ? 'selected' : ''}}>น้ำ</option>
                                                    <option value="2" {{($ProductBOM->ProType =="2") ? 'selected' : ''}}>น้ำแข็ง</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row col-md-12"> <!-- status -->
                                            <div class="col-md-5">
                                                <b> สถานะ</b>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="exampleRadios" value="T" {{$ProductBOM->status=='T'?"checked":""}}>ใช้งาน
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="exampleRadios" value="F" {{$ProductBOM->status=='F'?"checked":""}}>ยกเลิกการใช้งาน
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" style="overflow-y:scoll;">
                                    <table class="table table-striped table-hover table-sm" id="listMaterial" style="width:100%;">
                                    <col width="10%">
                                    <col width="10%">
                                    <col width="40%">
                                    <col width="20%">
                                    <col width="10%">
                                    <col width="10%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">รหัสวัสดุ</th>
                                            <th class="text-center">ชื่อวัสดุ</th>
                                            <th class="text-center">หน่วยนับ</th>
                                            <th class="text-center">จำนวน</th>
                                            <th class="text-center">การกระทำ</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="text-right card-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button> -->
                        <button type="submit" class="addData btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection

@section('jsbottom')
<!-- orakuploader -->
<script src="{{asset('js/orakuploader/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/orakuploader/orakuploader.js')}}"></script>
<script>
editphoto("{{$ProductBOM->ProImg}}");
//editphoto("1514181516_screen_shot_2560-12-17_at_20.31.58.png");

function editphoto(path)
{
    $('#editphoto').parent().html('<div id="editphoto" orakuploader="on"></div>');
    if(path!==""){
        $('#editphoto').orakuploader({
            orakuploader_path         : url+'/',
            orakuploader_ckeditor         : true,
            orakuploader_use_dragndrop            : true,
            orakuploader_use_sortable   : true,
            orakuploader_main_path : 'uploads/temp/',
            orakuploader_thumbnail_path : 'uploads/temp/',
            orakuploader_thumbnail_real_path : asset+'uploads/temp/',
            orakuploader_loader_image       : asset+'images/loader.gif',
            orakuploader_no_image       : asset+'images/no-image.jpg',
            orakuploader_add_label       : 'เลือกรูปภาพ',
            orakuploader_use_rotation: true,
            orakuploader_hide_on_exceed : true,
            orakuploader_maximum_uploads : 0,
            orakuploader_attach_images: [path],
        });
    }else{
        $('#editphoto').orakuploader({
            orakuploader_path         : url+'/',
            orakuploader_ckeditor         : true,
            orakuploader_use_dragndrop            : true,
            orakuploader_use_sortable   : true,
            orakuploader_main_path : 'uploads/temp/',
            orakuploader_thumbnail_path : 'uploads/temp/',
            orakuploader_thumbnail_real_path : asset+'uploads/temp/',
            orakuploader_loader_image       : asset+'images/loader.gif',
            orakuploader_no_image       : asset+'images/no-image.jpg',
            orakuploader_add_label       : 'เลือกรูปภาพ',
            orakuploader_use_rotation: true,
            orakuploader_hide_on_exceed : true,
            orakuploader_maximum_uploads : 1,
        });
    }
}
</script>

<!-- DataTables -->
<script>
var infoNew = "";
var dataTableListNew = $('#listNewMaterial').dataTable({
    "pageLength": 10,
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": url+"/Manufacture/Datatable/listMaterialNotInBOM/{{base64_encode($ProductBOM->ProID)}}",
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
        infoNew = dataTableListNew.api().page.info();
    },
    initComplete: function() {
    }
});


var info="";
var dataTableList = $('#listMaterial').dataTable({
    "pageLength": 10,
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": url+"/Manufacture/Datatable/listMaterialDatail/{{base64_encode($ProductBOM->ProID)}}",
        "data": function (d) {
        }
    },
    "columns": [
        //{data: 'checkbox', name: 'checkbox',orderable: false, searchable: false , "className": "text-center" },
        { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
        { "data": "MatCode" , "name":"MatCode"},
        { "data": "MatDescription" , "name":"MatDescription" },
        { "data": "Unit" , "name":"Unit" },
        { "data": "Quantity" , "name":"Quantity" },
        { "data": "action" , "name":"action" , "orderable": false , "searchable": false , "className": "text-center"},
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
         info = dataTableList.api().page.info();
    },
    initComplete: function() {
    }
});
</script>

<!-- Button -->
<script>
    $('body').on('click', '.btn-unit',function(){
      document.getElementById("FormPrimaryUnit").reset();
      $( "#primaryModalUnit" ).modal('show');
    });//end btn-add
    $('body').on('click', '.btn-add',function(){
        document.getElementById("FormPrimary").reset();
        dataTableListNew.api().ajax.reload();
        $( "#primaryModal" ).modal('show');
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
        var Mat = $(this).data('mat');
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
                    url : url+"/Manufacture/BOM/detail/delete/{{base64_encode($ProductBOM->ProID)}}/"+id+"/"+Mat,
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
$( "#FormPrimaryUnit" ).validate({
  rules: {
    name_th: "required",
  },
  messages: {
    name_th: "กรุณาระบุ",
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
      url : url+"/Setting/Unit",
      dataType : 'json',
      data : $(form).serialize()
    }).done(function(rec){
      if(rec.type == 'success'){
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        });
        $('#primaryModalUnit').modal('hide');
        // console.log($(form).serializeArray());
        var unit = "";
        var amount = "";
        $.each($(form).serializeArray(), function( i, field) {
            if(i==1) {
                unit = field.value;
            }
            if(i==4) {
                amount = field.value;
            }
        });
        var text = '<option value='+rec.id+'>'+unit+' ('+amount+')</option>';
        $('select#ProUnit').find('option:first').after(text);
        form.reset();
      }else{
        swal({
          confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
        });
      }
    });
  }
});
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
            url : url+"/Manufacture/BOM/detail/insertNewBOM",
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
            ProName: "required",
            ProUnit: "required",
            ProPrice: {
              required: true,
              number: true
            },
            DateOfManufacture: {
              required: true,
              number: true
            }
        },
        messages: {
            ProName: "กรุณาระบุ",
            ProPrice: "กรุณาระบุ",
            ProUnit: "กรุณาระบุ",
            DateOfManufacture: "กรุณาระบุ",
            ProPrice: {
              required: "กรุณาระบุ",
              number: 'กรอกตัวเลขเท่านั้น'
            },
            DateOfManufacture: {
              required: "กรุณาระบุ",
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
                url : url+"/Manufacture/BOM/detail/update",
                dataType : 'json',
                data : $(form).serialize()
            }).done(function(rec){
                if(rec.type == 'success'){
                    swal({
                        confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                    });
                    // window.location('{{Request::url()}}');
                    //$('#warningModal').modal('hide');
                    dataTableList.api().ajax.reload();
                    form.reset();
                    window.location.replace(url+"/Manufacture/BOM");
                }else{
                    swal({
                        confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                    });
                }
            });
        }
    });
</script>
<script>
    $('.addData').click(function() {
        $.each($('tbody').find('input[name*="BomQuantity"]'),function(k,v) {
            $(this).closest('tr').find('input[name*="BomQuantity"]').rules('add',{
                number: true,
                required: true,
                messages: {
                    number: "ตัวเลขเท่านั้น",
                    required: "กรุณาระบุ",
                }
            });
        });
        $( "#FormWarning" ).submit();
    });
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
@endsection
