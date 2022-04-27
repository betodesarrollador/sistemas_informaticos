<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}
  {$TABLEGRIDCSS}
  </head>

  <body>
  <input type="hidden" id="trafico_id" value="{$trafico_id}" />   

    <table align="center" width="98%">
        <thead>
          <tr>
            <th width="20%"><label>Ruta</label></th>
            <th>{$RUTAS}</th>
            <th>{$ORDEN}</th>
          </tr>
        </thead>
        <tbody>
        	<tr>
            	<td colspan="3"><iframe id="detalles_cambio"></iframe></td>
            </tr>
        </tbody>
      </table>
     <center>{$ACTUALIZAR}</center>
  </body>
</html>