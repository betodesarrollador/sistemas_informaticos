<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">

  {$JAVASCRIPT}
  
  {$CSSSYSTEM}
  
  {$TITLETAB}
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table align="center"><tr><td><label>Busqueda : </label></td></tr>
                            <tr><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
        <fieldset class="section">
        <table align="center">
          <tr>
            <td ><label>Tipo Identificacion : </label></td><td>{$TIPOIDENTIFICACION}{$TERCEROID}{$EJECUTIVOID}</td>
            <td><label>Tipo Contribuyente : </label></td><td>{$TIPOPERSONA}</td>
          </tr>
          <tr>
            <td><label>Numero Identificacion :</label></td><td align="left">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
          </tr>
          <tr id="filaApellidos">
            <td><label>Primer Apellido : </label></td><td align="left">{$PRIMERAPELLIDO}</td>
            <td><label>Segundo Apellido : </label></td><td align="left">{$SEGUNDOAPELLIDO}</td>
          </tr>
          <tr id="filaNombres">
            <td><label>Primer Nombre : </label></td><td>{$PRIMERNOMBRE}</td>
            <td><label>Otros Nombres : </label></td><td>{$OTROSNOMBRES}</td>
          </tr>
          <tr id="filaRazonSocial">            
          	<td><label>Razon Social : </label></td><td>{$RAZON_SOCIAL}</td>
            <td><label>Sigla : </label></td><td>{$SIGLA}</td>
          </tr>
          <tr>
            <td><label>Telefono : </label></td><td>{$TELEFONO}</td>
            <td><label>Movil : </label></td><td align="left">{$MOVIL}</td>
          </tr>
          <tr>
            <td><label>Telefax : </label></td><td>{$TELEFAX}</td>
            <td><label>Apartado A&eacute;reo : </label></td><td align="left">{$APARTADO}</td>
          </tr>

          <tr>
            <td><label>Ciudad Residencia : </label></td><td>{$UBICACION}{$UBICACIONID}</td>
            <td><label>Direccion : </label></td><td align="left">{$DIRECCION}</td>
          </tr>
          <tr>
            <td><label>Email :</label></td>
            <td align="left">{$EMAIL}</td>
            <td><label>Pagina Web : </label></td>
            <td>{$URL}</td>
          </tr>
          <tr>
            <td><label>Contacto :</label></td>
            <td align="left">{$CONTACT}</td>
            <td><label>Oficina: </label></td><td>{$OFICINAID}</td>
          </tr>
          <tr>
            <td><label>Regimen : </label></td>
            <td>{$REGIMENID}</td>
            <td><label>Tipo de Cuenta :</label></td>
            <td align="left">{$TIPOCUENTA}</td>

          </tr>

          <tr>
            <td><label>N&uacute;mero de Cuenta : </label></td>
            <td>{$NUM_CUENTA}</td>
            <td><label>Entidad Bancaria :</label></td>
            <td align="left">{$BANCO}{$BANCOID}</td>

          </tr>
          <tr>
            <td><label>Estado : </label></td>
            <td align="left">A{$ACTIVO}I{$INACTIVO}</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>          
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>
         <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
        {$FORM1END}
    </fieldset>
    
  </body>
</html>
