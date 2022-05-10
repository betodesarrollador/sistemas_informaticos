<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}
  {$TABLEGRIDCSS}
  </head>

  <body>
   
      <input type="hidden" id="abono_factura_id" value="{$abono_factura_id}" />
      <table align="center" id="tableDetalles" width="98%">
        <thead>
          <tr>
            <th>&nbsp;</th>
            <th>FACTURA No</th>
            <th>TIPO</th>
            <th>CONCEPTO</th>
            <th>FECHA</th> 
            <th>VENCIMIENTO</th> 
            <th>VALOR NETO</th> 
            <th>ABONOS</th>            
            <th>SALDO</th>        
            <th>VALOR A DESCONTAR</th> 
            <!--{foreach name=descuentos from=$DESCUENTOS item=j}     
            	<th>{$j.nombre}</th>
            {/foreach}  -->
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLES item=i}
          <tr>
            <td>       
                <input type="checkbox" name="chequear" onClick="checkRow(this);"  value="{$i.factura_proveedor_id}" />
                <input type="hidden" name="factura_proveedor_id" value="{$i.factura_proveedor_id}" class="required" />  
                <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}"  />  
            </td>
            <td name="numero_factura">{$i.consecutivo_id} <input type="hidden" name="numero_factura" value="{$i.consecutivo_id}"  />  </td>
            <td>{$i.tipo}</td>
             <td>{$i.concepto_factura_proveedor}<input type="hidden" name="concepto_hidden" value="{$i.concepto_factura_proveedor}"  /></td>	
            <td>{$i.fecha}</td>
            <td>{$i.vencimiento}</td>
            <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido" value="{$i.valor_neto}" size="13" readonly /></td>
            <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" size="13" readonly /></td>            
            <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo}" size="13" readonly /></td>            
            <td><input type="text" name="pagar" class="numeric required" value="{$i.saldo}" size="13" /></td>  
            <!--{assign var="incremen" value="1"}
            {foreach name=descuentos from=$DESCUENTOS item=j}     
            	<td>
                	<input type="text" name="descuento{$incremen}" id="descuento{$incremen}" onKeyUp="ValidarDes(this);"  class="numeric required" value="" size="13" />
                	<input type="hidden" name="descuento_id{$incremen}" id="descuento_id{$incremen}"  value="{$j.parametros_descuento_factura_id}"  />
                	{math assign="incremen" equation="x + y" x=$incremen y=1}
                </td>  
            {/foreach}  
			<input type="hidden" name="num_descu" id="num_descu"  value="{$incremen}"  />       -->               
          </tr> 
          {/foreach}	
        </tbody>
      </table>
     <center>{$ADICIONAR}</center>
  </body>
</html>