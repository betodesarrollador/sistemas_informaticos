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
      <!--<table align="center" id="tableDetalles" width="98%">
        <thead>
          <tr>
            <th colspan="10">SALDOS PENDIENTES</th>
          </tr>
          <tr>
            <th>&nbsp;</th>
            <th>CONSECUTIVO</th>
            <th>TIPO</th>
            <th>No</th>		
            <th>FACTURA</th>
            <th>FECHA</th> 
            <th>VALOR NETO</th> 
            <th>SALDO</th>        
            <th>ABONOS</th>
            <th>VALOR A PAGAR</th>        
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLES item=i}
          <tr>
            <td>       
                <input type="checkbox" name="chequear" onClick="checkRow(this);"  value="{$i.factura_proveedor_id}" />
                <input type="hidden" name="factura_proveedor_id" value="{$i.factura_proveedor_id}" class="required" /> 
                <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}"  /> 
                <input type="hidden" name="tipo" value="C"  /> 
            </td>
            <td>{$i.consecutivo_id}</td>
            <td>{$i.tipo}</td>
            <td width="15%">{if $i.orden_no neq ''}{$i.orden_no}{else}{$i.manifiesto}{/if}</td>
			<td>{$i.codfactura_proveedor}</td>
            <td>{$i.fecha_factura_proveedor}</td>
            <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido" value="{$i.valor_neto}" size="13" readonly /></td>
            <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo}" size="13" readonly /></td>            
            <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" size="13" readonly /></td>            
            <td><input type="text" name="pagar" class="numeric required" value="{$i.saldo}" size="13" /></td>            
          </tr> 
          {/foreach}	
        </tbody>
      </table>-->
	 <br />
      <table align="center" id="tableDetalles" width="98%">
        <thead>
          <tr>
            <th colspan="9">ORDENES DE COMPRA</th>
          </tr>
        
          <tr>
            <th>&nbsp;</th>
            <th>CONSECUTIVO</th>
			<th>FECHA</th>            
            <th>TIPO SERVICIO</th>
            <th>VALOR</th> 
            <th>CONCEPTO</th> 
            
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$ANTICIPOS item=i}
          
          {assign var="saldo_final" value="0"}
          
          <tr>
            <td>       
                <input type="checkbox" name="chequear_ant" onClick="checkRowAnt(this);"  value="{$i.orden_compra_id}" />
               
                <input type="hidden" name="tipo" value="A"  /> 
                
            </td>
            <td>{$i.consecutivo}<input type="hidden" name="consecutivo" value="{$i.consecutivo}"  /> </td>
            <td>{$i.fecha}</td>
             <td>{$i.tipo_servicio}</td>
            <td>{$i.valor|number_format:0:',':'.'}<input type="hidden" name="pagar" value="{$i.valor}"  /> </td>
            <td >{$i.concepto}</td>
            
           
             
          </tr> 
          {/foreach}	
        </tbody>
      </table>
      
     <center>{$ADICIONAR}</center>
  </body>
</html>