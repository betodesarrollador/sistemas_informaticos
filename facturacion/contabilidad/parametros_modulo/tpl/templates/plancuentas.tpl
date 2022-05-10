{if $sectionPlanCuentasTree neq 1}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">

  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS} 
  {$TITLETAB}  
  </head>
  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>
        <div id="table_find">
           <table align="center">
              <tr>
                <td><label>Busqueda : </label></td>
              </tr>
              <tr>
                <td>{$BUSQUEDA}</td>
              </tr>
          </table>
        </div>
        
        {$FORM1}
        <fieldset class="section">
        <table align="center">
          <tr>
            <td ><label>Empresa :</label></td>
            <td>{$EMPRESAS}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>          
          <tr>
            <td ><label>Codigo   :</label></td>
            <td>{$CODIGOPUC}{$PUCID}</td>
            <td><label>Nombre   :</label></td>
            <td>{$NOMBRE}</td>
          </tr>        
          <tr>
            <td ><label>Superior : </label></td>
            <td>{$PUCPUC}{$PUCPUCID}</td>
            <td><label>Naturaleza   :</label></td>
            <td>{$NATURALEZA}</td>
          </tr>
          <tr>
            <td ><label>Nivel : </label></td>
            <td>{$NIVEL}</td>
            <td><label>Movimiento ?</label></td>
            <td>{$MOVIMIENTO}</td>
          </tr>   
          <tr>
            <td><label>Contrapartida ? </label></td>
            <td>{$CONTRAPARTIDA}</td>
            <td><label>Centro Costo ? </label></td>
            <td>{$REQUIERECENTROCOSTO}</td>
          </tr>                  
          <tr>
            <td><label>Tercero ?</label></td>
            <td align="left">{$REQUIERETERCERO}</td>
            <td ><label>Sucursal ?  :</label></td>
            <td align="left">{$REQUIERESUCURSAL}</td>
          </tr> 
          <tr>
            <td><label>Corriente : </label></td>
            <td align="left">{$CORRIENTE}</td>
            <td align="left"><label>Estado :</label></td>
            <td align="left">Activo :{$ACTIVO} Inactivo{$INACTIVO}{$PUCEMPRESAID}</td>
          </tr> 		                    
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>                    
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$DESCARGAR}&nbsp;<button class="btn btn-success" id="exogena" tabindex="19" >Exogena</button>&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>
             
      <div id="divSolicitudFormatos">
          <iframe id="iframeSolicitud"></iframe>
      </div>
    </fieldset>
  </body>
</html>
	
{/if}    
{if $sectionPlanCuentasTree eq 1}
<fieldset id="PlanCuentasTree">
{if $print eq 0}
<table id="imp_tree">
 <tr><td align="right"><img src="../../../framework/media/images/forms/print.png" id="print"/></td></tr>
 <tr>
   <td> 
    {foreach name=empresas from=$empresas item=e}
      <a style="color: #F7F3D0; cursor:pointer;{if $empresa_id eq $e.empresa_id}text-transform:uppercase;font-weight:bold{else}text-transform:lowercase{/if}" id="{$e.empresa_id}" name="linkPlanCuentasTree">   
        {$e.razon_social}
      </a>
    {/foreach}
   </td>
 </tr>
</table> 
{/if}
<table id="tree">
<thead><tr><th align="center" >CODIGO</th><th>NOMBRE</th><th>NIVEL</th><th>NATURALEZA</th><th>MOVIMIENTO</th><th>CENTRO COSTO</th><th>TERCERO</th><th>COD DIAN</th><th>ESTADO</th></tr></thead>
<tbody>
{foreach name=puc from=$puc item=p}
<tr><td><div {if $p.movimiento eq 1}class="cuenta_movimiento"{else}class="cuenta_superior"{/if}>{$p.codigo_puc}</div></td><td><div {if $p.movimiento eq 1}class="cuenta_movimiento"{else}class="cuenta_superior"{/if}>{$p.nombre}</div></td><td>{$p.nivel}</td><td>{$p.naturaleza}</td><td>{if $p.movimiento eq 1}SI{else}NO{/if}</td><td>{if $p.requiere_centro_costo eq 1}SI{else}NO{/if}</td><td>{if $p.requiere_tercero eq 1}SI{else}NO{/if}</td><td>{$p.codigo_dian}</td><td>{$p.estado}</td></tr>
{/foreach}
</tbody>			
</table>
{$FORM1END} 		 
</fieldset>
{/if}