{if $sectionOficinasTree neq 1}
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
        <table width="70%" align="center">
            <tr>
                <td><label>Empresa :</label></td>
                <td>{$EMPRESAS}{$TOPEID}</td>
                <td><label>Oficina :</label></td>
                <td>{$OFICINA}</td>
            </tr>
            <tr>
                <td><label>Periodo : </label></td>
                <td align="left">{$PERIODO}</td>
                <td><label>Valor Tope :</label></td>
                <td align="left">{$VALOR}</td>
            </tr>
            <tr>
                <td><label>Porcentaje : </label></td>
                <td align="left">{$PORCENTAJE}</td>
                <td><label>Fecha Inicio :</label></td>
                <td>{$FECHAINICIO}</td>
            </tr>
            <tr>
                <td><label>Fecha Final : </label></td>
                <td align="left">{$FECHAFINAL}</td>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td><label>Descripci&oacute;n : </label></td>
                <td colspan="3" align="left">{$DESCRIPCION}</td>
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
    <fieldset>{$GRIDTOPE}</fieldset>
</body>
</html>
{/if}