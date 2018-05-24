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
                    <table class="table table-striped table-hover table-sm" id="ListCurrency">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">เลขที่ใบรับวัสดุ</th>
                                <th class="text-center">การกระทำ</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document" style="overflow-x:hidden;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}
                    <i class="fa fa-angle-right" aria-hidden="true"></i>เพิ่มข้อมูล
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">เลขที่เอกสาร</th>
                                    <th class="text-center">เลขที่ใบสั่งซื้อ</th>
                                    <th class="text-center">รหัสวัสดุ</th>
                                    <th class="text-center">ชื่อวัสดุ</th>
                                    <th class="text-center">หน่วยนับ</th>
                                    <th class="text-center">สาขา</th>
                                    <th class="text-center">ที่เก็บ</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="text-center">ต้นทุน/หน่วย</th>
                                    <th class="text-center">จำนวนเงิน</th>
                                </tr>
                            </thead>
                            <tbody id='DetailList'>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
<!-- /.conainer-fluid -->
@endsection

@section('jsbottom')
<script>

    var dataTableList = $('#ListCurrency').dataTable({
        "focusInvalid": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url+"/Stock/StockShow/listShow",
            "data": function ( d ) {

            }
        },
        "columns": [
            { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
            { "data": "no_doc" , "name":"no_doc" },
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

    $('body').on('click', '.btn-add',function(){
        window.location = url+'/Stock/StockAccept';
    });

    $('body').on('click', '.btn-detail', function(){
        var id = $(this).data('id');
        // $('#detailModal').modal('show');
        $.ajax({
            method : "POST",
            url : url+"/Stock/StockShow/show",
            dataType : 'json',
            data : {id:id}
        }).done(function(rec){
            $('#DetailList').empty();
            $.each( rec, function( key, value ) {
                // console.log(value);
                // html +=
                $('#DetailList').append(
                    '<tr class="text-center">\
                        <td>'+(key+1)+'</td>\
                        <td>'+value.MatNoDoc+'</td>\
                        <td>'+value.PoNO+'</td>\
                        <td>'+value.MatCode+'</td>\
                        <td>'+value.MatDescription+'</td>\
                        <td>'+value.name_th+'</td>\
                        <td>'+value.BraName+'</td>\
                        <td>'+((value.warehouse_name)?value.warehouse_name:'ไม่ระบุ')+'</td>\
                        <td>'+value.MatQuantity+'</td>\
                        <td>'+value.MatPricePerUnit+'</td>\
                        <td>'+value.MatPrice+'</td>\
                    </tr>'
                    );
                // $("#DetailList").append(html);
            });
            $('#detailModal').modal('show');
        });
    });

    $('body').on('click', '.btn-delete',function(){
        var id = $(this).data('id');
        swal({
            title:'คุณต้องการลบข้อมูลหรือไม่ ?',
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
                    url : url+"/Stock/StockShow/delete",
                    dataType : 'json',
                    data : {id:id}
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

$('body').on('click','.btn-print',function() {
    window.location.href = url+"/Stock/StockOrdering/PrintStockShow/"+$(this).data('id');
});

</script>

<!-- Form -->
@endsection
