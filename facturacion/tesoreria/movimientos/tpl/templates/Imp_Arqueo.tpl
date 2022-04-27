<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Impresion Arqueo</title>
{$CSSSYSTEM}
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="71%" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid"><table width="100%" border="0">
      <tr>
        <td width="160"><img src="{$DATOSENCABEZADO.logo}" width="150" height="62" /></td>
        <td width="386" align="center"><strong>{$DATOSENCABEZADO.razon_social_emp}</strong><br />
          &nbsp;{$DATOSENCABEZADO.tipo_identificacion_emp}: &nbsp;{$DATOSENCABEZADO.numero_identificacion_emp}<br /> Oficina: {$DATOSENCABEZADO.nom_oficina}</td>
      </tr>
    </table></td>
    <td width="29%" align="center" style="border-top:1px solid; border-right:1px solid; border-bottom:1px solid">
	<table width="100%" border="0">
	  <tr><td colspan="2" align="center">ARQUEO</td></tr>
      <tr>
        <td >Numero : </td>
        <td >{$DATOSENCABEZADO.consecutivo}</td>
      </tr>
      <tr>
        <td>Fecha : </td>
        <td>{$DATOSENCABEZADO.fecha_arqueo}</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid">
	<table cellspacing="0" cellpadding="0" width="98%" border="1" align="center" style="margin-top:8px; margin-bottom:8px">
      <tr align="left" >
        <td colspan="4" >&nbsp;CIFRAS MONETARIAS</td>
      </tr>
      <tr align="left" >
        <td  width="150" >&nbsp;MONEDAS</td>
        <td  width="150" >&nbsp;BILLETES</td>
        <td  width="150" >&nbsp;CHEQUES</td>
        <td  width="150" >&nbsp;TOTALES</td>        
      </tr>
      <tr>
          <td valign="top" style="padding:5px;" >
          	   <table border="0" width="98%">
                    <tr>
                        <td align="right">Valor</td><td align="right">Cantidad</td><td align="right">Total</td>
                    </tr>    
               			
			      	{foreach name=monedas from=$MONEDAS item=j}                    
               
                        <tr>
                            <td align="right">{$j.valor_dinero|number_format:0:",":"."}</td><td align="right">{$j.cantidad}</td><td align="right">{$j.valor|number_format:0:",":"."}</td>
                        </tr>    
	              
			      	{/foreach}
               </table>   
          </td>
        <td align="right" valign="top" style="padding:5px;" >
          	   <table border="0" width="98%">
                    <tr>
                        <td align="right">Valor</td><td align="right">Cantidad</td><td align="right">Total</td>
                    </tr>    
               			
			      	{foreach name=billetes from=$BILLETES item=i}                    
               
                        <tr>
                            <td align="right">{$i.valor_dinero|number_format:0:",":"."}</td><td align="right">{$i.cantidad}</td><td align="right">{$i.valor|number_format:0:",":"."}</td>
                        </tr>    
	              
			      	{/foreach}
               </table>   
        
        </td>
        <td align="right" style="padding:3px;" valign="top">{$DATOSENCABEZADO.cheques}</td>
        <td align="right" style="padding:3px;" valign="top">
        	<table border="0" cellpadding="2" cellspacing="2" width="95%">
            	<tr>
                	<td align="left">Total en efectivo: </td><td align="right">{$DATOSENCABEZADO.total_efectivo|number_format:2:",":"."}&nbsp;</td>
                </tr>    
            	<tr>
                	<td align="left">Total en Cheques: </td><td align="right">{$DATOSENCABEZADO.total_cheque|number_format:2:",":"."}&nbsp;</td>
                </tr>    
            	<tr>
                	<td align="left">Total en Caja: </td><td align="right">{$DATOSENCABEZADO.total_caja|number_format:2:",":"."}&nbsp;</td>
                </tr>    
            	<tr>
                	<td align="left">Saldo Auxiliar: </td><td align="right">{$DATOSENCABEZADO.saldo_auxiliar|number_format:2:",":"."}&nbsp;</td>
                </tr>    
            	<tr>
                	<td align="left">Diferencia: </td><td align="right">{$DATOSENCABEZADO.diferencia|number_format:2:",":"."}&nbsp;</td>
                </tr>    
			</table>

        </td>        
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; padding:5px">
    Auxiliar Caja<br /><br />

    {if count($REPORTE) > 0}
    
        
        {foreach name=reporte from=$REPORTE item=r}	
        
        <br />
        <table border="0" width="98%" align="center">
          <tr>
            <td width="72%" >&nbsp;{$r.codigo_puc}</td>
            <td align="right" class="subtitulo" >Saldo Anterior : &nbsp;{$r.saldo|number_format:0:",":"."}</td>
          </tr>  
          
          {if is_array($r.registros)}
          <tr>
            <td colspan="3">
                <table border="0" width="100%" id="registros">
                  <tr align="center">
                   <th class="borderLeft borderTop borderRight">Tercero</th>			  
                   <th class="borderLeft borderTop borderRight">Fecha</th>
                   <th class="borderTop borderRight">Oficina</th>
                   <th class="borderTop borderRight">Centro</th>		   
                   <th class="borderTop borderRight">Docto</th>
                   <th class="borderTop borderRight">Numero</th>
                   <th class="borderTop borderRight">Descripcion</th>
                   <th class="borderTop borderRight" align="right">Debito</th>
                   <th class="borderTop borderRight" align="right">Credito</th>
                   <th class="borderTop borderRight" align="right">Saldo</th>								
                  </tr>
    
                {foreach name=registros from=$r.registros item=rg}
                 <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                     <td class="borderLeft borderTop borderRight">{$rg.tercero}</td>
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
                     <td class="borderTop borderRight">
                       <a href="javascript:void(0)" onClick="viewDocument('{$rg.encabezado_registro_id}')" >{$rg.consecutivo}</a>
                     </td>
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
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="center">TOTAL</td>
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
    
        
        <br />
        <table width="80%" align="center" id="usuarioProceso">
          <tr>
            <td width="50%" align="left">Realizado Por : {$DATOSENCABEZADO.USUARIO}</td>
            <td width="50%" align="right">Fecha/Hora : {$DATOSENCABEZADO.fecha_creacion} </td>
          </tr>
        </table>
    {else}
      <p align="center">No se encontraron registros para esta Fecha!!!!</p>
    {/if}
    
	</td>
  </tr>
  
  <tr>
    <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; padding:5px">
    <BR /><BR />
	<table width="90%" border="0" align="center">
      <tr>
        <td width="50%"><table width="200" border="0" align="center">
          <tr>
            <td><br />_______________________________________________</td>
          </tr>
          <tr>
            <td align="center">APROBO</td>
          </tr>
        </table></td>
        <td width="50%"><table width="200" border="0" align="center">
          <tr>
            <td><br />____________________________________________</td>
          </tr>
          <tr>
            <td align="center">REALIZO</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
