{literal}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Impresion Factura - Si&amp;Si </title>
<style >
/* CSS Document */

   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#CCC;
	 font-weight:bold;
	 text-align:center;
	 border-bottom:#000 1px solid;
	 border-top:#000 2px solid;
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
	font-size:15px;
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
		font-size:17px;
		font-weight:bold
	}
</style>
{/literal}
</head>
<body>
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
                                	<td width="100">&nbsp;</td>
             						<td width="100" align="left" valign="top">&nbsp;</td>
              						<td width="580" valign="top" align="center">&nbsp;</td>
            						<td width="300">&nbsp;</td>
                                </tr>
          					</table>
                  		</td>
        			</tr>
                    <tr>
                    	<td colspan="4">&nbsp;<br /></td>
                    </tr>
        			<tr >
          				<td >
							<table  border="0" width="100%" cellpadding="0" cellspacing="0">
  								<tr>
    								<td valign="top" >
                                    	<table cellspacing="0" width="100%" cellpadding="0" >
                                        	<tr>
                                            	<td width="3">&nbsp;</td>
                                                <td colspan="3" align="left"><span class="content">{$DATOSORDENFACTURA.primer_nombre} {$DATOSORDENFACTURA.segundo_nombre} {$DATOSORDENFACTURA.primer_apellido} {$DATOSORDENFACTURA.segundo_apellido} {$DATOSORDENFACTURA.razon_social}</span></td>
                                                <td colspan="3" align="left"><span class="content">{$DATOSORDENFACTURA.fecha}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$DATOSORDENFACTURA.vencimiento}</span></td>
                                            </tr>
      										<tr>
                                            	<td width="3">&nbsp;</td>
                                                <td colspan="3" align="left"><span class="content">{$DATOSORDENFACTURA.numero_identificacion} {if $DATOSORDENFACTURA.digito_verificacion neq ''}-{/if} {$DATOSORDENFACTURA.digito_verificacion}</span></td>
                                                <td width="19">&nbsp;</td>
                                                <td width="39">&nbsp;</td>
                                           	</tr>
                                            
                                            <tr>
                                            	<td width="3">&nbsp;</td>
                                                <td colspan="3" align="left"><span class="content">{$DATOSORDENFACTURA.direccion}</span></td>
												<td width="19">&nbsp;</td>
                                                <td width="39">&nbsp;</td>
                                                <td width="250">&nbsp;</td>                                           
                                          </tr>
                                           <tr>
                                            	<td width="3">&nbsp;</td>
                                                <td colspan="2" align="left"><span class="content">{$DATOSORDENFACTURA.ciudad}</span></td>
                                                <td width="140"><span class="content">{$DATOSORDENFACTURA.telefono}</span></td>
                                                <td width="19">&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                       	  </tr>
                                            <tr>
                                            	<td colspan="7">&nbsp;</td>
                                            
                                            <tr>
                                            	<td colspan="7">&nbsp;</td>
                                            </tr>
                                            <tr>
                                            	<td colspan="6">&nbsp;</td>
                                            </tr>
											<tr>
   	                                            <td colspan="2" align="left"> </td>
                                                <td colspan="4" class="content">
                                                	<div align="left">
													{$DATOSORDENFACTURA.observacion} - 
                                                    {if $DATOSORDENFACTURA.remesas_rel neq '' }REMESAS: {$DATOSORDENFACTURA.remesas_rel|replace:",":", "}  -{/if}
                                                    {if $DATOSORDENFACTURA.os_rel neq '' }ORD SERVICIO: {$DATOSORDENFACTURA.os_rel|replace:",":", "} - {/if}
                                                    {if $DATOSORDENFACTURA.seg_rel neq '' }SEGUIMIENTO: {$DATOSORDENFACTURA.seg_rel|replace:",":", "}  {/if}
                                                    </div>
                                                </td>
                                                <td align="center"><b>{if $ITEMORDENFACTURA.valor_unitario}{$ITEMORDENFACTURA.valor_unitario|number_format:0:',':'.'}{else}{$ITEMORDENFACTURA.valor_unitario|number_format:0:',':'.'}{/if}</b></td>
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
   		  <td><table cellspacing="0" cellpadding="0" border="0">
   		    <tr align="center" >
   		      <td width="550" colspan="2">&nbsp;</td>
   		      <td width="210">&nbsp;</td>
   		      <td width="642" colspan="2">&nbsp;</td>
	        </tr>
   		    
			<tr align="center" >
   		      <td width="550" colspan="2">&nbsp;</td>
   		      <td width="210">&nbsp;</td>
   		      <td width="642" colspan="2">&nbsp;</td>
	        </tr>
            <tr align="center" >
   		      <td width="550" colspan="2">&nbsp;</td>
   		      <td width="210">&nbsp;</td>
   		      <td width="642" colspan="2">&nbsp;</td>
	        </tr>
            <tr align="center" >
   		      <td width="550" colspan="2">&nbsp;</td>
   		      <td width="210">&nbsp;</td>
   		      <td width="642" colspan="2">&nbsp;</td>
	        </tr>
            <tr>
              <td width="550" valign="top" class="content" colspan="6" align="left"><div align="left">{$DATOSORDENFACTURA.observacion1|substr:0:60}<br />{$DATOSORDENFACTURA.observacion1|substr:60:60}
              {$DATOSORDENFACTURA.observacion2|lower}</div><br /></td>
                    </tr>
           <tr >
    		<td colspan="6" class="content"><div align="left">&nbsp;</div></td>
  			</tr>
  
   		    {assign var="acumula_item" value="0"}
   		    {foreach name=puc_ordenfactura from=$PUC_ORDENFACTURA item=p}       
   		    {if $p.tercero_bien_servicio_factura eq '0' and $p.ret_tercero_bien_servicio_factura eq '0' and $p.aplica_ingreso eq '0'} 
  <tr class="content" align="right">
    <td >&nbsp;</td>
    <td colspan="4" class="content" align="center"><div align="center">{$p.despuc_bien_servicio_factura}&nbsp;&nbsp;&nbsp;</div></td>
    
    {if $p.contra_bien_servicio_factura eq '0' and $p.natu_bien_servicio_factura eq 'D'}
    <td class="content" align="center"><div align="center">{if $p.valor_liquida gt 0}{$p.valor_liquida|number_format:0:',':'.'}{else}{$p.valor|number_format:0:',':'.'}{/if}</div></td>
    
    {else}
    <td width="220" class="content" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <div align="center">{if $p.valor_liquida gt 0}{$p.valor_liquida|number_format:0:',':'.'}{else}{$p.valor|number_format:0:',':'.'}{/if}</div></td>
    {/if} </tr>
    
   		    {/if}
   		    {math assign="acumula_item" equation="x + y" x=$acumula_item y=1}
   		    {/foreach}
	      </table></td>                    
		</tr>
        <tr >
    		<td colspan="6" class="content"><div align="left">&nbsp;</div></td>
  			</tr>
        <tr >
    <td colspan="3" class="content"><div align="left">&nbsp;{$VALORLETRAS|substr:0:56} <br> &nbsp;{$VALORLETRAS|substr:56:56}&nbsp;Pesos M/Cte</div></td>
  </tr>
		<tr>
        	<td>        
                <table cellspacing="0" width="100%" cellpadding="0">
                    
                   
				</table>
			</td>
		</tr>                                    
        <tr>
        	<td valign="top">
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
                <th>&nbsp;CANTIDAD&nbsp;</th>
                <th>&nbsp;ORIGEN&nbsp;</th>
                <th>&nbsp;DESTINO&nbsp;</th>	
                <th>&nbsp;DESTINATARIOss&nbsp;</th>		
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
                <td>&nbsp;{$i.cantidad}&nbsp;</td>
                <td>&nbsp;{$i.origen}&nbsp;</td>
                <td>&nbsp;{$i.destino}&nbsp;</td>
                <td>&nbsp;{$i.destinatario}&nbsp;</td>
                <td>&nbsp;{$i.descripcion}&nbsp;</td>
                <td>&nbsp;{$i.valor_unitario}&nbsp;</td>
                <td>&nbsp;{$i.valor|number_format:2:",":"."}&nbsp;</td>
              </tr>
              {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor}
              {math assign="acumula_reme" equation="x + y" x=$acumula_reme y=1}
          {/foreach}	

              <tr style="border-top:#000 solid 1px;">
                <td colspan="8" align="right">&nbsp;TOTAL REMESAS {$acumula_reme} &nbsp;</td>
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

</body>