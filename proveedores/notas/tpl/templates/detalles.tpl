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
       <th width="10%">CODIGO</th>
        <th width="10%">TERCERO</th>
        <th width="5%">SUCURSAL</th>
        <th width="5%"> CC</th>
        <th width="5%">DEPTO.</th>
        <th width="5%">AREA</th>
        <th width="5%">UND NEGOCIO</th>
        <th width="15%">DESCRIPCION</th>		
        <th width="10%">BASE</th>
        <th width="10%">DEBITO</th>
        <th width="10%" >CREDITO</th>  
        {if $estado_abono_factura eq 'A'}
		 <th width="10%"><input type="checkbox" id="checkedAll"></th>
         {/if}
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
       	<input type="hidden" name="valor_total" value="{$i.valor_total}" class="required" />
        <input type="hidden" name="abonos" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" class="required" />        
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10"   />
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />  
        <input type="hidden" name="item_abono_factura_id" value="{$i.item_abono_factura_id}" />        </td>
        <td {if $i.requiere_tercero neq '1'} class="no_requerido" {/if}>
          <input type="text" name="tercero" id="tercero" value="{$i.numero_identificacion}" {if $i.requiere_tercero eq '1'} class="required" {else} class = "no_requerido" {/if} title="{$i.tercero}" size="10" {if $i.requiere_tercero neq '1'}readonly{/if} />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}"></td>
        <td class="no_requerido" width="5%">
          <input type="text" name="sucursal" id="sucursal" value="{$i.sucursal}" class = "no_requerido" readonly title="{$i.sucursal}" size="5" />
          <input name="sucursal_id" id="sucursal_hidden" type="hidden" value="{$i.sucursal_id}">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.codigo}" class = "no_requerido" readonly title="{$i.centro_de_costo}" size="5" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="departamento" id="departamento" value="{$i.codigo_dep}" class = "no_requerido" readonly title="{$i.departamento}" size="5" />
          <input name="departamento_id" id="departamento_hidden" type="hidden" value="{$i.departamento_id}">        
		</td>
       <td class="no_requerido" width="5%">
          <input type="text" name="area" id="area" value="{$i.codigo_area}" class = "no_requerido" readonly title="{$i.area}" size="5" />
          <input name="area_id" id="area_hidden" type="hidden" value="{$i.area_id}">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="unidadnegocio" id="unidadnegocio" value="{$i.nombre_unidad}" class = "no_requerido" readonly title="{$i.unidadnegocio}" size="5" />
          <input name="unidad_negocio_id" id="unidadnegocio_hidden" type="hidden" value="{$i.unidad_negocio_id}">        
		</td>
       
        <td><input type="text" name="desc_abono_factura" id="desc_abono_factura" value="{$i.desc_abono_factura}" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_abono_factura"   value="{$i.base_abono_factura}" maxlength="12"  size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_abono_factura" class="numeric" value="{$i.deb_item_abono_factura}" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_abono_factura" class="numeric" value="{$i.cre_item_abono_factura}" maxlength="15" size="12" /></td>
        {if $estado_abono_factura eq 'A'}
        <td><input type="checkbox" name="procesar" /></td>
        {/if}
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
        <td class="no_requerido" width="5%">
          <input type="text" name="sucursal" id="sucursal" value="" class = "no_requerido"  size="5" />
          <input name="sucursal_id" id="sucursal_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="" size="5" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="departamento" id="departamento" value="" size="5" />
          <input name="departamento_id" id="departamento_hidden" type="hidden" value="">        
		</td>
       <td class="no_requerido" width="5%">
          <input type="text" name="area" id="area" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="area_id" id="area_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="unidadnegocio" id="unidadnegocio" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="unidad_negocio_id" id="unidadnegocio_hidden" type="hidden" value="">        
		</td>
       
        <td><input type="text" name="desc_abono_factura" id="desc_abono_factura" value="" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_abono_factura"   value="" maxlength="12"  size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
      </tr>	
      {/if}
       </tbody>
  </table>
   <table align="center" id="tableDetalles" width="98%">
   	<tbody>
      <tr id="clon" style="display:none">
        <td>       
		 	
        <input type="hidden" name="abono_factura_proveedor_id" value="{$i.abono_factura_proveedor_id}" class="required" />	  		
        <input type="hidden" name="relacion_abono_factura_id" value="{$i.relacion_abono_factura_id}" class="required" />	  
        <input type="text" name="puc" value="" class="required" title="" size="10"   />
        <input type="hidden" name="puc_id" value="" class="required" />  
        <input type="hidden" name="item_abono_factura_id" value="" />        </td>
        <td >
          <input type="text" name="tercero" id="tercero" value=""  />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value=""></td>
        <td class="no_requerido" width="5%">
          <input type="text" name="sucursal" id="sucursal" value="" class = "no_requerido"  size="5" />
          <input name="sucursal_id" id="sucursal_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="" size="5" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="departamento" id="departamento" value="" size="5" />
          <input name="departamento_id" id="departamento_hidden" type="hidden" value="">        
		</td>
       <td class="no_requerido" width="5%">
          <input type="text" name="area" id="area" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="area_id" id="area_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido" width="5%">
          <input type="text" name="unidadnegocio" id="unidadnegocio" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="unidad_negocio_id" id="unidadnegocio_hidden" type="hidden" value="">        
		</td>
        <td><input type="text" name="desc_abono_factura" id="desc_abono_factura" value="" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_abono_factura"   value="" maxlength="12"  size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_abono_factura" class="numeric" value="" maxlength="15" size="12" /></td>
     <td><a name="saveDetalle"><img src="/rotterdan/framework/media/images/grid/save.png" /></a></td>
      </tr>	    	
	</tbody>
  </table>
  </body>
</html>