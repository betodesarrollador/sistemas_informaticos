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
        <table align="center">
            <tr>
                <td><label>Forma de Pago  : </label></td>
                <td>{$CUENTAID}{$FORMA}</td>
            </tr>
            <tr>
                <td><label>Cuenta Puc : </label></td>
                <td>{$PUC}{$PUCID}</td>
            </tr>
            <tr>
                <td><label>Naturaleza : </label></td>
                <td>{$NATURA}</td>
            </tr>
            <tr>
                <td colspan="2" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="right">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>{$FORM1END}
</body>
</html>
