<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>	

        <div id="table_find">
        <table align="center">
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}
        <table align="center">
          <tr>
            <td><label>Ubicacion : </label></td><td>{$UBICACION}{$UBICACIONID}{$PUESTROCONTROLID}</td>
            <td><label>Puesto Control : </label></td><td>{$PUESTOCONTROL}</td>
          <tr>
            <td><label>Responsable : </label></td><td>{$RESPONSABLE}</td>
            <td><label>Direccion : </label></td><td>{$DIRECCION}</td>
          </tr>
          <tr>
            <td><label>Telefono : </label></td><td>{$TELEFONO}</td>
            <td><label>Telefono 2 : </label></td><td>{$TELEFONO2}</td>
          </tr>
          <tr>
            <td><label>Movil : </label></td><td>{$MOVIL}</td>
            <td><label>Movil 2 : </label></td><td>{$MOVIL2}</td>
          </tr>
          <tr>
            <td><label>Email : </label></td><td>{$EMAIL}</td>
            <td>&nbsp;</td><td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td><td>&nbsp;</td>
            <td><label>Estado : </label></td><td>{$ESTADOPUESTO}</td>
          </tr>
          <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
          </tr>

	      <tr>
	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDPUESTOSCONTROL}</fieldset>
    
  </body>
</html>