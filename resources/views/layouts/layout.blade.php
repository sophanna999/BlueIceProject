<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="WorkByThai">
    <meta name="keyword" content="BlueIce">

    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

    <link href="{{asset('fonts/Trirong-webfont.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/simple-line-icons.css')}}" rel="stylesheet">

    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/jquery.validate.css')}}">
</head>
<body>
    @section('sidebar')
    @endsection

    <div class="container">
        @yield('body')
    </div>
</body>

    <script>
        var url = "{{url('')}}";
    </script>

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/popper/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>

    <!-- Plugin -->
    <script src="{{asset('js/validate/jquery.validate.js')}}"></script>
    <script  charset="utf8" src="{{asset('js/function.js')}}"></script>
    @yield('jsbottom')
</html>
