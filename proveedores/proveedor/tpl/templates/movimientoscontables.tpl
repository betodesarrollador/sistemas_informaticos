<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
    {$JAVASCRIPT}
    {$CSSSYSTEM} 
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
    {$FECHAREGISTROSTATIC}{$MODIFICASTATIC}{$USUARIOIDSTATIC}{$FORM1}
    <fieldset class="section">
        <table width="90%" align="center">
            <tr>
                <td><label>Fecha Reg :</label></td>
                <td><label>{$FECHAREG}{$FECHAREGISTRO}</label></td>
            </tr>        
            <tr>
                <td><label>N&deg; : </label></td>
                <td>{$CONSECUTIVO}{$ENCABEZADOID}</td>
                <td><label>Usuario : </label></td>
                <td><label>{$MODIF}{$MODIFICA}{$USUARIOID}</label></td>
                <td><label>Empresa : </label></td>
                <td>{$EMPRESASID}</td>
            </tr>
            <tr>
                <td><label>Fecha :</label></td>
                <td>{$FECHA}</td>
                {*<td><label>Forma pago :</label></td><td>{$FPAGO}</td>
                <td><label>Cuenta Pago :</label></td>
                <td><span>{$PUCID}</span></td>*}
                <td><label>Documento :</label></td>
                <td>{$TIPOSDOCUMENTOID}</td>
                <td><label>Oficina : </label></td>
                <td>{$OFICINASID}</td>
            </tr>
            <tr>
                <td><label>Valor :</label></td>
                <td>{$VALOR}</td>
                <td>{$TEXTOSOPORTE}</td>
                <td>{$NUMEROSOPORTE}</td>
                <td><label>Concepto : </label></td>
                <td>{$CONCEPTO}</td>
            </tr> 
            <tr>
                <td>{$TEXTOTERCERO}</td>
                <td colspan="3">{$TERCERO}{$TERCEROID}</td>
                <td><label>Scan : </label></td>
                <td>{$SCAN}</td>
            </tr> 
            <tr>
                <td><label>Estado :</label></td>
                <td colspan="5">{$ESTADO}{$ANULADO}{$MSJ_ANULADO}</td>
            </tr>                                                                      
        </table>
        <table width="100%">
            <tr>
                <td colspan="3">
                    <table width="100%">
                        <tr>
                            <td width="11%" id="loading">&nbsp;</td>
                            <td width="59%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
                            <td width="30%" align="right" ><!--<input name="button" type="button" class="buttonDetalle" id="saveImputacionesContables" value="Guardar Detalles" />
                            <input name="button2" type="button" class="buttonDetalle" id="deleteImputacionesContables" value="Borrar Detalles" />-->
                            <img src="../../../framework/media/images/grid/save.png" id="saveImputacionesContables" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteImputacionesContables" title="Borrar Seleccionados"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td colspan="3"><iframe id="movimientosContables" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
            <tr>
            <td align="left" width="10%">{$CONTABILIZAR}</td>
            <td align="center"><label><b>Ctrl+T = Tercero Ctrl+C = Concepto</b></label></td>
            <td align="right" width="60%">
                <table>
                    <tr>
                        <td><label>DEBITO :</label></td>
                        <td><label><span id="totalDebito">0</span></label></td>
                        <td><label>CREDITO :</label></td>
                        <td><label><span id="totalCredito">0</span></label></td>
                        <td><label>DIFERENCIA :</label></td>
                        <td><label><span id="totalDiferencia">0</span></label></td>                
                    </tr>
                </table>
			</td>
            </tr>
        </table>        
    
    </fieldset>
    <fieldset> {$GRIDSeguimiento}</fieldset>{$FORM1END}
    <div id="divAnulacion">
        <form>
            <table>       
                <tr>
                    <td><label>Fecha / Hora :</label></td>
                    <td>{$FECHALOG}</td>
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