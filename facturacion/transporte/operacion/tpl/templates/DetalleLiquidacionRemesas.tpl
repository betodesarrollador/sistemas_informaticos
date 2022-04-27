<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="solicitud_id" value="{$SOLICITUDID}" />
  <table id="tableSolicitudServicios">
   <thead>
    <tr>
     <th>REMESA</th>	
     <th>CLIENTE</th>
     <th>REMITENTE</th>          
     <th>DESTINATARIO</th>               	 
     <th>PRODUCTO</th>               
     <th>UNIDAD</th>               
     <th></th>          
     <th>PESO</th>                    
	 <th>VOLUMEN</th>
	 <th>DOCTO. CLIENTE</th>
	 <th>TIPO LIQUIDACION</th>
	 <th>VALOR UNIDAD</th>
	 <th>VALOR FACTURAR</th>
     <th>RENTABILIDAD</th>
     <th>% RENT.</th>
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    {math assign="utilidad" equation="(X-Y)" X=$d.valor_facturar Y=$d.valor_costo} 
    {math assign="porcutilidad" equation="(X/Y)*100" X=$utilidad Y=$d.valor_facturar}
    <tr>
	 <td>
       <input type="hidden" name="remesa_id"       value="{$d.remesa_id}" size="8" readonly />	 
	   <input type="text"   name="numero_remesa"   value="{$d.numero_remesa}" size="8" readonly />
	 </td>
     <td>
     	<input type="text" name="cliente"      value="{$d.cliente}" size="30"  />
     	<input type="hidden" name="cliente_id"      value="{$d.cliente_id}"   />
     </td>
     <td><input type="text" name="remitente"    value="{$d.remitente}" readonly /></td>          
     <td><input type="text" name="destinatario" value="{$d.destinatario}" readonly /></td>          
     <td><input type="text" name="producto"     value="{$d.descripcion_producto}" readonly /></td>          	 
     <td><input type="text" name="unidad"       value="{$d.unidad}" readonly /></td>          	 	 
     <td><input type="text" name="cantidad"     value="{$d.cantidad}" class="required" /></td>          	 	 	 
     <td><input type="text" name="peso"         value="{$d.peso}" /></td>   
     <td><input type="text" name="peso_volumen"      value="{$d.peso_volumen}" readonly /></td>   	 
	 <td><input type="text" name="documento_cliente" value="{$d.orden_despacho}" /></td>
     <td>
	   <select name="tipo_liquidacion">
	     <option value="NULL">( Seleccione )</option>
         <option value="G" {if $d.tipo_liquidacion eq 'G'}selected{/if}>Cant/Gls</option>
		 <option value="P" {if $d.tipo_liquidacion eq 'P'}selected{/if}>Peso</option>
		 <option value="V" {if $d.tipo_liquidacion eq 'V'}selected{/if}>Volumen</option>		 
		 <option value="C" {if $d.tipo_liquidacion eq 'C'}selected{/if}>Cupo</option>		 		 
	   </select>
	 </td>          	 	 	 	 
     <td><input type="text" name="valor_unidad_facturar"    value="{$d.valor_unidad_facturar}"/></td>          	 	 	 	 	 
     <td><input type="text" name="valor_facturar"           value="{$d.valor_facturar}"/></td>  
     <td><input type="text" name="rentabilidad"       		value="{$utilidad|number_format:2:',':'.'}" readonly /></td>
     <td><input type="text" name="porcentaje"       		value="{$porcutilidad|number_format:2:',':'.'}" readonly /></td>         	 	 	 	 	 	 
        	 	 	 	 	 	 
     <td>{if $d.estado eq 'MF' or $d.estado eq 'LQ' or $d.estado eq 'PD'  or $d.estado eq 'PC'}<a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a>{/if}</td>
     <td>{if $d.estado eq 'MF' or $d.estado eq 'LQ' or $d.estado eq 'PD' or $d.estado eq 'PC' }<input type="checkbox" name="procesar" />{/if}</td>     
    </tr>   
    {/foreach}

   </tbody>
  </table>
  </body>
</html>