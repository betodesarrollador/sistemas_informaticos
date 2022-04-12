<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>

  <body>
    <legend>{$TITLEFORM}</legend>	
  
	<fieldset>

        <div id="table_find">
        <table align="center">
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>
		{$OFICINAIDSTATIC}{$USUARIOIDSTATIC}{$FECHAINGRESOSTAT}
		{$FORM1}
        <table align="center" width="95%">
        	<tr>
            	<td>
                    <fieldset class="section"><legend>Datos del Servicio</legend>
                    <table align="center" width="98%">
                      <tr>
                        <td><label>Seguimiento : </label></td><td>{$SEGUIMIENTOID}{$SERVICIOTRANSPORTE}{$OFICINAID}{$USUARIOID}{$FECHAINGRESO}</td>
                        <td colspan="4">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><label>Fecha :</label></td><td>{$FECHA}</td>
                        <td><label>Estado : </label></td><td>{$ESTADO}{$ESTADO_SEL}</td>
                        <td><label>Tipo : </label></td><td>{$TIPO}</td>
                      </tr>
                      <tr>
                        <td><label> Cliente : </label></td><td>{$CLIENTE}{$CLIENTEID}</td>
                        <td><label> Identificaci&oacute;n : </label></td><td>{$CLIENTENIT}</td>
                        <td><label>Contactos :</label></td>
                        <td>{$CONTACTOS}</td>
                        
                      </tr>
                      <tr>
                        <td><label>Direcci&oacute;n : </label></td><td>{$CLIENTEDIR}</td>
                        <td><label>Tel&eacute;fono :</label></td><td>{$CLIENTETEL}</td>
                        <td><label>M&oacute;vil : </label></td><td>{$CLIENTEMOV}</td>
                      </tr>

                      <tr>
                        <td><label>Origen : </label></td><td>{$ORIGEN}{$ORIGENID}</td>
                        <td><label>Destino : </label></td><td>{$DESTINO}{$DESTINOID}</td>
                        <td colspan="2">&nbsp;</td> 
                      </tr>
                    </table>
                    </fieldset>
				</td>
			</tr>
            <tr>
            	<td>                          
                  <fieldset class="section"> <legend>Datos Vehiculo</legend>
                  <table>
                    <tbody>
                      <tr>
                        <td><label>Placa :</label></td>
                        <td>{$PLACAVEHICULO}{$PLACAVEHICULOID}{$PROPIO}</td>
                        <td><label>Marca :</label></td>
                        <td>{$MARCAVEHICULO}</td>
                        <td><label>Linea :</label></td>
                        <td>{$LINEAVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Modelo :</label></td>
                        <td>{$MODELOVEHICULO}</td>
                        <td><label>Modelo Repotenciado :</label></td>
                        <td>{$MODELOREPOTENCIADOVEHICULO}</td>
                        <td><label>Serie N° :</label></td>
                        <td>{$SERIEVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Color :</label></td>
                        <td>{$COLORVEHICULO}</td>
                        <td><label>Tipo de Carroceria :</label></td>
                        <td>{$CARROCERIAVEHICULO}</td>
                        <td><label>Registro Nal Carga :</label></td>
                        <td>{$REGISTRONALCARGAVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Configuracion :</label></td>
                        <td>{$CONFIGURACIONVEHICULO}</td>
                        <td><label>Peso Vacio :</label></td>
                        <td>{$PESOVACIOVEHICULO}</td>
                        <td><label>Numero Poliza SOAT:</label></td>
                        <td>{$NUMEROSOATVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Compañia de Seguros SOAT:</label></td>
                        <td>{$ASEGURADORASOATVEHICULO}</td>
                        <td><label>Vencimiento SOAT:</label></td>
                        <td>{$VENCIMIENTOSOATVEHICULO}</td>
                        <td><label>Placa Remolque :</label></td>
                        <td>{$REMOLQUE}{$PLACAREMOLQUE}{$PLACAREMOLQUEID}</td>
                      </tr>
                    </tbody>
                  </table>
                  </fieldset>
				</td>
			</tr>
            <tr>
            	<td>
                  <fieldset class="section"> <legend>Datos Conductor</legend>
                  <table align="center">
                    <tbody>
                      <tr>
                        <td><label>Conductor :</label></td>
                        <td>{$NOMBRECONDUCTOR}{$CONDUCTORID}</td>
                        <td><label>Doc Identificacion :</label></td>
                        <td>{$NUMEROIDENTIFICACION}</td>
                        <td><label>Direccion :</label></td>
                        <td>{$DIRECCIONCONDUCTOR}</td>
                      </tr>
                      <tr>
                        <td><label>Telefono :</label></td>
                        <td>{$TELEFONOCONDUCTOR}</td>
                        <td><label>M&oacute;vil :</label></td>
                        <td>{$MOVILCONDUCTOR}</td>
                        <td><label>Correo :</label></td>
                        <td>{$CORREOCONDUCTOR}</td>

                      </tr>
                      <tr>
                        <td><label>Ciudad :</label></td>
                        <td>{$CIUDADCONDUCTOR}</td>
                        <td><label>Catg Licencia :</label></td>
                        <td>{$CATEGORIALICENCIACONDUCTOR}</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>

                    </tbody>
                  </table>
                  </fieldset>
				</td>
			<tr>                                      	                      
            	<td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
            </tr>
      	</table>
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDSeguimiento}</fieldset>
    <div id="divAnulacion">
      <form>
        <table>       
          <tr>
            <td><label>Fecha / Hora :</label></td>
            <td>{$FECHALOG}{$USUARIOANULID}</td>
          </tr>          
          <tr>
            <td><label>Descripcion :</label></td>
            <td>{$OBSERVACIONES}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$ANULAR}</td>
          </tr>                    
        </table>
      </form>
    </div>
    
  </body>
</html>