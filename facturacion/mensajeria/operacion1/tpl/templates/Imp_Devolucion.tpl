<html>
	<head>
	{$CSSSYSTEM}
	{$JAVASCRIPT}
	<title>Impresion Devolucion</title>
{literal}
	<style >
			/* CSS Document */

			.anulado{
			width:500px;
			margin-top:180px;
			margin-left:230px;
			position:absolute;
			font-weight:bold;
			color:#FBCDBF;
			font-size:60px;
			opacity:0.2;
			filter:alpha(opacity=40);
			}

			.anulado1{
			width:500px;
			margin-top:400px;
			margin-left:230px;
			position:absolute;
			font-weight:bold;
			color:#FBCDBF;
			font-size:60px;
			opacity:0.2;
			filter:alpha(opacity=40);
			}
		</style>
{/literal}
	</head>

	<body>
		{if $DATOSDEVOLUCION[0].estado eq 'A'}
			<div class="anulado">ANULADO</div>
			<div class="anulado1">ANULADO</div>
		{/if}  
		{assign var="cont" value="0"}
		{foreach name=guias from=$DATOSDEVOLUCION item=r}
			<table  border="0" width="95%" align="center">
				<tr>
					<td align="center" colspan="4"> 
						<table border="0" width="100%" align="center">
							<tr>
								<td width="30%" align="left" ><img src="{$r.logo}" width="200" height="80" /></td>
								<td width="40%" ><div class="title">{$r.nombre_empresa}</div></td>
								<td width="30%" align="right">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="general">Documento: {$r.id_empresa}</td>
				</tr>
				<tr>
					<td colspan="4" class="general">OFICINA {$r.oficina} - {$r.direccion} </td>
				</tr>
				<tr>
					<td colspan="4" class="general">{$r.ciudad}</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="47%" align="left"><div class="title" style="font-size:16px">FECHA DEVOLUCI&Oacute;N:&nbsp;&nbsp;{$r.fecha_dev}</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<br><br>
				<tr>
					<td colspan="4" align="center">
						<table width="97%" border="0" align="center">
							<tr>
								<td width="14%"><label>Mensajero&nbsp;:</label></td>
								<td colspan="3"> {$r.proveedor} </td>
							</tr>
							<tr>
								<td><label>Identificacion&nbsp;: </label></td>
								<td width="37%">{$r.identificacion_prove} </td>
								<td width="21%"><label>Telefono&nbsp;: </label></td>
								<td width="28%">{if $r.telefono neq ''}{$r.telefono} - {/if}{$r.movil}</td>
							</tr>
							<tr>
								<td><label>Direccion : </label></td>
								<td>{$r.direccion} </td>
								<td><label>Ciudad : </label></td>
								<td>{$r.ciudad_devolucion}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<table  border="0" width="97%" align="center" class="producto">
							<thead>
								<tr align="center">
									<th class="productocelllefttop">Guia</th>
									<th class="productocellrighttop">Descripcion</th>
									<th class="productocellrighttop">Causal</th>
									<th class="productocellrighttop">Destino </th>
									<th class="productocellrighttop">Destinatario</th>
									<th class="productocellrighttop">Direcci&oacute;n</th>
									<th class="productocellrighttop">Fecha</th>
								</tr>
							</thead>
							<tbody>
								{foreach name=imputaciones from=$DETALLES item=i}
									<tr align="center">
										<td class="productocellleftbottom">{$i.numero_guia}</td>
										<td class="productocellrightbottom">{$i.descripcion_producto}</td>
										<td class="productocellrightbottom">{$i.causal}</td>
										<td class="productocellrightbottom">{$i.destino}</td>
										<td class="productocellrightbottom">{$i.destinatario}</td>
										<td class="productocellrightbottom">{$i.direccion_destinatario}</td>
										<td class="productocellrightbottom">{$i.fecha_guia}</td>
									</tr>
								{/foreach}
									<tr>
										<td>TOTAL GUIAS</td>
										<td>{$DETALLES|@count}</td>
									</tr>							
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td height="47" colspan="4">&nbsp;</td>
				</tr>  
				<tr>
					<td colspan="4">
						<table width="80%" border="0" align="center">
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr align="center">
								<td class="firmas"><hr width="80%" />APROBO</td>
								<td class="firmas"><hr width="80%" />REVISO</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>	  
				<tr>
					<td colspan="4">
						<table width="90%" border="0" align="center">
							<tr>
								<td>Elaborado por : {$r.usuario_registra}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br><br><br><br><br><br>
			{assign var=cont value=$cont+1}
			{if $cont eq 2} {assign var="cont" value="0"}<br class="saltopagina" /> {/if}
		{/foreach}
	</body>
</html>
