<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td>
  	<td align="center" class="titulo" width="40%">{if $tipo eq 'MC'} MANIFIESTOS {elseif  $tipo eq 'DU'} DESPACHOS URBANOS {elseif  $tipo eq 'DP'} DESPACHOS PARTICULARES {/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspRango Final: {$hasta}</td></tr>	
  </table>
	 
     {if $tipo eq 'MC'}
     
     	{assign var="placa" value=""}
        {assign var="subtotal" value="0"}
       
  		<table align="center" id="encabezado"  width="90%"> 
        
  		 {counter start=0 skip=1 direction=up assign=i}          
         {foreach name=detalles from=$DETALLESANTICIPOS item=r}
      
		  {if $placa eq '' or $placa ne $r.placa}              
              {if $placa neq '' and $placa ne $r.placa}
              
          <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="5" align="center" > SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center" >${$subtotal|number_format:2:',':'.'}</td>						
          </tr>     
            
          {assign var="subtotal" value="0"}
                     
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>	
              
              {/if}	              
              {assign var="placa" value=$r.placa} 
           
          <tr> <th colspan="1" align="left">PLACA : {$placa}<br /></th> </tr>            
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>      
                             
          <tr>
            <th class="borderLeft borderTop borderRight">TIPO DOCUMENTO</th>
            <th class="borderTop borderRight">NUMERO DOCUMENTO</th>
            <th class="borderTop borderRight">FECHA MANIFIESTO</th>
            <th class="borderTop borderRight">ESTADO MANIFIESTO</th>            
            <th class="borderTop borderRight">NUMERO EGRESO</th>
            <th class="borderTop borderRight">FECHA ANTICIPO</th>
            <th class="borderTop borderRight">CONTABILIZADO</th>                        
            <th class="borderTop borderRight">TENEDOR</th>
            <th class="borderTop borderRight">CONDUCTOR</th>            		
            <th class="borderTop borderRight">VALOR</th>
          </tr>         

			{/if}
          		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
		    <td class="borderLeft borderTop borderRight" align="center">{$tipo}</td>             
            <td class="borderTop borderRight" align="center">{$r.numero_documento}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_manifiesto}</td>
            <td class="borderTop borderRight" align="center">{$r.estado_manifiesto}</td>              
            <td class="borderTop borderRight" align="center">{$r.numero_egreso}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_anticipo}</td>
            <td class="borderTop borderRight" align="center">{$r.contabilizado}</td>                        
            <td class="borderTop borderRight">{$r.tenedor}</td>  
            <td class="borderTop borderRight">{$r.conductor}</td>              
            <td class="borderTop borderRight" align="center">${$r.valor|number_format:2:',':'.'}</td>   
          </tr> 
          
           {math assign="subtotal" equation="x + y" x=$subtotal y=$r.valor}
           {counter}{/foreach}

 		  <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="5" align="center" > SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center" >${$subtotal|number_format:2:',':'.'}</td>						
          </tr>                  
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>
                        
	 {/if}  {*MANIFIESTO*}     
     
          {if $tipo eq 'DU'}
          
     	{assign var="placa" value=""}
        {assign var="subtotal" value="0"}
       
  		<table align="center" id="encabezado"  width="90%"> 
        
  		 {counter start=0 skip=1 direction=up assign=i}          
         {foreach name=detalles from=$DETALLESANTICIPOS item=r}
      
		  {if $placa eq '' or $placa ne $r.placa}              
              {if $placa neq '' and $placa ne $r.placa}
              
          <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="5" align="center" > SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center" >${$subtotal|number_format:2:',':'.'}</td>						
          </tr>     
            
          {assign var="subtotal" value="0"}
                     
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>	
              
              {/if}	              
              {assign var="placa" value=$r.placa} 
           
          <tr> <th colspan="1" align="left">PLACA : {$placa}<br /></th> </tr>            
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>      
                             
          <tr>
            <th class="borderLeft borderTop borderRight">TIPO DOCUMENTO</th>
            <th class="borderTop borderRight">NUMERO DOCUMENTO</th>
            <th class="borderTop borderRight">FECHA DESPACHO</th>
            <th class="borderTop borderRight">ESTADO DESPACHO</th>            
            <th class="borderTop borderRight">NUMERO EGRESO</th>
            <th class="borderTop borderRight">FECHA ANTICIPO</th>
            <th class="borderTop borderRight">CONTABILIZADO</th>                        
            <th class="borderTop borderRight">TENEDOR</th>
            <th class="borderTop borderRight">CONDUCTOR</th>            		
            <th class="borderTop borderRight">VALOR</th>
          </tr>         

			{/if}
          		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
		    <td class="borderLeft borderTop borderRight" align="center">{$tipo}</td>             
            <td class="borderTop borderRight" align="center">{$r.numero_documento}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_despacho}</td>
            <td class="borderTop borderRight" align="center">{$r.estado_despacho}</td>              
            <td class="borderTop borderRight" align="center">{$r.numero_egreso}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_anticipo}</td>
            <td class="borderTop borderRight" align="center">{$r.contabilizado}</td>                        
            <td class="borderTop borderRight">{$r.tenedor}</td>  
            <td class="borderTop borderRight">{$r.conductor}</td>              
            <td class="borderTop borderRight" align="center">${$r.valor|number_format:2:',':'.'}</td>   
          </tr> 
          
           {math assign="subtotal" equation="x + y" x=$subtotal y=$r.valor}
           {counter}{/foreach}

 		  <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="5" align="center" > SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center" >${$subtotal|number_format:2:',':'.'}</td>						
          </tr>                  
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>
                        
	 {/if}  {*DESPACHOS URBANOS*}
     
          {if $tipo eq 'DP'}

          <tr> <th colspan="1" align="left">PLACA : <br /></th> </tr>            
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>           
                   
          <tr>
            <th class="borderLeft borderTop borderRight">TIPO DOCUMENTO</th>
            <th class="borderTop borderRight">NUMERO DOCUMENTO</th>
            <th class="borderTop borderRight">FECHA</th>
            <th class="borderTop borderRight">NUMERO EGRESO</th>
            <th class="borderTop borderRight">TENEDOR</th>		
            <th class="borderTop borderRight">VALOR</th>
          </tr>         
          		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
		    <td class="borderLeft borderTop borderRight" align="center"> {$tipo} </td>             
            <td class="borderTop borderRight" align="center"> - </td>  
            <td class="borderTop borderRight" align="center"> - </td>  
            <td class="borderTop borderRight" align="center"> - </td>  
            <td class="borderTop borderRight"> - </td>  
            <td class="borderTop borderRight" align="center"> - </td>   
          </tr> 
           
          <tr class="subtitulo">	
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="5" align="center" > SUBTOTAL : </td>
            <td class= "borderLeft borderTop borderRight borderBottom" colspan="6" align="center" > $ </td>						
          </tr>                  
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>	           
                        
	 {/if}  {*DESPACHOS PARTICULARES*}     
            
  </table>
  </body>
</html>