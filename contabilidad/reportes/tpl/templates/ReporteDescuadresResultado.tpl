<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>
<body> 
    <input type="hidden" id="trazabilidad_id" value="{$TRAZABILIDAD}" />
    <table width="90%" align="center" id="encabezado" border="0">
        <tr>
        	<td width="30%">&nbsp;</td>
            <td align="center" class="titulo" width="40%"><b>
            {if $TRAZABILIDAD eq 'DD'} LISTADO DE DOCUMENTOS DESCUADRADOS
            {elseif $TRAZABILIDAD eq 'DA'} LISTADO DE DOCUMENTOS ABIERTOS
            {elseif $TRAZABILIDAD eq 'MC'} LISTADO DE MOVIMIENTOS SIN CENTRO DE COSTO
            {elseif $TRAZABILIDAD eq 'MT'} LISTADO MOVIMIENTOS DE CUENTAS PARAMETRO TERCERO SI, CON MOVIMIENTOS SIN TERCERO
            {elseif $TRAZABILIDAD eq 'MP'} LISTADO MOVIMIENTOS DE CUENTAS PARAMETRO TERCERO NO, CON MOVIMIENTOS CON TERCERO
            {elseif $TRAZABILIDAD eq 'MM'} LISTADO DE MOVIMIENTOS EN CUENTAS MAYORES
            {elseif $TRAZABILIDAD eq 'DM'} LISTADO DE DOCUMENTOS ANULADOS CON MOVIMIENTOS
            {elseif $TRAZABILIDAD eq 'MS'} LISTADO DE MOVIMIENTOS SIN CODIGO CONTABLE{/if}
            </b></td>
            <td width="30%" align="right">&nbsp;</td>
		</tr>	
        <tr>
        	<td align="center" colspan="3"><b>Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rango Final: {$HASTA}</b></td>
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
		</tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
		</tr>	
    </table>
    {if $TRAZABILIDAD eq 'DA'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"><a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank"> {$r.consecutivo} </a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}
    {if $TRAZABILIDAD eq 'DD'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"><a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank">{$r.consecutivo}</a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}

    {if $TRAZABILIDAD eq 'MC'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> <a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank">{$r.consecutivo} </a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}
    
    {if $TRAZABILIDAD eq 'MT'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> <a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank">{$r.consecutivo} </a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}

    {if $TRAZABILIDAD eq 'MP'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> <a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank">{$r.consecutivo} </a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}
    
    {if $TRAZABILIDAD eq 'MM'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> <a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank">{$r.consecutivo} </a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}
    
    {if $TRAZABILIDAD eq 'DM'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> <a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank">{$r.consecutivo} </a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}
        
    {if $TRAZABILIDAD eq 'MS'}   
    <table align="center" id="encabezado" width="90%">  
        <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NRO. DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> TIPO DE DOCUMENTO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TERCERO </th>
        </tr> 
    {counter start=0 skip=1 direction=up assign=i}      
    {foreach name=detalles from=$DETALLESDESCUADRES item=r}  
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> <a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank">{$r.consecutivo} </a></td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tipo_documento} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.tercero} </td>  
        </tr>  
    
    {counter}{/foreach}
    
    {/if}


    
    </table>
</body>
</html>