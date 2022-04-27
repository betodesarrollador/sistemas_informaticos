<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="factura_id" value="{$factura_id}" />
  <input type="hidden" id="fuente_facturacion_cod" value="{$fuente_facturacion_cod}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>

      <tr>
        <th>FUENTE</th>
        <th>No</th>
        <th>CANTIDAD</th>
        <th>ORIGEN</th>
        <th>DESTINO</th>		
        <th>DESCRIPCION</th>
        <th>VALOR UNITARIO</th>		
        <th>VALOR TOTAL</th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}

          <tr>
            <td><input type="text" name="fuente" id="fuente" value="{$i.fuente}" class="required" size="15" readonly /></td>
            <td><input type="text" name="numero" id="numero" value="{$i.numero}" class="required" size="8" readonly /></td>                
            <td>       
                <input type="text" name="cantidad" value="{$i.cantidad}" class="required numeric" size="10" readonly  />
                <input type="hidden" name="detalle_factura_id" value="{$i.detalle_factura_id}" class="required" />        
            </td>
            <td><input type="text" name="origen" id="origen" value="{$i.origen}" class="required" size="10" readonly /></td>
            <td><input type="text" name="destino" id="destino" value="{$i.destino}" class="required" size="10" readonly /></td>
            
            <td><input type="text" name="descripcion" id="descripcion" value="{$i.descripcion}" class="required" size="28" readonly /></td>
            <td><input type="text" name="valor_unitario" id="valor_unitario" value="{$i.valor_unitario}" class="required numeric" size="12" readonly /></td>
            <td><input type="text" name="valor" id="valor" value="{$i.valor}" class="required numeric" size="12" readonly /></td>
          </tr>
	  {/foreach}	
	</tbody>
  </table>
  </body>
</html>