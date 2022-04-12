<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <div align="center" style="width: auto;">
  <input type="hidden" id="acta_id" name="acta_id" value="{$ACTAID}" />
  <table id="tableDetalle" align="center">
   <thead>
    <tr>
     <th>Tema Tratado</th>              	 
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>
    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="tema_id" id="tema_id" value="{$d.tema_id}" />
       <input type="textarea" name="tema" size="100%" value="{$d.tema}" class="required" />
	 </td>
	 {* <td>
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
	 </td>*}
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
    <tr>
	 <td>
	   <input type="hidden" name="tema_id" id="tema_id" value="" />
       <input type="textarea" name="tema" value="" size="100%" class="required" />
	 </td>
	 {* <td>
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
	 </td> *}
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>       
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	   <input type="hidden" name="tema_id" id="tema_id" value="" />
       <input type="textarea" name="tema" value="" size="100%" />
	 </td>
	 {* <td>
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
	 </td> *}
     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>      
  </table>
  </div>
  </body>
</html>