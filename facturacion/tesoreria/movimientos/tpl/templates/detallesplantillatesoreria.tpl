<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="plantilla_tesoreria_id" value="{$plantilla_tesoreria_id}" />
  <input type="hidden" id="tipo" value="{$TIPO}" />
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
		{if $TIPO neq '0'}<th>CONTRAPARTIDA</th>{/if}              
        <th>&nbsp;</th>		
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
    {if $TIPO eq '0'}
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10" readonly  />
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />        
        <input type="hidden" name="item_plantilla_tesoreria_id" value="{$i.item_plantilla_tesoreria_id}" /> </td>
        <td {if $i.requiere_tercero neq '1'} class="no_requerido" {/if}>
          <input type="text" name="tercero" id="tercero" value="{$i.numero_identificacion}" {if $i.requiere_tercero eq '1'} class="required" {else} class = "no_requerido" {/if} title="{$i.tercero}" size="10" {if $i.requiere_tercero neq '1' or $TERCERO_IN eq '0'}readonly{/if} />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}"></td>
        <td {if $i.requiere_centro_costo neq '1'} class="no_requerido" {/if}>
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.codigo}" {if $i.requiere_centro_costo eq '1'} class="required" {else} class = "no_requerido" {/if} title="{$i.centro_de_costo}" size="5" {if $i.requiere_centro_costo neq '1' or $CENTRO_IN eq '0'}readonly{/if} />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        </td>
        <td><input type="text" name="desc_plantilla_tesoreria" id="desc_plantilla_tesoreria" value="{$i.desc_plantilla_tesoreria}" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_plantilla_tesoreria" value="{$i.base_plantilla_tesoreria}" maxlength="12" size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_plantilla_tesoreria" class="numeric" value="{$i.deb_item_plantilla_tesoreria}" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_plantilla_tesoreria" class="numeric" value="{$i.cre_item_plantilla_tesoreria}" maxlength="15" size="12" /></td>
        <td>{if $i.estado neq 'C' and $i.estado neq 'I'}<a name="saveDetalle"><img src="/envipack/framework/media/images/grid/save.png" /></a>{/if}</td>		
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}	
    {else}
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10" />
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />        
        <input type="hidden" name="item_plantilla_tesoreria_id" value="{$i.item_plantilla_tesoreria_id}" /></td>
        <td {if $i.requiere_tercero neq '1'} class="no_requerido" {/if}>
          <input type="text" name="tercero" id="tercero" value="{$i.numero_identificacion}" {if $i.requiere_tercero eq '1'} class="required" {else} class = "no_requerido" {/if} title="{$i.tercero}" size="10" {if $i.requiere_tercero neq '1' or $TERCERO_IN eq '0'}readonly{/if} />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}"></td>
        <td {if $i.requiere_centro_costo neq '1'} class="no_requerido" {/if}>
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.codigo}" {if $i.requiere_centro_costo eq '1'} class="required" {else} class = "no_requerido" {/if} title="{$i.centro_de_costo}" size="5" {if $i.requiere_centro_costo neq '1' or $CENTRO_IN eq '0'}readonly{/if} />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        </td>
        <td><input type="text" name="desc_plantilla_tesoreria" id="desc_plantilla_tesoreria" value="{$i.desc_plantilla_tesoreria}" class="text" /></td>		        
        <td {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="no_requerido" {/if}>
          <input type="text" name="base_plantilla_tesoreria" value="{$i.base_plantilla_tesoreria}" maxlength="12"  size="15" {if $i.requiere_base_ofi eq '0' and $i.requiere_base_emp eq '0'} class="numeric no_requerido" readonly {else} class="numeric required" {/if}  /></td>
        <td><input type="text" name="deb_item_plantilla_tesoreria" class="numeric required" value="{$i.deb_item_plantilla_tesoreria}" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_plantilla_tesoreria" class="numeric required" value="{$i.cre_item_plantilla_tesoreria}" maxlength="15" size="12" /></td>
        <td>
        	<input type="radio" name="contra_plantilla_tesoreria" value="1" {if $i.contra_plantilla_tesoreria_id eq '1'}checked{/if} />
        </td>
        <td>{if $i.estado neq 'C' and $i.estado neq 'I'}<a name="saveAgregar"><img src="/envipack/framework/media/images/grid/save.png" /></a>{/if}</td>		
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}
      <tr>
        <td>       
           <input type="text" name="puc" value="" class="required" title="" size="10"  />
           <input type="hidden" name="puc_id" value="" class="required" />        
           <input type="hidden" name="item_plantilla_tesoreria_id" value="" />
        </td>
        <td>
           <input type="text" name="tercero" id="tercero" value="" class = "no_requerido"  title="" size="10"  />
           <input name="tercero_id" id="tercero_hidden" type="hidden" value="">
        </td>
        <td>
           <input type="text" name="centro_de_costo" id="centro_de_costo" value=""  class = "no_requerido"  title="" size="5" />
           <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">
        </td>
        <td><input type="text" name="desc_plantilla_tesoreria" id="desc_plantilla_tesoreria" value="" class="text" /></td>		        
        <td><input type="text" name="base_plantilla_tesoreria" value="" maxlength="12"  size="15"  class="numeric no_requerido" readonly   /></td>
        <td><input type="text" name="deb_item_plantilla_tesoreria" class="numeric required" value="" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_plantilla_tesoreria" class="numeric required" value="" maxlength="15" size="12" /></td>
        <td><input type="radio" name="contra_plantilla_tesoreria" value="1" /></td>        
        <td>{if $i.estado neq 'C' and $i.estado neq 'I'}<a name="saveAgregar"><img src="/envipack/framework/media/images/grid/add.png" /></a>{/if}</td>		
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
      
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
           <input type="text" name="puc" value="" class="required" title="" size="10"  />
           <input type="hidden" name="puc_id" value="" class="required" />        
           <input type="hidden" name="item_plantilla_tesoreria_id" value="" />
        </td>
        <td>
           <input type="text" name="tercero" id="tercero" value=""  class = "no_requerido"  title="" size="10"  />
           <input name="tercero_id" id="tercero_hidden" type="hidden" value="">
        </td>
        <td>
           <input type="text" name="centro_de_costo" id="centro_de_costo" value="" class = "no_requerido" title="" size="5" />
           <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        
        </td>
        <td><input type="text" name="desc_plantilla_tesoreria" id="desc_plantilla_tesoreria" value="" class="text" /></td>		        
        <td><input type="text" name="base_plantilla_tesoreria" value="" maxlength="12"  size="15"  class="numeric no_requerido" readonly /></td>
        <td><input type="text" name="deb_item_plantilla_tesoreria" class="numeric required" value="" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_plantilla_tesoreria" class="numeric required" value="" maxlength="15" size="12" /></td>
        <td>
        	<input type="radio" name="contra_plantilla_tesoreria" value="1" />
        </td>
        <td>{if $i.estado neq 'C' and $i.estado neq 'I'}<a name="saveAgregar"><img src="/envipack/framework/media/images/grid/add.png" /></a>{/if}</td>		
        <td><input type="checkbox" name="procesar" /></td>
      </tr>     
    {/if}  
	</tbody>
  </table>
  </body>
</html>