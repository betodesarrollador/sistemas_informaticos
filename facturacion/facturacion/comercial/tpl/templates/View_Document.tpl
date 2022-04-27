{literal}
<style>
/* CSS Document */

   .tipoDocumento{
    font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	font-weight:bold;
	text-align:center
   }
   
   .numeroDocumento{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:18px;
	 font-weight:bold;
	 text-align:center;
   }
   
   .subtitulos{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
	 font-weight:bold;
   }
   
   .contenido{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
   }

   .borderTop{
     border-top:1px solid;
   }

   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#EAEAEA;
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
     background-color:#E6E6E6;
	 font-weight:bold;
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
   }
   
   .cellRight{
     border-right:1px solid;
	 border-bottom:1px solid;
 	 padding: 3px;
	 
   }
   .cellRightRed{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;	
 	 padding: 3px;
	 color:#F00;
	 
   }
   
   .cellLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 padding: 3px;
   }

   .cellCenter{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
   }

   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
     background-color:#E6E6E6;
	 font-weight:bold;
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 border-top:1px solid;	 
     background-color:#E6E6E6;
	 font-weight:bold;
   }
   
   body{
    padding:0px;
   }
   
   .content{
    font-weight:bold;
	font-size:12px;
	text-transform:uppercase;
   }

   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:1px;
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
    <div align="center">
	<table style="margin-left:15px; margin-top:30px;"  cellpadding="0" cellspacing="0" width="90%">
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
             						<td width="256" align="left" valign="top">
                                    	<input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="{$DATOSENCABEZADO.encabezado_registro_id}" />
									    <img src="{$DATOSENCABEZADO.logo}" width="160" height="42" />									</td>
              						<td width="541" valign="top" align="center">
                                    	<strong>&nbsp;{$DATOSENCABEZADO.razon_social_emp}</strong><br />
                                        AGENCIA &nbsp;{$DATOSENCABEZADO.nom_oficina}<br />
                                        &nbsp;{$DATOSENCABEZADO.tipo_identificacion_emp}: &nbsp;{$DATOSENCABEZADO.numero_identificacion_emp}
                                  </td>
           						  <td width="400" valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right" width="100%">
                  							<tr >
                    							<td class="cellLeft borderTop tipoDocumento" width="200">{$DATOSENCABEZADO.tipo_documento}</td>
                  							    <td class="cellRight borderTop numeroDocumento" width="100">{$DATOSENCABEZADO.consecutivo}</td>
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
                                    	<table cellspacing="0" cellpadding="0" width="100%">
      										<tr>
                                                <td  class="cellLeft borderTop subtitulos">Fecha:</td>
                                                <td class="cellRight borderTop contenido">&nbsp;{$DATOSENCABEZADO.fecha}</td>
                                                <td class="cellRight borderTop subtitulos">Ciudad:</td>
                                                <td colspan="2" class="cellRight borderTop contenido">&nbsp;{$DATOSENCABEZADO.ciudad_ofi}</td>
                                          	</tr>
                                            
      										<tr>
                                                <td class="cellLeft subtitulos">{$DATOSENCABEZADO.texto_tercero}</td>
                                                <td class="cellRight contenido">&nbsp;{$DATOSENCABEZADO.primer_nombre} &nbsp;{$DATOSENCABEZADO.segundo_nombre} &nbsp;{$DATOSENCABEZADO.primer_apellido} &nbsp;{$DATOSENCABEZADO.segundo_apellido} &nbsp;{$DATOSENCABEZADO.razon_social}</td>
                                                <td class="cellRight subtitulos">{$DATOSENCABEZADO.tipo_identificacion}</td>
                                                <td class="cellRight contenido" colspan="2">&nbsp;{$DATOSENCABEZADO.numero_identificacion} {if $DATOSENCABEZADO.digito_verificacion neq ''}-{/if} &nbsp;{$DATOSENCABEZADO.digito_verificacion}</td>
                                          	</tr>
                                            <tr>
                                                <td class="cellLeft subtitulos">Concepto</td>
                                                <td class="cellRight contenido" colspan="4">&nbsp;{$DATOSENCABEZADO.concepto}</td>
                                            </tr>
      										<tr>
                                                <td class="cellLeft subtitulos">Forma de Pago</td>
                                                <td colspan="2" class="cellRight contenido">&nbsp;{if strlen(trim($DATOSENCABEZADO.formapago)) > 0}{$DATOSENCABEZADO.formapago}{else}NINGUNA{/if}</td>
                                                <td class="cellRight subtitulos">{$DATOSENCABEZADO.texto_soporte}</td>
                                                <td class="cellRight contenido">&nbsp;{$DATOSENCABEZADO.numero_soporte}</td>
                                          	</tr>
   									  </table>                              		</td>
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
                        <td  width="120"  class="cellTitleLeft" >CODIGO</td>
                        <td  width="117" class="cellTitleRight">TERCERO</td>
                        <td  width="30" class="cellTitleRight">CC</td>
                        <td  width="210" class="cellTitleRight">DETALLE</td>
                        <td  width="130" class="cellTitleRight">DEBITO</td>
                        <td  width="130" class="cellTitleRight">CREDITO</td>                        
                    </tr>
                    {foreach name=imputaciones from=$IMPUTACIONES item=i}                    
                    <tr>    
                        <td class="cellLeft contenido">&nbsp;{$i.puc_cod}</td>
                        <td class="cellRight contenido">&nbsp;{$i.numero_identificacion}</td>
                        <td class="cellRight contenido">&nbsp;{$i.codigo_centro_costo}</td>
                        <td class="cellRight contenido">&nbsp;{$i.descripcion}</td>
                        <td class="cellRight contenido">&nbsp;{$i.debito|number_format:2:',':'.'}</td>
                        <td class="cellRight contenido">&nbsp;{$i.credito|number_format:2:',':'.'}</td>                                                
                    </tr>
                    {/foreach}
					<tr><td colspan="4">&nbsp;</td></tr>
                    <tr>    
                        <td class="cellTitleLeft" colspan="4" align="center"><b>SUMAS IGUALES</b></td>
                        <td class="cellRight borderTop">&nbsp;<b>{$TOTAL.total_debito|number_format:2:',':'.'}</b></td>
                        <td class="cellRight borderTop">&nbsp;<b>{$TOTAL.total_credito|number_format:2:',':'.'}</b></td>                                                
                    </tr>
				</table>
			</td>                    
		</tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>    
        
        <tr>
        	<td>
            	<table cellspacing="0" class="table_firmas" cellpadding="0" width="100%" border="0">
                	<tr>
                    	<td colspan="5" class="normal cellLeft cellRight borderTop" valign="top" align="center">
						  Valor en Letras: &nbsp;{$TOTALES} Pesos M/CTE
						</td>
                    </tr>
                	<tr>
                    	<td width="120" valign="bottom" align="center" class="cellLeft">
						  {$DATOSENCABEZADO.modifica}<br /><br />
						  Elabor&oacute;
						</td>
                        <td width="120" valign="bottom" align="center" class="cellRight">Revis&oacute;</td>
                        <td width="120" valign="bottom" align="center" class="cellRight">Aprob&oacute;</td>
                    	<td width="200" valign="bottom" class="cellRight">
                        	Recib&iacute;
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            C.C. / NIT
                        </td>
                        <td width="160" height="80" valign="bottom" class="cellRight" align="center">Huella</td>
                        
                    </tr>

                </table>
            </td>
        </tr>    
	</table>                   
	</div>
</page>