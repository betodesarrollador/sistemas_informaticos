<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="fuente_facturacion_cod" value="{$fuente_facturacion_cod}" />
  <div class="container-fluid">
  <div class="row">
  <div class="col-sm-12">
  <br>
  <table class="table table-striped table-bordered" align="center" id="tableDetalles" width="98%">
    <thead class="table-primary">

      <tr>
          <th>Nº FACT</th>
          <th>CLIENTE</th>
          <th>CONCEPTO</th>
          <th>TIPO CLIENTE</th>
          <th>FECHA FACT</th>
          <th>VALOR NETO</th>
          <th>IVA </th>          
          <th>RETEFUENTE </th>                    
          <th>RETEICA  </th>                              
          <th>A PAGAR  </th>                                        
          <th>RELACION PAGOS</th>
          <th>FECHA RELACION PAGOS</th>
          <th>VALOR PAGO</th>
          <th>SALDO</th>
          <th>DIAS DIFERENCIA DE PAGO</th>
          <th>PORCENTAJE APLICADO</th>
          <th>VALOR COMISION</th>
          <th><input type="checkbox" id="checkedAll"></th>
        </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLES item=i}

         <!-- <tr>
            <td><input type="text" name="fuente" id="fuente" value="{$i.consecutivo_factura}" class="required" size="15" readonly /></td>
             <td >{$i.cliente_nombre}</td>              
            <td><input type="text" name="cantidad" value="{$i.fecha}" class="required numeric" size="10" readonly  /> </td>
            <td><input type="text" name="origen" id="origen" value="{$i.valor_neto}" class="required" size="10" readonly /></td>
            <td  align="center">{$i.relacion_pago}</td>
            <td><input type="text" name="descripcion" id="descripcion" value="{$i.fecha_relacion_pago}" class="required" size="28" readonly /></td>
            <td><input type="text" name="valor_unitario" id="valor_unitario" value="{$i.valor_relacion_pago}" class="required numeric" size="12" readonly /></td>
            <td><input type="text" name="valor" id="valor" value="{$i.saldo}" class="required numeric" size="12" readonly /></td>
            <td><input type="text" name="valor" id="valor" value="{$i.diferencia_dias}" class="required numeric" size="12" readonly /></td>
            <td><input type="text" name="valor" id="valor" value="{$i.porcentaje}" class="required numeric" size="12" readonly /></td>
            <td><input type="text" name="valor" id="valor" value="{$i.comision}" class="required numeric" size="12" readonly /></td>
          </tr>-->
          
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
           <input type="hidden" name="cliente_id" value="{$i.cliente_id}" />
           <input type="hidden" name="comercial_id" value="{$i.comercial_id}" />
           <input type="hidden" name="desde" value="{$desde}" />
           <input type="hidden" name="hasta" value="{$hasta}" />
           <input type="hidden" name="tipo" value="{$tipo}" />
          <td class="borderLeft borderTop borderRight">{$i.consecutivo_factura} </td>
          <td class="borderTop borderRight">{$i.cliente_nombre}</td>
          <td class="borderTop borderRight">{$i.concepto}</td>
          <td class="borderTop borderRight">{$i.tipo_cliente}</td>
          <td class="borderTop borderRight">{$i.fecha}</td>
          <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.valor|number_format:0:',':'.'}{/if}</td>
          <td class="borderTop borderRight">{if $i.estado eq 'ANULADA'}0{else}{$i.valor_iva|number_format:0:',':'.'}{/if}</td>
          <td class="borderTop borderRight">{if $i.estado eq 'ANULADA'}0{else}{$i.valor_rte|number_format:0:',':'.'}{/if}</td>
          <td class="borderTop borderRight">{if $i.estado eq 'ANULADA'}0{else}{$i.valor_ica|number_format:0:',':'.'}{/if}</td>
          <td class="borderTop borderRight">{if $i.estado eq 'ANULADA'}0{else}{$i.valor_neto|number_format:0:',':'.'}{/if}</td>                  
          <td class="borderTop borderRight" align="center">{$i.relacion_pago}</td>
          <td class="borderTop borderRight">{$i.fecha_relacion_pago}</td>
          <td class="borderTop borderLeft borderRight" align="center"><input type="text" name="valor_pago" id="valor_pago" value="{$i.valor_relacion_pago}" class="required numeric" size="12"  /></td>
          <td class="borderTop borderLeft borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.saldo|number_format:0:',':'.'}{/if}</td>
          <td class="borderTop borderRight" align="center">{if $i.diferencia_dias eq ''}PAGO AUN NO REGISTRADO{else}{$i.diferencia_dias}{/if}</td>
          <td class="borderTop borderLeft borderRight" align="center"><input type="text" name="porcentaje" id="porcentaje" value="{$i.porcentaje}" class="required numeric" size="12"  /></td>
           <td class="borderLeft borderTop borderRight" align="center">
           <input type="text" name="total_comision" id="total_comision" value="{$i.comision}" class="required numeric" size="12"  /></td>
          <td><input type="checkbox" name="procesar" /></td>
        </tr>
	  {/foreach}
      
      <tr>
      <td></td>
      </tr>	
	</tbody>
  </table>
  </body>
  </div>
  </div>
  </div>
</html>