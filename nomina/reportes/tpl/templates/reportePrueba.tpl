<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
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
                <td width="25%" align="center"><label>PERIODO</label></td>
                <td width="40%" align="center"><label>CONVOCADO</label></td>
                <td width="40%" align="center"><label>CARGO</label></td>
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                </td>
                <td valign="top">{$SI_CON}<br />{$CONVOCADO}{$CONVOCADOID}</td>
                <td valign="top">{$SI_CAR}<br />{$CARGO}{$CARGOID}</td>
  
            </tr>

			<tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="20%"></td>
                            <td width="50%" align="center">{$GENERAR}{$IMPRIMIR}{$LIMPIAR} <input class="btn btn-primary" type="button" name="generar_excel" id="generar_excel" value="Generar Archivo Excel>>" /></td>
                            <td width="20%"></td>
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
