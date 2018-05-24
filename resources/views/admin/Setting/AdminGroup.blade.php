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
                    <table class="table table-striped table-hover table-sm" id="ListAdminGroup">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">รหัสกลุ่ม</th>
                                <th class="text-center">ชื่อกลุ่ม</th>
                                <th class="text-center">รายละเอียด</th>
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
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- Start Body -->
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">ชื่อกลุ่ม</label>
                    <input name="name" class="form-control" placeholder="Group Name" value="" type="text">
                    <label class="control-label">รายละเอียด</label>
                    <input name="description" class="form-control" placeholder="Group Description" type="text">
                    <hr>
                    <!-- <div class="col-md-12">
                        <label class="control-label">การจัดการ <input type="hidden" name="crud_access" class="managevalue"></label>
                        <div style="max-height:250px; overflow-y:scroll; overflow-x:hidden;">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="manage[]" type="checkbox" value="1" onclick="checkmanage()">
                                    เพิ่มข้อมูล
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="manage[]" type="checkbox" value="2" onclick="checkmanage()">
                                    แก้ไขข้อมูล
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="manage[]" type="checkbox" value="3" onclick="checkmanage()">
                                    ลบข้อมูล
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr> -->
                    <div class="col-md-12">
                        <label class="control-label">สาขา <input type="hidden" name="branch_access" class="branchvalue"></label>
                        <div class="col-md-12" style="max-height:160px; overflow-y:scroll; overflow-x:hidden; border:solid 1px #ddd;">
                            <?php $i=0; ?>
                            @foreach($branchs as $branch)
                            <?php $i++; ?>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="access_branch[]" type="checkbox" value="{{$branch->BraID}}" onclick="checkbranch()">
                                    {{$i}} . {{$branch->BraName}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                <label class="control-label">เมนู <input type="hidden" class="menuvalue" name="menu_access"></label>
                    <?php $i=0; ?>
                    <div class="col-md-12" style="max-height:450px; overflow-y:scroll; overflow-x:hidden; border:solid 1px #ddd;">
                        @foreach($admin_menus as $menu)
                            @if($menu->main_menu_id==0)
                            <?php $i++; ?>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input head_{{$menu->id}}_" onclick="checkAll(document.getElementById('FormPrimary'),'menu_{{$menu->id}}_',this.checked);" type="checkbox" value="{{$menu->id}}" name="access_menu[]">
                                            {{$i}} . {{$menu->name}}
                                        </label>
                                    </div>
                                </div>
                                @foreach($admin_menus as $menuIn)
                                    @if($menu->id == $menuIn->main_menu_id && $menuIn->main_menu_id !== 0)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input menu_{{$menu->id}}_" type="checkbox" value="{{$menuIn->id}}" name="access_menu[]"
                                                    onclick="checkHead(document.getElementById('FormPrimary'),'menu_{{$menu->id}}_','head_{{$menu->id}}_',this.checked)">
                                                    {{($menuIn->sort_id)-1}} . {{$menuIn->name}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            <hr>
                            @endif
                        @endforeach
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

  <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-warning modal-lg" role="document" style="overflow-x:hidden;">
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
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label">ชื่อกลุ่ม</label>
                <input name="name" class="form-control" placeholder="Group Name" value="" type="text" id="name">
                <label class="control-label">รายละเอียด</label>
                <input name="description" class="form-control" placeholder="Group Description" type="text" id="description">
                <hr>
                <!-- <div class="col-md-12">
                    <label class="control-label">การจัดการ <input type="hidden" name="crud_access" class="managevalue"></label>
                    <div style="max-height:250px; overflow-y:scroll; overflow-x:hidden;">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="manage[]" type="checkbox" value="1" onclick="checkmanage()" id="m1">
                                เพิ่มข้อมูล
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="manage[]" type="checkbox" value="2" onclick="checkmanage()" id="m2">
                                แก้ไขข้อมูล
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="manage[]" type="checkbox" value="3" onclick="checkmanage()" id="m3">
                                ลบข้อมูล
                            </label>
                        </div>
                    </div>
                </div>
                <hr> -->
                <div class="col-md-12">
                    <label class="control-label">สาขา <input type="hidden" name="branch_access" class="branchvalue"></label>
                    <div class="col-md-12" style="max-height:160px; overflow-y:scroll; overflow-x:hidden; border:solid 1px #ddd;">
                        <?php $i=0; ?>
                        @foreach($branchs as $branch)
                        <?php $i++; ?>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="access_branch[]" type="checkbox" value="{{$branch->BraID}}" onclick="checkbranch()" id="b{{$branch->BraID}}">
                                {{$i}} . {{$branch->BraName}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
            <label class="control-label">เมนู <input type="hidden" class="menuvalue" name="menu_access"></label>
                <?php $i=0; ?>
                <div class="col-md-12" style="max-height:450px; overflow-y:scroll; overflow-x:hidden; border:solid 1px #ddd;">
                    @foreach($admin_menus as $menu)
                        @if($menu->main_menu_id==0)
                        <?php $i++; ?>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input head_{{$menu->id}}_" type="checkbox" value="{{$menu->id}}" name="access_menu[]" onclick="checkAll(document.getElementById('FormWarning'),'menu_{{$menu->id}}_',this.checked);" id="mn{{$menu->id}}">
                                        {{$i}} . {{$menu->name}}
                                    </label>
                                </div>
                            </div>
                            @foreach($admin_menus as $menuIn)
                                @if($menu->id == $menuIn->main_menu_id && $menuIn->main_menu_id !== 0)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input menu_{{$menu->id}}_" type="checkbox" value="{{$menuIn->id}}" name="access_menu[]"
                                                onclick="checkHead(document.getElementById('FormWarning'),'menu_{{$menu->id}}_','head_{{$menu->id}}_',this.checked)" id="mn{{$menuIn->id}}">
                                                {{($menuIn->sort_id)-1}} . {{$menuIn->name}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        <hr>
                        @endif
                    @endforeach
                </div>
            </div>
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
    var dataTableList = $('#ListAdminGroup').dataTable({
        "focusInvalid": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url+"/Setting/AdminGroup/listAdminGroup",
            "data": function ( d ) {
            }
        },
        "columns": [
            { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
            { "data": "id" , "name":"id" , "className": "text-center" },
            { "data": "name" , "name":"name" },
            { "data": "description" , "name":"description"},
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
        // console.log($('input[type="checkbox"][name*="access_branch"][value="{{session('BraID')}}"]'));
        $('input[type="checkbox"][name*="access_branch"][value="{{session('BraID')}}"]').prop({'checked':true});
        $( "#primaryModal" ).modal('show');
    });//end btn-add
    $('body').on('click', '.btn-edit', function(){
        document.getElementById("FormWarning").reset();
        var id = $(this).data('id');
        //alert(id);
        $.ajax({
            method : "GET",
            url : url+"/Setting/AdminGroup/"+id,
            dataType : 'json'
        }).done(function(rec){
            //menu_access
            if(rec.menu_access!==null){
                var mn = (rec.menu_access).split(",");
                for (i=0;i<mn.length;i++){
                    document.getElementById('mn'+mn[i]).checked=true;
                }
            }
            //branch_access
            if(rec.menu_access!==null){
                var b = (rec.branch_access).split(",");
                for (i=0;i<b.length;i++){
                    document.getElementById('b'+b[i]).checked=true;
                }
            }
            //crud_access
            // if(rec.menu_access!==null){
            //     var m = (rec.crud_access).split(",");
            //     for (i=0;i<m.length;i++){
            //         document.getElementById('m'+m[i]).checked=true;
            //     }
            // }
            $('#editid').val(rec.id);
            $('#name').val(rec.name);
            $('#description').val(rec.description);
            // $('.menuvalue').val(rec.menu_access);
            $('.managevalue').val(rec.crud_access);
            $('.branchvalue').val(rec.branch_access);
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
                    url : url+"/Setting/AdminGroup/delete/"+id,
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
            name: "required",
            description: {
                "required": true,
            }
        },
        messages: {
            name: "กรุณาระบุ",
            description: {
                "required":"กรุณาระบุ",
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
                url : url+"/Setting/AdminGroup",
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
            name: "required",
            description: {
                "required": true,
            }
        },
        messages: {
            name: "กรุณาระบุ",
            description: {
                "required":"กรุณาระบุ",
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
                url : url+"/Setting/AdminGroup/update",
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
<script type="text/javascript">
</script>
<script language="JavaScript">
/*
    $('.permission_menu').change(function(){
        var values = $('.permission_menu:checked').map(function(){
            return $(this).next('.permission_menu_value').val();
        }).get();
        $('#permission_menu').val(values.join(','));
    });
*/
    function getAccessMenu(name){
        var checkboxes = document.getElementsByName(name);
        var vals = "";
        for (var i=0, n=checkboxes.length;i<n;i++)
        {
            if (checkboxes[i].checked)
            {
                vals += ","+checkboxes[i].value;
            }
        }
        if (vals) vals = vals.substring(1);
        return vals;
    }
    function checkmanage(){
        $('.managevalue').val(getAccessMenu('manage[]'));
    }
    function checkbranch(){
        $('.branchvalue').val(getAccessMenu('access_branch[]'));
    }
    function checkAll(theForm,cName,status){
        for (i=0,n=theForm.elements.length;i<n;i++){
            if (theForm.elements[i].className.indexOf(cName)!=-1){
                theForm.elements[i].checked = status;
            }
        }
        $('.menuvalue').val(getAccessMenu('access_menu[]'));
    }
    function checkHead(theForm,cNameChild,cNameHead,status){
        var s=0;
        for (i=0,n=theForm.elements.length;i<n;i++){
            if (theForm.elements[i].checked==true){
                s++;
            }
        }
        for (i=0,n=theForm.elements.length;i<n;i++){
            if (theForm.elements[i].className.indexOf(cNameHead)!=-1 && s>0){
                theForm.elements[i].checked = true;
            }
            if(theForm.elements[i].className.indexOf(cNameHead)!=-1 && s==0){
                theForm.elements[i].checked = false;
            }
        }
    }
    $('input[name="access_menu[]"]').change(function(){
        $('.menuvalue').val(getAccessMenu('access_menu[]'));
    });
</script>
@endsection
