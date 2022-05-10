<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Calcular Tarifa - SI&amp;SI™</title>
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
                <tbody>
                    <tr>
                        <td><label>Busqueda : </label></td>
                        <td>{$BUSQUEDA}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </fieldset>
    {$OFICINAHIDDEN}
    {$OFICINAIDHIDDEN}
    {$FECHASTATIC}
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tbody>
                <tr>
                    <td><label>Consecutivo : </label></td>
                    <td>{$SOLICITUDID}</td>
                    <td><label>Fecha :</label></td>
                    <td>{$FECHA}</td>
                </tr>
                <tr>
                    <td><label>Oficina :</label></td>
                    <td>{$OFICINA}{$OFICINAID}</td>
                    <td><label>Cliente : </label></td>
                    <td>{$CLIENTE}{$CLIENTEID}</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center">{$GUARDAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
                </tr>
            </tbody>
        </table>
        <table id="toolbar">
            <tbody>
                <tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">&nbsp;</td>
                    <td id="fileUpload">{$ARCHIVOSOLICITUD}&nbsp;&nbsp;&nbsp;</td>
                </tr>               
            </tbody>
        </table>
    <fieldset class="section">
    <legend>Tarifas</legend>
        <iframe id="detalleCalculoTarifasRutaCubicajeCalculado" class="editableGrid"></iframe>
    </fieldset>	  
    <fieldset id="detalleSolicitud" class="section">
    <legend>Detalle Solicitud</legend>
        <iframe id="detalleCalculoTarifasRutaCubicaje" class="editableGrid"></iframe>
    </fieldset>	  
    {$FORM1END}
    </fieldset>
</body>
</html>