<html>
 <head>


  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   {$CSSSYSTEM}
   {$JAVASCRIPT}
   <title>Impresion Manifiesto</title>
    {literal}&nbsp;
    <style>
    
       .anulado{
          color:#003366;
          font-size:70px;
       }	
        
    </style>
    
    {/literal}
   
 </head>
 
 <body>
  {assign var="cont" value="0"}
  {foreach name=guias from=$DATOSREXPEDIDO item=r}
  	{if $r.estado eq 'A'}
    	<div style="position:absolute; top:120px; left:92px" class="anulado">MANIFIESTO ANULADO</div>
    {/if}
	<table  border="0" width="95%" align="center">
	  <tr>
        <td align="center" colspan="4"> 
		  <table border="0" width="100%" align="center">
		    <tr>
				<td width="30%" align="left" ><img src="{$r.logo}" width="200" height="80" /></td>
				<td width="40%" ><div class="title">{$r.nombre_empresa}</div></td>
				<td width="30%" align="right">&nbsp;</td>
			</tr>
		  </table>
		</td>
	  </tr>
	  <tr>
		<td colspan="4" class="general">Documento: {$r.id_empresa}</td>
	  </tr>
	  <tr>
		<td colspan="4" class="general">OFICINA {$r.oficina} - {$r.direccion} </td>
	  </tr>
	  <tr>
		<td colspan="4" class="general">{$r.ciudad}</td>
	  </tr>
	  <tr><td colspan="4">&nbsp;</td></tr>
	  
	  <tr>
	    <td colspan="4">
	    <table width="100%" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td width="53%" height="52" align="left"><div class="title" style="font-size:16px">MANIFIESTO NO.&nbsp;&nbsp;{$r.reexpedido}</div></td>
              <td width="47%" align="left"><div class="title" style="font-size:16px">FECHA:&nbsp;&nbsp;{$r.fecha_rxp}</div></td>
        </tr>
            </table>
           </td>
          </tr><br><br>
	  <tr>
	    <td colspan="4" align="center"><table width="97%" border="0" align="center">
          <tr>
            <td width="14%"><label>Mensajero&nbsp;:</label></td>
            <td colspan="3"> {$r.proveedor} </td>
          </tr>
          <tr>
            <td><label>Identificacion&nbsp;: </label></td>
            <td width="37%">{$r.identificacion} </td>
            <td width="10%"><label>Telefono&nbsp;: </label></td>
            <td width="39%">{$r.telefono} - {$r.movil}</td>
          </tr>
          <tr>
            <td><label>Direccion : </label></td>
            <td>{$r.direccion} </td>
            <td><label>Ciudad : </label></td>
            <td>{$r.ciudad_reexpedidor}</td>
          </tr>
          <tr>
          	<td><label>Origen :</label></td>
          	<td>{$r.origen}</td>
            <td><label>Destino :</label></td>
            <td>{$r.destino}
          </tr>
           <tr>
            <td><label>Hora salida :</label></td>
            <td>{$r.hora_salida}
          	<td><label>Interno :</label></td>
          	<td>{$r.interno}</td>
          </tr>
           <tr>
            <td><label>Observaci&oacute;n :</label></td>
            <td colspan="3">{$r.obser_rxp}
          </tr>
          
         </table>
	   </td>
      </tr>
       <tr>
      	<td>&nbsp;</td>
      </tr>
      <tr>
      	<td><b>GUIAS</b></td>
      </tr>
	  <tr>
	    <td colspan="4">
		<table  border="0" width="97%" align="center" class="producto">
		 <thead>
          <tr align="center">
            <th class="productocelllefttop">Guia</th>
            <th class="productocellrighttop">Cantidad</th>
            <th class="productocellrighttop">Producto</th>
            <th class="productocellrighttop">Remitente</th>
            <th class="productocellrighttop">Destino </th>
            <th class="productocellrighttop">Destinatario</th>      
            <th class="productocellrighttop">Direcci&oacute;n</th>            
            <th class="productocellrighttop">Fecha</th>
           </tr>
		  </thead>
		  <tbody>
           {foreach name=imputaciones from=$DETALLES item=i}        
                <tr align="center">
                    <td class="productocellleftbottom" align="left">{$i.numero_guia}</td>
                    <td class="productocellrightbottom">{$i.cantidad}</td>
                    <td class="productocellrightbottom">{$i.descripcion_producto}</td>
                    <td class="productocellrightbottom">{$i.remitente}</td>
                    <td class="productocellrightbottom">{$i.destino}</td>
                    <td class="productocellrightbottom">{$i.destinatario}</td>            
                    <td class="productocellrightbottom">{$i.direccion_destinatario}</td>            
                    <td class="productocellrightbottom">{$i.fecha_guia}</td>
                </tr>
            {/foreach}
           {foreach name=imputaciones from=$DETALLES2 item=j}        
                <tr align="center">
                    <td class="productocellleftbottom" align="left">{$j.numero_guia}</td>
                    <td class="productocellrightbottom">{$j.cantidad}</td>
                    <td class="productocellrightbottom">{$j.descripcion_producto}</td>
                    <td class="productocellrightbottom">{$j.remitente}</td>
                    <td class="productocellrightbottom">{$j.destino}</td>
                    <td class="productocellrightbottom">{$j.destinatario}</td>            
                    <td class="productocellrightbottom">{$j.direccion_destinatario}</td>            
                    <td class="productocellrightbottom">{$j.fecha_guia}</td>
                </tr>
            {/foreach}
            
            <tr>
                <td class="productocellleftbottom" colspan="3">TOTAL GUIAS MENSAJERIA</td>
                <td class="productocellleftbottom">{$DETALLES|@count}</td>
                <td class="productocellleftbottom" colspan="3">TOTAL GUIAS ENCOMIENDA</td>
                <td class="productocellleftbottom">{$DETALLES2|@count}</td>
                
            </tr>            
             
		  </tbody>
        </table></td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
      </tr>
     <!-- <tr>
      	<td><b>GUIAS INTERCONEXI&Oacute;N</b></td>
      </tr>
	  <tr>
	    <td colspan="4">
		<table  border="0" width="97%" align="center" class="producto">
		 <thead>
          <tr align="center">
            <th class="productocelllefttop">Guia</th>
            <th class="productocellrighttop">Tipo</th>
            <th class="productocellrighttop">Producto</th>
            <th class="productocellrighttop">Remitente</th>
            <th class="productocellrighttop">Destino </th>
            <th class="productocellrighttop">Destinatario</th>      
            <th class="productocellrighttop">Direcci&oacute;n</th>            
            <th class="productocellrighttop">Fecha</th>
           </tr>
		  </thead>
		  <tbody>
           {foreach name=imputaciones from=$DETALLES1 item=i}        
          <tr align="center">
            <td class="productocellleftbottom">{$i.numero_guia}</td>
            <td class="productocellrightbottom">{$i.tipo_mensajeria}</td>
            <td class="productocellrightbottom">{$i.descripcion_producto}</td>
            <td class="productocellrightbottom">{$i.remitente}</td>
            <td class="productocellrightbottom">{$i.destino}</td>
            <td class="productocellrightbottom">{$i.destinatario}</td>            
            <td class="productocellrightbottom">{$i.direccion_destinatario}</td>            
              <td class="productocellrightbottom">{$i.fecha_guia}</td>
            </tr>
             {/foreach}
            <tr>
                <td colspan="2">TOTAL GUIAS</td>
                <td>{$DETALLES1|@count}</td>
            </tr>  -->     
	  <tr>
	    <td height="47" colspan="4">&nbsp;</td>
      </tr>  
	  <tr>
	    <td colspan="4">
		<table width="80%" border="0" align="center">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr align="center">
            <td class="firmas"><hr width="80%" />APROBO</td>
            <td class="firmas"><hr width="80%" />REVISO</td>
          </tr>
        </table></td>
      </tr>
	  <tr>
	    <td colspan="4">&nbsp;</td>
      </tr>	  
	  <tr>
	    <td colspan="4"><table width="90%" border="0" align="center">
          <tr>
            <td>Elaborado por : {$r.usuario_registra}</td>
          </tr>
        </table></td>
      </tr>
	</table>
	<br><br><br><br><br><br>
    {assign var=cont value=$cont+1}


	{if $cont eq 2} {assign var="cont" value="0"}	<br class="saltopagina" /> {/if}
	
  {/foreach}
</body>
</html>
