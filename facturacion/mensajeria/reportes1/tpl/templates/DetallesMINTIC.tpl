<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
	</head>
	{if $REPORTE eq 1}
		<body>
			<table width="90%" align="center" id="encabezado" border="0.1 solid">
				<tr><td align="center">INGRESOS POR SERVICIO DE MENSAJERIA</td></tr>
				<tr><td align="center">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>
				<tr><td align="center">Valores dados en pesos Colombianos</td></tr>
			</table>

			<table align="center" id="encabezado"  width="90%" border="0.1 solid">
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">AÑO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TRIMESTRE</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">MES DEL TRIMESTRE</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO SERVICIO DE MENSAJERIA</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO DE ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">AMBITO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">RANGO PESO DEL ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INGRESOS</th>
				</tr>
				{foreach name=reporte from=$DETALLES item=r}
					{if $r.mes_trimestre eq 1 || $r.mes_trimestre eq 4 || $r.mes_trimestre eq 7 || $r.mes_trimestre eq 10}
						{assign var=mes_trimestre value=1}
					{elseif $r.mes_trimestre eq 2 || $r.mes_trimestre eq 5 || $r.mes_trimestre eq 8 || $r.mes_trimestre eq 11}
						{assign var=mes_trimestre value=2}
					{elseif $r.mes_trimestre eq 3 || $r.mes_trimestre eq 6 || $r.mes_trimestre eq 9 || $r.mes_trimestre eq 12}
						{assign var=mes_trimestre value=3}
					{/if}
					<tr>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.anio}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.trimestre}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$mes_trimestre}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.tipo_servicio}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.tipo_envio}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.ambito}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.rango_peso}</td>
						<td class="borderTop borderRight borderLeft borderBottom" >${$r.ingresos|number_format:2:",":"."}</td>
					</tr>
				{/foreach}
			</table>
		</body>
	{/if}
	{if $REPORTE eq 2}
		<body>
			<table width="90%" align="center" id="encabezado" border="0.1 solid">
				<tr><td align="center" colspan="11">TIEMPOS DE ENTREGA</td></tr>
				<tr><td align="center" colspan="11">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>
			</table>

			<table align="center" id="encabezado"  width="90%" border="0.1 solid">
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">AÑO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TRIMESTRE</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO AMBITO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA 12 HORAS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA 24 HORAS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA 36 HORAS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA 48 HORAS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA 60 HORAS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA 72 HORAS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA 96 HORAS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">% OBJETOS POSTALES TIEMPO DE ENTREGA MAS DE 96 HORAS</th>
				</tr>
				{assign var=total value=$DETALLES.0.total}
				{foreach name=reporte from=$DETALLES item=r}
					{if $r.anio neq ""}
						{assign var=cant_tiempo_entrega value=$r.cant_tiempo_entrega}
						<tr>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.anio}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.trimestre}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.tipo_envio}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.ambito}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 0 && $r.tiempo_entrega lt 12.1}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 12 && $r.tiempo_entrega lt 24.1}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 24 && $r.tiempo_entrega lt 36.1}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 36 && $r.tiempo_entrega lt 48.1}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 48 && $r.tiempo_entrega lt 60.1}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 60 && $r.tiempo_entrega lt 72.1}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 72 && $r.tiempo_entrega lt 96.1}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
							<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $r.tiempo_entrega gt 96}{math assign="val" equation=($cant_tiempo_entrega*100)/$total}{$val|number_format:2:",":"."}%{else}0%{/if}</td>
						</tr>
					{/if}
				{/foreach}
			</table>
		</body>
	{/if}
	{if $REPORTE eq 3}
		<body>
			<table width="90%" align="center" id="encabezado" border="0.1 solid">
				<tr><td align="center" colspan="11">PORCENTAJE DE ENTREGA BUEN ESTADO</td></tr>
				<tr><td align="center" colspan="11">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>
			</table>
			<table align="center" id="encabezado"  width="90%" border="0.1 solid">
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">AÑO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TRIMESTRE</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO AMBITO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">OBJETOS POSTALES ENVIADOS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">OBJETOS POSTALES ENTREGADOS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">OBJETOS PERDIDOS O AVERIADOS</th>
				</tr>
				{foreach name=reporte from=$DETALLES item=r}
					<tr>
						<td class="borderTop borderRight borderLeft borderBottom">{$r.anio}</td>
						<td class="borderTop borderRight borderLeft borderBottom">{$r.trimestre}</td>
						<td class="borderTop borderRight borderLeft borderBottom">{$r.tipo_envio}</td>
						<td class="borderTop borderRight borderLeft borderBottom">{$r.ambito}</td>
						<td class="borderTop borderRight borderLeft borderBottom">{if $r.enviados neq ''}{$r.enviados}{else}0{/if}</td>
						<td class="borderTop borderRight borderLeft borderBottom">{if $r.entregados neq ''}{$r.entregados}{else}0{/if}</td>
						<td class="borderTop borderRight borderLeft borderBottom">{if $r.noentregados neq ''}{$r.noentregados}{else}0{/if}</td>
					</tr>
				{/foreach}
			</table>
		</body>
	{/if}
	{if $REPORTE eq 4}
		<body>
			<table width="90%" align="center" id="encabezado" border="0.1 solid">
				<tr><td align="center" colspan="9">INGRESOS POR SERVICIO DE CORREO</td></tr>
				<tr><td align="center" colspan="9">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>
			</table>
			{assign var="EIL11" value=0}	{assign var="EIL12" value=0}	{assign var="TA11" value=0}
			{assign var="EIN21" value=0}	{assign var="EIN22" value=0}	{assign var="TA21" value=0}
			{assign var="EIIS31" value=0}	{assign var="EIIS32" value=0}	{assign var="TA31" value=0}
			{assign var="EIIE41" value=0}	{assign var="EIIE42" value=0}	{assign var="TA41" value=0}
			{assign var="EML51" value=0}	{assign var="EML52" value=0}	{assign var="TA51" value=0}
			{assign var="EMN61" value=0}	{assign var="EMN62" value=0}	{assign var="TA61" value=0}

			{assign var="XIL11" value=0}	{assign var="XIL12" value=0}	{assign var="XIL13" value=0}	{assign var="XIL14" value=0}	{assign var="TA12" value=0}
			{assign var="XIN21" value=0}	{assign var="XIN22" value=0}	{assign var="XIN23" value=0}	{assign var="XIN24" value=0}	{assign var="TA22" value=0}
			{assign var="XIIS31" value=0}	{assign var="XIIS32" value=0}	{assign var="XIIS33" value=0}	{assign var="XIIS34" value=0}	{assign var="TA32" value=0}
			{assign var="XIIE41" value=0}	{assign var="XIIE42" value=0}	{assign var="XIIE43" value=0}	{assign var="XIIE44" value=0}	{assign var="TA42" value=0}
			{assign var="XML51" value=0}	{assign var="XML52" value=0}	{assign var="XML53" value=0}	{assign var="XML54" value=0}	{assign var="TA52" value=0}
			{assign var="XMN61" value=0}	{assign var="XMN62" value=0}	{assign var="XMN63" value=0}	{assign var="XMN64" value=0}	{assign var="TA62" value=0}

			{assign var="TT1" value=0}	{assign var="TT1" value=0}	{assign var="TT1" value=0}	{assign var="TT1" value=0}	{assign var="TT1" value=0}

			{foreach name=reporte from=$DETALLES item=r}

				{if $r.tipo_servicio eq "ESPECIALIZADA"}

					{if $r.tipo_envio eq "INDIVIDUAL"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso lt 1.1}
								{assign var="EIL11" value=$EIL11+$r.valor_total}
							{elseif $r.peso gt 1}
								{assign var="EIL12" value=$EIL12+$r.valor_total}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso lt 1.1}
								{assign var="EIN21" value=$EIN21+$r.valor_total}
							{elseif $r.peso gt 1}
								{assign var="EIN22" value=$EIN22+$r.valor_total}
							{/if}

						{/if}

					{elseif $r.tipo_envio eq "MASIVO"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso lt 1.1}
								{assign var="EML51" value=$EML51+$r.valor_total}
							{elseif $r.peso gt 1}
								{assign var="EMN52" value=$EMN52+$r.valor_total}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso lt 1.1}
								{assign var="EMN61" value=$EMN61+$r.valor_total}
							{elseif $r.peso gt 1}
								{assign var="EMN62" value=$EMN62+$r.valor_total}
							{/if}

						{/if}

					{/if}

				{elseif $r.tipo_servicio eq "EXPRESA"}

					{if $r.tipo_envio eq "INDIVIDUAL"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="XIL11" value=$XIL11+$r.valor_total}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="XIL12" value=$XIL12+$r.valor_total}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="XIL13" value=$XIL13+$r.valor_total}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="XIL14" value=$XIL14+$r.valor_total}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="XIN11" value=$XIN11+$r.valor_total}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="XIN12" value=$XIN12+$r.valor_total}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="XIN13" value=$XIN13+$r.valor_total}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="XIN14" value=$XIN14+$r.valor_total}
							{/if}

						{/if}

					{elseif $r.tipo_envio eq "MASIVO"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="XML51" value=$XML51+$r.valor_total}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="XML52" value=$XML52+$r.valor_total}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="XML53" value=$XML53+$r.valor_total}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="XML54" value=$XML54+$r.valor_total}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="XMN61" value=$XMN61+$r.valor_total}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="XMN62" value=$XMN62+$r.valor_total}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="XMN63" value=$XMN63+$r.valor_total}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="XMN64" value=$XMN64+$r.valor_total}
							{/if}

						{/if}

					{/if}

				{/if}

			{/foreach}

			<table align="center" id="encabezado"  width="90%" border="0.1 solid">
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="2" align="center">TIPO DE SERVICIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="2" align="center">TIPO DE ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="2" align="center">AMBITO</th>
					<th class="borderTop borderRight borderLeft borderBottom" colspan="7" align="center">INGRESOS</th>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Hasta 1Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 1Kg y hasta 2Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 2Kg y hasta 3Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 3Kg y hasta 4Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 4Kg y hasta 5Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 5Kg y hasta 30Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TOTAL POR AMBITO</th>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="6">Correspondencia</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="4">ENVIOS INDIVIDUALES</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIL11|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIL12|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA11 equation=$EIL11+$EIL12}${$TA11|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIN21|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIN22|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA21 equation=$EIN21+$EIN22}${$TA21|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE SALIDA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIIS31|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIIS32|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA31 equation=$EIIS31+$EIIS32}${$TA31|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE ENTRADA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIIE41|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EIIE42|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA41 equation=$EIIE41+$EIIE42}${$TA41|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center" rowspan="2">ENVIOS MASIVOS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EML51|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EML52|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA51 equation=$EML51+$EML52}${$TA51|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EMN61|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$EMN62|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA61 equation=$EMN61+$EMN62}${$TA61|number_format:2:",":"."}</td>
				</tr>
				
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="6">Encomiendas</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="4">ENVIOS INDIVIDUALES</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIL11|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIL12|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIL13|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIL14|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA12 equation=$XIL11+$XIL12+$XIL13+$XIL14}${$TA12|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIN21|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIN22|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIN23|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIN24|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA22 equation=$XIN21+$XIN22+$XIN23+$XIN24}${$TA22|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE SALIDA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIS31|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIS32|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIS33|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIS34|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA32 equation=$XIIS31+$XIIS32+$XIIS33+$XIIS34}${$TA32|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE ENTRADA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIE41|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIE42|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIE43|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XIIE44|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA42 equation=$XIIE41+$XIIE42+$XIIE43+$XIIE44}${$TA42|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center" rowspan="2">ENVIOS MASIVOS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XML51|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XML52|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XML53|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XML54|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA52 equation=$XML51+$XML52+$XML53+$XML54}${$TA52|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XMN61|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XMN62|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XMN63|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">${$XMN64|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign=TA62 equation=$XMN61+$XMN62+$XMN63+$XMN64}${$TA62|number_format:2:",":"."}</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center" colspan="3">TOTAL POR PESO</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">
						{math assign=TT1 equation=$EIL11+$EIN21+$EIIS31+$EIIE41+$EML51+$EMN61}${$TT1|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">
						{math assign=TT2 equation=$EIL12+$EIN22+$EIIS32+$EIIE42+$EML52+$EMN62}${$TT2|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">
						{math assign=TT3 equation=$XIL11+$XIN21+$XIIS31+$XIIE41+$XML51+$XMN61}${$TT3|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">
						{math assign=TT4 equation=$XIL12+$XIN22+$XIIS32+$XIIE42+$XML52+$XMN62}${$TT4|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">
						{math assign=TT5 equation=$XIL13+$XIN23+$XIIS33+$XIIE43+$XML53+$XMN63}${$TT5|number_format:2:",":"."}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">
						{math assign=TT6 equation=$XIL14+$XIN24+$XIIS34+$XIIE44+$XML54+$XMN64}${$TT6|number_format:2:",":"."}</td>

					{math assign=TTN equation=$TT1+$TT2+$TT3+$TT4+$TT5+$TT6}
					{math assign=TAN equation=($TA11+$TA21+$TA31+$TA41+$TA51+$TA61)+($TA12+$TA22+$TA32+$TA42+$TA52+$TA62)}
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $TTN neq $TAN}Error en la ecuaciòn, solicite ayuda con el personal de soporte tecnico Si&Si.{else}SUMAS IGUALES: ${$TTN|number_format:2:",":"."}{/if}</td>
				</tr>
			</table>
		</body>
	{/if}
	{if $REPORTE eq 5}
		<body>
			<table width="90%" align="center" id="encabezado" border="0.1 solid">
				<tr><td align="center" colspan="9">ENVIOS DE LOS SERVICIOS DE MENSAJERIA</td></tr>
				<tr><td align="center" colspan="9">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>
			</table>

			<table align="center" id="encabezado"  width="90%" border="0.1 solid">
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">AÑO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TRIMESTRE</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">MES DEL TRIMESTRE</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO SERVICIO DE MENSAJERIA</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">TIPO DE ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">AMBITO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">RANGO PESO DEL ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NUMERO TOTAL DE ENVIOS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">PESO TOTAL ENVIOS</th>
				</tr>
				{foreach name=reporte from=$DETALLES item=r}
					{if $r.mes_trimestre eq 1 || $r.mes_trimestre eq 4 || $r.mes_trimestre eq 7 || $r.mes_trimestre eq 10}
						{assign var=mes_trimestre value=1}
					{elseif $r.mes_trimestre eq 2 || $r.mes_trimestre eq 5 || $r.mes_trimestre eq 8 || $r.mes_trimestre eq 11}
						{assign var=mes_trimestre value=2}
					{elseif $r.mes_trimestre eq 3 || $r.mes_trimestre eq 6 || $r.mes_trimestre eq 9 || $r.mes_trimestre eq 12}
						{assign var=mes_trimestre value=3}
					{/if}
					<tr>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.anio}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.trimestre}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$mes_trimestre}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.tipo_servicio}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.tipo_envio}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.ambito}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.rango_peso}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.cant_ingresos}</td>
						<td class="borderTop borderRight borderLeft borderBottom" align="center">{$r.peso_total|number_format:2:",":"."} Kg</td>
					</tr>
				{/foreach}
			</table>
		</body>
	{/if}
	{if $REPORTE eq 6}
		<body>
			<table width="90%" align="center" id="encabezado" border="0.1 solid">
				<tr><td align="center" colspan="9">ENVIOS DEL SERVICIO DE CORREO</td></tr>
				<tr><td align="center" colspan="9">Rango Inicial : {$DESDE}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$HASTA}</td></tr>
			</table>


			{assign var="A11" value=0}	{assign var="A12" value=0}	{assign var="A13" value=0}	{assign var="A14" value=0}	{assign var="AC1" value=0}	{assign var="AC7" value=0}
			{assign var="A21" value=0}	{assign var="A22" value=0}	{assign var="A23" value=0}	{assign var="A24" value=0}	{assign var="AC2" value=0}	{assign var="AC8" value=0}
			{assign var="A31" value=0}	{assign var="A32" value=0}	{assign var="A33" value=0}	{assign var="A34" value=0}	{assign var="AC3" value=0}	{assign var="AC9" value=0}
			{assign var="A41" value=0}	{assign var="A42" value=0}	{assign var="A43" value=0}	{assign var="A44" value=0}	{assign var="AC4" value=0}	{assign var="AC10" value=0}
			{assign var="A51" value=0}	{assign var="A52" value=0}	{assign var="A53" value=0}	{assign var="A54" value=0}	{assign var="AC5" value=0}	{assign var="AC11" value=0}
			{assign var="A61" value=0}	{assign var="A62" value=0}	{assign var="A63" value=0}	{assign var="A64" value=0}	{assign var="AC6" value=0}	{assign var="AC12" value=0}

			{assign var="B11" value=0}	{assign var="B12" value=0}	{assign var="B13" value=0}	{assign var="B14" value=0}
			{assign var="B21" value=0}	{assign var="B22" value=0}	{assign var="B23" value=0}	{assign var="B24" value=0}
			{assign var="B31" value=0}	{assign var="B32" value=0}	{assign var="B33" value=0}	{assign var="B34" value=0}
			{assign var="B41" value=0}	{assign var="B42" value=0}	{assign var="B43" value=0}	{assign var="B44" value=0}
			{assign var="B51" value=0}	{assign var="B52" value=0}	{assign var="B53" value=0}	{assign var="B54" value=0}
			{assign var="B61" value=0}	{assign var="B62" value=0}	{assign var="B63" value=0}	{assign var="B64" value=0}

			{assign var="B15" value=0}	{assign var="B16" value=0}	{assign var="B17" value=0}	{assign var="B18" value=0}	{assign var="PC1" value=0}	{assign var="PC7" value=0}
			{assign var="B25" value=0}	{assign var="B26" value=0}	{assign var="B27" value=0}	{assign var="B28" value=0}	{assign var="PC2" value=0}	{assign var="PC8" value=0}
			{assign var="B35" value=0}	{assign var="B36" value=0}	{assign var="B37" value=0}	{assign var="B38" value=0}	{assign var="PC3" value=0}	{assign var="PC9" value=0}
			{assign var="B45" value=0}	{assign var="B46" value=0}	{assign var="B47" value=0}	{assign var="B48" value=0}	{assign var="PC4" value=0}	{assign var="PC10" value=0}
			{assign var="B55" value=0}	{assign var="B56" value=0}	{assign var="B57" value=0}	{assign var="B58" value=0}	{assign var="PC5" value=0}	{assign var="PC11" value=0}
			{assign var="B65" value=0}	{assign var="B66" value=0}	{assign var="B67" value=0}	{assign var="B68" value=0}	{assign var="PC6" value=0}	{assign var="PC12" value=0}


			{assign var="TT1" value=0}
			{assign var="TT2" value=0}
			{assign var="TT3" value=0}
			{assign var="TT4" value=0}
			{assign var="TT5" value=0}
			{assign var="TT6" value=0}
			{assign var="TT7" value=0}
			{assign var="TT8" value=0}
			{assign var="TT9" value=0}
			{assign var="TT10" value=0}
			{assign var="TT11" value=0}
			{assign var="TT12" value=0}
 			
			{foreach name=reporte from=$DETALLES item=r}

				{if $r.tipo_servicio eq "ESPECIALIZADA"}

					{if $r.tipo_envio eq "INDIVIDUAL"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso lt 1.1}
								{assign var="A11" value=$A11+1}
								{assign var="A13" value=$A13+$r.peso}
							{elseif $r.peso gt 1}
								{assign var="A12" value=$A12+1}
								{assign var="A14" value=$A14+$r.peso}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso lt 1.1}
								{assign var="A21" value=$A21+1}
								{assign var="A23" value=$A23+$r.peso}
							{elseif $r.peso gt 1}
								{assign var="A22" value=$A22+1}
								{assign var="A24" value=$A24+$r.peso}
							{/if}

						{/if}

					{elseif $r.tipo_envio eq "MASIVO"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso lt 1.1}
								{assign var="A51" value=$A51+1}
								{assign var="A53" value=$A53+$r.peso}
							{elseif $r.peso gt 1}
								{assign var="A52" value=$A52+1}
								{assign var="A54" value=$A54+$r.peso}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso lt 1.1}
								{assign var="A61" value=$A61+1}
								{assign var="A63" value=$A63+$r.peso}
							{elseif $r.peso gt 1}
								{assign var="A62" value=$A62+1}
								{assign var="A64" value=$A64+$r.peso}
							{/if}

						{/if}

					{/if}

				{elseif $r.tipo_servicio eq "EXPRESA"}

					{if $r.tipo_envio eq "INDIVIDUAL"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="B11" value=$B11+1}
								{assign var="B15" value=$B15+$r.peso}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="B12" value=$B12+1}
								{assign var="B16" value=$B16+$r.peso}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="B13" value=$B13+1}
								{assign var="B17" value=$B17+$r.peso}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="B14" value=$B14+1}
								{assign var="B18" value=$B18+$r.peso}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="B21" value=$B21+1}
								{assign var="B25" value=$B25+$r.peso}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="B22" value=$B22+1}
								{assign var="B26" value=$B26+$r.peso}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="B23" value=$B23+1}
								{assign var="B27" value=$B27+$r.peso}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="B24" value=$B24+1}
								{assign var="B28" value=$B28+$r.peso}
							{/if}

						{/if}

					{elseif $r.tipo_envio eq "MASIVO"}

						{if $r.ambito eq "LOCAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="B51" value=$B51+1}
								{assign var="B55" value=$B55+$r.peso}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="B52" value=$B52+1}
								{assign var="B56" value=$B56+$r.peso}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="B53" value=$B53+1}
								{assign var="B57" value=$B57+$r.peso}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="B54" value=$B54+1}
								{assign var="B58" value=$B58+$r.peso}
							{/if}

						{elseif $r.ambito eq "NACIONAL"}

							{if $r.peso gt 2 and $r.peso lt 3.1}
								{assign var="B61" value=$B61+1}
								{assign var="B65" value=$B65+$r.peso}
							{elseif $r.peso gt 3 and $r.peso lt 4.1}
								{assign var="B62" value=$B62+1}
								{assign var="B66" value=$B66+$r.peso}
							{elseif $r.peso gt 4 and $r.peso lt 5.1}
								{assign var="B63" value=$B63+1}
								{assign var="B67" value=$B67+$r.peso}
							{elseif $r.peso gt 5 and $r.peso lt 30.1}
								{assign var="B64" value=$B64+1}
								{assign var="B68" value=$B68+$r.peso}
							{/if}

						{/if}

					{/if}

				{/if}

			{/foreach}
			<table align="center" id="encabezado"  width="90%" border="0.1 solid">
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="2" align="center">TIPO DE SERVICIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="2" align="center">TIPO DE ENVIO</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="2" align="center">AMBITO</th>
					<th class="borderTop borderRight borderLeft borderBottom" colspan="6" align="center">Nùmero Total de Envios</th>
					<th class="borderTop borderRight borderLeft borderBottom" colspan="6" align="center">Peso Total de los Envìos</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center" colspan="2">TOTAL POR AMBITO</th>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Hasta 1Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 1Kg y hasta 2Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 2Kg y hasta 3Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 3Kg y hasta 4Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 4Kg y hasta 5Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 5Kg y hasta 30Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Hasta 1Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 1Kg y hasta 2Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 2Kg y hasta 3Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 3Kg y hasta 4Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 4Kg y hasta 5Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Mayor a 5Kg y hasta 30Kg</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Cantidad</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">Peso</th>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="6">Correspondencia</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="4">ENVIOS INDIVIDUALES</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A11}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A12}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A13} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A14} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC1" equation=$A11+$A12}{$AC1}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC1" equation=$A13+$A14}{$PC1} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A21}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A22}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A23} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A24} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC2" equation=$A21+$A22}{$AC2}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC2" equation=$A23+$A24}{$PC2} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE SALIDA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A31}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A32}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A33} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A34} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC3" equation=$A31+$A32}{$AC3}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC3" equation=$A33+$A34}{$PC3} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE ENTRADA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A41}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A42}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A43} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A44} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC4" equation=$A41+$A42}{$AC4}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC4" equation=$A43+$A44}{$PC4} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center" rowspan="2">ENVIOS MASIVOS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A51}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A52}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A53} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A54} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC5" equation=$A51+$A52}{$AC5}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC5" equation=$A53+$A54}{$PC5} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A61}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A62}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A63} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$A64} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"></td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC6" equation=$A61+$A62}{$AC6}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC6" equation=$A63+$A64}{$PC6} Kg</td>
				</tr>
				
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="6">Encomiendas</th>
					<th class="borderTop borderRight borderLeft borderBottom" rowspan="4">ENVIOS INDIVIDUALES</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B11}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B12}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B13}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B14}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B15} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B16} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B17} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B18} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC7" equation=$B11+$B12+$B13+$B14}{$AC7}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC7" equation=$B15+$B16+$B17+$B17}{$PC7} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B21}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B22}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B23}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B24}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B25} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B26} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B27} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B28} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC8" equation=$B21+$B22+$B23+$B24}{$AC8}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC8" equation=$B25+$B26+$B27+$B28}{$PC8} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE SALIDA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B31}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B32}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B33}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B34}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B35} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B36} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B37} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B38} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC9" equation=$B31+$B32+$B33+$B34}{$AC9}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC9" equation=$B35+$B36+$B37+$B38}{$PC9} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">INTERNACIONAL DE ENTRADA</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B41}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B42}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B43}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B44}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B45} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B46} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B47} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B48} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC10" equation=$B41+$B42+$B43+$B44}{$AC10}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC10" equation=$B45+$B46+$B47+$B48}{$PC10} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center" rowspan="2">ENVIOS MASIVOS</th>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">LOCAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B51}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B52}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B53}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B54}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B55} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B56} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B57} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B58} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC11" equation=$B51+$B52+$B53+$B54}{$AC11}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC11" equation=$B55+$B56+$B57+$B58}{$PC11} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center">NACIONAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B61}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B62}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B63}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B64}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center" bgcolor="grey"> </td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B65} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B66} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B67} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{$B68} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="AC12" equation=$B61+$B62+$B63+$B64}{$AC12}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="PC12" equation=$B65+$B66+$B67+$B68}{$PC12} Kg</td>
				</tr>
				<tr>
					<th class="borderTop borderRight borderLeft borderBottom" align="center" colspan="3">TOTAL</th>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT1" equation=$A11+$A21+$A31+$A41+$A51+$A61}{$TT1}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT2" equation=$A12+$A22+$A32+$A42+$A52+$A62}{$TT2}</td>

					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT3" equation=$B11+$B21+$B31+$B41+$B51+$B61}{$TT3}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT4" equation=$B21+$B22+$B23+$B24+$B25+$B26}{$TT4}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT5" equation=$B13+$B23+$B33+$B43+$B53+$B63}{$TT5}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT6" equation=$B14+$B24+$B34+$B44+$B54+$B64}{$TT6}</td>

					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT7" equation=$A13+$A23+$A33+$A43+$A53+$A63}{$TT7} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT8" equation=$A14+$A24+$A34+$A44+$A54+$A64}{$TT8} Kg</td>

					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT9" equation=$B51+$B52+$B53+$B54+$B55+$B56}{$TT9} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT10" equation=$B61+$B62+$B63+$B64+$B65+$B66}{$TT10} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT12" equation=$B17+$B27+$B37+$B47+$B57+$B67}{$TT12} Kg</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{math assign="TT11" equation=$B18+$B28+$B38+$B48+$B58+$B68}{$TT11} Kg</td>

					{math assign="TN" equation=$TT1+$TT2+$TT3+$TT4+$TT5+$TT6}
					{math assign="TP" equation=$TT7+$TT8+$TT9+$TT10+$TT11+$TT12}
					{math assign="AC" equation=($AC1+$AC2+$AC3+$AC4+$AC5+$AC6)+($AC7+$AC8+$AC9+$AC10+$AC11+$AC12)}
					{math assign="PC" equation=($PC1+$PC2+$PC3+$PC4+$PC5+$PC6)+($PC7+$PC8+$PC9+$PC10+$PC11+$PC12)}
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $TN neq $AC}Error en la ecuaciòn, solicite ayuda con el personal de soporte tecnico Si&Si.{else}SUMAS IGUALES: {math equation=($TN+$AC)/2}{/if}</td>
					<td class="borderTop borderRight borderLeft borderBottom" align="center">{if $TP neq $PC}Error en la ecuaciòn, solicite ayuda con el personal de soporte tecnico Si&Si.{else}SUMAS IGUALES: {math equation=($PC+$TP)/2}  Kg{/if}</td>
				</tr>
			</table>
		</body>
	{/if}
</html>
