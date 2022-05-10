<html>
  <head>
    <title>Balance General</title>
    {$CSSSYSTEM} 	
  </head>
  <body>
  	<td>
	  	<table width="80%" align="center" id="encabezado" border="0">
		  <tr><td align="center" colspan="8" class="header">{$EMPRESA} </td></tr>
		  <tr><td colspan="8" align="center" class="header">Nit. {$NIT}</td></tr>
		  <tr><td colspan="8">&nbsp;</td></tr>	  
		  <tr><td align="center" colspan="8" class="header">COMPARATIVO ESTADO DE RESULTADOS</td></tr>	 	 	   
		  <tr><td align="center" colspan="8" class="header">PERIODO 1 : {$DESDE1} - {$HASTA1}</td></tr>	 	   
		  <tr><td align="center" colspan="8" class="header">PERIODO 2 : {$DESDE2} - {$HASTA2}</td></tr>	 	   
		  <tr><td align="center" colspan="8" class="header">(Valores Expresados en pesos Colombianos)</td></tr>	 	   	  
		  <tr><td align="center" colspan="8" class="header">Centros : {$CENTROS}</td></tr>	 	   	  	  	  
		</table>  
		<br><br>
			<table width="80%" align="center" cellpadding="8" class="table_general" border="2">
				<tr>
				    <th width="10%" style="border:1px solid">CODIGO</th>
					<th width="40%"  align="center" style="border:1px solid">CUENTA</th>
				    <th width="10%"  align="center" style="border:1px solid" colspan="2">PERIODO 1</th>
				    <th width="10%"  align="center" style="border:1px solid" colspan="2">PERIODO 2</th>
				    <th width="10%"  align="center" style="border:1px solid" colspan="2">VARIACI&Oacute;N</th>
				</tr>
				<tr>
				    <td style="border:1px solid">&nbsp;</td>
				    <td style="border:1px solid">&nbsp;</td>
				    <td style="border:1px solid">TOTAL</td>
				    <td style="border:1px solid" align="center">% PARTICIPACI&Oacute;N</td>
				    <td style="border:1px solid">TOTAL</td>
				    <td style="border:1px solid" align="center">% PARTICIPACI&Oacute;N</td>
				    <td style="border:1px solid">ABSOLUTA</td>
				    <td style="border:1px solid">PORCENTAJE</td>
				</tr>
				{assign var="var" value="0"}
				{assign var="sump1cents" value="0"}
				{assign var="sump2cents" value="0"}
			{section name=rows loop=$arrayResult|count}
				{assign var="val" value=$var+1}
			  	{assign var="a" value=$arrayResult[$val].codigo}
				<tr align="left" bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
					<td align="left" style="border:1px solid">{$arrayResult[$var].codigo}</td>
					<td align="left" style="border:1px solid">{$arrayResult[$var].cuenta}</td>
					
					{if $arrayResult[$var].codigo|substr:0:1 eq 4}
						{assign var="total" value=$arrayResult1[0].subtotal.total}
						{assign var="total1" value=$arrayResult1[0].subtotal.total1}
					{/if}
					{if $arrayResult[$var].codigo|substr:0:1 eq 5}
						{assign var="total" value=$arrayResult1[1].subtotal.total}
						{assign var="total1" value=$arrayResult1[1].subtotal.total1}
					{/if}
					{if $arrayResult[$var].codigo|substr:0:1 eq 6}
						{assign var="total" value=$arrayResult1[2].subtotal.total}
						{assign var="total1" value=$arrayResult1[2].subtotal.total1}
					{/if}
					{if $arrayResult[$var].codigo|substr:0:1 eq 7}
						{assign var="total" value=$arrayResult1[3].subtotal.total}
						{assign var="total1" value=$arrayResult1[3].subtotal.total1}
					{/if}
					<td align="right" style="border:1px solid" >{$arrayResult[$var].saldo|number_format:0:",":"."}</td>
				    <td align="right" style="border:1px solid">{if $arrayResult[$var].tipo eq $NIVEL}{math assign="porcentaje" equation="((saldo / total)*100)" saldo=$arrayResult[$var].saldo total=$total}{$porcentaje|number_format:2:",":"."}%{/if}</td>
				    <td align="right" style="border:1px solid">{$arrayResult[$var].saldo1|number_format:0:",":"."}</td>
				    <td align="right" style="border:1px solid">{if $arrayResult[$var].tipo eq $NIVEL}{math assign="porcentaje1" equation="((saldo / total)*100)" saldo=$arrayResult[$var].saldo1 total=$total1}{$porcentaje1|number_format:2:",":"."}%{/if}</td>
				    <td align="left" style="border:1px solid">{math assign="absoluto" equation="(saldo2 - saldo1)" saldo1=$arrayResult[$var].saldo saldo2=$arrayResult[$var].saldo1}{$absoluto|number_format:2:",":"."}</td>
					<td align="left" style="border:1px solid">{math assign="percentabs" equation="($absoluto/saldo1)*100" saldo1=$arrayResult[$var].saldo}{$percentabs|number_format:2:",":"."}%</td>
				</tr>
				  <!-- SUBTOTAL -->
				  	{if $arrayResult[$var].tipo eq $NIVEL}
						{assign var="sump1cents" value=$sump1cents+$porcentaje}
						{assign var="sump2cents" value=$sump2cents+$porcentaje1}
					{/if}
				  	{if $a eq 5}
						<tr>
							<td colspan="8"  class="total">
								<tr style="border:2px solid">
									<td colspan="2" align="left" class="header">{$arrayResult1[0].subtotal.texto}</td>
									<td  align="right">{$arrayResult1[0].subtotal.total|number_format:0:",":"."}</td>
									<td>{$sump1cents|number_format:0:",":"."} %</td>
									<td  align="right">{$arrayResult1[0].subtotal.total1|number_format:0:",":"."}</td>
									<td>{$sump2cents|number_format:0:",":"."} %</td>
								</tr>
							</td>
						</tr>
						<tr><td colspan="8">&nbsp;</td></tr>
				{assign var="sump1cents" value="0"}
				{assign var="sump2cents" value="0"}
					{/if}
					{if $a eq 6}
						<tr>
							<td colspan="8"  class="total">
								<tr style="border:2px solid">
									<td colspan="2" align="left" class="header">{$arrayResult1[1].subtotal.texto}</td>
									<td align="right">{$arrayResult1[1].subtotal.total|number_format:0:",":"."}</td>
									<td>{$sump1cents|number_format:0:",":"."} %</td>
									<td align="right">{$arrayResult1[1].subtotal.total1|number_format:0:",":"."}</td>
									<td>{$sump2cents|number_format:0:",":"."} %</td>
								</tr>
							</td>
						</tr>
						<tr><td colspan="8">&nbsp;</td></tr>
				{assign var="sump1cents" value="0"}
				{assign var="sump2cents" value="0"}
					{/if}
					{if $a eq 7}
						<tr>
							<td colspan="8"  class="total">
								<tr style="border:2px solid">
									<td colspan="2" align="left" class="header">{$arrayResult1[2].subtotal.texto}</td>
									<td align="right">{$arrayResult1[2].subtotal.total|number_format:0:",":"."}</td>
									<td>{$sump1cents|number_format:0:",":"."} %</td>
									<td align="right">{$arrayResult1[2].subtotal.total1|number_format:0:",":"."}</td>
									<td>{$sump2cents|number_format:0:",":"."} %</td>
								</tr>
							</td>
						</tr>
						<tr><td colspan="8">&nbsp;</td></tr>
				{assign var="sump1cents" value="0"}
				{assign var="sump2cents" value="0"}
					{/if}
				{assign var="var" value=$var+1}
			{/section}
			<tr>
				<td colspan="8"  class="total">
					<tr style="border:2px solid">
						<td colspan="2" align="left" class="header">{$arrayResult1[3].subtotal.texto}</td>
						<td align="right">{$arrayResult1[3].subtotal.total|number_format:0:",":"."}</td>
						<td>{$sump1cents|number_format:0:",":"."} %</td>
						<td align="right">{$arrayResult1[3].subtotal.total1|number_format:0:",":"."}</td>
						<td>{$sump2cents|number_format:0:",":"."} %</td>
						{assign var="sump1cents" value="0"}
				{assign var="sump2cents" value="0"}
					</tr>
				</td>
			</tr>
			<tr>
				<td colspan="8"  class="total">
					<tr style="border:2px solid">
						<td colspan="2" align="left" class="header">TOTAL DE UTILIDAD</td>
						{assign var=a value=$arrayResult1[1].subtotal.total+$arrayResult1[2].subtotal.total+$arrayResult1[3].subtotal.total}
						{assign var=b value=$arrayResult1[0].subtotal.total-$a}
						<td align="center">{if $b lt 0}PERDIDA{else}GANACIA{/if}<br>{$b|number_format:0:",":"."}</td>
						<td align="right"></td>
						{assign var=a value=$arrayResult1[1].subtotal.total1+$arrayResult1[2].subtotal.total1+$arrayResult1[3].subtotal.total1}
						{assign var=b value=$arrayResult1[0].subtotal.total1-$a}
						<td align="center">{if $b lt 0}PERDIDA{else}GANACIA{/if}<br>{$b|number_format:0:",":"."}</td>
						<td></td>
					</tr>
				</td>
			</tr>
		</table>
		<td>
  </table>
  </body>
</html>