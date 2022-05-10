<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body>
    <input type="hidden" id="orden_servicio_id" value="{$orden_servicio_id}" />
    <table align="center" id="tableDetalles" width="98%">
        <thead>
            <tr>
                <th>CANTIDAD</th>
                <th>REMESA</th>
                <th>DESCRIPCION</th>
                <th>V/r UNITARIO</th>
                <th>VALOR TOTAL</th>
                <th id="titleSave">&nbsp;</th>
                <th><input type="checkbox" id="checkedAll"></th>
            </tr>
        </thead>
        <tbody>
            {foreach name=detalles from=$DETALLES item=i}
                <tr>
                    <td>
                        <input type="text" name="cant_item_orden_servicio" id="cant_item_orden_servicio"
                            value="{$i.cant_item_orden_servicio}" class="required numeric"
                            {if $i.estado_orden_servicio neq 'A'}readonly{/if} size="10" />
                        <input type="hidden" name="item_orden_servicio_id" value="{$i.item_orden_servicio_id}" />
                    </td>
                    <td>
                        <input type="text" name="remesa" id="remesa" value="{$i.remesa}" class=""
                            {if $i.estado_orden_servicio neq 'A'}readonly{/if} size="10" />
                        <input type="hidden" name="remesa_id" value="{$i.remesa_id}" />
                    </td>
                    <td><input type="text" name="desc_item_orden_servicio" id="desc_item_orden_servicio"
                            value="{$i.desc_item_orden_servicio}" class="required"
                            {if $i.estado_orden_servicio neq 'A'}readonly{/if} /></td>
                    <td><input type="text" name="valoruni_item_orden_servicio" id="valoruni_item_orden_servicio"
                            value="{$i.valoruni_item_orden_servicio}" class="required numeric"
                            {if $i.estado_orden_servicio neq 'A'}readonly{/if} /></td>
                    <td><input type="text" name="valor_total" id="valor_total"
                            value="{math equation="x * y" x=$i.cant_item_orden_servicio y=$i.valoruni_item_orden_servicio}"
                            class="numeric no_requerido" readonly /></td>
                    <td>{if $i.estado_orden_servicio eq 'A'}<a name="saveDetalles"><img
                                src="../../../framework/media/images/grid/add.png" /></a>{/if}</td>
                    <td>{if $i.estado_orden_servicio eq 'A'}<input type="checkbox" name="procesar" />{/if}</td>
                </tr>
            {/foreach}
            {if $i.estado_orden_servicio eq 'A' or  $i.estado_orden_servicio eq ''}
                <tr>
                    <td>
                        <input type="text" name="cant_item_orden_servicio" id="cant_item_orden_servicio" value=""
                            class="required numeric" size="10" />
                        <input type="hidden" name="item_orden_servicio_id" value="" />
                    </td>
                    <td>
                        <input type="text" name="remesa" id="remesa" value="" class="" size="10" />
                        <input type="hidden" name="remesa_id" value="" />
                    </td>

                    <td><input type="text" name="desc_item_orden_servicio" id="desc_item_orden_servicio" value=""
                            class="required" /></td>
                    <td><input type="text" name="valoruni_item_orden_servicio" id="valoruni_item_orden_servicio" value=""
                            class="required numeric" /></td>
                    <td><input type="text" name="valor_total" id="valor_total" value="" class="numeric no_requerido"
                            readonly /></td>
                    <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png"
                                alt="Adicionar" /></a></td>
                    <td><input type="checkbox" name="procesar" /></td>
                </tr>
            {/if}
        </tbody>
    </table>
    <table width="98%" align="center">
        <tr id="clon">
            <td>
                <input type="text" name="cant_item_orden_servicio" id="cant_item_orden_servicio" value=""
                    class="required numeric" size="10" />
                <input type="hidden" name="item_orden_servicio_id" value="" />
            </td>
            <td>
                <input type="text" name="remesa" id="remesa" value="" class="" size="10" />
                <input type="hidden" name="remesa_id" value="" />
            </td>

            <td><input type="text" name="desc_item_orden_servicio" id="desc_item_orden_servicio" value=""
                    class="required" /></td>
            <td><input type="text" name="valoruni_item_orden_servicio" id="valoruni_item_orden_servicio" value=""
                    class="required numeric" /></td>
            <td><input type="text" name="valor_total" id="valor_total" value="" class="numeric no_requerido" readonly />
            </td>
            <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a>
            </td>
            <td><input type="checkbox" name="procesar" /></td>
        </tr>
    </table>
</body>

</html>