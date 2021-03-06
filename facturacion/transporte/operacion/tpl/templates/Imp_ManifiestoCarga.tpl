<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
{literal}&nbsp;
<style>

/* CSS Document */

.table_condi{
	border:#000 2px solid;
	font-size:9px;
	width:600px;
	font-family:Arial, Helvetica, sans-serif;
}
.table_condi td{
	padding:2px 1px 2px 1px;
		
}
.bottom_condi{
	border-bottom:#000 2px solid;
}
.celda_bordes{
	border:#000 1px solid;
}
.table_detalles{
	border:#000 2px solid;
	font-size:12px;
	width:600px;
	font-family:Arial, Helvetica, sans-serif;
}
.celda_nombre{
	height:20px;
	width:270px;
	text-align:center;
}

.celda_control{
	height:80px;
	width:290px;
}
.celda_firmas{
	height:70px;
	width:170px;
}



#contenedor{
	width:1200px;
	height:572px;
	/*background:#000000;*/
}

</style>
<style>

    .saltopagina {
      page-break-after: always;
    }	

   table tr td{
      font-size:8px;
   }
   
   .borderRight{
     border-right:1px solid;
   }
   
   .borderLeft{
    border-left:1px solid;
   }
   
   .borderBottom{
     border-bottom:1px solid;
   }

   .borderTop{
     border-top:1px solid;
   }

     
   .title{
     /*background-color:#999999;*/
	 font-weight:bold;
	 text-align:center;
	 border:1px solid;
   }
   
   .fontBig{
     font-size:10px;
   }
   
   .fontBig1{
     font-size:10.3px;
   }
   
    .fontBig2{
     font-size:11px;
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
   
    .cellTotal{
	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
	   
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
	font-size:8px;
	text-align:center;
	text-transform:uppercase;
   }
   
   .cellTitleProd{
      font-size:6px;
	  font-weight:bold;
	  vertical-align:middle;
    }
 
   .anulado{
      color:#003366;
	  font-size:70px;
   }
	
  	
</style>

{/literal}
</head>
<body onLoad="javascript:window.print()">
{if $DATOSMANIFIESTO.aprobacion_ministerio2 neq '0' && $DATOSMANIFIESTO.aprobacion_ministerio2 neq '' || $DATOSMANIFIESTO.estado eq 'A' || $DATOSMANIFIESTO.activo_impresion eq 'N'}
  <title>Impresion Manifieso de Carga :{$DATOSMANIFIESTO.manifiesto}</title> 
          <div style="position:relative">
          {if $DATOSMANIFIESTO.estado eq 'A'}<div style="position:absolute; top:13px; left:15px" class="anulado">MANIFIESTO ANULADO</div>{/if}
            
          <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td colspan="2" align="center">
              	<table width="100%" border="0" cellpadding="0" cellspacing="0">
               	  <tr>
                  	<td>
       	  <table  border="0" cellpadding="0" cellspacing="0" width="100%">
                    		<tr>
                    		 <td width="300" align="left">
                         <img src="{$DATOSMANIFIESTO.logo}" width="150" height="50" />&nbsp;			  				 
                         <img src="../../../framework/media/images/general/supertransporte.png" width="207" height="42" />	
                         <img src="../../../framework/media/images/general/ministerioo.jpg" width="213" height="63" />&nbsp;&nbsp;&nbsp;	   
                      </td>
                      <td width="600" align="center">
                        <div style="font-size:12px;">{$DATOSMANIFIESTO.razon_social}</div>
                        <div>NIT: {$DATOSMANIFIESTO.numero_identificacion_empresa}</div>
                        <div>&nbsp;</div>
                        <div>{$DATOSMANIFIESTO.direccion}</div>		
                        <div>TEL: {$DATOSMANIFIESTO.telefono}</div>	
                        <div>{$DATOSMANIFIESTO.ciudad}</div>
                        <div>{if $DATOSMANIFIESTO.id_mobile neq ''} ID MOBILE : {$DATOSMANIFIESTO.id_mobile}&nbsp;{/if}</div>			
                      </td>
                      <td width="500" align="center"> 
                         <span class="contec_center"><img src="{$DATOSMANIFIESTO.foto_vehiculo}" width="126"  height="91" /></span><img src="{$DATOSMANIFIESTO.foto_conductor}" width="126"  height="91" /></td>
                         <td style="vertical-align:top"><img src="{$CODIGOQR}" width="126"  height="100" />&nbsp;</td>
                      <td width="400" valign="top" align="right"><table cellspacing="0" cellpadding="0" align="right">
                      	                       
                        <tr >
                           <td class="title borderTop">Nro. MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
                        </tr>
                        <tr >
                          <td class="infogeneral"><font size="1">{$DATOSMANIFIESTO.manifiesto}&nbsp;</font></td>
                        </tr>
                        <tr >
                          <td class="title">AUTORIZACI&Oacute;N</td>
                        </tr>                
                        <tr >
                          <td align="center" class="borderLeft borderRight borderBottom">{if $DATOSMANIFIESTO.aprobacion_ministerio2 neq '0' && $DATOSMANIFIESTO.aprobacion_ministerio2 neq '' }{$DATOSMANIFIESTO.aprobacion_ministerio2}{else} ART. 10 DEL TITULO VII  RESOL. 0377 DE 2013 (Por favor Revise Observaciones){/if}</td>
                        </tr>
                        
                        <tr>
                         <td>"La impresión en soporte cartular (papel) de este acto administrativo producido por medios electronicos en cumplimiento de la ley 527 de 1999 (Articulos 6 al 13) y de la ley 962 de 2005 (Articulo 6), es una reproducción del documento original que se encuentra en formato electrónico, cuya representación digital goza de autenticidad, integridad y no repudio."</td>
                          
                        </tr>  
                        
                      </table></td>
                      
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>
        <table  border="0" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="73%" valign="bottom"><table cellspacing="0" cellpadding="0" border="0">
            </table></td>
            
            <td width="27%" valign="bottom"><table cellspacing="0" cellpadding="0" border="0" >
            </table></td>
            
          </tr>
        </table></td>
                </tr>
              </table></td>
            </tr>
            
            <tr>
              <td colspan="2">
        <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tr>
                  <td colspan="4" class="borderBottom">&nbsp;</td>
                </tr>
                <tr align="center">
                  <td  width="155"  class="cellLeft" >Fecha de Expedici&oacute;n</td>
                  <td  width="300" class="cellRight">Tipo Manifiesto</td>
                  <td  width="310" class="cellRight">Origen Viaje</td>
                  <td  width="200" class="cellRight">Destino Viaje</span></td>
                </tr>
                <tr align="center" >
                  <td  width="155" class="cellLeft" >{$DATOSMANIFIESTO.fecha_mc}&nbsp;</td>
                  <td  width="300" class="cellRight">{$DATOSMANIFIESTO.tipo_manifiesto|upper}&nbsp;</td>
                  <td  width="310" class="cellRight">{$DATOSMANIFIESTO.origen}&nbsp;</td>
                  <td  width="180" class="cellRight" align="center">{$DATOSMANIFIESTO.destino}&nbsp;</td>
                </tr>
              </table>	  
              <table cellspacing="0" cellpadding="0" width="100%" border="0" >
          <tr >
            <td colspan="9"   class="cellLeft" align="center">INFORMACION DEL VEH&Iacute;CULO Y CONDUCTOR</td>
          </tr> 
                    <tr align="center" >
                      <td width="230" colspan="3" class="cellLeft" >Titular Manifiesto</td>
                      <td width="150" class="cellRight">Documento de Identificaci&oacute;n</td>
                      <td width="250" colspan="2" class="cellRight">Direcci&oacute;n del Titular</td>
                      <td width="150" class="cellRight">Tel&eacute;fono del Titular</td>
                      <td width="180" colspan="2" class="cellRight">Ciudad y Departamento</td>
                    </tr>
                    <tr align="center" >
                      <td class="cellLeft" colspan="3" >{$DATOSMANIFIESTO.titular_manifiesto}&nbsp;</td>
                      <td class="cellRight">{$DATOSMANIFIESTO.numero_identificacion_titular_manifiesto}&nbsp;</td>
                      <td class="cellRight" colspan="2" >{$DATOSMANIFIESTO.direccion_titular_manifiesto|substr:0:57}&nbsp;</td>
                      <td class="cellRight">{$DATOSMANIFIESTO.telefono_titular_manifiesto}&nbsp;</td>
                      <td class="cellRight" colspan="2" >{$DATOSMANIFIESTO.ciudad_titular_manifiesto}&nbsp;</td>
                    </tr>  
          <tr align="center">
            <td width="80" class="cellLeft">Placa</td>
            <td width="160" class="cellRight">Marca</td>    
            <td width="100" class="cellRight">Placa Remolque</td>
            <td width="80" class="cellRight">Configuraci&oacute;n</td>
            <td width="50" class="cellRight">Peso Vac&iacute;o</td>   
            <td width="110" class="cellRight">Poliza</td>     
            <td width="187" class="cellRight">Compa&ntilde;&iacute;a de Seguros SOAT</td>
            <td width="120" class="cellRight">Vencimiento SOAT</td>    
          </tr>
          <tr >
            <td class="cellLeft" align="center" >{$DATOSMANIFIESTO.placa}&nbsp;</td>
            <td class="cellRight" align="center">{$DATOSMANIFIESTO.marca}&nbsp;</td>    
            <td class="cellRight" align="center">{$DATOSMANIFIESTO.placa_remolque}&nbsp;</td>
            <td class="cellRight" align="center">{$DATOSMANIFIESTO.configuracion}&nbsp;</td>
            <td class="cellRight" align="center">{$DATOSMANIFIESTO.peso_vacio}&nbsp;</td>
            <td class="cellRight" align="center">{$DATOSMANIFIESTO.numero_soat}&nbsp;</td>
            <td class="cellRight" align="center">{$DATOSMANIFIESTO.nombre_aseguradora}&nbsp;</td>
            <td class="cellRight" align="center">{$DATOSMANIFIESTO.vencimiento_soat}&nbsp;</td>    
          </tr>
          </table>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr align="center" >
            <td width="15%" class="cellLeft" align="center">Conductor</td>
            <td width="15%" class="cellRight" align="center">Documento de Identificaci&oacute;n</td>
            <td width="25%" class="cellRight" align="center">Direcci&oacute;n</td>   
            <td width="10%" class="cellRight" align="center">Tel&eacute;fono</td>     
            <td width="10%" class="cellRight" align="center"> Nro. Licencia</td>
            <td width="15%" class="cellRight" align="center">Ciudad y Departamento</td>
          </tr>
          <tr >
            <td width="15%" class="cellLeft" align="center">{$DATOSMANIFIESTO.nombre}&nbsp;</td>
            <td width="15%" class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_conductor}&nbsp;</td>
            <td width="25%" class="cellRight" align="center">{$DATOSMANIFIESTO.direccion_conductor}&nbsp;</td>
            <td width="10%" class="cellRight" align="center">{$DATOSMANIFIESTO.telefono_conductor}&nbsp;</td> 
            <td width="10%" class="cellRight" align="center">{$DATOSMANIFIESTO.numero_licencia_cond}&nbsp;</td>    
            <td width="15%" class="cellRight" align="center">{$DATOSMANIFIESTO.ciudad_conductor}&nbsp;</td>
          </tr>
        </table>
          <table width="100%" cellpadding="0" cellspacing="0" border="0" >
          <tr >
            <td width="15%" align="center" class="cellLeft">Poseedor o Tenedor del Veh&iacute;culo</td>
            <td width="15%" align="center" class="cellRight">Documento de Identificaci&oacute;n</td>
            <td width="25%" align="center" class="cellRight">Direcci&oacute;n</td>
            <td width="20%" align="center" class="cellRight">Tel&eacute;fono</td>
            <td width="15%" colspan="2" align="center" class="cellRight">Ciudad y Departamento</td>
          </tr>
          <tr >
            <td width="15%" class="cellLeft" align="center">{$DATOSMANIFIESTO.tenedor}&nbsp;</td>
            <td width="15%" class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_tenedor}&nbsp;</td>
            <td width="25%" class="cellRight" align="center">{$DATOSMANIFIESTO.direccion_tenedor}&nbsp;</td>
            <td width="20%" class="cellRight" align="center">{$DATOSMANIFIESTO.telefono_tenedor}&nbsp;</td>
            <td width="15%" class="cellRight" colspan="2" align="center">{$DATOSMANIFIESTO.ciudad_tenedor}&nbsp;</td>
          </tr>
          </table></td>
            </tr>
            <tr>
              <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr ></tr>
                <tr >
                  <td  align="center" colspan="14" class="cellRight borderLeft">INFORMACI&Oacute;N DE LA MERCANC&Iacute;A TRANSPORTADA</td>
                </tr>
                <tr >
                  <td  align="center" colspan="6" class="cellRight borderLeft">Informaci&oacute;n Mercanc&iacute;a</td>
                  <td  align="center" colspan="1" class="cellRight">Informaci&oacute;n Remitente</td>
                  <td  align="center" colspan="1" class="cellRight borderLef" >Informaci&oacute;n Destinatario</td>
                  <td  align="center" colspan="1" class="cellRight">Dueño Poliza</td>
                </tr>
                <tr align="center">
                  <td width="38"  class="cellLeft cellTitleProd">Nro. Remesa</td>
                  <td width="31" class="cellRight cellTitleProd">Unidad Medida</td>
                   <td width="31" class="cellRight cellTitleProd">Peso</td>
                  <td width="28" class="cellRight cellTitleProd">Cantidad</td>
                  <td width="40" class="cellRight cellTitleProd">Naturaleza</td>
                  <td width="89" class="cellRight cellTitleProd">Empaque - Producto Transportado</td>
                  <td width="160" colspan="1" class="cellRight cellTitleProd">NIT/CC Nombre/Raz&oacute;n Social</td>
                  <td width="160" colspan="1" class="cellRight cellTitleProd">NIT/CC Nombre/Raz&oacute;n Social</td>
                  <td width="160" colspan="1" class="cellRight cellTitleProd">&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellLeft" align="center">{$DATOSREMESAS[0].numero_remesa}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].medida|upper}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].peso}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].cantidad}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].naturaleza|upper}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].empaque|upper} - {$DATOSREMESAS[0].descripcion_producto|substr:0:40}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].doc_remitente} - {$DATOSREMESAS[0].remitente}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].doc_destinatario} - {$DATOSREMESAS[0].destinatario}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[0].dueno_poliza}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellLeft" align="center">{$DATOSREMESAS[1].numero_remesa}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].medida}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].peso}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].cantidad}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].naturaleza}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].empaque} - {$DATOSREMESAS[1].descripcion_producto|substr:0:40}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].doc_remitente} - {$DATOSREMESAS[1].remitente}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].doc_destinatario} - {$DATOSREMESAS[1].destinatario}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[1].dueno_poliza}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellLeft" align="center">{$DATOSREMESAS[2].numero_remesa}&nbsp;;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].medida}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].peso}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].cantidad}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].naturaleza}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].empaque} - {$DATOSREMESAS[2].descripcion_producto|substr:0:40}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].doc_remitente} - {$DATOSREMESAS[2].remitente}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].doc_destinatario} - {$DATOSREMESAS[2].destinatario}&nbsp;</td>
                  <td class="cellRight" align="center">{$DATOSREMESAS[2].dueno_poliza}&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr >
                  <td align="center" colspan="14" class="cellRight borderLeft">VALORES Y OBSERVACIONES</td>
                </tr>
                    <tr>
                      <td  align="center" class="cellRight borderLeft">Valor a Pagar </td>
                      <td colspan="2"  align="center" class="cellRight">Valor a Pagar Pactado en Letras : &nbsp;&nbsp; {$SALDOPAGARLETRAS}&nbsp;&nbsp;PESOS M/CTE</td>
                      <td width="289" rowspan="8" align="center" valign="bottom" class="cellRight">Huella</td>
                      <td width="759" align="center" class="cellRight" valign="middle" >Fecha Estimada Entrega</td>
                    </tr>
                    <tr>
                      <td width="231" rowspan="9" align="left" valign="top" class="borderLeft">
        <table width="231" height="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td width="130" class="cellRight borderTop">Valor a Pagar Pactado</td>
                      <td class="cellRight borderTop" align="right">{if $DATOSMANIFIESTO.valor_flete > 0}&nbsp;${$DATOSMANIFIESTO.valor_flete|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
                    </tr>
                    
                    {if count($IMPUESTOS) > 0}&nbsp;			
                      {foreach name=impuestos from=$IMPUESTOS item=i}&nbsp;
                      <tr>
                        <td class="CellRight">{$i.nombre}&nbsp;</td>
                        <td class="cellRight" align="right">{if $i.valor > 0}&nbsp;${$i.valor|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
                      </tr>			
                      {/foreach}&nbsp;
                    
                    {else}&nbsp;
                      <tr>
                        <td class="CellRight">Retencion en la Fuente</td>
                        <td class="cellRight" align="right">0</td>
                      </tr>
                      <tr>
                        <td class="CellRight">Retencion ICA</td>
                        <td class="cellRight" align="right">0</td>
                      </tr>			
                    {/if}&nbsp;	
                    <tr>
                      <td class="CellRight">Valor Neto a Pagar</td>
                      <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_neto_pagar > 0}&nbsp;${$DATOSMANIFIESTO.valor_neto_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="CellRight">Valor Anticipo&nbsp;</td>
                      <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_anticipo > 0}&nbsp;${$DATOSMANIFIESTO.valor_anticipo|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="CellRight">Saldo por Pagar</td>
                      <td class="cellRight" align="right">{if $DATOSMANIFIESTO.saldo_por_pagar > 0}&nbsp;${$DATOSMANIFIESTO.saldo_por_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="CellRight">Fecha Pago de Saldo</td>
                      <td class="cellRight" align="right">{$DATOSMANIFIESTO.fecha_pago_saldo}&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="CellRight" >Lugar Pago del Saldo:&nbsp;</td>
                      <td class="cellRight" >{$DATOSMANIFIESTO.lugar_pago_saldo|substr:0:38}&nbsp; {$DATOSMANIFIESTO.lugar_pago_saldo|substr:38:68}</td>
                    </tr>
                    <tr>
                      <td class="CellRight">Cargue Pagado Por:</td>
                      <td class="cellRight">{$DATOSMANIFIESTO.cargue_pagado_por}&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="CellRight">Descargue Pagado Por:</td>
                      <td class="cellRight">{$DATOSMANIFIESTO.descargue_pagado_por}&nbsp;</td>
                    </tr>           
                  </table>	 </td>
                      <td width="793" rowspan="7" align="center" valign="top" class="cellRight">Firma Autorizada Popr la Empresa<br> <img  width="100%" height="100%" src="{$DATOSMANIFIESTO.firma_desp}"></td>
                      <td width="936" rowspan="7" align="center" class="cellRight" valign="top">Firma y Huella del Conductor</td>
                      <td align="center" class="cellRight" height="8" valign="middle"> {$DATOSMANIFIESTO.fecha_entrega_mcia_mc}&nbsp;&nbsp;{$DATOSMANIFIESTO.hora_entrega}&nbsp; </td>
                    </tr>
                    <tr> <td align="center" class="cellRight" height="8" valign="middle">Precinto</td> </tr>
                    <tr> <td align="center" class="cellRight" height="8" valign="middle">{$DATOSMANIFIESTO.numero_precinto}&nbsp;</td> </tr>
                    <tr> <td width="759" align="center" class="cellRight" height="8" valign="middle">Numero DTA</td> </tr>
                    <tr> <td width="759"  align="center" class="cellRight" valign="middle" >{$DATOSMANIFIESTO.numero_formulario}&nbsp;</td> </tr>
                    <tr> <td width="759" align="center" class="cellRight" valign="top">Observaciones</td> </tr>
                    <tr> <td align="center" class="borderRight" valign="top" height="20">{$DATOSMANIFIESTO.observaciones}<br>{if $DATOSMANIFIESTO.aprobacion_ministerio2 neq '0' && $DATOSMANIFIESTO.aprobacion_ministerio2 neq '' }&nbsp;{else} <span style="font-size:10px;">{$DATOSMANIFIESTO.ultimo_error_reportando_ministario2}</span>{/if}&nbsp;<br>LA EMPRESA, NO AUTORIZA EXCEDER LA CAPACIDAD DEL VEHÍCULO</td> </tr>
                    <tr> 
                      <td align="left" class="cellRight">Nombre : {$DATOSMANIFIESTO.usuario_registra|substr:0:30}&nbsp;</td>
                      <td colspan="2" align="left" class="cellRight">Nombre : {$DATOSMANIFIESTO.nombre|substr:0:30}&nbsp;</td>
                      <td width="759" align="center" class="borderRight  borderBottom  borderTop">Contenedor </td> </tr>
                    <tr>
                      <td align="left"  class="cellRight">Documento de Identificacion: {$DATOSMANIFIESTO.usuario_registra_numero_identificacion}&nbsp;</td>
                      <td colspan="2" align="left"  class="cellRight">Documento de Identificacion: {$DATOSMANIFIESTO.numero_identificacion}&nbsp;</td>
                      <td width="759" align="center" class="borderRight borderBottom"> 
                      {$DATOSMANIFIESTO.numero_contenedor}			  
                        {if strlen(trim($DATOSMANIFIESTO.numero_contenedor)) > 0}
                          {$DATOSMANIFIESTO.numero_contenedor}&nbsp;
                        {else}
                          {$DATOSMANIFIESTO.numero_contenedor_dta}&nbsp;
                        {/if}
                      </td>
                    </tr>
                </table>	  
              </td>
            </tr>
              <tr>
                 <td class="CellRight borderLeft">Documento firmado digitalmente por la empresa: {$DATOSMANIFIESTO.razon_social}&nbsp;</td>              
              </tr>     
          </table>
          
          </div>
          
           <br class="saltopagina" />
           <div style="page-break-before: always">
    <table width="100%" class="cellTotal" cellspacing="0">
		<tr>
			<td>
        <tr>
            <td>
                <table width="100%" cellspacing="0">
                    <tr>
                        <td width="75%" class="borderBottom  fontBig2" colspan="3" align="center"><b>CONTRATO DE
                                VINCULACION TEMPORAL PARA EL SERVICIO DE TRANSPORTE TERRESTRE DE CARGA</b> </td>
                        <td width="25%" class="borderLeft borderBottom" rowspan="2" align="center"><img
                                src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" /></td>
                    </tr>
                    <tr>
                        <td align="center" class="cellRight fontBig"><b>SGCS - PESV</b></td>
                        <td align="center" class="cellRight fontBig"><b>F-OPS-008</b></td>
                        <td align="center" class="borderBottom fontBig"><b>V3 – 15/01/2018</b></td>
                    </tr>
				</table>
			</td>
        </tr>
        <tr>
                <td class="borderBottom fontBig1" align="justify">Entre los suscritos {$DATOSMANIFIESTO.razon_social} identificada con
                    {$DATOSMANIFIESTO.numero_identificacion_empresa} en adelante <b>LA EMPRESA</b> y el señor {$DATOSMANIFIESTO.nombre}
                    identificado con Cedula de Ciudadanía número {$DATOSMANIFIESTO.numero_identificacion_conductor} <b>PLACA DEL
                        VEHÍCULO</b>  {$DATOSMANIFIESTO.placa} <b>PLACA DEL TRÁILER O REMOLQUE </b>{$DATOSMANIFIESTO.placa_remolque}
                    en adelante EL CONTRATISTA se ha celebrado el siguiente contrato. <b>*PRIMERO-OBJETO</b>; El CONTRATISTA se
                    compromete a prestar el servicio de transporte terrestre de carga en la ruta asignada y su vinculación será
                    transitoria desde el momento del cargue de la mercancía hasta su entrega en el destino según los términos, tiempos y
                    condiciones económicas definidas en el manifiesto de carga expedido por LA EMPRESA. <b>*SEGUNDO- ALCANCE</b>: EL
                    CONTRATISTA se compromete a cumplir estrictamente con las políticas, protocolos y buenas prácticas de seguridad vial
                    y la operación en la cadena de suministro definidas en los numerales I), II), III) y IV) del presente contrato.
                    <b>*TERCERO-FORMA DE PAGO</b>; LA EMPRESA se compromete a realizar los pagos acordados en los términos definidos en
                    el manifiesto de carga expedido por LA EMPRESA. <b>*CUARTO-INCUMPLIMIENTO Y SANCIONES</b>: LA EMPRESA podrá exigir
                    al CONTRATISTA el pago de los valores económicos resultantes de Averías y Faltantes a la carga que sean causadas por
                    negligencia o malas prácticas en la prestación del servicio objeto del contrato. <b>*QUINTO-AUTONOMIA TECNICA Y
                        ADMINISTRATIVA</b>: EL CONTRATISTA manifiesta tener autonomía técnica y administrativa para el desarrollo del
                    CONTRATO en la ruta definida por el manifiesto de carga. <b> *SEXTO-DECLARACIONES Y AUTORIZACIONES</b>: EL
                    CONTRATISTA Autoriza a LA EMPRESA de manera expresa, voluntaria y permanente a consultar, solicitar, reportar,
                    divulgar y transmitir a las bases o bancos de datos y centrales de riesgos y demás entidades públicas y privadas con
                    funciones de vigilancia y control cuyo fin sea proveer información referente al comportamiento e historial en los
                    contratos, relaciones comerciales, infracciones de tránsito, accidentes e incidentes de tránsito, así como mis
                    hábitos de entrega, cuidado, prevención y manejo de dineros o bienes en los contratos y el manejo de la información
                    personal necesaria para el estudio, análisis y eventual celebración de contratos con LA EMPRESA o terceros
                    relacionados con el objeto social de LA EMPRESA de acuerdo a lo establecido en su política de tratamiento de datos.
                </td>
        </tr>
        <tr>
            <td align="center" class="borderBottom fontBig2"><b>I. CONDICIONES PARA EL CONDUCTOR CONTRATISTA</b></td>
        </tr>
        <tr>
            <td align="justify" class="borderBottom fontBig1">a)<b>EL CONTRATISTA</b> manifiesta encontrarse en óptimas condiciones
                físicas y mentales para el desarrollo de la RUTA CONTRATADA. En caso de modificación o alteración de su estado de
                salud lo reportara con oportunidad a <b>LA EMPRESA</b><br>
                b) <b>EL CONTRATISTA</b> permite la Toma de Pruebas de Alcoholemia y sustancias psicoactivas cuando <b>LA
                    EMPRESA</b> estime conveniente, como mecanismo de control de la seguridad de las operaciones y la seguridad
                vial.<br>
                c) <b>EL CONTRATISTA</b> realizará a su costo una vez al año la toma de exámenes de control PSICOMETRICOS;
                Audiometría, Visiometria, Examen de coordinación motriz, examen de psicología y los entregara a <b>LA EMPRESA</b>
                cuando sean requeridos.<br>
                d) <b>EL CONTRATISTA</b> portará los pagos vigentes de afiliación al sistema general de salud, riesgos laborales y
                pensiones y los presentará en caso de ser solicitados.
            </td>
        </tr>
        <tr>
            <td align="center" class="borderBottom fontBig2"><b>II. CONDICIONES PARA EL VEHÍCULO O EQUIPO
                    CONTRATISTA</b></td>
        </tr>
        <tr>
                <td align="justify" class="borderBottom fontBig1">a) Garantizar que las condiciones tecnicomecanicas del vehículo son
                    óptimas para desarrollo de la <b>RUTA CONTRATADA</b> Y declara desarrollar un Plan de Mantenimiento como mínimo
                    BIMENSUAL de forma PREVENTIVA y CORRECTIVO de acuerdo a la necesidad en talleres idóneos de acuerdo a las
                    características del vehículo (Ficha técnica del fabricante) y naturaleza de los mantenimientos efectuados y
                    presentara los registros de su ejecución a <b>LA EMPRESA.</b> En caso de ser solicitado en su inspección y
                    auditoria. Así mismo El Contratista se compromete a mantener vigentes los permisos, pólizas de responsabilidad civil
                    extracontractual, SOAT, licencias necesarias para desarrollar la Ruta contratada.<br>b) <b>EL CONTRATISTA</b>
                    Permitirá que funcionarios de <b>LA EMPRESA</b> realicen la inspección PREOPERACIONAL del vehículo y del tráiler con
                    el objetivo de garantizar sus condiciones técnicas y mecánicas que prevengan Accidentes de tránsito y contaminación
                    del despacho con mercancías o cargas de sustancias ilícitas.<br>c) El Contratista <b>NO</b>El Contratista NO debe
                    manipular o alterar el dispositivo GPS del vehículo durante el trayecto contratado.</td>
        </tr>
        <tr>
            <td align="center" class="borderBottom fontBig2"><b>III. CONDICIONES PARA LA RUTA CONTRATADA</b></td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellspacing="0">
                    <tr>
                        <td width="50%" align="justify" class="cellRight fontBig1"> a) Reportarse personalmente en los puestos de control
                            asignados durante la ruta contratada.<br>
                            b) El Contratista se compromete a usar el equipo de comunicación celular UNICAMENTE con dispositivo MANOS LIBRES y
                            contestar las llamadas de monitoreo, Está prohibido TEXTEAR (CHAT, e-mail, otros medios “Redes sociales”) durante la
                            actividad de conducción.<br>
                            c) El Contratista se compromete a Cumplir con las normas y código de tránsito aplicables en la legislación nacional
                            y local (pico y placa, otros) incluido el uso de cinturón de seguridad y los límites de velocidad definidos en la
                            Vía tanto en trayectos urbanos y nacionales, así mismo reportar cualquier infracción de tránsito que le haya sido
                            impuesta en el transcurso de la Ruta contratada.<br>
                        
                            d) Pernoctar y realizar las paradas en los sitios autorizados por Control Tráfico Los sitios de parada y pernoctada
                            deben ser confiables para garantizar la integridad personal, la de la Carga y la del vehículo. <br>
                        
                            e) Realizar por lo menos cada tres (3) horas paradas de descanso que permitan mantener su concentración, estado
                            físico y mental, que garanticen su atención en la vía transitada contribuyendo de esta manera con la prevención de
                            accidentes de tránsito.<br>
                            f) No está permitido lavar el vehículo durante la ruta.<br>
                            g) El Contratista es responsable por verificar que el vehículo sea cargado con el peso máximo permitido por el
                            Ministerio de Transporte, en caso contrario reportar la novedad a LA EMPRESA antes de iniciar la ruta.<br>
                            h) Cumplir con el retorno de la documentación (Remesa, manifiesto, hoja de tiempos, factura cliente, otros) máximo
                            24 horas después del descargue para despachos URBANOS y 48 horas para despachos NACIONALES. Toda novedad, faltante o
                            avería debe ser reportada en los documentos soporte del despacho. </td>
                            <td width="50%" align="justify" class="borderBottom fontBig1">i) NOVEDADES CON ACCIDENTES DE TRANSITO; En caso de
                                presentarse, reportar inmediatamente a la Policía y brindar atención a las víctimas o afectados de la misma,
                                realizar los reportes solicitados y conservar copia de los mismos en caso de ser requeridos por LA EMPRESA.<br>
                            
                                NOVEDADES con la RUTA; en casos de retrasos en la vía (accidentes - cierres de vía, asonada, paros, otros); El
                                cambio de ruta solo se da con autorización de la empresa al igual que:<br>
                                NOVEDADES con el CONDUCTOR Cambio de conductor debido a cambios en su estado de salud que afecten la continuidad del
                                viaje.<br>
                                NOVEDADES con el EQUIPO Cambio debido a Fallas mecánicas, varadas, etc.<br>
                                NOVEDADES con la CARGA, Faltantes, mermas, averías, hurto o saqueo.<br>
                                j) Se compromete a realizar antes, durante y en las zonas de parqueo y paradas, rondas de inspección del vehículo
                                con el fin de garantizar la integridad de la carga, verificando los precintos de seguridad, el estado de la carga,
                                intrusión de materiales o carga no autorizados o ilícitos y revisar que el vehículo no haya sufrido alteraciones
                                mecánicas e informar inmediatamente cualquier irregularidad detectada.<br></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellspacing="0">
                    <tr>
                        <td width="50%" align="center" class="cellRight fontBig2"><b>IV. CONDICIONES DE PRESERVACIÓN DE
                                LA CARGA</b></td>
                        <td rowspan="2" align="center" valign="bottom" class="cellRight"><b>FIRMA EL CONTRATISTA</b>
                        </td>
                        <td rowspan="2" align="center" valign="bottom" class="borderBottom"><b>HUELLA INDICE DERECHO</b>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="justify" class="cellRight fontBig1">a) Presentarse en los sitios de cargue y descargue en la
                            fecha y hora señalada y realizar la salida a ruta según las instrucciones de LA EMPRESA.<br>
                            b) No transportar cargas diferentes a las relacionadas en los documentos soportes entregados por LA EMPRESA y el
                            Generador de carga. Mantener siempre contacto visual con el vehículo y no abandonar la carga.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
        <tr>
            <td align="center" class="fontBig1"> <b>Señor Contratista para contactos comunicarse con:</b> Tráfico y
                Seguridad 321 203 78 67 - 310 873 63 43 – Fijo en Bogotá (1) 413 9567. <b>Calle 19A # 91-05, Bogotá </b>
            </td>
        </tr>

        </td>
        </tr>


    </table>






</div>
           
        
        {if count($DATOSREMESASANEXO) > 3}&nbsp;
        
        
          {assign var="cont"    value="1"}&nbsp;
          {assign var="contTot" value="$TOTALREMESAS"}&nbsp;  
        
          {foreach name=remesas_anexo from=$DATOSREMESASANEXO item=ra}&nbsp;
          
             {if $smarty.foreach.remesas_anexo.iteration > 3}&nbsp;
             
               {if $cont eq 1}&nbsp;
                  <br class="saltopagina" />	
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td colspan="2"><table  border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                            <td width="843" align="left"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;  </td>
                            <td width="1394" align="center"><div>MANIFIESTO DE CARGA</div>
                                <div>{$DATOSMANIFIESTO.oficina}</div>
                              <div>{$DATOSMANIFIESTO.direccion_oficina}</div></td>
                            <td width="64" align="center">&nbsp;</td>
                            <td width="1104" valign="top" align="right"><table cellspacing="0" cellpadding="0" align="right">
                                <tr >
                                  <td rowspan="3" ><img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" />&nbsp;&nbsp;&nbsp;</td>
                                  <td  class="title">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
                                </tr>
                                <tr >
                                  <td class="infogeneral">{$DATOSMANIFIESTO.manifiesto}&nbsp;</td>
                                </tr>
                                <tr >
                                  <td class="borderLeft borderRight">COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td><table cellspacing="0" cellpadding="0" border="0">
                          <tr >
                            <td  colspan="6" class="title">DATOS DE LA EMPRESA</td>
                          </tr>
                          <tr>
                            <td width="60"  class="cellLeft">EMPRESA:</td>
                            <td width="250" class="cellRight">{$DATOSMANIFIESTO.razon_social}&nbsp;</td>
                            <td width="40"  class="cellRight">SIGLA:</td>
                            <td width="150" class="cellRight">{$DATOSMANIFIESTO.sigla}&nbsp;</td>
                            <td width="50" class="cellRight">NIT:</td>
                            <td width="80" class="cellRight">{$DATOSMANIFIESTO.numero_identificacion_empresa}&nbsp;</td>
                          </tr>
                          <tr >
                            <td class="cellLeft">DIRECCI&Oacute;N:</td>
                            <td class="cellRight">{$DATOSMANIFIESTO.direccion}&nbsp;</td>
                            <td class="cellRight">CIUDAD:</td>
                            <td class="cellRight">{$DATOSMANIFIESTO.ciudad}&nbsp;</td>
                            <td class="cellRight">TEL&Eacute;FONO:</td>
                            <td class="cellRight">{$DATOSMANIFIESTO.telefono}&nbsp;</td>
                          </tr>
                        </table></td>
                        <td><table cellspacing="0" cellpadding="0" border="0" >
                          <tr >
                            <td width="269"  align="center"  class="borderLeft cellRight borderTop">TIPO  MANIFIESTO</td>
                            <td width="332"  align="center"  class="cellRight borderTop"><span class="cellRight">N&Uacute;MERO INTERNO  EMPRESA </span></td>
                          </tr>
                          <tr>
                            <td  height="8" align="center" class="borderLeft cellRight">{$DATOSMANIFIESTO.tipo_manifiesto}&nbsp;</td>
                            <td  height="8" align="center" class="cellRight">{$DATOSMANIFIESTO.codigo_empresa}&nbsp;</td>
                          </tr>
                          <tr>
                            <td  height="9" align="center" class="borderLeft cellRight">&nbsp;</td>
                            <td  height="9" align="center" class="cellRight">&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                    <br />
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">		
                <tr >
                  <td  align="center"colspan="14" class="title">INFORMACI&Oacute;N DE LA MERCANC&Iacute;A TRANSPORTADA</td>
                </tr>			
                <tr align="center">
                  <td width="38"  class="cellLeft cellTitleProd">No. DE    REMESA</td>
                  <td width="31" class="cellRight cellTitleProd">UNIDAD DE    MEDIDA</td>
                  <td width="28" class="cellRight cellTitleProd">CANTIDAD</td>
                  <td width="40" class="cellRight cellTitleProd">NATURALEZA</td>
                  <td width="45" class="cellRight cellTitleProd">EMPAQUE</td>
                  <td width="34" class="cellRight cellTitleProd">C&Oacute;DIGO PRODUCTO</td>
                  <td width="89" class="cellRight cellTitleProd">PRODUCTO TRANSPORTADO</td>
                  <td width="160" colspan="2" class="cellRight cellTitleProd">ORIGEN - DESTINO</td>
                  <td width="330" colspan="4" class="cellRight cellTitleProd">NOMBRE</td>
                  <td width="55" class="cellRight cellTitleProd">IDENTIFICACION</td>
                </tr>			
               <tr>
                <td rowspan="4" class="cellLeft" align="center">{$ra.numero_remesa}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.medida}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.cantidad}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.naturaleza}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.empaque}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.producto}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{*{$ra.descripcion_producto}*}sus productos&nbsp;</td>
                  <td class="cellTitleRight">LUGAR DE ORIGEN</td>
                  <td class="cellRight" width="80">{$ra.origen}&nbsp;</td>
                  <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
                  <td colspan="3" class="cellRight">{$ra.propietario_mercancia}&nbsp;</td>
                  <td class="cellRight">{$ra.numero_identificacion_propietario_mercancia}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellTitleRight">DIRECCI&Oacute;N</td>
                  <td class="cellRight">{$ra.direccion_remitente|substr:0:37}&nbsp;</td>
                  <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
                  <td colspan="3" class="cellRight">{$ra.remitente}&nbsp;</td>
                  <td class="cellRight">{$ra.doc_remitente}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellTitleRight">LUGAR DE DESTINO</td>
                  <td class="cellRight">{$ra.destino}&nbsp;</td>
                  <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
                  <td colspan="3" class="cellRight">{$ra.destinatario}&nbsp;</td>
                  <td class="cellRight">{$ra.doc_destinatario}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellTitleRight">DIRECCI&Oacute;N</td>
                  <td class="cellRight">{$ra.direccion_destinatario|substr:0:37}&nbsp;</td>
                  <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
                  <td class="cellRight">{$ra.aseguradora|substr:0:26}&nbsp;</td>
                  <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
                  <td class="cellRight">{$ra.numero_poliza}&nbsp;</td>
                  <td class="cellRight">{$ra.nit_aseguradora}&nbsp;</td>
                </tr>			 
                    
               {else}&nbsp;
               <tr>
                <td rowspan="4" class="cellLeft" align="center">{$ra.numero_remesa}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.medida}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.cantidad}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.naturaleza}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.empaque}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{$ra.producto}&nbsp;</td>
                  <td rowspan="4" class="cellRight" align="center">{*{$ra.descripcion_producto}*}sus productos&nbsp;&nbsp;</td>
                  <td class="cellTitleRight">LUGAR DE ORIGEN</td>
                  <td class="cellRight" width="80">{$ra.origen}&nbsp;</td>
                  <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
                  <td colspan="3" class="cellRight">{$ra.propietario_mercancia}&nbsp;</td>
                  <td class="cellRight">{$ra.numero_identificacion_propietario_mercancia}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellTitleRight">DIRECCI&Oacute;N</td>
                  <td class="cellRight">{$ra.direccion_remitente|substr:0:37}&nbsp;</td>
                  <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
                  <td colspan="3" class="cellRight">{$ra.remitente}&nbsp;</td>
                  <td class="cellRight">{$ra.doc_remitente}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellTitleRight">LUGAR DE DESTINO</td>
                  <td class="cellRight">{$ra.destino}&nbsp;</td>
                  <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
                  <td colspan="3" class="cellRight">{$ra.destinatario}&nbsp;</td>
                  <td class="cellRight">{$ra.doc_destinatario}&nbsp;</td>
                </tr>
                <tr >
                  <td class="cellTitleRight">DIRECCI&Oacute;N</td>
                  <td class="cellRight">{$ra.direccion_destinatario|substr:0:37}&nbsp;</td>
                  <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
                  <td class="cellRight">{$ra.aseguradora|substr:0:26}&nbsp;</td>
                  <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
                  <td class="cellRight">{$ra.numero_poliza}&nbsp;</td>
                  <td class="cellRight">{$ra.nit_aseguradora}&nbsp;</td>
                </tr>	    	   	
               {/if}&nbsp;
                 
               {if $cont eq $contTot or $smarty.foreach.remesas_anexo.iteration eq count($DATOSREMESASANEXO) or $cont eq 7}&nbsp;
                  </table>
                 {assign var="cont" value="1"}&nbsp;
               {else}&nbsp;
                   {assign var="cont" value=$cont+1}&nbsp;
               {/if}&nbsp;	   
                 
             {/if}&nbsp;  
          
          {/foreach}&nbsp;
          
        
        {/if}&nbsp;
        
        
        {if count($TRAFICO) > 0}
        
            <div style="page-break-before:always;width:100%">
            {assign var="si_men" value="0"}
                <table width="100%">
                    <tr>
                        <td width="50%" valign="top">
                            <table cellspacing="0" cellpadding="0"  width="100%">
                                <tr>
                                    <td colspan="5" align="center" style="border-left:1px solid;border-top:1px solid; border-right:1px solid">POLITICA DE SEGURIDAD EN RUTA DE {$DATOSMANIFIESTO.razon_social}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid">ACUERDO DE COMPROMISO PARA CONDUCTORES  <br></td>
                                </tr>
                                <tr><td colspan="5">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="5" align="justify">
                                      <p align="justify"><b>MANIFIESTO DE CARGA N&deg; &nbsp;&nbsp;</b> <u>{$DATOSMANIFIESTO.manifiesto}</u>&nbsp;    <b>ORIGEN: </b>&nbsp;&nbsp;<u>{$DATOSMANIFIESTO.origen}.</u> <b>Destino :</b>&nbsp;&nbsp; <u>{$DATOSMANIFIESTO.destino}</u></p>
                                      <p align="justify">Yo, &nbsp;<u>{$DATOSMANIFIESTO.nombre}</u>&nbsp; &nbsp;Identificado  con c.c N&deg;&nbsp;&nbsp;<u>{$DATOSMANIFIESTO.numero_identificacion_conductor}</u></p><p align="justify">Me comprometo a cumplir con las normas establecidas por la {$DATOSMANIFIESTO.razon_social} relacionadas :</p></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                   <td colspan="5"><strong>&nbsp;COMPROMISOS (Secci&oacute;n 1):</strong></td>
                                </tr>
                                <tr>
                                    <td width="5%" class="celda_bordes">1</td>
                                    <td class="celda_bordes" colspan="4">Cuando sea necesario realizar una parada no programada se debe  garantizar que el sitio ofrezca las condiciones de seguridad para el veh&iacute;culo y la carga.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">2</td>
                                    <td class="celda_bordes" colspan="4">Pernoctar y parquear&nbsp; en lugares indicados por Control Trafico&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">3</td>
                                    <td class="celda_bordes" colspan="4">No lavar el veh&iacute;culo durante la ruta establecida.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">4</td>
                                    <td class="celda_bordes" colspan="4">Seguir los horarios establecidos por la empresa.&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">5</td>
                                    <td class="celda_bordes" colspan="4">No llevar acompa&ntilde;antes ni a los escoltas en la cabina.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">6</td>
                                    <td class="celda_bordes" colspan="4">Comunicar inmediatamente&nbsp; a la oficina que gener&oacute; el despacho&nbsp; cualquier cambio de conductor</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">7</td>
                                    <td class="celda_bordes" colspan="4">Informar a control trafico el inicio, y termino del recorrido, informar si hay novedades durante el recorrido &oacute; entrega de la mercanc&iacute;a.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">8</td>
                                    <td class="celda_bordes" colspan="4">Reportarme personalmente en los puestos de control establecidos en el plan de ruta (ver sanciones).</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">9</td>
                                    <td class="celda_bordes" colspan="4">Portar un celular encendido con minutos disponibles, en caso de cambio de numero actualizarlo.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">10</td>
                                    <td class="celda_bordes" colspan="4">No ingerir bebidas embriagantes ni sustancias alucin&oacute;genas durante la&nbsp; ruta, y en los lugares de pernoctada.&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">11</td>
                                    <td class="celda_bordes" colspan="4" >Entregar los cumplidos m&aacute;ximo 24 horas despacho urbano y 48 horas nacional, despu&eacute;s de la entrega al responsable o enviarlos por correo a las oficinas.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">12</td>
                                    <td class="celda_bordes" colspan="4">Portar documentos de servicio de salud al cual me encuentro afiliado (EPS y ARP).</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">13</td>
                                    <td class="celda_bordes" colspan="4" >Garantizar que las puertas de la cabina permanezcan siempre aseguradas durante todo el recorrido.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">14</td>
                                    <td class="celda_bordes" colspan="4">De presentarse devoluci&oacute;n por averia &oacute; faltante de producto y sea registrado en la remesa o manifiesto, responder&eacute; por los valores econ&oacute;micos declarados en los documentos de la carga.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">15</td>
                                    <td class="celda_bordes" colspan="4">Regresar el material de amarre proporcionado por LP LOGISTICS: lazos,    tablas, estibas, kits.</td>
                                </tr>
            					<tr>
                                    <td class="celda_bordes">16</td>
                                    <td class="celda_bordes" colspan="4">El conductor es responsable de verificar que su veh&iacute;culo sea cargado con el peso maximo permitido por el Ministerio de Transporte.</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">17</td>
                                    <td class="celda_bordes" colspan="4">Al cargar contenedores vac&iacute;os el conductor debe realizar la respectiva inspecci&oacute;n para descartar compartimentos ocultos y el transporte de mercanc&iacute;as il&iacute;citas.</td>
                                </tr>
                                <tr>
                                	<td class="celda_bordes">18</td>
                                	<td class="celda_bordes" colspan="4">Los Parqueaderos Autorizados por la empresa son:<br>1) PARQUEADERO CENTENARIO 1 <br>Diagonal 16 # 90 - 95<br>2) PARQUEADERO CENTENARIO 2 <br>Diagonal 16 # 90 - 89 
                                    </td>
                                </tr>
            
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5" ><p align="justify"><b>Declaro que al veh&iacute;culo se le ha efectuado el mantenimiento tecno-mec&aacute;nico requerido para que permanezca    operando con normalidad durante el trayecto&nbsp;    asignado.&nbsp;</b></p></td>
                                </tr>
                                <tr><td colspan="5">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="5"><p align="justify"><b>Me comprometo a iniciar viaje a las&nbsp;&nbsp; <u>{$DATOSMANIFIESTO.hora_estimada_salida}</u> del d&iacute;a &nbsp;&nbsp;<u>{$DATOSMANIFIESTO.fecha_estimada_salida}</u> y a permanecer con la caravana.</b></p></td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">FIRMA _________________________________    HUELLA INDICE DERECHO______________&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
            
                                <tr>
                                    <td colspan="5">CELULAR_______________________________ CELULAR 2 ______________________________</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" >FAVOR TENER EN CUENTA LAS RECOMENDACIONES DE LA CARTILLA DE INDUCCION A TRANSPORTISTAS</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="celda_bordes" align="center"><strong>TELEFONOS&nbsp; TRAFICO Y SEGURIDAD 3212037867 - 3108736343 - 310 679 16 13 &nbsp;Tels: {$DATOSMANIFIESTO.telefono}-{$DATOSMANIFIESTO.oficina}</strong></td>
                                </tr>
                            </table>
                        </td>
                        <td width="48%" valign="top">
                        <table cellpadding="0" cellspacing="0" style="font-size:9px" width="100%">
                                <tr>
                                     <td colspan="2" >
                                       <table cellpadding="0" cellspacing="0" width="100%" >
                                         <tr>
                                           <td colspan="6" align="center"><strong>{$DATOSMANIFIESTO.razon_social}</strong></td>
                                         </tr>
                                         <tr>
                                           <td class="celda_bordes">Fecha:&nbsp;</td>
                                           <td class="celda_bordes">{$TRAFICO.fecha_inicial_salida}&nbsp;</td>
                                           <td class="celda_bordes">Hora:&nbsp;</td>
                                           <td class="celda_bordes">{$TRAFICO.hora_inicial_salida}&nbsp;</td>
                                           <td class="celda_bordes">{$TRAFICO.tipo_doc}:&nbsp;</td>
                                           <td class="celda_bordes">{$TRAFICO.num_doc}&nbsp;</td>
                                         </tr>
                                         <tr>
                                           <td class="celda_bordes">Placa:&nbsp;</td>
                                           <td class="celda_bordes">{$TRAFICO.placa}&nbsp;</td>
                                           <td class="celda_bordes">Tipo:&nbsp;</td>
                                           <td class="celda_bordes">{$TRAFICO.configuracion}&nbsp;</td>
                                           <td class="celda_bordes">Caracter&iacute;sticas:&nbsp;</td>
                                           <td class="celda_bordes">{$TRAFICO.linea_vehiculo}&nbsp;</td>
                                         </tr>
                                         <tr>
                                           <td class="celda_bordes">Conductor:&nbsp;</td>
                                           <td colspan="5" class="celda_bordes">{$DATOSMANIFIESTO.nombre}&nbsp;</td>
                                         </tr>
                                       </table>                               </td>                    
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_nombre">
                                     {if $DETALLES[0].tipo_punto neq ''}
                                      <b>{$DETALLES[0].tipo_punto|substr:0:30}: </b>{$DETALLES[0].nombre|substr:0:40}<br />
                                      {$DETALLES[0].direccion|substr:0:160}&nbsp;<br> {$DETALLES[0].observacion|substr:0:60}
                                      
                                      {elseif $si_men eq '0' }
                                        <b>
                                        {assign var="si_men" value="1"}                   
                                      {else}
                                        <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                    {/if}                             </td>
                                    <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[1].tipo_punto neq ''}
                                        <b>{$DETALLES[1].tipo_punto|substr:0:30}: </b>{$DETALLES[1].nombre|substr:0:40}<br />
                                        {$DETALLES[1].direccion|substr:0:220}&nbsp;<br> {$DETALLES[1].observacion|substr:0:60}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             
                                    </td>
                                </tr>
                                <tr>
                                  <td class="celda_bordes celda_control">&nbsp;</td>
                                  <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[2].tipo_punto neq ''}
                                            <b>{$DETALLES[2].tipo_punto|substr:0:20}: </b>{$DETALLES[2].nombre|substr:0:40}<br />{$DETALLES[2].direccion|substr:0:220}&nbsp;<br> {$DETALLES[2].observacion|substr:0:60}
                                        {elseif $si_men eq '0' }<br>&nbsp; 
                                            {assign var="si_men" value="2"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             
                                    </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[3].tipo_punto neq ''}
                                            <b>{$DETALLES[3].tipo_punto|substr:0:30}: </b>{$DETALLES[3].nombre|substr:0:30}<br />{$DETALLES[3].direccion|substr:0:220}&nbsp;<br> {$DETALLES[3].observacion|substr:0:60}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                </tr>
                                
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
            
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[4].tipo_punto neq ''}
                                            <b>{$DETALLES[4].tipo_punto|substr:0:40}: </b>{$DETALLES[4].nombre|substr:0:40}<br />{$DETALLES[4].direccion|substr:0:60}&nbsp;<br> {$DETALLES[4].observacion|substr:0:60}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[5].tipo_punto neq ''}
                                            <b>{$DETALLES[5].tipo_punto|substr:0:30}: </b>{$DETALLES[5].nombre|substr:0:50}<br />{$DETALLES[5].direccion|substr:0:50}&nbsp;<br> {$DETALLES[5].observacion|substr:0:50}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                </tr>
                                
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[6].tipo_punto neq ''}
                                            <b>{$DETALLES[6].tipo_punto|substr:0:30}: </b>{$DETALLES[6].nombre|substr:0:40}<br />{$DETALLES[6].direccion|substr:0:60}&nbsp;<br> {$DETALLES[6].observacion|substr:0:60}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[7].tipo_punto neq ''}
                                            <b>{$DETALLES[7].tipo_punto|substr:0:30}: </b>{$DETALLES[7].nombre|substr:0:40}<br />{$DETALLES[7].direccion|substr:0:70}&nbsp;<br> {$DETALLES[7].observacion|substr:0:70}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[8].tipo_punto neq ''}
                                            <b>{$DETALLES[8].tipo_punto|substr:0:30}: </b>{$DETALLES[8].nombre|substr:0:40}<br />{$DETALLES[6].direccion|substr:0:60}&nbsp;<br> {$DETALLES[8].observacion|substr:0:80}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[9].tipo_punto neq ''}
                                            <b>{$DETALLES[9].tipo_punto|substr:0:30}: </b>{$DETALLES[9].nombre|substr:0:40}<br />{$DETALLES[7].direccion|substr:0:70}&nbsp;<br> {$DETALLES[9].observacion|substr:0:90}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[10].tipo_punto neq ''}
                                            <b>{$DETALLES[10].tipo_punto|substr:0:30}: </b>{$DETALLES[10].nombre|substr:0:40}<br />{$DETALLES[6].direccion|substr:0:60}&nbsp;<br> {$DETALLES[10].observacion|substr:0:100}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[11].tipo_punto neq ''}
                                            <b>{$DETALLES[11].tipo_punto|substr:0:30}: </b>{$DETALLES[11].nombre|substr:0:40}<br />{$DETALLES[7].direccion|substr:0:70}&nbsp;<br> {$DETALLES[11].observacion|substr:0:110}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[12].tipo_punto neq ''}
                                            <b>{$DETALLES[12].tipo_punto|substr:0:30}: </b>{$DETALLES[12].nombre|substr:0:40}<br />{$DETALLES[6].direccion|substr:0:60}&nbsp;<br> {$DETALLES[12].observacion|substr:0:120}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[13].tipo_punto neq ''}
                                            <b>{$DETALLES[13].tipo_punto|substr:0:30}: </b>{$DETALLES[13].nombre|substr:0:40}<br />{$DETALLES[7].direccion|substr:0:70}&nbsp;<br> {$DETALLES[13].observacion|substr:0:130}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[12].tipo_punto neq ''}
                                            <b>{$DETALLES[14].tipo_punto|substr:0:30}: </b>{$DETALLES[14].nombre|substr:0:40}<br />{$DETALLES[6].direccion|substr:0:60}&nbsp;<br> {$DETALLES[14].observacion|substr:0:140}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[15].tipo_punto neq ''}
                                            <b>{$DETALLES[15].tipo_punto|substr:0:30}: </b>{$DETALLES[15].nombre|substr:0:40}<br />{$DETALLES[7].direccion|substr:0:70}&nbsp;<br> {$DETALLES[15].observacion|substr:0:150}
                                        {elseif $si_men eq '0' }<br />&nbsp;<br>&nbsp; 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                             </td>
                                </tr>
                                <tr>                            
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                            </table>
                            
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td class="celda_bordes" width="50%">Nombre del Conductor</td>
                                    <td class="celda_bordes" width="50%">Firma</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes" valign="top" height="110"><div>{$DATOSMANIFIESTO.nombre} </div><div>&nbsp;</div></td>
                                    <td class="celda_bordes celda_firmas">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="celda_bordes" align="center">El no reportarse en los puestos de control de la empresa, genera descuento en la planilla de 50.000 pesos, por cada uno.</td>
                                </tr>
                                
                          </table>
                      </td>
                    </tr>
                </table>
            </div>
            
            {if $NUMDETALLES[0].movi gt '6'}
            
            <div style="page-break-before:always;">
                <table width="100%">
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%" >
                                <tr>
                                    <td colspan="6" align="center"><strong>{$DATOSMANIFIESTO.razon_social}</strong></td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">Fecha:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.fecha_inicial_salida}&nbsp;</td>
                                    <td class="celda_bordes">Hora:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.hora_inicial_salida}&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.tipo_doc}:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.num_doc}&nbsp;</td>
                                    
                                </tr>
                                <tr>
                                    <td class="celda_bordes">Placa:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.placa}&nbsp;</td>
                                    <td class="celda_bordes">Tipo:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.configuracion}&nbsp;</td>
                                    <td class="celda_bordes">Caracter&iacute;sticas:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.linea_vehiculo}&nbsp;</td>
                                    
                                </tr>
                                <tr>
                                    <td class="celda_bordes">Conductor:&nbsp;</td>
                                    <td colspan="5" class="celda_bordes">{$DATOSMANIFIESTO.nombre}&nbsp;</td>
                                </tr>
                            </table>   
                                             
                            <table cellpadding="0" cellspacing="0"  style="font-size:9px">
                                <tr>
                                    <td class="celda_bordes celda_nombre">{if $DETALLES[8].tipo_punto neq ''}
                                            <b>{$DETALLES[8].tipo_punto|substr:0:30}: </b>{$DETALLES[8].nombre|substr:0:40}<br />{$DETALLES[8].direccion|substr:0:60}&nbsp;<br> {$DETALLES[8].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[9].tipo_punto neq ''}
                                            <b>{$DETALLES[9].tipo_punto|substr:0:30}: </b>{$DETALLES[9].nombre|substr:0:40}<br />{$DETALLES[9].direccion|substr:0:60}&nbsp;<br> {$DETALLES[9].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[10].tipo_punto neq ''}
                                            <b>{$DETALLES[10].tipo_punto|substr:0:30}: </b>{$DETALLES[10].nombre|substr:0:40}<br />{$DETALLES[10].direccion|substr:0:60}&nbsp;<br> {$DETALLES[10].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[11].tipo_punto neq ''}
                                            <b>{$DETALLES[11].tipo_punto|substr:0:30}: </b>{$DETALLES[11].nombre|substr:0:40}<br />{$DETALLES[11].direccion|substr:0:60}&nbsp;<br> {$DETALLES[11].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[12].tipo_punto neq ''}
                                            <b>{$DETALLES[12].tipo_punto|substr:0:30}: </b>{$DETALLES[12].nombre|substr:0:40}<br />{$DETALLES[12].direccion|substr:0:60}&nbsp;<br> {$DETALLES[12].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[13].tipo_punto neq ''}
                                            <b>{$DETALLES[13].tipo_punto|substr:0:30}: </b>{$DETALLES[13].nombre|substr:0:40}<br />{$DETALLES[13].direccion|substr:0:60}&nbsp;<br> {$DETALLES[13].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[14].tipo_punto neq ''}
                                            <b>{$DETALLES[14].tipo_punto|substr:0:30}: </b>{$DETALLES[14].nombre|substr:0:40}<br />{$DETALLES[14].direccion|substr:0:60}&nbsp;<br> {$DETALLES[14].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[15].tipo_punto neq ''}
                                            <b>{$DETALLES[15].tipo_punto|substr:0:30}: </b>{$DETALLES[15].nombre|substr:0:40}<br />{$DETALLES[15].direccion|substr:0:60}&nbsp;<br> {$DETALLES[15].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                          </table>
                            
                            <table cellpadding="0" cellspacing="0"  width="100%">
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            
                                <tr>
                                    <td class="celda_bordes">Nombre del Conductor</td>
                                    <td class="celda_bordes">Firma</td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes" valign="top"><div>{$DATOSMANIFIESTO.nombre} </div><div>&nbsp;</div></td>                            
                                    <td class="celda_bordes celda_firmas">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="celda_bordes" align="center">El no reportarse en los puestos de control de la empresa, genera descuento en la planilla de 50.000 pesos, por cada uno.</td>
                                </tr>
                                
                            </table>
                      </td>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%" >
                                <tr>
                                    <td colspan="6" align="center"><strong>{$DATOSMANIFIESTO.razon_social}</strong></td>
                                </tr>
                                <tr>
                                    <td class="celda_bordes">Fecha:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.fecha_inicial_salida}&nbsp;</td>
                                    <td class="celda_bordes">Hora:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.hora_inicial_salida}&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.tipo_doc}:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.num_doc}&nbsp;</td>
                                    
                                </tr>
                                <tr>
                                    <td class="celda_bordes">Placa:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.placa}&nbsp;</td>
                                    <td class="celda_bordes">Tipo:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.configuracion}&nbsp;</td>
                                    <td class="celda_bordes">Caracter&iacute;sticas:&nbsp;</td>
                                    <td class="celda_bordes">{$TRAFICO.linea_vehiculo}&nbsp;</td>
                                    
                                </tr>
                                <tr>
                                    <td class="celda_bordes">Conductor:&nbsp;</td>
                                    <td colspan="5" class="celda_bordes">{$DATOSMANIFIESTO.nombre}&nbsp;</td>
                                </tr>
                            </table>   
                                             
                            <table cellpadding="0" cellspacing="0"  style="font-size:9px">
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[16].tipo_punto neq ''}
                                            <b>{$DETALLES[16].tipo_punto|substr:0:30}: </b>{$DETALLES[16].nombre|substr:0:40}<br />{$DETALLES[16].direccion|substr:0:60}&nbsp;<br> {$DETALLES[16].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[17].tipo_punto neq ''}
                                            <b>{$DETALLES[17].tipo_punto|substr:0:30}: </b>{$DETALLES[17].nombre|substr:0:40}<br />{$DETALLES[17].direccion|substr:0:60}&nbsp;<br> {$DETALLES[17].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[18].tipo_punto neq ''}
                                            <b>{$DETALLES[18].tipo_punto|substr:0:30}: </b>{$DETALLES[18].nombre|substr:0:40}<br />{$DETALLES[18].direccion|substr:0:60}&nbsp;<br> {$DETALLES[18].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[19].tipo_punto neq ''}
                                            <b>{$DETALLES[19].tipo_punto|substr:0:30}: </b>{$DETALLES[19].nombre|substr:0:40}<br />{$DETALLES[19].direccion|substr:0:60}&nbsp;<br> {$DETALLES[19].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[20].tipo_punto neq ''}
                                            <b>{$DETALLES[20].tipo_punto|substr:0:30}: </b>{$DETALLES[20].nombre|substr:0:40}<br />{$DETALLES[20].direccion|substr:0:60}&nbsp;<br> {$DETALLES[20].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[21].tipo_punto neq ''}
                                            <b>{$DETALLES[21].tipo_punto|substr:0:30}: </b>{$DETALLES[21].nombre|substr:0:40}<br />{$DETALLES[21].direccion|substr:0:60}&nbsp;<br> {$DETALLES[21].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                                <tr>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[22].tipo_punto neq ''}
                                            <b>{$DETALLES[22].tipo_punto|substr:0:30}: </b>{$DETALLES[22].nombre|substr:0:40}<br />{$DETALLES[22].direccion|substr:0:60}&nbsp;<br> {$DETALLES[22].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                     <td class="celda_bordes celda_nombre">
                                        {if $DETALLES[23].tipo_punto neq ''}
                                            <b>{$DETALLES[23].tipo_punto|substr:0:30}: </b>{$DETALLES[23].nombre|substr:0:40}<br />{$DETALLES[23].direccion|substr:0:60}&nbsp;<br> {$DETALLES[23].observacion|substr:0:60}
                                        {elseif $si_men eq '0' } 
                                            {assign var="si_men" value="1"}                   
                                        {else}
                                            <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                        {/if}                                
                                     </td>
                                </tr>
                                <tr>                            
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                    <td class="celda_bordes celda_control">&nbsp;</td>
                                </tr>
                          </table>
                            
                            <table cellpadding="0" cellspacing="0"  width="100%">
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            
                                <tr>
                                    <td class="celda_bordes">Nombre del Conductor</td>
                                    <td class="celda_bordes">Firma</td>
                                </tr>
                                <tr>
                                                                <td class="celda_bordes" valign="top"><div>{$DATOSMANIFIESTO.nombre} </div><div>&nbsp;</div></td>
                                    <td class="celda_bordes celda_firmas">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="celda_bordes" align="center">El no reportarse en los puestos de control de la empresa, genera descuento en la planilla de 50.000 pesos, por cada uno.</td>
                                </tr>
                                
                            </table>
                      </td>
                    </tr>
              </table>
            </div>
            {/if}
        
        {/if} 
        
        {if count($HOJADETIEMPOS) > 0}&nbsp;
        <br class="saltopagina" />	
        <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1" width="100%">
          <tr>
            <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;</td>
            <td colspan="5" rowspan="3" align="center">HOJA DE TIEMPOS </td>
            <td colspan="3" align="center">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
          </tr>
          <tr>
            <td colspan="3" align="center">{$DATOSMANIFIESTO.manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center">COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
          </tr>    
          <tr>
            <td colspan="8" align="center">DATOS DE LA EMPRESA</td>
            <td>TIPO DE    MANIFIESTO</td>
            <td colspan="2" rowspan="3"><table cellspacing="0" cellpadding="0">
              <tr>
                <td>N&Uacute;MERO INTERNO <br />EMPRESA TRANSPORTE</td>
              </tr>
              <tr>
                <td  height="17" align="center">{$DATOSMANIFIESTO.codigo_empresa}&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>EMPRESA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.razon_social}&nbsp;</td>
            <td>SIGLA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.sigla}&nbsp;</td>
            <td>NIT:</td>
            <td>{$DATOSMANIFIESTO.numero_identificacion_empresa}&nbsp;</td>
            <td rowspan="2" align="center">{$DATOSMANIFIESTO.tipo_manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td>DIRECCI&Oacute;N:</td>
            <td colspan="2">{$DATOSMANIFIESTO.direccion}&nbsp;</td>
            <td>CIUDAD:</td>
            <td colspan="2">{$DATOSMANIFIESTO.ciudad}&nbsp;</td>
            <td>TEL&Eacute;FONO:</td>
            <td>{$DATOSMANIFIESTO.telefono}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="11" align="center">PLAZOS Y TIEMPOS </td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$HOJADETIEMPOS[0].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[0].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[0].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[0].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[0].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[0].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[0].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[0].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$HOJADETIEMPOS[0].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[0].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[0].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[0].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[0].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[0].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$HOJADETIEMPOS[1].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[1].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[1].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[1].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[1].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[1].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[1].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[1].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$HOJADETIEMPOS[1].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[1].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[1].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[1].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[1].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[1].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$HOJADETIEMPOS[2].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[2].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[2].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[2].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[2].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[2].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[2].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[2].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$HOJADETIEMPOS[2].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[2].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[2].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[2].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[2].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[2].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$HOJADETIEMPOS[3].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[3].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[3].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[3].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[3].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[3].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[3].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[3].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$HOJADETIEMPOS[3].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[3].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[3].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$HOJADETIEMPOS[3].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$HOJADETIEMPOS[3].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[3].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="11">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td align="center" width="430" height="30">__________________________________________________________________</td>
                  <td align="center" width="430" height="30">_________________________________________________________</td>
                </tr>
                <tr>
                  <td align="center">FIRMA CONDUCTOR </td>
                  <td align="center">FIRMA EMPRESA </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        {/if}&nbsp;
        
        {if count($HOJADETIEMPOSASANEXO) > 4}&nbsp;
        
        
          {assign var="cont2"    value="1"}&nbsp;
          {assign var="contTot2" value="$TOTALHOJADETIEMPOS"}&nbsp;  
        
          {foreach name=hoja_tiempos_anexo from=$HOJADETIEMPOSASANEXO item=ht}&nbsp;
          
             {if $smarty.foreach.hoja_tiempos_anexo.iteration > 5}&nbsp;
             
               {if $cont2 eq 1}&nbsp;
        <br class="saltopagina" />	
        <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1">
          <tr>
            <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;</td>
            <td colspan="5" rowspan="3" align="center">HOJA DE TIEMPOS </td>
            <td colspan="3" align="center">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
          </tr>
          <tr>
            <td colspan="3" align="center">{$DATOSMANIFIESTO.manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center">COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
          </tr>    
          <tr>
            <td colspan="8" align="center">DATOS DE LA EMPRESA</td>
            <td>TIPO DE    MANIFIESTO</td>
            <td colspan="2" rowspan="3"><table cellspacing="0" cellpadding="0">
              <tr>
                <td>N&Uacute;MERO INTERNO <br />EMPRESA TRANSPORTE</td>
              </tr>
              <tr>
                <td  height="17" align="center">{$DATOSMANIFIESTO.codigo_empresa}&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>EMPRESA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.razon_social}&nbsp;</td>
            <td>SIGLA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.sigla}&nbsp;</td>
            <td>NIT:</td>
            <td>{$DATOSMANIFIESTO.numero_identificacion_empresa}&nbsp;</td>
            <td rowspan="2" align="center">{$DATOSMANIFIESTO.tipo_manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td>DIRECCI&Oacute;N:</td>
            <td colspan="2">{$DATOSMANIFIESTO.direccion}&nbsp;</td>
            <td>CIUDAD:</td>
            <td colspan="2">{$DATOSMANIFIESTO.ciudad}&nbsp;</td>
            <td>TEL&Eacute;FONO:</td>
            <td>{$DATOSMANIFIESTO.telefono}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="11" align="center">PLAZOS Y TIEMPOS </td>
          </tr>
                  {else}&nbsp;	   
                  <tr>
                    <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
                    <td rowspan="4">CARGUE</td>
                    <td rowspan="2">&nbsp;PLAZO
                      HORAS&nbsp; PACTADAS CARGUE<br />
                      (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
                    <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
                    <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
                    <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
                    <td>&nbsp;C.C.:&nbsp;</td>
                  </tr>
                  <tr>
                    <td rowspan="6">{$ht.numero_remesa}&nbsp;</td>
                    <td rowspan="2">{$ht.horas_pactadas_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.fecha_llegada_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_llegada_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.fecha_salida_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_salida_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;{$ht.entrega}&nbsp;</td>
                    <td>&nbsp;C.C.:&nbsp;{$ht.cedula_entrega}&nbsp;</td>
                  </tr>
                  <tr>
                    <td rowspan="4">DESCARGUE</td>
                    <td rowspan="2">&nbsp;PLAZO
                      HORAS&nbsp; PACTADAS DESCARGUE<br />
                      (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
                    <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
                    <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
                    <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
                    <td>&nbsp;C.C.:&nbsp;</td>
                  </tr>
                  <tr>
                    <td rowspan="2">{$ht.horas_pactadas_descargue}&nbsp;</td>
                    <td rowspan="2">&nbsp;{$ht.fecha_llegada_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_llegada_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">&nbsp;{$ht.fecha_salida_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_salida_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
                    <td>&nbsp;C.C.:&nbsp;{$ht.cedula_recibe}&nbsp;</td>
                  </tr>	   
                  {/if}&nbsp;
                 
               {if $cont2 eq $contTot2 or $smarty.foreach.hoja_tiempos_anexo.iteration eq count($HOJADETIEMPOSASANEXO) or $cont2 eq 5}&nbsp;
                      <tr>
                        <td colspan="11">
                          <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td align="center" width="430" height="30">__________________________________________________________________</td>
                              <td align="center" width="430" height="30">_________________________________________________________</td>
                            </tr>
                            <tr>
                              <td align="center">FIRMA CONDUCTOR </td>
                              <td align="center">FIRMA EMPRESA </td>
                            </tr>
                          </table>
                        </td>
                      </tr>	   
                    </table>
                 {assign var="cont2" value="1"}&nbsp;
               {else}&nbsp;
                   {assign var="cont2" value=$cont2+1}&nbsp;
               {/if}&nbsp;	   
                 
             {/if}&nbsp;  
          
          {/foreach}&nbsp;
          
        
        {/if}&nbsp;	   
        {if count($TIEMPOSCARGUE) > 0 and not count($HOJADETIEMPOS) > 0}&nbsp;
        <br class="saltopagina" />	
        <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1" width="100%">
          <tr>
            <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;</td>
            <td colspan="5" rowspan="3" align="center">HOJA DE TIEMPOS </td>
            <td colspan="3" align="center">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
          </tr>
          <tr>
            <td colspan="3" align="center">{$DATOSMANIFIESTO.manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center">COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
          </tr>    
          <tr>
            <td colspan="8" align="center">DATOS DE LA EMPRESA</td>
            <td>TIPO DE    MANIFIESTO</td>
            <td colspan="2" rowspan="3"><table cellspacing="0" cellpadding="0">
              <tr>
                <td>N&Uacute;MERO INTERNO <br />EMPRESA TRANSPORTE</td>
              </tr>
              <tr>
                <td  height="17" align="center">{$DATOSMANIFIESTO.codigo_empresa}&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>EMPRESA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.razon_social}&nbsp;</td>
            <td>SIGLA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.sigla}&nbsp;</td>
            <td>NIT:</td>
            <td>{$DATOSMANIFIESTO.numero_identificacion_empresa}&nbsp;</td>
            <td rowspan="2" align="center">{$DATOSMANIFIESTO.tipo_manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td>DIRECCI&Oacute;N:</td>
            <td colspan="2">{$DATOSMANIFIESTO.direccion}&nbsp;</td>
            <td>CIUDAD:</td>
            <td colspan="2">{$DATOSMANIFIESTO.ciudad}&nbsp;</td>
            <td>TEL&Eacute;FONO:</td>
            <td>{$DATOSMANIFIESTO.telefono}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="11" align="center">PLAZOS Y TIEMPOS </td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$TIEMPOSCARGUE[0].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[0].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[0].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[0].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[0].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[0].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$TIEMPOSCARGUE[0].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[0].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$TIEMPOSCARGUE[0].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[0].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[0].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[0].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[0].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[0].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$TIEMPOSCARGUE[1].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[1].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[1].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[1].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[1].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[1].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$TIEMPOSCARGUE[1].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[1].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$TIEMPOSCARGUE[1].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[1].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[1].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[1].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[1].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[1].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$TIEMPOSCARGUE[2].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[2].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[2].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[2].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[2].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[2].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$TIEMPOSCARGUE[2].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[2].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$TIEMPOSCARGUE[2].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[2].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[2].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[2].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[2].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[2].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
            <td rowspan="4">CARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS CARGUE<br />
              (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="6">{$TIEMPOSCARGUE[3].numero_remesa}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[3].horas_pactadas_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[3].fecha_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[3].hora_llegada_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[3].fecha_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[3].hora_salida_lugar_cargue}&nbsp;</td>
            <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;{$TIEMPOSCARGUE[3].entrega}&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[3].cedula_entrega}&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4">DESCARGUE</td>
            <td rowspan="2">&nbsp;PLAZO
              HORAS&nbsp; PACTADAS DESCARGUE<br />
              (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
            <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
            <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
            <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
            <td>&nbsp;HORA&nbsp;</td>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
            <td>&nbsp;C.C.:&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">{$TIEMPOSCARGUE[3].horas_pactadas_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[3].fecha_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[3].hora_llegada_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;{$TIEMPOSCARGUE[3].fecha_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">{$TIEMPOSCARGUE[3].hora_salida_lugar_descargue}&nbsp;</td>
            <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
            <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
            <td>&nbsp;C.C.:&nbsp;{$TIEMPOSCARGUE[3].cedula_recibe}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="11">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td align="center" width="430" height="60">__________________________________________________________________</td>
                  <td align="center" width="430" height="60"><img  width="50%" height="100%" src="{$DATOSMANIFIESTO.firma_desp}"></td>
                </tr>
                <tr>
                  <td align="center">FIRMA CONDUCTOR </td>
                  <td align="center">FIRMA EMPRESA </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        {/if}&nbsp;
        
        
        {if count($TIEMPOSCARGUEANEXO) > 4 and not count($HOJADETIEMPOS) > 0}&nbsp;
        
        
          {assign var="cont2"    value="1"}&nbsp;
          {assign var="contTot2" value="$TOTALTIEMPOSCARGUE"}&nbsp;  
        
          {foreach name=tiempos_cargue_anexo from=$TIEMPOSCARGUEANEXO item=ht}&nbsp;
          
             {if $smarty.foreach.tiempos_cargue_anexo.iteration > 5}&nbsp;
             
               {if $cont2 eq 1}&nbsp;
        <br class="saltopagina" />	
        <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1">
          <tr>
            <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;</td>
            <td colspan="5" rowspan="3" align="center">HOJA DE TIEMPOS </td>
            <td colspan="3" align="center">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
          </tr>
          <tr>
            <td colspan="3" align="center">{$DATOSMANIFIESTO.manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center">COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
          </tr>    
          <tr>
            <td colspan="8" align="center">DATOS DE LA EMPRESA</td>
            <td>TIPO DE    MANIFIESTO</td>
            <td colspan="2" rowspan="3"><table cellspacing="0" cellpadding="0">
              <tr>
                <td>N&Uacute;MERO INTERNO <br />EMPRESA TRANSPORTE</td>
              </tr>
              <tr>
                <td  height="17" align="center">{$DATOSMANIFIESTO.codigo_empresa}&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>EMPRESA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.razon_social}&nbsp;</td>
            <td>SIGLA:</td>
            <td colspan="2">{$DATOSMANIFIESTO.sigla}&nbsp;</td>
            <td>NIT:</td>
            <td>{$DATOSMANIFIESTO.numero_identificacion_empresa}&nbsp;</td>
            <td rowspan="2" align="center">{$DATOSMANIFIESTO.tipo_manifiesto}&nbsp;</td>
          </tr>
          <tr>
            <td>DIRECCI&Oacute;N:</td>
            <td colspan="2">{$DATOSMANIFIESTO.direccion}&nbsp;</td>
            <td>CIUDAD:</td>
            <td colspan="2">{$DATOSMANIFIESTO.ciudad}&nbsp;</td>
            <td>TEL&Eacute;FONO:</td>
            <td>{$DATOSMANIFIESTO.telefono}&nbsp;</td>
          </tr>
          <tr>
            <td colspan="11" align="center">PLAZOS Y TIEMPOS </td>
          </tr>
                  {else}&nbsp;	   
                  <tr>
                    <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
                    <td rowspan="4">CARGUE</td>
                    <td rowspan="2">&nbsp;PLAZO
                      HORAS&nbsp; PACTADAS CARGUE<br />
                      (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
                    <td colspan="2">&nbsp;LLEGADA    AL LUGAR DE CARGUE&nbsp;</td>
                    <td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
                    <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
                    <td>&nbsp;C.C.:&nbsp;</td>
                  </tr>
                  <tr>
                    <td rowspan="6">{$ht.numero_remesa}&nbsp;</td>
                    <td rowspan="2">{$ht.horas_pactadas_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.fecha_llegada_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_llegada_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.fecha_salida_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_salida_lugar_cargue}&nbsp;</td>
                    <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;{$ht.entrega}&nbsp;</td>
                    <td>&nbsp;C.C.:&nbsp;{$ht.cedula_entrega}&nbsp;</td>
                  </tr>
                  <tr>
                    <td rowspan="4">DESCARGUE</td>
                    <td rowspan="2">&nbsp;PLAZO
                      HORAS&nbsp; PACTADAS DESCARGUE<br />
                      (INCLUYE TIEMPO DE ESPERA&nbsp;</td>
                    <td colspan="2">&nbsp;LLEGADA AL LUGAR DE DESCARGUE&nbsp;</td>
                    <td colspan="2">&nbsp;SALIDA DEL LUGAR DE DESCARGUE&nbsp;</td>
                    <td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td>&nbsp;FECHA&nbsp;    &nbsp;</td>
                    <td>&nbsp;HORA&nbsp;</td>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
                    <td>&nbsp;C.C.:&nbsp;</td>
                  </tr>
                  <tr>
                    <td rowspan="2">{$ht.horas_pactadas_descargue}&nbsp;</td>
                    <td rowspan="2">&nbsp;{$ht.fecha_llegada_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_llegada_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">&nbsp;{$ht.fecha_salida_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">{$ht.hora_salida_lugar_descargue}&nbsp;</td>
                    <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
                    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
                    <td>&nbsp;C.C.:&nbsp;{$ht.cedula_recibe}&nbsp;</td>
                  </tr>	   
                  {/if}&nbsp;
                 
               {if $cont2 eq $contTot2 or $smarty.foreach.tiempos_cargue_anexo.iteration eq count($TIEMPOSCARGUEANEXO) or $cont2 eq 5}&nbsp;
                      <tr>
                        <td colspan="11">
                          <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td align="center" width="430" height="60">__________________________________________________________________</td>
                              <td align="center" width="430" height="60"><img  width="100%" height="100%" src="{$DATOSMANIFIESTO.firma_desp}"></td>
                            </tr>
                            <tr>
                              <td align="center">FIRMA CONDUCTOR </td>
                              <td align="center">FIRMA EMPRESA </td>
                            </tr>
                          </table>
                        </td>
                      </tr>	   
                    </table>
                 {assign var="cont2" value="1"}&nbsp;
               {else}&nbsp;
                   {assign var="cont2" value=$cont2+1}&nbsp;
               {/if}&nbsp;	   
                 
             {/if}&nbsp;  
          
          {/foreach}&nbsp;
          
        
        {/if}&nbsp;
        {else}
    	 <div style="position:relative">
             No se puede generar el formato de Impresi&oacute;n, ya que el manifiesto no posee N&uacute;mero de Aprobaci&oacute;n del Ministerio
             Por las siguientes razones:
             <br><br>
             Error Manifiesto: {$DATOSMANIFIESTO.ultimo_error_reportando_ministario2}
             <br><br>
             {foreach name=remesas_anexo from=$DATOSREMESASANEXO item=ra}&nbsp;
             	{if $ra.aprobacion_ministerio2 eq '0' || $ra.aprobacion_ministerio2 eq ''}
					Error Remesa {$ra.numero_remesa}: {$ra.ultimo_error_reportando_ministario2}<br><br>
				{/if}			 
             {/foreach}
                       
         </div>
    {/if}  

        

</body>
</html>