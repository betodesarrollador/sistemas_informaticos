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
        <table align="center" width="60%">
            <tr>
                <td><label>Empresa   :</label></td>
                <td colspan="3">{$EMPRESAS}{$PERIODOID}</td>
            </tr>
            <tr>
                <td><label>Año : </label></td>
                <td align="left">{$ANIO}</td>
                <td><label>Periodo N&uacute;mero :</label></td>
                <td align="left">{$NUMERO}</td>
            </tr>
            <tr>
                <td><label>Fecha Inicio :</label></td>
                <td align="left">{$DESDE}</td>
                <td><label>Fecha Final : </label></td>
                <td>{$HASTA}</td>
            </tr> 
            <tr>
                <td><label>Mostrar :</label></td>
                <td align="left">{$MOSTRAR}</td>
                <td><label>Estado : </label></td>
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
    <fieldset>{$GRIDPERIODO}</fieldset>
</body>
</html>
{/if}