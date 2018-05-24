@extends('layouts.admin')
@section('csstop')
@endsection

@section('body')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> {{$title}}
            </div>
            <div class="card-body">
                <form id="UpdateRef">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row col-md-12">
                        <label class="col-sm-2 col-form-label">กำหนดรูปแบบเอกสาร</label>
                        <div class="col-sm-4 form-group">
                            <select class="form-control" name="BraID" id="BraID" onchange="changeBranch(this.value)">
                                <option value="">เลือกสาขา</option>
                                @foreach($Branch as $bra)
                                <option value="{{$bra->BraID}}">{{$bra->BraName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select class="form-control" name="ref_id" id="ref_id">
                                <option value="">เลือกรูปแบบเอกสาร</option>
                                @foreach($RefType as $ref)
                                <option value="{{$ref->ref_id}}">{{$ref->ref_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary ">
                                บันทึก
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="col-md-12 row">
                    <!-- <label class="col-sm-2 col-form-label">ตรวจสอบเอกสาร</label>
                    <div class="form-group col-md-4">
                        <select class="form-control" name="SupTambon">
                            <option value="">เลือกสาขา</option>
                            @foreach($Branch as $bra)
                            <option value="{{$bra->BraID}}">{{$bra->BraName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group date datecalendare">
                            <input id="datedoc" name="datedoc" class="form-control" value="201712" placeholder="yyyymm" type="text">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary ">
                            ค้นหา
                        </button>
                    </div> -->
                    <?php
                        $refid=0;
                        $format = array('PURCHASE ORDER','INVOICE','BOM','ใบเบิกวัสดุ','ใบคืนวัสดุ','ใบเปิดสินค้า');
                        $j=0;$k=0;
                        foreach($RefType as $ref){
                            $f[$k] = $ref->ref_format;
                            //$rformat[$k] = $f[$k];
                            $rformat[$k] = explode(",",$f[$k]);
                            $k++;
                        }
                    ?>
                    <!-- <table class="table table-striped" id="RefNumberList">
                      <thead>
                        <tr>
                          <th scope="col">หัวข้อ</th>
                          <th scope="col">รูปแบบเอกสาร</th>
                          <th scope="col">เอกสารล่าสุด</th>
                          <th scope="col">จำนวน</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table> -->

                    <div class="form-group col-12">
                        <hr>
                        <div class="form-inline">
                            <div class="col-sm-4 text-left">หัวข้อ</div>
                            <div class="col-sm-4 text-left">รูปแบบเอกสาร</div>
                            <div class="col-sm-4 text-left">เลขเที่อกสารล่าสุด</div>
                            <!-- <div class="col-sm-3 text-center">จำนวน</div> -->
                        </div>
                        <hr>
                    </div>

                    <div class="form-group col-12 show">
                        <div class="form-inline">
                            <div class="col-md-12 text-center" style="color:red;"><h4>ยังไม่เลือก</h4></div>
                            <!-- <div class="col-sm-4 text-center"></div>
                            <div class="col-sm-4 text-center"></div>
                            <div class="col-sm-4 text-center"></div> -->
                            <!-- <div class="col-sm-3 text-center">20</div> -->
                        </div>
                    </div>
                    <?php $j++; ?>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('jsbottom')
<script>
//     var RefNumberList = $('#RefNumberList').dataTable({
//     "focusInvalid": false,
//     "processing": true,
//     "serverSide": true,
//     "ajax": {
//       "url": url + "/BranchManagement/RefNumberManage/RefNumberList",
//       "data": function (d) {
//       }
// },
// "columns": [
//   {"data": "InvDate","name": "InvDate", "className": "text-center"},
//   {"data": "InvID", "name": "InvID", "className": "text-center"},
//   {"data": "CusNO", "name": "CusNO", "className": "text-center"},
//   {"data": "SubToTal", "name": "SubToTal", "className": "text-center"},
//   {"data": "SubToTal", "name": "SubToTal", "className": "text-center"},
//   {"data": "Pay", "name": "Pay", "className": "text-center"},
//   {"data": "Pay", "name": "Pay", "className": "text-center"},
//   {"data": "Pay", "name": "Pay", "className": "text-center"},
//   {"data": "Accured", "name": "Accured", "className": "text-center"},
//   {"data": "Accured", "name": "Accured", "className": "text-center"},
//   {"data": "action", "name": "action", "className": "text-center", "orderable": false, "searchable": false},
// ],
//   "language": {
//     "paginate": {
//       "previous": "ก่อน",
//       "next": "ต่อไป"
//     },
//     "lengthMenu": "แสดง _MENU_ รายการ ต่อ หน้า",
//     "search": "ค้นหา",
//     "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
//     "info": "แสดง หน้า _PAGE_ จาก _PAGES_",
//     "infoEmpty": "ไม่มีข้อมูลบันทึก",
//     "infoFiltered": "(ค้นหา จากทั้งหมด _MAX_ รายการ)",
//   },
//   responsive: true,
//   "drawCallback": function (settings) {
//   }
// });
    $( "#UpdateRef" ).validate({
        rules: {
            ref_id: "required",
            BraID: "required",
        },
        messages: {
            ref_id: "กรุณาเลือก",
            BraID: "กรุณาเลือก",
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
                url : url+"/BranchManagement/RefNumberManage/update",
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

    function changeBranch(value){
        if(value!='') {
            $('#ref_id').prop('disabled',false);
            $.ajax({
                method : "GET",
                url : url+"/BranchManagement/RefNumberManage/"+value,
                dataType : 'json',
            }).done(function(rec){
                console.log(rec);
                $('#ref_id').val(rec.ref_id);
                $('.show').empty();
                $.each(rec.ref_format,function(k,v) {
                    console.log(v);
                    console.log(rec.ref_ym_format[k]);
                    $('.show').append(`
                        <div class="form-inline">
                            <div class="col-sm-4 text-left">`+v+`</div>
                            <div class="col-sm-4 text-left">`+rec.ref_ym_format[k]+`</div>
                            <div class="col-sm-4 text-left">`+rec.num[k]+`</div>
                        </div>
                    `);
                });
            });
        } else {
            $('#ref_id').prop('disabled',true);
            $('#ref_id').val('');
        }
    }
    $('#ref_id').change(function() {
        $.ajax({
            method : "GET",
            url : url+"/BranchManagement/RefNumberManage/"+$('#BraID').val()+"/"+$(this).val(),
            dataType : 'json',
        }).done(function(rec){
            console.log(rec);
            // $('#ref_id').val(rec.ref_id);
            $('.show').empty();
            $.each(rec.ref_format,function(k,v) {
                // console.log(v);
                console.log(rec.ref_ym_format[k]);
                $('.show').append(`
                    <div class="form-inline">
                        <div class="col-sm-4 text-left">`+v+`</div>
                        <div class="col-sm-4 text-left">`+rec.ref_ym_format[k]+`</div>
                        <div class="col-sm-4 text-left">`+rec.num[k]+`</div>
                    </div>
                `);
            });
        });
    });
</script>
@endsection
