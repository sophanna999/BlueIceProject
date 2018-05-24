@extends('layouts.layout')
@section('body')

    <div class="app align-items-center justify-content-center">
      <div class="col-md-6">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">

            <!-- <form method="POST" action="{{ route('login') }}" accept-charset="utf-8" id="FormLogin"> -->
            <form method="POST" action="{{url('Manual')}}" accept-charset="utf-8" id="FormLogin">
              {{ csrf_field() }}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <h1>เข้าสู่ระบบ</h1>
              <p class="text-muted">เข้าใช้งานด้วยบัญชีของท่าน</p>
              @if ($errors->has('email'))
                    <strong style='color:red;'>{{ $errors->first('email') }}</strong>
              @endif
              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
              </div>
              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" required>
              </div>

              <div class="input-group mb-4">
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> จดจำการเข้าสู่ระบบ
                      </label>
                  </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <!-- <button type="button" class="btn btn-primary px-4">Login</button> -->
                  <button type="submit" class="btn btn-primary px-4">เข้าสู่ระบบ</button>
                </div>
              </div>
            </form>            </div>
          </div>

        </div>
      </div>
    </div>

@endsection

@section('jsbottom')
<script>
    $( "#FormLogin" ).validate({
      rules: {
        username: "required",
        password: "required",
      },
      messages: {
        username: "  กรุณาระบุ",
        password: "  กรุณาระบุ",
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
          $( element ).parents('.input-group').addClass( "has-error" ).removeClass( "has-success" );
      },
      unhighlight: function (element, errorClass, validClass) {
          $( element ).parents('.input-group').addClass( "has-success" ).removeClass( "has-error" );
      }
  });
</script>
@endsection
