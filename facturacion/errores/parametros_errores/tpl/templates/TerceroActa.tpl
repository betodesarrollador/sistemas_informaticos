<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <div align="center">
  <input type="hidden" id="acta_id" value="{$ACTAID}" />
  <table id="tableDetalle" align="center">
   <thead>
    <tr>
     <th>Acuerdo Y/O Compromiso</th>
     <th>Prioridad</th>
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>
    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="acuerdo_id" id="acuerdo_id" value="{$d.acuerdo_id}" />
       <input type="text" name="compromiso" value="{$d.compromiso}" size="100" class="required" />
	 </td>
   <td>
          <select name="prioridad" class="required">
            <option value="NULL">(... Seleccione ...)</option>
            <option value="1" {if $d.prioridad eq '1'}selected{/if}>ALTA</option>	   
            <option value="2" {if $d.prioridad eq '2'}selected{/if}>MEDIA</option>	   		 
            <option value="3" {if $d.prioridad eq '3'}selected{/if}>BAJA</option>	   		 
          </select>
        </td>
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
    <tr>
	 <td>
	   <input type="hidden" name="acuerdo_id" id="acuerdo_id" value="" />
       <input type="text" name="compromiso" value="" size="100" class="required" />
	 </td>
   <td>
      <select name="prioridad" class="required">
        <option value="NULL">(... Seleccione ...)</option>
        <option value="1">ALTA</option>	   
        <option value="2">MEDIA</option>	   		 
        <option value="3">BAJA</option>	   		 
      </select>
    </td>
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>       
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	   <input type="hidden" name="acuerdo_id" id="acuerdo_id" value="" />
       <input type="text" name="compromiso" value="" size="100" />
	 </td>
   <td>
   <td>
      <select name="prioridad" class="required">
        <option value="NULL">(... Seleccione ...)</option>
        <option value="1">ALTA</option>	   
        <option value="2">MEDIA</option>	   		 
        <option value="3">BAJA</option>	   		 
      </select>
    </td>
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>      
  </table>
  </div>
  </body>
</html>