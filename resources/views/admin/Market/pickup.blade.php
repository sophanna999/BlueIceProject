<!-- @extends('layouts.admin') -->
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link href="{{asset('js/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('body')
<div class="col-lg-12" >
    <div class="card card-accent-primary">
        <div class="card-header" style="width: 100%">
            <i class="fa fa-align-justify"></i> การเบิกสินค้าขึ้นรถ
            <div class="pull-right">
                <button type="button" class="btn btn-primary fa fa-plus btn-add" data-toggle="modal" data-target="#myModal" >&nbsp;เพิ่ม</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="report_rawmaterial" class="table table-bordered table-striped table-sm" style="width: 100%">
                    <thead class="table-info">
                        <th style="width: 35px;" align="center"><center>ลำดับ</center></th>
                        <th><center>เลขที่ใบเบิก</center></th>
                        <th><center>รถบรรทุก</center></th>
                        <th><center>วันที่/เวลา</center></th>
                        <th style="width: 200px;"><center>การกระทำ</center></th>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->
<div id="primaryModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">การเบิกสินค้าขึ้นรถ</h4>
            </div>
            <form id="FormPrimary" method="post" class="form-horizontal" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="num">เลขที่ใบเบิก</label>
                            <input type="text" class="form-control TruckProID" name="TruckProID" placeholder="เลขที่ใบเบิก" readonly>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="date">วันที่</label>
                            <div class="input-group date">
                                <input type="text" name="TruckDate" class="form-control datecalendar TruckDate" placeholder="yyyy/mm/dd">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary ">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="TruckID">ทะเบียนรถ</label>
                            <select class="form-control TruckID"  name="TruckID">
                                <option value="">เลือก</option>
                                @foreach($Truck as $data)
                                <option value="{{$data->TruckID}}">{{$data->TruckNumber}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="TruckID">คนขับ</label>
                            <input type="text" name="driver" class="form-control" value="">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="TruckID">จํานวนรอบ</label>
                            <input type="text" class="form-control RoundAmount" name="RoundAmount" placeholder="จํานวนรอบ" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="TruckID">หมายเหตุ</label>
                            <textarea style="resize:none;" name="notation" rows="3" class="form-control notation" placeholder="หมายเหตุ"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <table class="table">
                                <tr>
                                    <th>เลือก</th>
                                    <th>สินค้า</th>
                                    <th>จำนวน</th>
                                    <th class="text-center">คงเหลือ</th>
                                </tr>
                                @foreach($Product as $k => $data)
                                <tr>
                                    <td style="width:5%;"> <input type="checkbox" class="ProID" id="ProID[{{$k}}]" name="ProID[{{$k}}]" value="{{$data->BomID}}"> </td>
                                    <td class="text-left"> {{$data->ProName}} </td>
                                    <td><input type="number" class="form-control ProNumber" id="ProNumber_{{$k}}" name="ProNumber[{{$k}}]" min=0> </td>
                                    <td class="text-center">
                                        @foreach($inStock as $val)
                                        @if($val->BomID == $data->BomID)
                                        {{$val->count}}
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- <div class="form-group col-sm-6">
                        <label for="ProID">จำนวน</label>
                        <input type="number" class="form-control ProNumber1" name="ProNumber[1]">
                    </div> -->
                </div>
                <div class="a"></div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="บันทึก">
                <input type="button" class="btn btn-danger" data-dismiss="modal" value="ปิด">
            </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
</div>
<!-- Modal -->
<!--Detail Modal -->
<div id="DetailModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">การเบิกสินค้าขึ้นรถ</h4>
            </div>
            <form id="FormDetail" method="post" class="form-horizontal" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="num">เลขที่ใบเบิก</label>
                            <input type="text" class="form-control D_TruckProID" name="TruckProID" placeholder="เลขที่ใบเบิก" value="" readonly>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="date">วันที่</label>
                            <div class="input-group date">
                                <input type="text" name="TruckDate" class="form-control datecalendar D_TruckDate" placeholder="yyyy/mm/dd">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary ">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="TruckID">ทะเบียนรถ</label>
                            <select class="form-control D_TruckID"  name="TruckID">
                                <option value="">เลือก</option>
                                @foreach($Truck as $data)
                                <option value="{{$data->TruckID}}">{{$data->TruckNumber}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="TruckID">คนขับ</label>
                            <input type="text" class="form-control driver" name="driver" placeholder="" readonly>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="TruckID">จํานวนรอบ</label>
                            <input type="text" class="form-control RoundAmount" name="RoundAmount" placeholder="จํานวนรอบ" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="TruckID">หมายเหตุ</label>
                            <textarea style="resize:none;" name="notation" rows="3" class="form-control notation" placeholder="หมายเหตุ" readonly></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <table class="table">
                                <thead>
                                    <th>สินค้า</th>
                                    <th>จำนวน</th>
                                </thead>
                                <tbody class="TruckDetail">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="a"></div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="ปิด">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!-- Modal -->

<!--Edit Modal -->
<div id="EditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">การเบิกสินค้าขึ้นรถ</h4>
            </div>
            <form id="FormUpdateTruck" method="post" class="form-horizontal" action="">
                <input type="hidden" class="form-control" name="" id="edit_id">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="num">เลขที่ใบเบิก</label>
                            <input type="text" class="form-control D_TruckProID" name="TruckProID" placeholder="เลขที่ใบเบิก" value="" readonly>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="date">วันที่</label>
                            <div class="input-group date">
                                <input type="text" name="TruckDate" class="form-control datecalendar D_TruckDate" placeholder="yyyy/mm/dd">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary ">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="TruckID">ทะเบียนรถ</label>
                            <select class="form-control D_TruckID"  name="TruckID">
                                <option value="">เลือก</option>
                                @foreach($Truck as $data)
                                <option value="{{$data->TruckID}}">{{$data->TruckNumber}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="TruckID">คนขับ</label>
                            <input type="text" class="form-control driver" name="driver" placeholder="" readonly>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="TruckID">จํานวนรอบ</label>
                            <input type="text" class="form-control RoundAmount" name="RoundAmount" placeholder="จํานวนรอบ" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="TruckID">หมายเหตุ</label>
                            <textarea style="resize:none;" name="notation" rows="3" class="form-control notation" placeholder="หมายเหตุ"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <table class="table">
                                <tr>
                                    <th>เลือก</th>
                                    <th>สินค้า</th>
                                    <th>จำนวน</th>
                                    <th class="text-center">คงเหลือ</th>
                                </tr>
                                @foreach($Product as $k => $data)
                                <tr>
                                    <td style="width:5%;"> <input type="checkbox" class="ProID" id="ProID[{{$k}}]" name="ProID[{{$k}}]" value="{{$data->BomID}}"> </td>
                                    <td class="text-left"> {{$data->ProName}} </td>
                                    <td><input type="number" class="form-control U_ProNumber" id="ProNumber_{{$k}}" name="ProNumber[{{$k}}]" min=0> </td>
                                    <td class="text-center">
                                        @foreach($inStock as $val)
                                        @if($val->BomID == $data->BomID)
                                        {{$val->count}}
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="a"></div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="อัปเดต">
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="ปิด">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!-- Modal -->

@endsection

@section('jsbottom')
<!-- DataTables -->
<script src="{{asset('js/daterangepicker/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
<script>
var index = 0;
var dataTableList = $('#report_rawmaterial').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": url + "/Market/Pickup/listPickup",
        "data": function (d) {
        }
    },
    "columns": [
        {"data": "DT_Row_Index", "className": "text-center", "orderable": false, "searchable": false},
        {"data": "TruckProID", "name": "TruckProID", "className": "text-center"},
        {"data": "TruckNumber", "name": "TruckNumber", "className": "text-center"},
        //        {"data": "ProName", "name": "ProName", "className": "text-center"},
        //        {"data": "ProNumber", "name": "ProNumber", "className": "text-center"},
        //        {"data": "ProUnit", "name": "ProUnit", "className": "text-center"},
        //        {"data": "ProPrice", "name": "ProPrice", "className": "text-right"},
        //        {"data": "Myr", "name": "Myr", "className": "text-right"},
        //        {"data": "totalThb", "name": "BraNum", "className": "text-right"},
        //        {"data": "totalMyr", "name": "BraID", "className": "text-right"},
        {"data": "TruckDate", "name": "TruckDate", "className": "text-center"},
        {"data": "action", "name": "action", "className": "text-center", "orderable": false, "searchable": false},
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
    "drawCallback": function (settings) {
    }
});
// set token for ajax
$('document').ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
$('.datecalendar').daterangepicker({
    timePicker: true,
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD HH:mm:ss'
    }
});


$('body').on('click', '.btn-add', function () {
    for (var i = 0; i <= index; i++) {
        $('.ProID' + i + '[name="ProID[' + i + ']"]').rules("remove");
        $('.ProNumber' + i + '[name="ProNumber[' + i + ']"]').rules("remove");
    }
    index = 0;
    $(".a").children().remove();
    document.getElementById("FormPrimary").reset();
    CountCheck = [];
    //    photo();
    $.ajax({
        url: url + "/FunctionPrefix/Branch/OP/5/ใบเปิดสินค้า",
        success: function (result) {
            $('body').find('input:checkbox').removeAttr('disabled');
            $(".TruckProID").val(result);
            $("#primaryModal").modal('show');
        }});
    }); //end btn-add

    $('body').on('click', '.btn-delpro', function () {
        $(".a .row:last").remove();
        // ./ Remove Last Rules
        $('.ProID' + index + '[name="ProID[' + index + ']"]').rules("remove");
        $('.ProNumber' + index + '[name="ProNumber[' + index + ']"]').rules("remove");
        if(index > 2){
            index--;
        }
    }); //end btn-delpro
    $('body').on('click', '.btn-show', function () {
        var id = $(this).data('id');
        $.ajax({
            method: "POST",
            url: url + "/Market/Pickup/show",
            dataType: 'json',
            data: {
                id:id
            }
        }).done(function (rec) {
            $('.TruckDetail').empty();
            $.each(rec, function( key, value ) {
                $('.TruckDetail').append('<tr>'+
                '<td>'+value.ProName+'</td>'+
                '<td>'+value.ProNumber+'</td>'+
                '</tr>');

                $('.driver').val(value.driver);
                $('.D_TruckProID').val(value.TruckProID);
                $('.D_TruckID').val(value.TruckID);
                $('.D_TruckID').prop('disabled',true);
                $('.ProID').val(value.ProID);
                $('.ProNumber').val(value.ProNumber);
                $('.D_TruckDate').val(value.TruckDate);
                $('.D_TruckDate').prop('disabled',true);
                $('.RoundAmount').val(value.RoundAmount);
                $('.notation').val(value.notation);
            });

            $('#DetailModal').modal('show');

        });
    }); //end btn-show

    $('body').on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        $.ajax({
            method: "POST",
            url: url + "/Market/Pickup/show",
            data: {id:id},
            dataType: 'json',
        }).done(function (rec) {
            // $('.EditTruck').empty();
            $('input:checkbox').each(function() {
                $(this).prop('checked',false);
            });
            $('.U_ProNumber').each(function() {
                $(this).val('');
            });
            $('#edit_id').val(rec[0].TruckProID);
            $.each(rec, function( key, value ) {
                // console.log(value);
                $('.D_TruckProID').val(value.TruckProID);
                $('.D_TruckID').val(value.TruckID).prop('readonly',true);
                $('body').find('input:checkbox[value="'+value.BomID+'"]').closest('tr').find('.U_ProNumber').val(value.ProNumber);
                $('body').find('input:checkbox[value="'+value.BomID+'"]').prop('checked', true);
                $('.D_TruckDate').val(value.TruckDate).prop('readonly',true);
                if(value.status=='T') {
                    $('body').find('input:checkbox[value="'+value.BomID+'"]').attr('readonly', 'readonly');
                    $('body').find('input:checkbox[value="'+value.BomID+'"]').closest('tr').find('.U_ProNumber').attr('readonly', 'readonly');
                } else {
                    $('body').find('input:checkbox[value="'+value.BomID+'"]').removeAttr('readonly');
                    $('body').find('input:checkbox[value="'+value.BomID+'"]').closest('tr').find('.U_ProNumber').removeAttr('readonly');
                }
                $('.RoundAmount').val(value.RoundAmount);
                $('.driver').val(value.driver);
            });
            $('.notation').val(rec[0].notation);

            $('#EditModal').modal('show');
        });
    }); //end btn-edit
    $('body').on('click','input:checkbox',function(e) {
        if($(this).attr('readonly')==="readonly") {
            $(this).prop('checked',true);
        }
    });
    $('body').on('click', '.btn-delete', function () {
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
            if (result.value == true) {
                $.ajax({
                    method: "post",
                    url: url + "/Market/Pickup/delete",
                    dataType: 'json',
                    data: {
                        id: id
                    }
                }).done(function (rec) {
                    if (rec.type == 'success') {
                        swal({
                            confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                        });
                        dataTableList.api().ajax.reload();
                    } else {
                        swal(rec.title, rec.text, rec.type);
                    }
                });
            }
        });
    }); //end btn-delete
    $("#FormPrimary").validate({
        rules: {
            TruckDate: "required",
            TruckID: "required",
            driver: "required",
            // 'ProID[1]': "required",
            // 'ProNumber[1]': "required",
        },
        messages: {
            TruckDate: "",
            TruckID: "กรุณาระบุ",
            driver: "กรุณาระบุ",
            // 'ProID[1]': "กรุณาระบุ",
            // 'ProNumber[1]': "กรุณาระบุ",
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form) {
            var btn = $(form).find('[type="submit"]');
            $.ajax({
                method: "POST",
                url: url + "/Market/Pickup/store",
                dataType: 'json',
                data: $(form).serialize() + "&index=" + index
            }).done(function (rec) {
                for (var i = 0; i <= {{sizeof($Product)}}; i++) {
                    $('.ProID[name="ProID[' + i + ']"]').rules("remove");
                    $('.ProNumber[name="ProNumber[' + i + ']"]').rules("remove");
                }
                index = 0;
                $(".a").children().remove();
                if (rec.type == 'success') {
                    swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                }).then((rec) => {
                    if(rec) {
                        dataTableList.api().ajax.reload();
                        $('#primaryModal').modal('hide');
                        form.reset();
                        location.reload();
                    }
                });
                } else {
                    swal({
                        confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                    });
                }
            });
        }
    });

    $("#FormUpdateTruck").validate({
        rules: {
            ProNumber: "required",
        },
        messages: {
            ProNumber: "กรุณาระบุ",
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form) {
            var id = $('#edit_id').val();
            var btn = $(form).find('[type="submit"]');
            // console.log($(form).serialize()+'&edit_id='+id);
            $.ajax({
                method: "POST",
                url: url + "/Market/Pickup/update",
                dataType: 'json',
                data: $(form).serialize()+'&edit_id='+id,
            }).done(function (rec) {
                if (rec.type == 'success') {
                    swal({
                        confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                    });
                    $('#EditModal').modal('hide');
                    dataTableList.api().ajax.reload();
                    form.reset();
                } else {
                    swal({
                        confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                    });
                }
            });
        }
    });

    $('body').on('change','input[type="checkbox"]', function(e){
        var name = $(this).parent().parent().find('input[type="number"]')[0].id;
        if($(this).prop('checked')==true){
            check = 0;
            $("#"+name).rules("add", {
                required: true,
                messages: {
                    required: "กรุณาระบุ",
                }
            });
        }else{
            $('#'+name).rules("remove");
        }
    });

    $('body').on('click','input[type="submit"]',function(e) {
        var this_form = $(this);
        var check = 0;
        $.each($(this).closest('form').find('input:checkbox'),function() {
            if($(this).prop('checked')==true) {
                check = 1;
            }
        });
        if(check==0) {
            swal({
                confirmButtonText: 'ตกลง', title: "ข้อมูลไม่ครบ", text: "กระณาเลือกอย่างน้อย 1 สินค้า", type: "error"
            });
            e.preventDefault();
        }
    });

    function CheckRoundAmount() {
        var truck_date = $('input[name="TruckDate"]').val();
        var truck_id   = $('select[name="TruckID"]').val();

        if (truck_date!= '' && truck_id != '') {
            $.ajax({
                method: "GET",
                url: url + "/Market/Pickup/GetRoundAmount",
                dataType: 'json',
                data: {TruckDate:truck_date,TruckID:truck_id}
            }).done(function (rec) {
                $('.RoundAmount').val(rec);
            });
        }

    }

    $('body').on('change','.TruckDate', function(){
        CheckRoundAmount();
    });
    $('body').on('change','.TruckID', function(){
        CheckRoundAmount();
    });
    $('.ProNumber,.U_ProNumber').focus(function() {
        var tag = $(this);
        var data = tag.closest('tr').find('.ProID').val();
        $.ajax({
            url: url+'/Market/Pickup/getInStock',
            method: 'get',
            dataType: 'json',
            success: function(rec) {
                $.each(rec,function(k,v){
                    tag.closest('tr').find('tr:last').text();
                    if(data == v.BomID) {
                        tag.closest('tr').find('td:last').text(v.count);
                    }
                });
            }
        });
    });
</script>
@endsection
