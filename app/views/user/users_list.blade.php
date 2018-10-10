@extends('layouts.layout')
@section('content')
    <?php

    use Illuminate\Support\Facades\Input;

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
                        <h4 class="card-title">Trabajadores</h4>
                        <!--                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
                        <div class="table-responsive m-t-40">
                            <table id="users_datatables"
                                   class="display nowrap table table-hover table-striped table-bordered" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Foto</th>
                                    <th>Usuario</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users_list as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->full_name}}</td>
                                        <td><img width="50" src="{{$user->profile_image}}" alt=""></td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->mobile_number}}</td>
                                        <td>{!!  $user->status ? '<span class="f-left margin-r-5" id="status_'.$user->id.'"><a data-toggle="tooltip"  class="btn btn-success btn-xs" title="Active" onClick="changeStatus('.$user->id.')" >Active</a></span>' : '<span class="f-left margin-r-5" id = "status_'.$user->id.'"><a data-toggle="tooltip"  class="btn btn-danger btn-xs" title="Inactive" onClick="changeStatus('.$user->id.')" >Inactive</a></span>'!!}</td>
                                        <td>
                                            <a href="{{route('users.add', $user->id)}}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <form method="POST" action="{{route("users.delete", ["id" => $user->id])}}" accept-charset="UTF-8"
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
                                            {{--<a href="{{route('users.delete', $user->id)}}" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash-o"></i>
                                            </a>--}}
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
                url: '{{route('users.status')}}',
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
            });
        });
        function confirm_click(e) {
            var r = confirm("¿Seguro que desea eliminar?");
            if (r == true) {
                $(e).closest('form').submit();
            }
        }
    </script>

@endsection

