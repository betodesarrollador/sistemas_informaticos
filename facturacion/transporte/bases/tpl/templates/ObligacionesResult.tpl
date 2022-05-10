<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tercero_id" value="{$tercero_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th width="25%">CODIGO</th>
        <th width="50%">NOMBRE</th>
        <th width="25%">ESTADO </th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$OBLIGACIONES item=i}
      <tr>
        <td>{$i.codigo}</td>
        <td>{$i.nombre}</td>           
        <td >
        	<input type="checkbox" name="procesar" id="procesar" onClick="guardarObligacion(this);"  {if $i.estado_obli eq 'A'} checked="checked" {/if} />
        	<input type="hidden" name="tercero_obligacion_id" id="tercero_obligacion_id" value="{$i.tercero_obligacion_id}" />
        	<input type="hidden" name="codigo_obligacion_id" id="codigo_obligacion_id" value="{$i.codigo_obligacion_id}" />            
            
        </td>
      </tr> 
	  {/foreach}

	</tbody>
	</table>          
  </body>
</html>