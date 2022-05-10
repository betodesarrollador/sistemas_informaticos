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
        <th>DIRECCION</th>
         <th>CORREO</th>
        <th>CARGO</th>
        <th>CIUDAD</th>	
        <th id="titleSave">&nbsp;</th>	
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
        <input type="text" name="nombre_cliente_operativa" value="{$i.nombre_cliente_operativa}" class="required" title="{$i.nombre_cliente_operativa}" size="15" />
        <input type="hidden" name="cliente_factura_operativa_id" value="{$i.cliente_factura_operativa_id}" /> </td>
        <td><input type="text" name="telefono_cliente_operativa" value="{$i.telefono_cliente_operativa}" class="required" size="10" /></td>
        <td><input type="text" name="direccion_cliente_operativa" value="{$i.direccion_cliente_operativa}"  size="10" /></td>
        <td><input type="text" name="correo_cliente_factura_operativa" value="{$i.correo_cliente_factura_operativa}" class="required email" size="15" /></td>
        <td><input type="text" name="cargo_cliente_operativa" value="{$i.cargo_cliente_operativa}" class="required" size="10" /></td>        
        <td><input type="text" name="ciudad" value="{$i.ciudad}" class="required" size="10" />
	        <input type="hidden" name="ubicacion_id" value="{$i.ubicacion_id}" class="required" /></td> 
        <td><a name="saveOperativas"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}
      <tr>
        <td>       
        <input type="text" name="nombre_cliente_operativa" value="" class="required" size="15" />
        <input type="hidden" name="cliente_factura_operativa_id" value="" /> </td>
        <td><input type="text" name="telefono_cliente_operativa" value="" class="required" size="10" /></td>
        <td><input type="text" name="direccion_cliente_operativa" value="" class="" size="10" /></td>
        <td><input type="text" name="correo_cliente_factura_operativa" value="" class="required email" size="15" /></td>
        <td><input type="text" name="cargo_cliente_operativa" value="" class="required" size="10" /></td>        
        <td><input type="text" name="ciudad" value="" class="required" size="10" />
	        <input type="hidden" name="ubicacion_id" value="" class="required" /></td>        
        <td><a name="saveOperativas"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="text" name="nombre_cliente_operativa" value="" class="required" size="15" />
        <input type="hidden" name="cliente_factura_operativa_id" value="" /> </td>
        <td><input type="text" name="telefono_cliente_operativa" value="" class="required" size="10" /></td>
        <td><input type="text" name="direccion_cliente_operativa" value="" class="" size="10" /></td>
		<td><input type="text" name="correo_cliente_factura_operativa" value="" class="required email" size="15" /></td>        
        <td><input type="text" name="cargo_cliente_operativa" value="" class="required" size="10" /></td>
        <td><input type="text" name="ciudad" value="" class="required" size="10" />
	        <input type="hidden" name="ubicacion_id" value="" class="required" /></td>        
        <td><a name="saveOperativas"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>