<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="remesa_id" value="{$REMESAID}" />
  <table width="958" id="tableRemesas">
   <thead>
    <tr>
     <th width="103">REFERENCIA</th>	 
     <th width="126">DESCRIPCION</th>	 
     <th width="45">CANT</th>	 	 	 	 	 
     <th width="56">PESO</th>	 	 
     <th width="59">VALOR</th>	 	 	 	 	 	 	 
     <th width="64">LARGO</th>
     <th width="61">ANCHO</th>
	 <th width="53">ALTO</th>
	 <th width="56">PESO VOL</th>
     <th width="73">GUIA CLIENTE </th>	 	 	 	 	 	 	 
     <th width="144">OBSERV</th>	 	 	 	 	 	 	 	 
	 <th width="42">&nbsp;</th>
     <th width="20"><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
       <input type="hidden" name="detalle_remesa_id" id="detalle_remesa_id" value="{$d.detalle_remesa_id}" />            
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value="{$d.detalle_ss_id}" />        	 
	   <input type="text" name="referencia_producto" size="6"  id="referencia_producto"  value="{$d.referencia_producto}" class="required" />
	 </td> 	 
	 <td><input type="text" name="descripcion_producto" id="descripcion_producto" size="20" value="{$d.descripcion_producto}" class="required" /></td>
	 <td><input type="text" name="cantidad" size="3" id="cantidad" value="{$d.cantidad}" class="required numeric saltoscrolldetalle" /></td>	 	 	 
	 <td><input type="text" name="peso" size="3" id="peso" value="{$d.peso}" class="numeric saltoscrolldetalle" /></td>	 
	 <td><input type="text" name="valor" size="3" id="valor" value="{$d.valor}" class="required numeric saltoscrolldetalle" /></td>	 	 	 
	 <td><input type="text" name="largo" size="2" id="largo" value="{$d.largo}" class="numeric saltoscrolldetalle" /></td>
	 <td><input type="text" name="ancho" size="2" id="ancho" value="{$d.ancho}" class="numeric saltoscrolldetalle" /></td>
	 <td><input type="text" name="alto" size="2" id="alto" value="{$d.alto}" class="numeric saltoscrolldetalle" /></td>	 
	 <td><input type="text" name="peso_volumen" size="3" id="peso_volumen" value="{$d.peso_volumen}" class="numeric saltoscrolldetalle" /></td>	 	 
	 <td><input type="text" name="guia_cliente" size="7" id="guia_cliente" value="{$d.guia_cliente}" class="saltoscrolldetalle" /></td>	 	 	 	 	 	 
	 <td><input type="text" name="observaciones" id="observaciones" value="{$d.observaciones}" class="saltoscrolldetalle" /></td>	 	 	 	 	 
     <td><a name="saveDetalleRemesa"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}

    <tr>
	 <td>
	   <input type="text" name="referencia_producto" size="6"  id="referencia_producto"  value="" class="required" />
       <input type="hidden" name="detalle_remesa_id" id="detalle_remesa_id" value="" />            
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value="" />	   
	 </td> 	 	 
	 <td><input type="text" name="descripcion_producto" id="descripcion_producto" size="20" value="" class="required" /></td>
	 <td><input type="text" name="cantidad" size="3"id="cantidad" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 
	 <td><input type="text" name="peso" size="3" id="peso" value="" class="numeric saltoscrolldetalle" /></td>	 
	 <td><input type="text" name="valor" size="3" id="valor" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 	 	 	 
	 <td><input type="text" name="largo" size="2" id="largo" value="" class="numeric saltoscrolldetalle" /></td>
	 <td><input type="text" name="ancho" size="2" id="ancho" value="" class="numeric saltoscrolldetalle" /></td>
	 <td><input type="text" name="alto" size="2" id="alto" value="" class="numeric saltoscrolldetalle" /></td>	 
	 <td><input type="text" name="peso_volumen" size="3" id="peso_volumen" value="" class="numeric saltoscrolldetalle" /></td>	 	 
	 <td><input type="text" name="guia_cliente" size="7" id="guia_cliente" value="" class="saltoscrolldetalle" /></td>	 	 	 
	 <td><input type="text" name="observaciones" id="observaciones" value="" class="saltoscrolldetalle" /></td>	 	 	 	 	 
     <td><a name="saveDetalleRemesa"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
	</tbody>
  </table>
  <table>
    <tr id="clon">
	 <td>
	   <input type="text" name="referencia_producto" size="6"  id="referencia_producto"  value="" class="required" />
       <input type="hidden" name="detalle_remesa_id" id="detalle_remesa_id" value="" />            
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value="" />	   
	 </td> 	 	 
	 <td><input type="text" name="descripcion_producto" id="descripcion_producto" size="20" value="" class="required" /></td>
	 <td><input type="text" name="cantidad" size="3"id="cantidad" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 
	 <td><input type="text" name="peso" size="3" id="peso" value="" class="numeric saltoscrolldetalle" /></td>	 
	 <td><input type="text" name="valor" size="3" id="valor" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 	 	 	 
	 <td><input type="text" name="largo" size="2" id="largo" value="" class="numeric saltoscrolldetalle" /></td>
	 <td><input type="text" name="ancho" size="2" id="ancho" value="" class="numeric saltoscrolldetalle" /></td>
	 <td><input type="text" name="alto" size="2" id="alto" value="" class="numeric saltoscrolldetalle" /></td>	 
	 <td><input type="text" name="peso_volumen" size="3" id="peso_volumen" value="" class="numeric saltoscrolldetalle" /></td>	 	 
	 <td><input type="text" name="guia_cliente" size="7" id="guia_cliente" value="" class="saltoscrolldetalle" /></td>	 	 	 
	 <td><input type="text" name="observaciones" id="observaciones" value="" class="saltoscrolldetalle" /></td>	 	 	 	 	 
     <td><a name="saveDetalleRemesa"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>
  </table>  
  </body>
</html>