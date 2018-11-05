@extends('layouts.layout')
@section("migajas")
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route("hour-registration")}}">Horas</a>
        </li>
        <li class="breadcrumb-item active">Registro</li>
    </ol>
@endsection
@section('content')

    <link type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css"/>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--  <link rel="stylesheet" href="/resources/demos/style.css">-->
    <!--  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!--<link href="{{ URL::asset('/admin/css/jquery.timepicker.css')}}" rel="stylesheet" type="text/css" />-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/clock/bootstrap-clockpicker.min.css')}}">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Registro de horas trabajadas</h4><br>
            </div>

            <div class="card-block">
                <form id="myForm" action="{{url('hour-registration/add/'.@$projects->id)}}" method="POST"
                      class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="question">Proyecto</label>
                                <div class="col-md-8">
                                    <?php $projectid = old('project') != '' ? old('project') : (isset($projects['project']) ? $projects['project'] : ''); ?>
                                    <select id="project" name="project" required="" class="form-control"
                                            style="margin-left: 0px;">
                                        <option value="">--Proyecto--</option>
                                        @foreach($project_list as $row)
                                            <option value="{{$row['id']}}" {{($row['id']==$projectid)?'selected':''}}>{{$row['name']}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('project'))
                                        <span class="help-block">
                        <strong>{{ $errors->first('project') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div id="trabajadores"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="question">Fecha</label>
                                <div class="col-md-8">
                                    <input id="datepicker" name="date" required="" readonly type="text"
                                           value="<?php echo old('date') != '' ? old('date') : (isset($projects['work_date']) ? $projects['work_date'] : ''); ?>"
                                           class="form-control" placeholder="Select date" autocomplete="off">
                                    @if ($errors->has('date'))
                                        <span class="help-block">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="question">Inicio</label>
                                <div class="col-md-8 clockpicker-with-callbacks">
                                    <input id="start_time" name="start_time" required="" type="text"
                                           value="<?php echo old('start_time') != '' ? old('start_time') : (isset($projects['start_time']) ? $projects['start_time'] : ''); ?>"
                                           onkeypress="return false" class="form-control" placeholder="Start Time"
                                           autocomplete="off" readonly>
                                    @if ($errors->has('start_time'))
                                        <span class="help-block">
                        <strong>{{ $errors->first('start_time') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="question">Fin</label>
                                <div class="col-md-8 clockpicker-with-callbacks">
                                    <input id="end_time" name="end_time" required="" type="text"
                                           value="<?php echo old('end_time') != '' ? old('end_time') : (isset($projects['end_time']) ? $projects['end_time'] : ''); ?>"
                                           class="form-control" placeholder="End time" autocomplete="off" readonly>
                                    @if ($errors->has('end_time'))
                                        <span class="help-block">
                        <strong>{{ $errors->first('end_time') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="question">Break (en minutos)</label>
                                <div class="col-md-8">
                                    <input id="break" name="break" min="0" type="number"
                                           value="<?php echo old('break') != '' ? old('break') : (isset($projects['break']) ? $projects['break'] : ''); ?>"
                                           class="form-control" placeholder="break" autocomplete="on">
                                    @if ($errors->has('break'))
                                        <span class="help-block">
                        <strong>{{ $errors->first('break') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="question">Horas trabajadas</label>
                                <div class="col-md-8">
                                    <input id="total_hours" name="total_hours" readonly="" type="text"
                                           value="<?php echo old('total_hours') != '' ? old('total_hours') : (isset($projects['total_hours']) ? $projects['total_hours'] : ''); ?>"
                                           class="form-control">
                                    @if ($errors->has('total_hours'))
                                        <span class="help-block">
                        <strong>{{ $errors->first('total_hours') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-md-3 form-control-label" for="textarea-input">&nbsp;</label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-dot-circle-o"></i>
                                        Guardar
                                    </button>&nbsp;
                                    <a class="btn btn-secondary" href="{{route("hour-registration")}}">
                                        <i class="fa fa-ban"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <style>
        .help-block {
            color: #d14;
        }
    </style>
    <!--<script src="{{ URL::asset('/admin/js/jquery.timepicker.js')}}" type="text/javascript"></script>-->
    <script type="text/javascript" src="{{ URL::asset('/clock/bootstrap-clockpicker.min.js')}}"></script>
    <script type="text/javascript">

        $(function () {

            $('#end_time').val('');
            $('#total_hours').val('');
            $('#break').val('');

            $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});

            $('#start_time').clockpicker({
                donetext: 'Seleccionar',
                autoclose: true,
                //twelvehour: true,
                placement: 'top',
                afterDone: function () {
                    var startTime = new Date("2017-01-26 " + $("#start_time").val());
                    $('#end_time').prop('disabled', false);
                }
            });

            var startTime = null;
            var endTime = null;
            var diff = 0;
            $('#end_time').clockpicker({
                donetext: 'Seleccionar',
                autoclose: true,
                //twelvehour: true,
                placement: 'top',
                afterDone: function () {
                    var start = $("#start_time").val();
                    var end = $("#end_time").val();
                    startTime = new Date("2017-01-26 " + start);
                    endTime = new Date("2017-01-26 " + end);
                    if (end < start)
                        startTime = new Date("2017-01-25 " + start);

                    diff = (endTime - startTime) / 1000 / 60;
                    $('#break').attr('max', diff);
                    var total = (diff / 60).toFixed(1);
                    if (total != 1.5)
                        total = Math.round(total);
                    $('#total_hours').val(total);
                }
            });

            $('#break').on('change keyup', function () {
                var breakMinutes = $(this).val();
                if (breakMinutes == "")
                    breakMinutes = 0;

                var start = $('#start_time').val();
                var end = $('#end_time').val();
                if (start.length > 0 && end.length > 0) {

                    var brkd = (diff - breakMinutes);
                    $('#total_hours').val((brkd / 60).toFixed(1));
                }
            });

            // Manually toggle to the minutes view
            $('#check-minutes').click(function (e) {
                // Have to stop propagation here
                e.stopPropagation();
                input.clockpicker('show').clockpicker('toggleView', 'minutes');
            });

            $("#project").on("change", function () {
                var id = $(this).val();
                $("#trabajadores").html("");
                $.ajax({
                    type: "get",
                    url: "{{route('workers-by-project')}}/" + id,
                    contentType: "application/json",
                    dataType: "json",
                    success: function (trabajadores) {
                        /*$("#worker").append("<option value=''>--Trabajador--</option>");*/
                        for (var g = 0; g < trabajadores.length; g++) {
                            var trabajador = trabajadores[g];
                            $("#trabajadores").append(
                                "<label>" +
                                "<input type='checkbox' name='trabajadores[]' value='" + trabajador.id + "'> " + trabajador.full_name +
                                "</label><br>");
                        }
                    }
                });
            });

            // Resaltar los que no están seleccionados
            $(document).on("change","input[name='trabajadores[]']", function(){
                if($(this).prop("checked"))
                {
                    $(this).parent().css("font-weight","bolder");
                }else{
                    $(this).parent().css("font-weight","normal");
                }
            });
        });
    </script>

@endsection

