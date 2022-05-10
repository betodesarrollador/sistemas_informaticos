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
						<select  class="required" id="periodo_contable_id" name="periodo_contable_id" style="width: 80px;">
							<option value="">...SELECCIONE...</option>
							{foreach name=periodos from=$PERIODOS item=p}
								<option value="{$p.periodo_contable_id}" selected>{$p.anio}</option>
							{/foreach}
						</select>
					</td>
					<td rowspan="{$k}">
						CORREO <br> MASIVO
						<input type="text" id="tipo_servicio_mensajeria_id" name="tipo_servicio_mensajeria_id" value="2" hidden>
						<input type="text" id="cliente_id" name="cliente_id" value="{$CLIENTEID}" hidden>
					</td>
                    <td>Tipo</td>
					<td>Rango</td>
					<td>Valor minimo</td>
					<td>Valor maximo</td>
					<td>Valor Minimo Declarado</td>
					<td>Tasa Seguro</td>
					<td>Guardar</td>
				</tr>
				{foreach name=detalles from=$DETALLESENVIOS item=d}
					<tr>
                    	<td>
                        	<input type="text" id="tipo_envio_id" name="tipo_envio_id" value="{$d.tipo_envio_id}" hidden>
                            <input type="text" id="tarifas_masivo_id" name="tarifas_masivo_id" value="{$d.tarifas_masivo_id}" hidden>
							<input type="text" id="tarifas_masivo_cliente_id" name="tarifas_masivo_cliente_id" value="{$d.tarifas_masivo_cliente_id}" hidden>
                            <input type="text" id="nombre" name="nombre" value="{$d.nombre}" >
                        </td>
						<td>
                            <input type="text" id="rangos" name="rangos" value="{$d.rangos}" >
						</td>
						<td>$
							<input type="text" id="base_ini" name="base_ini" value="{if $d.base_ini neq ''}{$d.base_ini}{else}0{/if}" hidden>
							<input type="text" class="required numeric" id="valor_min" name="valor_min" value="{if $d.base_ini_cliente neq ''}{$d.base_ini_cliente}{else}{$d.base_ini}{/if}" {if $d.base_ini eq 0 OR $d.base_ini eq ''}disabled{/if} size="12">
						</td>
						<td>$
							<input type="text" id="base_max" name="base_max" value="{if $d.base_max neq ''}{$d.base_max}{else}0{/if}" hidden>
							<input type="text" class="required numeric" id="valor_max" name="valor_max" value="{if $d.base_max_cliente neq ''}{$d.base_max_cliente}{else}{$d.base_max}{/if}" {if $d.base_max eq 0 OR $d.base_max eq ''}disabled{/if} size="12">
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