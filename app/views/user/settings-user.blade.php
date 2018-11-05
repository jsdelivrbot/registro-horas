@extends('layouts.layout')
@section("migajas")
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard-user')}}">Inicio</a>
        </li>
        <li class="breadcrumb-item active">Ajustes</li>
    </ol>
@endsection
@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Ajustes</strong>
            </div>
            <div class="card-block">
                <form action="{{route("settings-user")}}" method="post" enctype="multipart/form-data"
                      class="form-horizontal ">
                    {{ csrf_field() }}
                    <div class="row form-group">
                        @if(session()->has("status"))
                            <span class="alert alert-success">{{session("status")}}</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Nombre de usuario</label>
                        <div class="col-md-9">
                            <input type="text" id="text-input" name="username" value="{{@$data->username}}"
                                   class="form-control" placeholder="Nombre de usuario">
                            @if ($errors->has('username'))
                                <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                            @endif
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



