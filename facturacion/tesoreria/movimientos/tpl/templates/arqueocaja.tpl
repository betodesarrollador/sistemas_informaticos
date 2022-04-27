<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
		<div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>    
        {$FORM1}
        <fieldset class="section"> 
        <table align="center" width="95%">
        	<tr>
            	<td><label>Caja:</label></td>
                <td>{$PARAMETROSLEGALIZACION}</td>
            </tr>
            <tr>
                <td width="9%"><label>Fecha Arqueo:</label></td>
                <td width="12%">{$FECHA}{$USUARIOID} {$PUCID}{$INIPUCID}{$INI2PUCID}{$INI3PUCID}{$INI4PUCID}{$INI5PUCID}{$INI6PUCID}{$CENTROCOSTOR}{$OFICINAID}{$DOCUMENTOS}{$CENTROCOSTO}</td>
                <td width="9%"><label>Consecutivo :</label></td>
                <td width="12%">{$CONSECUTIVO} </td>
                <td width="8%"><label>Estado :</label></td>
                <td width="12%">{$ESTADO} </td>
                 <td width="40%">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$CERRAR}&nbsp;{$IMPRIMIR}&nbsp;{*$ANULAR*}&nbsp;{$LIMPIAR}{$ARQUEOCAJAID}</td>
            </tr>
        </table>
        </fieldset>
		<fieldset class="section"> 
        <legend>Reporte Caja</legend>        
		<table width="100%">
			<tr><td colspan="2"><iframe id="detallesCaja" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table>
        </fieldset>
        <fieldset class="section"> 
        <legend>Cifras Monetarias</legend>
        <table width="100%" border="1" >
			<tr>
            	<td valign="top">
                	<table  width="95%"  id="tableMonedas" >
						<tr>
                        	<td><label>Tipo de Monedas</label></td>
                        	<td ><label>Cantidad</label></td>                            
                        	<td ><label>Total</label></td>                                                        
                            
                        </tr>
                    	{foreach name=monedas from=$MONEDAS item=d}
                        <tr id="rowMonedas">
                        	<td>
                           		<input type="hidden" name="monedas" id="tipo_dinero_id" value="{$d.tipo_dinero_id}" />
                           		<input type="text" name="monedas" id="valor_dinero" value="{$d.valor_dinero}" size="8" readonly />
                             </td>
                             <td>
                                    <input type="text" name="monedas" id="cantidad" value="" class="numeric" size="6" class="required"  />
                             </td>
                             <td>
                                    <input type="text" name="monedas" id="total" value="" class="numeric" size="8" readonly  />
                             </td>
						</tr>					                         
                        {/foreach}                    
                    
                    </table>
                </td>
            	<td valign="top">
                	<table  width="95%"  id="tableBilletes" >
						<tr >
                        	<td ><label>Tipo de Billetes</label></td>
                        	<td ><label>Cantidad</label></td>                            
                        	<td ><label>Total</label></td>                                                        
                        </tr>
                    
                    	{foreach name=billetes from=$BILLETES item=d}
                        <tr id="rowBilletes">
                        	<td>
                           		<input type="hidden" name="billetes" id="tipo_dinero_id" value="{$d.tipo_dinero_id}" />
                           		<input type="text" name="billetes" id="valor_dinero" value="{$d.valor_dinero}" size="8" readonly />
                             </td>
                             <td>
                                    <input type="text" name="billetes" id="cantidad" value="" class="numeric" size="6"  />
                             </td>
                             <td>
                                    <input type="text" name="billetes" id="total" value="" class="numeric" size="8" readonly  />
                             </td>
						</tr>					                         
                        {/foreach}                    
                    
                    </table>
                
                </td>
            	<td valign="top">
                	<table  width="95%"  id="tableCheques" >
						<tr >
                        	<td><label>Cheques</label></td>
                        </tr>
						<tr >
                        	<td>{$CHEQUES1}</td>
                        </tr>
                    
                    </table>
                
                </td>

            	<td valign="top">
                	<table  width="95%">
						<tr>
                        	<td colspan="2"><label>Totales</label></td>
                        </tr>
                    
                        <tr>
                        	<td><label>Total en efectivo:</label></td>
                             <td>{$EFECTIVO}</td>
						</tr>                             
                        <tr>
                        	<td><label>Total en Cheques:</label></td>
                             <td>{$TOT_CHEQUE}</td>
						</tr>                             
                        <tr>
                        	<td><label>Total en Caja:</label></td>
                             <td>{$TOT_CAJA}</td>
						</tr>                             
                        <tr>
                        	<td><label>Saldo Auxiliar:</label></td>
                             <td>{$SAL_AUXILIAR}</td>
						</tr>                             
                        <tr>
                        	<td><label>Diferencia:</label></td>
                             <td>{$DIFERENCIA}</td>
						</tr>                             
                    
                    </table>
                
                </td>
                
            </tr>
		</table> 
        </fieldset>
        <tr>
          <td colspan="" width="90%" align="center"></td>
        </tr>  
		</table>                           
		{$FORM1END}
   </fieldset>
	<fieldset>{$GRIDARQUEOCAJA}</fieldset> 
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
            <td><label>Descripcion :</label></td>
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
