<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="orden_compra_id" value="{$orden_compra_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th>CANTIDAD</th>
        <th>REMESA</th>      
        <th>DESCRIPCION</th>		
        <th>V/r UNITARIO</th>  
        <th>VALOR TOTAL</th>                
        <th id="titleSave">&nbsp;</th>                
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
            <input type="text" name="cant_item_liquida_orden" id="cant_item_liquida_orden" value="{$i.cant_item_liquida_orden}" class="required numeric"  size="10" {if $i.estado_orden_compra neq 'A'}readonly{/if}  />
            <input type="hidden" name="item_liquida_orden_id" value="{$i.item_liquida_orden_id}"  />        
        </td>
        <td>
            <input type="text" name="remesa" id="remesa" value="{$i.remesa}" class="" {if $i.estado_orden_compra neq 'A'}readonly{/if}  size="10"  />
            <input type="hidden" name="remesa_id" id="remesa_id" value="{$i.remesa_id}"  />        
        </td>
        
        <td><input type="text" name="desc_item_liquida_orden" id="desc_item_liquida_orden" value="{$i.desc_item_liquida_orden}" class="required" {if $i.estado_orden_compra neq 'A'}readonly{/if} /></td>		        
        <td><input type="text" name="valoruni_item_liquida_orden" id="valoruni_item_liquida_orden" value="{$i.valoruni_item_liquida_orden}" class="required numeric"  {if $i.estado_orden_compra neq 'A'}readonly{/if} /></td>
		<td><input type="text" name="valor_total" id="valor_total" value="{math equation="x * y" x=$i.cant_item_liquida_orden y=$i.valoruni_item_liquida_orden}" class="numeric no_requerido" readonly /></td>        
        <td>{if $i.estado_orden_compra eq 'A'}<a name="saveDetalles"><img src="/rotterdan/framework/media/images/grid/add.png" /></a>{/if}</td>
        <td>{if $i.estado_orden_compra eq 'A'}<input type="checkbox" name="procesar" />{/if}</td>
      </tr> 
	  {/foreach}	
      {if $i.estado_orden_compra eq 'A'}
      <tr>
        <td>       
            <input type="text" name="cant_item_liquida_orden" id="cant_item_liquida_orden" value="" class="required numeric"  size="10"  />
            <input type="hidden" name="item_liquida_orden_id" value=""  />        
        </td>  
        <td>
            <input type="text" name="remesa" id="remesa" value="" class=""  size="10"  />
            <input type="hidden" name="remesa_id" id="remesa_id"  value=""  />        
        </td>
          
        <td><input type="text" name="desc_item_liquida_orden" id="desc_item_liquida_orden" value=""  class="required"  /></td>		        
        <td><input type="text" name="valoruni_item_liquida_orden" id="valoruni_item_liquida_orden" value=""  class="required numeric"  /></td>
		<td><input type="text" name="valor_total" id="valor_total" value="" class="numeric no_requerido" readonly /></td>        
        <td><a name="saveDetalles"><img src="/rotterdan/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
      {/if}
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
            <input type="text" name="cant_item_liquida_orden" id="cant_item_liquida_orden" value="" class="required numeric"  size="10"  />
            <input type="hidden" name="item_liquida_orden_id" value=""  />        
        </td>
        <td>
            <input type="text" name="remesa" id="remesa" value="" class=""  size="10"  />
            <input type="hidden" name="remesa_id" id="remesa_id"  value=""  />        
        </td>

        <td><input type="text" name="desc_item_liquida_orden" id="desc_item_liquida_orden" value="" class="required" /></td>		        
        <td><input type="text" name="valoruni_item_liquida_orden" id="valoruni_item_liquida_orden" value="" class="required numeric" /></td>
		<td><input type="text" name="valor_total" id="valor_total" value=""class="numeric no_requerido" readonly /></td>        
        <td><a name="saveDetalles"><img src="/rotterdan/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>