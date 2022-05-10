<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
{$JAVASCRIPT}
{$CSSSYSTEM}     
{$TITLETAB} 
</head>
 <body>
 

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

	{$FORM1}
      {$PRESUPUESTOID}
        <table align="center">
          <tbody>
          <tr>
            <td><label>Periodo : </label></td><td>{$PERIODOCONTABLEID}</td>
            <td><label>Estado : </label></td><td>{$ESTADO}</td>
          </tr>
	      <tr>
	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
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
        
      <div><iframe style="height:700px" id="detallePresupuesto" class="editableGrid"></iframe></div>
      
      {$FORM1END}
    </fieldset>

  </body></html>