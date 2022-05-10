<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Poliza Seguro</title>
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
                    <td ><label>Busqueda :</label></td>
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
                <td colspan="3">{$EMPRESAS}{$POLIZAID}</td>
            </tr>
            <tr>
                <td><label>Aseguradora :</label></td>
                <td colspan="3">{$ASEGURADORA}</td>
			</tr>
            <tr>
                <td><label>Fecha Expedici&oacute;n :</label></td>
                <td>{$EXPEDICION}</td>
                <td><label>Fecha Vencimiento :</label></td>
                <td>{$VENCIMIENTO}</td>
            </tr>
            <tr>
                <td><label>Poliza No. :</label></td>
                <td>{$POLIZA}</td>
                <td><label>Prima Mensual :</label></td>
                <td>{$VALOR}</td>
            </tr>
            <tr>
                <td><label>Deducible :</label></td>
                <td>{$DEDUCIBLE}</td>
                <td><label>Valor Maximo Despacho :</label></td>
                <td>{$VALORMAXIMO}</td>
            </tr>
            <tr>
                <td><label>Hora Inicio Autorizado :</label></td>
                <td>{$HORAINICIO}</td>
                <td><label>Hora Final Autorizado :</label></td>
                <td>{$HORAFINAL}</td>
            </tr>
            <tr>
                <td><label>Modelo Minimo :</label></td>
                <td>{$VALORMINIMO}</td>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
            </tr>                              
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {*<div><iframe id="detallePoliza"></iframe></div>*}
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDPOLIZASEGURO}</fieldset>

</body>
</html>