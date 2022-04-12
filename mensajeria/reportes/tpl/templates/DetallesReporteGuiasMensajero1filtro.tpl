<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
    {$TITLETAB}
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
        {if $DESDE neq '' AND $HASTA neq ''}
        <tr>
            <td align="center" colspan="3">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td>
        </tr>
        {elseif $DETALLES neq ''}
        <tr>
            <td>MENSAJERO: {$DETALLES.0.mensajero_recibe}</td>
        </tr>
        {else}
        <tr>
            <td>MENSAJERO: {$TRANSITO.0.mensajero_recibe}</td>
        </tr>
        {/if}
    </table>

    <table align="center"  width="90%">
        <tr>
            <th class="borderTop borderRight borderLeft borderBottom">GUIA Nº</th>
            
            <th class="borderTop borderRight borderLeft borderBottom">FECHA</th>
            <th class="borderTop borderRight borderLeft borderBottom">OFICINA</th>
            <th class="borderTop borderRight borderLeft borderBottom">TIPO SERVICIO</th>
            <th class="borderTop borderRight borderLeft borderBottom">TIPO ENVIO</th>                    
            <th class="borderTop borderRight borderLeft borderBottom">ESTADO MENSAJERIA</th>
            <th class="borderTop borderRight borderLeft borderBottom">Nº MANIFIESTO</th>
            <th class="borderTop borderRight borderLeft borderBottom">FECHA RECIBE</th>
            <th class="borderTop borderRight borderLeft borderBottom">INTERNO</th>
            <th class="borderTop borderRight borderLeft borderBottom">DOC MENSAJERO </th>
            <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO RECIBE</th>
            <th class="borderTop borderRight borderLeft borderBottom">FECHA ENTREGA</th>
            <th class="borderTop borderRight borderLeft borderBottom">DOC USUARIO CUMPLIDO</th>
            <th class="borderTop borderRight borderLeft borderBottom">USUARIO CUMPLIDO</th>
            <th class="borderTop borderRight borderLeft borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderLeft borderBottom">DESTINO</th>

            <th class="borderTop borderRight borderLeft borderBottom">PESO</th>
            <th class="borderTop borderRight borderLeft borderBottom">VOLUMEN</th>
            <th class="borderTop borderRight borderLeft borderBottom">CANTIDAD</th>
            <th class="borderTop borderRight borderLeft borderBottom">VALOR FLETE</th>            
            <th class="borderTop borderRight borderLeft borderBottom">VALOR SEGURO</th>
            <th class="borderTop borderRight borderLeft borderBottom">VALOR OTROS</th>
            <th class="borderTop borderRight borderLeft borderBottom">VALOR DESCUENTO</th>
            <th class="borderTop borderRight borderLeft borderBottom">VALOR TOTAL</th>

        </tr>
        {assign var="total_flete"      value=0} 
        {assign var="total_seguro"     value=0} 
        {assign var="total_otros"      value=0}  
        {assign var="total_descuentos" value=0}        
        {assign var="total_total"      value=0}          
        
        {foreach name=detalles from=$DETALLES item=i}
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.fecha_guia}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.oficina}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_servicio_mensajeria}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_envio}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.estado_mensajeria}</td>       
            <td class="borderTop borderRight borderLeft borderBottom" align="center">{if $i.reexpedido eq ''}N/A{else}{$i.reexpedido}{/if}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_recibe eq ''}N/A {else}{$i.fecha_recibe}{/if}</td>                    
            <td class="borderTop borderRight borderLeft borderBottom" align="center">{if $i.interno eq ''}N/A{else}{$i.interno}{/if}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_recibe_doc eq ''}N/A {else}{$i.mensajero_recibe_doc}{/if}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_recibe eq ''}N/A {else}{$i.mensajero_recibe}{/if}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.fecha_entrega}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{if $i.usuario_entrega_doc eq ''}N/A {else}{$i.usuario_entrega_doc}{/if}</td>                    
            <td class="borderTop borderRight borderLeft borderBottom">{if $i.usuario_entrega eq ''}N/A {else}{$i.usuario_entrega}{/if}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.origen}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.destino}</td>

            <td class="borderTop borderRight borderLeft borderBottom">{$i.peso}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.peso_volumen}</td>
            <td class="borderTop borderRight borderLeft borderBottom">{$i.cantidad}</td> 
            <td class="borderTop borderRight borderLeft borderBottom" align="right">{if $i.estado_mensajeria eq 'ANULADO'}$0{else}${$i.valor_flete|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight borderLeft borderBottom" align="right">{if $i.estado_mensajeria eq 'ANULADO'}$0{else}${$i.valor_seguro|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight borderLeft borderBottom" align="right">{if $i.estado_mensajeria eq 'ANULADO'}$0{else}${$i.valor_otros|number_format:0:',':'.'}{/if}</td> 
            <td class="borderTop borderRight borderLeft borderBottom" align="right">{if $i.estado_mensajeria eq 'ANULADO'}$0{else}${$i.valor_descuento|number_format:0:',':'.'}{/if}</td>
            <td class="borderTop borderRight borderLeft borderBottom" align="right">{if $i.estado_mensajeria eq 'ANULADO'}$0{else}${$i.valor_total|number_format:0:',':'.'}{/if}</td>

            
        </tr>

        {if $i.estado_mensajeria neq 'ANULADO'}
        
        {math assign="total_flete"          equation="x + y" x=$total_flete        y=$i.valor_flete}
        {math assign="total_seguro"         equation="x + y" x=$total_seguro       y=$i.valor_seguro}
        {math assign="total_otros"          equation="x + y" x=$total_otros        y=$i.valor_otros}
        {math assign="total_descuentos"     equation="x + y" x=$total_descuentos   y=$i.valor_descuento}
        {math assign="total_total"          equation="x + y" x=$total_total        y=$i.valor_total}

        {/if}                        
        
        {/foreach}
        <tr>
            <td class="borderTop borderRight" colspan="19" align="right">TOTALES</td> 
            <td class="borderTop borderRight" align="right">${$total_flete|number_format:0:',':'.'}</td>
            <td class="borderTop borderRight" align="right">${$total_seguro|number_format:0:',':'.'}</td>                         
            <td class="borderTop borderRight" align="right">${$total_otros|number_format:0:',':'.'}</td>
            <td class="borderTop borderRight" align="right">${$total_descuentos|number_format:0:',':'.'}</td>
            <td class="borderTop borderRight" align="right">${$total_total|number_format:0:',':'.'}</td>            
        </tr>                        
        
    </table>

</body>
</html>
