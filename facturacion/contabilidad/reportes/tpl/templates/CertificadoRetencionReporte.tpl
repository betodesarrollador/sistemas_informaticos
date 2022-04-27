<html>
<head>
    <title>Certificado de Retenci&oacute;n</title>
    {$JAVASCRIPT}
    {$CSSSYSTEM} 	
</head>
  
<body onLoad="javascript:window.print()">       
    <table style="font-size:12px; font-family:Times New Roman, Times, serif">
        <tr>
        	<td align="center">{$c.nombre_certificado}<br>{$c.empresa} {$c.oficina}<br>{$c.direccion}<br>Nit.{$c.nit_empresa}</td>
        </tr>                        
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td align="right">NO.{$c.numero}</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
		</tr>
        <tr>
            <td align="justify">POR EL PERIODO GRAVABLE COMPRENDIDO DESDE: <strong>{$desde}</strong> HASTA: <strong>{$hasta}</strong>,SE CONSIGN&Oacute; EN {$c.entidad}, LA SUMA DE {$c.total_letras|upper} (${$c.total|number_format:0:",":"."})</td>
        </tr>                
        <tr>
        	<td>&nbsp;</td>
        </tr>        
        <tr>
        	<td align="left">PRACTICADA A: {$c.tercero}, Identificado con Documento No.{$c.identificacion}</td>
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
                <table style="font-size:12px; font-family:Times New Roman, Times, serif" align="center" border="1" cellpadding="1" cellspacing="0" width="80%">
                    <tr align="center">
                        <td><b>CONCEPTO</b></td>
                        <td><b>BASE GRAVABLE</b></td>
                        <td><b>RETENCI&Oacute;N</b></td>
                    </tr>	
                    {foreach name=conceptos from=$c.movimientos item=m}
                    <tr>
                        <td>{$m.nombre}</td>
                        <td align="right">${$m.base|number_format:0:",":"."}</td>
                        <td align="right">${$m.total|number_format:0:",":"."}</td>
                    </tr>	
                    {/foreach}
                    <tr>
                    	<td>TOTAL</td>
                        <td align="right">${$c.base|number_format:0:",":"."}</td>
                        <td align="right">${$c.total|number_format:0:",":"."}</td>
                    </tr>	             
                </table>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
		</tr>
        <tr>
            <td>
                <table style="font-size:12px; font-family:Times New Roman, Times, serif" width="100%" cellpadding="0" >
                    <tr>
                        <td width="30%">{$c.ciudad}&nbsp;-&nbsp;{$c.fecha_texto|upper}</td>
                        <td>&nbsp;</td>
                        <td width="30%">Decreto {$c.decreto}</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>                          
                    <tr>
						<td colspan="2">&nbsp;</td>
                        <td width="30%" align="center">________________________</td>
                    </tr>
                    <tr>
						<td colspan="2">&nbsp;</td>                    
                        <td width="30%" align="center">FIRMA AGENTE RETENEDOR</td>
                    </tr>
                </table>
            </td>
        </tr>                                
    </table>
</body>
</html>