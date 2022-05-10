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
  {if $DATOSMANIFIESTO.estado eq 'A'}<div style="position:absolute; top:40%; left:5%" class="anulado">MANIFIESTO ANULADO</div>{/if}
	
  <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td colspan="2" align="center">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><table  border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
             <td width="843" align="left">
			     <img src="{$DATOSMANIFIESTO.logo}?123" width="130" height="52" />&nbsp;			  				 
		         
			  </td>
              <td width="1394" align="center">
			    <div>MANIFIESTO DE CARGA</div>
				<div>{$DATOSMANIFIESTO.oficina}</div>
				<div>{$DATOSMANIFIESTO.direccion_oficina}</div>				
			  </td>
              <td width="64" align="center">&nbsp;</td>
              <td width="1104" valign="top" align="right"><table cellspacing="0" cellpadding="0" align="right">
                <tr >
                  <td rowspan="3" ><img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" />&nbsp;&nbsp;&nbsp;</td>
                  <td  class="title">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
                </tr>
                <tr >
                  <td class="infogeneral"><font size="1">{$DATOSMANIFIESTO.manifiesto}&nbsp;</font></td>
                </tr>
                <tr >
                  <td class="borderLeft borderRight">COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
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
	<td width="27%" valign="bottom"><table cellspacing="0" cellpadding="0" border="0" >
      <tr >
        <td width="269"  align="center"  class="borderLeft cellRight borderTop">TIPO  MANIFIESTO</td>
        <td width="332"  align="center"  class="cellRight borderTop">N&Uacute;MERO INTERNO  EMPRESA</td>
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
        <tr align="center">
          <td  width="155"  class="cellLeft" >FECHA DE EXPEDICI&Oacute;N</td>
          <td  width="300" class="cellRight">ORIGEN DEL VIAJE</td>
          <td  width="310" class="cellRight">DESTINO DEL VIAJE</td>
          <td  width="200" class="cellRight">FECHA LIMITE ENTREGA CARGA </td>
        </tr>
        <tr align="center" >
          <td  width="155" class="cellLeft" >{$DATOSMANIFIESTO.fecha_mc}&nbsp;</td>
          <td  width="300" class="cellRight">{$DATOSMANIFIESTO.origen}&nbsp;</td>
          <td  width="310" class="cellRight">{$DATOSMANIFIESTO.destino}&nbsp;</td>
          <td  width="180" class="cellRight" align="center">{$DATOSMANIFIESTO.fecha_entrega_mcia_mc}&nbsp;</td>
        </tr>
        <tr>
		  <td colspan="4">
		  
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr align="center" >
			  <td width="230" class="cellLeft" >TITULAR MANIFIESTO</td>
			  <td width="150"  class="cellRight">DOCUMENTO DE IDENTIFICACI&Oacute;N    </td>
			  <td width="250" class="cellRight">DIRECCI&Oacute;N DEL TITULAR</td>
			  <td width="150"  class="cellRight">TEL&Eacute;FONO DEL TITULAR</td>
			  <td width="180" class="cellRight">CIUDAD Y DEPARTAMENTO</td>
			</tr>
			<tr align="center" >
			  <td class="cellLeft" >{$DATOSMANIFIESTO.titular_manifiesto}&nbsp;</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.numero_identificacion_titular_manifiesto}&nbsp;</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.direccion_titular_manifiesto|substr:0:57}&nbsp;</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.telefono_titular_manifiesto}&nbsp;</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.ciudad_titular_manifiesto}&nbsp;</td>
			</tr>		  
		  </table>		  </td>
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
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[0].numero_remesa}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].medida}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].cantidad}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].naturaleza}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].empaque}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].producto}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{*{$DATOSREMESAS[0].descripcion_producto}*}sus productos&nbsp;&nbsp;</td>
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
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].numero_poliza}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].nit_aseguradora}&nbsp;&nbsp;</td>
        </tr>
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[1].numero_remesa}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].medida}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].cantidad}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].naturaleza}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].empaque}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].producto}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{*{$DATOSREMESAS[1].descripcion_producto}*}sus productos&nbsp;&nbsp;&nbsp;</td>
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
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].numero_poliza}&nbsp;&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].nit_aseguradora}&nbsp;&nbsp;</td>
        </tr>	
		
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[2].numero_remesa}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].medida}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].cantidad}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].naturaleza}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].empaque}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].producto}&nbsp;&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{*{$DATOSREMESAS[2].descripcion_producto}*}sus productos&nbsp;&nbsp;&nbsp;</td>
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
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
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
              <td width="289" rowspan="8" align="center" valign="bottom" class="cellRight">HUELLA</td>
              <td width="759" align="center" class="cellRight" valign="middle" >FECHA ESTIMADA ENTREGA</td>
            </tr>
            <tr>
              <td width="231" rowspan="9" align="left" valign="top" class="borderLeft">
<table width="231" height="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td width="130" class="cellRight borderTop">VALOR A PAGAR PACTADO</td>
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
                <td class="CellRight">RETENCION EN LA    FUENTE</td>
                <td class="cellRight" align="right">0</td>
              </tr>
              <tr>
                <td class="CellRight">RETENCION ICA</td>
                <td class="cellRight" align="right">0</td>
              </tr>			
            {/if}&nbsp;						
			
            <tr>
              <td class="CellRight">VALOR NETO A PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_neto_pagar > 0}&nbsp;${$DATOSMANIFIESTO.valor_neto_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
            </tr>
            <tr>
              <td class="CellRight">VALOR ANTICIPO&nbsp;</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_anticipo > 0}&nbsp;${$DATOSMANIFIESTO.valor_anticipo|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
            </tr>
            <tr>
              <td class="CellRight">SALDO POR PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.saldo_por_pagar > 0}&nbsp;${$DATOSMANIFIESTO.saldo_por_pagar|number_format:2:",":"."}&nbsp;{else}&nbsp;0{/if}&nbsp;</td>
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
              <td width="793" rowspan="7" align="center" valign="top" class="cellRight">FIRMA AUTORIZADA POR LA EMPRESA</td>
              <td width="936" rowspan="7" align="center" class="cellRight" valign="top">FIRMA Y HUELLA DEL CONDUCTOR</td>
              <td align="center" class="cellRight" height="8" valign="middle"> {$DATOSMANIFIESTO.fecha_entrega_mcia_mc}&nbsp;&nbsp;{$DATOSMANIFIESTO.hora_entrega}&nbsp; </td>
            </tr>
            <tr>
              <td align="center" class="cellRight" height="8" valign="middle">PRECINTO</td>
            </tr>
            <tr>
              <td align="center" class="cellRight" height="8" valign="middle">{$DATOSMANIFIESTO.numero_precinto}&nbsp;</td>
            </tr>
            <tr>
              <td width="759" align="center" class="cellRight" height="8" valign="middle">Numero DTA</td>
            </tr>
            <tr>
              <td width="759"  align="center" class="cellRight" valign="middle" >{$DATOSMANIFIESTO.numero_formulario}&nbsp;</td>
            </tr>
            <tr>
              <td width="759" align="center" class="cellRight" valign="top">OBSERVACIONES</td>
            </tr>
            <tr>
              <td align="center" class="borderRight" valign="top" height="20">{$DATOSMANIFIESTO.observaciones}<br>ID MOBILE : {$DATOSMANIFIESTO.id_mobile}&nbsp;</td>
            </tr>
            <tr>
              <td align="left" class="cellRight">NOMBRE : {$DATOSMANIFIESTO.usuario_registra|substr:0:30}&nbsp;</td>
              <td colspan="2" align="left" class="cellRight">NOMBRE : {$DATOSMANIFIESTO.nombre|substr:0:30}&nbsp;</td>
              <td width="759" align="center" class="borderRight  borderBottom  borderTop"  >CONTENEDOR </td>
            </tr>
            <tr>
              <td align="left"  class="cellRight">DOCUMENTO DE IDENTIFICACION: {$DATOSMANIFIESTO.usuario_registra_numero_identificacion}&nbsp;</td>
              <td colspan="2" align="left"  class="cellRight">DOCUMENTO DE IDENTIFICACION: {$DATOSMANIFIESTO.numero_identificacion}&nbsp;</td>
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
                    <td width="843" align="left"><img src="{$DATOSMANIFIESTO.logo}?123" width="130" height="52" />&nbsp;  </td>
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
                            <td colspan="5" align="center" style="border-left:1px solid;border-top:1px solid; border-right:1px solid">POLITICA DE SEGURIDAD EN RUTA DE LA {$DATOSMANIFIESTO.razon_social}</td>
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
                            <td class="celda_bordes" colspan="4" >Entregar los cumplidos m&aacute;ximo 24 horas despacho urbano y 48 horas nacional, despu&eacute;s de la entrega al responsable en LOGISCOM o a enviarlos por correo a las oficinas de LOGISCOM.</td>
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
                            <td class="celda_bordes" colspan="4">Regresar el material de amarre proporcionado por LOGISCOM: lazos,    tablas, estibas.</td>
                        </tr>
    
                        <tr>
                            <td colspan="5"><p align="justify"><b>Doy f&eacute; que estos compromisos se encuentran claros, de faltar a alguno los anteriores puntos autorizo a aplicar una multa por un valor de $ 50.000 Mcte por las siguientes infracciones (Secci&oacute;n 2):</b></p></td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">1</td>
                            <td class="celda_bordes" colspan="4">El no reporte en puestos de control. (Una multa por cada puesto de control)</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">2</td>
                            <td class="celda_bordes" colspan="4">No radicar documentos cumplidos. (Una multa por cada documento no radicado)</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">3</td>
                            <td class="celda_bordes" colspan="4">No garantizar la comunicaci&oacute;n durante el recorrido. (para terceros la multa mas el veto del vehiculo)</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">4</td>
                            <td class="celda_bordes" colspan="4">Llevar armas de cualquier tipo en el veh&iacute;culo.</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">5</td>
                            <td class="celda_bordes" colspan="4">Llevar acompa&ntilde;ante/s en la cabina.&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">6</td>
                            <td class="celda_bordes" colspan="4">Parar o pernoctar en lugares NO autorizados por Control Tr&aacute;fico.&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">7</td>
                            <td class="celda_bordes" colspan="4">Todas las conductas que atenten a la seguridad de la carga, el veh&iacute;culo y la integridad del transportador.&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="celda_bordes">8</td>
                            <td class="celda_bordes" colspan="4">Diligenciar la Hoja de tiempos que hace parte del manifiesto de carga.&nbsp;</td>
                        </tr>
    
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5" ><p align="justify"><b>Declaro que el veh&iacute;culo se le ha efectuado el mantenimiento tecno-mec&aacute;nico requerido para que permanezca    operando con normalidad durante el trayecto&nbsp;    asignado.&nbsp;</b></p></td>
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
                            <td colspan="5">&nbsp;</td>
                        </tr>						
                        <tr>
                            <td colspan="5" align="center" >FAVOR TENER EN CUENTA LAS RECOMENDACIONES DE LA CARTILLA DE INDUCCION A TRANSPORTISTAS</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="celda_bordes" align="center"><strong>TELEFONOS&nbsp; TRAFICO Y SEGURIDAD 318-3485205 - 3212008962</strong></td>
                        </tr>
						<tr><td colspan="5">&nbsp;</td></tr>
                        <tr>
                            <td colspan="5" class="celda_bordes" align="center"><strong>Tels: {$DATOSMANIFIESTO.telefono}-{$DATOSMANIFIESTO.oficina}</strong></td>
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
							  {$DETALLES[0].direccion|substr:0:60}&nbsp;<br> {$DETALLES[0].observacion|substr:0:60}
							  
                              {elseif $si_men eq '0' }
                                <b>
                                {assign var="si_men" value="1"}                   
                              {else}
                                <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                            {/if}                             </td>
                            <td class="celda_bordes celda_nombre">
							    {if $DETALLES[1].tipo_punto neq ''}
                                <b>{$DETALLES[1].tipo_punto|substr:0:30}: </b>{$DETALLES[1].nombre|substr:0:40}<br />
								{$DETALLES[1].direccion|substr:0:60}&nbsp;<br> {$DETALLES[1].observacion|substr:0:60}
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
                                    <b>{$DETALLES[2].tipo_punto|substr:0:20}: </b>{$DETALLES[2].nombre|substr:0:40}<br />{$DETALLES[2].direccion|substr:0:60}&nbsp;<br> {$DETALLES[2].observacion|substr:0:60}
                                {elseif $si_men eq '0' }<br>&nbsp; 
                                    {assign var="si_men" value="2"}                   
                                {else}
                                    <b>&nbsp;</b>&nbsp;<br />&nbsp;<br>&nbsp; 
                                {/if}                             
							</td>
                             <td class="celda_bordes celda_nombre">
                                {if $DETALLES[3].tipo_punto neq ''}
                                    <b>{$DETALLES[3].tipo_punto|substr:0:30}: </b>{$DETALLES[3].nombre|substr:0:30}<br />{$DETALLES[3].direccion|substr:0:60}&nbsp;<br> {$DETALLES[3].observacion|substr:0:60}
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
    <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="130" height="52" />&nbsp;</td>
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
    <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
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
    <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
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
    <td rowspan="2">&nbsp;No.    REMESA&nbsp;</td>
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
    <td colspan="3" rowspan="3" align="left" valign="top"><img src="{$DATOSMANIFIESTO.logo}?123" width="130" height="52" />&nbsp;</td>
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