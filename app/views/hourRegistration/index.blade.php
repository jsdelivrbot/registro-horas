@extends('layouts.layout')
@section("css")
    <link rel="stylesheet" href="/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/clock/bootstrap-clockpicker.min.css')}}">
    {{--<link rel="stylesheet" href="/fullcalendar/scheduler.min.css">--}}
@endsection
@section("migajas")
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Horas</li>
    </ol>
@endsection
@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Horas Registradas</h4><br>
                        <a class="btn btn-info" href="{{route("hour-registration.add")}}">
                            <i class="fa fa-plus"></i> Ingresar horas
                        </a>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-3">
                                <input id="rangoDeFechas" class="form-control" readonly>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="proyectos">
                                    <option value="">Proyecto</option>
                                    @foreach($proyectos as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="empleados">
                                    <option value="">Trabajador</option>
                                    @foreach($trabajadores as $p)
                                        <option value="{{$p->id}}">{{$p->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Total de horas:
                                    <b>
                                        <span id="horasTotales" style="color:#00b3ee; font-size: 1.1rem;"></span>
                                    </b>
                                </label>
                            </div>
                        </div>
                        <div id='calendar'></div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->
@endsection
@section("js")
    <script src="/fullcalendar/moment.min.js"></script>
    <script src="/fullcalendar/fullcalendar.min.js"></script>
    {{--<script src="/fullcalendar/scheduler.min.js"></script>--}}
    <script src='/fullcalendar/locale/es.js'></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('/clock/bootstrap-clockpicker.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var empleados = [];
        var horasRegistradas = [];
        var calendario = undefined;
        var desde = moment();
        var hasta = moment();

        // Calcular la quincena actual
        var calcularQuincenaActual = function () {
            var today = moment().get("date");
            if (today > 15) {
                // Segunda quincena
                desde = moment(moment().get("year") + "-" + (moment().get("month") + 1) + "-16");
                hasta = moment(moment().get("year") + "-" + (moment().get("month") + 1) + "-" + moment().endOf("month").get("date"));
            } else {
                // Primer quincena
                desde = moment(moment().get("year") + "-" + (moment().get("month") + 1) + "-01");
                hasta = moment(moment().get("year") + "-" + (moment().get("month") + 1) + "-15");
            }
        };
        // Cargar las horas registradas de la BD
        var loadData = function () {

            var empleadoId = $("#empleados").val();
            var proyectoId = $("#proyectos").val();
            localStorage.setItem("fc_proyectoId", proyectoId);
            localStorage.setItem("fc_empleadoId", empleadoId);

            if (empleadoId == "")
                empleadoId = 0;
            if (proyectoId == "")
                proyectoId = 0;

            $.ajax({
                type: "post",
                url: "{{route('hours-registered')}}",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                    "desde": desde.format("YYYY-MM-DD"),
                    "hasta": hasta.format("YYYY-MM-DD"),
                    "proyectoId": proyectoId,
                    "empleadoId": empleadoId
                }),
                success: function (datos) {
                    horasRegistradas = [];
                    for (var i = 0; i < datos.length; i++) {
                        var dato = datos[i];
                        horasRegistradas.push({
                            id: dato.id.toString(),
                            title: dato.total_hours,
                            start: dato.work_date,
                            color: dato.worker.color,
                            data: dato
                        });

                    }
                    loadCalendar();
                    calcularHorasTotales();
                }
            });
        };
        // Cargar el calendario de nuevo
        var loadCalendar = function () {
            if (calendario != undefined)
                calendario.fullCalendar("destroy");
            calendario = $('#calendar').fullCalendar({
                locale: 'es',
                /*schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',*/
                defaultView: 'month',
                header: {
                    right:  'prev,next'
                },
                editable: true, // If it's editable
                selectable: true, // If events are selectable,
                events: horasRegistradas,
                resources: empleados,
                showNonCurrentDates: false,
                eventClick: function (e, jsEvent, view) {
                    $(document).off("click").on("click", ".btnEditar", function () {
                        $(jsEvent.currentTarget).popover('hide');
                        var modal = $("#editarRegistroHora");
                        var diff = 0;
                        startTime = new Date("2017-01-26 " + e.data.start_time);
                        endTime = new Date("2017-01-26 " + e.data.end_time);
                        if (endTime < startTime)
                            startTime = new Date("2017-01-25 " + e.data.start_time);

                        diff = (endTime - startTime) / 1000 / 60;
                        // Set campo fecha
                        var fechaPicker = modal.find("#fecha").datepicker({
                            dateFormat: 'yy-mm-dd'
                        });
                        fechaPicker.datepicker("setDate", e.start.format("YYYY-MM-DD"));
                        $('#desde').clockpicker({
                            donetext: 'Seleccionar',
                            autoclose: true,
                            'default': e.data.start_time,
                            placement: 'bottom',
                            afterDone: function () {
                                var start = $("#desde").val();
                                var end = $("#hasta").val();
                                startTime = new Date("2017-01-26 " + start);
                                endTime = new Date("2017-01-26 " + end);
                                if (endTime < startTime)
                                    startTime = new Date("2017-01-25 " + start);

                                diff = (endTime - startTime) / 1000 / 60;
                                $('#break').attr('max', diff);
                                var total = ((diff - $("#break").val()) / 60).toFixed(1);
                                $('#totalHoras').val(total);
                            }
                        });
                        $('#hasta').clockpicker({
                            donetext: 'Seleccionar',
                            autoclose: true,
                            'default': e.data.end_time,
                            placement: 'bottom',
                            afterDone: function () {
                                var start = $("#desde").val();
                                var end = $("#hasta").val();
                                startTime = new Date("2017-01-26 " + start);
                                endTime = new Date("2017-01-26 " + end);
                                if (endTime < startTime)
                                    startTime = new Date("2017-01-25 " + start);

                                diff = (endTime - startTime) / 1000 / 60;
                                $('#break').attr('max', diff);
                                var total = ((diff - $("#break").val()) / 60).toFixed(1);
                                $('#totalHoras').val(total);
                            }
                        });
                        // Set campo desde
                        modal.find("#desde").val(e.data.start_time);
                        // Set campo hasta
                        modal.find("#hasta").val(e.data.end_time);
                        // Set campo break
                        modal.find("#break").val(e.data.break);
                        // Change and keypress event
                        modal.find("#break").on('change keyup', function () {
                            var breakMinutes = $(this).val();
                            if (breakMinutes == "")
                                breakMinutes = 0;

                            var start = $('#desde').val();
                            var end = $('#hasta').val();
                            if (start.length > 0 && end.length > 0) {

                                var brkd = (diff - breakMinutes);
                                $('#totalHoras').val((brkd / 60).toFixed(1));
                            }
                        });
                        // Set campo total_hours
                        modal.find("#totalHoras").val(e.data.total_hours);
                        modal.modal("show");
                        // Cuando se guardan los cambios
                        modal.find("#guardarEdicionRegistroHoras").off("click").on("click", function () {
                            var registro = {};
                            registro.trabajadores = [e.data.worker.id];
                            registro.project = e.data.project.id;
                            registro.date = $("#fecha").val();
                            registro.start_time = $("#desde").val();
                            registro.end_time = $("#hasta").val();
                            registro.break = $("#break").val();
                            registro.total_hours = $("#totalHoras").val();

                            $.ajax({
                                type: "post",
                                url: "{{route('hour-registration.add')}}/" + e.id,
                                contentType: "application/json",
                                data: JSON.stringify(registro),
                                dataType: "json",
                                success: function (res) {
                                    modal.modal("hide");
                                    loadData();
                                }
                            });
                        });
                    });
                },
                eventRender: function (eventObj, $el) {
                    $el.popover({
                        title: eventObj.data.worker.full_name,
                        content: "<ul>" +
                        "<li><b>Proyecto:</b> " + eventObj.data.project.name + "</li>" +
                        "<li><b>Inicio:</b> " + eventObj.data.start_time + "</li>" +
                        "<li><b>Fin:</b> " + eventObj.data.end_time + "</li>" +
                        "<li><b>Descanso:</b> " + eventObj.data.break + " Minutos</li>" +
                        "<li><b>Horas:</b> " + eventObj.data.total_hours + "</li>" +
                        "</ul>" +
                        "<button class='btn btn-secondary btnEditar'>" +
                        "<i class='fa fa-cogs'></i>" +
                        "</button>",
                        html: true,
                        trigger: "hover",
                        placement: 'top',
                        container: 'body'
                    });
                },
                viewRender: function(view, element) {
                    /*var f = view.start.format("YYYY-MM-DD");
                    var e = view.end.format("YYYY-MM-DD");
                    if(calendario != undefined)
                    {
                        var inicio = desde.format("YYYY-MM-DD");
                        var fin = hasta.format("YYYY-MM-DD");
                        if(f  !== inicio && e !== fin)
                        {
                            desde = view.start;
                            hasta = view.end;
                            loadData();
                        }
                    }*/
                }
            });

            calendario.fullCalendar("gotoDate", desde);
        };
        // Calcular horas totales
        var calcularHorasTotales = function () {
            var t = 0;
            for (var f = 0; f < horasRegistradas.length; f++)
                t += parseFloat(horasRegistradas[f].data.total_hours);

            $("#horasTotales").text(t);

        };
        // End Inicio del proceso con la primer quincena

        // Cuando se cambia la lista de proyectos
        $("#proyectos").on("change", function () {
            loadData();
        });
        // Cuando se cambia la lista de empleados
        $("#empleados").on("change", function () {
            loadData();
        });

        // Al iniciar DOM, se cargan valores del usuario
        $(document).ready(function () {
            var element = null;
            if (localStorage.getItem("fc_proyectoId") != undefined) {
                // Si ya se seleccionó algún proyecto
                element = $("#proyectos");
                element.val(localStorage.getItem("fc_proyectoId"));
            }

            if (localStorage.getItem("fc_empleadoId") != undefined) {
                // Si ya se seleccionó algún proyecto
                element = $("#empleados");
                element.val(localStorage.getItem("fc_empleadoId"));
            }

            if (localStorage.getItem("fc_desde") != undefined && localStorage.getItem("fc_hasta") != undefined) {
                // Si ya se seleccionó alguna fecha
                desde = moment(localStorage.getItem("fc_desde"));
                hasta = moment(localStorage.getItem("fc_hasta"));
            }else{
                // Inicio del proceso con la primer quincena
                calcularQuincenaActual();
            }

            // Se crea el daterange picker
            $("#rangoDeFechas").daterangepicker({
                startDate: desde,
                endDate: hasta,
                ranges: {
                    'Quincena 1': [moment().date(1), moment().date(1).add(14, 'days')],
                    'Quincena 2': [moment().date(1).add(15, 'days'), moment().endOf('month')],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')]
                },
                locale: {
                    "customRangeLabel": "Personalizado",
                    "applyLabel": "Aceptar",
                    "cancelLabel": "Cancelar"
                }
            }, function (start, end, label) {
                desde = start;
                hasta = end;

                localStorage.setItem("fc_desde", desde.format("YYYY-MM-DD"));
                localStorage.setItem("fc_hasta", hasta.format("YYYY-MM-DD"));

                loadData();
            });
            $(document).on("click",".fc-prev-button",function(e){
                desde = calendario.fullCalendar("getDate");
                hasta = moment(desde).endOf('month');
                localStorage.setItem("fc_desde", desde.format("YYYY-MM-DD"));
                localStorage.setItem("fc_hasta", hasta.format("YYYY-MM-DD"));
                loadData();
            });
            $(document).on("click",".fc-next-button",function(e){
                desde = calendario.fullCalendar("getDate");
                hasta = moment(desde).endOf('month');
                localStorage.setItem("fc_desde", desde.format("YYYY-MM-DD"));
                localStorage.setItem("fc_hasta", hasta.format("YYYY-MM-DD"));
                loadData();
            });
            loadData();
        });
    </script>
@endsection