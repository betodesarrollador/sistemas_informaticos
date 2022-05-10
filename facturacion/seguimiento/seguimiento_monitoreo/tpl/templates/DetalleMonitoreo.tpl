<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="seguimiento_id" value="{$SEGUIMIENTOID}" />
  <input type="hidden" id="FechaHoraSalida" value="{$FECHAHORASALIDA}"/>
  <table align="center" id="tableDetalleMonitoreo">
    <thead>
      <tr>
        <th>ORDEN</th>
        <th>UBICACION</th>
        <th>PASO ESTIMADO</th>
        <th>FECHA ARRIBO</th>
        <th>HORA ARRIBO</th>
        <th>NOVEDAD</th>
        <th>MIN DETENIDO</th>
        <th>RETRAZO</th>
        <th>PUESTO CONTROL</th>
        <th>OBSERVACIONES</th>
        <th>&nbsp;</th>
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLESSEGUIMIENTO item=d}
      <tr>
        <td>
		  <input type="hidden" name="detalle_seg_id" value="{$d.detalle_seg_id}" />
		  <input type="text" name="orden_det_seg" value="{$d.orden_det_seg}" size="1" readonly="readonly" />
		</td>
        <td>
		  <input type="text" name="ubicacion" id="ubicacion" value="{$d.ubicacion}" />
		  <input type="hidden" name="ubicacion_id" id="ubicacion_hidden"  value="{$d.ubicacion_id}" class="numeric required">
		</td>
        <td><input type="text" name="paso_estimado" value="{$d.paso_estimado}" readonly="readonly" size="18" class="datetime required" /></td>
        <td><input type="text" name="fecha_reporte" value="{$d.fecha_reporte}" class="date required" size="10"/></td>
        <td><input type="text" name="hora_reporte" value="{$d.hora_reporte}" size="10" class="time required" /></td>
        <td>
		  <input type="text" name="novedad" id="novedad" value="{$d.novedad}" />
		  <input type="hidden" name="novedad_id" id="novedad_hidden" value="{$d.novedad_id}" class="numeric">
		</td>
        <td><input type="text" name="tiempo_novedad" value="{$d.tiempo_novedad}" size="10" class="integer" /></td>
        <td><input type="text" name="retraso" value="{$d.retraso}" readonly="readonly" size="7" class="integer" /></td>
        <td>
		  <input type="text" name="puesto_control" value="{$d.puesto_control}" readonly="readonly" />
		  <pre class="detalle_puesto_control">{$d.detalle_puesto_control}</pre>
		</td>
        <td><textarea name="obser_deta" class="alphanum_space">{$d.obser_deta}</textarea></td>
        <td><a name="saveDetalleMonitoreo"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>	  
	  {/foreach}	
      <tr>
        <td class="dragHandle">
		  <input type="hidden" name="detalle_seg_id" />
		  <input type="text" name="orden_det_seg" size="1" readonly="readonly" />
		</td>
        <td>
		  <input type="text" name="ubicacion" id="ubicacion" />
		  <input type="hidden" name="ubicacion_id" id="ubicacion_hidden" class="numeric required" />
		</td>
        <td><input type="text" name="paso_estimado" value="{$FECHAHORASALIDA}" readonly="readonly" size="18" class="datetime required" /></td>
        <td><input type="text" name="fecha_reporte" size="10" class="date required" /></td>
        <td><input type="text" name="hora_reporte" size="10" class="time required" /></td>
        <td>
		  <input type="text" name="novedad" id="novedad" />
		  <input type="hidden" name="novedad_id" id="novedad_hidden" class="integer" />
		</td>
        <td><input type="text" name="tiempo_novedad" value="0" size="10" class="integer" /></td>
        <td><input type="text" name="retraso" value="0" readonly="readonly" size="7" /></td>
        <td>
		  <input type="text" name="puesto_control" readonly="readonly" />
		  <pre class="detalle_puesto_control"></pre>
		</td>
        <td><textarea name="obser_deta" class="alphanum_space"></textarea></td>
        <td><a name="saveDetalleMonitoreo"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table>
      <tr id="clon">
              <td class="dragHandle">
		  <input type="hidden" name="detalle_seg_id" />
		  <input type="text" name="orden_det_seg" size="1" readonly="readonly" />
		</td>
        <td>
		  <input type="text" name="ubicacion" id="ubicacion" />
		  <input type="hidden" name="ubicacion_id" id="ubicacion_hidden" class="numeric required" />
		</td>
        <td><input type="text" name="paso_estimado" value="{$FECHAHORASALIDA}" readonly="readonly" size="18" class="datetime required" /></td>
        <td><input type="text" name="fecha_reporte" size="10" class="date required" /></td>
        <td><input type="text" name="hora_reporte" size="10" class="time required" /></td>
        <td>
		  <input type="text" name="novedad" id="novedad" />
		  <input type="hidden" name="novedad_id" id="novedad_hidden" class="integer" />
		</td>
        <td><input type="text" name="tiempo_novedad" value="0" size="10" class="integer" /></td>
        <td><input type="text" name="retraso" value="0" readonly="readonly" size="7" /></td>
        <td>
		  <input type="text" name="puesto_control" readonly="readonly" />
		  <pre class="detalle_puesto_control"></pre>
		</td>
        <td><textarea name="obser_deta" class="alphanum_space"></textarea></td>
        <td><a name="saveDetalleMonitoreo"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>	 
  </table>
  </body>
</html>