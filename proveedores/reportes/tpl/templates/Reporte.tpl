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
            <table>
                <tr>
					<td width="35%" align="center"><label>TIPO DE REPORTE</label></td>
                    <td valign="top">{$TIPO}</td>
                    <td width="35%" align="center"><label>SALDOS CON CORTE</label></td>
                    <td valign="top">{$SALDOS}</td>
                </tr>
            </table>
        </fieldset>
         <fieldset class="section">
        <table align="center" width="95%">
            <tr>
                <td width="20%" align="center"><label>PERIODO</label></td>
                <td width="20%" align="center"><label>PROVEEDOR</label></td>
                <td width="20%" align="center"><label>OFICINA</label></td>
                <td width="20%" align="center"><label>DOCUMENTO</label></td>
                <td width="20%" align="center"><label>CUENTAS</label></td>
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br><br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}<br><br>
                </td>
                <td valign="top">{$SI_PRO}<br />{$PROVEEDOR}{$PROVEEDORID}</td>
                <td valign="top"><label>Todos</label> {$ALLOFFICE}<br />{$OFICINA}</td>
                <td valign="top"><label>Todos</label> {$ALLDOCS}<br />{$TIPO_DOCUMENTO_ID}</td>
                <td valign="top"><label>Todos</label> {$ALLCTAS}<br />{$PUC_ID}</td>
            </tr>

			<tr>
            	<td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GENERAR}&nbsp;{$DESCARGAR}&nbsp;{$EXCEL}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
                            <td width="15%" align="right" ></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>
		<table width="100%">
			<tr><td colspan="7"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table>        
		{$FORM1END}
	</fieldset>
    
</body>
</html>
