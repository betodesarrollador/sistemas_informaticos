{literal}
<style>
/* CSS Document */

   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#F2F2F2;
	 font-weight:bold;
	 text-align:center;
	 border-top:1px solid;
	 border-right:1px solid;
	 border-left:1px solid;
	 border-bottom:1px solid;
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
	   opacity:0.1;
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
	   opacity:0.1;
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
	   opacity:0.1;
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
	   opacity:0.1;
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
	   opacity:0.1;
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
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

</style>
{/literal}
	
<page orientation="portrait" >
	{if $DATOSORDENCARGUE.estado eq 'A'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
        <div class="anulado2">ANULADO</div>
    {/if}    
	{if $DATOSORDENCARGUE.estado eq 'R'}
        <div class="realizado">REALIZADO</div>
        <div class="realizado1">REALIZADO</div>
        <div class="realizado2">REALIZADO</div>
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
                                    	<img src="{$DATOSORDENCARGUE.logo}" width="150" height="40" alt="Imagen Logo" />                                       
                                    </td>
              						<td width="240" valign="top" align="center">
                                        <span class="fontsmall">{$DATOSORDENCARGUE.razon_social}<br />{$DATOSORDENCARGUE.tipo_identificacion_emp} {$DATOSORDENCARGUE.numero_identificacion_emp}<br />{$DATOSORDENCARGUE.dir_oficna}. <br />Tel&eacute;fonos: {$DATOSORDENCARGUE.tel_oficina}. Ciudad: {$DATOSORDENCARGUE.ciudad_ofi} </span>
                                    </td>
              						<td width="33" align="center" valign="top">&nbsp;</td>
              						<td width="180" valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right">
                  							<tr >
                    							<td  class="title">
                                                	<strong class="fontBig">ORDEN DE CARGUE No</strong>
                                                </td>
                  							</tr>
                  							<tr >
                    							<td class="infogeneral">{$DATOSORDENCARGUE.consecutivo}</td>
                  							</tr>
                  							<tr >
                    							<td  class="title">OFICINA</td>
                  							</tr>
                  							<tr>
                    							<td class="infogeneral">{$DATOSORDENCARGUE.nom_oficina}</td>
                  							</tr>
                  							<tr>
                    							<td class="title">Fecha Expedici&oacute;n</td>
                  							</tr>
                  							<tr>
                    							<td class="infogeneral">{$DATOSORDENCARGUE.fecha_ingre}</td>
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
                    	<td><div class="encabezado">Autorizamos para entregar al Se&ntilde;or Conductor {$DATOSORDENCARGUE.nombre}, del Vehiculo de placas {$DATOSORDENCARGUE.placa} la siguiente mercanc&iacute;a: {$DATOSORDENCARGUE.producto}</div></td>
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
        										<td  colspan="4" class="title">DATOS DEL CLIENTE Y ESPECIFICACIONES DE CARGUE</td>
      										</tr>
      										<tr>
                                                <td width="130"  class="cellTitleLeft">Cliente:</td>
                                                <td width="330" class="cellLeft"><span class="content">{$DATOSORDENCARGUE.cliente}</span></td>
                                                <td width="140" class="cellTitleRight">Identificaci&oacute;n:</td>
                                                <td width="180" class="cellRight"><span class="content">{$DATOSORDENCARGUE.cliente_nit}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Direcci&oacute;n Cargue:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENCARGUE.direccion_cargue}</span></td>
                                                <td class="cellTitleRight">Tel&eacute;fono:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCARGUE.cliente_tel}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Contacto:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENCARGUE.contacto}</span></td>
                                                <td class="cellTitleRight">Tipo Servicio:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCARGUE.tipo_servicio}</span></td>
                                          </tr>
                                          
                                          <tr>
                                                <td class="cellTitleLeft">Origen:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENCARGUE.origen}</span></td>
                                                <td class="cellTitleRight">Destino:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCARGUE.destino}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Producto:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENCARGUE.producto}</span></td>
                                                <td class="cellTitleRight">Cantidad:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCARGUE.cantidad_cargue}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Peso:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENCARGUE.peso}</span></td>
                                                <td class="cellTitleRight">Unidad Peso:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCARGUE.unidad_peso}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Volumen:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENCARGUE.peso_volumen}</span></td>
                                                <td class="cellTitleRight">Unidad Volumen:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCARGUE.unidad_volumen}</span></td>
                                          </tr>
                                          <tr>
                                                <td class="cellTitleLeft">Fecha:</td>
                                                <td class="cellLeft"><span class="content">{$DATOSORDENCARGUE.fecha}</span></td>
                                                <td class="cellTitleRight">Hora:</td>
                                                <td class="cellRight"><span class="content">{$DATOSORDENCARGUE.hora}</span></td>
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
          				<td colspan="4"  class="title">INFORMACI&Oacute;N DEL VEHICULO</td>
        			</tr>
                    <tr>
                        <td rowspan="6" class="cellTitleLeft"><span class="contec_center">
						<img src="{$DATOSORDENCARGUE.foto_vehiculo}" width="169"  height="121" alt="No existe Imagen del vehiculo" /></span></td>
                        <td  width="240" class="cellTitleLeft" align="center">Placa</td>
                        <td  width="240" class="cellTitleLeft" align="center">Marca</td>
                        <td  width="240" class="cellRight" align="center" >Modelo</td>
                    </tr>
                    <tr>
                      <td  width="240" class="cellTitleLeft"><span class="contec_center">{$DATOSORDENCARGUE.placa}</span></td>
                      <td  width="240" class="cellTitleLeft"><span class="contec_center">{$DATOSORDENCARGUE.marca}</span></td>
                      <td class="cellRight" ><span class="contec_center">{$DATOSORDENCARGUE.modelo}</span></td>
                    </tr>
                    <tr>
                      <td  width="240" class="cellTitleLeft">Model Repotenciado</td>
                      <td  width="240" class="cellTitleLeft">Linea</td>
                      <td class="cellRight" >SERIE No</td>
                    </tr>
                    <tr>
                      <td  width="240" class="cellTitleLeft"><span class="contec_center">{$DATOSORDENCARGUE.modelo_repotenciado}</span></td>
                      <td  width="240" class="cellTitleLeft"><span class="contec_center">{$DATOSORDENCARGUE.linea}</span></td>
                      <td class="cellRight" ><span class="contec_center">{$DATOSORDENCARGUE.serie}</span></td>
                    </tr>
                    
                    <tr align="center" >
                        <td  width="240"  class="cellTitleLeft" >Color</td>
                        <td  width="240" class="cellTitleRight">Tipo de Carroceria</td>
                        <td  width="240" class="cellTitleRight">Registro Nacional de Carga</td>
                    </tr>
                    <tr align="center" >
                      <td  class="cellTitleLeft" ><span class="contec_center">{$DATOSORDENCARGUE.color}</span></td>
                      <td  width="240" class="cellTitleRight"><span class="contec_center">{$DATOSORDENCARGUE.carroceria}</span></td>
                      <td  width="240" class="cellTitleRight"><span class="contec_center">{$DATOSORDENCARGUE.registro_nacional_carga}</span></td>
                    </tr>
                    <tr >
                        <td  width="240" colspan="2" class="cellLeft" >Configuraci&oacute;n</td>
                        <td  width="240" class="cellRight">Peso Vacio</div></td>
                        <td  width="240" class="cellRight">N&uacute;mero P&oacute;liza SOAT</div></td>
                    </tr>
                    <tr align="center" >
                        <td  width="240" colspan="2"  class="cellTitleLeft" ><span class="contec_center">{$DATOSORDENCARGUE.configuracion}</span></td>
                        <td  width="240" class="cellTitleRight"><span class="contec_center">{$DATOSORDENCARGUE.peso_vacio}</span></td>
                        <td  width="240" class="cellTitleRight"><span class="contec_center">{$DATOSORDENCARGUE.numero_soat}</span></td>
                    </tr>
                    <tr >
                        <td  width="240" colspan="2" class="cellLeft" >
						Compa&ntilde;ia Seguros SOAT</td>
                        <td  width="240" class="cellRight">Vencimiento SOAT</td>
                        <td  width="240" class="cellRight">Placa Remolque</td>
                    </tr>
                    <tr align="center" >
                        <td  width="240" colspan="2"  class="cellTitleLeft" ><span class="contec_center">{$DATOSORDENCARGUE.nombre_aseguradora}</span></td>
                        <td  width="240" class="cellTitleRight"><span class="contec_center">{$DATOSORDENCARGUE.vencimiento_soat}</span></td>
                        <td  width="240" class="cellTitleRight"><span class="contec_center">{$DATOSORDENCARGUE.placa_remolque}</span></td>
                    </tr>
        			<tr >
                        <td  width="240" colspan="2" class="cellLeft" ><div class="contec_center"></div></td>
                        <td  width="240" class="cellRight"><div class="contec_center"></div></td>
                        <td  width="240" class="cellRight"><div class="contec_center"></div></td>
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
                        <td  rowspan="7" class="cellTitleLeft">
						  <img src="{$DATOSORDENCARGUE.foto_conductor}" width="160"  height="126" alt="No existe imagen del conductor" /></td>
                        <td  width="490" class="cellTitleLeft">Nombres y Apellidos</td>
                        <td  width="487" class="cellRight" >Documento de Identificaci&oacute;n</td>
                    </tr>
                    <tr>
                      <td class="cellTitleLeft"><span class="contec_center">{$DATOSORDENCARGUE.nombre}</span></td>
                      <td  width="487" class="cellRight" ><span class="contec_center">{$DATOSORDENCARGUE.numero_identificacion}</span></td>
                    </tr>

                    <tr align="center" >
                        <td  width="490" class="cellTitleRight">Ciudad</td>
                        <td  width="487" class="cellTitleRight">Direcci&oacute;n</td>
                    </tr>
                    <tr >
                        <td  width="490" class="cellRight"><span class="contec_center">{$DATOSORDENCARGUE.ciudad_conductor}</span></td>
                        <td  width="487" class="cellRight"><div class="contec_center">{$DATOSORDENCARGUE.direccion_conductor}</div></td>
                    </tr>
                    <tr >
                      <td class="cellRight">Tel&eacute;fono</td>
                      <td  width="487" class="cellRight">Licencia</td>
                    </tr>
                    <tr >
                      <td class="cellRight"><span class="contec_center">{$DATOSORDENCARGUE.telefono_conductor}</span></td>
                      <td  width="487" class="cellRight"><span class="contec_center">{$DATOSORDENCARGUE.telefono_conductor}</span></td>
                    </tr>
                    <tr >
                      <td class="cellRight">Categor&iacute;a Licencia</td>
                      <td  width="487" class="cellRight">&nbsp;</td>
                    </tr>
                    <tr align="center" >
                        <td  width="160"  class="cellLeft" >&nbsp;</td>
                        <td  width="490" class="cellRight">{$DATOSORDENCARGUE.categoria_licencia_conductor}</td>
                        <td  width="487" class="cellRight">&nbsp;</td>
                    </tr>
				</table>
			</td>                    
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		  <td>
		    <table width="100%">
			 <tr>
			   <td class="title" align="left">OBSERVACIONES</td>
			   <td class="cellRight" style="border-top:1px solid" width="80%">&nbsp;{$DATOSORDENCARGUE.observaciones}</td>
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