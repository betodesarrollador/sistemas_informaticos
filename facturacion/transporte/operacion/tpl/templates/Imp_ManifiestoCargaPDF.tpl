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
	
<page orientation="paysage" backtop="0mm" backbottom="0mm" backleft="5mm" backright="0mm">
  <table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td align="center">
	  <table width="100%" border="0">
        <tr>
          <td><table  border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
             <td width="242" align="left">
			     <img src="../../../framework/media/images/general/logoclienteacceso.png" width="160" height="42" />&nbsp;			  				 
		         <img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" />
			   </td>
              <td width="400">MINISTERIO DE TRANSPORTE ANEXO 1 FORMATO &Uacute;NICO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
              <td width="53" align="center">&nbsp;</td>
              <td width="280" valign="top" align="right">
			  <table cellspacing="0" cellpadding="0" align="right">
                  <tr >
                    <td rowspan="3" ><img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" />&nbsp;&nbsp;&nbsp;</td>
                    <td  class="title">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
                  </tr>
                  <tr >
                    <td class="infogeneral">{$DATOSMANIFIESTO.manifiesto}</td>
                  </tr>
                  <tr >
                    <td>COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>
<table  border="0" width="100%" cellpadding="0" cellspacing="0">

  <tr>
    <td valign="top"><table cellspacing="0" cellpadding="0">
      <tr >
        <td  colspan="6" class="title">DATOS DE LA EMPRESA</td>
      </tr>
      <tr>
        <td width="60"  class="cellLeft">EMPRESA:</td>
        <td width="250" class="cellRight">{$DATOSMANIFIESTO.razon_social}</td>
        <td width="40"  class="cellRight">SIGLA:</td>
        <td width="150" class="cellRight">{$DATOSMANIFIESTO.sigla}</td>
        <td width="50" class="cellRight">NIT:</td>
        <td width="80" class="cellRight">{$DATOSMANIFIESTO.numero_identificacion_empresa}</td>
      </tr>
      <tr >
        <td class="cellLeft">DIRECCI&Oacute;N:</td>
        <td class="cellRight">{$DATOSMANIFIESTO.direccion}</td>
        <td class="cellRight">CIUDAD:</td>
        <td class="cellRight">{$DATOSMANIFIESTO.ciudad}</td>
        <td class="cellRight">TEL&Eacute;FONO:</td>
        <td class="cellRight">{$DATOSMANIFIESTO.telefono}</td>
      </tr>
    </table></td>
	<td><table cellspacing="0" cellpadding="0" >
      <tr >
        <td  class="title" width="135">TIPO DE MANIFIESTO</td>
      </tr>
      <tr>
        <td class="infogeneral" height="17">{$DATOSMANIFIESTO.tipo_manifiesto}</td>
      </tr>
    </table></td><td align="right"><table cellspacing="0" cellpadding="0">
      <tr>
        <td   class="cellTitle">N&Uacute;MERO INTERNO  EMPRESA TRANSPORTE</td>
      </tr>
      <tr>
        <td  class="infogeneral" height="17">{$DATOSMANIFIESTO.codigo_empresa}</td>
      </tr>
    </table></td>
    </tr>
</table>		  
		  </td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td>
<table cellspacing="0" cellpadding="0" width="100%" border="0">
        <tr >
          <td colspan="4"  class="cellLeft">INFORMACI&Oacute;N DEL MANIFIESTO DE CARGA</td>
        </tr>
        <tr align="center" >
          <td  width="155"  class="cellLeft" >FECHA DE EXPEDICI&Oacute;N    (AAAA/MM/DD)</td>
          <td  width="300" class="cellRight">ORIGEN DEL VIAJE</td>
          <td  width="310" class="cellRight">DESTINO DEL VIAJE</td>
          <td  width="200" class="cellRight">FECHA LIMITE ENTREGA CARGA (AAAA/MM/DD)</td>
        </tr>
        <tr >
          <td  width="155" class="cellLeft" >{$FECHA}</td>
          <td  width="300" class="cellRight">{$DATOSMANIFIESTO.origen}</td>
          <td  width="310" class="cellRight">{$DATOSMANIFIESTO.destino}</td>
          <td  width="180" class="cellRight" align="center">{$DATOSMANIFIESTO.fecha_entrega_mcia_mc}</td>
        </tr>
        <tr>
		  <td colspan="4">
		  
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr >
			  <td width="230" class="cellLeft" >TITULAR MANIFIESTO</td>
			  <td width="150"  class="cellRight">DOCUMENTO DE IDENTIFICACI&Oacute;N    No.</td>
			  <td width="250" class="cellRight">DIRECCI&Oacute;N DEL TITULAR</td>
			  <td width="150"  class="cellRight">TEL&Eacute;FONO DEL TITULAR</td>
			  <td width="180" class="cellRight">CIUDAD Y DEPARTAMENTO</td>
			</tr>
			<tr >
			  <td class="cellLeft" >{$DATOSMANIFIESTO.titular_manifiesto}</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.numero_identificacion_titular_manifiesto}</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.direccion_titular_manifiesto|substr:0:57}</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.telefono_titular_manifiesto}</td>
			  <td class="cellRight">{$DATOSMANIFIESTO.ciudad_titular_manifiesto}</td>
			</tr>		  
		  </table>
		  
		  </td>
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
    <td width="120"  class="cellRight">VENCIMIENTO(AAAA/MM/DD)</td>
    <td width="110"  class="cellRight">No. POLIZA</td>
  </tr>
  <tr >
    <td class="cellLeft" align="center" >{$DATOSMANIFIESTO.placa}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.marca}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.configuracion}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.placa_remolque}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.peso_vacio}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.nombre_aseguradora}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.vencimiento_soat}</td>
    <td   class="cellRight" align="center">{$DATOSMANIFIESTO.numero_soat}</td>
  </tr>
  </table>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" >
  <tr align="center" >
    <td width="250"   class="cellLeft">PROPIETARIO&nbsp; DEL VEH&Iacute;CULO</td>
    <td width="150"  class="cellRight">DOCUMENTO DE IDENTIFICACI&Oacute;N    No.</td>
    <td width="256"  class="cellRight">DIRECCI&Oacute;N DEL PROPIETARIO</td>
    <td  width="150" class="cellRight">TEL&Eacute;FONO DEL PROPIETARIO</td>
    <td  width="150" class="cellRight">CIUDAD Y DEPARTAMENTO</td>
  </tr>
  <tr >
    <td  class="cellLeft" >{$DATOSMANIFIESTO.propietario}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_propietario}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.direccion_propietario|substr:0:65}</td>
    <td class="cellRight">{$DATOSMANIFIESTO.telefono_propietario}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.ciudad_propietario}</td>
  </tr>
  <tr >
    <td   class="cellLeft">POSEEDOR O TENEDOR    DEL VEH&Iacute;CULO</td>
    <td  class="cellRight" align="center">DOCUMENTO DE IDENTIFICACI&Oacute;N    No.</td>
    <td  class="cellRight">DIRECCI&Oacute;N DEL POSEEDOR O    TENEDOR</td>
    <td class="cellRight">TEL&Eacute;FONO DEL POSEEDOR O    TENEDOR</td>
    <td  class="cellRight">CIUDAD Y DEPARTAMENTO</td>
  </tr>
  <tr >
    <td  class="cellLeft" >{$DATOSMANIFIESTO.tenedor}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_tenedor}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.direccion_tenedor}</td>
    <td class="cellRight">{$DATOSMANIFIESTO.telefono_tenedor}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.ciudad_tenedor}</td>
  </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr align="center" >
    <td width="250"   class="cellLeft">CONDUCTOR DEL    VEH&Iacute;CULO</td>
    <td width="150"  class="cellRight">DOCUMENTO DE IDENTIFICACI&Oacute;N    No.</td>
    <td width="150"  class="cellRight">No. LICENCIA DE CONDUCCI&Oacute;N</td>
    <td width="261"  class="cellRight">DIRECCI&Oacute;N DEL CONDUCTOR</td>
    <td width="150"  class="cellRight">CIUDAD Y DEPARTAMENTO</td>
  </tr>
  <tr >
    <td  class="cellLeft" >{$DATOSMANIFIESTO.nombre}</td>
    <td  class="cellRight" align="center">{$DATOSMANIFIESTO.numero_identificacion_conductor}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.numero_licencia_cond}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.direccion_conductor}</td>
    <td  class="cellRight">{$DATOSMANIFIESTO.ciudad_conductor}</td>
  </tr>
</table></td>
    </tr>
    <tr>
      <td>
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
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[0].numero_remesa}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].medida}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].cantidad}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].naturaleza}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].empaque}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[0].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight" width="160">{$DATOSREMESAS[0].origen}&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[0].propietario_mercancia}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].numero_identificacion_propietario_mercancia}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[0].direccion_remitente|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[0].remitente}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].doc_remitente}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[0].destino}&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[0].destinatario}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].doc_destinatario}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[0].direccion_destinatario|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].aseguradora|substr:0:26}&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].numero_poliza}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].nit_aseguradora}&nbsp;</td>
        </tr>
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[1].numero_remesa}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].medida}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].cantidad}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].naturaleza}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].empaque}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[1].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight">{$DATOSREMESAS[1].origen}&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[1].propietario_mercancia}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].numero_identificacion_propietario_mercancia}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[1].direccion_remitente|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[1].remitente}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].doc_remitente}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[1].destino}&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[1].destinatario}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].doc_destinatario}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[1].direccion_destinatario|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].aseguradora|substr:0:26}&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[0].numero_poliza}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[1].nit_aseguradora}&nbsp;</td>
        </tr>
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[2].numero_remesa}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].medida}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].cantidad}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].naturaleza}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].empaque}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[2].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight">{$DATOSREMESAS[2].origen}&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[2].propietario_mercancia}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].numero_identificacion_propietario_mercancia}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[2].direccion_remitente|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[2].remitente}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].doc_remitente}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[2].destino}&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[2].destinatario}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].doc_destinatario}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[2].direccion_destinatario|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].aseguradora|substr:0:26}&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].numero_poliza}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[2].nit_aseguradora}&nbsp;</td>
        </tr>
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[3].numero_remesa}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[3].medida}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[3].cantidad}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[3].naturaleza}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[3].empaque}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[3].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[3].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight">{$DATOSREMESAS[3].origen}&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[3].propietario_mercancia}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[3].numero_identificacion_propietario_mercancia}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[3].direccion_remitente|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[3].remitente}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[3].doc_remitente}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[3].destino}&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[3].destinatario}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[3].doc_destinatario}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[3].direccion_destinatario|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[3].aseguradora|substr:0:26}&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[3].numero_poliza}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[3].nit_aseguradora}&nbsp;</td>
        </tr>
        <tr >
          <td rowspan="4" class="cellLeft" align="center">{$DATOSREMESAS[4].numero_remesa}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[4].medida}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[4].cantidad}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[4].naturaleza}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[4].empaque}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[4].producto}&nbsp;</td>
          <td rowspan="4" class="cellRight" align="center">{$DATOSREMESAS[4].descripcion_producto}&nbsp;</td>
          <td class="cellTitleRight" align="left">LUGAR DE ORIGEN</td>
          <td class="cellRight">{$DATOSREMESAS[4].origen}&nbsp;</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[4].propietario_mercancia}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[4].numero_identificacion_propietario_mercancia}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[4].direccion_remitente|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[4].remitente}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[4].doc_remitente}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">LUGAR DE DESTINO</td>
          <td class="cellRight">{$DATOSREMESAS[4].destino}&nbsp;</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$DATOSREMESAS[4].destinatario}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[4].doc_destinatario}&nbsp;</td>
        </tr>
        <tr >
          <td class="cellTitleRight" align="left">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$DATOSREMESAS[4].direccion_destinatario|substr:0:37}&nbsp;</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[4].aseguradora|substr:0:26}&nbsp;</td>
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[4].numero_poliza}&nbsp;</td>
          <td class="cellRight">{$DATOSREMESAS[4].nit_aseguradora}&nbsp;</td>
        </tr>								
      </table></td>
    </tr>
    <tr>
      <td>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  class="cellLeft" align="center">VALOR A PAGAR</td>
          <td  class="cellRight" align="center">VALOR A PAGAR PACTADO EN LETRAS</td>
        </tr>
        <tr>
          <td width="18%"  valign="top">
		  <table width="231" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100" class="cellLeft">VALOR A PAGAR PACTADO</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_flete > 0}${$DATOSMANIFIESTO.valor_flete|number_format:2:",":"."}{else}0{/if}</td>
            </tr>
			
			{if count($IMPUESTOS) > 0}
			
			  {foreach name=impuestos from=$IMPUESTOS item=i}
              <tr>
                <td class="cellLeft">{$i.nombre}</td>
                <td class="cellRight" align="right">{if $i.valor > 0}${$i.valor|number_format:2:",":"."}{else}0{/if}</td>
              </tr>			
			  {/foreach}
			
			{else}
              <tr>
                <td class="cellLeft">RETENCION EN LA    FUENTE</td>
                <td class="cellRight" align="right">0</td>
              </tr>
              <tr>
                <td class="cellLeft">RETENCION ICA</td>
                <td class="cellRight" align="right">0</td>
              </tr>			
            {/if}						
			
            <tr>
              <td class="cellLeft">VALOR NETO A PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_neto_pagar > 0}${$DATOSMANIFIESTO.valor_neto_pagar|number_format:2:",":"."}{else}0{/if}</td>
            </tr>
            <tr>
              <td class="cellLeft">VALOR ANTICIPO&nbsp;</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.valor_anticipo > 0}${$DATOSMANIFIESTO.valor_anticipo|number_format:2:",":"."}{else}0{/if}</td>
            </tr>
            <tr>
              <td class="cellLeft">SALDO POR PAGAR</td>
              <td class="cellRight" align="right">{if $DATOSMANIFIESTO.saldo_por_pagar > 0}${$DATOSMANIFIESTO.saldo_por_pagar|number_format:2:",":"."}{else}0{/if}</td>
            </tr>
            <tr>
              <td class="cellLeft">FECHA PAGO DE SALDO</td>
              <td class="cellRight" align="right">{$DATOSMANIFIESTO.fecha_pago_saldo}</td>
            </tr>
            <tr>
              <td class="infogeneral" colspan="2" height="63"><br />LUGAR PARA EL PAGO DEL SALDO:<br /><br />                
                {$DATOSMANIFIESTO.lugar_pago_saldo|substr:0:38}<br />
				{$DATOSMANIFIESTO.lugar_pago_saldo|substr:38:68}			  </td>
            </tr>
            <tr>
              <td class="cellLeft">CARGUE    PAGADO POR:</td>
              <td class="cellRight">{$DATOSMANIFIESTO.cargue_pagado_por}</td>
            </tr>
            <tr>
              <td class="cellLeft">DESCARGUE    PAGADO POR:</td>
              <td class="cellRight">{$DATOSMANIFIESTO.descargue_pagado_por}</td>
            </tr>
          </table>		  </td>
          <td  valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td height="50" colspan="3" rowspan="4" align="center" class="cellRight"><table align="center">
                  <tr>
                    <td>{$SALDOPAGARLETRAS}</td>
                  </tr>
                  <tr>
                    <td>__________________________________________________</td>
                  </tr>
                  <tr>
                    <td>PESOS M/CTE</td>
                  </tr>
              </table></td>
              <td width="164" align="center" class="cellRight" valign="middle" >FECHA ESTIMADA ENTREGA</td>
            </tr>
            <tr>
              <td align="center" class="cellRight" height="8" valign="middle"> {$DATOSMANIFIESTO.fecha_entrega_mcia_mc}&nbsp;{$DATOSMANIFIESTO.hora_entrega} </td>
            </tr>
            <tr>
              <td align="center" class="cellRight" height="8" valign="middle">PRECINTO</td>
            </tr>
            <tr>
              <td align="center" class="cellRight" height="8" valign="middle">{$DATOSMANIFIESTO.numero_precinto}</td>
            </tr>
            <tr>
              <td  align="center" class="cellTitleRight" width="50%">FIRMA AUTORIZADA POR LA EMPRESA </td>
              <td width="25%" colspan="2" align="center" class="cellTitleRight">FIRMA Y HUELLA DEL CONDUCTOR</td>
              <td width="164" align="center" class="cellRight" height="8" valign="middle">Numero DTA</td>
            </tr>
            <tr>
              <td width="200" height="83" rowspan="2" align="center" valign="top" class="cellRight">FIRMA </td>
              <td width="200" height="83" rowspan="2" align="center" valign="top" class="cellRight">FIRMA</td>
              <td width="100" rowspan="2" align="center" valign="bottom" class="cellRight">HUELLA</td>
              <td width="164" height="8" align="center" class="cellRight" valign="middle" >{$DATOSMANIFIESTO.numero_formulario}</td>
            </tr>
            <tr>
              <td width="164" height="73" align="center" class="borderRight" valign="top">      
			   OBSERVACIONES<br /><br />{$DATOSMANIFIESTO.observaciones}
			  </td>
            </tr>
            
            <tr>
              <td align="left" class="cellRight">NOMBRE : {$DATOSMANIFIESTO.usuario_registra|substr:0:30}</td>
              <td colspan="2" align="left" class="cellRight">NOMBRE : {$DATOSMANIFIESTO.nombre|substr:0:30}</td>
              <td width="164" align="center" class="borderRight  borderBottom  borderTop"  >CONTENEDOR </td>
            </tr>
            <tr>
              <td align="left"  class="cellRight">DOCUMENTO DE IDENTIFICACION: {$DATOSMANIFIESTO.usuario_registra_numero_identificacion}</td>
              <td colspan="2" align="left"  class="cellRight">DOCUMENTO DE IDENTIFICACION: {$DATOSMANIFIESTO.numero_identificacion}</td>
              <td width="164" align="center" class="borderRight borderBottom">{$DATOSMANIFIESTO.numero_formulario}</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</page>

{if count($DATOSREMESASANEXO) > 5}


  {assign var="cont"    value="1"}
  {assign var="contTot" value="$TOTALREMESAS"}  

  {foreach name=remesas_anexo from=$DATOSREMESASANEXO item=ra}
  
     {if $smarty.foreach.remesas_anexo.iteration > 5}
	 
	   {if $cont eq 1}
	     <page orientation="paysage">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td colspan="3"><table  border="0" cellpadding="0" cellspacing="0" width="100%">
				  <tr>
					<td width="242" align="left"><img src="../../../framework/media/images/general/logoclienteacceso.png" width="160" height="42" />&nbsp; <img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" /> </td>
					<td width="400">MINISTERIO DE TRANSPORTE ANEXO 1 FORMATO &Uacute;NICO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
					<td width="53" align="center">&nbsp;</td>
					<td width="280" valign="top" align="right"><table cellspacing="0" cellpadding="0" align="right">
						<tr >
						  <td rowspan="3" ><img src="../../../framework/media/images/general/ministeriotransporte.jpg" height="42" />&nbsp;&nbsp;&nbsp;</td>
						  <td  class="title">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
						</tr>
						<tr >
						  <td class="infogeneral">{$DATOSMANIFIESTO.manifiesto}</td>
						</tr>
						<tr >
						  <td>COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)</td>
						</tr>
					</table></td>
				  </tr>
				</table>
				</td>
			  </tr>
			  <tr>
				<td>
				<table cellspacing="0" cellpadding="0">
				  <tr >
					<td  colspan="6" class="title">DATOS DE LA EMPRESA</td>
				  </tr>
				  <tr>
					<td width="60"  class="cellLeft">EMPRESA:</td>
					<td width="250" class="cellRight">{$DATOSMANIFIESTO.razon_social}</td>
					<td width="40"  class="cellRight">SIGLA:</td>
					<td width="150" class="cellRight">{$DATOSMANIFIESTO.sigla}</td>
					<td width="50" class="cellRight">NIT:</td>
					<td width="80" class="cellRight">{$DATOSMANIFIESTO.numero_identificacion}</td>
				  </tr>
				  <tr >
					<td class="cellLeft">DIRECCI&Oacute;N:</td>
					<td class="cellRight">{$DATOSMANIFIESTO.direccion}</td>
					<td class="cellRight">CIUDAD:</td>
					<td class="cellRight">{$DATOSMANIFIESTO.ciudad}</td>
					<td class="cellRight">TEL&Eacute;FONO:</td>
					<td class="cellRight">{$DATOSMANIFIESTO.telefono}</td>
				  </tr>
				</table></td>
				<td><table cellspacing="0" cellpadding="0" >
				  <tr >
					<td  class="title" width="135">TIPO DE MANIFIESTO</td>
				  </tr>
				  <tr>
					<td class="infogeneral" height="17">{$DATOSMANIFIESTO.tipo_manifiesto}</td>
				  </tr>
				</table></td>
				<td><table cellspacing="0" cellpadding="0">
				  <tr>
					<td   class="cellTitle">N&Uacute;MERO INTERNO  EMPRESA TRANSPORTE</td>
				  </tr>
				  <tr>
					<td  class="infogeneral" height="17">{$DATOSMANIFIESTO.codigo_empresa}</td>
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
        <td rowspan="4" class="cellLeft" align="center">{$ra.numero_remesa}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.medida}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.cantidad}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.naturaleza}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.empaque}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.producto}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.descripcion_producto}</td>
          <td class="cellTitleRight">LUGAR DE ORIGEN</td>
          <td class="cellRight" width="80">{$ra.origen}</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$ra.propietario_mercancia}</td>
          <td class="cellRight">{$ra.numero_identificacion_propietario_mercancia}</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$ra.direccion_remitente|substr:0:37}</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$ra.remitente}</td>
          <td class="cellRight">{$ra.doc_remitente}</td>
        </tr>
        <tr >
          <td class="cellTitleRight">LUGAR DE DESTINO</td>
          <td class="cellRight">{$ra.destino}</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$ra.destinatario}</td>
          <td class="cellRight">{$ra.doc_destinatario}</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$ra.direccion_destinatario|substr:0:37}</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$ra.aseguradora|substr:0:26}</td>
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$ra.numero_poliza}</td>
          <td class="cellRight">{$ra.nit_aseguradora}</td>
	    </tr>			 
			
	   {else}
	   <tr>
        <td rowspan="4" class="cellLeft" align="center">{$ra.numero_remesa}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.medida}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.cantidad}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.naturaleza}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.empaque}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.producto}</td>
          <td rowspan="4" class="cellRight" align="center">{$ra.descripcion_producto}</td>
          <td class="cellTitleRight">LUGAR DE ORIGEN</td>
          <td class="cellRight" width="80">{$ra.origen}</td>
          <td class="cellRight">&nbsp;PROPIETARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$ra.propietario_mercancia}</td>
          <td class="cellRight">{$ra.numero_identificacion_propietario_mercancia}</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$ra.direccion_remitente|substr:0:37}</td>
          <td class="cellRight">&nbsp;REMITENTE&nbsp;</td>
          <td colspan="3" class="cellRight">{$ra.remitente}</td>
          <td class="cellRight">{$ra.doc_remitente}</td>
        </tr>
        <tr >
          <td class="cellTitleRight">LUGAR DE DESTINO</td>
          <td class="cellRight">{$ra.destino}</td>
          <td class="cellRight">&nbsp;DESTINATARIO&nbsp;</td>
          <td colspan="3" class="cellRight">{$ra.destinatario}</td>
          <td class="cellRight">{$ra.doc_destinatario}</td>
        </tr>
        <tr >
          <td class="cellTitleRight">DIRECCI&Oacute;N</td>
          <td class="cellRight">{$ra.direccion_destinatario|substr:0:37}</td>
          <td class="cellRight">&nbsp;C&Iacute;A. DE SEGUROS&nbsp;</td>
          <td class="cellRight">{$ra.aseguradora|substr:0:26}</td>
          <td class="cellRight">&nbsp;POLIZA No.&nbsp;</td>
          <td class="cellRight">{$ra.numero_poliza}</td>
          <td class="cellRight">{$ra.nit_aseguradora}</td>
	    </tr>	    	   	
	   {/if}
	 	 
   	   {if $cont eq $contTot or $smarty.foreach.remesas_anexo.iteration eq count($DATOSREMESASANEXO) or $cont eq 11}
	      </table>
          </page>
         {assign var="cont" value="1"}
	   {else}
	       {assign var="cont" value=$cont+1}
	   {/if}	   
	   	 
	 {/if}  
  
  {/foreach}
  

{/if}

{if count($HOJADETIEMPOS) > 0}
<page orientation="paysage" backtop="0mm" backbottom="0mm" backleft="5mm" backright="0mm">
<table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1">
  <tr>
    <td colspan="3" rowspan="3" align="left" valign="top"><img src="../../../framework/media/images/general/logoclienteacceso.png" width="160" height="42" />&nbsp;<img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" /></td>
    <td colspan="5" rowspan="3" align="center">HOJA DE TIEMPOS </td>
    <td colspan="3" align="center">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
    </tr>
  <tr>
    <td colspan="3" align="center">{$DATOSMANIFIESTO.manifiesto}</td>
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
        <td  height="17" align="center">{$DATOSMANIFIESTO.codigo_empresa}</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>EMPRESA:</td>
    <td colspan="2">{$DATOSMANIFIESTO.razon_social}</td>
    <td>SIGLA:</td>
    <td colspan="2">{$DATOSMANIFIESTO.sigla}</td>
    <td>NIT:</td>
    <td>{$DATOSMANIFIESTO.numero_identificacion_empresa}</td>
    <td rowspan="2" align="center">{$DATOSMANIFIESTO.tipo_manifiesto}</td>
    </tr>
  <tr>
    <td>DIRECCI&Oacute;N:</td>
    <td colspan="2">{$DATOSMANIFIESTO.direccion}</td>
    <td>CIUDAD:</td>
    <td colspan="2">{$DATOSMANIFIESTO.ciudad}</td>
    <td>TEL&Eacute;FONO:</td>
    <td>{$DATOSMANIFIESTO.telefono}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[0].numero_remesa}</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].horas_pactadas_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].fecha_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].fecha_salida_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_salida_lugar_cargue}</td>
    <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[0].entrega}</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[0].cedula_entrega}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[0].horas_pactadas_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[0].fecha_llegada_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_llegada_lugar_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[0].fecha_salida_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[0].hora_salida_lugar_descargue}</td>
    <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[0].cedula_recibe}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[1].numero_remesa}</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].horas_pactadas_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].fecha_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].fecha_salida_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_salida_lugar_cargue}</td>
    <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[1].entrega}</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[1].cedula_entrega}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[1].horas_pactadas_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[1].fecha_llegada_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_llegada_lugar_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[1].fecha_salida_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[1].hora_salida_lugar_descargue}</td>
    <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[1].cedula_recibe}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[2].numero_remesa}</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].horas_pactadas_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].fecha_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].fecha_salida_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_salida_lugar_cargue}</td>
    <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[2].entrega}</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[2].cedula_entrega}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[2].horas_pactadas_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[2].fecha_llegada_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_llegada_lugar_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[2].fecha_salida_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[2].hora_salida_lugar_descargue}</td>
    <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[2].cedula_recibe}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="6">{$HOJADETIEMPOS[3].numero_remesa}</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].horas_pactadas_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].fecha_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_llegada_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].fecha_salida_lugar_cargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_salida_lugar_cargue}</td>
    <td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;{$HOJADETIEMPOS[3].entrega}</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[3].cedula_entrega}</td>
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
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
    <td>&nbsp;HORA&nbsp;</td>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
    <td>&nbsp;C.C.:&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">{$HOJADETIEMPOS[3].horas_pactadas_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[3].fecha_llegada_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_llegada_lugar_descargue}</td>
    <td rowspan="2">&nbsp;{$HOJADETIEMPOS[3].fecha_salida_lugar_descargue}</td>
    <td rowspan="2">{$HOJADETIEMPOS[3].hora_salida_lugar_descargue}</td>
    <td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
    <td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
    <td>&nbsp;C.C.:&nbsp;{$HOJADETIEMPOS[3].cedula_recibe}</td>
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
</page>
{/if}


{if count($HOJADETIEMPOSASANEXO) > 4}


  {assign var="cont2"    value="1"}
  {assign var="contTot2" value="$TOTALHOJADETIEMPOS"}  

  {foreach name=hoja_tiempos_anexo from=$HOJADETIEMPOSASANEXO item=ht}
  
     {if $smarty.foreach.hoja_tiempos_anexo.iteration > 5}
	 
	   {if $cont2 eq 1}
<page orientation="paysage" backtop="0mm" backbottom="0mm" backleft="5mm" backright="0mm">
<table style="margin:0px 0px 0px 0px"  cellpadding="0" cellspacing="0" border="1">
  <tr>
    <td colspan="3" rowspan="3" align="left" valign="top"><img src="../../../framework/media/images/general/logoclienteacceso.png" width="160" height="42" />&nbsp;<img src="../../../framework/media/images/general/Logo_BASC.jpg" width="" height="42" /></td>
    <td colspan="5" rowspan="3" align="center">HOJA DE TIEMPOS </td>
    <td colspan="3" align="center">N&Uacute;MERO MANIFIESTO ELECTR&Oacute;NICO DE CARGA</td>
    </tr>
  <tr>
    <td colspan="3" align="center">{$DATOSMANIFIESTO.manifiesto}</td>
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
        <td  height="17" align="center">{$DATOSMANIFIESTO.codigo_empresa}</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>EMPRESA:</td>
    <td colspan="2">{$DATOSMANIFIESTO.razon_social}</td>
    <td>SIGLA:</td>
    <td colspan="2">{$DATOSMANIFIESTO.sigla}</td>
    <td>NIT:</td>
    <td>{$DATOSMANIFIESTO.numero_identificacion_empresa}</td>
    <td rowspan="2" align="center">{$DATOSMANIFIESTO.tipo_manifiesto}</td>
    </tr>
  <tr>
    <td>DIRECCI&Oacute;N:</td>
    <td colspan="2">{$DATOSMANIFIESTO.direccion}</td>
    <td>CIUDAD:</td>
    <td colspan="2">{$DATOSMANIFIESTO.ciudad}</td>
    <td>TEL&Eacute;FONO:</td>
    <td>{$DATOSMANIFIESTO.telefono}</td>
    </tr>
  <tr>
    <td colspan="11" align="center">PLAZOS Y TIEMPOS </td>
  </tr>
		  {else}	   
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
			<td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
			<td>&nbsp;HORA&nbsp;</td>
			<td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
			<td>&nbsp;HORA&nbsp;</td>
			<td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
			<td>&nbsp;C.C.:&nbsp;</td>
		  </tr>
		  <tr>
			<td rowspan="6">{$ht.numero_remesa}</td>
			<td rowspan="2">{$ht.horas_pactadas_cargue}</td>
			<td rowspan="2">{$ht.fecha_llegada_lugar_cargue}</td>
			<td rowspan="2">{$ht.hora_llegada_lugar_cargue}</td>
			<td rowspan="2">{$ht.fecha_salida_lugar_cargue}</td>
			<td rowspan="2">{$ht.hora_salida_lugar_cargue}</td>
			<td rowspan="2">QUIEN  ENTREGA&nbsp;</td>
			<td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;NOMBRE:&nbsp;{$ht.entrega}</td>
			<td>&nbsp;C.C.:&nbsp;{$ht.cedula_entrega}</td>
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
			<td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
			<td>&nbsp;HORA&nbsp;</td>
			<td>&nbsp;FECHA&nbsp;    (AAAA/MM/DD)&nbsp;</td>
			<td>&nbsp;HORA&nbsp;</td>
			<td colspan="2">&nbsp;NOMBRE:&nbsp;</td>
			<td>&nbsp;C.C.:&nbsp;</td>
		  </tr>
		  <tr>
			<td rowspan="2">{$ht.horas_pactadas_descargue}</td>
			<td rowspan="2">&nbsp;{$ht.fecha_llegada_lugar_descargue}</td>
			<td rowspan="2">{$ht.hora_llegada_lugar_descargue}</td>
			<td rowspan="2">&nbsp;{$ht.fecha_salida_lugar_descargue}</td>
			<td rowspan="2">{$ht.hora_salida_lugar_descargue}</td>
			<td rowspan="2">&nbsp;QUIEN    RECIBE&nbsp;</td>
			<td colspan="3" height="15">&nbsp;FIRMA:&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;NOMBRE:&nbsp;recibe</td>
			<td>&nbsp;C.C.:&nbsp;{$ht.cedula_recibe}</td>
		  </tr>	   
	      {/if}
	 	 
   	   {if $cont2 eq $contTot2 or $smarty.foreach.hoja_tiempos_anexo.iteration eq count($HOJADETIEMPOSASANEXO) or $cont2 eq 5}
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
          </page>
         {assign var="cont2" value="1"}
	   {else}
	       {assign var="cont2" value=$cont2+1}
	   {/if}	   
	   	 
	 {/if}  
  
  {/foreach}
  

{/if}	   