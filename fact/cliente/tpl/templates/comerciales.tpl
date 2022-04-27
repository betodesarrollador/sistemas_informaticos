<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tercero_id" value="{$tercero_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th width="30%">COMERCIAL</th>
        <th width="15%">AGENCIA</th>
        <th width="15%">TIPO COMISION</th>
        <th width="18%">TARIFA</th>
        <th width="14%">%FIJO</th>
        
        <th width="5%" id="titleSave">&nbsp;</th>	
        <th width="3%"><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}
      <tr>
        <td>   
       
        <select style="width:260px;" name="comercial_id" > 
                <option value="NULL">NINGUNA</option>
                {foreach name=comercial from=$COMERCIAL item=l}	        		
                    <option value="{$l.value}" {if $i.comercial_id eq $l.value} selected="selected" {/if} >{$l.text}</option>
                {/foreach}
            </select>  
            <input type="hidden" name="comerciales_cliente_id" value="{$i.comerciales_cliente_id}" /> </td>  
        <td><select style="width:160px;" name="agencia_id" > 
                <option value="NULL">NINGUNA</option>
                {foreach name=agencia from=$AGENCIA item=m}	        		
                    <option value="{$m.value}" {if $i.oficina_id eq $m.value} selected="selected" {/if} >{$m.text}</option>
                {/foreach}
            </select> </td>
        <td><select style="width:160px;" name="tipo_comision" > 
                <option value="NULL">NINGUNA</option>
               	<option value="F" {if $i.tipo_recaudo eq 'F'} selected="selected" {/if} >FACTURACION</option>
                <option value="R" {if $i.tipo_recaudo eq 'R'} selected="selected" {/if} >RECAUDO</option>
                </select> </td>
        <td><select style="width:160px;" name="tipo_variable" > 
                <option value="NULL">NINGUNA</option>
               	<option value="V" {if $i.tipo_variable eq 'V'} selected="selected" {/if} >VARIABLE</option>
                <option value="F" {if $i.tipo_variable eq 'F'} selected="selected" {/if} >FIJO</option>
                </select> </td>         
                
       <td> <input type="text" name="porcentaje_fijo" value="{$i.porcentaje_fijo}" /></td>   
        <td><a name="saveComerciales"><img src ="/envipack/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}
      <tr>
        <td>       
       <select style="width:260px;" name="comercial_id" > 
                <option value="NULL">NINGUNO</option>
                {foreach name=comercial from=$COMERCIAL item=l}	        		
                    <option value="{$l.value}" >{$l.text}</option>
                {/foreach}
            </select>  <input type="hidden" name="comerciales_cliente_id"  />  
              </td>
        <td><select style="width:160px;" name="agencia_id" > 
                <option value="NULL">NINGUNA</option>
                {foreach name=agencia from=$AGENCIA item=m}	        		
                    <option value="{$m.value}"  >{$m.text}</option>
                {/foreach}
            </select> </td>
        <td><select style="width:160px;" name="tipo_comision" > 
                <option value="NULL">NINGUNA</option>
               
               	<option value="F"  >FACTURACION</option>
                <option value="R"  >RECAUDO</option>
               
                </select></td>
           <td><select style="width:160px;" name="tipo_variable" > 
                <option value="NULL">NINGUNA</option>
               	<option value="V"  >VARIABLE</option>
                <option value="F" >FIJO</option>
                </select> </td>                 
       <td> <input type="text" name="porcentaje_fijo" /></td>       
        <td><a name="saveComerciales"><img src="/envipack/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
       <select style="width:260px;" name="comercial_id" > 
                <option value="NULL">NINGUNO</option>
                {foreach name=comercial from=$COMERCIAL item=l}	        		
                    <option value="{$l.value}" >{$l.text}</option>
                {/foreach}
            </select>    <input type="hidden" name="comerciales_cliente_id" /> </td>
        <td><select style="width:160px;" name="agencia_id" > 
                <option value="NULL">NINGUNA</option>
                {foreach name=agencia from=$AGENCIA item=m}	        		
                    <option value="{$m.value}"  >{$m.text}</option>
                {/foreach}
            </select> </td>
        <td><select style="width:160px;" name="tipo_comision" > 
                <option value="NULL">NINGUNA</option>
                
               	<option value="F"  >FACTURACION</option>
                <option value="R"  >RECAUDO</option>
                </select></td>
                 <td><select style="width:160px;" name="tipo_variable" > 
                <option value="NULL">NINGUNA</option>
               	<option value="V"  >VARIABLE</option>
                <option value="F" >FIJO</option>
                </select> </td> 
             <td> <input type="text" name="porcentaje_fijo" /></td>  
        <td><a name="saveComerciales"><img src="/envipack/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
  </table>
  </body>
</html>