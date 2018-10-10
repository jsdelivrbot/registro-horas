@extends('layouts.initial')

@section('content')
<div class="container d-table">
    <div class="d-100vh-va-middle">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                
                @if (session('type')=='error')
                    <div class="alert alert-danger">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('type')=='success')
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-group">
                    <div class="card p-2">
                        @if($status==true)
                        <form action="{{url("resetHandler/".$token)}}" name="frmlogin" id="frmlogin" method="post">
                            {{ csrf_field() }}
                            <div class="card-block">
                                <h1>Reset Password</h1>

                                <div class="input-group" style="margin-bottom:0.5rem !important">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" class="form-control validate[required]" placeholder="New Password" name="new_password">
                                </div>
                                @if ($errors->has('new_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                                @endif
                                
                                <div class="input-group" style="margin-bottom:0.5rem !important">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" class="form-control validate[required]" placeholder="Confirm Password" name="confirm_password">
                                </div>
                                @if ($errors->has('confirm_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                                @endif
                                <div class="row">
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-primary px-2">Reset</button>
                                    </div>
                                </div>
                        </form>
                        @else
                            <div class="card-block">
                                <h1>Token has been expired.</h1>
                        @endif
                        </div>
                    </div>
                    <div class="card card-inverse py-3 hidden-md-down" style="width:44%">
                        <div class="card-block text-xs-center">
                            <div>
                                <img style="margin-top: 15%;" width="100%" src= "{{url('public/images/logo.png')}}"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
