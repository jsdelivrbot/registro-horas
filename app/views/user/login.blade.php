@extends('layouts.login_layout')

@section('content')
    <div class="container d-table">
        <div class="d-100vh-va-middle">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    @if (session('status'))
                        <div class="alert alert-danger">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card-group">
                        <div class="card p-2">
                            <form action="{{ url('login') }}" name="frmlogin" id="frmlogin" method="post">
                                <div class="card-block">
                                    <h1>One Way</h1>
                                    {{ csrf_field() }}
                                    <div class="input-group mb-1">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                        <input type="text" class="form-control" value="{{old('username')}}"
                                               placeholder="Username" name="username">
                                    </div>
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                    @endif
                                    <div class="input-group mb-2">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                        <input type="password" class="form-control validate[required]"
                                               value="{{old('password')}}" placeholder="Password" name="password">
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <button type="submit" class="btn btn-primary px-2">Login</button>
                                        </div>
                                        <div class="col-xs-6 text-xs-right">
                                            <!--                                        <button type="button" class="btn btn-link px-0">Forgot password?</button>-->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
