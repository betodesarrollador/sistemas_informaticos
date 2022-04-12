<html>
  <head>
    <title>Balance de Prueba</title>
	{$JAVASCRIPT}
    {$CSSSYSTEM} 	
  </head>
  
  <body>

    <table width="80%" align="center" id="encabezado" border="0">
	  <tr><td width="30%">&nbsp;</td>
	  <td align="center" class="titulo" width="40%">Balance de Pruebas</td><td width="30%" align="right">&nbsp;</td></tr>	
	  <tr><td colspan="3">&nbsp;</td></tr>
	  <tr><td align="center" colspan="3">{$EMPRESA} </td></tr>
	  <tr><td colspan="3" align="center">Nit. {$NIT}</td></tr>
	  <tr><td align="center" colspan="3">Sucursales : {$CENTROS}</td></tr>	 	 	   
	  <tr><td align="center" colspan="3">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>	 	   
	</table>	
		
	<br /><br />
    {if $OPCTERCERO eq 'U'}
	<table border="0" width="95%" align="center">
	  <tr>
	    <td colspan="3" >&nbsp;{$TERCEROUNO}</td>
	  </tr>   
    </table> <br />
    {/if}
	<table border="0" width="95%%" align="center">	    	  
	  <tr>
		<td width="100%" colspan="3">
			<table border="0" width="100%" id="registros">
			  <tr align="center">
			   <th class="borderTop borderRight">Generar auxiliar</th>
               <th class="borderTop borderRight">Codigo</th>
			   <th class="borderTop borderRight">Cuenta</th>               
			   <th class="borderTop borderRight" align="right">Saldo Anterior</th>
			   <th class="borderTop borderRight" align="right">Debito</th>
			   <th class="borderTop borderRight" align="right">Credito</th>
			   <th class="borderTop borderRight" align="right">Nuevo Saldo</th>								
			  </tr>
             {assign var="cuenta_puc" value=""}  
             {assign var="nuevo_saldo_cuenta" value="0"}     

			{foreach name=reporte from=$REPORTE item=r}    
                 {if $OPCTERCERO eq 'T' && $NIVEL eq '5' && ($cuenta_puc=='' || $cuenta_puc!=$r.cod_puc)}
                 	 {if $r.debito_cuenta !='' || $r.credito_cuenta!=''}
                     	{if $r.saldo_anterior_cuenta!='' }
                        	{assign var="saldo_anterior_cuenta1" value=$r.saldo_anterior_cuenta}    
                        {else}
                        	{assign var="saldo_anterior_cuenta1" value="0"}                            
                        {/if}
                        {if $r.naturaleza eq 'D'}
                            {math assign="nuevo_saldo_cuenta" equation="((W+X)-Y)" W=$saldo_anterior_cuenta1 X=$r.debito_cuenta Y=$r.credito_cuenta }
                        {else}
                            {math assign="nuevo_saldo_cuenta" equation="((W+Y)-X)" W=$saldo_anterior_cuenta1 X=$r.debito_cuenta Y=$r.credito_cuenta }
                        {/if}
                     {else}
	                     {assign var="nuevo_saldo_cuenta" value=$r.saldo_anterior_cuenta}  
                     
                     {/if}
                     {if $r.saldo_anterior_cuenta!='' ||  $r.debito_cuenta!='' || $r.credito_cuenta!=''}
                         <tr bgcolor="#d0d0d0"> 
                         
                            <td class="borderTop borderRight" align="left"><strong><a href="javascript:void(0)" onClick="popPup('LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&reporte=C&opciones_tercero=T&opciones_centros={$opciones_centros}&centro_de_costo_id={$centro_de_costo_id}&opciones_documentos=T&documentos={$documentos}&opciones_oficinas=T&cuenta_desde_id={$r.puc_id}&cuenta_hasta_id={$r.puc_id}&desde={$DESDE}&hasta={$HASTA}&agrupar=defecto&balancegeneral=true',10,900,600)">Auxiliar---></a></strong></td>
                             <td class="borderTop borderRight" align="left"><a href="javascript:void(0)" >{$r.cod_puc}</a></td>
                             <td class="borderTop borderRight" align="left"><strong>{$r.nombre}</strong></td>                 
                             <td class="borderTop borderRight" align="right"><strong>{$r.saldo_anterior_cuenta|number_format:0:",":"."}</strong></td>
                             <td class="borderTop borderRight" align="right"><strong>{$r.debito_cuenta|number_format:0:",":"."}</strong></td>
                             <td class="borderTop borderRight" align="right"><strong>{$r.credito_cuenta|number_format:0:",":"."}</strong></td>
                             <td class="borderTop borderRight" align="right"><strong>{$nuevo_saldo_cuenta|number_format:0:",":"."}</strong></td>
                         
                         </tr>	
                     {/if}
                     {assign var="cuenta_puc" value=$r.cod_puc}  
                 {/if}				        
                 {if $r.saldo_anterior>0 || $r.saldo_anterior<0  || $r.debito>0 || $r.credito>0}
                 
                     <tr {if $r.tipo_link neq 1} bgcolor="#d0d0d0"{/if}>
                         {if $OPCTERCERO eq 'U'}
                             <td class="borderTop borderRight " align="left" ><a href="javascript:void(0)"  {if $r.tipo_link eq 1} class="color2" {/if} onClick="popPup('LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&reporte=C&opciones_tercero=U&tercero_id={$tercero_id}&opciones_centros={$opciones_centros}&centro_de_costo_id={$centro_de_costo_id}&opciones_documentos=T&documentos={$documentos}&opciones_oficinas=T&cuenta_desde_id={$r.puc_id}&cuenta_hasta_id={$r.puc_id}&desde={$DESDE}&hasta={$HASTA}&agrupar=defecto&balancegeneral=true',10,900,600)">Auxiliar---></a></td>
                         {else}
                            <td class="borderTop borderRight" align="left"><a href="javascript:void(0)" {if $r.tipo_link eq 1} class="color2"  {assign var="consulta_tercero" value="&opciones_tercero=U&tercero_id="} {else} {assign var="consulta_tercero" value="&opciones_tercero=T"}{/if} onClick="popPup('LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&reporte=C&opciones_centros={$opciones_centros}&centro_de_costo_id={$centro_de_costo_id}&opciones_documentos=T&documentos={$documentos}&opciones_oficinas=T&cuenta_desde_id={$r.puc_id}&cuenta_hasta_id={$r.puc_id}&desde={$DESDE}&hasta={$HASTA}&agrupar=defecto&balancegeneral=true{$consulta_tercero}{$r.tipo_tercero_id}',10,900,600)">Auxiliar---></a></td>
                         {/if}    
                         <td class="borderTop borderRight" align="left">{if $r.tipo_link eq 1} &nbsp;&nbsp;&nbsp; {/if}<a href="javascript:void(0)" {if $r.tipo_link eq 1} class="color2" {/if}>{$r.codigo_puc}</a></td>     
                         <td class="borderTop borderRight" align="left">{if $r.tipo_link eq 1} &nbsp;&nbsp;&nbsp; {/if}{$r.cuenta}</td>                  
                         <td class="borderTop borderRight" align="right">{$r.saldo_anterior|number_format:0:",":"."}</td>
                         <td class="borderTop borderRight" align="right">{$r.debito|number_format:0:",":"."}</td>
                         <td class="borderTop borderRight" align="right">{$r.credito|number_format:0:",":"."}</td>
                         <td class="borderTop borderRight" align="right">{$r.nuevo_saldo|number_format:0:",":"."}</td>
                     </tr>	
                 {/if}	
			{/foreach} 

                 <tr bgcolor="{cycle values="#d0d0d0,#eeeeee"}">
                     <td class="borderTop borderRight" align="left" colspan="3">TOTAL</td>
                     <td class="borderTop borderRight" align="right"></td>
                     <td class="borderTop borderRight" align="right">{$DEBITO|number_format:0:",":"."}</td>
                     <td class="borderTop borderRight" align="right">{$CREDITO|number_format:0:",":"."}</td>
                     <td class="borderTop borderRight" align="right"></td>
                  </tr>		
            
            </table>
	  </td>
	</tr>
	</table>
	
	
	<table width="80%" align="center" id="usuarioProceso">
	  <tr>
	    <td width="50%" align="left">Procesado Por : {$USUARIO}</td>
		<td width="50%" align="right">Fecha/Hora : {$FECHA} {$HORA}</td>
	  </tr>
	</table>


 </body>
</html>