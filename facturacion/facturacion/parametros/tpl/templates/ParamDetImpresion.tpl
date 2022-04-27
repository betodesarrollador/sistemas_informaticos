<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo_bien_servicio_factura_id" value="{$tipo_bien_servicio_factura_id}" />
  <table align="center" id="tableParamDetImpresion" width="98%">
    <thead>
      <tr>
        <th>REMESA</th>
        <th>ORDEN</th>		
        <th>FECHA</th>		
        <th>PESO</th>
        <th>PLACA</th> 
        <th>DESCRIPCION</th>
        <th>ORIGEN</th>        
        <th>DESTINO</th> 
        <th>CANTIDAD</th> 
        <th>VALOR UNITARIO</th> 
        <th>VALOR TOTAL</th> 
        <th>DOC CLIENTE</th> 
        <th>OBSERVACION UNO</th>  
        <th>OBSERVACION DOS</th> 
        <th id="titleSave">&nbsp;</th> 
        <th >&nbsp;</th>                
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=ParamDetImpresion from=$ParamDetImpresion item=i}
      
      <tr >
	    {if $i.activo eq '0' }
        <td style="background:#F02846;">       
        {else}
        <td>
        {/if}
        <input type="checkbox" name="remesa" value="1" {if $i.remesa eq '1'}checked{/if} />
        <input type="hidden" name="parametro_impresion_id" value="{$i.parametro_impresion_id}" class="required" /> </td>
        <td>
            <input type="checkbox" name="orden" value="1" {if $i.orden eq '1'}checked{/if} />
        </td>
        <td>
           <input type="checkbox" name="fecha" value="1" {if $i.orden eq '1'}checked{/if} />
        </td>        		        
        <td>
            <input type="checkbox" name="peso" value="1" {if $i.peso eq '1'}checked{/if} />          
        </td>
        <td>
        	<input type="checkbox" name="placa" value="1" {if $i.placa eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="descripcion" value="1" {if $i.descripcion eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="origen" value="1" {if $i.origen eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="destino" value="1" {if $i.destino eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="cantidad" value="1" {if $i.cantidad eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="valor_unitario" value="1" {if $i.valor_unitario eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="valor_total" value="1" {if $i.valor_total eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="doc_cliente" value="1" {if $i.doc_cliente eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="observacion_uno" value="1" {if $i.observacion_uno eq '1'}checked{/if} />
        </td>
        <td>
        	<input type="checkbox" name="observacion_dos" value="1" {if $i.observacion_dos eq '1'}checked{/if} />
        </td>

        <td><a name="saveParamDetImpresion"><img src="../../../framework/media/images/grid/add.png" /></a></td>
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
        <input type="checkbox" name="remesa" value="1"  />
        <input type="hidden" name="parametro_impresion_id" value="" class="required" />        
        <td>
           <input type="checkbox" name="orden" value="1">
        </td>		
		<td>
           <input type="checkbox" name="fecha" value="1">
        </td>        		                
        <td>
            <input type="checkbox" name="peso" value="1">       
		</td>
        <td>
        	<input type="checkbox" name="placa" value="1">
        </td>
        <td>
        	<input type="checkbox" name="descripcion" value="1">
        </td>
        <td>
        	<input type="checkbox" name="origen" value="1">
        </td>
        <td>
        	<input type="checkbox" name="destino" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="cantidad" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="valor_unitario" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="valor_total" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="doc_cliente" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="observacion_uno" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="observacion_dos" value="1"  />
        </td>
        
        <td><a name="saveParamDetImpresion"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td>&nbsp;</td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="checkbox" name="remesa" value="1">
        <input type="hidden" name="parametro_impresion_id" value="" class="required" />        
        </td>
        <td>
          <input type="checkbox" name="orden" value="1">
        </td>
		<td>
           <input type="checkbox" name="fecha" value="1">
        </td>        		                
        <td>
        	<input type="checkbox" name="peso" value="1">          
        </td>
        <td>
        	<input type="checkbox" name="placa" value="1">
        </td>
        <td>
        	<input type="checkbox" name="descripcion" value="1">
        </td>
        <td>
        	<input type="checkbox" name="origen" value="1">
        </td>
        <td>
        	<input type="checkbox" name="destino" value="1"  />
        </td>
        <td>
        	<input type="checkbox" name="cantidad" value="1"  />
        </td>
         <td>
        	<input type="checkbox" name="valor_unitario" value="1"  />
        </td>
         <td>
        	<input type="checkbox" name="valor_total" value="1"  />
        </td>
         <td>
        	<input type="checkbox" name="doc_cliente" value="1"  />
        </td>
         <td>
        	<input type="checkbox" name="observacion_uno" value="1"  />
        </td>
         <td>
        	<input type="checkbox" name="observacion_dos" value="1"  />
        </td>
        
        <td><a name="saveParamDetImpresion"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td>&nbsp;</td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>