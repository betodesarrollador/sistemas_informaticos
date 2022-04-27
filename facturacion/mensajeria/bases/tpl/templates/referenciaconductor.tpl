<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>

  <body>
	<fieldset>
        <legend><img src="../media/images/forms/empresas.png" height="48"></legend>

        <div id="table_find">
        <table>
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}
        <table>
          <tr>
            <td><label>Numero Identificacion : </label></td><td>{$NUMEROIDENTIFICACION}</td>
            <td><label>Nombre Conductor : </label></td><td>{$NOMBRECONDUCTOR}</td>
          </tr>
          <tr>
            <td><label>Tipo Referencia : </label></td><td>{$TIPOREFERENCIA}</td>
            <td><label>Funcionario : </label></td><td>{$FUNCIONARIO}</td>
          </tr>
          <tr>
            <td><label>Nombre Referencia : </label></td><td>{$NOMBREREFERENCIA}</td>
            <td><label>Nombre Empresa : </label></td><td>{$NOMBREEMPRESA}</td>
          </tr>
          <tr>
            <td><label>Cargo : </label></td><td>{$CARGO}</td>
            <td><label>Telefono : </label></td><td>{$TELEFONO}</td>
          </tr>
          <tr>
            <td><label>Observaciones : </label></td><td>{$OBSERVACIONES}</td>
            <td>&nbsp;</td><td>&nbsp;</td>
          </tr>
          <tr>
	        <td>&nbsp;</td>
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
    <fieldset>{$GRIDREFERENCIA}</fieldset>
    
  </body>
</html>