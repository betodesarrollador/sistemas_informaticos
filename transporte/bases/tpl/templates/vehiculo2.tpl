<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
  
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>vehiculo2.tpl</title>

  
</head><body>
<form>
  <fieldset> <legend></legend>DATOS PROPIETARIO VEHICULO</fieldset>
  <table width="100%">
    <tbody>
      <tr>
        <td><label>Nombre :</label></td>
        <td>{$PROPIETARIO}</td>
        <td><label>Rut :</label></td>
        <td>{$RUTPROPIETARIO}</td>
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
        <td><label>Ciudad :</label></td>
        <td colspan="5">{$CIUDADPROPIETARIO}{$CIUDADPROPIETARIOID}</td>
      </tr>
    </tbody>
  </table>
  <fieldset> <legend>DATOS TENEDOR VEHICULO</legend>
  <table width="100%">
    <tbody>
      <tr>
        <td><label>Nombre :</label></td>
        <td>{$TENEDOR}</td>
        <td><label>Rut :</label></td>
        <td>{$RUTTENEDOR}</td>
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
        <td><label>Ciudad :</label></td>
        <td colspan="5">{$CIUDADTENEDOR}{$CIUDADTENEDORID}</td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <fieldset> <legend>ARCHIVOS IMAGEN</legend>
  <table width="100%">
    <tbody>
      <tr>
        <td colspan="4" align="center">CONDUCTOR</td>
      </tr>
      <tr>
        <td><label>Cedula :</label></td>
        <td>{$ARCHIVOCEDULACONDUCTOR}</td>
        <td><label>Licencia:</label></td>
        <td>{$ARCHIVOLICENCIACONDUCTOR}</td>
      </tr>
      <tr>
        <td><labe>Antecedentes :</labe></td>
        <td>{$ARCHIVOANTECEDENTESCONDUCTOR}</td>
        <td><labe>Afiliacion ARP :</labe></td>
        <td>{$ARCHIVOARPCONDUCTOR}</td>
      </tr>
      <tr>
        <td><labe>Afiliacion POS :</labe></td>
        <td colspan="3">{$ARCHIVOAFILIACIONPOSCONDUCTOR}</td>
      </tr>
      <tr>
        <td colspan="4" align="center">PROPIETARIO</td>
      </tr>
      <tr>
        <td><label>Targeta Propiedad Vehiculo:</label></td>
        <td>{$ARCHIVOTARJETAPROPIEDADVEHICULO}</td>
        <td><label>Cedula Propietario Vehiculo:</label></td>
        <td>{$ARCHIVOCEDULAPROPIETARIOVEHICULO}</td>
      </tr>
      <tr>
        <td><label>Contrato del Leasing :</label></td>
        <td>{$ARCHIVOCONTRATOLEASING}</td>
        <td><label>Rut Propietario o Tenedor:</label></td>
        <td>{$ARCHIVORUTPROPIETARIOTENEDOR}</td>
      </tr>
      <tr>
        <td colspan="4" align="center">VEHICULO</td>
      </tr>
      <tr>
        <td><label>Registro Nacional de Carga:</label></td>
        <td>{$ARCHIVOREGISTRONACIONALCARGA}</td>
        <td><label>Registro Nacional de Remolque:</label></td>
        <td>{$ARCHIVOREGISTRONACIONALREMOLQUE}</td>
      </tr>
      <tr>
        <td><label>Revision Tecnomecanica:</label></td>
        <td>{$ARCHIVOREVISIONTECNOMECANICA}</td>
        <td><label>Afiliacion Empresa Transporte:</label></td>
        <td>{$ARCHIVOAFILIACIONEMPRESATRANSPORTE}</td>
      </tr>
      <tr>
        <td><label>SOAT:</label></td>
        <td colspan="3">{$ARCHIVOSOAT}</td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <fieldset> <legend>VERIFICACION DE DATOS</legend>
  <table width="100%">
    <tbody>
      <tr>
        <td>RESPONSABLE POR VERIFICACION</td>
        <td>NOMBRE PERSONA QUE ATENDIO</td>
        <td>TIPO VERIFICACION</td>
      </tr>
      <tr>
        <td>1.&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>2.&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>3.&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  </fieldset>
</form>

</body></html>