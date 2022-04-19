<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    {$JAVASCRIPT} {$CSSSYSTEM} {$TITLETAB}
</head>

<body>
    <div class="row alert alert-primary">
        <div class="col-md-6">
            <h3><i class="fa fa-cogs"></i> CONTROL PANEL TAREAS V2.1 &emsp13;</h3>
        </div>

        <div class="col-md-6">
            <div class="btn-group btn-group-toggle btn-sm" data-toggle="buttons">
                {foreach name=tipo from=$TIPO_TAREA key=llave item=t} {if $llave eq 0}

                <label class="btn btn-primary active"> <input type="radio" name="{$t.tipo_tarea_id }" id="{$t.tipo_tarea_id }" onchange="cargaNewPanel(this)" autocomplete="off" checked /> {$t.nombre} </label>

                {else if}

                <label class="btn btn-primary"> <input type="radio" name="{$t.tipo_tarea_id }" id="{$t.tipo_tarea_id }" onchange="cargaNewPanel(this)" autocomplete="off" /> {$t.nombre} </label>

                {/if} {/foreach}
            </div>
        </div>
    </div>

    {* Table avances *}

    <div class="pos-f-t">
        <nav class="alert alert-success" style="margin-top: 15px; padding: 0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleAvances" aria-controls="navbarToggleAvances" aria-label="Toggle navigation"><i class="fa fa-list"></i>&emsp;Avances</button>
        </nav>
        <div class="collapse detalle_actividad" id="navbarToggleAvances" id="detalle_actividad">
            <br />
            <div class="table-responsive">
                <table id="detalles_responsables" class="table table-hover table-sm" width="99%">
                    <thead>
                        <tr>
                            <th>Responsables</th>
                            <th>Promedio Avance</th>
                            <th>N° Tareas</th>
                            <th>N° Tareas Activas</th>
                            <th>N° Tareas Cerradas</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {* Table tareas para entregar hoy *}

    <div class="pos-f-t">
        <nav class="alert alert-warning" style="margin-top: 15px; padding: 0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleActuales" aria-controls="navbarToggleActuales" aria-label="Toggle navigation">
                <i class="fa fa-list"></i>&emsp;Tareas para entregar hoy
            </button>
        </nav>
        <div class="collapse detalle_actividad" id="navbarToggleActuales" id="detalle_actividad">
            <br />
            <div class="table-responsive">
                <table id="tareas_actuales" class="table table-hover table-sm" width="99%">
                    <thead>
                        <tr>
                            <th>Responsables</th>
                            <th>Codigo</th>
                            <th>Cliente</th>
                            <th>Fecha inicio</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {* Table tareas sin entregar (Con retraso) *}

    <div class="pos-f-t">
        <nav class="alert alert-danger" style="margin-top: 15px; padding: 0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleSinEntregar" aria-controls="navbarToggleSinEntregar" aria-label="Toggle navigation">
                <i class="fa fa-list"></i>&emsp;Tareas sin entregar (Con retraso)
            </button>
        </nav>
        <div class="collapse detalle_actividad" id="navbarToggleSinEntregar" id="detalle_actividad">
            <br />
            <div class="table-responsive">
                <table id="tareas_vencidas" class="table table-sm table-hover" width="99%">
                    <thead>
                        <tr>
                            <th>Tipo tarea</th>
                            <th>Responsables</th>
                            <th>Prioridad</th>
                            <th>Codigo</th>
                            <th>Cliente</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Dias de retraso</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {* Table tareas Finalizadas *}

    <div class="pos-f-t">
        <nav class="alert alert-success" style="margin-top: 15px; padding: 0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleFinalizadas" aria-controls="navbarToggleFinalizadas" aria-label="Toggle navigation">
                <i class="fa fa-list"></i>&emsp;Tareas finalizadas
            </button>
        </nav>
        <div class="collapse detalle_actividad" id="navbarToggleFinalizadas" id="detalle_actividad">
            <br />
            <div class="table-responsive">
                <table id="tareas_finalizadas" class="table table-sm table-hover" width="99%">
                    <thead>
                        <tr>
                            <th>Tipo tarea</th>
                            <th>Responsables</th>
                            <th>Estado</th>
                            <th>Codigo</th>
                            <th>Cliente</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {* Tareas pendientes por socializar *}

    <div class="pos-f-t">
        <nav class="alert alert-secondary" style="margin-top: 15px; padding: 0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglePendienteSocializar" aria-controls="navbarTogglePendienteSocializar" aria-label="Toggle navigation">
                <i class="fa fa-list"></i>&emsp;Tareas pendientes por socializar
            </button>
        </nav>
        <div class="collapse detalle_actividad" id="navbarTogglePendienteSocializar" id="detalle_actividad">
            <br />
            <div class="table-responsive">
                <table id="tareas_pendiente_socializar" class="table table-sm table-hover" width="99%">
                    <thead>
                        <tr>
                            <th>Tipo tarea</th>
                            <th>Responsables</th>
                            <th>Estado</th>
                            <th>Codigo</th>
                            <th>Cliente</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Finalizar</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <hr />

    <br />

    {* Table principal *}

    <div class="row">
        <div class="col-md-12">
            <table id="detalles" class="table table-sm table-hover" frame="BOX" style="text-align: center;" width="99%">
                <thead class="table-primary">
                    <tr>
                        <th>Codigo</th>
                        <th><i class="fa fa-pencil"></i></th>
                        <th><i class="fa fa-pencil"></i></th>
                        <th>Tipo tarea</th>
                        <th>Cliente</th>
                        <th>Prioridad</th>
                        <th>Tarea</th>
                        <th>Asiganada por</th>
                        <th>Responsable</th>
                        <th>Observacion</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Adjunto</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--modal agregar observacion-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Observación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" id="actividad_id_modal" value="" />
                            <label for="observacion" class="col-form-label">Observación:</label>
                            <textarea class="form-control" id="observacion" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="guardar_observacion">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!--modal cierre-->
    <div class="modal fade" id="exampleModalCierre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cerrar Actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" id="actividad_id_modal_cierre" value="" />
                            <label for="fecha_cierre" class="col-form-label">Fecha Cierre:</label>
                            <input type="date" class="form-control" id="fecha_cierre" required />
                        </div>
                        <div class="form-group">
                            <label for="observacion_cierre" class="col-form-label">Observación Cierre:</label>
                            <textarea class="form-control" id="observacion_cierre" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Codigo Commit:</label>
                            <input type="text" class="form-control" id="commit" required />
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">De no haber hecho uso de la herramienta GIT justifique el por que :</label>
                            <textarea class="form-control" id="justificacion_git" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning"   data-dismiss="modal" id="pendiente_socializar">Pendiente por socializar</button>
                    <button type="button" class="btn btn-primary"   data-dismiss="modal" id="guardar_cierre">Cerrar Actividad</button>
                </div>
            </div>
        </div>
    </div>

    <!--modal ver observaciones-->
    <div class="modal fade" id="exampleModalObservacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Observaciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <table id="table_observacion" class="table table-bordered table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th><i class="fa fa-comments-o"></i> Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>
