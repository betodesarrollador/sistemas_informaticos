<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}

    {$CSSSYSTEM}

    {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        <div id="table_find">
            <table align="center">
                <tr>
                    <td><label>Busqueda : </label></td>
                </tr>
                <tr>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center" width="90%">
            <tr>
                <td><label>Fecha : </label></td>
                <td>{$FECHA}</td>
                <td><label>Centro de Costo : </label></td>
                <td>{$CENTROCOSTOID}</td>
            </tr>
            <tr>
                <td><label>Cliente : </label></td>
                <td>{$CLIENTENOM}{$CLIENTEID}</td>
                <td><label>Tel&eacute;fono : </label></td>
                <td>{$CLIENTETEL}</td>
            </tr>
            <tr>
                <td><label>Direcci&oacute;n : </label></td>
                <td>{$CLIENTEDIR}</td>
                <td><label>Ciudad : </label></td>
                <td>{$CLIENTECIU}</td>
            </tr>
            <tr>
                <td><label>Contacto : </label></td>
                <td>{$CLIENTECON}</td>
                <td><label>Correo : </label></td>
                <td>{$CLIENTECORREO}</td>
            </tr>
            <tr>
                <td><label>Tipo Servicio : </label></td>
                <td>{$TIPOSERVICIO}{$TIPOSERVICIOID}</td>
                <td><label>Forma de Venta : </label></td>
                <td>{$PAGO}</td>
            </tr>
            <tr>
                <td><label>Descripci&oacute;n : </label></td>
                <td colspan="3">{$DESCRIPCION}</td>
            </tr>
            <tr>
                <td><label>ORDEN DE SERVICIO No. : </label></td>
                <td>{$CONSECUTIVO}{$ORDENID}{$INSUSUARIOID}{$FECHAINGRESO}{$OFICINAID}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">
                                {$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$LIQUIDAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}
                            </td>
                            <td width="15%" align="right">
                                <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc"
                                    title="Guardar Seleccionados" /> <img
                                    src="../../../framework/media/images/grid/no.gif" id="deleteDetallepuc"
                                    title="Borrar Seleccionados" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">&nbsp;</td>
                <td width="40%"><iframe id="subtotales" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
        </table>
        {$FORM1END}
    </fieldset>
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid" onclick="showTable()"
            style="float:right;">Mostrar tabla</button></fieldset>
    <div id="divAnulacion">
        <form>
            <table>
                <tr>
                    <td><label>Fecha / Hora :</label></td>
                    <td>{$FECHALOG}{$USUARIOID}{$ANULOFICINAID}</td>
                </tr>
                <tr>
                    <td><label>Causal :</label></td>
                    <td>{$CAUSALESID}</td>
                </tr>
                <tr>
                    <td><label>Descripci&oacute;n :</label></td>
                    <td>{$OBSERVACIONES}</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">{$ANULAR}</td>
                </tr>
            </table>
        </form>
    </div>
    <div id="divLiquidar">
        <form>
            <table>
                <tr>
                    <td><label>Fecha / Hora :</label></td>
                    <td>{$FECHALOG1}{$INSUSUARIOID1}</td>
                </tr>
                <tr>
                    <td><label>Descripci&oacute;n :</label></td>
                    <td>{$OBSERVACIONES1}</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">{$LIQUIDAR}</td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>