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
     font-size:16px;
   }
   
   .fontsmall{
   	font-size:10px;
	   
   }
   .infogeneral{
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
     font-weight:bold;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;	 
	 
   }
   
   .cellLeft{
	  font-weight:bold;  
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;
   }


   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 font-size:13px;
	 text-align:left;
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 font-size:13px;
	 text-align:left;	 
   }
   
   body{
    padding:0px;
   }
   .contec_center{
    font-weight:bold;
	font-size:12px;
	text-align:center;
	text-transform:uppercase;
   }
   .content{
    font-weight:bold;
	font-size:12px;
	text-align:left;
	text-transform:uppercase;
   }

   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:100px;
   }
   .encabezado{
	   width:740px;
	   text-align:justify;
	   font-size:14px;
	
   }
   .anulado{
	   width:500px;
	   margin-top:280px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.5;
	   filter:alpha(opacity=40);
   }

   .anulado1{
	   width:500px;
	   margin-top:490px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.5;
	   filter:alpha(opacity=40);
   }
   .anulado2{
	   width:500px;
	   margin-top:750px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.5;
	   filter:alpha(opacity=40);
   }
   
   .realizado{
	   width:500px;
	   margin-top:280px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.5;
	   filter:alpha(opacity=40);
   }

   .realizado1{
	   width:500px;
	   margin-top:490px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.5;
	   filter:alpha(opacity=40);
   }

   .realizado1{
	   width:500px;
	   margin-top:750px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.5;
	   filter:alpha(opacity=40);
   }

</style>
{/literal}
	
<page orientation="portrait" >
	{if $DATOSORDENSEGUIMIENTO.estado eq 'A'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
        <div class="anulado2">ANULADO</div>
    {/if}    
	{if $DATOSORDENSEGUIMIENTO.estado eq 'F'}
        <div class="realizado">FINALIZADO</div>
        <div class="realizado1">FINALIZADO</div>
        <div class="realizado2">FINALIZADO</div>
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
             						<td width="242" align="left" valign="top">
                                    	<img src="{$DATOSORDENSEGUIMIENTO.logo}" width="160" height="40" />                                       
                                    </td>
              						<td width="240" valign="top">
                                        <span class="fontsmall">{$DATOSORDENSEGUIMIENTO.razon_social}<br />{$DATOSORDENSEGUIMIENTO.tipo_identificacion_emp} {$DATOSORDENSEGUIMIENTO.numero_identificacion_emp}<br />{$DATOSORDENSEGUIMIENTO.dir_oficna}. <br />Tel&eacute;fonos: {$DATOSORDENSEGUIMIENTO.tel_oficina}. Ciudad: {$DATOSORDENSEGUIMIENTO.ciudad_ofi} </span>
                                    </td>
              						<td width="33" align="center" valign="top"><img src="../../../framework/media/images/general/Logo_BASC.jpg" /></td>
              						<td width="180" valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right">
                  							<tr >
                    							<td  class="title">
                                                	<strong class="fontBig">ORDEN DE SEGUIMIENTO No</strong>
                                                </td>
                  							</tr>
                  							<tr >
                    							<td class="infogeneral">{$DATOSORDENSEGUIMIENTO.seguimiento_id}</td>
                  							</tr>
                  							<tr >
                    							<td  class="title">OFICINA</td>
                  							</tr>
                  							<tr>
                    							<td class="infogeneral">{$DATOSORDENSEGUIMIENTO.nom_oficina}</td>
                  							</tr>
                  							<tr>
                    							<td class="title">Fecha Expedici&oacute;n</td>
                  							</tr>
                  							<tr>
                    							<td class="infogeneral">{$DATOSORDENSEGUIMIENTO.fecha_ingre}</td>
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
                    	<td><div class="encabezado">Autorizamos al Se&ntilde;or Conductor {$DATOSORDENSEGUIMIENTO.nombre}, del Vehiculo de placas {$DATOSORDENSEGUIMIENTO.placa} que realice el servicio de transporte.</div></td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                    </tr>

        			<tr>
          				<td>
							<table   width="100%" cellpadding="0" cellspacing="0" border="0">
  								<tr>
    								<td valign="top">
                                    	<table cellspacing="0" cellpadding="0" width="100%" border="0">
						     	 			<tr>
        										<td  colspan="4" class="title">DATOS DEL CLIENTE Y ESPECIFICACIONES</td>
      										</tr>
      										<tr>
                                                <td width="130"  class="cellTitleLeft">Cliente:</td>
                                                <td width="330" class="cellLeft"><span class="content">{$DATOSORDENSEGUIMIENTO.cliente}</span></td>
                                                <td width="140" class="cellTitleRight">Identificaci&oacute;n:</td>
                                                <td width="180" class="cellRight"><span class="content">{$DATOSORDENSEGUIMIENTO.cliente_nit}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Direcci&oacute;n Cargue:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENSEGUIMIENTO.direccion_cargue}</span></td>
                                                <td class="cellTitleRight">Tel&eacute;fono:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENSEGUIMIENTO.cliente_tel}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">M&oacute;vil:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENSEGUIMIENTO.movil_conductor}</span></td>
                                                <td class="cellTitleRight">Correo:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENSEGUIMIENTO.correo_conductor}</span></td>
                                          </tr>
                                          
                                          <tr>
                                                <td class="cellTitleLeft">Origen:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENSEGUIMIENTO.origen}</span></td>
                                                <td class="cellTitleRight">Destino:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENSEGUIMIENTO.destino}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Fecha:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENSEGUIMIENTO.fecha}</span></td>
                                                <td class="cellTitleRight">&nbsp;</td>
                                                <td class="cellRight">&nbsp;</td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Contactos:</td>
                                                <td class="cellLeft" colspan="3">
                                                	{foreach name=contactos from=$CONTACTOS item=i}
                                                        <span class="content">
                                                        	{$i.nombre_contacto}&nbsp; M&oacute;vil: {$i.cel_contacto}<br />
                                                        </span>
                                                    {/foreach}    
                                                
                                                </td>
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
        			<tr >
          				<td colspan="3"  class="title">INFORMACI&Oacute;N DEL VEHICULO</td>
        			</tr>
                    <tr>
                        <td  width="480" class="cellTitleLeft" colspan="2">Foto Vehiculo</td>
                        <td  width="240" class="cellRight" >
						  <div class="contec_center">
						    <img src="{$DATOSORDENSEGUIMIENTO.foto_vehiculo}"  height="70" />
						  </div>
						</td>
                    </tr>
                    
                    <tr align="center" >
                        <td  width="240"  class="cellTitleLeft" >Placa</td>
                        <td  width="240" class="cellTitleRight">Marca</td>
                        <td  width="240" class="cellTitleRight">Linea</td>
                    </tr>
                    <tr >
                        <td  width="240" class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.placa}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.marca}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.linea}</div></td>
                    </tr>
                    <tr align="center" >
                        <td  width="240"  class="cellTitleLeft" >Modelo</td>
                        <td  width="240" class="cellTitleRight">Model Repotenciado</td>
                        <td  width="240" class="cellTitleRight">SERIE No</td>
                    </tr>
                    <tr >
                        <td  width="240" class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.modelo}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.modelo_repotenciado}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.serie}</div></td>
                    </tr>
                    <tr align="center" >
                        <td  width="240"  class="cellTitleLeft" >Color</td>
                        <td  width="240" class="cellTitleRight">Tipo de Carroceria</td>
                        <td  width="240" class="cellTitleRight">Registro Nacional de Carga</td>
                    </tr>
        			<tr >
                        <td  width="240" class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.color}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.carroceria}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.registro_nacional_carga}</div></td>
			        </tr>
                    <tr align="center" >
                        <td  width="240"  class="cellTitleLeft" >Configuraci&oacute;n</td>
                        <td  width="240" class="cellTitleRight">Peso Vacio</td>
                        <td  width="240" class="cellTitleRight">N&uacute;mero P&oacute;liza SOAT</td>
                    </tr>
                    <tr >
                        <td  width="240" class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.configuracion}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.peso_vacio}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.numero_soat}</div></td>
                    </tr>
                    <tr align="center" >
                        <td  width="240"  class="cellTitleLeft" >Compa&ntilde;ia Seguros SOAT</td>
                        <td  width="240" class="cellTitleRight">Vencimiento SOAT</td>
                        <td  width="240" class="cellTitleRight">Placa Remolque</td>
                    </tr>
                    <tr >
                        <td  width="240" class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.nombre_aseguradora}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.vencimiento_soat}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.placa_remolque}</div></td>
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
				<table cellspacing="0" cellpadding="0" width="100%" border="0">
        			<tr >
          				<td colspan="3"  class="title">INFORMACI&Oacute;N DEL CONDUCTOR</td>
        			</tr>
                    <tr>
                        <td  width="480" class="cellTitleLeft" colspan="2">Foto Conductor</td>
                        <td  width="240" class="cellRight" >
						  <div class="contec_center">
						    <img src="{$DATOSORDENSEGUIMIENTO.foto_conductor}"  height="70" />
						  </div>
						</td>
                    </tr>

                    <tr align="center" >
                        <td  width="240"  class="cellTitleLeft" >Nombres y Apellidos</td>
                        <td  width="240" class="cellTitleRight">Documento de Identificaci&oacute;n</td>
                        <td  width="240" class="cellTitleRight">Categor&iacute;a Licencia</td>
                    </tr>
                    <tr >
                        <td  width="240" class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.nombre}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.numero_identificacion}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.categoria_licencia_conductor}</div></td>
                    </tr>
                    <tr align="center" >
                        <td  width="240"  class="cellLeft" >Direcci&oacute;n</td>
                        <td  width="240" class="cellRight">Tel&eacute;fono</td>
                        <td  width="240" class="cellRight">Ciudad</td>
                    </tr>
                    <tr >
                        <td  width="240" class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.direccion_conductor}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.telefono_conductor}</div></td>
                        <td  width="240" class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.ciudad_conductor}</div></td>
                    </tr>
				</table>
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
                        <td width="240">Conductor</td>
                    </tr>

                </table>
            </td>
        </tr>    
	</table>                   
</page>