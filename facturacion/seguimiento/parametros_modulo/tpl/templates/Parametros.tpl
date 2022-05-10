<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>
  
  
  <body>
	<fieldset>
        <legend><img src="../media/images/forms/parametros_reporte.png" height="48"></legend>

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
            <td><label>Cliente : </label></td><td colspan="3">{$CLIENTE}{$CLIENTE_ID}{$PARAMETROSID}</td>
          </tr>
          <tr>
            <td><label>Minuto : </label></td><td>{$MINUTO}</td>
            <td><label>Tiempo Indicador Rojo : </label></td><td>{$ROJO}</td>          
            
          </tr>
          <tr>
            <td><label>Horas  : </label></td><td>{$HORAS}</td>
	        <td><label>Tiempo Indicador Amarilla : </label></td><td>{$AMARILLO}</td>            
		  </tr>
          <tr>
            <td><label>D&iacute;as : </label></td><td>{$DIAS}</td>
          	<td><label>Tiempo Indicador Verde : </label></td><td>{$VERDE}</td>
		  </tr>	
		  <tr>
              <td><label>Estado : </label></td><td colspan="3">{$ESTADO}</td>
          </tr>          
          
	      <tr>
	        <td colspan="4" align="center">&nbsp;</td>
          </tr>
	      <tr>
	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDParametros}</fieldset>
    
  </body>
</html>