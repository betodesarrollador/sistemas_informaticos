<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}
  {$TABLEGRIDCSS}
  </head>

  <body>
   
      <input type="hidden" id="abono_factura_proveedor_id" value="{$abono_factura_proveedor_id}" />
      <table align="center" id="tableDetalles" width="98%">
        <thead>
          <tr>
            <th>&nbsp;</th>
            <th>DOCUMENTO CONTABLE</th>
            <th>FECHA DOC.</th>            
            <th>NUMERO CHEQUE</th>
            <th>VALOR NETO</th>		
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLES item=i}
          <tr>
            <td>       
                <input type="checkbox" name="chequear" onClick="checkRow(this);"  value="{$i.abono_factura_id}" />
                <input type="hidden" name="num_cheque" value="{$i.num_cheque}" class="required" /> 
            </td>
            <td>{$i.consecutivo}</td>
            <td>{$i.fecha}</td>
			<td>{$i.num_cheque}</td>
            <td>{$i.valor_neto_factura|number_format:2:",":"."}</td>
          </tr> 
          {/foreach}	
        </tbody>
      </table>
     <center>{$ADICIONAR}</center>
  </body>
</html>