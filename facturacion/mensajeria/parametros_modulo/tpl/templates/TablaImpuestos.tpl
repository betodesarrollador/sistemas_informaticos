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
    {$FORM1}{$TABLAIMPUESTOID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Empresa :</label></td><td>{$EMPRESAS}</td>
                <td><label>Agencia :</label></td><td>{$AGENCIA}</td>
            </tr>
            <tr>
                <td><label>Impuesto :</label></td><td>{$IMPUESTOID}</td>		  
                <td><label>Nombre :</label></td><td>{$NOMBRE}</td>
            </tr>
            <tr>
                <td><label>Base : </label></td>
                <td>{$BASE}</td>
                <td><label>Impuesto :</label></td>
                <td>{$BASEIMPUESTOID}</td>
            </tr>
            <tr>
                <td><label>Visible Impresi&oacute;n : </label></td>
                <td>{$VISIBLE}</td>
                <td><label>Orden : </label></td>
                <td>{$ORDEN}</td>
            </tr>		
            <tr>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
                <td colspan="2">
                	<table>
                    	<tr>
                        	<td><label>Rte : </label>{$RTE}</td>
                            <td><label>Ica : </label>{$ICA}</td>
						</tr>
					</table>
				</td>
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
    <fieldset>{$GRIDTABLAIMPUESTOS}</fieldset>

</body>
</html>