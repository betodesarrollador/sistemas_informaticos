<html>
  <head>

{literal}
<style>
/* CSS Document */

   table tr td table{
     width:100%;
   }

   table tr td{
      font-size:12px;
	  padding:2px;
   }
     
   .title{
     background-color:#CECECE;
	 font-weight:bold;
	 text-align:center;
	 border:1px solid;
   }

    .borderTop{
	  border-top:1px solid;
	}

    .borderLeft{
	  border-right:1px solid;
	}
	
    .borderRight{
	  border-right:1px solid;
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
	   text-align:justify;
	   font-size:14px;
	
   }


</style>
{/literal}
<title>Impresion Orden Particular</title>
</head>

<body onLoad="javascript:window.print()">
	
	{if $DATOSORDENSEGUIMIENTO.estado eq 'A'}
        {/if}    
	{if $DATOSORDENSEGUIMIENTO.estado eq 'F'}
        <div class="realizado2">FINALIZADO</div>
    {/if}    
    
	<table style="margin-left:15px; margin-top:15px; margin-right:15px;"  cellpadding="0" cellspacing="0">
    	<tr>
      		<td align="center">
            	<table width="100%" border="0">
        			<tr>
          				<td>
                        	<table  border="0" cellpadding="0" cellspacing="0">
            					<tr>
             						<td align="left" valign="top">
                                    	<img src="{$DATOSORDENSEGUIMIENTO.logo}" width="160" height="40" />                                    </td>
           						  <td valign="top" align="center">
                                    <span class="fontsmall">
                                    {$DATOSORDENSEGUIMIENTO.razon_social}<br />
                                    {$DATOSORDENSEGUIMIENTO.tipo_identificacion_emp} {$DATOSORDENSEGUIMIENTO.numero_identificacion_emp}<br />
                                    OFICINA  {$DATOSORDENSEGUIMIENTO.nom_oficina} <br />
                                      {$DATOSORDENSEGUIMIENTO.dir_oficna}. <br />
                                      TEL: {$DATOSORDENSEGUIMIENTO.tel_oficina}. CIUDAD: {$DATOSORDENSEGUIMIENTO.ciudad_ofi}<BR />
                                    </p></td>
              						<td align="center" valign="top"><img src="../../../framework/media/images/general/Logo_BASC.jpg" /></td>
              						<td valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right">
                  							<tr >
                    							<td  class="title">
                                                	DESPACHO PARTICULAR No                                                </td>
                  							</tr>
                  							<tr >
                    							<td class="borderLeft borderRight" align="center">{$DATOSORDENSEGUIMIENTO.seguimiento_id}</td>
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
                    	<td><div class="encabezado">Autorizamos al Se&ntilde;or Conductor {$DATOSORDENSEGUIMIENTO.nombre}, del Vehiculo de placas {$DATOSORDENSEGUIMIENTO.placa} que realice el servicio de transporte.</div></td>
                    </tr>
      			</table>
			</td>
        </tr>
		<tr><td><table cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td  colspan="4" class="title">DATOS DEL CLIENTE Y ESPECIFICACIONES</td>
          </tr>
          <tr>
            <td width="10%"  class="cellTitleLeft">Cliente:</td>
            <td width="33%" class="cellTitleRight">{$DATOSORDENSEGUIMIENTO.cliente}</td>
            <td width="7%" class="cellTitleRight">Identificaci&oacute;n:</td>
            <td width="50%" class="cellRight"><span >{$DATOSORDENSEGUIMIENTO.cliente_nit}</span></td>
          </tr>
          <tr>
            <td class="cellTitleLeft">Direcci&oacute;n Cargue:</td>
            <td class="cellTitleRight"><span >{$DATOSORDENSEGUIMIENTO.direccion_cargue}</span></td>
            <td class="cellTitleRight">Tel&eacute;fono:</td>
            <td class="cellRight"><span >{$DATOSORDENSEGUIMIENTO.cliente_tel}</span></td>
          </tr>
          <tr>
            <td class="cellTitleLeft">M&oacute;vil:</td>
            <td class="cellTitleRight"><span >{$DATOSORDENSEGUIMIENTO.movil_conductor}</span></td>
            <td class="cellTitleRight">Correo:</td>
            <td class="cellRight"><span >{$DATOSORDENSEGUIMIENTO.correo_conductor}</span></td>
          </tr>
          <tr>
            <td class="cellTitleLeft">Origen:</td>
            <td class="cellTitleRight"><span >{$DATOSORDENSEGUIMIENTO.origen}</span></td>
            <td class="cellTitleRight">Destino:</td>
            <td class="cellRight"><span >{$DATOSORDENSEGUIMIENTO.destino}</span></td>
          </tr>
          <tr>
            <td class="cellTitleLeft">Fecha:</td>
            <td class="cellTitleRight"><span >{$DATOSORDENSEGUIMIENTO.fecha}</span></td>
            <td class="cellTitleRight">Contactos:</td>
            <td class="cellRight">&nbsp;{foreach name=contactos from=$CONTACTOS item=i}  {$i.nombre_contacto}&nbsp; M&oacute;vil: {$i.cel_contacto}<br />
              {/foreach}</td>
          </tr>
        </table></td></tr>
    	<tr>
   		  <td>
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
        			<tr >
          				<td colspan="4"  class="title">INFORMACI&Oacute;N DEL VEHICULO</td>
        			</tr>
                    
                    <tr align="center" >
                        <td width="38%"  class="cellTitleLeft" >Placa</td>
                        <td width="39%" class="cellTitleRight">Marca</td>
                        <td width="23%" colspan="2" rowspan="8" align="right" class="cellTitleRight">
						  <img src="{$DATOSORDENSEGUIMIENTO.foto_vehiculo}" width="265"  height="184" alt="Imagen del Vehiculo no disponible" />
						</td>
                    </tr>
                    <tr >
                      <td class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.placa}</div></td>
                        <td class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.marca}</div></td>
                    </tr>
                    <tr align="center" >
                        <td  class="cellTitleLeft" >Linea</td>
                        <td class="cellTitleRight">Modelo</td>
                    </tr>
                    <tr >
                      <td class="cellLeft" align="center" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.linea}</div></td>
                        <td class="cellRight"><div class="contec_center"><span class="contec_center">{$DATOSORDENSEGUIMIENTO.modelo}</span></div></td>
                    </tr>
                    <tr align="center" >
                        <td  class="cellTitleLeft" >Model Repotenciado</td>
                        <td class="cellTitleRight">SERIE No</td>
                    </tr>
        			<tr >
                      <td class="cellLeft" ><div class="contec_center"><span class="contec_center">{$DATOSORDENSEGUIMIENTO.modelo_repotenciado}</span></div></td>
                        <td class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.serie}</div></td>
                    </tr>
                    <tr >
                      <td class="cellLeft" >Color</td>
                      <td class="cellRight">Tipo de Carroceria</td>
                    </tr>
                    <tr >
                      <td align="center"  class="cellTitleLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.color}</div></td>
                      <td align="center" class="cellTitleRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.carroceria}</div></td>
                    </tr>
			  </table>
		  </td>                    
		</tr>   
    	<tr>
   		  <td>
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
        			<tr >
          				<td colspan="3"  class="title">INFORMACI&Oacute;N DEL CONDUCTOR</td>
        			</tr>

                    <tr align="center" >
                        <td width="38%"  class="cellTitleLeft" >Nombres y Apellidos</td>
                        <td width="39%" class="cellTitleRight">Documento de Identificaci&oacute;n</td>
                        <td width="23%" rowspan="6" class="cellTitleRight">
						  <img src="{$DATOSORDENSEGUIMIENTO.foto_conductor}" width="265"  height="184" alt="Imagen del conductor no disponible" />
						</td>
                    </tr>
                    <tr >
                      <td class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.nombre}</div></td>
                        <td class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.numero_identificacion}</div></td>
                    </tr>
                    <tr >
                      <td class="cellLeft" >Categor&iacute;a Licencia</td>
                      <td class="cellRight">Direcci&oacute;n</td>
                    </tr>
                    <tr >
                      <td class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.categoria_licencia_conductor}</div></td>
                      <td class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.direccion_conductor}</div></td>
                    </tr>
                    <tr align="center" >
                      <td  class="cellLeft" >Tel&eacute;fono</td>
                      <td class="cellRight">Ciudad</td>
                    </tr>
                    <tr >
                      <td class="cellLeft" ><div class="contec_center">{$DATOSORDENSEGUIMIENTO.telefono_conductor}</div></td>
                      <td class="cellRight"><div class="contec_center">{$DATOSORDENSEGUIMIENTO.ciudad_conductor}</div></td>
                    </tr>
			  </table>
		  </td>                    
		</tr>
		<tr>
		  <td>
           <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		     <tr><td colspan="2" class="title">FLETE PACTADO</td>
		     </tr>
            <tr>
              <td width="295" class="cellLeft">VALOR A PAGAR PACTADO</td>
              <td width="969" align="right" class="cellRight">{if $DATOSORDENSEGUIMIENTO.valor_flete > 0}&nbsp;${$DATOSORDENSEGUIMIENTO.valor_flete|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
            </tr>
			
			{if count($IMPUESTOS) > 0}&nbsp;
			
			  {foreach name=impuestos from=$IMPUESTOS item=i}&nbsp;
              <tr>
                <td class="cellLeft">{$i.nombre}&nbsp;</td>
                <td class="cellRight" align="right">{if $i.valor > 0}&nbsp;${$i.valor|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
              </tr>			
			  {/foreach}&nbsp;
			
			{else}&nbsp;
              <tr>
                <td class="cellLeft">RETENCION EN LA    FUENTE</td>
                <td class="cellRight" align="right">0</td>
              </tr>
              <tr>
                <td class="cellLeft">RETENCION ICA</td>
                <td class="cellRight" align="right">0</td>
              </tr>			
            {/if}&nbsp;						
			
            <tr>
              <td class="cellLeft">VALOR NETO A PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSORDENSEGUIMIENTO.valor_neto_pagar > 0}&nbsp;${$DATOSORDENSEGUIMIENTO.valor_neto_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
            </tr>
            <tr>
              <td class="cellLeft">ANTICIPO EMPRESA&nbsp;</td>
              <td class="cellRight" align="right">{if $DATOSORDENSEGUIMIENTO.valor_anticipo_empresa > 0}&nbsp;${$DATOSORDENSEGUIMIENTO.valor_anticipo_empresa|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
            </tr>
            <tr>
              <td class="cellLeft">ANTICIPO CLIENTE&nbsp;</td>
              <td class="cellRight" align="right">{if $DATOSORDENSEGUIMIENTO.valor_anticipo_cliente > 0}&nbsp;${$DATOSORDENSEGUIMIENTO.valor_anticipo_cliente|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
            </tr>			
            <tr>
              <td class="cellLeft">SALDO POR PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSORDENSEGUIMIENTO.saldo_por_pagar > 0}&nbsp;${$DATOSORDENSEGUIMIENTO.saldo_por_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
            </tr>
          </table>		  
		  </td>
		</tr>
        <tr>
        	<td>
            	<table cellspacing="0" cellpadding="0" border="0">
                	<tr>
                    	<td  height="70" valign="bottom" align="center">_____________________________________</td>
                        <td >&nbsp;</td>
                        <td valign="bottom" align="center">_____________________________________</td>
                    </tr>
                	<tr>
                    	<td  align="center">Empresa</td>
                        <td >&nbsp;</td>
                        <td align="center">Conductor</td>
                    </tr>

              </table>
            </td>
        </tr>    
</table>                   
</body>
</html>