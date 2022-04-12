<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="si_cliente" value="{$si_cliente}" />
  <input type="hidden" id="si_tenedor" value="{$si_tenedor}" /> 
  <input type="hidden" id="si_vehiculo" value="{$si_vehiculo}" />
  <input type="hidden" id="si_conductor" value="{$si_conductor}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td>
  	<td align="center" class="titulo" width="40%">{if $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'} HISTORICO GENERAL
        						{elseif $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'} HISTORICO CLIENTE
                                {elseif $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'} HISTORICO TENEDOR
                                {elseif $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 1} HISTORICO CONDUCTOR 
                                {elseif $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 'ALL'} HISTORICO VEHICULO
                                {elseif $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 'ALL'} HISTORICO CLIENTE - VEHICULO
                                {elseif $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'} HISTORICO CLIENTE - TENEDOR
                                {elseif $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 1} HISTORICO CLIENTE - CONDUCTOR
                                {elseif $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 1} HISTORICO CONDUCTOR - TENEDOR
                                {elseif $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 1} HISTORICO CONDUCTOR - VEHICULO
                                {elseif $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 'ALL'} HISTORICO TENEDOR - VEHICULO
                                {elseif $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 1} HISTORICO CLIENTE - VEHICULO - CONDUCTOR
                                {elseif $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 'ALL'} HISTORICO CLIENTE - VEHICULO - TENEDOR
                                {elseif $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 1} HISTORICO CONDUCTOR - VEHICULO - TENEDOR
                                {elseif $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 1} HISTORICO CONDUCTOR - CLIENTE - TENEDOR
                                {elseif $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 1} HISTORICO VEHICULO - CONDUCTOR - CLIENTE - TENEDOR                                                  
                                                  {/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3"> Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rango Final: {$hasta}</td></tr>	
  </table>
	 
     {if $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'}   
       
     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td> 
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* GENERAL *}
        
        
{if $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'}   
       
     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>  
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* CLIENTE *} 
        
{if $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'}   
      
     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>  
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* TENEDOR *}  
        
{if $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 1}   
      
     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>  
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* CONDUCTOR *}  
        
{if $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 'ALL'}   
      
     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* VEHICULO *} 
        
{if $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 'ALL'}   
      
     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* CLIENTE - VEHICULO *} 
        
{if $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 'ALL'}   
      
     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CLIENTE - TENEDOR *}     
        
{if $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 'ALL' and $si_conductor eq 1}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CLIENTE - CONDUCTOR *} 
        
{if $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 1}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CONDUCTOR - TENEDOR *}  
        
{if $si_cliente eq 'ALL' and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 1}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CONDUCTOR - VEHICULO *}                        
       
{if $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 'ALL'}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* TENEDOR - VEHICULO *}
        
{if $si_cliente eq 1 and $si_tenedor eq 'ALL' and $si_vehiculo eq 1 and $si_conductor eq 1}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CLIENTE - VEHICULO - CONDUCTOR *}   
        
{if $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 'ALL'}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CLIENTE - VEHICULO - TENEDOR *}  
        
{if $si_cliente eq 'ALL' and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 1}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CONDUCTOR - VEHICULO - TENEDOR *}  
        
{if $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 'ALL' and $si_conductor eq 1}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* CONDUCTOR - CLIENTE - TENEDOR *}
        
{if $si_cliente eq 1 and $si_tenedor eq 1 and $si_vehiculo eq 1 and $si_conductor eq 1}   

     	{assign var="clien" value=""}               
         {foreach name=detalles from=$DETALLESHISTORICO item=r}
       
		  {if $clien eq '' or $clien neq $r.cliente}              
            {assign var="clien" value=$r.cliente} 
          
          	{if $clien neq '' or $clien neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$clien}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> NUMERO CONSECUTIVO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> N. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> CLASE </th>		           
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> CONDUCTOR </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> PRODUCTO </th> 
            <th class="borderTop borderRight borderBottom" align="center"> PESO </th>		
            <th class="borderTop borderRight borderBottom" align="center"> CANTIDAD </th>   
            <th class="borderTop borderRight borderBottom" align="center"> VALOR </th>		
            <th class="borderTop borderRight borderBottom" align="center"> ESTADO </th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.manifiesto}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.clase_remesa}</td>   
            <td class="borderTop borderRight borderBottom">{$r.tenedor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.conductor}</td>  
            <td class="borderTop borderRight borderBottom">{$r.vehiculo}</td>
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>           
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:60}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>  
       
          {/foreach}
                                  
	 	{/if}    
        {* VEHICULO - CONDUCTOR - CLIENTE - TENEDOR *}                                       
              
  </table>
  </body>
</html>