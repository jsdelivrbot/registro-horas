@extends('layouts.layout')
@section('content')
    <?php
    if (isset($_GET['page'])) {
        if ($_GET['page'] >= 2) {
            $start = 1 + (10 * ($_GET['page'] - 1));
            //echo $start; die;
        } else {
            $start = 1;
        }
    } else {
        $start = 1;
    }
    ?>



    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Proyectos</h4>
                        <!--                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
                        <div class="table-responsive m-t-40">
                            <table id="users_datatables"
                                   class="display nowrap table table-hover table-striped table-bordered" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>No. de trabajadores</th>
                                    <th>Creado</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($proyectos as $proyecto)
                                    <tr>
                                        <td>
                                            {{$proyecto->id}}
                                        </td>
                                        <td>
                                            {{$proyecto->name}}
                                        </td>
                                        <td>{{$proyecto->address}}</td>
                                        <td>
                                            <span class="f-left margin-r-5">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-id="ID" >
                                                    {{count($proyecto->project_worker)}} Trabajador{{count($proyecto->project_worker) > 1 ? 'es': ''}}
                                                </button>
                                            </span>
                                        </td>
                                        <td>{{$proyecto->created_at}}</td>
                                        <td>{!!  $proyecto->status == '1' ? '<span class="f-left margin-r-5" id="status_'.$proyecto->id.'"><a data-toggle="tooltip"  class="btn btn-success btn-xs" title="Active" onClick="changeStatus('.$proyecto->id.')" >Active</a></span>' : '<span class="f-left margin-r-5" id = "status_'.$proyecto->id.'"><a data-toggle="tooltip"  class="btn btn-danger btn-xs" title="Inactive" onClick="changeStatus('.$proyecto->id.')" >Inactive</a></span>'!!}</td>
                                        <td>
                                            <a href="{{route('projects.add', $proyecto->id)}}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <form method="POST" action="{{route("projects.delete", ["id" => $proyecto->id])}}" accept-charset="UTF-8"
                                                  style="display:inline" class="deleteFrom">
                                                <input name="_method" value="POST" type="hidden">
                                                {{csrf_field()}}
                                                <span>
                                                <a href="javascript:void(0)" onclick="confirm_click(this);"
                                                   data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->

    <script>


        function changeStatus(id) {
            $.ajax({
                url: '{{route('projects.status')}}',
                type: 'POST',
                data: {user_id: id},
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $("#status_" + id).html(response);
                }
            });
        }

        $(function () {
            var table = $('#users_datatables').DataTable({
                order: [[0, "desc"]]
            });
        });
        function confirm_click(e) {
            var r = confirm("¿Seguro que desea eliminar?");
            if (r == true) {
                $(e).closest('form').submit();
            }
        }

        function noOfWorkers(e) {
            $.ajax({
                url: '{{route('projects.workersList')}}',
                type: 'POST',
                data: {id: e},
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {
                        $(".worker-container").html(response.data);
                        $('#myModal').modal('show');
                    }

                }
            });
        }

    </script>
@endsection
