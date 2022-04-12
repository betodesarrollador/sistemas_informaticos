<html>
	<head>
		<title>Balance General</title>
		{$CSSSYSTEM}
	</head>
	<body>
		<table width="80%" align="center" id="encabezado" border="0">
			<tr><td align="center" colspan="4" class="header">DESDE - {$DESDE} : HASTA - {$HASTA}</td></tr>
			<tr><td align="center" colspan="4" class="header">(Valores Expresados en pesos Colombianos)</td></tr>
			<tr><td align="center" colspan="4" class="header">Centros : {$CENTROS}</td></tr>
		</table>  
		<br><br>
		<table width="80%" align="center" cellpadding="4" class="table_general">
			<thead>
				<tr align="center" class="title">
					<th width="10%" style="border-right:1px solid">CODIGO CTA</th>
					<th width="40%"  align="center" style="border-right:1px solid">NOMBRE CUENTA</th>
					<th width="10%"  align="center" style="border-right:1px solid">SALDO DEBITO</th>
					<th width="10%"  align="center" style="border-right:1px solid">SALDO CREDITO</th>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
			</thead>
			<tbody>
				{assign var="i" value=0}
				{section name=rows loop=$arrayResult|count}
					{assign var="k" value=0}
					{assign var="subdeb" value=0}
					{assign var="subcred" value=0}
					{section name=row loop=$arrayResult[$i]|count}
						{if $arrayResult[$i][$k].debito eq 0 and $arrayResult[$i][$k].credito eq 0}
						{else}
							<tr align="left" bgcolor="{cycle values="#EEEEEE,#D0D0D0"}" style="border:1px solid">
								<td align="left" style="border:1px solid" class="codigo_puc">{if $k eq 0}{$arrayResult[$i][$k].codigo_puc}{/if}</td>
								<td align="left" style="border:1px solid" class="cuentas_movimiento">{$arrayResult[$i][$k].nombre}</td>
								<td align="left" style="border:1px solid">{$arrayResult[$i][$k].debito|number_format:2:",":"."}</td>
								<td align="left" style="border:1px solid">{$arrayResult[$i][$k].credito|number_format:2:",":"."}</td>
							</tr>
						{/if}
						{assign var="subdeb" value=$subdeb+$arrayResult[$i][$k].debito}
						{assign var="subcred" value=$subcred+$arrayResult[$i][$k].credito}
						{assign var="nom" value=$arrayResult[$i][$k].codigo_puc}
 						{assign var="k" value=$k+1}
					{/section}
					{if $arrayResult[$i]|is_array}
						{if $subdeb eq 0 and $subcred eq 0}
						{else}
							<tr>
								<td></td>
							</tr>
	 						<tr>
	 							<td colspan="2" align="center">SUBTOTAL {$nom}</td>
	 							<td align="left" style="border:1px solid">{$subdeb|number_format:2:",":"."}</td>
	 							<td align="left" style="border:1px solid">{$subcred|number_format:2:",":"."}</td>
	 						</tr>
	 						<tr>
	 							<td></td>
	 						</tr>
 						{/if}
 					{/if}
					{assign var="i" value=$i+1}
				{/section}
				<tr>
					<td></td>
				</tr	>
				<tr>
					<td colspan="2" align="center" style="border:1px solid">TOTAL DEBITO Y CREDITO</td>
					<td style="border:1px solid">{$TDEBITO|number_format:2:",":"."}</td>
					<td style="border:1px solid">{$TCREDITO|number_format:2:",":"."}</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>  