@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
@endsection

@section('body')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header" style="width: 100%">
            <i class="fa fa-align-justify"></i><strong>การจัดการรายจ่ายซื้อวัตถุดิบ</strong>
            <div class="row pull-center">
                <div class="col-sm-4" style="width: 100%"></div>
                <form action="" method="post" class="form-inline">
                    <br>
                    <div class="form-group date">
                        <label for="datedoc"></label>
                        <input type="text" name="start" class="form-control datecalendar start">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" style="margin-top:-1px">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="datedoc">&nbsp; ถึง &nbsp;</label>
                        <input type="text" name="stop" class="form-control date datecalendar stop">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" style="margin-top:-1px">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <!-- <div class="pull-right" style="margin-top:-35px;margin-right: 114px;">
                <button type="button" class="btn btn-primary fa fa-search" style="width:90px; height: 40px">&nbsp; ค้นหา</button>
            </div> -->
            <div class="pull-right" style="margin-top:-35px;">
                <button type="button" class="btn btn-primary fa fa-plus" data-toggle="modal" data-target="#myModal" style="width:90px; height: 40px"> เพิ่ม</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm" id="List">
                    <thead>
                        <tr>
                            <th style="text-align:center;vertical-align:middle;" rowspan="2"><b>วันที่สั่งซื้อ</b></th>
                            <td style="text-align:center;" colspan="5"><b>การจัดการรายจ่ายซื้อวัตถุดิบ</b></td>
                            <th style="text-align:center;vertical-align:middle;" rowspan="2"><b>การกระทำ</b></th>
                        </tr>
                        <tr>
                            <!-- <th>วันที่สั่งซื้อ</th> -->
                            <th>หมวดบัญชี</th>
                            <th>หมวดบัญชี</th>
                            <th>จำนวน</th>
                            <th>ราคารวม(บาท)</th>
                            <th>ราคารวม(ริงกิต)</th>
                            <!-- <th>การกระทำ</th> -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">การจัดการรายจ่ายซื้อวัตถุดิบ</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="date">วันที่สั้งซื้อ</label>
                        <div class="input-group date datecalendar">
                            <input type="text" id="datedoc" name="datedoc" class="form-control" placeholder="dd/mm/yyyy">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary ">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="product">รายการวัตถุดิบ</label>
                        <select class="form-control" id="product">
                            <option>ขวดน้ำ</option>
                            <option>กระสอบ</option>
                            <option>ลังใส่ขวดน้ำ</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="num">ร้านค้า</label>
                        <input type="text" class="form-control" name="store" id="store" placeholder="ร้านค้า">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="price">ราคารวม</label>
                        <div class="input-group">
                            <input type="number" id="price" name="price" class="form-control" placeholder="ราคารวม">
                            <span class="input-group-btn">
                                <select class="form-control form-info" id="ccmonth">
                                    <option>บาท</option>
                                    <option>ริงกิต</option>
                                </select>
                            </span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="ProID">จำนวน</label>
                            <input type="number" class="form-control" name="ProID" id="ProID" min="0" max="100" placeholder="จำนวน">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" data-dismiss="modal" style="width:60px; height: 40px">บันทึก</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>
<!-- Modal -->
<div id="MyDelete" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">คุณต้องการลบหรือไม่</h4></center>
            </div>
            <div class="modal-body">
                <center>
                    <button type="submit" class="btn btn-danger" data-dismiss="modal" style="width:60px; height: 40px">ลบ</button>
                    <button type="button" class="btn btn" data-dismiss="modal" style="width:60px; height: 40px">ปิด</button>
                </center>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script>
$('.datecalendar').daterangepicker({
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    }
});
$(function() {
    var List = $('#List').dataTable({
        "focusInvalid": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url+"/Accounting/MaterialExpenditure/list",
            "data": function ( d ) {
                d.start = $('.start').val();
                d.stop = $('.stop').val();
            }
        },
        "columns": [
            { "data": "PoDate" , "name":"PoDate" },
            { "data": "Podescription" , "name":"Podescription"},
            { "data": "SupName" , "name":"SupName" },
            { "data": "sum" , "name":"sum" },
            { "data": "bath" , "name":"bath" ,"orderable": false, "searchable": false },
            { "data": "ringgit" , "name":"ringgit" ,"orderable": false, "searchable": false },
            { "data": "action" , "name":"action" ,"orderable": false, "searchable": false },
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
    $('.start, .stop').change(function() {
        List.api().ajax.reload();
    });
});
</script>
@endsection
