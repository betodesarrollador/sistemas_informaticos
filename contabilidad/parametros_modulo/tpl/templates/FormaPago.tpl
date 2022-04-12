<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css"> 
  {$JAVASCRIPT}
  
  {$CSSSYSTEM}
  
  {$TITLETAB}
  </head>
  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>
        <div id="table_find">
        <table align="center">
        <tr>
          <td><label>Busqueda : </label></td>
        </tr>
        <tr>
          <td>{$BUSQUEDA}</td>
        </tr>
        </table>
        </div>
        
        {$FORM1}{$FORMAPAGOID}
        <fieldset class="section">	
        <table align="center">		  
          <tr>
            <td><label>Codigo :</label></td><td>{$CODIGO}</td>
            <td ><label>Nombre : </label></td><td>{$NOMBRE}</td>            
          </tr>       
          <tr>
		    <td><label>Requiere Soporte : </label></td>
			<td >{$SOPORTE}</td>
            <td ><label>Estado:</label></td>
            <td >A{$ACTIVO}I{$INACTIVO}{$TIPO}</td>
          </tr>  
		  <tr><td colspan="4">&nbsp;</td></tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>	 
		 <fieldset class="section">	
         <table id="toolbar">
          <tbody><tr>
            <td id="messages"><div>&nbsp;</div></td>
            <td id="detailToolbar">
	      <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados">
	      <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados">
            </td>
            <td id="fileUpload">{$ARCHIVOSOLICITUD}</td>
          </tr>               
         </tbody>
		 </table>	
      	 <div><iframe name="detalleFormaPago" id="detalleFormaPago" src="about:blank"></iframe></div>
         </fieldset>
         
         <fieldset class="section">	
         <div align="right">
              <img src="../../../framework/media/images/grid/save.png" id="saveTerceros" title="Guardar Seleccionados">
              <img src="../../../framework/media/images/grid/no.gif" id="deleteTerceros" title="Borrar Seleccionados">
         </div> 
         <div><iframe name="terceroFormaPago" id="terceroFormaPago" src="about:blank"></iframe></div>		 
         </fieldset>
      
    
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
      {$FORM1END}
    </fieldset>
    
  </body>
</html>
