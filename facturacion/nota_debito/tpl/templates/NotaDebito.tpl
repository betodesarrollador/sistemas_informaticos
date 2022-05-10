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
                <td><label>Factura : </label></td>
                <td>{$NUMSOPORTE}{$FACTURAID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$NOTAID}</td>
            </tr>

            <tr>
                <td><label>Fecha Factura : </label></td>
                <td>{$FECHAFACPRO}</td>
                <td><label>Valor Factura : </label></td>
                <td>{$VALOR}</td>
            </tr>

            <tr>
                <td><label>Tipo de Documento : </label></td>
                <td>{$TIPODOC}</td>
                <td><label>Fecha : </label></td>
                <td>{$FECHANOTA}</td>
            </tr>

            <tr>
                <td><label>Cliente : </label></td>
                <td>{$CLIENTE}{$CLIENTEID}</td>
                <td><label>Documento : </label></td>
                <td>{$NUMDOC}</td>
            </tr>

            <tr>
                <td><label>Valor Nota Debito : </label></td>
                <td>{$VALORNOTA}</td>
                <td><label>Motivo Nota : </label></td>
                <td>{$MOTIVONOTA}</td>
            </tr>

            <tr>
                <td><label>Concepto Nota : </label></td>
                <td>{$CONCEPTO}</td>
                <td><label>Tipo de Servicio : </label></td>
                <td>{$SERV}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
                <td><label>Doc. Contable : </label></td>
                <td>{$CONSECDOC}{$DOCID}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
        <legend>Detalles Factura :</legend>
        <table width="100%">
            <tr>
                <td colspan="7"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
            <tr>
                <td><label>Detalles Contables :</label></td>
            </tr>
            <tr>
                <td colspan="7"><iframe id="detallesContables" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
        <legend>Detalles Nota :</legend>
        <table width="100%">
            <tr>
                <td colspan="7"><iframe id="subtotales" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
        </table>
    </fieldset>
            <tr>
                <td colspan="5" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="5%">&nbsp;</td>
                            <td width="100%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;<!--{$ANULAR}-->{$LIMPIAR}&nbsp;{$IMPRIMIR}&nbsp;<!--{$PDF}-->&nbsp;{$CONTABILIZAR}&nbsp;&nbsp;{*{$REPORTAR}*}&nbsp;{$ENVIOFACTURA}&nbsp;{$REPORTARVP}</td>
                        </tr>
                    </table>                
                </td>
            </tr>
        </table>
        {$FORM1END}
        <div id="divSolicitudFacturas">
            <iframe id="iframeSolicitud"></iframe>
        </div>
    </fieldset>
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
    <div id="divAnulacion">
        <form>
            <table>
                <tr>
                    <td><label>Fecha / Hora :</label></td>
                    <td>{$FECHALOG}{$ANULUSUARIOID}{$ANULOFICINAID}</td>
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
</body>

</html>