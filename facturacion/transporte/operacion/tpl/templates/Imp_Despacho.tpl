<html>
 <head>
{literal}&nbsp;
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
	
  	
</style>

{/literal}
</head>
<body onLoad="javascript:window.print()" style="margin:0px 0px 0px 0px">
	
  <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td colspan="2" align="center">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><table  border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
             <td width="843" align="left">
			    <img src="{$DATOSMANIFIESTO.logo}" width="190" height="40" />&nbsp;		  				 
		         			   </td>
              <td width="1394" align="center">
			    <div>DESPACHO URBANO</div>
				<div>{$DATOSMANIFIESTO.oficina}</div>
				<div>{$DATOSMANIFIESTO.direccion_oficina}</div>
                <div>ID Mobile: {$DATOSMANIFIESTO.id_mobile}</div>
			  </td>
              <td width="64" align="center">&nbsp;</td>
              <td width="1104" valign="top" align="right"><table cellspacing="0" cellpadding="0" align="right">
                <tr >
                  <td rowspan="2" ><img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" />&nbsp;&nbsp;&nbsp;</td>
                  <td  class="title">N&Uacute;MERO PLANILLA URBANO </td>
                </tr>
                <tr >
                  <td class="infogeneral">{$DATOSMANIFIESTO.despacho}&nbsp;</td>
                </tr>
                
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>
<table  border="0" width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="bottom"><table cellspacing="0" cellpadding="0" border="0" width="100%">
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
	</tr>
</table>		  </td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td colspan="2">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
        <tr >
          <td colspan="4"  class="cellLeft" align="center">INFORMACI&Oacute;N DEL MANIFIESTO DE CARGA</td>
        </tr>
        <tr align="center" >
          <td  width="155"  class="cellLeft" >FECHA DE EXPEDICI&Oacute;N    </td>
          <td  width="300" class="cellRight">ORIGEN DEL VIAJE</td>
          <td  width="310" class="cellRight">DESTINO DEL VIAJE</td>
        </tr>
        <tr >
          <td  width="155" class="cellLeft" align="center" >{$DATOSMANIFIESTO.fecha_du}&nbsp;</td>
          <td  width="300" class="cellRight" align="center">{$DATOSMANIFIESTO.origen}&nbsp;</td>
          <td  width="310" class="cellRight" align="center">{$DATOSMANIFIESTO.destino}&nbsp;</td>
        </tr>
      </table>	  
	  <table cellspacing="0" cellpadding="0" width="100%" border="0" >
  <tr >
    <td colspan="9"   class="cellLeft" align="center">INFORMACION DEL VEH&Iacute;CULO</td>
  </tr>
  <tr align="center" >
    <td width="80" class="cellLeft">PLACA</td>
    <td width="160" class="cellRight">MARCA</td>
    <td width="80" class="cellRight">CONFIGURACI&Oacute;N</td>
    <td width="100"  class="cellRight">PLACA REMOLQUE</td>
    <td width="50"  class="cellRight">PESO  VAC&Iacute;O</td>
    <td width="50"  rowspan="2" class="cellRight" align="center">SOAT</td>
    <td width="187"  class="cellRight">COMPA&Ntilde;&Iacute;A DE SEGUROS SOAT</td>
    <td width="120"  class="cellRight">VENCIMIENTO</td>
    <td width="110"  class="cellRight"> POLIZA</td>
  </tr>
  <tr >
    <td class="cellLeft" align="center" >{$DATOSMANIFIESTO.placa}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.marca}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.configuracion}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.placa_remolque}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.peso_vacio}&nbsp;</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.nombre_aseguradora}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.vencimiento_soat}&nbsp;</td>
    <td   class="cellRight" align="center">{$DATOSMANIFIESTO.numero_soat}&nbsp;</td>
  </tr>
  </table>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" >
  <tr align="center" >
    <td width="250"   class="cellLeft">PROPIETARIO&nbsp; DEL VEH&Iacute;CULO</td>
    <td width="150"  class="cellRight">DOCUMENTO DE IDENTIFICACI&Oacute;N    </td>
    <td width="256"  class="cellRight">DIRECCI&Oacute;N DEL PROPIETARIO</td>
    <td  width="150" class="cellRight">TEL&Eacute;FONO DEL PROPIETARIO</td>
    <td  width="150" class="cellRight">CIUDAD Y DEPARTAMENTO</td>
  </tr>
  <tr >
    <td  class="cellLeft" >{$DATOSMANIFIESTO.propietario}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_propietario}&nbsp;</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.direccion_propietario|substr:0:65}&nbsp;</td>
    <td class="cellRight">{$DATOSMANIFIESTO.telefono_propietario}&nbsp;</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.ciudad_propietario}&nbsp;</td>
  </tr>
  <tr >
    <td   class="cellLeft">POSEEDOR O TENEDOR    DEL VEH&Iacute;CULO</td>
    <td  class="cellRight" align="center">DOCUMENTO DE IDENTIFICACI&Oacute;N    </td>
    <td  class="cellRight">DIRECCI&Oacute;N DEL POSEEDOR O    TENEDOR</td>
    <td class="cellRight">TEL&Eacute;FONO DEL POSEEDOR O    TENEDOR</td>
    <td  class="cellRight">CIUDAD Y DEPARTAMENTO</td>
  </tr>
  <tr >
    <td  class="cellLeft" >{$DATOSMANIFIESTO.tenedor}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_tenedor}&nbsp;</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.direccion_tenedor}&nbsp;</td>
    <td class="cellRight">{$DATOSMANIFIESTO.telefono_tenedor}&nbsp;</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.ciudad_tenedor}&nbsp;</td>
  </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr align="center" >
    <td width="250"   class="cellLeft">CONDUCTOR DEL    VEH&Iacute;CULO</td>
    <td width="150"  class="cellRight">DOCUMENTO DE IDENTIFICACI&Oacute;N    </td>
    <td width="150"  class="cellRight"> LICENCIA DE CONDUCCI&Oacute;N</td>
    <td width="261"  class="cellRight">DIRECCI&Oacute;N DEL CONDUCTOR</td>
    <td width="150"  class="cellRight">CIUDAD Y DEPARTAMENTO</td>
  </tr>
  <tr >
    <td  class="cellLeft" >{$DATOSMANIFIESTO.nombre}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_conductor}&nbsp;</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.numero_licencia_cond}&nbsp;</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.direccion_conductor}&nbsp;</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.ciudad_conductor}&nbsp;</td>
  </tr>
</table></td>
    </tr>
    <tr>
      <td colspan="2">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr >
          <td  align="center" colspan="14" class="cellRight borderLeft">INFORMACI&Oacute;N DE LA MERCANC&Iacute;A TRANSPORTADA</td>
        </tr>
        <tr align="center">
          <td width="38"  class="cellLeft cellTitleProd"> DE    REMESA</td>
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
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[0].numero_remesa}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].medida}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].cantidad}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].naturaleza}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].empaque}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight" width="160">{$DATOSREMESAS[0].origen}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[0].propietario_mercancia}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].numero_identificacion_propietario_mercancia}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[0].direccion_remitente|substr:0:37}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[0].remitente}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].doc_remitente}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[0].destino}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[0].destinatario}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].doc_destinatario}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[0].direccion_destinatario|substr:0:37}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].aseguradora|substr:0:26}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA &nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].numero_poliza}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].nit_aseguradora}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[1].numero_remesa}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].medida}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].cantidad}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].naturaleza}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].empaque}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight">{$DATOSREMESAS[1].origen}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[1].propietario_mercancia}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].numero_identificacion_propietario_mercancia}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[1].direccion_remitente|substr:0:37}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[1].remitente}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].doc_remitente}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[1].destino}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[1].destinatario}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].doc_destinatario}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[1].direccion_destinatario|substr:0:37}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].aseguradora|substr:0:26}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA &nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].numero_poliza}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].nit_aseguradora}&nbsp;&nbsp;</td>
        </tr>	
		
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[2].numero_remesa}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].medida}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].cantidad}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].naturaleza}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].empaque}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight">{$DATOSREMESAS[2].origen}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[2].propietario_mercancia}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].numero_identificacion_propietario_mercancia}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[2].direccion_remitente|substr:0:37}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[2].remitente}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].doc_remitente}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[2].destino}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[2].destinatario}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].doc_destinatario}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[2].direccion_destinatario|substr:0:37}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].aseguradora|substr:0:26}&nbsp;&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA &nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].numero_poliza}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].nit_aseguradora}&nbsp;&nbsp;</td>
        </tr>				
      </table></td>
    </tr>
    <tr>
	  <td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td  align="center" class="cellRight borderLeft">VALOR A PAGAR </td>
              <td colspan="2"  align="center" class="cellRight">VALOR PAGAR PACTADO EN LETRAS : &nbsp;&nbsp; {$SALDOPAGARLETRAS}&nbsp;&nbsp;PESOS M/CTE</td>
              <td width="289" rowspan="6" align="center" valign="bottom" class="cellRight">HUELLA</td>
              <td width="759" align="center" class="cellRight" valign="middle" >FECHA ESTIMADA ENTREGA</td>
            </tr>
            <tr>
              <td width="231" rowspan="7" align="left" valign="top" class="borderLeft">
<table width="231" height="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td width="130" class="cellRight borderTop">VALOR A PAGAR PACTADO</td>
              <td class="cellRight borderTop" align="right">{if $DATOSMANIFIESTO.valor_flete > 0}&nbsp;${$DATOSMANIFIESTO.valor_flete|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}</td>
            </tr>
			
			{if count($IMPUESTOS) > 0}&nbsp;
			
			  {foreach name=impuestos from=$IMPUESTOS item=i}&nbsp;
              <tr>
                <td class="CellRight">{$i.nombre}&nbsp;</td>
                <td class="cellRight" align="right">{if $i.valor > 0}&nbsp;${$i.valor|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}</td>
              </tr>			
			  {/foreach}
			
			{else}&nbsp;
              <tr>
                <td class="CellRight">RETENCION EN LA    FUENTE</td>
                <td class="cellRight" align="right">0</td>
              </tr>
              <tr>
                <td class="CellRight">RETENCION ICA</td>
                <td class="cellRight" align="right">0</td>
              </tr>			
            {/if}						
			
            <tr>
              <td class="CellRight">VALOR NETO A PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_neto_pagar > 0}&nbsp;${$DATOSMANIFIESTO.valor_neto_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}</td>
            </tr>
            <tr>
              <td class="CellRight">VALOR ANTICIPO&nbsp;</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_anticipo > 0}&nbsp;${$DATOSMANIFIESTO.valor_anticipo|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}</td>
            </tr>
            <tr>
              <td class="CellRight">SALDO POR PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.saldo_por_pagar > 0}&nbsp;${$DATOSMANIFIESTO.saldo_por_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}</td>
            </tr>
            <tr>
              <td class="CellRight">FECHA PAGO DE SALDO</td>
              <td class="cellRight" align="right">{$DATOSMANIFIESTO.fecha_pago_saldo}&nbsp;</td>
            </tr>
            <tr>
              <td class="CellRight" >LUGAR PAGO DEL SALDO:&nbsp;</td>
              <td class="cellRight" >{$DATOSMANIFIESTO.lugar_pago_saldo|substr:0:38}&nbsp;
{$DATOSMANIFIESTO.lugar_pago_saldo|substr:38:68}</td>
            </tr>
            <tr>
              <td class="CellRight">CARGUE    PAGADO POR:</td>
              <td class="cellRight">{$DATOSMANIFIESTO.cargue_pagado_por}&nbsp;</td>
            </tr>
            <tr>
              <td class="CellRight">DESCARGUE    PAGADO POR:</td>
              <td class="cellRight">{$DATOSMANIFIESTO.descargue_pagado_por}&nbsp;</td>
            </tr>
          </table>			  </td>
              <td width="793" rowspan="5" align="center" valign="top" class="cellRight">FIRMA AUTORIZADA POR LA EMPRESA<br><img  width="100%" height="100%" src="{$DATOSMANIFIESTO.firma_desp}"></td>
              <td width="936" rowspan="5" align="center" class="cellRight" valign="top">FIRMA Y HUELLA DEL CONDUCTOR</td>
              <td align="center" class="cellRight" height="8" valign="middle"> {$DATOSMANIFIESTO.fecha_entrega_mcia_du}&nbsp;&nbsp;{$DATOSMANIFIESTO.hora_entrega}&nbsp; </td>
            </tr>
            <tr>
              <td align="center" class="cellRight" height="8" valign="middle">PRECINTO</td>
            </tr>
            <tr>
              <td align="center" class="cellRight" height="8" valign="middle">{$DATOSMANIFIESTO.numero_precinto}&nbsp;</td>
            </tr>
            <tr>
              <td width="759" align="center" class="cellRight" height="8" valign="middle">OBSERVACIONES</td>
            </tr>
            <tr>
              <td width="759"  align="center" valign="middle" class="cellRight" >{$DATOSMANIFIESTO.observaciones}&nbsp;</td>
            </tr>
            
            <tr>
              <td align="left" class="cellRight">NOMBRE : {$DATOSMANIFIESTO.usuario_registra|substr:0:30}&nbsp;</td>
              <td colspan="2" align="left" class="cellRight">NOMBRE : {$DATOSMANIFIESTO.nombre|substr:0:30}&nbsp;</td>
              <td width="759" align="center" class="borderRight  borderBottom  borderTop"  >CONTENEDOR </td>
            </tr>
            <tr>
              <td align="left"  class="cellRight">DOCUMENTO DE IDENTIFICACION: {$DATOSMANIFIESTO.usuario_registra_numero_identificacion}&nbsp;</td>
              <td colspan="2" align="left"  class="cellRight">DOCUMENTO DE IDENTIFICACION: {$DATOSMANIFIESTO.numero_identificacion}&nbsp;</td>
              <td width="759" align="center" class="borderRight borderBottom">{$DATOSMANIFIESTO.numero_formulario}&nbsp;</td>
            </tr>
        </table>	  
	  </td>
    </tr>
  </table>

{if count($DATOSREMESASANEXO) >3}&nbsp;


  {assign var="cont"    value="1"}&nbsp;
  {assign var="contTot" value="$TOTALREMESAS"}&nbsp;  

  {foreach name=remesas_anexo from=$DATOSREMESASANEXO item=ra}&nbsp;
  
     {if $smarty.foreach.remesas_anexo.iteration >3}&nbsp;
	 
	   {if $cont eq 1}&nbsp;
          <br class="saltopagina" />	
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td><table  border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="843" align="left"><img src="{$DATOSMANIFIESTO.logo}" width="190" height="40" /></td>
                    <td width="1394" align="center"><div>DESPACHO URBANO</div>
                        <div>{$DATOSMANIFIESTO.oficina}</div>
                      <div>{$DATOSMANIFIESTO.direccion_oficina}</div></td>
                    <td width="64" align="center">&nbsp;</td>
                    <td width="1104" valign="top" align="right"><table cellspacing="0" cellpadding="0" align="right">
                        <tr >
                          <td rowspan="2" ><img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" />&nbsp;&nbsp;&nbsp;</td>
                          <td  class="title">N&Uacute;MERO PLANILLA URBANO </td>
                        </tr>
                        <tr >
                          <td class="infogeneral">{$DATOSMANIFIESTO.despacho}&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                </table></td>
			  </tr>
			  <tr>
				<td>
				<table cellspacing="0" cellpadding="0" width="100%">
				  <tr >
					<td  colspan="6" class="title">DATOS DE LA EMPRESA</td>
				  </tr>
				  <tr>
					<td width="60"  class="cellLeft">EMPRESA:</td>
					<td width="250" class="cellRight">{$DATOSMANIFIESTO.razon_social}&nbsp;</td>
					<td width="40"  class="cellRight">SIGLA:</td>
					<td width="150" class="cellRight">{$DATOSMANIFIESTO.sigla}&nbsp;</td>
					<td width="50" class="cellRight">NIT:</td>
					<td width="80" class="cellRight">{$DATOSMANIFIESTO.numero_identificacion}&nbsp;</td>
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
			  </tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">		
        <tr >
          <td  align="center"colspan="14" class="title">INFORMACI&Oacute;N DE LA MERCANC&Iacute;A TRANSPORTADA</td>
        </tr>			
        <tr align="center">
          <td width="38"  class="cellLeft cellTitleProd"> DE    REMESA</td>
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
          <td rowspan="4" class="cellRight" align="center">{$ra.producto}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.descripcion_producto}&nbsp;&nbsp;</td>
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
          <td class="cellRight">&nbsp;POLIZA &nbsp;</td>
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
          <td rowspan="4" class="cellRight" align="center">{$ra.producto}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.descripcion_producto}&nbsp;&nbsp;</td>
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
          <td class="cellRight">&nbsp;POLIZA &nbsp;</td>
          <td class="cellRight">{$ra.numero_poliza}&nbsp;</td>
          <td class="cellRight">{$ra.nit_aseguradora}&nbsp;</td>
	    </tr>	    	   	
	   {/if}
	 	 
   	   {if $cont eq $contTot or $smarty.foreach.remesas_anexo.iteration eq count($DATOSREMESASANEXO) or $cont eq 7}&nbsp;
	      </table>
         {assign var="cont" value="1"}&nbsp;
	   {else}&nbsp;
	       {assign var="cont" value=$cont+1}&nbsp;
	   {/if}	   
	   	 
	 {/if}
  
  {/foreach}
  

{/if}

{if count($HOJADETIEMPOS) > 0}&nbsp;
<br class="saltopagina" />	
<table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1" width="100%">
  <tr>
    <td colspan="3" rowspan="3" align="left" valign="top">{$DATOSMANIFIESTO.logo}&nbsp;</td>
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
    <td rowspan="2">&nbsp;    REMESA&nbsp;</td>
    <td rowspan="4">CARGUE</td>
    <td rowspan="2">&nbsp;PLAZO<br />
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
    <td rowspan="2">&nbsp;    REMESA&nbsp;</td>
    <td rowspan="4">CARGUE</td>
    <td rowspan="2">&nbsp;PLAZO<br />
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
    <td rowspan="2">&nbsp;    REMESA&nbsp;</td>
    <td rowspan="4">CARGUE</td>
    <td rowspan="2">&nbsp;PLAZO<br />
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
    <td rowspan="2">&nbsp;    REMESA&nbsp;</td>
    <td rowspan="4">CARGUE</td>
    <td rowspan="2">&nbsp;PLAZO<br />
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
{/if}


{if count($HOJADETIEMPOSASANEXO) > 4}&nbsp;


  {assign var="cont2"    value="1"}&nbsp;
  {assign var="contTot2" value="$TOTALHOJADETIEMPOS"}&nbsp;  

  {foreach name=hoja_tiempos_anexo from=$HOJADETIEMPOSASANEXO item=ht}&nbsp;
  
     {if $smarty.foreach.hoja_tiempos_anexo.iteration > 5}&nbsp;
	 
	   {if $cont2 eq 1}&nbsp;
<br class="saltopagina" />	
<table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1">
  <tr>
    <td colspan="3" rowspan="3" align="left" valign="top">{$DATOSMANIFIESTO.logo}&nbsp;</td>
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
			<td rowspan="2">&nbsp;    REMESA&nbsp;</td>
			<td rowspan="4">CARGUE</td>
			<td rowspan="2">&nbsp;PLAZO<br />
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
			<td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
			<td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
			<td>&nbsp;C.C.:&nbsp;{$ht.cedula_recibe}&nbsp;</td>
		  </tr>	   
	      {/if}
	 	 
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
	   {/if}	   
	   	 
	 {/if}
  
  {/foreach}
  

{/if}
</body>
</html>