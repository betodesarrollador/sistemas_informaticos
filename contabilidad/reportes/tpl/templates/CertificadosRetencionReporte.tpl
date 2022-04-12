<html>
<head>
    <title>Certificado Retenci&oacute;n</title>
    {$JAVASCRIPT}
    {$CSSSYSTEM} 	
</head>
  
<body onLoad="this.print()">
    {if count($CERTIFICADOS) > 0}
    {foreach name=certificados from=$CERTIFICADOS item=c}
    <table style="font-size:12px; font-family:'Times New Roman', Times, serif" align="center">
        <tr>
        	<td align="center">
            	<table style="font-size:12px; font-family:'Times New Roman', Times, serif" border="0" width="100%">
					<tr>
                    	<td width="30%">&nbsp;</td>
                        <td width="50%"></td>
                        <td width="20%"><img src="{$logo}" alt="logo"></td>
                    </tr>                
                	<tr>
                    	<td width="30%">&nbsp;</td>
                        <td width="50%" align="center">{$c.nombre_certificado}<br>{$c.empresa} - {$c.oficina}<br>{$c.direccion}<br>NIT.{$c.nit_empresa}</td>
                        <td width="20%"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td align="right">Certificado NO.{$c.numero}</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td align="justify">POR EL PERIODO GRAVABLE COMPRENDIDO DESDE: <strong>{$desde}</strong> HASTA: <strong>{$hasta}</strong>,SE CONSIGN&Oacute; EN {$c.entidad}, {$c.ciudad}, LA SUMA DE {$c.total_letras|upper} (${$c.total|number_format:0:",":"."})</td>
        </tr>                
        <tr>
        	<td>&nbsp;</td>
        </tr>        
        <tr>
        	<td align="left">PRACTICADA A : {$c.tercero}, Identificado con Documento No. {$c.identificacion}</td>
        </tr>                
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td align="left">CORRESPONDIENTE A LOS SIGUIENTES CONCEPTOS :</td>
        </tr>                
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                <table style="font-size:12px; font-family:'Times New Roman', Times, serif" align="center" border="1" cellpadding="1" cellspacing="0" width="80%">
                    <tr align="center">
                        <td><b>CONCEPTO</b></td>
                        <td><b>BASE GRAVABLE</b></td>
                        <td><b>RETENCI&Oacute;N</b></td>
                    </tr>	
                    {assign var="acumula_base" value="0"}
                    {assign var="acumula_retencion" value="0"}
                    {foreach name=conceptos from=$c.movimientos item=m}
                    <tr>
                        <td>{$m.nombre}</td>
                        <td align="right">${$m.base|number_format:0:",":"."}</td>
                        <td align="right">${$m.saldo|number_format:0:",":"."}</td>
                    </tr>	
                    {math assign="acumula_base" equation="x + y" x=$acumula_base y=$m.base}
                    {math assign="acumula_retencion" equation="x + y" x=$acumula_retencion y=$m.saldo}
                    {/foreach}
                    <tr>
                        <td>TOTAL</td><td align="right">${$acumula_base|number_format:0:",":"."}</td>
                        <td align="right">${$acumula_retencion|number_format:0:",":"."}</td>
                    </tr>	             
                </table>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
	        <td>
    		    <table style="font-size:12px; font-family:'Times New Roman', Times, serif" width="100%">
				    <tr>
					    <td width="30%">{$c.ciudad} - {$c.fecha_texto}</td>
                        <td>&nbsp;</td>
                        <td width="30%">Decreto {$c.decreto}</td>
                    </tr>
					<tr>
                    	<td width="30%">&nbsp;</td>
					</tr>                          
					<tr>
                        <td colspan="2" width="30%">&nbsp;</td>
                        <td width="30%" align="center">________________________</td>
                    </tr>
                    <tr>
                        <td colspan="2" width="30%">&nbsp;</td>
                        <td width="30%" align="center">FIRMA AGENTE RETENEDOR</td>
                    </tr>
				</table>
			</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>                                
    </table>
    <br>
    <br>
    <table style="font-size:12px; font-family:'Times New Roman', Times, serif" align="center">
        <tr>
        	<td align="center">
            	<table style="font-size:12px; font-family:'Times New Roman', Times, serif" border="0" width="100%">
					<tr>
                    	<td width="30%">&nbsp;</td>
                        <td width="50%"></td>
                        <td width="20%"><img src="{$logo}" alt="logo"></td>
                    </tr>                
                	<tr>
                    	<td width="30%">&nbsp;</td>
                        <td width="50%" align="center">{$c.nombre_certificado}<br>{$c.empresa} - {$c.oficina}<br>{$c.direccion}<br>NIT.{$c.nit_empresa}</td>
                        <td width="20%"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td align="right">Certificado NO.{$c.numero}</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td align="justify">POR EL PERIODO GRAVABLE COMPRENDIDO DESDE: <strong>{$desde}</strong> HASTA: <strong>{$hasta}</strong>,SE CONSIGN&Oacute; EN {$c.entidad}, {$c.ciudad}, LA SUMA DE {$c.total_letras|upper} (${$c.total|number_format:0:",":"."})</td>
        </tr>                
        <tr>
        	<td>&nbsp;</td>
        </tr>        
        <tr>
        	<td align="left">PRACTICADA A : {$c.tercero}, Identificado con Documento No. {$c.identificacion}</td>
        </tr>                
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td align="left">CORRESPONDIENTE A LOS SIGUIENTES CONCEPTOS :</td>
        </tr>                
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                <table style="font-size:12px; font-family:'Times New Roman', Times, serif" align="center" border="1" cellpadding="1" cellspacing="0" width="80%">
                    <tr align="center">
                        <td><b>CONCEPTO</b></td>
                        <td><b>BASE GRAVABLE</b></td>
                        <td><b>RETENCI&Oacute;N</b></td>
                    </tr>	
                    {assign var="acumula_base" value="0"}
                    {assign var="acumula_retencion" value="0"}
                    {foreach name=conceptos from=$c.movimientos item=m}
                    <tr>
                        <td>{$m.nombre}</td>
                        <td align="right">${$m.base|number_format:0:",":"."}</td>
                        <td align="right">${$m.saldo|number_format:0:",":"."}</td>
                    </tr>	
                    {math assign="acumula_base" equation="x + y" x=$acumula_base y=$m.base}
                    {math assign="acumula_retencion" equation="x + y" x=$acumula_retencion y=$m.saldo}
                    {/foreach}
                    <tr>
                        <td>TOTAL</td><td align="right">${$acumula_base|number_format:0:",":"."}</td>
                        <td align="right">${$acumula_retencion|number_format:0:",":"."}</td>
                    </tr>	             
                </table>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
	        <td>
    		    <table style="font-size:12px; font-family:'Times New Roman', Times, serif" width="100%">
				    <tr>
					    <td width="30%">{$c.ciudad} - {$c.fecha_texto}</td>
                        <td>&nbsp;</td>
                        <td width="30%">Decreto {$c.decreto}</td>
                    </tr>
					<tr>
                    	<td width="30%">&nbsp;</td>
					</tr>                          
					<tr>
                        <td colspan="2" width="30%">&nbsp;</td>
                        <td width="30%" align="center">________________________</td>
                    </tr>
                    <tr>
                        <td colspan="2" width="30%">&nbsp;</td>
                        <td width="30%" align="center">FIRMA AGENTE RETENEDOR</td>
                    </tr>
				</table>
			</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>                                
    </table>    
    {/foreach}  
    
    {/if}
</body>
</html>