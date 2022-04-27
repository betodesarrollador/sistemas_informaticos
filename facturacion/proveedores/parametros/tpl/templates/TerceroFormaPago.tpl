<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <div align="center">
  <input type="hidden" id="forma_pago_id" value="{$FORMAPAGOID}" />
  <table id="tableDetalle" align="center">
   <thead>
    <tr>
     <th>TERCERO</th>
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="forma_pago_tercero_id" id="forma_pago_tercero_id" value="{$d.forma_pago_tercero_id}" />
       <input type="text" name="tercero" value="{$d.tercero}" size="100" class="required" />
	   <input type="hidden" name="tercero_id" value="{$d.tercero_id}" class="required" />
	 </td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}

    <tr>
	 <td>
	   <input type="hidden" name="forma_pago_tercero_id" id="forma_pago_tercero_id" value="" />
       <input type="text" name="tercero" value="" size="100" class="required" />
	   <input type="hidden" name="tercero_id" value="" class="required" />
	 </td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>       
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	   <input type="hidden" name="forma_pago_tercero_id" id="forma_pago_tercero_id" value="" />
       <input type="text" name="tercero" value="" size="100" />
	   <input type="hidden" name="tercero_id" value="" />
	 </td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>      
  </table>
  </div>
  </body>
</html>