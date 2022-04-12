<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="/rotterdan/framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body style="padding: 8px;"> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado">
          <tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">{if $tipo eq 'FP'}Facturas Pendientes{elseif  $tipo eq 'EC'}Estado De Cuenta{elseif  $tipo eq 'RF'}Relaci&oacute;n de Facturas{elseif  $tipo eq 'PE'}Cartera por Edades{/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
          <tr><td colspan="3">&nbsp;</td></tr>
          <tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td></tr>
          {if $proveedor neq 'NULL'}
          <tr><td colspan="3">&nbsp;</td></tr>
          <tr><td align="center" colspan="3"><b>PROVEEDOR:</b> {$proveedor}</td></tr>
          {/if}	 	   
        </table>

  <table align="center" width="100%" class="table table-striped">
      {if $tipo eq 'FP'}
          {assign var="prov" value=""}
          {assign var="acumula_total" value="0"}
          {assign var="acumula_saldos" value="0"}

          {assign var="acumula_totales" value="0"}
          {assign var="acumula_saldos_total" value="0"}
          
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $prov eq '' or $prov neq $i.proveedor_nombre}
              
              {if $prov neq '' and $prov neq $i.proveedor_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:0:',':'.'}</td>								
                  </tr>  
                  {assign var="acumula_total" value="0"}
                  {assign var="acumula_saldos" value="0"}
                  <tr>
                    <th colspan="7" align="left">&nbsp;</th>
                  </tr>	
                  <tr>
                    <th colspan="7" align="left">&nbsp;</th>
                  </tr>	
                  
                  
			  {/if}	
              {assign var="prov" value=$i.proveedor_nombre}

          <tr>
          	<th colspan="7" align="left">{$i.proveedor_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="7" align="left">&nbsp;</th>
          </tr>	

          <tr>
            <th class="borderLeft borderTop borderRight">CLIENTE</th>
          	<th class="borderLeft borderTop borderRight">CAUSACION NO.</th>
            <th class="borderTop borderRight">DOC. REFERENCIA</th>
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">FECHA FACT</th>
            <th class="borderTop borderRight">VENCE</th>
            <th class="borderTop borderRight">DIAS</th>		
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">SALDO</th>
          </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td class="borderLeft borderTop borderRight">{$i.proveedor_nombre}</td> 
          	<td class="borderLeft borderTop borderRight">{$i.consecutivo_id}</td> 
            <td class="borderTop borderRight">{if $i.codfactura_proveedor neq ''}Fact. {$i.codfactura_proveedor}{/if} {if $i.manifiesto neq ''}Planilla: {$i.manifiesto}{/if} {if $i.orden_no neq ''}Orden Ser No: {$i.orden_no}{/if}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.fecha_factura_proveedor}</td>  
            <td class="borderTop borderRight">{$i.vence_factura_proveedor}</td>  
            <td class="borderTop borderRight">{$i.dias}</td>  
            <td class="borderTop borderRight" align="right">{$i.valor_neto|number_format:0:',':'.'}</td>  
            <td class="borderTop borderRight" align="right">{$i.saldo|number_format:0:',':'.'}</td>  
          </tr> 
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
          {math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}

          {math assign="acumula_totales" equation="x + y" x=$acumula_totales y=$i.valor_neto}
          {math assign="acumula_saldos_total" equation="x + y" x=$acumula_saldos_total y=$i.saldo}
          
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:0:',':'.'}</td>								
          </tr>  

          <tr >
           <td  colspan="7" align="right">&nbsp;</td>
          </tr>  
          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="7" align="right">TOTAL TODOS LOS TERCEROS</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_totales|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos_total|number_format:0:',':'.'}</td>								
          </tr>  
          
      {elseif $tipo eq 'RS'}    
          
          
           <tr>
          	<th class="borderLeft borderTop borderRight">ORDEN NO.</th>
            <th class="borderTop borderRight">SUCURSAL</th>
             <th class="borderTop borderRight">ESTADO</th>
            <th class="borderTop borderRight">FECHA</th>
            <th class="borderTop borderRight">PROVEEDOR</th>
            <th class="borderTop borderRight">SOLICITUD DE SERV.</th>
            <th class="borderTop borderRight">DESCRIPCION</th>
            <th class="borderTop borderRight">TIPO SERVICIO</th>
          </tr>
         
           {foreach name=detalles from=$DETALLES item=i}
            <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                <td class="borderLeft borderTop borderRight">{$i.consecutivo}</td>           
                <td class="borderTop borderRight">{$i.oficina} </td> 
                <td class="borderTop borderRight">{$i.estado} </td> 
                <td class="borderTop borderRight">{$i.fecha_orden_compra}</td> 
                <td class="borderTop borderRight">{$i.proveedor_nombre}</td>  
                <td class="borderTop borderRight">{$i.solicitud}</td>  
                <td class="borderTop borderRight">{$i.descrip_orden_compra}</td>  
                <td class="borderTop borderRight">{$i.tiposervicio}</td>
             </tr> 
           
             {/foreach}	
          
       {elseif $tipo eq 'SP'}    
          
          
           <tr>
          	<th class="borderLeft borderTop borderRight">ORDEN NO.</th>
            <th class="borderTop borderRight">SUCURSAL</th>
             <th class="borderTop borderRight">ESTADO</th>
            <th class="borderTop borderRight">FECHA</th>
            <th class="borderTop borderRight">PROVEEDOR</th>
            <th class="borderTop borderRight">SOLICITUD DE SERV.</th>
            <th class="borderTop borderRight">DESCRIPCION</th>
            <th class="borderTop borderRight">TIPO SERVICIO</th>
          </tr>
         
           {foreach name=detalles from=$DETALLES item=i}
            <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                <td class="borderLeft borderTop borderRight">{$i.consecutivo}</td>           
                <td class="borderTop borderRight">{$i.oficina} </td> 
                <td class="borderTop borderRight">{$i.estado} </td> 
                <td class="borderTop borderRight">{$i.fecha_orden_compra}</td> 
                <td class="borderTop borderRight">{$i.proveedor_nombre}</td>  
                <td class="borderTop borderRight">{$i.solicitud}</td>  
                <td class="borderTop borderRight">{$i.descrip_orden_compra}</td>  
                <td class="borderTop borderRight">{$i.tiposervicio}</td>
             </tr> 
           
             {/foreach}	   

      {elseif $tipo eq 'RF'}
          {assign var="prov" value=""}
          {assign var="acumula_total" value="0"}
          {assign var="acumula_pagos" value="0"}
          {assign var="acumula_saldos" value="0"}
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $prov eq '' or $prov neq $i.proveedor_nombre}
              
              {if $prov neq '' and $prov neq $i.proveedor_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="8" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:0:',':'.'}</td>
                    <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_pagos|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:0:',':'.'}</td>								
                  </tr>  
                  {assign var="acumula_total" value="0"}
                  {assign var="acumula_pagos" value="0"}
                  {assign var="acumula_saldos" value="0"}
                  <tr>
                    <th colspan="7" align="left">&nbsp;</th>
                  </tr>	
                  <tr>
                    <th colspan="7" align="left">&nbsp;</th>
                  </tr>	
                  
                  
			  {/if}	
              {assign var="prov" value=$i.proveedor_nombre}

          <tr>
          	<th colspan="7" align="left">{$i.proveedor_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="7" align="left">&nbsp;</th>
          </tr>	

          <tr>
          	<th class="borderLeft borderTop borderRight">CAUSACION NO.</th>
            <th class="borderTop borderRight">DOC. REFERENCIA</th>
            <th class="borderTop borderRight">ESTADO</th>
             <th class="borderTop borderRight">CENTRO</th>		
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">FECHA</th>
            <th class="borderTop borderRight">VENCE</th>
            <th class="borderTop borderRight">RELACION PAGOS</th>
            <th class="borderTop borderRight">VALOR FACTURA</th>
            <th class="borderTop borderRight">VALOR PAGOS</th>
            <th class="borderTop borderRight">SALDO</th>
          </tr>
          {/if}
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
          	<td class="borderLeft borderTop borderRight">{$i.consecutivo_id}</td>           
            <td class="borderTop borderRight">{if $i.codfactura_proveedor neq ''}Fact. {$i.codfactura_proveedor}{/if} {if $i.manifiesto neq ''}Planilla: {$i.manifiesto}{/if} {if $i.orden_no neq ''}Orden Ser No: {$i.orden_no}{/if} </td> 
            <td class="borderTop borderRight">{$i.estado}</td> 
            <td class="borderTop borderRight">{$i.centro}</td>  
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.fecha_factura_proveedor}</td>  
            <td class="borderTop borderRight">{$i.vence_factura_proveedor}</td>
            <td class="borderTop borderRight">{$i.relacion_pago} {$i.relacion_anticipos}</td>  
            <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.valor_neto|number_format:0:',':'.'}{/if}</td>
            <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.abonos|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.saldo|number_format:0:',':'.'}{/if}</td>  
          </tr> 
          {if $i.estado neq 'ANULADA'}
              {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
              {math assign="acumula_pagos" equation="x + y" x=$acumula_pagos y=$i.abonos}
              {math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}
          {/if}
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="8" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:0:',':'.'}</td>
            <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_pagos|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:0:',':'.'}</td>								
          </tr>  

      {elseif $tipo eq 'RC'}
          {assign var="prov" value=""}
          {assign var="acumula_total" value="0"}
          {assign var="acumula_saldos" value="0"}
      

          <tr>
          	<th class="borderLeft borderTop borderRight">CAUSACION NO.</th>
            <th class="borderTop borderRight">DOC. REFERENCIA</th>
            <th class="borderTop borderRight">PROVEEDOR</th>
            <th class="borderTop borderRight">CENTRO</th>		
            <th class="borderTop borderRight">OFICINA</th>
            <th class="borderTop borderRight">ESTADO</th>
            <th class="borderTop borderRight">FECHA</th>            
            <th class="borderTop borderRight">VENCE</th>
            <th class="borderTop borderRight">VALOR</th>
            <th class="borderTop borderRight">SALDO</th>
          </tr>
          {foreach name=detalles from=$DETALLES item=i}

          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
          	<td class="borderLeft borderTop borderRight">{$i.consecutivo_id}</td>                     
            <td class="borderTop borderRight">{if $i.manifiesto neq ''}Planilla: {$i.manifiesto}{elseif $i.codfactura_proveedor neq ''}Fact. {$i.codfactura_proveedor}{/if}  {if $i.orden_no neq ''}Orden Ser No: {$i.orden_no}{/if} {$i.tipo} </td> 
            <td class="borderTop borderRight">{$i.proveedor_nombre}</td> 
            <td class="borderTop borderRight">{$i.centro}</td>  
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.estado}</td>  
            <td class="borderTop borderRight">{$i.fecha_factura_proveedor}</td>  
            <td class="borderTop borderRight">{$i.vence_factura_proveedor}</td>
            <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.valor_neto|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight" align="right">{if $i.estado eq 'ANULADA'}0{else}{$i.saldo|number_format:0:',':'.'}{/if}</td>  
          </tr> 
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
          {math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="8" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_total|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_saldos|number_format:0:',':'.'}</td>								
          </tr>  

      
      {elseif  $tipo eq 'EC'}

              
              {assign var="acumula_total_pagado" value="0"}
              {assign var="acumula_total" value="0"}
              {assign var="i" value="0"}
              {foreach name=factura from=$DETALLES[0].factura item=fv}
             
             {if $proveedor eq 'NULL'}
                 <tr>
                   <td align="left" colspan="3"><b>PROVEEDOR:</b> {$fv.proveedor}</td>
                   <td colspan="3"><b>NIT:</b> {$fv.numero_identificacion}</td>
                 </tr>
             {/if}	 	  
                      <thead class="thead-dark">
                      <tr>
                        <th scope="col">NUM DOC</th>   
                        <th scope="col">TIPO DOC</th>
                        <th scope="col">DETALLE</th>
                        <th scope="col">FECHA DOC</th>
                        <th scope="col">FECHA VENC</th> 
                        <th scope="col">DIAS</th>		
                        <th scope="col">ESTADO</th>
                        <th scope="col">VALOR</th>
                        <th scope="col">DESCUENTO</th>
                        <th scope="col">ABONO</th>
                        <th scope="col">ABONO MAYOR VR</th>
                        <th scope="col">SALDO</th>
                      </tr>
                      </thead>
                    
                        {assign var="abono" value="0"}
                        {assign var="saldo" value=$fv.valor}
                         <tr>
                            <td><a href="javascript:void(0)" onClick="viewDocumentFactura('{$fv.factura_proveedor_id}');" >{$fv.codfactura_proveedor}</a></td> 
                            <td>{$fv.tipo_documento}</td> 
                            <td>{$fv.concepto}</td>  
                            <td>{$fv.fecha_factura_proveedor}</td>  
                            <td>{$fv.vence_factura_proveedor}</td>  
                            <td>{$fv.dias}</td> 
                            <td>{$fv.estado}</td>  
                            <td>{$fv.valor|number_format:2:',':'.'}</td>  
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>{$saldo|number_format:2:',':'.'}</td>
                         </tr>
 
              {if $fv.abono_factura > 0 && $fv.descuento > 0 || $fv.abono_factura > 0 && $fv.descuento_mayor > 0 || $fv.abono_factura > 0}

              {foreach name=descuento from=$DETALLES[$i].descuento item=d}
                             
                       {if $fv.descuento > 0}
                        
                          {if $d.estado eq 'ANULADA'}
                            {assign var="abono" value="0"}
                            {math assign="saldo" equation="x - y" x=$saldo y=$abono}
                          {else}
                            {math assign="abono" equation="x - y" x=$d.valor_abono y=$d.abonos_desc}
                            {math assign="saldo" equation="x - y" x=$saldo y=$d.valor_abono}
                          {/if} 

                       {elseif $fv.descuento_mayor > 0}

                          {if $d.estado eq 'ANULADA'}
                            {assign var="abono" value="0"}
                            {math assign="saldo" equation="x - y" x=$saldo y=$abono}
                          {else}
                            {math assign="abono" equation="x + y" x=$d.valor_abono y=$d.mayor_pago}
                            {math assign="saldo" equation="x - y" x=$saldo y=$abono} 
                          {/if}

                       {else} 

                        {if $d.estado eq 'ANULADA'}
                            {assign var="abono" value="0"}
                            {math assign="saldo" equation="x - y" x=$saldo y=$abono}
                          {else}
                            {assign var="abono" value=$d.valor_abono} 
                            {math assign="saldo" equation="x - y" x=$saldo y=$abono}
                          {/if}

                        

                       {/if}
 
                         <tr>

                         {if $d.consecutivo > 0}
                            <td><a href="javascript:void(0)" onClick="viewDocument('{$d.encabezado_registro_id}');" >{$d.consecutivo}</a></td> 
                         {else}
                            <td><b>Pendiente Por Consecutivo</b></td>
                         {/if}  

                            <td>{$d.tipo_documento}</td> 
                            <td>{$d.concepto}</td>  
                            <td>{$d.fecha}</td>  
                            <td>{$d.vencimiento}</td>  
                            <td>{$d.dias}</td> 
                            <td>{$d.estado}</td>  
                            <td>--</td>

                            {if $fv.descuento > 0}  
                             <td>{$d.abonos_desc|number_format:2:',':'.'}</td>
                            {else}
                             <td>--</td>
                            {/if} 

                            {if $fv.descuento > 0}
                            <td>{$abono|number_format:2:',':'.'}</td>
                            {else}
                             <td>{$d.valor_abono|number_format:2:',':'.'}</td>
                            {/if}

                            {if $fv.descuento_mayor > 0}  
                            <td>{$d.mayor_pago|number_format:2:',':'.'}</td>
                            {else}
                             <td>--</td>
                            {/if} 
                             
                            <td>{$saldo|number_format:2:',':'.'}</td>  
                        </tr>

                          {math assign="acumula_total_pagado" equation="x + y" x=$acumula_total_pagado y=$abono}

              {/foreach}
              {/if}
                            <tr>
                             <td colspan="11" align="right"><b>SALDO PENDIENTE</b></td>
                             {if $fv.estado eq 'ANULADA'}
                               {assign var="saldo" value=0}
                               <td align="center">&nbsp;{$saldo|number_format:2:',':'.'}</td>
                             {else}
                               <td align="center">&nbsp;{$saldo|number_format:2:',':'.'}</td>
                             {/if}								
                           </tr> 
                           <tr><td>&nbsp;</td></tr>

                          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$saldo}
                          
                        
                          
                          {math assign="i" equation="x + y" x=$i y=1}
           {/foreach}
           
                            <tr><td align="center">&nbsp;</td></tr>
                            <tr>	
                              <td colspan="5" align="right"><b style="color: #ff0f0f">SALDO GENERAL PENDIENTE</b></td>
                              <td colspan="7" align="left"><b style="color: #20bf20">SALDO GENERAL PAGADO</b></td>
                            </tr>
                            <tr>
                              <td colspan="5" align="right"><b style="color: #ff0f0f">{$acumula_total|number_format:2:',':'.'}</b></td>
                              <td colspan="7" align="left"><b style="color: #20bf20">{$acumula_total_pagado|number_format:2:',':'.'}</b></td>								
                           </tr> 
                
            
        {elseif  $tipo eq 'PE'}

          {assign var="prov" value=""}
          {assign var="acumula_total" value="0"}

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
          
          {foreach name=detalles from=$DETALLES item=i}
      
		  {if $prov eq '' or $prov neq $i.proveedor_nombre}
              
              {if $prov neq '' and $prov neq $i.proveedor_nombre}
              
                  <tr class="subtitulo">
                   <td class="borderLeft borderTop borderRight borderBottom" colspan="4" align="right">TOTAL</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_0|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_30|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_60|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_180|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360mas|number_format:0:',':'.'}</td>
                   <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
                  </tr>  
                  {assign var="acumula_0" value="0"}
                  {assign var="acumula_30" value="0"}
                  {assign var="acumula_60" value="0"}
                  {assign var="acumula_90" value="0"}
                  {assign var="acumula_180" value="0"}
                  {assign var="acumula_360" value="0"}
                  {assign var="acumula_360mas" value="0"}
                  <tr>
                    <th colspan="12" align="left">&nbsp;</th>
                  </tr>	
                  <tr>
                    <th colspan="12" align="left">&nbsp;</th>
                  </tr>	
                  
                  
			  {/if}	
              {assign var="prov" value=$i.proveedor_nombre}

          <tr>
          	<th colspan="12" align="left">{$i.proveedor_nombre}<br /></th>
          
          </tr>	
          <tr>
          	<th colspan="12" align="left">&nbsp;</th>
          </tr>	

          <tr>
            <th class="borderLeft borderTop borderRight" rowspan="2">DOC. REFERENCIA</th>
            <th class="borderTop borderRight" rowspan="2">OFICINA</th>
            <th class="borderTop borderRight" rowspan="2">FECHA FACT</th>
            <th class="borderTop borderRight" rowspan="2">VENCE</th>
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
            <td class="borderLeft borderTop borderRight">{if $i.codfactura_proveedor neq ''}Fact. {$i.codfactura_proveedor}{/if} {if $i.manifiesto neq ''}Planilla: {$i.manifiesto}{/if} {if $i.orden_no neq ''}Orden Ser No: {$i.orden_no}{/if}</td> 
            <td class="borderTop borderRight">{$i.oficina}</td>  
            <td class="borderTop borderRight">{$i.fecha_factura_proveedor}</td>  
            <td class="borderTop borderRight">{$i.vence_factura_proveedor}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias lt 0 or  $i.dias eq 0}{$i.saldo|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias lt 0 or  $i.dias eq 0}{$i.dias}{/if}</td>  
            
            <td class="borderTop borderRight" align="right">{if $i.dias gt 0 and $i.dias lt 31 }{$i.saldo|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 0 and $i.dias lt 31 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 30 and $i.dias lt 61 }{$i.saldo|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 30 and $i.dias lt 61 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 60 and $i.dias lt 91 }{$i.saldo|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 60 and $i.dias lt 91 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 90 and $i.dias lt 181 }{$i.saldo|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 90 and $i.dias lt 181 }{$i.dias}{/if}</td>  
            
            <td class="borderTop borderRight" align="right">{if $i.dias gt 180 and $i.dias lt 361 }{$i.saldo|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 180 and $i.dias lt 361 }{$i.dias}{/if}</td>  

            <td class="borderTop borderRight" align="right">{if $i.dias gt 360}{$i.saldo|number_format:0:',':'.'}{/if}</td>  
            <td class="borderTop borderRight">{if $i.dias gt 360}{$i.dias}{/if}</td>  

          </tr> 
          {if  $i.dias lt 0 or  $i.dias eq 0 }
	          {math assign="acumula_0" equation="x + y" x=$acumula_0 y=$i.saldo}
          {/if}
          
          {if $i.dias gt 0 and $i.dias lt 31 }
	          {math assign="acumula_30" equation="x + y" x=$acumula_30 y=$i.saldo}
          {/if}
          {if $i.dias gt 30 and $i.dias lt 61 }   
          	{math assign="acumula_60" equation="x + y" x=$acumula_60 y=$i.saldo}
          {/if}  
          {if $i.dias gt 60 and $i.dias lt 91 }
	          {math assign="acumula_90" equation="x + y" x=$acumula_90 y=$i.saldo}          
          {/if}
          {if $i.dias gt 90 and $i.dias lt 181 }
	          {math assign="acumula_180" equation="x + y" x=$acumula_180 y=$i.saldo}          
          {/if}
          {if $i.dias gt 180 and $i.dias lt 361 }
	          {math assign="acumula_360" equation="x + y" x=$acumula_360 y=$i.saldo}          
          {/if}
          
          {if $i.dias gt 360}    
	          {math assign="acumula_360mas" equation="x + y" x=$acumula_360mas y=$i.saldo}          
          {/if}    

          {if  $i.dias lt 0 or  $i.dias eq 0 }
	          {math assign="acumulat_0" equation="x + y" x=$acumulat_0 y=$i.saldo}
          {/if}
          
          {if $i.dias gt 0 and $i.dias lt 31 }
	          {math assign="acumulat_30" equation="x + y" x=$acumulat_30 y=$i.saldo}
          {/if}
          {if $i.dias gt 30 and $i.dias lt 61 }   
          	{math assign="acumulat_60" equation="x + y" x=$acumulat_60 y=$i.saldo}
          {/if}  
          {if $i.dias gt 60 and $i.dias lt 91 }
	          {math assign="acumulat_90" equation="x + y" x=$acumulat_90 y=$i.saldo}          
          {/if}
          {if $i.dias gt 90 and $i.dias lt 181 }
	          {math assign="acumulat_180" equation="x + y" x=$acumulat_180 y=$i.saldo}          
          {/if}
          {if $i.dias gt 180 and $i.dias lt 361 }
	          {math assign="acumulat_360" equation="x + y" x=$acumulat_360 y=$i.saldo}          
          {/if}
          
          {if $i.dias gt 360}    
	          {math assign="acumulat_360mas" equation="x + y" x=$acumulat_360mas y=$i.saldo}          
          {/if}    
          
          {math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.saldo}
          
		  {/foreach}	

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTAL</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_0|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_30|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_60|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_90|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_180|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumula_360mas|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
          </tr>  
          <tr >
           <td  colspan="13" align="right">&nbsp;</td>
          </tr>  

          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTAL PENDIENTE</td>
           <td class="borderTop borderRight borderBottom" align="right" colspan="10">&nbsp;{$acumula_total|number_format:0:',':'.'}</td>
          </tr>  

          <tr >
           <td  colspan="13" align="right">&nbsp;</td>
          </tr>  
          <tr class="subtitulo">
           <td class="borderLeft borderTop borderRight borderBottom" colspan="3" align="right">TOTALES POR EDADES</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_0|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_30|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_60|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_90|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_180|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_360|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;{$acumulat_360mas|number_format:0:',':'.'}</td>
           <td class="borderTop borderRight borderBottom" align="right">&nbsp;</td>								
          </tr>  

      
      {/if}   
       
  </table>
  </body>
</html>