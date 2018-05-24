@extends('layouts.admin')
@section('csstop')
  <title>{{$title}} | BlueIce</title>
@endsection

@section('body')
    <style type="text/css">
        .modal-body{
            height: 70vh;
            overflow-y: auto;
        }
    </style>
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
                  <table class="table table-striped table-hover table-sm" id="ListCustomer">
                  <thead>
                      <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">รหัสลูกค้า</th>
                          <th class="text-center">ชื่อลูกค้า</th>
                          <th class="text-center">ที่อยู่</th>
                          <th class="text-center">เบอร์โทร</th>
                          <th class="text-center">มือถือ</th>
                          <th class="text-center">แฟกซ์</th>
                          <th class="text-center">ประเภท</th>
                          <th class="text-center">การกระทำ</th>
                      </tr>
                  </thead>
                  </table>
              </div>
          </div>
          </div>
      </div>
  </div>
  <!-- /.conainer-fluid -->
  <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
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
            <div class="modal-body">
                <div class="card-body">
                    <div class="card-header">
                        <strong>เพิ่มข้อมูลลูกค้า</strong>
                        <i class="fa fa-plus pull-right" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></i>
                    </div>
                    <div class="collapse show" id="collapseExample">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="CusID">รหัสขึ้นต้น</label>
                                        <input type="text" class="form-control" name="CusID" placeholder="etc. C" maxlength="3" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="CusNumID">รหัสลูกค้า</label>
                                        <input type="text" class="form-control" name="CusNumID" value="{{ $number_id }}" placeholder="etc. 0001" readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="CusName">ชื่อลูกค้า</label>
                                        <input type="text" class="form-control" name="CusName" placeholder="Enter your Name" required>
                                    </div>
                                </div>
                            </div>
                            <!--/.row-->

                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="CusNum">เลขที่ตั้ง</label>
                                    <input type="text" class="form-control" name="CusNum" placeholder="Enter your Number" required>
                                </div>
                                <div class="form-group col-sm-8">
                                    <label for="CusRoad">ถนน</label>
                                    <input type="text" class="form-control" name="CusRoad" placeholder="Enter your Road" required>
                                </div>
                            </div>
                            <!--/.row-->

                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="CusState">จังหวัด</label>
                                    <select class="form-control CusState" name="CusState" id="CusState" onchange="ReservationProvince(this, '.CusCity')" required>
                                        <option value="">เลือกจังหวัด</option>
                                        @foreach($Provinces as $province)
                                        <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    <label for="CusCity">เมือง / อำเภอ / เขต</label>
                                    <select class="form-control CusCity" name="CusCity" id="CusCity" onchange="ReservationAmphur(this, '.CusTambon')" required>
                                        <option value="">เลือกเมือง / อำเภอ / เขต</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="CusTambon">ตำบล / แขวง</label>
                                    <select class="form-control CusTambon" name="CusTambon" id="CusTambon" onchange="ReservationZipcode(this, '.CusZipcode')" required>
                                        <option value="">เลือกตำบล</option>
                                    </select>
                                </div>
                            </div>
                            <!--/.row-->

                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="CusZipcode">รหัสไปรษณีย์</label>
                                    <input type="text" class="form-control CusZipcode" name="CusZipcode" id="CusZipcode" placeholder="Enter your Zipcode" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="CusCountry">ประเทศ</label>
                                    <select class="form-control" name="CusCountry">
                                        <option value="">เลือกประเทศ</option>
                                        @foreach($Countrys as $Country)
                                        <option value="{{ $Country->country_id }}">{{ $Country->name_th }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="CusPhone">เบอร์โทร</label>
                                    <input type="text" class="form-control" name="CusPhone" placeholder="Enter your Phone" required>
                                </div>
                            </div>
                            <!--/.row-->

                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="CusMobile">มือถือ</label>
                                    <input type="text" class="form-control" name="CusMobile" placeholder="Enter your MobilePhone" required>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="CusFax">แฟกซ์</label>
                                        <input type="text" class="form-control" name="CusFax" placeholder="Enter your Fax" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="CusType">ประเภท</label>
                                        <select class="form-control" name="CusType" required>
                                          <option value="">เลือกประเภท</option>
                                          @foreach($PaymentType as $row)
                                          <option value="{{ $row->id }}">{{ $row->paymentType_name }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--/.row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="TruckID">ทะเบียน</label>
                                        <select class="form-control" name="TruckID">
                                            <option value="">เลือกทะเบียนรถ</option>
                                            @foreach($Trucks as $Truck)
                                            <option value="{{ $Truck->TruckID }}">{{ $Truck->TruckNumber }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8" style="text-align: center;">
                                    <img src="{{ asset('img/qrcode.png') }}" border='0'/>
                                    <img style="width: 35%;" src="{{ asset('img/barcode.png') }}" alt=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="alladres">
                        <div class="card-header">
                            <strong>ที่อยู่ส่งของ</strong>
                            <i class="fa fa-plus pull-right clone2"></i>
                        </div>
                        <div class="collapse show addRow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="CusNum">เลขที่ตั้ง</label>
                                        <input type="text" class="form-control" name="AodNum[]" placeholder="Enter your Number" required>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <label for="CusRoad">ถนน</label>
                                        <input type="text" class="form-control" name="AodRoad[]" placeholder="Enter your Road" required>
                                    </div>
                                </div>
                                <!--/.row-->
                                <!--ที่อยู่ สาขา-->
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="AodState">จังหวัด</label>
                                        <select class="form-control AodState" name="AodState[]" id="AodState" onchange="ReservationProvince(this, '.AodCity')" required>
                                            <option value="">เลือกจังหวัด</option>
                                            @foreach($Provinces as $province)
                                            <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="AodCity">เมือง / อำเภอ / เขต</label>
                                            <select class="form-control AodCity" name="AodCity[]" id="AodCity" onchange="ReservationAmphur(this, '.AodTambon')" required>
                                                <option value="">เลือกเมือง / อำเภอ / เขต</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="AodTambon">ตำบล / แขวง</label>
                                        <select class="form-control AodTambon" name="AodTambon[]" id="AodTambon" onchange="ReservationZipcode(this, '.AodZipcode')" required>
                                            <option value="">เลือกตำบล</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/.row-->

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="CusZipcode">รหัสไปรษณีย์</label>
                                        <input type="text" class="form-control AodZipcode" name="AodZipcode[]" id="AodZipcode" placeholder="Enter your Zipcode" required>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="CusCountry">ประเทศ</label>
                                        <select class="form-control" name="AodCountry[]" required>
                                            <option value="">เลือกประเทศ</option>
                                            @foreach($Countrys as $Country)
                                            <option value="{{ $Country->country_id }}">{{ $Country->name_th }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/.row-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

<div class="collapse show addRow" id="collapseExample2" hidden>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="CusNum">เลขที่ตั้ง</label>
                <input type="text" class="form-control" name="AodNum[]" placeholder="Enter your Number" required>
            </div>
            <div class="form-group col-sm-8">
                <label for="CusRoad">ถนน</label>
                <input type="text" class="form-control" name="AodRoad[]" placeholder="Enter your Road" required>
            </div>
        </div>
        <!--/.row-->
        <!--ที่อยู่ สาขา-->
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="AodState">จังหวัด</label>
                <select class="form-control AodState" name="AodState[]" id="AodState" onchange="ReservationProvince(this, '#AodCity')" required>
                    <option value="">เลือกจังหวัด</option>
                    @foreach($Provinces as $province)
                    <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="AodCity">เมือง / อำเถอ / เขต</label>
                    <select class="form-control AodCity" name="AodCity[]" id="AodCity" onchange="ReservationAmphur(this, '#AodTambon')" required>
                        <option value="">เลือกเมือง / อำเถอ / เขต</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-sm-4">
                <label for="AodTambon">ตำบล / แขวง</label>
                <select class="form-control AodTambon" name="AodTambon[]" id="AodTambon" onchange="ReservationZipcode(this, '#AodZipcode')" required>
                    <option value="">เลือกตำบล</option>
                </select>
            </div>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="form-group col-sm-4">
                <label for="CusZipcode">รหัสไปรษณีย์</label>
                <input type="text" class="form-control AodZipcode" name="AodZipcode[]" id="AodZipcode" placeholder="Enter your Zipcode" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="CusCountry">ประเทศ</label>
                <select class="form-control" name="AodCountry[]" required>
                    <option value="">เลือกประเทศ</option>
                    @foreach($Countrys as $Country)
                    <option value="{{ $Country->country_id }}">{{ $Country->name_th }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--/.row-->
    </div>
</div>

  <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-warning modal-lg" role="document">
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
        <form id="FormWarning" class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="editid" id="editid">
        <div class="modal-body">
            <div class="card-body">
                <div class="card-header">
                    <strong>เพิ่มข้อมูลลูกค้า</strong>
                    <i class="fa fa-plus pull-right" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></i>
                </div>
                <div class="collapse show" id="collapseExample">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="CusID">รหัสขึ้นต้น</label>
                                    <input type="text" class="form-control" name="CusID" id="CusID" maxlength="3" placeholder="etc. C" required>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="CusNumID">รหัสลูกค้า</label>
                                    <input type="text" class="form-control" name="CusNumID" id="CusNumID" placeholder="etc. 0001" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="CusName">ชื่อลูกค้า</label>
                                    <input type="text" class="form-control" name="CusName" id="CusName" placeholder="Enter your Name" required>
                                </div>
                            </div>
                        </div>
                        <!--/.row-->

                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="CusNum">เลขที่ตั้ง</label>
                                <input type="text" class="form-control" name="CusNum" id="CusNum" placeholder="Enter your Number" required>
                            </div>
                            <div class="form-group col-sm-8">
                                <label for="CusRoad">ถนน</label>
                                <input type="text" class="form-control" name="CusRoad" id="CusRoad" placeholder="Enter your Road" required>
                            </div>
                        </div>
                        <!--/.row-->

                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="CusState">จังหวัด</label>
                                <select class="form-control" name="CusState" id="CusState1" onchange="ReservationProvince(this, '#CusCity1')" required>
                                    <option value="">เลือกจังหวัด</option>
                                    @foreach($Provinces as $province)
                                    <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="CusCity">เมือง / อำเภอ / เขต</label>
                                    <select class="form-control CusCity" name="CusCity" id="CusCity1" onchange="ReservationAmphur(this, '#CusTambon1')" required>
                                        <option value="">เลือกเมือง / อำเภอ / เขต</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="CusTambon">ตำบล / แขวง</label>
                                <select class="form-control CusTambon" name="CusTambon" id="CusTambon1" onchange="ReservationZipcode(this, '#CusZipcode1')" required>
                                    <option value="">เลือกตำบล</option>
                                </select>
                            </div>
                        </div>
                        <!--/.row-->

                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="CusZipcode">รหัสไปรษณีย์</label>
                                <input type="text" class="form-control" name="CusZipcode" id="CusZipcode1" placeholder="Enter your Zipcode" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="CusCountry">ประเทศ</label>
                                <select class="form-control" name="CusCountry" id="CusCountry" >
                                    <option value="">เลือกประเทศ</option>
                                    @foreach($Countrys as $Country)
                                    <option value="{{ $Country->country_id }}">{{ $Country->name_th }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="CusPhone">เบอร์โทร</label>
                                <input type="text" class="form-control" name="CusPhone" id="CusPhone" placeholder="Enter your Phone" required>
                            </div>
                        </div>
                        <!--/.row-->

                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="CusMobile">มือถือ</label>
                                <input type="text" class="form-control" name="CusMobile" id="CusMobile" placeholder="Enter your MobilePhone" required>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="CusFax">แฟกซ์</label>
                                    <input type="text" class="form-control" name="CusFax" id="CusFax" placeholder="Enter your Fax" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="CusType">ประเภท</label>
                                    <select class="form-control" name="CusType" id="CusType" required>
                                      <option value="">เลือกประเภท</option>
                                      @foreach($PaymentType as $row)
                                      <option value="{{ $row->id }}">{{ $row->paymentType_name }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/.row-->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="TruckID">ทะเบียน</label>
                                    <select class="form-control" name="TruckID" id="TruckID">
                                        <option value="">เลือกทะเบียนรถ</option>
                                        @foreach($Trucks as $Truck)
                                        <option value="{{ $Truck->TruckID }}">{{ $Truck->TruckNumber }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8" style="text-align: center;">
                                <img src="{{ asset('img/qrcode.png') }}" border='0'/>
                                <img style="width: 35%;" src="{{ asset('img/barcode.png') }}" alt=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="alladdress">
                    <div class="card-header">
                        <strong>ที่อยู่ส่งของ</strong>
                        <i class="fa fa-plus pull-right clone3"></i>
                    </div>
                </div>
            </div>
        </div>
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
  <!-- /.modal -->
@endsection

@section('jsbottom')
<!-- DataTables -->
<script type="text/javascript">
    var dataTableList = $('#ListCustomer').dataTable({
      "focusInvalid": false,
      "processing": true,
      "serverSide": true,
      "ajax": {
          "url": url+"/Information/Datatable/listCustomer",
          "data": function ( d ) {
          }
      },
      "columns": [
          { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
          { "data": "CusID" , "name":"CusID" },
          { "data": "CusName" , "name":"CusName" },
          { "data": "CusNum" , "name":"CusNum" },
          { "data": "CusPhone" , "name":"CusPhone" },
          { "data": "CusMobile" , "name":"CusMobile" },
          { "data": "CusFax" , "name":"CusFax" },
          { "data": "paymentType_name" , "name":"paymentType_name" },
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
</script>

<!-- Button -->
<script type="text/javascript">
    $('body').on('click', '.btn-add',function(){
        document.getElementById("FormPrimary").reset();
        $( "#primaryModal" ).modal('show');
    });//end btn-add

    $("body").on('click', '.clone2', function () {
        var id = $(this).data('id');
        $("#collapseExample2").clone().appendTo("#alladres").find("input, select").val("");
        $('#alladres #collapseExample2').addClass('addRow');
        $('#alladres #collapseExample2').attr('id', 'B' + $(".addRow").length);
        $("#B" + $(".addRow").length).removeAttr("hidden");
        $("#B" + $(".addRow").length + " .AodState").attr("id", 'AodState' + $(".addRow").length);
        $("#B" + $(".addRow").length + " .AodCity").attr("id", 'AodCity' + $(".addRow").length);
        $("#B" + $(".addRow").length + " .AodTambon").attr("id", 'AodTambon' + $(".addRow").length);
        $("#B" + $(".addRow").length + " .AodZipcode").attr("id", 'AodZipcode' + $(".addRow").length);
        $("#B" + $(".addRow").length + " .AodState").attr("onchange", "ReservationProvince(this,'#AodCity" + $(".addRow").length + "')");
        $("#B" + $(".addRow").length + " .AodCity").attr("onchange", "ReservationAmphur(this,'#AodTambon" + $(".addRow").length + "')");
        $("#B" + $(".addRow").length + " .AodTambon").attr("onchange", "ReservationZipcode(this,'#AodZipcode" + $(".addRow").length + "')");
        $("#B" + $(".addRow").length + " select[name='AodTambon[]']").attr('id', "AodTambon" + $(".addRow").length);
        $("#B" + $(".addRow").length + " select[name='AodCity[]']").attr('id', "AodCity" + $(".addRow").length);
        $("#B" + $(".addRow").length + " input[name='AodZipcode[]']").attr('id', "AodZipcode" + $(".addRow").length);
    });

    $("body").on('click', '.clone3', function () {
        var id = $(this).data('id');
        $("#collapseExample2").clone().appendTo("#alladdress").find("input, select").val("");
        $('#alladdress #collapseExample2').addClass('numRow');
        $('#alladdress #collapseExample2').attr('id', 'A' + $(".numRow").length);
        $("#A" + $(".numRow").length).removeAttr("hidden");
        $("#A" + $(".numRow").length).append('<input type="hidden" name="ID[]" id="id" value="">');
        $("#A" + $(".numRow").length + " .AodState").attr("id", 'AodState' + $(".numRow").length);
        $("#A" + $(".numRow").length + " .AodCity").attr("id", 'AodCity' + $(".numRow").length);
        $("#A" + $(".numRow").length + " .AodTambon").attr("id", 'AodTambon' + $(".numRow").length);
        $("#A" + $(".numRow").length + " .AodZipcode").attr("id", 'AodZipcode' + $(".numRow").length);
        $("#A" + $(".numRow").length + " .AodState").attr("onchange", "ReservationProvince(this,'#AodCity" + $(".numRow").length + "')");
        $("#A" + $(".numRow").length + " .AodCity").attr("onchange", "ReservationAmphur(this,'#AodTambon" + $(".numRow").length + "')");
        $("#A" + $(".numRow").length + " .AodTambon").attr("onchange", "ReservationZipcode(this,'#AodZipcode" + $(".numRow").length + "')");
        $("#A" + $(".numRow").length + " select[name='AodTambon[]']").attr('id', "AodTambon" + $(".numRow").length);
        $("#A" + $(".numRow").length + " select[name='AodCity[]']").attr('id', "AodCity" + $(".numRow").length);
        $("#A" + $(".numRow").length + " input[name='AodZipcode[]']").attr('id', "AodZipcode" + $(".numRow").length);
    });

    $('body').on('click', '.btn-edit', function(){
        var id = $(this).data('id');
        $.ajax({
            method : "GET",
            url : url+"/Information/CustomerInfomation/"+id,
            dataType : 'json',
            success:function(rec) {
                AutoReservation(rec.customer.CusState,rec.customer.CusCity,rec.customer.CusTambon,'#CusState1','#CusCity1','#CusTambon1','#CusZipcode1');
            }
        }).done(function(rec){
            $('#CusID').val(rec.number_id[0]);
            $('#CusNumID').val(rec.number_id[1]);
            $('#CusName').val(rec.customer.CusName);
            $('#CusNum').val(rec.customer.CusNum);
            $('#CusRoad').val(rec.customer.CusRoad);
            $('#CusState1').val(rec.customer.CusState);
            // $('#CusTambon1').val(rec.customer.CusTambon);
            // $('#CusCity1').val(rec.customer.CusCity);
            $('#CusZipcode1').val(rec.customer.CusZipcode);
            $('#CusCountry').val(rec.customer.CusCountry);
            $('#CusPhone').val(rec.customer.CusPhone);
            $('#CusMobile').val(rec.customer.CusMobile);
            $('#CusFax').val(rec.customer.CusFax);
            $('#CusType').val(rec.customer.CusType);
            $('#TruckID').val(rec.customer.TruckID);
            $('#editid').val(rec.customer.CusAutoID);
            $('#alladdress .numRow').remove();
            $.each(rec.customer_aod, function(i, item) { // Loop data
                if(rec.customer_aod.length==0) { // If not data
                    $("#collapseExample2").clone().appendTo("#alladdress").find("input, select").val("");
                } else {
                    $("#collapseExample2").clone().appendTo("#alladdress");
                    $('#alladdress #collapseExample2').addClass('numRow');
                    $('#alladdress #collapseExample2').attr('id', 'A'+i);
                    $("#A" + i).removeAttr("hidden");
                    $("#A" + i + " select[name='AodState[]']").attr('id', "AodState" + i).val(item.AodState);
                    $("#A" + i + " select[name='AodCity[]']").attr('id', "AodCity" + i); //.val(item.AodCity)
                    $("#A" + i + " select[name='AodTambon[]']").attr('id', "AodTambon" + i); //.val(item.AodTambon)
                    $("#A" + i + " input[name='AodZipcode[]']").attr('id', "AodZipcode" + i); //.val(item.AodZipcode)
                    $("#A" + i + " .AodState").attr("onchange", "ReservationProvince(this,'#AodCity" + i + "')");
                    $("#A" + i + " .AodCity").attr("onchange", "ReservationAmphur(this,'#AodTambon" + i + "')");
                    $("#A" + i + " .AodTambon").attr("onchange", "ReservationZipcode(this,'#AodZipcode" + i + "')");
                    $("#A" + i + " input[name='AodNum[]']").val(item.AodNum);
                    $("#A" + i + " input[name='AodRoad[]']").val(item.AodRoad);
                    $("#A" + i + " select[name='AodCountry[]']").val(item.AodCountry);
                    $("#A" + i).append('<input type="hidden" name="ID[]" id="id" value="' + item.AodID + '">')
                    AutoReservation(item.AodState,item.AodCity,item.AodTambon,'#AodState' + i,'#AodCity' + i,'#AodTambon' + i,'#AodZipcode' + i);
                }
            })
            $('#warningModal').modal('show');
        });
     });//end btn-edit

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
                    url : url+"/Information/CustomerInfomation/delete/"+id,
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
    });//end btn-delete
</script>

<!-- Form -->
<script type="text/javascript">
    $( "#FormPrimary" ).validate({
        rules: {
            CusID: "required",
            CusNumID: "required",
            CusName: "required",
            CusNum: "required",
            CusRoad: "required",
            CusTambon: "required",
            CusCity: "required",
            CusState: "required",
            CusZipcode: "required",
            CusCountry: "required",
            CusPhone: {required:true, maxlength:9, minlength:9,number:true},
            CusMobile: {required:true, maxlength:10, minlength:10,number:true},
            // CusFax: {maxlength:9, minlength:9,number:true},
            CusType: "required",
            // TruckID: "required",
        },
        messages: {
            CusID: "กรุณาระบุ",
            CusNumID: "กรุณาระบุ",
            CusName: "กรุณาระบุ",
            CusNum: "กรุณาระบุ",
            CusRoad: "กรุณาระบุ",
            CusTambon: "กรุณาเลือก",
            CusCity: "กรุณาเลือก",
            CusState: "กรุณาเลือก",
            CusZipcode: "กรุณาระบุ",
            CusCountry: "กรุณาเลือก",
            CusPhone: {required:"กรุณาระบุ",number:"ตัวเลขเท่านั้น",minlength:"9 ตัวอักษร"},
            CusMobile: {required:"กรุณาระบุ",number:"ตัวเลขเท่านั้น",minlength:"10 ตัวอักษร"},
            // CusFax: {minlength:"9 ตัวอักษร",number:"ตัวเลขเท่านั้น"},
            CusType: "กรุณาเลือก",
            // TruckID: "กรุณาเลือก",
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
                url : url+"/Information/CustomerInfomation",
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
            CusID: "required",
            CusNumID: "required",
            CusName: "required",
            CusNum: "required",
            CusRoad: "required",
            CusTambon: "required",
            CusCity: "required",
            CusState: "required",
            CusZipcode: "required",
            CusCountry: "required",
            CusPhone: {required:true, maxlength:9, minlength:9,number:true},
            CusMobile: {required:true, maxlength:10, minlength:10,number:true},
            // CusFax: {required:true, maxlength:9, minlength:9},
            CusType: "required",
            // TruckID: "required",
        },
        messages: {
            CusID: "กรุณาระบุ",
            CusNumID: "กรุณาระบุ",
            CusName: "กรุณาระบุ",
            CusNum: "กรุณาระบุ",
            CusRoad: "กรุณาระบุ",
            CusTambon: "กรุณาเลือก",
            CusCity: "กรุณาเลือก",
            CusState: "กรุณาเลือก",
            CusZipcode: "กรุณาระบุ",
            CusCountry: "กรุณาเลือก",
            CusPhone: {required:"กรุณาระบุ",number:"ตัวเลขเท่านั้น",minlength:"9 ตัวอักษร"},
            CusMobile: {required:"กรุณาระบุ",number:"ตัวเลขเท่านั้น",minlength:"10 ตัวอักษร"},
            // CusFax: {required:"กรุณาระบุ",minlength:"9 ตัวอักษร"},
            CusType: "กรุณาเลือก",
            // TruckID: "กรุณาเลือก",
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
                url : url+"/Information/CustomerInfomation/update",
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
