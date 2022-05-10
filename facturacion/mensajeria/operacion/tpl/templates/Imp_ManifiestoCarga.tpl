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
	height:30px;
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

  <title>Impresion Manifieso de Carga :{$DATOSMANIFIESTO.manifiesto}</title> 
  
  <div style="position:relative">
  {if $DATOSMANIFIESTO.estado eq 'A'}<div style="position:absolute; top:120px; left:92px" class="anulado">MANIFIESTO ANULADO</div>{/if}
	
  <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td colspan="2" align="center">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><table  border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
             <td width="843" align="left">
			     <img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;			  				 
		         <img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" /><br /></td>
              <td width="1394" align="center">
                <div style="font-size:12px;">{$DATOSMANIFIESTO.razon_social}</div>
                <div>NIT: {$DATOSMANIFIESTO.numero_identificacion_empresa}</div>
				<div>&nbsp;</div>
				<div>{$DATOSMANIFIESTO.direccion}</div>		
                <div>TEL: {$DATOSMANIFIESTO.telefono}</div>	
                <div>{$DATOSMANIFIESTO.ciudad}</div>			
			  </td>
              <td width="64" align="center">&nbsp;</td>
              <td width="1104" valign="top" align="right"><table cellspacing="0" cellpadding="0" align="right">
                <tr >
                  <td rowspan="4" ><img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" />&nbsp;&nbsp;&nbsp;</td>
                  <td class="title borderTop">Nro. MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
                </tr>
                <tr >
                  <td class="infogeneral"><font size="1">{$DATOSMANIFIESTO.manifiesto}&nbsp;</font></td>
                </tr>
                <tr >
                  <td class="title">N&Uacute;MERO APROBACI&Oacute;N</td>
                </tr>                
                <tr >
                  <td align="center" class="borderLeft borderRight borderBottom">{$DATOSMANIFIESTO.aprobacion_ministerio}&nbsp;</td>
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
        <tr ></tr>
        <tr >
          <td  align="center" colspan="14" class="cellRight borderLeft">INFORMACI&Oacute;N DE LA MERCANC&Iacute;A TRANSPORTADA</td>
        </tr>
        <tr >
          <td  align="center" colspan="4" class="cellRight borderLeft">Informaci&oacute;n Mercanc&iacute;a</td>
          <td  align="center" colspan="1" class="cellRight1">Informaci&oacute;n Remitente</td>
          <td  align="center" colspan="1" class="cellRight borderLeft">Informaci&oacute;n Destinatario</td>
        </tr>
        <tr align="center">
          <td width="38"  class="cellLeft cellTitleProd">Nro. Guia</td>
          <td width="28" class="cellRight cellTitleProd">Cantidad</td>
          <td width="28" class="cellRight cellTitleProd">Peso (Kg)</td>          
          <td width="89" class="cellRight cellTitleProd">Producto Transportado</td>
          <td width="160" colspan="1" class="cellRight cellTitleProd borderTop">NIT/CC Nombre/Raz&oacute;n Social</td>
          <td width="160" colspan="1" class="cellRight cellTitleProd">NIT/CC Nombre/Raz&oacute;n Social</td>
        </tr>
        <tr >
          <td class="cellLeft1 cellRight borderLeft" align="center">{$DATOSGUIAS[0].numero_guia}&nbsp;</td>
          <td class="cellRight1 borderBottom" align="center">{$DATOSGUIAS[0].cantidad}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom borderRight" align="center">{$DATOSGUIAS[0].peso}&nbsp;</td>
          <td class="cellRight1 borderBottom" align="center">{$DATOSGUIAS[0].referencia_producto|substr:0:40}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom" align="center">{$DATOSGUIAS[0].doc_remitente} - {$DATOSGUIAS[0].remitente}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom borderRight" align="center">{$DATOSGUIAS[0].doc_destinatario} - {$DATOSGUIAS[0].destinatario}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellLeft1 cellRight borderLeft" align="center">{$DATOSGUIAS[1].numero_guia}&nbsp;</td>
          <td class="cellRight1 borderBottom" align="center">{$DATOSGUIAS[1].cantidad}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom borderRight" align="center">{$DATOSGUIAS[1].peso}&nbsp;</td>
          <td class="cellRight1 borderBottom" align="center">{$DATOSGUIAS[1].referencia_producto|substr:0:40}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom" align="center">{$DATOSGUIAS[1].doc_remitente} - {$DATOSGUIAS[1].remitente}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom borderRight" align="center">{$DATOSGUIAS[1].doc_destinatario} - {$DATOSGUIAS[1].destinatario}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellLeft1 cellRight borderLeft borderBottom" align="center">{$DATOSGUIAS[2].numero_guia}&nbsp;</td>
          <td class="cellRight1 borderBottom" align="center">{$DATOSGUIAS[2].cantidad}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom borderRight" align="center">{$DATOSGUIAS[2].peso}&nbsp;</td>
          <td class="cellRight1 borderBottom" align="center">{$DATOSGUIAS[2].referencia_producto|substr:0:40}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom" align="center">{$DATOSGUIAS[2].doc_remitente} - {$DATOSGUIAS[2].remitente}&nbsp;</td>
          <td class="cellRight1 borderLeft borderBottom borderRight" align="center">{$DATOSGUIAS[2].doc_destinatario} - {$DATOSGUIAS[2].destinatario}&nbsp;</td>
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
<table width="386" height="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td width="96" class="cellRight borderTop">Valor a Pagar Pactado</td>
              <td width="290" align="right" class="cellRight borderTop">{if $DATOSMANIFIESTO.valor_flete > 0}&nbsp;${$DATOSMANIFIESTO.valor_flete|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
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
              <td class="cellRight" >{$DATOSMANIFIESTO.lugar_pago_saldo|substr:0:38}&nbsp; $DATOSMANIFIESTO.lugar_pago_saldo|substr:38:68}</td>
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
              <td width="793" rowspan="7" align="center" valign="top" class="cellRight">Firma Autorizada Popr la Empresa</td>
              <td width="936" rowspan="7" align="center" class="cellRight" valign="top">Firma y Huella del Conductor</td>
              <td align="center" class="cellRight" height="8" valign="middle"> {$DATOSMANIFIESTO.fecha_entrega_mcia_mc}&nbsp;&nbsp;{$DATOSMANIFIESTO.hora_entrega}&nbsp; </td>
            </tr>
            <tr> <td align="center" class="cellRight" height="8" valign="middle">Precinto</td> </tr>
            <tr> <td align="center" class="cellRight" height="8" valign="middle">{$DATOSMANIFIESTO.numero_precinto}&nbsp;</td> </tr>
            <tr> <td width="759" align="center" class="cellRight" height="8" valign="middle">Numero DTA</td> </tr>
            <tr> <td width="759"  align="center" class="cellRight" valign="middle" >{$DATOSMANIFIESTO.numero_formulario}&nbsp;</td> </tr>
            <tr> <td width="759" align="center" class="cellRight" valign="top">Observaciones</td> </tr>
            <tr> <td align="center" class="borderRight" valign="top" height="20">{$DATOSMANIFIESTO.observaciones}<br>ID MOBILE : {$DATOSMANIFIESTO.id_mobile}&nbsp;</td> </tr>
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

{if count($DATOSGUIASANEXO) > 3}&nbsp;

  {assign var="cont"    value="1"}&nbsp;
  {assign var="contTot" value="$TOTALGUIAS"}&nbsp;  

  {foreach name=guias_anexo from=$DATOSGUIASANEXO item=ra}&nbsp;
  
     {if $smarty.foreach.guias_anexo.iteration > 3}&nbsp;
	 
	   {if $cont eq 1}&nbsp;
<br class="saltopagina" />	
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td colspan="2"><table  border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="843" align="left"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp; <img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" /> </td>
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
          <td width="38"  class="cellLeft cellTitleProd">No. DE GUIA</td>
          <td width="28" class="cellRight cellTitleProd">CANTIDAD</td>
          <td width="89" class="cellRight cellTitleProd">PRODUCTO TRANSPORTADO</td>
          <td width="160" colspan="2" class="cellRight cellTitleProd">ORIGEN - DESTINO</td>
          <td width="330" colspan="4" class="cellRight cellTitleProd">NOMBRE</td>
          <td width="55" class="cellRight cellTitleProd">IDENTIFICACION</td>
        </tr>			
	   <tr>
        <td rowspan="4" class="cellLeft" align="center">{$ra.numero_guia}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.cantidad}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.referencia_producto}&nbsp;</td>
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
        <td rowspan="4" class="cellLeft" align="center">{$ra.numero_guia}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.cantidad}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.descripcion_producto}&nbsp;</td>
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
	 	 
   	   {if $cont eq $contTot or $smarty.foreach.guias_anexo.iteration eq count($DATOSGUIASANEXO) or $cont eq 7}&nbsp;
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
                <td  valign="top">
                    <table cellspacing="0" cellpadding="0"  width="100%">
                        <tr>
                            <td colspan="5" align="center" style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid">ACUERDO DE COMPROMISO PARA CONDUCTORES  <br></td>
                        </tr>
						<tr><td colspan="5">&nbsp;</td></tr>
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
                            <td class="celda_bordes" colspan="4">Informar a control trafico el inicio, y termino del recorrido, informar si hay novedades durante el recorrido &oacute; entrega de la mercanc&iacute;a.</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">4</td>
                            <td class="celda_bordes" colspan="4">No ingerir bebidas embriagantes ni sustancias alucin&oacute;genas durante la&nbsp; ruta, y en los lugares de pernoctada.&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">5</td>
                            <td class="celda_bordes" colspan="4" >Entregar los cumplidos m&aacute;ximo 24 horas despacho urbano y 48 horas nacional, despu&eacute;s de la entrega al responsable en chiquinquira o a enviarlos por correo a las oficinas de chiquinquira.</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">6</td>
                            <td class="celda_bordes" colspan="4">Portar documentos de servicio de salud al cual me encuentro afiliado (EPS y ARP).</td>
                        </tr>
    
                        <tr>
                            <td colspan="5"><p align="justify"><b>Doy f&eacute; que estos compromisos se encuentran claros, de faltar a alguno los anteriores puntos autorizo a aplicar una multa por un valor de $ 50.000 Mcte por las siguientes infracciones (Secci&oacute;n 2):</b></p></td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">1</td>
                            <td class="celda_bordes" colspan="4">No radicar documentos cumplidos. (Una multa por cada documento no radicado)</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">2</td>
                            <td class="celda_bordes" colspan="4">No garantizar la comunicaci&oacute;n durante el recorrido. </td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">3</td>
                            <td class="celda_bordes" colspan="4">Todas las conductas que atenten a la seguridad de la carga, el veh&iacute;culo y la integridad del transportador.&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">4</td>
                            <td class="celda_bordes" colspan="4">No Diligenciar la Hoja de tiempos que hace parte del manifiesto de carga.&nbsp;</td>
                        </tr>
    
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5" ><p align="justify"><b>Declaro que al veh&iacute;culo se le ha efectuado el mantenimiento tecno-mec&aacute;nico requerido para que permanezca    operando con normalidad durante el trayecto&nbsp;    asignado.&nbsp;</b></p></td>
                        </tr>
						<tr><td colspan="5">&nbsp;</td></tr>
    
                  </table>
                    <br />
                  <table cellspacing="0" cellpadding="0" border="1" width="99%">
                      <col width="31">
                      <col width="25">
                      <col width="32">
                      <col width="170">
                      <col width="89">
                      <col width="80" span="2">
                      <col width="76">
                      <col width="78">
                      <col width="69">
                      <col width="80" span="4">
                      <tr>
                        <td width="31"></td>
                        <td width="25"></td>
                        <td width="32"></td>
                        <td width="170"></td>
                        <td width="89"></td>
                        <td width="80"></td>
                        <td width="80"></td>
                        <td width="76"></td>
                        <td width="78" align="left" valign="top"><table cellpadding="0" cellspacing="0">
                          <tr>
                              <td width="78"></td>
                          </tr>
                        </table></td>
                        <td width="69"></td>
                        <td width="80"></td>
                        <td width="80"></td>
                        <td width="80"></td>
                        <td width="80"></td>
                      </tr>
                      <tr>
                        <td colspan="4" width="258">Inicio</td>
                        <td colspan="2" width="169">Ruta</td>
                        <td width="80">No.</td>
                        <td colspan="2" width="154" style="background:#CCC;">FR-OPE-012 REV 1-12-JUN-2012</td>
                        <td colspan="2">Guia Nro.</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3" width="88">&nbsp;Fecha</td>
                        <td width="170">&nbsp;Placa</td>
                        <td width="89">&nbsp;Origen</td>
                        <td colspan="2" width="160">&nbsp;Destino</td>
                        <td colspan="2">&nbsp;Producto</td>
                        <td colspan="3">&nbsp;Cliente</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>D</td>
                        <td>M</td>
                        <td>A</td>
                        <td rowspan="2" width="170">&nbsp;{$DATOSMANIFIESTO.placa}&nbsp;</td>
                        <td rowspan="2">&nbsp;{$DATOSMANIFIESTO.origen}&nbsp;</td>
                        <td colspan="2" rowspan="2">&nbsp;{$DATOSMANIFIESTO.destino}&nbsp;</td>
                        <td colspan="2" rowspan="2">&nbsp;</td>
                        <td colspan="3" rowspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td width="170"> Fechas de Inspeccion </td>
                        <td colspan="2">D_____M_____A______    </td>
                        <td colspan="2">D_____M_____A______    </td>
                        <td colspan="2">D_____M_____A______    </td>
                        <td colspan="2">D_____M_____A______    </td>
                        <td colspan="2">D_____M_____A______    </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td width="170"> Hora de Inspeccion </td>
                        <td colspan="2">______ AM____PM____</td>
                        <td colspan="2">______ AM____PM____</td>
                        <td colspan="2">______ AM____PM____</td>
                        <td colspan="2">______ AM____PM____</td>
                        <td colspan="2">______ AM____PM____</td>
                      </tr>
                      <tr>
                        <td colspan="3" width="88">Mercancias Recibidas</td>
                        <td width="170">Inspeccion</td>
                        <td colspan="2">Inicio Ruta</td>
                        <td colspan="2" width="156">Muelle o Sitio de Cargue</td>
                        <td colspan="2" width="147">Paradas Extras</td>
                        <td colspan="2">Pernoctada</td>
                        <td colspan="2">Fin de Ruta</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td width="170">Cabezote</td>
                        <td>Normal</td>
                        <td>Anormal</td>
                        <td>Normal</td>
                        <td>Anormal</td>
                        <td>Normal</td>
                        <td>Anormal</td>
                        <td>Normal</td>
                        <td>Anormal</td>
                        <td>Normal</td>
                        <td>Anormal</td>
                      </tr>
                      <tr>
                        <td colspan="3">Contenedor</td>
                        <td width="170">Parachoques,Neumaticos y llantas</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>20</td>
                        <td></td>
                        <td>40</td>
                        <td width="170">Puertas,compartimientos de herramientas</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">Bultos</td>
                        <td>&nbsp;</td>
                        <td width="170">caja de baterias</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">Bolsones</td>
                        <td>&nbsp;</td>
                        <td width="170">Respiraderos</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">Paquetes</td>
                        <td>&nbsp;</td>
                        <td width="170">Tanques de combustibles</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">Grannel</td>
                        <td>&nbsp;</td>
                        <td width="170">Compartimientos del interior de la cabina, litera</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">Otros</td>
                        <td>&nbsp;</td>
                        <td width="170">Seccion de pasajeros y techo</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">Inspecciones</td>
                        <td width="170">Remolques</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>N</td>
                        <td>A</td>
                        <td width="170">quinta rueda -  compartimiento natural / placa del patin</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>N</td>
                        <td>A</td>
                        <td width="170">Exterior - frente y costados</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>N</td>
                        <td>A</td>
                        <td width="170">Posterior - Parachoques/puertas</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>N</td>
                        <td>A</td>
                        <td>Pared delantera</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>N</td>
                        <td>A</td>
                        <td>Lado izquierdo</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>N</td>
                        <td>A</td>
                        <td>Lado  derecho</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>N</td>
                        <td>A</td>
                        <td>Piso</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>N</td>
                        <td>A</td>
                        <td>techo interior/esterior</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td width="69">&nbsp;</td>
                        <td width="80">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td width="80">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>9</td>
                        <td>N</td>
                        <td>A</td>
                        <td>puertas interiores, exteriores</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>10</td>
                        <td>N</td>
                        <td>A</td>
                        <td>Exterior / seccion inferior</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">Observaciones:</td>
                        <td colspan="11">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="14">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="14" align="center">Tiempos de Cargue</td>                        
                      </tr> 
                      <tr>
                        <td colspan="3"align="center">Fecha Llegada</td>                        
						<td align="center">&nbsp;</td>                        
						<td align="center">Hora Llegada</td>                        
						<td align="center">&nbsp;</td>  
                        <td align="center">Fecha Entrada</td>                        
						<td align="center">&nbsp;</td>                        
						<td align="center">Hora Entrada</td>                        
						<td align="center">&nbsp;</td>
                        <td align="center">Fecha Salida</td>                        
						<td align="center">&nbsp;</td>                        
						<td align="center">Hora Salida</td>                        
						<td align="center">&nbsp;</td>                                                                                              
                      </tr> 
                      <tr>
                        <td colspan="14">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="14" align="center">Tiempos de Descargue</td>                        
                      </tr> 
                      <tr>
                        <td colspan="3"align="center">Fecha Llegada</td>                        
						<td align="center">&nbsp;</td>                        
						<td align="center">Hora Llegada</td>                        
						<td align="center">&nbsp;</td>  
                        <td align="center">Fecha Entrada</td>                        
						<td align="center"></td>                        
						<td align="center">Hora Entrada</td>                        
						<td align="center">&nbsp;</td>
                        <td align="center">Fecha Salida</td>                        
						<td align="center">&nbsp;</td>                        
						<td align="center">Hora Salida</td>                        
						<td align="center">&nbsp;</td>                                                                                              
                      </tr>                                                                  
                      <tr>
                        <td colspan="4" width="258" height="50px">Nombre y Firma Conductor.</td>
                        <td colspan="10">&nbsp;</td>
                      </tr>
                </table>
                </td>
            </tr>
        </table>
    </div>
{/if} 

{if count($HOJADETIEMPOS) > 0}&nbsp;
<br class="saltopagina" />	
<table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1" width="100%">
  <tr>
    <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;<img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" /></td>
    <td colspan="5" rowspan="3" align="center">HOJA DE TIEMPOS </td>
    <td colspan="3" align="center">Nro. MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
  </tr>
  <tr>
    <td colspan="3" align="center">{$DATOSMANIFIESTO.manifiesto}&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
  </tr>    
  <tr>
    <td colspan="8" align="center">DATOS DE LA EMPRESA</td>
    <td>Tipo de Manifiesto</td>
    <td colspan="2" rowspan="3"><table cellspacing="0" cellpadding="0">
      <tr>
        <td>Numero Aprobacion</td>
      </tr>
      <tr>
        <td  height="17" align="center">{$DATOSMANIFIESTO.codigo_empresa}&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>EMPRESA:</td>
    <td colspan="2">{$DATOSMANIFIESTO.razon_social}&nbsp;</td>
    <td>Sigla:</td>
    <td colspan="2">{$DATOSMANIFIESTO.sigla}&nbsp;</td>
    <td>NIT:</td>
    <td>{$DATOSMANIFIESTO.numero_identificacion_empresa}&nbsp;</td>
    <td rowspan="2" align="center">{$DATOSMANIFIESTO.tipo_manifiesto}&nbsp;</td>
  </tr>
  <tr>
    <td>Direcci&oacute;n:</td>
    <td colspan="2">{$DATOSMANIFIESTO.direccion}&nbsp;</td>
    <td>Ciudad:</td>
    <td colspan="2">{$DATOSMANIFIESTO.ciudad}&nbsp;</td>
    <td>Tel&eacute;fono:</td>
    <td>{$DATOSMANIFIESTO.telefono}&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" align="center">PLAZOS Y TIEMPOS </td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;Nro. Guia&nbsp;</td>
    <td rowspan="4">Cargue</td>
    <td rowspan="2">&nbsp;Plazo<br />
Horas&nbsp; Pactadas Cargue<br />
(Incluye Tiempo de Espera)&nbsp;</td>
    <td colspan="2">&nbsp;&nbsp;Llegada al Lugar de Cargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Cargue&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha&nbsp;&nbsp;&nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;&nbsp;Fecha&nbsp;&nbsp;</td>
    <td>Hora&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[0].numero_guia}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].horas_pactadas_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].fecha_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].fecha_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">Quien Entrega&nbsp;</td>
    <td colspan="3" height="15">&nbsp;&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;&nbsp;{$HOJADETIEMPOS[0].entrega}&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[0].cedula_entrega}&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="4">Descargue</td>
    <td rowspan="2">&nbsp;Plaxo<br />
Horas&nbsp; Pactadas Descargue<br />
      (Incluye Tiempo de Espera)&nbsp;</td>
    <td colspan="2">Llegada al Lugar de Descargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Descargue&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha&nbsp;&nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;Fecha&nbsp;&nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td colspan="2">&nbsp;Nombre:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[0].horas_pactadas_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[0].fecha_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[0].fecha_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;Quien Recibe&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;recibe</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[0].cedula_recibe}&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;Nro. Guia&nbsp;</td>
    <td rowspan="4">Cargue</td>
    <td rowspan="2">&nbsp;Plazo<br />
      Horas&nbsp; Pactadas Cargue<br />
    (Incluye Tiempo de Espera)&nbsp;</td>
    <td colspan="2">&nbsp;Llegada al Lugar de Cargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Cargue&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha&nbsp;&nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;Fecha&nbsp;&nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td colspan="2">&nbsp;Nombre:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[1].numero_Guia}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].horas_pactadas_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].fecha_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].fecha_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">Quien Entrega&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;{$HOJADETIEMPOS[1].entrega}&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[1].cedula_entrega}&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="4">Descargue</td>
    <td rowspan="2">&nbsp;Plaxo<br />
      Horas&nbsp; Pactadas Descargue<br />
    (Incluye Tiempo de Espera)&nbsp;</td>
    <td colspan="2">&nbsp;Llegada al Lugar de Descargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Descargue&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha&nbsp;&nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;Fecha&nbsp;&nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td colspan="2">&nbsp;Nombre:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[1].horas_pactadas_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[1].fecha_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[1].fecha_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;Quien Recibe&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;recibe</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[1].cedula_recibe}&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;Nro. Guia&nbsp;</td>
    <td rowspan="4">Cargue</td>
    <td rowspan="2">&nbsp;Plazo<br />
      Horas&nbsp; Pactadas Cargue<br />
      (Lugar de Descargue)&nbsp;</td>
    <td colspan="2">&nbsp;Llegada al Lugar de Cargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Cargue&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha&nbsp;    &nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;Fecha&nbsp;    &nbsp;</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td colspan="2">&nbsp;Nombre:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[2].numero_guia}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].horas_pactadas_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].fecha_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].fecha_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">Quien Entrega&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;{$HOJADETIEMPOS[2].entrega}&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[2].cedula_entrega}&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="4">Descargue</td>
    <td rowspan="2">&nbsp;Plazo<br />
      Horas&nbsp; Pactadas Descatgue<br />
      (Incluye Tiempo de Espera)&nbsp;</td>
    <td colspan="2">Llegada al Lugar de Descargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Descargue&nbsp;&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;&nbsp;Fecha</td>
    <td>Hora&nbsp;</td>
    <td colspan="2">&nbsp;Nombre:&nbsp;&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[2].horas_pactadas_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[2].fecha_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[2].fecha_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">Quien Recibe&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;recibe</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[2].cedula_recibe}&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;No. Guia&nbsp;</td>
    <td rowspan="4">Cargue</td>
    <td rowspan="2">&nbsp;Plazo<br />
Horas&nbsp; Pactadas Cargue<br />
      (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
    <td colspan="2">&nbsp;Llegada al Lugar de Cargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Cargue&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;&nbsp;Fecha&nbsp;</td>
    <td>Hora&nbsp;</td>
    <td colspan="2">&nbsp;Nombre:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[3].numero_guia}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].horas_pactadas_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].fecha_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_llegada_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].fecha_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_salida_lugar_cargue}&nbsp;</td>
    <td rowspan="2">Quien Entrega&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;&nbsp;{$HOJADETIEMPOS[3].entrega}&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[3].cedula_entrega}&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="4">Descargue</td>
    <td rowspan="2">&nbsp;Plazo<br />
Horas&nbsp; Pactadas Descatgue<br />
(Incluye Tiempo de Espera)&nbsp;</td>
    <td colspan="2">&nbsp;Llegada al Lugar de Descargue&nbsp;</td>
    <td colspan="2">&nbsp;Salida del Lugar de Descargue&nbsp;</td>
    <td rowspan="2">&nbsp;Conductor&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;Fecha</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td>&nbsp;Fecha</td>
    <td>&nbsp;Hora&nbsp;</td>
    <td colspan="2">&nbsp;Nombre:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[3].horas_pactadas_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[3].fecha_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_llegada_lugar_descargue}&nbsp;</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[3].fecha_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_salida_lugar_descargue}&nbsp;</td>
    <td rowspan="2">Quien Recibe&nbsp;&nbsp;</td>
    <td colspan="3" height="15">&nbsp;Firma:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Nombre:&nbsp;&nbsp;recibe</td>
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
	      <td align="center">Firma Conductor</td>
	      <td align="center">Firma Empresa</td>
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
    <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="160" height="42" />&nbsp;<img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" /></td>
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
			<td rowspan="2">&nbsp;No. GUIA&nbsp;</td>
			<td rowspan="4">CARGUE</td>
			<td rowspan="2">&nbsp;PLAZO<br />
			  HORAS&nbsp; PACTADAS CARGUE<br />
			  (INCLUYE TIEMPO DE ESPERA)&nbsp;</td>
			<td colspan="2">&nbsp;LLEGADA  AL LUGAR DE CARGUE&nbsp;</td>
			<td colspan="2">&nbsp;SALIDA DEL LUGAR DE CARGUE&nbsp;</td>
			<td rowspan="2">&nbsp;CONDUCTOR&nbsp;</td>
			<td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;FECHA&nbsp; &nbsp;</td>
			<td>&nbsp;HORA&nbsp;</td>
			<td>&nbsp;FECHA&nbsp; &nbsp;</td>
			<td>&nbsp;HORA&nbsp;</td>
			<td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
			<td>&nbsp;C.C.:&nbsp;</td>
		  </tr>
		  <tr>
			<td rowspan="6">{$ht.numero_guia}&nbsp;</td>
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
			<td rowspan="2">&nbsp;PLAZO<br />
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
			<td rowspan="2">&nbsp;QUIEN RECIBE&nbsp;</td>
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

</body>
</html>