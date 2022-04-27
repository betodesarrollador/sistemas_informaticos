<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <center>
  <input type="hidden" id="ordencompra_id" value="{$ORDENID}" />
  <table id="tableDetalle">
    <thead>
      <tr>
	  
        <th>REMESA</th>
        <th>ORIGEN</th>
        <th>DESTINO</th>
        <th>OBSERVACIONES</th>
        <th>COSTO</th>
        
        <th>&nbsp;</th>
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	{foreach name=detalles from=$DETALLE item=d}
      <tr>
        <td>
        	<input type="hidden" name="detalle_ordenconexo_id" value="{$d.detalle_ordenconexo_id}" />
            <input type="text" name="remesa" size="4" value="{$d.remesa}" />
            <input type="hidden" name="remesa_id" class="required" value="{$d.remesa_id}" />
        </td>
        <td>
        	<input type="text" name="origen" value="{$d.origen}" />
            <input type="hidden" name="origen_id" value="{$d.origen_id}">
        </td>
        <td>
        	<input type="text" name="destino" value="{$d.destino}" />
            <input type="hidden" name="destino_id" value="{$d.destino_id}">
        </td>
        <td><textarea name="observaciones" style="width:200px;height:20px;">{$d.observaciones}</textarea></td>
        <td><input type="text" name="costo_ordenconexo" value="{$d.costo_ordenconexo}" class="numeric" /></td>
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
	{/foreach}
      <tr>
        <td>
        	<input type="hidden" name="detalle_ordenconexo_id" />
            <input type="text" name="remesa" size="4" />
            <input type="hidden" name="remesa_id" class="required" />
        </td>
        <td>
        	<input type="text" name="origen" />
            <input type="hidden" name="origen_id">
        </td>
        <td>
        	<input type="text" name="destino" />
            <input type="hidden" name="destino_id">
        </td>
        <td><textarea name="observaciones" style="width:200px;height:20px;"></textarea></td>
        <td><input type="text" name="costo_ordenconexo" class="numeric" /></td>
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
	</tbody>
  </table>
  <table>
      <tr id="clon">
        <td>
        	<input type="hidden" name="detalle_ordenconexo_id" />
            <input type="text" name="remesa" size="4" />
            <input type="hidden" name="remesa_id" class="required" />
        </td>
        <td>
        	<input type="text" name="origen" />
            <input type="hidden" name="origen_id">
        </td>
        <td>
        	<input type="text" name="destino" />
            <input type="hidden" name="destino_id">
        </td>
        <td><textarea name="observaciones" style="width:200px;height:20px;"></textarea></td>
        <td><input type="text" name="costo_ordenconexo" /></td>
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </center>
  </body>
</html>