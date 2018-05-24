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
                                        {{$check[0]->purchaseorder->branch->BraNum}} ถนน {{$check[0]->purchaseorder->branch->BraRoad}} <br>
                                        ตําบล {{$check[0]->purchaseorder->branch->district->district_name}} อำเภอ  {{$check[0]->purchaseorder->branch->amphur->amphur_name}} <br>
                                        จังหวัด {{$check[0]->purchaseorder->branch->province->province_name}} ประเทศ  {{$check[0]->purchaseorder->branch->country->name_th}} <br>
                                        รหัสไปรษณีย์ {{$check[0]->purchaseorder->branch->BraZipcode}}<br>
                                        เบอร์โทร {{$check[0]->purchaseorder->branch->BraMobile}}<br>
                                        แฟ็กซ์  {{$check[0]->purchaseorder->branch->BraFax}}<br></p>
                                </td>
                                <td align="center" width="30%" style="color: black;padding-top: 10px; font-weight: bold;"><p style="font-size: 17px;margin-top: -51px;">ใบสั่งซื้อ</p></td>
                                <td align="left" width="35%" style="color: black; font-size: 20px;padding-top: 10px; border-bottom: none; border-top:none; border-right:none;">
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>PO : </strong> {{$check[0]->PoNO}}</p>
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Date : </strong> {{$check[0]->purchaseorder->PoDate}}</p>
                                    <!-- <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Time :</strong> 11:33:27 &nbsp;&nbsp;&nbsp;&nbsp; <strong>Page : 1/1</strong></p>  -->
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
                    <th height="30px" width="10%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Item Name <br> ชื่อของสินค้า</th>
                    <th height="30px" width="5%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Qty <br> จำนวน</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Price/Unit <br>ราคา/หน่วย</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Discount <br>ส่วนลด</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Amount <br>จํานวนเงิน</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = $sum_money = 0; ?>
                @foreach($check as $k => $v)
                <?php
                    $i              += $v->PoQTY*$v->PoUnitPrice;
                    $less_cash_disc = $check[0]->purchaseorder->PoOther;
                    $total          = $i - $less_cash_disc;
                    $tax            = $check[0]->purchaseorder->PoTax;
                    $grand_total    = $total+$tax;
                    $sum_tax = ($v->PoTax!="0.0")?$v->PoTax*($v->PoQTY*$v->PoUnitPrice)/100:0;
                    $money          = number_format($v->PoQTY*$v->PoUnitPrice+$sum_tax,2);
                    $sum_money += $v->PoQTY*$v->PoUnitPrice+$sum_tax;
                ?>
                <tr>
                    <td height="30px" width="5%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="center">&nbsp; {{$id++}}</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="left">&nbsp;{{$v->PoDescription}}</td>
                    <td height="30px" width="5%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{$v->PoQTY}} &nbsp;</td>
                    <td height="30px" width="10%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{$v->PoUnitPrice}} &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">{{0}} &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right" class="amount">{{$money}} &nbsp;</td>
                </tr>
                @endforeach

            </tbody>

        </table>
<!--foot -->
@php
    if($tax!=0) {
        $tax = $tax*$sum_money/100;
    }
    $total = $sum_money - $less_cash_disc;
    $grand_total = $sum_money+$tax;
@endphp
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
                    <td width="15%" align="right" class="sumtotal" id="sumtotal">{{number_format($sum_money,2)}}​&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;<strong> หักส่วนลดพิเศษ (Less Cash Disc)</strong></td>
                    <td align="right" class="less_cash_disc" id="less_cash_disc">{{number_format($less_cash_disc,2)}}​&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp; <strong> ยอดคงเหลือ (Total)</strong></td>
                    <td align="right" class="total" id="total">{{number_format($total,2)}}​&nbsp;</td>
                </tr>
                <tr>
                    <td> &nbsp; <strong>ภาษีมูลค่าเพิ่ม (Total VAT)</strong></td>
                    <td align="right" class="total_vat" id="total_vat">{{number_format($tax,2)}}​​​​ &nbsp;</td>
                </tr>
            </tbody>
        </table>
        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
            <tbody>
                <tr>
                    <td rowspan="4" width="55%">
                        <p style="margin-top: 13px; text-align: center; font-size: 15px;">&nbsp; <strong>({{App\Http\Controllers\FunctionController::m2t($grand_total)}})</strong></p>
                    </td>
                    <td width="30%">&nbsp;<strong> ยอดสุทธิ (Grand Total)</strong></td>
                    <td width="15%" align="right" class="grand_total" id="grand_total = ">{{number_format($grand_total,2)}} &nbsp;</td>
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
