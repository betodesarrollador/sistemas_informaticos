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
        <table align="center">
          <tr>
            <td><label>Cliente : </label></td>
            <td>{$CLIENTEID}</td>
            <td><label>Origen  : </label></td><td>{$TARIFASCLIENTEID}{$ORIGEN}{$ORIGENID}</td>
          </tr>
          <tr>
            <td><label>Destino : </label></td>
            <td align="left">{$DESTINO} {$DESTINOID}</td>
            <td><label>Desde :</label></td>
            <td>{$DESDE}</td>
          </tr>
          <tr>
            <td><label>Hasta : </label></td>
            <td align="left">{$HASTA}</td>
            <td><label>Valor   : </label></td><td align="left">{$VALOR}</td>
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
        {$FORM1END}
    </fieldset>
    
    <fieldset>
    {$GRIDTARIFAS}
    </fieldset>
    
  </body>
</html>
