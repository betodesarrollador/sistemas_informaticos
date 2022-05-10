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
	    <th>PLANILLA&nbsp;</th>  
	    <th>PROPIO&nbsp;</th>		  	
	    <th>ESTADO&nbsp;</th>		  
	    <th>FECHA PLANILLA&nbsp;</th>		  	  
	    <th>ORIGEN&nbsp;</th>		  	  	  	  	  
	    <th>DESTINO&nbsp;</th>
   	    <th>REPORTADO MIN.&nbsp;</td>		  	  	  	  	  	  
        <th>APROBACION MIN.&nbsp;</th>
        <th>REPORTADO CUMPLIDO&nbsp;</th>
        <th>APROBADO CUMPLIDO&nbsp;</th>
	    <th>ANULACION MINISTERIO&nbsp;</th>
        <th>APROBADO ANULACION&nbsp;</th>
	 </tr>
	 </thead>
	 
	 <tbody>
	 	 
	 {foreach name=despachos from=$DATA.data item=r}	  
	 <tr>
	  <td>{$smarty.foreach.despachos.iteration}</td>
	  <td>{$r.oficina}&nbsp;</td>
	  <td>{$r.manifiesto}&nbsp;</td>  
	  <td>{$r.propio}&nbsp;</td>		  	
	  <td>{$r.estado}&nbsp;</td>		  
	  <td>{$r.fecha_planilla}&nbsp;</td>		  	  
	  <td>{$r.origen}&nbsp;</td>		  	  	  	  	  
	  <td>{$r.destino}&nbsp;</td>
   	  <td>{$r.reportado_ministerio2}&nbsp;</td>
      <td>{$r.aprobacion_ministerio2}&nbsp;</td>   
  	  <td>{$r.reportado_ministerio3}&nbsp;</td>
      <td>{$r.aprobacion_ministerio3}&nbsp;</td>
      <td>{$r.anulado_ministerio}&nbsp;</td>
      <td>{$r.anulacion_ministerio}&nbsp;</td>
		  	  	  	  	  	  
	 </tr>	 	  	 
	 {/foreach}
	 
	 </tbody>
	</table>
  
  </body>
</html>