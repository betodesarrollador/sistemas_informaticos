<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
    {$JAVASCRIPT}
    {$CSSSYSTEM}
    {$TITLETAB} 
</head>
<body style = "background: #F7F4F4; padding-left: 21px; padding-right: 20px; padding-top: 10px;">   

<div class="panel">
    <div class="titulo">
    <h3 style="text-align:center"><i class="fa fa-check-square-o" aria-hidden="true"></i> CONTROL PANEL</h3>
    </div>
    <div class="container-fluid">
    <hr>

        <div class="row">
            <div class="col">
                    <div class="table-responsive-sm">
                  	<table id="panel" class="table table-striped table-bordered table-hover">
					<thead class="table-primary">
						<tr>
							<th><i class="fa fa-user" aria-hidden="true"></i> Cliente</th>
							<th><i class="fa fa-book" aria-hidden="true"></i> Proyecto</th>
							<th><i class="fa fa-level-up" aria-hidden="true"></i> Fase Actual</th>
                            <th><i class="fa fa-window-restore" aria-hidden="true"></i> Actividades</th>
                            <th><i class="fa fa-percent" aria-hidden="true"></i> Porcentaje Avance</th>
                            <th><i class="fa fa-user" aria-hidden="true"></i> Usuario Asignado</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
                </div>
            </div>
        </div>
        <hr>
        <div id="detalle_actividad" class="detalle_actividad">
          <div class="row">
             <div class="col">
             <br>
                   <div class="cerrar">
                        <button class="btn btn-primary" id="cerrar">Cerrar</button>
                   </div>
                   <h3 style="text-align:center"><i class="fa fa-table" aria-hidden="true"></i> DETALLES</h3>
                   <div class="row">
                        <div class="col">

                            <label>Cliente:</label>
                            {$CLIENTE}

                        </div>

                        <div class="col">

                            <label>Proyecto:</label>
                            {$PROYECTO}

                        </div>
                   </div>
                   <br>
                   <div class="table-responsive">
                  	<table id="detalles" class="table table-bordered table-hover">
					<thead class="table-primary">
						<tr>
							<th><i class="fa fa-window-restore" aria-hidden="true"></i> Actividad</th>
                            <th><i class="fa fa-level-up" aria-hidden="true"></i> Fase</th>
							<th><i class="fa fa-adjust" aria-hidden="true"></i> Estado</th>
							<th><i class="fa fa-user" aria-hidden="true"></i> Responsable</th>
                            <th><i class="fa fa-commenting" aria-hidden="true"></i> Observacion</th>
                            <th><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Inicio</th>
                            <th><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Inicio Real</th>
                            <th><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Fin</th>
                            <th><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Fin Real</th>
                            <th colspan="2"><i class="fa fa-pencil" aria-hidden="true"></i> Opciones</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				    </table>
                    </div>

                </div>
            </div>
        </div>
    
            
        


    </div>
</div>
    <!--modal agregar observacion-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva Observación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
            <div class="form-group">
                <input type="hidden" id="actividad_id_modal" value="">
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
    <div class="modal fade" id="exampleModalCierre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cerrar Actividad</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
            <div class="form-group">
                <input type="hidden" id="actividad_id_modal_cierre" value="">
                <label for="fecha_cierre" class="col-form-label">Fecha Cierre:</label>
                <input type="date" class="form-control" id="fecha_cierre" required></textarea>
            </div>
            <div class="form-group">
                <label for="observacion_cierre" class="col-form-label">Observación Cierre:</label>
                <textarea class="form-control" id="observacion_cierre" required></textarea>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" data-dismiss="modal" id="guardar_cierre">Cerrar Actividad</button>
        </div>
        </div>
    </div>
    </div>

    <!--modal ver observaciones-->
    <div class="modal fade" id="exampleModalObservacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Observaciones</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
            <div class="form-group">
               <table id="table_observacion" class="table table-bordered table-striped table-hover">
					<thead class="table-primary">
						<tr>
							<th><i class="fa fa-comments-o" aria-hidden="true"></i> Observaciones</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
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
</html>