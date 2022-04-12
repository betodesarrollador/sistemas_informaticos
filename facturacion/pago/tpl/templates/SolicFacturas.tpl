<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
    {$TABLEGRIDJS}
    {$TABLEGRIDCSS}
</head>

<body>

    <input type="hidden" id="abono_factura_id" value="{$abono_factura_id}" />
    <table align="center" id="tableDetalles" width="98%">
        <thead>
            <tr>
                {math assign="total_col" equation="x + y +z" x=9 y=$TOTALDESC z=$TOTALMAYOR}
                <th colspan="{$total_col}">FACTURAS DE VENTA</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>FACTURA No</th>
                <th>TIPO</th>
                <th>FECHA</th>
                <th>VENCIMIENTO</th>
                <th>VALOR NETO</th>
                <th>SALDO</th>
                <th>ABONOS</th>
                {if $TIPO eq 'NC'}
                <th>VALOR A DESCONTAR</th>
                {else }
                <th>VALOR A PAGAR</th>
                {/if}
                {foreach name=descuentos from=$DESCUENTOS item=j}
                <th style="color:#F00;">{$j.nombre}</th>
                {/foreach}
                {foreach name=mayor from=$MAYOR item=i}
                <th style="color:#0C0;">{$i.nombre}</th>
                {/foreach}
                {if $TIPO eq 'NC'}
                <th>VALOR NETO</th>
                {/if }
            </tr>
        </thead>
        <tbody>
            {foreach name=detalles from=$DETALLES item=i}
            <tr>
                <td>
                    <input type="checkbox" name="checkfactura" onClick="checkRow(this);" value="{$i.factura_id}" />
                    <input type="hidden" name="factura_id" value="{$i.factura_id}" class="required" />
                    <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}" />
                </td>
                <td>{$i.consecutivo_id}</td>
                <td>{$i.tipo}</td>
                <td>{$i.fecha}</td>
                <td>{$i.vencimiento}</td>
                <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido"
                        value="{$i.valor_neto|number_format:0:'.':''}" size="13" readonly /></td>
                <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo|number_format:0:'.':''}"
                        size="13" readonly /></td>
                <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido"
                        value="{if $i.abonos eq ''}0{else}{$i.abonos|number_format:0:'.':''}{/if}" size="13" readonly /></td>
                {if $TIPO eq 'NC'}
                <td><input type="text" name="pagar_nota" class="required" onKeyUp="ValidarSaldoNota(this);"
                        value="{$i.saldo|number_format:0:',':'.'}" size="13" /></td>
                {else }
                <td><input type="text" name="pagar" class="required" value="{$i.saldo|number_format:0:',':'.'}"
                        size="13" /></td>
                {/if}
                {assign var="incremen" value="1"}
                {foreach name=descuentos from=$DESCUENTOS item=j}
                <td>
                    <input type="text" name="descuento{$incremen}" id="descuento{$incremen}" onKeyUp="ValidarDes(this);"
                        class="numeric required" value="" size="13" />
                    <input type="hidden" name="descuento_id{$incremen}" id="descuento_id{$incremen}"
                        value="{$j.parametros_descuento_factura_id}" />
                    <input type="hidden" name="puc_id{$incremen}" id="puc_id{$incremen}" value="{$j.puc_id}" />
                    <input type="hidden" name="tipo_descu_id{$incremen}" id="tipo_descu_id{$incremen}" value="DESC" />
                    {math assign="incremen" equation="x + y" x=$incremen y=1}
                </td>
                {/foreach}

                {foreach name=mayor from=$MAYOR item=k}
                <td>
                    <input type="text" name="descuento{$incremen}" id="descuento{$incremen}" onKeyUp="ValidarDes(this);"
                        class="numeric required" value="" size="13" />
                    <input type="hidden" name="descuento_id{$incremen}" id="descuento_id{$incremen}"
                        value="{$k.parametros_descuento_factura_id}" />
                    <input type="hidden" name="puc_id{$incremen}" id="puc_id{$incremen}" value="{$k.puc_id}" />
                    <input type="hidden" name="tipo_descu_id{$incremen}" id="tipo_descu_id{$incremen}" value="MAS" />
                    {math assign="incremen" equation="x + y" x=$incremen y=1}
                </td>
                {/foreach}
                {if $TIPO eq 'NC'}
                <!--class numeric requier-->
                <td><input type="text" name="pagar" class="required" value="{$i.saldo|number_format:0:',':'.'}"
                        size="13" /></td>
                {/if }
                {math assign="total_descu" equation="x - y" x=$incremen y=1}
                <input type="hidden" name="num_descu" id="num_descu" value="{$total_descu|number_format:0:',':'.'}" />

            </tr>
            {/foreach}
        </tbody>
    </table>

    <br>

    <table align="center" id="tableNotasDebito" width="98%">
        <thead>
            <tr>
                {math assign="total_col" equation="x + y +z" x=9 y=$TOTALDESC z=$TOTALMAYOR}
                <th colspan="{$total_col}">NOTAS DEBITO</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>NOTA DEBITO No</th>
                <th>CONSECUTIVO FACTURA</th>
                <th>TIPO</th>
                <th>FECHA</th>
                <th>VALOR NETO</th>
                <th>SALDO</th>
                <th>ABONOS</th>
                {if $TIPO eq 'NC'}
                <th>VALOR A DESCONTAR</th>
                {else }
                <th>VALOR A PAGAR</th>
                {/if}
                {foreach name=descuentos from=$DESCUENTOS item=j}
                <th style="color:#F00;">{$j.nombre}</th>
                {/foreach}
                {foreach name=mayor from=$MAYOR item=i}
                <th style="color:#0C0;">{$i.nombre}</th>
                {/foreach}
                {if $TIPO eq 'NC'}
                <th>VALOR NETO</th>
                {/if }
            </tr>
        </thead>
        <tbody>
            {foreach name=detalles_nota from=$DETNOTASDEBITO item=i}
            <tr>
                <td>
                    <input type="checkbox" name="checknota" onClick="checkRow(this);" value="{$i.nota_debito_id}" />
                    <input type="hidden" name="nota_debito_id" value="{$i.nota_debito_id}" class="required" />
                    <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}" />
                </td>
                <td>{$i.consecutivo_id}</td>
                <td>{$i.consecutivo_factura}</td>
                <td>{$i.tipo}</td>
                <td>{$i.fecha}</td>
                <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido"
                        value="{$i.valor_neto|number_format:0:'.':''}" size="13" readonly /></td>
                <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo|number_format:0:'.':''}"
                        size="13" readonly /></td>
                <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido"
                        value="{if $i.abonos eq ''}0{else}{$i.abonos|number_format:0:'.':''}{/if}" size="13" readonly /></td>
                {if $TIPO eq 'NC'}
                <td><input type="text" name="pagar_nota" class="required" onKeyUp="ValidarSaldoNota(this);"
                        value="{$i.saldo|number_format:0:',':'.'}" size="13" /></td>
                {else }
                <td><input type="text" name="pagar" class="required" value="{$i.saldo|number_format:0:',':'.'}"
                        size="13" /></td>
                {/if}
                {assign var="incremen" value="1"}
                {foreach name=descuentos from=$DESCUENTOS item=j}
                <td>
                    <input type="text" name="descuento{$incremen}" id="descuento{$incremen}" onKeyUp="ValidarDes(this);"
                        class="numeric required" value="" size="13" />
                    <input type="hidden" name="descuento_id{$incremen}" id="descuento_id{$incremen}"
                        value="{$j.parametros_descuento_factura_id}" />
                    <input type="hidden" name="puc_id{$incremen}" id="puc_id{$incremen}" value="{$j.puc_id}" />
                    <input type="hidden" name="tipo_descu_id{$incremen}" id="tipo_descu_id{$incremen}" value="DESC" />
                    {math assign="incremen" equation="x + y" x=$incremen y=1}
                </td>
                {/foreach}

                {foreach name=mayor from=$MAYOR item=k}
                <td>
                    <input type="text" name="descuento{$incremen}" id="descuento{$incremen}" onKeyUp="ValidarDes(this);"
                        class="numeric required" value="" size="13" />
                    <input type="hidden" name="descuento_id{$incremen}" id="descuento_id{$incremen}"
                        value="{$k.parametros_descuento_factura_id}" />
                    <input type="hidden" name="puc_id{$incremen}" id="puc_id{$incremen}" value="{$k.puc_id}" />
                    <input type="hidden" name="tipo_descu_id{$incremen}" id="tipo_descu_id{$incremen}" value="MAS" />
                    {math assign="incremen" equation="x + y" x=$incremen y=1}
                </td>
                {/foreach}
                {if $TIPO eq 'NC'}
                <!--class numeric requier-->
                <td><input type="text" name="pagar" class="required" value="{$i.saldo|number_format:0:',':'.'}"
                        size="13" /></td>
                {/if }
                {math assign="total_descu" equation="x - y" x=$incremen y=1}
                <input type="hidden" name="num_descu" id="num_descu" value="{$total_descu|number_format:0:',':'.'}" />

            </tr>
            {/foreach}
        </tbody>
    </table>
    <center>{$ADICIONAR}</center>
</body>

</html>