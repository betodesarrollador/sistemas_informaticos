<html>

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        {$JAVASCRIPT}
        {$CSSSYSTEM}
        {$TITLETAB}
    </head>

    <body>

        <table width="80%" align="center" id="encabezado" border="0">
            <tr>
                <td align="center" colspan="3" class="header">{$EMPRESA} </td>
            </tr>
            <tr>
                <td colspan="3" align="center" class="header">Nit. {$NIT}</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td align="center" colspan="3" class="header">BALANCE GENERAL</td>
            </tr>
            <tr>
                <td align="center" colspan="3" class="header">A CORTE : {$HASTA}</td>
            </tr>
            <tr>
                <td align="center" colspan="3" class="header">(Valores Expresados en pesos Colombianos)</td>
            </tr>
            <tr>
                <td align="center" colspan="3" class="header">Centros : {$CENTROS}</td>
            </tr>
        </table>
        <br><br>

        {assign var="pasivo" value="0"}
        {assign var="patrimonio" value="0"}
        {assign var="codigo_puc" value="0"}
        <table width="95%" align="center" cellpadding="3" class="table_general">
            <thead>
                <tr align="center" class="title">
                    <th width="10%" style="border-right:1px solid">CODIGO</th>
                    <th width="45%" align="center" style="border-right:1px solid">CUENTA</th>
                    <th width="10%" align="center" style="border-right:1px solid">PARCIAL</th>
                    {if $NIVEL > 4 }<th width="10%" align="center" style="border-right:1px solid">AUX</th>{/if}
                    {if $NIVEL > 3 }<th width="10%" align="center" style="border-right:1px solid">SUBCUENTA</th>{/if}
                    {if $NIVEL > 2 }<th width="10%" align="center" style="border-right:1px solid">CUENTA</th>{/if}
                    {if $NIVEL > 1 }<th width="10%" align="center" style="border-right:1px solid">GRUPO</th>{/if}
                    {if $NIVEL > 0 }<th width="10%" align="center" style="border-right:1px solid">CLASE</th>{/if}
                </tr>
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
            </thead>

            <tbody>
                {section name=reporte loop=$arrayResult}

                {assign var="codigo_puc" value=$arrayResult[reporte].codigo}
                {if $codigo_puc eq 2}

                  {assign var="pasivo" value=$arrayResult[reporte].saldo}
                    

                {/if}
                {if $codigo_puc eq 3}
                {assign var="patrimonio" value=$arrayResult[reporte].saldo}

                {/if}

                <tr align="left" bgcolor="{cycle values=" #eeeeee,#d0d0d0"}">
                    <td class="codigo_puc">
                        {$codigo_puc}
                    </td>

                    {if $arrayResult[reporte].tipo eq 'AUX'}
                    <td class="cuentas_movimiento">{$arrayResult[reporte].cuenta}</td>
                    {elseif $arrayResult[reporte].tipo eq 'CLASE'}
                    <td class="cuentas_primer_nivel">{$arrayResult[reporte].cuenta}</td>
                    {else}
                    <td class="cuentas_mayores">{$arrayResult[reporte].cuenta}</td>
                    {/if}

                    <td>&nbsp;</td>
                    {if $NIVEL > 4 }
                    <td align="right">
                        {if $arrayResult[reporte].tipo eq 'AUX'}{$arrayResult[reporte].saldo|number_format:2:",":"."}{else}&nbsp;{/if}
                    </td>
                    {/if}
                    {if $NIVEL > 3 }
                    <td align="right">
                        {if $arrayResult[reporte].tipo eq 'SUBCUENTA'}{$arrayResult[reporte].saldo|number_format:2:",":"."}{else}&nbsp;{/if}
                    </td>
                    {/if}
                    {if $NIVEL > 2 }
                    <td align="right">
                        {if $arrayResult[reporte].tipo eq 'CUENTA'}{$arrayResult[reporte].saldo|number_format:2:",":"."}{else}&nbsp;{/if}
                    </td>
                    {/if}
                    {if $NIVEL > 1 }
                    <td align="right">
                        {if $arrayResult[reporte].tipo eq 'GRUPO'}{$arrayResult[reporte].saldo|number_format:2:",":"."}{else}&nbsp;{/if}
                    </td>
                    {/if}
                    {if $NIVEL > 0 }
                    <td align="right">
                        {if $arrayResult[reporte].tipo eq 'CLASE'}{$arrayResult[reporte].saldo|number_format:2:",":"."}{else}&nbsp;{/if}
                    </td>
                    {/if}
                </tr>

                {if is_array($arrayResult[reporte].terceros)}
                {foreach name=terceros from=$arrayResult[reporte].terceros item=t}
                {if $t.saldo neq 0}
                <tr bgcolor="{cycle values=" #F8F8F8,#FFFFFF"}">
                    <td>&nbsp;</td>
                    <td align="left" class="terceros">&nbsp;&nbsp;{$t.tercero}</td>
                    <td align="right">
                        <a href="javascript:void(0)" onClick="popPup('LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&reporte=C&opciones_tercero=U&tercero_id={$t.tercero_id}&opciones_centros={$opciones_centros}&centro_de_costo_id={$centro_de_costo_id}&opciones_documentos=T&documentos={$documentos}&cuenta_desde_id={$t.puc_id}&cuenta_hasta_id={$t.puc_id}&hasta={$hasta}&agrupar=defecto&balancegeneral=true',10,900,600)">{$t.saldo|number_format:2:",":"."}</a>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                {/if}
                {/foreach}
                {/if}


                {if is_array($arrayResult[reporte].subtotal)}
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="8" class="total">
                        <table width="100%">
                            <tr>
                                <td width="50%" align="left">{$arrayResult[reporte].subtotal.texto}</td>
                                <td width="50%" align="right">{$arrayResult[reporte].subtotal.total|number_format:2:",":"."}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
                {/if}

                {/section}

                <tr>
                    <td colspan="8" class="total">
                        <table width="100%">
                            <tr>
                                <td align="left">TOTAL PASIVO Y PATRIMONIO</td>
                                <td align="right">
                                    {math assign="total" equation="(X+Y)" X=$pasivo Y=$patrimonio}
                                    {$total|number_format:2:",":"."}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="8" align="center">
                        <table width="80%" align="center">
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td align="left">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">{$parametros[0].representante_nombres}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">{$parametros[0].representante_cargo}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">C.C&nbsp;{$parametros[0].representante_cedula}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td align="left">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">{$parametros[0].revisor_nombres}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">{$parametros[0].revisor_cargo}&nbsp;T:P&nbsp;{$parametros[0].revisor_tarjeta_profesional}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">C.C&nbsp;{$parametros[0].revisor_cedula}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td align="left">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">{$parametros[0].contador_nombres}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">{$parametros[0].contador_cargo}&nbsp;T:P&nbsp;{$parametros[0].contador_tarjeta_profesional}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="footer">C.C&nbsp;{$parametros[0].contador_cedula}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </tbody>

        </table>

    </body>

</html>