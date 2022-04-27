<html>

  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link type="text/css" rel="stylesheet" href="../../../framework/css/printer.css" />  
    <script language="javascript" type="text/javascript" src="../../../framework/js/printer.js"></script>
    <title>Impresion Vehiculo</title>	
	{literal}
	 <style>
	   .borderTop{
	     border-top:1px solid;
	   }
	 </style>
	{/literal}
  </head>
  
<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="40%" rowspan="4" align="center" class="cellLeft" style="border-top:1px solid">Documento confidencial propiedad de COMPAÑÍA<br>
          TRANSPORTADORA transAlejandria / Elaborado por<br>SQHSE transAlejandria /Bajo LA Norma BASC<br>Versión 4 de 2012 / Funza 2012</td>
        <td width="15%" rowspan="4" align="center" class="cellRight" style="border-top:1px solid">HOJA DE VIDA VEHÍCULO</td>
        <td width="15%" rowspan="4" align="center" class="cellRight" style="border-top:1px solid"><img src="{$DATOSVEHICULO.archivo_imagen_frontal}" width="180" height="80" /></td>  
        <td width="15%" rowspan="4" align="center" class="cellRight" style="border-top:1px solid"><img src="{$DATOSVEHICULO.logo}" width="180" height="80" /></td>
        <td width="15%" class="cellRight" style="border-top:1px solid">Código: FT 1-1</td>
      </tr>
      <tr>
        <td class="cellRight">Versión: 4</td>
      </tr>
      <tr>
        <td class="cellRight">Vigencia:</td>
      </tr>
      <tr>
        <td align="center" class="cellRight">Pág 1 de 2</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="cellTitle">DATOS DEL VEHÍCULO (SEGÚN TARJETA DE PROPIEDAD)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="12%" class="cellLeft"><label>PLACA :</label><div>{$DATOSVEHICULO.placa}</div></td>
        <td width="18%" class="cellRight"><label>CONFIGURACION :</label><div>{$DATOSVEHICULO.configuracion}</div></td>
        <td width="21%" class="cellRight"><label>TIPO VEHICULO :</label><div>{$DATOSVEHICULO.tipo_vehiculo}</div></td>
        <td width="9%" class="cellRight"><label>N&deg; EJES :</label><div>{$DATOSVEHICULO.numero_ejes}</div></td>
        <td width="18%" class="cellRight"><label>CAPACIDAD KLS :</label><div>{$DATOSVEHICULO.capacidad}</div></td>
        <td width="22%" class="cellRight"><label>PESO VACIO KLS :</label><div>{$DATOSVEHICULO.peso_vacio}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>MARCA :</label><div>{$DATOSVEHICULO.marca}</div></td>
        <td class="cellRight"><label>LINEA :</label><div>{$DATOSVEHICULO.linea}</div></td>
        <td colspan="2" class="cellRight"><label>COLOR:</label><div>{$DATOSVEHICULO.color}</div></td>
        <td class="cellRight"><label>MODELO : </label><div>{$DATOSVEHICULO.modelo_vehiculo}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>REPOTENCIADO :</label><div>{$DATOSVEHICULO.modelo_repotenciado}</div> </td>
        <td class="cellRight"><label>TIPO COMBUSTIBLE  : </label><div>{$DATOSVEHICULO.tipo_combustible}</div></td>
        <td colspan="2" class="cellRight"><label>N&deg; MOTOR : </label><div>{$DATOSVEHICULO.motor}</div></td>
        <td class="cellRight"><label>N&deg; CHASIS : </label><div>{$DATOSVEHICULO.chasis}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>TIPO CARROCERIA : </label><div>{$DATOSVEHICULO.carroceria}</div></td>
        <td class="cellRight"><label>TARJETA PROPIEDAD : /<div>{$DATOSVEHICULO.tarjeta_propiedad}</div></td>
        <td colspan="2" class="cellRight"><label>PLACA REMOLQUE : </label><div>{$DATOSVEHICULO.placa_remolque}</div></td>
        <td class="cellRight"><label>MARCA REMOLQUE : </label><div>{$DATOSVEHICULO.marca_remolque}</div></td>
      </tr>
      <tr>
        <td class="cellLeft"><label>MODELO REMOLQUE: </label><div>{$DATOSVEHICULO.modelo_remolque}</div></td>
        <td class="cellRight"><label>CONFIGURACION REMOLQUE: </label>
        <div>{$DATOSVEHICULO.tipo_remolque}</div></td>
        <td colspan="2" class="cellRight"><label>AFILIADO A: </label><div>{$DATOSVEHICULO.empresa_afiliado}</div></td>
        <td class="cellRight"><label>CARNET N&deg; :</label><div>{$DATOSVEHICULO.numero_carnet}</div> </td>
        <td class="cellRight"><label>VENCE : </label><div>{$DATOSVEHICULO.vencimiento_afiliacion}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>CIUDAD : </label><div>{$DATOSVEHICULO.ciudad_vehiculo}</div></td>
        <td class="cellRight"><label>TEL&Eacute;FONO : </label><div>{$DATOSVEHICULO.telefono_vehiculo}</div></td>
        <td colspan="2" class="cellRight"><label>POLIZA SOAT N&deg; : </label><div>{$DATOSVEHICULO.numero_soat}</div></td>
        <td class="cellRight"><label>VENCIMIENTO SOAT : </label><div>{$DATOSVEHICULO.vencimiento_soat}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>ASEGURADORA SOAT : </label><div>{$DATOSVEHICULO.asegura_soat}</div></td>
        <td colspan="3" class="cellRight"><label>REVISION TECNICOMECANICA Y GASES : </label><div>{$DATOSVEHICULO.tecnomecanico_vehiculo}</div></td>
        <td class="cellRight"><label>VIGENCIA : </label><div>{$DATOSVEHICULO.vencimiento_tecno_vehiculo}</div></td>
      </tr>
      <tr>
        <td colspan="3" class="cellLeft"><label>REGISTRO NACIONAL DE CARGA : </label><div>{$DATOSVEHICULO.registro_nacional_carga}</div></td>
        <td colspan="3" class="cellRight"><label>RESOLUCION DE EXP : </label><div>{$DATOSVEHICULO.resolucion_expedicion}</div></td>
        </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>PROVEEDOR GPS : </label><div>{$DATOSVEHICULO.monitoreo_satelital}</div></td>
        <td class="cellRight"><label>LINK : </label><div>{$DATOSVEHICULO.link_monitoreo_satelital}</div></td>
        <td colspan="2" class="cellRight"><label>USUARIO : </label><div>{$DATOSVEHICULO.usuario}</div></td>
        <td class="cellRight"><label>CONTRASE&Ntilde;A : </label><div>{$DATOSVEHICULO.password}</div></td>
      </tr>
      <tr>
        <td colspan="6" align="center" class="cellTitle">DATOS PROPIETARIO VEHICULO </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="72%" colspan="3" class="cellLeft"><label>NOMBRE DEL PROPIETARIO DEL VEHÍCULO:</label><div>{$DATOSVEHICULO.propietario}</div></td>
        <td width="28%" class="cellRight"><label>TIPO PERSONA:</label><div>{$DATOSVEHICULO.tipo_persona_propietario}</div></td>
      </tr>
      <tr>
        <td class="cellLeft"><label>CÉDULA o NIT No.</label><div>{$DATOSVEHICULO.cedula_nit_propietario}</div></td>
        <td class="cellRight"><label>D.V.</label><div>{$DATOSVEHICULO.dv_nit_propietario}</div></td>
        <td class="cellRight"><label>TELÉFONO:</label><div>{$DATOSVEHICULO.telefono_propietario}</div></td>
        <td class="cellRight"><label>CELULAR:</label><div>{$DATOSVEHICULO.celular_propietario}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>DIRECCIÓN RESIDENCIA:</label><div>{$DATOSVEHICULO.direccion_propietario}</div></td>
        <td class="cellRight"><label>CIUDAD:</label><div>{$DATOSVEHICULO.ciudad_propietario}</div></td>
        <td class="cellRight"><label>Email:</label><div>{$DATOSVEHICULO.email_propietario}</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="cellTitle">POSEEDOR O TENEDOR DEL VEHÍCULO</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="72%" colspan="3" class="cellLeft"><label>NOMBRE DEL POSEEDOR O TENEDOR DEL VEH&Iacute;CULO :</label><div>{$DATOSVEHICULO.tenedor}</div></td>
        <td width="28%" class="cellRight"><label>TIPO PERSONA:</label><div>{$DATOSVEHICULO.tipo_persona_tenedor}</div></td>
      </tr>
      <tr>
	    <td class="cellLeft"><label>C&Eacute;DULA o NIT No.</label><div>{$DATOSVEHICULO.cedula_nit_tenedor}</div></td>
        <td class="cellRight"><label>D.V.</label><div>{$DATOSVEHICULO.dv_nit_tenedor}</div></td>
        <td class="cellRight"><label>TEL&Eacute;FONO:</label><div>{$DATOSVEHICULO.telefono_tenedor}</div></td>
        <td class="cellRight"><label>CELULAR:</label><div>{$DATOSVEHICULO.celular_tenedor}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>DIRECCI&Oacute;N RESIDENCIA:</label><div>{$DATOSVEHICULO.direccion_tenedor}</div></td>
        <td class="cellRight"><label>CIUDAD:<div>{$DATOSVEHICULO.ciudad_tenedor}</div></td>
        <td class="cellRight"><label>Email:</label><div>{$DATOSVEHICULO.email_tenedor}</div></td>
      </tr>
      <tr>
        <td colspan="2" class="cellLeft"><label>TIPO CUENTA BANCARIA:</label><div>{$DATOSVEHICULO.tipo_cuenta}</div></td>
        <td class="cellRight"><label>ENTIDAD BANCARIA:</label><div>{$DATOSVEHICULO.banco}</div></td>
        <td class="cellRight"><label>NUMERO DE CUENTA:</label><div>{$DATOSVEHICULO.numero_cuenta_tene}</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="infogeneral" align="center">FAVOR ANEXAR COPIA N&Iacute;TIDA DE LOS SIGUIENTES DOCUMENTOS<br />
(si los documentos no son claros no ser&aacute;n admitidos)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr align="center">
        <td colspan="2" class="cellLeft borderTop"><b>DOCUMENTOS CONDUCTOR</b></td>
        <td colspan="2" class="cellRight borderTop"><b>DOCUMENTOS PROPIETARIO</b></td>
        <td colspan="2" class="cellRight borderTop"><b>DOCUMENTOS VEHICULO</b></td>
      </tr>
      <tr>
        <td width="27%" class="cellLeft">Cédula del Conductor.</td>
        <td width="4%" class="cellRight"><div align="center">{$DATOSVEHICULO.archivo_cedula_conductor}</div></td>
        <td width="32%" class="cellRight">Tarjeta de Propiedad del Vehiculo. </td>
        <td width="4%" class="cellRight"><div align="center"></div></td>
        <td width="29%" class="cellRight">Registro Nacional de Carga. </td>
        <td width="4%" class="cellRight"><div align="center"></div></td>
      </tr>
      <tr>
        <td class="cellLeft">Licencia del Conductor.</td>
        <td class="cellRight"><div align="center"></div></td>
        <td class="cellRight">Cedula del propietario y/o tenedor.</td>
        <td class="cellRight"><div align="center"></div></td>
        <td class="cellRight">Registro Nacional de Remolque</td>
        <td class="cellRight"><div align="center"></div></td>
      </tr>
      <tr>
        <td class="cellLeft">Antecedentes judiciales</td>
        <td class="cellRight"><div align="center"></div></td>
        <td class="cellRight">Contrato del Leasing - Cuando aplique</td>
        <td class="cellRight"><div align="center"></div></td>
        <td class="cellRight">Revisión Tecnomecanica Vigente.</td>
        <td class="cellRight"><div align="center"></div></td>
      </tr>
      <tr>
        <td class="cellLeft">Afiliación a Riesgos Profesionales A.R.P.</td>
        <td class="cellRight"><div align="center"></div></td>
        <td class="cellRight">RUT Propietario ó Tenedor</td>
        <td class="cellRight"><div align="center"></div></td>
        <td class="cellRight">Afiliación a la Empresa de Transporte. </td>
        <td class="cellRight"><div align="center"></div></td>
      </tr>
      <tr>
        <td class="cellLeft">Afiliación al P.O.S. </td>
        <td class="cellRight"><div align="center"></div></td>
        <td colspan="2" class="cellRight">&nbsp;</td>
        <td class="cellRight">SOAT.</td>
        <td class="cellRight"><div align="center"></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="cellTitle">VERIFICACION DE DATOS</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr align="center">
        <td class="cellLeft">RESPONSABLE POR VERIFICACION</td>
        <td class="cellRight">NOMBRE PERSONA QUE ATENDIO</td>
        <td class="cellRight">TIPO DE VERIFICACION</td>
      </tr>
      <tr>
        <td class="cellLeft">1. <div>{$DATOSVEHICULO.responsable_verificacion1}</div></td>
        <td class="cellRight"><div>{$DATOSVEHICULO.nombre_persona_atendio1}</div></td>
        <td class="cellRight"><div>{$DATOSVEHICULO.tipo_verificacion1}</div></td>
      </tr>
      <tr>
        <td class="cellLeft">2.<div>{$DATOSVEHICULO.responsable_verificacion2}</div></td>
        <td class="cellRight"><div>{$DATOSVEHICULO.nombre_persona_atendio2}</div></td>
        <td class="cellRight"><div>{$DATOSVEHICULO.tipo_verificacion2}</div></td>
      </tr>
      <tr>
        <td class="cellLeft">3.<div>{$DATOSVEHICULO.responsable_verificacion3}</div></td>
        <td class="cellRight"><div>{$DATOSVEHICULO.nombre_persona_atendio3}</div></td>
        <td class="cellRight"><div>{$DATOSVEHICULO.tipo_verificacion3}</div></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td>
	  <table width="100%" border="0" cellpadding="2" cellspacing="0">
		  <tr>
			<td width="37%" class="cellLeft"><label>FECHA DE CONFIRMACION : </label><div>{$DATOSVEHICULO.fecha_confirmacion}</div></td>
			<td width="34%" class="cellRight" align="right"><label>APROBACION : </label></td>
			<td width="14%" class="cellRight" align="center">SI&nbsp;&nbsp;&nbsp;{if $DATOSVEHICULO.aprobacion eq 1}X{/if}</td>
			<td width="15%" class="cellRight" align="center">NO&nbsp;&nbsp;&nbsp;{if $DATOSVEHICULO.aprobacion eq 0}X{/if}</td>
		  </tr>	  
	  </table>
	</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="55%" class="cellLeft"><label>DOY CONSTANCIA QUE SE REALIZO LA VERIFICACIÓN DE ESTA HOJA DE VIDA SIGUIENDO EL <BR />
          PROCEDIMIENTO ESTABLECIDO POR EL ÁREA DE SEGURIDAD</label></td>
        <td width="45%" align="center" class="cellRight"><br><div>{$DATOSVEHICULO.responsable_verificacion1}</div><hr width="80%"><label>NOMBRE Y FIRMA DEL FUNCIONARIO</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="35%" class="cellLeft"><label>APROBO :</label> <b>{$DATOSVEHICULO.aprobo}</b></td>
        <td width="35%" class="cellRight"><label>REVISO :</label> <b>{$DATOSVEHICULO.reviso}</b></td>
        <td width="30%" class="cellRight"><label>USUARIO :</label> <b>{$DATOSVEHICULO.nombre_usuario}</b></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>