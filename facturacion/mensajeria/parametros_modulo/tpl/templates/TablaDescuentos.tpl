<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Tabla de Descuentos</title>
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
    {$FORM1}{$DESCUENTOID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Empresa :</label></td>
                <td>{$EMPRESAS}</td>
                <td><label>Agencia :</label></td>
                <td>{$AGENCIA}</td>
            </tr>
            <tr>
                <td><label>Nombre Descuento :</label></td>
                <td>{$DESCUENTO}</td>
                <td><label>C&oacute;digo Contable :</label></td>
                <td>{$PUC}{$PUCID}</td>
            </tr>
            <tr>
                <td><label>Naturaleza : </label></td>
                <td>{$NATURALEZA}</td>
                <td><label>Calculo : </label></td>
                <td>{$CALCULO}</td>
            </tr>
            <tr>
                <td><label>Porcentaje :</label></td>
                <td>{$PORCENTAJE}</td>
                <td><label>Visible Impresi&oacute;n : </label></td>
                <td>{$VISIBLE}</td>
            </tr>	
            <tr>
                <td><label>Estado :</label></td>
                <td colspan="3">{$ESTADO}</td>
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
    <fieldset>{$GRIDTablaDescuentos}</fieldset>
</body>
</html>