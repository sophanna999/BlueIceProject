@extends('layouts.admin')
@section('csstop')
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">
<title>{{$title}} | BlueIce</title>
@endsection

@section('body')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header" style="width: 100%">
            <i class="fa fa-align-justify"></i><strong>{{$title}}</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class='col-md-12'>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-expanded="false">เลือกตามลูกค้า</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-expanded="false">เลือกตามรถบรรทุก</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="list" role="tabpanel" aria-expanded="true">
                            <div class="table-responsive">
                                <div class='row justify-content-md-center'>
                                    <div class="col-md-3 date">
                                        <input type="text" class='form-control datecalendar date_list' id="start">
                                    </div>
                                    ถึง : 
                                    <div class="col-md-3 date">
                                        <input type="text" class='form-control datecalendar date_list' id="end">
                                    </div>
                                </div>
                                <br>
                                <table id="report" class="table table-bordered table-striped table-sm">
                                    <thead class="table-info">
                                        <tr class='text-center'>
                                            <th style="width:10%;">วัน/เดือน/ปี</th>
                                            <th style="width:15%">รถบรรทุก</th>
                                            <th style="width:15%">ลูกค้า</th>
                                            <th style="width:15%">สถานที่</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="all" role="tabpanel" aria-expanded="false">
                            <div class='row justify-content-md-center'>
                                รถบรรทุก :
                                <div class="col-md-3">
                                    <select class='form-control date_all' id='truck'>
                                        <option>กรุณาเลือกรถบรรทุก</option>
                                        @foreach($truck as $row)
                                            <option value="{{$row->TruckID}}">{{$row->TruckNumber}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                วันที่ : 
                                <div class="col-md-3 date">
                                    <input type="text" class='form-control datecalendar date_all' id="date">
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class='col-md-12'>
                                    <div id="map_all" style="height:600px;width:100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="mapModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-info">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left">ระบุเส้นทางการส่งสินค้า</h4>
            </div>
            <div class="modal-body">
                <center>
                    <div id="map" style="width:700px;height:400px;background:yellow;width: 100%"></div>
                </center>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsbottom')
<script src="{{asset('js/daterangepicker/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqPH3YHS9dLAS7zRTdTZLUfbn4gGw1sYo&callback=myMap"></script>
<script>

    $('body').on('click','.btn-location',function(data){
        var btn = $(this);
        btn.button('loading');
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');

        var mapOptions = {
            center: {lat: lat, lng: lng},
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.HYBRID
        }

        var maps = new google.maps.Map(document.getElementById("map"),mapOptions);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng),
            map: maps,
            title: 'your location'
        });

        $("#mapModal").modal('show');
    });

    $( document ).ready(function() {
        var mapOptions = {
            center: {lat: 6.0272013, lng: 101.9691003},
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.HYBRID
        }
        var maps = new google.maps.Map(document.getElementById("map_all"),mapOptions);
    });

    $('.datecalendar').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD-MM-YYYY',
        }
    });

    var TableList = $('#report').dataTable({
        "ajax": {
            "url": url+"/Report/DeliverLocalReport/List",
            "data": function ( d ) {
                d.start = $('#start').val();
                d.end = $('#end').val();
            }
        },
        "columns": [
            {"data" : "date"},
            {"data" : "truck"},
            {"data" : "customer"},
            {"data" : "action"}

        ]
    });

    $('body').on('change', '.date_list',function(){
        TableList.api().ajax.reload();
    });

    $('body').on('change', '.date_all',function(){
        var truck = $('#truck').val();
        var date = $('#date').val();
        $.ajax({
            method : "GET",
            url : url+"/Report/DeliverLocalReport/getMarkByTruck/"+truck+"/"+date,
            dataType : 'json'
        }).done(function(locations){
            var bounds = new google.maps.LatLngBounds();
            var map = new google.maps.Map(document.getElementById('map_all'), {
                zoom: 15,
                center: new google.maps.LatLng(6.0272013, 101.9691003),
                mapTypeId: google.maps.MapTypeId.HYBRID
            });

            var infowindow = new google.maps.InfoWindow();
            var marker, i;

            for (i = 0; i < locations.length; i++) {  
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });

                if(locations.length>0){
                    bounds.extend(marker.position);
                }

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
            if(locations.length>0){
                map.fitBounds(bounds);
            }
        });
    });

</script>
@endsection
