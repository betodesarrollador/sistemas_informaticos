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
        {$FORM1}
        <table align="center">
          <tr>
            <td><label>Tercero Incorrecto  : </label></td>
            <td>{$TERCEROID}{$TERCERO}</td>
          </tr>
          <tr>
            <td><label>Tercero Correcto  : </label></td>
            <td>{$TERCEROID1}{$TERCERO1}</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center">{$ACTUALIZAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
        {$FORM1END}
    </fieldset>    
  </body>
</html>
