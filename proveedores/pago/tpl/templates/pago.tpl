<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM} 
    {$TABLEGRIDCSS}
    {$TITLETAB}
</head>

<body>
    <fieldset>
    <legend>{$TITLEFORM}</legend>
        <div id="table_find">
        	<table>
            	<tr>
                	<td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div> 
    </fieldset>   
    {$FORM1}
    <fieldset class="section">
        <table align="center" width="90%">
            <tr>
                <td width="15%"><label>Forma de Pago :</label></td>
                <td align="left">{$PAGO}</td>
                <td><label>Tipo de Documento : </label></td>
                <td>{$DOCID}</td>
            </tr>
            <tr>
                <td><label>Proveedor : </label></td>
                <td>{$PROVEEDOR}{$PROVEEDORID}</td>
                <td><label>Nit / Identificaci&oacute;n : </label></td>
                <td>{$PROVEEDORNIT}</td>
            </tr>
            <tr>
                <td><label>Buscar Causaciones</label>&nbsp;<img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar Facturas Pendientes Proveedor"/></td>
                <td>{$CONCEPTOFACTU}{$CAUSACIONFACTU}{$VALORESCAUSACION}{$DESCUENTOITEMS}</td>
                <td><label>Fecha de Pago : </label></td>
                <td>{$FECHA}</td>
            </tr>
            <tr>
                <td><label>Valor Pago : </label></td>
                <td>{$VALORPAGO}</td>
                <td><label>No de Cheque (Si aplica):</label></td>
                <td>{$NUMCHEQUE}</td>
            </tr>
            <tr>
                <td><label>Valor Descuento : </label></td>
                <td>{$VALORDESCU}</td>
                <td><label>Doc Contable No :</label></td>
                <td>{$NUMSOPORTE}{$ABONOID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$ENCABEZADOID}</td>
            </tr>
            <tr>
                <td><label>Valor Neto : </label></td>
                <td>{$VALORNETO}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td><label>Observaciones :</label></td>
                <td colspan="3">{$OBSERVACIONES1}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GUARDAR}&nbsp;<span style="display:none;">{$ACTUALIZAR}</span>&nbsp;{$ANULAR}&nbsp;{$REVERSAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$ENVIAR}</td>
                            <td width="15%" align="right" >
                            <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/>
                            </td>
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
                <td align="left" width="20%"><span >{$CONTABILIZAR}</span></td>
                <td align="center" width="30%"><label><b>Ctrl+T = Tercero Ctrl+C = Concepto</b></label></td>
                <td align="right"  width="10%"></td>
                <td width="10%"><label>DEBITO :</label></td>
                <td width="10%"><label><span id="totalDebito">0</span></label></td>
                <td width="10%"><label>CREDITO:</label></td>
                <td width="10%"><label><span id="totalCredito">0</span></label></td>
            </tr>    
        </table>        
       
        <div id="divSolicitudFacturas">
        <iframe id="iframeSolicitud"></iframe>
        </div>
    </fieldset>
    <fieldset>{$GRIDPAGO}</fieldset>
     {$FORM1END}   
    <div id="divAnulacion">
        <form>
            <table>       
                <tr>
                    <td><label>Fecha / Hora :</label></td>
                    <td>{$FECHALOG}{$ANULUSUARIOID}{$OFICINAANUL}</td>
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
    <div id="divReversar">
        <form>
            <table>       
                <tr>
                    <td><label>Fecha / Hora :</label></td>
                    <td>{$FECHALOGREV}{$REVERUSUARIOID}</td>
                </tr>          
                <tr>
                    <td><label>Documento :</label></td>
                    <td>{$REVDOCID}</td>
                </tr> 
                <tr>
                    <td><label>Descripci&oacute;n :</label></td>
                    <td>{$OBSERVACIONESREV}</td>
                </tr> 
                <tr>
                    <td colspan="2" align="center">{$REVERSAR}</td>
                </tr>                    
            </table>
        </form>
    </div>
    
</body>
</html>
