<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
        <table align="center" width="90%">
          <tr>
            <td><label>Forma de Pago  : </label></td><td>{$CUENTAID}{$FORMA}</td>
            <td><label>Cuenta Puc : </label></td><td>{$PUC}{$PUCID}</td>
          </tr>
          <tr>
            <td><label>Naturaleza : </label></td><td>{$NATURA}</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="right">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
        {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    
  </body>
</html>
