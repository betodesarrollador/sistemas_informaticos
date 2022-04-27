<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
   <input type="hidden" id="tipo_nov" value="{$tipo_nov}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%"></td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr>
    	<td align="center" colspan="3">
            REPORTE TRAFICO<br />
    	</td>
    </tr>	 	   
  	<tr>
    	<td align="left" colspan="3">
            PARAMETROS<br />
            {if $desde neq 'NULL'} Rango Inicial: {$desde}{/if}
            {if $hasta neq 'NULL'} Rango Final: {$hasta}{/if}  
            {if $desde_h neq 'NULL'} Horario:  {$desde_h}{/if} 
            {if $hasta_h neq 'NULL'} - {$hasta_h}{/if} <br />
            {if $si_cliente eq 'ALL'} Todos los Clientes {else} Cliente: {$cliente} {/if}<br />
            {if $si_placa eq 'ALL'} Todos Los Veh&iacute;culos {else} Veh&iacute;culo: {$placa} {/if}<br>
            {if $opciones_conductor eq 'T'} Todos Los Conductores {else} Conductor: {$conductor} {/if}<br>
	        {if $all_oficina eq 'SI'} Todas Las Oficinas{/if}<br>
    	</td>
    </tr>	 	   

  </table>	

  <table align="center" id="encabezado"  width="90%">

      {assign var="numeros" value=""}
      {assign var="contador" value="1"}
      
      {foreach name=detalles from=$DETALLES item=i}
  
          {if $numeros eq '' or $numeros neq $i.numero}
              
              {assign var="numeros" value=$i.numero}
              {assign var="contador" value="1"}
              <tr>
                <th colspan="7" align="left">&nbsp;</th>
              </tr>	
              <tr>
                <th colspan="7" align="left">&nbsp;</th>
              </tr>	
    
              <tr>
                <th colspan="7" align="left">Vehiculo: {$i.placa}  {$i.tipo_doc} {$i.numero}&nbsp;&nbsp;&nbsp;  - Fecha Salida: {$i.fecha_inicial_salida} Hora Salida: {$i.hora_inicial_salida}</th>
              
              </tr>	
              <tr>
                <th colspan="7" align="left">Origen: {$i.origen} Destino: {$i.destino} {if $i.ruta neq ''}&nbsp;&nbsp;&nbsp; - Ruta: {$i.ruta }{/if} </th>
              </tr>	
              {if $i.escolta_recibe neq '' or $i.escolta_entrega neq ''}
              <tr>
                <th colspan="7" align="left">{if $i.escolta_recibe neq ''}Escolta Recibe: {$i.escolta_recibe} {/if}{if $i.escolta_entrega neq ''}  Escolta Entgrega: {$i.escolta_entrega} {/if}</th>
              </tr>	
			  {/if}
              <tr>
                <th colspan="7" align="left">&nbsp;</th>
              </tr>	
        
              <tr>
                <th class="borderLeft borderTop borderRight">ORDEN</th>
                <th class="borderTop borderRight">PUNTO REFERENCIA</th>
                <th class="borderTop borderRight">UBICACION</th>
                <th class="borderTop borderRight">FECHA</th>
                <th class="borderTop borderRight">HORA</th>		
                <th class="borderTop borderRight">NOVEDAD</th>
                <th class="borderTop borderRight">OBSERVACION</th>
              </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$contador}</td> 
            <td class="borderTop borderRight">{$i.punto_referencia}</td>  
            <td class="borderTop borderRight">{$i.ubicacion_punto}</td>  
            <td class="borderTop borderRight">{$i.fecha_reporte}</td>  
            <td class="borderTop borderRight">{$i.hora_reporte}</td>  
            <td class="borderTop borderRight" align="right">{$i.novedad}</td>  
            <td class="borderTop borderRight" align="right">{$i.obser_deta}</td>  
          </tr> 
           {math equation="x + y" x=$contador y=1 assign="contador"}
  
      {/foreach}	
  </table>
  </body>
</html>