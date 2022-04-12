<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  
  <form name="detalle_campos_archivo_cliente" id="detalle_campos_archivo_cliente" onSubmit="return false">
  
   <div align="center">
    <table id="tableCamposArchivo" width="90%" align="center">
      <thead>
        <tr>
          <th>NOMBRE CAMPO ARCHIVO CLIENTE</th>
          <th>NOMBRE CAMPO SOLICITUD SERVICIO</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      
      {foreach name=detalle_solicitud from=$DETALLES item=d}
      <tr>
        <td>
	    <input type="hidden" name="campos_archivo[{$smarty.foreach.detalle_solicitud.iteration}][campos_archivo_tarifas_id]"  value="{$d.campos_archivo_tarifas_id}">
        <input type="text" autocomplete="off" name="campos_archivo[{$smarty.foreach.detalle_solicitud.iteration}][nombre_campo]"  value="{$d.nombre_campo}" class="required" />
       </td>
       <td>
	    <select name="campos_archivo[{$smarty.foreach.detalle_solicitud.iteration}][campos_archivo_solicitud_id]">
		 <option value="NULL">(.... Seleccione ....)</option>
	    {foreach name=campos_archivo from=$CAMPOSSOLICITUD item=c}		
		 <option value="{$c.campos_archivo_solicitud_id}" {if $c.campos_archivo_solicitud_id eq $d.campos_archivo_solicitud_id}selected{/if}>
		 {$c.nombre_campo}
		 {if $c.requerido eq 1}<span style="color:red">*</span>{/if}
		 </option>
		{/foreach}
	    </select>
      </td>
      <td><img name="removeField" src="../../../framework/media/images/grid/no.gif" /></td>
    </tr>
    {/foreach}
	
  </tbody>  
  </table>
  </div>
  </form>
 </body>
</html>