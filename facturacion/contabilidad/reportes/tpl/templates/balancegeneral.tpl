<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
    {$TITLETAB}
</head>

<body>

    <fieldset>
        <legend>{$TITLEFORM}</legend>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center" class="tableFilter">
            <thead>
                <tr align="center">
                    <td align="center" valign="top" style="display:none">REPORTE</td>
                    <td align="center" valign="top"><label>FECHA CORTE</label></td>
                    <td align="right" valign="top">
                        <table width="100%">
                            <tr>
                                <td width="50%"><label>CC</label>
                                    <label for="centros_todos"></label></td>
                                <td><label for="centros_todos">Todos</label>{$CENTROSTODOS}</td>
                            </tr>
                        </table>
                    </td>
                    <td align="center" valign="top"><label>TERCERO</label></td>
                    <td align="center" valign="top"><label>NIVEL CUENTAS</label></td>
                    <td align="center" valign="top"><label>DOC. CIERRE</label></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td valign="top" style="display:none">{$REPORTE}</td>
                    <td valign="top">
                        <table border="0">
                            <tr style="display:none">
                                <td><label>DESDE </label></td>
                                <td>{$DESDE}</td>
                            </tr>
                            <tr>
                                <td>
                                    <!--<label>FECHA CORTE </label>-->
                                </td>
                                <td>{$HASTA}</td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top" align="right">{$CENTROCOSTOID}{$OFICINAID}</td>
                    <td align="center">
                        <table border="0" align="center">
                            <tr>
                                <td align="left" valign="top">{$OPTERCERO}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="bottom">{$TERCERO}{$TERCEROID}</td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top" align="center">{$NIVEL}</td>
                    <td valign="top" align="center">{$OPCIERRE}</td>
                </tr>
            </tbody>
        </table>
        <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$DESCARGAR}</div>
    </fieldset>
    {$FORM1END}
    {$FORM2}
    <iframe id="frameReporte" name="frameReporte"></iframe>
    {$FORM2END}

</body>

</html>