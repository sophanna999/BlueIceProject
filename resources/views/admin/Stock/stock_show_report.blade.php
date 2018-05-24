@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('css/prints.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"><title>{{$title}} | BlueIce</title>
<style>
        body{
            font-family: 'Garuda';
        }
    </style>
@endsection

@section('body')
<div class="col-lg-12">
                <!-- <div style="page-break-after: always;"> </div> -->

<!--head -->
                <div>
                    <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
                            <tr>
                                <td align="center" width="20%" style="color: black; font-size: 20px;padding-top: 10px; border-bottom: none; border-top:none; border-left:none;">
                                    <p style="font-size: 35px; font-weight: bold; ">หจก.บลูไอซ์ หะยีมะดาโอ๊ะ</p>
                                    <div class="row">
                                    <div class="col-sm-6" align="right">
                                    <p style="font-size: 15px;">เลขประจําตัวผู้เสียภาษี : 0963554000461 สาขาที่ออกใบกํากับภาษีคือ </p>
                                    </div>
                                    <div class="col-sm-6" align="left" style="margin-top: 2px; font-size: 15px;">
                                    <input type="checkbox"> สำนักงานใหญ่ &nbsp;&nbsp;
                                    <input type="checkbox" checked> สาขา ...................
                                    </div>
                                    </div>

                                </td>
                            </tr>
                        </table>
                </div>
                    <div>
                        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
                            <tr>
                                <td align="left" width="35%" style="color: black;padding-top: 10px; border-bottom: none; border-top:none; border-left:none;">
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;">
                                        {{$check[0]->stockmaterial->branch->BraNum}} ถนน {{$check[0]->stockmaterial->branch->BraRoad}} <br>
                                        ตําบล {{$check[0]->stockmaterial->branch->district->district_name}} อำเภอ  {{$check[0]->stockmaterial->branch->amphur->amphur_name}} <br>
                                        จังหวัด {{$check[0]->stockmaterial->branch->province->province_name}} ประเทศ  {{$check[0]->stockmaterial->branch->country->name_th}} <br>
                                        รหัสไปรษณีย์ {{$check[0]->stockmaterial->branch->BraZipcode}}<br>
                                        เบอร์โทร {{$check[0]->stockmaterial->branch->BraMobile}}<br>
                                        แฟ็กซ์  {{$check[0]->stockmaterial->branch->BraFax}}<br></p>
                                </td>
                                <td align="center" width="30%" style="color: black;padding-top: 10px; font-weight: bold;"><p style="font-size: 17px;margin-top: -51px;">ข้อมูลใบรับวัสดุ</p></td>
                                <td align="left" width="35%" style="color: black; font-size: 20px;padding-top: 10px; border-bottom: none; border-top:none; border-right:none;">
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>PO : </strong> {{$check[0]->MatNoDoc}}</p>
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Date : </strong> {{$check[0]->stockmaterial->date_doc}}</p>
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Department : </strong> {{$check[0]->stockmaterial->department->department_name}} </p>
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Receiver : </strong> {{$check[0]->stockmaterial->recorder->firstname.' '.$check[0]->stockmaterial->recorder->lastname}}</p>
                                </td>
                            </tr>
                        </table>
                    </div>

        <div style="padding-top: 10px">

        <!--mid -->

        <table style="border-collapse: collapse;" width="100%" >
            <thead>
                <tr>
                    <th height="30px" width="5%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Item <br> ลำดับ</th>
                    <th height="30px" width="10%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">PO Number <br> เลขที่ใบสั่งซื่อ</th>
                    <th height="30px" width="5%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Material Code <br> รหัสวัสดุ</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Material Name <br>ชื่อวัสดุ</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Branch <br>สาขา</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Amount <br>จํานวน</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Price/Unit <br>ราคา/หน่วย</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Total<br>จํานวนเงินรวม</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach($check as $k => $v)
                <?php
                    $i              += $v->MatQuantity*$v->MatPricePerUnit;
                    $less_cash_disc = $check[0]->MatDiscount;
                    $total          = $i - $less_cash_disc;
                ?>
                <tr>
                    <td height="30px" width="5%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="center">&nbsp; {{$id++}}</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="left">&nbsp;{{$v->PoNO}}</td>
                    <td height="30px" width="5%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{$v->MatCode}} &nbsp;</td>
                    <td height="30px" width="10%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{$v->MatDescription}} &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{$v->branch->BraName}} &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{$v->MatQuantity}} &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{$v->MatPricePerUnit}} &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right" class="amount">{{number_format($v->MatQuantity*$v->MatPricePerUnit,2)}} &nbsp;</td>
                </tr>
                @endforeach

            </tbody>

        </table>
<!--foot -->
        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
            <tbody>
                <tr>
                    <td rowspan="4" width="55%">
                        <p style="margin-top: 13px;">&nbsp; ได้รับรับสินค้าดังรายการข้างบนเรียบร้อยแล้ว <br>
                        &nbsp; Recieved the above mentioned on good order and dondition. <br>
                        &nbsp; การชําระเงินด้วยเช็คจะสมบูรณ์ต่อเมื่อบริษัทฯ ได้รับเงินตามเช็คเรียบร้อยแล้ว <br>
                        &nbsp; Payment by cheque not valid till the cheque has been honoured.</p>
                    </td>
                    <td width="30%">&nbsp;<strong> รวมเงิน (Sub Total)</strong></td>
                    <td width="15%" align="right" class="sumtotal" id="sumtotal">{{number_format($i,2)}}​&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;<strong> หักส่วนลดพิเศษ (Less Cash Disc)</strong></td>
                    <td align="right" class="less_cash_disc" id="less_cash_disc">{{$less_cash_disc}}​&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
            <tbody>
                <tr>
                    <td rowspan="4" width="55%">
                        <p style="margin-top: 13px; text-align: center; font-size: 15px;">&nbsp; <strong>({{ App\Http\Controllers\FunctionController::m2t($total) }})</strong></p>
                    </td>
                    <td width="30%">&nbsp;<strong> ยอดสุทธิ (Grand Total)</strong></td>
                    <td width="15%" align="right" class="grand_total" id="grand_total = ">{{number_format($total,2)}} &nbsp;</td>
                </tr>
            </tbody>
        </table>
        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
            <tbody>
                <tr>
                   <td style="border-right: none; height: 150px;" width="20%"><center style="margin-top: 56px;">____________<br> ผู้รับสินค้า <br> Receiver</center></td>
                   <td style="border-left: none" width="20%"><center style="margin-top: 56px;">____________<br> วันที่รับ <br> Received Date</center></td>
                   <td width="20%"><center style="margin-top: 56px;">____________<br> ผู้ส่งสินค้า <br> Deliverer</center></td>
                   <td style="border-right: none" width="20%"><center style="margin-top: 56px;">____________<br> ผู้รับเงิน <br> Collector</center></td>
                   <td style="border-left: none" width="20%"><center style="margin-top: 56px;">____________<br> ผู้อนุมัติ <br> Authorized</center></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script>
// var other_val = $('.other_val').val();
// var Tax_val = $('.Tax_val').val();
// $(function(){
//    $('.amount').each(function(){
//         CalculateSum();
//    });
// });

// function CalculateSum(){
//     var sum = 0;
//     $('.amount').each(function(){
//         // console.log($(this).text());
//         if (!isNaN($(this).text()) && $(this).text().length !=0) {
//             sum+= parseFloat($(this).text());
//         }
//     });
//     var sumtotal           = $('.sumtotal').text(sum);
//     var sumtotal_res       = $('#sumtotal').text();
//     var other_res          = $('.less_cash_disc').text(other_val);
//     var less_cash_disc_res = $('#less_cash_disc').text();
//     var total_vat          = $('.total_vat').text(Tax_val);
//     var total_vat_res      = $('.total_vat').text();
//     var total              = $('.total').text(parseFloat(sumtotal_res)- parseFloat(less_cash_disc_res));
//     var total_res          = $('.total').text();
//     var grand_total        = $('.grand_total').text(parseFloat(total_res)+ parseFloat(total_vat_res));
// }
</script>
@endsection
