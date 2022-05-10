{literal}
<style>
/* CSS Document */

   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#999999;
	 font-weight:bold;
	 text-align:center;
   }
   
   .fontBig{
     font-size:10px;
   }
   
   .infoGeneral{
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
	 text-align:center;
   }
   
   .cellTitle{
     background-color:#999999;
	 font-weight:bold;
	 text-align:center;
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
   }
   
   .cellRight{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;	
 	 padding: 3px;
	 
   }
   .cellRightRed{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;	
 	 padding: 3px;
	 color:#F00;
	 
   }
   
   .cellLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;
	 padding: 3px;
   }

   .cellCenter{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:center;
   }

   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
     background-color:#999999;
	 font-weight:bold;
	 text-align:center;	   
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 border-top:1px solid;	 
     background-color:#999999;
	 font-weight:bold;
	 text-align:center;	 
   }
   
   body{
    padding:0px;
   }
   
   .content{
    font-weight:bold;
	font-size:12px;
	text-align:center;
	text-transform:uppercase;
   }

   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:120px;
   }
   .anulado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

   .anulado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .realizado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

   .realizado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

</style>
{/literal}
	
<page orientation="portrait" >
	{if $DATOSORDENSERVICIO.estado_pre_orden_compra eq 'I'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
    {/if}    
	{if $DATOSORDENCOMPRA.estado_pre_orden_compra eq 'L'}
        <div class="realizado">LIQUIDADO</div>
        <div class="realizado1">LIQUIDADO</div>
    {/if}    
    
	<table style="margin-left:15px; margin-top:30px;"  cellpadding="0" cellspacing="0">
    	<tr>
      		<td align="center">
            	<table width="100%" border="0">
        			<tr>
          				<td></td>
        			</tr>
        			<tr>
          				<td>
                        	<table  border="0" cellpadding="0" cellspacing="0" width="100%">
            					<tr>
             						<td width="242" align="left"><img src="{$DATOSORDENCOMPRA.logo}" width="160" height="42" /></td>
              						<td width="200"><strong>Solicitud de servicio</strong></td>
              						<td width="53" align="center"><img src="../../../framework/media/images/general/Logo_BASC.jpg" /></td>
              						<td width="220" valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right">
                  							<tr >
                    							<td  class="title">Solicitud No</td>
                  							</tr>
                  							<tr >
                    							<td class="infoGeneral">{$DATOSORDENCOMPRA.consecutivo}</td>
                  							</tr>
                  							<tr >
                    							<td  class="title">OFICINA</td>
                  							</tr>
                  							<tr >
                    							<td class="infoGeneral">{$DATOSORDENCOMPRA.nom_oficina}</td>
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
							<table  border="0" width="100%" cellpadding="0" cellspacing="0">
  								<tr>
    								<td valign="top">
                                    	<table cellspacing="0" cellpadding="0">
						     	 			<tr >
        										<td  colspan="4" class="title">DATOS SOLICITUD DE SERVICIO</td>
      										</tr>
      										<tr>
                                                <td width="110"  class="cellLeft">FECHA</td>
                                                <td width="215" class="cellRight"><span class="content">{$DATOSORDENCOMPRA.fecha_pre_orden_compra}</span></td>
                                                <td width="120" class="cellRight">CENTRO DE COSTO</td>
                                                <td width="180" class="cellRight"><span class="content">{$DATOSORDENCOMPRA.centro_costo}</span></td>
                                          	</tr>
                                            
      										<tr>
                                                <td class="cellLeft">PROVEEDOR</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.primer_nombre} {$DATOSORDENCOMPRA.segundo_nombre} {$DATOSORDENCOMPRA.primer_apellido} {$DATOSORDENCOMPRA.segundo_apellido} {$DATOSORDENCOMPRA.razon_social}</span></td>
                                                <td class="cellRight">IDENTIFICACION</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.numero_identificacion} {if $DATOSORDENCOMPRA.digito_verificacion neq ''}-{/if} {$DATOSORDENCOMPRA.digito_verificacion}</span></td>
                                          	</tr>
                                          	<tr>
                                                <td class="cellLeft">DIRECCI&Oacute;N</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.direccion}</span></td>
                                                <td class="cellRight">TEL&Eacute;FONO</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.telefono}</span></td>
                                          	</tr>
                                          	<tr>
                                                <td class="cellLeft">CIUDAD</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.ciudad}</span></td>
                                                <td class="cellRight">CORREO</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.email}</span></td>

                                          	</tr>

                                          	<tr>
                                                <td class="cellLeft">CONTACTO</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.contac_proveedor}</span></td>
                                                <td class="cellRight" colspan="2">&nbsp;</td>
                                          	</tr>
                                          	<tr style="display:none">
                                                <td class="cellLeft">TIPO DE SERVICIO</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.servicio}</span></td>
                                                <td class="cellRight">FORMA DE COMPRA</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCOMPRA.forma_compra}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellLeft">DESCRIPCION</td>
                                                <td class="cellRight" colspan="3"><span class="content">{$DATOSORDENCOMPRA.descrip_pre_orden_compra}</span></td>
                                          </tr>
                                           <tr style="display:none">
                                                <td class="cellLeft">OBSERVACIONES</td>
                                                <td class="cellRight" colspan="3"><span class="content">{$DATOSORDENCOMPRA.observ_pre_orden_compra}</span></td>
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
                    {if $NUMITEM_ORDENCOMPRA.total_item gt '0'} 
                        <tr >
                            <td colspan="4"  class="title">REQUERIMIENTOS DE PRODUCTOS O SERVICIOS </td>
                        </tr>
                    
                        <tr align="center" >
                            <td  width="120"  class="cellCenter" >CANTIDAD</td>
                            <td  width="300" class="cellCenter">DESCRIPCION</td>
                            <td  width="150" class="cellCenter">V/r UNITARIO</td>
                            <td  width="150" class="cellCenter">VALOR TOTAL</td>
                        </tr>
                        {foreach name=itemsolicitud from=$ITEMORDENCOMPRA item=i}                    
                        <tr>    
                            <td class="cellLeft">{$i.cant_item_pre_orden_compra|number_format:2:',':'.'}</td>
                            <td class="cellRight">{$i.desc_item_pre_orden_compra}</td>
                            <td class="cellRight">{$i.valoruni_item_pre_orden_compra|number_format:2:',':'.'}</td>
                            <td class="cellRight">{math assign="totals" equation="x * y" x=$i.cant_item_pre_orden_compra y=$i.valoruni_item_pre_orden_compra}{$totals|number_format:2:',':'.'}</td>
                            
                        </tr>
                        {/foreach}
                        <tr>
                        	<td class="cellRight" colspan="3">TOTAL PARCIAL</td>
                            <td class="cellLeft">{$VALITEM_ORDENCOMPRA.valor_item|number_format:2:',':'.'}</td>
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
        	<td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>    
    	<tr>
      		<td>
                {if $TOTPUC_ORDENCOMPRA.total_puc gt '0'} 
                    <table cellspacing="0" cellpadding="0" style="margin-left:460px;"  border="0">

                        <tr >
                            <td colspan="2"  class="title">LIQUIDACION FINAL</td>
                        </tr>
                    
                        {foreach name=puc_solicitud from=$PUC_ORDENCOMPRA item=i}                    
                        <tr>    
                            <td width="120" class="cellLeft">{$i.despuc_bien_servicio}</td>
                            {if $i.contra_bien_servicio eq '0' and $i.natu_bien_servicio eq 'C'}
                                <td width="140" class="cellRightRed">{$i.valor|number_format:2:',':'.'}</td>
                            {else}
                                <td  width="140"class="cellRight">{$i.valor|number_format:2:',':'.'}</td>
                            {/if}
                            
                        </tr>
                        {/foreach}
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
                        <td width="240">Proveedor</td>
                    </tr>

                </table>
            </td>
        </tr>    
	</table>                   
</page>