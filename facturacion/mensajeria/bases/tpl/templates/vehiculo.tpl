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
    <legend>{$TITLEFORM}</legend>

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
{$EMPRESAIDSTATIC}{$RESPONSABLEVERIFICACION1STATIC}{$RESPONSABLEVERIFICACION2STATIC}{$RESPONSABLEVERIFICACION3STATIC}{$FORM1}
<fieldset class="section"> <legend>DATOS VEHICULO (SEGÚN TARJETA DE
PROPIEDAD)</legend>
<table width="100%">
  <tbody>
    <tr>
      <td width="4%"><label>Placa :</label></td>
      <td colspan="3">{$PLACA}{$PLACAID}{$EMPRESAID}</td>
      <td width="5%"><label>Configuracion :</label></td>
      <td width="19%">{$CONFIGURACION}</td>
      <td width="5%"><label>Tipo de Vehiculo :</label></td>
      <td width="13%">{$TIPOVEHICULO}</td>
      <td width="5%"><label>N. Ejes :</label></td>
      <td width="19%">{$NUMEROEJES}</td>
    </tr>
    <tr>
      <td><label>Capacidad :</label></td>
      <td width="10%">{$CAPACIDADCARGA}</td>
      <td width="9%"><label>Unidad:</label></td>
      <td width="11%">{$UNIDADCAPACIDADCARGA}</td>
      <td><label>Peso Vacio Kls :</label></td>
      <td>{$PESOVACIO}<br>      </td>
      <td><label>Marca :</label></td>
      <td>{$MARCA}{$MARCAID}</td>
      <td><label>Linea :</label></td>
      <td>{$LINEA}{$LINEAID}</td>
    </tr>
    <tr>
      <td><label>Color :</label></td>
      <td colspan="3">{$COLOR}{$COLORID}</td>
      <td><label>Modelo :</label></td>
      <td>{$MODELO}</td>
      <td><label>Modelo Repotenciado :</label></td>
      <td>{$MODELOREPOTENCIADO}</td>
      <td><label></label>
      <label>Tipo Combustible :</label></td>
      <td>{$COMBUSTIBLE}</td>
    </tr>
    <tr>
      <td><span style="vertical-align: top;">
      <label>N. Motor :</label>
      </span></td>
      <td colspan="3"><span style="vertical-align: top;">{$MOTOR}</span></td>
      <td><span style="vertical-align: top;">
      <label>N. Serie Chasis :</label>
      </span></td>
      <td><span style="vertical-align: top;">{$CHASIS}</span></td>
	  <td><span style="vertical-align: top;">
      <label>Carroceria :</label>
      </span></td>
	  <td><span style="vertical-align: top;">{$CARROCERIA}</span></td>	  
	  <td><span style="vertical-align: top;">
	    <label>Tarjeta Propiedad :</label>
	  </span></td>
	  <td><span style="vertical-align: top;">{$TARJETAPROPIEDAD}</span></td>		  
    </tr>	
    <tr id="filaRemolque">
      <td><label>Placa Remolque :</label></td>
      <td colspan="3">{$PLACAREMOLQUE}{$PLACAREMOLQUEID}<br>      </td>
      <td><label>Marca Remolque :</label></td>
      <td>{$MARCAREMOLQUE}{$MARCAREMOLQUEID}</td>
      <td><label>Modelo Remolque :</label></td>
      <td>{$MODELOREMOLQUE}</td>
      <td><label>Configuracion :</label></td>
      <td>{$TIPOREMOLQUE}</td>
    </tr>
    <tr>
      <td><label>Empresa a la cual esta afiliado :</label></td>
      <td colspan="3">{$EMPRESAAFILIADOVEHICULO}</td>
      <td><label>Numero Carnet :</label></td>
      <td>{$NUMEROCARNET}</td>
      <td><label>Vence :</label></td>
      <td>{$VENCIMIENTOAFILIACION}</td>
      <td><label>Ciudad :</label></td>
      <td>{$CIUDADVEHICULO}{$CIUDADVEHICULOID}</td>
    </tr>
    <tr>
      <td><label>Telefono :</label></td>
      <td colspan="3">{$TELEFONOVEHICULO}</td>
      <td><label>Soat :</label></td>
      <td>{$SOAT}</td>
      <td><label>Vencimiento :</label></td>
      <td>{$VENCESOAT}</td>
      <td><label>Aseguradora : </label></td>
      <td>{$ASEGSOAT}{$ASEGSOATID}</td>
    </tr>
    <tr>
      <td><label>Revision Tecnico Mecanica: </label></td>
      <td colspan="3"> {$TECNOMECANICO}</td>
      <td><label>Vigencia: </label></td>
      <td>{$VENCETECNOMECANICO}</td>
      <td><label>Registro Nacional de Carga : </label></td>
      <td>{$REGISTRONACIONALCARGA}</td>
      <td><label></label>
      <label>Monitoreo Satelital: </label></td>
      <td>{$MONITOREOSATELITAL}</td>
    </tr>
    <tr>
      <td><label>Link: </label></td>
      <td colspan="3">{$LINKMONITOREOSATELITAL}</td>
      <td><label>Usuario: </label></td>
      <td>{$USUARIO}</td>
      <td><label>Contraseña: </label></td>
      <td>{$PASSWORD}</td>
      <td><label>Propio: </label></td>
      <td>{$PROPIO}</td>
    </tr>
	<tr>
	  <td><label>Estado :</label></td>
	  <td colspan="9">{$ESTADO}</td>
	</tr>
  </tbody>
</table>
</fieldset>
<fieldset class="section"> <legend>DATOS CONDUCTOR</legend>
<table width="100%">
  <tr>
    <td><label>Conductor :</label></td>
	<td>{$CONDUCTOR}{$CONDUCTORID}</td>
  </tr>
</table>
</fieldset>
<fieldset class="section"> <legend>DATOS PROPIETARIO VEHICULO</legend>
<table width="100%">
  <tbody>
    <tr>
      <td><label>Nombre :</label></td>
      <td>{$NOMBREPROPIETARIO}{$IDENTIDADPROPIETARIO}</td>
      <td><label>Tipo Persona :</label></td>
      <td>{$TIPOPERSONAPROPIETARIO}</td>
      <td><label>Cedula o Nit :</label></td>
      <td>{$CEDULANITPROPIETARIO}</td>
    </tr>
    <tr>
      <td><label>Telefono :</label></td>
      <td>{$TELEFONOPROPIETARIO}</td>
      <td><label>Celular :</label></td>
      <td>{$CELULARPROPIETARIO}</td>
      <td><label>Direccion :</label></td>
      <td>{$DIRECCIONPROPIETARIO}</td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Ciudad :</label></td>
      <td style="vertical-align: top;">{$CIUDADPROPIETARIO}{$CIUDADPROPIETARIOID}</td>
      <td style="vertical-align: top;"><label>Email :</label></td>
      <td style="vertical-align: top;">{$EMAILPROPIETARIO}<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
  </tbody>
</table>
</fieldset>
<fieldset class="section"> <legend>DATOS TENEDOR VEHICULO</legend>
<table width="100%">
  <tbody>
    <tr>
      <td><label>Nombre :</label></td>
      <td>{$NOMBRETENEDOR}{$IDENTIDADTENEDOR}</td>
      <td><label>Tipo Persona :</label></td>
      <td>{$TIPOPERSONATENEDOR}</td>
      <td><label>Cedula o Nit :</label></td>
      <td>{$CEDULANITTENEDOR}</td>
    </tr>
    <tr>
      <td><label>Telefono :</label></td>
      <td>{$TELEFONOTENEDOR}</td>
      <td><label>Celular :</label></td>
      <td>{$CELULARTENEDOR}</td>
      <td><label>Direccion :</label></td>
      <td>{$DIRECCIONTENEDOR}</td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Ciudad :</label></td>
      <td style="vertical-align: top;">{$CIUDADTENEDOR}</td>
      <td style="vertical-align: top;"><label>Email :</label></td>
      <td style="vertical-align: top;">{$EMAILTENEDOR}<br>
      </td>
      <td style="vertical-align: top;"><label>Tipo Cuenta Bancaria :</label></td>
      <td style="vertical-align: top;">{$TIPOCUENTATENEDOR}<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><label>Entidad Bancaria :</label></td>
      <td style="vertical-align: top;">{$BANCOCUENTATENEDOR}<br>
      </td>
      <td style="vertical-align: top;"><label>N. Cuenta</label></td>
      <td style="vertical-align: top;">{$NUMEROCUENTATENEDOR}<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
  </tbody>
</table>
</fieldset>
<fieldset class="section"> <legend>DOCUMENTOS PROPIETARIO</legend>
<table width="100%">
  <tbody>
    <tr>
      <td>{$ARCHIVOTARJETAPROPIEDADVEHICULO}</td>
    </tr>
  </tbody>
</table>
</fieldset>
<fieldset class="section"> <legend>DOCUMENTOS VEHICULO</legend>
  <table width="100%">
    <tr>
      <td><label>Foto Frontal:</label></td>
      <td>{$FOTOFRONTAL}</td>
      <td><label>Foto Lateral:</label></td>
      <td>{$FOTOLATERAL}</td>
    </tr>	
	
    <tr>
      <td><label>Foto Trasera:</label></td>
      <td>{$FOTOTRASERA}</td>
      <td><label>Documentos:</label></td>
      <td>{$ARCHIVOREGISTRONACIONALCARGA}</td>
    </tr>		
	
 
  </table>
</fieldset>
<fieldset class="section"> <legend>VERIFICACION DE DATOS</legend>
<table align="center" width="100%">
  <tbody>
    <tr class="subSection" align="center">
      <td>RESPONSABLE POR VERIFICACION</td>
      <td>NOMBRE PERSONA QUE ATENDIO</td>
      <td>CIUDAD</td>
      <td>TELEFONO</td>
      <td>TIPO VERIFICACION</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span>1.</span> {$RESPONSABLEVERIFICACION1}&nbsp;</td>
      <td>{$PERSONAQUEATENDIO1}&nbsp;</td>
      <td>{$CIUDADPERSONAQUEATENDIO1}{$CIUDADIDPERSONAQUEATENDIO1} &nbsp;</td>
      <td>{$TELEFONOPERSONAQUEATENDIO1}</td>
      <td>{$TIPOVERIFICACION1}&nbsp;</td>
    </tr>
    <tr>
      <td><span>2.</span> {$RESPONSABLEVERIFICACION2} <br>      </td>
      <td>{$PERSONAQUEATENDIO2} <br>      </td>
      <td>{$CIUDADPERSONAQUEATENDIO2}{$CIUDADIDPERSONAQUEATENDIO2} &nbsp;</td>
      <td>{$TELEFONOPERSONAQUEATENDIO2}</td>
      <td>{$TIPOVERIFICACION2} <br>      </td>
    </tr>
    <tr>
      <td><span>3.</span> {$RESPONSABLEVERIFICACION3} <br>      </td>
      <td>{$PERSONAQUEATENDIO3} <br>      </td>
      <td>{$CIUDADPERSONAQUEATENDIO3}{$CIUDADIDPERSONAQUEATENDIO3} &nbsp;</td>
      <td>{$TELEFONOPERSONAQUEATENDIO3}</td>
      <td>{$TIPOVERIFICACION3} </td>
    </tr>
    <tr>
      <td colspan="5" rowspan="1" style="vertical-align: top;">
      <table style="text-align: left; width: 90%; margin-top: 20px;" align="center" border="0" cellpadding="2" cellspacing="2">
        <tbody>
          <tr>
            <td style="vertical-align: top;"><label>Fecha
Confirmacion :</label></td>
            <td style="vertical-align: top;">{$FECHACONFIRMACION}<br>            </td>
            <td style="vertical-align: top;"><label>Aprobacion :</label></td>
            <td style="vertical-align: top;">{$APROBACION}<br>            </td>
          </tr>
          <tr>
            <td style="vertical-align: top;"><label>Aprobo :</label></td>
            <td style="vertical-align: top;">{$APROBO}{$APROBOID}<br>            </td>
            <td style="vertical-align: top;"><label>Reviso :</label></td>
            <td style="vertical-align: top;">{$REVISO}{$REVISOID}<br>            </td>
          </tr>
        </tbody>
      </table>
      <br>      </td>
    </tr>
  </tbody>
</table>
<table align="center">
<tbody><tr>
<td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}</td>
</tr>
</tbody></table>
</fieldset>
{$FORM1END} </fieldset>

<fieldset>{$GRIDVEHICULO}</fieldset>

</body></html>