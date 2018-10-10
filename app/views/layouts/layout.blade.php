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
        <title>:: Panel - <?php echo isset($title) ? $title : ''; ?></title>
        <!-- Icons -->
        <link href="{{ URL::asset('admin/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('admin/css/simple-line-icons.css')}}" rel="stylesheet">
        <!-- Main styles for this application -->
        <link href="{{ URL::asset('css/style.css')}}" rel="stylesheet">

        <link href="{{ URL::asset('admin/css/style.css')}}" rel="stylesheet">
        <script	src="{{ URL::asset('admin/js/jquery.min.js')}}"></script>
        @yield("css")
    </head>

    <body class="navbar-fixed sidebar-nav fixed-nav">
        @include('include.header')
        @include('include.sidebar')
        <!-- Main content -->
        <main class="main">
            {{--@include('include.breadcrumb')--}}
                @yield("migajas")
            @include('include.flash_message')
            <!-- /.conainer-fluid -->
        </main>
        <footer class="footer">
            <span class="text-left">
                © 2018 Registro de horas laborales
            </span>
            <span class="float-xs-right">
                Hecho por Loudyx
            </span>
        </footer>
        <!-- project model popup -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                 Modal content
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Workers</h4>
                    </div>
                    <div class="modal-body worker-container">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
         <!-- Image cropper model popup -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                    </div>
                </div>
            </div>
        </div>
        @include("hourRegistration.modal-edicion")
        
        <!-- Bootstrap and necessary plugins -->
        <script src="{{ URL::asset('admin/js/tether.min.js')}}"></script>
        <script src="{{ URL::asset('admin/js/moment.js')}}"></script>
        <script src="{{ URL::asset('admin/js/bootstrap.min.js')}}"></script>

        <!-- GenesisUI main scripts -->
        <script src="{{ URL::asset('admin/js/app.js')}}"></script>
        <script src="{{ URL::asset('admin/js/jscolor.js')}}"></script>
        <!-- Plugins and scripts required by this views -->
        <!-- Custom scripts required by this view -->


        <script src="{{ asset('admin/js/lib/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('admin/js/lib/datatables/datatables-init.js') }}"></script>
    @yield("js")

    </body>

</html>
