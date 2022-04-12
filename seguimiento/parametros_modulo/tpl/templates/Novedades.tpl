<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>
  
  
  <body>
	<fieldset>
        <legend><img src="../media/images/forms/novedades.png" height="48"></legend>

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
            <td><label>Novedad : </label></td><td>{$NOVEDAD}{$NOVEDADID}</td>
            <td><label>Alerta Panico : </label></td><td>{$ALERTAPANICO}</td>
          </tr>
          <tr>
            <td><label>Detiene Recorrido : </label></td><td>{$DETIENE}</td>
            <td><label>Tiempo Detenido (minutos) : </label></td><td>{$TIEMPODETIENE}</td>
          </tr>
          <tr>
            <td><label>Reporta al Cliente : </label></td><td>{$REPORTA}</td>
            <td><label>Reporte Interno : </label></td><td>{$REPORTAINT}</td>
		  </tr>	

          <tr>
          	<td><label>Requiere Remesa : </label></td><td>{$REQREMESA}</td>
            <td><label>Finaliza Seguimiento a Remesa : </label></td><td>{$FINREMESA}</td>
           
            
          </tr>
          <tr>
			<td><label>Finaliza Recorrido : </label></td><td>{$FINALIZAREC}</td>               
	        <td><label>Estado : </label></td><td>{$ESTADONOVEDAD}</td>
          </tr>

	      <tr>
	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
        <div align="right">
		  <img src="../../../framework/media/images/grid/save.png" id="saveDetallesCorreos" title="Guardar Seleccionados"/>
		  <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesCorreos" title="Borrar Seleccionados"/>
		</div>
      
      <div align="left">Correos para Reportes Internos</div>
      <div><iframe id="detalleCorreos" frameborder="0"></iframe></div>
      
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDNovedades}</fieldset>
    
  </body>
</html>