<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body> 
    <input type="hidden" id="tipo" value="{$tipo}" />
    <input type="hidden" id="estado" value="{$estado}" />    
    <table width="90%" align="center" id="encabezado" border="0">
        <tr>
        	<td width="30%">&nbsp;</td>
            <td align="center" class="titulo" width="40%">
            {if $estado eq 'CE'} REPORTE ANTICIPOS POR EDADES 
            {elseif  $estado eq 'P'} REPORTE ANTICIPOS PENDIENTES 
            {elseif  $estado eq 'ALL'} RELACION ANTICIPOS {/if}
            
            </td>
            <td width="30%" align="right">&nbsp;</td>
		</tr>	
        <tr>
        	<td colspan="3">&nbsp;</td>
		</tr>
        <tr>
        	<td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rango Final : {$hasta}</td>
		</tr>	
    </table>
    {if $estado eq 'P'}
    {assign var="tenedor" value=""}
    {assign var="subtotal" value="0"}
    
    <table align="center" id="encabezado" width="90%"> 
    {counter start=0 skip=1 direction=up assign=i}          
    {foreach name=detalles from=$DETALLESANTICIPOS item=r}
    
   
    
    {if $tenedor eq '' or $tenedor ne $r.tenedor_id}              
    {if $tenedor neq '' and $tenedor ne $r.tenedor_id}
        <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center"> SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" align="right" >${$subtotal|number_format:2:',':'.'}</td>	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="left" >&nbsp;</td>						            					
        </tr>     
        {assign var="subtotal" value="0"}
        <tr> 
        	<th colspan="7" align="left">&nbsp;</th> 
		</tr>	
    {/if}	              
        {assign var="tenedor" value=$r.tenedor_id} 
        <tr> 
            <th colspan="12" align="left">TENEDOR : {$r.tenedor}<br /></th> 
        </tr>            
        <tr> 
            <th colspan="12" align="left">&nbsp;</th> 
        </tr>      
        <tr>
            <th class="borderLeft borderTop borderRight">DOCUMENTO</th>
            <th class="borderTop borderRight">FECHA PLANILLA</th>
            <th class="borderTop borderRight">ESTADO PLANILLA</th>            
            <th class="borderTop borderRight">N&Uacute;MERO EGRESO</th>
            <th class="borderTop borderRight">FECHA ANTICIPO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th> 
            <th class="borderTop borderRight">ESTADO ANTICIPO</th>                       
            <th class="borderTop borderRight">PLACA</th>
            <th class="borderTop borderRight">CONDUCTOR</th>    
        </tr>         
    {/if}
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
            <td class="borderLeft borderTop borderRight" align="center">{$r.tipo_documento}-{$r.numero_documento}</td>             
            <td class="borderTop borderRight" align="center">{$r.fecha_planilla}</td>
            <td class="borderTop borderRight" align="center">{$r.estado_planilla}</td>              
            <td class="borderTop borderRight" align="center">{$r.numero_egreso}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_anticipo}</td>
            <td class="borderTop borderRight" align="center">{$r.dias}</td>
            <td class="borderTop borderRight" align="right">${$r.valor|number_format:2:',':'.'}</td>       
            <td class="borderTop borderRight" align="center">{$r.estado_anticipo}</td>                   
            <td class="borderTop borderRight">{$r.placa}</td>  
            <td class="borderTop borderRight">{$r.conductor}</td>   
        </tr> 
        {math assign="subtotal" equation="x + y" x=$subtotal y=$r.valor}
        {counter}{/foreach}
        <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center"> SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" align="right" >${$subtotal|number_format:2:',':'.'}</td>	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="left" >&nbsp;</td>						            					
        </tr>                  
        <tr> 
        	<th colspan="7" align="left">&nbsp;</th> 
		</tr>
    </table>
    {/if}
    {if $estado eq 'ALL'}
    {assign var="tenedor" value=""}
    {assign var="subtotal" value="0"}
    {assign var="saldot" value="0"}
    
    <table align="center" id="encabezado" width="90%"> 
    {counter start=0 skip=1 direction=up assign=i}          
    {foreach name=detalles from=$DETALLESANTICIPOS item=r}
    {if $tenedor eq '' or $tenedor ne $r.tenedor_id}              
    {if $tenedor neq '' and $tenedor ne $r.tenedor_id}
        <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center"> SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" align="right" >${$subtotal|number_format:2:',':'.'}</td>	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="7" align="left" >&nbsp;</td>						            					
        </tr>     
        {assign var="subtotal" value="0"}
        <tr> 
        	<th colspan="7" align="left">&nbsp;</th> 
		</tr>	
    {/if}	              
        {assign var="tenedor" value=$r.tenedor_id} 
        <tr> 
            <th colspan="13" align="left">TENEDOR : {$r.tenedor}<br /></th> 
        </tr>            
        <tr> 
            <th colspan="13" align="left">&nbsp;</th> 
        </tr>      
        <tr>
            <th class="borderLeft borderTop borderRight">DOCUMENTO</th>
            <th class="borderTop borderRight">FECHA PLANILLA</th>
            <th class="borderTop borderRight">ESTADO PLANILLA</th>            
            <th class="borderTop borderRight">N&Uacute;MERO EGRESO</th>
            <th class="borderTop borderRight">FECHA ANTICIPO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th> 
            <th class="borderTop borderRight">DEVOLUCIONES</th> 
            <th class="borderTop borderRight">ESTADO ANTICIPO</th>                       
            <th class="borderTop borderRight">PLACA</th>
            <th class="borderTop borderRight">CONDUCTOR</th>    
            <th class="borderTop borderRight">LEGALIZACI&Oacute;N/<br>LIQUIDACI&Oacute;N</th>        		
            <th class="borderTop borderRight">ABONOS</th>
            <th class="borderTop borderRight">SALDO</th>
        </tr>         
    {/if}
		{if $r.abono>0 && $r.estado_anticipo neq 'ANULADO'}	    
			{math assign="saldot" equation="x - y" x=$r.valor y=$r.abono}    
        {elseif $r.estado_anticipo neq 'ANULADO'}
			{math assign="saldot" equation="x - y" x=$r.valor y=0}    
		{elseif $r.estado_anticipo eq 'ANULADO'}            
        	{assign var="saldot" value="0"}
        {/if}            
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
            <td class="borderLeft borderTop borderRight" align="left">{$r.tipo_documento}-{$r.numero_documento}</td>             
            <td class="borderTop borderRight" align="center">{$r.fecha_planilla}</td>
            <td class="borderTop borderRight" align="center">{$r.estado_planilla}</td>              
            <td class="borderTop borderRight" align="center">{$r.numero_egreso}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_anticipo}</td>
            <td class="borderTop borderRight" align="center">{$r.dias}</td>
            <td class="borderTop borderRight" align="right">${$r.valor|number_format:2:',':'.'}</td>       
            <td class="borderTop borderRight" align="right">${$r.devol|number_format:2:',':'.'}</td>       
            <td class="borderTop borderRight" align="center">{$r.estado_anticipo}</td>                   
            <td class="borderTop borderRight">{$r.placa}</td>  
            <td class="borderTop borderRight">{$r.conductor}</td>   
            <td class="borderTop borderRight" align="center">{$r.numero_legalizacion}</td>             
            <td class="borderTop borderRight" align="right">${$r.abono|number_format:2:',':'.'}</td> 
            <td class="borderTop borderRight" align="right">${$saldot|number_format:2:',':'.'}</td>                 
        </tr> 
        {if $r.estado_anticipo neq 'ANULADO'}	
        	{math assign="subtotal" equation="x + y" x=$subtotal y=$r.valor}
        {/if}
        {counter}{/foreach}
        <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center"> SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" align="right" >${$subtotal|number_format:2:',':'.'}</td>	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="7" align="left" >&nbsp;</td>						            					
        </tr>                  
        <tr> 
        	<th colspan="7" align="left">&nbsp;</th> 
		</tr>
    </table>
    {/if}
    {if $estado eq 'CE'}
      <table align="center" id="encabezado"  width="90%">  
 		  {assign var="tenedor" value=""}
          {assign var="subtotal" value="0"}
          {assign var="saldot" value="0"}
          
          {assign var="acumula_0" value="0"}
          {assign var="acumula_30" value="0"}
          {assign var="acumula_60" value="0"}
          {assign var="acumula_90" value="0"}
          {assign var="acumula_180" value="0"}
          {assign var="acumula_360" value="0"}
          {assign var="acumula_360mas" value="0"}


          {assign var="acumulat_0" value="0"}
          {assign var="acumulat_30" value="0"}
          {assign var="acumulat_60" value="0"}
          {assign var="acumulat_90" value="0"}
          {assign var="acumulat_180" value="0"}
          {assign var="acumulat_360" value="0"}
          {assign var="acumulat_360mas" value="0"}

    {foreach name=detallesAnticipos from=$DETALLESANTICIPOS item=i}
    
    {if $i.abono>0 && $i.estado_anticipo neq 'ANULADO' && $i.devol>0}	    
			{math assign="saldot" equation="(x - y) - z" x=$i.valor y=$i.abono z=$i.devol}
        {elseif $i.abono>0 && $i.estado_anticipo neq 'ANULADO'}
            {math assign="saldot" equation="x - y" x=$i.valor y=$i.abono}
        {elseif $i.estado_anticipo neq 'ANULADO' && $i.devol>0}
            {math assign="saldot" equation="x - y" x=$i.valor y=$i.devol}        
        {elseif $i.estado_anticipo neq 'ANULADO'}
			{math assign="saldot" equation="x - y" x=$i.valor y=0}    
		{elseif $i.estado_anticipo eq 'ANULADO'}            
        	{assign var="saldot" value="0"}
        {/if}            
           
         {if $saldot!=0}   
    
    
          
         {if $tenedor eq '' or $tenedor neq $i.tenedor_id}
         {if $tenedor neq '' and $tenedor neq $i.tenedor_id}
         {math assign="acumula_total_tene" equation="s + t + u + v + x + y + z" s=$acumula_0 t=$acumula_30 u=$acumula_60 v=$acumula_90 x=$acumula_180 y=$acumula_360 z=$acumula_360mas}
        
         <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTAL EDADES</td>
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">{$acumula_total_tene|number_format:2:',':'.'}</td>
                   <td class="borderLeft borderTop borderRight borderBottom" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_0|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_30|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_60|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_180|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360mas|number_format:2:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                  </tr>  
                  {assign var="acumula_0" value="0"}
                  {assign var="acumula_30" value="0"}
                  {assign var="acumula_60" value="0"}
                  {assign var="acumula_90" value="0"}
                  {assign var="acumula_180" value="0"}
                  {assign var="acumula_360" value="0"}
                  {assign var="acumula_360mas" value="0"}
                  
                  <tr> <th colspan="4" align="left">&nbsp;</th> </tr>	        
                  <tr> <th colspan="4" align="left">&nbsp;</th> </tr>
        
        {/if}
      {assign var="tenedor" value=$i.tenedor_id}
   
   		   <tr><th colspan="5" align="left">TENEDOR : {$i.tenedor} - {$i.numero_identificacion_tenedor}<br/></th></tr>	
           <tr> <th colspan="4" align="left">&nbsp;</th> </tr>   
      
      
      
   	      <tr>
           	<th class="borderLeft borderTop borderRight" rowspan="2">DOCUMENTO</th>
            <th class="borderLeft borderTop borderRight" rowspan="2">No EGRESO</th>
            <th class="borderLeft borderTop borderRight" rowspan="2">PLACA</th>            
            <th class="borderTop borderRight" rowspan="2">OFICINA</th>
            <th class="borderTop borderRight" rowspan="2">FECHA EGRESO</th>
            <th class="borderTop borderRight" rowspan="2">NUMERO DOCUMENTO</th>
            <th class="borderTop borderRight" rowspan="2">VALOR</th>
            <th class="borderTop borderRight" colspan="2">MENOR A 30</th>   
            <th class="borderTop borderRight" colspan="2">1-30</th>		
            <th class="borderTop borderRight" colspan="2">31-60</th>
            <th class="borderTop borderRight" colspan="2">61-90</th>
            <th class="borderTop borderRight" colspan="2">91-180</th>
            <th class="borderTop borderRight" colspan="2">181-360</th>
            <th class="borderTop borderRight" colspan="2">MAYOR A 360</th>

         </tr>
         
         <tr>
            <th class="borderLeft borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">SALDO</th>
            <th class="borderTop borderRight">DIAS</th>
            
          </tr>      
         {/if}
     

		{if $i.abono>0 && $i.estado_anticipo neq 'ANULADO' && $i.devol>0}	    
			{math assign="saldot" equation="(x - y) - z" x=$i.valor y=$i.abono z=$i.devol}
        {elseif $i.abono>0 && $i.estado_anticipo neq 'ANULADO'}
            {math assign="saldot" equation="x - y" x=$i.valor y=$i.abono}
        {elseif $i.estado_anticipo neq 'ANULADO' && $i.devol>0}
            {math assign="saldot" equation="x - y" x=$i.valor y=$i.devol}        
        {elseif $i.estado_anticipo neq 'ANULADO'}
			{math assign="saldot" equation="x - y" x=$i.valor y=0}    
		{elseif $i.estado_anticipo eq 'ANULADO'}            
        	{assign var="saldot" value="0"}
        {/if}            
           
           
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.tipo_documento}-{$i.numero_documento}</td>
            <td class="borderLeft borderTop borderRight">{$i.numero_egreso}</td>
            <td class="borderLeft borderTop borderRight">{$i.placa}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>
            <td class="borderTop borderRight" align="center">{$i.fecha_anticipo}</td>  
            <td class="borderTop borderRight">{$i.numero_documento}</td> 
            <td class="borderTop borderRight">{$i.valor|number_format:2:',':'.'}</td> 
            
            <td class="borderTop borderRight" align="right">{if $i.dias lt 0 or  $i.dias eq 0}{$saldot|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.dias lt 0 or  $i.dias eq 0}{$i.dias}{/if}</td>  
            
            <td class="borderTop borderRight" align="right">{if $i.dias gt 0 and $i.dias lt 31 }{$saldot|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.dias gt 0 and $i.dias lt 31 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 30 and $i.dias lt 61 }{$saldot|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.dias gt 30 and $i.dias lt 61 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 60 and $i.dias lt 91 }{$saldot|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.dias gt 60 and $i.dias lt 91 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 90 and $i.dias lt 181 }{$saldot|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.dias gt 90 and $i.dias lt 181 }{$i.dias}{/if}</td>  
            
            <td class="borderTop borderRight" align="right">{if $i.dias gt 180 and $i.dias lt 361 }{$saldot|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.dias gt 180 and $i.dias lt 361 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 360}{$saldot|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.dias gt 360}{$i.dias}{/if}</td> 
         </tr>
         {/if}
		  {if  $i.dias lt 0 or  $i.dias eq 0 }
	          {math assign="acumula_0" equation="x + y" x=$acumula_0 y=$saldot}
          {/if}
          
          {if $i.dias gt 0 and $i.dias lt 31 }
	          {math assign="acumula_30" equation="x + y" x=$acumula_30 y=$saldot}
          {/if}
          {if $i.dias gt 30 and $i.dias lt 61 }   
          	{math assign="acumula_60" equation="x + y" x=$acumula_60 y=$saldot}
          {/if}  
          {if $i.dias gt 60 and $i.dias lt 91 }
	          {math assign="acumula_90" equation="x + y" x=$acumula_90 y=$saldot}          
          {/if}
          {if $i.dias gt 90 and $i.dias lt 181 }
	          {math assign="acumula_180" equation="x + y" x=$acumula_180 y=$saldot}          
          {/if}
          {if $i.dias gt 180 and $i.dias lt 361 }
	          {math assign="acumula_360" equation="x + y" x=$acumula_360 y=$saldot}          
          {/if}
          
          {if $i.dias gt 360}    
	          {math assign="acumula_360mas" equation="x + y" x=$acumula_360mas y=$saldot}          
          {/if}    

          {if  $i.dias lt 0 or  $i.dias eq 0 }
	          {math assign="acumulat_0" equation="x + y" x=$acumulat_0 y=$saldot}
          {/if}
          
          {if $i.dias gt 0 and $i.dias lt 31 }
	          {math assign="acumulat_30" equation="x + y" x=$acumulat_30 y=$saldot}
          {/if}
          {if $i.dias gt 30 and $i.dias lt 61 }   
          	{math assign="acumulat_60" equation="x + y" x=$acumulat_60 y=$saldot}
          {/if}  
          {if $i.dias gt 60 and $i.dias lt 91 }
	          {math assign="acumulat_90" equation="x + y" x=$acumulat_90 y=$saldot}          
          {/if}
          {if $i.dias gt 90 and $i.dias lt 181 }
	          {math assign="acumulat_180" equation="x + y" x=$acumulat_180 y=$saldot}          
          {/if}
          {if $i.dias gt 180 and $i.dias lt 361 }
	          {math assign="acumulat_360" equation="x + y" x=$acumulat_360 y=$saldot}          
          {/if}
          
          {if $i.dias gt 360}    
	          {math assign="acumulat_360mas" equation="x + y" x=$acumulat_360mas y=$saldot}          
          {/if}    
          
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$saldot}
          {/foreach} 
          {math assign="acumula_total_tene" equation="s + t + u + v + x + y + z" s=$acumula_0 t=$acumula_30 u=$acumula_60 v=$acumula_90 x=$acumula_180 y=$acumula_360 z=$acumula_360mas}

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTAL EDADES</td>
           <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">{$acumula_total_tene|number_format:2:',':'.'}</td>
           <td class="borderLeft borderTop borderRight borderBottom" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_0|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_30|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_60|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_180|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360mas|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
          </tr>  
          <tr >
           <td  colspan="13" align="right">&nbsp;</td>
          </tr>  
          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="right">GRAN TOTAL POR EDADES</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_0|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>	   
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_30|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_60|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_90|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_180|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_360|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_360mas|number_format:2:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
          </tr>   
  </table>
  {/if}
</body>
</html>