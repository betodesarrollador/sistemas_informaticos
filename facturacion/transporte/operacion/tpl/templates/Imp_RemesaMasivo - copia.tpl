<html>
 <head>
   {$CSSSYSTEM}
   {$JAVASCRIPT}
   <title>Impresion Remesas</title>
 </head>
 
 <body>
  {assign var="cont" value="0"}
  {foreach name=remesas from=$DATOSREMESAS item=r}
	<table  border="0" width="95%" align="center">
	  <tr>
        <td align="center" colspan="4"> 
		  <table border="0" width="100%" align="center">
		    <tr>
				<td width="30%" align="left" >&nbsp;</td>
				<td width="40%" ><div class="title">{$r.empresa}</div></td>
				<td width="30%" align="right"><img src="{$r.logo}" width="200" height="50" /></td>
			</tr>
		  </table>
		</td>
	  </tr>
	  <tr>
		<td colspan="4" class="general">N.I.T: {$r.numero_identificacion}</td>
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
              <td width="53%" align="left"><div id="bcTarget">{$REMESACODBAR}</div></td>
              <td width="47%">RESOLUCION HABILITACION N&deg; {$r.resolucion_habilitacion} del {$r.fecha_habilitacion}<br>
               RANGOS AUTORIZADOS del {$r.rango_manif_ini} al {$r.rango_manif_fin}<br>
               FECHA: {$FECHA} 
              </td>
             </tr>
            </table>
           </td>
          </tr>
	  <tr>
	    <td colspan="4" align="center"><table width="97%" border="0" align="center">
          <tr>
            <td width="9%"><label>Origen:</label></td>
            <td width="34%"> {$r.origen} </td>
            <td width="15%"><label>Destino :</label></td>
            <td width="42%"> {$r.destino} </td>
          </tr>
          <tr>
            <td><label>Remitente: </label></td>
            <td>{$r.remitente} </td>
            <td><label>Destinatario : </label></td>
            <td>{$r.destinatario} </td>
          </tr>
          <tr>
            <td><label>Direccion :</label></td>
            <td> {$r.direccion_remitente} </td>
            <td><label>Direccion : </label></td>
            <td>{$r.direccion_destinatario} </td>
          </tr>
          <tr>
            <td><label>Telefono : </label></td>
            <td>{$r.telefono_remitente} </td>
            <td><label>Telefono : </label></td>
            <td>{$r.telefonio_destinatario} </td>
          </tr>
          <tr>
            <td><label>Planilla : </label></td>
            <td>{$r.planilla} </td>
            <td><label>Conductor : </label></td>
            <td>{$r.conductor} </td>
          </tr>		  
          <tr>
            <td><label>Observaci&oacute;n : </label></td>
            <td>{$r.observaciones} </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>		  

        </table>
	   </td>
      </tr>
	  <tr>
	    <td colspan="4">
		<table  border="0" width="97%" align="center" class="producto">
		 <thead>
          <tr align="center">
            <th class="productocelllefttop">Codigo</th>
            <th class="productocellrighttop">Descripcion</th>
            <th class="productocellrighttop">Naturaleza</th>
            <th class="productocellrighttop">U. Empaque </th>
            <th class="productocellrighttop">U. Medida </th>
            <th class="productocellrighttop">Cantidad</th>
           </tr>
		  </thead>
		  <tbody>
          <tr align="center">
            <td class="productocellleftbottom">{$r.codigo}</td>
            <td class="productocellrightbottom">{$r.descripcion_producto}</td>
            <td class="productocellrightbottom">{$r.naturaleza}</td>
            <td class="productocellrightbottom">{$r.empaque}</td>
            <td class="productocellrightbottom">{$r.medida}</td>
            <td class="productocellrightbottom">{$r.cantidad}</td>
            </tr>
		  </tbody>
        </table></td>
      </tr>
	  <tr>
	    <td colspan="4">&nbsp;</td>
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
            <td class="firmas"><hr width="80%" />EMPRESA</td>
            <td class="firmas"><hr width="80%" />CONDUCTOR</td>
            <td class="firmas"><hr width="80%" />RECIBE</td>
          </tr>
        </table></td>
      </tr>
	  <tr>
	    <td colspan="4">&nbsp;</td>
      </tr>	  
	  <tr>
	    <td colspan="4"><table width="90%" border="0" align="center">
          <tr>
            <td>Elabora por : {$USUARIO}</td>
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