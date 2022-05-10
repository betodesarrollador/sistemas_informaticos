<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>

  <table id="tableSolicitudServicios" width="100%" align="center">
   <thead>
    <tr>
	 <th style='text-transform:upperCase'>CLIENTE</th> 		
	 <th style='text-transform:upperCase'>FECHA LLEGADA</th> 	
	 <th style='text-transform:upperCase'>HORA LLEGADA</th>  	
	 <th style='text-transform:upperCase'>FECHA ENTRADA</th>  	
	 <th style='text-transform:upperCase'>HORA ENTRADA</th>  	
	 <th style='text-transform:upperCase'>FECHA SALIDA</th>  	
	 <th style='text-transform:upperCase'>HORA SALIDA</th>  	
	 <th style='text-transform:upperCase'>&nbsp;</th>
    </tr>
   </thead>
      
   <tbody>
      
   {foreach name=tiempos from=$TIEMPOS item=t}
    <tr>	
	 <td>
	  {$t.cliente}
	  <input type="hidden" name="tiempos_clientes_remesas_id" value="{$t.tiempos_clientes_remesas_id}" />
	 </td> 		
	 <td>
	   <input type="text" name="fecha_llegada_cargue" value="{$t.fecha_llegada_cargue}" size="10" class="required" />
	 </td> 	
	 <td>
	   <input type="text" name="hora_llegada_cargue"  value="{$t.hora_llegada_cargue}"  size="4"  onkeyup = "separateTime(this,this.value)" class="required" />
	 </td>  	
	 <td>
	   <input type="text" name="fecha_entrada_cargue" value="{$t.fecha_entrada_cargue}" size="10" class="required" />
	 </td>  	
	 <td>
	   <input type="text" name="hora_entrada_cargue" value="{$t.hora_entrada_cargue}"   size="4" onkeyup = "separateTime(this,this.value)" class="required"  />
	 </td>  	
	 <td>
	   <input type="text" name="fecha_salida_cargue" value="{$t.fecha_salida_cargue}"   size="10" class="required" />
	 </td>  	
	 <td>
	   <input type="text" name="hora_salida_cargue" value="{$t.hora_salida_cargue}"     size="4" onkeyup = "separateTime(this,this.value)" class="required"  />
	 </td>  	
	 <td><a href="javascript:void(0)" name="saveTiempos"><img src="../../../framework/media/images/grid/save.png" /></a></td>	 
    </tr>          
   {/foreach}
      
    </tbody>        
   </table>  
  
  </body>
</html>