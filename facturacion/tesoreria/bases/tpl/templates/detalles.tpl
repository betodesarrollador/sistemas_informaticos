<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo_bien_servicio_teso_id" value="{$tipo_bien_servicio_teso_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th>CODIGO</th>
		<th>TERCERO</th>  
        <th>CC</th>              
        <th>DESCRIPCION</th>		
        <th>BASE</th>		
        <th>NATURALEZA</th>
        <th>CONTRAPARTIDA</th>        
        <th id="titleSave">&nbsp;</th>                
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>       
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10"/>
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />        
        <input type="hidden" name="codpuc_bien_servicio_teso_id" value="{$i.codpuc_bien_servicio_teso_id}" />
        </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" value="{$i.tercero}" class = "no_requerido" readonly title="{$i.tercero}" size="40" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}">
        </td>
        <td class="no_requerido">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.centro_de_costo}" class = "no_requerido" readonly title="{$i.centro_de_costo}" size="11" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        
		</td>        
        <td><input type="text" name="descripcion" id="descripcion" value="{$i.descripcion}" class="text" /></td>
        <td class="no_requerido">
          <input type="text" name="base" class="numeric no_requerido"  value="{$i.base}" maxlength="12"  size="10" />
        </td>       		        
        <td>
          <select name="natu_bien_servicio_teso">
              <option value="D"{if $i.natu_bien_servicio_teso eq 'D'}selected{/if}>Debito</option>
              <option value="C"{if $i.natu_bien_servicio_teso eq 'C'}selected{/if}>Cr&eacute;dito</option>      
          </select>              
        </td>
        <td> <input type="radio" name="contra_bien_servicio_teso" value="1" {if $i.contra_bien_servicio_teso eq '1'}checked{/if} /> </td>
        <td><a name="saveDetalles"><img src="/envipack/framework/media/images/grid/add.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}	
      <tr>
        <td>       
        <input type="text" name="puc" value="" class="required" size="10" title=""  />
        <input type="hidden" name="puc_id" value="" class="required" />        
        <input type="hidden" name="codpuc_bien_servicio_teso_id" value="" /> </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" value="" class = "no_requerido" readonly title="{$i.tercero}" size="10" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="">        </td>
        <td class="no_requerido">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="" class = "no_requerido" readonly title="{$i.centro_de_costo}" size="5" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="">        
		</td>        
        <td><input type="text" name="descripcion" id="descripcion" class="text" title="" /></td>		
        <td class="no_requerido"><input type="text" name="base" class="numeric no_requerido"  maxlength="12" readonly size="15" /></td>      		                
        <td>
          <select name="natu_bien_servicio_teso" >
              <option value="D">Debito</option>
              <option value="C">Cr&eacute;dito</option>      
          </select>              
		</td>
        <td> <input type="radio" name="contra_bien_servicio_teso" value="1"> </td>
        <td><a name="saveDetalles"><img src="/envipack/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="text" name="puc" value="" class="required" size="10" title=""  />
        <input type="hidden" name="puc_id" value="" class="required" />        
        <input type="hidden" name="codpuc_bien_servicio_teso_id" value="" />
        </td>
        <td class="no_requerido">
          <input type="text" name="tercero" id="tercero" value="{$i.tercero}" class = "no_requerido" readonly title="{$i.tercero}" size="10" />
          <input name="tercero_id" id="tercero_hidden" type="hidden" value="{$i.tercero_id}">
        </td>
        <td class="no_requerido">
          <input type="text" name="centro_de_costo" id="centro_de_costo" value="{$i.centro_de_costo}" class = "no_requerido" readonly title="{$i.centro_de_costo}" size="5" />
          <input name="centro_de_costo_id" id="centro_de_costo_hidden" type="hidden" value="{$i.centro_de_costo_id}">        
		</td>        
        <td><input type="text" name="descripcion" id="descripcion" class="text" title="" /></td>
        <td class="no_requerido"><input type="text" name="base" class="numeric no_requerido"  maxlength="12" readonly size="15" /></td>      		                
        <td>
          <select name="natu_bien_servicio_teso">
              <option value="D">Debito</option>
              <option value="C">Cr&eacute;dito</option>      
          </select>              
        </td>
        <td> <input type="radio" name="contra_bien_servicio_teso" value="1"> </td>
        <td><a name="saveDetalles"><img src="/envipack/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>