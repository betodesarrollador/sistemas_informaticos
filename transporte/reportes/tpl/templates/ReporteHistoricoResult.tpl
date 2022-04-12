<html>
  <head>
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  {$TITLETAB}        
  </head>
  
  <body>

    <table border="1" width="90%" align="center">
	 <tr align="center">
      <td>CONS</td><!---->
	  <td>FECHA</td>
	  <td>DESPACHO</td>	  
	  <td>CLASE</td>	
	  <td>CLIENTE</td>		  
	  <td>ORIGEN</td>		  	  
	  <td>DESTINO</td>		  	  	  
	  <td>CODIGO</td>		  	  	  	  
	  <td>PRODUCTO</td>		  	  	  	  	  
	  <td>PESO</td>		  	  	  	  	  	  
	  <td>CANTIDAD</td>		  	  	  	  	  	  	  
	  <td>VALOR</td>		  	  	  	  	  	  	  	  
	  <td>ESTADO</td>		  	  	  	  	  	  	  	  	  
	 </tr>
	 
	 {assign var="total_peso" value="0"}
	 {assign var="total_cantidad" value="0"}
	 {assign var="total_valor" value="0"}	 	 
	 
	 {foreach name=remesas from=$DATA item=r}	  
	 <tr>
	 
	  <td>{$r.remesa_id}</td>
	  <td>{$r.fecha_remesa}</td>
	  <td>{$r.documento_cliente}</td>
	  <td>{$r.CLASE}</td>           
	  <td>{$r.cliente}</td>
	  <td>{$r.origen}</td>	  
	  <td>{$r.destino}</td>
	  <td>{$r.codigo}</td>
	  <td>{$r.descripcion_producto}</td>	  
	  <td>{$r.peso}</td>
	  <td>{$r.cantidad}</td>
	  <td>{$r.valor|number_format:0:",":"."}</td>	  
	  <td>{$r.estado}</td>	  
	 </tr>	 

      {math assign="total_peso"     equation="(X+Y)" X=$total_peso     Y=$r.peso}	 
      {math assign="total_cantidad" equation="(X+Y)" X=$total_cantidad Y=$r.cantidad}	 
      {math assign="total_valor"    equation="(X+Y)" X=$total_valor    Y=$r.valor}	 
	  	 
	 {/foreach}
	 
	 <tr>
	  <td colspan="9" align="right">TOTALES :</td>
	  <td>{$total_peso}</td>
	  <td>{$total_cantidad}</td>
	  <td>{$total_valor|number_format:0:",":"."}</td>	  
	  <td>&nbsp;</td>	  
	 </tr>		 
	 
	</table>
  
  </body>
</html>