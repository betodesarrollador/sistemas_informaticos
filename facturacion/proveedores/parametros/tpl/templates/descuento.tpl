<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}
  {$TABLEGRIDCSS}
  {$TITLETAB}  
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
        <fieldset class="section">
        <table align="center">
          <tr>
            <td><label>Nombre Descuento : </label></td><td>{$PARAMEID}{$NOMBRE}</td>
            <td><label>C&oacute;digo PUC : </label></td><td>{$PUC}{$PUCID}</td>
          </tr>
          <tr>
            <td><label>Naturaleza  : </label></td><td>{$NATURALEZA}</td>
            <td><label>Oficina : </label></td><td>{$OFICINA}</td>
          </tr>
          <tr>
            <td><label>Estado  : </label></td><td>{$ESTADO}</td>
            <td>&nbsp;</td><td>&nbsp;</td>
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
        
    
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>
  </fieldset>
    {$FORM1END}
    
  </body>
</html>
