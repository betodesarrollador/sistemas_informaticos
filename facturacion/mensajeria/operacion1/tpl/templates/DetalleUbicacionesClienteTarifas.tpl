<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  
  <form name="detalle_campos_archivo_cliente" id="detalle_campos_archivo_cliente" onSubmit="return false">
  
   <div align="center">
    <table id="tableUbicacionesCliente" width="90%" align="center">
      <thead>
        <tr>
          <th>UBICACION CLIENTE</th>
          <th>UBICACION SOLICITUD SERVICIO</th>
		  <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      
      {foreach name=detalle_solicitud from=$DETALLES item=d}
      <tr>
        <td>
        <input type="text" autocomplete="off" name="nombre"  value="{$d.nombre}" class="required" />
       </td>
       <td>
	    <select name="ubicacion_id">
		 <option value="NULL">(.... Seleccione ....)</option>
	    {foreach name=campos_archivo from=$CAMPOSSOLICITUD item=c}		
		 <option value="{$c.value}" {if $c.value eq $d.ubicacion_id}selected{/if}>{$c.text}</option>
		{/foreach}
	    </select>
      </td>
	  <td><img name="remove" src="../../../framework/media/images/grid/close.png" /></td>
    </tr>
    {/foreach}
	
      <tr>
        <td>
        <input type="text" autocomplete="off" name="nombre"  value="" class="required" />
       </td>
       <td>
	    <select name="ubicacion_id">
		 <option value="NULL">(.... Seleccione ....)</option>
	    {foreach name=campos_archivo from=$CAMPOSSOLICITUD item=c}		
		 <option value="{$c.value}" >{$c.text}</option>
		{/foreach}
	    </select>
      </td>
	  <td><img name="add" src="../../../framework/media/images/grid/add.png" /></td>	  
    </tr>
	
      <tr id="clon">
        <td>
        <input type="text" autocomplete="off" name="nombre"  value="" class="required" />
       </td>
       <td>
	    <select name="ubicacion_id">
		 <option value="NULL">(.... Seleccione ....)</option>
	    {foreach name=campos_archivo from=$CAMPOSSOLICITUD item=c}		
		 <option value="{$c.value}">{$c.text}</option>
		{/foreach}
	    </select>
      </td>
	  <td><img name="add" src="../../../framework/media/images/grid/add.png" /></td>	  
    </tr>		
	
  </tbody>  
  </table>
  </div>
  </form>
 </body>
</html>