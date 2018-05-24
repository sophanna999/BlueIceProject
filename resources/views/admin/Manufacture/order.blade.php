@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
@endsection

@section('body')
<div class="col-md-12">
<form class="AddAllOrder" id="AddAllOrder">
    <div class=" card card-accent-success">
        <div class="card-header">
            <b class="text_head">ใบสั่งผลิตสินค้า</b>
            <!--<a href="#" class="btn btn-success pull-right"> ใบสั่งผลิตสินค้า</a>-->
        </div>
        <div class="card-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="bom_no">เลขที่ใบสั่งผลิต:</label>
                    <div class="input-group">
                        <input type="text" id="bom_no" name="bom_no" class="form-control" placeholder="" value="{{$po_id}}" readonly>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="bom_date">วันที่ออกใบสั่งผลิต :</label>
                    <div class="input-group date">
                        <input type="text" id="bom_date" name="bom_date" class="form-control dateproduct" value="" placeholder="dd/mm/yyyy">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="bom_date_start">วันที่เริ่มผลิต :</label>
                    <div class="input-group date">
                        <input type="text" id="bom_date_start" name="bom_date_start" class="form-control dateproduct" value="" placeholder="dd/mm/yyyy">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="bom_date_end">วันที่คาดว่าจะเสร็จ :</label>
                    <div class="input-group date">
                        <input type="text" id="bom_date_end" name="bom_date_end" class="form-control dateproduct" placeholder="dd/mm/yyyy">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary ">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div><!-- end row -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="department_id">แผนกผลิต :</label>
                    <div class="input-group">
                        <select class="form-control" name="department_id" id="department_id">
                            <option value="">กรุณาเลือก</option>
                            @foreach($departments as $department)
                            <option value="{{$department->department_id}}">{{$department->department_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="branch_id">ผู้บันทึก :</label>
                    <select class="form-control" name="branch_id" id="branch_id">
                        @foreach($branchs as $branch)
                        <option value="{{$branch->BraID}}">{{$branch->BraName}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="numdoc">ผู้บันทึก :</label>
                    <div class="input-group">
                        {{$user}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="bom_comment">หมายเหตุ :</label>
                    <div class="input-group">
                        <textarea class="form-control" name="bom_comment" id="bom_comment"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="pull-right">
                <a href="#" style="width: 100px;" class="btn btn-primary btn-add" data-toggle="modal" data-target="#create">
                    <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
                </a>
            </div>
            <table class="table table-striped table-bordered table-autosort table-responsive-sm table-hover table-outline mb-0" cellspacing="0" width="100%" id="myTable">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 2%;">#</th>
                        <th style="text-align: center; width: 10%;">รหัสงาน</th>
                        <th style="text-align: center; width: 23%;">สินค้า</th>
                        <!-- <th style="text-align: center; width: 10%;">ผลิต(ขวด)</th> -->
                        <th style="text-align: center; width: 10%;;">หนวยผลิต</th>
                        <th style="text-align: center; width: 10%;">ไลน์ผลิต</th>
                        <th style="text-align: center; width: 10%;">วันเริ่ม</th>
                        <th style="text-align: center; width: 10%;">วันเสร็จ</th>
                        <th style="text-align: center;">คำอธิบาย</th>
                        <th style="text-align: center; width: 5%;">ลบ</th>
                    </tr>
                </thead>
                <tbody class="detail">
                    @php ($i=0)
                    @foreach($ProData as $k => $val)
                    <tr>
                        <input type="hidden" name="pro_id[{{$k}}]" value="{{$val->ProID}}">
                        <td class="no" style="text-align: center;">{{++$i}}</td>
                        <td style="text-align: center;"><input name="task_no[{{$k}}]" class="form-control" value="0002" readonly></td>
                        <td>{{$val->ProName}}</td>
                        <!-- <td> <input style="text-align: right;" name="amount[{{$k}}]" class="form-control" type="text"></td> -->
                        <td> <input style="text-align: right;" name="package_amount[{{$k}}]" class="form-control" type="text"></td>
                        <td>
                            <select class="form-control" name="matchine_id[{{$k}}]">
                                <option value="">กรุณาเลือก</option>
                                @foreach($matchines as $matchine)
                                <option value="{{$matchine->MachID}}">{{$matchine->MachName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <div class="input-group date">
                                <input type="text" class="form-control dateproduct" name="pro_start[{{$k}}]" id="pro_start" value="" placeholder="dd/mm/yyyy">
                            </div>
                            <!-- From: <input type="text" id="txtFromDate" />
                            To: <input type="text" id="txtToDate" /> -->
                        </td>
                        <td>
                            <div class="input-group date">
                                <input type="text" class="form-control dateproduct" name="pro_end[{{$k}}]" id="pro_end" value="" placeholder="dd/mm/yyyy">
                            </div>
                        </td>
                        <td><textarea class="form-control" name="detailer[{{$k}}]" style="width: 100%;"></textarea></td>
                        <td style="text-align: center;" class="sorting_1">
                            <a href="#" class="btn btn-danger btn-delete" data-value="{{$val->ProID}}">
                                <i class=" fa fa-trash" aria-hidden="true"></i> ลบ
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer" style="text-align: center;">
            <a href="#" class="btn btn-success save"><i class="fa fa-check-square" aria-hidden="true" style="margin-top: 1px; "></i>  บันทึก</a>
            <a href="#" class="btn btn-danger btn-cancel"><i class="fa fa-times-rectangle" aria-hidden="true" style="margin-top: 1px;"></i> ยกเลิก</a>
            <!-- <a href="#" class="btn btn-outline-warning active "><i class="fa fa-print" aria-hidden="true"></i> พิมพ์</a> -->
        </div>
    </div>
</form>
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
            <form id="FormPrimary">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Start Body -->
                <div class="modal-body">
                    <div id="table">
                        <table class="datatable table table-bordered table-striped table-sm">
                            <thead>
                                <th style="text-align: center; width:50%;">รหัสสินค้า</th>
                                <th style="text-align: center;">ชื่อสินค้า</th>
                                <th style="text-align: center; width:20%;">เลือก</th>
                            </thead>
                            <tbody>
                                @foreach($bom as $val)
                                <tr>
                                    <td>{{$val->ProID}}</td>
                                    <td>{{$val->ProName}}</td>
                                    <td><center><input value="{{$val->ProID}}" type="checkbox" name="ProID[]" /></center></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
</div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<!-- <script src="{{asset('js/daterangepicker/bootstrap-datetimepicker.min.js')}}"></script> -->
<script>
var check_arr = new  Array();
@foreach($ProID as $val)
check_arr.push("{{$val}}");
@endforeach
numTask(check_arr);
$('#BraID').val({{session('BraID')}});
$('.dateproduct').daterangepicker({
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    }
});

$(document).ready(function () {
    $('#myTable').DataTable();
});

$("body").on('click', '.save', function () {
    var id = $(this).data('id');
    //        alert(id);
    $("#" + id).modal('hide');
    $("#save").modal('show');
});

$('body').on('click', '.btn-add',function(){
    document.getElementById("FormPrimary").reset();
    $.each(check_arr,function(key,val) {
        var check_val = $('body').find('input:checkbox[value="'+val+'"]').val();
        if(check_val) {
            $('body').find('input:checkbox[value="'+val+'"]').closest('tr').hide();
        }
    });
    $( "#primaryModal" ).modal('show');
});//end btn-add

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
            method : "GET",
            url : url+"/Manufacture/ProductOrdering/findProduct",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            if(rec) {
                var matchine = '<option value="">กรุณาเลือก</option>';
                $.each(rec.matchines, function(k,v) {
                    matchine += '<option value="'+v.MachID+'">'+v.MachName+'</option>';
                });
                $.each(rec.ProData, function(k,v) {
                    var index = check_arr.length;
                    check_arr.push(v.ProID);
                    $('tbody.detail').append('<tr>\n\
                    <input type="hidden" name="pro_id['+index+']" value="'+v.ProID+'">\n\
                    <td style="text-align: center;" class="no"></td>\n\
                    <td style="text-align: center;"><input class="form-control" name="task_no['+index+']" value="0002" readonly></td>\n\
                    <td>'+v.ProName+'</td>\n\
                    <!--<td><input class="form-control" style="text-align: right;" name="amount['+index+']" type="text"></td>-->\n\
                    <td><input class="form-control" style="text-align: right;" name="package_amount['+index+']" type="text"></td>\n\
                    <td>\n\
                    <select class="form-control"  name="matchine_id['+index+']">'+matchine+'\n\
                    </select>\n\
                    </td>\n\
                    <td>\n\
                    <div class="input-group date">\n\
                    <input type="text" name="pro_start['+index+']" class="form-control dateproduct" value="{{date("Y-m-d")}}" placeholder="dd/mm/yyyy">\n\
                    </div>\n\
                    </td>\n\
                    <td>\n\
                    <div class="input-group date">\n\
                    <input type="text" class="form-control dateproduct" name="pro_end['+index+']" value="{{date("Y-m-d")}}" placeholder="dd/mm/yyyy">\n\
                    </div>\n\
                    </td>\n\
                    <td><textarea name="detailer['+index+']" style="width: 100%;" class="form-control"></textarea></td>\n\
                    <td style="text-align: center;" class="sorting_1">\n\
                    <a href="#" class="btn btn-danger btn-delete" data-value="'+v.ProID+'">\n\
                    <i class=" fa fa-trash" aria-hidden="true"></i> ลบ\n\
                    </a></td>\n\
                    </tr>');
                });
                index();
                numTask(check_arr);
                $('#primaryModal').modal('hide');
                $('.dateproduct').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            } else {
                $('#primaryModal').modal('hide');
            }
        });
    }
});
$('body').on('click','.btn-delete',function() {
    $(this).closest('tr').remove();
    check_arr.pop($(this).data('value'));
    $('body').find('input:checkbox[value="'+$(this).data('value')+'"]').closest('tr').show();
    index();
    numTask(check_arr);
});
function index() {
    var i = 0;
    $('body').find('.no').each(function() {
        $(this).text(++i)
    });
}
$( "#AddAllOrder" ).validate({
    rules: {
        department_id: "required",
    },
    messages: {
        department_id: "กรุณาเลือก",
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
            url : url+"/Manufacture/ProductOrdering",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            if(rec.type == 'success'){
                swal({
                  confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
                }).then((rec) => {
                  window.location.href = "{{url('Manufacture/ProductOrdering')}}";
                });
              form.reset();
            }else{
              swal({
                confirmButtonText:'ตกลง',title: rec.title,text: rec.text,type: rec.type
              });
            }
        });
    }
});
$('.save').click(function() {
    $.each($('#AddAllOrder').find('select[name*="matchine_id"]'),function(k,v) {
        $(this).rules('add',{
            required: true,
            messages: {
                required: "กรุณาเลือก",
            }
        });
        $(this).closest('tr').find('input[name*="amount"]').rules('add',{
            number: true,
            required: true,
            messages: {
                number: "ตัวเลขเท่านั้น",
                required: "กรุณาระบุ",
            }
        });
        $(this).closest('tr').find('input[name*="package_amount"]').rules('add',{
            number: true,
            required: true,
            messages: {
                number: "ตัวเลขเท่านั้น",
                required: "กรุณาระบุ",
            }
        });
    });
    $('#AddAllOrder').submit();
});
function numTask(data) {
    $.ajax({
        method : "GET",
        url : url+"/Manufacture/ProductOrdering/numTask",
        dataType: 'json',
        data : {num:data}
    }).done(function(rec){
        var i = 0;
        $('input[name*="task_no"]').each(function() {
            $(this).val(rec.num[i]);
            i++;
        });
    });
}

$("body").on('click','.btn-cancel', function(){
    swal({
      title: 'คุณต้องการยกเลิกรายการจริงหรือไหม?',
      text: "หากต้องการยกเลิก กดปุ่ม 'ยืนยัน'",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: "ยกเลิก"
    }).then((result) => {
      if (result.value) {
        window.location = url+"/Manufacture/ProductOrdering";
      }
    })
});

</script>
@endsection
