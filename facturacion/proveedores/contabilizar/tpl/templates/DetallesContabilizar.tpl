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
					<td colspan="11"><strong>CAUSACIONES Y PAGOS PENDIENTES POR CONTABILIZAR</strong></td>
				</tr>
				<tr style="font-weight:bold;">
					<td><input type="checkbox" name="all" id="all" value="" /></td>
					<td>TIPO</td>
                    <td>FECHA</td>
					<td>VENCIMIENTO</td>
                    <td># REFERENCIA</td>
                    <td>PROVEEDOR</td>
					<td>VALOR</td> 
                    <td>TIPO DOCUMENTO</td> 
				</tr>
	                {if count($DATA)>0}
                
						{foreach name=reporte from=$DATA item=k}

                            <tr>
                                <td><input type="checkbox" onClick="comparar();" name="id" id="id" value="{$k.id}-{$k.tipo}" /></td>
                                <td align="left">&nbsp;{$k.tipo}</td>
                                <td align="center">{$k.fecha}</td>
                                <td align="center">{$k.vencimiento}</td>
								<td align="left">&nbsp;{$k.numero_referencia}</td>                                
                                <td align="left">&nbsp;{$k.proveedor}</td>
                                <td align="right">&nbsp;${$k.valor|number_format:2:",":"."}&nbsp;</td>
                                <td align="left">&nbsp;{$k.tipo_documento}</td>
                            </tr>
                        {/foreach}
                    {else}
                    	<tr><td colspan="11">No existen Registros Pendientes de Contabilizar</td></tr>   
                    {/if}
                    
			</table>
		</div>
	</body>
</html>