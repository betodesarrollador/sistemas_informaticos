<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}
  {$TABLEGRIDCSS}
  </head>

  <body>
   
      <input type="hidden" id="detalle_seg_id" value="{$detalle_seg_id}" />
      <table align="center" id="tableDetalles" width="98%">
        <thead>
          <tr>
            <th>&nbsp;</th>
            <th>REMESA No</th>
            <th>OBSERVACIONES</th>        
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLES item=i}
          <tr>
            <td>       
                <input type="checkbox" onClick="checkRow(this);" {if $i.ingresado eq '1'}checked{/if}  value="{$i.remesa_id}" />
                <input type="hidden" name="remesa_id" value="{$i.remesa_id}" class="required" />  
                <input type="hidden" name="ingresado" value="{$i.ingresado}" class="no_requerido" />  
                <input type="hidden" name="detalle_seg_rem_id" value="{$i.detalle_seg_rem_id}" class="no_requerido" />  
            </td>
            <td>{$i.numero_remesa}</td>
            <td class="no_requerido"><input type="text" name="observaciones" class="no_requerido" value="{$i.observaciones}" size="80" /></td>
          </tr> 
          {/foreach}	
        </tbody>
      </table>
     <center>{$ACTUALIZAR}</center>
  </body>
</html>