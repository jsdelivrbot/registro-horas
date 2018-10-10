<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.2
 * @link http://coreui.io
 * Copyright (c) 2016 creativeLabs Łukasz Holeczek
 * @license MIT
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
        <meta name="author" content="Lukasz Holeczek">
        <meta name="keyword" content="CoreUI Bootstrap 4 Admin Template">
        <link rel="icon" href="{{URL::asset('images/icon.png')}}"/>
        <title>:: Login</title>
        <link href="{{ URL::asset('admin/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('admin/css/simple-line-icons.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('admin/css/style.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('admin/css/custom.css')}}" rel="stylesheet">
        <script	src="{{ URL::asset('admin/js/jquery.min.js')}}"></script>
    </head>
    <body class="navbar-fixed sidebar-nav fixed-nav">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    @if (session('success'))
                    <div class="alertmsg alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alertmsg alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    @yield('content')
                </div>
                <!--/row-->
            </div>
        </div>
        <script src="{{ URL::asset('admin/js/tether.min.js')}}"></script>
        <script src="{{ URL::asset('admin/js/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('admin/js/app.js')}}"></script>
        <script src="{{ URL::asset('admin/js/jscolor.js')}}"></script>
        <!-- Plugins and scripts required by this views -->
        <!-- Custom scripts required by this view -->
        <!--<script src="{{ URL::asset('admin/js/views/main.js')}}"></script>-->


        <!-- Include Multi Select plugin's CSS and JS: -->
        <script type="text/javascript" src="{{ URL::asset('admin/js/bootstrap-multiselect.js')}}"></script>
        <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-multiselect.css')}}" type="text/css"/>


    </body>

</html>
