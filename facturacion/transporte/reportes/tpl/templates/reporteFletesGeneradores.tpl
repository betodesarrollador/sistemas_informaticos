<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">    
        {$JAVASCRIPT}
        {$CSSSYSTEM} 
        {$TITLETAB}  
    </head>
    <body>
        <legend>{$TITLEFORM}</legend>
        {$FORM1}
            <fieldset class="section">
            <table align="center" width="90%">
                <tr>
                    <td width="25%" align="center"><label>PERIODO</label></td>
                    <td width="35%" align="center"><label>CLIENTE</label></td>
                    <td width="20%" align="center"><label>OFICINA</label></td>
                    <td width="20%" align="center"><label>TIPO DESPACHO</label></td>
                    {*<td width="20%" align="center"><label>TIPO REPORTE</label></td>*}
                </tr>
                <tr>
                    <td valign="top">
                    	<label>Desde:&nbsp;</label> {$DESDE}<br>
    					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                    </td>
                    <td valign="top">{$SI_CLI}<br />{$CLIENTE}{$CLIENTEID}</td>
                    <td valign="top"><label>Todos</label>{$ALLOFFICE}<br/>{$OFICINA}</td>
                    <td valign="top"><label>Todos</label>{$ALLESTADO}<br/>{$ESTADO}</td>
                    {*<td valign="top">{$TRAZABILIDAD}</td>*}
                </tr>
    			<tr>
                	<td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5" align="center">
                        <table width="100%">
                            <tr>
                                <td id="loading" width="20%"></td>
                                <td width="50%" align="center">{$GENERAR}{$IMPRIMIR}{$EXCEL}</td>
                                <td width="20%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </fieldset>       
    	{$FORM1END}
        {$FORM2}
            <iframe id="frameReporte" name="frameReporte" src="" height="300"></iframe>
        {$FORM2END}
    </body>
</html>
