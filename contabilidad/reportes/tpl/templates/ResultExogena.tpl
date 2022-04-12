<html>
  <head>
    <title>Informaci&oacute;n Exogena</title>
	{$JAVASCRIPT}
    {$CSSSYSTEM} 	
  </head>
  
  <body>
  {if count($DATA) > 0}
    <table width="99%" align="center" id="encabezado" border="0">
	  <tr><td align="center" class="titulo">Informaci&oacute;n Exogena</td></tr>	
	  <tr><td>&nbsp;</td></tr>
	  <tr><td align="center" colspan="3">FORMATO {$FORMATO}&nbsp;&nbsp;&nbsp;&nbsp;Periodo: {$ANIO}</td></tr>	 	   
	</table>	
	<br />
    <table border="0" width="99%" id="registros">
         <tr align="center">
              {$campostpl}
              {$cate_tpl}
              {$campostpl_1}
         </tr>
         {foreach name=reporte  from=$DATA item=datos}	
         	 {assign var="conceptoactual" value=""}
         <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
             {foreach  key=key item=df from=$datos}
             	<td class="borderLeft borderTop borderRight" {if is_numeric($df)} align="right" {/if}} >
                	{if $key eq 'concepto' }{assign var="conceptoactual" value=$df}{/if}
                	{if is_numeric($df) && $key neq 'concepto'  && $key neq 'numero_identificacion' && $key neq 'cod_muni' }
                    	{$df|number_format:0:",":"."}
                    {else}
                    	{if  $key eq 'numero_identificacion'}
			                <a href="javascript:void(0)" onClick="popPup('InformacionExogenaClass.php?ACTIONCONTROLER=onclickGenerarAuxiliarExogena&numero_identificacion={$df}&concepto={$conceptoactual}&periodo={$ANIO}&formato={$FORMATO}&formato_exogena_id={$FORMATOID}',10,900,600)">
	                    		{$df}
                            </a>    
                        {else}
                        	{$df}
                        
                        {/if}   
                    {/if}
                </td>
             {/foreach}
           
          </tr>		
          {/foreach}
          <!--
          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="center">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.total_debito|number_format:2:",":"."}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.total_credito|number_format:2:",":"."}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.saldo_total|number_format:2:",":"."}</td>								
          </tr>  
          -->
    </table>

{else}
  <p align="center">No se encontraron registros que coincidan con los filtros seleccionados!!!!</p>
{/if}
 </body>
</html>