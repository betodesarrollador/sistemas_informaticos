<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
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
        <table align="center" class="tableFilter" width="100%">
            <thead>
                <tr align="center">
                    <td align="center" valign="top" style="display:none">REPORTE</td>
                    <td align="center" valign="top"><label>FECHA CORTE</label></td>
                    <td align="right" valign="top">
                        <table>
                            <tr>
                                <td width="80%"><label>CC</label></td>
                                
                                <td><label for="centros_todos">Todos</label>{$CENTROSTODOS}</td>
                            </tr>
                        </table>
                    </td>
                    <td align="center" valign="top"><label>&emsp;&emsp;TERCERO</label></td>
                    <td align="center" valign="top"><label>DOC. CIERRE</label></td>
                    <td align="center" valign="top"><label>AGRUPAR POR</label></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td valign="top" style="display:none">{$REPORTE}</td>
                    <td valign="top">
                        <table width="95%">
                            <tr>
                                <td><label>DESDE </label></td>
                                <td>{$DESDE}</td>
                            </tr>
                            <tr>
                                <td><label>HASTA</label></td>
                                <td>{$HASTA}</td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">{$CENTROCOSTOID}{$OFICINAID}</td>
                    <td valign="top">{$OPTERCERO}{$TERCERO}{$TERCEROID}</td>
                    <td valign="top">{$OPCIERRE}</td>
                    <td valign="top">{$AGRUPAR}</td>
                </tr>
            </tbody>
        </table>
        <br><br><br>
        <table>
        <tr>
        <td align="center"><label>&emsp;NIVEL CUENTAS</label> </td>
        <td>&emsp;&emsp;</td>
        <td align="center"><label> CUENTAS</label> </td>
        </tr>
        <tr>
            <td align="center">{$NIVEL}&emsp;&emsp;</td>
            <td>&emsp;&emsp;</td>
            <td>&emsp;&emsp;{$CUENTASPUC}</td>
            <td align="center"><label>Todas&emsp;</label>{$CUENTASTODAS}</td>
        </tr>
        
        </table>
        
        <br><br>
        
        <div align="center">{$GENERAR}&emsp;{$IMPRIMIR}&emsp;{$DESCARGAR}</div>
        <br>
    </fieldset>
    {$FORM1END}
    {$FORM2}
    <iframe id="frameReporte" name="frameReporte"></iframe>
    {$FORM2END}

</body>

</html>