<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo_bien_servicio_factura_id" value="{$tipo_bien_servicio_factura_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>DESCRIPCION</th>		
        <th>DESCRIPCION LIQUIDACION</th>		
        <th>NATURALEZA</th>
        <th>CONTRAPARTIDA</th> 
        <th>INGRESO TERCEROS</th>
        <th>IMPUESTO TERCEROS</th>        
        <th>APLICA TOTAL</th> 
        <th>APLICA INGRESO</th> 
        <th>APLICA TENEDOR</th>   
        <th id="titleSave">&nbsp;</th>                
         <th >&nbsp;</th>        
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=devolucion from=$DEVOLUCION item=i}
      <tr>
        <td>       
        <input type="text" name="puc" value="{$i.codigo_puc}" class="required" title="{$i.puc}" size="10"  />
        <input type="hidden" name="puc_id" value="{$i.puc_id}" class="required" />        
        <input type="hidden" name="devpuc_bien_servicio_factura_id" value="{$i.devpuc_bien_servicio_factura_id}" />        </td>
        <td><input type="text" name="descripcion" id="descripcion" value="{$i.descripcion}" class="text" /></td>
        <td><input type="text" name="despuc_bien_servicio_factura" id="despuc_bien_servicio_factura" value="{$i.despuc_bien_servicio_factura}" class="text required" /></td>        		        
        <td>
            <select name="natu_bien_servicio_factura">
        		<option value="D"{if $i.natu_bien_servicio_factura eq 'D'}selected{/if}>Debito</option>
        		<option value="C"{if $i.natu_bien_servicio_factura eq 'C'}selected{/if}>Cr&eacute;dito</option>      
            </select>              
        </td>
        <td>
        	<input type="radio" name="contra_bien_servicio_factura" value="1" {if $i.contra_bien_servicio_factura eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="radio" name="tercero_bien_servicio_factura" value="1" {if $i.tercero_bien_servicio_factura eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="ret_tercero_bien_servicio_factura" value="1" {if $i.ret_tercero_bien_servicio_factura eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="reteica_bien_servicio_factura" value="1" {if $i.reteica_bien_servicio_factura eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="aplica_ingreso" value="1" {if $i.aplica_ingreso eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="aplica_tenedor" value="1" {if $i.aplica_tenedor eq '1'}checked{/if} />
        </td>

        <td><a name="saveDevolucion"><img src="../../../framework/media/images/grid/add.png" /></a></td>
         {if $i.activo eq '0' }
         <td><a name="activar"><img src="../../../framework/media/images/grid/load.png" title="activar cuenta" /></a></td>
         {else}
         <td>&nbsp;</td>
         {/if}
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}	
      <tr>
        <td>       
        <input type="text" name="puc" value="" class="required" size="10" title=""  />
        <input type="hidden" name="puc_id" value="" class="required" />        
        <input type="hidden" name="devpuc_bien_servicio_factura_id" value="" />        </td>
        <td><input type="text" name="descripcion" id="descripcion" class="text" title="" /></td>		
		<td><input type="text" name="despuc_bien_servicio_factura" id="despuc_bien_servicio_factura" value="" class="text required" /></td>        		                
        <td>
        	<select name="natu_bien_servicio_factura" >
        		<option value="D">Debito</option>
        		<option value="C">Cr&eacute;dito</option>      
            </select>              
		</td>
        <td>
        	<input type="radio" name="contra_bien_servicio_factura" value="1">
        </td>
       <td>
        	<input type="radio" name="tercero_bien_servicio_factura" value="1">
        </td>
        <td>
        	<input type="checkbox" name="ret_tercero_bien_servicio_factura" value="1">
        </td>
        <td>
        	<input type="checkbox" name="reteica_bien_servicio_factura" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="aplica_ingreso" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="aplica_tenedor" value="1" />
        </td>
        
        <td><a name="saveDevolucion"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td>&nbsp;</td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="text" name="puc" value="" class="required" size="10" title=""  />
        <input type="hidden" name="puc_id" value="" class="required" />        
        <input type="hidden" name="devpuc_bien_servicio_factura_id" value="" />
        </td>
        <td><input type="text" name="descripcion" id="descripcion" class="text" title="" /></td>
		<td><input type="text" name="despuc_bien_servicio_factura" id="despuc_bien_servicio_factura" value="" class="text required" /></td>        		                
        <td>
        	<select name="natu_bien_servicio_factura">
        		<option value="D">Debito</option>
        		<option value="C">Cr&eacute;dito</option>      
            </select>              
        </td>
        <td>
        	<input type="radio" name="contra_bien_servicio_factura" value="1">
        </td>
         <td>
        	<input type="radio" name="tercero_bien_servicio_factura" value="1">
        </td>
        <td>
        	<input type="checkbox" name="ret_tercero_bien_servicio_factura" value="1">
        </td>
        <td>
        	<input type="checkbox" name="reteica_bien_servicio_factura" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="aplica_ingreso" value="1"  />
        </td>
         <td>
        	<input type="checkbox" name="aplica_tenedor" value="1" />
        </td>
        
        <td><a name="saveDevolucion"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td>&nbsp;</td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>