<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
    <link rel="stylesheet" href="/application/bodega/bases/css/bootstrap1.css">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        {$FORM1}
        <fieldset class="section">
            <table align="center" width="90%">
                <tr>
                    <td width="25%" align="center"><label>PERIODO</label></td>
                    <td width="35%" align="center"><label>CLIENTE</label></td>
                    <td width="20%" align="center"><label>TIPO DE REPORTE</label></td>
                </tr>
                <tr>
                    <td valign="top">
                        <label>Desde:&nbsp;</label> {$DESDE}<br><br>
                        <label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                    </td>
                    <td valign="top">{$SI_CLI}<br />{$CLIENTE}{$CLIENTEID}</td>
                    <td valign="top">{$TIPO}</td>
                </tr>

                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center">

                    </td>
                </tr>
            </table>
        </fieldset>
        <table width="100%">
            <tr>
                <td id="loading" width="15%">&nbsp;</td>
                <td width="60%" align="center">{$GENERAR}&nbsp;{$DESCARGAR}&nbsp;{$EXCEL}&nbsp;</td>
                <td width="15%" align="right"></td>
            </tr>
        </table>
        <br>
        <fieldset class="section">
            <table width="100%">
                <tr>
                    <td colspan="7"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
                </tr>
            </table>
        </fieldset>
        {$FORM1END}
    </fieldset>
</body>

</html>