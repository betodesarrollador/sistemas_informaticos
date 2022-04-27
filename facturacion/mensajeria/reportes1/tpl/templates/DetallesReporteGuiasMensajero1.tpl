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
    {if $TRANSITO eq '' AND $ENTREGADO eq '' AND $DEVUELTO eq '' AND $DETALLES eq ''}
    <table align="center"  width="90%">
        <thead>
            <th class="borderTop borderRight borderLeft borderBottom">GUIA Nº</th>
            <th class="borderTop borderRight borderLeft borderBottom">ORDEN SERVICIO</th>                        
            <th class="borderTop borderRight borderLeft borderBottom">GUIA PADRE</th>
            <th class="borderTop borderRight borderLeft borderBottom">FECHA</th>
            <th class="borderTop borderRight borderLeft borderBottom">OFICINA</th>
            <th class="borderTop borderRight borderLeft borderBottom">TIPO SERVICIO</th>
            <th class="borderTop borderRight borderLeft borderBottom">TIPO ENVIO</th>
            <th class="borderTop borderRight borderLeft borderBottom">FACTURAS</th>                        
            <th class="borderTop borderRight borderLeft borderBottom">ESTADO MENSAJERIA</th>
            <th class="borderTop borderRight borderLeft borderBottom">Nº MANIFIESTO</th>
            <th class="borderTop borderRight borderLeft borderBottom">FECHA RECIBE</th>
            <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO RECIBE</th>
            <th class="borderTop borderRight borderLeft borderBottom">FECHA DE DEVOLUCI&Oacute;N</th>
            <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO DEVUELVE</th>
            <th class="borderTop borderRight borderLeft borderBottom">CAUSAL</th>
            <th class="borderTop borderRight borderLeft borderBottom">FECHA DE REENVIO</th>
            <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO REENVIO</th>
            <th class="borderTop borderRight borderLeft borderBottom">FECHA OFICINA DESTINO</th>
            <th class="borderTop borderRight borderLeft borderBottom">USUARIO OFICINA DESTIONO</th>
            
            <th class="borderTop borderRight borderLeft borderBottom">FECHA DE ENTREGA</th>
            <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO ENTREGA</th>
            <th class="borderTop borderRight borderLeft borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderLeft borderBottom">DESTINO</th>
            <th class="borderTop borderRight borderLeft borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderLeft borderBottom">DESTINATARIO</th>
            <th class="borderTop borderRight borderLeft borderBottom">DIRECCION DESTINATARIO</th>
            <th class="borderTop borderRight borderLeft borderBottom">DESCRIPCI&Oacute;N</th>
            <th class="borderTop borderRight borderLeft borderBottom">DOC. CLIENTE</th>
            <th class="borderTop borderRight borderLeft borderBottom">UNIDAD</th>
            <th class="borderTop borderRight borderLeft borderBottom">PESO</th>
            <th class="borderTop borderRight borderLeft borderBottom">CANTIDAD</th>
            <th class="borderTop borderRight borderLeft borderBottom">TIPO DE LIQUIDACI&Oacute;N</th>
            <th class="borderTop borderRight borderLeft borderBottom">OBSERVACIONES</th>
        </thead>
        <tr>
            <td class="borderTop borderRight borderLeft borderBottom" colspan="22" align="center">
            NO HAY ELEMENTOS PARA MOSTRAR EN ESTA CONSULTA
            </td>
        </tr>
    </table>
    {/if}
    {if $DETALLES eq ''}
        {if $TRANSITO neq ''}
            {assign var=a1 value=0}
            {foreach name=transito from=$TRANSITO item=a}
                {assign var=a1 value=$a1+1}
            {/foreach}
            <table width=100% align="left">
                <tr>
                    <td align="left" class="borderTop borderBottom"><img src="/velotax/framework/media/images/grid/add.png" alt="+" name="abrir_transito" id="abrir_transito"/><img src="/velotax/framework/media/images/grid/close.png" alt="-" name="cerrar_transito"  id="cerrar_transito" hidden/></td><td class="borderTop borderBottom" colspan=21>TOTAL EN TRANSITO: {$a1}</td>
                </tr>
            </table>
            <table align="left"  width="90%" id="transito_display">
                <thead>
                    <th class="borderTop borderRight borderLeft borderBottom">USUARIO REGISTRA</th>                
                    <th class="borderTop borderRight borderLeft borderBottom">GUIA Nº</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">OFICINA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO SERVICIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO ENVIO</th>                        
                    <th class="borderTop borderRight borderLeft borderBottom">FACTURAS</th>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">ESTADO MENSAJERIA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">Nº MANIFIESTO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA RECIBE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO RECIBE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE DEVOLUCION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO DEVUELVE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">CAUSAL</th>

                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE REENVIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO REENVIO</th>

                    <th class="borderTop borderRight borderLeft borderBottom">FECHA OFICINA DESTINO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">USUARIO OFICINA DESTIONO</th>
                    
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE ENTREGA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO ENTREGA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">ORIGEN</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DESTINO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DOC REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TELEFONO REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DIRECCION REMITENTE</th>
    
                    <th class="borderTop borderRight borderLeft borderBottom">DESTINATARIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DIRECCION DESTINATARIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DESCRIPCION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DOC. CLIENTE</th>                        
                    <th class="borderTop borderRight borderLeft borderBottom">UNIDAD</th>
                    <th class="borderTop borderRight borderLeft borderBottom">PESO</th>
    
                    <th class="borderTop borderRight borderLeft borderBottom">CANTIDAD</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO DE LIQUIDACION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">OBSERVACIONES</th>
                </thead>
                {foreach name=detalles from=$TRANSITO item=i}
                <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.solicitud_id}</td>                        
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia_padre}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.fecha_guia}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.oficina}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_servicio_mensajeria}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_envio}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.facturas}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.estado_mensajeria}</td>
                    <td class="borderTop borderRight borderLeft borderBottom" align="center">{if $i.reexpedido eq ''}N/A{else}{$i.reexpedido}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_recibe eq ''}N/A {else}{$i.fecha_recibe}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_recibe eq ''}N/A {else}{$i.mensajero_recibe}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_devuelve eq ''}N/A {else}{$i.fecha_devuelve}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_devuelve eq ''}N/A {else}{$i.mensajero_devuelve}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.causal_devolucion eq ''}N/A {else}{$i.causal_devolucion}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_reenvio eq ''}N/A {else}{$i.fecha_reenvio}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_reenvio eq ''}N/A {else}{$i.mensajero_reenvio}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_destino eq ''}N/A {else}{$i.fecha_destino}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.usuario_destino eq ''}N/A {else}{$i.usuario_destino}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_entrega eq ''}N/A {else}{$i.fecha_entrega}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_entrega eq ''}N/A {else}{$i.mensajero_entrega}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.origen}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.destino}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.doc_remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.telefono_remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_remitente}</td>
    
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.destinatario}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_destinatario}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.descripcion_producto}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.orden_despacho}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.medida}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.peso}</td>
    
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.cantidad}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">
                        {if $i.tipo_liquidacion eq 'P'}PENDIENTE{/if}{if $i.tipo_liquidacion eq 'M'}MANIFESTADO{/if}
                        {if $i.tipo_liquidacion eq 'L'}LIQUDADO{/if}{if $i.tipo_liquidacion eq 'A'}ANULADO{/if}
                    </td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.observaciones eq ''}N/A{else}{$i.observaciones}{/if}</td>
                </tr>
                {/foreach}
            </table>
        {/if}
        {if $ENTREGADO neq ''}
            {assign var=a2 value=0}
            {foreach name=entregado from=$ENTREGADO item=a}
                {assign var=a2 value=$a2+1}
            {/foreach}
            <table width=100% align="left">
                <tr>
                    <td align="left" class="borderTop borderBottom"><img src="/velotax/framework/media/images/grid/add.png" alt="+" name="abrir_entregado" id="abrir_entregado"/><img src="/velotax/framework/media/images/grid/close.png" alt="-" name="cerrar_entregado"  id="cerrar_entregado" hidden/></td><td class="borderTop borderBottom" colspan=21>TOTAL ENTREGADOS: {$a2}</td>
                </tr>
            </table>
            <table align="left"  width="90%" id="entregado_display">
                <tr>
                    <th class="borderTop borderRight borderLeft borderBottom">GUIA Nº</th>
                    <th class="borderTop borderRight borderLeft borderBottom">ORDEN SERVICIO</td>                        
                    <th class="borderTop borderRight borderLeft borderBottom">GUIA PADRE</th>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">OFICINA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO SERVICIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO ENVIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FACTURAS</th>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">ESTADO MENSAJERIA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">Nº MANIFIESTO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA RECIBE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO RECIBE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE DEVOLUCION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO DEVUELVE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">CAUSAL</th>

                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE REENVIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO REENVIO</th>

                    <th class="borderTop borderRight borderLeft borderBottom">FECHA OFICINA DESTINO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">USUARIO OFICINA DESTIONO</th>
                    
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE ENTREGA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO ENTREGA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">ORIGEN</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DESTINO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DOC REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TELEFONO REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DIRECCION REMITENTE</th>
    
                    <th class="borderTop borderRight borderLeft borderBottom">DESTINATARIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DIRECCION DESTINATARIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DESCRIPCION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DOC. CLIENTE</th>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">UNIDAD</th>
                    <th class="borderTop borderRight borderLeft borderBottom">PESO</th>
    
                    <th class="borderTop borderRight borderLeft borderBottom">CANTIDAD</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO DE LIQUIDACION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">OBSERVACIONES</th>
                </tr>
                {foreach name=detalles from=$ENTREGADO item=i}
                <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.solicitud_id}</td>                                                
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia_padre}</td>                        
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.fecha_guia}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.oficina}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_servicio_mensajeria}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_envio}</td>                        
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.facturas}</td>                        
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.estado_mensajeria}</td>		
                    <td class="borderTop borderRight borderLeft borderBottom" align="center">{if $i.reexpedido eq ''}N/A{else}{$i.reexpedido}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_recibe eq ''}N/A {else}{$i.fecha_recibe}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_recibe eq ''}N/A {else}{$i.mensajero_recibe}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_devuelve eq ''}N/A {else}{$i.fecha_devuelve}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_devuelve eq ''}N/A {else}{$i.mensajero_devuelve}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.causal_devolucion eq ''}N/A {else}{$i.causal_devolucion}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_reenvio eq ''}N/A {else}{$i.fecha_reenvio}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_reenvio eq ''}N/A {else}{$i.mensajero_reenvio}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_destino eq ''}N/A {else}{$i.fecha_destino}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.usuario_destino eq ''}N/A {else}{$i.usuario_destino}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_entrega eq ''}N/A {else}{$i.fecha_entrega}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_entrega eq ''}N/A {else}{$i.mensajero_entrega}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.origen}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.destino}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.doc_remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.telefono_remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_remitente}</td>
    
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.destinatario}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_destinatario}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.descripcion_producto}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.orden_despacho}</td>                        
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.medida}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.peso}</td>
    
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.cantidad}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">
                        {if $i.tipo_liquidacion eq 'P'}PENDIENTE{/if}{if $i.tipo_liquidacion eq 'M'}MANIFESTADO{/if}
                        {if $i.tipo_liquidacion eq 'L'}LIQUDADO{/if}{if $i.tipo_liquidacion eq 'A'}ANULADO{/if}
                    </td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.observaciones eq ''}N/A{else}{$i.observaciones}{/if}</td>
                </tr>
                {/foreach}
            </table>
        {/if}
        {if $DEVUELTO neq ''}
            {assign var=a3 value=0}
            {foreach name=devuelto from=$DEVUELTO item=a}
                {assign var=a3 value=$a3+1}
            {/foreach}
            <table width=100% align="left">
                <tr>
                    <td align="left" class="borderTop borderBottom"><img src="/velotax/framework/media/images/grid/add.png" alt="+" name="abrir_devuelto" id="abrir_devuelto"/><img src="/velotax/framework/media/images/grid/close.png" alt="-" name="cerrar_devuelto"  id="cerrar_devuelto" hidden/></td><td class="borderTop borderBottom" colspan=21>TOTAL DEVUELTOS: {$a3}</td>
                </tr>
            </table>
            <table align="left"  width="90%" id="devuelto_display">
                <tr>
                    <th class="borderTop borderRight borderLeft borderBottom">GUIA Nº</th>
                    <th class="borderTop borderRight borderLeft borderBottom">ORDEN SERVICIO</td>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">GUIA PADRE</th>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">OFICINA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO SERVICIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO ENVIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FACTURAS</th>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">ESTADO MENSAJERIA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">Nº MANIFIESTO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA RECIBE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO RECIBE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE DEVOLUCION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO DEVUELVE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">CAUSAL</th>

                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE REENVIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO REENVIO</th>

                    <th class="borderTop borderRight borderLeft borderBottom">FECHA OFICINA DESTINO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">USUARIO OFICINA DESTIONO</th>
                    
                    <th class="borderTop borderRight borderLeft borderBottom">FECHA DE ENTREGA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO ENTREGA</th>
                    <th class="borderTop borderRight borderLeft borderBottom">ORIGEN</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DESTINO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DOC REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TELEFONO REMITENTE</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DIRECCION REMITENTE</th>
    
                    <th class="borderTop borderRight borderLeft borderBottom">DESTINATARIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DIRECCION DESTINATARIO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DESCRIPCION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">DOC. CLIENTE</th>                                                
                    <th class="borderTop borderRight borderLeft borderBottom">UNIDAD</th>
                    <th class="borderTop borderRight borderLeft borderBottom">PESO</th>
    
                    <th class="borderTop borderRight borderLeft borderBottom">CANTIDAD</th>
                    <th class="borderTop borderRight borderLeft borderBottom">TIPO DE LIQUIDACION</th>
                    <th class="borderTop borderRight borderLeft borderBottom">OBSERVACIONES</th>
                </tr>
                {foreach name=detalles from=$DEVUELTO item=i}
                    <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.solicitud_id}</td>                                                    
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia_padre}</td>                            
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.fecha_guia}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.oficina}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_servicio_mensajeria}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_envio}</td>                            
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.facturas}</td>            
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.estado_mensajeria}</td>			
                        <td class="borderTop borderRight borderLeft borderBottom" align="center">{if $i.reexpedido eq ''}N/A{else}{$i.reexpedido}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_recibe eq ''}N/A {else}{$i.fecha_recibe}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_recibe eq ''}N/A {else}{$i.mensajero_recibe}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_devuelve eq ''}N/A {else}{$i.fecha_devuelve}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_devuelve eq ''}N/A {else}{$i.mensajero_devuelve}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.causal_devolucion eq ''}N/A {else}{$i.causal_devolucion}{/if}</td>

                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_reenvio eq ''}N/A {else}{$i.fecha_reenvio}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_reenvio eq ''}N/A {else}{$i.mensajero_reenvio}{/if}</td>

                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_destino eq ''}N/A {else}{$i.fecha_destino}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.usuario_destino eq ''}N/A {else}{$i.usuario_destino}{/if}</td>

                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_entrega eq ''}N/A {else}{$i.fecha_entrega}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_entrega eq ''}N/A {else}{$i.mensajero_entrega}{/if}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.origen}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.destino}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.doc_remitente}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.remitente}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.telefono_remitente}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_remitente}</td>
        
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.destinatario}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_destinatario}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.descripcion_producto}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.orden_despacho}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.medida}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.peso}</td>
        
                        <td class="borderTop borderRight borderLeft borderBottom">{$i.cantidad}</td>
                        <td class="borderTop borderRight borderLeft borderBottom">
                            {if $i.tipo_liquidacion eq 'P'}PENDIENTE{/if}{if $i.tipo_liquidacion eq 'M'}MANIFESTADO{/if}
                            {if $i.tipo_liquidacion eq 'L'}LIQUDADO{/if}{if $i.tipo_liquidacion eq 'A'}ANULADO{/if}
                        </td>
                        <td class="borderTop borderRight borderLeft borderBottom">{if $i.observaciones eq ''}N/A{else}{$i.observaciones}{/if}</td>
                    </tr>
                {/foreach}
            </table>
        {/if}
        {if $TRANSITO neq '' OR $ENTREGADO neq '' OR $DEVUELTO neq ''}
            {assign var=total value=$a1+$a2+$a3}
            <table width=100% align="left">
                <tr>
                    <td class="borderTop borderBottom"></td>
                    <td align="left" class="borderTop borderBottom" colspan=21>TOTAL DE GUIAS: {$total}</td>
                </tr>
            </table>
        {/if}
    {else}
        <table align="center"  width="90%">
            <tr>
                <th class="borderTop borderRight borderLeft borderBottom">GUIA Nº</th>
                <th class="borderTop borderRight borderLeft borderBottom">ORDEN SERVICIO</td>                                            
                <th class="borderTop borderRight borderLeft borderBottom">GUIA PADRE</th>                                                
                
                <th class="borderTop borderRight borderLeft borderBottom">FECHA</th>
                <th class="borderTop borderRight borderLeft borderBottom">OFICINA</th>
                <th class="borderTop borderRight borderLeft borderBottom">TIPO SERVICIO</th>
                <th class="borderTop borderRight borderLeft borderBottom">TIPO ENVIO</th>                    
                <th class="borderTop borderRight borderLeft borderBottom">FACTURAS</th>                        
                
                <th class="borderTop borderRight borderLeft borderBottom">ESTADO MENSAJERIA</th>

                <th class="borderTop borderRight borderLeft borderBottom">Nº MANIFIESTO</th>
                <th class="borderTop borderRight borderLeft borderBottom">FECHA RECIBE</th>
                <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO RECIBE</th>
                <th class="borderTop borderRight borderLeft borderBottom">FECHA DE DEVOLUCION</th>
                <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO DEVUELVE</th>
                <th class="borderTop borderRight borderLeft borderBottom">CAUSAL</th>

                <th class="borderTop borderRight borderLeft borderBottom">FECHA DE REENVIO</th>
                <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO REENVIO</th>

                    <th class="borderTop borderRight borderLeft borderBottom">FECHA OFICINA DESTINO</th>
                    <th class="borderTop borderRight borderLeft borderBottom">USUARIO OFICINA DESTIONO</th>
                
                <th class="borderTop borderRight borderLeft borderBottom">FECHA DE ENTREGA</th>
                <th class="borderTop borderRight borderLeft borderBottom">MENSAJERO ENTREGA</th>
                <th class="borderTop borderRight borderLeft borderBottom">ORIGEN</th>
                <th class="borderTop borderRight borderLeft borderBottom">DESTINO</th>
                <th class="borderTop borderRight borderLeft borderBottom">DOC REMITENTE</th>
                <th class="borderTop borderRight borderLeft borderBottom">REMITENTE</th>
                <th class="borderTop borderRight borderLeft borderBottom">TELEFONO REMITENTE</th>
                <th class="borderTop borderRight borderLeft borderBottom">DIRECCION REMITENTE</th>

                <th class="borderTop borderRight borderLeft borderBottom">DESTINATARIO</th>
                <th class="borderTop borderRight borderLeft borderBottom">DIRECCION DESTINATARIO</th>
                <th class="borderTop borderRight borderLeft borderBottom">DESCRIPCION</th>
                <th class="borderTop borderRight borderLeft borderBottom">UNIDAD</th>
                <th class="borderTop borderRight borderLeft borderBottom">PESO</th>
                <th class="borderTop borderRight borderLeft borderBottom">DOC. CLIENTE</th>                        
                <th class="borderTop borderRight borderLeft borderBottom">CANTIDAD</th>
                <th class="borderTop borderRight borderLeft borderBottom">TIPO DE LIQUIDACION</th>
                <th class="borderTop borderRight borderLeft borderBottom">OBSERVACIONES</th>
            </tr>
            {foreach name=detalles from=$DETALLES item=i}
                <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.solicitud_id}</td>                                                
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.numero_guia_padre}</td>                            
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.fecha_guia}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.oficina}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_servicio_mensajeria}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.tipo_envio}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.facturas}</td>                        
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.estado_mensajeria}</td>		
                    <td class="borderTop borderRight borderLeft borderBottom" align="center">{if $i.reexpedido eq ''}N/A{else}{$i.reexpedido}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_recibe eq ''}N/A {else}{$i.fecha_recibe}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_recibe eq ''}N/A {else}{$i.mensajero_recibe}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_devuelve eq ''}N/A {else}{$i.fecha_devuelve}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_devuelve eq ''}N/A {else}{$i.mensajero_devuelve}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.causal_devolucion eq ''}N/A {else}{$i.causal_devolucion}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_reenvio eq ''}N/A {else}{$i.fecha_reenvio}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_reenvio eq ''}N/A {else}{$i.mensajero_reenvio}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_destino eq ''}N/A {else}{$i.fecha_destino}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.usuario_destino eq ''}N/A {else}{$i.usuario_destino}{/if}</td>

                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.fecha_entrega eq ''}N/A {else}{$i.fecha_entrega}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.mensajero_entrega eq ''}N/A {else}{$i.mensajero_entrega}{/if}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.origen}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.destino}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.doc_remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.telefono_remitente}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_remitente}</td>
    
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.destinatario}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.direccion_destinatario}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.descripcion_producto}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.medida}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.peso}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.orden_despacho}</td>
    
                    <td class="borderTop borderRight borderLeft borderBottom">{$i.cantidad}</td>
                    <td class="borderTop borderRight borderLeft borderBottom">
                        {if $i.tipo_liquidacion eq 'P'}PENDIENTE{/if}{if $i.tipo_liquidacion eq 'M'}MANIFESTADO{/if}
                        {if $i.tipo_liquidacion eq 'L'}LIQUDADO{/if}{if $i.tipo_liquidacion eq 'A'}ANULADO{/if}
                    </td>
                    <td class="borderTop borderRight borderLeft borderBottom">{if $i.observaciones eq ''}N/A{else}{$i.observaciones}{/if}</td>
                </tr>
            {/foreach}
        </table>
    {/if}
</body>
</html>
