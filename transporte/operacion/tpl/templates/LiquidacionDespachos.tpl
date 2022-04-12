<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}   
    {$JAVASCRIPT}
    {$TABLEGRIDJS}  
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
    {$FECHASTATIC}
    {$FORM1}
    {$ENCABEZADOREGISTROID}{$LIQUIDACIONID}{$USUARIOID}{$USUARIO}
    <fieldset class="section">	
    <legend>Datos Despacho</legend>	
        <table width="80%" align="center">
            <tr>
                <td><label>No. Despacho :</label></td>
                <td colspan="3">{$DESPACHO}{$DESPACHOID}</td>
			</tr>
            <tr>
                <td><label>Fecha :</label></td>
                <td>{$FECHA}</td>
				<td><label>Vencimiento :</label></td>
                <td>{$VENCIMIENTO}</td>                
            </tr>
            <tr>
                <td><label>Tenedor :</label></td>
                <td>{$TENEDOR}{$TENEDORID}</td>
                <td><label>Vehiculo :</label></td>
                <td>{$PLACA}{$PLACAID}</td>
            </tr>
            <tr>
                <td><label>Origen :</label></td>
                <td>{$ORIGEN}{$ORIGENID}</td>
                <td><label>Destino :</label></td>
                <td>{$DESTINO}{$DESTINOID}</td>
            </tr>
            <tr>
                <td><label>Concepto :</label></td>
                <td>{$CONCEPTO}</td>
                <td><label>Lugar Pago  : </label></td>
                <td>{$OFICINAID}</td>
            </tr>		
            <tr>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
                <td><label>Observaciones :</label></td>
                <td>{$OBSERVACIONES}</td>
            </tr>
             <tr>
                <td><label>Autoriza Pago :</label></td>
                <td>{$AUTORIZAPAGO}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Liquidacion</legend>
        <table width="100%">
            <tr>
                <td>
                    <div id="divLiquidacion" align="center">
                        <table id="tableLiquidacion" width="90%">
                            <tbody>					
                                <tr class="title">
                                    <td colspan="2" align="right"><b>VALOR FLETE :</b></td>
                                    <td colspan="4">
                                    {$VALORFLETE}
                                    <input type="hidden" name="detalle_liquidacion_valor_flete_id"  value="" /></td>
                                </tr>	
                                <tr class="title">
                                    <td colspan="2" align="right"><b>SOBRE FLETE :</b></td>
                                    <td>
                                    {$VALORSOBREFLETE}
                                    <input type="hidden" name="detalle_liquidacion_valor_sobre_flete_id"  value="" />						    </td>
                                    <td><b>OBSERVACI&Oacute;N : </b></td>
                                    <td colspan="2">{$OBSERVACIONSOBREFLETE}</td>
                                </tr>				
                                <tr id="rowImpuestos" class="rowImpuestos">
                                    <td class="title" align="center">Impuesto</td>					 
                                    <td class="content" align="center">
                                    <input type="hidden" name="impuestos" id="impuestos_despacho_id" value="" />
                                    <input type="hidden" name="impuestos" id="impuesto_id" value="" />				
                                    <input type="hidden" name="impuestos" id="porcentaje" value="" />										 		 
                                    <input type="hidden" name="impuestos" id="formula" value="" />										 		 						
                                    <input type="hidden" name="impuestos" id="monto" value="" />	
                                    <input type="hidden" name="impuestos" id="base" value="" />							 									 							                         <input type="text" name="impuestos" id="nombre" value="" size="37" disabled />					   
                                    </td>	 	 
                                    <td colspan="4" class="content">
                                    <input type="text" name="impuestos" id="valor" value="" class="" disabled />
                                    <input type="hidden" name="impuestos" id="detalle_liquidacion_despacho_id"  value="" />					   
                                    </td>	 	 	 	 	 
                                </tr>
                                <tr class="title">
                                    <td colspan="2" align="right"><b>VALOR NETO PAGAR :</b></td>
                                    <td colspan="4"  >{$VALORNETO}</td>
                                </tr>				
                                <tr id="rowDescuentos" class="rowDescuentos">
                                    <td class="title" align="center">Descuento</td>	 
                                    <td class="content" align="center">
                                    <input type="hidden" name="descuentos" id="descuentos_despacho_id" value="" />
                                    <input type="hidden" name="descuentos" id="descuento_id" value="" />						 						 
                                    <input type="text" name="descuentos" id="nombre" value="" size="37" disabled />
                                    <input type="hidden" name="descuentos" id="calculo" value="">					   
                                    </td>	 
                                    <td colspan="4" class="content">
                                    <input type="text" name="descuentos" id="valor" value="" class="" />
                                    <input type="hidden" name="descuentos" id="detalle_liquidacion_despacho_id"  value="" />					   
                                    </td>	 	 	 	 	 
                                </tr>
                                <tr id="rowAnticipos" class="rowAnticipos">
                                    <td class="title" align="center">Anticipo</td>	 
                                    <td class="content" align="center">
                                    <input type="hidden" name="anticipos" id="anticipos_despacho_id" value="" />
                                    <input type="hidden" name="anticipos" id="numero" value="" />					   
                                    <input type="text" name="anticipos" id="tenedor" value="" size="37" disabled />
                                    <input type="hidden" name="anticipos" id="tenedor_id" value="" />					   
                                    </td>	 
                                    <td colspan="4" class="content">
                                    <input type="text" name="anticipos" id="valor" value="" class="" disabled /></td>	 	 	 	 	 
                                </tr>
                                <tr class="title">
                                    <td colspan="2" align="right"><b>SALDO POR PAGAR :</b></td>
                                    <td colspan="4">
                                    {$SALDOPAGAR}
                                    <input type="hidden" name="detalle_liquidacion_saldo_por_pagar_id"  value="" />
                                    <input type="button" name="calcularFlete" id="calcularFlete" value="Calcular" class="buttondefault"   /></td>
                                </tr>
                            </tbody>
                        </table>  				  
                    </div>			   	   			   
                </td>
            </tr>
        </table>
    </fieldset>
    <table align="center">
        <tr>
            <td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}</td>
        </tr>
    </table>
    {$FORM1END}
    </fieldset>    
    <div id="divAnulacion">
        <form onSubmit="return false">
            <table>              
                <tr>
                    <td><label>Causal :</label></td>
                    <td>{$CAUSALANULACIONID}</td>
                </tr>
                <tr>
                    <td><label>Descripci&oacute;n :</label></td>
                    <td>{$OBSERVANULACION}</td>
                </tr> 
                <tr>
                    <td colspan="2" align="center">{$ANULAR}</td>
                </tr>                    
            </table>
        </form>
    </div>    
    <div>{$GRIDMANIFIESTOS}</div>
</body>
</html>