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
                <h2>Invoice</h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <address>
                        <strong>Branch:</strong><br>
                        {{$check[0]->customerinvoice->branch->BraNum }} ถนน {{$check[0]->customerinvoice->branch->BraRoad}} <br>
                        ตําบล {{$check[0]->customerinvoice->branch->district->district_name}} อำเภอ  {{$check[0]->customerinvoice->branch->amphur->amphur_name}} <br>
                        จังหวัด {{$check[0]->customerinvoice->branch->province->province_name}} ประเทศ  {{$check[0]->customerinvoice->branch->country->name_th}} <br>
                        รหัสไปรษณีย์ {{$check[0]->customerinvoice->branch->BraZipcode}}<br>
                        เบอร์โทร {{$check[0]->customerinvoice->branch->BraMobile}}<br>
                        แฟ็กซ์  {{$check[0]->customerinvoice->branch->BraFax}}<br>
                    </address>
                </div>
                <div class="col-6 text-right">
                    <h4 class=""><strong>Invoice : </strong> {{$check[0]->customerinvoice->InvID}}</h4>
                    <h5 class=""><strong>Customer ID : </strong>{{$check[0]->customerinvoice->CusID}} </h5>
                    <h5 class=""><strong>Date : </strong>{{$check[0]->customerinvoice->InvDate}}</h5>
                    <h5 class=""><strong>Currency : </strong> {{$check[0]->customerinvoice->currency->currency_name}} </h5>
                </div>
            </div>
            <div class="row">
            @if($check[0]->Customer!=NULL)
                <div class="col-6">
                    <address>
                        <strong>Bill To:</strong><br>
                        {{$check[0]->Customer->CusNum }} ถนน {{$check[0]->Customer->CusRoad}} <br>
                        ตําบล {{$check[0]->Customer->district->district_name}} อำเภอ  {{$check[0]->Customer->amphur->amphur_name}} <br>
                        จังหวัด {{$check[0]->Customer->province->province_name}} ประเทศ  {{$check[0]->Customer->country->name_th}} <br>
                        รหัสไปรษณีย์ {{$check[0]->Customer->CusZipcode}}<br>
                        เบอร์โทร {{$check[0]->Customer->CusMobile}}<br>
                        แฟ็กซ์  {{$check[0]->Customer->CusFax}}<br>

                    </address>
                </div>  
                @endif
                @if($check[0]->customeraddressofdelivery!=NULL)
                <div class="col-6 text-right">
                    <address>
                        <strong>Shipped To:</strong><br>
                        {{$check[0]->customeraddressofdelivery->AodNum }} ถนน {{$check[0]->customeraddressofdelivery->AodNum}} <br>
                        ตําบล {{$check[0]->customeraddressofdelivery->district->district_name}} อำเภอ  {{$check[0]->customeraddressofdelivery->amphur->amphur_name}} <br>
                        จังหวัด {{$check[0]->customeraddressofdelivery->province->province_name}} ประเทศ  {{$check[0]->customeraddressofdelivery->country->name_th}} <br>
                        รหัสไปรษณีย์ {{$check[0]->customeraddressofdelivery->AodZipcode}}<br>
                    </address>
                </div>
                @endif
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
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @foreach($check as $v)
                                <tr>
                                    <td>{{$v->product->ProName}}</td>
                                    <td class="text-center">{{$v->UnitPrice}}</td>
                                    <td class="text-center">{{$v->ProSales}}</td>
                                    <td class="text-right">{{$v->UnitPrice*$v->ProSales}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                    <td class="thick-line text-right">$670.99</td>
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
@endsection
