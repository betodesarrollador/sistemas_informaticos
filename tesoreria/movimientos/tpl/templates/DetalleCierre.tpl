<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>

  <table id="tableSolicitudServicios" width="100%" >
    <thead>
        <th style='text-transform:upperCase'>numero remesa</th> 
        <th style='text-transform:upperCase'>Valor Cobrado</th>  	
        <th style='text-transform:upperCase;'>Tipo</th> 	
        <th style='text-transform:upperCase;'>Oficina</th> 	        
        
        <th style='text-transform:upperCase'>origen</th>  	
        <th style='text-transform:upperCase'>destino</th>  	
        <th style='text-transform:upperCase'>fecha</th>  	
        <th style='text-transform:upperCase;'>descrip produc</th>  	
        <th style='text-transform:upperCase'>cantidad</th>  	
        <th style='text-transform:upperCase;'>peso neto</th>  	
        <th style='text-transform:upperCase'>remitente</th>  	
        <th style='text-transform:upperCase; display:none'>dir remi</th>  	
        <th style='text-transform:upperCase; display:none'>tel remi</th>  	
        <th style='text-transform:upperCase'>destinatario</th>  	
        <th style='text-transform:upperCase; display:none'>doc destinatario</th>  	
        <th style='text-transform:upperCase'>dir dest</th>  	
        <th style='text-transform:upperCase; display:none'>tel dest</th>  	
        <th style='text-transform:upperCase'><span style="color:red; font-weight:bold">Quitar</span></th> 
      </tr>
      </thead>
      
      <tbody>
      
      {foreach name=detalle from=$DETALLES item=d}
      <tr>	
        <td>{$d.numero_remesa}</td>  
        <td>{$d.valor_cobrado|number_format:0:",":"."}</td>  	
        <td>{$d.tipo}</td> 
        <td>{$d.oficina}</td> 	
        
        <td>{$d.origen}</td>  	
        <td>{$d.destino}</td>  	
        <td>{$d.fecha_rm}</td>  	
        <td>{$d.descrip_produc_rm}</td>  	
        <td>{$d.cantidad_rm}</td>  	
        <td >{$d.peso_neto_rm}</td>  	
        <td>{$d.remitente_rm}</td>  	
        <td style="display:none">{$d.dir_remi_rm}</td>  	
        <td style="display:none">{$d.tel_remi_rm}</td>  	
        <td>{$d.destinatario_rm}</td>  	
        <td style="display:none">{$d.doc_destinatario_rm}</td>  	
        <td>{$d.dir_dest_rm}</td>  	
        <td style="display:none">{$d.tel_dest_rm}</td>  	
        <td>{if $d.estado eq 'E'}<input type="checkbox" onClick="deleteDetalleManifiesto(this,{$d.detalle_cierre_contado_id})" />{/if}</td>         
      </tr>    
      
      {/foreach}
      
      </tbody>        
    </table>
  
  
  </body>
</html>