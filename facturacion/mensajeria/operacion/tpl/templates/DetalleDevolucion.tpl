<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <table id="tableSolicitudServicios" width="100%" >
    <thead>
        <th style='text-transform:upperCase'>numero guia</th>  	
        <th style='text-transform:upperCase; display:none'>cliente</th>  	
        <th style='text-transform:upperCase'>origen</th>  	
        <th style='text-transform:upperCase'>destino</th> 	
        <th style='text-transform:upperCase'>fecha</th>  	
        <th style='text-transform:upperCase;'>descrip produc</th>  	
        <th style='text-transform:upperCase'>cantidad</th>  	
        <th style='text-transform:upperCase'>peso (kg)</th>  	
        <th style='text-transform:upperCase; display:none'>valor declarado</th>  	
        <th style='text-transform:upperCase'>remitente</th>	
        <th style='text-transform:upperCase; display:none'>dir remi</th>  	
        <th style='text-transform:upperCase; display:none'>tel remi</th>  	
        <th style='text-transform:upperCase'>destinatario</th>  	
        <th style='text-transform:upperCase; display:none'>doc destinatario</th>  	
        <th style='text-transform:upperCase'>dir dest</th>  	
        <th style='text-transform:upperCase; display:none'>tel dest</th>  
        <th style='text-transform:upperCase'>Valor</th>  
        <th style='text-transform:upperCase'>GUARDAR</th>  
        <th style='text-transform:upperCase'><span style="color:red; font-weight:bold">Quitar</span></th> 
      </tr>
      </thead>      
      <tbody>      
      {foreach name=detalle from=$DETALLES item=d}
      <tr>	
        <td>{$d.numero_guia}</td>  	
        <td style="display:none">{$d.cliente}</td>  	
        <td>{$d.origen}</td>  	
        <td>{$d.destino}</td>	
        <td>{$d.fecha_rm}</td>  	
        <td>{$d.descrip_produc_rm}</td>  	
        <td>{$d.cantidad_rm}</td>  	
        <td>{$d.peso_rm}</td>  	
        <td style="display:none">{$d.valor_rm}</td>  	
        <td>{$d.remitente_rm}</td> 	
        <td style="display:none">{$d.dir_remi_rm}</td>  	
        <td style="display:none">{$d.tel_remi_rm}</td>  	
        <td>{$d.destinatario_rm}</td>  	
        <td style="display:none">{$d.doc_destinatario_rm}</td>  	
        <td>{$d.dir_dest_rm}</td>  	
        <td style="display:none">{$d.tel_dest_rm}            <input type="hidden" name="detalle_devolucion_id" id="detalle_devolucion_id" value="{$d.detalle_devolucion_id}"/></td>  	
        <td><input type="text" name="valor_flete" id="valor_flete" class="numeric" value="{$d.valor_flete}"/></td>   
        <td>{if $d.estado_man eq 'P' || $d.estado_man eq 'M'}<a name="saveDetalleDevolucion"><img src="/envipack/framework/media/images/grid/save.png" /></a>{/if}</td>
        <td>{if $d.estado_mensajeria_id eq '4' && $d.estado_man eq 'P'}<input type="checkbox" onClick="deleteDetalleDevolucion(this,{$d.detalle_devolucion_id})" />{/if}</td>         
      </tr>          
      {/foreach}      
      </tbody>        
    </table>
  </body>
</html>