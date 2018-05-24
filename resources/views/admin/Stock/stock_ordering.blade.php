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
                                <th class="text-center">เลขที่ใบสั่งซื้อ</th>
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
                                    <th class="text-center">#ITEM</th>
                                    <th class="text-center">DESCRIPTION</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-center">UNIT PRICE</th>
                                    <th class="text-center">TAX</th>
                                    <th class="text-center">TOTAL</th>
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

@endsection
@section('jsbottom')
<!-- DataTables -->
<script>
var dataTableList = $('#ListCurrency').dataTable({
  "focusInvalid": false,
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": url+"/Stock/StockOrdering/List",
    "data": function ( d ) {
    }
  },
  "columns": [
    { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
    { "data": "PoNO" , "name":"PoNO" },
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
  window.location = url+'/Stock/SystemMaterial';
});

$('body').on('click', '.btn-detail', function(){
    var id = $(this).data('id');
    $.ajax({
        method : "POST",
        url : url+"/Stock/StockOrdering/show",
        dataType : 'json',
        data : {id:id}
    }).done(function(rec){
        $('#DetailList').empty();
        $.each( rec, function( key, value ) {
            var sum = value.PoQTY*value.PoUnitPrice;
            var tax = (sum*value.PoTax)/100;
            var total = sum+tax;
            var html = '';
            html +=
                '<tr class="text-center">\
                    <td>'+(key+1)+'</td>\
                    <td>'+value.PoDescription+'</td>\
                    <td>'+value.PoQTY+'</td>\
                    <td>'+value.PoUnitPrice+'</td>\
                    <td>'+value.PoTax+'</td>\
                    <td>'+total+'</td>\
                </tr>';
            $("#DetailList").append(html);
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
                url : url+"/Stock/StockOrdering/delete",
                dataType : 'json',
                data : {id : id}
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

// $('body').on('click','.btn-print',function() {
//     var id = $(this).data('id');
//     $.ajax({
//         method : "POST",
//         url    : url+"/Stock/StockOrdering/prints",
//         dataType : 'json',
//         data : {id:id}
//     });
//     // window.location.href = url+"/Stock/StockOrdering/prints/"+$(this).data('id');
// });
$('body').on('click','.btn-print',function() {
    window.location.href = url+"/Stock/StockOrdering/prints/"+$(this).data('id');
});
</script>

<!-- Form -->
@endsection
