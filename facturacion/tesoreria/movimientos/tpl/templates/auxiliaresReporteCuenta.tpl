<html>
  <head>
    <title>Libro Auxiliar</title>
	{$JAVASCRIPT}
    {$CSSSYSTEM} 	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
  
  <body>
  {if count($REPORTE) > 0}

    <table width="80%" align="center" id="encabezado" border="0">
	  <tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">Libros Auxiliares</td><td width="30%" align="right">&nbsp;</td></tr>	
	  <tr><td colspan="3">&nbsp;</td></tr>
	  <tr><td align="center" colspan="3">{$EMPRESA} </td></tr>
	  <tr><td colspan="3" align="center">Nit. {$NIT}</td></tr>
	  <tr><td align="center" colspan="3">Centros : {$CENTROS}</td></tr>	 	 	   
	  <tr><td align="center" colspan="3">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>	 	   
	</table>	
	
	{foreach name=reporte from=$REPORTE item=r}	
	
	<br />
	<table border="0" width="80%" align="center">
	  <tr>
	    <td width="72%" >&nbsp;{$r.codigo_puc}</td>
		<td align="right" class="subtitulo" >Saldo Anterior : &nbsp;{$r.saldo|number_format:0:",":"."}</td>
	  </tr>  
	  
	  {if is_array($r.registros)}
	  <tr>
		<td colspan="3">
			<table border="0" width="100%" id="registros">
			  <tr align="center">
			   <th class="borderLeft borderTop borderRight">Tercero</th>			  
			   <th class="borderLeft borderTop borderRight">Fecha</th>
			   <th class="borderTop borderRight">Oficina</th>
			   <th class="borderTop borderRight">Centro</th>		   
			   <th class="borderTop borderRight">Docto</th>
			   <th class="borderTop borderRight">Numero</th>
			   <th class="borderTop borderRight">Descripcion</th>
			   <th class="borderTop borderRight" align="right">Debito</th>
			   <th class="borderTop borderRight" align="right">Credito</th>
			   <th class="borderTop borderRight" align="right">Saldo</th>								
			  </tr>

			{foreach name=registros from=$r.registros item=rg}
			 <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
			     <td class="borderLeft borderTop borderRight">{$rg.tercero}</td>
			   {if strlen(trim($rg.fecha)) > 0}       
			     <td class="borderLeft borderTop borderRight">{$rg.fecha}</td>
			   {else}
			     <td class="borderLeft borderTop borderRight" align="center">-------</td>
			    {/if}
			   {if strlen(trim($rg.oficina)) > 0}     
			     <td class="borderTop borderRight">{$rg.oficina}</td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}
			   {if strlen(trim($rg.centro_costo)) > 0}
			     <td class="borderTop borderRight">{$rg.centro_costo}</td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}
			   {if strlen(trim($rg.documento)) > 0}   
			     <td class="borderTop borderRight">{$rg.documento}   </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}			   
			   {if strlen(trim($rg.consecutivo)) > 0}   
			     <td class="borderTop borderRight">
				   <a href="javascript:void(0)" onClick="viewDocument('{$rg.encabezado_registro_id}')" >{$rg.consecutivo}</a>
				 </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}
			   {if strlen(trim($rg.descripcion)) > 0} 
			     <td class="borderTop borderRight">{$rg.descripcion} </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}		   		   		   		   		   	   
			   {if strlen(trim($rg.debito)) > 0}      
			     <td class="borderTop borderRight" align="right">{$rg.debito|number_format:0:",":"."} </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}		   					               
			   {if strlen(trim($rg.credito)) > 0}     
			     <td class="borderTop borderRight" align="right">{$rg.credito|number_format:0:",":"."}</td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}		   						               
			   {if strlen(trim($rg.saldo)) > 0}       
			     <td class="borderTop borderRight" align="right">{$rg.saldo|number_format:0:",":"."}  </td>
			   {else}
			     <td class="borderTop borderRight" align="center">0</td>
			   {/if}			 
			  </tr>		
			{/foreach}

			  <tr class="subtitulo">
			   <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="center">TOTAL</td>
			   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.total_debito|number_format:0:",":"."}</td>
			   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.total_credito|number_format:0:",":"."}</td>
			   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.saldo_total|number_format:0:",":"."}</td>								
			  </tr>  
            </table>
	  </td>
	</tr>
	{/if}
	</table>
	{/foreach}
	
	
	<table width="80%" align="center" id="usuarioProceso">
	  <tr>
	    <td width="50%" align="left">Procesado Por : {$USUARIO}</td>
		<td width="50%" align="right">Fecha/Hora : {$FECHA} {$HORA}</td>
	  </tr>
	</table>
{else}
  <p align="center">No se encontraron registros que coincidan con los filtros seleccionados!!!!</p>
{/if}

 </body>
</html>