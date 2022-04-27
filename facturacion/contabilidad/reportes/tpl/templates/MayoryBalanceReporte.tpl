<html>
	<head>
		<title>Balance de Prueba</title>
		{$JAVASCRIPT}
		{$CSSSYSTEM} 	
		</head>
	<body>
		<table width="80%" align="center" id="encabezado" border="0">
			<tr><td align="center" colspan="8">{$EMPRESA} - {$NIT}<BR>MAYOR Y BALANCE</td></tr>
			<tr><td align="center" colspan="8">Centro de costos : {$CENTROS}</td></tr>
			<tr><td align="center" colspan="8">DESDE : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;HASTA: {$HASTA}</td></tr>	 	   
		</table>	
			<br />
		<table border="0" width="95%%" align="center">	    	  
			<tr>
				<td width="100%">
					<table border="0" width="100%" id="registros">
						<tr align="center">
							<th style="border: 1px solid" align="center" width="5%" rowspan="2">Codigo Cta.</th>             
							<th style="border: 1px solid" align="center" width="25%" rowspan="2">Nombre</th>             
							<th style="border: 1px solid" align="center" colspan="2" width="23%">Saldo Anterior</th>
							<th style="border: 1px solid" align="center" colspan="2" width="23%">Movimiento del Periodo</th>
							<th style="border: 1px solid" align="center" colspan="2" width="23%">Nuevo Saldo</th>								
						</tr>
						<tr>
							<td align="center" style="border: 1px solid">DEBITO</td>
							<td align="center" style="border: 1px solid">CREDITO</td>
							<td align="center" style="border: 1px solid">DEBITO</td>
							<td align="center" style="border: 1px solid">CREDITO</td>
							<td align="center" style="border: 1px solid">DEBITO</td>
							<td align="center" style="border: 1px solid">CREDITO</td>
						</tr>
						{assign var="k" value=0}
						{assign var="satotaldeb" value=0}
						{assign var="satotalcred" value=0}
						{assign var="totaldeb" value=0}
						{assign var="totalcred" value=0}
						{assign var="nstotaldeb" value=0}
						{assign var="nstotalcred" value=0}
						{section name=reporte loop=$REPORTE|count}
                            {if $REPORTE[$k].debito eq 0 and $REPORTE[$k].credito eq 0 and $REPORTE[$k].sadebito eq 0 and $REPORTE[$k].sacredito eq 0}
                            {else}
                                <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                                    <td style="border: 1px solid" align="left">{$REPORTE[$k].codigo_puc}</td>            
                                    <td style="border: 1px solid" align="left">{$REPORTE[$k].nombre_puc}</td>            
                                    <td style="border: 1px solid" align="right">{$REPORTE[$k].sadebito|number_format:2:",":"."}</td>
                                    <td style="border: 1px solid" align="right">{$REPORTE[$k].sacredito|number_format:2:",":"."}</td>
                                    <td style="border: 1px solid" align="right">{$REPORTE[$k].debito|number_format:2:",":"."}</td>
                                    <td style="border: 1px solid" align="right">{$REPORTE[$k].credito|number_format:2:",":"."}</td>
                                    <td style="border: 1px solid" align="right">{$REPORTE[$k].nuevo_saldod|number_format:2:",":"."}</td>
                                    <td style="border: 1px solid" align="right">{$REPORTE[$k].nuevo_saldoc|number_format:2:",":"."}</td>
                                </tr>
                                {assign var="satotaldeb" value=$satotaldeb+$REPORTE[$k].sadebito}
                                {assign var="satotalcred" value=$satotalcred+$REPORTE[$k].sacredito}
                                {assign var="totaldeb" value=$totaldeb+$REPORTE[$k].debito}
                                {assign var="totalcred" value=$totalcred+$REPORTE[$k].credito}
                                {assign var="nstotaldeb" value=$nstotaldeb+$REPORTE[$k].nuevo_saldod}
                                {assign var="nstotalcred" value=$nstotalcred+$REPORTE[$k].nuevo_saldoc}
                            {/if}
							{assign var="k" value=$k+1}
						{/section}
							<tr>
								<td></td>
							</tr>
							<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
								<td align="center" colspan="2">TOTAL</td>
								<td style="border: 1px solid" align="right">{$satotaldeb|number_format:2:",":"."}</td>
								<td style="border: 1px solid" align="right">{$satotalcred|number_format:2:",":"."}</td>
								<td style="border: 1px solid" align="right">{$totaldeb|number_format:2:",":"."}</td>
								<td style="border: 1px solid" align="right">{$totalcred|number_format:2:",":"."}</td>
								<td style="border: 1px solid" align="right">{$nstotaldeb|number_format:2:",":"."}</td>
								<td style="border: 1px solid" align="right">{$nstotalcred|number_format:2:",":"."}</td>
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