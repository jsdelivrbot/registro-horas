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
                    <div class="card-header">
                        <h4>Horas registradas</h4><br>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-3">
                                <input id="rangoDeFechas" class="form-control" readonly>
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="empleadoId" id="empleadoId" value="{{session("id")}}">
                            </div>
                            <div class="col-md-3">
                                <label>Total de horas: <b><span id="horasTotales" style="color:#00b3ee; font-size: 1.1rem;"></span></b></label>
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
        var loadData = function () {

            var empleadoId = $("#empleadoId").val();
            localStorage.setItem("fc_empleadoId", empleadoId);

            $.ajax({
                type: "post",
                url: "{{route('hours-registered')}}",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                    "desde": desde.format("YYYY-MM-DD"),
                    "hasta": hasta.format("YYYY-MM-DD"),
                    "proyectoId": 0,
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
                defaultView: 'month',
                header: {
                    right:  'prev,next'
                },
                editable: true, // If it's editable
                selectable: true, // If events are selectable,
                events: horasRegistradas,
                resources: empleados,
                showNonCurrentDates: false,
                eventRender: function (eventObj, $el) {
                    $el.popover({
                        title: eventObj.data.worker.full_name,
                        content: "<ul>" +
                        "<li><b>Proyecto:</b> " + eventObj.data.project.name + "</li>" +
                        "<li><b>Inicio:</b> " + eventObj.data.start_time + "</li>" +
                        "<li><b>Fin:</b> " + eventObj.data.end_time + "</li>" +
                        "<li><b>Descanso:</b> " + eventObj.data.break + " Minutos</li>" +
                        "<li><b>Horas:</b> " + eventObj.data.total_hours + "</li>" +
                        "</ul>",
                        html: true,
                        trigger: "hover",
                        placement: 'top',
                        container: 'body'
                    });
                }
            });

            calendario.fullCalendar("gotoDate",desde);
        };
        // Calcular horas totales
        var calcularHorasTotales = function () {
            var t = 0;
            for (var f = 0; f < horasRegistradas.length; f++)
                t += parseFloat(horasRegistradas[f].data.total_hours);

            $("#horasTotales").text(t);

        };
        // End Inicio del proceso con la primer quincena

        // Al iniciar DOM, se cargan valores del usuario
        $(document).ready(function () {
            var element = null;

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
