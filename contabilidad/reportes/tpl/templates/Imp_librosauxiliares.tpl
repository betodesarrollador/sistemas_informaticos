<html>
  <head>
    <title>Libro Auxiliar</title>
    {literal}
	<style>
/* CSS Document */
*{
 font-family:Arial, Helvetica, sans-serif;
 font-size:12px;
}
#encabezado{
  margin-bottom:15px;
} 
#encabezado tr td{
  font-weight:bold;
}
#registros{
  margin-top:15px;
}
#registros tr td{
  padding:4px;
}
.titulo{
 font-size:16px;
}
.subtitulo{
  font-weight:bold;
}
.borderLeft{
 border-left:1px solid;
}
.borderRight{
 border-right:1px solid;
}

.borderBottom{
  border-bottom:1px solid;
}
.borderTop{
  border-top:1px solid;
}
#usuarioProceso{
  margin-top:15px;
}
	
	{/literal}
	</style>
  </head>
  
  <body>
  <br><br><br><br>
    <!--<page_header>
		
    <table width="700"  align="center" id="encabezado" border="0">
	  <tr>
	    <td width="200">&nbsp;</td>
		<td align="center" class="titulo" width="300">Libros Auxiliares</td>
		<td width="200" align="right">Pag. [[page_cu]]/[[page_nb]]</td>
	  </tr>		 	   
	</table>		
	
    </page_header>  -->
	
    <page_footer>
	<table width="700" align="center" id="usuarioProceso">
	  <tr>
	    <td width="350" align="left">Procesado Por : {$USUARIO}</td>
		<td width="350" align="right">Fecha/Hora : {$FECHA} {$HORA}</td>
	  </tr>
	</table>
    </page_footer>	
  
  {if count($REPORTE) > 0}
    <table width="700"  align="center" id="encabezado" border="0">
	  <tr>
	    <td width="200">&nbsp;</td>
		<td align="center" class="titulo" width="300">Libros Auxiliares</td>
		<td width="200" align="right">Pag. [[page_cu]]/[[page_nb]]</td>
	  </tr>	
	  <tr><td align="center" colspan="3" width="700">{$EMPRESA} </td></tr>
	  <tr><td colspan="3" align="center" width="700">Nit. {$NIT}</td></tr>
	  <tr><td align="center" colspan="3" width="700">Centros : {$CENTROS}</td></tr>	 	 	   
	  <tr><td align="center" colspan="3" width="700">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>	 	   
	</table>	
	
	{foreach name=reporte from=$REPORTE item=r}	
	
	<br />
	<table border="0" width="700" align="center">
	  <tr>
	    <td colspan="3" width="700" >&nbsp;{$r.tercero}</td>
	  </tr>
	  <tr>
	    <td width="500" >&nbsp;{$r.codigo_puc}</td>
		<td width="200" align="right" class="subtitulo" >Saldo Anterior : &nbsp;{$r.saldo|number_format:0:",":"."}</td>
	  </tr>  
	  
	  {if is_array($r.registros)}
	  <tr>
		<td colspan="3" width="700">
			<table border="0" width="700" id="registros">
			  <tr align="center">
			   <th width="55" class="borderLeft borderTop borderRight">Fecha</th>
			   <th width="45" class="borderTop borderRight">Oficina</th>
			   <th width="45" class="borderTop borderRight">Centro</th>		   
			   <th width="35" class="borderTop borderRight">Docto</th>
			   <th width="45" class="borderTop borderRight">Numero</th>
			   <th width="245" class="borderTop borderRight">Descripcion</th>
			   <th width="70" class="borderTop borderRight" >Debito</th>
			   <th width="70" class="borderTop borderRight" >Credito</th>
			   <th width="70" class="borderTop borderRight" >Saldo</th>								
			  </tr>
			{foreach name=registros from=$r.registros item=rg}
			 <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
			   {if strlen(trim($rg.fecha)) > 0}       
			     <td class="borderLeft borderTop borderRight">{$rg.fecha}</td>
			   {else}
			     <td class="borderLeft borderTop borderRight" align="center">-------</td>
			    {/if}
			   {if strlen(trim($rg.oficina)) > 0}     
			     <td class="borderTop borderRight">{$rg.oficina}</td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}
			   {if strlen(trim($rg.centro_costo)) > 0}
			     <td class="borderTop borderRight">{$rg.centro_costo}</td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}
			   {if strlen(trim($rg.documento)) > 0}   
			     <td class="borderTop borderRight">{$rg.documento}   </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}			   
			   {if strlen(trim($rg.consecutivo)) > 0}   
			     <td class="borderTop borderRight">{$rg.consecutivo}</td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}
			   {if strlen(trim($rg.descripcion)) > 0} 
			     <td class="borderTop borderRight">{$rg.descripcion} </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}		   		   		   		   		   	   
			   {if strlen(trim($rg.debito)) > 0}      
			     <td class="borderTop borderRight" align="right">{$rg.debito|number_format:0:",":"."} </td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}		   					               
			   {if strlen(trim($rg.credito)) > 0}     
			     <td class="borderTop borderRight" align="right">{$rg.credito|number_format:0:",":"."}</td>
			   {else}
			     <td class="borderTop borderRight" align="center">-------</td>
			   {/if}		   						               
			   {if strlen(trim($rg.saldo)) > 0}       
			     <td class="borderTop borderRight" align="right">{$rg.saldo|number_format:0:",":"."}  </td>
			   {else}
			     <td class="borderTop borderRight" align="center">0</td>
			   {/if}			 
			  </tr>		
			{/foreach}
			  <tr class="subtitulo">
			   <td class="borderLeft borderTop borderRight borderBottom" colspan="6" align="center">TOTAL</td>
			   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.total_debito|number_format:0:",":"."}</td>
			   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.total_credito|number_format:0:",":"."}</td>
			   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$r.saldo_total|number_format:0:",":"."}</td>								
			  </tr>  
            </table>
	  </td>
	</tr>
	{/if}
	</table>
	{/foreach}
	
{else}
  <p align="center">No se encontraron registros que coincidan con los filtros seleccionados!!!!</p>
{/if}
 </body>
</html>