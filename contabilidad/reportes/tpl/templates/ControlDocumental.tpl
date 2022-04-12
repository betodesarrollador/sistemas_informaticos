<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/talpa/framework/css/bootstrap.css"> 
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
                <td  align="left" valign="top"><label>DOCUMENTO</label></td>
                <td  align="right"><label for="documentos_todos">Todos</label>{$DOCUMENTOSTODOS}&nbsp;&nbsp;</td>
                <td align="center" valign="top"><label>FECHA</label></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" valign="top">{$DOCUMENTOS}</td>
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
            </tr>
        </tbody>
    </table>
    <br><br>
    <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$EXPORT}</div>
    </fieldset>
    {$FORM1END}
    {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
    {$FORM2END}

</body>
</html>