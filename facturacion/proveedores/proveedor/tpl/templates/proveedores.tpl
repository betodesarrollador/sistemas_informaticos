<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
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
    <legend>Informaci&oacute;n general</legend>        
        <table align="center">
            <tr>
                <td><label>Tipo Identificaci&oacute;n : </label></td>
                <td>{$TIPOIDENTIFICACION}{$TERCEROID}{$PROVEEDORID}</td>
                <td><label>Tipo Contribuyente : </label></td>
                <td>{$TIPOPERSONA}</td>
            </tr>
            <tr>
                <td><label>N&uacute;mero Identificaci&oacute;n :</label></td>
                <td align="left" colspan="3">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
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
                <td><label>Ciudad Residencia : </label></td>
                <td>{$UBICACION}{$UBICACIONID}</td>
                <td><label>Direcci&oacute;n : </label></td>
                <td align="left">{$DIRECCION}</td>
            </tr>
            <tr>
                <td><label>Email :</label></td>
                <td align="left">{$EMAIL}</td>
                <td><label>Pagina Web : </label></td>
                <td>{$URL}</td>
            </tr>
            <tr>
                <td ><label>Fecha Ingreso :</label></td>
                <td colspan="3">{$FECHAINGRESO}</td>
            </tr> 
            <tr>
                <td><label>Contacto :</label></td>
                <td align="left">{$CONTACT}</td>
                <td><label>Estado : </label></td>
                <td align="left">{$ESTADO}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Informaci&oacute;n Tributaria</legend>        
        <table align="center">
            <tr>
                <td><label>Autorretenedor : </label></td>
                <td><label>SI{$AUTORET_SI}NO{$AUTORET_NO}</label></td>
                <td><label>AutoReteica :</label></td>
                <td align="left"><label>SI{$AGENTE_SI}NO{$AGENTE_NO}</label></td>
            </tr>
            <tr>
                <td><label>AutoCREE : </label></td>
                <td colspan="3"><label>SI{$RENTA_SI}NO{$RENTA_NO}</label></td>
            </tr>
            <tr>
                <td><label>Regimen : </label></td>
                <td>{$REGIMENID}</td>
                <td><label>Tipo de Cuenta :</label></td>
                <td align="left">{$TIPOCUENTA}</td>
            </tr>
            <tr>
                <td><label>N&uacute;mero de Cuenta : </label></td>
                <td>{$NUM_CUENTA}</td>
                <td><label>Entidad Bancaria :</label></td>
                <td align="left">{$BANCO}{$BANCOID}</td>
            </tr>
            <tr>
                <td><label>Cert. Bancaria : </label></td>
                <td colspan="3">{$CERTIFICACIONBANC}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Informaci&oacute;n Financiera</legend>        
        <table align="center" width="60%">
            <tr>
                <td><label>Saldo : </label></td>
                <td>{$SALDO}</td>
                <td><label>Saldo Mensual :</label></td>
                <td>{$SALDO_MEN}</td>
            </tr>
            <tr>
                <td><label>Vencimientos : </label></td>
                <td colspan="3">{$VENCIMIENTOS}</td>
            </tr>          
        </table>
    </fieldset>          
    <table align="center">
        <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
        </tr>
    </table>
    
    <fieldset>{$GRIDPROVEEDORES}</fieldset>{$FORM1END}
    </fieldset>

</body>
</html>
