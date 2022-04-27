<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	{$JAVASCRIPT}
	{$CSSSYSTEM}
</head>

<body style="padding: 8px;">

	<input type="hidden" id="tipo" value="{$tipo}" />

	<table width="90%" align="center" id="encabezado">
		<tr>
			<td width="30%" style="border:none;">&nbsp;</td>
			<td align="center" class="titulo" width="40%" style="border:none;">{if $tipo eq 'FP'}Facturas Pendientes{elseif $tipo eq
				'RE'}Reporte
				Recaudos{elseif $tipo eq 'EC'}Estado De Cuenta{elseif $tipo eq 'RF'}Relaci&oacute;n de Facturas{elseif
				$tipo eq
				'PE'}Cartera por Edades{elseif $tipo eq 'RP'}Remesas Pendientes de Facturar{elseif $tipo eq 'VE'}Reporte de ventas{/if}</td>
			<td width="30%" align="right" style="border:none;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" style="border:none;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" colspan="3" style="border:none;">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta}</td>
		</tr>
		{if $cliente neq 'NULL'}
		<tr>
			<td colspan="3" style="border:none;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" colspan="3" style="border:none;"><b>CLIENTE:</b> {$cliente}</td>
		</tr>
		{/if}
	</table>

	<table align="center" width="100%" class="table table-bordered table-striped">
		{if $tipo eq 'FP'}
		{assign var="clien" value=""}
		{assign var="acumula_total" value="0"}
		{assign var="acumula_saldos" value="0"}
		{assign var="acumula_total_final" value="0"}
		{assign var="acumula_saldos_final" value="0"}
		{foreach name=detalles from=$DETALLES item=i}

		{if $clien eq '' or $clien neq $i.cliente_nombre}

			{if $clien neq '' and $clien neq $i.cliente_nombre}

			<tr>
				<td colspan="5" align="right">TOTAL</td>
				<td align="right" style="color: #4eb724">&nbsp;<b>{$acumula_total|number_format:0:',':'.'}
				</b></td>
				<td align="right" style="color: #ff1f1f">&nbsp;<b>{$acumula_saldos|number_format:0:',':'.'}
				</b></td>
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

		    {assign var="clien" value=$i.cliente_nombre}

		<tr>
			<th colspan="7" align="left">{$i.cliente_nombre}<br /></th>
		</tr>

		<tr>
			<th colspan="7" align="left">&nbsp;</th>
		</tr>

		<tr class="table-primary">
			<th>No FACT</th>
			<th>OFICINA</th>
			<th>FECHA FACT</th>
			<th>VENCE</th>
			<th>DIAS</th>
			<th>VALOR</th>
			<th>SALDO</th>
		</tr>
		{/if}

		<tr>
			<td>{$i.consecutivo_factura} </td>
			<td>{$i.oficina}</td>
			<td>{$i.fecha}</td>
			<td>{$i.vencimiento}</td>
			<td>{$i.dias}</td>
			<td align="right">{$i.valor_neto|number_format:0:',':'.'}</td>
			<td align="right">{$i.saldo|number_format:0:',':'.'}</td>
		</tr>

		{math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
		{math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}
		{math assign="acumula_total_final" equation="x + y" x=$acumula_total_final y=$i.valor_neto}
		{math assign="acumula_saldos_final" equation="x + y" x=$acumula_saldos_final y=$i.saldo}
		
		{/foreach}

		<tr>
			<td  colspan="5" align="right"><b>TOTAL<b></td>
			<td  align="right" style="color: #4eb724">&nbsp;<b>{$acumula_total|number_format:0:',':'.'}</b></td>
			<td  align="right" style="color: #ff1f1f">&nbsp;<b>{$acumula_saldos|number_format:0:',':'.'}</b></td>
		</tr>

		<tr>
			<th colspan="7" align="left">&nbsp;</th>
		</tr>

		<tr>
			<td  colspan="5" align="right"><b>TOTAL</b></td>
			<td  align="right" style="color: #4eb724">&nbsp;<b>{$acumula_total_final|number_format:0:',':'.'}</b></td>
			<td  align="right" style="color: #ff1f1f">&nbsp;<b>{$acumula_saldos_final|number_format:0:',':'.'}</b></td>
		</tr>

		{elseif $tipo eq 'RF'}
		{assign var="clien" value=""}
		{assign var="acumula_total" value="0"}
		{assign var="acumula_saldos" value="0"}
		{assign var="acumula_total_final" value="0"}
		{assign var="acumula_saldos_final" value="0"}

		{foreach name=detalles from=$DETALLES item=i}

		{if $clien eq '' or $clien neq $i.cliente_nombre}

		{if $clien neq '' and $clien neq $i.cliente_nombre}

		<tr>
			<td colspan="7" align="right">TOTAL 1</td>
			<td align="right" style="color: #4eb724">&nbsp;<b>{$acumula_total|number_format:0:',':'.'}</b>
			</td>
			<td align="right" style="color: #ff1f1f">&nbsp;<b>{$acumula_saldos|number_format:0:',':'.'}</b>
			</td>
		</tr>
		{assign var="acumula_total" value="0"}
		{assign var="acumula_saldos" value="0"}
		<tr>
			<th colspan="9" align="left">&nbsp;</th>
		</tr>
		
		<tr>
			<th colspan="9" align="left">&nbsp;</th>
		</tr>


		{/if}
		{assign var="clien" value=$i.cliente_nombre}

		<tr>
			<th colspan="9" align="left">{$i.cliente_nombre}<br /></th>

		</tr>
		<tr>
			<th colspan="9" align="left">&nbsp;</th>
		</tr>

		<tr class="table-primary">
			<th>No FACT</th>
			<th>ESTADO</th>
			<th>CENTRO</th>
			<th>OFICINA</th>
			<th>FECHA FACT</th>
			<th>VENCE</th>
			<th>RELACION PAGOS</th>
			<th>VALOR</th>
			<th>SALDO</th>
		</tr>
		{/if}
		<tr>
			<td>{$i.consecutivo_factura} </td>
			<td>{$i.estado}</td>
			<td>{$i.centro}</td>
			<td>{$i.oficina}</td>
			<td>{$i.fecha}</td>
			<td>{$i.vencimiento}</td>
			<td>{$i.relacion_pago}</td>
			<td align="right">{if $i.estado eq
				'ANULADA'}0{else}{$i.valor_neto|number_format:0:',':'.'}{/if}</td>
			<td align="right">{if $i.estado eq
				'ANULADA'}0{else}{$i.saldo|number_format:0:',':'.'}{/if}</td>
		</tr>
		{math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
		{math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}
		{math assign="acumula_total_final" equation="x + y" x=$acumula_total_final y=$i.valor_neto}
		{math assign="acumula_saldos_final" equation="x + y" x=$acumula_saldos_final y=$i.saldo}
		{/foreach}

		<tr>
			<td colspan="7" align="right">TOTAL 2</td>
			<td align="right" style="color: #4eb724">&nbsp;<b>{$acumula_total|number_format:0:',':'.'}</b>
			</td>
			<td align="right" style="color: #ff1f1f">&nbsp;<b>{$acumula_saldos|number_format:0:',':'.'}</b>
			</td>
		</tr>
		<tr>
			<th colspan="9" align="left">&nbsp;</th>
		</tr>
		<tr>
			<td colspan="7" align="right"><b>TOTAL 3</b></td>
			<td align="right" style="color: #4eb724">&nbsp;<b>{$acumula_total_final|number_format:0:',':'.'}</b>
			</td>
			<td align="right" style="color: #ff1f1f">&nbsp;<b>{$acumula_saldos_final|number_format:0:',':'.'}</b>
			</td>
		</tr>
		{elseif $tipo eq 'RE'}
		{assign var="clien" value=""}
		{assign var="acumula_total" value="0"}
		{assign var="acumula_saldos" value="0"}

		{assign var="acumula_pagos" value="0"}

		{assign var="acumula_totales" value="0"}
		{assign var="acumula_saldos_total" value="0"}
		{assign var="acumula_pagos_total" value="0"}

		{foreach name=detalles from=$DETALLES item=i}
		{if $clien eq '' or $clien neq $i.cliente_nombre}
		{if $clien neq '' and $clien neq $i.cliente_nombre}
		<tr>
			<td colspan="3" align="center"><b>TOTAL</b></td>
			<td align="right" style="color: #4eb724"><b>{$acumula_total|number_format:0:',':'.'}</b></td>
			<td colspan="2" align="center"><b>TOTAL PAGOS</b></td>
			{math assign="acumula_pagos" equation="x - y" x=$acumula_total y=$acumula_saldos}
			<td align="right" style="color: #4eb724"><b>{$acumula_pagos|number_format:0:',':'.'}</b></td>
			<td align="right" style="color: #ff1f1f"><b>{$acumula_saldos|number_format:0:',':'.'}</b></td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"></td>
		</tr>
		{assign var="acumula_total" value="0"}
		{assign var="acumula_saldos" value="0"}
		{assign var="acumula_pagos" value="0"}
		<tr>
			<th colspan="11" align="left">&nbsp;</th>
		</tr>
		<tr>
			<th colspan="11" align="left">&nbsp;</th>
		</tr>
		{/if}
		{assign var="clien" value=$i.cliente_nombre}
		<tr>
			<th colspan="11" align="left">{$i.cliente_nombre}<br /></th>
		</tr>
		<tr>
			<th colspan="11" align="left">&nbsp;</th>
		</tr>
		<tr class="table-primary">
			<th>Nº FACT</th>
			<th>OFICINA</th>
			<th>FECHA FACT</th>
			<th>VALOR</th>
			<th>RELACION PAGOS</th>
			<th>FECHA RELACION PAGOS</th>
			<th>VALOR PAGO</th>
			<th>SALDO</th>
			<th>DIAS DIFERENCIA DE PAGO</th>
			<th>COMERCIAL</th>
			<th>USUARIO</th>
		</tr>
		{/if}
		<tr>
			<td>{$i.consecutivo_factura} </td>
			<td>{$i.oficina}</td>
			<td>{$i.fecha}</td>
			<td align="right">{if $i.estado eq
				'ANULADA'}0{else}{$i.valor_neto|number_format:0:',':'.'}{/if}</td>
			<td align="center">{$i.relacion_pago}</td>
			<td>{$i.fecha_relacion_pago}</td>
			<td>{$i.valor_relacion_pago|number_format:0:',':'.'}</td>
			<td align="right">{if $i.estado eq
				'ANULADA'}0{else}{$i.saldo|number_format:0:',':'.'}{/if}</td>
			<td align="center">{if $i.diferencia_dias eq ''}PAGO AUN NO
				REGISTRADO{else}{$i.diferencia_dias}{/if}</td>
			<td>{$i.comercial}</td>
			<td>{$i.usuario}</td>
		</tr>
		{math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
		{math assign="acumula_saldos" equation="x + y" x=$acumula_saldos y=$i.saldo}

		{if $i.estado neq 'ANULADA'}
		{math assign="acumula_totales" equation="x + y" x=$acumula_totales y=$i.valor_neto}
		{math assign="acumula_saldos_total" equation="x + y" x=$acumula_saldos_total y=$i.saldo}

		{/if}
		{/foreach}
		<tr>
			<td colspan="3" align="center"><b>TOTAL<b></td>
			<td align="right" style="color: #4eb724">{$acumula_total|number_format:0:',':'.'}</td>
			<td colspan="2" align="center"><b>TOTAL PAGOS</b></td>
			{math assign="acumula_pagos" equation="x - y" x=$acumula_total y=$acumula_saldos}

			<td align="right" style="color: #4eb724"><b>{$acumula_pagos|number_format:0:',':'.'}</b></td>
			<td align="right" style="color: #ff1f1f"><b>{$acumula_saldos|number_format:0:',':'.'}</b></td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"></td>

		</tr>
		<tr>
			<td colspan="7" align="right">&nbsp;</td>
		</tr>
		<tr>
		    <td colspan="3" align="center"><b>TOTAL<b></td>
			<td align="center align="right" style="color: #4eb724"><b>{$acumula_totales|number_format:0:',':'.'}</b></td>
			<td colspan="2" align="center"><b>TOTAL PAGOS</b></td>
			{math assign="acumula_pagos_total" equation="x - y" x=$acumula_totales y=$acumula_saldos_total}

			<td align="right" style="color: #4eb724"><b>{$acumula_pagos_total|number_format:0:',':'.'}</b>
			</td>

			<td align="right" style="color: #ff1f1f"><b>{$acumula_saldos_total|number_format:0:',':'.'}</b>
			</td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"></td>

		</tr>

		{elseif $tipo eq 'EC'}


		{assign var="acumula_total_pagado" value="0"}
		{assign var="acumula_total" value="0"}
		{assign var="i" value="0"}
		{foreach name=factura from=$DETALLES[0].factura item=fv}

		{if $cliente eq 'NULL'}
		<tr>
			<td align="left" colspan="3"><b>CLIENTE:</b> {$fv.cliente}</td>
			<td colspan="3"><b>NIT:</b> {$fv.numero_identificacion}</td>
		</tr>
		{/if}
		<thead class="table-primary">
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
			<td><a href="javascript:void(0)"
					onClick="viewDocumentFactura('{$fv.factura_id}');">{$fv.consecutivo_factura}</a>
			</td>
			<td>{$fv.tipo_documento}</td>
			<td>{$fv.concepto}</td>
			<td>{$fv.fecha}</td>
			<td>{$fv.vencimiento}</td>
			<td>{$fv.dias}</td>
			<td>{$fv.estado}</td>
			<td>{$fv.valor|number_format:0:',':'.'}</td>
			<td>--</td>
			<td>--</td>
			<td>--</td>
			<td>{$saldo|number_format:0:',':'.'}</td>
		</tr>

		{if $fv.abono_factura > 0 && $fv.descuento > 0 || $fv.abono_factura > 0 && $fv.descuento_mayor > 0 ||
		$fv.abono_factura > 0}

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
			<td><a href="javascript:void(0)" onClick="viewDocument('{$d.encabezado_registro_id}');">{$d.consecutivo}</a>
			</td>
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
			<td>{$d.abonos_desc|number_format:0:',':'.'}</td>
			{else}
			<td>--</td>
			{/if}

			{if $fv.descuento > 0}
			<td>{$abono|number_format:0:',':'.'}</td>
			{else}
			<td>{$d.valor_abono|number_format:0:',':'.'}</td>
			{/if}

			{if $fv.descuento_mayor > 0}
			<td>{$d.mayor_pago|number_format:0:',':'.'}</td>
			{else}
			<td>--</td>
			{/if}

			<td>{$saldo|number_format:0:',':'.'}</td>
		</tr>

		{math assign="acumula_total_pagado" equation="x + y + z" x=$acumula_total_pagado y=$abono z=$d.abonos_desc}

		{/foreach}
		{/if}
		<tr>
			<td colspan="11" align="right"><b>SALDO PENDIENTE</b></td>
			{if $fv.estado eq 'ANULADA'}
			{assign var="saldo" value=0}
			<td align="center">&nbsp;{$saldo|number_format:0:',':'.'}</td>
			{else}
			<td align="center">&nbsp;{$saldo|number_format:0:',':'.'}</td>
			{/if}
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>

		{math assign="acumula_total" equation="x + y" x=$acumula_total y=$saldo}



		{math assign="i" equation="x + y" x=$i y=1}
		{/foreach}

		<tr>
			<td align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5" align="right"><b style="color: #ff0f0f">SALDO GENERAL PENDIENTE</b></td>
			<td colspan="7" align="left"><b style="color: #20bf20">SALDO GENERAL PAGADO</b></td>
		</tr>
		<tr>
			<td colspan="5" align="right"><b style="color: #ff0f0f">{$acumula_total|number_format:0:',':'.'}</b></td>
			<td colspan="7" align="left"><b style="color: #20bf20">{$acumula_total_pagado|number_format:0:',':'.'}</b>
			</td>
		</tr>


		{elseif $tipo eq 'PE'}

		{assign var="clien" value=""}
		{assign var="acumula_total" value="0"}

		{assign var="acumula_0" value="0"}
		{assign var="acumula_30" value="0"}
		{assign var="acumula_60" value="0"}
		{assign var="acumula_90" value="0"}
		{assign var="acumula_90mas" value="0"}

		{foreach name=detalles from=$DETALLES item=i}

		{if $clien eq '' or $clien neq $i.cliente_nombre}

		{if $clien neq '' and $clien neq $i.cliente_nombre}

		<tr>
			<td colspan="3" align="right">TOTAL</td>
			<td align="right">&nbsp;{$acumula_0|number_format:0:',':'.'}</td>
			<td align="right">&nbsp;</td>

			<td align="right">&nbsp;{$acumula_30|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;{$acumula_60|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;{$acumula_90|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;{$acumula_90mas|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
		</tr>
		{assign var="acumula_0" value="0"}
		{assign var="acumula_30" value="0"}
		{assign var="acumula_60" value="0"}
		{assign var="acumula_90" value="0"}
		{assign var="acumula_90mas" value="0"}
		<tr>
			<th colspan="13" align="left">&nbsp;</th>
		</tr>
		<tr>
			<th colspan="13" align="left">&nbsp;</th>
		</tr>


		{/if}
		{assign var="clien" value=$i.cliente_nombre}

		<tr>
			<th colspan="13" align="left">{$i.cliente_nombre}<br /></th>

		</tr>
		<tr>
			<th colspan="13" align="left">&nbsp;</th>
		</tr>

		<tr class="table-primary">
			<th rowspan="2">No FACT</th>
			<th rowspan="2">OFICINA</th>
			<th rowspan="2">VENCE</th>
			<th colspan="2">MENOR A 1</th>
			<th colspan="2">1-30</th>
			<th colspan="2">31-60</th>
			<th colspan="2">61-90</th>
			<th colspan="2">MAYOR A 90</th>
		</tr>
		<tr class="table-success">
			<th>VALOR</th>
			<th>DIAS</th>
			<th>VALOR</th>
			<th>DIAS</th>
			<th>VALOR</th>
			<th>DIAS</th>
			<th>VALOR</th>
			<th>DIAS</th>
			<th>VALOR</th>
			<th>DIAS</th>
		</tr>
		{/if}
		<tr>
			<td>{$i.consecutivo_factura}</td>
			<td >{$i.oficina}</td>
			<td>{$i.vencimiento}</td>

			<td  align="right">{if $i.dias lt 0 or $i.dias eq
				0}{$i.saldo|number_format:0:',':'.'}{/if}</td>
			<td>{if $i.dias lt 0 or $i.dias eq 0}{$i.dias}{/if}</td>

			<td  align="right">{if $i.dias gt 0 and $i.dias lt 31
				}{$i.saldo|number_format:0:',':'.'}{/if}</td>
			<td >{if $i.dias gt 0 and $i.dias lt 31 }{$i.dias}{/if}</td>

			<td  align="right">{if $i.dias gt 30 and $i.dias lt 61
				}{$i.saldo|number_format:0:',':'.'}{/if}</td>
			<td >{if $i.dias gt 30 and $i.dias lt 61 }{$i.dias}{/if}</td>

			<td  align="right">{if $i.dias gt 60 and $i.dias lt 91
				}{$i.saldo|number_format:0:',':'.'}{/if}</td>
			<td>{if $i.dias gt 60 and $i.dias lt 91 }{$i.dias}{/if}</td>

			<td align="right">{if $i.dias gt 90}{$i.saldo|number_format:0:',':'.'}{/if}
			</td>
			<td>{if $i.dias gt 90}{$i.dias}{/if}</td>

		</tr>
		{if $i.dias lt 0 or $i.dias eq 0 }
		{math assign="acumula_0" equation="x + y" x=$acumula_0 y=$i.valor_neto}
		{/if}

		{if $i.dias gt 0 and $i.dias lt 31 }
		{math assign="acumula_30" equation="x + y" x=$acumula_30 y=$i.valor_neto}
		{/if}
		{if $i.dias gt 30 and $i.dias lt 61 }
		{math assign="acumula_60" equation="x + y" x=$acumula_60 y=$i.saldo}
		{/if}
		{if $i.dias gt 60 and $i.dias lt 91 }
		{math assign="acumula_90" equation="x + y" x=$acumula_90 y=$i.saldo}
		{/if}
		{if $i.dias gt 90}
		{math assign="acumula_90mas" equation="x + y" x=$acumula_90mas y=$i.saldo}
		{/if}
		{math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.saldo}


		{/foreach}

		<tr>
			<td colspan="3" align="right">TOTAL</td>
			<td align="right">&nbsp;{$acumula_0|number_format:0:',':'.'}</td>
			<td align="right">&nbsp;</td>

			<td align="right">&nbsp;{$acumula_30|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;{$acumula_60|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;{$acumula_90|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;{$acumula_90mas|number_format:0:',':'.'}
			</td>
			<td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="13" align="right">&nbsp;</td>
		</tr>

		<tr>
			<td colspan="3" align="right"><b>TOTAL PENDIENTE</b></td>
			<td align="right" colspan="10" style="color: #ff0f0f">
				&nbsp;<b>{$acumula_total|number_format:0:',':'.'}</b></td>
		</tr>

	</table>

	{elseif $tipo eq 'RP'}
	<table class="table table-striped tableFixHead">
		<thead class="table-primary" align="center" width="100%">
			<tr>
				<th>No REMESA</th>
				<th>No. PLANILLA</th>
				<th>FECHA REMESA</th>
				<th>OFICINA</th>
				<th>CLIENTE</th>
				<th>TIPO REMESA</th>
				<th>ESTADO</th>
				<th>CLASE</th>
				<th>ORIGEN</th>
				<th>DESTINO</th>
				<th>MEDIDA</th>
				<th>A FACTURAR</th>
			</tr>
		</thead>
		{assign var="acumula_total" value="0"}
		{foreach name=detalles from=$DETALLES item=i}
		<tr>
			<td>{$i.numero_remesa}</td>
			<td>{$i.planilla}</td>
			<td>{$i.fecha_remesa}</td>
			<td>{$i.oficina_remesa}</td>
			<td>{$i.cliente}</td>
			<td>{$i.tipo_remesa}</td>
			<td>{$i.estado}</td>
			<td>{$i.clase}</td>
			<td>{$i.origen}</td>
			<td>{$i.destino}</td>
			<td>{$i.medida}</td>
			<td>${$i.valor_facturar|number_format:0:',':'.'}</td>
		</tr>
			{math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_facturar}
		{/foreach}
		<tr>
			<td colspan="11" align="right"><b>TOTAL A FACTURAR</b></td>
			<td align="right" colspan="1" style="color: #ff0f0f">
			&nbsp;<b>{$acumula_total|number_format:0:',':'.'}</b></td>
		</tr>
		{elseif $tipo eq 'VE'}
			<table class="table table-striped tableFixHead">
				<thead class="table-primary" align="center" width="100%">
					<tr>
						<th>No DOCUMENTO</th>
						<th>TIPO DOCUMENTO</th>
						<th>FECHA</th>
						<th>OFICINA</th>
						<th>CLIENTE</th>
						<th>VALOR TOTAL</th>
						
						
					</tr>
				</thead>
				{assign var="acumula_total" value="0"}
				{foreach name=detalles from=$DETALLES item=i}
				<tr>
					<td>{$i.consecutivo}</td>
					<td>{$i.tipo_documento}</td>
					<td>{$i.fecha}</td>
					<td>{$i.oficina}</td>
					<td>{$i.cliente_nombre}</td>
					
					<td>${$i.valor_neto|number_format:0:',':'.'}</td>
				</tr>
					{math assign="acumula_total" equation="x + y" x=$acumula_total y=$i.valor_neto}
				{/foreach}
				<tr>
					<td colspan="5" align="right"><b>TOTAL VENDIDO</b></td>
					<td align="center" colspan="1" style="color: #11af02">
					<b>${$acumula_total|number_format:0:',':'.'}</b></td>
				</tr>
		
				

		{/if}
	</table>
</body>

</html>