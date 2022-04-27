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
	  <tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">REPORTE IMPUESTOS</td><td width="30%" align="right">&nbsp;</td></tr>	
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
		<td align="right" class="subtitulo" >Saldo Anterior : &nbsp;{$r.saldo|number_format:2:",":"."}</td>
	  </tr>  
	  
	  {if is_array($r.registros)}

	  
	  <tr>
		<td colspan="3">
			<table border="0" width="100%" id="registros">
			  <tr align="center">
			   <th class="borderLeft borderTop borderRight">Nombre /Razon social</th>
               <th class="borderTop borderRight">Documento</th>			  
			   <th class="borderLeft borderTop borderRight">Ciudad</th>
			   <th class="borderTop borderRight">Base</th>
			   <th class="borderTop borderRight">%</th>		   
			   <th class="borderTop borderRight">Valor</th>
			  </tr>

			{foreach name=registros from=$r.registros item=rg}
			 <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
			     <td class="borderLeft borderTop borderRight">{$rg.tercero}</td>
				 <td class="borderLeft borderTop borderRight">{$rg.tercero_iden}</td>                 
				 <td class="borderLeft borderTop borderRight">{$rg.ciudad}</td>                 
			   
               
               {if strlen(trim($rg.base)) > 0} 
			     <td class="borderTop borderRight" align="right">{$rg.base|number_format:2:",":"."} </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}	
			   <td class="borderTop borderRight" align="right">{$rg.porcentaje} </td>	   		   		   		   		   	   
			   {if trim($rg.credito) > 0}      
			     <td class="borderTop borderRight" align="right">{$rg.credito|number_format:2:",":"."} </td>
			   {else}
			     <td class="borderTop borderRight" align="right">{$rg.debito|number_format:2:",":"."}</td>
			   {/if}		   					               
			   			 
			  </tr>		
			{/foreach}

			  <tr class="subtitulo">
			   <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="center">TOTALES</td>
			   <td class="borderTop borderRight borderBottom" align="right">{$r.total_base|number_format:2:",":"."}</td>  
			    <td class="borderTop borderRight borderBottom" align="center"></td>   
			    {if trim($r.total_credito) > 0}      
			     <td class="borderTop borderRight borderBottom" align="right">{$r.total_credito|number_format:2:",":"."}</td>
			   {else}
			     <td class="borderTop borderRight borderBottom" align="right">{$r.total_debito|number_format:2:",":"."}</td>
			   {/if}	          
			   
			  			
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