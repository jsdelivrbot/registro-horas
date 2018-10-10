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
    <link href="{{ URL::asset('public/admin/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('public/admin/css/simple-line-icons.css')}}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ URL::asset('public/admin/css/style.css')}}" rel="stylesheet">

</head>

<body>

	@yield('content')


 <!-- Bootstrap and necessary plugins -->
    <script	src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="bower_components/pace/pace.min.js"></script>


    <!-- Plugins and scripts required by all views -->
    <script src="{{ URL::asset('public/admin/js/views/chart.js') }}"></script>


    <!-- GenesisUI main scripts -->
    <script src="{{ URL::asset('public/admin/js/app.js')}}"></script>
    <!-- Plugins and scripts required by this views -->
    <!-- Custom scripts required by this view -->
    <!--<script src="{{ URL::asset('public/admin/js/views/main.js')}}"></script>-->



</body>

</html>