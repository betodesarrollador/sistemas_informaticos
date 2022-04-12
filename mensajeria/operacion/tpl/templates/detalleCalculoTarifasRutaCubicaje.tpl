<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="solicitud_servicio_tarifar_id" value="{$SOLICITUDID}" />
  <table id="tableSolicitudServicios" width="90%" align="center">
   <thead>
    <tr align="center">
     <th>SHPMENT</th>
     <th>ORIGEN</th>          
     <th>DESTINO</th>  
     <th>CUBICAJE</th>  	              	 
     <th>TARIFA</th>               
     <th align="right">&nbsp;</th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr align="center">
     <td>{$d.shipment}</td>
     <td>{$d.origen}</td>          
	 <td>{$d.destino}</td>
	 <td>{$d.cubicaje}</td>	 
	 <td align="right">{$d.valor|number_format:2:",":"."}</td>
     <td align="right"><input type="checkbox" name="procesar" /></td>     
    </tr>
	{/foreach}
	
   </tbody>
  </table>
  
  </body>
</html>