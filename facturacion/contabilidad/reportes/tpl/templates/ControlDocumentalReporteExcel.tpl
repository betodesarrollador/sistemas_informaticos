<html>
  <head>
    <title>Libro Auxiliar</title>
	{$JAVASCRIPT}
    {$CSSSYSTEM} 	
  </head>
  
  <body>
  {if count($REPORTE) > 0}

	<table border="0" width="80%" align="center">
	
			  <tr align="center">
			   <th class="borderLeft borderTop borderRight">Codigo</th>
			   <th class="borderTop borderRight">Consecutivo</th>
			   <th class="borderTop borderRight">Fecha</th>		   
			   <th class="borderTop borderRight">Tercero</th>
			   <th class="borderTop borderRight">Valor</th>
			   <th class="borderTop borderRight">Estado</th>
			  </tr>
	{foreach name=reporte from=$REPORTE item=r}	
	
    <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
		
			   <td class="borderLeft borderTop borderRight">{$r.codigo_doc}</td>
			   <td class="borderTop borderRight">{$r.consecutivo}</td>
			   <td class="borderTop borderRight">{$r.fecha}</td>		   
			   <td class="borderTop borderRight">{$r.tercero}</td>
			   <td class="borderTop borderRight">{$r.valor|number_format:0:",":"."}</td>
			   <td class="borderTop borderRight">{$r.estado}</td>
			  </tr>
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