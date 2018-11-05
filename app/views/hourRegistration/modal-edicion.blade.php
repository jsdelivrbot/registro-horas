<!-- project model popup -->
<div class="modal fade" tabindex="-1" role="dialog" id="editarRegistroHora">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edición de horas registradas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="question">Fecha</label>
                    <div class="col-md-8">
                        <input id="fecha" name="fecha" readonly type="text" class="form-control" placeholder="Fecha" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="question">Inicio</label>
                    <div class="col-md-8 clockpicker-with-callbacks">
                        <input id="desde" name="start_time" readonly required="" type="text" class="form-control" placeholder="Inicio" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="question">Fin</label>
                    <div class="col-md-8 clockpicker-with-callbacks">
                        <input id="hasta" name="end_time" readonly required="" type="text" class="form-control" placeholder="Fin" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="question">Break (en minutos)</label>
                    <div class="col-md-8">
                        <input id="break" name="break" min="0" type="number" class="form-control" placeholder="break" autocomplete="on">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="question">Horas trabajadas</label>
                    <div class="col-md-8">
                        <input id="totalHoras" name="total_hours" readonly="" type="text" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarEdicionRegistroHoras">Guardar</button>
            </div>
        </div>
    </div>
</div>