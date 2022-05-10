<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
	</head>
	<body>
		<table align="center" width="100%">
			<thead>
				<tr>
					<th>SOLICITUD ID</th>
					<th>FECHA</th>
					<th>CLIENTES</th>
					<th>NIT</th>
					<th>CANTIDAD DE GUIAS</th>
				</tr>
			</thead>
			<tbody>
				{foreach name=detalle_solicitud from=$DETALLES item=d}
					<tr>
						<td>
							<input id="solicitud_id" name="solicitud_id" value="{$d.solicitud_id}" disabled>
						</td>
						<td>
							<label id="fecha" name="fecha">{$d.fecha}</label>
						</td>
						<td>
							<label id="cliente" name="cliente" value="{$d.cliente}">{$d.cliente}</label>
						</td>
						<td>
							<label id="nit" name="nit" value="{$d.nit}">{$d.nit}</label>
						</td>
						<td>
							{$d.guia}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</body>
</html>