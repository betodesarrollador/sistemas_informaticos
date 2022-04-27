<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
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
        <div id="table_find">
            <table>
                <tbody>
                    <tr>
                        <td><label>Busqueda : </label></td>
                        <td>{$BUSQUEDA}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    {$OFICINAIDSTATIC}{$USUARIOIDSTATIC}{$FECHAINGRESOSTAT}
    </fieldset>
    {$FORM1}
    <fieldset> 
    <legend>ORDEN DE CARGUE</legend>
        <table align="center" width="100%">
            <tbody>
                <tr>
                    <td align="center">
                        <fieldset class="section">
                            <table align="center" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="12%"><label>Orden Cargue No.</label></td>
                                        <td>{$ORDENCARGUEID}{$CONSECUTIVO}</td>
                                        <td><label>Solicitud No.</label></td>
                                        <td>{$SOLICITUDID}{$DETSOLICITUD}{$OFICINAID}{$USUARIOID}{$FECHAINGRESO}</td>
                                        <td width="13%"><label>Fecha de Cargue : </label></td>
                                        <td>{$FECHA}</td>
                                        <td><label>Hora:</label></td>
                                        <td>{$HORA}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Cliente : </label></td>
                                        <td>{$CLIENTE}{$CLIENTEID}</td>
                                        <td><label>Nit : </label></td>
                                        <td>{$CLIENTENIT}</td>
                                        <td><label>Tel&eacute;fono : </label></td>
                                        <td colspan="3">{$CLIENTETEL}</td>
                                	</tr>
                                    <tr>
                                        <td><label>Direcci&oacute;n :</label></td>
                                        <td>{$CLIENTEDIR}</td>
                                        <td><label>Contacto :</label></td>
                                        <td>{$CONTACTOID}</td>
                                        <td><label>Tipo Servicio  :</label></td>
                                        <td colspan="3">{$SERVICIO}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Origen :</label></td>
                                        <td>{$ORIGEN}{$ORIGENID}</td>
                                        <td><label>Destino :</label></td>
                                        <td>{$DESTINO}{$DESTINOID}</td>
                                        <td><label>Dcto. Cliente :</label></td>
                                        <td colspan="3">{$ORDENDESPACHO}</td>
                                    </tr>		  
                                    <tr>
                                        <td><label>Remitente  :</label></td>
                                        <td>{$REMITENTE}{$REMITENTEID}</td>
                                        <td><label>Destinatario :</label></td>
                                        <td>{$DESTINATARIO}{$DESTINATARIOID}</td>
                                        <td><label>Estado :</label></td>
                                        <td colspan="3">{$ESTADO}</td>
                                    </tr>		  
                                    <tr>
                                        <td><label>Producto :</label></td>
                                        <td>{$PRODUCTO}{$PRODUCTOID}</td>
                                        <td><label>Peso :</label></td>
                                        <td>{$PESOCANT}</td>
                                        <td><label>Unidad Peso :</label></td>
                                        <td colspan="3">{$PESO}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Cantidad :</label></td>
                                        <td>{$CANTIDAD}</td>
                                        <td><label>Volumen :</label></td>
                                        <td>{$VOLCANTI}</td>
                                        <td><label>Unidad  Volumen :</label></td>
                                        <td colspan="3">{$VOLUMEN}</td>
                                    </tr>
                                    <tr>
                                    	<td><label>Unidad Empaque :</label></td>
						                <td>{$UNIDADEMPAQUE}</td>
                                        <td><label>Observaciones:</label></td>
                                        <td colspan="5">{$OBSERVACIONESOC}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
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
                                        <td><label>Configuraci&oacute;n :</label></td>
                                        <td>{$CONFIGURACIONVEHICULO}</td>
                                        <td><label>Peso Vacio :</label></td>
                                        <td>{$PESOVACIOVEHICULO}</td>
                                        <td><label>Capacidad Vehiculo :</label></td>
                                        <td>{$CAPACIDADVEHICULO}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td><label>Numero Poliza SOAT :</label></td>
                                        <td>{$NUMEROSOATVEHICULO}</td>
                                        <td><label>Compañia de Seguros SOAT :</label></td>
                                        <td>{$ASEGURADORASOATVEHICULO}</td>
                                        <td><label>Vencimiento SOAT :</label></td>
                                        <td>{$VENCIMIENTOSOATVEHICULO}</td>
                                                                            </tr>
                                    <tr>
                                        <td><label>Placa Remolque :</label></td>
                                        <td>{$REMOLQUE}{$PLACAREMOLQUE}{$PLACAREMOLQUEID}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" align="center">
                        <fieldset class="section"> <legend>Datos Conductor</legend>
                            <table align="center" id="tableDataConductor">
                                <tbody>
                                    <tr>
                                        <td><label>Conductor :</label></td>
                                        <td>{$NOMBRECONDUCTOR}{$CONDUCTORID}</td>
                                        <td><label>Doc Identificaci&oacute;n :</label></td>
                                        <td>{$NUMEROIDENTIFICACION}</td>
                                        <td><label>Licencia :</label></td>
                                        <td>{$LICENCIACONDUCTOR} </td>
                                    </tr>
                                    <tr>
                                        <td><label>Cat :</label></td>
                                        <td>{$CATEGORIALICENCIACONDUCTOR}</td>
                                        <td><label>Direcci&oacute;n :</label></td>
                                        <td>{$DIRECCIONCONDUCTOR}</td>
                                        <td><label>Tel&eacute;fono :</label></td>
                						<td>{$TELEFONOCONDUCTOR}</td>
                                    </tr>
                                    <tr>
                                        <td><label>M&oacute;vil :</label></td>
                                        <td>{$MOVILCONDUCTOR}</td>
                                        <td><label>Ciudad :</label></td>
                                        <td colspan="3">{$CIUDADCONDUCTOR}</td>
                                    </tr>		  
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" align="center">
                        <fieldset class="section"> <legend>Datos Propietario</legend>
                            <table align="center">
                                <tbody>
                                    <tr>
                                        <td><label>Propietario :</label></td>
                                        <td>{$PROPIETARIO}</td>
                                        <td><label>Doc Identificaci&oacute;n :</label></td>
                                        <td>{$DOCIDENTIFICACIONPROPIETARIO}</td>
                                        <td><label>Direcci&oacute;n :</label></td>
                                        <td>{$DIRECCIONPROPIETARIO}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Tel&eacute;fono :</label></td>
                                        <td>{$TELEFONOPROPIETARIO}</td>
                                        <td><label>Ciudad :</label></td>
                                        <td colspan="3">{$CIUDADPROPIETARIO}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" align="center">
						<fieldset class="section"> <legend>Datos Tenedor</legend>
                            <table align="center">
                                <tbody>
                                    <tr>
                                        <td><label>Tenedor :</label></td>
                                        <td>{$TENEDOR}{$TENEDORID}</td>
                                        <td><label>Doc Identificaci&oacute;n :</label></td>
                                        <td>{$DOCIDENTIFICACIONTENEDOR}</td>
                                        <td><label>Direcci&oacute;n :</label></td>
                                        <td>{$DIRECCIONTENEDOR}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Tel&eacute;fono :</label></td>
                                        <td>{$TELEFONOTENEDOR}</td>
                                        <td><label>Ciudad :</label></td>
                                        <td colspan="3">{$CIUDADTENEDOR}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" align="center">
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
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <table width="98%" align="center">
                            <tr>
                                <td align="center">{$GUARDAR}{$ACTUALIZAR}{$IMPRIMIR}{$ANULAR}{$LIMPIAR}&nbsp;&nbsp;&nbsp;{$GENERARDOC}</td>
                            </tr>
                        </table>
                    </td>
            	</tr>
        	</tbody>
		</table>
    </fieldset>
    {$FORM1END} 
    <fieldset>{$GRIDOrdenCargue}</fieldset>  
    <div id="divAnulacion">
        <form>
            <table>       
                <tr>
                    <td><label>Fecha / Hora :</label></td>
                    <td>{$FECHALOG}{$USUARIOANULID}</td>
                </tr>          
                <tr>
                    <td><label>Descripci&oacute;n :</label></td>
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