<style>
    @page {
        header: page-header;
        footer: page-footer;
    }
    table{
        width: 100%; 
        text-align: center;
    }
    .content{
        padding: 1%;
        float: left;
        text-align: center;
        width: 100%;
        height: 100%;
    }
    title{
        display: none;
        color: white;
    }
</style>
<?php ini_set('memory_limit', '512M'); ?>
<htmlpageheader name="page-header">
    <div style="text-align: center;">
        <title>
            Customer Barcode
        </title>
    </div>
</htmlpageheader>
@foreach($cus as $cusqr)
<div class="content">
    <div><h1>{{$cusqr->CusID}}</h1></div>
    <div class="qrcodeTable{{$cusqr->CusID}}">
        <barcode code="{{$cusqr->CusID}}" size="5" type="QR" error="M" class="barcode" />
    </div>
    <br><br><br><br>
    <div class="barcode{{$cusqr->CusID}}" style="margin: auto;">
        <barcode code="{{$cusqr->CusID}}" type="C39" size="4" text="{{$cusqr->CusID}}" class="barcode" />
        {{$cusqr->CusID}}
    </div>
</div>
@endforeach
<htmlpagefooter name="page-footer">
</htmlpagefooter>