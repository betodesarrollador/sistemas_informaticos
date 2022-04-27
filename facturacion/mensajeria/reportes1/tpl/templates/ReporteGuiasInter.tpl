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
                <td width="20%" align="center"><label>ESTADO</label></td>
                <td width="20%" align="center"><label>TIPO SERV.</label></td>                
                <td width="20%" align="center"><label>OFICINA</label></td>
                <td width="35%" align="center"><label>CLIENTE</label></td>
                <td width="20%" align="center"><label>ORIGEN</label></td>                
                <td width="20%" align="center"><label>DESTINO</label></td>
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                </td>
                <td valign="top"><label>Todos</label>{$ALLESTADO}<br/>{$ESTADO}</td>
                <td valign="top"><label>Todos</label>{$ALLSERV}<br/>{$TIP_SERV}</td>                
                <td valign="top"><label>Todos</label>{$ALLOFICINA}<br/>{$OFICINA}</td>                
                <td valign="top">{$SI_CLI}<br />{$CLIENTE}{$CLIENTEID}</td>
                <td valign="top">{$ORIGEN}{$ORIGENID}</td>             
                <td valign="top">{$DESTINO}{$DESTINOID}</td>
            </tr>

			<tr>
            	<td colspan="7">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="10%"></td>
                            <td width="60%" align="center">{$GENERAR}{$GENERAREXCEL}{$EXCELFORMATO}{$FOTOS}{$IMPRIMIR}</td>
                            <td width="10%"></td>
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
