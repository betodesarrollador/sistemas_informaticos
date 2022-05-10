<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tercero_id" value="{$tercero_id}" />
  <table align="center" id="tableDetalles" width="100%">
    <thead>
      <tr>
        <th>NOMBRES Y APELLIDOS</th>
        <th>TELEFONO</th>
         <th>CORREO</th>
        <th>CARGO</th>
        
        <th id="titleSave">&nbsp;</th>	
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
        <input type="text" name="nombre_cliente_administrativa" value="{$i.nombre_cliente_administrativa}" class="required" title="{$i.nombre_cliente_administrativa}" size="15" />
        <input type="hidden" name="cliente_factura_administrativa_id" value="{$i.cliente_factura_administrativa_id}" /> </td>
        <td><input type="text" name="telefono_cliente_administrativa" value="{$i.telefono_cliente_administrativa}" class="required" size="10" />
        <input type="hidden" name="direccion_cliente_administrativa" value="{$i.direccion_cliente_administrativa}"  size="10" /></td>
        <td><input type="text" name="correo_cliente_factura_administrativa" value="{$i.correo_cliente_factura_administrativa}" class="required email" size="15" /></td>
        <td><input type="text" name="cargo_cliente_administrativa" value="{$i.cargo_cliente_administrativa}" class="required" size="10" />        
        <input type="hidden" name="ciudad" value="{$i.ciudad}" class="" size="10" />
	        <input type="hidden" name="ubicacion_id" value="{$i.ubicacion_id}" class="" /></td> 
        <td><a name="saveAdministrativas"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}
      <tr>
        <td>       
        <input type="text" name="nombre_cliente_administrativa" value="" class="required" size="15" />
        <input type="hidden" name="cliente_factura_administrativa_id" value="" /> </td>
        <td><input type="text" name="telefono_cliente_administrativa" value="" class="required" size="10" />
        <input type="hidden" name="direccion_cliente_administrativa" value="" class="" size="10" /></td>
        <td><input type="text" name="correo_cliente_factura_administrativa" value="" class="required email" size="15" /></td>
        <td><input type="text" name="cargo_cliente_administrativa" value="" class="required" size="10" />     
        <input type="hidden" name="ciudad" value="" class="" size="10" />
	        <input type="hidden" name="ubicacion_id" value="" class="" /></td>        
        <td><a name="saveAdministrativas"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="text" name="nombre_cliente_administrativa" value="" class="required" size="15" />
        <input type="hidden" name="cliente_factura_administrativa_id" value="" /> </td>
        <td><input type="text" name="telefono_cliente_administrativa" value="" class="required" size="10" />
        <input type="hidden" name="direccion_cliente_administrativa" value="" class="" size="10" /></td>
		<td><input type="text" name="correo_cliente_factura_administrativa" value="" class="required email" size="15" /></td>        
        <td><input type="text" name="cargo_cliente_administrativa" value="" class="required" size="10" />
        <input type="hidden" name="ciudad" value="" class="" size="10" />
	        <input type="hidden" name="ubicacion_id" value="" class="" /></td>        
        <td><a name="saveAdministrativas"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>