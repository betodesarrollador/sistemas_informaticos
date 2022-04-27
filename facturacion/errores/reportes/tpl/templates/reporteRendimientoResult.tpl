<html>
<head>
	{$JAVASCRIPT}
	{$CSSSYSTEM} 
	<link media='screen' type='text/css' href='../css/head_static.css' rel='stylesheet'/>
	{$TITLETAB}    
</head>
<body>
	<table class="table table-hover table-sm table-responsive tableFixHead">
		<thead>
			<tr align="center">
				<th>&nbsp;</th>
				<th>Num. tarea</th>
				<th>RESPONSABLE&nbsp;</th>	  	  	  	  	  	  	  	  
				<th>TAREA&nbsp;</th>  	
				<th>FECHAFINAL&nbsp;</th> 	  	  		  	  
				<th>FECHA FINAL&nbsp;</th>	  	  	  			          
				<th>DIAS PERMITIDOS&nbsp;</th>	  	  	  			          
				<th>FECHA CIERRE&nbsp;</th>	  	  	  			        
				<th>FECHA CIERRE REAL&nbsp;</th>	  	  	  			        
				<th>DIAS RETRASO&nbsp;</th>	  	  	  			        
			</tr>
		</thead>
		<tbody>
			{assign var="sumaDias" value="0"}
			{assign var="desarrollador_anterior" value=""}		
			{assign var="iteracionActual" value="0"}	
			{assign var="iteracionReal" value="0"}	

			{foreach name=rend from=$DATA item=r}	  
			
				{assign var="iterAnterior" value="0"}

				
				{if $desarrollador_anterior neq $r.desarrollador and $desarrollador_anterior neq ""}

					{assign var="iterAnterior" value=$iteracionReal}
					{assign var="iteracionActual" value=$smarty.foreach.rend.iteration}
					{math assign="iteracionReal" equation="x - y" x=$iteracionActual y=1}
					{math assign="CantidadTareas" equation="x - y" x=$iteracionReal y=$iterAnterior}
					{math assign="promDias" equation="x / y" x=$sumaDias y=$CantidadTareas}
					
					<tr>
						<td  colspan="9" align="right" style="background-color: #ff1f1f"><b>EL PROMEDIO DE RETRASO EN CIERRES DE {$desarrollador_anterior} ES DE: <b></td>
						<td align="right" style="background-color: #ff1f1f">{$promDias|number_format:2:',':'.'}<br></td>
					</tr>
					{assign var="sumaDias" value="0"}
				{/if}
	

				<tr>
					<td>{$smarty.foreach.rend.iteration}</td>
					<td>{$r.actividad_programada_id}</td>
					<td>{$r.desarrollador}&nbsp;</td> 
					<td>{$r.nombre}&nbsp;</td>	 	  	  	  	  	  
					<td>{$r.fecha_inicial}&nbsp;</td>      
					<td>{$r.fecha_final}&nbsp;</td>         
					<td>{$r.dias_permitidos}&nbsp;</td>         
					<td>{$r.fecha_cierre_real}&nbsp;</td> 
					<td>{$r.fecha_cierre}&nbsp;</td> 
					<td>{$r.dias_retraso}&nbsp;</td> 
				</tr>	 	
				
					{math assign="sumaDias" equation="x + y" x=$sumaDias y=$r.dias_retraso}
					{assign var="desarrollador_anterior" value=$r.desarrollador}
				
			{/foreach}

				{assign var="numeroIteraciones" value=$DATA|@count}
				{math assign="promedio" equation="x / y" x=$sumaDias y=$DATA|@count}

			<tr>
				<td  colspan="9" align="center"><b>Promedio Dias Retraso<b></td>
				<td align="center" style="background-color: #ff1f1f">{$promedio|number_format:2:',':'.'}&nbsp;</td> 
			</tr>
		</tbody>
	</table>
</body>
</html>