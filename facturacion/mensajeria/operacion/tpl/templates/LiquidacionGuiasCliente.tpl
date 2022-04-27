<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
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
    <legend>Datos Liquidaci&oacute;n</legend>
        <table width="90%" align="center">
            <tr>
                <td width="10%"><label>Consecutivo : </label></td>
                <td colspan="3">{$LIQUIDACIONID}{$CONSECUTIVO}{$OFICINAID}{$USUARIOID}{$FECHA_REG}{$GUIASID}</td>
            </tr>
            <tr>
                <td><label>Cliente : </label></td>
                <td >{$CLIENTEID}{$CLIENTE}</td>
                <td><label>Oficina :</label></td>
                <td>{$OFICINAID1}</td>
            </tr>
            <tr>
                <td><label>Desde : </label></td>
                <td>{$DESDE}</td>
                <td><label>Hasta : </label></td>
                <td>{$HASTA}</td>
            </tr>
            <tr>
                <td><label>Valor : </label></td>
                <td>{$VALOR}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td> &nbsp;</td>
                <td>{$IMPORTARSOLICITUD}</td>
                <td><label>Ultima Liquidaci&oacute;n : </label></td>
                <td>{$UltimaLiquidacion}</td>
            </tr>
           	<tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}&nbsp;</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section" > 
    <legend>GUIAS</legend>
        <iframe id="detalleLiquidacion" src=""></iframe> 
    </fieldset>
    <div id="divOrdenServicio">
        <iframe id="iframeOrdenServicio" style="height: 370px;"></iframe>
    </div>
    {$FORM1END}
    </fieldset>
    <div id="divAnulacion">
        <form onSubmit="return false">
            <table>              
                <tr>
                    <td><label>Descripci&oacute;n Anulaci&oacute;n :</label></td>
                    <td>{$OBSERVANULACION}</td>
                </tr> 
                <tr>
                    <td colspan="2" align="center">{$ANULAR}</td>
                </tr>                    
            </table>
        </form>
    </div>
</body>
</html>