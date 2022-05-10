<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body>
    <input type="hidden" id="tipo" value="{$tipo}" />

    <table width="90%" align="center" id="encabezado" border="0">
        <tr>
            <td width="30%">&nbsp;</td>
            <td align="center" class="titulo" width="40%">REMESAS POR ORIGEN</td>
            <td width="30%" align="right">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" colspan="4">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td>
        </tr>
    </table>

    <table align="center" class="table" id="encabezado" width="90%">
    <thead class="table-primary">
        <tr>
            <th class="borderLeft borderTop borderRight">ORIGEN</th>
            <th class="borderTop borderRight">NUM REMESA</th>
            <th class="borderTop borderRight">VALOR REMESA</th>
            <th class="borderTop borderRight">NUM FACTURA</th>
            <th class="borderTop borderRight">VALOR FACTURA</th>
        </tr>
    </thead>
        {foreach name=detalles from=$DETALLES item=i}
        <tr bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.origen} </td>
            <td class="borderTop borderRight">{$i.numero_remesa}</td>
            <td class="borderTop borderRight" align="right">{$i.valor_facturar|number_format:2:',':'.'}</td>
            <td class="borderTop borderRight">{$i.consecutivo_factura}</td>
            <td class="borderTop borderRight" align="right">{$i.valor|number_format:2:',':'.'}</td>
        </tr>
        {/foreach}
    </table>
</body>

</html>