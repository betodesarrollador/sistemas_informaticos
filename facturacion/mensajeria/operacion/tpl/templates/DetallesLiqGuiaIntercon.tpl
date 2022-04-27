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
					<th>GUIA
                    	<input id="cliente_id" name="cliente_id" value="{$CLIENTEID}" type="hidden"> 
                        <input id="guias_interconexion_id" name="guias_interconexion_id" value="{$GUIASID}" type="hidden">
                        <input id="fecha_inicial" name="fecha_inicial" value="{$FECHA_INICIAL}" type="hidden">
                        <input id="fecha_final" name="fecha_final" value="{$FECHA_FINAL}" type="hidden">  
                    </th>
					<th>FECHA</th>
					<th>ESTADO</th>
                    <th>VALOR</th>
					<th>ORIGEN</th>
					<th>DESTINO</th>
				</tr>
			</thead>
			<tbody>
				{foreach name=detalle_solicitud from=$DETALLES item=d}
					<tr>
						<td><input id="guia_interconexion_id" name="guia_id" value="{$d.guia_interconexion_id}" type="hidden">{$d.numero_guia}</td>
						<td>{$d.fecha_guia}</td>
						<td>{$d.estado_mensajeria}</td>
                        <td>{$d.valor_total|number_format:0:".":","}</td>
						<td>{$d.origen}</td>                        
						<td>{$d.destino}</td>                                                
					</tr>
				{/foreach}
			</tbody>
		</table>
	</body>
</html>