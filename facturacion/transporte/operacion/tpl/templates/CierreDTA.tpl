<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}
  {$TABLEGRIDCSS}
  {$TITLETAB}
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>
        
        {$FORM1}{$DTAID}

	     <table width="100%" border="0" align="center">
          <tr>
		    <td>
		     <fieldset class="section">
		      <legend>Apertura DTA</legend>			
			  <table align="center">
				  <tr>
					<td><label>N. Formulario :</label></td>
					<td>{$NUMEROFORMULARIO}</td>
					<td><label>Manifiesto Carga:</label></td>
					<td>{$MANIFIESTOCARGA}</td>
					<td><label>Despacho Urbano  :</label></td>
					<td>{$DESPACHOURBANO}</td>
				  </tr>
				  <tr><td colspan="6">&nbsp;</td></tr>				  
				  <tr>
					<td><label>Cliente :</label></td>
					<td>{$CLIENTE}{$CLIENTEID}</td>
					<td><label>Fecha Consignacion :</label></td>
					<td>{$FECHACONSIGNACION}</td>
					<td><label>Fecha Entrega :</label></td>
					<td>{$FECHAENTREGADTA}</td>
				  </tr>				  
				  <tr>
					<td><label>N. Contenedor :</label></td>
					<td>{$NUMEROCONTENEDORDTA}</td>
					<td><label>Naviera :</label></td>
					<td>{$NAVIERA}</td>
					<td><label>Tara :</label></td>
					<td>{$TARA}</td>
				  </tr>
				  <tr>
					<td><label>Tipo :</label></td>
					<td>{$TIPO}</td>
					<td><label>Numero precinto :</label></td>
					<td>{$NUMEROPRECINTO}</td>
					<td><label>Cod. Producto :</label></td>
					<td>{$CODIGO}</td>
				  </tr>
				  <tr>
					<td><label>Producto : </label></td>
					<td>{$PRODUCTO}{$PRODUCTOID}</td>
					<td><label>Peso :</label></td>
					<td>{$PESO}</td>
					<td><label>Responsable DIAN :</label></td>
					<td>{$RESPONSABLEDIAN}</td>
				  </tr>
				  <tr>
					<td><label>Responsable Empresa :</label></td>
					<td>{$RESPONSABLEEMPRESA}</td>
					<td><label>Observaciones :</label></td>
					<td>{$OBSERVACIONES}</td>
					<td><label>Estado : </label></td>
					<td>{$ESTADODTA}</td>
                </tr>	
				<tr>
				  <td colspan="6"><table width="100%" align="center" id="imagenesDTA">
                    <tr>
                      <td width="16%">&nbsp;</td>
                      <td width="25%"><label><a href="javascript:void(0)" target="_blank" name="imagen_formulario_file" id="imagen_formulario_file">Imagen Formulario</a></label></td>
                      <td width="19%"><label><a href="javascript:void(0)" target="_blank" name="foto_posterior_file" id="foto_posterior_file">Foto Posterior</a></label></td>
                      <td><label><a href="javascript:void(0)" target="_blank" name="foto_lateral_derecha_file" id="foto_lateral_derecha_file">Foto Lateral Derecha</a></label></td>
                      <td width="24%"><label></label></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><label><a href="javascript:void(0)" target="_blank" name="foto_lateral_izquierda_file" id="foto_lateral_izquierda_file">Foto Lateral Izquierda</a></label></td>
                      <td><label><a href="javascript:void(0)" target="_blank" name="foto_anterior_file" id="foto_anterior_file">Foto Anterior</a></label></td>
                      <td width="16%"><label><a href="javascript:void(0)" target="_blank" name="foto_precinto_file" id="foto_precinto_file">Foto precinto</a></label></td>
                      <td width="24%">&nbsp;</td>
                    </tr>
                  </table></td>
				</tr>		  
			  </table>
       	      </fieldset>
			</td>
		  </tr>
          <tr>
            <td  align="center">&nbsp;</td>
          </tr>
          <tr>
		    <td  align="center">
			<fieldset class="section">
			 <legend>Cierre DTA</legend>
			  <table align="center" width="80%">
				  <tr>
					<td align="left"><label>Fecha Cierre : </label></td>
					<td align="left">{$FECHACIERRE}</td>
					<td align="left"><label>Zona Franca : </label></td>
					<td colspan="3" align="left">{$ZONASFRANCASID}</td>
			    </tr>
				  <tr>
					<td ><label>Responsable DIAN entrega :</label></td>
					<td >{$RESPONSABLEDIANENTREGA}</td>
					<td ><label>Responsable Empresa Entrega : </label></td>
					<td colspan="3" align="left">{$RESPONSABLEEMPRESAENTREGA}</td>
			    </tr>
				  <tr>
					<td><label>Novedades : </label></td>
					<td>{$NOVEDADES}</td>
					<td><label>Imagen Prueba Entrega : </label></td>
					<td colspan="3" align="left">{$IMAGENPRUEBAENTREGA}</td>
			    </tr>			  
			  </table>
			  </fieldset>
			</td>
		  </tr>
        </table>
	    <div align="center" id="divToolBarButtons">&nbsp;{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</div>		
    {$FORM1END}	

     <div align="center">{$GRIDDTA}</div>
  </body>
</html>
