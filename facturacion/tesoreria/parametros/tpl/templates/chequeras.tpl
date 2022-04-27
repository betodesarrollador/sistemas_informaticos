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
                <td><label>Banco :</label></td>
                <td>{$BANCO}{$BANCOID}{$CHEQUERAID}</td>
                <td><label>Cuenta PUC :</label></td>
                <td>{$PUC}{$PUCID}</td>
            </tr>
            <tr>
                <td><label>Tipo Cuenta :</label></td>
                <td>{$TIPOCUEN}</td>           
                <td><label>Referencia :</label></td>
                <td>{$REFERENCIA}</td>
            </tr>          
            <tr>
                <td><label>Rango Inicial : </label></td>
                <td align="left">{$RANGOINI}</td>
                <td ><label>Rango Final :</label></td>
                <td align="left">{$RANGOFIN}</td>
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
    <fieldset>{$GRIDCHEQUERAS}</fieldset>
</body>
</html>
{/if}