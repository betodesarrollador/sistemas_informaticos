<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="enturnamiento_id" value="{$enturnamiento_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th>PRODUCTO</th>
        <th>CODIGO BARRAS</th>	
        <th>SERIAL EAN</th>		
        <th>CANTIDAD</th>                 
        <th id="titleSave">&nbsp;</th>                
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detallesEnturnamiento from=$DETALLES item=i}
      <tr>
        <td> 
            <input type="hidden" name="enturnamiento_detalle_id" value="{$i.enturnamiento_detalle_id}"  />       
            <input type="text" name="producto" id="producto" value="{$i.producto}" class="required"  size="30" {if $i.estado neq 'D'}readonly{/if}  />
            <input type="hidden" name="producto_id" value="{$i.producto_id}"  />
        </td>
        <td><input type="text" name="codigo_barra" id="codigo_barra" value="{$i.codigo_barra}" class="required" {if $i.estado neq 'D'}readonly{/if}/></td>
        <td><input type="text" name="serial" id="serial" value="{$i.serial}" class="required" {if $i.estado neq 'D'}readonly{/if}  /></td>		        
        <td><input type="text" name="cantidad" id="cantidad" value="{$i.cantidad}" class="required numeric" {if $i.estado neq 'D'}readonly{/if}  /></td>        
        <td>{if $i.estado eq 'D'}<a name="saveDetalles"><img src="sistemas_informaticos/framework/media/images/grid/save.png" /></a>{/if}</td>
        <td>{if $i.estado eq 'D'}<input type="checkbox" name="procesar" />{/if}</td>
      </tr> 
	  {/foreach}	
      {if $i.estado eq 'D' or  $i.estado eq ''}
      <tr>
        <td> 
            <input type="hidden" name="enturnamiento_detalle_id" value=""  />      
            <input type="text" name="producto" id="producto" value="" class="required"  size="30" />
            <input type="hidden" name="producto_id" value="" />        
        </td>  
        <td><input type="text" name="codigo_barra" id="codigo_barra" value="" class="required"/></td>
        <td><input type="text" name="serial" id="serial" value=""  class="required"  /></td>		        
        <td><input type="text" name="cantidad" id="cantidad" value=""  class="required numeric"  /></td>        
        <td><a name="saveDetalles"><img src="sistemas_informaticos/framework/media/images/grid/save.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
      {/if}
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td> 
            <input type="hidden" name="enturnamiento_detalle_id" id="enturnamiento_detalle_id" value=""  />   
            <input type="text" name="producto" id="producto" value="" class="required"  size="30"  />
            <input type="hidden" name="producto_id" id="producto_id" value=""  />        
        </td>
        <td><input type="text" name="codigo_barra" id="codigo_barra" value="" class="required"/></td>
        <td><input type="text" name="serial" id="serial" value="" class="required" /></td>		        
        <td><input type="text" name="cantidad" id="cantidad" value="" class="required numeric" /></td>        
        <td><a name="saveDetalles"><img src="sistemas_informaticos/framework/media/images/grid/save.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
  </table>
  </body>
</html>