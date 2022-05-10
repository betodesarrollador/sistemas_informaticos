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
   .cellTotal{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 border-top:1px solid;
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
	font-size:13px;
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
	   opacity:0.2;
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
	   opacity:0.2;
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
	   opacity:0.2;
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
	   opacity:0.2;
	   filter:alpha(opacity=40);
   }

	.fontsmall{
		font-size:14px;
	}
	.fontgrande{
		font-size:18px;
		font-weight:bold
	}
</style>
{/literal}
	
<page orientation="portrait" >
	{if $DATOSORDENFACTURA.estado eq 'I'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
    {/if}    
	{if $DATOSORDENFACTURA.estado eq 'C'}
        <div class="realizado">CONTABILIZADA</div>
        <div class="realizado1">CONTABILIZADA</div>
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
                                	<td width="25%" align="left"><img src="{$DATOSORDENFACTURA.logo}" width="190" height="52" /><br />www.envipack.com.co<br />E-mail: facturacionycartera@envipackcolombia.com</td>
             						<td width="50%" align="center" valign="top"><span class="fontgrande">{$DATOSORDENFACTURA.razon_social_emp}</span><br /> <span class="fontsmall">{$DATOSORDENFACTURA.tipo_identificacion_emp} {$DATOSORDENFACTURA.numero_identificacion_emp}<br />REGIMEN COMUN<br />ACTIVIDAD ECONOMICA TRANSPORTE<br />Res Facturaci&oacute;n DIAN {$DATOSORDENFACTURA.resolucion_dian} del {$DATOSORDENFACTURA.fecha_resolucion_dian} {$DATOSORDENFACTURA.rangos_factura}  </span></td>
              						<td width="25%" valign="top" align="center">
                                    
                                    <table width="180" height="57">
                                    	<!--<tr><td><img src="../../../framework/media/images/general/supertransporte.jpg" width="190" height="52" /></td></tr>-->
                                   		<tr>
                                    		<td align="center" class="cellTotal">{$DATOSORDENFACTURA.texto_soporte}: </td>
                                    	</tr>
                                    	<tr>
                                        	<td align="center" class="cellTotal"><span align="center" class="content" style="font-size:18px;">{$DATOSORDENFACTURA.prefijo}&nbsp;-&nbsp;{$DATOSORDENFACTURA.consecutivo_factura}</span></td>
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
							<table  border="0" width="100%" cellpadding="0" cellspacing="0" class="cellTotal">
  								<tr>
    								<td valign="top">
                                    	<table cellspacing="0" width="100%" cellpadding="0">
      										<tr>
                                                <td colspan="3" align="left" valign="top" width="70%">Se�ores : <br /><span class="content">{$DATOSORDENFACTURA.primer_nombre} {$DATOSORDENFACTURA.segundo_nombre} {$DATOSORDENFACTURA.primer_apellido} {$DATOSORDENFACTURA.segundo_apellido} {$DATOSORDENFACTURA.razon_social}</span><br /> <span class="content">{$DATOSORDENFACTURA.numero_identificacion} {if $DATOSORDENFACTURA.digito_verificacion neq ''}-{/if} {$DATOSORDENFACTURA.digito_verificacion}</span><br /><span class="content">{$DATOSORDENFACTURA.direccion}</span><br /><span class="content">{$DATOSORDENFACTURA.telefono}&nbsp;-&nbsp;{$DATOSORDENFACTURA.ciudad}</span></td>
                                                <td colspan="2" align="right" width="30%"><table align="center" width="100%">
                                                <tr>
                                                <td align="center" class="cellTotal"><span class="title">FECHA</span></td>
                                                <td align="center" class="cellTotal"><span class="title">VENCIMIENTO</span></td>
                                                </tr>
                                                <tr>
                                                <td align="center" class="cellTotal"><span class="content">&nbsp;{$DATOSORDENFACTURA.fecha}</span></td>
                                                <td align="center" class="cellTotal"><span class="content">&nbsp;{$DATOSORDENFACTURA.vencimiento}</span></td>
                                                </tr>
                                                <tr>
                                                <td align="center" class="cellTotal" colspan="2"><span class="title">FORMA DE PAGO</span></td>
                                                </tr>
                                                <tr>
                                                <td align="center" class="cellTotal" colspan="2"><span class="content">&nbsp;{$DATOSORDENFACTURA.forma_compra_venta}</span></td>
                                                </tr>
                                                </table>
                                                </td>
                                            </tr>                                   
    									</table>
           		          </td>
    							</tr>
							</table>		  
		  				</td>
        			</tr>
      			</table>
			</td>
        </tr>
	   	<tr>
   		  <td>
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
                    {if $DATOSORDENFACTURA.observacion neq '' and $DATOSORDENFACTURA.observacion neq 'NULL'}
                    <tr>
                        <td class="cellTotal">Concepto</td>
                        <td class="cellTotal" colspan="10"><span class="content">{$DATOSORDENFACTURA.observacion}</span></td>
                    </tr>
                    {/if}
                    <tr align="center" class="cellTotal">
                    	<td width="15%" class="title" >CANTIDAD</td>
                        <td width="60%" class="title" colspan="9">DESCRIPCION</td>
                        <td width="25%" class="title" >VALOR</td>
                    </tr>
                        {foreach name=itemordenfactura from=$ITEMORDENFACTURA item=i}                    
                    <tr>
                        <td class="cellRight">{$i.cantidades|number_format:0:',':'.'}&nbsp;</td>
                        <td class="cellRight" colspan="9">{if $i.fuente neq 'Remesa'}{$i.descripcion}{else}Servicio de Transporte&nbsp;-&nbsp;Remesa No.&nbsp;{$i.no_remesa}{/if}&nbsp;</td>
                        <td class="cellRight"><div align="right">{$i.valor|number_format:0:',':'.'}</div></td>
                    </tr>
                        {/foreach}
                        {assign var="acumula_item" value="0"}
                        {foreach name=puc_ordenfactura from=$PUC_ORDENFACTURA item=i}       
                        {if $i.tercero_bien_servicio_factura eq '0' and $i.ret_tercero_bien_servicio_factura eq '0' and $i.aplica_ingreso eq '0'}              
                        <tr>    
                        	<td colspan="8" style="border-left:#000 1px solid;">{if $acumula_item eq '0'}SON: {$VALORLETRAS} Pesos M/Cte{/if}&nbsp;</td>
                            <td colspan="2" align="right" >{$i.despuc_bien_servicio_factura}&nbsp;&nbsp;</td>
                            {if $i.contra_bien_servicio_factura eq '0' and $i.natu_bien_servicio_factura eq 'D'}
                                <td class="cellRightRed"><div align="right">{if $i.valor_liquida gt 0}{$i.valor_liquida|number_format:0:',':'.'}{else}{$i.valor|number_format:0:',':'.'}{/if}</div></td>
                            {else}
                                <td class="cellRight"><div align="right">{if $i.valor_liquida gt 0}{$i.valor_liquida|number_format:0:',':'.'}{else}{$i.valor|number_format:0:',':'.'}{/if}</div></td>
                            {/if}                        </tr>
                        {/if}
                        {math assign="acumula_item" equation="x + y" x=$acumula_item y=1}
                        {/foreach}
				</table>
		  </td>                    
		</tr>
		<tr>
        	<td>        
                <table cellspacing="0" width="100%" cellpadding="0">
                    <tr >
                        <td  class="title"><div align="left">&nbsp;Observaciones:</div></td>
                    </tr>
                    <tr>
                        <td class="cellTotal">{$DATOSORDENFACTURA.observacion1}</td>
                    </tr>
                    <tr>
                        <td class="cellTotal">{$DATOSORDENFACTURA.observacion2}</td>
                    </tr>
                    
				</table>
			</td>
		</tr>                                    
        <tr>
        	<td valign="top">
                <table cellspacing="0" width="100%" cellpadding="0">
                    <tr>
                        <td width="30%" class="cellTotal" valign="bottom" align="center">
                            ____________________________________
                            FIRMA AUTORIZADA 
                            
                        
                         </td>
                        <td width="40%" class="cellTotal" valign="bottom" align="center">
                            ____________________________________ <br />
                            FIRMA Y SELLO ACEPTACION
                        
                        </td>
                        <td width="30%" class="cellTotal" valign="top">
                            ESTA ES UNA FACTURA DE VENTA que para todos
                            sus efectos se asimila a una letra de cambio segun
                            los articulos 621, 773, 774 del Codigo de Comercio.
                            Si la misma no se paga en la fecha de su vencimiento
                            se cobrara el interes corriente vigente.                        
                        </td>
                        
                    </tr>
				</table>
                <div align="center"><br />
                    RESPONDEMOS POR EL TRANSPORTE DE SU MERCANCIA<br />
                    {$DATOSORDENFACTURA.dir_oficna}. <br />
                    TELS: {$DATOSORDENFACTURA.tel_oficina}.<br />
                    Impreso por computador {$DATOSORDENFACTURA.razon_social_emp|lower} {$DATOSORDENFACTURA.tipo_identificacion_emp} {$DATOSORDENFACTURA.numero_identificacion_emp}
				</div>
                <div align="left">Elaborado Por : {$DATOSORDENFACTURA.elaborado}</div>
            </td>
        </tr>    
	</table>                   
</page>
{if $DETALLES[0].fuente neq ''}
<page orientation="portrait" style="page-break-before:always;" >
    <table style="margin-left:15px; margin-top:30px;"   width="100%" border="0">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <table  border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="40">&nbsp;</td>
                        <td width="350" align="left" valign="top"><img src="{$DATOSORDENFACTURA.logo}" width="190" height="52" /></td>
                        <td width="600" valign="top" align="center"><span class="fontgrande">{$DATOSORDENFACTURA.razon_social_emp}</span><br /> <span class="fontsmall">{$DATOSORDENFACTURA.tipo_identificacion_emp} {$DATOSORDENFACTURA.numero_identificacion_emp}  </span></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><strong>ANEXO FACTURA DE VENTA No {$DATOSORDENFACTURA.consecutivo_factura}</strong></td></tr>
        <tr>
        	<td>
                <table  border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="290">Proyecto:</td>
                        <td width="200" align="left" valign="top">Fecha: {$DATOSORDENFACTURA.fecha}</td>
                        <td width="500" valign="top" align="center">Cliente: {$DATOSORDENFACTURA.razon_social} {$DATOSORDENFACTURA.primer_nombre} {$DATOSORDENFACTURA.segundo_nombre} {$DATOSORDENFACTURA.primer_apellido} {$DATOSORDENFACTURA.segundo_apellido} </td>
                    </tr>
                </table>
            </td>
        </tr>
	</table><br />
	<table width="100%" border="1"   cellpadding="0" cellspacing="0">
	    <thead>
    		<tr>
                <th>&nbsp;FUENTE&nbsp;</th>
                <th>&nbsp;No&nbsp;</th>
                <th>&nbsp;FECHA</th>
                {if $DATOSORDENFACTURA.cliente_id eq '5'}
                <th>&nbsp;CENTRO COSTO</th>
                <th>&nbsp;PROYECTO</th>
                {/if}
                <th>&nbsp;CANT&nbsp;</th>
                <th>&nbsp;ORIGEN&nbsp;</th>
                <th>&nbsp;DESTINO&nbsp;</th>
                <th>&nbsp;DESTINATARIO&nbsp;</th>		
                <th>&nbsp;DESCRIPCION&nbsp;</th>
                <th>&nbsp;VALOR UNITARIO&nbsp;</th>		
                <th>&nbsp;VALOR TOTAL&nbsp;</th>
	        </tr>
		</thead> 
        <tbody>
          {assign var="acumula_total" value="0"}
          {assign var="acumula_reme" value="0"}
          {foreach name=detalles from=$DETALLES item=i}
    
              <tr>
                <td>&nbsp;{$i.fuente}&nbsp;</td>
                <td>&nbsp;{$i.numero}&nbsp;</td>
                <td>&nbsp;{$i.fecha_remesa}&nbsp;</td>
                {if $i.cliente_id eq '5'}
                 <td>&nbsp;{$i.orden_despacho}&nbsp;</td>
                  <td>&nbsp;{$i.proyecto}&nbsp;</td>
                 {/if}               
                <td>&nbsp;{$i.cantidad}&nbsp;</td>
                <td>&nbsp;{$i.origen}&nbsp;</td>
                <td>&nbsp;{$i.destino}&nbsp;</td>
                <td>&nbsp;{$i.destinatario}</td>
                <td>&nbsp;{$i.descripcion}&nbsp;</td>
                <td>&nbsp;{$i.valor_unitario}&nbsp;</td>
                <td>&nbsp;{$i.valor|number_format:2:",":"."}&nbsp;</td>
              </tr>
              {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor}
              {math assign="acumula_reme" equation="x + y" x=$acumula_reme y=1}
          {/foreach}	

              <tr style="border-top:#000 solid 1px;">
                <td {if $i.cliente_id eq '5'}colspan="11" {else}colspan="9" {/if} align="right">&nbsp;TOTAL REMESAS {$acumula_reme} &nbsp;</td>
                <td>&nbsp;{$acumula_total|number_format:2:",":"."}&nbsp;</td>
              </tr>
          
        </tbody>           
    </table>

    <table style="margin-top:30px;"   width="100%" border="1" cellspacing="0">
        <tr><td width="50%"><strong>Son:</strong></td><td width="50%"><strong>Obs:</strong></td></tr>
        <tr><td ><strong>{$VALORLETRAS1}</strong></td><td >&nbsp;</td></tr>        
	</table>

    <table style="margin-top:30px;"   width="50%" border="0">
        <tr><td><strong>Elaboro:</strong></td><td><strong>{$DATOSORDENFACTURA.elaborado}</strong></td></tr>
	</table>
    
    <table style="margin-top:20px;"   width="100%" border="0">
        <tr><td><strong>Aprobo:</strong></td><td><strong>___________________________</strong></td><td><strong>Recibio:</strong></td><td><strong>___________________________</strong></td></tr>
	</table>
    
    
</page>
{/if}
