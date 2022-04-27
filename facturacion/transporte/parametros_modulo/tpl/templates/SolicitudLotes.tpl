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
            <img src="../media/images/forms/solicitud_lotes.png" height="45">
        </legend>

        <div id="table_find">
        <table align="center">
         <tr>
           <td><label>Busqueda :</label></td><td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}{$CAMPOARCHIVOID}
        <table align="center">
          <tr>
            <td><label>Cliente :</label></td><td colspan="3">{$CLIENTEID}</td>
          </tr>
          <tr>
            <td><label>Campo Sol. Servicio :</label></td><td>{$COLUMNAID}</td>
            <td><img src="../media/images/forms/arrow-skip-right-icon.png" title="Equivalencia" style="cursor:pointer"></td>
            <td><label>Columna Archivo :</label></td><td>{$CAMPOARCHIVO}</td>
          </tr>
          <tr>
	        <td colspan="5">&nbsp;</td>
          </tr>

	      <tr>
	        <td colspan="5" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
      
      
        <div align="right">
		  <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados"/>
		  <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados"/>
		</div>
        
      <div><iframe id="detalleSolicitudLotes"></iframe></div>
      
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDSolicitudLotes}</fieldset>
    
  </body>
</html>