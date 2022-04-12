{if $sectionOficinasTree neq 1}
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
            <td width="229" ><label>Empresa :</label></td>
            <td width="234">{$EMPRESASID}</td>
            <td width="240"><label>Codigo   :</label></td>
            <td width="199">{$CODIGO}{$DOCUMENTOSID}</td>
          </tr>
          <tr>
            <td><label>Nombre : </label></td>
            <td align="left">{$NOMBRE}</td>
            <td ><label>Texto Tercero   :</label></td>
            <td align="left">{$TEXTOTERCERO}</td>
          </tr>
          <tr>
            <td><label>Texto Soporte :</label></td>
            <td align="left">{$TEXTOSOPORTE}</td>
            <td ><label>Requiere Soporte   :</label></td>
            <td align="left">{$REQUIERESOPORTE}</td>
          </tr>  
          <tr>
            <td><label>Consecutivo Periodo ?</label></td>
            <td align="left">{$CONSECUTIVOANUAL}</td>
            <td ><label>Consecutivo Por : </label></td>
            <td align="left">{$CONSECUTIVOPOR}</td>
          </tr>  
          <tr>
            <td><label>Consecutivo   :</label></td>
            <td align="left">{$CONSECUTIVO}</td>
            <td ><label>Documento de Cierre  : </label></td>
            <td align="left">{$DECIERRE}</td>
          </tr>	
          <tr>
			<td><label>Documento de Traslado  : </label></td>
            <td align="left">{$DETRASLADO}</td>
            <td ><label>Documento de Anticipo  : </label></td>
            <td align="left">{$DEANTICIPO}</td>
          </tr>
          <tr>
            <td><label>Documento de Devoluci&oacute;n  : </label></td>
            <td>{$DEDEVOLUCION}</td>
            <td><label>Pago Facturaci&oacute;n  : </label></td>
            <td>{$PAGOFACTURA}</td>
          </tr>
          <tr>
            <td><label>Pago Proveedores  : </label></td>
            <td>{$PAGOPROVEEDOR}</td>
            <td><label>Nota Credito  : </label></td>
            <td>{$NOTACREDITO}</td>          
          </tr>
          <tr>
            <td><label>Nota Debito  : </label></td>
            <td>{$NOTADEBITO}</td>          
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
         <fieldset>
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
		 <div><iframe name="detalleDocumento" id="detalleDocumento" src="about:blank"></iframe></div>
		 
      
    
    <fieldset> <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
      {$FORM1END}
    </fieldset>
  </body>
</html>
	
{/if}