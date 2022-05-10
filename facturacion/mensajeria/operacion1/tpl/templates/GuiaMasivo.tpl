<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Generar Guia por Lotes - SI&amp;SI</title>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  
</head>
<body>
    <fieldset>
    <legend>{$TITLEFORM}</legend>
    {$OFICINAHIDDEN}
    {$OFICINAIDHIDDEN}
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tbody>
                <tr>
                    <td><label>Cliente : </label></td>
                    <td colspan="3">{$CLIENTE}{$CLIENTEID}</td>
                </tr>
                <tr>
                    <td><label>Origen : </label></td>
                    <td>{$ORIGEN}{$ORIGENID}</td>
                    <td><label>Destino : </label></td>
                    <td>{$DESTINO}{$DESTINOID}</td>
                </tr>
                <tr>
                	<td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="4" align="center">{$BUSCAR}&nbsp;{$GUARDAR}&nbsp;</td>
                </tr>
            
            </tbody>
        </table>
        <div>
        	<iframe id="detalleCamposArchivoCliente" class="editableGrid"></iframe>
        </div>
    {$FORM1END}
    </fieldset>
</body>
</html>