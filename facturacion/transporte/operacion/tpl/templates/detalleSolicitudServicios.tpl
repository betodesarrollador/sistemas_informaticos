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
     <th>PLACA VEHICULO</th>	
     <th>ORDEN CLIENTE</th>
     <th>NOMBRE REMITENTE</th>          
     <th>TIPO ID REMITENTE</th>               	 
     <th>ID REMITENTE</th>               
     <th>DIR REMITENTE</th>               
     <th>CIUDAD ORIGEN MERCANCIA</th>          
     <th>TEL REMITENTE</th>                    
     <th>NOMBRE DESTINATARIO</th>         
     <th>TIPO ID DESTINATARIO</th>         	 
     <th>ID DESTINATARIO</th>                                         
     <th>DIR DESTINO MERCANCIA</th>                                   
     <th>CIUDAD DESTINO MERCANCIA</th>                              
     <th>TEL DESTINATARIO</th>                                        
     <th>REFERENCIA PRODUCTO</th>                                             
     <th>DESCRIPCION PRODUCTO</th>                                                  
     <th>CANTIDAD</th>                                                       
     <th>PESO</th>                                                            
     <th>UNIDAD</th>                                                                 
     <th>PESO VOLUMEN</th>
     <th>UNIDAD</th>     
     <th>VALOR DECLARADO</th>
     <th>OBSERVACIONES REMESA</th>
     <th>VALORES COMPLEMENTARIOS</th>
     <th>DESCRIPCION VLRS COMP</th>
      <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td><input type="text" name="shipment" id="shipment" value="{$d.shipment}" /></td>
     <td>
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value="{$d.detalle_ss_id}">            
       <input type="text" autocomplete="off" name="orden_despacho" id="orden_despacho" value="{$d.orden_despacho}" class=" " />
     </td>
     <td>
	   <input type="text" autocomplete="off" name="remitente" id="remitente" value="{$d.remitente}" class=" " />
	   <input type="hidden" autocomplete="off" name="remitente_id" id="remitente_id" value="{$d.remitente_id}" class=" " />	   
	 </td>          
	 <td>
	   <select name="tipo_identificacion_remitente_id" id="tipo_identificacion_remitente_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}" {if $d.tipo_identificacion_remitente_id eq $t.value}selected{/if}>{$t.text}</option>
		 {/foreach}
	   </select>
	 </td>
     <td>
	   <input type="text" autocomplete="off" name="doc_remitente" id="doc_remitente" value="{$d.doc_remitente}" class="  integer" />
	 </td>               
     <td>
       <input type="text" autocomplete="off" name="direccion_remitente" id="direccion_remitente" value="{$d.direccion_remitente}" class=" " />
     </td>  
     <td>
       <input type="text" autocomplete="off" name="origen" id="origen" value="{$d.origen}" class=" " />     
       <input type="hidden" name="origen_id" id="origen_id" value="{$d.origen_id}" class="  integer" />            
     </td>          
     <td>
      <input type="text" autocomplete="off" name="telefono_remitente" id="telefono_remitente" value="{$d.telefono_remitente}" class="  integer "/>
     </td>          
     <td>
	   <input type="text" autocomplete="off" name="destinatario" id="destinatario" value="{$d.destinatario}" class="  " />
	   <input type="hidden" autocomplete="off" name="destinatario_id" id="destinatario" value="{$d.destinatario_id}" class="  " />	   
	 </td>     
	 <td>
	   <select name="tipo_identificacion_destinatario_id" id="tipo_identificacion_destinatario_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}" {if $d.tipo_identificacion_destinatario_id eq $t.value}selected{/if}>{$t.text}</option>
		 {/foreach}
	   </select>	 	 
	 </td>
     <td>
       <input type="text" autocomplete="off" name="doc_destinatario" id="doc_destinatario" value="{$d.doc_destinatario}" class="  integer " />
     </td>          
     <td>
      <input type="text" autocomplete="off" name="direccion_destinatario" id="direccion_destinatario" value="{$d.direccion_destinatario}" class="  "/>
     </td> 
     <td>
       <input type="text" autocomplete="off" name="destino" id="destino" value="{$d.destino}" class="  " />     
       <input type="hidden" name="destino_id" id="destino_id" value="{$d.destino_id}" class="  integer" />            
     </td>      
     <td>
      <input type="text" autocomplete="off" name="telefono_destinatario" id="telefono_destinatario" value="{$d.telefono_destinatario}" class="  integer " />
     </td>     
     <td>
       <input type="text" autocomplete="off" name="referencia_producto" id="referencia_producto" value="{$d.referencia_producto}" class="  " />
     </td>     
     <td>
        <input type="text" autocomplete="off" name="descripcion_producto" id="descripcion_producto" value="{$d.descripcion_producto}" class="  " />
       <input type="hidden" name="producto_id" id="producto_id" value="{$d.producto_id}" class="  integer" />  
      </td>     
     <td><input type="text" autocomplete="off" name="cantidad" id="cantidad" value="{$d.cantidad}" class="  integer " /></td>          
     <td><input type="text" autocomplete="off" name="peso" id="peso" value="{$d.peso}" class="  integer " /></td>               
     <td>
       <select name="unidad_peso_id" class="  ">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADES item=u}
         <option value="{$u.value}" {if $u.value eq $d.unidad_peso_id }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                    
     <td><input type="text" autocomplete="off" name="peso_volumen" id="peso_volumen" value="{$d.peso_volumen}" class="  numeric" /></td>               
     <td>
       <select name="unidad_volumen_id" id="unidad_volumen_id" class="  ">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADESVOLUMEN item=u}
         <option value="{$u.value}" {if $u.value eq $d.unidad_volumen_id }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                                                     
     <td><input type="text" autocomplete="off" name="valor_unidad" id="valor_unidad" value="{$d.valor_unidad}" class="  numeric " /></td>
     <td>
       <input type="text" autocomplete="off" name="observaciones" id="observaciones" value="{$d.observaciones}" class="  " />
     </td>  
     <td><input type="text" autocomplete="off" name="valores_complementarios" id="valores_complementarios" value="{$d.valores_complementarios}" class="integer " /></td>       
     <td>
       <input type="text" autocomplete="off" name="descrip_val_comp" id="descrip_val_comp" value="{$d.descrip_val_comp}" class="  " />
     </td>         
     <td><a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
    
    
    
    

    <tr>
	 <td><input type="text" name="shipment" id="shipment" value="" /></td>	
     <td>
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" vaue="" >            
       <input type="text" autocomplete="off" name="orden_despacho" id="orden_despacho" value="" class="" />
     </td>
     <td>
	   <input type="text" autocomplete="off" name="remitente" id="remitente" value="" class="" />
	   <input type="hidden" autocomplete="off" name="remitente_id" id="remitente_id" value="" class="" />	   
	 </td>   
	<td>
	   <select name="tipo_identificacion_remitente_id" id="tipo_identificacion_remitente_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>
	 </td>	
     <td>
	   <input type="text" autocomplete="off" name="doc_remitente" id="doc_remitente" value="" class="  integer" />
	 </td>  
	 <td><input type="text" autocomplete="off" name="direccion_remitente" id="direccion_remitente" value="" class=" " /></td>   
     <td>
       <input type="text" autocomplete="off" name="origen" id="origen" value="" class=" ">     
       <input type="hidden" name="origen_id" id="origen_id" value="" class="  integer">            
     </td>     
	 
     <td><input type="text" autocomplete="off" name="telefono_remitente" id="telefono_remitente" value="" class="  integer " /></td>          
     <td>
	   <input type="text" autocomplete="off" name="destinatario" id="destinatario" value="" class=" " />
	   <input type="hidden" autocomplete="off" name="destinatario_id" id="destinatario" value="" class="  " />	   
	 </td>     
	 <td>
	   <select name="tipo_identificacion_destinatario_id" id="tipo_identificacion_destinatario_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>	 	 
	 </td>	 
     <td>
       <input type="text" autocomplete="off" name="doc_destinatario" id="doc_destinatario" value="" class="  integer " />
     </td>           
     <td><input type="text" autocomplete="off" name="direccion_destinatario" id="direccion_destinatario" value="" class="  " /></td>     
     <td>
       <input type="text" autocomplete="off" name="destino" id="destino" value="" class="  ">     
       <input type="hidden" name="destino_id" id="destino_id" value="" class="  integer">            
     </td>      
     <td><input type="text" autocomplete="off" name="telefono_destinatario" id="telefono_destinatario" value="" class="  integer " /></td>     
     <td><input type="text" autocomplete="off" name="referencia_producto" id="referencia_producto" value="" class="  " /></td>     
     <td><input type="text" autocomplete="off" name="descripcion_producto" id="descripcion_producto" value="" class="  " />
     <input type="hidden" name="producto_id" id="producto_id" value="" class="  integer" /></td>     
     <td><input type="text" autocomplete="off" name="cantidad" id="cantidad" value="" class="  integer " /></td>          
     <td><input type="text" autocomplete="off" name="peso" id="peso" value="" class="  integer " /></td>               
     <td>
       <select name="unidad_peso_id" class="  ">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADES item=u}
         <option value="{$u.value}" {if $u.value eq 39 }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                    
     <td><input type="text" autocomplete="off" name="peso_volumen" id="peso_volumen" value="" class="  integer " /></td>               
     <td>
       <select name="unidad_volumen_id" id="unidad_volumen_id" class="  ">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADESVOLUMEN item=u}
         <option value="{$u.value}" {if $u.value eq 54 }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                                                     
     <td><input type="text" autocomplete="off" name="valor_unidad" id="valor_unidad" value="" class="  integer " /></td>               
     <td><input type="text" autocomplete="off" name="observaciones" id="observaciones" value="" class="  " /></td>  
     <td><input type="text" autocomplete="off" name="valores_complementarios" id="valores_complementarios" value="" class="integer " /></td> 
      <td>
       <input type="text" autocomplete="off" name="descrip_val_comp" id="descrip_val_comp" value="" class="" />
     </td>               
     <td><a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>
   </tbody>
  </table>
  
  
  
  
  
  <table>
     <tr id="clon">
	 <td><input type="text" name="shipment" id="shipment" value="" /></td>		 
     <td>
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" vaue="" >            
       <input type="text" autocomplete="off" name="orden_despacho" id="orden_despacho" value="" class=" " />
     </td>
     <td>
	   <input type="text" autocomplete="off" name="remitente" id="remitente" value="" class=" " />
	   <input type="hidden" autocomplete="off" name="remitente_id" id="remitente_id" value="" class=" " />	   
	 </td>          
	 <td>
	   <select name="tipo_identificacion_remitente_id" id="tipo_identificacion_remitente_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>
	 </td>	 
     <td>
	   <input type="text" autocomplete="off" name="doc_remitente" id="doc_remitente" value="" class="  integer" />
	 </td>  
	 <td><input type="text" autocomplete="off" name="direccion_remitente" id="direccion_remitente" value="" class=" " /></td>   
     <td>
       <input type="text" autocomplete="off" name="origen" id="origen" value="" class=" ">     
       <input type="hidden" name="origen_id" id="origen_id" value="" class="  integer">            
     </td>     
	 
     <td><input type="text" autocomplete="off" name="telefono_remitente" id="telefono_remitente" value="" class="  integer " /></td>          
     <td>
	   <input type="text" autocomplete="off" name="destinatario" id="destinatario" value="" class="  " />
	   <input type="hidden" autocomplete="off" name="destinatario_id" id="destinatario" value="" class="  " />	   
	 </td>     
	 <td>
	   <select name="tipo_identificacion_destinatario_id" id="tipo_identificacion_destinatario_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>	 	 
	 </td>	 
     <td>
       <input type="text" autocomplete="off" name="doc_destinatario" id="doc_destinatario" value="" class="  integer " />
     </td>           
     <td><input type="text" autocomplete="off" name="direccion_destinatario" id="direccion_destinatario" value="" class="  " /></td>     
     <td>
       <input type="text" autocomplete="off" name="destino" id="destino" value="" class="  ">     
       <input type="hidden" name="destino_id" id="destino_id" value="" class="  integer">            
     </td>      
     <td><input type="text" autocomplete="off" name="telefono_destinatario" id="telefono_destinatario" value="" class="  integer " /></td>     
     <td><input type="text" autocomplete="off" name="referencia_producto" id="referencia_producto" value="" class="  " /></td>     
     <td><input type="text" autocomplete="off" name="descripcion_producto" id="descripcion_producto" value="" class="  " />
     <input type="hidden" name="producto_id" id="producto_id" value="" class="  integer" /></td>     
     <td><input type="text" autocomplete="off" name="cantidad" id="cantidad" value="" class="  integer " /></td>          
     <td><input type="text" autocomplete="off" name="peso" id="peso" value="" class="  integer " /></td>               
     <td>
       <select name="unidad_peso_id" class="  ">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADES item=u}
         <option value="{$u.value}" {if $u.selected }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                    
     <td><input type="text" autocomplete="off" name="peso_volumen" id="peso_volumen" value="" class="  numeric " /></td>               
     <td>
       <select name="unidad_volumen_id" id="unidad_volumen_id" class="  ">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADESVOLUMEN item=u}
         <option value="{$u.value}" {if $u.selected }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                                                     
     <td><input type="text" autocomplete="off" name="valor_unidad" id="valor_unidad" value="" class="  numeric " /></td>   
      <td><input type="text" autocomplete="off" name="observaciones" id="observaciones" value="" class="  " /></td>
      <td><input type="text" autocomplete="off" name="valores_complementarios" id="valores_complementarios" value="" class="integer " /></td>
       <td>
       <input type="text" autocomplete="off" name="descrip_val_comp" id="descrip_val_comp" value="" class=" " />
     </td>                            
     <td><a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>
  </table>
  
  </body>
</html>