<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">{if $tipo eq 'MC'} ANTICIPOS MANIFIESTOS {elseif  $tipo eq 'DU'} ANTICIPOS DESPACHOS URBANOS{/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
	  <tr><td align="center" colspan="3">Rango Inicial :{$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final:{$hasta}</td></tr> 
  </table>
 
  <table align="center" id="cuerpo"  width="90%">
 	{if $tipo eq 'MC' or $tipo eq 'DU' or $tipo eq 'MC,DU'}
  
 		  {assign var="placa" value=""}
          {assign var="subtotal" value="0"}
          
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

    {foreach name=detallesEdades from=$DETALLESEDADES item=i}
     
      {if $placa eq '' or $placa neq $i.placa}
        {if $placa neq '' and $placa neq $i.placa}
        
         <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTAL</td>
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
      {assign var="placa" value=$i.placa}
   
   		   <tr><th colspan="4" align="left">PLACA :{$i.placa}<br/></th></tr>	
           <tr> <th colspan="4" align="left">&nbsp;</th> </tr>   
      
      
      
   	      <tr>
            <th class="borderLeft borderTop borderRight" rowspan="2">No EGRESOsss</th>
            <th class="borderLeft borderTop borderRight" rowspan="2">TENEDOR</th>            
            <th class="borderTop borderRight" rowspan="2">OFICINA</th>
            <th class="borderTop borderRight" rowspan="2">FECHA EGRESO</th>
            <th class="borderTop borderRight" rowspan="2">NUMERO DOCUMENTO</th>
            <th class="borderTop borderRight" colspan="2">MENOR A 1</th>   
            <th class="borderTop borderRight" colspan="2">1-30</th>		
            <th class="borderTop borderRight" colspan="2">31-60</th>
            <th class="borderTop borderRight" colspan="2">61-90</th>
            <th class="borderTop borderRight" colspan="2">91-180</th>
            <th class="borderTop borderRight" colspan="2">181-360</th>
            <th class="borderTop borderRight" colspan="2">MAYOR A 360</th>

         </tr>
         
         <tr>
            <th class="borderLeft borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">DIAS</th>
            
          </tr>      
         {/if}
     
                    
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.numero_egreso}</td>
            <td class="borderLeft borderTop borderRight">{$i.tenedor}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>
            <td class="borderTop borderRight">{$i.fecha_anticipo}</td>  
            <td class="borderTop borderRight">{$i.numero_documento}</td> 
            
            <td class="borderTop borderRight" align="right">{if $i.dias lt 0 or  $i.dias eq 0}{$i.valor|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias lt 0 or  $i.dias eq 0}{$i.dias}{/if}</td>  
            
            <td class="borderTop borderRight" align="right">{if $i.dias gt 0 and $i.dias lt 31 }{$i.valor|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 0 and $i.dias lt 31 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 30 and $i.dias lt 61 }{$i.valor|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 30 and $i.dias lt 61 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 60 and $i.dias lt 91 }{$i.valor|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 60 and $i.dias lt 91 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 90 and $i.dias lt 181 }{$i.valor|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 90 and $i.dias lt 181 }{$i.dias}{/if}</td>  
            
            <td class="borderTop borderRight" align="right">{if $i.dias gt 180 and $i.dias lt 361 }{$i.valor|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 180 and $i.dias lt 361 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 360}{$i.valor|number_format:2:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 360}{$i.dias}{/if}</td> 
         </tr>
         
                   {if  $i.dias lt 0 or  $i.dias eq 0 }
	          {math assign="acumula_0" equation="x + y" x=$acumula_0 y=$i.valor}
          {/if}
          
          {if $i.dias gt 0 and $i.dias lt 31 }
	          {math assign="acumula_30" equation="x + y" x=$acumula_30 y=$i.valor}
          {/if}
          {if $i.dias gt 30 and $i.dias lt 61 }   
          	{math assign="acumula_60" equation="x + y" x=$acumula_60 y=$i.valor}
          {/if}  
          {if $i.dias gt 60 and $i.dias lt 91 }
	          {math assign="acumula_90" equation="x + y" x=$acumula_90 y=$i.valor}          
          {/if}
          {if $i.dias gt 90 and $i.dias lt 181 }
	          {math assign="acumula_180" equation="x + y" x=$acumula_180 y=$i.valor}          
          {/if}
          {if $i.dias gt 180 and $i.dias lt 361 }
	          {math assign="acumula_360" equation="x + y" x=$acumula_360 y=$i.valor}          
          {/if}
          
          {if $i.dias gt 360}    
	          {math assign="acumula_360mas" equation="x + y" x=$acumula_360mas y=$i.valor}          
          {/if}    

          {if  $i.dias lt 0 or  $i.dias eq 0 }
	          {math assign="acumulat_0" equation="x + y" x=$acumulat_0 y=$i.valor}
          {/if}
          
          {if $i.dias gt 0 and $i.dias lt 31 }
	          {math assign="acumulat_30" equation="x + y" x=$acumulat_30 y=$i.valor}
          {/if}
          {if $i.dias gt 30 and $i.dias lt 61 }   
          	{math assign="acumulat_60" equation="x + y" x=$acumulat_60 y=$i.valor}
          {/if}  
          {if $i.dias gt 60 and $i.dias lt 91 }
	          {math assign="acumulat_90" equation="x + y" x=$acumulat_90 y=$i.valor}          
          {/if}
          {if $i.dias gt 90 and $i.dias lt 181 }
	          {math assign="acumulat_180" equation="x + y" x=$acumulat_180 y=$i.valor}          
          {/if}
          {if $i.dias gt 180 and $i.dias lt 361 }
	          {math assign="acumulat_360" equation="x + y" x=$acumulat_360 y=$i.valor}          
          {/if}
          
          {if $i.dias gt 360}    
	          {math assign="acumulat_360mas" equation="x + y" x=$acumulat_360mas y=$i.valor}          
          {/if}    
          
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor}

         
                  
          {/foreach} 
          
          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTAL</td>
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
           <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTALES POR EDADES</td>
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

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="5" align="right">TOTAL PENDIENTE</td>
           <td class="borderTop borderRight borderBottom" align="right" colspan="10">&nbsp;{$acumula_total|number_format:2:',':'.'}</td>
          </tr>  
          
       
               

   {/if}
  </table>
  

  
  </body>
</html>