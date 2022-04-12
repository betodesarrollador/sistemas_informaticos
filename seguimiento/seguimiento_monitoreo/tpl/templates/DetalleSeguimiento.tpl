<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="trafico_id" value="{$TRAFICOID}" />
  <input type="hidden" id="FechaSalida" value="{$FECHASALIDA}"/>
  <input type="hidden" id="HoraSalida" value="{$HORASALIDA}"/>
  <input type="hidden" id="FechaActual" value="{$FECHAACTUAL}"/>
  <input type="hidden" id="HoraActual" value="{$HORAACTUAL}"/>
  
  <table align="center" id="tableDetalleSeguimiento">
    <thead>
      <tr>
        <th width="3%">ORDEN</th>
        <th width="15%">PUNTO O CIUDAD </th>  
		<th>TIPO PUNTO</th>      
        {*<th width="15%">UBICACION</th>*}
        <th width="5%">FECHA</th>
        <th width="5%">HORA</th>
        <th>NOVEDAD</th>        
        <th width="15%">OBSERVACI&Oacute;N</th>         
        <th width="8%">REMESA</th>         
        <th>CAUSAL</th> 
         <!--<th width="7%">&nbsp;</th>-->
         <th width="2%">&nbsp;</th>
         <th>&nbsp;</th>		 
         <th width="2%"><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLESSEGUIMIENTO item=d}
      <tr class="detalleSeguimiento">
        <td><input type="hidden" name="detalle_seg_id" value="{$d.detalle_seg_id}" /><input type="hidden" name="detalle_ruta_id" value="{$d.detalle_ruta_id}" /><input type="text" name="orden_det_ruta" value="{$d.orden_det_ruta}" size="1" readonly="readonly" /></td>
        <td><input type="text" name="punto_referencia" id="punto_referencia" title="{$d.punto_referencia}" value="{$d.punto_referencia}" size="28" class="" /><input name="punto_referencia_id" id="punto_referencia_id" type="hidden" value="{$d.punto_referencia_id}" class=""><input name="ubicacion_id" id="ubicacion_id" type="hidden" value="{$d.ubicacion_id}" ></td>        
		<td><input type="text" name="tipo_punto" id="tipo_punto" value="{$d.tipo_punto}" readonly /></td>
        {*<td><input type="text" name="ubicacion" id="ubicacion" title="{$d.ubicacion}" value="{$d.ubicacion}" size="25" {if $d.punto_referencia_id neq ''} readonly {/if}  /><input name="ubicacion_id" id="ubicacion_id" type="hidden" value="{$d.ubicacion_id}" class="required"></td>*}
        <td><input type="text" name="fecha_reporte" readonly value="{if $d.fecha_reporte eq ''}{$FECHAACTUAL}{else}{$d.fecha_reporte}{/if}" size="9" class="date required" /></td>
        <td><input type="text" name="hora_reporte" readonly value="{if $d.hora_reporte eq ''}{$HORAACTUAL}{else}{$d.hora_reporte}{/if}" size="8" class="time required" /></td>        
        <td>
        	<select style="width:160px;" name="novedad_id" onChange="comprobar_novedad(this);"> 
                <option value="NULL">NINGUNA</option>
                {foreach name=novedad from=$NOVEDAD item=l}	        		
                    <option value="{$l.value}" {if $d.novedad_id eq $l.value} selected="selected" {/if} >{$l.text}</option>
                {/foreach}
            </select>        
        </td>        
        <td><input type="text" name="obser_deta" value="{$d.obser_deta}"  /></td>
        <td>
        	<select style="width:160px;" name="remesa_id" disabled> 
                <option value="NULL">NINGUNA</option>
                {foreach name=remesa from=$REMESAS item=x}	        		
                    <option value="{$x.value}" {if $d.remesa_id eq $x.value} selected="selected" {/if}  >{$x.text}</option> 
                {/foreach}
            </select>        
        </td><!--<td class="no_requerido" ><input type="text" name="remesas" value="{$d.remesas}" class="no_requerido" readonly />&nbsp;</td>-->    
        
        <td style="max-width:160px;">
        	<select style="width:160px;" name="causal_devolucion_id" disabled> 
                <option value="NULL">NINGUNA</option>
                {foreach name=causal from=$CAUSAL item=x}	        		
                    <option value="{$x.value}" {if $d.causal_devolucion_paqueteo_id eq $x.value} selected="selected" {/if} >{$x.text}</option> <!--{if $d.novedad_id eq $x.value} selected="selected" {/if}-->
                {/foreach}
            </select>        
        </td>        
        
          
        <!--<td class="no_requerido" ><a name="AsignRemesas"><img src="../../../framework/media/images/grid/settings.gif" id="edit_remesas" alt="Remesas" title="Editar Asignaci&oacute;n de Remesas" /></a></td>-->
       
        <td> {if $d.estado_trafico neq 'F' &&  $d.estado_trafico neq 'A'}<a name="saveDetalleSeguimiento" href="javascript:void(0)" onClick="agregar(this)"><img src="../../../framework/media/images/grid/add.png" /></a> {/if}</td>
        <td> {if $d.estado_trafico neq 'F' &&  $d.estado_trafico neq 'A'}<a href="javascript:void(0)" onClick="deleteDetalleSeguimiento(this)"><img src="/roa/framework/media/images/grid/close.png" /></a> {/if}</td>		
        <td> {if $d.estado_trafico neq 'F' &&  $d.estado_trafico neq 'A'}
        	<input type="checkbox" name="procesar" />
	        <input type="hidden" name="fecha_hora_registro" value="{if $d.fecha_hora_registro eq ''}{$FECHAACTUAL} {$HORAACTUAL}{else}{$d.fecha_hora_registro}{/if}" size="15" class="required" readonly />        
			 {/if}		
        </td>
       
      </tr>	  
	  {/foreach}	
	  
	  {if COUNT($DETALLESSEGUIMIENTO) eq 0}
      <tr class="detalleSeguimiento">
        <td><input type="hidden" name="detalle_seg_id" value="{$d.detalle_seg_id}" /><input type="hidden" name="detalle_ruta_id" value="{$d.detalle_ruta_id}" /><input type="text" name="orden_det_ruta" value="{$d.orden_det_ruta}" size="1" readonly="readonly" /></td>
        <td><input type="text" name="punto_referencia" id="punto_referencia" title="{$d.punto_referencia}" value="{$d.punto_referencia}" size="28" class="" /><input name="punto_referencia_id" id="punto_referencia_id" type="hidden" value="{$d.punto_referencia_id}" class=""><input name="ubicacion_id" id="ubicacion_id" type="hidden" value="{$d.ubicacion_id}" ></td>        
		<td><input type="text" name="tipo_punto" id="tipo_punto" value="{$d.tipo_punto}" readonly /></td>
        {*<td><input type="text" name="ubicacion" id="ubicacion" title="{$d.ubicacion}" value="{$d.ubicacion}" size="25" {if $d.punto_referencia_id neq ''} readonly {/if}  /><input name="ubicacion_id" id="ubicacion_id" type="hidden" value="{$d.ubicacion_id}" class="required"></td>*}
        <td><input type="text" name="fecha_reporte" readonly value="{if $d.fecha_reporte eq ''}{$FECHAACTUAL}{else}{$d.fecha_reporte}{/if}" size="9" class="date required" /></td>
        <td><input type="text" name="hora_reporte" readonly value="{if $d.hora_reporte eq ''}{$HORAACTUAL}{else}{$d.hora_reporte}{/if}" size="8" class="time required" /></td>        
        <td>
        	<select style="width:160px;"  name="novedad_id" onChange="comprobar_novedad(this);"> 
                <option value="NULL">NINGUNA</option>
                {foreach name=novedad from=$NOVEDAD item=l}	        		
                    <option value="{$l.value}" {if $d.novedad_id eq $l.value} selected="selected" {/if} >{$l.text}</option>
                {/foreach}
            </select>        </td>        
        <td><input type="text" name="obser_deta" value="{$d.obser_deta}"  /></td>
        <td>
        	<select style="width:160px;" name="remesa_id" disabled> 
                <option value="NULL">NINGUNA</option>
                {foreach name=remesa from=$REMESAS item=x}	        		
                    <option value="{$x.value}"  >{$x.text}</option> 
                {/foreach}
            </select>        
        </td><!--<td class="no_requerido" ><input type="text" name="remesas" value="{$d.remesas}" class="no_requerido" readonly />&nbsp;</td>-->    
        <td>
        	<select style="width:160px;" name="causal_devolucion_id" disabled> 
                <option value="NULL">NINGUNA</option>
                {foreach name=causal from=$CAUSAL item=x}	        		
                    <option value="{$x.value}"  >{$x.text}</option> 
                {/foreach}
            </select>        
        </td> 
        <!--<td class="no_requerido" ><a name="AsignRemesas"><img src="../../../framework/media/images/grid/settings.gif" id="edit_remesas" alt="Remesas" title="Editar Asignaci&oacute;n de Remesas" /></a></td>-->
        <td>{if $d.estado_trafico neq 'F' &&  $d.estado_trafico neq 'A'}<a name="saveDetalleSeguimiento" href="javascript:void(0)" onClick="agregar(this)"><img src="../../../framework/media/images/grid/add.png" /></a>{/if}</td>
        <td>{if $d.estado_trafico neq 'F' &&  $d.estado_trafico neq 'A'}<a href="javascript:void(0)" onClick="deleteDetalleSeguimiento(this)"><img src="/roa/framework/media/images/grid/close.png" /></a>{/if}</td>		
        <td>{if $d.estado_trafico neq 'F' &&  $d.estado_trafico neq 'A'}
        	<input type="checkbox" name="procesar" />
	        <input type="hidden" name="fecha_hora_registro" value="{if $d.fecha_hora_registro eq ''}{$FECHAACTUAL} {$HORAACTUAL}{else}{$d.fecha_hora_registro}{/if}" size="15" class="required" readonly />        </td>
		    {/if} 
      </tr>	  	  
	  {/if} 
	</tbody>
  </table>
  <table>
      <tr id="clon">
        <td ><input type="hidden" name="detalle_seg_id" /><input type="hidden" name="detalle_ruta_id" value="" /><input type="text" name="orden_det_ruta" size="1" value="" readonly="readonly" /></td>
        <td><input type="text" name="punto_referencia" id="punto_referencia" size="28" value="" class="" /><input name="punto_referencia_id" id="punto_referencia_id" type="hidden" value="" class=""><input name="ubicacion_id" id="ubicacion_id"  type="hidden" /></td>        
		<td><input type="text" name="tipo_punto" id="tipo_punto" value="" /></td>		
        {*<td><input type="text" name="ubicacion" id="ubicacion" size="25" /><input name="ubicacion_id" id="ubicacion_id" class="required" type="hidden" /></td>*}
        <td><input type="text" name="fecha_reporte" readonly value="{$FECHAACTUAL}" size="9"  class="date required" /></td>
        <td><input type="text" name="hora_reporte" readonly value="{$HORAACTUAL}"  size="8"  class="time required" /></td>        
        <td>
        	<select style="width:160px;"  name="novedad_id" onChange="comprobar_novedad(this);"> 
                <option value="NULL">NINGUNA</option>
                {foreach name=novedad from=$NOVEDAD item=l}	        		
                    <option value="{$l.value}">{$l.text}</option>
                {/foreach}
            </select>        </td>        
        <td><input type="text" name="obser_deta" value=""  /></td>
        <td>
        	<select style="width:160px;" name="remesa_id" disabled> 
                <option value="NULL">NINGUNA</option>
                {foreach name=remesa from=$REMESAS item=x}	        		
                    <option value="{$x.value}"  >{$x.text}</option> 
                {/foreach}
            </select>        
        </td><!--<td class="no_requerido" ><input type="text" name="remesas" value="" class="no_requerido" readonly />&nbsp;</td>-->    
        <td>
        	<select style="width:160px;" name="causal_devolucion_id" disabled> 
                <option value="NULL">NINGUNA</option>
                {foreach name=causal from=$CAUSAL item=x}	        		
                    <option value="{$x.value}"  >{$x.text}</option>
                {/foreach}
            </select>        
        </td>        
        
        <!--<td class="no_requerido" ><a name="AsignRemesas"><img src="../../../framework/media/images/grid/settings.gif" id="edit_remesas" alt="Remesas" title="Editar Asignaci&oacute;n de Remesas" /></a></td>-->
        <td><a name="saveDetalleSeguimiento" href="javascript:void(0)" onClick="agregar(this)"><img src="../../../framework/media/images/grid/add.png" /></a></td>
		<td><a href="javascript:void(0)" onClick="deleteDetalleSeguimiento(this)"><img src="/roa/framework/media/images/grid/close.png" /></a></td>
        <td>
        	<input type="checkbox" name="procesar" />
			<input type="hidden" name="fecha_hora_registro" value="{$FECHAACTUAL} {$HORAACTUAL}" size="15" class="required" readonly />		</td>           
      </tr>	 
  </table>
  </body>
</html>