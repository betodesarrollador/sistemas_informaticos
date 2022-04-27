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
    <fieldset class="section">
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
    <fieldset class="section">
    {$FORM1}
    <table align="center">
        <tr>
            <td><label>Asunto  : </label></td>
            <td colspan="2">{$ERRORES_ID}{$ASUNTO}</td>
            <td><label>Fecha Ingreso Error : </label></td>
            <td align="center">{$FECHAERROR}</td>
        </tr>
        <tr>
            <td><label>Cliente : </label></td>
            <td colspan="4">{$CLIENTE_ID}{$CLIENTE}</td>
        </tr>
        <tr>
        	<td><label>Modulos : </label></td>
            <td colspan="2">{$MODULOS}</td>
            <td><label>Estado : </label></td>
            <td>{$ESTADO}{$USUARIOMOD}</td>
        </tr>
        <tr>
        <td><label>Descripci&oacute;n : </label></td>
        <td colspan="5">{$DESCRIPCION}{$USUARIOID}</td>
        </tr>
        <tr>
        <td><label>Soluci&oacute;n : </label></td>
        <td colspan="5">{$SOLUCION}</td>
        </tr>
        <tr>
		<td><label>Fecha Soluci&oacute;n  : </label></td>
        <td>{$FECHASOLUCION}</td>
        </tr>
        
        <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
        <tr>
        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
        </tr>
    </table>
    {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDFaq}</fieldset>

</body>
</html>
