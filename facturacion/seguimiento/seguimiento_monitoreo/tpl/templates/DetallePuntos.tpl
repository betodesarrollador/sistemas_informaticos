<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="trafico_id" value="{$TRAFICOID}" />
  <input type="hidden" id="ruta_id" value="{$RUTAID}"/>
  <input type="hidden" id="orden" value="{$ULTPUNTO.orden}"/>
  
  <table align="center" >
    <thead>
      <tr>
        <th width="3%">ORDEN</th>
        <th width="15%">PUNTO O CIUDAD </th>        
        <th width="15%">TIPO PUNTO </th>
        <th width="2%"><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLESPUNTOS item=d}
      <tr>
        <td>
        	<input type="hidden" name="detalle_ruta_id" value="{$d.detalle_ruta_id}" />
        	<input type="hidden" name="orden_det_ruta" value="{math equation="x + y" x=$ULTPUNTO.orden y=$d.orden}" />
            <input type="text" name="orden" value="{$d.orden}" size="1" readonly="readonly" />
        </td>
        <td><input type="text" name="punto_referencia" id="punto_referencia" title="{$d.punto_referencia}" value="{$d.punto_referencia}" size="28" readonly /><input name="punto_referencia_id" id="punto_referencia_id" type="hidden" value="{$d.punto_referencia_id}" class=""></td>        
        <td><input type="text" name="ubicacion" id="ubicacion" title="{$d.ubicacion}" value="{$d.ubicacion}" size="25"  readonly   /><input name="ubicacion_id" id="ubicacion_id" type="hidden" value="{$d.ubicacion_id}" class="required"></td>
        <td>
        	<input type="checkbox" name="procesar" />
        </td>
      </tr>	  
	  {/foreach}	
	</tbody>
  </table>
  </body>
</html>