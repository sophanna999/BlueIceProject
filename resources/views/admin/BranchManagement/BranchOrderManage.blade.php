@extends('layouts.admin')
@section('csstop')
  <title>{{$title}} | BlueIce</title>
  <link rel="stylesheet" href="{{asset('js/orakuploader/orakuploader.css')}}">
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
                  <table class="table table-striped table-hover table-sm" id="ListBranch">
                  <thead>
                      <tr>
                            <th class="text-center">ลำดับ</th>
                            <th class="text-center">รหัสสาขา</th>
                            <th class="text-center">ชื่อสาขา</th>
                            <th class="text-center">ที่อยู่สาขา</th>
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
                    <label class="control-label">รหัสสาขา</label>
                    <input name="BraID" class="form-control" placeholder="Branch_ID" type="text">
                    <br>
                    <label class="control-label">ชื่อสาขา</label>
                    <input name="BraName" class="form-control" placeholder="Branch_name" type="text">
                </div>
                <div class="form-group offset-md-1 col-md-4">
                    <label class="control-label">รูปภาพสาขา</label>
                    <div id="photo" name="photo" orakuploader="on"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">เลขที่ตั้ง</label>
                    <input class="form-control" name="BraNum" placeholder="Enter your Number" type="text">
                </div>
                <div class="form-group col-md-8">
                    <label for="BraRoad">ถนน</label>
                    <input class="form-control" name="BraRoad" placeholder="Enter your Road" type="text">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="BraState">จังหวัด</label>
                    <div>
                    <select class="form-control" name="BraState" id="BraState" onchange="Province(this.value,'BraCity','BraTambon','BraZipcode')">
                        <option value="">เลือกจังหวัด</option>
                        @foreach($Provinces as $province)
                        <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BraCity">เมือง / อำเภอ / เขต</label>
                        <div>
                        <select class="form-control" name="BraCity" id="BraCity">
                            <option value="">เลือก อำเภอ/เขต</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="BraTambon">ตำบล / แขวง</label>
                    <div>
                    <select class="form-control" name="BraTambon" id="BraTambon">
                        <option value="">เลือก ตำบล/แขวง</option>
                    </select>
                    </div>
                </div>
            </div>
            <!--/.row-->
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="BraZipcode">รหัสไปรษณีย์</label>
                    <div>
                    <input class="form-control" name="BraZipcode" id="BraZipcode" placeholder="Enter your Zipcode" type="text">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="BraCountry">ประเทศ</label>
                    <select class="form-control" name="BraCountry">
                        <option value="">เลือกประเทศ</option>
                        @foreach($Countries as $Country)
                            <option value="{{$Country->country_id}}">{{$Country->name_th}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">เบอร์โทร</label>
                    <input name="BraPhone" class="form-control" placeholder="Enter your Phone" value="" type="text">
                </div>
            </div><!--/.row-->
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="BraMobile">มือถือ</label>
                    <input class="form-control" name="BraMobile" placeholder="Enter your MobilePhone" type="text">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BraFax">แฟกซ์</label>
                        <input class="form-control" name="BraFax" placeholder="Enter your Fax" type="text">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BraType">ประเภท</label>
                        <input class="form-control" name="BraType" placeholder="Enter your Suptomer Type" type="text">
                    </div>
                </div>
            </div><!--/.row-->
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
        <form id="FormWarning" class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="editid" id="editid">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">รหัสสาขา</label>
                    <input name="BraID" id="BraID" class="form-control" placeholder="Branch_ID" readonly type="text">
                    <br>
                    <label class="control-label">ชื่อสาขา</label>
                    <input name="BraName" id="BraName" class="form-control" placeholder="Branch_name" value="" type="text">
                </div>
                <div class="form-group offset-md-1 col-md-4">
                    <label class="control-label">รูปภาพสาขา</label>
                    <div id="editphoto" orakuploader="on"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">เลขที่ตั้ง</label>
                    <input class="form-control" name="BraNum" id="BraNum" placeholder="Enter your Number" type="text">
                </div>
                <div class="form-group col-md-8">
                    <label for="BraRoad">ถนน</label>
                    <input class="form-control" name="BraRoad" id="BraRoad" placeholder="Enter your Road" type="text">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="BraState1">จังหวัด</label>
                    <div>
                    <select class="form-control" name="BraState" id="BraState1" onchange="Province(this.value,'BraCity1','BraTambon1','BraZipcode1')">
                        <option value="">เลือกจังหวัด</option>
                        @foreach($Provinces as $province)
                        <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BraCity">เมือง / อำเภอ / เขต</label>
                        <div>
                        <select class="form-control" name="BraCity" id="BraCity1">
                            <option value="">เลือก อำเภอ/เขต</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="BraTambon">ตำบล / แขวง</label>
                    <div>
                    <select class="form-control" name="BraTambon" id="BraTambon1">
                        <option value="">เลือก ตำบล/แขวง</option>
                    </select>
                    </div>
                </div>
            </div>
            <!--/.row-->
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="BraZipcode">รหัสไปรษณีย์</label>
                    <div>
                    <input class="form-control" name="BraZipcode" id="BraZipcode1" placeholder="Enter your Zipcode" type="text">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="BraCountry">ประเทศ</label>
                    <select class="form-control" name="BraCountry" id="BraCountry">
                        <option value="">เลือกประเทศ</option>
                        @foreach($Countries as $Country)
                            <option value="{{$Country->country_id}}">{{$Country->name_th}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">เบอร์โทร</label>
                    <input name="BraPhone" id="BraPhone" class="form-control" placeholder="Enter your Phone" type="text">
                </div>
            </div><!--/.row-->
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="BraMobile">มือถือ</label>
                    <input class="form-control" name="BraMobile" id="BraMobile" placeholder="Enter your MobilePhone" type="text">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BraFax">แฟกซ์</label>
                        <input class="form-control" name="BraFax" id="BraFax" placeholder="Enter your Fax" type="text">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BraType">ประเภท</label>
                        <input class="form-control" name="BraType" id="BraType" placeholder="Enter your Suptomer Type" type="text">
                    </div>
                </div>
            </div><!--/.row-->
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
<script src="{{asset('js/orakuploader/orakuploader.js')}}"></script>
<script src="{{asset('js/orakuploader/jquery-ui.min.js')}}"></script>
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
    function editphoto(path){
        $('#editphoto').parent().html('<div id="editphoto" orakuploader="on"></div>');

        if(path){
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
    var dataTableList = $('#ListBranch').dataTable({
        "focusInvalid": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url+"/BranchManagement/Datatable/listBranch",
            "data": function ( d ) {
            }
        },
        "columns": [
            { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
            { "data": "BraID" , "name":"BraID" },
            { "data": "BraName" , "name":"BraName" },
            { "data": "address" , "name":"address" },
            { "data": "created_at" , "name":"created_at" },
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
        photo();
        document.getElementById("FormPrimary").reset();
        $( "#primaryModal" ).modal('show');
        $('.has-error').removeClass('has-error');
        $('span.error').remove();
    });//end btn-add
    $('body').on('click', '.btn-edit', function(){
        $('.has-error').removeClass('has-error');
        $('span.error').remove();
        var id = $(this).data('id');
        $.ajax({
            method : "GET",
            url : url+"/BranchManagement/BranchOrderManage/"+id,
            dataType : 'json',
            success:function(rec) {
                valAddress(rec.BraTambon,rec.BraCity,rec.BraState,'BraTambon1','BraCity1','BraState1','BraZipcode1');
            }
        }).done(function(rec){
            editphoto(rec.photo);
            $('#editid').val(id);
            $('#BraID').val(rec.BraID);
            $('#BraName').val(rec.BraName);
            $('#BraNum').val(rec.BraNum);
            $('#BraPhone').val(rec.BraPhone);
            $('#BraMobile').val(rec.BraMobile);
            $('#BraFax').val(rec.BraFax);
            $('#BraType').val(rec.BraType);
            $('#CusBook').val(rec.CusBook);
            $('#SupBook').val(rec.SupBook);
            $('#BomBook').val(rec.BomBook);
            $('#MatBook').val(rec.MatBook);
            $('#PurBook').val(rec.PurBook);
            $('#PO').val(rec.PO);
            $('#INV').val(rec.INV);
            $('#BOM').val(rec.BOM);
            $('#REQ').val(rec.REQ);
            $('#DER').val(rec.DER);
            $('#BraState1').val(rec.BraState);
            $('#BraZipcode1').val(rec.BraZipcode);
            $('#BraRoad').val(rec.BraRoad);
            $('#BraCountry').val(rec.BraCountry);
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
                    url : url+"/BranchManagement/BranchOrderManage/delete/"+id,
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
            BraName: "required",
            BraMobile: {
                "required":true,
                "minlength": 10,
                "maxlength": 10,
                "number":true,
            },
            BraNum:"required",
            BraRoad:"required",
            BraState:"required",
            BraCity:"required",
            BraTambon:"required",
            BraZipcode:"required",
            BraCountry:"required",
        },
        messages: {
            BraName: "กรุณาระบุ",
            BraMobile: {
                "required":"กรุณาระบุ",
                "number": "รูปแบบข้อมูลไม่ถูกต้อง",
                "minlength":"รูปแบบข้อมูลไม่ถูกต้อง",
                "maxlength":"รูปแบบข้อมูลไม่ถูกต้อง",
            },
            BraNum:"กรุณาระบุ",
            BraRoad:"กรุณาระบุ",
            BraState:"กรุณาระบุ",
            BraCity:"กรุณาระบุ",
            BraTambon:"กรุณาระบุ",
            BraZipcode:"กรุณาระบุ",
            BraCountry:"กรุณาระบุ",
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
                url : url+"/BranchManagement/BranchOrderManage",
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
                        confirmButtonText:'ตกลง',title: rec.title_error,text: rec.text,type: rec.type
                    });
                }
            });
        }
    });
    $( "#FormWarning" ).validate({
        rules: {
            BraName: "required",
            BraMobile: {
                "required":true,
                "minlength": 10,
                "maxlength": 10,
                "number":true,
            },
            BraNum:"required",
            BraRoad:"required",
            BraState:"required",
            BraCity:"required",
            BraTambon:"required",
            BraZipcode:"required",
            BraCountry:"required",
        },
        messages: {
            BraName: "กรุณาระบุ",
            BraMobile: {
                "required":"กรุณาระบุ",
                "number": "รูปแบบข้อมูลไม่ถูกต้อง",
                "minlength":"รูปแบบข้อมูลไม่ถูกต้อง",
                "maxlength":"รูปแบบข้อมูลไม่ถูกต้อง",
            },
            BraNum:"กรุณาระบุ",
            BraRoad:"กรุณาระบุ",
            BraState:"กรุณาระบุ",
            BraCity:"กรุณาระบุ",
            BraTambon:"กรุณาระบุ",
            BraZipcode:"กรุณาระบุ",
            BraCountry:"กรุณาระบุ",
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
                url : url+"/BranchManagement/BranchOrderManage/update",
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
