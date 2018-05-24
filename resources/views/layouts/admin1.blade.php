<!--
* CoreUI - Open Source Bootstrap Admin Template
* @version v1.0.6
* @link http://coreui.io
* Copyright (c) 2017 creativeLabs Łukasz Holeczek
* @license MIT
-->
<!DOCTYPE html>
<html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="author" content="WorkByThai">
        <meta name="keyword" content="BlueIce">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
        <!-- Styles required by this views -->
        <!-- link href="{{asset('js/lightGallery/css/lightgallery.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('js/orakuploader/orakuploader.css')}}"> -->
        <!-- <link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}"> -->
        <link rel="stylesheet" href="{{asset('js/datatables/css/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/jquery.validate.css')}}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- Icons -->
        <!--<link href="{{asset('fonts/kanit-webfont.css')}}" rel="stylesheet">-->
        <link href="{{asset('fonts/Trirong-webfont.css')}}" rel="stylesheet">
        <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{asset('css/simple-line-icons.css')}}" rel="stylesheet">
        <!-- Bootstrap -->
        <!-- <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">-->
        <!-- Main styles for this application -->
        <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
        <link href="{{asset('js/pace/pace.css')}}" rel="stylesheet">
        <link href="{{asset('js/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet">

        <link href="{{asset('css/custom.css')}}" rel="stylesheet">
        <link href="{{asset('css/select2.css')}}" rel="stylesheet">
        @yield('csstop')
    </head>

    <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

        <header class="app-header navbar">
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}"></a>
        </header>

        <div class="app-body">
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/')}}"><i class="icon-speedometer"></i>
                                แผงควบคุม
                            </a>
                        </li>

                        <?php
                        foreach ($AdminMenu as $Set) {
                            if ($Set->main_menu_id !== '0') {
                                $Sub_Menu[$Set->main_menu_id][$Set->id] = $Set;
                            }
                        }
                        ?>
                        @foreach($AdminMenu as $Menu)
                        @if($Menu->main_menu_id == 0)
                        <li class="nav-item {{ isset($Sub_Menu[$Menu->id]) ? 'nav-dropdown':''}}">
                            @if(isset($Sub_Menu[$Menu->id]) && in_array($Menu->id,$PermissionMenu))
                            <a class="nav-link {{ isset($Sub_Menu[$Menu->id]) ? 'nav-dropdown-toggle':''}}" href="#">
                                <i class="fa fa-{{$Menu->icon}}"></i>
                                <span>{{$Menu->name}}</span>
                            </a>
                            <ul class="nav-dropdown-items">
                                @foreach($Sub_Menu[ $Menu->id ] as $SubMenu)

                                <li class="nav-item">
                                    <a style="font-weight:300;" class="nav-link"
                                       href="{{url($Menu->link.'/'.$SubMenu->link)}}">
                                        <i class="fa fa-{{$SubMenu->icon}}"></i>
                                        {{$SubMenu->name}}</a>
                                </li>

                                @endforeach
                            </ul>
                            @endif
                            @if(!isset($Sub_Menu[$Menu->id]))
                            <a class="nav-link" href="{{url($Menu->link)}}"><i class="fa fa-{{$Menu->icon}}"></i> {{$Menu->name}}</a>
                            @endif
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </nav>
                <button class="sidebar-minimizer brand-minimizer" type="button"></button>
            </div>
            <main class="main">
                @section('breadcrumb')
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">หน้าแรก</a>
                    </li>
                    @isset($main_menu)
                    <li class="breadcrumb-item">{{$main_menu}}</li>
                    @endisset
                    @isset($title)
                    <li class="breadcrumb-item active">
                        {{$title}}
                    </li>
                    @endisset
                    @isset($child)
                    <li class="breadcrumb-item active">{{$child}}</li>
                    @endisset
                    <!-- Breadcrumb Menu-->
                    <!--
                    <li class="breadcrumb-menu d-md-down-none">
                        <div class="btn-group" role="group" aria-label="Button group">
                        <a class="btn" href="#"><i class="icon-speech"></i></a>
                        <a class="btn" href="./"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                        <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
                        </div>
                    </li>
                    -->
                    <li class="breadcrumb-menu d-md-down-none">
                        <div class="btn-group">
                            <btn class="btn"><i class="fa fa-building-o"></i> :&nbsp;หจก.บลูไอซ์หะยีมะดาโอ๊ะ </btn>
                            ( <btn class="btn">รหัสสาขา :&nbsp;{{ session('BraID') }}</btn>,
                            <btn class="btn">สาขา :&nbsp;{{ session('BraName') }}</btn> )
                        </div>
                    </li>
                </ol>
                @endsection
                @yield('breadcrumb')
                @yield('body')
            </main>

        </div>

        <footer class="app-footer">
            <span><a href="http://coreui.io">CoreUI</a> © 2017 creativeLabs.</span>
            <span class="ml-auto">Powered by <a href="http://coreui.io">CoreUI</a></span>
        </footer>

        <!-- Bootstrap and necessary plugins -->
        <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"
            type="text/javascript"></script> -->

        <script src="{{asset('js/popper/dist/umd/popper.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/pace/pace.min.js')}}"></script>
        <!-- Plugins and scripts required by all views -->
        <!-- <script src="{{asset('js/Chart.js')}}"></script>-->
        <!-- CoreUI main scripts -->
        <script src="{{asset('js/app.js')}}"></script>
        <!-- Custom scripts required by this view -->
        <!-- <script src="{{asset('js/views/main.js')}}"></script> -->

        <!-- Plugin -->
        <script src="{{asset('js/validate/jquery.validate.js')}}"></script>
        <script src="{{asset('js/sweetalert2/sweetalert2.min.js')}}"></script>
        <!--<script src="{{asset('js/lightGallery/js/lightgallery-all.min.js')}}"></script>-->
        <!-- <script src="{{asset('js/daterangepicker/moment.js')}}"></script>
        <script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script> -->
        <!--<script src="{{asset('js/orakuploader/orakuploader.js')}}"></script>-->
        <script src="{{asset('js/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{asset('js/datatables/js/dataTables.bootstrap4.js')}}"></script>
        <script src="{{asset('js/select2.js')}}"></script>
        <script>
            var url = "{{url('')}}";
            var asset = "{{asset('')}}";
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script>
            $('body').on('click','.nav-link',function() {
                var this_item = $(this);
                var check = 0; //0 add 1 remove
                if(this_item.closest('li').hasClass('open')==false) {
                    check = 1;
                }
                $.each($('.nav-link'),function() {
                    $(this).closest('li').removeClass('open');
                });
                if(check==1) {
                    this_item.closest('li').removeClass('open');
                } else {
                    this_item.closest('li').addClass('open');
                }
            });
        </script>
        <script  charset="utf8" src="{{asset('js/function.js')}}"></script>
        @yield('jsbottom')

    </body>
</html>
