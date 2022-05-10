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
            <th class="borderTop borderRight">GUIA Nº</th>
            <th class="borderTop borderRight">FECHA</th>
            <th class="borderTop borderRight">REMITENTE</th>
            <th class="borderTop borderRight">ORIGEN</th>
            <th class="borderTop borderRight">DESTINATARIO</th>
            <th class="borderTop borderRight">DESTINO</th>            
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">ESTADO MENSAJERIA</th>
          </tr>
          {foreach name=detalles from=$DETALLES item=i}

          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderTop borderRight">{$i.prefijo}-{$i.numero_guia}</td> 
            <td class="borderTop borderRight">{$i.fecha_guia}</td> 
            <td class="borderTop borderRight">{$i.remitente}</td>
            <td class="borderTop borderRight">{$i.origen}</td>  
            <td class="borderTop borderRight">{$i.destinatario}</td>
            <td class="borderTop borderRight">{$i.destino}</td>
            <td class="borderTop borderRight">{$i.oficina}</td>
            <td class="borderTop borderRight">{$i.estado}</td>  
          </tr>
        {/foreach}  
  </table>
</body>
</html>
