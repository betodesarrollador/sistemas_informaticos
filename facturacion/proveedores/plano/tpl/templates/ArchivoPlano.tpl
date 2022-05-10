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
        {$FORM1}
         <fieldset class="section">
        <table align="center" width="90%">
            <tr>
                <td width="15%">&nbsp;</td>
                <td width="25%" align="center"><label>PERIODO</label></td>
                <td width="20%" align="center"><label>TIPO DE REPORTE</label></td>
            </tr>
            <tr>
            	<td width="15%">&nbsp;</td>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}<br><br>
                <td valign="top">{$TIPO}</td>
            </tr>

			<tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GENERAR}&nbsp;{$DESCARGAR}&nbsp;{$IMPRIMIR}</td>    
                            <td width="15%" align="right" ></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>
		<table width="100%">
			<tr><td colspan="7"><iframe id="framePlano" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table>   
	</fieldset>
    <fieldset> <legend align="center">	Cuentas Inscritas : </legend>
     {$GRIDPROVEEDORES}</fieldset>
    
</body>
</html>
