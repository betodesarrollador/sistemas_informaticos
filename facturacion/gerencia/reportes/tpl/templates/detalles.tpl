<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">{if $tipo eq 'VF'}Valor Facturado{elseif  $tipo eq 'EC'}Estado Cartera{elseif  $tipo eq 'RF'}Relaci&oacute;n de Facturas{elseif  $tipo eq 'PE'}Cartera por Edades{/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td></tr>	 	   
  </table>	

  <table align="center" id="encabezado"  width="90%">
      {if $tipo eq 'VF'}
          {assign var="clien" value=""}
          {assign var="acumula_total" value="0"}
          {assign var="acumula_saldos" value="0"}
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $clien eq '' or $clien neq $i.cliente_nombre}
              
              {if $clien neq '' and $clien neq $i.cliente_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:2:',':'.'}</td>								
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
              {assign var="clien" value=$i.cliente_nombre}

          <tr>
          	<th colspan="7" align="left">{$i.cliente_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="7" align="left">&nbsp;</th>
          </tr>	

          <tr>
            <th class="borderLeft borderTop borderRight">No FACT</th>
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">FECHA FACT</th>
            <th class="borderTop borderRight">VENCE</th>
            <th class="borderTop borderRight">DIAS</th>		
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">SALDO</th>
          </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.consecutivo_factura} </td> 
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.fecha}</td>  
            <td class="borderTop borderRight">{$i.vencimiento}</td>  
            <td class="borderTop borderRight">{$i.dias}</td>  
            <td class="borderTop borderRight" align="right">{$i.valor_neto|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight" align="right">{$i.saldo|number_format:2:',':'.'}</td>  
          </tr> 
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
          {math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:2:',':'.'}</td>								
          </tr>  

      {elseif $tipo eq 'RF'}
          {assign var="clien" value=""}
          {assign var="acumula_total" value="0"}
          {assign var="acumula_saldos" value="0"}
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $clien eq '' or $clien neq $i.cliente_nombre}
              
              {if $clien neq '' and $clien neq $i.cliente_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:2:',':'.'}</td>								
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
              {assign var="clien" value=$i.cliente_nombre}

          <tr>
          	<th colspan="7" align="left">{$i.cliente_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="7" align="left">&nbsp;</th>
          </tr>	

          <tr>
            <th class="borderLeft borderTop borderRight">No FACT</th>
            <th class="borderTop borderRight">ESTADO</th>
             <th class="borderTop borderRight">CENTRO</th>		
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">FECHA FACT</th>
            <th class="borderTop borderRight">VENCE</th>
            <th class="borderTop borderRight">RELACION PAGOS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">SALDO</th>
          </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.consecutivo_factura} </td> 
            <td class="borderTop borderRight">{$i.estado}</td> 
            <td class="borderTop borderRight">{$i.centro}</td>  
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.fecha}</td>  
            <td class="borderTop borderRight">{$i.vencimiento}</td>
            <td class="borderTop borderRight">{$i.relacion_pago}</td>  
            <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.valor_neto|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.saldo|number_format:2:',':'.'}{/if}</td>  
          </tr> 
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
          {math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:2:',':'.'}</td>								
          </tr>  
      
      {elseif  $tipo eq 'EC'}

          {assign var="clien" value=""}
          {assign var="acumula_total" value="0"}
          {assign var="acumula_saldos" value="0"}
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $clien eq '' or $clien neq $i.cliente_nombre}
              
              {if $clien neq '' and $clien neq $i.cliente_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:2:',':'.'}</td>								
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
              {assign var="clien" value=$i.cliente_nombre}

          <tr>
          	<th colspan="7" align="left">{$i.cliente_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="7" align="left">&nbsp;</th>
          </tr>	

          <tr>
            <th class="borderLeft borderTop borderRight">No FACT</th>   
            <th class="borderTop borderRight">TIPO</th>
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">FECHA FACT</th>
            <th class="borderTop borderRight">FECHA VENCIMIENTO</th> 
            <th class="borderTop borderRight">DIAS</th>		
            <th class="borderTop borderRight">VALOR NETO</th>
            <th class="borderTop borderRight">SALDO</th>
          </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.consecutivo_factura} </td> 
            <td class="borderTop borderRight">{$i.tipo}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.fecha}</td>  
            <td class="borderTop borderRight">{$i.vencimiento}</td>  
            <td class="borderTop borderRight">{$i.dias}</td>  
            <td class="borderTop borderRight" align="right">{$i.valor_neto|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight" align="right">{$i.saldo|number_format:2:',':'.'}</td>  
          </tr> 
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
          {math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:2:',':'.'}</td>								
          </tr>  
      
      {elseif  $tipo eq 'PE'}

          {assign var="clien" value=""}
          {assign var="acumula_total" value="0"}

          {assign var="acumula_0" value="0"}
          {assign var="acumula_30" value="0"}
          {assign var="acumula_60" value="0"}
          {assign var="acumula_90" value="0"}
          {assign var="acumula_90mas" value="0"}
          
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $clien eq '' or $clien neq $i.cliente_nombre}
              
              {if $clien neq '' and $clien neq $i.cliente_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_0|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_30|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_60|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90mas|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                  </tr>  
                  {assign var="acumula_0" value="0"}
                  {assign var="acumula_30" value="0"}
                  {assign var="acumula_60" value="0"}
                  {assign var="acumula_90" value="0"}
                  {assign var="acumula_90mas" value="0"}
                  <tr>
                    <th colspan="11" align="left">&nbsp;</th>
                  </tr>	
                  <tr>
                    <th colspan="11" align="left">&nbsp;</th>
                  </tr>	
                  
                  
			  {/if}	
              {assign var="clien" value=$i.cliente_nombre}

          <tr>
          	<th colspan="11" align="left">{$i.cliente_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>	

          <tr>
            <th class="borderLeft borderTop borderRight" rowspan="2">No FACT</th>
            <th class="borderTop borderRight" rowspan="2">OFICINA</th>
            <th class="borderTop borderRight" rowspan="2">VENCE</th>
            <th class="borderTop borderRight" colspan="2">MENOR A 1</th>            
            <th class="borderTop borderRight" colspan="2">1-30</th>		
            <th class="borderTop borderRight" colspan="2">31-60</th>
            <th class="borderTop borderRight" colspan="2">61-90</th>
            <th class="borderTop borderRight" colspan="2">MAYOR A 90</th>
          </tr>
          <tr>
            <th class="borderLeft borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
          </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.consecutivo_factura}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.vencimiento}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias lt 0 or  $i.dias eq 0}{$i.saldo|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias lt 0 or  $i.dias eq 0}{$i.dias}{/if}</td>  
            
            <td class="borderTop borderRight" align="right">{if $i.dias gt 0 and $i.dias lt 31 }{$i.saldo|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 0 and $i.dias lt 31 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 30 and $i.dias lt 61 }{$i.saldo|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 30 and $i.dias lt 61 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 60 and $i.dias lt 91 }{$i.saldo|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 60 and $i.dias lt 91 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 90}{$i.saldo|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 90}{$i.dias}{/if}</td>  

          </tr> 
          {if  $i.dias lt 0 or  $i.dias eq 0 }
	          {math assign="acumula_0" equation="x + y" x=$acumula_0 y=$i.valor_neto}
          {/if}
          
          {if $i.dias gt 0 and $i.dias lt 31 }
	          {math assign="acumula_30" equation="x + y" x=$acumula_30 y=$i.valor_neto}
          {/if}
          {if $i.dias gt 30 and $i.dias lt 61 }   
          	{math assign="acumula_60" equation="x + y" x=$acumula_60 y=$i.saldo}
          {/if}  
          {if $i.dias gt 60 and $i.dias lt 91 }
	          {math assign="acumula_90" equation="x + y" x=$acumula_90 y=$i.saldo}          
          {/if}
          {if $i.dias gt 90}    
	          {math assign="acumula_90mas" equation="x + y" x=$acumula_90mas y=$i.saldo}          
          {/if}    
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.saldo}

          
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_0|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_30|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_60|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90mas|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
          </tr>  
          <tr >
           <td  colspan="13" align="right">&nbsp;</td>
          </tr>  

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTAL PENDIENTE</td>
           <td class="borderTop borderRight borderBottom" align="right" colspan="10">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
          </tr>  

      
      {/if}   
       
  </table>
  </body>
</html>