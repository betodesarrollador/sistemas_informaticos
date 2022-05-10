{if $sectionReporte eq 1}
<table id="balanceReport" width="90%" align="center">
<thead>
 <tr align="left"><th colspan="8" align="center"><b>LIBRO MAYOR</b></th></tr>
 <tr align="left">
  <th align="center" >CODIGO</th>
  <th>NOMBRE</th>
  <th>CLASE</th>
  <th>GRUPO</th>  
  <th>CUENTA</th>    
  <th>SUBCUENTA</th>
  <th>AUX</th>
 </tr>
</thead>
<tbody>
{foreach name=puc from=$puc item=p}
<tr>
  <td><div {if $p.movimiento eq 1}class="cuenta_movimiento"{else}class="cuenta_superior"{/if}>{$p.codigo_puc}</div></td>
  <td><div {if $p.movimiento eq 1}class="cuenta_movimiento"{else}class="cuenta_superior"{/if}>{$p.nombre}</div></td>
  <td>{if $p.nivel eq 1}{$p.saldo}{/if}</td>
  <td>{if $p.nivel eq 2}{$p.saldo}{/if}</td>
  <td>{if $p.nivel eq 3}{$p.saldo}{/if}</td>
  <td>{if $p.nivel eq 4}{$p.saldo}{/if}</td>
  <td>{if $p.nivel > 4}{$p.saldo}{/if}</td>      
</tr>
 {if count($p.saldo_terceros) > 0}
   {foreach name=saldo_terceros from=$p.saldo_terceros item=st}
    <tr>
	  <td>&nbsp;</td>
	  <td colspan="6">
	    <table>
		  <tr>
		    <td><div style="font-size:10px; font-weight:bold; text-transform:capitalize">{$st.tercero}</div></td>
			<td><div style="font-size:10px; font-weight:bold">{$st.saldo}</div></td>
		   </tr>
	     </table>
     </td>
    </tr> 
	{/foreach}
 {/if}

{/foreach}
</tbody>			
</table>		 
{/if}