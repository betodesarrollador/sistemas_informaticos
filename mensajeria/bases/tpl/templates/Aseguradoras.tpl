<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
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
        
        {$FORM1}{$ASEGURADORAID}
        <table align="center">		  
          <tr>
            <td><label>Numero Identificacion :</label></td><td>{$NIT}</td>
            <td ><label>Digito Verificacion : </label></td><td>{$DIGITOVERIFICACION}</td>            
          </tr>       
          <tr>
            <td><label>Nombre : </label></td><td>{$NOMBRE}</td>
		    <td><label>Estado:</label></td>
			<td >A{$ACTIVO}I{$INACTIVO}{$TIPO}</td>
          </tr>  
		  <tr><td colspan="4">&nbsp;</td></tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
        {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDTERCEROS}</fieldset>
    
  </body>
</html>
