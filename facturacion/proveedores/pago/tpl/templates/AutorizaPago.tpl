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
			{$FORM1}
			<fieldset class="section">
            <legend>Autorizar Pago</legend>
            <table align="center">
                <tr>
                    <td valign="top"><label>Desde:</label></td>
                    <td valign="top">{$DESDE}</td>
                    <td valign="top"><label>Hasta:</label></td>
                    <td valign="top">{$HASTA}</td>
                </tr>
                	<td>&nbsp;</td>
                	<td align="right"><label>Proveedor:</label></td>
                    <td colspan="2" align="left">{$PROVEEDOR}{$PROVEEDORID}</td>
                    
                <tr>
                
                </tr>
            </table>
            </fieldset>
			{$FORM1END}
            <fieldset class="section">
            	<div align="center">{$GENERAR}&nbsp;{$GENERAREXCEL}&nbsp;{$CONTABILIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$GENERAREXCEL2}&nbsp;{$IMPRIMIR1}&nbsp;{$LIMPIAR}</div>
                <iframe src="" id="frameDepreciados" name="frameDepreciados" height="300px"></iframe>
            </fieldset>
            
		</fieldset>
	</body>
</html>
