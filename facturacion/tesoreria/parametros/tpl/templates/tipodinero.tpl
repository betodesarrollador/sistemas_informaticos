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
                	<td><label>Busqueda :</label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>        
    {$FORM1}
    <fieldset class="section">
        <table width="60%" align="center">
            <tr>
                <td><label>Tipo :</label></td>
                <td>{$TIPODINID}{$TIPO}</td>
                <td><label>Nombre :</label></td>
                <td>{$NOMBRE}</td>
            </tr>
            <tr>
                <td><label>Valor :</label></td>
                <td>{$VALOR}</td>           
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
    {$FORM1END}
    </fieldset>    
    <fieldset>{$GRIDTIPODINERO}</fieldset>
</body>
</html>
{/if}