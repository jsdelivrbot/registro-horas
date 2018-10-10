@extends('layouts.layout')
@section('content')  

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <strong><?php echo $title;?></strong>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">Name :</div>
                                                <div class="text-uppercase">
                                                    {{@$user->full_name}}
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">User Type :</div>
                                                <div class="text-uppercase">
                                                    
                                                    @if (!empty($user->social_type))
                                                        {{strtoupper(@$user->social_type)}}
                                                    @else
                                                        {{strtoupper('manually')}}
                                                    @endif                                                    
                                                </div>
                                            </div>
                                        </div>                                           
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">Email :</div>
                                                <div class="text-uppercase">
                                                    {{@$user->email}}
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">Gender :</div>
                                                <div class="text-uppercase">
                                                   {{$user->gender}}
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">Date Of Birth :</div>
                                                <div class="text-uppercase">
                                                    <?php echo date('d M Y',strtotime($user->dob)); ?>
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">Nationality :</div>
                                                <div class="text-uppercase">
                                                     <?php echo $user['country']['name'];?>
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">User Status :</div>
                                                <div class="text-uppercase">
                                                    {{($user->status==1)?"Active":"Inactive"}}
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">Mobile Number :</div>
                                                <div class="text-uppercase">
                                                    {{@$user->mobile_number}}
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-block text-xs-center">
                                                <div class="h6">Created :</div>
                                                <div class="text-uppercase">
                                                    {{@$user->created_at}}
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>
                                </div>
                               
                                <!--/row-->
                               
                            </div>
                            <div class="card-footer">
                                <a class="btn btn-outline-primary left-back-btn" href="{{url('users/')}}"  >Back</a>
                            </div>
                            
                        </div>

                    </div>
                    <!--/col-->
                </div>
                <!--/.row-->

@endsection

   
