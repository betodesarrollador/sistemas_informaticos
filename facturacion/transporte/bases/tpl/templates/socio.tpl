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
        <th>NOMBRES Y APELLIDOS</th>
        <th>IDENTIFICACION</th>
        <th>DIRECCION</th>
        <th>CIUDAD</th>	
        <th id="titleSave">&nbsp;</th>	
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
        <input type="text" name="nombre_cliente_socio" value="{$i.nombre_cliente_socio}" class="required" title="{$i.nombre_cliente_socio}" size="20" />
        <input type="hidden" name="cliente_factura_socio_id" value="{$i.cliente_factura_socio_id}" /> </td>
        <td><input type="text" name="id_cliente_socio" value="{$i.id_cliente_socio}" class="required" title="{$i.id_cliente_socio}" size="10" /></td>
        <td><input type="text" name="direccion_cliente_socio" value="{$i.direccion_cliente_socio}" class="required" size="10" /></td>
        <td><input type="text" name="ciudad" value="{$i.ciudad}" class="required" size="10" />
	        <input type="hidden" name="ubicacion_id" value="{$i.ubicacion_id}" class="required" /></td> 
        <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}
      <tr>
        <td>       
        <input type="text" name="nombre_cliente_socio" value="" class="required" size="20" />
        <input type="hidden" name="cliente_factura_socio_id" value="" /> </td>
        <td><input type="text" name="id_cliente_socio" value="" class="required" size="10" /></td>
        <td><input type="text" name="direccion_cliente_socio" value="" class="required" size="10" /></td>
        <td><input type="text" name="ciudad" value="" class="required" size="10" />
	        <input type="hidden" name="ubicacion_id" value="" class="required" /></td>        
        <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="text" name="nombre_cliente_socio" value="" class="required" size="20" />
        <input type="hidden" name="cliente_factura_socio_id" value="" /> </td>
        <td><input type="text" name="id_cliente_socio" value="" class="required" size="10" /></td>
        <td><input type="text" name="direccion_cliente_socio" value="" class="required" size="10" /></td>
        <td><input type="text" name="ciudad" value="" class="required" size="10" />
	        <input type="hidden" name="ubicacion_id" value="" class="required" /></td>        
        <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>