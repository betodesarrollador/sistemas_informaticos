<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body> 

 <input type="hidden" id="destino_id" value="{$destino_id}" />  
 <input type="hidden" id="fecha_guia" value="{$fecha_guia}" />
 <input type="hidden" id="departamento_id" value="{$departamento_id}" />
 <input type="hidden" id="reexpedido_id" value="{$reexpedido_id}" />
 <span style="float:left; color:#F00; margin-left:20px; margin-top:2px;" id="mensaje_alerta">&nbsp;</span>
 <div align="right" style="margin-right:20px;">Codigo de Barras: <input type="text"  name="codigo_barras1" id="codigo_barras1" /></div>
{assign var="destino" value=""}  
  {foreach name=detalles from=$DETALLES item=r}
     {if $destino eq '' or $destino neq $r.destino}              
      {assign var="destino" value=$r.destino}
      
      {if $destino neq '' or $destino neq $r.destino}</table>
      {/if}      
          <table align="center" id="encabezado" width="95%"> 
          <tr>
            <th colspan="7" align="left">DESTINO : {$destino}<br /></th>       

          </tr>            
          <tr>
          	<th colspan="7" align="left">&nbsp;</th>
          </tr>   
        
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom"><input type="checkbox" id="checkedAllss" ></th>
            <th class="borderTop borderRight borderBottom">GUIA</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>		
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>
            <th class="borderTop borderRight borderBottom">DIRECCION</th>            
            <th class="borderTop borderRight borderBottom">FECHA</th>                    
          </tr>    
          	{/if}                   		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.link}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.guia}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>  
            <td class="borderTop borderRight borderBottom">{$r.direccion_destinatario}</td>              
            <td class="borderTop borderRight borderBottom">{$r.fecha}</td>              
          </tr>  
       
          {/foreach}   
        {* GUIA *}
        
  </table>
  </body>
</html>