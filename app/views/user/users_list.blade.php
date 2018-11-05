@extends('layouts.layout')
@section("migajas")
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Trabajadores</li>
    </ol>
@endsection
@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Trabajadores</h4><br>
                        <a class="btn btn-info" href="{{route("users.add")}}">
                            <i class="fa fa-plus"></i> Nuevo
                        </a>
                    </div>
                    <div class="card block">
                        <div class="table-responsive m-t-40">
                            <table id="users_datatables"
                                   class="display nowrap table table-hover table-striped table-bordered" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users_list as $user)
                                    <tr>
                                        <td><img width="50" src="{{$user->profile_image}}" alt=""></td>
                                        <td>{{$user->full_name}}</td>
                                        <td>{{$user->mobile_number}}</td>
                                        <td>{!!$user->status==1 ? '<span class="f-left margin-r-5" id="status_'.$user->id.'"><a data-toggle="tooltip"  class="btn btn-success btn-xs" title="Active" onClick="changeStatus('.$user->id.')" >Activo</a></span>' : '<span class="f-left margin-r-5" id = "status_'.$user->id.'"><a data-toggle="tooltip"  class="btn btn-danger btn-xs" title="Inactivo" onClick="changeStatus('.$user->id.')" >Inactivo</a></span>'!!}</td>
                                        <td>
                                            <a href="{{route('users.add', $user->id)}}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <form method="POST" action="{{route("users.delete", ["id" => $user->id])}}"
                                                  accept-charset="UTF-8"
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
            var table = $('#users_datatables').DataTable({});
        });
        function confirm_click(e) {
            var r = confirm("¿Seguro que desea eliminar?");
            if (r == true) {
                $(e).closest('form').submit();
            }
        }
    </script>

@endsection

