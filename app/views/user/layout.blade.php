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
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>Administrator Console</title>

    <!-- Icons -->
    <link href="{{ URL::asset('admin/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('admin/css/simple-line-icons.css')}}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ URL::asset('admin/css/style.css')}}" rel="stylesheet">

</head>

<body class="navbar-fixed sidebar-nav fixed-nav">
	@include('header')
    @include('sidebar')

	@yield('content')

	<footer class="footer">
        <span class="text-left">
            <a href="http://coreui.io">CoreUI</a> © 2016 creativeLabs.
        </span>
        <span class="float-xs-right">
            Powered by <a href="http://coreui.io">CoreUI</a>
        </span>
    </footer>

	
 <!-- Bootstrap and necessary plugins -->
    <script	src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="bower_components/pace/pace.min.js"></script>


    <!-- Plugins and scripts required by all views -->
    <!--script src="{{ URL::asset('admin/js/views/chart.js') }}"></script-->


    <!-- GenesisUI main scripts -->
    <script src="{{ URL::asset('admin/js/app.js')}}"></script>
    <!-- Plugins and scripts required by this views -->
    <!-- Custom scripts required by this view -->
    <!--<script src="{{ URL::asset('admin/js/views/main.js')}}"></script>-->



</body>

</html>
