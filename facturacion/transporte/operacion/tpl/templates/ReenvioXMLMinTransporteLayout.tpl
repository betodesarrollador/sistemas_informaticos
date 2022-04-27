{if $REPORTE eq 'SI'}
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
	  <td align="left">&nbsp;{$c.conductor}</td>
	  <td align="justify">&nbsp;{$c.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$c.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$c.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendConductorMintransporte" />
          <input type="hidden" name="tipo"    			 value="CONDUCTOR" />
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
	  <td align="left">&nbsp;{$p.propietario}</td>
	  <td align="justify">&nbsp;{$p.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$p.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$p.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendPropietarioMintransporte" />
          <input type="hidden" name="tipo"    			 value="PROPIETARIOS" />
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
	  <td align="left">&nbsp;{$tn.tenedor}</td>
	  <td align="justify">&nbsp;{$tn.fecha_error_reportando_ministerio}</td>
	  <td align="justify">&nbsp;{$tn.ultimo_error_reportando_ministario}</td>
	  <td align="justify">&nbsp;<a href="{$tn.path_xml}" target="_blank">XML</a></td>
	  <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  
	  <td align="justify">&nbsp;
		 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
		  <input type="hidden" name="ACTIONCONTROLER"    value="sendTenedorMintransporte" />
          <input type="hidden" name="tipo"    			 value="TENEDORES" />
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
          <input type="hidden" name="tipo"    			 value="REMOLQUES" />
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
          <input type="hidden" name="tipo"    			 value="VEHICULOS" />
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
          <input type="hidden" name="tipo"    			 value="CLIENTES" />
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
          <input type="hidden" name="tipo"    			 value="REMITENTES" />
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
          <input type="hidden" name="tipo"    			 value="DESTINATARIOS" />
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

 {if count($REMESAS) > 0}
 <br/>
 <table align="center" border="1" width="95%">
 <thead>
  <tr align="center">
   <th>REMESA</th>
   <th>FECHA ULTIMO REPORTE</th>
   <th>ERROR </th>
   <th>ARCHIVO XML</th>
   <th>RECONSTRUIR XML</th>						   
   <th>&nbsp;</th>
  </tr>
  </thead>
  
  {foreach name=remesa from=$REMESAS item=i}
   <tr>
    <td align="justify">&nbsp;{$i.numero_remesa}</td>
	<td align="justify">&nbsp;{$i.fecha_error_reportando_ministerio2}</td>
	<td align="justify">&nbsp;{$i.ultimo_error_reportando_ministario2}</td>
	<td align="justify">&nbsp;<a href="{$i.path_xml_remesa}" target="_blank">XML</a></td>
    <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  	  	
	<td align="justify">&nbsp;
	 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	  <input type="hidden" name="ACTIONCONTROLER"            value="sendInformacionRemesa" />
      <input type="hidden" name="tipo"    			 value="REMESAS" />
	  <input type="hidden" name="reconstruir"                value="" />		  		  	  
	  <input type="hidden" name="remesa_id"                  value="{$i.remesa_id}" />
      <input type="hidden" name="manifiesto_id"       value="{$i.manifiesto_id}" />
	  <input type="hidden" name="path_xml_remesa" value="{$i.path_xml_remesa}" />	  
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
	   <th>MANIFIESTO</th>
       <th>FECHA ULTIMO REPORTE</th>
	   <th>ERROR</th>
	   <th>ARCHIVO XML</th>   
       <th>RECONSTRUIR XML</th>						   
       <th>&nbsp;</th>	   
	  </tr>
	  </thead>	  
	  <tbody>
	  
      {foreach name=remesas from=$MANIFIESTOS item=rm}
	   <tr>   
	   <td align="justify">&nbsp;{$rm.manifiesto}</td>
       <td align="justify">&nbsp;{$rm.fecha_error_reportando_ministerio2}</td>
	   <td align="justify">&nbsp;{$rm.ultimo_error_reportando_ministario2}</td>      
	   <td align="justify">&nbsp;<a href="{$rm.path_xml_manifiesto}" target="_blank">XML</a></td>   
       <td align="center">&nbsp;<input type="checkbox" checked  name="reconstruirXML" value="" /></td>	  	  	  	  	  	  	  	
	   <td align="justify">&nbsp;
	    <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	     <input type="hidden" name="ACTIONCONTROLER"    value="sendInformacionManifiesto" />
         <input type="hidden" name="tipo"    			 value="MANIFIESTOS" />
	     <input type="hidden" name="reconstruir"        value="" />		  		  		 
	     <input type="hidden" name="manifiesto_id"      value="{$rm.manifiesto_id}" />		 
	     <input type="hidden" name="path_xml_manifiesto"    value="{$rm.path_xml_manifiesto}" />	  
	     <input type="submit" name="enviar" id="enviar" value="Enviar >" />
	    </form>
	   </td>	 
	   </tr>  	
	  {/foreach}
	    
	  </tbody>	  
	</table>	  
	
 {/if} 

 {if count($CUMREMESAS) > 0}
 <br/>
 <table align="center" border="1" width="95%">
 <thead>
  <tr align="center">
   <th>REMESA</th>
   <th>FECHA REMESA</th>
   <th>FECHA ULTIMO REPORTE</th>
   <th>ERROR </th>
   <th>&nbsp;</th>
  </tr>
  </thead>
  
  {foreach name=remesa from=$CUMREMESAS item=i}
   <tr>
    <td align="justify">&nbsp;{$i.numero_remesa}</td>
	<td align="justify">&nbsp;{$i.fecha_remesa}</td>
    <td align="justify">&nbsp;{$i.fecha_error_reportando_ministerio3}</td>
	<td align="justify">&nbsp;{$i.ultimo_error_reportando_ministario3}</td>
	<td align="justify">&nbsp;
	 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	  <input type="hidden" name="ACTIONCONTROLER"            value="sendInformacionCumRemesa" />
      <input type="hidden" name="tipo"    			 value="CUMREMESAS" />
	  <input type="hidden" name="reconstruir"                value="" />		  		  	  
	  <input type="hidden" name="remesa_id"                  value="{$i.remesa_id}" />
	  <input type="hidden" name="path_xml_remesa" value="{$i.path_xml_remesa}" />	  
	  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
	 </form>
	</td>	 
   </tr>  
  {/foreach}
 </table>
 {/if}

 {if count($CUMMANIFIESTOS) > 0}
     <br />
	 <table align="center" border="1" width="95%">
	  <thead>
	  <tr align="center">
	   <th>MANIFIESTO</th>	
       <th>FECHA MANIFIESTO</th>   
       <th>FECHA ULTIMO REPORTE</th>   
	   <th>ERROR</th>
       <th>&nbsp;</th>	   
	  </tr>
	  </thead>	  
	  <tbody>
	  
      {foreach name=manifiestos from=$CUMMANIFIESTOS item=mf}
	   <tr>
	   <td align="justify">&nbsp;{$mf.manifiesto}</td>
        <td align="justify">&nbsp;{$mf.fecha_mc}</td>	   
        <td align="justify">&nbsp;{$mf.fecha_error_reportando_ministerio3}</td>	   
	    <td align="justify">&nbsp;{$mf.ultimo_error_reportando_ministario3}</td>      
 
	   <td align="justify">&nbsp;
	    <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	     <input type="hidden" name="ACTIONCONTROLER"     value="sendInformacionCumManifiesto" />
         <input type="hidden" name="tipo"    			 value="CUMMANIFIESTOS" />
		 <input type="hidden" name="reconstruir"         value="" />		  		  		 
	     <input type="hidden" name="manifiesto_id"       value="{$mf.manifiesto_id}" />
	     <input type="hidden" name="liquidacion_despacho_id"       value="{$mf.liquidacion_despacho_id}" />         
	     <input type="submit" name="enviar" id="enviar"  value="Enviar >" />
	    </form>
	   </td>	 
	   </tr>  	
	  {/foreach}
	    
	  </tbody>	  
	</table>	  
	
 {/if}

 {if count($CUMMANIFIESTOSPRO) > 0}
     <br />
	 <table align="center" border="1" width="95%">
	  <thead>
	  <tr align="center">
	   <th>MANIFIESTO</th>	
       <th>FECHA MANIFIESTO</th>   
       <th>FECHA ULTIMO REPORTE</th>   
	   <th>ERROR</th>
       <th>&nbsp;</th>	   
	  </tr>
	  </thead>	  
	  <tbody>
	  
      {foreach name=manifiestos from=$CUMMANIFIESTOSPRO item=mf}
	   <tr>
	   <td align="justify">&nbsp;{$mf.manifiesto}</td>
        <td align="justify">&nbsp;{$mf.fecha_mc}</td>	   
        <td align="justify">&nbsp;{$mf.fecha_error_reportando_ministerio3}</td>	   
	    <td align="justify">&nbsp;{$mf.ultimo_error_reportando_ministario3}</td>      
 
	   <td align="justify">&nbsp;
	    <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	     <input type="hidden" name="ACTIONCONTROLER"     value="sendInformacionCumManifiestoPropio" />
         <input type="hidden" name="tipo"    			 value="CUMMANIFIESTOSPRO" />
		 <input type="hidden" name="reconstruir"         value="" />		  		  		 
	     <input type="hidden" name="manifiesto_id"       value="{$mf.manifiesto_id}" />
	     <input type="submit" name="enviar" id="enviar"  value="Enviar >" />
	    </form>
	   </td>	 
	   </tr>  	
	  {/foreach}
	    
	  </tbody>	  
	</table>	  
	
 {/if}




 {if count($ANUREMESAS) > 0}
 <br/>
 <table align="center" border="1" width="95%">
 <thead>
  <tr align="center">
   <th>REMESA</th>
   <th>FECHA REMESA</th>
   <th>FECHA ULTIMO REPORTE</th>
   <th>ERROR </th>
   <th>&nbsp;</th>
  </tr>
  </thead>
  
  {foreach name=remesa from=$ANUREMESAS item=i}
   <tr>
    <td align="justify">&nbsp;{$i.numero_remesa}</td>
	<td align="justify">&nbsp;{$i.fecha_remesa}</td>
    <td align="justify">&nbsp;{$i.fecha_error_anulando_ministerio}</td>
	<td align="justify">&nbsp;{$i.ultimo_error_anulando_ministario}</td>
	<td align="justify">&nbsp;
	 <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	  <input type="hidden" name="ACTIONCONTROLER"            value="sendInformacionAnulRemesa" />
      <input type="hidden" name="tipo"    			 value="ANUREMESAS" />
	  <input type="hidden" name="remesa_id"          value="{$i.remesa_id}" />
      <input type="hidden" name="numero_remesa"      value="{$i.numero_remesa}" />
      <input type="hidden" name="causal_anulacion_id" value="{$i.causal_anulacion_id}" />
	  <input type="submit" name="enviar" id="enviar" value="Enviar >" />
	 </form>
	</td>	 
   </tr>  
  {/foreach}
 </table>
 {/if}

 {if count($ANUMANIFIESTOS) > 0}
     <br />
	 <table align="center" border="1" width="95%">
	  <thead>
	  <tr align="center">
	   <th>MANIFIESTO</th>	
       <th>FECHA MANIFIESTO</th>   
       <th>FECHA ULTIMO REPORTE</th>   
	   <th>ERROR</th>
       <th>&nbsp;</th>	   
	  </tr>
	  </thead>	  
	  <tbody>
	  
      {foreach name=manifiestos from=$ANUMANIFIESTOS item=mf}
	   <tr>
	   <td align="justify">&nbsp;{$mf.manifiesto}</td>
        <td align="justify">&nbsp;{$mf.fecha_mc}</td>	   
        <td align="justify">&nbsp;{$mf.fecha_error_anulando_ministerio}</td>	   
	    <td align="justify">&nbsp;{$mf.ultimo_error_anulando_ministario}</td>      
 
	   <td align="justify">&nbsp;
	    <form action="ReenvioXMLMinTransporteClass.php" method="POST" onsubmit="return deshabilitaBoton(this)" >
	     <input type="hidden" name="ACTIONCONTROLER"     value="sendInformacionAnulManifiesto" />
         <input type="hidden" name="tipo"    			 value="ANUMANIFIESTOS" />
	     <input type="hidden" name="manifiesto_id"       value="{$mf.manifiesto_id}" />
	     <input type="hidden" name="manifiesto"       	 value="{$mf.manifiesto}" />
	     <input type="hidden" name="causal_anulacion_id" value="{$mf.causal_anulacion_id}" />
  
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

{else}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Reenvio XML MinTransporte</title>
{$CSSSYSTEM} {$JAVASCRIPT}
</head>

<body>

 <div align="center">
 <fieldset>
     <legend>
        <img src="../media/images/forms/operacion.png" height="45">
        <img src="../media/images/forms/reenvio.png" height="45">
    </legend>

 <fieldset class="section">
 	<table width="40%">
    	<tr>
        	<td><label>Tipo</label></td>
            <td>
                 <select name="tipo" id="tipo" >
                    <option value="">SELECCIONE</option>
                    <option value="CONDUCTOR">CONDUCTOR</option>
                    <option value="PROPIETARIOS">PROPIETARIOS</option>
                    <option value="TENEDORES">TENEDORES</option>
                    <option value="REMOLQUES">REMOLQUES</option>
                    <option value="VEHICULOS">VEHICULOS</option>    
                    <option value="CLIENTES">CLIENTES</option>  
                    <option value="REMITENTES">REMITENTES</option>        
                    <option value="DESTINATARIOS">DESTINATARIOS</option>  
                    <option value="REMESAS">REMESAS</option>      
                    <option value="MANIFIESTOS">MANIFIESTOS</option>        
                    <!--<option value="CUMREMESAS">CUMPLIDOS REMESAS</option>-->      
                    <option value="CUMMANIFIESTOS">CUMPLIDOS MANIFIESTOS NO PROPIOS</option>
                    <option value="CUMMANIFIESTOSPRO">CUMPLIDOS MANIFIESTOS PROPIOS</option>        
                    <option value="ANUREMESAS">REMESAS ANULADAS</option>      
                    <option value="ANUMANIFIESTOS">MANIFIESTOS ANULADOS</option>        
                    
                 </select>
           </td>
		    <td>&emsp;&emsp;&emsp;</td>
            <td><input type="button" id="report_all" value="REPORTAR BASES" class="btn btn-success" onclick="reportarBases()"></td>
		</tr>
	</table>                   
 </fieldset>
 <fieldset class="section">
 	<iframe name="frameResult" id="frameResult" src="" height="480px"></iframe>
 
 </fieldset>
 
 </fieldset>
 </div>
</body>
</html>


{/if}