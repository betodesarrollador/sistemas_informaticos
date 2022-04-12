<html>
	<head>
	<title>Inventario Y Balance</title>
	{$JAVASCRIPT}
	{$CSSSYSTEM}
	</head>
	<body>
		<table width="80%" align="center" id="encabezado" border="0">
			<tr><td align="center" colspan="3">Centros : {$CENTROS}</td></tr>
			<tr><td align="center" colspan="3">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>
		</table>
		<br />
		<table border="0" width="95%%" align="center">
			<tr>
				<td width="100%" colspan="3">
					<table border="0" width="100%" id="registros">
						<tr align="center">
							<th class="borderTop borderRight">Codigo</th>
							<th class="borderTop borderRight">Cuenta</th>
							<th class="borderTop borderRight" align="right">Saldo Anterior</th>
							<th class="borderTop borderRight" align="right">Debito</th>
							<th class="borderTop borderRight" align="right">Credito</th>
							<th class="borderTop borderRight" align="right">Nuevo Saldo</th>
						</tr>
						{foreach name=reporte from=$REPORTE item=r}
							{if $r.debito eq 0 and $r.credito eq 0}
							{else}
								<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
									<td class="borderTop borderRight" align="left">{$r.codigo_puc}</td>
									<td class="borderTop borderRight" align="left">{$r.cuenta}</td>
									<td class="borderTop borderRight" align="right">{$r.saldo_anterior|number_format:2:",":"."}</td>
									<td class="borderTop borderRight" align="right">{$r.debito|number_format:2:",":"."}</td>
									<td class="borderTop borderRight" align="right">{$r.credito|number_format:2:",":"."}</td>
									<td class="borderTop borderRight" align="right">{$r.nuevo_saldo|number_format:2:",":"."}</td>
								</tr>
							{/if}
						{/foreach}
						<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
							<td class="borderTop borderRight" align="left" colspan="2">TOTAL</td>
							<td class="borderTop borderRight" align="right"></td>
							<td class="borderTop borderRight" align="right">{$DEBITO|number_format:2:",":"."}</td>
							<td class="borderTop borderRight" align="right">{$CREDITO|number_format:2:",":"."}</td>
							<td class="borderTop borderRight" align="right"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="80%" align="center" id="usuarioProceso">
			<tr>
				<td width="50%" align="left">Procesado Por : {$USUARIO}</td>
				<td width="50%" align="right">Fecha/Hora : {$FECHA} {$HORA}</td>
			</tr>
		</table>
	</body>
</html>