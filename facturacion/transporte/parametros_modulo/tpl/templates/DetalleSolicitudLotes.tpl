<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <center>
  <input type="hidden" id="campo_archivo_solicitud_id" value="{$CAMPOID}" />
  <input type="hidden" id="autoSugerente" value="{$AUTOSUGERENTE}" />
  <table id="tableDetalle">
    <thead>
      <tr>
	  
        <th>VALOR SISTEMA</th>
        <th>VALOR ARCHIVO</th>
        
        <th>&nbsp;</th>
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	{foreach name=detalles from=$DETALLE item=d}
      <tr>
        <td>
        	<input type="hidden" name="relacion_archivo_det_solicitud_id" value="{$d.relacion_archivo_det_solicitud_id}" />
            <input type="text" name="valor_foranea" value="{$d.valor_foranea}" />
            <input type="hidden" name="valor_foranea_id" value="{$d.valor_foranea_id}" />
        </td>
        <td>
        	<input type="text" name="valor_archivo" value="{$d.valor_archivo}" />
        </td>
        
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
	{/foreach}
      <tr>
        <td>
        	<input type="hidden" name="relacion_archivo_det_solicitud_id"  />
            <input type="text" name="valor_foranea" />
            <input type="hidden" name="valor_foranea_id" />
        </td>
        <td>
        	<input type="text" name="valor_archivo" />
        </td>
        
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
	</tbody>
  </table>
  
  <table>
      <tr id="clon">
        <td>
        	<input type="hidden" name="relacion_archivo_det_solicitud_id"  />
            <input type="text" name="valor_foranea" />
            <input type="hidden" name="valor_foranea_id" />
        </td>
        <td>
        	<input type="text" name="valor_archivo" />
        </td>
        
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </center>
  </body>
</html>