<?php /* Smarty version 2.6.26, created on 2021-03-30 16:03:51
         compiled from PanelSoporte.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'PanelSoporte.tpl', 40, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
    <?php print $this->_tpl_vars['JAVASCRIPT']; ?>

    <?php print $this->_tpl_vars['CSSSYSTEM']; ?>

    <?php print $this->_tpl_vars['TITLETAB']; ?>
 
</head>
<body style = "background: #F7F4F4; padding-left: 21px; padding-right: 20px; padding-top: 10px;">   

<div class="PanelSoporte">
    <div class="titulo">
    <h3 style="text-align:center"><i class="fa fa-check-square-o" aria-hidden="true"></i> CONTROL PANEL TAREAS</h3>
    </div>
    <div class="container-fluid">
        <hr>
        <div id="detalle_actividad" class="detalle_actividad">
          <div class="row">
             <div class="col">
                   <br>
                   <div class="table-responsive">
                  	<table id="detalles_responsables" class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Responsables</th>
                            <th scope="col">Promedio Avance</th>
                            <th scope="col">N° Tareas</th>
                            <th scope="col">N° Tareas Activas</th>
                            <th scope="col">N° Tareas Cerradas</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $_from = $this->_tpl_vars['PROM']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['promedio'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promedio']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p']):
        $this->_foreach['promedio']['iteration']++;
?>
                        

                            <tr>
                                <td><b><?php print $this->_tpl_vars['p'][0]['responsable']; ?>
<b></td>
                                <td>
                                <div class="progress">
                                  <div class="progress-bar" role="progressbar" style="width: <?php print $this->_tpl_vars['p'][0]['promedio']; ?>
%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"><b><?php print ((is_array($_tmp=$this->_tpl_vars['p'][0]['promedio'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%d") : smarty_modifier_string_format($_tmp, "%d")); ?>
%</b></div>
                                </div>
                                </td>
                                <td style="text-align:center"><button class="btn btn-primary"><?php print $this->_tpl_vars['p'][0]['numero_tareas']; ?>
</button></td>
                                <td style="text-align:center"><button class="btn btn-success"><?php print $this->_tpl_vars['p'][0]['numero_tareas_activas']; ?>
</button></td>
                                <td style="text-align:center"><button class="btn btn-danger"><?php print $this->_tpl_vars['p'][0]['numero_tareas_cerradas']; ?>
</button></td>
                            </tr>

                        <?php endforeach; endif; unset($_from); ?>
                        </tbody>
                    </table>
                    </div> 
                </div>
            </div>
        </div>   

        <hr>
        <div id="detalle_actividad" class="detalle_actividad">
          <div class="row">
             <div class="col">
                   <br>
                   <div class="table-responsive">
                  	<table id="detalles" class="table table-bordered table-hover">
					<thead class="table-primary">
						<tr>
                            <th scope="col"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</th>
                            <th scope="col"><i class="fa fa-pencil" aria-hidden="true"></i></th>
                            							<th scope="col"><i class="fa fa-window-restore" aria-hidden="true"></i> Cliente</th>
                            <th scope="col"><i class="fa fa-level-up" aria-hidden="true"></i> Tarea</th>
                            <th scope="col"><i class="fa fa-level-up" aria-hidden="true"></i> Responsable</th>
							<th scope="col"><i class="fa fa-adjust" aria-hidden="true"></i> Estado</th>
                            <th scope="col"><i class="fa fa-commenting" aria-hidden="true"></i> Observacion</th>
                            <th scope="col"><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Inicio</th>
                            <th scope="col"><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Inicio Real</th>
                            <th scope="col"><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Fin</th>
                            <th scope="col"><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Fin Real</th>
                            <th scope="col"><i class="fa fa-calendar-o" aria-hidden="true"></i> Fecha Cierre Real</th>
						</tr>
					</thead>
					<tbody>
                    <?php $_from = $this->_tpl_vars['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tareas'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tareas']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['r']):
        $this->_foreach['tareas']['iteration']++;
?>

                    <tr>
                        <td>&nbsp;</td>
                                                <td><button type="button" class="btn btn-danger" id="cerrar" data-toggle="modal" data-target="#exampleModalCierre"><i class="fa fa-check-square" aria-hidden="true"></i></button></td>
                        <td><input type="hidden" id="soporte_id" value="<?php print $this->_tpl_vars['r']['soporte_id']; ?>
"><?php print $this->_tpl_vars['r']['cliente']; ?>
</td>
                        <td><?php print $this->_tpl_vars['r']['nombre']; ?>
</td>
                        <td><strong> <?php print $this->_tpl_vars['r']['responsable']; ?>
 </strong></td>
                        <?php if ($this->_tpl_vars['r']['estado'] == 'ACTIVO'): ?>
                            <td style="background-color:#71f793"><?php print $this->_tpl_vars['r']['estado']; ?>
</td>
                        <?php elseif ($this->_tpl_vars['r']['estado'] == 'INACTIVO'): ?>
                            <td style="background-color:#fffea5"><?php print $this->_tpl_vars['r']['estado']; ?>
</td>
                        <?php else: ?>
                            <td style="background-color:#f95a5a"><?php print $this->_tpl_vars['r']['estado']; ?>
</td>
                        <?php endif; ?>
                        <td><div style=" width: 250px; height: 200px;overflow: scroll;"> <?php print $this->_tpl_vars['r']['descripcion']; ?>
 </div><br><button type="button" class="btn btn-primary" id="ver_observacion" data-toggle="modal" data-target="#exampleModalObservacion"><i class="fa fa-eye" aria-hidden="true"></i></button></td>
                        <td> <?php print $this->_tpl_vars['r']['fecha_inicial']; ?>
 </td>
                        <td> <?php print $this->_tpl_vars['r']['fecha_inicial_real']; ?>
 </td>
                        <td> <?php print $this->_tpl_vars['r']['fecha_final']; ?>
 </td>
                        <td> <?php print $this->_tpl_vars['r']['fecha_final_real']; ?>
 </td>
                        <td> <?php print $this->_tpl_vars['r']['fecha_cierre_real']; ?>
 </td>
                    </tr>

                    <?php endforeach; endif; unset($_from); ?>
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
                <input type="hidden" id="soporte_id_modal" value="">
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
            <h5 class="modal-title" id="exampleModalLabel">Cerrar Soporte</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
            <div class="form-group">
                <input type="hidden" id="soporte_id_modal_cierre" value="">
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
            <button type="submit" class="btn btn-primary" data-dismiss="modal" id="guardar_cierre">Cerrar Soporte</button>
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