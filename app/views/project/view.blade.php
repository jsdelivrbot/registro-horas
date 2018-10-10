@extends('layouts.layout')
@section('content')  
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong><?php echo $title; ?></strong>
                <a class="btn btn-outline-primary left-back-btn" href="{{url('admin/pitches/')}}"  >Back</a>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-block text-xs-center">
                                <div class="h6">Owner Email :</div>
                                <div class="text-uppercase">
                                    <?php echo $pitchDetail['ground']['email_id'];?>
                                </div>
                            </div>
                        </div>                                           
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-block text-xs-center">
                                <div class="h6">Pitch Name :</div>
                                <div class="text-uppercase">
                                    {{$pitchDetail['pitch_name']}}
                                </div>
                            </div>
                        </div>                                        
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-block text-xs-center">
                                <div class="h6">Pitch Size :</div>
                                <div class="text-uppercase">
                                    {{$pitchDetail['pitch_size']}}
                                </div>
                            </div>
                        </div>                                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-block text-xs-center">
                                <div class="h6">Price :</div>
                                <div class="text-uppercase">
                                    {{$pitchDetail['price']}}
                                </div>
                            </div>
                        </div>                                        
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-block text-xs-center">
                                <div class="h6">Type :</div>
                                <div class="text-uppercase">
									{{$pitchDetail['pitch_type']}}
                                </div>
                            </div>
                        </div>                                        
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-block text-xs-center">
                                <div class="h6">Ground Status :</div>
                                <div class="text-uppercase">
									 {{($pitchDetail['status']==1)?"Active":"Inactive"}}
                                </div>
                            </div>
                        </div>                                           
                    </div>
                </div>
                
                

                <!--/row-->

            </div>
        </div>

    </div>
    <!--/col-->
</div>
<!--/.row-->

@endsection


