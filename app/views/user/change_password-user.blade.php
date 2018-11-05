@extends('layouts.layout')
@section("migajas")
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard-user')}}">Inicio</a>
        </li>
        <li class="breadcrumb-item active">Cambio de contraseña</li>
    </ol>
@endsection
@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Cambiar contraseña</strong>
            </div>
            <div class="card-block">
                <form action="{{url("change-password-user")}}" method="post" enctype="multipart/form-data"
                      class="form-horizontal ">
                    {{ csrf_field() }}
                    @if (session()->has("errors"))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach (session("errors") as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{session()->forget("errors")}}
                    @endif
                    @if (session()->has("success"))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success" role="alert">
                                    <ul>
                                        @foreach (session("success") as $item)
                                            <li>{!! $item !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{session()->forget("success")}}
                    @endif
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Contraseña actual</label>
                        <div class="col-md-9">
                            <input type="password" id="text-input" value="{{old("old_password")}}" name="old_password" class="form-control"
                                   placeholder="Contraseña actual">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Nueva contraseña</label>
                        <div class="col-md-9">
                            <input type="password" id="text-input" value="{{old("new_password")}}" name="new_password" class="form-control"
                                   placeholder="Nueva contraseña">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Confirme su nueva contraseña</label>
                        <div class="col-md-9">
                            <input type="password" id="text-input" value="{{old("confirm_password")}}" name="confirm_password" class="form-control"
                                   placeholder="Confirme su nueva contraseña">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-md-3 form-control-label" for="textarea-input">&nbsp;</label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


@endsection



                  
