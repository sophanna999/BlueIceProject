@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
@endsection

@section('body')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> ใบรับวัสดุ
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-2" for="search">ค้นหาใบสั่งซื้อ :</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="e.g. PO12345, PO54321">
                        <span class="input-group-btn">
                            <button type="button" id="search"  class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <form id="StockMaterial">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group row">
                    <label class="col-md-2" for="date_doc">เลขที่เอกสาร :</label>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" id="num_doc" class="form-control" name="num_doc" value="{{$ref_id}}" readonly>
                        </div>
                    </div>

                    <label class="col-md-2" for="date_doc">วันที่เอกสาร :</label>
                    <div class="col-md-2">
                        <div class="input-group date datecalendar">
                            <input type="text" id="date_doc" name="date_doc" class="datecalendar form-control" placeholder="dd/mm/yyyy">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div><!-- end row -->
                <div class="form-group row">
                    <label class="col-md-2" for="department_id">รหัสแผนก :</label>
                    <div class="col-md-2">
                        <div class="input-group">
                            <select class="form-control" name="department_id" id="department_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach($departments as $key => $val)
                                <option value="{{$val->department_id}}" data-name="{{$val->department_name}}">{{$val->department_id}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group date">
                            <input type="text" id="department_name" name="department_name" class="form-control" placeholder="ชื่อแผนก" readonly>
                        </div>
                    </div>
                </div><!-- end row -->
                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="notation">หมายเหตุ :</label>
                    </div>
                    <div class="col-md-6">
                        <textarea name="notation" class="form-control"></textarea>
                    </div>
                </div><!-- end row -->
                <div class="form-group row">
                    <label class="col-md-2" for="user_recorder">รหัสผู้บันทึก :</label>
                    <div class="col-md-4" style="margin-left: -4px;">
                        <div class="input-group">
                            <select class="form-control" name="user_recorder" id="user_recorder">
                                @foreach($users as $key => $val)
                                <option value="{{$val->id}}">{{$val->firstname.' '.$val->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <label class="col-md-2" for="user_recipient">รหัสผู้รับสินค้า :</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <select class="form-control" name="user_recipient" id="user_recipient">
                                @foreach($users as $key => $val)
                                <option value="{{$val->id}}">{{$val->firstname.' '.$val->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><!-- end row -->
            </form>
            <div class="pull-right">
                <button class="btn btn-primary btn-sm pull-right btn-add">
                    <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
                </button>
            </div><br><br>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="ListMaterial">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขที่เอกสาร</th>
                            <th>เลขที่ใบสั่งซื้อ</th>
                            <th>รหัสวัสดุ</th>
                            <th>ชื่อวัสดุ</th>
                            <th>หน่วยนับ</th>
                            <th>สาขา</th>
                            <th>ที่เก็บ</th>
                            <th>จำนวน</th>
                            <th>ต้นทุน/หน่วย</th>
                            <th>จำนวนเงิน</th>
                            <th>การกระทำ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="background-color: #20a8d8;">
                            <td colspan="10">รวม</td>
                            <td colspan="2" style="text-align: left;">xx</td>
                        </tr>
                    </tfoot>
                </table>
            </div><hr>
            <!-- <div class="row col-md-12">
                <div  class="col-md-2"></div>
                <div  class="col-md-2"></div>
                <div  class="col-md-2"></div>
                <div  class="col-md-2"></div>
                <div style="text-align: right;" class="col-md-2"><label for="total">รวม </label></div>
                <div  class="form-group row col-md-2">
                    <input name="total" class="form-control" readonly="" value="{{number_format(4204800.00, 2)}}"/>
                </div>
            </div> -->
            <div class="card-footer">
                <center>
                    <button class="btn btn-success" id="save"><i class="fa fa-check-square" aria-hidden="true"></i>  บันทึก</button>
                    <button class="btn btn-danger " id="cancel"><i class="fa fa-times-rectangle" aria-hidden="true"></i> ยกเลิก</button>
                </center>
            </div>
        </div>
    </div>
</div>
<!-- เลือกข้อมูล -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info modal-lg" role="document" style="overflow-x:hidden;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    เลือกข้อมูล
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="FormInfo" method="post" class="form-horizontal" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="num" name="num" value="{{base64_encode($ref_id)}}">
                <input type="hidden" id="PoNOSearch" name="PoNO" value="">
                <!-- Start Body -->
                <div class="modal-body">
                    <div class="form-group col-md-6">
                        <label class="control-label">ที่เก็บ</label>
                        <select class="form-control" name="StockID">
                            <option value="">กรุณาเลือกที่เก็บ</option>
                            @foreach($warehouses as $val)
                            <option value="{{$val->id}}">{{$val->warehouse_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <th>รหัสวัสดุ</th>
                            <th>ชื่อวัสดุ</th>
                            <th>จำนวนรับสั่ง</th>
                            <th>จำนวนรับเข้า</th>
                            <th>หน่วยนับ</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>สกุลเงิน</th>
                            <th>กลุ่มสินค้า</th>
                            <th>ภาษี</th>
                            <th>สินค้า</th>
                            <th>รับวัสดุ</th>
                        </thead>
                        <tbody class="Po_data">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

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
                <input type="hidden" id="num" name="num" value="{{$ref_id}}">
                <!-- Start Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">รหัสวัสดุ</label>
                            <input name="MatCode" class="form-control" placeholder="Material No." value="" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">ชื่อวัสดุ</label>
                            <input name="MatDescription" class="form-control" placeholder="Material Name" value="" type="text">
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">หน่วยนับ</label>
                            <select class="form-control" name="MatUnit">
                                <option value="">กรุณาเลือกหน่วยนับ</option>
                                @foreach($units as $val)
                                <option value="{{$val->unit_id}}">{{$val->name_th}} ({{$val->name_en}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">สาขา</label>
                            <select class="form-control" id="defaultBranch" name="MatBranch">
                                <option value="">กรุณาเลือกสาขา</option>
                                @foreach($branchs as $val)
                                <option value="{{$val->BraID}}">{{$val->BraName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">ที่เก็บ</label>
                            <select class="form-control" name="StockID">
                                <option value="">กรุณาเลือกที่เก็บ</option>
                                @foreach($warehouses as $val)
                                <option value="{{$val->id}}">{{$val->warehouse_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">จำนวน</label>
                            <input name="MatQuantity" class="form-control" placeholder="Material Name" value="" type="text">
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">ต้นทุน/หน่วย</label>
                            <input name="MatPricePerUnit" class="form-control" placeholder="Cost/Unit" value="" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">จำนวนเงิน</label>
                            <input name="MatPrice" class="form-control" placeholder="Prices" value="" type="text">
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">เลขที่ใบสั่งซื้อ</label>
                            <input name="PoNO" class="form-control" placeholder="เลขที่ใบสั่งซื้อ" value="" type="text">
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
<!-- ./modal add -->
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
                <input id="editid" type="hidden" name="editid">
                <!-- Start Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">รหัสวัสดุ</label>
                            <input name="MatCode" id="MatCode" class="form-control" placeholder="Material No." value="" type="text" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">ชื่อวัสดุ</label>
                            <input name="MatDescription" id="MatDescription" class="form-control" placeholder="Material Name" value="" type="text" disabled>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">หน่วยนับ</label>
                            <select class="form-control" id="MatUnit" name="MatUnit">
                                <option value="">กรุณาเลือกหน่วยนับ</option>
                                @foreach($units as $val)
                                <option value="{{$val->unit_id}}">{{$val->name_th}} ({{$val->name_en}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">สาขา</label>
                            <select class="form-control" id="MatBranch" name="MatBranch">
                                <option value="">กรุณาเลือกสาขา</option>
                                @foreach($branchs as $val)
                                <option value="{{$val->BraID}}">{{$val->BraName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">ที่เก็บ</label>
                            <select class="form-control" id="StockID" name="StockID">
                                <option value="">กรุณาเลือกที่เก็บ</option>
                                @foreach($warehouses as $val)
                                <option value="{{$val->id}}">{{$val->warehouse_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">จำนวน</label>
                            <input name="MatQuantity" id="MatQuantity" class="form-control" placeholder="Material Name" value="" type="text">
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">ต้นทุน/หน่วย</label>
                            <input name="MatPricePerUnit" id="MatPricePerUnit" class="form-control" placeholder="Cost/Unit" value="" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">จำนวนเงิน</label>
                            <input name="MatPrice" id="MatPrice" class="form-control" placeholder="Prices" value="" type="text">
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">เลขที่ใบสั่งซื้อ</label>
                            <input name="PoNO" id="PoNO" class="form-control" placeholder="เลขที่ใบสั่งซื้อ" value="" type="text" disabled>
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
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script>
var dataTableList = $('#ListMaterial').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": url+"/Stock/StockAccept/ListMaterial",
        "data": function ( d ) {
            d.MatNoDoc = $('#num_doc').val();
        }
    },
    "columns": [
        { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
        { "data": "MatNoDoc" , "name":"MatNoDoc" },
        { "data": "PoNO" , "name":"PoNO"},
        { "data": "MatCode" , "name":"MatCode" , "className": "text-center" },
        { "data": "MatDescription" , "name":"MatDescription"},
        { "data": "MatUnit" , "name":"MatUnit" },
        { "data": "MatBranch" , "name":"MatBranch" },
        { "data": "StockID" , "name":"StockID" },
        { "data": "MatQuantity" , "name":"MatQuantity" },
        { "data": "MatPricePerUnit" , "name":"MatPricePerUnit" },
        { "data": "MatPrice" , "name":"MatPrice" },
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
    },
    "footerCallback": function (row, data, start, end, display) {
        var api = this.api(), data;
        var intVal = function (i) {
            return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
        };
        // Total over this page

        pageTotal = api.column(10, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0)
        // Update footer
        // $(api.column(1).footer()).html(pageTotal1);
        $(api.column(10).footer()).html(pageTotal);
    }
});

$('.datecalendar').daterangepicker({
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    }
});

$("#cancel").click(function() {
    swal({
        title: 'คุณต้องการยกเลิกและลบข้อมูลหรือไม่ ?',
        text: "หากต้องการยกเลิกและลบ กดปุ่ม 'ยืนยัน'",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.value==true) {
            var num = $("#num_doc").val();
            $.ajax({
                method : "GET",
                url : url+"/Stock/StockAccept/delete/"+num,
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
});

$("body").on('click', '.save', function () {
    var id = $(this).data('id');
    $("#" + id).modal('hide');
    $("#save").modal('show');
});

$('body').on('click', '.btn-add',function(){
    document.getElementById("FormPrimary").reset();
    var num = $('input[name=num_doc]').val();
    $("#num").val(num);
    $("#defaultBranch").val({{session('BraID')}});
    $( "#primaryModal" ).modal('show');
});

//end btn-add

$('body').on('click', '.btn-edit', function(){
    //  document.getElementById("FormWarning").reset();
    var id = $(this).data('id');
    var num = $("#num_doc").val();
    $.ajax({
        method : "POST",
        url : url+"/Stock/StockAccept/edit",
        dataType : 'json',
        data : {id:id, num:num}
    }).done(function(rec){
        $('#editid').val(rec.MatCode);
        $('#MatCode').val(rec.MatCode);
        $('#PoNO').val(rec.PoNO);
        $('#MatNoDoc').val(rec.MatNoDoc);
        $('#MatDescription').val(rec.MatDescription);
        $('#MatUnit').val(rec.MatUnit);
        $('#MatBranch').val(rec.MatBranch);
        $('#StockID').val(rec.StockID);
        $('#MatPricePerUnit').val(rec.MatPricePerUnit);
        $('#MatPrice').val(rec.MatPrice);
        $('#MatQuantity').val(rec.MatQuantity);
        $('#PoNO').val(rec.PoNO);
        $('#warningModal').modal('show');
    });
});//end btn-edit

$('body').on('click', '.btn-delete',function(){
    var id = $(this).data('id');
    var num = $("#num_doc").val();
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
                url : url+"/Stock/StockAccept/delete",
                dataType : 'json',
                data : {id:id , num:num}
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

$("#user_recorder, #user_recipient").val("{{Auth::user()->id}}");


$("body").on('change', '#department_id', function () {
    $('input#department_name').val($(this).find('option[value="'+$(this).val()+'"]').data('name'));
});

$( "#FormPrimary" ).validate({
    rules: {
        MatCode: "required",
        MatDescription: "required",
        MatUnit: "required",
        MatBranch: "required",
        StockID: "required",
        MatPrice: "required",
        MatPricePerUnit: "required",
        MatQuantity: "required",
        PoNO: "required",
    },
    messages: {
        MatCode: "กรุณาระบุ",
        MatDescription: "กรุณาระบุรายละเอียด",
        MatUnit: "กรุณาเลือกหน่วยนับ",
        MatBranch: "กรุณาเลือกสาขา",
        StockID: "กรุณาเลือกที่เก็บ",
        MatPrice: "กรุณาระบุราคา",
        MatPricePerUnit: "กรุณาระบุต้นทุนต่อหน่วย",
        MatQuantity: "กรุณาระบุจำนวน",
        PoNO: "กรุณาระบุเลขที่ใบสั่งซื้อ",
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
            url : url+"/Stock/StockAccept",
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
        MatUnit: "required",
        MatBranch: "required",
        // StockID: "required",
        MatPrice: "required",
        MatPricePerUnit: "required",
        MatQuantity: "required",
    },
    messages: {
        MatUnit: "กรุณาเลือกหน่วยนับ",
        MatBranch: "กรุณาเลือกสาขา",
        // StockID: "กรุณาเลือกที่เก็บ",
        MatPrice: "กรุณาระบุราคา",
        MatPricePerUnit: "กรุณาระบุต้นทุนต่อหน่วย",
        MatQuantity: "กรุณาระบุจำนวน",
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
            url : url+"/Stock/StockAccept/update",
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

$( "#StockMaterial" ).validate({
    rules: {
        num_doc: "required",
        date_doc: "required",
        department_id: "required",
        user_recorder: "required",
        user_recipient: "required",
    },
    messages: {
        num_doc: "กรุณาระบุเลขที่เอกสาร",
        date_doc: "กรุณาระบุวันที่เอกสาร",
        department_id: "กรุณาเลือกแผนก",
        user_recorder: "กรุณาเลือกผู้บันทึก",
        user_recipient: "กรุณาเลือกผู้รับสินค้า",
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
            url : url+"/Stock/StockAccept/updateStockMaterial",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            if(rec.type == 'success'){
                $('#infoModal').modal('hide');
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                }).then((rec) => {
                    if(rec) {
                        dataTableList.api().ajax.reload();
                        form.reset();
                        location.reload();
                    }
                });
            }else{
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                });
            }
        });
    }
});

$("#save").click(function() {
    $("#StockMaterial").submit();
});

$( "#FormInfo" ).validate({
    // rules: {
    //   StockID: "required",
    // },
    // messages: {
    //   StockID: "กรุณาเลือก",
    // },
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
            url : url+"/Stock/StockAccept/addMaterial",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            $('#FormInfo').modal('hide');
            if(rec.type == 'success'){
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                }).then((rec) => {
                    if(rec) {
                        dataTableList.api().ajax.reload();
                        form.reset();
                        location.reload();
                    }
                });
            }else{
                swal({
                    confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                });
            }
        });
    }
});

$('#search').click(function() {
    var search = $('input[name="search"]').val();
    $.ajax( {
        method: "POST",
        url: url+"/Stock/StockAccept/searchPurchaseOrder",
        data: {
            text_search : search,
        },
        success: function(result) {
            console.log(result.purchase.length);
            if(result.purchase.length !== 0) {
                $('.Po_data').empty();
                $('#num').val($('#num_doc').val());
                $('#PoNOSearch').val(search);
                var option = "";
                var option_group = "";
                var pro_group_id = "";
                $.each(result.unit, function(k, rec) {
                    option += "<option value="+rec.unit_id+">"+rec.name_th+"("+rec.name_en+")</option>";
                });
                $.each(result.group, function(k, rec) {
                    option_group += "<option value="+rec.id+">"+rec.ProGroupName+"</option>";
                });
                var i = 0;
                $.each(result.purchase, function(k, rec) {
                    $('.Po_data').append("<tr>"+
                    "<td>"+rec.MatCode+"</td>"+
                    "<td>"+rec.PoDescription+"</td>"+
                    "<td>"+rec.PoQTY+"</td>"+
                    "<td><input type='text' onfocus='if(this.value==\"\"){this.value=\"1\"}' name='MatQuantity["+i+"]' value="+(rec.PoQTY-rec.PoQTYAccept)+"></td>"+
                    "<td><select name='MatUnit["+i+"]'>"+
                    option+
                    "</select></td>"+
                    "<td>"+rec.PoUnitPrice+"</td>"+
                    "<td>"+rec.currency_name+"</td>"+
                    "<td><select name='ProGroupID["+i+"]'>"+
                    option_group+
                    "</select></td>"+
                    "<td>"+rec.PoTax+"</td>"+
                    "<td><input type='checkbox' name='ProStatus["+i+"]' value='Y'></td>"+
                    "<td><input type='checkbox' name='MatCode["+i+"]' value="+rec.MatCode+"></td>"+
                    "</tr>");
                    i++;
                });
                $('#infoModal').modal('show');
            } else {
                swal({
                    confirmButtonText:'ตกลง',title: "ค้นหาข้อมูล",text: "ไม่พบข้อมูล",type: "warning"
                });
            }
        },
        error: function() {
            swal({
                confirmButtonText:'ตกลง',title: "error",text: "กรุณาติดต่อผู้ดูแลระบบ",type: "error"
            });
        }
    });
});
$('body').on('focus, keyup', 'input[name*="MatQuantity"], input[name="MatPrice"], input[name="MatPricePerUnit"]', function() {
    if($(this).val()==0) {
        $(this).val(1);
    }
});
$('body').on('blur', 'input[name*="MatQuantity"], input[name="MatPrice"], input[name="MatPricePerUnit"]', function() {
    if($(this).val()=="") {
        $(this).val(1);
    }
});
</script>
@endsection
