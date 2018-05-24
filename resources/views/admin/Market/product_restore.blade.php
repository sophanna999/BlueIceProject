@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<title>{{$title}} | BlueIce</title>
<style media="screen">
.modal-maximize {
    max-width: 100%;
}
.modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
}
.modal-dialog {
    position: fixed;
    margin: 0;
    width: 100%;
    height: 100%;
    padding: 0;
}
.modal-content {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border: 2px solid #3c7dcf;
    border-radius: 0;
    box-shadow: none;
}
.modal-header {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    height: 50px;
    padding: 10px;
    background: #6598d9;
    border: 0;
}
.modal-title {
    font-weight: 300;
    font-size: 2em;
    color: #fff;
    line-height: 30px;
}
.modal-body {
    position: absolute;
    top: 50px;
    bottom: 60px;
    width: 100%;
    font-weight: 300;
    overflow: auto;
}
.modal-footer {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    height: 60px;
    padding: 10px;
    background: #f1f3f5;
}
::-webkit-scrollbar {
    -webkit-appearance: none;
    width: 10px;
    background: #f1f3f5;
    border-left: 1px solid darken(#f1f3f5, 10%);
}
::-webkit-scrollbar-thumb {
    background: darken(#f1f3f5, 20%);
}
</style>
@endsection

@section('body')
<div class="col-sm-12">
    <div class="card card-accent-primary">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> การส่งคืนสินค้าเข้าสต๊อก
        </div>
        <div class="card-body">

            <div class="table table-responsive" style="width: 100%; overflow-x: scroll;">
                <table id="list" class="table table-striped table-hover table-sm">
                    <thead class="table-info">
                        <tr>
                            <th>ลำดับ</th>
                            <th>รถบรรทุก</th>
                            <th>รอบการส่ง</th>
                            <th>วันที่ส่ง</th>
                            <th>การกระทำ</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-warning modal-maximize" role="document" style="overflow-x:hidden;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}
                    <i class="fa fa-angle-right" id="title-edit" aria-hidden="true"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="FormWarning" method="post" class="form-horizontal" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="TruckProID" id="TruckProID">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>จำนวนส่ง</th>
                                    <th>สินค้า</th>
                                    <th>จำนวนเบิก</th>
                                    <th>วัน/เวลาทีเบิก</th>
                                    <th>สินค้า</th>
                                    <th>จำนวนคืน</th>
                                    <th>จำนวนที่เสียหาย</th>
                                    <th>หน่วย</th>
                                    <th>วัน/เวลาที่คืน</th>
                                    <th>เลือก</th>
                                    <!-- <th>ยืนยัน</th> -->
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-warning update_store">บันทึก</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info modal-maximize" role="document" style="overflow-x:hidden;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}
                    <i class="fa fa-angle-right" id="title-detail" aria-hidden="true"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="FormInfo" method="post" class="form-horizontal" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="" id="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>สินค้า</th>
                                    <th>จำนวนเบิก</th>
                                    <th>หน่วย</th>
                                    <th>วัน/เวลาทีเบิก</th>
                                    <th>จำนวนเงินที่ขายได้</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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
<script type="text/javascript">
$('body').on('click','input:checkbox',function() {
    if($(this).is(':checked')) {
        $(this).closest('tr').find('input[name*="restore"]').rules("add", {
            required:true,
            number:true,
            messages: {
                required: "กรุณาระบุ",
                number: "ตัวเลขเท่านั้น",
            }
        });
        $(this).closest('tr').find('input[name*="corrupt"]').rules("add", {
            number:true,
            messages: {
                number: "ตัวเลขเท่านั้น",
            }
        });
    } else {
        $(this).closest('tr').find('input[name*="restore"]').rules("remove");
        $(this).closest('tr').find('input[name*="corrupt"]').rules("remove");
        $(this).closest('tr').find('.error').empty();
    }
});

var dataTableList = $('#list').dataTable({
    "focusInvalid": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": url+"/Market/ProductRestore/list",
        "data": function ( d ) {
            d.MatNoDoc = $('#num_doc').val();
        }
    },
    "columns": [
        { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
        { "data": "TruckNumber" , "name":"TruckNumber" },
        { "data": "RoundAmount" , "name":"RoundAmount" },
        { "data": "TruckDate" , "name":"TruckDate" },
        { "data": "action" , "name":"action" , "className": "text-center" ,"orderable": false, "searchable": false },
    ],
    "order":[3,'desc'],
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
$('body').on('click', '.btn-edit', function(){
    document.getElementById("FormWarning").reset();
    var id = $(this).data('id');
    $.ajax({
        method : "POST",
        url : url+"/Market/ProductRestore/edit",
        dataType : 'json',
        data : {id:id}
    }).done(function(rec){
        $('#title-edit').html(' แก้ไข <i class="fa fa-angle-right" id="title-detail" aria-hidden="true"></i> ทะเบียนรถ : '+rec.product[0].TruckNumber);
        var str = '<tr>';
        var index = 0;
        var check_no = 0;
        var check_index = -1;
        $.each(rec.product,function(k,v) {
            check_index = check_no;
            var status = (v.status==='T')?'disabled':'';
            var checked =  (v.status==='T')?'checked':'';
            var corupt = '';
            var restore = '';
            if((v.status==='T')) {
                corupt = (v.p_cor!=null)?v.p_cor:0;
                restore = (v.ProRestore!=null)?v.ProRestore:0;
            } else {

            }
            if(checked=='') {
                ++check_no;
                cheek_index = check_no;
            } else {
                check_index = 100000;
            }
            index++;
            str+='\n\
            <td>'+index+'</td>\n\
            <td>'+v.ProName+'</td>\n\
            <td>'+v.ProNumber+'</td>\n\
            <td>'+v.TruckDate+'</td>\n\
            <td>'+v.ProName+'</td>\n\
            <td><input type="text" name="restore['+check_index+']" class="form-control" value="'+restore+'" '+status+'></td>\n\
            <td><input type="text" name="corrupt['+check_index+']" class="form-control" value="'+corupt+'" '+status+'></td>\n\
            <td>'+v.name_th+'</td>\n\
            <td><input type="text" name="dateRestore['+check_index+']" class="datecalendar form-control" '+status+'></td>\n\
            <td style="text-align:center;vertical-align:middle;"><input type="checkbox" class="BomID" id="BomID[]" name="BomID['+check_index+']" value="'+v.BomID+'" '+status+' '+checked+'></td>\n\
            <!--<td><button type="button" class="btn btn-warning">ยืนยัน</button></td>-->\n\
            </tr>';
        });
        $('#TruckProID').val(id);
        $('#FormWarning').find('tbody').empty();
        $('#FormWarning').find('tbody').append(str);
        $('.datecalendar').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        if(rec.payment.length!=0) {
            var chk = [];
            $.each(rec.payment,function(k,v) {
                chk.push(v.BomID);
            });
            $.each($('#FormWarning').find('input:checkbox'),function(key,val) {
                var aa = $(this).val();
                var bb = $(this);
                if(!$.inArray(aa, chk)) {
                    // console.log(123);
                    $.each(rec.payment,function(k,v) {
                        // console.log(aa+" "+v.BomID);
                        if(aa==v.BomID) {
                            bb.closest('tr').find('td:first').after('<td>'+v.sale+'</td>');
                        }
                    });
                } else {
                    bb.closest('tr').find('td:first').after('<td>0</td>');
                }
            });
        } else {
            $('#FormWarning').find('input:checkbox').closest('tr').find('td:first').after('<td>0</td>');
        }
        $('#warningModal').modal('show');
    });
});//end btn-edit

$('body').on('click', '.btn-detail', function(){
    document.getElementById("FormInfo").reset();
    var id = $(this).data('id');
    $.ajax({
        method : "POST",
        url : url+"/Market/ProductRestore/edit",
        dataType : 'json',
        data : {id:id}
    }).done(function(rec){
        $('#title-detail').html(' รายละเอียดข้อมูล <i class="fa fa-angle-right" id="title-detail" aria-hidden="true"></i> '+id);
        var str = '<tr>';
        var index = 0;
        $.each(rec,function(k,v) {
            index++;
            str+='\n\
            <td>'+index+'</td>\n\
            <td>'+v.ProName+'</td>\n\
            <td>'+v.ProNumber+'</td>\n\
            <td>'+v.name_th+'</td>\n\
            <td>'+v.TruckDate+'</td>\n\
            <td>a</td>\n\
            </tr>';
        });
        $('#FormInfo').find('tbody').empty();
        $('#FormInfo').find('tbody').append(str);
        $('#infoModal').modal('show');
    });
});//end btn-detail

// $('body').on('click','.update_store', function(){
// console.log($(this));
//   if (!$('#BomID').prop('checked')) {
//     $('#BomID').closest('div').find('span').remove();
//     $('#BomID').closest('div').append('<span id="BomID-error" class="help-block">This field is required.</span>');
//   }

// });

$( "#FormWarning" ).validate({
    rules: {
    },
    messages: {
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
            url : url+"/Market/ProductRestore/update",
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
