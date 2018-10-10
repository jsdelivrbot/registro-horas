@extends('layouts.layout')
@section('content')  

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <strong><?php echo $title; ?></strong>
        </div>
        <div class="card-block">
            <form action="{{url("settings")}}" method="post" enctype="multipart/form-data" class="form-horizontal ">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="text-input">Username</label>
                    <div class="col-md-9">
                        <input type="text" id="text-input" name="username" value="{{@$data->username}}" class="form-control" placeholder="Username">
                        @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif                                         
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="text-input">Email</label>
                    <div class="col-md-9">
                        <input type="text" id="text-input" name="email" value="{{@$data->email}}" class="form-control" placeholder="Email Address">
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif                                         
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-md-3 form-control-label" for="textarea-input">&nbsp;</label>
                    <div class="col-md-9">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



