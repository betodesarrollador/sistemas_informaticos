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
        <table align="center" width="99%">
            <tr>
                <td width="20%" align="center"><label>PERIODO</label></td>
                <td width="25%" align="center"><label>CLIENTE</label></td>
                 <td width="25%" align="center"><label>VEHICULO</label></td>
                {*<td width="15%" align="center"><label>OFICINA</label></td>*}
                <td width="15%" align="center"><label>TIPO DE REPORTE</label></td>
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}<br><br>
                	<label>Hora Inicial:</label> {$DESDEH}<br>
					<label>Hora final:&nbsp;&nbsp;&nbsp;</label> {$HASTAH}<br>
                    
                </td>
                <td valign="top">
                	{$SI_CLI}<br />{$CLIENTE}{$CLIENTEID}<br><br>
              		<label>CONDUCTOR</label><br>{$OPCIONESCONDUCTOR}<br>{$CONDUCTOR}{$CONDUCTORID}

                	
                
                </td>
                <td valign="top">{$SI_PLA}<br />{$PLACA}{$PLACAID}</td>
                {*<td valign="top"><label>Todos</label> {$ALLOFFICE}<br />{$OFICINA}</td>*}
                <td valign="top">
                	{$TIPO}<br><br>
                    <label>TIPO DE NOVEDAD</label><br>
                    {$TIPO_NOV}
                    <label>TIPO DE DOCUMENTO</label><br><br>
                    {$TIPO_DOC}
                    
                </td>
            </tr>
			<tr >
            	<td colspan="4">{$SOLOUNO} <label>Solo la Ultima Novedad</label></td>
            </tr>

			<tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GENERAR} &nbsp;{$DESCARGAR}&nbsp;{$DESCARGAR_CSV}&nbsp;{$IMPRIMIR}</td>
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
