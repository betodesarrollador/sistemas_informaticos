<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
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
                <td  align="left" valign="top"><label>CC</label></td>
                <td  align="right"><label for="centros_todos">Todos</label>{$CENTROSTODOS}&nbsp;</td>
                <td align="center" valign="top"><label>FECHA</label></td>
                <td align="center" valign="top"><label>IMPUESTO</label></td>
                <td align="center" valign="top"><label>AGRUPAR</label></td>                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td valign="top" style="display:none">{$REPORTE}</td>
                <td colspan="2" valign="top">{$CENTROCOSTOID}{$OFICINAID}</td>
                <td valign="top">
                    <table border="0">
                        <tr>
                            <td width="50"><label>DESDE </label></td>
                            <td width="200">{$DESDE}</td>
                        </tr>
                        <tr>
                            <td><label>HASTA </label></td>
                            <td>{$HASTA}</td>
                        </tr>
                    </table>
                </td>
                <td valign="top">{$TIPOIMP}</td>
                <td valign="top">
                    <table border="0">
                        <tr>
                            <td><label>Auxiliar</label></td>
                            <td><input type="radio" name="agrupar" id="defecto" value="defecto" checked /></td>
                        </tr>
                        <tr>
                            <td><label>Cuenta</label></td>
                            <td><input type="radio" name="agrupar" id="cuenta" value="cuenta" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$EXPORT}</div>
    </fieldset>
    {$FORM1END}
    {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
    {$FORM2END}

</body>
</html>