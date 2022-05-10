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
        <th>CODIGO</th>
        <th>IDENTIFICACION</th>
        <th>TERCERO</th>
        <th>DESCRIPCION</th>
        <th>BASE</th>		
        <th>DEBITO</th>
        <th>CREDITO</th>		
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}

          <tr>
            <td><input type="text" name="codigo_puc" id="codigo_puc" value="{$i.codigo_puc}" class="required" size="15" readonly /></td>
            <td><input type="text" name="numero_identificacion" id="numero_identificacion" value="{$i.numero_identificacion}" class="required" size="8" readonly /></td>                
            <td>       
                <input type="text" name="tercero" id="tercero" value="{$i.tercero}" class="required numeric" size="10" readonly  />
                <input type="hidden" name="tercero_id" id="tercero_id" value="{$i.tercero_id}" class="required" />        
            </td>
            <td><input type="text" name="descripcion" id="descripcion" value="{$i.descripcion}" class="required" size="10" readonly /></td>
            <td><input type="text" name="base" id="base" value="{$i.base}" class="required" size="10" readonly /></td>
            
            <td><input type="text" name="debito" id="debito" value="{$i.debito}" class="required" size="28" readonly /></td>
            <td><input type="text" name="credito" id="credito" value="{$i.credito}" class="required numeric" size="12" readonly /></td>
          </tr>
	  {/foreach}	
	</tbody>
  </table>
  </body>
</html>