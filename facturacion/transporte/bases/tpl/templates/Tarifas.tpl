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
			<table align="center" width="100%" border="1" >
				<tr>
					{assign var="k" value=$DETALLESENVIOS|@count}
					{assign var="k" value=$k+1}
					<td rowspan="{$k}">AÑO: <br>
						<select  class="required" id="periodo" name="periodo" style="width: 80px;">
							<option value="">...SELECCIONE...</option>
							{foreach name=periodos from=$PERIODOS item=p}
								<option value="{$p.value}" {if $p.value eq $ACTUAL }selected{/if}>{$p.text}</option>
							{/foreach}
						</select>
						<input type="text" id="cliente_id" name="cliente_id" value="{$CLIENTEID}" hidden>
						<input type="text" id="tercero_id" name="tercero_id" value="{$TERCEROID}" hidden>
                        
					</td>
					<td></td>
					<td>Porcentaje</td>
					<td>Minimo Despacho</td>
                    
                    <td>Min Kilos Despacho</td>
                    <td>Min Kilos Unidad</td>  
                    <td>Min  Unidades</td>                    
                    
                    <td>Precio Unidad 1</td> 
                    <td>Hasta</td> 
                    <td>Precio Unidad 2</td> 
                    
                    <td>Tasa Seguro</td>
                    <td>Minimo Declarado</td>
					<td>Guardar</td>
				</tr>
				{foreach name=detalles from=$DETALLESENVIOS item=d}
					<tr>
						<td>
							<input type="hidden" id="convencion_id" name="convencion_id" value="{$d.convencion_id}" >
							<input type="hidden" id="tarifas_destino_cliente_id" name="tarifas_destino_cliente_id" value="{$d.tarifas_destino_cliente_id}" >                            
							<input type="text" id="nombre_tipo_envio" name="nombre_tipo_envio" value="{$d.nombre}" readonly>
						</td>
						<td>%<input type="text" size="3" maxlength="2" class="numeric" id="porcentaje" name="porcentaje" value="{if $d.porcentaje neq ''}{$d.porcentaje}{else}0{/if}" >
                            <select  class="required" id="tipo" name="tipo" style="width: 100px;">
                                    <option value="D"  {if $d.tipo eq 'D' }selected{/if}>DESCUENTO</option>
                                    <option value="I" {if $d.tipo eq 'I' }selected{/if} >INCREMENTO</option>
                            </select>
                            
						</td>
						<td>$<input type="text" size="5" maxlength="12" class="numeric" id="minimo_despacho" name="minimo_despacho" value="{if $d.minimo_despacho neq ''}{$d.minimo_despacho}{else}0{/if}" ></td>

						<td><input type="text" size="4" maxlength="12" class="numeric" id="minimo_kilo" name="minimo_kilo" value="{if $d.minimo_kilo neq ''}{$d.minimo_kilo}{else}0{/if}" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="minimo_kilo_unidad" name="minimo_kilo_unidad" value="{if $d.minimo_kilo_unidad neq ''}{$d.minimo_kilo_unidad}{else}0{/if}" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="minimo_unidad" name="minimo_unidad" value="{if $d.minimo_unidad neq ''}{$d.minimo_unidad}{else}0{/if}" ></td>
                        
                        <!-- /////////////////////-->
                        
                        <td><input type="text" size="4" maxlength="12" class="numeric" id="precio1" name="precio1" value="{if $d.precio1 neq ''}{$d.precio1}{else}0{/if}" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="hasta" name="hasta" value="{if $d.hasta neq ''}{$d.hasta}{else}0{/if}" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="precio2" name="precio2" value="{if $d.precio2 neq ''}{$d.precio2}{else}0{/if}" ></td>
                        
                     <!-- /////////////////////-->
                     
						<td>%<input type="text" size="2" maxlength="3" class="numeric" id="tasa_seguro" name="tasa_seguro" value="{if $d.tasa_seguro neq ''}{$d.tasa_seguro}{else}0{/if}" ></td>
                        
                        
						<td>$<input type="text" size="5" maxlength="12" class="numeric" id="minimo_declarado" name="minimo_declarado" value="{if $d.minimo_declarado neq ''}{$d.minimo_declarado}{else}0{/if}" ></td>

						<td>
							<a name="saveDetalleTarifaCliente">
								<img id="guarda" name="guarda" src="../../../framework/media/images/grid/save.png" />
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
		</form>
	</body>
</html>