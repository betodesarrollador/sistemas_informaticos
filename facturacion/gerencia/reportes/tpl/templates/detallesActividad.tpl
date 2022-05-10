<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/application/framework/css/bootstrap1.css">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body style="padding: 8px;">
    <input type="hidden" id="tipo" value="{$tipo}" />

    <table width="90%" align="center" id="encabezado">
        <tr>
            <td width="30%">&nbsp;</td>
            <td align="center" class="titulo" width="40%">{if $tipo eq 'VF'}Valor Facturado{elseif $tipo eq 'IN'}INGRESOS{elseif $tipo eq 'VP'}VALOR PROVEEDOR{elseif $tipo eq 'GA'}VALOR DE GASTO{/if}</td>
            <td width="30%" align="right">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td>
        </tr>
    </table>


    {if $tipo eq 'VF'}
    
        <table align="center" id="encabezado" width="100%" class="table table-striped">
            <tr>
                <th class="borderLeft borderTop borderRight" align="center"> CANTIDAD DE FACTURAS </th>
                <th class="borderTop borderRight" align="center"> VALOR FACTURADO </th>
                <th class="borderTop borderRight" align="center"> EMPRESA </th>
            </tr>
            {counter start=0 skip=1 direction=up assign=i}
            {foreach name=detalles from=$DETALLES item=r}
        
                <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
        
                    <td class="borderLeft borderTop borderRight borderBottom" align="center"> {$r.num_factura} </td>
                    <td class="borderTop borderRight borderBottom" align="center"> {$r.valor_facturado|number_format:0:',':'.'} </td>
                  <td class="borderTop borderRight borderBottom" align="center"> {$r.empresa} </td>
        
                </tr>
        
            {counter}{/foreach} 
        </table>
    
    {/if} 


    {if $tipo eq 'IN'}
    
        <table align="center" id="encabezado" width="100%" class="table table-striped">
            <tr>
                <th class="borderLeft borderTop borderRight" align="center"> VALOR DE INGRESO </th>
                <th class="borderTop borderRight" align="center"> EMPRESA </th>
    
            </tr>
            {counter start=0 skip=1 direction=up assign=i}
            {foreach name=detalles from=$DETALLES item=r}
        
                <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
        
                    <td class="borderLeft borderTop borderRight borderBottom" align="center"> {$r.valor_ingreso|number_format:0:',':'.'} </td>
                    <td class="borderTop borderRight borderBottom" align="center"> {$r.empresa|replace:"siandsi":""} </td>
        
                </tr>
        
            {counter}{/foreach} 
        </table>
    
    {/if} 


    {if $tipo eq 'VP'}
    
        <table align="center" id="encabezado" width="100%" class="table table-striped">
            <tr>
                <th class="borderLeft borderTop borderRight" align="center"> CANTIDAD DE FACTURAS </th>
                <th class="borderTop borderRight" align="center"> VALOR FACTURADO </th>
                <th class="borderTop borderRight" align="center"> EMPRESA </th>
            </tr>
            {counter start=0 skip=1 direction=up assign=i}
            {foreach name=detalles from=$DETALLES item=r}
        
                <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
        
                    <td class="borderLeft borderTop borderRight borderBottom" align="center"> {$r.num_factura} </td>
                    <td class="borderTop borderRight borderBottom" align="center"> {$r.valor_facturado|number_format:0:',':'.'} </td>
<td class="borderTop borderRight borderBottom" align="center"> {$r.empresa|replace:"siandsi":""} </td>
        
                </tr>
        
            {counter}{/foreach} 
        </table>
    
    {/if} 

    {if $tipo eq 'GA'}
    
        <table align="center" id="encabezado" width="100%" class="table table-striped">
            <tr>
                <th class="borderLeft borderTop borderRight" align="center"> VALOR DE GASTO </th>
                <th class="borderTop borderRight" align="center"> EMPRESA </th>
    
            </tr>
            {counter start=0 skip=1 direction=up assign=i}
            {foreach name=detalles from=$DETALLES item=r}
        
                <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
        
                    <td class="borderLeft borderTop borderRight borderBottom" align="center"> {$r.valor_gasto|number_format:0:',':'.'} </td>
                    <td class="borderTop borderRight borderBottom" align="center"> {$r.empresa|replace:"siandsi":""} </td>
        
                </tr>
        
            {counter}{/foreach} 
        </table>
    
    {/if} 
</body>

</html>