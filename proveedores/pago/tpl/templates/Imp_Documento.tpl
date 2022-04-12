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
	margin-top:1px;
	border:#333 1px solid;
   }
   .table_firmas td{
	   height:80px;
	   border:#333 1px solid;
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
   .normal{
	   height:30px;
   }

</style>
{/literal}
	
<page orientation="portrait" >
	{if $DATOSENCABEZADO.estado_orden_compra eq 'I'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
    {/if}    
	{if $DATOSENCABEZADO.estado_orden_compra eq 'L'}
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
             						<td width="220" align="left" valign="top"><img src="{$DATOSENCABEZADO.logo}" width="160" height="42" /></td>
              						<td width="300" valign="top">
                                    	<strong>{$DATOSENCABEZADO.razon_social_emp}</strong><br />
                                        Agencia {$DATOSENCABEZADO.nom_oficina}<br />
                                        {$DATOSENCABEZADO.tipo_identificacion_emp}: {$DATOSENCABEZADO.numero_identificacion_emp}
                                    </td>
              						<td width="200" valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right">
                  							<tr >
                    							<td  class="title">{$DATOSENCABEZADO.documento_tipo}</td>
                  							</tr>
                  							<tr >
                    							<td class="infoGeneral">{$DATOSENCABEZADO.consecutivo}</td>
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
        										<td  colspan="6" class="title">&nbsp;</td>
      										</tr>
      										<tr>
                                                <td width="130"  class="cellLeft">Fecha:</td>
                                                <td width="230" colspan="2" class="cellRight"><span class="content">{$DATOSENCABEZADO.fecha}</span></td>
                                                <td width="130" class="cellRight">Ciudad:</td>
                                                <td width="190" colspan="2" class="cellRight"><span class="content">{$DATOSENCABEZADO.ciudad_ofi}</span></td>
                                          	</tr>
                                            
      										<tr>
                                                <td class="cellLeft">{$DATOSENCABEZADO.tercero_tipo}</td>
                                                <td class="cellRight" colspan="2"><span class="content">{$DATOSENCABEZADO.primer_nombre} {$DATOSENCABEZADO.segundo_nombre} {$DATOSENCABEZADO.primer_apellido} {$DATOSENCABEZADO.segundo_apellido} {$DATOSENCABEZADO.razon_social}</span></td>
                                                <td class="cellRight">{$DATOSENCABEZADO.tipo_identificacion}</td>
                                                <td class="cellRight" colspan="2"><span class="content">{$DATOSENCABEZADO.numero_identificacion} {if $DATOSENCABEZADO.digito_verificacion neq ''}-{/if} {$DATOSENCABEZADO.digito_verificacion}</span></td>
                                          	</tr>
                                            <tr>
                                                <td class="cellLeft">Concepto</td>
                                                <td class="cellRight" colspan="5"><span class="content">{$DATOSENCABEZADO.concepto}</span></td>
                                            </tr>
      										<tr>
                                                <td class="cellLeft">Forma de Pago</td>
                                                <td class="cellRight"><span class="content">{$DATOSENCABEZADO.formapago}</span></td>
                                                <td class="cellRight">No Cheque</td>
                                                <td class="cellRight"><span class="content"></span></td>
                                                <td class="cellRight">Soporte No</td>
                                                <td class="cellRight"><span class="content">{$DATOSENCABEZADO.numero_soporte|substr:0:15}</span></td>
                                                
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
                
                    <tr align="center" >
                        <td  width="120"  class="title" >Codigo</td>
                        <td  width="235" class="title">Detalle</td>
                        <td  width="120" class="title">Base</td>
                        <td  width="130" class="title">Debito</td>
                        <td  width="130" class="title">Credito</td>                        
                    </tr>
                    {foreach name=imputaciones from=$IMPUTACIONES item=i}                    
                    <tr>    
                        <td class="cellLeft">{$i.puc_cod}</td>
                        <td class="cellRight">{$i.descripcion|substr:0:30}</td>
                        <td class="cellRight">{$i.base|number_format:2:',':'.'}</td>
                        <td class="cellRight">{$i.debito|number_format:2:',':'.'}</td>
                        <td class="cellRight">{$i.credito|number_format:2:',':'.'}</td>                                                
                    </tr>
                    {/foreach}
                    <tr>    
                        <td class="cellLeft" colspan="3">SUMAS IGUALES</td>
                        <td class="cellRight">{$TOTAL.total_debito|number_format:2:',':'.'}</td>
                        <td class="cellRight">{$TOTAL.total_credito|number_format:2:',':'.'}</td>                                                
                    </tr>
                    
				</table>
			</td>                    
		</tr>
        <tr>
        	<td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>    
        
        <tr>
        	<td>
            	<table cellspacing="0" class="table_firmas" cellpadding="0" width="100%" border="0">
                	<tr>
                    	<td colspan="5" class="normal" valign="top">Valor en Letras: {$TOTALES} Pesos M/CTE</td>
                    </tr>
                	<tr>
                    	<td width="115" valign="bottom">Elabor&oacute;</td>
                        <td width="115" valign="bottom">Revis&oacute;</td>
                        <td width="115" valign="bottom">Aprob&oacute;</td>
                    	<td width="210">
                        	Recib&iacute;
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            C.C. / NIT
                        </td>
                        <td width="160" valign="bottom">Huella</td>
                        
                    </tr>

                </table>
            </td>
        </tr>    
	</table>                   
</page>