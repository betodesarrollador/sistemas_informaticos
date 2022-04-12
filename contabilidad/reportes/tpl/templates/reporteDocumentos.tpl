<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">

    {$JAVASCRIPT}
    {$CSSSYSTEM} 
    {$TITLETAB}  
</head>
<body>
    <legend>{$TITLEFORM}</legend>
    {$FORM1}
        <fieldset class="section">
        <table align="center" width="50%">
            <tr>
                <td width="30%" align="center"><label>PERIODO</label></td>
                <td width="30%" align="center"><label>TIPO REPORTE</label></td>
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                </td>
                <td valign="top">{$TRAZABILIDAD}</td>
            </tr>
			<tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading"></td>
                            <td align="center">{$GENERAR}&nbsp;&nbsp;{$IMPRIMIR}&nbsp;&nbsp;{$EXCEL}</td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>       
		{$FORM1END}
    {$FORM2}
        <iframe id="frameReporte" name="frameReporte" src="" height="300"></iframe>
    {$FORM2END}
</body>
</html>
