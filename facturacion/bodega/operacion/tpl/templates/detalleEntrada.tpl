<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="entrada_id" value="{$entrada_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th>PRODUCTO</th>
        <th>CODIGO BARRAS</th>	
        <th>SERIAL EAN</th>		
        <th>CANTIDAD</th>
        <th>UBICACION BODEGA</th>  
        <th>POSICION</th> 
        <th>ESTADO PRODUCTO</th>                                 
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalleEntrada from=$DETALLES item=i}
      <tr>
        <td> 
            <input type="hidden" name="recepcion_detalle_id" value="{$i.recepcion_detalle_id}"  />
            <input type="hidden" name="entrada_detalle_id" value="{$i.entrada_detalle_id}"  />       
            <input type="text" name="producto" id="producto" value="{$i.producto}" class="required"  size="30" readonly />
            <input type="hidden" name="producto_id" value="{$i.producto_id}"  />
        </td>
        <td><input type="text" name="codigo_barra" id="codigo_barra" value="{$i.codigo_barra}" class="required" readonly/></td>
        <td><input type="text" name="serial" id="serial" value="{$i.serial}" class="required" readonly  /></td>		        
        <td><input type="text" name="cantidad" id="cantidad" value="{$i.cantidad}" class="required numeric" readonly /></td>        
         <td>      
            <!--<input type="text" name="ubicacion_bodega" id="ubicacion_bodega" value="{$i.ubicacion_bodega}" class="required" placeholder="Código ó Nombre Ubicacion Bodega"  size="30" />
            <input type="hidden" name="ubicacion_bodega_id" value="{$i.ubicacion_bodega_id}" /> -->
            {if $i.ubicacion_bodega_id > 0 }
              <select name="ubicacion_bodega" id="ubicacion_bodega" disabled>
                <option value="{$i.ubicacion_bodega_id}">{$i.ubicacion_bodega}</option>
              </select>
            {else}
              <select name="ubicacion_bodega" id="ubicacion_bodega">
                <option value="NULL">Seleccione</option>
              </select>
            {/if}
        </td>
        <td>      
            <select name="posicion" id="posicion">
              <option value="{$i.posicion_id}">{$i.posicion}</option>
            </select>
        </td>
        <td>
           <select name="estado_producto" id="estado_producto" class="required">
             <option value="{$i.estado_producto_id}">{$i.estado_producto}</option>
           </select>
        </td>
        {if $i.ubicacion_bodega_id > 0 }
        <td>{if $i.estado eq 'P'}<input type="checkbox" name="procesar" />{/if}</td>
        {else}
        <td>{if $i.estado eq 'IN' || $i.estado eq 'P' }<input type="checkbox" name="procesar" />{/if}</td>
        {/if}
      </tr>
      {/foreach}
     
      </tbody>  
  </table>

  </body>
</html>