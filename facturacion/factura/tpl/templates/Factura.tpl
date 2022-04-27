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
        <table align="center" width="85%">
            <tr>
                <td><label>Fecha Factura : </label></td>
                <td>{$FECHAFACPRO}{$NPAGOS}</td>
                <td><label>Fecha Vencimiento : </label></td>
                <td>{$VENCEFACPRO}</td>
            </tr>
            <tr>
                <td><label>Forma de Venta : </label></td>
                <td>{$FORMACOM}</td>
                <td><label>Tipo de Factura : </label></td>
                <td>{$TIPOFAC}</td>
            </tr>
            <tr>
                <td><label>Fuente Principal : </label></td>
                <td>{$FUENTEID}</td>
                <td><label>Tipo de Servicio : </label></td>
                <td>
                    <span id="VACIO0">&nbsp;</span>
                    <span id="OS0">{$SERV_OS}</span>
                    <span id="RM0">{$SERV_RM}</span>
                    <span id="ST0">{$SERV_ST}</span> </td>
            </tr>
            <tr>
                <td><label>Cliente : </label></td>
                <td>{$CLIENTE}{$CLIENTEID}</td>
                <td><label>Sede : </label></td>
                <td>{$SEDES}</td>
            </tr>
            <tr>
                <td><label>Nit / Identificaci&oacute;n : </label></td>
                <td>{$CLIENTENIT}</td>
                <td><label>Tel&eacute;fono : </label></td>
                <td>{$CLIENTETELE}</td>
            </tr>
            <tr>
                <td><label>Direcci&oacute;n: </label></td>
                <td>{$CLIENTEDIREC}</td>
                <td><label>Ciudad: </label></td>
                <td>{$CLIENTECIUDAD}</td>
            </tr>
            <tr>
                <td><label>Email: </label></td>
                <td>{$CLIENTEEMAIL}</td>
                <td><label>Fecha Radicacion:</label></td>
                <td>{$RADICFAC}</td>
            </tr>

            <tr>
                <td width="10%"><label>Concepto:</label></td>
                <td>{$OBSERVACION}</td>
                <td><label>Valor : </label></td>
                <td>{$VALOR}</td>
            </tr>
            <tr>
                <td><label>FACTURA No:</label></td>
                <td>{$NUMSOPORTE}{$FACTURAID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$TIMPRE}</td>
            </tr>
            <tr>
                <td width="10%" rowspan="4" colspan="2">
                    <fieldset class="section">
                        <legend> Agregar items</legend>
                        <table>
                            <tr>
                                <td>
                                    <span id="VACIO1"><label>Buscar: </label></span>
                                    <span id="OS1"><label>Buscar Ordenes de Servicio : </label></span>
                                    <span id="RM1"><label>Buscar Remesas : </label></span>
                                    <span id="ST1"><label>Buscar Seguimientos : </label></span> </td>
                                <td><img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar" />{$CONCEPTO}{$CONCEPTOITEM}</td>
                            </tr>
                            <tr>
                                <td> <label>Agregar por numero: </label></td>
                                <td> {$CODIGODEBARRAS}</td>
                            </tr>
                            <tr>
                                <td> <label>Agregar por Bloque: </label></td>
                                <td> {$AGREGARNUMEROS}<button  class="btn btn-primary " style="vertical-align: top;" id="procesarBloq" name="procesarBloq" onclick="procesarBloque();" >Procesar<br/>Bloque</button></td>
                            <tr>
                                <td> <label>Subir archivo Excel: </label><a href="../../../framework/ayudas/ArchivoBaseFactura.xls" download="ArchivoBaseNomina"><img src="../../../framework/media/images/general/excel.png" width="25" height="25"/></a></td>
                                <td> {$EXCELAGREGAR}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div>
                                        <span style=" color:#F00; margin-left:20px; margin-top:2px;" id="mensaje_alerta">&nbsp;</span>
                                    </div>
                                    <div>
                                        <span style=" color:rgb(48, 185, 14); margin-left:20px; margin-top:2px;" id="mensaje_exito">&nbsp;</span>
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </fieldset>

                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>


                <td><label>Adjunto max (4 MB):</label></td>
                <td id="fileUpload">{$ADJUNTO}</td>
            </tr>
            <tr>

                <td id="adjuntover">&nbsp;</td>

            </tr>
            <tr>
                <td colspan="1">&nbsp;{$IMPUESTOID}</td>
            </tr>

            <tr>
                <td colspan="5" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="5%">&nbsp;</td>
                            <td width="100%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}
                                <!--&nbsp;{$PDF}-->&nbsp;{$CONTABILIZAR}&nbsp;&nbsp;{*{$REPORTAR}*}&nbsp;{$ENVIOFACTURA}&nbsp;{$REPORTARVP}</td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <table width="100%">
            <tr>
                <td colspan="7"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
            <tr>
                <td align="left" width="60%">&nbsp;</td>
                <td width="40%"><iframe id="subtotales" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
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

    <div id="divIca">
        <form>
            <fieldset class="section">
                <table>
                    <h4>¡ATENCION!</h4><br>
                    <h6> Alguna de las remesas seleccionadas tiene un origen diferente a la ubicación que esta manejando el impuesto del tipo de servicio.<br><br>¡Por favor seleccione el impuesto que desea emplear en la factura!</h6>
                    <tr>
                        <td><label>Reteica :</label></td>
                        <td>{$RETEICA}</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">{$SELECCIONAR}</td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
</body>

</html>