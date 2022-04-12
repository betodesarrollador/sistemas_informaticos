<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>
  
  
  <body>
	<fieldset>
        <legend>
			<img src="../media/images/forms/parametros_modulo.png" height="45">
            <img src="../media/images/forms/novedades_remesa.png" height="45">
        </legend>

        <div id="table_find">
        <table align="center">
         <tr>
           <td><label>Busqueda :</label></td><td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}{$NOVEDADID}
        <table align="center">
          <tr>
            <td><label>Novedad :</label></td><td>{$NOVEDAD}</td>
          </tr>
          <tr>
            <td><label>Visible al Cliente :</label></td><td>{$NOVEDADCLIENTE}</td>
          </tr>
          <tr>
            <td><label>Estado de la Novedad :</label></td><td>{$ESTADO}</td>
          </tr>
          <tr>
	        <td colspan="4">&nbsp;</td>
          </tr>

	      <tr>
	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
      
      
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDNovedadRemesa}</fieldset>
    
  </body>
</html>