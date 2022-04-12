<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td>{$TITLEFORM}</td>
	            <td><a href="https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx" target="_blank" title="Consulta de Antecedes Disciplinarios"> <img src="../../../framework/media/images/general/procuraduria_logo.jpg" title="Consulta de Antecedes Disciplinarios" height="30" width="30"> </a></td>
	            <td><a href="http://web.mintransporte.gov.co/Consultas/transito/Consulta23122010.htm" target="_blank" title="Consulta Ministerio de Transporte"> <img src="../../../framework/media/images/general/ministeriotransporte.jpg" title="Consulta Ministerio de Transporte" height="30" width="30"></a></td>
	            <td><a href="http://190.84.240.175/cera/" target="_blank" title="Consulta Asecarga"> <img src="../../../framework/media/images/general/A1_ASECARGA_normal.jpg" title="Consulta Asecarga" height="30" width="30"> </a> </td>
            	<td><a href="http://www.simit.org.co/Simit/" target="_blank" title="Consulta Simit"> <img src="../../../framework/media/images/general/simit.jpg" title="Consulta Simit" height="30" width="30"> </a>            
	            <a href="https://muisca.dian.gov.co/WebRutMuisca/DefConsultaEstadoRUT.faces" target="_blank" title="Consulta Simit"> <img src="../../../framework/media/images/general/dian.jpg" title="Consulta Muisca" height="30" width="30"> </a>           
	            <a href="http://antecedentes.policia.gov.co:7003/WebJudicial/index.xhtml" target="_blank" title="Consulta Antecedentes Judiciales"><img src="../../../framework/media/images/general/policianacional.jpg" title="Consulta Antecedentes Judiciales" height="30" width="30"></a>
            	</td>
            </tr>
        </tbody>
    </table>  
    <fieldset>
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
                <td><label>Tipo Identificaci&oacute;n : </label></td>
                <td>{$TIPOIDENTIFICACION}{$TERCEROID}</td>
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
                <td><label>Razon Social : </label></td>
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
                <td><label>Ciudad Residencia : </label></td>
                <td>{$UBICACION}{$UBICACIONID}</td>
                <td><label>Direcci&oacute;n : </label></td>
                <td align="left">{$DIRECCION}</td>
            </tr>
            <tr>
                <td><label>Email :</label></td>
                <td align="left">{$EMAIL}</td>
                <td><label>Regimen : </label></td>
                <td>{$REGIMENID}</td>
            </tr>
            <tr>
                <td><label>Autorretenedor Renta : </label></td>
                <td>{$AUTORRETENEDORRENTA}</td>
                <td><label>Agente Ica :</label></td>
                <td align="left">{$AUTORRETENEDORICA}</td>
            </tr>		  
            <tr>
                <td><label>Propietario Vehiculo :</label></td>
                <td align="left">{$PROPIETARIOVEHICULO}</td>
                <td align="left"><label>Estado : </label></td>
                <td align="left">{$ESTADO}</td>
            </tr>          
            <tr>
                <td align="center" colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDTERCEROS}</fieldset>

</body>
</html>
