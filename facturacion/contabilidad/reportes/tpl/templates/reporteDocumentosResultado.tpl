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
                        {if $TRAZABILIDAD eq 'E'} LISTADO DE DOCUMENTOS EN ESTADO EDICION
                        {elseif $TRAZABILIDAD eq 'C'} LISTADO DE DOCUMENTOS EN ESTADO CONTABILIZADO
                        {elseif $TRAZABILIDAD eq 'A'} LISTADO DE DOCUMENTOS EN ESTADO ANULADOS
                        {/if}
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
        {if $TRAZABILIDAD eq 'E'}
            <table align="center" id="encabezado" width="90%">
                <tr>
                    <th class="borderLeft borderTop borderRight borderBottom" align="center"> MODULO </th>
                    <th class="borderLeft borderTop borderRight borderBottom" align="center"> FECHA DOC </th>
                    <th class="borderTop borderRight borderBottom" align="center"> CODIGO OFICINA </th>
                    <th class="borderTop borderRight borderBottom" align="center"> NOMBRE OFICINA </th>
                    <th class="borderTop borderRight borderBottom" align="center"> USUARIO </th>
                </tr>
                {counter start=0 skip=1 direction=up assign=i}
                {foreach name=detalles from=$DETALLESDESCUADRES item=r}
        
                    {foreach name=item from=$r item=l}
            
                        <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
            
                            <td class="borderLeft borderTop borderRight borderBottom" align="center"><a href="{$l.direccion}?ACTIVIDADID=75&{$l.llave}={$l.consecutivo}" target="_blank"> {$l.modulo} </a></td>
                            <td class="borderTop borderRight borderBottom" align="center"> {$l.fecha} </td>
                            <td class="borderTop borderRight borderBottom" align="center"> {$l.oficina_codigo} </td>
                            <td class="borderTop borderRight borderBottom" align="center"> {$l.oficina_nombre} </td> 
                            <td class="borderTop borderRight borderBottom" align="center"> {$l.modifica} </td>
            
                        </tr>
                    {/foreach}
                {counter}{/foreach}
    
            {/if}

            {if $TRAZABILIDAD eq 'C'}
                <table align="center" id="encabezado" width="90%">
                    <tr>
                        <th class="borderLeft borderTop borderRight borderBottom" align="center"> MODULO </th>
                        <th class="borderLeft borderTop borderRight borderBottom" align="center"> FECHA DOC </th>
                        <th class="borderTop borderRight borderBottom" align="center"> CODIGO OFICINA </th>
                        <th class="borderTop borderRight borderBottom" align="center"> NOMBRE OFICINA </th>
                        <th class="borderTop borderRight borderBottom" align="center"> USUARIO </th>
                    </tr>
                    {counter start=0 skip=1 direction=up assign=i}
                    {foreach name=detalles from=$DETALLESDESCUADRES item=r}
        
                        <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
        
                            <td class="borderLeft borderTop borderRight borderBottom" align="center"><a href="../../../contabilidad/movimientos/clases/MovimientosContablesClass.php?ACTIVIDADID=75&encabezado_registro_id={$r.encabezado_registro_id}" target="_blank"> CONTABILIDAD </a></td>
                            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha}</td>
                            <td class="borderTop borderRight borderBottom" align="center"> {$r.oficina_codigo}</td>
                            <td class="borderTop borderRight borderBottom" align="center"> {$r.oficina_nombre} </td> 
                            <td class="borderTop borderRight borderBottom" align="center"> {$r.modifica} </td>
        
                        </tr>
        
                    {counter}{/foreach}
    
                {/if} 

                {if $TRAZABILIDAD eq 'I'}
                    <table align="center" id="encabezado" width="90%">
                        <tr>
                            <th class="borderLeft borderTop borderRight borderBottom" align="center"> MODULO </th>
                            <th class="borderLeft borderTop borderRight borderBottom" align="center"> FECHA DOC </th>
                            <th class="borderTop borderRight borderBottom" align="center"> CODIGO OFICINA </th>
                            <th class="borderTop borderRight borderBottom" align="center"> NOMBRE OFICINA </th>
                            <th class="borderTop borderRight borderBottom" align="center"> USUARIO </th>
                        </tr>
                        {counter start=0 skip=1 direction=up assign=i}
                        {foreach name=detalles from=$DETALLESDESCUADRES item=r}
        
                            {foreach name=item from=$r item=l}
            
                                <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
            
                                    <td class="borderLeft borderTop borderRight borderBottom" align="center"><a href="{$l.direccion}?ACTIVIDADID=75&{$l.llave}={$l.consecutivo}" target="_blank"> {$l.modulo} </a></td>
                                    <td class="borderTop borderRight borderBottom" align="center"> {$l.fecha} </td>
                                    <td class="borderTop borderRight borderBottom" align="center"> {$l.oficina_codigo} </td>
                                    <td class="borderTop borderRight borderBottom" align="center"> {$l.oficina_nombre} </td> 
                                    <td class="borderTop borderRight borderBottom" align="center"> {$l.modifica} </td>
            
                                </tr>
                            {/foreach}
                        {counter}{/foreach}
    
                    {/if}
                </table>
    </body>

</html>