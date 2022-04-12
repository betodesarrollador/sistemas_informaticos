<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
		{$TABLEGRIDCSS}
		{$TITLETAB}
	</head>
	<body {if $PRINTERS eq 'si'} onLoad="javascript:window.print()" {/if}>
    <fieldset>
    {$FORM1}
		<div align="center">
        	
			<table width="100%" style="font-size:13px;">
				<tr>
					<td colspan="5"><strong>REMESAS</strong></td>
                    <td></td> 
                    <td style="font-weight:bold;">&nbsp; &nbsp; Factura a Relacionar : &nbsp;<input type="text"size="6"  autocomplete="off" onkeypress=';ajax_suggest(this,event,"relacion_factura","null",null,null,null)' title="relacion_factura_id" name="relacion_factura" id="relacion_factura" value="" class="required saltoscrolldetalle" />     
                   <input type="hidden" size="6"  name="relacion_factura_id" id="relacion_factura_id" value="" class="required integer" /></td>
				</tr>
				<tr style="font-weight:bold;">
					<td>CONSECUTIVO</td>
                    <td>FECHA REMESA</td>
					<td>TIPO REMESA</td>
					<td>CLIENTE</td>
                    <td>FACTURA NO.</td>
					<td>ESTADO</td>                   
					<td>Seleccionar todo : &nbsp;<input size="6" type="checkbox" name="checkedAll" id="checkedAll"  value=""></td>
					<!--<td>CONCEPTO</td>
					<td>TIPO DEPRECIACION</td>
					<td>DOC CONTABLE</td>-->
				</tr>
	                {if count($DATA)>0}
                
						{foreach name=reporte from=$DATA item=k}

                            <tr>
                                <td>&nbsp;{$k.numero_remesa}</td>
                                <td>{$k.fecha_remesa}</td>
                                <td>&nbsp;{$k.paqueteo}</td>
                                <td>&nbsp;{$k.cliente_remesa}</td>
                                <td>&nbsp;{$k.factura_remesa}</td>
                                <td align="left">&nbsp;{$k.estado}</td>
                                <td  colspan="2 "align="center"><input type="checkbox" name="procesar" value="{$k.remesa_id}"></input></td>
                                <!--<td align="right">&nbsp;${$k.valor_real|number_format:2:",":"."}</td>
                                <td align="left">&nbsp;{$k.concepto}</td>
                                <td>&nbsp;{$k.nombre_depreciacion}</td>
                                <!--<td>{$k.encabezado_registro_id}</td>-->
                            </tr>
                        {/foreach}
                    {else}
                    	<tr><td colspan="11">No existen Remesas asociadas a esa Solcitud en las Fechas Seleccionadas.</td></tr>   
                    {/if}
                    
			</table>
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
        </fieldset>
        {$FORM1END}
	</body>
</html>