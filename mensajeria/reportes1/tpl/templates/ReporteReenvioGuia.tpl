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
         
            </table>
        </fieldset>
         <fieldset class="section">
        <table align="center" width="90%">
            
            <div id="general">
                <tr>
                    <td align="center"><label>PERIODO</label></td>
                    <td align="center"><label>ESTADO</label></td>
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
                    <td valign="top"><label>Todos</label>{$ALLOFICINA}<br>{$OFICINA}</td>
                    <td valign="top">{$SI_ME}<br />{$MENSAJERO}{$MENSAJEROID}</td>
                    <td valign="top">{$ORIGEN}{$ORIGENID}</td>             
                    <td valign="top">{$DESTINO}{$DESTINOID}</td>
                </tr>
            </div>
			<tr>
            	<td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="20%"></td>
                            <td width="50%" align="center">{$GENERAR}{$GENERAREXCEL}{$IMPRIMIR}</td>
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
