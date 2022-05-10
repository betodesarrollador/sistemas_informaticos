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
 <input type="hidden" id="manifiesto_id" value="{$manifiesto_id}" />
  
  {foreach name=detalles from=$DETALLES item=r}
       
          <table align="center" id="encabezado" width="90%">         
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom"></th>
            <th class="borderTop borderRight borderBottom">GUIA</th>
            <th class="borderTop borderRight borderBottom">REMITENTE</th>
            <th class="borderTop borderRight borderBottom">DESTINO</th>		
            <th class="borderTop borderRight borderBottom">DESTINATARIO</th>
            <th class="borderTop borderRight borderBottom">FECHA</th>                    
          </tr>                     		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center">{$r.link}</td>  
            <td class="borderTop borderRight borderBottom" align="center">{$r.guia}</td>  
            <td class="borderTop borderRight borderBottom">{$r.remitente}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destino}</td>  
            <td class="borderTop borderRight borderBottom">{$r.destinatario}</td>  
            <td class="borderTop borderRight borderBottom">{$r.fecha}</td>              
          </tr>  
       
          {/foreach}   
        {* GUIA *}
        
  </table>
  </body>
</html>