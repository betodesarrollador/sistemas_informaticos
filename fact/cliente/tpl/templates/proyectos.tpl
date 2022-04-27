<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tercero_id" value="{$tercero_id}" />
  <table align="center" id="tableDetalles1" width="100%">
    <thead>
      <tr>
        <th>NOMBRE PROYECTO</th>
        <th>CODIGO PROYECTO</th>
        <th>COMERCIAL</th>
        <th>ESTADO</th>
        <th id="titleSave">&nbsp;</th>	
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr >
        <td>       
        <input type="text" name="nombre_proyecto" value="{$i.nombre}" class="required" title="{$i.nombre}" size="15" />
        <input type="hidden" name="cliente_proyecto_id" value="{$i.cliente_proyecto_id}" /> </td>
        <td><input type="text" name="codigo_proyect" value="{$i.codigo}" class="required" size="10" /></td>
       	<td> <select  name="comercial_id"> 
                <option value="NULL">NINGUNA</option>
                {foreach name=comercial from=$COMERCIAL item=l}	        		
                    <option value="{$l.value}" {if $i.comercial_id eq $l.value} selected="selected" {/if} >{$l.text}</option>
                {/foreach}
            </select>       </td>
       
        <td>
        	<select  name="estado_proyecto" class="required"> 
                
                <option value="A" {if $i.estado eq "A" } selected="selected" {/if} >ACTIVO</option>
                <option value="I" {if $i.estado eq "I"} selected="selected" {/if}>INACTIVO</option>
                
            </select>        </td>    
        <td><a name="saveProyectos"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}
      <tr>
        <td>       
        <input type="text" name="nombre_proyecto" value="" class="required" title="{$i.nombre}" size="15" />
        <input type="hidden" name="cliente_proyecto_id" value="" /> </td>
        <td><input type="text" name="codigo_proyecto" value="" class="required" size="10" /></td>
       <td>   <select  name="comercial_id"> 
                <option value="NULL">NINGUNA</option>
                {foreach name=comercial from=$COMERCIAL item=l}	        		
                    <option value="{$l.value}">{$l.text}</option>
                {/foreach}
            </select>     </td>
        <td>
        	<select  name="estado_proyecto" class="required"> 
                <option value="NULL" selected="selected" >SELECCIONE</option>
                <option value="A" >ACTIVO</option>
                <option value="I" >INACTIVO</option>
                
            </select>        </td>    
        <td><a name="saveProyectos"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
        <input type="text" name="nombre_proyecto" value="" class="required" title="" size="15" />
        <input type="hidden" name="cliente_proyecto_id" value="" /> </td>
        <td><input type="text" name="codigo_proyecto" value="" class="required" size="10" /></td>
        <td>  <select  name="comercial_id"> 
                <option value="NULL">NINGUNA</option>
                {foreach name=comercial from=$COMERCIAL item=l}	        		
                    <option value="{$l.value}">{$l.text}</option>
                {/foreach}
            </select>     </td>
        <td>
        	<select  name="estado_proyecto" class="required"> 
                <option value="NULL"  selected="selected">SELECCIONE</option>
                <option value="A"   >ACTIVO</option>
                <option value="I"   >INACTIVO</option>
                
            </select>        </td>    
        <td><a name="saveProyectos"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
  </table>
  </body>
</html>