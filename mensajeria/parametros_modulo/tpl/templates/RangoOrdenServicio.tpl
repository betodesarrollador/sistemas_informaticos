<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Rango Guia</title>
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
                    <td><label>Busqueda :</label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
     </fieldset>   
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Empresa :</label></td>
                <td colspan="3">{$EMPRESAS}{$RANGOID}</td>
            </tr>
            <tr>
                <td><label>Agencia :</label></td>
                <td>{$AGENCIA}</td>
                <td><label>Fecha :</label></td>
                <td>{$FECHA}</td>
            </tr>
            <tr>
                <td><label>Disponible Desde :</label></td>
                <td>{$DISPOINICIAL}</td>
                <td><label>Cantidad Asignar :</label></td>
                <td>{$TOTAL}</td>
            </tr>
            <tr>
                <td><label>Rango Inicial :</label></td>
                <td>{$INICIAL}</td>
                <td><label>Rango Final :</label></td>
                <td>{$FINAL}</td>
            </tr>
            <tr>
                <td><label>Utilizados :</label></td>
                <td>{$UTILIZADO}</td>
                <td><label>Saldo :</label></td>
                <td>{$SALDO}</td>
            </tr>
            <tr>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>            
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
	            <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
    	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
	<fieldset>{$GRIDRANGOORDENSERVICIO}</fieldset>
</body>
</html>