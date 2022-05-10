<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
  {$JAVASCRIPT} 
  {$TABLEGRIDJS}  
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB} 
</head>
 <body>
<fieldset>
 <table>
  <tbody>
    <tr>
      <td> {$TITLEFORM}</td>
      <td> <a href="https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx" target="_blank" title="Consulta de Antecedes Disciplinarios"> <img src="../../../framework/media/images/general/procuraduria_logo.jpg" title="Consulta de Antecedes Disciplinarios" height="30" width="30"> </a>
      </td>
      <td> <a href="http://web.mintransporte.gov.co/Consultas/transito/Consulta23122010.htm" target="_blank" title="Consulta Ministerio de Transporte"> <img src="../../../framework/media/images/general/ministeriotransporte.jpg" title="Consulta Ministerio de Transporte" height="30" width="30"> </a>
      </td>
      <td> <a href="http://190.84.240.175/cera/" target="_blank" title="Consulta Asecarga"> <img src="../../../framework/media/images/general/A1_ASECARGA_normal.jpg" title="Consulta Asecarga" height="30" width="30"> </a> </td>
      <td> <a href="http://www.simit.org.co/Simit/" target="_blank" title="Consulta Simit"> <img src="../../../framework/media/images/general/simit.jpg" title="Consulta Simit" height="30" width="30"> </a>
	  
	  <a href="https://muisca.dian.gov.co/WebRutMuisca/DefConsultaEstadoRUT.faces" target="_blank" title="Consulta Simit"> <img src="../../../framework/media/images/general/dian.jpg" title="Consulta Muisca" height="30" width="30"> </a>
	  
	  <a href="http://antecedentes.policia.gov.co:7003/WebJudicial/index.xhtml" target="_blank" title="Consulta Antecedentes Judiciales"><img src="../../../framework/media/images/general/policianacional.jpg" title="Consulta Antecedentes Judiciales" height="30" width="30"></a>
	   </td>
	  
	  
	  
    </tr>
  </tbody>
</table>
<div id="table_find">
<table>
  <tbody>
    <tr>
      <td><label>Busqueda : </label></td>
      <td>{$BUSQUEDA}</td>
    </tr>
  </tbody>
</table>
</div>
{$FORM1}
<fieldset class="section"><legend>INFORMACION DEL CONDUCTOR</legend>
<table align="center">
  <tbody>
    <tr>    </tr>
    <tr>
      <td><label>Tipo Identificacion :</label></td>
      <td>{$TIPOPERSONA}{$TIPOIDENTIFICACION}</td>
      <td><label>Identificacion :</label></td>
      <td style="vertical-align: top;">{$NUMEROIDENTIFICACION}{$CONDUCTORID}{$TERCEROID}</td>
      <td style="vertical-align: top;"><label>Expedida En :</label></td>
      <td>{$LUGAREXPEDICION}<br>      </td>
    </tr>
    <tr>
      <td><label>Primer Nombre :</label></td>
      <td>{$PRIMERNOMBRE}</td>
      <td><label>Segundo Nombre : </label></td>
      <td style="vertical-align: top;">{$OTROSNOMBRES}</td>
      <td style="vertical-align: top;"><label>Primer Apellido :</label></td>
      <td>{$PRIMERAPELLIDO}</td>
    </tr>
    <tr>
      <td><label>Segundo Apellido :</label></td>
      <td>{$SEGUNDOAPELLIDO}</td>
      <td><label>Fecha Nacimiento :</label></td>
      <td style="vertical-align: top;">{$FECHANACIMIENTO} </td>
      <td style="vertical-align: top;"><label>Edad :</label></td>
      <td>{$EDAD} <span class="description">Años</span> </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Estatura :</label></td>
      <td style="vertical-align: top;">{$ESTATURA}<br>      </td>
      <td style="vertical-align: top;"><label>Tipo Sangre :</label></td>
      <td style="vertical-align: top;">{$TIPOSANGRE}</td>
      <td style="vertical-align: top;"><label>Señales Particulares :</label></td>
      <td colspan="1" rowspan="2" style="vertical-align: top;">{$SENALES}<br>      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><br>      </td>
      <td style="vertical-align: top;"><br>      </td>
      <td style="vertical-align: top;"><br>      </td>
      <td style="vertical-align: top;"><br>      </td>
      <td style="vertical-align: top;"><br>      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Libreta Militar : </label></td>
      <td style="vertical-align: top;">{$LIBRETAMILITAR}</td>
      <td style="vertical-align: top;"><label>EPS : </label></td>
      <td style="vertical-align: top;">{$EPS}</td>
      <td style="vertical-align: top;"><label>ARP : </label></td>
      <td style="vertical-align: top;">{$ARP}</td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Licencia de Conduccion :</label></td>
      <td style="vertical-align: top;">{$NUMEROLICENCIA}</td>
      <td style="vertical-align: top;"><label>Categoria Licencia :</label>       </td>
      <td style="vertical-align: top;">{$CATEGORIALICENCIA}</td>
      <td style="vertical-align: top;"><label>Fecha Vencimiento :</label>      </td>
      <td style="vertical-align: top;">{$VENCIMIENTOLICENCIA}</td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Tipo Residencia :</label></td>
      <td style="vertical-align: top;">{$TIPOVIVIENDA}</td>	
      <td style="vertical-align: top;"><label>Ciudad Residencia : </label></td>
      <td style="vertical-align: top;">{$UBICACION}{$UBICACIONID}</td>
      <td style="vertical-align: top;"><label>Direccion Residencia :</label></td>
      <td style="vertical-align: top;">{$DIRECCIONRESIDENCIA}</td>
    </tr>
	

    <tr>
      <td><label>Barrio :</label>
      <label></label></td>
      <td><span style="vertical-align: top;">{$BARRIO}</span><br>      </td>
      <td><label></label><label><span style="vertical-align: top;">Telefono Fijo : </span></label></td>
      <td style="vertical-align: top;">{$TELEFONOFIJO}<br>      </td>
      <td style="vertical-align: top;"><label>Celular : </label></td>
      <td>{$TELEFONOCELULAR}</td>
    </tr>
	
    <tr>
      <td><label>Antiguedad en Vivienda :</label></td>
      <td><span style="vertical-align: top;">{$ANTIGUEDADVIVIENDA} <span class="description">Meses</span></span></td>
      <td><label>Telefono Arrendatario :</label>
        <br></td>
      <td><span style="vertical-align: top;">{$TELEFONOARRENDATARIO}<br>
      </span></td>
      <td style="vertical-align: top;"><label>Nombre Arrendatario :</label></td>
      <td>{$ARRENDATARIO}&nbsp;</td>
    </tr>
    <tr>
      <td><label><span style="vertical-align: top;">Estado Civil : </span></label></td>	
      <td style="vertical-align: top;">{$ESTADOCIVIL} </td>
      <td><label>Personas a Cargo :</label></td>
      <td><span style="vertical-align: top;">{$PERSONASACARGO}<br></span></td>	  
      <td style="vertical-align: top;"><label>Nombre Compañero/a : </label></td>
      <td>{$NOMBRECOMPANERO} </td>
    </tr>
    <tr>
      <td><label>N° Hijos :</label></td>
      <td>{$NUMEROHIJOS}</td>
      <td><label>Estado :</label></td>
      <td>{$ESTADO}&nbsp;</td>
    </tr>
  </tbody>
</table>
</fieldset>
<fieldset class="section">
<legend>ARCHIVOS DE IMAGEN :</legend>
<table width="100%">
  <tbody>
    <tr>
	  <td><label>Foto :</label></td>
	  <td colspan="3">{$FOTO}</td>
	</tr>
    <tr>
      <td style="width: 119px;"><label>Documentos Identificacion :</label></td>
      <td style="width: 200px;">{$CEDULAESCAN}</td>
      <td style="vertical-align: top; width: 93px;"><label>Documentos Verificacion : </label></td>
      <td style="vertical-align: top; width: 233px;">{$LICENCIAESCAN}</td>
    </tr>
	
    <tr style="display:none">
      <td style="width: 119px;"><label>Antecedentes Judiciales : </label></td>
      <td style="width: 234px;">{$PASADOESCAN}</td>
      <td style="vertical-align: top; width: 93px;"><label>Carnet EPS :
      </label></td>
      <td style="vertical-align: top; width: 233px;">{$EPSESCAN}</td>
    </tr>
    <tr style="display:none">
      <td style="vertical-align: top;"><label>Licencia :</label></td>
      <td style="vertical-align: top;">{$LICENDIAESCAN}</td>
      <td style="vertical-align: top;"><label>Carnet ARP : </label></td>
      <td style="vertical-align: top;">{$ARPESCAN}</td>
    </tr>
	
    <tr>
      <td style="vertical-align: top;"><label>Huella Indice Izquierdo :
      </label></td>
      <td style="vertical-align: top;">{$HUELLAINDICEIZQ}</td>
      <td style="vertical-align: top;"><label>Huella
Pulgar Izquierdo : </label></td>
      <td style="vertical-align: top;">{$HUELLAPULGARIZQ}</td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Huella
Pulgar Der :</label></td>
      <td style="vertical-align: top;">{$HUELLAPULGARDER}</td>
      <td style="vertical-align: top;"><label>Huella
Indice Der :</label></td>
      <td style="vertical-align: top;">{$HUELLAINDICEDER}</td>
    </tr>
  </tbody>
</table>
</fieldset>
<fieldset class="section"> <legend>EMPRESAS POR LAS CUALES HA CARGADO</legend>
<table>
  <tbody>
    <tr>
	  <td><label>Cargo Primera Vez :</label></td>
	  <td colspan="5">{$CARGAPRIMERAVEZ}</td>
	</tr>
    <tr>
      <td style="width: 263px;"><label>1. Empresa : </label></td>
      <td style="width: 134px;">{$EMPRESACARGO1}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>CIudad :</label></td>
      <td style="vertical-align: top; width: 179px;">{$CIUDADEMPRESACARGO1TXT}{$CIUDADEMPRESACARGO1}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Telefono :</label></td>
      <td style="width: 135px;" colspan="4">{$TELEFONOEMPRESACARGO1}<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 263px;"><label>Nombre
Persona que Atendio : </label></td>
      <td style="vertical-align: top; width: 134px;">{$NOMBREPERSONAATENDIO1}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>Cargo :</label></td>
      <td style="vertical-align: top; width: 179px;">{$CARGOPERSONAATENDIO1}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Cuanto
Tiempo Lleva Cargando :</label></td>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 135px;">{$TIEMPOLLEVACARGANDO1}<span>Meses</span>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 263px;"><label>En que
rutas :</label></td>
      <td style="vertical-align: top; width: 134px;">{$RUTAS1}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>Que Tipo de
Mercancia :</label></td>
      <td style="vertical-align: top; width: 179px;">{$TIPOMERCANCIA1}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Cuantos
Viajes ha realizado : </label></td>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 135px;">{$VIAJESREALIZADOS1}<br>
      </td>
    </tr>
    <tr>
      <td style="width: 263px;"><br>
      </td>
      <td style="width: 134px;"><br>
      </td>
      <td style="vertical-align: top; width: 165px;"><br>
      </td>
      <td style="vertical-align: top; width: 179px;"><br>
      </td>
      <td style="vertical-align: top; width: 328px;"><br>
      </td>
      <td style="width: 135px;" colspan="4"><br>
      </td>
    </tr>
    <tr>
      <td style="width: 263px;"><label>2. Empresa : </label></td>
      <td style="width: 134px;">{$EMPRESACARGO2}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>CIudad :</label></td>
      <td style="vertical-align: top; width: 179px;">{$CIUDADEMPRESACARGO2TXT}{$CIUDADEMPRESACARGO2}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Telefono :</label></td>
      <td style="width: 135px;" colspan="4">{$TELEFONOEMPRESACARGO2}<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 263px;"><label>Nombre
Persona que Atendio : </label></td>
      <td style="vertical-align: top; width: 134px;">{$NOMBREPERSONAATENDIO2}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>Cargo :</label></td>
      <td style="vertical-align: top; width: 179px;">{$CARGOPERSONAATENDIO2}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Cuanto
Tiempo Lleva Cargando :</label></td>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 135px;">{$TIEMPOLLEVACARGANDO2}<span>Meses</span>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 263px;"><label>En que
rutas :</label></td>
      <td style="vertical-align: top; width: 134px;">{$RUTAS2}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>Que Tipo de
Mercancia :</label></td>
      <td style="vertical-align: top; width: 179px;">{$TIPOMERCANCIA2}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Cuantos
Viajes ha realizado : </label></td>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 135px;">{$VIAJESREALIZADOS2}<br>
      </td>
    </tr>
    <tr>
      <td style="width: 263px;"><br>
      </td>
      <td style="width: 134px;"><br>
      </td>
      <td style="vertical-align: top; width: 165px;"><br>
      </td>
      <td style="vertical-align: top; width: 179px;"><br>
      </td>
      <td style="vertical-align: top; width: 328px;"><br>
      </td>
      <td style="width: 135px;" colspan="4"><br>
      </td>
    </tr>
    <tr>
      <td style="width: 263px;"><label>3. Empresa : </label></td>
      <td style="width: 134px;">{$EMPRESACARGO3}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>CIudad :</label></td>
      <td style="vertical-align: top; width: 179px;">{$CIUDADEMPRESACARGO3TXT}{$CIUDADEMPRESACARGO3}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Telefono :</label></td>
      <td style="width: 135px;" colspan="4">{$TELEFONOEMPRESACARGO3}<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 263px;"><label>Nombre
Persona que Atendio : </label></td>
      <td style="vertical-align: top; width: 134px;">{$NOMBREPERSONAATENDIO3}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>Cargo :</label></td>
      <td style="vertical-align: top; width: 179px;">{$CARGOPERSONAATENDIO3}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Cuanto
Tiempo Lleva Cargando :</label></td>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 135px;">{$TIEMPOLLEVACARGANDO3}<span>Meses</span>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 263px;"><label>En que
rutas :</label></td>
      <td style="vertical-align: top; width: 134px;">{$RUTAS3}<br>
      </td>
      <td style="vertical-align: top; width: 165px;"><label>Que Tipo de
Mercancia :</label></td>
      <td style="vertical-align: top; width: 179px;">{$TIPOMERCANCIA3}<br>
      </td>
      <td style="vertical-align: top; width: 328px;"><label>Cuantos
Viajes ha realizado : </label></td>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 135px;">{$VIAJESREALIZADOS3}<br>
      </td>
    </tr>
    <tr>
      <td style="width: 263px;"><br>
      </td>
      <td style="width: 134px;"><br>
      </td>
      <td style="vertical-align: top; width: 165px;"><br>
      </td>
      <td style="vertical-align: top; width: 179px;"><br>
      </td>
      <td style="vertical-align: top; width: 328px;"><br>
      </td>
      <td style="width: 135px;" colspan="4"><br>
      </td>
    </tr>
  </tbody>
</table>
</fieldset>
<fieldset class="section"> <legend>REFERENCIAS FAMILIARES</legend>
<table width="100%">
  <tbody>
    <tr>
      <td style="vertical-align: top; width: 189px;"><label>1. Persona :</label></td>
      <td style="vertical-align: top; width: 252px;">{$REFERENCIA1}<br>
      </td>
      <td style="vertical-align: top; width: 119px;"><label>Ciudad :</label></td>
      <td style="vertical-align: top; width: 259px;">{$CIUDADREFERENCIA1TXT}{$CIUDADREFERENCIA1}<br>
      </td>
      <td style="vertical-align: top; width: 138px;"><label>Telefono :</label></td>
      <td style="width: 243px;">{$TELEFONOREFERENCIA1}</td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 189px;"><label>2. Persona :</label></td>
      <td style="vertical-align: top; width: 252px;">{$REFERENCIA2}<br>
      </td>
      <td style="vertical-align: top; width: 119px;"><label>Ciudad :</label></td>
      <td style="vertical-align: top; width: 259px;">{$CIUDADREFERENCIA2TXT}{$CIUDADREFERENCIA2}<br>
      </td>
      <td style="vertical-align: top; width: 138px;"><label>Telefono :</label></td>
      <td style="width: 243px;">{$TELEFONOREFERENCIA2}</td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 189px;"><label>3. Persona :</label></td>
      <td style="vertical-align: top; width: 252px;">{$REFERENCIA3}<br>
      </td>
      <td style="vertical-align: top; width: 119px;"><label>Ciudad :</label></td>
      <td style="vertical-align: top; width: 259px;">{$CIUDADREFERENCIA3TXT}{$CIUDADREFERENCIA3}<br>
      </td>
      <td style="vertical-align: top; width: 138px;"><label>Telefono :</label></td>
      <td style="width: 243px;">{$TELEFONOREFERENCIA3}</td>
    </tr>
  </tbody>
</table>
</fieldset>
<fieldset>
<table width="100%">
  <tbody>
    <tr>
      <td style="width: 135px;" colspan="9" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}</td>
    </tr>
  </tbody>
</table>
</fieldset>
{$FORM1END} </fieldset>

<fieldset>{$GRIDCONDUCTORES}</fieldset>

</body></html>