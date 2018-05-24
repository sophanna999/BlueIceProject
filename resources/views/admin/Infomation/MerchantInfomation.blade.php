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
                  <table class="table table-striped table-hover table-sm" id="ListMerchant">
                  <thead>
                      <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">รหัสผู้ขาย</th>
                          <th class="text-center">ชื่อผู้ขาย</th>
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
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="SupID">รหัสขึ้นต้น</label>
                                <input type="text" class="form-control" name="SupID" placeholder="etc. S" maxlength="3" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="SupNumID">รหัสผู้ขาย</label>
                                <input type="text" class="form-control" name="SupNumID" value="{{ $number_id }}" placeholder="etc. 0001" readonly required>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="SupName">ชื่อผู้ขาย</label>
                                <input type="text" class="form-control" name="SupName" placeholder="Enter your Name">
                            </div>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="SupNum">เลขที่ตั้ง</label>
                            <input type="text" class="form-control" name="SupNum" placeholder="Enter your Number">
                        </div>
                        <div class="form-group col-sm-8">
                            <label for="SupRoad">ถนน</label>
                            <input type="text" class="form-control" name="SupRoad" placeholder="Enter your Road">
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="SupState">จังหวัด</label>
                            <select class="form-control SupState" name="SupState" id="SupState" onchange="ReservationProvince(this, '.SupCity')">
                                <option value="">เลือกจังหวัด</option>
                                @foreach($Provinces as $province)
                                <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="SupCity">เมือง / อำเภอ / เขต</label>
                                <select class="form-control SupCity" name="SupCity" id="SupCity" onchange="ReservationAmphur(this, '.SupTambon')">
                                  <option value="">เลือกเมือง / อำเภอ / เขต</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="SupTambon">ตำบล / แขวง</label>
                            <select class="form-control SupTambon" name="SupTambon" id="SupTambon" onchange="ReservationZipcode(this, '.SupZipcode')">
                              <option value="">เลือกตำบล</option>
                            </select>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="SupZipcode">รหัสไปรษณีย์</label>
                            <div>
                              <input type="text" class="form-control SupZipcode" name="SupZipcode" id="SupZipcode" placeholder="Enter your Zipcode">
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="SupCountry">ประเทศ</label>
                            <select class="form-control SupCountry" name="SupCountry">
                                <option value="">เลือกประเทศ</option>
                                @foreach($Countrys as $Country)
                                <option value="{{ $Country->country_id }}">{{ $Country->name_th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="SupPhone">เบอร์โทร</label>
                            <input type="text" class="form-control" name="SupPhone" placeholder="Enter your Phone">
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="SupMobile">มือถือ</label>
                            <input type="text" class="form-control" name="SupMobile" placeholder="Enter your MobilePhone">
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="SupFax">แฟกซ์</label>
                                <input type="text" class="form-control" name="SupFax" placeholder="Enter your Fax">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="SupType">ประเภท</label>
                                <select class="form-control" name="SupType">
                                  <option value="">เลือกประเภท</option>
                                  @foreach($PaymentType as $row)
                                  <option value="{{ $row->id }}">{{ $row->paymentType_name }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--/.row-->
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
        <form id="FormWarning" class="form-horizontal"><form id="FormPrimary" method="post" class="form-horizontal" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="editid" id="editid">
        <div class="modal-body">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="SupID">รหัสขึ้นต้น</label>
                            <input type="text" class="form-control" name="SupID" id="SupID" placeholder="etc. S" maxlength="3" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="SupNumID">รหัสผู้ขาย</label>
                            <input type="text" class="form-control" name="SupNumID" id="SupNumID" placeholder="etc. 0001" readonly required>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="SupName">ชื่อผู้ขาย</label>
                            <input type="text" class="form-control" name="SupName" id="SupName" placeholder="Enter your Name">
                        </div>
                    </div>
                </div>
                <!--/.row-->

                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="SupNum">เลขที่ตั้ง</label>
                        <input type="text" class="form-control" name="SupNum" id="SupNum" placeholder="Enter your Number">
                    </div>
                    <div class="form-group col-sm-8">
                        <label for="SupRoad">ถนน</label>
                        <input type="text" class="form-control" name="SupRoad" id="SupRoad" placeholder="Enter your Road">
                    </div>
                </div>
                <!--/.row-->

                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="SupState">จังหวัด</label>
                        <select class="form-control SupState" name="SupState" id="SupState1" onchange="ReservationProvince(this, '#SupCity1')">
                            <option value="">เลือกจังหวัด</option>
                            @foreach($Provinces as $province)
                            <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="SupCity">เมือง / อำเถอ / เขต</label>
                            <select class="form-control SupCity" name="SupCity" id="SupCity1" onchange="ReservationAmphur(this, '#SupTambon1')">
                              <option value="">เลือกเมือง / อำเถอ / เขต</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="SupTambon">ตำบล / แขวง</label>
                        <select class="form-control SupTambon" name="SupTambon" id="SupTambon1" onchange="ReservationZipcode(this, '#SupZipcode1')">
                          <option value="">เลือกตำบล</option>
                        </select>
                    </div>
                </div>
                <!--/.row-->

                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="SupZipcode">รหัสไปรษณีย์</label>
                        <div>
                          <input type="text" class="form-control SupZipcode" name="SupZipcode" id="SupZipcode1" placeholder="Enter your Zipcode">
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="SupCountry">ประเทศ</label>
                        <select class="form-control SupCountry" name="SupCountry" id="SupCountry">
                            <option value="">เลือกประเทศ</option>
                            @foreach($Countrys as $Country)
                            <option value="{{ $Country->country_id }}">{{ $Country->name_th }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="SupPhone">เบอร์โทร</label>
                        <input type="text" class="form-control" name="SupPhone" id="SupPhone" placeholder="Enter your Phone">
                    </div>
                </div>
                <!--/.row-->

                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="SupMobile">มือถือ</label>
                        <input type="text" class="form-control" name="SupMobile" id="SupMobile" placeholder="Enter your MobilePhone">
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="SupFax">แฟกซ์</label>
                            <input type="text" class="form-control" name="SupFax" id="SupFax" placeholder="Enter your Fax">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="SupType">ประเภท</label>
                            <select class="form-control" name="SupType" id="SupType">
                              <option value="">เลือกประเภท</option>
                              @foreach($PaymentType as $row)
                              <option value="{{ $row->id }}">{{ $row->paymentType_name }}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!--/.row-->
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close" data-dismiss="modal">ปิด</button>
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
    var dataTableList = $('#ListMerchant').dataTable({
      "focusInvalid": false,
      "processing": true,
      "serverSide": true,
      "ajax": {
          "url": url+"/Information/Datatable/listMerchant",
          "data": function ( d ) {
          }
      },
      "columns": [
          { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
          { "data": "SupID" , "name":"SupID" },
          { "data": "SupName" , "name":"SupName" },
          { "data": "SupNum" , "name":"SupNum" },
          { "data": "SupPhone" , "name":"SupPhone" },
          { "data": "SupMobile" , "name":"SupMobile" },
          { "data": "SupFax" , "name":"SupFax" },
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
        $( "#FormPrimary" )[0].reset();
        $( "#primaryModal" ).modal('show');
    });//end btn-add

    $('body').on('click', '.btn-edit', function(){
        var id = $(this).data('id');
        $.ajax({
            method : "GET",
            url : url+"/Information/MerchantInfomation/"+id,
            dataType : 'json',
            success:function(rec) {
                AutoReservation(rec.result.SupState,rec.result.SupCity,rec.result.SupTambon,'#SupState1','#SupCity1','#SupTambon1','#SupZipcode1');
            }
        }).done(function(rec){
            $('#SupID').val(rec.number_id[0]);
            $('#SupNumID').val(rec.number_id[1]);
            $('#SupName').val(rec.result.SupName);
            $('#SupNum').val(rec.result.SupNum);
            $('#SupRoad').val(rec.result.SupRoad);
            $('#SupState1').val(rec.result.SupState);
            $('#SupCountry').val(rec.result.SupCountry);
            $('#SupPhone').val(rec.result.SupPhone);
            $('#SupMobile').val(rec.result.SupMobile);
            $('#SupFax').val(rec.result.SupFax);
            $('#SupType').val(rec.result.SupType);
            $('#editid').val(rec.result.SupAutoID);
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
                    url : url+"/Information/MerchantInfomation/delete/"+id,
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
            SupID: "required",
            SupNumID: "required",
            SupName: "required",
            SupNum: "required",
            SupRoad: "required",
            SupTambon: "required",
            SupCity: "required",
            SupZipcode: "required",
            SupCountry: "required",
            SupPhone: "required",
            SupMobile: "required",
            SupFax: "required",
            SupType: "required",
            SupState: "required",
        },
        messages: {
            SupID: "กรุณาระบุ",
            SupNumID: "กรุณาระบุ",
            SupName: "กรุณาระบุ",
            SupNum: "กรุณาระบุ",
            SupRoad: "กรุณาระบุ",
            SupTambon: "กรุณาเลือก",
            SupCity: "กรุณาเลือก",
            SupZipcode: "กรุณาระบุ",
            SupCountry: "กรุณาเลือก",
            SupPhone: "กรุณาระบุ",
            SupMobile: "กรุณาระบุ",
            SupFax: "กรุณาระบุ",
            SupType: "กรุณาเลือก",
            SupState: "กรุณาเลือก",
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
                url : url+"/Information/MerchantInfomation",
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
            SupID: "required",
            SupNumID: "required",
            SupName: "required",
            SupNum: "required",
            SupRoad: "required",
            SupTambon: "required",
            SupCity: "required",
            SupZipcode: "required",
            SupCountry: "required",
            SupPhone: "required",
            SupMobile: "required",
            SupFax: "required",
            SupType: "required",
            SupState: "required",
        },
        messages: {
            SupID: "กรุณาระบุ",
            SupNumID: "กรุณาระบุ",
            SupName: "กรุณาระบุ",
            SupNum: "กรุณาระบุ",
            SupRoad: "กรุณาระบุ",
            SupTambon: "กรุณาเลือก",
            SupCity: "กรุณาเลือก",
            SupZipcode: "กรุณาระบุ",
            SupCountry: "กรุณาเลือก",
            SupPhone: "กรุณาระบุ",
            SupMobile: "กรุณาระบุ",
            SupFax: "กรุณาระบุ",
            SupType: "กรุณาเลือก",
            SupState: "กรุณาเลือก",
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
                url : url+"/Information/MerchantInfomation/update",
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
