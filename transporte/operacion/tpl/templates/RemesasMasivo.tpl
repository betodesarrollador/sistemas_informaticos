<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM} 
    {$TABLEGRIDCSS}  
    {$TITLETAB}    
</head>

<body>

    <fieldset>
    <legend>{$TITLEFORM}</legend>
        <div id="divSolicitudRemesa">
            <iframe id="iframeSolicitudRemesa"></iframe>
        </div>
	    <div id="divOrdenCargueRemesa">
    		<iframe id="iframeOrdenCargueRemesa"></iframe>
    	</div>	
	    <div id="table_find">
            <table align="center" width="100%">
                <tr>
                    <td><label>Busqueda :</label></td>
                    <td>{$BUSQUEDA}</td>
                    <td align="right">{$IMPORTARORDENCARGUE}&nbsp;{$IMPORTARSOLICITUD}&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
    	</div>
    </fieldset>
    {$OFICINAIDSTATIC}{$FECHA}{$ASEGURADORAIDSTATIC}{$NUMEROPOLIZASTATIC}{$FECHAVENCEPOLIZASTATIC}{$FORM1}{$DETALLESSID}
    <fieldset class="section">
	<legend>Informaci&oacute;n general</legend>
        <table align="center" width="85%">
            <tr>
                <td><label>Tipo Remesa :</label></td>
                <td>{$TIPOREMESA}{$REMESAID}{$DETALLESSID}{$OFICINAID}</td>
                <td><label>Fecha Remesa :</label></td>
                <td>{$FECHAREMESA}</td>
            </tr>
            <tr>
                <td><label>Fecha Recogida :</label></td>
                <td>{$FECHARECOGIDA}</td>
                <td><label>Hora Recogida :</label></td>
                <td>{$HORARECOGIDA}</td>
            </tr>		  
            <tr>
                <td><label>Remesa No. :</label></td>
                <td>{$NUMEROREMESA}{$DETALLEREMESAID}</td>
                <td><label>Solicitud Servicio :</label></td>
                <td>{$SOLICITUDID}</td>
            </tr>
            <tr>
                <td><label>Cliente :</label></td>
                <td>{$CLIENTE}{$CLIENTEID}</td>
                <td><label>Contacto :</label></td>
                <td>{$CONTACTOS}</td>
            </tr>	  
            <tr>
                <td><label>Propietario Mercancia :</label></td>
                <td>{$PROPIETARIO}{$PROPIETARIOTXT}{$PROPIETARIOID}{$TIPOIDENTIFICACIONPROPIETARIO}{$NUMEROIDENTIFICACIONPROPIETARIO}</td>
                <td><label>Clase Remesa  :</label></td>
                <td>{$CLASEREMESA}</td>			
            </tr>         
            <tr>
                <td><label>N. Remesa Padre :</label></td>
                <td>{$NUMEROREMESAPADRE}</td>
                <td><label>Nacional :</label></td>
                <td>{$NACIONAL}{$APROBACIONMANIFIESTO}{$MANIFIESTOID}</td>
            </tr>
            <tr>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
                <td><label>Foto Cumplido :</label></td>
                <td>{$FOTO_CUMPLIDO}</td>
            </tr>	
             <tr >
            <td valign="top" ><label>N&uacute;mero Aprobaci&oacute;n :</label></td>
            <td valign="top" >{$REPORTADOMIN}</td>
            <td valign="top" ><label>N&uacute;mero Cumplido :</label></td>
            <td valign="top" >{$REPORTADOCUMMIN}</td>
          </tr> 				   
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Seguro de La Mercancia</legend>
        <table width="100%">
            <tr>
                <td><label>Amparada Por :</label></td>
                <td>{$AMPARADAPOR}</td>
                <td><label>Aseguradora :</label></td>
                <td>{$ASEGURADORAS}</td>
            </tr>
            <tr>
                <td><label>N° Poliza :</label></td>
                <td>{$NUMEROPOLIZA}</td>
                <td><label>Fecha Vencimiento :</label></td>
                <td>{$FECHAVENCEPOLIZA}</td>
            </tr>		
        </table>
    </fieldset>		
    <fieldset class="section">
    <legend>Datos Remesa</legend>
        <table align="center" width="85%">
            <tr>
                <td>
                    <table align="center" width="100%">
                        <tr>
                            <td><label>Remitente :</label></td>
                            <td>{$REMITENTE}{$REMITENTEID}{$TIPOIDENTIFICACIONREMITENTEID}</td>
                        </tr>
                        <tr>
                            <td><label>Origen :</label></td>
                            <td>{$ORIGEN}{$ORIGENID}</td>
                        </tr>				  
                        <tr>
                            <td><label>Documento :</label></td>
                            <td>{$DOCUMENTOREMITENTE}</td>
                        </tr>
                        <tr>
                            <td><label>Direcci&oacute;n :</label></td>
                            <td>{$DIRECCIONORIGEN}</td>
                        </tr>
                        <tr>
                            <td><label>Telefono :</label></td>
                            <td>{$TELEFONOORIGEN}</td>
                        </tr>
                        <tr>
                            <td><label>Dcto. Cliente  :</label></td>
                            <td>{$ORDENDESPACHO}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table align="center" width="100%">
                        <tr>
                            <td><label>Destinatario :</label></td>
                            <td>{$DESTINATARIO}{$DESTINATARIOID}{$TIPOIDENTIFICACIONDESTINATARIOID}</td>
                        </tr>
                        <tr>
	                        <td><label>Destino :</label></td>
                            <td>{$DESTINO}{$DESTINOID}</td>
                        </tr>				  
                        <tr>
                            <td><label>Documento :</label></td>
                            <td>{$DOCUMENTODESTINATARIO}</td>
                        </tr>
                        <tr>
                            <td><label>Direcci&oacute;n :</label></td>
                            <td>{$DIRECCIONDESTINO}</td>
                        </tr>
                        <tr>
	                        <td><label>Telefono :</label></td>
                            <td>{$TELEFONODESTINO}</td>
                        </tr>
					</table>
                </td>
            </tr>	
		</table>
    </fieldset>			
    <fieldset class="section">
    <legend>Datos Producto</legend>
        <table width="85%" align="center" >
            <tr>
                <td width="18%"><label>Codigo Producto  :</label></td>
                <td>{$PRODUCTOID}{$PRODUCTO}</td>
                <td><label>Producto : </label></td>
                <td>{$DESCRIPCIONPRODUCTO}</td>
            </tr>
            <tr>
                <td><label>Naturaleza :</label></td>
                <td width="32%">{$NATURALEZA}</td>
                <td width="21%"><label>Unidad Empaque :</label></td>
                <td>{$UNIDADEMPAQUE}</td>
            </tr>
            <tr>
                <td><label>Unidad Medida :</label></td>
                <td>{$UNIDADMEDIDA}</td>
                <td><label>Cantidad :</label></td>
                <td width="29%">{$CANTIDAD}</td>
            </tr>
            <tr>
                <td><label>Peso Neto :</label></td>
                <td>{$PESONETO}</td>
                <td><label>Valor Declarado :</label></td>
                <td>{$VALORDECLARADO}</td>
            </tr>
            <tr>
                <td valign="top"><label>Peso Volumen :</label></td>
                <td valign="top">{$PESOVOLUMEN}</td>
                <td valign="top"><label>Observaciones :</label></td>
                <td valign="top">{$OBSERVACIONES}</td>
            </tr>    
            <tr>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"><label>Placa Vehiculo :</label></td>
                <td valign="top">{$PLACA}</td>
            </tr>               
        </table>
    </fieldset>	

    <fieldset class="section">
        <legend>Valor a Facturar</legend>
        <table align="center">
        <tr>		  
            <td><label>Tipo Liquidacion :</label></td><td>{$TIPOLIQUIDACION}</td>
            <td><label>Valor Unidad :</label></td><td>{$VALORUNIDADFACTURAR}</td>			  
            <td><label>Valor Facturar:</label></td><td>{$VALORFACTURAR}</td>				  
        </tr>
        </table>
    </fieldset>		    			

    {*
    <fieldset class="section">
    <legend>Liquidacion</legend>
        <table align="center">
            <tr>		  
                <td><label>Tipo Liquidacion :</label></td>
                <td>{$TIPOLIQUIDACION}</td>
                <td><label>Valor Unidad :</label></td>
                <td>{$VALORUNIDADFACTURAR}</td>			  
                <td><label>Valor Facturar:</label></td>
                <td>{$VALORFACTURAR}</td>				  
                <!--<td><label>Documento Cliente :</label></td>
                <td>{$DOCUMENTOCLIENTE}</td>-->
            </tr>
        </table>
    </fieldset>		
    *}
        <table align="center">
            <tr>
                <td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$LIMPIAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <div id="rangoImp">
      <div align="center">
	    <p align="center">
	      <fieldset class="section">
		  <table id="tableGuia">
		    <tr>
		    	<td>
		    		<b>Formato:</b>{$FORMATO}&nbsp;&nbsp;&nbsp;<b>Remesas:</b>&nbsp;&nbsp;&nbsp;{$REMESASIMP}<br><br>
		    		<b>Desde:&nbsp;</b>{$RANGODESDE}
		    		<b>&nbsp;&nbsp;&nbsp;Hasta:&nbsp;</b>{$RANGOHASTA}<br><br>
		    		
		    	</td>
		    </tr>
		    <tr> <td><b>Fecha Creaci&oacute;n Remesas: </b>{$FECHAREMESACREA} </td> </tr>            
			 <tr> <td>&nbsp;</td> </tr>
			 <tr> <td align="center">{$PRINTCANCEL}{$PRINTOUT}</td> </tr>
		  </table>
          </fieldset>
		</p>
	  </div>
	</div>		
    <fieldset>{$GRIDREMESAS}</fieldset>
        <div id="divAnulacion">
            <form onSubmit="return false">
                <table>              
                    <tr>
                        <td><label>Causal :</label></td>
                        <td>{$CAUSALANULACIONID}</td>
                    </tr>
                    <tr>
                        <td><label>Descripci&oacute;n :</label></td>
                        <td>{$OBSERVANULACION}</td>
                    </tr> 
                    <tr>
                        <td colspan="2" align="center">{$ANULAR}</td>
                    </tr>                    
                </table>
            </form>
        </div>	
</body>
</html>