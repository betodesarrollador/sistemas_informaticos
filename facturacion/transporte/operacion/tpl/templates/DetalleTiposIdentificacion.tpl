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
          <th>TIPO IDENTIFICACION  CLIENTE</th>
          <th>TIPO IDENTIFICACION SOLICITUD SERVICIO</th>
        </tr>
      </thead>
      <tbody>
      
      {foreach name=detalle_tipo_identificacion from=$DETALLES item=d}
      <tr>
        <td>
	    <input type="hidden" name="campos_archivo[{$smarty.foreach.detalle_tipo_identificacion.iteration}][tipo_identificacion_cliente_id]"  value="{$d.tipo_identificacion_cliente_id}">
        <input type="text" autocomplete="off" name="campos_archivo[{$smarty.foreach.detalle_tipo_identificacion.iteration}][nombre]"  value="{$d.nombre}" class="required" />
       </td>
       <td>
	    <select name="campos_archivo[{$smarty.foreach.detalle_tipo_identificacion.iteration}][tipo_identificacion_id]">
		 <option value="NULL">(.... Seleccione ....)</option>
	    {foreach name=campos_archivo from=$CAMPOSSOLICITUD item=c}		
		 <option value="{$c.value}" {if $c.value eq $d.tipo_identificacion_id}selected{/if}>{$c.text}</option>
		{/foreach}
	    </select>
      </td>
    </tr>
    {/foreach}
	
  </tbody>  
  </table>
  </div>
  </form>
 </body>
</html>