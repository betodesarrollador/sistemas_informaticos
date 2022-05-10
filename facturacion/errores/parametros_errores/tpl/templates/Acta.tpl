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
        
        {$FORM1}
        <fieldset class="section">	
        <table align="center">		  
          <tr>
            <td><label>No. Acta :</label></td><td>{$ACTAID}{$USUARIOREGISTRA}{$USUARIOACTUALIZA}</td>
            <td><label>Nombre Acta / Proyecto : </label></td><td>{$NOMBRE}</td>  
            <td><label>Cliente :</label></td><td>{$CLIENTEID}{$CLIENTE}</td>     
          </tr>  
          <tr>
            <td><label>No. Ticket : </label></td><td>{$PQRID}</td>   
            <td><label>Fecha Acta :</label></td><td>{$FECHA}</td> 
            <td><label>Asunto Acta : </label></td><td>{$ASUNTO}</td>  
          </tr>
          <tr>  
            <td><label>Ciudad : </label></td><td>{$UBICACIONID}{$UBICACION}</td>   
          </tr>
		  <tr><td colspan="6">&nbsp;</td></tr>
          <tr>
            <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}&nbsp;{$ENVIOMAIL}</td>
          </tr>
         </table>
         </fieldset>	
          
		 <fieldset class="section">	
     <legend>Temas Tradados</legend>
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
      	 <div><iframe name="detalleActa" id="detalleActa" src="about:blank"></iframe></div>
         </fieldset>
         
         <fieldset class="section">	
         <legend>Acuerdos Y Compromisos</legend>
         <div align="right">
              <img src="../../../framework/media/images/grid/save.png" id="saveTerceros" title="Guardar Seleccionados">
              <img src="../../../framework/media/images/grid/no.gif" id="deleteTerceros" title="Borrar Seleccionados">
         </div> 
         <div><iframe name="terceroActa" id="terceroActa" src="about:blank"></iframe></div>		 
         </fieldset>  

         <fieldset class="section">
         <legend>Participantes</legend>	
         <div align="right">
              <img src="../../../framework/media/images/grid/save.png" id="saveParticipantes" title="Guardar Seleccionados">
              <img src="../../../framework/media/images/grid/no.gif" id="deleteParticipantes" title="Borrar Seleccionados">
         </div> 
         <div><iframe name="participantesActa" id="participantesActa" src="about:blank"></iframe></div>		 
         </fieldset>
      
    
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
      {$FORM1END}
    </fieldset>
    
  </body>
</html>
