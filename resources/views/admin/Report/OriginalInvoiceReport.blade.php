@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<title>{{$title}} | BlueIce</title>
<style>
        body{
            font-family: 'Garuda';
        }
    </style>
@endsection

@section('body')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header" style="width: 100%">
            <i class="fa fa-align-justify"></i><strong>{{$title}}</strong>
        </div>
        <div class="card-body">
            <?php $test = 5; ?>
        <?php for($i=1;$i<=$test;$i++){ ?>

        <?php if($i % 17 ==1){ ?>

                <?php if($i != 1){ ?>

                <div style="page-break-after: always;"> </div>

                <?php }?>

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
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;">106/11 หมู่ที่6 ต.ปาเสมัส อ.สุไหงโก-ลก นาราธิราส</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;">รหัสไปรษณีย์ : 06120</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;">Tel : 073-613-989, 081-122-1212, 086-299-8777</p> 
                                </td>
                                <td align="center" width="30%" style="color: black;padding-top: 10px; font-weight: bold;"><p style="font-size: 17px;margin-top: -51px;">ต้นฉบับใบกํากับภาษี/ต้นฉบับใบเสร็จรับเงิน</p></td>
                                <td align="left" width="35%" style="color: black; font-size: 20px;padding-top: 10px; border-bottom: none; border-top:none; border-right:none;">
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Inv. No. : </strong>INV0654214254</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Date :</strong>08/03/2561</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Time :</strong> 11:33:27 &nbsp;&nbsp;&nbsp;&nbsp; <strong>Page : 1/1</strong></p> 
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div>
                        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
                            <tr>
                                <td align="left" width="55%">
                                    <p style="font-size: 15px; padding-top:10px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;">เลขประจําตัวเสียภาษี : / สํานักงานใหญ่</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Customer No. :</strong>  99999</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Customer Name :</strong>  Somsri Saksri</p> 
                                </td>
                                <td align="left" width="45%">
                                    <p style="font-size: 15px; padding-top:10px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Term of payment :</strong> ต้องยอมรับเรา</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Reference No. :</strong>  99999</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Due Date :</strong>30/12/2018</p> 
                                    <p style="font-size: 15px; padding-top:0px;padding-right: 50px;padding-bottom: 0px;padding-left: 20px;"><strong>Salesman No. :</strong>  S0212414</p> 
                                </td>
                            </tr>
                        </table>
                    </div>

        <div style="padding-top: 10px">
            <?php } ?>

        <!--mid -->

        <table style="border-collapse: collapse;" width="100%" >
              <?php if($i % 17 ==1) { ?>
            <thead>
                <tr>
                    <th height="30px" width="5%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Item <br> ลำดับ</th>
                    <th height="30px" width="10%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Article Number <br> รหัสสินค้า</th>
                    <th height="30px" width="25%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Article Description <br>รายละเอียด</th>
                    <th height="30px" width="5%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Qty <br> จำนวน</th>
                    <th height="30px" width="10%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Unit <br>หน่วย</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Price/Unit <br>ราคา/หน่วย</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Discount <br>ส่วนลด</th>
                    <th height="30px" width="15%" bgcolor="#F8F8FF" style="font-size: 15px; border: #000 solid 1px; text-align: center;">Amount <br>จํานวนเงิน</th>
                </tr>
            </thead>
            <?php }  ?>
            <tbody>
                <tr>
                    <td height="30px" width="5%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="center">&nbsp;<?php echo $i;?></td>
                    <td height="30px" width="10%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="left">&nbsp;01-CLEO</td>
                    <td height="30px" width="25%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="left">&nbsp;จาปารา น้ำหอม กลิ่น คลีโอพัตรา 8 มล.</td>
                    <td height="30px" width="5%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">1.00 &nbsp;</td>
                    <td height="30px" width="10%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="center">BOX</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">1,190.00 &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">1,190.00 &nbsp;</td>
                    <td height="30px" width="15%" style="border-bottom: none; border-top:none; font-size: 15px;border-left: #000 solid 1px; border-right: #000 solid 1px;" align="right">1,190.00 &nbsp;</td>
                </tr>

            </tbody>

        </table>
<!--foot -->
        <?php //  ตอนดึงข้อมูลใช้อันนี้แทน   if(($i % 17 ==0 && $i!=1) || ($i == count($test))) { ?>
        <?php if(($i % 17 ==0 && $i!=1) || ($i == ($test))) { ?>
        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
            <tbody>
                <tr>
                    <td rowspan="4" width="55%">
                        <p style="margin-top: 13px;">&nbsp; ได้รับรับสินค้าดังรายการข้างบนเรียนร้อยแล้ว <br> 
                        &nbsp; Recieved the above mentioned on good order and dondition. <br> 
                        &nbsp; การชําระเงินด้วยเช็คจะสมบูรณ์ต่อบริษัท ได้รับเงินตามเช็คเรียบร้อยแล้ว <br> 
                        &nbsp; Payment by cheque not valid till the cheque has been honoured.</p>
                    </td>
                    <td width="30%">&nbsp;<strong> รวมเงิน (Sub Total)</strong></td>
                    <td width="15%" align="right">197,809.00</td>
                </tr>
                <tr>
                    <td>&nbsp;<strong> หักส่วนลดพิเศษ (Less Cash Disc)</strong></td>
                    <td align="right">197,809.00</td>
                </tr>
                <tr>
                    <td>&nbsp; <strong> ยอดคงเหลือ (Total)</strong></td>
                    <td align="right">197,809.00</td>
                </tr>
                <tr>
                    <td> &nbsp; <strong>ภาษีมูลค่าเพิ่ม (Total VAT)</strong></td>
                    <td align="right">197,809.00</td>
                </tr>
            </tbody>
        </table>
        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
            <tbody>
                <tr>
                    <td rowspan="4" width="55%">
                        <p style="margin-top: 13px; text-align: center; font-size: 20px;">&nbsp; <strong>(หนึ่งแสนเก้าหมื่นเจ็ดพันแปดร้อยเก้าบาทถ้วน)</strong></p>
                    </td>
                    <td width="30%">&nbsp;<strong> ยอดสุทธิ (Grand Total)</strong></td>
                    <td width="15%" align="right">197,809.00</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div style="padding-top: 10px">
        <table style="border-collapse: collapse;" border="1" width="100%" class="table_css">
            <tr>
               <td style="border-right: none; height: 150px;" width="20%"><center style="margin-top: 56px;">___________________________________<br> ผู้รับสินค้า <br> Receiver</center></td>
               <td style="border-left: none" width="20%"><center style="margin-top: 56px;">___________________________________<br> วันที่รับ <br> Received Date</center></td>
               <td width="20%"><center style="margin-top: 56px;">___________________________________<br> ผู้ส่งสินค้า <br> Deliverer</center></td>
               <td style="border-right: none" width="20%"><center style="margin-top: 56px;">___________________________________<br> ผู้รับเงิน <br> Collector</center></td>
               <td style="border-left: none" width="20%"><center style="margin-top: 56px;">___________________________________<br> ผู้อนุมัติ <br> Authorized</center></td>
            </tr>
        </table>
    </div>
        <?php }  ?>

        <?php } ?>
        </div>
    </div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script>

</script>
@endsection
