@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
@endsection

@section('body')
<div class="col-md-12">
    <div class="card card-accent-primary">
        <div class="card-header">
            ตรวจสอบและรับสินค้า
        </div>
        <div class="card-body">
            <form id="FormPrimary">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="rp_no">เลขที่ใบรับสินค้า :</label>
                        <div class="input-group">
                            <input type="text" id="rp_no" name="rp_no" class="form-control" value="{{$rp}}" readonly>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrow-up"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="rp_date">วันที่เอกสาร :</label>
                        <div class="input-group">
                            <input type="text" id="rp_date" name="rp_date" class="form-control datecalendar" value="" placeholder="dd/mm/yyyy">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div><!-- end row -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="rp_user_record">ผู้บันทึก :</label>
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select class="form-control" name="rp_user_record" id="rp_user_record">
                                    @foreach($users as $key => $val)
                                    <option value="{{$val->id}}">{{$val->firstname.' '.$val->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="rp_user_reciept">ผู้รับสินค้า :</label>
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select class="form-control" name="rp_user_reciept" id="rp_user_reciept">
                                    @foreach($users as $key => $val)
                                    <option value="{{$val->id}}">{{$val->firstname.' '.$val->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label" for="rp_notation">หมายเหตุ :</label>
                        <div class="row">
                            <div class="input-group col-md-8">
                                <textarea name="rp_notation" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
                <!-- <div class="pull-right">
                <a href="#" style="width: 100px;" class="btn btn-primary" data-toggle="modal" data-target="#create">
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
            </a>
        </div><br><br> -->
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">รหัสงาน</th>
                    <th style="text-align: center;">รหัสสินค้า</th>
                    <th style="text-align: center;">ชื่อสินค้า</th>
                    <th style="text-align: center;">หน่วยบรรจุ</th>
                    <th style="text-align: center;">สาขา</th>
                    <th style="text-align: center;">ที่เก็บ</th>
                    <th style="text-align: center;">จำนวนสินค้ารับเข้า</th>
                    <th style="text-align: center;">สินค้าเสียหาย</th>
                    <th style="text-align: center;">คืนวัสดุ</th>
                    <th style="text-align: center;">กลุ่มสินค้า</th>
                    <th style="text-align: center;">ปิดงาน</th>
                    <!-- <th style="text-align: center;">วัตถุดิบคงเหลือ</th> -->
                    <!-- <th style="text-align: center;">จำนวนวัตถุดิบคืน</th> -->
                </tr>
            </thead>
            <tbody>
                @php ($i=0)
                @foreach($bomOrder as $key => $val)
                <input type="hidden" name="task_no[{{$key}}]" value="{{$val->task_no}}">
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$val->task_no}}</td>
                    <td>{{$val->pro_id}}</td>
                    <td>{{$val->ProName}}</td>
                    <td><input style="text-align: right;" class="form-control" tyle="text" value="{{$val->amount}}" readonly></td>
                    <td>
                        <select class="form-control" name="branch_reciept[{{$key}}]">
                            <option value="">กรุณาเลือก</option>
                            @foreach($branch as $v)
                            <option value="{{$v->BraID}}">{{$v->BraName}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="warehouse_id[{{$key}}]">
                            <option value="">กรุณาเลือก</option>
                            @foreach($warehouse as $v)
                            <option value="{{$v->id}}">{{$v->warehouse_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input style="text-align: right;" class="form-control" name="pass_amount[{{$key}}]" value=""/></td>
                    <td><input style="text-align: right;" class="form-control" name="corrupt_amount[{{$key}}]" value=""/></td>
                    <td style="text-align:center;vertical-align:middle;">
                        <button type="button" name="material_restore" class="btn btn-sm btn-outline-warning material_restore" data-id="{{$val->pro_id}}">รายละเอียด</button>
                    </td>
                    <td>
                        <select class="form-control" name="group_product_id[{{$key}}]">
                            <option value="">กรุณาเลือก</option>
                            @foreach($ProductGroup as $v)
                            <option value="{{$v->id}}">{{$v->ProGroupName}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td style="text-align: center; vertical-align: middle;"><input type="checkbox" name="status[{{$key}}]" value="T"></td>
                    <!-- <td style="text-align: center;" class="sorting_1"> -->
                    <!-- 3 รายการ<br> -->
                    <!-- <button class="btn btn-warning detail" type="button" data-material="{{$val->pro_id}}">รายละเอียด</button> -->
                    <!-- </td> -->
                    <!-- <td style="text-align: center;" class="sorting_1"> -->
                    <!-- 3 รายการ<br> -->
                    <!-- <button class="btn btn-warning detail" type="button" data-material="{{$val->pro_id}}">รายละเอียด</button> -->
                    <!-- </td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer" style="text-align: center;">
            <button type="submit" class="btn btn-sm btn-primary save"><i class="fa fa-dot-circle-o"></i> บันทึก</button>
            <button type="reset" class="btn btn-sm btn-danger btn-cancel"><i class="fa fa-ban"></i> ยกเลิก</button>
            <!-- <button class="btn btn-sm btn-warning"><i class="fa fa-print"></i> พิมพ์</button> -->
        </div>
    </form>
</div>
</div>
</div>
<div id="create" class="modal fade" role="dialog"> <!-- modal create -->
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">เพิ่มข้อมูลงาน</h4></center>
            </div>
            <div class="modal-body">
                <div id="table">
                    <table class="datatable table table-bordered table-striped table-sm">
                        <thead>
                            <th style="text-align: center;">เลือก</th>
                            <th style="text-align: center;">รหัสงาน</th>
                            <th style="text-align: center;">วันที่ออกงาน</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" name="slmat[]" /></td>
                                <td style="text-align: center;">0001</td>
                                <td><?php echo date('d/m/Y'); ?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="slmat[]" /></td>
                                <td style="text-align: center;">0002</td>
                                <td><?php echo date('d/m/Y'); ?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="slmat[]" /></td>
                                <td style="text-align: center;">0003</td>
                                <td><?php echo date('d/m/Y'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <a href="#" class="btn btn-primary save" data-id="create" style="width:90px; height: 40px">บันทึก</a>
                    <button type="button" class="btn btn" data-dismiss="modal" style="width:90px; height: 40px">ยกเลิก</button>
                </center>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
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
            <form id="FormWarning">
                <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                {{csrf_field()}}
                <!-- <input type="hidden" id='editid' name="editid"> -->
                <input type="hidden" name="task_no_wait" id="task_no_wait">
                <!-- Start Body -->
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <th>รหัสวัตถุดิบ</th>
                            <th>ชื่อวัตถุดิบ</th>
                            <th style="text-align:center;">วัตถุดิบคงเหลือ</th>
                            <th style="text-align:center;">หน่วยนับ</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script>
$("#user_recorder, #user_recipient").val("{{Auth::user()->id}}");
$(document).ready(function () {
    $('.hidamout').hide();
});
$('.datecalendar').daterangepicker({
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    }
});
$("body").on('click', '.save', function () {
    var id = $(this).data('id');
    $("#" + id).modal('hide');
    $("#save").modal('show');
});
$('.material_restore').click(function() {
    var task_no_wait = $(this).closest('tr').find('td:first').next().text();
    var material = $(this).data('id');
    var newText = '';
    $.ajax({
        method : "POST",
        url : url+"/Manufacture/VerifyAccrptProduct/GetBom",
        dataType : 'json',
        data : {material:material,task_no:task_no_wait}
    }).done(function(rec){
        var arr = [];
        $.each(rec.data,function(k,v) {
            $('#task_no_wait').val(task_no_wait);
            if($.inArray(v.MatCode,arr)== -1) {
                arr.push(v.MatCode);
                newText += '<tr>\n\
                <td><input type="text" class="form-control" name="MatCode['+k+']" value="'+v.MatCode+'" readonly></td>\n\
                <td>'+v.MatDescription+'</td>\n\
                <td><input type="text" name="restore['+k+']" class="form-control" value="'+rec.data_res[v.MatCode]+'"></td>\n\
                <td>'+v.name_th+'</td>\n\
                </tr>';
            }
        });
        arr.length = 0;
        $('#warningModal').find('tbody').empty();
        $('#warningModal').find('tbody').append(newText);
        $('#warningModal').modal('show');
    });
});
$("#FormWarning").validate({
    rules: {
    },
    messages: {
    },
    errorElement: "span",
    errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block" );
        if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ));
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
            url : url+"/Manufacture/VerifyAccrptProduct/MatWaitReturn",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            if(rec.type == 'success'){
                form.reset();
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                });
            }else{
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                });
            }
            $('#warningModal').modal('hide');
        });
    }
});
$( "#FormPrimary" ).validate({
    rules: {
    },
    messages: {
    },
    errorElement: "span",
    errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block" );
        if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ));
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
        var check = 0;
        $.each($('body').find('input:checkbox[name*="status"]'),function() {
            if($(this).prop('checked')==true) {
                check = 1;
            }
        });
        if(check==1) {
            $.ajax({
                method : "POST",
                url : url+"/Manufacture/VerifyAccrptProduct/RecieptProduct",
                dataType : 'json',
                data : $(form).serialize()
            }).done(function(rec){
                if(rec.type == 'success'){
                    form.reset();
                    swal({
                        confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                    }).then((rec) => {
                        window.location.href = "{{url('Manufacture/VerifyAccrptProduct')}}";
                    });
                }else{
                    swal({
                        confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                    });
                }
            });
        }
    }
});
$('input:checkbox[name*="status"]').click(function() {
    var k = parseInt($(this).closest('tr').find('td:first').text())-1;
    if($(this).prop('checked')==true) {
        // console.log(parseInt($(this).closest('tr').find('td:first').text())-1);
        $('input[name="pass_amount['+k+']"]').rules("add", {
            required: true,
            number: true,
            messages: {
                required: "กรุณาระบุ",
                number: "ตัวเลขเท่านั้น"
            }
        });
        $('select[name="group_product_id['+k+']"]').rules("add", {
            required: true,
            messages: {
                required: "กรุณาระบุ",
            }
        });
    } else {
        $('input[name="pass_amount['+k+']"]').closest('td').find('span').remove();
        $('input[name="pass_amount['+k+']"]').rules('remove');
        $('input[name="group_product_id['+k+']"]').closest('td').find('span').remove();
        $('input[name="group_product_id['+k+']"]').rules('remove');
    }
});
$('input[name*="pass_amount"]').blur(function() {
    if($(this).val()==0) {
        $(this).val('');
    }
});

$("body").on('click','.btn-cancel', function(e){
    swal({
        title : "คุณต้องการยกเลิกรายการจริงหรือไหม ?",
        text  : "หากต้องการยกเลิก กดปุ่ม 'ยืนยัน'",
        type  : "warning",
        showCancelButton   : true,
        confirmButtonColor : "#3085d6",
        cancelButtonColor  : "#d33",
        confirmButtonText  : "ยืนยัน",
        cancelButtonText   : "ยกเลิก"
    }).then((result) => {
        if (result.value) {
            window.location = url+"/Manufacture/VerifyAccrptProduct"
        }
    })
});
</script>
@endsection
