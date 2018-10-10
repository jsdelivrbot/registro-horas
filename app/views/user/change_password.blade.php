@extends('layouts.layout')
@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong><?php echo $title;?></strong>
            </div>
            <div class="card-block">
                <form action="{{url("change-password")}}" method="post" enctype="multipart/form-data"
                      class="form-horizontal ">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Old Password</label>
                        <div class="col-md-9">
                            <input type="password" id="text-input" name="old_password" class="form-control"
                                   placeholder="Old Password">
                            @if ($errors->has('old_password'))
                                <span class="help-block">
                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">New Password</label>
                        <div class="col-md-9">
                            <input type="password" id="text-input" name="new_password" class="form-control"
                                   placeholder="New Password">
                            @if ($errors->has('new_password'))
                                <span class="help-block">
                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Confirm Password</label>
                        <div class="col-md-9">
                            <input type="password" id="text-input" name="confirm_password" class="form-control"
                                   placeholder="Confirm Password">
                            @if ($errors->has('confirm_password'))
                                <span class="help-block">
                                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-md-3 form-control-label" for="textarea-input">&nbsp;</label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


@endsection



                  
