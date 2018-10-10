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
                        <div class="card-block text-xs-center">
                            <div>
                                <h1>Email verification completed successfully now can you log.</h1>
                            </div>
                        </div>
                        @else
                        <div class="card-block text-xs-center">
                            <div>
                                <h1>Token has expired.</h1>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card " style="width:44%">
                        <img width="321px" height="287px" src="{{url('public/images/logo.png')}}">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
