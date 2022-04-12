<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body> 
    <input  type="hidden" id="estado" value="{$estado_id}" />
    
    <table width="90%" align="center" id="encabezado" border="0">
        <tr>
        	<td width="30%">&nbsp;</td><td width="30%" align="right">&nbsp;</td>
        </tr> 
        <tr>
        	<td colspan="3">&nbsp;</td>
        </tr>
        <tr>
        	<td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td>
        </tr>       
    </table>  
    <table align="center" id="encabezado"  width="90%">
        <tr>
            <th class="borderTop borderRight">USUARO REGISTRA</th>
            <th class="borderTop borderRight">OFICINA</th>            
            <th class="borderTop borderRight">IDENTIFICACI&Oacute;N</th>
            <th class="borderTop borderRight">GUIA Nº</th>
            <th class="borderTop borderRight">FECHA</th>
            <th class="borderTop borderRight">TIPO SERVICIO</th>
            <th class="borderTop borderRight">TIPO ENVIO</th>
            <th class="borderTop borderRight">ORIGEN</th>
            <th class="borderTop borderRight">DESTINO</th>
            <th class="borderTop borderRight">PESO</th>
            <th class="borderTop borderRight">CANTIDAD</th>
            <th class="borderTop borderRight">VALOR FLETE</th>            
            <th class="borderTop borderRight">VALOR SEGURO</th>
            <th class="borderTop borderRight">VALOR DESCUENTO</th>
            <th class="borderTop borderRight">VALOR OTROS</th>
            <th class="borderTop borderRight">VALOR TOTAL</th>
        </tr>
         {assign var="total_flete" value=0} 
         {assign var="total_seguro" value=0} 
         {assign var="total_otros" value=0}          
         {assign var="total_total" value=0}          
         
        {foreach name=detalles from=$DETALLES item=i}
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
        	<td class="borderTop borderRight">{$i.usuario}</td>
        	<td class="borderTop borderRight">{$i.oficina}</td>            
            <td class="borderTop borderRight">{$i.doc_usuario}</td>
            <td class="borderTop borderRight">{$i.prefijo}-{$i.numero_guia}</td> 
            <td class="borderTop borderRight">{$i.fecha_guia}</td>
            <td class="borderTop borderRight">{$i.tipo_servicio}</td>
            <td class="borderTop borderRight">{$i.tipo_envio}</td>
            <td class="borderTop borderRight">{$i.origen}</td> 
            <td class="borderTop borderRight">{$i.destino}</td>
            <td class="borderTop borderRight">{$i.peso}</td>
            <td class="borderTop borderRight">{$i.cantidad}</td> 
            <td class="borderTop borderRight" align="right">{if $i.valor_flete eq 'ANULADO'}$0{else}${$i.valor_flete|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.valor_flete eq 'ANULADO'}$0{else}${$i.valor_seguro|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.valor_flete eq 'ANULADO'}$0{else}${$i.valor_descuento|number_format:0:',':'.'}{/if}</td> 
            <td class="borderTop borderRight" align="right">{if $i.valor_flete eq 'ANULADO'}$0{else}${$i.valor_otros|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.valor_flete eq 'ANULADO'}$0{else}${$i.valor_total|number_format:0:',':'.'}{/if}</td>
        </tr>
        {math assign="total_flete" equation="x + y" x=$total_flete y=$i.valor_flete}
        {math assign="total_seguro" equation="x + y" x=$total_seguro y=$i.valor_seguro}
        {math assign="total_otros" equation="x + y" x=$total_otros y=$i.valor_otros}
        {math assign="total_total" equation="x + y" x=$total_total y=$i.valor_total}                        
        {/foreach}  
        <tr>
        	<td class="borderTop borderRight" colspan="11" align="right">TOTALES</td> 
        	<td class="borderTop borderRight" align="right">${$total_flete|number_format:0:',':'.'}</td>
        	<td class="borderTop borderRight" align="right">${$total_seguro|number_format:0:',':'.'}</td>                         
        	<td class="borderTop borderRight" align="right">${$total_otros|number_format:0:',':'.'}</td>
        	<td class="borderTop borderRight" align="right">${$total_total|number_format:0:',':'.'}</td>            
		</tr>                        
    </table>
</body>
</html>
