<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
		{$TABLEGRIDCSS}
		{$TITLETAB}
	</head>
	<body {if $PRINTERS eq 'si'} onLoad="javascript:window.print()" {/if}>
		<div align="center">
        	
			<table width="100%" style="font-size:13px;">
				<tr>
					<td colspan="10"><strong>FACTURAS PENDIENTES POR AUTORIZAR DESDE: {$DESDE} HASTA: {$HASTA}</strong></td>
				</tr>
				<tr style="font-weight:bold;">
					<td><input type="checkbox" name="all" id="all" value="" /></td>
                    <td>NO.</td>
					<td>PROVEEDOR</td>
					<td>COD. FACT</td>
                    <td>FECHA FACTURA</td>
					<td>VENC. FACTURA</td> 
                    <td>CONCEPTO</td> 
                    <td>VALOR</td> 
                    <td>ABONOS</td> 
                    <td>SALDO</td> 
				</tr>
	                {if count($DATA)>0}
                
						{foreach name=reporte from=$DATA item=k}
							{if $k.saldo gt 0}
                            <tr>
                                <td><input type="checkbox" onClick="comparar();" name="factura_proveedor_id" id="factura_proveedor_id" value="{$k.factura_proveedor_id}" /></td>
                                <td>{$k.consecutivo}</td>
                                <td align="left">{$k.proveedor}</td>
                                <td align="left">{$k.codfactura_proveedor}</td>
                                <td align="left">{$k.fecha_factura_proveedor}</td>
                                <td align="left">{$k.vence_factura_proveedor}</td>                                
                                <td align="left">{$k.concepto_factura_proveedor}</td>
                                <td align="right">&nbsp;${$k.valor_factura_proveedor|number_format:2:",":"."}</td>
                                <td align="right">&nbsp;${$k.abonos|number_format:2:",":"."}</td>
                                <td align="right"><input type="input" size="8" name="saldo" id="saldo"  style="text-align:right; vertical-align:middle; font-family:serif; font-size:13px"value="${$k.saldo|number_format:2:",":"."}" />&nbsp;</td>                                
                            </tr>
                            {/if}
                        {/foreach}
                    {else}
                    	<tr><td colspan="9">No existen Facturas Pendientes de Autorizar.</td></tr>   
                    {/if}
                    
			</table>
			<br><br>
            <!--
			<table width="100%">
				<tr>
					<td colspan="4">ACTIVOS QUE NO HAN SIDO DEPRECIADOS EN ESTA TRANSACCION</td>
				</tr>
				<tr>
					<td>CODIGO ACTIVO</td>
					<td>NOMBRE</td>
					<td>PLACA FISICO</td>
					<td>CLASE DE ACTIVO</td>
				</tr>
				{foreach name=reporte from=$ACTIVOS item=r}
					{foreach name=reporte2 from=$r item=k}
						<tr>
							<td>{$k.codigo_item}</td>
							<td>{$k.nombre}</td>
							<td>{$k.placa_fisico}</td>
							<td>{$k.clase_activo}</td>
						</tr>
					{/foreach}
				{/foreach}
			</table>-->
		</div>
	</body>
</html>