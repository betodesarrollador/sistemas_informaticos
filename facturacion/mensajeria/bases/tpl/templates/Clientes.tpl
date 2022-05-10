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
    <div id="table_find">
    <table>
        <tr>
            <td><label>Busqueda : </label></td>
            <td>{$BUSQUEDA}</td>
        </tr>
    </table>
    </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
    <table align="center">
        <tr>
            <td colspan="4"><label>1. IDENTIFICACI&Oacute;N</label></td>
        </tr>
        <tr>
            <td><label>Tipo Identificaci&oacute;n : </label></td>
            <td>{$TIPOIDENTIFICACION}{$TERCEROID}{$CLIENTEID}{$REMITENTEID}</td>
            <td><label>Tipo Contribuyente : </label></td>
            <td>{$TIPOPERSONA}</td>
        </tr>
        <tr>
            <td><label>Numero Identificaci&oacute;n :</label></td>
            <td align="left">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
        </tr>
        <tr id="filaApellidos">
            <td><label>Primer Apellido : </label></td>
            <td align="left">{$PRIMERAPELLIDO}</td>
            <td><label>Segundo Apellido : </label></td>
            <td align="left">{$SEGUNDOAPELLIDO}</td>
        </tr>
        <tr id="filaNombres">
            <td><label>Primer Nombre : </label></td>
            <td>{$PRIMERNOMBRE}</td>
            <td><label>Otros Nombres : </label></td>
            <td>{$OTROSNOMBRES}</td>
        </tr>
        <tr id="filaRazonSocial">
            <td><label>Raz&oacute;n Social : </label></td>
            <td>{$RAZON_SOCIAL}</td>
            <td><label>Sigla : </label></td>
            <td>{$SIGLA}</td>
        </tr>
        <tr>
            <td><label>Telefono : </label></td>
            <td>{$TELEFONO}</td>
            <td><label>Movil : </label></td>
            <td align="left">{$MOVIL}</td>
        </tr>
        <tr>
            <td><label>Telefax : </label></td>
            <td>{$TELEFAX}</td>
            <td><label>Apartado A&eacute;reo : </label></td>
            <td align="left">{$APARTADO}</td>
        </tr>
        <tr>
            <td><label>Direcci&oacute;n : </label></td>
            <td align="left">{$DIRECCION}</td>
            <td><label>Direcci&oacute;n Correspondencia : </label></td>
            <td>{$CORRESPON}</td>
        </tr>
        <tr>
            <td><label>Ciudad Residencia : </label></td>
            <td>{$UBICACION}{$UBICACIONID}</td>
            <td><label>Email :</label></td>
            <td align="left">{$EMAIL}</td>
        </tr>
        <tr>
            <td><label>P&aacute;gina Web : </label></td>
            <td>{$URL}</td>
            <td><label>Contacto :</label></td>
            <td align="left">{$CONTACT}</td>
        </tr>
        <tr>
            <td><label>Registro Mercantil : </label></td>
            <td>{$REGISTROM}</td>
            <td><label>Camara de Comercio :</label></td>
            <td align="left">{$CCOMERCIO}</td>
        </tr>
        <tr>
        	<td><label>Fecha de Inicio : </label></td>
            <td>{$FECHAINI}</td>
            <td><label>Estado : </label></td>
            <td align="left">{$ESTADO}</td>
        </tr>
    </table>
    </fieldset>
    <fieldset class="section" id="legal">
    <table align="center">
        <tr>
            <td colspan="4"><label>2. INFORMACI&Oacute;N LEGAL (Solo personas Jur&iacute;dicas)</label></td>
        </tr>
        <tr>
            <td colspan="4"><label>Socios- Para Sociedades Anónimas relacione los Miembros de la Junta Directiva</label></td>
        </tr>
        <tr>
            <td colspan="4" align="right">
            <img src="../../../framework/media/images/grid/save.png" id="saveDetallesoc" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesoc" title="Borrar Seleccionados"/>
            <iframe id="socios" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
        </tr>
        <tr>
            <td colspan="4"><label>Representante Legal</label></td>
        </tr>
        <tr>
            <td><label>Nombres y Apellidos : </label></td>
            <td>{$REPRELEG}</td>
            <td><label>Identificaci&oacute;n :</label></td>
            <td align="left">{$REPRELEGID}</td>
        </tr>
        <tr>
            <td><label>Direcci&oacute;n : </label></td>
            <td>{$DIRREPRELEG}</td>
            <td><label>Ciudad :</label></td>
            <td align="left">{$REPUBICACION}{$REPUBICACIONID}</td>
        </tr>
        <tr>
            <td><label>Capital Social : </label></td>
            <td>{$CAPITAL}</td>
            <td><label>Descripci&oacute;n Actividad :</label></td>
            <td align="left">{$DESACTIVIDAD}</td>
        </tr>
    </table>
    </fieldset>
    <fieldset class="section" id="tributaria">
    <table align="center">
        <tr>
            <td colspan="4"><label>3. INFORMACI&Oacute;N TRIBUTARIA</label></td>
        </tr>
        <tr>
            <td><label>Autorretenedor : </label></td>
            <td>SI{$AUTORET_SI}NO{$AUTORET_NO}</td>
            <td><label>Agente Reteica :</label></td>
            <td align="left">SI{$AGENTE_SI}NO{$AGENTE_NO}</td>
        </tr>
        <tr>
            <td><label>Regimen : </label></td>
            <td colspan="3">{$REGIMENID}</td>
        </tr>
    </table>
    </fieldset>
    <fieldset class="section" id="operativas">
    <table align="center">
        <tr>
            <td colspan="4"><label>4. INFORMACI&Oacute;N OPERATIVA</label></td>
        </tr>
        <tr>
            <td colspan="4"><label>Personal que realiza directamente la operaci&oacute;n</label></td>
        </tr>
        <tr>
            <td colspan="4" align="right">
            <img src="../../../framework/media/images/grid/save.png" id="saveDetalleope" title="Guardar Seleccionados"/> <img src="../../..	/framework/media/images/grid/no.gif" id="deleteDetalleope" title="Borrar Seleccionados"/>
            <iframe id="operativa" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
        </tr>
        <tr>
            <td><label>Origen de Recursos :</label></td>
            <td colspan="3">{$RECURSOS}</td>
        </tr>
    </table>
    </fieldset>
    <fieldset class="section" id="financiera">
    <table align="center">
        <tr>
            <td colspan="4"><label>5. INFORMACI&Oacute;N FINANCIERA</label></td>
        </tr>
        <tr>
            <td><label>Tipo de Cuenta :</label></td>
            <td align="left">{$TIPOCUENTA}</td>
            <td><label>N&uacute;mero de Cuenta : </label></td>
            <td>{$NUM_CUENTA}</td>
        </tr>
        <tr>
            <td><label>Entidad Bancaria :</label></td>
            <td align="left" colspan="3">{$BANCOID}</td>
        </tr>
    </table>
    </fieldset>
    <fieldset class="section" id="tarifas24h" style="display: none">
    <table align="center">
        <tr>
            <td colspan="4"><label>6. TARIFAS MENSAJERIA 24 HORAS</label></td>
        </tr>
        <tr>
            <td colspan="4" align="right">
            <iframe id="24h" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
        </tr>
    </table>
	</fieldset>
    <fieldset class="section" id="tarifasnormal" style="display: none">
    <table align="center">
        <tr>
    	    <td colspan="4"><label>7. TARIFAS CREDITO</label></td>
        </tr>
        <tr>
        	<td colspan="4" align="right">
        	<iframe id="normal" frameborder="0" marginheight="0" marginwidth="0"></iframe>
        	</td>
        </tr>
    </table>
    </fieldset>
    <fieldset class="section" id="tarifasmasivo" style="display: none">
    <table align="center">
        <tr>
        	<td colspan="4"><label>8. TARIFAS MENSAJERIA MASIVA</label></td>
        </tr>
        <tr>
        	<td colspan="4" align="right">
        	<iframe id="masivo" frameborder="0" marginheight="0" marginwidth="0"></iframe>
        	</td>
        </tr>
    </table>
	</fieldset>
    <fieldset class="section" id="comercial">
    <table align="center" width="90%">  
        <tr>
            <td colspan="6"><label>9. ASESOR COMERCIAL</label></td>
        </tr>
        <tr>
            <td colspan="4" align="right">
            <img src="../../../framework/media/images/grid/save.png" id="saveDetallecom" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallecom" title="Borrar Seleccionados"/>
            <iframe id="comerciales" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
        </tr>
    </table>
    </fieldset>        
    <table align="center">
        <tr>
    	    <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$DUPLICAR}</td>
        </tr>
    </table>
    </fieldset>
    {$FORM1END}
    <fieldset>{$GRIDCLIENTES}</fieldset>
    <div id="divDuplicar" style="display:none">
    <form>
    <table>       
        <tr>
            <td><label>Tipo Servicio :</label></td>
            <td>{$TIPOMENSAJERIAID}{$USUARIOID}</td>
        </tr>          
        <tr>
            <td><label>Periodo Base :</label></td>
            <td>{$PERIODO}</td>
        </tr> 
        <tr>
            <td><label>Periodo Final :</label></td>
            <td>{$PERIODOFIN}</td>
        </tr>           
        <tr>
            <td colspan="2" align="center">{$DUPLICAR}</td>
        </tr>                    
    </table>
    </form>
    </div>                
</body>
</html>
