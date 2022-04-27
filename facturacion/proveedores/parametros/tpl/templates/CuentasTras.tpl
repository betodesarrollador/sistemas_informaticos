<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
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
        
        {$FORM1}{$CUENTAID}
        <fieldset class="section">	
        <table align="center">		  
          <tr>
            <td><label>Codigo Puc:</label></td><td>{$DESCRIPCION}{$PUCID}</td> <td><label>Descripci&oacute;n Corta:</label></td><td>{$DESCRIPCIONCORTA}</td>
            <td><label>Oficina:</label></td><td>{$OFICINA}</td>
            <td ><label>Estado:</label></td>
            <td >A&nbsp;{$ACTIVO}&nbsp;&nbsp;I&nbsp;{$INACTIVO}{$TIPO}</td>
          </tr>       
		  <tr><td colspan="6">&nbsp;</td></tr>
          <tr>
            <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>	 
         
        
    

    
    <fieldset>{$GRIDFORMASPAGO}</fieldset>
  </fieldset>
    {$FORM1END}
    
  </body>
</html>
