@extends('layouts.layout')
@section("migajas")
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route("projects")}}">Proyectos</a>
        </li>
        <li class="breadcrumb-item active">Registro</li>
    </ol>
@endsection
@section('content')
    <style>

        .selects select {
            width: 80%;
            float: left;
        }

        .selects a {
            width: 20%;
            float: right;
        }

        .selects {
            float: left;
            width: 100%;
        }

        .selects {
            margin-bottom: 10px;
            float: left;
            width: 100%;
        }

        .selects a i {
            float: right;
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 100%;
            line-height: 40px;
            text-align: center;
            color: red;
        }
    </style>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Registro de Proyectos</h4><br>
            </div>
            <div class="card-block">
                <form id="myForm" action="{{url('projects/add/'.@$project->id)}}" method="POST" class="form-horizontal"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Nombre</label>
                        <div class="col-md-6">
                            <input id="name" name="name" required="" type="text"
                                   value="<?php echo old('name') != '' ? old('name') : (isset($project->name) ? $project->name : ''); ?>"
                                   class="form-control" placeholder="Nombre" autocomplete="on">
                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Dirección</label>
                        <div class="col-md-6">
                            <input id="address" name="address" required="" type="text"
                                   value="<?php echo old('address') != '' ? old('address') : (isset($project->address) ? $project->address : ''); ?>"
                                   class="form-control" placeholder="Dirección" autocomplete="on">
                            @if ($errors->has('address'))
                                <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <?php if (isset($project->id)) { ?>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Trabajadores</label>
                        <div class="col-md-6">
                            <div class="field_wrapper">

                                <?php $worker = $ProjectWorker; ?>
                                <?php foreach ($worker as $key => $value) { ?>
                                <div class="selects">
                                    <select name="worker[]" required="" class="form-control">
                                        @if(!empty($users_list))
                                            @foreach($users_list as $row)
                                                <option value="{{$row['id']}}" {{($row['id']==$value)?'selected':''}}>{{$row['full_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <a href="javascript:void(0);" data-id="{{$value}}" class="remove_button_ajax"><i
                                                class="fa fa-trash-o"></i></a>

                                    @if ($errors->has('worker'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('worker') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                                <?php } ?>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-info btn-md add_button"
                               title="Agregar Trabajador">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Trabajadores</label>
                        <div class="col-md-6">
                            <div class="field_wrapper">
                                <div class="selects">
                                    <?php $worker = $ProjectWorker; ?>
                                    <select name="worker[]" required="" class="form-control" style="width: 100%;">
                                        <option value="">Eliga</option>
                                        @if(!empty($users_list))
                                            @foreach($users_list as $row)
                                                <option value="{{$row['id']}}" {{(in_array($row['id'],$worker))?'selected':''}}>{{$row['full_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('worker'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('worker') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary add_button" title="Agregar Trabajador">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="textarea-input">&nbsp;</label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-success"><i class="fa fa-dot-circle-o"></i> Guardar
                            </button>&nbsp;
                            <a class="btn btn-secondary" href="{{route("projects")}}">
                                <i class="fa fa-ban"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="clone hide" style="display:none">
        <div class="selects">
            <select name="worker[]" required="" class="form-control">
                <option value="">Eliga</option>
                @if(!empty($users_list))
                    @foreach($users_list as $row)
                        <option value="{{$row['id']}}">{{$row['full_name']}}</option>
                    @endforeach
                @endif
            </select>
            <a href="javascript:void(0);" class="remove_button"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = $(".clone").html();
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function () {

                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function (e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
            $(wrapper).on('click', '.remove_button_ajax', function (e) {
                //alert($(this).attr('data-id'));
                $.ajax({
                    url: '{{route('projects.deleteWorker')}}',
                    type: 'POST',
                    data: {id: $(this).attr('data-id')},
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        //$("#status_"+id).html(response);
                    }
                });


                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>


@endsection



