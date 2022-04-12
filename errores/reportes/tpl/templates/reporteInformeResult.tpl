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
				<th>RESPONSABLE&nbsp;</th>	  	  	  	  	  	  	  	  
				<th>FECHA REGISTRO&nbsp;</th>  	
				<th>¿QUE VOY HACER?&nbsp;</th> 	  	  		  	  
				<th>¿QUE VOY HACER MAÑANA?&nbsp;</th>	  	  	  			          
				<th>NOVEDADES&nbsp;</th>	  	  	  			              
			</tr>
		</thead>
		<tbody>


			{foreach name=rend from=$DATA item=r}	  
		
				<tr>
					<td>{$smarty.foreach.rend.iteration}</td>
					<td>{$r.desarrollador}&nbsp;</td> 
					<td>{$r.fecha_registro}&nbsp;</td>	 	  	  	  	  	  
					<td>{$r.quehicehoy}&nbsp;</td>      
					<td>{$r.dotomorrow}&nbsp;</td>         
					<td>{$r.novedades}&nbsp;</td>         
				</tr>	 	
				
			{/foreach}

		</tbody>
	</table>
</body>
</html>