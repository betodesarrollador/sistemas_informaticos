<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$TABLEGRIDJS}
		{$CSSSYSTEM}
		{$TABLEGRIDCSS}
		{$TITLETAB}
	</head>
	<body>
		<form>
			<table align="center" width="100%" border="1" id="tableTarifasCliente" name="tableTarifasCliente">
				<tr>
					{assign var="k" value=$DETALLESENVIOS|@count}
					{assign var="k" value=$k+1}
					<td rowspan="{$k}">AÑO:<br>
						<select  class="required" id="periodo_contable_id" name="periodo_contable_id" style="width: 60px;">
							<option value="">...SELECCIONE...</option>
							{foreach name=periodos from=$PERIODOS item=p}
								<option value="{$p.periodo_contable_id}" selected>{$p.anio}</option>
							{/foreach}
						</select>
					</td>
					<td rowspan="{$k}">
						24 HORAS
						<input type="text" id="tipo_servicio_mensajeria_id" name="tipo_servicio_mensajeria_id" value="3" hidden>
						<input type="text" id="cliente_id" name="cliente_id" value="{$CLIENTEID}" hidden>
					</td>
					<td></td>
					<td>Sobre </td>
					<td>Kg Inicial</td>
                    <td>Kg Adicional</td>
					<td>Min Declarado</td>
					<td>Tasa Seguro</td>
					<td>Guardar</td>
				</tr>
				{foreach name=detalles from=$DETALLESENVIOS item=d}
					<tr>
						<td>
							<input type="text" id="tipo_envio_id" name="tipo_envio_id" value="{$d.tipo_envio_id}" hidden>
							<input type="text" id="tarifas_mensajeria_cliente_id" name="tarifas_mensajeria_cliente_id" value="{$d.tarifas_mensajeria_cliente_id}" hidden>
							<input type="text" id="nombre_tipo_envio" name="nombre_tipo_envio" value="{$d.nombre}" readonly>
						</td>
						<td>$
							<input type="text" id="min_base_ini" name="min_base_ini" value="{if $d.min_base_ini neq ''}{$d.min_base_ini}{else}0{/if}" hidden>
							<input type="text" class="required numeric" id="vr_kg_inicial_min" name="vr_kg_inicial_min" value="{if $d.min_base_ini neq ''}{$d.min_base_ini}{else}0{/if}" {if $d.min_base_ini eq 0 OR $d.min_base_ini eq ''}disabled{/if} size="12">
						</td>
						<td>$
							<input type="text" id="min_base_kg_ini" name="min_base_kg_ini" value="{if $d.min_base_kg_ini neq ''}{$d.min_base_kg_ini}{else}0{/if}" hidden>
							<input type="text" class="required numeric" id="vr_kg_inicial_max" name="vr_kg_inicial_max" value="{if $d.min_base_kg_ini neq ''}{$d.min_base_kg_ini}{else}0{/if}" {if $d.min_base_kg_ini eq 0 OR $d.min_base_kg_ini eq ''}disabled{/if} size="12">
						</td>
						<td>$
							<input type="text" id="min_base_adi" name="min_base_adi" value="{if $d.min_kg_adicional neq ''}{$d.min_kg_adicional}{else}0{/if}" hidden>
							<input type="text" class="required numeric" id="vr_kg_adicional_min" name="vr_kg_adicional_min" value="{if $d.min_kg_adicional neq ''}{$d.min_kg_adicional}{else}0{/if}" {if $d.min_kg_adicional eq 0 OR $d.min_kg_adicional eq ''}disabled{/if}  size="12">
						</td>
						<td>$
							<input type="text" class="numeric" id="vr_min_dec_base" name="vr_min_dec_base" value="{if $d.vr_min_declarado neq ''}{$d.vr_min_declarado}{else}0{/if}" hidden>
							<input type="text" class="required numeric" id="vr_min_declarado" name="vr_min_declarado" value="{if $d.vr_min_declarado neq ''}{$d.vr_min_declarado}{else}0{/if}" {if $d.vr_min_declarado eq 0 OR $d.vr_min_declarado eq ''}disabled{/if} size="12">
						</td>
						<td>
							<input type="text" class="numeric" id="impuesto_base" name="impuesto_base" value="{if $d.porcentaje_seguro neq ''}{$d.porcentaje_seguro}{else}0{/if}" hidden>
							<input type="text" class="required numeric" id="porcentaje_seguro" name="porcentaje_seguro" value="{if $d.porcentaje_seguro neq ''}{$d.porcentaje_seguro}{else}0{/if}" {if $d.porcentaje_seguro eq 0 OR $d.porcentaje_seguro eq ''}disabled{/if} size="4">
						</td>
						<td>
							<a name="saveDetalleTarifaCliente">
								<img id="guarda" name="guarda" src="/velotax/framework/media/images/grid/save.png" />
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
		</form>
	</body>
</html>