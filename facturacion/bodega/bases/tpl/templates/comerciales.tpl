<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="/gmtprueba/framework/css/bootstrap.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tercero_id" value="{$tercero_id}" />
  <table align="center" id="tableDetalles" width="98%">
    <thead>
      <tr>
        <th>COMERCIAL</th>
        <th>AGENCIA</th>
        <th>TIPO COMISION</th>
        
        <th id="titleSave">&nbsp;</th>	
        <th><input type="checkbox" id="checkedAll"></th>
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
       |
	        
        <td><a name="saveComerciales"><img src ="sistemas_informaticos/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	  {/foreach}
      <tr>
        <td>       
       <select style="width:260px;" name="comercial_id" > 
                <option value="NULL">NINGUNA</option>
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
            
        <td><a name="saveComerciales"><img src="sistemas_informaticos/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
	</tbody>
  </table>
  <table width="98%" align="center">
      <tr id="clon">
        <td>       
       <select style="width:260px;" name="comercial_id" > 
                <option value="NULL">NINGUNA</option>
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
            
        <td><a name="saveComerciales"><img src="sistemas_informaticos/framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr> 
  </table>
  </body>
</html>