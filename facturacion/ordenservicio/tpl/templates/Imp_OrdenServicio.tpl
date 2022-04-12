{literal}
    <style>
        /* CSS Document */

        table tr td {
            font-size: 12px;
        }

        .title {
            background-color: #999999;
            font-weight: bold;
            text-align: center;
        }

        .fontBig {
            font-size: 10px;
        }

        .infoGeneral {
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            text-align: center;
        }

        .cellTitle {
            background-color: #999999;
            font-weight: bold;
            text-align: center;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        }

        .cellRight {
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            text-align: left;
            padding: 3px;

        }

        .cellRightRed {
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            text-align: left;
            padding: 3px;
            color: #F00;

        }

        .cellLeft {
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            text-align: left;
            padding: 3px;
        }

        .cellCenter {
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            text-align: center;
        }

        .cellTitleLeft {
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            border-top: 1px solid;
            background-color: #999999;
            font-weight: bold;
            text-align: center;
        }

        .cellTitleRight {
            border-right: 1px solid;
            border-bottom: 1px solid;
            border-top: 1px solid;
            background-color: #999999;
            font-weight: bold;
            text-align: center;
        }

        body {
            padding: 0px;
        }

        .content {
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            text-transform: uppercase;
        }

        .table_firmas {
            font-weight: bold;
            font-size: 14px;
            margin-top: 120px;
        }

        .anulado {
            width: 500px;
            margin-top: 180px;
            margin-left: 230px;
            position: absolute;
            font-weight: bold;
            color: #FBCDBF;
            font-size: 60px;
            opacity: 0.2;
            filter: alpha(opacity=40);
        }

        .anulado1 {
            width: 500px;
            margin-top: 400px;
            margin-left: 230px;
            position: absolute;
            font-weight: bold;
            color: #FBCDBF;
            font-size: 60px;
            opacity: 0.2;
            filter: alpha(opacity=40);
        }

        .realizado {
            width: 500px;
            margin-top: 180px;
            margin-left: 230px;
            position: absolute;
            font-weight: bold;
            color: #A0F5AB;
            font-size: 60px;
            opacity: 0.2;
            filter: alpha(opacity=40);
        }

        .realizado1 {
            width: 500px;
            margin-top: 400px;
            margin-left: 230px;
            position: absolute;
            font-weight: bold;
            color: #A0F5AB;
            font-size: 60px;
            opacity: 0.2;
            filter: alpha(opacity=40);
        }
    </style>
{/literal}

<page orientation="portrait">
    {if $DATOSORDENSERVICIO.estado_orden_servicio eq 'I'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
    {/if}
    {if $DATOSORDENSERVICIO.estado_orden_servicio eq 'L'}
        <div class="realizado">LIQUIDADO</div>
        <div class="realizado1">LIQUIDADO</div>
    {/if}
    {if $DATOSORDENSERVICIO.estado_orden_servicio eq 'F'}
        <div class="realizado">FACTURADO</div>
        <div class="realizado1">FACTURADO</div>
    {/if}

    <table style="margin-left:15px; margin-top:30px;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="100%" border="0">
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="242" align="left"><img src="{$DATOSORDENSERVICIO.logo}" width="160"
                                            height="60" /></td>
                                    <td width="200"><strong>ORDEN DE SERVICIO</strong></td>
                                    {* <td width="53" align="center"><img src="../../../framework/media/images/general/Logo_BASC.jpg" /></td> *}
                                    <td width="220" valign="top" align="right">
                                        <table cellspacing="0" cellpadding="0" align="right">
                                            <tr>
                                                <td class="title">ORDEN DE SERVICIO No</td>
                                            </tr>
                                            <tr>
                                                <td class="infoGeneral">{$DATOSORDENSERVICIO.consecutivo}</td>
                                            </tr>
                                            <tr>
                                                <td class="title">OFICINA</td>
                                            </tr>
                                            <tr>
                                                <td class="infoGeneral">{$DATOSORDENSERVICIO.nom_oficina}</td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="top">
                                        <table cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="4" class="title">DATOS ORDEN DE SERVICIO</td>
                                            </tr>
                                            <tr>
                                                <td width="130" class="cellLeft">FECHA</td>
                                                <td width="270" class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.fecha_orden_servicio}</span>
                                                </td>
                                                <td width="130" class="cellRight">CENTRO DE COSTO</td>
                                                <td width="210" class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.centro_costo}</span></td>
                                            </tr>

                                            <tr>
                                                <td class="cellLeft">CLIENTE</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.primer_nombre}
                                                        {$DATOSORDENSERVICIO.segundo_nombre}
                                                        {$DATOSORDENSERVICIO.primer_apellido}
                                                        {$DATOSORDENSERVICIO.segundo_apellido}
                                                        {$DATOSORDENSERVICIO.razon_social}</span></td>
                                                <td class="cellRight">IDENTIFICACION</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.numero_identificacion}
                                                        {if $DATOSORDENSERVICIO.digito_verificacion neq ''}-{/if}
                                                        {$DATOSORDENSERVICIO.digito_verificacion}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="cellLeft">DIRECCI&Oacute;N</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.direccion}</span></td>
                                                <td class="cellRight">TEL&Eacute;FONO</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.telefono}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="cellLeft">CIUDAD</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.ciudad}</span></td>
                                                <td class="cellRight">CORREO</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.email}</span></td>

                                            </tr>

                                            <tr>
                                                <td class="cellLeft">CONTACTO</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.contac_proveedor}</span>
                                                </td>
                                                <td class="cellRight" colspan="2">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="cellLeft">TIPO DE SERVICIO</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.servicio}</span></td>
                                                <td class="cellRight">FORMA DE VENTA</td>
                                                <td class="cellRight"><span
                                                        class="content">{$DATOSORDENSERVICIO.forma_compra}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="cellLeft">DESCRIPCION</td>
                                                <td class="cellRight" colspan="3"><span
                                                        class="content">{$DATOSORDENSERVICIO.descrip_orden_servicio}</span>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                    {if $NUMITEM_ORDENSERVICIO.total_item gt '0'}
                        <tr>
                            <td colspan="4" class="title">REQUERIMIENTOS DE PRODUCTOS O SERVICIOS INICIALES</td>
                        </tr>

                        <tr align="center">
                            <td width="120" class="cellCenter">CANTIDAD</td>
                            <td width="300" class="cellCenter">DESCRIPCION</td>
                            <td width="150" class="cellCenter">V/r UNITARIO</td>
                            <td width="150" class="cellCenter">VALOR TOTAL</td>
                        </tr>
                        {foreach name=itemordenservicio from=$ITEMORDENSERVICIO item=i}
                            <tr>
                                <td class="cellLeft">{$i.cant_item_orden_servicio|number_format:2:',':'.'}</td>
                                <td class="cellRight">{$i.desc_item_orden_servicio}</td>
                                <td class="cellRight">{$i.valoruni_item_orden_servicio|number_format:2:',':'.'}</td>
                                <td class="cellRight">
                                    {math assign="totals" equation="x * y" x=$i.cant_item_orden_servicio y=$i.valoruni_item_orden_servicio}{$totals|number_format:2:',':'.'}
                                </td>

                            </tr>
                        {/foreach}
                        <tr>
                            <td class="cellRight" colspan="3">TOTAL PARCIAL</td>
                            <td class="cellLeft">{$VALITEM_ORDENSERVICIO.valor_item|number_format:2:',':'.'}</td>
                        </tr>

                    {else}
                        <tr>
                            <td colspan="4" class="title">NO EXISTEN REGISTROS DE REQUERIMIENTOS DE PRODUCTOS O SERVICIOS
                                INICIALES</td>
                        </tr>

                    {/if}
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                    {if $NUMLIQ_ORDENSERVICIO.total_liq gt '0'}
                        <tr>
                            <td colspan="4" class="title">REQUERIMIENTOS DE PRODUCTOS O SERVICIOS FINALES</td>
                        </tr>

                        <tr align="center">
                            <td width="120" class="cellCenter">CANTIDAD</td>
                            <td width="300" class="cellCenter">DESCRIPCION</td>
                            <td width="150" class="cellCenter">V/r UNITARIO</td>
                            <td width="150" class="cellCenter">VALOR TOTAL</td>
                        </tr>
                        {foreach name=liqordenservicio from=$LIQORDENSERVICIO item=i}
                            <tr>
                                <td class="cellLeft">{$i.cant_item_liquida_servicio|number_format:2:',':'.'}</td>
                                <td class="cellRight">{$i.desc_item_liquida_servicio}</td>
                                <td class="cellRight">{$i.valoruni_item_liquida_servicio|number_format:2:',':'.'}</td>
                                <td class="cellRight">
                                    {math assign="totals1" equation="x * y" x=$i.cant_item_liquida_servicio y=$i.valoruni_item_liquida_servicio}{$totals1|number_format:2:',':'.'}
                                </td>
                            </tr>
                        {/foreach}
                        <tr>
                            <td class="cellRight" colspan="3">TOTAL PARCIAL</td>
                            <td class="cellLeft">{$VALLIQ_ORDENSERVICIO.valor_liq|number_format:2:',':'.'}</td>
                        </tr>

                    {else}
                        <tr>
                            <td colspan="4" class="title">NO EXISTEN REGISTROS DE REQUERIMIENTOS DE PRODUCTOS O SERVICIOS
                                FINALES</td>
                        </tr>

                    {/if}
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                {if $TOTPUC_ORDENSERVICIO.total_puc gt '0'}
                    <table cellspacing="0" cellpadding="0" style="margin-left:460px;" border="0">

                        <tr>
                            <td colspan="2" class="title">LIQUIDACION FINAL</td>
                        </tr>

                        {foreach name=puc_ordenservicio from=$PUC_ORDENSERVICIO item=i}
                            <tr>
                                <td width="120" class="cellLeft">{$i.despuc_bien_servicio_factura}</td>
                                {if $i.contra_bien_servicio_factura eq '0' and $i.natu_bien_servicio_factura eq 'D'}
                                    <td width="140" class="cellRightRed">{$i.valor|number_format:2:',':'.'}</td>
                                {else}
                                    <td width="140" class="cellRight">{$i.valor|number_format:2:',':'.'}</td>
                                {/if}

                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <table cellspacing="0" cellpadding="0" style="margin-left:480px;" border="0">
                        <tr>
                            <td class="title">NO ESTA LIQUIDADA LA ORDEN DE SERVICIO</td>
                        </tr>
                    </table>
                {/if}
            </td>
        </tr>

        <tr>
            <td>
                <table cellspacing="0" class="table_firmas" cellpadding="0" width="100%" border="0">
                    <tr>
                        <td width="240">_____________________________________</td>
                        <td width="240">&nbsp;</td>
                        <td width="240">_____________________________________</td>
                    </tr>
                    <tr>
                        <td width="240">Empresa</td>
                        <td width="240">&nbsp;</td>
                        <td width="240">Cliente</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</page>