<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Solicitud de Servicio - Online Tools™</title></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  

    <fieldset>
      <legend>{$TITLEFORM}</legend>
      <div id="table_find">
        <table>
         <tbody><tr>
           <td><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </tbody></table>
    </div>

        {$OFICINAHIDDEN}
        {$OFICINAIDHIDDEN}
        {$FECHASTATIC}
	{$FORM1}
        <table align="center">
          <tbody><tr>
            <td><label>Solicitud No. : </label></td><td>{$SOLICITUDID}</td>
            <td><label>Fecha:</label></td>
            <td>{$FECHASOLICITUD}</td>
            <td><label>Oficina:</label></td>
            <td>{$OFICINAID}</td>
          </tr>
          <tr>
            <td><label>Cliente : </label></td><td colspan="3">{$CLIENTE}{$CLIENTEID}</td>
            <td><label>Contacto: </label></td>
            <td>{$CONTACTOID}</td>
          </tr>
          <tr>
            <td><label>Tipo Servicio : </label></td><td colspan="3">{$TIPOSERVICIO}</td>
            <td>&nbsp;</td><td>&nbsp;</td>
            </tr>
          <tr>
            <td><label>Fecha recogida : </label></td><td colspan="3">{$FECHARECOGIDA}</td>
            <td><label>Hora Recogida : </label></td><td>{$HORARECOGIDA}</td>
            </tr>
          <tr style="display:none">
            <td><label>Fecha Entrega : </label></td><td colspan="3">{$FECHAENTREGA}</td>
            <td><label>Hora Entrega : </label></td><td>{$HORAENTREGA}</td>
          </tr>
          <tr>
	        <td>&nbsp;</td>
	        <td colspan="3">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
          </tr>
	      <tr>
	        <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </tbody>
      </table>
      
      <table id="toolbar">
          <tbody><tr>
            <td id="messages"><div>&nbsp;</div></td>
            <td id="detailToolbar">
	      <img src="../../../framework/media/images/grid/save.png" id="saveDetallesSoliServi" title="Guardar Seleccionados">
	      <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesSoliServi" title="Borrar Seleccionados">
            </td>
            <td id="fileUpload">{$ARCHIVOSOLICITUD}</td>
          </tr>               
      </tbody></table>
        
      <div><iframe id="detalleSoliServi" class="editableGrid"></iframe></div>
      
      {$FORM1END}
    </fieldset>

    {*<fieldset>{$GRIDSOLICITUDSERVICIOS}</fieldset>*}
    
  </body></html>