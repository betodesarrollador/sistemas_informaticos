<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body>
    <input type="hidden" id="tipo" value="{$tipo}" />
    <input type="hidden" id="filtro" value="{$filtro}" />

    <table width="90%" align="center" id="encabezado" border="0">
        <tr>
            <td width="30%">&nbsp;</td>
            <td align="center" class="titulo" width="40%">
                {if $tipo eq 'PECC'}CARTERA TOTAL CLIENTE {$cliente}
                {elseif  $tipo eq 'FDAF'}CONTRATOS AFIANZADOS DIRECTAS PERIODO
                {/if}</td>
            <td width="30%" align="right">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" align="center"> EDAD :
            {if $filtro eq 'ALL'}TODAS LAS EDADES
              {elseif  $filtro eq 'tipo0'} MENOR A 1 DIA
                {elseif  $filtro eq 'tipo30'} 1 A 30 DIAS
                  {elseif  $filtro eq 'tipo60'} 31 A 60 DIAS
                    {elseif  $filtro eq 'tipo90'} 61 A 90 DIAS
                      {elseif  $filtro eq 'tipo10'} MAYOR A 90 DIAS
                      {/if}
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" colspan="3">Periodo : {$desde} al {$hasta}</td>
        </tr>
    </table>

    <table align="center" id="encabezado" width="90%">
        {if $tipo eq 'PECC' }
            {assign var="acumula_valor" value="0"}
            {assign var="acumula_impuestos" value="0"}
            {assign var="acumula_abonos" value="0"}
            <tr>
                <th class="borderLeft borderTop borderRight">CONSECUTIVO</th>
                <th class="borderLeft borderTop borderRight">FECHA</th>
                <th class="borderLeft borderTop borderRight">VENCE</th>
                <th class="borderLeft borderTop borderRight">DIAS</th>
                <th class="borderLeft borderTop borderRight">OFICINA</th>
                <th class="borderLeft borderTop borderRight">CENTRO</th>
                <th class="borderLeft borderTop borderRight">ESTADO</th>
                <th class="borderLeft borderTop borderRight">VALOR IMPUESTOS</th>
                <th class="borderLeft borderTop borderRight">VALOR NETO</th>
                <th class="borderLeft borderTop borderRight">ABONOS</th>

            </tr>
            {foreach name=detalles from=$pendiente item=i}
                {math assign="acumula_valor" equation="x + y" x=$acumula_valor y=$i.valor_neto}
                {math assign="acumula_impuestos" equation="x + y" x=$acumula_impuestos y=$i.valor_impuestos}
                {math assign="acumula_abonos" equation="x + y" x=$acumula_abonos y=$i.abonos}
                <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}" class="{$i.dias}" name="filaDetalles">
                    <td class="borderTop borderRight" align="right">{$i.consecutivo_factura}</td>
                    <td class="borderTop borderRight" align="right">{$i.fecha}</td>
                    <td class="borderTop borderRight" align="right">{$i.vencimiento}</td>
                    <td class="borderTop borderRight" align="right">{$i.dias}</td>
                    <td class="borderTop borderRight" align="left">{$i.oficina}</td>
                    <td class="borderTop borderRight" align="left">{$i.centro}</td>
                    <td class="borderTop borderRight" align="left">{$i.estado}</td>
                    <td class="borderTop borderRight" align="right">${$i.valor_impuestos|number_format:0:',':'.'}</td>
                    <td class="borderTop borderRight" align="right">${$i.valor_neto|number_format:0:',':'.'}</td>
                    <td class="borderTop borderRight" align="right">${$i.abonos|number_format:0:',':'.'}</td>


                </tr>
            {/foreach}
            <tr bgcolor="#CCCCCC">
                <th class="borderLeft borderTop borderRight" colspan="7">TOTALES</th>
                <th class="borderLeft borderTop borderRight">${$acumula_impuestos|number_format:0:',':'.'}</th>
                <th class="borderLeft borderTop borderRight">${$acumula_valor|number_format:0:',':'.'}</th>
                <th class="borderLeft borderTop borderRight">${$acumula_abonos|number_format:0:',':'.'}</th>
            </tr>

        {/if}


    </table>
</body>

</html>