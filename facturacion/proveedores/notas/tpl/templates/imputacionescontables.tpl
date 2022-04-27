<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="encabezado_registro_id" value="{$encabezado_registro_id}" />
  <table align="center" id="tableImputaciones" width="120%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>TERCERO</th>
         <th>SUCURSAL</th>
        <th>CC</th>
        <th>DEPARTAMENTO</th>
        <th>AREA</th>
        <th>UND NEGOCIO</th>
        <th>DESCRIPCION</th>		
        <th>BASE</th>
        <th>DEBITO</th>
        <th>CREDITO</th>      
		{if $ESTADO eq 'E'}  
        <th id="titleSave">&nbsp;</th>                
        <th><input type="checkbox" id="checkedAll"></th>
		{else}
		<th colspan="2">&nbsp;</th>
		{/if}
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$IMPUTACIONES item=i}
      <tr>
        <td>       
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10"  />
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />        
        <input type="hidden" name="imputacion_contable_id" value="{$i.imputacion_contable_id}" />        </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" value="{$i.numero_identificacion}" class = "no_requerido" readonly title="{$i.tercero}" size="10" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}">        </td>
       
        <td class="no_requerido">
          <input type="text" name="sucursal" id="sucursal" value="{$i.sucursal}" class = "no_requerido" readonly title="{$i.sucursal}" size="10" />
          <input name="sucursal_id" id="sucursal_hidden" type="hidden" value="{$i.sucursal_id}">        
		</td>
        <td class="no_requerido">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.codigo}" class = "no_requerido" readonly title="{$i.centro_de_costo}" size="5" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        
		</td>
        
        
        
        
        
        <td class="no_requerido">
          <input type="text" name="departamento" id="departamento" value="{$i.codigo_dep}" class = "no_requerido" readonly title="{$i.departamento}" size="5" />
          <input name="departamento_id" id="departamento_hidden" type="hidden" value="{$i.departamento_id}">        
		</td>
       <td class="no_requerido">
          <input type="text" name="area" id="area" value="{$i.codigo_area}" class = "no_requerido" readonly title="{$i.area}" size="5" />
          <input name="area_id" id="area_hidden" type="hidden" value="{$i.area_id}">        
		</td>
        <td class="no_requerido">
          <input type="text" name="unidadnegocio" id="unidadnegocio" value="{$i.nombre_unidad}" class = "no_requerido" readonly title="{$i.unidadnegocio}" size="5" />
          <input name="unidad_negocio_id" id="unidadnegocio_hidden" type="hidden" value="{$i.unidad_negocio_id}">        
		</td>
       
        
        
        
        <td><input type="text" name="descripcion" id="descripcion" value="{$i.descripcion}" class="text" /></td>		        
        <td class="no_requerido">
          <input type="text" name="base" class="numeric no_requerido"  value="{$i.base}" maxlength="12"  size="15" />        </td>
        <td> <input type="text" name="debito" {if $i.debito<0 } class="numeric_negative" {else} class="numeric" {/if} value="{$i.debito}" maxlength="15" size="12" ></td>        
        <td> <input type="text" name="credito" {if $i.credito<0 } class="numeric_negative" {else} class="numeric" {/if} value="{$i.credito}" maxlength="15" size="12" ></td>
		
		{if $ESTADO eq 'E'}
        <td><a name="saveImputacion"><img src="/rotterdan/framework/media/images/grid/save.png" alt="Guardar y/o Actualizar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
		{else}
		<td colspan="2">&nbsp;</td>
		{/if}
      </tr> 
	  {/foreach}	
	  
	  {if $ESTADO eq 'E'}
      <tr>
        <td>       
        <input type="text" name="puc" value="" class="required" size="10" title=""  />
        <input type="hidden" name="puc_id" value="" class="required" />        
        <input type="hidden" name="imputacion_contable_id" value="" />        </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" class = "no_requerido" readonly size="10" title="" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="">        </td>
       
       <td class="no_requerido">
          <input type="text" name="sucursal" id="sucursal" value="" class = "no_requerido" readonly title="" size="10" />
          <input name="sucursal_id" id="sucursal_hidden" type="hidden" value="">        
		</td>  
        <td class="no_requerido"><input type="text" name="centro_de_costo" id="centro_de_costo" class = "no_requerido" readonly size="5" title="" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        </td>        
        
        
           <td class="no_requerido">
          <input type="text" name="departamento" id="departamento" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="departamento_id" id="departamento_hidden" type="hidden" value="">        
		</td>
         <td class="no_requerido">
          <input type="text" name="area" id="area" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="area_id" id="area_hidden" type="hidden" value="">        
		</td> 
     
        <td class="no_requerido">
          <input type="text" name="unidadnegocio" id="unidadnegocio" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="unidad_negocio_id" id="unidadnegocio_hidden" type="hidden" value="">        
		</td>
       
        
        
        
        
        
        <td><input type="text" name="descripcion" id="descripcion" class="text" title="" /></td>		
        <td class="no_requerido"><input type="text" name="base" class="numeric no_requerido"  maxlength="12" readonly size="15" /></td>
        <td><input type="text" name="debito" class="numeric" maxlength="15" size="12" value="0.00" /></td>        
        <td><input type="text" name="credito" class="numeric" maxlength="15" size="12" value="0.00" /></td>

		
			{if $ESTADO eq 'E'}
        <td><a name="saveImputacion"><img src="/rotterdan/framework/media/images/grid/save.png" alt="Guardar y/o Actualizar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
		{else}
		<td colspan="2">&nbsp;</td>
		{/if}
      </tr> 
	  
 	  {/if}
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="text" name="puc" value="" class="required" size="10" title=""  />
        <input type="hidden" name="puc_id" value="" class="required" />        
        <input type="hidden" name="imputacion_contable_id" value="" />
        </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" class = "no_requerido" readonly size="10" title="" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="">
        </td>
        
        
         <td class="no_requerido">
          <input type="text" name="sucursal" id="sucursal" value="" class = "no_requerido" readonly title="" size="10" />
          <input name="sucursal_id" id="sucursal_hidden" type="hidden" value="">        
		</td> 
        <td class="no_requerido">
          <input type="text" name="centro_de_costo" id="centro_de_costo" class = "no_requerido" readonly size="5" title="" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">
        </td>        
        
        
        
          
        <td class="no_requerido">
          <input type="text" name="departamento" id="departamento" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="departamento_id" id="departamento_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido">
          <input type="text" name="area" id="area" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="area_id" id="area_hidden" type="hidden" value="">        
		</td>
        <td class="no_requerido">
          <input type="text" name="unidadnegocio" id="unidadnegocio" value="" class = "no_requerido" readonly title="" size="5" />
          <input name="unidad_negocio_id" id="unidadnegocio_hidden" type="hidden" value="">        
		</td>
       
        
        
        
        
        
        <td><input type="text" name="descripcion" id="descripcion" class="text" title="" /></td>		
        <td class="no_requerido"><input type="text" name="base" class="numeric no_requerido" maxlength="12" readonly size="15" /></td>
        <td><input type="text" name="debito" class="numeric" maxlength="15" size="12" value="0.00" /></td>        
        <td><input type="text" name="credito" class="numeric" maxlength="15" size="12" value="0.00" /></td>
		
		{if $ESTADO eq 'E'}
        <td><a name="saveImputacion"><img src="/rotterdan/framework/media/images/grid/save.png" alt="Guardar y/o Actualizar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
		{else}
		<td colspan="2">&nbsp;</td>
		{/if}
      </tr>
  </table>
  </body>
</html>