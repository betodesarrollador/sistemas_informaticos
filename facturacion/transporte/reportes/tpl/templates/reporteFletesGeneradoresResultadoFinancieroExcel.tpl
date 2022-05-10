<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
	</head>
	<body> 
		<input type="hidden" id="estado_id" value="{$estado_id}" />
		<table width="80%" align="center" id="encabezado" border="0">
			<tr><td align="center" colspan="13" class="header">{$EMPRESA} </td></tr>
			<tr><td colspan="13" align="center" class="header">Nit. {$NIT}</td></tr>
			<tr><td colspan="13">&nbsp;</td></tr>
			<tr><td align="center" colspan="13" class="header">REPORTE FLETES GENERADORES</td></tr>
			<tr><td align="center" colspan="13" class="header">DESDE - {$DESDE} : HASTA - {$HASTA}</td></tr>
			<tr><td align="center" colspan="13" class="header">(Valores Expresados en pesos Colombianos)</td></tr>
			<tr>
				<td align="center" class="header" width="40%" colspan="13">
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
					<th style="border: 1px solid" colspan="8">DATOS DEL SERVICIO</th>
					<th style="border: 1px solid" colspan="5">INGRESOS SERVICIOS</th>
				</tr>
				<tr>
					<th style="border: 1px solid">Nº REMESA</th>
					<th style="border: 1px solid">FECHA</th>
					<th style="border: 1px solid">CIUDAD ORIGEN</th>
					<th style="border: 1px solid">CIUDAD DESTINO</th>
					<th style="border: 1px solid">PLACA VEHICULO</th>
					<th style="border: 1px solid">CONFIG VEHICULO</th>
					<th style="border: 1px solid">TIPO REMESA</th>
					<th style="border: 1px solid">N° AUTORIZACION RNDC</th>

					<th style="border: 1px solid">CLIENTE</th>
					<th style="border: 1px solid">TIPO TARIFA DE SERVICIO</th>
					<th style="border: 1px solid">Nº FACTURA</th>
					<th style="border: 1px solid">FECHA FACTURA</th>
					<th style="border: 1px solid">V/R FACTURA</th>
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
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].configuracion}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].tipo_remesa}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].aprobacion}</td>

						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].cliente}</td>
						<td style="border: 1px solid">
							{if $DETALLESTRAZABILIDAD[$k].tipo_liquidacion eq 'C'}CUPO{/if}
							{if $DETALLESTRAZABILIDAD[$k].tipo_liquidacion eq 'P'}PESO{/if}
							{if $DETALLESTRAZABILIDAD[$k].tipo_liquidacion eq 'V'}VOLUMEN{/if}
						</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].numfactura}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].fecfactura}</td>
						<td style="border: 1px solid">{$DETALLESTRAZABILIDAD[$k].valfactura}</td>
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
					<td style="border: 1px solid" colspan="12"align="center">TOTAL</td>
					<td style="border: 1px solid">{assign var=tot_util value=$total_facturas-$tot_costo}{$tot_util}</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>