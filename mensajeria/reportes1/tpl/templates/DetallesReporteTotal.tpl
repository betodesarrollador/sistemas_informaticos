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
    <tr><td colspan="3" align="center">Reporte Consolidado Por Clientes</td></tr>
    <tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td></tr>       
  </table>  

  <table align="center" id="encabezado"  width="90%">
          <tr>
            <th class="borderTop borderRight borderLeft">CLIENTE</th>
            <th class="borderTop borderRight">ALISTAMIENTO</th>            
            <th class="borderTop borderRight">BODEGA ORIGEN</th>
            <th class="borderTop borderRight">BODEGA DESTINO</th>
            <th class="borderTop borderRight">TRANSITO</th>
            <th class="borderTop borderRight">DISTRIBUCI&Oacute;N</th>            
            <th class="borderTop borderRight">ENTREGADO</th>
            <th class="borderTop borderRight">DEVUELTO</th>
            <th class="borderTop borderRight">ANULADO</th>
            <th class="borderTop borderRight">TOTAL GUIAS</th>
          </tr>
          {foreach name=detalles from=$DETALLES item=i}

          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderTop borderRight borderLeft borderBottom" align="left">{$i.nombre_cliente}</td> 
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_alistamiento}</td>             
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_origen}</td>
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_destino}</td> 
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_transito}</td> 
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_distribucion}</td>             
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_entregado}</td> 
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_devuelto}</td> 
            <td class="borderTop borderRight borderBottom" align="right">{$i.g_anulado}</td>               
            <td class="borderTop borderRight borderBottom" align="right">{$i.total_guias}</td>               
          </tr>
        {/foreach}  
  </table>
  </body>
</html>
