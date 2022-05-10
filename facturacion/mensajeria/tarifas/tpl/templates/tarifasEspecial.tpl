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
        <div id="table_find">
            <table>
                <tr>                
                    <td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
	</fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tr>
                {$TARIFAID}
                <td><label>Origen :</label></td>
                <td>{$ORIGENID}{$ORIGEN}</td>
                <td><label>Destino :</label></td>
                <td>{$DESTINOID}{$DESTINO}</td>
                <td><label>Tipo Envio :</label></td>
                <td>{$TIPOENVIOID}</td>
            </tr>
            <tr>
                <td><label>Valor Primer KG :</label></td>
                <td >{$VALORPRIMERKG}</td>
                <td><label>Valor KG Adicional :</label></td>
                <td>{$VALORADDKG}</td>
                <td><label>Tipo Servicio:</label></td> 
                <td>{$TIPOSERVICIOID}</td>
                
            </tr>            
            <tr>
                <td  colspan="4"align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$DUPLICAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDTARIFASESPECIALES}</fieldset>      
</body>
</html>