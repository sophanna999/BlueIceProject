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
                <h2>Purchase Order</h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        <!-- John Smith<br> -->
                        {{$check[0]->purchaseorder->branch->BraNum}} ถนน {{$check[0]->purchaseorder->branch->BraRoad}} <br>
                        ตําบล {{$check[0]->purchaseorder->branch->district->district_name}} อำเภอ  {{$check[0]->purchaseorder->branch->amphur->amphur_name}} <br>
                        จังหวัด {{$check[0]->purchaseorder->branch->province->province_name}} ประเทศ  {{$check[0]->purchaseorder->branch->country->name_th}} <br>
                        รหัสไปรษณีย์ {{$check[0]->purchaseorder->branch->BraZipcode}}<br>
                        เบอร์โทร {{$check[0]->purchaseorder->branch->BraMobile}}<br>
                        แฟ็กซ์  {{$check[0]->purchaseorder->branch->BraFax}}<br>
                    </address>
                </div>
                <div class="col-6 text-right">
                    <h4 class=""><strong>PO : </strong>{{$check[0]->PoNO}}</h4>
                    <h5 class=""><strong>Date : </strong> {{$check[0]->purchaseorder->PoDate}}</h5>


                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <address>
                        <strong>Vendor:</strong><br>
                        <!-- John Smith<br> -->
                        {{$check[0]->purchaseorder->supplier->SupNum}} ถนน {{$check[0]->purchaseorder->supplier->SupRoad}} <br>
                        ตําบล {{$check[0]->purchaseorder->supplier->district->district_name}} อำเภอ  {{$check[0]->purchaseorder->supplier->amphur->amphur_name}} <br>
                        จังหวัด {{$check[0]->purchaseorder->supplier->province->province_name}} ประเทศ  {{$check[0]->purchaseorder->supplier->country->name_th}} <br>
                        รหัสไปรษณีย์ {{$check[0]->purchaseorder->supplier->SupZipcode}}<br>
                        เบอร์โทร {{$check[0]->purchaseorder->supplier->SupMobile}}<br>
                        แฟ็กซ์  {{$check[0]->purchaseorder->supplier->SupFax}}<br>
                    </address>
                </div>
                <div class="col-6 text-right">
                    <address>
                        <strong>Shipped To:</strong><br>
                        {{$check[0]->purchaseorder->shipto->BraNum}} ถนน {{$check[0]->purchaseorder->shipto->BraRoad}} <br>
                        ตําบล {{$check[0]->purchaseorder->shipto->district->district_name}} อำเภอ  {{$check[0]->purchaseorder->shipto->amphur->amphur_name}} <br>
                        จังหวัด {{$check[0]->purchaseorder->shipto->province->province_name}} ประเทศ  {{$check[0]->purchaseorder->shipto->country->name_th}} <br>
                        รหัสไปรษณีย์ {{$check[0]->purchaseorder->shipto->BraZipcode}}<br>
                        เบอร์โทร {{$check[0]->purchaseorder->shipto->BraMobile}}<br>
                        แฟ็กซ์  {{$check[0]->purchaseorder->shipto->BraFax}}<br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>Item</strong></td>
                                    <td class="text-center"><strong>Price</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"><strong>Totals</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($check as $v)
                                <tr>
                                    <td>{{$v->PoDescription}}</td>
                                    <td class="text-center">{{$v->PoUnitPrice}}</td>
                                    <td class="text-center">{{$v->PoQTY}}</td>
                                    <td class="text-right">{{($v->PoUnitPrice*$v->PoQTY)+(($v->PoUnitPrice*$v->PoQTY)*($v->PoTax)/100)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                    <td class="thick-line text-right subtotal"></td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Shipping</strong></td>
                                    <td class="no-line text-right">$15</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Total</strong></td>
                                    <td class="no-line text-right">$685.99</td>
                                </tr>
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
        var total = 0;
        $.each($('tbody>tr'),function(){
            total += parseFloat($(this).find('td:last').text().replace(',', ''));
        });
        $('.subtotal').text(total);
    });
</script>
@endsection
