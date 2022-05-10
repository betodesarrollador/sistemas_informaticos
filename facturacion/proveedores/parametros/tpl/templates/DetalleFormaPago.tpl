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
     <th>PUC</th>
     <th>BANCO</th>          
     <th>NATURALEZA</th>               	 
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="cuenta_tipo_pago_id" id="cuenta_tipo_pago_id" value="{$d.cuenta_tipo_pago_id}" />
       <input type="text" name="puc" value="{$d.puc}" size="60" class="required" />
	   <input type="hidden" name="puc_id" value="{$d.puc_id}" class="required" />
	 </td>
	 <td>
	   <select name="banco_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=bancos from=$BANCOS item=b}
		 <option value="{$b.value}" {if $b.value eq $d.banco_id}selected{/if}>{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
	 <td>
	   <select name="cuenta_tipo_pago_natu" class="required">
	     <option value="NULL">(... Seleccione ...)</option>
		 <option value="D" {if $d.cuenta_tipo_pago_natu eq 'D'}selected{/if}>DEBITO</option>	   
		 <option value="C" {if $d.cuenta_tipo_pago_natu eq 'C'}selected{/if}>CREDITO</option>	   		 
	   </select>
	 </td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}

    <tr>
	 <td>
	   <input type="hidden" name="cuenta_tipo_pago_id" id="cuenta_tipo_pago_id" value="" />
       <input type="text" name="puc" value="" size="60" class="required" />
	   <input type="hidden" name="puc_id" value="" class="required" />
	 </td>
	 <td>
	   <select name="banco_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=bancos from=$BANCOS item=b}
		 <option value="{$b.value}">{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
	 <td>
	   <select name="cuenta_tipo_pago_natu" class="required">
	     <option value="NULL">(... Seleccione ...)</option>
		 <option value="D">DEBITO</option>	   
		 <option value="C">CREDITO</option>	   		 
	   </select>
	 </td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>       
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	   <input type="hidden" name="cuenta_tipo_pago_id" id="cuenta_tipo_pago_id" value="" />
       <input type="text" name="puc" value="" size="60" />
	   <input type="hidden" name="puc_id" value="" />
	 </td>
	 <td>
	   <select name="banco_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=bancos from=$BANCOS item=b}
		 <option value="{$b.value}">{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
	 <td>
	   <select name="cuenta_tipo_pago_natu">
	     <option value="NULL">(... Seleccione ...)</option>
		 <option value="D">DEBITO</option>	   
		 <option value="C">CREDITO</option>	   		 
	   </select>
	 </td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>      
  </table>
  </div>
  </body>
</html>