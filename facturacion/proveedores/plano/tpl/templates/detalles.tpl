<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">Facturas Pendientes</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td></tr>	 	   
  </table>	

  <table align="center" id="encabezado"  width="90%">
      {if $tipo eq 'FP'}
          {assign var="prov" value=""}
          {assign var="acumula_total" value="0"}
          {assign var="acumula_saldos" value="0"}

          {assign var="acumula_totales" value="0"}
          {assign var="acumula_saldos_total" value="0"}
          
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $prov eq '' or $prov neq $i.proveedor_nombre}
              
              {if $prov neq '' and $prov neq $i.proveedor_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="6" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" colspan="2" align="right">&nbsp;{$acumula_saldos|number_format:2:',':'.'}</td>	
                   							
                  </tr>  
                  {assign var="acumula_total" value="0"}
                  {assign var="acumula_saldos" value="0"}
                  <tr>
                    <th colspan="7" align="left">&nbsp;</th>
                  </tr>	
                  <tr>
                    <th colspan="7" align="left">&nbsp;</th>
                  </tr>	
                  
                  
			  {/if}	
              {assign var="prov" value=$i.proveedor_nombre}

          <tr>
          	<th colspan="7" align="left">{$i.proveedor_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="7" align="left">&nbsp;</th>
          </tr>	

          <tr>
            <th class="borderLeft borderTop borderRight">No DOC</th>
            <th class="borderLeft borderTop borderRight">FECHA DOC</th>
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">FECHA FACT</th>
            <th class="borderTop borderRight">VENCE</th>
            <th class="borderTop borderRight">DIAS</th>		
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">EXCLUIR</th>
          </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">
            {$i.tipo} : {$i.codfactura_proveedor}{$i.manifiesto}{$i.orden_no}{$i.reexpedido}</td> 
            <td class="borderLeft borderTop borderRight">{$i.fecha_documento}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.fecha_factura_proveedor}</td>  
            <td class="borderTop borderRight">{$i.vence_factura_proveedor}</td>  
            <td class="borderTop borderRight">{$i.dias}</td>  
            <td class="borderTop borderRight" align="right">{$i.valor_neto|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight" align="right">{$i.saldo|number_format:2:',':'.'}</td> 
            
            
              <td class="borderTop borderRight" align="right"><input type="checkbox" onClick="deleteDetalleManifiesto(this,{$d.detalle_despacho_id})" /></td>
          </tr> 
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
          {math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}

          {math assign="acumula_totales" equation="x + y" x=$acumula_totales y=$i.valor_neto}
          {math assign="acumula_saldos_total" equation="x + y" x=$acumula_saldos_total y=$i.saldo}
          
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>	
           							
          </tr>  

          <tr >
           <td  colspan="7" align="right">&nbsp;</td>
          </tr>  
          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="6" align="right">TOTAL TODOS LOS TERCEROS</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_totales|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos_total|number_format:2:',':'.'}</td>								
          </tr>  

           {/if}   
       
  </table>
  </body>
</html>