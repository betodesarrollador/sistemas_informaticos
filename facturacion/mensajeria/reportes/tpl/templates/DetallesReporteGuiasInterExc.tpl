<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input  type="hidden" id="estado" value="{$estado_id}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
    <tr><td width="30%">&nbsp;</td><td width="30%" align="right">&nbsp;</td></tr> 
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td></tr>       
  </table>  

  <table align="center" id="encabezado"  width="90%">
          <tr>
            <th class="borderTop borderRight">GUIA Nº</th>
            <th class="borderTop borderRight">DOC CLIENTE</th>
            <th class="borderTop borderRight">ORDEN SERVICIO</th>
            <th class="borderTop borderRight">FECHA</th>
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">TIPO ENVIO</th>            
            <th class="borderTop borderRight">ESTADO MENSAJERIA</th>
            <th class="borderTop borderRight">NOV DEVOLUCION</th>
            <th class="borderTop borderRight">MENSAJERO</th>
            <th class="borderTop borderRight">FECHA CARGUE</th>            
            <th class="borderTop borderRight">TIPO DE SERVICIO</th>
            <th class="borderTop borderRight">N° MANIFIESTO</th>
            <th class="borderTop borderRight">CLIENTE</th>
            <th class="borderTop borderRight">ORIGEN</th>   
            <th class="borderTop borderRight">DESTINO</th>
            <th class="borderTop borderRight">FECHA DE ENTREGA</th>
            <th class="borderTop borderRight">DOC REMITENTE</th>
            <th class="borderTop borderRight">REMITENTE</th>
            <th class="borderTop borderRight">TELEFONO REMITENTE</th>
            <th class="borderTop borderRight">DIRECCION REMITENTE</th>
            <th class="borderTop borderRight">DESTINATARIO</th>
            <th class="borderTop borderRight">NIT DESTINATARIO</th>
            <th class="borderTop borderRight">DIR. DESTINATARIO</th>
			<th class="borderTop borderRight">TEL DESTINATARIO</th>		            
            <th class="borderTop borderRight">DESCRIPCION</th>
            <th class="borderTop borderRight">PROCESO</th>
            <th class="borderTop borderRight">PEDIDO</th>
            <th class="borderTop borderRight">UNIDAD</th>
            <th class="borderTop borderRight">FACTURAS</th>
            <th class="borderTop borderRight">UNIDAD MEDIDA</th>
            <th class="borderTop borderRight">PESO</th>
            <th class="borderTop borderRight">CANTIDAD</th>
            <th class="borderTop borderRight">TIPO DE LIQUIDACION</th>
            <th class="borderTop borderRight">OBSERVACIONES</th>
            <th class="borderTop borderRight">VALOR FLETE</th>
            <th class="borderTop borderRight">VALOR SEGURO</th>
            <th class="borderTop borderRight">VALOR OTROS</th>
            <th class="borderTop borderRight">VALOR TOTAL</th>
            <th class="borderTop borderRight">FOTO CUMPLIDO</th>
          </tr>
          {foreach name=detalles from=$DETALLES item=i}

          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderTop borderRight">&nbsp;{$i.numero_guia}</td> 
            <td class="borderTop borderRight">{$i.documento_cliente}</td>
            <td class="borderTop borderRight">{$i.orden_servicio}</td> 
            <td class="borderTop borderRight">{$i.fecha_guia}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>
            <td class="borderTop borderRight">{$i.tipo_envio}</td>                
            <td class="borderTop borderRight">{$i.estado_mensajeria}</td>  
            <td class="borderTop borderRight">{$i.nov_devolucion}</td>             
            <td class="borderTop borderRight">{$i.mensajero}</td>
            <td class="borderTop borderRight">{$i.fecha_rxp}</td>            
            <td class="borderTop borderRight">{$i.tipo_servicio}</td>
            <td class="borderTop borderRight">{$i.manifiesto}</td>
            <td class="borderTop borderRight">{$i.nombre_cliente}</td>
            <td class="borderTop borderRight">{$i.origen}</td>  
            <td class="borderTop borderRight">{$i.destino}</td>
            <td class="borderTop borderRight">{$i.fecha_entrega}</td>
            <td class="borderTop borderRight">{$i.doc_remitente}</td>
            <td class="borderTop borderRight">{$i.remitente}</td>
            <td class="borderTop borderRight">{$i.telefono_remitente}</td>
            <td class="borderTop borderRight">{$i.direccion_remitente}</td>
            <td class="borderTop borderRight">{$i.destinatario}</td> 
            <td class="borderTop borderRight">{$i.nit_destinatario}</td> 
            <td class="borderTop borderRight">{$i.direccion_destinatario}</td>   
            <td class="borderTop borderRight">{$i.telefono_destinatario}</td>  
            <td class="borderTop borderRight">{$i.descripcion_producto}</td> 

            <td class="borderTop borderRight">{$i.proceso}</td> 
            <td class="borderTop borderRight">{$i.pedido}</td> 
            <td class="borderTop borderRight">{$i.unidad}</td> 
            <td class="borderTop borderRight">{$i.facturas}</td> 
            
            <td class="borderTop borderRight">{$i.medida}</td> 
            <td class="borderTop borderRight">{$i.peso}</td>
            <td class="borderTop borderRight">{$i.cantidad}</td> 
            <td class="borderTop borderRight">{$i.tipo_liquidacion}</td>
            <td class="borderTop borderRight">{$i.observaciones}</td>  
            <td class="borderTop borderRight">{$i.valor_flete}</td>  
            <td class="borderTop borderRight">{$i.valor_seguro}</td>  
            <td class="borderTop borderRight">{$i.valor_otros}</td>  
            <td class="borderTop borderRight">{$i.valor_total}</td>
	        <td class="borderTop borderRight">{if $i.foto_cumplido != ''}<a href="{$i.foto_cumplido}">{$i.numero_guia}</a>{else}Sin foto{/if}</td>
          </tr>
        {/foreach}  
  </table>
  </body>
</html>
