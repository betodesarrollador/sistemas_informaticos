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
        <table>
            <tr>
                <td width="229" ><label>Empresa : </label></td>
                <td width="264">{$EMPRESAID}{$PARAMETROANTICIPOID}</td>
                <td width="210"><label>Oficina : </label></td>
                <td width="241">{$OFICINAID}</td>
            </tr>        
            <tr>
                <td width="229" ><label>Documento Contable :</label></td>
                <td width="264">{$DOCUMENTOCONTABLE}</td>
                <td width="210"><label>Cuenta Puc : </label></td>
                <td width="241">{$PUC}{$PUCID}</td>
            </tr>
            <tr>
                <td><label>Nombre : </label></td>
                <td align="left">{$NOMBRE}</td>
                <td><label>Natutaleza : </label></td>
                <td align="left">{$NATURALEZA}</td>
            </tr>
            <tr>
                <td align="left"><label>Propio :</label></td>
                <td align="left">{$PROPIO}</td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
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
    <fieldset>{$GRIDIMPUESTOS}</fieldset>

</body>
</html>
