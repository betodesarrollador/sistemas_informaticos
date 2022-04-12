<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input  type="hidden" id="estado" value="{$estado}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">{if $estado eq 'E'}Arqueos en Ediciòn{elseif  $estado eq 'A'}Arqueos Anulados{elseif  $estado eq 'C'}Arqueos Cerrados{/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td></tr>	 	   
  </table>	

  <table align="center" id="encabezado"  width="90%">
    
          <tr>
            <th class="borderLeft borderTop borderRight">CONSECUTIVO</th>
            <th class="borderLeft borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">FECHA ARQUEO</th>
            <th class="borderTop borderRight">EFECTIVO</th>
            <th class="borderTop borderRight">CHEQUE</th>   
            <th class="borderTop borderRight">SALDO AUX</th>
            <th class="borderTop borderRight">ESTADO</th>
          </tr>
          {foreach name=detalles from=$DETALLES item=i}

          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.consecutivo}</td> 
            <td class="borderLeft borderTop borderRight">{$i.oficina}</td> 
            <td class="borderTop borderRight">{$i.fecha_arqueo}</td>  
            <td class="borderTop borderRight">{$i.total_efectivo|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight">{$i.total_cheque|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight">{$i.saldo_auxiliar|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight">{$i.estado_arqueo}</td>
          </tr>
        {/foreach}  
  </table>
  </body>
</html>