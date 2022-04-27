<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="estado_id" value="{$estado_id}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td>
  	<td align="center" class="titulo" width="40%">{if $estado_id eq 'MF'} REMESAS MANIFESTADAS 
    											  {elseif  $estado_id eq 'ET'} REMESAS ENTREGADAS 
                                                  {elseif  $estado_id eq 'PD,P'} REMESAS PENDIENTES 
                                                   {elseif  $estado_id eq 'PC'} REMESAS PROCESANDO 
                                                  {elseif  $estado_id eq 'LQ'} REMESAS LIQUIDADAS 
                                                  {elseif  $estado_id eq 'FT'} REMESAS FACTURADAS 
                                                  {elseif  $estado_id eq 'AN'} REMESAS ANULADAS
                                                  {elseif  $estado_id eq 'PD,P,PC,MF,LQ,AN,FT,ET'} REMESAS
                                                  {else} REMESAS
                                                  {/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3"> Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rango Final: {$hasta}</td></tr>	
  </table>

     {if $estado_id eq 'PD,P'}     
     	{assign var="cliente" value=""}               
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente neq $r.cliente}              
            {assign var="cliente" value=$r.cliente} 
          
          {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
           <th class="borderLeft borderTop borderRight borderBottom">NACIONAL</th>
            <th class="borderLeft borderTop borderRight ">OFICINA REMESA</th>
            <th class="borderLeft borderTop borderRight">NUMERO REMESA</th>
            <th class="borderTop borderRight borderBottom">ESTADO</th>    
            <th class="borderTop borderRight borderBottom">CLASE</th>	
            <th class="borderTop borderRight borderBottom">FECHA REMESA</th>
            <th class="borderTop borderRight borderBottom">CLIENTE</th>
            <th class="borderTop borderRight borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>	
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>	
            <th class="borderTop borderRight borderBottom">ORDEN DESPACHO</th>
            <th class="borderTop borderRight borderBottom">CODIGO</th>
            <th class="borderTop borderRight borderBottom">PRODUCTO</th> 
            <th class="borderTop borderRight borderBottom">NATURALEZA</th> 
            <th class="borderTop borderRight borderBottom">EMPAQUE</th> 
            <th class="borderTop borderRight borderBottom">MEDIDA</th>                         
            <th class="borderTop borderRight borderBottom">CANTIDAD </th> 
            <th class="borderTop borderRight borderBottom">PESO VOLUMEN</th>		
            <th class="borderTop borderRight borderBottom">PESO</th>   
            <th class="borderTop borderRight borderBottom">VALOR MERCANCIA</th>
            <th class="borderTop borderRight borderBottom">VALOR FLETE</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL</th>                                       
            <th class="borderTop borderRight borderBottom">VALOR FLETE LIQ</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO LIQ</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS LIQ</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL LIQ</th>                                       
            
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.nacional}</td>
             <td class="borderTop borderRight borderBottom" align="center">{$r.oficina_remesa}</td>   
            <td class="borderTop borderRight borderBottom" align="center">{$r.numero_remesa}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
            <td class="borderTop borderRight borderBottom">{$r.clase}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td> 
            <td class="borderTop borderRight borderBottom">{$r.cliente}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.codigo}</td>   
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.naturaleza}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.empaque}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.medida}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td>   
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso_volumen}</td>             
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_mercancia|number_format:2:',':'.'}</td>                         

            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_total|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_total|number_format:2:',':'.'}</td>                         
            
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* PENDIENTES *}
	 
     {if $estado_id eq 'MF'}     
     	{assign var="cliente" value=""}               
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente neq $r.cliente}              
            {assign var="cliente" value=$r.cliente} 
          
          {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
           <th class="borderLeft borderTop borderRight borderBottom">OFICINA PLANILLA</th>
           <th class="borderLeft borderTop borderRight ">TIPO</th>   
           <th class="borderTop borderRight borderBottom">N. PLANILLA</th>       
           <th class="borderLeft borderTop borderRight ">NACIONAL</th>
           <th class="borderLeft borderTop borderRight ">PROPIO</th>  
           <th class="borderLeft borderTop borderRight ">PLACA</th> 
           <th class="borderLeft borderTop borderRight ">CONDUCTOR</th> 
           <th class="borderLeft borderTop borderRight ">FECHA PLANILLA</th>           
           <th class="borderLeft borderTop borderRight ">OFICINA REMESA</th>
           <th class="borderLeft borderTop borderRight ">NUMERO REMESA</th>
           <th class="borderTop borderRight borderBottom">ESTADO</th>  
           <th class="borderTop borderRight borderBottom">CLASE</th>	 
           <th class="borderTop borderRight borderBottom">FECHA REMESA</th>
           <th class="borderTop borderRight borderBottom">CLIENTE</th>
            <th class="borderTop borderRight borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>	
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>	
            <th class="borderTop borderRight borderBottom">ORDEN DESPACHO</th>
            <th class="borderTop borderRight borderBottom">CODIGO</th>
            <th class="borderTop borderRight borderBottom">PRODUCTO</th> 
            <th class="borderTop borderRight borderBottom">NATURALEZA</th> 
            <th class="borderTop borderRight borderBottom">EMPAQUE</th> 
            <th class="borderTop borderRight borderBottom">MEDIDA</th>  
            <th class="borderTop borderRight borderBottom">CANTIDAD</th> 
            <th class="borderTop borderRight borderBottom">PESO VOLUMEN</th>		
            <th class="borderTop borderRight borderBottom">PESO</th>  
            <th class="borderTop borderRight borderBottom">VALOR MERCANCIA</th>   
            <th class="borderTop borderRight borderBottom">VALOR FLETE</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL</th>                                       
            <th class="borderTop borderRight borderBottom">VALOR FLETE LIQ</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO LIQ</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS LIQ</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL LIQ</th>                                       
                        
             
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
	 		<td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.oficina_planilla}</td>            
            <td class="borderLeft borderTop borderRight " align="center">{$r.tipo}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.planilla}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.nacional}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.propio}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.placa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.conductor}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.fecha_planilla}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.oficina_remesa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.numero_remesa}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td> 
            <td class="borderTop borderRight borderBottom">{$r.clase}</td>   
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom">{$r.cliente}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.codigo}</td>   
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.naturaleza}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.empaque}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.medida}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td>   
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso_volumen}</td>             
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td>
			<td class="borderTop borderRight borderBottom" align="center">${$r.valor_mercancia|number_format:2:',':'.'}</td>    
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_total|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_total|number_format:2:',':'.'}</td>                         
                                                   
          </tr>  
       
          {/foreach}
                                  
	 	{/if}
        {* MANIFESTADAS *}
        
     {if $estado_id eq 'ET'}     
     	{assign var="cliente" value=""}        
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente ne $r.cliente}                      
            {assign var="cliente" value=$r.cliente} 
            
         {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
           
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
            <th class="borderLeft borderTop borderRight">NUMERO REMESA</th>
            <th class="borderTop borderRight">FECHA REMESA</th>
            <th class="borderTop borderRight borderBottom">TIPO</th>
            <th class="borderTop borderRight">N. PLANILLA</th>
            <th class="borderTop borderRight">ORDEN DESPACHO</th>            
            <th class="borderTop borderRight">CLASE</th>		
            <th class="borderTop borderRight">ORIGEN</th>
            <th class="borderTop borderRight">DESTINO</th>		
            <th class="borderTop borderRight">PRODUCTO</th> 
            <th class="borderTop borderRight">PESO</th>		
            <th class="borderTop borderRight">CANTIDAD</th>   
            <th class="borderTop borderRight">VALOR</th>	
            <th class="borderTop borderRight borderBottom">REFERENCIA</th>   
            <th class="borderTop borderRight borderBottom">CANTIDAD REF</th>               
            <th class="borderTop borderRight">ESTADO</th>                    
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight" align="center">{$r.numero_remesa}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom">{$r.tipo}</td>
            <td class="borderTop borderRight">{$r.planilla}</td>
            <td class="borderTop borderRight">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight">{$r.clase}</td>  
            <td class="borderTop borderRight">{$r.origen}</td>  
            <td class="borderTop borderRight">{$r.destino}</td>  
            <td class="borderTop borderRight">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight" align="center">{$r.peso}</td> 
            <td class="borderTop borderRight" align="center">{$r.cantidad}</td> 
            <td class="borderTop borderRight" align="center">${$r.valor}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.referencia_producto}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad_ref}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td>                
          </tr>           
          {/foreach}        
                                  
	 	{/if} 
        {* ENTREGADAS *} 
        
     {if $estado_id eq 'AN'}     
     	{assign var="cliente" value=""}        
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente ne $r.cliente}                            
            {assign var="cliente" value=$r.cliente} 
            
         {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%">            
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
           <th class="borderLeft borderTop borderRight borderBottom">OFICINA PLANILLA</th>
           <th class="borderLeft borderTop borderRight ">TIPO</th>   
           <th class="borderTop borderRight borderBottom">N. PLANILLA</th>       
           <th class="borderLeft borderTop borderRight ">NACIONAL</th>
           <th class="borderLeft borderTop borderRight ">PROPIO</th>  
           <th class="borderLeft borderTop borderRight ">PLACA</th> 
           <th class="borderLeft borderTop borderRight ">CONDUCTOR</th> 
           <th class="borderLeft borderTop borderRight ">FECHA PLANILLA</th>           
           <th class="borderLeft borderTop borderRight ">OFICINA REMESA</th>
           <th class="borderLeft borderTop borderRight ">NUMERO REMESA</th>
           <th class="borderTop borderRight borderBottom">ESTADO</th>  
           <th class="borderTop borderRight borderBottom">CLASE</th>	 
           <th class="borderTop borderRight borderBottom">FECHA REMESA</th>
           <th class="borderTop borderRight borderBottom">CLIENTE</th>
            <th class="borderTop borderRight borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>	
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>	
            <th class="borderTop borderRight borderBottom">ORDEN DESPACHO</th>
            <th class="borderTop borderRight borderBottom">CODIGO</th>
            <th class="borderTop borderRight borderBottom">PRODUCTO</th> 
            <th class="borderTop borderRight borderBottom">NATURALEZA</th> 
            <th class="borderTop borderRight borderBottom">EMPAQUE</th> 
            <th class="borderTop borderRight borderBottom">MEDIDA</th>                         
            <th class="borderTop borderRight borderBottom">CANTIDAD </th> 
            <th class="borderTop borderRight borderBottom">PESO VOLUMEN</th>		
            <th class="borderTop borderRight borderBottom">PESO</th>   
            <th class="borderTop borderRight borderBottom">VALOR MERCANCIA</th>              
            <th class="borderTop borderRight">CAUSA ANULACION</th>   
            <th class="borderTop borderRight">OBSERVACION</th>
            <th class="borderTop borderRight">FECHA ANULACION</th>   
            <th class="borderTop borderRight">USUARIO QUE ANULO</th>            		
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
	 		<td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.oficina_planilla}</td>            
            <td class="borderLeft borderTop borderRight " align="center">{$r.tipo}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.planilla}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.nacional}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.propio}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.placa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.conductor}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.fecha_planilla}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.oficina_remesa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.numero_remesa}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td> 
            <td class="borderTop borderRight borderBottom">{$r.clase}</td>   
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom">{$r.cliente}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.codigo}</td>   
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.naturaleza}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.empaque}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.medida}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td>   
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso_volumen}</td>             
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td>
			<td class="borderTop borderRight borderBottom" align="center">${$r.valor_mercancia|number_format:2:',':'.'}</td>                                       
            <td class="borderTop borderRight borderBottom">{$r.causal_anulacion}</td>  
            <td class="borderTop borderRight borderBottom">{$r.observacion_anulacion}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_anulacion}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.usuario_anulacion}</td>              
          </tr>           
          {/foreach}                        
	 	{/if} 
        {* ANULADAS *}     
        
	{if $estado_id eq 'FT'}     
     	{assign var="cliente" value=""}               
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente neq $r.cliente}              
            {assign var="cliente" value=$r.cliente} 
          
          {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
           <th class="borderLeft borderTop borderRight borderBottom">OFICINA PLANILLA</th>
           <th class="borderLeft borderTop borderRight ">TIPO</th>   
           <th class="borderTop borderRight borderBottom">N. PLANILLA</th>       
           <th class="borderLeft borderTop borderRight ">NACIONAL</th>
           <th class="borderLeft borderTop borderRight ">PROPIO</th>  
           <th class="borderLeft borderTop borderRight ">PLACA</th> 
           <th class="borderLeft borderTop borderRight ">CONDUCTOR</th> 
           <th class="borderLeft borderTop borderRight ">FECHA PLANILLA</th>           
           <th class="borderLeft borderTop borderRight ">OFICINA REMESA</th>
           <th class="borderLeft borderTop borderRight ">NUMERO REMESA</th>
           <th class="borderTop borderRight borderBottom">ESTADO</th>  
           <th class="borderTop borderRight borderBottom">CLASE</th>	 
           <th class="borderTop borderRight borderBottom">FECHA REMESA</th>
           <th class="borderTop borderRight borderBottom">CLIENTE</th>
            <th class="borderTop borderRight borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>	
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>	
            <th class="borderTop borderRight borderBottom">ORDEN DESPACHO</th>
            <th class="borderTop borderRight borderBottom">CODIGO</th>
            <th class="borderTop borderRight borderBottom">PRODUCTO</th> 
            <th class="borderTop borderRight borderBottom">NATURALEZA</th> 
            <th class="borderTop borderRight borderBottom">EMPAQUE</th> 
            <th class="borderTop borderRight borderBottom">MEDIDA</th>                         
            <th class="borderTop borderRight borderBottom">CANTIDAD </th> 
            <th class="borderTop borderRight borderBottom">PESO VOLUMEN</th>		
            <th class="borderTop borderRight borderBottom">PESO</th>   
            <th class="borderTop borderRight borderBottom">VALOR MERCANCIA</th>   
            <th class="borderTop borderRight borderBottom">VALOR FLETE</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL</th>                                       
            <th class="borderTop borderRight borderBottom">VALOR FLETE LIQ</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO LIQ</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS LIQ</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL LIQ</th>                                       
                       
            <th class="borderTop borderRight">NUMERO FACTURA</th>   
            <th class="borderTop borderRight">FECHA FACTURA</th>
            <th class="borderTop borderRight">VALOR FACTURADO</th>   
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
	 		<td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.oficina_planilla}</td>            
            <td class="borderLeft borderTop borderRight " align="center">{$r.tipo}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.planilla}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.nacional}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.propio}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.placa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.conductor}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.fecha_planilla}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.oficina_remesa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.numero_remesa}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td> 
            <td class="borderTop borderRight borderBottom">{$r.clase}</td>   
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom">{$r.cliente}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.codigo}</td>   
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.naturaleza}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.empaque}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.medida}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td>   
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso_volumen}</td>             
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td>
			<td class="borderTop borderRight borderBottom" align="center">${$r.valor_mercancia|number_format:2:',':'.'}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_total|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_total|number_format:2:',':'.'}</td>                         
                                                  
            <td class="borderTop borderRight borderBottom">{$r.numero_factura}</td>  
            <td class="borderTop borderRight borderBottom">{$r.fecha_factura}</td> 
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_facturado|number_format:2:',':'.'}</td> 
          </tr>           
          {/foreach}                        
                                  
	 	{/if} 
        {* FACTURADAS *}  
        
	{if $estado_id eq 'LQ'}     
     	{assign var="cliente" value=""}               
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente neq $r.cliente}              
            {assign var="cliente" value=$r.cliente} 
          
          {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
           <th class="borderLeft borderTop borderRight borderBottom">OFICINA PLANILLA</th>
           <th class="borderLeft borderTop borderRight ">TIPO</th>   
           <th class="borderTop borderRight borderBottom">N. PLANILLA</th>       
           <th class="borderLeft borderTop borderRight ">NACIONAL</th>
           <th class="borderLeft borderTop borderRight ">PROPIO</th>  
           <th class="borderLeft borderTop borderRight ">PLACA</th> 
           <th class="borderLeft borderTop borderRight ">CONDUCTOR</th> 
           <th class="borderLeft borderTop borderRight ">FECHA PLANILLA</th>           
           <th class="borderLeft borderTop borderRight ">OFICINA REMESA</th>
           <th class="borderLeft borderTop borderRight ">NUMERO REMESA</th>
           <th class="borderTop borderRight borderBottom">ESTADO</th>  
           <th class="borderTop borderRight borderBottom">CLASE</th>	 
           <th class="borderTop borderRight borderBottom">FECHA REMESA</th>
           <th class="borderTop borderRight borderBottom">CLIENTE</th>
            <th class="borderTop borderRight borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>	
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>	
            <th class="borderTop borderRight borderBottom">ORDEN DESPACHO</th>
            <th class="borderTop borderRight borderBottom">CODIGO</th>
            <th class="borderTop borderRight borderBottom">PRODUCTO</th> 
            <th class="borderTop borderRight borderBottom">NATURALEZA</th> 
            <th class="borderTop borderRight borderBottom">EMPAQUE</th> 
            <th class="borderTop borderRight borderBottom">MEDIDA</th>                         
            <th class="borderTop borderRight borderBottom">CANTIDAD </th> 
            <th class="borderTop borderRight borderBottom">PESO VOLUMEN</th>		
            <th class="borderTop borderRight borderBottom">PESO</th>   
            <th class="borderTop borderRight borderBottom">VALOR MERCANCIA</th>  
            <th class="borderTop borderRight borderBottom">VALOR FLETE</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL</th>                                       
            <th class="borderTop borderRight borderBottom">VALOR FLETE LIQ</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO LIQ</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS LIQ</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL LIQ</th>                                       
                        
            <th class="borderTop borderRight">NUMERO LIQUIDACION</th>   
            <th class="borderTop borderRight">FECHA LIQUIDACION</th>
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
	 		<td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.oficina_planilla}</td>            
            <td class="borderLeft borderTop borderRight " align="center">{$r.tipo}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.planilla}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.nacional}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.propio}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.placa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.conductor}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.fecha_planilla}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.oficina_remesa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.numero_remesa}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td> 
            <td class="borderTop borderRight borderBottom">{$r.clase}</td>   
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom">{$r.cliente}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.codigo}</td>   
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.naturaleza}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.empaque}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.medida}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td>   
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso_volumen}</td>             
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td>
			<td class="borderTop borderRight borderBottom" align="center">${$r.valor_mercancia|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_total|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_total|number_format:2:',':'.'}</td>                         
                                                 
            <td class="borderTop borderRight borderBottom">{$r.numero_liquidacion}</td>  
            <td class="borderTop borderRight borderBottom">{$r.fecha_liquidacion}</td> 
          </tr>           
          {/foreach}                        
                                  
	 	{/if} 
        {* LIQUIDADAS *}
        
        {if $estado_id eq 'PD,P,PC,MF,LQ,AN,FT,ET'}   
        
     	{assign var="cliente" value=""}               
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente neq $r.cliente}              
            {assign var="cliente" value=$r.cliente} 
          
          {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
           <th class="borderLeft borderTop borderRight borderBottom">OFICINA PLANILLA</th>
           <th class="borderLeft borderTop borderRight ">TIPO</th>   
           <th class="borderTop borderRight borderBottom">N. PLANILLA</th>       
           <th class="borderLeft borderTop borderRight ">NACIONAL</th>
           <th class="borderLeft borderTop borderRight ">PROPIO</th>  
           <th class="borderLeft borderTop borderRight ">PLACA</th> 
           <th class="borderLeft borderTop borderRight ">CONDUCTOR</th> 
           <th class="borderLeft borderTop borderRight ">FECHA PLANILLA</th>           
           <th class="borderLeft borderTop borderRight ">OFICINA REMESA</th>
           <th class="borderLeft borderTop borderRight ">NUMERO REMESA</th>
           <th class="borderTop borderRight borderBottom">ESTADO</th>  
           <th class="borderTop borderRight borderBottom">CLASE</th>	 
           <th class="borderTop borderRight borderBottom">FECHA REMESA</th>
           <th class="borderTop borderRight borderBottom">CLIENTE</th>
            <th class="borderTop borderRight borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>	
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>	
            <th class="borderTop borderRight borderBottom">ORDEN DESPACHO</th>
            <th class="borderTop borderRight borderBottom">CODIGO</th>
            <th class="borderTop borderRight borderBottom">PRODUCTO</th> 
            <th class="borderTop borderRight borderBottom">NATURALEZA</th> 
            <th class="borderTop borderRight borderBottom">EMPAQUE</th> 
            <th class="borderTop borderRight borderBottom">MEDIDA</th>                         
            <th class="borderTop borderRight borderBottom">CANTIDAD</th> 
            <th class="borderTop borderRight borderBottom">PESO VOLUMEN</th>		
            <th class="borderTop borderRight borderBottom">PESO</th>  
            <th class="borderTop borderRight borderBottom">VALOR MERCANCIA</th>   
            <th class="borderTop borderRight borderBottom">VALOR FLETE</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL</th>                                       
            <th class="borderTop borderRight borderBottom">VALOR FLETE LIQ</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO LIQ</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS LIQ</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL LIQ</th>                                       
            
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
	 		<td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.oficina_planilla}</td>            
            <td class="borderLeft borderTop borderRight " align="center">{$r.tipo}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.planilla}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.nacional}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.propio}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.placa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.conductor}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.fecha_planilla}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.oficina_remesa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.numero_remesa}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td> 
            <td class="borderTop borderRight borderBottom">{$r.clase}</td>   
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom">{$r.cliente}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.codigo}</td>   
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.naturaleza}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.empaque}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.medida}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td>              
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso_volumen}</td>             
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td>   
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_mercancia|number_format:2:',':'.'}</td>     
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_total|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_total|number_format:2:',':'.'}</td>                         
                              
          </tr>  
       
          {/foreach}
        {else}
        
     	{assign var="cliente" value=""}               
         {foreach name=detalles from=$DETALLESREMESAS item=r}
       
		  {if $cliente eq '' or $cliente neq $r.cliente}              
            {assign var="cliente" value=$r.cliente} 
          
          {if $cliente neq '' or $cliente neq $r.cliente}</table>{/if}
          <table align="center" id="encabezado" width="90%"> 
          <tr>
            <th colspan="11" align="left">CLIENTE : {$cliente}<br /></th>       
          </tr>            
          <tr>
          	<th colspan="11" align="left">&nbsp;</th>
          </tr>    
          <tr>
           <th class="borderLeft borderTop borderRight borderBottom">OFICINA PLANILLA</th>
           <th class="borderLeft borderTop borderRight ">TIPO</th>   
           <th class="borderTop borderRight borderBottom">N. PLANILLA</th>       
           <th class="borderLeft borderTop borderRight ">NACIONAL</th>
           <th class="borderLeft borderTop borderRight ">PROPIO</th>  
           <th class="borderLeft borderTop borderRight ">PLACA</th> 
           <th class="borderLeft borderTop borderRight ">CONDUCTOR</th> 
           <th class="borderLeft borderTop borderRight ">FECHA PLANILLA</th>           
           <th class="borderLeft borderTop borderRight ">OFICINA REMESA</th>
           <th class="borderLeft borderTop borderRight ">NUMERO REMESA</th>
           <th class="borderTop borderRight borderBottom">ESTADO</th>  
           <th class="borderTop borderRight borderBottom">CLASE</th>	 
           <th class="borderTop borderRight borderBottom">FECHA REMESA</th>
           <th class="borderTop borderRight borderBottom">CLIENTE</th>
            <th class="borderTop borderRight borderBottom">ORIGEN</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>	
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>	
            <th class="borderTop borderRight borderBottom">ORDEN DESPACHO</th>
            <th class="borderTop borderRight borderBottom">CODIGO</th>
            <th class="borderTop borderRight borderBottom">PRODUCTO</th> 
            <th class="borderTop borderRight borderBottom">NATURALEZA</th> 
            <th class="borderTop borderRight borderBottom">EMPAQUE</th> 
            <th class="borderTop borderRight borderBottom">MEDIDA</th>                         
            <th class="borderTop borderRight borderBottom">CANTIDAD</th> 
            <th class="borderTop borderRight borderBottom">PESO VOLUMEN</th>		
            <th class="borderTop borderRight borderBottom">PESO</th>  
            <th class="borderTop borderRight borderBottom">VALOR MERCANCIA</th> 
            <th class="borderTop borderRight borderBottom">VALOR FLETE</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL</th>                                       
            <th class="borderTop borderRight borderBottom">VALOR FLETE LIQ</th>     
            <th class="borderTop borderRight borderBottom">VALOR SEGURO LIQ</th>               
            <th class="borderTop borderRight borderBottom">VALOR OTROS LIQ</th>                           
            <th class="borderTop borderRight borderBottom">VALOR TOTAL LIQ</th>                                       
              
          </tr>  
                 
			{/if} 
                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
	 		<td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.oficina_planilla}</td>            
            <td class="borderLeft borderTop borderRight " align="center">{$r.tipo}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.planilla}</td>  
            <td class="borderLeft borderTop borderRight " align="center">{$r.nacional}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.propio}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.placa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.conductor}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.fecha_planilla}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.oficina_remesa}</td>
            <td class="borderLeft borderTop borderRight " align="center">{$r.numero_remesa}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.estado}</td> 
            <td class="borderTop borderRight borderBottom">{$r.clase}</td>   
            <td class="borderTop borderRight borderBottom" align="center">{$r.fecha_remesa}</td>  
            <td class="borderTop borderRight borderBottom">{$r.cliente}</td> 
            <td class="borderTop borderRight borderBottom">{$r.origen}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.orden_despacho}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.codigo}</td>   
            <td class="borderTop borderRight borderBottom">{$r.descripcion_producto|substr:0:50}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.naturaleza}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.empaque}</td>
            <td class="borderTop borderRight borderBottom" align="center">{$r.medida}</td> 
            <td class="borderTop borderRight borderBottom" align="center">{$r.cantidad}</td>              
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso_volumen}</td>             
			<td class="borderTop borderRight borderBottom" align="center">{$r.peso}</td>   
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_mercancia|number_format:2:',':'.'}</td>  
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_total|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_flete|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_seguro|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_otros|number_format:2:',':'.'}</td>                         
            <td class="borderTop borderRight borderBottom" align="center">${$r.valor_liq_total|number_format:2:',':'.'}</td>                         
                                 
          </tr>  
       
          {/foreach}        
                                  
	 	{/if}
        
        
        {* TODOS *}        
        
        
  </table>
  </body>
</html>
