<html>
 <head>
   <title>Impresion DTA</title>
 </head>
 <body>
  
    <div style="border:1px solid; width:90%;margin-left:40px; margin-top:40px; margin-bottom:30px; margin-right:30px" align="center">
	 <fieldset class="section">
	 <table align="center" border="0" width="70%">
	    <tr>
	      <td colspan="4" align="center" style="height:50px"><b>IMPRESION DTA</b></td>
        </tr>	 
        <tr>
          <td width="12%" align="right" bgcolor="#F3F3F3"><div align="left"><b></b></div><b><label >
            <div align="left">Cliente :  </div>
          </label></b></td>
          <td width="36%">{$DTA.cliente}</td>
          <td width="13%" align="right" bgcolor="#F3F3F3"><b>
          <div align="left"><b>Fecha</b></div></td>
          <td width="39%"><div align="left"><b>
          <label></label>
          </b>{$FECHA} </div></td>
        </tr>		 
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">N. Formulario </div>
          </label></b></td>
          <td width="36%">{$DTA.numero_formulario}</td>
          <td bgcolor="#F3F3F3" align="right"><b>
          <div align="left">Fecha Consignacion </div></td>
          <td width="39%"><div align="left">{$DTA.fecha_consignacion}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Fecha Entrega </div>
          </label></b></td>
          <td>{$DTA.fecha_entrega_dta}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">N. Contenedor </div>
          </label></b></td>
          <td><div align="left">{$DTA.numero_contenedor_dta}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Naviera </div>
          </label></b></td>
          <td>{$DTA.naviera}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Tara </div>
          </label></b></td>
          <td><div align="left">{$DTA.tara}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><b>
          <div align="left">Tipo </div></td>
          <td>{$DTA.tipo}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Numero precinto </div>
          </label></b></td>
          <td><div align="left">{$DTA.numero_precinto}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Cod. Producto </div>
          </label></b></td>
          <td>{$DTA.codigo}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Producto  </div>
          </label></b></td>
          <td><div align="left">{$DTA.producto}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Peso </div>
          </label></b></td>
          <td>{$DTA.peso}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Responsable DIAN </div>
          </label></b></td>
          <td><div align="left">{$DTA.responsable_dian}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Responsable Empresa </div>
          </label></b></td>
          <td>{$DTA.responsable_empresa}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Observaciones </div>
          </label></b></td>
          <td><div align="left">{$DTA.observaciones_dta}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Estado  </div>
          </label></b></td>
          <td>{$DTA.estado_dta}</td>
          <td bgcolor="#F3F3F3" align="right"><b>
          <div align="left">Fecha Cierre  </div></td>
          <td><div align="left">{$DTA.fecha_cierre}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Zona Franca  </div>
          </label></b></td>
          <td>{$DTA.zonas_francas_id}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Responsable DIAN entrega </div>
          </label></b></td>
          <td><div align="left">{$DTA.responsable_dian_entrega}</div></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Responsable Empresa Entrega  </div>
          </label></b></td>
          <td>{$DTA.responsable_empresa_entrega}</td>
          <td bgcolor="#F3F3F3" align="right"><div align="left"><b></b></div>            <b><label >
            <div align="left">Novedades  </div>
          </label></b></td>
          <td><div align="left">{$DTA.novedades}</div></td>
        </tr>
     </table>
	 </fieldset>
     <br>
 	 <fieldset class="section">	
	  <table align="center" style="padding-top:20px; border:1px solid">
	    <tr align="center" bgcolor="#F3F3F3"><td><b>FOTO ANTERIOR</b></td><td><b>FOTO POSTERIOR</b></td></tr>
		<tr>
		  <td align="center" valign="top"><img src="{$DTA.foto_anterior}" width="350" height="200" /></td>
		  <td valign="top"><img src="{$DTA.foto_posterior}" width="350" height="200" /></td>
		</tr>
	    <tr align="center" bgcolor="#F3F3F3"><td><b>FOTO LATERAL DERECHA</b></td><td><b>FOTO LATERAL IZQUIERDA</b></td></tr>		
		<tr>
		  <td valign="top"><img src="{$DTA.foto_lateral_derecha}" width="350" height="200" /></td> 
		  <td valign="top"><img src="{$DTA.foto_lateral_izquierda}" width="350" height="200" /></td>			
		</tr>
	    <tr align="center" bgcolor="#F3F3F3"><td><b>FOTO PRECINTO</b></td><td><b>IMAGEN PRUEBA</b></td></tr>				
		<tr>
		  <td valign="top"><img src="{$DTA.foto_precinto}" width="350" height="200" /></td>
		  <td valign="top"><img src="{$DTA.imagen_prueba_entrega}" width="350" height="200" /></td>
		</tr>
	  </table>
 </fieldset>
</div>

</body>
</html>