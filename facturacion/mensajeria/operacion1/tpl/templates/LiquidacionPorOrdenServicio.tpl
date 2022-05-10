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
    <legend>Datos Liquidaci&Oacute;n</legend>
    	<table align="center">
        	<tr>
                {$USUARIO}
                {$OFICINA}
                {$FECHALIQUIDACION}
                <td><label>Consecutivo : </label></td>
                <td colspan="3">{$LIQUIDACIONID}{$CONSECUTIVO}</td>
            </tr>
            <tr>
                {$CLIENTEID}
                <td><label>Cliente : </label></td>
                <td>{$CLIENTE}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td><label>Desde : </label></td>
                <td>{$DESDE}</td>
                <td><label>Hasta : </label></td>
                <td>{$HASTA}</td>
            </tr>
            <tr>
                <td colspan="5" align="center">{$IMPORTARSOLICITUD}</td>
            </tr>
        </table>
    </fieldset>
    <div id="divOrdenServicio">
        <iframe id="iframeOrdenServicio" style="height: 350px;"></iframe>
    </div>
    <div id="divDetallesOrden">
        <iframe id="iframeDetallesOrden" style="height: 150px;"></iframe>
    </div>
    <table align="center">
        <tr>
            <td colspan="4">{$GUARDAR}&nbsp;{$IMPRIMIR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;</td>
        </tr>
    </table>
    {$FORM1END}
    <div id="divAnulacion" align="center">
        <form onSubmit="return false">
            <table align="center">
                <tr>
                    <td colspan="2"><label>Descripci&oacute;n Anulaci&oacute;n :</label></td>
                </tr>
                <tr>
                    <td>{$OBSERVACIONANULA}</td>
                </tr>
                <tr>
                    <td>{$ANULAR}</td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>