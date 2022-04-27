<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="novedad_id" value="{$NOVEDADID}" />
  <table align="center" id="tableDetalleCorreo" width="98%">
    <thead>
      <tr>
        <th>USUARIO</th>
        <th>CORREO</th>
        <th>&nbsp;</th>
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLESCORREOS item=d}
      <tr>
        <td>
        	<input name="reporte_novedad_id" type="hidden"  value="{$d.reporte_novedad_id}" />
        	<input type="text" name="usuario" id="usuario" size="35" value="{$d.usuario}" />
        	<input name="usuario_id" type="hidden" value="{$d.usuario_id}" class="required" />
          	
        </td>
        <td><input type="text" name="correo" value="{$d.correo}" size="35" class="required" /></td>
        <td><a name="saveDetalleCorreo"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>	  
	  {/foreach}	
      <tr>
        <td>
        	<input name="reporte_novedad_id" type="hidden" value="" />
            <input type="text" name="usuario" id="usuario"  size="35" value="" />
        	<input name="usuario_id" type="hidden" value="" class="required" />
        </td>
        <td><input type="text" name="correo" value="" size="35" class="required" /></td>
        <td><a name="saveDetalleCorreo"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>
            <input name="reporte_novedad_id" type="hidden" value="" />
        	<input type="text" name="usuario" id="usuario" size="35" value="" />
        	<input name="usuario_id" type="hidden" value="" class="required" />
        </td>
        <td><input type="text" name="correo" value="" size="35" class="required" /></td>
        <td><a name="saveDetalleCorreo"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>	 
  </table>
  </body>
</html>