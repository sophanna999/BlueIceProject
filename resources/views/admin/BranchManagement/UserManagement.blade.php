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
                  <table class="table table-border table-striped" id="UserManagement">
                  <thead>
                        <tr>
                            <th class="txt-center">ลำดับ</th>
                            <th class="text-center">บัญชีผู้ใช้</th>
                            <th class="text-center">ชื่อ</th>
                            <th class="text-center">นามสกุล</th>
                            <th class="text-center">อีเมล</th>
                            <th class="text-center">กลุ่ม</th>
                            <th class="text-center">แผนก</th>
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
    <div class="modal-dialog modal-primary modal-lg" role="document">
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
        <div class="modal-body">
        <!-- Start Form -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">อีเมล</label>
                    <input name="email" class="form-control" type="email">
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">User Name</label>
                    <input name="username" class="form-control" value="" type="text">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">รหัสผ่าน</label>
                    <input name="password" class="form-control" type="password">
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">ยืนยันรหัสผ่าน</label>
                    <input name="password_re" class="form-control" type="password">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">ชื่อ</label>
                    <input name="firstname" class="form-control" type="text">
                </div>

                <div class="form-group col-md-6">
                    <label class="control-label">นามสกุล</label>
                    <input name="lastname" class="form-control" type="text">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">แผนก</label>
                    <select name="department" class="form-control">
                        <option value="">เลือกแผนก</option>
                        @foreach($Departments as $department)
                            <option value="{{$department->department_id}}">{{$department->department_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">เลือกกลุ่มผู้ใช้งาน</label>
                    <select name="user_group_id" class="form-control">
                        <option value="">เลือกกลุ่มผู้ใช้งาน</option>
                        @foreach($AdminGroups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">

                <div class="form-group col-md-12">
                <label class="control-label">เลือกสาขา</label>
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input branch_head_checkbox" onclick="checkAll(document.getElementById('FormPrimary'),'branch_checkbox',this.checked);">
                        เลือกทั้งหมด
                        </label>
                        <input type="hidden" name="branch_access" class="branch_access">
                    </div>
                    <div class="form-group col-md-12" style="overflow-x:hidden; overflow-y:scroll; max-height:105px; border:solid 1px #ddd;">
                    <?php $j=1; ?>
                    @foreach($Branchs as $branch)
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="checkbox" name="access_branch[]" class="form-check-input branch_checkbox" value="{{$branch->BraID}}" onclick="checkHeadAll(document.getElementById('FormPrimary'),'branch_checkbox','branch_head_checkbox',this.checked);">
                        {{$j}} .
                        {{$branch->BraName}}

                        @if ($branch->BraNum)
                        &nbsp;&nbsp;ที่อยู่{{$branch->BraNum}}
                        @endif
                        @if ($branch->district['district_name'])
                        &nbsp;&nbsp;ตำบล{{$branch->district['district_name']}}
                        @endif

                        @if ($branch->amphur['amphur_name'])
                        &nbsp;&nbsp;อำเภอ{{$branch->amphur['amphur_name']}}
                        @endif

                        @if ($branch->province['province_name'])
                        &nbsp;&nbsp;จังหวัด{{$branch->province['province_name']}}
                        @endif

                        @if ($branch->amphur['zipcode'])
                        &nbsp;&nbsp;รหัสไปรษณีย์&nbsp;{{$branch->amphur['zipcode']}}
                        @endif


                        <?php $j++; ?>
                        </label>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>

        <!-- End Form -->
        </div>
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
  <div class="modal-dialog modal-warning modal-lg" role="document">
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
      <input name="editid" id="editid" class="form-control" type="hidden">
      <div class="modal-body">
      <!-- Start Form -->
          <div class="row">
              <div class="form-group col-md-6">
                  <label class="control-label">อีเมล</label>
                  <input name="email" id="email" class="form-control" type="email">
              </div>
              <div class="form-group col-md-6">
                  <label class="control-label">User Name</label>
                  <input name="username" id="username" class="form-control" value="" type="text">
              </div>
          </div>
          <!--
          <div class="row">
              <div class="form-group col-md-6">
                  <label class="control-label">รหัสผ่าน</label>
                  <input name="password" class="form-control" type="password">
              </div>
              <div class="form-group col-md-6">
                  <label class="control-label">ยืนยันรหัสผ่าน</label>
                  <input name="password_re" class="form-control" type="password">
              </div>
          </div>
          -->
          <div class="row">
              <div class="form-group col-md-6">
                  <label class="control-label">ชื่อ</label>
                  <input name="firstname" id="firstname" class="form-control" type="text">
              </div>

              <div class="form-group col-md-6">
                  <label class="control-label">นามสกุล</label>
                  <input name="lastname" id="lastname" class="form-control" type="text">
              </div>
          </div>
          <div class="row">
              <div class="form-group col-md-6">
                  <label class="control-label">แผนก</label>
                  <select name="department" id="department" class="form-control">
                      <option value="">เลือกแผนก</option>
                      @foreach($Departments as $department)
                          <option value="{{$department->department_id}}">{{$department->department_name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-md-6">
                  <label class="control-label">เลือกกลุ่มผู้ใช้งาน</label>
                  <select name="user_group_id" id="user_group_id" class="form-control">
                      <option value="">เลือกกลุ่มผู้ใช้งาน</option>
                      @foreach($AdminGroups as $group)
                          <option value="{{$group->id}}">{{$group->name}}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="row">

              <div class="form-group col-md-12">
              <label class="control-label">เลือกสาขา</label>
                  <div class="form-check">
                      <label class="form-check-label">
                      <input type="checkbox" class="form-check-input branch_head_checkbox" onclick="checkAll(document.getElementById('FormWarning'),'branch_checkbox',this.checked);">
                      เลือกทั้งหมด
                      </label>
                      <input type="hidden" name="branch_access" class="branch_access">
                  </div>
                  <div class="form-group col-md-12" style="overflow-x:hidden; overflow-y:scroll; max-height:105px; border:solid 1px #ddd;">
                  <?php $j=1; ?>
                  @foreach($Branchs as $branch)
                  <div class="form-check">
                      <label class="form-check-label">
                      <input type="checkbox" name="access_branch[]" class="form-check-input branch_checkbox" value="{{$branch->BraID}}" onclick="checkHeadAll(document.getElementById('FormWarning'),'branch_checkbox','branch_head_checkbox',this.checked);"  id="ba{{$branch->BraID}}_">
                      {{$j}} .
                      {{$branch->BraName}}

                      @if ($branch->BraNum)
                      &nbsp;&nbsp;ที่อยู่{{$branch->BraNum}}
                      @endif
                      @if ($branch->district['district_name'])
                      &nbsp;&nbsp;ตำบล{{$branch->district['district_name']}}
                      @endif

                      @if ($branch->amphur['amphur_name'])
                      &nbsp;&nbsp;อำเภอ{{$branch->amphur['amphur_name']}}
                      @endif

                      @if ($branch->province['province_name'])
                      &nbsp;&nbsp;จังหวัด{{$branch->province['province_name']}}
                      @endif

                      @if ($branch->amphur['zipcode'])
                      &nbsp;&nbsp;รหัสไปรษณีย์&nbsp;{{$branch->amphur['zipcode']}}
                      @endif


                      <?php $j++; ?>
                      </label>
                  </div>
                  @endforeach
                  </div>
              </div>
          </div>

      <!-- End Form -->
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
<script>
var dataTableList = $('#UserManagement').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": url+"/BranchManagement/Datatable/UserManagement",
        "data": function ( d ) {
        }
    },
    "columns": [
            { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
            { "data": "username" , "name":"username" },
            { "data": "firstname" , "name":"firstname" },
            { "data": "lastname" , "name":"lastname" },
            { "data": "email" , "name":"email" },
            { "data": "group" , "name":"group", "className": "text-center", "searchable": false  },
            //{ "data": "branch" , "name":"branch", "className": "text-center", "searchable": false },
            { "data": "department" , "name":"department", "className": "text-center", "searchable": false  },
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
    document.getElementById("FormWarning").reset();
    $( "#primaryModal" ).modal('show');
});//end btn-add

$('body').on('click', '.btn-edit',function(){
    var id = $(this).data('id');
    //alert(id);
    $.ajax({
        method : "GET",
        url : url+"/BranchManagement/UserManagement/"+id,
        dataType : 'json'
    }).done(function(rec){

        //document.getElementById("FormWarning").reset();
        //branch_access
        if(rec.branch_access!=null){
            var ba = (rec.branch_access).split(",");
            //alert(ba[0]);
            for (i=0;i<ba.length;i++){
                document.getElementById( 'ba'+ba[i]+'_' ).checked = true;
            }
            //checkbox checkall
            var s=0; var l = (rec.branch_access).split(",");
            var theForm = document.getElementById('FormWarning');
            for (i=0,n=theForm.elements.length;i<n;i++){
                if (theForm.elements[i].className.indexOf('branch_checkbox')!=-1){
                    s++;
                }
            }
            if(l.length==s){
                //alert('s='+s+" ,l="+l);
                for (i=0,n=theForm.elements.length;i<n;i++){
                    if (theForm.elements[i].className.indexOf('branch_head_checkbox')!=-1){
                        theForm.elements[i].checked = true;
                    }
                }
            }
        }

        $('#editid').val(rec.id);
        $('#username').val(rec.username);
        $('#firstname').val(rec.firstname);
        $('#lastname').val(rec.lastname);
        $('#email').val(rec.email);
        $('#user_group_id').val(rec.user_group_id);
        $('.branch_access').val(rec.branch_access);
        $('#department').val(rec.department_id);
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
                method : "POST",
                url : url+"/BranchManagement/UserManagement/delete/"+id,
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
        email: "required",
        username: "required",
        password: {
            "required": true,
            "minlength": 6,
        } ,
        password_re: {
            "required": true,
            "minlength": 6,
        }
    },
    messages: {
        email: "กรุณาระบุ",
        username: "กรุณาระบุ",
        password: {
            "required": "กรุณาระบุ",
            "minlength":"ไม่น้อย 6 ตัวอักษร",
        } ,
        password_re: {
            "required": "กรุณาระบุ",
            "minlength":"ไม่น้อย 6 ตัวอักษร",
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
            url : url+"/BranchManagement/UserManagement",
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
        email: "required",
        username: "required",
        password: {
            "required": true,
            "minlength": 6,
        } ,
        password_re: {
            "required": true,
            "minlength": 6,
        }
    },
    messages: {
        email: "กรุณาระบุ",
        username: "กรุณาระบุ",
        password: {
            "required": "กรุณาระบุ",
            "minlength":"ไม่น้อย 6 ตัวอักษร",
        } ,
        password_re: {
            "required": "กรุณาระบุ",
            "minlength":"ไม่น้อย 6 ตัวอักษร",
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
            url : url+"/BranchManagement/UserManagement/update",
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

function checkAll(theForm,cName,status){
    for (i=0,n=theForm.elements.length;i<n;i++){
        if (theForm.elements[i].className.indexOf(cName)!=-1){
            theForm.elements[i].checked = status;
        }
    }
    $('.branch_access').val(getAccessMenu('access_branch[]'));
}

function checkHeadAll(theForm,cNameChild,cNameHead,status){
    var s=0; var cd=0;
    for (i=0,n=theForm.elements.length;i<n;i++){
        if (theForm.elements[i].checked==true && theForm.elements[i].className.indexOf(cNameChild)!=-1){
            s++;
        }
        if (theForm.elements[i].className.indexOf(cNameChild)!=-1){
            cd++;
        }
    }

    for (i=0,n=theForm.elements.length;i<n;i++){
        if(theForm.elements[i].className.indexOf(cNameHead)!=-1 && s==cd){
            theForm.elements[i].checked = true;
        }
        if(theForm.elements[i].className.indexOf(cNameHead)!=-1 && s<cd){
            theForm.elements[i].checked = false;
        }
    }
    //alert(s+"  "+cd);
    $('.branch_access').val(getAccessMenu('access_branch[]'));
}

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
</script>
@endsection
