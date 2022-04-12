<html>
  <head>
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  {$TITLETAB}        
  </head>
  
  <body>

    <table border="1" width="90%" align="center">
	  <thead>
	   <tr align="center">
	    <th>&nbsp;</th>
	    <th>OFICINA&nbsp;</th>
	    <th>PLACA&nbsp;</th>		  	  	  	  
	    <th>CONDUCTOR&nbsp;</th>
	    <th>IDENTIFICACION&nbsp;</th>	  
	    <th>TENEDOR&nbsp;</th>
	    <th>IDENTIFICACION&nbsp;</th>	  	  
	    <th>PLANILLA&nbsp;</th>  
	    <th>NACIONAL&nbsp;</th>
	    <th>PROPIO&nbsp;</th>		  	
	    <th>ESTADO&nbsp;</th>		  
	    <th>FECHA PLANILLA&nbsp;</th>		  	  
	    <th>LUGAR PAGO&nbsp;</th>		  	  	  
	    <th>ORIGEN&nbsp;</th>		  	  	  	  	  
	    <th>DESTINO&nbsp;</th>
	    <th>N ANTICIPO&nbsp;</th>		
	    <th>FECHA LIQUIDACION</th>	
	    <th>VALOR TOTAL&nbsp;</th>	
	   {foreach name=impuestos from=$DATA.impuestos item=i}
	    <th>{$i.nombre}&nbsp;</th>
	   {/foreach}
	  
	   <th>ANTICIPOS&nbsp;</th>		  	  
	  	  	  	
	   {foreach name=descuentos from=$DATA.descuentos item=d}
	   <th>{$d.nombre}&nbsp;</th>
	   {/foreach}		  	    	  	  	  	  	  
	  
  	  <th>SALDO PAGAR&nbsp;</th>	
	 </tr>
	 
	 </thead>
	 
	 <tbody>
	 	 
	 {foreach name=despachos from=$DATA.data item=r}	  
	 <tr>
	  <td>{$smarty.foreach.despachos.iteration}</td>
	  <td>{$r.oficina}&nbsp;</td>
	  <td>{$r.placa}&nbsp;</td>		  	  	  	  
	  <td>{$r.conductor}&nbsp;</td>
	  <td>{$r.numero_identificacion}&nbsp;</td>	  
	  <td>{$r.tenedor}&nbsp;</td>
	  <td>{$r.numero_identificacion_tenedor}&nbsp;</td>	  	  
	  <td>{$r.manifiesto}&nbsp;</td>  
	  <td>{$r.nacional}&nbsp;</td>
	  <td>{$r.propio}&nbsp;</td>		  	
	  <td>{$r.estado}&nbsp;</td>		  
	  <td>{$r.fecha_planilla}&nbsp;</td>		  	  
	  <td>{$r.lugar_autorizado_pago}&nbsp;</td>		  	  	  
	  <td>{$r.origen}&nbsp;</td>		  	  	  	  	  
	  <td>{$r.destino}&nbsp;</td>		  	  	  	  	  	  
	  <td>{$r.numero_anticipos}&nbsp;</td>		  	  	  	  	  	  	  
	  <td>{$r.fecha_liquidacion}&nbsp;</td>		  	  	  	  	  	  	  
	  <td>{$r.valor_total}&nbsp;</td>		  	  
	  
	  {foreach name=impuestos from=$DATA.impuestos item=i}
	   <td>{$r[$i.nombre]}&nbsp;</td>
	  {/foreach}
	  
	  <td>{$r.anticipos}&nbsp;</td>		  	  	  	  
	  	  	  	
	  {foreach name=descuentos from=$DATA.descuentos item=d}
	   <td>{$r[$d.nombre]}&nbsp;</td>
	  {/foreach}				
				  	  	  
	  <td>{$r.saldo_por_pagar}&nbsp;</td>		  	  	  	  	  	  	  	  
	 </tr>	 	  	 
	 {/foreach}
	 
	 </tbody>
	</table>
  
  </body>
</html>