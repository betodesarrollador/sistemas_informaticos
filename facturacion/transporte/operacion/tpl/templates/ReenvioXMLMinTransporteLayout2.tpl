<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Reenvio XML MinTransporte</title>
{$CSSSYSTEM} {$JAVASCRIPT}
</head>

<body>

 <div align="center">

 {if count($CONDUCTORES) > 0}
   <br />
   <table align="center" border="1" width="95%">
   <thead>
    <tr>
	  <th>CONDUCTOR</th>
	  <th>FECHA ULTIMO REPORTE</th>
	  <th>ERROR</th>
	  <th>ARCHIVO XML</th>
	  <th>RECONSTRUIR XML</th>
	  <th>&nbsp;</th>
	</tr>
    </thead>
	
	{foreach name=conductores from=$CONDUCTORES item=c}
    <tr>
	  <td align="justify">&nbsp;{$c.conductor}</td>
	  <td align="justify">&nbsp;{$c.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$c.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$c.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendConductorMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  
		  <input type="hidden" name="conductor_id"       value="{$c.conductor_id}" />
		  <input type="hidden" name="path_xml"           value="{$c.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
		 </form>	  
	  </td>
	</tr>	
	{/foreach}
  </table>
 {/if}
 
 {if count($PROPIETARIOS) > 0}
  <br/>
  <table align="center" border="1" width="95%">
   <thead>
   <tr>
    <th>PROPIETARIO</th>
	<th>FECHA ULTIMO REPORTE</th>
	<th>ERROR</th>
	<th>ARCHIVO XML</th>
    <th>RECONSTRUIR XML</th>	
	<th>&nbsp;</th>
   </tr>
   </thead>
   
   {foreach name=propietarios from=$PROPIETARIOS item=p}
   <tr>
	  <td align="justify">&nbsp;{$p.propietario}</td>
	  <td align="justify">&nbsp;{$p.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$p.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$p.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendPropietarioMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  		  
		  <input type="hidden" name="tercero_id"         value="{$p.tercero_id}" />
		  <input type="hidden" name="path_xml"           value="{$p.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
		 </form>	  
	  </td>
   </tr>   
   {/foreach}
  </table>
 {/if}
 
 {if count($TENEDORES) > 0}
  <br/>
  <table align="center" border="1" width="95%">
   <thead>
   <tr>
    <th>TENEDOR</th>
	<th>FECHA ULTIMO REPORTE</th>
	<th>ERROR</th>
	<th>ARCHIVO XML</th>
    <th>RECONSTRUIR XML</th>		
	<th>&nbsp;</th>
   </tr>
   </thead>
    
   {foreach name=tenedores from=$TENEDORES item=tn}
   <tr>
	  <td align="justify">&nbsp;{$tn.tenedor}</td>
	  <td align="justify">&nbsp;{$tn.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$tn.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$tn.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendTenedorMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  		  		  
		  <input type="hidden" name="tenedor_id"         value="{$tn.tenedor_id}" />
		  <input type="hidden" name="path_xml"           value="{$tn.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
		 </form>	  
	  </td>
   </tr>   
   {/foreach}
  </table>
  
 {/if} 
 
 {if count($REMOLQUES) > 0}
  <br/>
  <table align="center" border="1" width="95%">
   <thead>
   <tr>
    <th>REMOLQUE</th>
	<th>FECHA ULTIMO REPORTE</th>
	<th>ERROR</th>
	<th>ARCHIVO XML</th>
    <th>RECONSTRUIR XML</th>			
	<th>&nbsp;</th>
   </tr>
   </thead>
    
   {foreach name=remolques from=$REMOLQUES item=rm}
   <tr>
	  <td align="justify">&nbsp;{$rm.placa_remolque}</td>
	  <td align="justify">&nbsp;{$rm.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$rm.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$rm.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendRemolqueMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  		  		  
		  <input type="hidden" name="placa_remolque_id"  value="{$rm.placa_remolque_id}" />
		  <input type="hidden" name="path_xml"           value="{$rm.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
		 </form>	  
	  </td>
   </tr>   
   {/foreach}
  </table> 
 
 {/if}
 
 {if count($VEHICULOS) > 0}
  <br/>
  <table align="center" border="1" width="95%">
   <thead>
   <tr>
    <th>VEHICULO</th>
	<th>FECHA ULTIMO REPORTE</th>
	<th>ERROR</th>
	<th>ARCHIVO XML</th>
    <th>RECONSTRUIR XML</th>			
	<th>&nbsp;</th>
   </tr>
   </thead>
    
   {foreach name=vehiculos from=$VEHICULOS item=vh}
   <tr>
	  <td align="justify">&nbsp;{$vh.placa}</td>
	  <td align="justify">&nbsp;{$vh.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$vh.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$vh.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendVehiculoMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  		  		  
		  <input type="hidden" name="placa_id"           value="{$vh.placa_id}" />
		  <input type="hidden" name="path_xml"           value="{$vh.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
		 </form>	  
	  </td>
   </tr>   
   {/foreach}
  </table> 
 
 {/if} 
 
 {if count($CLIENTES) > 0}
  <br/>
  <table align="center" border="1" width="95%">
   <thead>
   <tr>
    <th>CLIENTE</th>
	<th>FECHA ULTIMO REPORTE</th>
	<th>ERROR</th>
	<th>ARCHIVO XML</th>
    <th>RECONSTRUIR XML</th>				
	<th>&nbsp;</th>
   </tr>
   </thead>
    
   {foreach name=clientes from=$CLIENTES item=ct}
   <tr>
	  <td align="justify">&nbsp;{$ct.nombre}&nbsp;{$ct.primer_apellido}&nbsp;{$ct.segundo_apellido}</td>
	  <td align="justify">&nbsp;{$ct.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$ct.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$ct.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendRemitenteDestinatarioMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  		  		  
		  <input type="hidden" name="cliente_id"         value="{$ct.cliente_id}" />
		  <input type="hidden" name="path_xml"           value="{$ct.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
		 </form>	  
	  </td>
   </tr>   
   {/foreach}
  </table> 
 
 {/if}  
 
 {if count($REMITENTES) > 0}
  <br/>
  <table align="center" border="1" width="95%">
  <thead>
   <tr>
    <th>REMITENTE</th>
	<th>FECHA ULTIMO REPORTE</th>
	<th>ERROR</th>
	<th>ARCHIVO XML</th>
    <th>RECONSTRUIR XML</th>					
	<th>&nbsp;</th>
   </tr>
   </thead>
    
   {foreach name=remitentes from=$REMITENTES item=rt}
   <tr>
	  <td align="justify">&nbsp;{$rt.nombre}&nbsp;{$rt.primer_apellido}&nbsp;{$rt.segundo_apellido}</td>
	  <td align="justify">&nbsp;{$rt.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$rt.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$rt.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"           value="sendRemitenteDestinatarioMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  		  		  
		  <input type="hidden" name="remitente_destinatario_id" value="{$rt.remitente_destinatario_id}" />
		  <input type="hidden" name="tipo"                      value="R" />		  
		  <input type="hidden" name="path_xml"                  value="{$rt.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar"        value="Enviar >" />
		 </form>	  
	  </td>
   </tr>   
   {/foreach}
  </table> 
 
 {/if} 
 
 
 {if count($DESTINATARIOS) > 0}
  <br/>
  <table align="center" border="1" width="95%">
   <thead>
   <tr>
    <th>DESTINATARIO</th>
	<th>FECHA ULTIMO REPORTE</th>
	<th>ERROR</th>
	<th>ARCHIVO XML</th>
    <th>RECONSTRUIR XML</th>						
	<th>&nbsp;</th>
   </tr>
   </thead>
    
   {foreach name=destinatarios from=$DESTINATARIOS item=dt}
   <tr>
	  <td align="justify">&nbsp;{$dt.nombre}&nbsp;{$dt.primer_apellido}&nbsp;{$dt.segundo_apellido}</td>
	  <td align="justify">&nbsp;{$dt.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$dt.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$dt.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"           value="sendRemitenteDestinatarioMintransporte" />
		  <input type="hidden" name="reconstruir"        value="" />		  		  		  
		  <input type="hidden" name="remitente_destinatario_id" value="{$dt.remitente_destinatario_id}" />
		  <input type="hidden" name="tipo"                      value="D" />		  		  
		  <input type="hidden" name="path_xml"                  value="{$dt.path_xml}" />	  
		  <input type="submit" name="enviar" id="enviar"        value="Enviar >" />
		 </form>	  
	  </td>
   </tr>   
   {/foreach}
  </table> 
 
 {/if} 

 {if count($INFOCARGA) > 0}
 <br/>
 <table align="center" border="1" width="95%">
 <thead>
  <tr align="center">
   <th>INFORMACION CARGA</th>
   <th>FECHA ULTIMO REPORTE</th>
   <th>ERROR INFORMACION CARGA</th>
   <th>ARCHIVO XML</th>
   <th>RECONSTRUIR XML</th>						   
   <th>&nbsp;</th>
  </tr>
  </thead>
  
  {foreach name=informacion_carga from=$INFOCARGA item=i}
   <tr>
    <td align="justify">&nbsp;{$i.numero_remesa}</td>
	<td align="justify">&nbsp;{$i.fecha_error_reportando_ministerio}</td>
	<td align="justify">&nbsp;{$i.ultimo_error_reportando_ministario}</td>
	<td align="justify">&nbsp;<a href="{$i.path_xml_informacion_carga}" target="_blank">XML</a></td>
    <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  	  	
	<td align="justify">&nbsp;
	 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	  <input type="hidden" name="ACTIONCONTROLER"            value="sendInformacionCarga" />
	  <input type="hidden" name="reconstruir"                value="" />		  		  	  
	  <input type="hidden" name="remesa_id"                  value="{$i.remesa_id}" />
	  <input type="hidden" name="path_xml_informacion_carga" value="{$i.path_xml_informacion_carga}" />	  
	  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
	 </form>
	</td>	 
   </tr>  
  {/foreach}
 </table>
 {/if}
 
 {if count($MANIFIESTOS) > 0}
     <br />  
	 <table align="center" border="1" width="95%">
	  <thead>
	  <tr align="center">
	   <th>INFORMACION VIAJE</th>	 
	   <th>REMESA(S)</th>  
	   <th>ERROR INFROMACION VIAJE</th>
	   <th>ARCHIVO XML</th>   
       <th>RECONSTRUIR XML</th>						   
       <th>&nbsp;</th>	   
	  </tr>
	  </thead>	  
	  <tbody>
	  
      {foreach name=info_viaje from=$MANIFIESTOS item=iv}     	  
	   <tr>
	   <td align="justify">&nbsp;{$iv.manifiesto}</td>	   
	   <td align="justify">&nbsp;{$iv.remesas}</td>
	   <td align="justify">&nbsp;{$iv.ultimo_error_reportando_ministario}</td>      
	   <td align="justify">&nbsp;<a href="{$iv.path_xml_informacion_viaje}" target="_blank">XML</a></td>   
       <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  	  	
	   <td align="justify">&nbsp;
	    <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	     <input type="hidden" name="ACTIONCONTROLER"            value="sendInformacionViaje" />
		 <input type="hidden" name="reconstruir"                value="" />		  		  		 
	     <input type="hidden" name="manifiesto_id"              value="{$iv.manifiesto_id}" />
	     <input type="hidden" name="path_xml_informacion_viaje" value="{$iv.path_xml_informacion_viaje}" />	  
	     <input type="submit" name="enviar" id="enviar" value="Enviar >" />
	    </form>
	   </td>	 
	   </tr>  	
      {/foreach}	     
	  
	  </tbody>	  
	</table>	
	
 {/if} 

 {if count($MANIFIESTOS2) > 0}
     <br />
	 <table align="center" border="1" width="95%">
	  <thead>
	  <tr align="center">	   
	   <th>REMESA</th>
	   <th>ERROR REMESA</th>
	   <th>ARCHIVO XML</th>   
       <th>RECONSTRUIR XML</th>						   
       <th>&nbsp;</th>	   
	  </tr>
	  </thead>	  
	  <tbody>
	  
      {foreach name=remesas from=$MANIFIESTOS2 item=rm}
	   <tr>   
	   <td align="justify">&nbsp;{$rm.numero_remesa}</td>
	   <td align="justify">&nbsp;{$rm.ultimo_error_reportando_ministario2}</td>      
	   <td align="justify">&nbsp;<a href="{$rm.path_xml_remesa}" target="_blank">XML</a></td>   
       <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  	  	
	   <td align="justify">&nbsp;
	    <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	     <input type="hidden" name="ACTIONCONTROLER"    value="sendInformacionRemesa" />
	     <input type="hidden" name="reconstruir"        value="" />		  		  		 
	     <input type="hidden" name="manifiesto_id"      value="{$rm.manifiesto_id}" />		 
	     <input type="hidden" name="remesa_id"          value="{$rm.remesa_id}" />
	     <input type="hidden" name="path_xml_remesa"    value="{$rm.path_xml_remesa}" />	  
	     <input type="submit" name="enviar" id="enviar" value="Enviar >" />
	    </form>
	   </td>	 
	   </tr>  	
	  {/foreach}
	    
	  </tbody>	  
	</table>	  
	
 {/if} 

 {if count($MANIFIESTOS3) > 0}
     <br />
	 <table align="center" border="1" width="95%">
	  <thead>
	  <tr align="center">
	   <th>MANIFIESTO</th>	   
	   <th>REMESA(S)</th>
	   <th>ERROR MANIFIESTO</th>
	   <th>ARCHIVO XML INFO VIAJE</th>   
       <th>RECONSTRUIR XML</th>						   
       <th>&nbsp;</th>	   
	  </tr>
	  </thead>	  
	  <tbody>
	  
      {foreach name=manifiestos from=$MANIFIESTOS3 item=mf}
	   <tr>
	   <td align="justify">&nbsp;{$mf.manifiesto}</td>	   
	   <td align="justify">&nbsp;{$mf.remesas}</td>
	   <td align="justify">&nbsp;{$mf.ultimo_error_reportando_ministario3}</td>      
	   <td align="justify">&nbsp;<a href="{$mf.path_xml_manifiesto}" target="_blank">XML</a></td>   
       <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  	  	
	   <td align="justify">&nbsp;
	    <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	     <input type="hidden" name="ACTIONCONTROLER"     value="sendInformacionManifiesto" />
		 <input type="hidden" name="reconstruir"         value="" />		  		  		 
	     <input type="hidden" name="manifiesto_id"       value="{$mf.manifiesto_id}" />
	     <input type="hidden" name="path_xml_manifiesto" value="{$mf.path_xml_manifiesto}" />	  
	     <input type="submit" name="enviar" id="enviar"  value="Enviar >" />
	    </form>
	   </td>	 
	   </tr>  	
	  {/foreach}
	    
	  </tbody>	  
	</table>	  
	
 {/if}
 </div>
</body>
</html>
