<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <div align="center">
  <input type="hidden" id="impuesto_id" value="{$IMPUESTOID}" />
  <table id="tableSolicitudServicios" align="center">
   <thead>
    <tr>
     <th>PERIODO CONTABLE</th>
     <th>PORCENTAJE</th>          
     <th>FORMULA</th>               	 
     <th>MONTO MINIMO</th>               
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>
    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="impuesto_periodo_contable_id" id="impuesto_periodo_contable_id" value="{$d.impuesto_periodo_contable_id}" />
	   <select name="periodo_contable_id" id="periodo_contable_id" class="required">
	    <option value="NULL" value="">(.. Seleccione ..)</option>
		{foreach name=periodo from=$PERIODOS item=p}
		<option value="{$p.value}" {if $p.value eq $d.periodo_contable_id}selected{/if}>{$p.text}</option>
		{/foreach}
	   </select>
	 </td>
	 <td><input type="text" name="porcentaje" id="porcentaje" value="{$d.porcentaje}" class="required" /></td>
	 <td><input type="text" name="formula" id="formula" value="{$d.formula}" class="required" /></td>
	 <td><input type="text" name="monto" id="monto" value="{$d.monto}" class="required" /></td>	
     <td><a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
    <tr>
	 <td>
	   <input type="hidden" name="impuesto_periodo_contable_id" id="impuesto_periodo_contable_id" value="" />
	   <select name="periodo_contable_id" id="periodo_contable_id" class="required">
	    <option value="NULL" value="">(.. Seleccione ..)</option>
		{foreach name=periodo from=$PERIODOS item=p}
		<option value="{$p.value}">{$p.text}</option>
		{/foreach}
	   </select>
	 </td>
	 <td><input type="text" name="porcentaje" id="porcentaje" value="" class="required" /></td>
	 <td><input type="text" name="formula" id="formula" value="(BASE*PORCENTAJE)/100" class="required" /></td>
	 <td><input type="text" name="monto" id="monto" value="" class="required" /></td>	
     <td><a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>      
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	   <input type="hidden" name="impuesto_periodo_contable_id" id="impuesto_periodo_contable_id" value="" />
	   <select name="periodo_contable_id" id="periodo_contable_id" class="required">
	    <option value="NULL" value="">(.. Seleccione ..)</option>
		{foreach name=periodo from=$PERIODOS item=p}
		<option value="{$p.value}">{$p.text}</option>
		{/foreach}
	   </select>
	 </td>
	 <td><input type="text" name="porcentaje" id="porcentaje" value="" class="required" /></td>
	 <td><input type="text" name="formula" id="formula" value="(BASE*PORCENTAJE)/100" class="required" /></td>
	 <td><input type="text" name="monto" id="monto" value="" class="required" /></td>	
     <td><a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>    
    </tr>   
  </table>
  </div>
  </body>
</html>