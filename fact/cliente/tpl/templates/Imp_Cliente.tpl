{literal}
<style>

   table tr td{
      font-size:8px;
   }
   
   .borderRight{
     border-right:1px solid;
   }
   
   .borderBottom{
     border-bottom:1px solid;
   }
     
   .title{
     /*background-color:#999999;*/
	 font-weight:bold;
	 text-align:center;
	 border:1px solid;
   }
   
   .fontBig{
     font-size:12px;
   }
   
   .infogeneral{
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
	 text-align:center;
   }
   
   .cellTitle{
     /*background-color:#999999;*/
	 font-weight:bold;
	 text-align:center;
	 border-top:1px solid;   	 
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
   }
   
   .cellRight{
     border-right:1px solid;
	 border-bottom:1px solid;
	 
   }
   
   .cellLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;	 
   }
   
   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
     /*background-color:#999999;*/
	 font-weight:bold;
	 text-align:center;	   
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 /*border-top:1px solid;	 */
     /*background-color:#999999;*/
	 /*font-weight:bold;*/
	 text-align:left;	 
   }
   
   body{
    padding:0px 0px 0px 0px;
   }
   
   .content{
    font-weight:bold;
	font-size:10px;
	text-align:center;
	text-transform:uppercase;
   }
   
   .cellTitleProd{
      font-size:8px;
	  font-weight:bold;
	  vertical-align:middle;
    }
  	
</style>
{/literal}
	
<page orientation="portrait" backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm">
	<table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="0">
    	<tr>
      		<td align="center">
	  			<table width="100%" border="0">
        			<tr>
            			<td width="230" align="left"><img src="../../../framework/media/images/varios/logoUlc.jpg" width="160" height="42" />&nbsp;</td>			  				 
              			<td width="400">
                        	<strong>VINCULACI&Oacute;N E IDENTIFICACI&Oacute;N DE CLIENTES</strong><br />
                            De conformidad con la Circular Externa No.011  de la Supertransporte de Noviembre 25 de 2011<br />
                            Diligenciar el Formulario en su Totalidad<br />   
                            (Informaci&oacute;n Estrictamente Confidencial)<br />                            
                        </td>
            			<td width="160" align="left"><img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" />&nbsp;<img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" /></td>			  				 
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
        				<td colspan="4" class="title">1. IDENTIFICACI&Oacute;N</td>
                    </tr>
                    <tr>    
                        <td width="120"  class="cellLeft">TIPO PERSONA:</td>
                        <td width="620" colspan="3" class="cellRight">{$DATOSCLIENTE.tipo_per}&nbsp;</td>
      				</tr>
                    <tr>    
                        <td class="cellLeft">NOMBRE/RAZON SOCIAL:</td>
                        <td colspan="3" class="cellRight">{$DATOSCLIENTE.primer_nombre}&nbsp;{$DATOSCLIENTE.segundo_nombre}&nbsp;{$DATOSCLIENTE.primer_apellido}&nbsp;{$DATOSCLIENTE.segundo_apellido}&nbsp;{$DATOSCLIENTE.razon_social}</td>
      				</tr>
                    <tr>    
                        <td class="cellLeft">IDENTIFICACION:</td>
                        <td width="250"  class="cellRight">{$DATOSCLIENTE.numero_identificacion} {$DATOSCLIENTE.digito_verificacion}</td>
                        <td width="120" class="cellLeft">TIPO IDENTIFICACION:</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.tipo_identificacion}</td>
      				</tr>
                    <tr>    
                        <td class="cellLeft">DIRECCION:</td>
                        <td width="250"  class="cellRight">{$DATOSCLIENTE.direccion}</td>
                        <td width="120" class="cellLeft">CIUDAD:</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.ciudad}</td>
      				</tr>
                    <tr>    
                        <td class="cellLeft">DIRECCION CORRESPONDENCIA:</td>
                        <td width="250"  class="cellRight">{$DATOSCLIENTE.corres_cliente_factura}</td>
                        <td width="120" class="cellLeft">APARTADO:</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.apartado}</td>
      				</tr>
                    <tr>    
                        <td class="cellLeft">TELEFONOS:</td>
                        <td width="250"  class="cellRight">{$DATOSCLIENTE.telefono}</td>
                        <td width="120" class="cellLeft">FAX:</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.telefax}</td>
      				</tr>

                    <tr>    
                        <td class="cellLeft">CORREO ELECTRONICO:</td>
                        <td width="250"  class="cellRight">{$DATOSCLIENTE.email_cliente}&nbsp;</td>
                        <td width="120" class="cellLeft">REG. MERCANTIL:</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.reg_cliente_factura}&nbsp;</td>
      				</tr>
                    <tr>    
                        <td class="cellLeft">CAMARA DE COMERCIO:</td>
                        <td width="250"  class="cellRight">{$DATOSCLIENTE.ccomercio_cliente_factura}&nbsp;</td>
                        <td width="120" class="cellLeft">&nbsp;</td>
                        <td width="250" class="cellRight">&nbsp;</td>
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
        				<td colspan="4" class="title">2. INFORMACI&Oacute;N LEGAL (Solo para personas Jur&iacute;dicas)</td>
                    </tr>
			    	<tr>
        				<td colspan="4" class="title">Socios- Para Sociedades An&oacute;nimas relacione los Miembros de la Junta Directiva</td>
                    </tr>

                    <tr>    
                        <td width="350" class="cellLeft"><strong>NOMBRES Y APELLIDOS</strong></td>
                        <td width="100" class="cellRight"><strong>IDENTIFICACION</strong></td>
                        <td width="200" class="cellRight"><strong>DIRECCION</strong></td>
                        <td width="100" class="cellRight"><strong>CIUDAD</strong></td>
                        
      				</tr>
	 				{foreach name=datoslegal from=$DATOSLEGAL item=i}                    
                    <tr>    
                        <td width="350" class="cellLeft">{$i.nombre_cliente_socio}</td>
                        <td width="100" class="cellRight">{$i.id_cliente_socio}</td>
                        <td width="200" class="cellRight">{$i.direccion_cliente_socio}</td>
                        <td width="90" class="cellRight">{$i.origen_socio}</td>
                        
      				</tr>
                    {/foreach}
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
        				<td colspan="4" class="title">Representante Legal</td>
                    </tr>
                    <tr>    
                        <td width="350" class="cellLeft"><strong>NOMBRES Y APELLIDOS</strong></td>
                        <td width="100" class="cellRight"><strong>IDENTIFICACION</strong></td>
                        <td width="200" class="cellRight"><strong>DIRECCION</strong></td>
                        <td width="100" class="cellRight"><strong>CIUDAD</strong></td>
                        
      				</tr>
                  
                    <tr>    
                        <td width="350" class="cellLeft">{$DATOSCLIENTE.repreleg_cliente_factura}</td>
                        <td width="100" class="cellRight">{$DATOSCLIENTE.idrepre_cliente_factura}</td>
                        <td width="200" class="cellRight">{$DATOSCLIENTE.dirrepre_cliente_factura}</td>
                        <td width="90" class="cellRight">{$DATOSCLIENTE.ciudad_rep}</td>
      				</tr>
                    <tr>    
                        <td width="350" class="cellLeft"><strong>CAPITAL SOCIAL REGISTRADO: </strong></td>
                        <td colspan="3" class="cellRight">{$DATOSCLIENTE.capital_cliente_factura}</td>
      				</tr>
                    <tr>    
                        <td width="350" class="cellLeft"><strong>DESCRIPCION ACTIVIDAD ECONOMICA: </strong></td>
                        <td colspan="3" class="cellRight">{$DATOSCLIENTE.actividad_cliente_factura}</td>
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
        				<td colspan="3" class="title">3. INFORMACION TRIBUTARIA</td>
                    </tr>
                    <tr>    
                        <td width="260" class="cellLeft"><strong>REGIMEN</strong></td>
                        <td width="250" class="cellRight"><strong>AUTORRETENEDOR</strong></td>
                        <td width="250" class="cellRight"><strong>AGENTE RETEICA</strong></td>
      				</tr>
                    <tr>    
                        <td width="260" class="cellLeft">{$DATOSCLIENTE.regimen}</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.autoretenedor}</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.reteica}</td>
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
        				<td colspan="5" class="title">4. INFORMACION OPERATIVA</td>
                    </tr>
			    	<tr>
        				<td colspan="5" class="title">Personal que realiza directamente la operaci&oacute;n</td>
                    </tr>
                    <tr>    
                        <td width="300" class="cellLeft"><strong>NOMBRES Y APELLIDOS</strong></td>
                        <td width="100" class="cellRight"><strong>TELEFONO</strong></td>                        
                        <td width="100" class="cellRight"><strong>CARGO</strong></td>
                        <td width="150" class="cellRight"><strong>DIRECCION</strong></td>
                        <td width="100" class="cellRight"><strong>CIUDAD</strong></td>
                        
      				</tr>
	 				{foreach name=operativas from=$OPERATIVAS item=j}                    
                    <tr>    
                        <td width="300" class="cellLeft">{$j.nombre_cliente_operativa}</td>
                        <td width="100" class="cellRight">{$j.telefono_cliente_operativa}</td>
                        <td width="100" class="cellRight">{$j.cargo_cliente_operativa}</td>
                        <td width="150" class="cellRight">{$j.direccion_cliente_operativa}</td>
                        <td width="100" class="cellRight">{$j.origen_operativa}</td>
      				</tr>
                    {/foreach}
                    <tr>    
                        <td class="cellLeft"><strong>ORIGEN DE LOS RECURSOS CON LOS QUE SE REALIZA LA OPERACI&Oacute;N</strong></td>
                        <td colspan="4" class="cellRight">{$DATOSCLIENTE.recursos_cliente_factura}</td>                        
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
        				<td colspan="3" class="title">5. INFORMACION FINANCIERA</td>
                    </tr>
			    	<tr>
        				<td colspan="3" class="title">Referencia Bancaria</td>
                    </tr>
                    <tr>    
                        <td width="250" class="cellLeft"><strong>TIPO DE CUENTA</strong></td>
                        <td width="250" class="cellRight"><strong>NUMERO DE CUENTA</strong></td>                        
                        <td width="250" class="cellRight"><strong>BANCO</strong></td>
                        
      				</tr>
                    <tr>    
                        <td width="250" class="cellLeft">{$DATOSCLIENTE.cuenta}</td>
                        <td width="250" class="cellRight">{$DATOSCLIENTE.numcuenta_cliente_factura}</td>                        
                        <td width="250" class="cellRight">{$DATOSCLIENTE.banco}</td>
                        
      				</tr>

				</table>
			</td>
        </tr>            
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>

        <tr>            
            <td>FECHA DILIGENCIAMIENTO ___________________________________________________________________________</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>

        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>

        <tr>            
            <td>COMERCIAL RESPONSABLE _________________________________________________________________________</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>CERTIFICO QUE LA INFORMACI&Oacute;N CONSIGNADA ARRIBA ES CORRECTA</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>
        <tr>            
            <td>&nbsp;</td>                                                            
        </tr>

        <tr>            
            <td>
				<table  border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>    
                        <td width="300">________________________________________________</td>
                        <td width="150">&nbsp;</td>
                        <td width="300">________________________________________________</td>                        
      				</tr>
                    <tr>    
                        <td width="300">REPRESENTANTE LEGAL O CARGO AUTORIZADO</td>
                        <td width="150">&nbsp;</td>
                        <td width="300">FIRMA PERSONA NATURAL</td>                        
      				</tr>

				</table>
            </td>                                                            
        </tr>

	</table>                                                       
</page>