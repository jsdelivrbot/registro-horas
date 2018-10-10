@extends('layouts.layout')
@section("css")
    <link rel="stylesheet" href="/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/clock/bootstrap-clockpicker.min.css')}}">
    {{--<link rel="stylesheet" href="/fullcalendar/scheduler.min.css">--}}
@endsection
@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Horas registradas</h4>
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
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Total de horas: <span id="horasTotales"></span></label>
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
                hasta = moment(moment().get("year") + "-" + (moment().get("month") + 1) + "-" + moment().endOf("month"));
            } else {
                // Primer quincena
                desde = moment(moment().get("year") + "-" + (moment().get("month") + 1) + "-01");
                hasta = moment(moment().get("year") + "-" + (moment().get("month") + 1) + "-15");
            }
        };
        // Cargar las horas registradas de la BD
        var loadData = function (data) {
            $.ajax({
                type: "post",
                url: "{{route('hours-registered')}}",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                    "desde": desde.format("YYYY-MM-DD"),
                    "hasta": hasta.format("YYYY-MM-DD"),
                    "proyectoId": data.proyectoId,
                    "empleadoId": data.empleadoId
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
                editable: true, // If it's editable
                selectable: true, // If events are selectable,
                events: horasRegistradas,
                resources: empleados,
                eventClick: function (e, jsEvent, view) {
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
                    modal.find("#break").on('change keypress', function () {
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
                            success : function(res){
                                modal.modal("hide");

                                var proyectoId_ = $("#proyectos").val();
                                var empleadoId_ = $("#empleados").val();

                                if(proyectoId_ == "")
                                    proyectoId_ = 0;
                                if(empleadoId_ == "")
                                    empleadoId_ = 0;
                                loadData({
                                    proyectoId: proyectoId_,
                                    empleadoId: empleadoId_
                                });
                            }
                        });
                    });
                },
                eventRender: function (eventObj, $el) {
                    $el.popover({
                        title: eventObj.data.worker.full_name,
                        content: "<ul>" +
                        "<li>Inicio: " + eventObj.data.start_time + "</li>" +
                        "<li>Fin: " + eventObj.data.end_time + "</li>" +
                        "<li>Descanso: " + eventObj.data.break + " Minutos</li>" +
                        "<li>Horas: " + eventObj.data.total_hours + "</li>" +
                        "</ul>",
                        html: true,
                        trigger: "hover",
                        placement: 'top',
                        container: 'body'
                    });
                }
            });
        };
        // Calcular horas totales
        var calcularHorasTotales = function () {
            var t = 0;
            for (var f = 0; f < horasRegistradas.length; f++)
                t += parseFloat(horasRegistradas[f].data.total_hours);

            $("#horasTotales").text(t);

        };

        // Inicio del proceso con la primer quincena
        calcularQuincenaActual();
        loadData({
            proyectoId: 0,
            empleadoId: 0
        });
        // End Inicio del proceso con la primer quincena

        // Cuando se cambia la lista de proyectos
        $("#proyectos").on("change", function () {
            var proyectoId = $(this).val();

            localStorage.setItem("fc_proyectoId", proyectoId);

            $("#empleados").html("<option value=''>Trabajador</option>");

            if (proyectoId != "") {
                // Sólo si se seleccionó algo en la lista de proyectos
                $.ajax({
                    type: "get",
                    url: "{{route('workers-by-project')}}/" + proyectoId,
                    contentType: "application/json",
                    dataType: "json",
                    success: function (trabajadores) {
                        empleados = [];
                        for (var g = 0; g < trabajadores.length; g++) {
                            var trabajador = trabajadores[g];
                            $("#empleados").append("<option value='" + trabajador.id + "'>" + trabajador.full_name + "</option>");
                            empleados.push({
                                id: trabajador.id,
                                title: trabajador.full_name,
                                color: trabajador.color
                            });
                        }
                        if (localStorage.getItem("fc_empleadoId") !== undefined) {
                            // Si ya se seleccionó algún empleado
                            var element = $("#empleados");
                            element.val(localStorage.getItem("fc_empleadoId"));
                            element.trigger("change");
                        } else {
                            loadData({
                                proyectoId: proyectoId,
                                empleadoId: 0
                            });
                        }
                    }
                });
            } else {
                loadData({
                    proyectoId: 0,
                    empleadoId: 0
                });
            }
        });
        // Cuando se cambia la lista de empleados
        $("#empleados").on("change", function () {
            var empleadoId = $(this).val();

            localStorage.setItem("fc_empleadoId", empleadoId);

            if (empleadoId == "")
                empleadoId = 0;
            loadData({
                proyectoId: $("#proyectos").val(),
                empleadoId: empleadoId
            });
        });

        // Al iniciar DOM, se cargan valores del usuario
        $(document).ready(function () {
            var element = null;
            if (localStorage.getItem("fc_proyectoId") != undefined) {
                // Si ya se seleccionó algún proyecto
                element = $("#proyectos");
                element.val(localStorage.getItem("fc_proyectoId"));
                element.trigger("change");
            }

            if (localStorage.getItem("fc_desde") != undefined && localStorage.getItem("fc_hasta") != undefined) {
                // Si ya se seleccionó alguna fecha
                desde = moment(localStorage.getItem("fc_desde"));
                hasta = moment(localStorage.getItem("fc_hasta"));
            }

            // Se crea el daterange picker
            $("#rangoDeFechas").daterangepicker({
                startDate: desde,
                endDate: hasta,
                ranges: {
                    'Quincena 1': [moment().date(1), moment().date(1).add(14, 'days')],
                    'Quincena 2': [moment().date(1).add(14, 'days'), moment().endOf('month')],
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

                loadData({
                    proyectoId: $("#proyectos").val(),
                    empleadoId: $("#empleados").val()
                });
            });
        });
    </script>
@endsection