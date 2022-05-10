<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body>
    <input type="hidden" id="orden_servicio_id" value="{$orden_servicio_id}" />
    <table align="center" id="tableDetalles" width="98%">
        <tbody>
            {foreach name=detalles from=$DETALLES item=i}
                <tr>
                    <td align="left">{$i.despuc_bien_servicio_factura}</td>
                    <td align="right">
                        <input type="text" name="valor" id="valor" value="{$i.valor|string_format:'%d'}"
                            class="required numeric {if $i.natu_bien_servicio_factura eq 'D' and $i.contra_bien_servicio_factura neq '1'}negativo{/if}" />
                        <input type="hidden" name="natu_bien_servicio_factura" id="natu_bien_servicio_factura"
                            value="{$i.natu_bien_servicio_factura}" />
                        <input type="hidden" name="puc_id" id="puc_id" value="{$i.puc_id}" />
                        <input type="hidden" name="contra_bien_servicio_factura" id="contra_bien_servicio_factura"
                            value="{$i.contra_bien_servicio_factura}" />
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</body>

</html>