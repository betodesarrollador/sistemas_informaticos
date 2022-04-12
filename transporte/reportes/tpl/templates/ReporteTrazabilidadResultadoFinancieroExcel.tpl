<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
	</head>
	<body> 
		<input type="hidden" id="estado_id" value="{$estado_id}" />
		<table width="80%" align="center" id="encabezado" border="0">
			<tr><td align="center" colspan="24" class="header">{$EMPRESA} </td></tr>
			<tr><td colspan="24" align="center" class="header">Nit. {$NIT}</td></tr>
			<tr><td colspan="24">&nbsp;</td></tr>
			<tr><td align="center" colspan="24" class="header">DIARIO COLUMNARIO</td></tr>
			<tr><td align="center" colspan="24" class="header">DESDE - {$DESDE} : HASTA - {$HASTA}</td></tr>
			<tr><td align="center" colspan="24" class="header">(Valores Expresados en pesos Colombianos)</td></tr>
			<tr>
				<td align="center" class="header" width="40%" colspan="24">
					{if $estado_id eq 'MC'} 
							TRAZABILIDAD MANIFIESTOS
						{elseif $estado_id eq 'DU'}
							TRAZABILIDAD DESPACHOS URBANOS 
						{elseif $estado_id eq 'MC,DU'}
							TRAZABILIDAD MANIFIESTOS - DESPACHOS URBANOS
					{/if}
				</td>
			</tr>
		</table>
		<table>
			<thead>
				<tr>
					<th style="border: 1px solid" colspan="7">DATOS DEL SERVICIO</th>
					<th style="border: 1px solid" colspan="7">INGRESOS SERVICIOS</th>
					<th style="border: 1px solid" colspan="7">COSTOS SERVICIOS</th>
					<th style="border: 1px solid">TOTAL COSTO</th>
					<th style="border: 1px solid" colspan="2">RENTABILIDAD FLETE</th>
				</tr>
				<tr>
					<th style="border: 1px solid">Nº REMESA</th>
					<th style="border: 1px solid">FECHA</th>
					<th style="border: 1px solid">CIUDAD ORIGEN</th>
					<th style="border: 1px solid">CIUDAD DESTINO</th>
					<th style="border: 1px solid">PLACA VEHICULO</th>
					<th style="border: 1px solid">ESTADO</th>
					<th style="border: 1px solid">OFICINA</th>

					<th style="border: 1px solid">CLIENTE</th>
					<th style="border: 1px solid">Nº FACTURA</th>
					<th style="border: 1px solid">FECHA FACTURA</th>
					<th style="border: 1px solid">V/R FACTURA</th>
					<th style="border: 1px solid">Nº RECIBO</th>
					<th style="border: 1px solid">FECHA PAGO</th>
					<th style="border: 1px solid">V/R PAGADO</th>

					<th style="border: 1px solid">Nº DE PLANILLA</th>
					<th style="border: 1px solid">TIPO</th>
					<th style="border: 1px solid">FECHA</th>
					<th style="border: 1px solid">V/R LIQUIDADO</th>
					<th style="border: 1px solid">Nº O. COMPRA</th>
					<th style="border: 1px solid">FECHA</th>
					<th style="border: 1px solid">V/R</th>

					<th style="border: 1px solid">V/R</th>

					<th style="border: 1px solid">V/R UTILIDAD</th>
					<th style="border: 1px solid">% RENTABILIDAD</th>
				</tr>

			</thead>
			<tbody>
				{assign var=k value=0}
				{assign var="total_facturas" value=0}
				{assign var="total_planillas" value=0}
				{assign var="total_oc" value=0}
				{section name=rows loop=$DETALLESTRAZABILIDAD|count}
					<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].numero_remesa}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].fecha_remesa}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].origen}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].destino}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].placa}</td>
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'PD'}PENDIENTE{/if}
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'PC'}PROCENSANDO{/if}
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'MF'}MANIFESTADO{/if}
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}ANULADO{/if}
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'LQ'}LIQUIDADO{/if}
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'FT'}FACTURADO{/if}
						</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].oficina}</td>

						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].cliente}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].numfactura}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].fecfactura}</td>
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}
								{$DETALLESTRAZABILIDAD[$k].valfactura}
							{else}
								{$DETALLESTRAZABILIDAD[$k].valfactura}
							{/if}
						</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].relacion_pago}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].fecha_relacion_pago}</td>
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}0
							{else}{$DETALLESTRAZABILIDAD[$k].valor_relacion_pago}
							{/if}
						</td>
						
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].numero_planilla}</td>
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].es eq 'MC'}MANIFIESTO DE CARGA{/if}
							{if $DETALLESTRAZABILIDAD[$k].es eq 'DU'}DESPACHO URBANO{/if}
						</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].fecha}</td>
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}0
							{else}
								{assign var=valor_costo value=$DETALLESTRAZABILIDAD[$k].valor_costo+$DETALLESTRAZABILIDAD[$k].valor_sflete}
								{$valor_costo}
							{/if}
						</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].ordenes_compras}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].fecha_ordenes_compras}</td>
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}0
							{else}{$DETALLESTRAZABILIDAD[$k].valor_orden_compra}
							{/if}
						</td>

						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}0
							{else}{assign var=tot_costo value=$valor_costo+$DETALLESTRAZABILIDAD[$k].valor_orden_compra}
							{$tot_costo}
							{/if}
						</td>

						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}0
							{else}{assign var=tot_util value=$DETALLESTRAZABILIDAD[$k].valfactura-$tot_costo}
							{$tot_util}
							{/if}
						</td>
						{assign var=util value=$tot_util/$DETALLESTRAZABILIDAD[$k].valfactura}
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].estado eq 'AN'}0
							{else}{assign var=per_util value=$util*100}
							{$per_util}%
							{/if}
						</td>
					</tr>
					{assign var="total_facturas" value=$total_facturas+$DETALLESTRAZABILIDAD[$k].valfactura}
					{assign var="total_planillas" value=$total_planillas+$valor_costo}
					{assign var="total_oc" value=$total_oc+$DETALLESTRAZABILIDAD[$k].valor_orden_compra}
					{assign var=k value=$k+1}
				{/section}
				<tr>
					<td></td>
				</tr>
				<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
					<td style="border: 1px solid" colspan="7" align="center">TOTALES</td>

					<td style="border: 1px solid"></td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid">{$total_facturas}</td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid"></td>
					
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid">{$total_planillas}</td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid"></td>
					<td style="border: 1px solid">{$total_oc}</td>

					<td style="border: 1px solid">{assign var=tot_costo value=$total_planillas+$total_oc}{$tot_costo}</td>

					<td style="border: 1px solid">{assign var=tot_util value=$total_facturas-$tot_costo}{$tot_util}</td>
					
					{assign var=util value=$tot_util/$total_facturas}
					<td style="border: 1px solid">{assign var=per_util value=$util*100}{$per_util}%</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>