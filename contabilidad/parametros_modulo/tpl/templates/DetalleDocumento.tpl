<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <div align="center">
  <input type="hidden" id="tipo_documento_id" value="{$DOCUMENTOID}" />
  <table id="tableDetalle" align="center">
   <thead>
    <tr>
     <th>OFICINA</th>          
     <th>CONSECUTIVO</th>               	 
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>
    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="consecutivo_documento_oficina_id" id="consecutivo_documento_oficina_id" value="{$d.consecutivo_documento_oficina_id}" />	 
	   <select name="oficina_id" class="required">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=oficinas from=$OFICINAS item=b}
		 <option value="{$b.value}" {if $b.value eq $d.oficina_id}selected{/if}>{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
	 <td><input type="text" name="consecutivo" id="consecutivo" value="{$d.consecutivo}" class="required" /></td>
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
    <tr>
	 <td>
	<input type="hidden" name="consecutivo_documento_oficina_id" id="consecutivo_documento_oficina_id" value="" />	 
	   <select name="oficina_id" class="required">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=oficinas from=$OFICINAS item=b}
		 <option value="{$b.value}" >{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
	 <td><input type="text" name="consecutivo" id="consecutivo" value="" class="required" /></td>
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>    
    </tr>       
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	<input type="hidden" name="consecutivo_documento_oficina_id" id="consecutivo_documento_oficina_id" value="" />	 
	   <select name="oficina_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=oficinas from=$OFICINAS item=b}
		 <option value="{$b.value}" >{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
	 <td><input type="text" name="consecutivo" id="consecutivo" value="" /></td>
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>      
    </tr>      
  </table>
  </div>
  </body>
</html>