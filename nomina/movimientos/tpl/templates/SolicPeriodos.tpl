<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}
  {$TABLEGRIDCSS}
  </head>

  <body>
   
      <input type="hidden" id="abono_factura_proveedor_id" value="{$abono_factura_proveedor_id}" />
      <table align="center" id="tableDetalles" width="98%">
        <thead>
          <tr>
            <th>&nbsp;</th>
            <th>PERIODO</th>
            <th>INICIO</th>
            <th>FINAL</th>		
            <th>DIAS GANADOS</th>
            <th>DIAS DESCONTADOS</th>
            <th>DIAS A DESCONTAR</th>
            <th>DIAS A PAGAR</th> 
                  
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLES item=i}
          <tr>
            <td>       
                {if $i.dias_otorgados neq 15 && $i.dias_pagados eq 0 } <input type="checkbox" name="chequear" onClick="checkRow(this);"  value="{$i.factura_proveedor_id}" />
                {/if}<input type="hidden" name="fecha_inicio_hidden" value="{$i.fecha_inicio_hidden}"  /> 
                <input type="hidden" name="fecha_final_hidden" value="{$i.fecha_final_hidden}"  /> 
                <input type="hidden" name="fecha_inicio" value="{$i.inicio_periodo}"  /> 
                <input type="hidden" name="fecha_final" value="{$i.fin_periodo}"  /> 
                <input type="hidden" name="dias_hidden" value="{$i.dias_ganados}"  /> 
                <input type="hidden" name="diaso_hidden" value="{$i.dias_otorgados}"  /> 
            </td>
            <td>{$i.numero_periodo}</td>
            <td>{$i.inicio_periodo}</td>
            <td>{$i.fin_periodo}</td>
			      <td>{$i.dias_ganados}</td>
            <td>{$i.dias_otorgados}</td>
            
            <td><input type="number" name="dias_asignar" class="numeric no_requerido"  size="13" value="{math equation="x - y" x=$i.dias_otorgados y=$i.dias_pagados}" {if $i.dias_otorgados > 0}  readonly {/if} /></td>
            <td><input type="number" name="dias_pagar" class="numeric no_requerido"  size="13" value="{$i.dias_pagados}" {if $i.dias_otorgados >= 15 || $i.dias_pagados > 0}  readonly {/if}/></td>
          </tr> 
          {/foreach}	
        </tbody>
      </table>
     <center>{$ADICIONAR}</center>
  </body>
</html>