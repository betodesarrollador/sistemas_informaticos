<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="trafico_id" value="{$TRAFICOID}" />
  
  
  <table align="center" id="tableRemesas" width="100%">
    <thead>
      <tr>
       
        <th width="10%">REMESA </th>  
		 <th width="5%">FECHA REMESA </th>  
        <th width="5%">ORIGEN</th>
        <th width="5%">DESTINO</th>
        <th width="5%">DIRECCION ENTREGA</th>
        <th>CLIENTE</th>        
        <th width="15%">OBSERVACI&Oacute;N</th>  
        <th width="15%">ULTIMA NOVEDAD</th>        
       </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$REMESAS item=d}
       <tr>
       
        <td width="10%"><input width="100%"  type="text" name="numero_remesa" id="numero_remesa" value="{$d.numero_remesa}" readonly /></td>  
		<td ><input width="100%"  type="text" name="fecha_remesa" id="fecha_remesa" value="{$d.fecha_remesa}" readonly /></td>  
        <td ><input width="100%" type="text" name="origen" id="origen" value="{$d.origen}" readonly /></td>
        <td ><input width="100%" type="text" name="destino" id="destino" value="{$d.destino}" readonly /></td>
        <td ><input width="100%" type="text" name="direccion_destinatario" id="direccion_destinatario" value="{$d.direccion_destinatario}" readonly /></td>
        <td width="5%"><input width="100%" type="text" name="cliente" id="cliente" value="{$d.cliente}" readonly /></td>        
        <td width="15%"><input width="100%"  type="text" name="observacion" id="observacion" value="{$d.observaciones}" readonly /></td>  
        <td width="15%"><input width="100%" type="text" name="ult_novedad" id="ult_novedad" value="{$d.ult_novedad}" readonly /></td>                
        </tr>
	  {/foreach}	
	  
	 
	</tbody>
  </table>
  
  </body>
</html>