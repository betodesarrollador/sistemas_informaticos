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
	{*<input type="hidden" id="TIPO_UBI" value="{$TIPO_UBI}" />*}
    <table align="center" width="70%">
        <tr>
            <td><label>Tipo de Ubicaci&oacute;n :</label></td>
            <td align="left">{$TIPO_UBI}</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td><label>{if $TIPO_UBI eq 'D'} Pa&iacute;s : {elseif  $TIPO_UBI eq 'M'} Departamento : {/if}</label></td>
            <td align="left">{$PAIS}{$UBIUBICACIONID}</td>
        </tr>
        <tr>
            <td><label>{if $TIPO_UBI eq 'D'}Codigo Departamento : {elseif  $TIPO_UBI eq 'M'} Codigo Municipio : {/if}</label></td>
            <td align="left">{$COD_DEPTO}</td>
        </tr>      		                     
        <tr>
            <td><label>{if $TIPO_UBI eq 'D'}Nombre Departamento : {elseif  $TIPO_UBI eq 'M'} Nombre Municipio :{/if}</label></td>
            <td align="left">{$NOM_DEPARTAMENTO}{$DEPARTAMENTO}{$UBICACIONID}</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$LIMPIAR}</td>
        </tr>
	</table>
    {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDPERIODO}</fieldset>
</body>
</html>