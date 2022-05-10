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
                <td width="10%" align="center"><label>PERIODO</label></td>
                <td width="10%" align="center"><label>ESTADO</label></td>
                <td width="10%" align="center"><label>TIPO SERV.</label></td>
                <td width="15%" align="center"><label>USUARIO</label></td>                
                <td width="10%" align="center"><label>OFICINA</label></td>
                <td width="15%" align="center"><label>REMITENTE</label></td>
                <td width="15%" align="center"><label>DESTINATARIO</label></td>              
                
            </tr>
            
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                </td>
                <td valign="top"><label>Todos</label>{$ALLESTADO}<br/>{$ESTADO}</td>
                <td valign="top"><label>Todos</label>{$ALLSERV}<br/>{$TIP_SERV}</td>
                <td valign="top">{$SI_USU}<br />{$USUARIO}{$USUARIOID}</td>                
                <td valign="top"><label>Todos</label>{$ALLOFICINA}<br/>{$OFICINA}</td>                
                <td valign="top">{$SI_REM}<br />{$REMITENTE}{$REMITENTEID}</td>
                <td valign="top">{$SI_DES}<br />{$DESTINATARIO}{$DESTINATARIOID}</td>            
                
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top"><label>DESTINO</label> <br><br>{$DESTINO}{$DESTINOID}</td>
            <td valign="top"><label>ORIGEN</label> <br><br>{$ORIGEN}{$ORIGENID}</td> 
            </tr>

			<tr>
            	<td colspan="7">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="10%"></td>
                            <td width="60%" align="center">{$GENERAR}{$GENERAREXCEL}{$EXCELFORMATO}{$EXCELFILTRADO}{$FOTOS}{$IMPRIMIR}</td>
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
