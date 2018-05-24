@extends('layouts.layout')
@section('csstop')
<!-- <link href="{{asset('js/lightGallery/css/lightgallery.min.css')}}" rel="stylesheet"> -->
@endsection

@section('body')

<br>
<div class="container">
  <div class="col-md-12">
  <h2 class="text-center"><u>กรุณาระบุสาขา</u></h2>
  <br>
  <div class="row">

      @if($branchs->count())
        @foreach($branchs as $key => $branch)
        <div class="col-md-3" style="float:left;">
          <div class="card" >
          <a href="{{url('branch')}}/{{$branch->BraID}}">
            <img class="card-img-top" src="{{asset('/uploads/temp/')}}/{{$branch->photo}}" alt="Card image cap">
            <div class="card-block">

              <p class="card-text">{{$branch->BraName}}</p>
            </div>
            </a>
          </div>
        </div>
        @endforeach
      @else
        <div class="">
          <h3><strong>ไม่มีข้อมูล กรุณาติดต่อผู้ดูแลระบบ</strong></h3><br>
          <!-- <a href="{{url('Logout')}}"><button class="btn btn-warning">ออกจากระบบ</button></a> -->
        </div>
      @endif
  </div>
      <div class="row">
          <!-- <h3><strong>ไม่มีข้อมูล กรุณาติดต่อผู้ดูแลระบบ</strong></h3><br> -->
          <a href="{{url('Logout')}}"><button class="btn btn-warning">ออกจากระบบ</button></a>
      </div>
  </div>
</div>
@endsection

@section('jsbottom')
<!-- <script src="{{asset('js/lightGallery/js/lightgallery-all.min.js')}}"></script> -->
@endsection
