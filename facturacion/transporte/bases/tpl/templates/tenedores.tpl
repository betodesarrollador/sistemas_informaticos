<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Tenedor</title>
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
        <table align="center" >
            <tr>
                <td><label>Tipo Identificaci&oacute;n   :</label></td>
                <td>{$TIPOIDENTIFICACION}</td>
                <td><label>Tipo Persona   :</label></td>
                <td>{$TIPOPERSONA}</td>
            </tr>
            <tr>
                <td><label>N&uacute;mero Identificaci&oacute;n   :</label></td>
                <td colspan="3">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}{$TENEDORID}{$TERCEROID}{$PROVEEDORID}</td>
            </tr>
            <tr id="filaApellidos">
                <td><label>Primer Apellido    :</label></td>
                <td>{$PRIMERAPELLIDO}</td>
                <td><label>Segundo Apellido   :</label></td>
                <td>{$SEGUNDOAPELLIDO}</td>
            </tr>
            <tr id="filaNombres">
                <td><label>Primer Nombre      :</label></td>
                <td>{$PRIMERNOMBRE}</td>
                <td><label>Otros Nombres  : </label></td>
                <td>{$OTROSNOMBRES}</td>
            </tr>
            <tr id="filaRazonSocial">
                <td><label>Raz&oacute;n Social      :</label></td>
                <td>{$RAZON_SOCIAL}</td>
                <td><label>Sigla  : </label></td>
                <td>{$SIGLA}</td>
            </tr>
            <tr>
                <td><label>Ciudad : </label></td>
                <td>{$UBICACION}{$UBICACIONID}</td>
                <td><label>Direcci&oacute;n : </label></td>
                <td>{$DIRECCIONRESIDENCIA}</td>
            </tr>
            <tr>
                <td><label>Tel&eacute;fono Fijo : </label></td>
                <td>{$TELEFONOFIJO}</td>
                <td><label>Tel&eacute;fono Celular : </label></td>
                <td>{$TELEFONOCELULAR}</td>
            </tr>
            <tr>
                <td><label>Fecha Datacredito : </label></td>
                <td>{$FECHADATACREDITO}</td>
                <td><label>Calificaci&oacute;n Datacredito: </label></td>
                <td>{$CALIFICACIONDATA}</td>
            </tr>
            <tr>
                <td><label>RUT :</label></td>
                <td>{$RUT}</td>
                <td><label>Documentos :</label></td>
                <td>{$DOCUMENTOS}</td>
            </tr>
            <tr>
                <td><label>SEGURIDAD SOCIAL :</label></td>
                <td>{$SEGURIDADSOCIAL}</td>
                <td><label>VENC. SEGURIDAD SOCIAL :</label></td>
                <td>{$VENCSEGURIDADSOCIAL}</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>	
            <tr>
                <td><label>Autorretenedor Renta : </label></td>
                <td>{$AUTORRETENEDORRENTA}</td>
                <td><label>Agente Ica :</label></td>
                <td align="left">{$AUTORRETENEDORICA}</td>
            </tr>	
            <tr>
                <td><label>AutoCREE : </label></td>
                <td colspan="3">{$AUTOCREE}</td>
            </tr>			  	  
            <tr>
                <td><label>Tipo de Cuenta : </label></td>
                <td>{$TIPOCUENTA}</td>
                <td><label>N&uacute;mero de Cuenta : </label></td>
                <td>{$NUMEROCUENTA}</td>
            </tr>
            <tr>
                <td><label>Entidad Bancaria : </label></td>
                <td>{$BANCOID}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>        
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDTENEDORES}</fieldset>
</body>
</html>