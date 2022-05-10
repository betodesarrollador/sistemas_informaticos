<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}  
  {$TITLETAB}  
  </head>

  <body>
   
<fieldset id="PlanCuentasTree">
<legend>{$TITLEFORM}</legend>
{if $print eq 0}
<table id="imp_tree">
 <tr>
   <td> 
    {foreach name=empresas from=$empresas item=e}
      <a style="cursor:pointer;{if $empresa_id eq $e.empresa_id}text-transform:uppercase;font-weight:bold{else}text-transform:lowercase{/if}" id="{$e.empresa_id}" name="linkPlanCuentasTree">   
        {$e.razon_social}
      </a>
    {/foreach}
   </td>
 </tr>
</table> 
{/if}
<table id="tree">
<thead><tr><th align="center" >CODIGO</th><th>NOMBRE</th><th>PRESUPUESTAR</th></tr></thead>
<tbody>

{foreach name=puc from=$puc item=p}
  <tr>
   <td>
    <div {if $p.movimiento eq 1}class="cuenta_movimiento"{else}class="cuenta_superior"{/if}>{$p.codigo_puc}</div></td><td><div {if $p.movimiento eq 1}class="cuenta_movimiento"{else}class="cuenta_superior"{/if}>{$p.nombre}</div><td>{if $p.movimiento eq 1}<input type="checkbox" name="cuenta_presupuestar" value="{$p.puc_id}" {if $p.presupuestar eq 1}checked{/if} />{/if}</td></td></td>
  </tr>
{/foreach}

</tbody>			
</table>		 
</fieldset>
</body></html>