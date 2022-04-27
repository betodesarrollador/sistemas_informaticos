<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>

  <body>
	<fieldset>
        <legend><img src="../media/images/forms/directorio_apoyo.png" height="48"></legend>

        <div id="table_find">
        <table>
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}
        <table align="center">
          <tr>
            <td><label>Tipo de Apoyo : </label></td><td>{$TIPOAPOYO}</td>          
            <td><label>Ubicacion : </label></td><td>{$UBICACION}{$UBICACIONID}</td>
          </tr>
          <tr>
            <td><label>Identificaci&oacute;n : </label></td><td>{$IDENAPOYO}</td>                    
            <td><label>Nombre : </label></td><td>{$APOYO}{$APOYOID}</td>          
		  </tr>	            
          <tr>
            <td><label>Contacto : </label></td><td>{$CONTACTO}</td>
      	     <td><label>Correo : </label></td><td>{$CORREO}</td>            

          </tr>
          <tr>
      	     <td><label>Tel&eacute;fono : </label></td><td>{$TELEFONO}</td>
             <td><label>M&oacute;vil : </label></td><td>{$MOVIL}</td>
          </tr>
          </tr>
             <td><label>Direccion : </label></td><td>{$DIRECCION}</td>      	     
      	     <td><label>Placa : </label></td><td>{$PLACA}</td>
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
    <fieldset>{$GRIDDirectoriosApoyo}</fieldset>
    
  </body>
</html>