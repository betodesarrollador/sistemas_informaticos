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
            <table>
                <tr>
                    <td><label>BUSCAR POR GUIA</label></td>
                    <td>{$ALLGUIA}</td>
                    <td><label>GUIA Nº</label></td>
                    <td align="center">{$GUIAID}</td>
                </tr>
                <tr>
                    <td><label>BUSCAR POR MANIFIESTO</label></td>
                    <td>{$ALLREEXPEDIDO}</td>
                    <td><label>MANIFIESTO Nº</label></td>
                    <td align="center">{$REEXPEDIDO}</td>
                    <td><label>CONSOLIDADO</label></td>
                    <td>{$CONSOLIDADOREX}</td>
                </tr>
            </table>
        </fieldset>
         <fieldset class="section">
        <table align="center" width="90%">
            
            <div id="general">
                <tr>
                    <td align="center"><label>PERIODO</label></td>
                    <td align="center"><label>ESTADO</label></td>
                    <td align="center"><label>TIPO SERV.</label></td>
                    <td align="center"><label>USUARIO</label></td>                    
                    <td align="center"><label>OFICINA</label></td>
                    <td align="center"><label>MENSAJERO</label></td>
                    <td align="center"><label>ORIGEN</label></td>                
                    <td align="center"><label>DESTINO</label></td> 
                </tr>
                <tr>
                    <td valign="top">
                    	<label>Desde:&nbsp;</label> {$DESDE}<br>
    					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                    </td>
                    <td valign="top"><label>Todos</label>{$ALLESTADO}<br>{$ESTADO}</td>
                    <td valign="top"><label>Todos</label>{$ALLSERV}<br>{$SERVICIO}</td> 
                     <td valign="top">{$SI_USU}<br />{$USUARIO}{$USUARIOID}</td>                   
                    <td valign="top"><label>Todos</label>{$ALLOFICINA}<br>{$OFICINA}</td>
                    <td valign="top">{$SI_ME}<br />{$MENSAJERO}{$MENSAJEROID}<br><br><br><label>PLACA</label>&emsp;&emsp;{$PLACA}</td>
                    <td valign="top">{$ORIGEN}{$ORIGENID}<br><br><label><br><br>Peso:&nbsp;&nbsp;&nbsp;</label> {$PESO} </td>         
                    <td valign="top">{$DESTINO}{$DESTINOID}<br><br><label>GUIA:&nbsp;&nbsp;&nbsp;</label><br><br><label>Todos</label>{$ALLGUIAS}<br>{$GUIA}</td>
                </tr>
            </div>
			<tr>
            	<td colspan="5">&emsp;</td>
            </tr>
            <tr>
                <td colspan="5" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="20%"></td>
                            <td width="50%" align="center">{$GENERAR}{$GENERAREXCEL}{$EXCELFILTRADO}{$IMPRIMIR}</td>
                            <td width="20%"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>
		{$FORM1END}
        <table width="100%">
            <tr><td colspan="7"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
        </table>        
	</fieldset>
    
</body>
</html>
