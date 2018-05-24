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
                <table class="table table-striped table-hover table-sm" id="ListRefType">
                <thead>
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th class="text-center">รหัสประเภทเอกสาร</th>
                        <th class="text-center">ชื่อประเภทเอกสาร</th>
                        <th class="text-center">คำอธิบาย</th>
                        <th class="text-center">รูปแบบ</th>
                        <th class="text-center">วันที่เพิ่ม</th>
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
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">ชื่อ</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="ref_name" placeholder="ชื่อ">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">คำอธิบาย</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="ref_description" placeholder="คำอธิบาย">
                </div>
            </div>
            <hr>
            <?php
                $Names = array("PURCHASE ORDER", "INVOICE", "BOM","ใบเบิกวัสดุ", "ใบคืนวัสดุ", "ใบเปิดสินค้า","ใบรับวัสดุ","ใบสั่งสินค้า","ใบรับสินค้า");
                $format = array('Ym','ym','YM','yM','Y-m','y-m','Y-M','y-M','Y/m','y/m','Y/M','y/M');
            ?>
            @foreach($Names as $k => $Name)
            <div class="form-group row detail">
                <label for="inputPassword" class="col-sm-3 col-form-label">{{$Name}}</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="ref_format[{{$k}}]" placeholder="คำนำหน้าหรือตัวย่อ">
                </div>
                <div class="col-sm-5">
                    <select name="ref_ym_format[{{$k}}]" class="form-control">
                        <option value="">เลือกรูปแบบปีเดือน</option>
                        @foreach($format as $fm)
                        <option value="{{$fm}}">{{$fm}} ( {{date($fm)}} )</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endforeach
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
        <input type="hidden" name="ref_id" id="ref_id">
        <!-- Start Body -->
        <div class="modal-body">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">ชื่อ</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="ref_name" name="ref_name" placeholder="ชื่อ">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">คำอธิบาย</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="ref_description" name="ref_description" placeholder="คำอธิบาย">
                </div>
            </div>
            <hr>
            <?php
                $Names = array("PURCHASE ORDER", "INVOICE", "BOM","ใบเบิกวัสดุ", "ใบคืนวัสดุ", "ใบเปิดสินค้า","ใบรับวัสดุ","ใบสั่งสินค้า","ใบรับสินค้า");
                $fcount = 0;
            ?>
            @foreach($Names as $k => $Name)
            <div class="form-group row detail">
                <label for="inputPassword" class="col-sm-3 col-form-label">{{$Name}}</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control format_{{$fcount}}_" name="ref_format[{{$k}}]" placeholder="คำนำหน้าหรือตัวย่อ">
                </div>
                <div class="col-sm-5">
                    <select name="ref_ym_format[{{$k}}]" class="form-control format_ym_{{$fcount}}_">
                        <option value="">เลือกรูปแบบปีเดือน</option>
                        @foreach($format as $fm)
                        <option value="{{$fm}}">{{$fm}} ( {{date($fm)}} )</option>
                        @endforeach
                    </select>
                </div>
                <?php $fcount++; ?>
            </div>
            @endforeach
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
    var dataTableList = $('#ListRefType').dataTable({
      "focusInvalid": false,
      "processing": true,
      "serverSide": true,
      "ajax": {
          "url": url+"/Setting/Datatable/listRefType",
          "data": function ( d ) {
          }
      },
      "columns": [
            { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
            { "data": "ref_id" , "name":"ref_id" },
            { "data": "ref_name" , "name":"ref_name" },
            { "data": "ref_description" , "name":"ref_description", "className": "text-center" },
            { "data": "ref_format" , "name":"ref_format", "className": "text-center" },
            { "data": "created_at" , "name":"created_at", "className": "text-center" },
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
</script>

<!-- Button -->
<script>
    $('body').on('click', '.btn-add',function(){
        $('body').find('span.error').closest('span').remove();
        $("#primaryModal").find('.has-error').removeClass('has-error');
        $("#primaryModal").find('.has-success').removeClass('has-success');
        document.getElementById("FormPrimary").reset();
        $( "#primaryModal" ).modal('show');
    });//end btn-add

    $('body').on('click', '.btn-edit', function(){
        $('body').find('span.error').closest('span').remove();
        $("#warningModal").find('.has-error').removeClass('has-error');
        $("#warningModal").find('.has-success').removeClass('has-success');
        document.getElementById("FormWarning").reset();
        var id = $(this).data('id');
        //alert(id);
        $.ajax({
            method : "GET",
            url : url+"/Setting/RefType/"+id,
            dataType : 'json'
        }).done(function(rec){
            if(rec.ref_format){
                var fm = (rec.ref_format).split(",");
            }
            if(rec.ref_ym_format){
                var fmym = (rec.ref_ym_format).split(",");
            }
            for (i=0;i<fm.length;i++){
                if(rec.ref_format){
                    $('.format_'+i+'_').val(fm[i]);
                }
                if(rec.ref_ym_format){
                    $('.format_ym_'+i+'_').val(fmym[i]);
                }
            }

            $('#ref_id').val(rec.ref_id);
            $('#ref_name').val(rec.ref_name);
            $('#ref_description').val(rec.ref_description);
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
                    method : "get",
                    url : url+"/Setting/RefType/delete/"+id,
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
            ref_name: "required",
        },
        messages: {
            ref_name: "กรุณาระบุ",
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
                url : url+"/Setting/RefType",
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
            ref_name: "required",
        },
        messages: {
            ref_name: "กรุณาระบุ",
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
                url : url+"/Setting/RefType/update",
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
    $('body').on('click','button[type="submit"]',function() {
        $.each($(this).closest('form').find('.detail'),function(){
            $(this).find('input').rules("add",{
                required:true,
                messages: {
                    required: "กรุณาระบุ",
                }
            });
            $(this).find('select').rules("add",{
                required:true,
                messages: {
                    required: "กรุณาเลือก",
                }
            });
        });
    });
    $('#primaryModal').is(':visible',function(){
        alert('a');
    });
</script>
@endsection
