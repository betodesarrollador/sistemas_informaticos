<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body> 
  <input type="hidden" id="liquidacion_int_cesantias_id" value="{$liquidacion_int_cesantias_id}" />
   <table align="center" id="tableImputaciones" width="98%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>TERCERO</th>
        <th>CC</th>
        <th>DESCRIPCION</th>		
        <th>BASE</th>
        <th>DEBITO</th>
        <th>CREDITO</th>      
		<th colspan="2">&nbsp;</th>
		
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10"  />
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />        
        <input type="hidden" name="detalle_int_cesantias_puc_id" value="{$i.detalle_int_cesantias_puc_id}" />        </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" value="{$i.numero_identificacion}" class = "no_requerido" readonly title="{$i.tercero}" size="10" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}">        </td>
        <td class="no_requerido">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.codigo}" class = "no_requerido" readonly title="{$i.centro_de_costo}" size="5" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        
		</td>
        <td><input type="text" name="descripcion" id="descripcion" value="{$i.desc_int_cesantias}" class="text" /></td>		        
        <td class="no_requerido">
          <input type="text" name="base" class="numeric no_requerido"  value="{$i.base_int_cesantias}" maxlength="12"  size="15" />        </td>
        <td><input type="text" name="debito"  class="numeric"  value="{$i.deb_item_int_cesantias}" maxlength="15" size="12" /></td>        
        <td><input type="text" name="credito" class="numeric" value="{$i.cre_item_int_cesantias}" maxlength="15" size="12" /></td>
		<td colspan="2">&nbsp;</td>
		
      </tr> 
	  {/foreach}	
	  
	  {if $ESTADO eq 'E'}
      <tr>
        <td>       
        <input type="text" name="puc" value="" class="required" size="10" title=""  />
        <input type="hidden" name="puc_id" value="" class="required" />        
        <input type="hidden" name="detalle_int_cesantias_puc_id" value="" />        </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" class = "no_requerido" readonly size="10" title="" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="">        </td>
        <td class="no_requerido"><input type="text" name="centro_de_costo" id="centro_de_costo" class = "no_requerido" readonly size="5" title="" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        </td>        
        <td><input type="text" name="descripcion" id="descripcion" class="text" title="" /></td>		
        <td class="no_requerido"><input type="text" name="base" class="numeric no_requerido"  maxlength="12" readonly size="15" /></td>
        <td><input type="text" name="debito" class="numeric" maxlength="15" size="12" value="0.00" /></td>        
        <td><input type="text" name="credito" class="numeric" maxlength="15" size="12" value="0.00" /></td>

		
		{if $ESTADO eq 'E'}
        <td><a name="saveImputacion"><img src="/rotterdan_test/framework/media/images/grid/save.png" alt="Guardar y/o Actualizar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
		{else}
		<td colspan="2">&nbsp;</td>
		{/if}
      </tr> 
	  
 	  {/if}
	</tbody>
  </table>
  </body>
</html>