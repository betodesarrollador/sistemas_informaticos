<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="abono_factura_proveedor_id" value="{$abono_factura_proveedor_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>TERCERO</th>
        <th>CC</th>
        <th>DESCRIPCION</th>		
        <th>BASE</th>
        <th>DEBITO</th>
        <th>CREDITO</th>        
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       

       	<input type="hidden" name="valor_total" value="{$i.valor_total}" class="required" />
        <input type="hidden" name="abonos" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" class="required" />        
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10" readonly  />
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />  
        <input type="hidden" name="item_abono_factura_id" value="{$i.item_abono_factura_id}" />        </td>
        <td {if $i.requiere_tercero neq '1'} class="no_requerido" {/if}>
          <input type="text" name="tercero" id="tercero" value="{$i.numero_identificacion}" {if $i.requiere_tercero eq '1'} class="required" {else} class = "no_requerido" {/if} title="{$i.tercero}" size="10" {if $i.requiere_tercero neq '1'}readonly{/if} />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}"></td>
        <td {if $i.requiere_centro_costo neq '1'} class="no_requerido" {/if}>
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.codigo}" {if $i.requiere_centro_costo eq '1'} class="required" {else} class = "no_requerido" {/if} title="{$i.centro_de_costo}" size="5" {if $i.requiere_centro_costo neq '1'}readonly{/if} />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        </td>
        <td><input type="text" name="desc_abono_factura" id="desc_abono_factura" value="{$i.desc_abono_factura}" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_abono_factura"   value="{$i.base_abono_factura}" maxlength="12"  size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_abono_factura" class="numeric" value="{$i.deb_item_abono_factura}" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_abono_factura" class="numeric" value="{$i.cre_item_abono_factura}" maxlength="15" size="12" /></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}	
      {if $estado_abono_factura eq 'A'}
      <tr>
        <td>       
		 	
        <input type="hidden" name="abono_factura_proveedor_id" value="{$i.abono_factura_proveedor_id}" class="required" />	  		
        <input type="hidden" name="relacion_abono_factura_id" value="{$i.relacion_abono_factura_id}" class="required" />	  
        <input type="text" name="puc" value="" class="required" title="" size="10"   />
        <input type="hidden" name="puc_id" value="" class="required" />  
        <input type="hidden" name="item_abono_factura_id" value="" />        </td>
        <td >
          <input type="text" name="tercero" id="tercero" value=""  />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value=""></td>
        <td >
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        </td>
        <td><input type="text" name="desc_abono_factura" id="desc_abono_factura" value="" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_abono_factura"   value="" maxlength="12"  size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a><input type="checkbox" name="procesar" style="display:none"/></td>
      </tr>	 
      {/if} 
      </tbody>
  </table>
   <table align="center" id="tableDetalles" width="98%">
   	<tbody>
      <tr id="clon">
        <td>       
		 	
        <input type="hidden" name="abono_factura_proveedor_id" value="{$i.abono_factura_proveedor_id}" class="required" />	  		
        <input type="hidden" name="relacion_abono_factura_id" value="{$i.relacion_abono_factura_id}" class="required" />	  
        <input type="text" name="puc" value="" class="required" title="" size="10"   />
        <input type="hidden" name="puc_id" value="" class="required" />  
        <input type="hidden" name="item_abono_factura_id" value="" />        </td>
        <td >
          <input type="text" name="tercero" id="tercero" value=""  />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value=""></td>
        <td >
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        </td>
        <td><input type="text" name="desc_abono_factura" id="desc_abono_factura" value="" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_abono_factura"   value="" maxlength="12"  size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a><input type="checkbox" name="procesar" style="display:none"/></td>
      </tr>	  
	</tbody>
  </table>
  </body>
</html>