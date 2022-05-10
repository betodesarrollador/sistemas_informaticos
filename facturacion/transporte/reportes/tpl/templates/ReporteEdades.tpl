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
                <td width="25%" align="center"><label>PERIODO</label></td>
                <td width="35%" align="center"><label>VEHICULO</label></td>
                <td width="35%" align="center"><label>TENEDOR</label></td>
                <td width="20%" align="center"><label>OFICINA</label></td>
                <td width="20%" align="center"><label>TIPO DE DOCUMENTO</label></td>
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                </td>
                <td valign="top">{$SI_VEH}<br />{$VEHICULO}{$VEHICULOID}</td>
                <td valign="top">
                	{$SI_TEN}<br />{$TENEDOR}{$TENEDORID}<br/><br/>
                    <label>Estado</label><br/>{$ESTADO}
                </td>
                <td valign="top"><label>Todos</label>{$ALLOFFICE}<br/>{$OFICINA}</td>
                <td valign="top">
                	<label>Todos</label>{$ALLDOCUMENTO}<br/>{$TIPO}
                </td>
            </tr>

			<tr>
            	<td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="20%"></td>
                            <td width="50%" align="center">{$GENERAR}{$IMPRIMIR} {$EXCEL}</td>
                            
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
