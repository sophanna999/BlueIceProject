@extends('layouts.admin')
    @section('csstop')
        <link href="{{asset('/js/select2/select2.min.css')}}" rel="stylesheet"/>
        <link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
        <title>{{$title}} | BlueIce</title>
    @endsection
@section('body')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header" style="width: 100%">
            <i class="fa fa-align-justify"></i><strong>การจัดการรถขนส่งสินค้า</strong>
            <div class="pull-right">
                <button class="btn btn-primary btn-add fa fa-plus"> เพิ่ม</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="report_rawmaterial" class="table table-bordered table-striped table-sm">
                    <thead class="table-info">
                        <tr>
                            <th align="center" style="width: 60px;">ทะเบียนรถ</th>
                            <th align="center" style="width: 52px;">วันต่อภาษี</th>
                            <th align="center" style="width: 89px">วันหมดอายุภาษี</th>
                            <th align="center" style="width: 100px;">เช็คสภาพครั้งที่ 1</th>
                            <th align="center" style="width: 100px;">เช็คสภาพครั้งที่ 2</th>
                            <th align="center" style="width: 100px;">เช็คสภาพครั้งที่ 3</th>
                            <th align="center" style="width: 100px;">เช็คสภาพครั้งที่ 4</th>
                            <th align="center" style="width: 100px;">เช็คสภาพครั้งที่ 5</th>
                            <th align="center" style="width: 100px;">เช็คสภาพครั้งที่ 6</th>
                            <th align="center" style="width: 229px;">
                                <center>แก้ไข | ลบ</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-info" role="document">
        <div class="modal-content">
            <form id="FormAdd">
                <div class="modal-header">
                    <h4 class="modal-title">ลงทะเบียนรถ</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="TruckNumber">ทะเบียนรถ</label>
                            <input type="text" class="form-control" name="TruckNumber" id="TruckNumber" placeholder="ทะเบียนรถ">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="TruckNumber">เอเย่นต์</label>
                            <select class="form-control" name="agency_id">
                                @foreach($agency as $val)
                                <option value="{{$val->id}}">{{$val->agency_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="TruckTax">วันต่อภาษี</label>
                            <div class="input-group date">
                                <input type="text" id="TruckTax" name="TruckTax" class="form-control datecalendar" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="offpaytax">วันหมดอายุ</label>
                            <div class="input-group date">
                                <input type="text" id="TruckTaxExpiration" name="TruckTaxExpiration" class="form-control datecalendar" placeholder="dd/mm/yyyy">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check1">วันตรวจเช็คสภาพครั้งที่ 1</label>
                            <div class="input-group date">
                                <input type="text" id="TruckCheck1" name="TruckCheck1" class="form-control datecalendar" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check2">วันตรวจเช็คสภาพครั้งที่ 2</label>
                            <div class="input-group date">
                                <input type="text" id="TruckCheck2" name="TruckCheck2" class="form-control datecalendar" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check3">วันตรวจเช็คสภาพครั้งที่ 3</label>
                            <div class="input-group date">
                                <input type="text" id="TruckCheck3" name="TruckCheck3" class="form-control datecalendar" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check4">วันตรวจเช็คสภาพครั้งที่ 4</label>
                            <div class="input-group date">
                                <input type="text" id="TruckCheck4" name="TruckCheck4" class="form-control datecalendar" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check5">วันตรวจเช็คสภาพครั้งที่ 5</label>
                            <div class="input-group date">
                                <input type="text" id="TruckCheck5" name="TruckCheck5" class="form-control datecalendar" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check6">วันตรวจเช็คสภาพครั้งที่ 6</label>
                            <div class="input-group date">
                                <input type="text" id="TruckCheck6" name="TruckCheck6" class="form-control datecalendar" placeholder="dd/mm/yyyy"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="from-group col-md-12">
                            <label for="add_user_id">คนขับ</label>
                            <div class="input-group">
                                <select name='user_id' id='add_user_id' class='select2' style="width: 100%;">
                                    <option value=''>กรุณาเลือกคนขับ</option>
                                    @foreach($user as $row)
                                        <option value='{{ $row->id }}'>{{ $row->firstname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" style="width:60px; height: 40px">บันทึก</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-info" role="document">
        <div class="modal-content">
            <input type="hidden" id='TruckID'>
            <form id="FormEdit">
                <div class="modal-header">
                    <h4 class="modal-title">แก้ไขการลงทะเบียนรถ</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="TruckNumber">ทะเบียนรถ</label>
                            <input type="text" class="form-control" name="TruckNumber" id="edit_TruckNumber">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="TruckNumber">เอเย่นต์</label>
                            <select class="form-control" name="agency_id" id="agency_id">
                                @foreach($agency as $val)
                                <option value="{{$val->id}}">{{$val->agency_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="TruckTax">วันต่อภาษี</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckTax" name="TruckTax" class="form-control datecalendar"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="offpaytax">วันหมดอายุ</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckTaxExpiration" name="TruckTaxExpiration" class="form-control datecalendar">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check1">วันตรวจเช็คสภาพครั้งที่ 1</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckCheck1" name="TruckCheck1" class="form-control datecalendar"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check2">วันตรวจเช็คสภาพครั้งที่ 2</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckCheck2" name="TruckCheck2" class="form-control datecalendar"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check3">วันตรวจเช็คสภาพครั้งที่ 3</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckCheck3" name="TruckCheck3" class="form-control datecalendar"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check4">วันตรวจเช็คสภาพครั้งที่ 4</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckCheck4" name="TruckCheck4" class="form-control datecalendar"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check5">วันตรวจเช็คสภาพครั้งที่ 5</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckCheck5" name="TruckCheck5" class="form-control datecalendar"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="from-group col-sm-6">
                            <label for="check6">วันตรวจเช็คสภาพครั้งที่ 6</label>
                            <div class="input-group date">
                                <input type="text" id="edit_TruckCheck6" name="TruckCheck6" class="form-control datecalendar"><span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="from-group col-md-12">
                            <label for="edit_user_id">คนขับ</label>
                            <div class="input-group" id='edit_user_div'>
                                <!-- <select name='user_id' id='edit_user_id' class='select2' style="width: 100%;">
                                    <option value=''>กรุณาเลือกคนขับ</option>
                                    @foreach($user as $row)
                                        <option value='{{ $row->id }}'>{{ $row->username }}</option>
                                    @endforeach
                                </select> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" style="width:60px; height: 40px">บันทึก</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MyCustomer -->
<div class="modal fade" id="ModalCustomer" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-primary" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ข้อมูลลูกค้า</h4>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-md-9">
                        <select class="select2 form-control" name="cusId" id='cusSelect' style="width:100%">
                            <option value="">กรุณาเลือก</option>
                        </select>
                    </div>
                    <div class="col-md-3 pull-right">
                        <input type="hidden" id='truck_id'>
                        <button class="btn btn-primary btn-condensed btn-add_customer"><i class="ace-icon fa fa-plus"></i> เพิ่มลูกค้า</button>
                    </div>
                </div>
                <hr>
                <div class='row'>
                    <div class="col-md-12">
                        <table id="customer" align="center" class="table table-bordered table-striped table-sm">
                            <thead class="table-info">
                                <tr class='text-center'>
                                    <th>ลำดับ</th>
                                    <th>รหัสลูกค้า</th>
                                    <th style="width: 288px;">ชื่อลูกค้า</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody id='customerBody'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>

@endsection
@section('jsbottom')
<!-- DataTables -->
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('/js/select2/select2.min.js')}}"></script>
<script>

    var TableList = $('#report_rawmaterial').dataTable({
        "ajax": {
            "url": url+"/Market/ManagePickup/Lists",
            "data": function ( d ) {
                //d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {"data" : "TruckNumber"},
            {"data" : "TruckTax"},
            {"data" : "TruckTaxExpiration"},
            {"data" : "TruckCheck1"},
            {"data" : "TruckCheck2"},
            {"data" : "TruckCheck3"},
            {"data" : "TruckCheck4"},
            {"data" : "TruckCheck5"},
            {"data" : "TruckCheck6"},
            { "data": "action","className":"action text-center" }
        ]
    });

    $(document).ready(function () {
        $('.select2').select2();
        $('.datecalendar').val('');
        $('#report_rawmaterial').DataTable();
    });

    $('.datecalendar').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD',
        }
    });

    // add button
    $('body').on('click', '.btn-add',function(){
        $("#ModalAdd").modal('show');
    });

    $('#FormAdd').validate({
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        focusInvalid: false,
        rules: {
            TruckNumber: "required",
        },
        messages: {
            TruckNumber: "กรุณากรอกข้อมูลทะเบียนรถบรรทุก",
        },
        highlight: function (e) {
            validate_highlight(e);
        },
        submitHandler: function (form) {
            var btn = $(form).find('[type="submit"]');
            var data_ar = $(form).serializeArray();
            $.ajax({
                method : "POST",
                url : url+"/Market/ManagePickup",
                dataType : 'json',
                data : data_ar
            }).done(function(rec){
                if(rec.status==1){
                    TableList.api().ajax.reload();
                    form.reset();
                    swal(rec.title,rec.content,"success");
                    $('#ModalAdd').modal('hide');
                }else if(rec.status==2){
                    swal("ผิดพลาด","ทะเบียนรถนี้มีอยู่ในระบบแล้ว กรุณาตรวจสอบใหม่อีกครั้ง","error");
                    btn.button("reset");
                }else{
                    swal("system.system_alert","system.system_error","error");
                    btn.button("reset");
                }
            });
        }
    });
    // end add button

    // edit button
    $('body').on('click', '.btn-edit', function(){
        var id = $(this).data('id');
        $.ajax({
            method : "GET",
            url : url+"/Market/ManagePickup/"+id,
            dataType : 'json'
        }).done(function(rec){
            $('#TruckID').val(rec.TruckID);
            $('#edit_TruckNumber').val(rec.TruckNumber);
            $('#edit_TruckTax').val(rec.TruckTax);
            $('#edit_TruckTaxExpiration').val(rec.TruckTaxExpiration);
            $('#edit_TruckCheck1').val(rec.TruckCheck1);
            $('#edit_TruckCheck2').val(rec.TruckCheck2);
            $('#edit_TruckCheck3').val(rec.TruckCheck3);
            $('#edit_TruckCheck4').val(rec.TruckCheck4);
            $('#edit_TruckCheck5').val(rec.TruckCheck5);
            $('#edit_TruckCheck6').val(rec.TruckCheck6);
            $('#agency_id').val(rec.agency_id);
            // $('#agency_id').find('option[value="'+rec.agency_id+'"]').prop('selected',true);
            // $('#edit_user_id').select2('val',[rec.user_id]);
            $('#ModalEdit').modal('show');
            $('#edit_user_div').empty();
            var html = '';
            html +=
                '<select name="user_id" id="edit_user_id" class="select2_edit" style="width: 100%;">\
                    <option value="">กรุณาเลือกคนขับ</option>';
                    $.each( rec.user, function( key, value ) {
                        var check = (value.id==rec.user_id) ? 'selected' : '';
                        html += '<option value="'+value.id+'" '+check+'>'+value.firstname+'</option>';
                    });
            html += '</select>';
            $("#edit_user_div").append(html);
            $('.select2_edit').select2();
        });
    });

    $('#FormEdit').validate({
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        focusInvalid: false,
        rules: {

        },
        messages: {

        },
        highlight: function (e) {
            validate_highlight(e);
        },
        submitHandler: function (form) {
            var id = $('#TruckID').val();
            var btn = $(form).find('[type="submit"]');
            var data_ar = $(form).serializeArray();
            $.ajax({
                method : "POST",
                url : url+"/Market/ManagePickup/"+id,
                dataType : 'json',
                data : data_ar
            }).done(function(rec){
                if(rec.status==1){
                    TableList.api().ajax.reload();
                    form.reset();
                    swal(rec.title,rec.content,"success");
                    $('#ModalEdit').modal('hide');
                }else if(rec.status==2){
                    swal("ผิดพลาด","ทะเบียนรถนี้มีอยู่ในระบบแล้ว กรุณาตรวจสอบใหม่อีกครั้ง","error");
                    btn.button("reset");
                }else{
                    swal("system.system_alert","system.system_error","error");
                    btn.button("reset");
                }
            });
        }
    });
    // end edit button

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
                    url : url+"/Market/ManagePickup/delete/"+id,
                    dataType : 'json'
                }).done(function(rec){
                    if(rec.status==1){
                        swal(rec.title,rec.content,"success");
                        TableList.api().ajax.reload();
                    }else{
                        swal("ระบบมีปัญหา","กรุณาติดต่อผู้ดูแล","error");
                    }
                });
            }
        });
    });

    function customer(id){
        $('#truck_id').val(id);
        $.ajax({
            method : "GET",
            url : url+"/Market/ManagePickup/customer/"+id,
            dataType : 'json'
        }).done(function(rec){
            $("#customerBody").html('');
            $.each( rec.table, function( key, value ) {
                $("#customerBody").append(
                    "<tr class='text-center'>\
                        <td>"+(key+1)+"</td>\
                        <td>"+value.CusID+"</td>\
                        <td>"+value.CusName+"</td>\
                        <td><button class='btn-xs btn-danger btn-del_customer' data-id='"+value.CusAutoID+"'><i class='fa fa-times'></i></button></td>\
                    </tr>"
                );
            });
            $('#cusSelect').html('');
            $('#cusSelect').append($("<option value=''>กรุณาเลือก</option>"));
            $.each(rec.select, function(key, value) {
                $('#cusSelect').append($("<option></option>").attr("value",value.CusAutoID).text(value.CusName));
            });

            $('#ModalCustomer').modal('show');
        });
    }

    $('body').on('click', '.btn-add_customer', function(){
        var TruckID = $('#truck_id').val();
        var cusID = $('#cusSelect').val();
        if(cusID=='') {
            cusID = 'error';
        }
        $.ajax({
            method : "GET",
            url : url+"/Market/ManagePickup/customer/"+cusID+"/"+TruckID,
            dataType : 'json'
        }).done(function(rec){
            if(rec.status==1){
                swal({
                    title : rec.title,
                    text : rec.content,
                    type : "success",
                    timer : 2500
                });
                customer(TruckID);
            }else{
                swal(rec.title,rec.content,"error");
            }
        });
    });

    $('body').on('click', '.btn-del_customer', function(){
        var id = $(this).data('id');
        $.ajax({
            method : "GET",
            url : url+"/Market/ManagePickup/del_customer/"+id,
            dataType : 'json'
        }).done(function(rec){
            if(rec.status==1){
                swal({
                    title : rec.title,
                    text : rec.content,
                    type : "success",
                    timer : 2500
                });
                customer(TruckID);
            }else{
                swal(rec.title,rec.content,"error");
            }
        });
    })



</script>
@endsection
