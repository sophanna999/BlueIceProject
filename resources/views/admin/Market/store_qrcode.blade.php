@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
@endsection
@section('body')
<div class="col-lg-12">
    <div class="card card-accent-primary">
        <div class="card-header">
            <i class="fa fa-align-justify"></i>การสร้าง QR Code ลูกหรับลูกค้า
            <div class="pull-right">
                <form id="formprint" action="{{url('/Market/StoreQRCode/getPrintQRCode')}}" method="post" target="_blank">
                    {{ csrf_field() }}
                    <input type="hidden" id="getCheck" name="getCheck" class="form-control" readonly/>
                    <button type="submit" class="btn btn-primary fa fa-print print">&nbsp;ปริ้นที่เลือก</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                <table class="table table-striped table-hover table-sm" id="listCustomer" style="width: 100%;">
                    <thead class="table-info">
                        <tr>
                            <td style="widtd: 63px;;vertical-align:middle" rowspan="2"><center>ลำดับ</center></td>
                    <td style="widtd: 63px;;vertical-align:middle" rowspan="2"><center>รหัสลูกค้า</center></td>
                    <td style="widtd: 123px;vertical-align:middle;" rowspan="2"><center>ชื่อลูกค้า</center></td>

                    <td style="widtd: 30%;vertical-align:middle;" rowspan="2"><center>ที่อยู่</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>ถนน</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>อำเถอ</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>เมือง</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>จังหวัด</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>ไปรษณีย์</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>ประเทศ</center></td>

                    <td rowspan="2" style="vertical-align:middle;"><center>เบอร์โทรศัพท์</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>มือถือ</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>แฟกซ์</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>QR Code</center></td>
                    <td rowspan="2" style="vertical-align:middle;"><center>Barcode</center></td>
                    <td><center>การกระทำ</center></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label for="checkbox1">
                                    <input type="checkbox" id="printQR0" name="printQR[]"> เลือกทั้งหมด
                                </label>
                            </div>
                        </td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myprint" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-info">
        <!-- Modal content-->
        <div class="modal-content"style="text-align: center;">
            <div class="modal-header">
                <h4 class="modal-title">คุณต้องการปริ้น Qr code นี้หรือไม่</h4>
            </div>
            <div class="modal-body printcode">

            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="submit" class="btn btn-success fa fa-print printpdf" data-dismiss="modal" style="width:90px; height: 40px"> ปริ้น</button>
                    <button type="button" class="btn btn cancelprint" data-dismiss="modal" style="width:90px; height: 40px">ยกเลิก</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>
@endsection
@section('jsbottom')
<script type="text/javascript">
// set token for ajax
    $('document').ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
// datatable
    var dataTableList = $('#listCustomer').dataTable({
        "focusInvalid": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url + "/Market/StoreQRCode/listCustomer",
            "data": function (d) {
            }
        },
        "columns": [
            {"data": "DT_Row_Index", "className": "text-center", "orderable": false, "searchable": false},
            {"data": "CusID", "name": "CusID", "className": "text-center"},
            {"data": "CusName", "name": "CusName"},
            {"data": "CusNum", "name": "CusNum"},
            {"data": "CusRoad", "name": "CusRoad", visible: false},
            {"data": "district_name", "name": "district_name", visible: false},
            {"data": "amphur_name", "name": "amphur_name", visible: false},
            {"data": "province_name", "name": "province_name", visible: false},
            {"data": "CusZipcode", "name": "CusZipcode", visible: false},
            {"data": "name_th", "name": "name_th", visible: false},
            {"data": "CusPhone", "name": "CusPhone"},
            {"data": "CusMobile", "name": "CusMobile"},
            {"data": "CusFax", "name": "CusFax"},
            {"data": "CusQRCODE", "name": "CusQRCODE", "className": "text-center", "orderable": false, "searchable": false},
            {"data": "CusQRCODE", "name": "CusQRCODE", "className": "text-center", "orderable": false, "searchable": false},
            {"data": "action", "name": "action", "className": "text-center", "orderable": false, "searchable": false}
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
            putvalue();
            info = dataTableList.api().page.info();
        },
        initComplete: function () {
            //alert('a');
            putvalue();
        }
    });
    var getCheck = [];
//    check all
    $('body').on('click', '#printQR0', function () {
        var idtag = '#' + $(this).attr('id');
        if ($(idtag).prop('checked') == true) {
            getCheck = [];
            $.ajax({
                method: "post",
                url: url + "/Market/StoreQRCode/getCustomer",
                dataType: 'json'
            }).done(function (rec) {
                if (rec.type == 'success') {
                    for (var j = 0; j < rec.cus.length; j++) {
                        getCheck[j] = rec.cus[j].CusAutoID;
                    }
                    $('#getCheck').val(getCheck);
                    putvalue();
                    dataTableList.api().ajax.reload();
                } else {
                    swal({
                        confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                    });
                    getCheck = [];
                    $('#printQR0').prop('checked', false);
                }
            });
        } else {
            getCheck = [];
            $('input[name*="printQR[]"]').prop('checked', false);
            $('#getCheck').val(getCheck);
            putvalue();
        }
    });
// check select
    $('body').on('click', 'input[name*="printQR[]"]', function () {
        var addressarray = $.inArray(parseInt($(this).val()), getCheck); // เช็คว่า มีค่าอยู่ใน array แล้วหรือไม่
        var idtag = '#' + $(this).attr('id');
        if (addressarray < 0) {
            if ($(idtag).prop('checked') == true) {
                getCheck[getCheck.length] = $(this).val();
                $('#getCheck').val(getCheck);
            }
        } else {
            if ($(idtag).prop('checked') != true) {
                var f = addressarray;
                var l = getCheck.length;
                getCheck.splice(f, 1);
                $('#getCheck').val(getCheck);
                $('#printQR0').prop('checked', false);
            }
        }
    });
// loop check
    function putvalue() {
        for (i = 0; i < getCheck.length; i++) {
            if ('#printQR' + $(getCheck[i]) !== null) {
                $('#printQR' + getCheck[i]).prop('checked', true);
            }
        }
    }
// action form
    $('#formprint').submit(function (e) {
//        alert();
        if ($('#getCheck').val() !== '') {
            return true;
        } else {
            swal('กรุณาเลือกก่อนกดปุ่ม ปริ้น');
        }
        return false;
    });
</script>
@endsection
