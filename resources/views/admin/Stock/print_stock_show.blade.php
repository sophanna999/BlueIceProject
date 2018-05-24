@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('css/prints.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
@endsection
@section('body')
<div class="container test">
    <div class="row">
        <div class="col-12">
            <div class="invoice-title">
                <h2>Stock Recieved</h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <address>
                        <strong>ชื่อแผนก:</strong> {{$check[0]->stockmaterial->department->department_name}} <br>
                        <strong>ผู้บันทึก:</strong> {{$check[0]->stockmaterial->reciever->firstname.' '.$check[0]->stockmaterial->reciever->lastname}} <br>
                        <strong>ผู้รับสินค้า:</strong> {{$check[0]->stockmaterial->recorder->firstname.' '.$check[0]->stockmaterial->recorder->lastname}} <br>
                    </address>
                </div>
                <div class="col-6 text-right">
                    <address>
                        <strong>PO :</strong> {{$check[0]->MatNoDoc}} <br>
                        <strong>DATE :</strong> {{$check[0]->stockmaterial->date_doc}} <br>
                    </address>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Stock Recieved</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>No</strong></td>
                                    <td class="text-center"><strong>เลขที่ใบสั่งซื้อ</strong></td>
                                    <td class="text-center"><strong>รหัสวัสดุ</strong></td>
                                    <td class="text-right"><strong>ชื่อวัสดุ</strong></td>
                                    <td class="text-right"><strong>สาขา</strong></td>
                                    <td class="text-right"><strong>จํานวน</strong></td>
                                    <td class="text-right"><strong>จํานวน/ต้นทุนต่อหน่วย</strong></td>
                                    <td class="text-right"><strong>จํานวนเงินรวม</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @foreach($check as $val)
                                    <tr>
                                        <td>{{$id++}}</td>
                                        <td class="text-center">{{$val->PoNO}}</td>
                                        <td class="text-center">{{$val->MatCode}}</td>
                                        <td class="text-right">{{$val->MatDescription}}</td>
                                        <td class="text-right">{{$val->branch->BraName}}</td>
                                        <td class="text-right">{{$val->MatUnit}}</td>
                                        <td class="text-right">{{number_format($val->MatPricePerUnit)}}</td>
                                        <td class="text-right total">{{number_format($val->MatUnit * $val->MatPricePerUnit,2)}}</td>
                                    </tr>
                                @endforeach()
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-right"><strong>Total</strong></td>
                                    <td class="thick-line text-right subtotal"></td>
                                </tr>
                                <!-- <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Shipping</strong></td>
                                    <td class="no-line text-right">$15</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Total</strong></td>
                                    <td class="no-line text-right">$685.99</td>
                                </tr> -->
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('jsbottom')

<script>
    $(function(){
        CalTotal();
        function CalTotal(){
            var total = 0;
            $.each($('tbody>tr'),function(){
                console.log($(this).find('td:last').text());
                total += parseFloat($(this).find('td:last').text().replace(',', ''));
            });
        $('.subtotal').text(addCommas(total));
        }
        function addCommas(nStr)
            {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
    });
</script>
@endsection
