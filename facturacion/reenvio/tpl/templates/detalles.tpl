<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  <div style="padding:5px">
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr>
    	<td width="30%">&nbsp;</td>
        <td align="center" class="titulo" width="40%">
    		{if $tipo eq 'TF'}
            	TODAS LAS FACTURAS
            {elseif  $tipo eq 'SR'}
            	SIN ACUSE DE RECIBO
            {elseif  $tipo eq 'SA'}
            	SIN APROBACION DIAN
            {elseif  $tipo eq 'CR'}
            	CON ACUSE DE RECIBO
            {elseif  $tipo eq 'CA'}
            	CON APROBACION DIAN
            {/if}
         </td>
         <td width="30%" align="right">&nbsp;</td>
    </tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td></tr>	 	   
  </table>	

  <table class="table table-bordered" align="center"  width="90%">
      <tr class="table-primary">
        <th>No FACT</th>
        <th>CLIENTE</th>
        <th>OFICINA</th>
        <th>FECHA FACT</th>
        <th>VENCE</th>
        <th>VALOR</th>
        <th>REPORTADA</th> 
        <th>CUFE</th> 
        <th>ACUSE</th>       
        <th>ACUSE RESPUESTA</th>
        <th>COMENTARIO</th>   
        <th>FECHA ACUSE</th>
        <th>VALIDACI&Oacute;N DIAN</th>        
        <th>XML</th>        
        <th>PDF</th> 
        <th>REENVIO</th>         
        <th>SINCRONIZAR</th>
                       
        
      </tr>
  
          
      {foreach name=detalles from=$DETALLES item=i}
  
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
    
            <td>{$i.prefijo}{$i.consecutivo_factura}</td> 
            <td>{$i.cliente_nombre}</td>          
            <td>{$i.oficina}</td>
            <td>{$i.fecha}</td>  
            <td>{$i.vencimiento}</td>  
            <td align="right">{$i.valor|number_format:0:',':'.'}</td> 
            <td>{$i.reportada}</td>
            <td><div style="width:100px; overflow-x:auto;">{$i.cufe}</div></td>
            <td>{$i.tipo_acuse}</td>
            <td>{$i.acuse_respuesta}</td>
            <td>{$i.acuseComentario}</td>                  
            <td>{$i.fecha_acuse}</td>                  
            <td>{$i.validacion_dian}</td> 
            <td><a href="../../../archivos/facturacion/xml/{$i.xml_dian}" target="_blank">{$i.xml_dian}</a></td>                          
            <td><a href="../../../archivos/facturacion/facturas/{$i.pdf_dian}" target="_blank">{$i.pdf_dian}</a></td>
            <td align="center">
                <img src="../media/images/MenuArbol/content.png" width="15px" alt="x" title="Reenviar" style="cursor:pointer;" onClick="parent.sincroniza_reenvio({$i.factura_id});" />
            </td>                          

            <td class="borderTop borderRight" align="center">
                <img src="../media/images/MenuArbol/sincronizar.png" width="15px" alt="x" title="sincronizar" style="cursor:pointer;" onClick="parent.sincroniza_estado({$i.factura_id});" />
            </td>          
                        
          </tr> 
      {/foreach}	
       
  </table>
  </div>
  </body>
</html>
