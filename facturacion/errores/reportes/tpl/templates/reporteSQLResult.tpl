<html>
<head>
	{$JAVASCRIPT}
	{$CSSSYSTEM} 
	<link media='screen' type='text/css' href='../css/head_static.css' rel='stylesheet' />
	{$TITLETAB}    
</head>

<body>

	<table class="table table-hover table-sm table-responsive tableFixHead">
		<thead>
			<tr align="center">
				<th>&nbsp;</th>
				<th>QUERY&nbsp;</th>	  	  	  	  
				<th>BASE DE DATOS&nbsp;</th>  
				<th>RESULTADO&nbsp;</th>	
				<th>DESARROLLADOR&nbsp;</th> 	  	  		  	  
				<th>FECHA&nbsp;</th>	  	  	  			          
			</tr>

		</thead>

		<tbody>

			{foreach name=log from=$DATA item=r}	  

			<tr>
				<td>{$smarty.foreach.log.iteration}</td>
				<td>{$r.query|replace:";":";<br><br>"}&nbsp;</td>	  	  	  
				<td>{$r.db|replace:",":"<br>"}&nbsp;</td>  
				<td>{$r.resultado}&nbsp;</td>	 
				<td>{$r.desarrollador}&nbsp;</td>  	  	  	  	  	  
				<td>{$r.fecha}&nbsp;</td>      
			</tr>	 	

			{/foreach}

		</tbody>
	</table>

</body>
</html>