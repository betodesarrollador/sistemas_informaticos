<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Impresi&oacute;n Liquidacion Guias</title>
{$CSSSYSTEM}
</head>

<body>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width="100%" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid; border-right:1px solid">
            <table width="100%" border="0">
                <tr>
                    <td width="30%" align="center"><img src="{$DATOSENCABEZADO.logo}" width="160" height="42" /></td>
                    <td width="70%" align="center"><strong>{$DATOSENCABEZADO.razon_social_emp}</strong><br />{$DATOSENCABEZADO.sigla_emp}<br />
                    &nbsp;{$DATOSENCABEZADO.tipo_identificacion_emp}: &nbsp;{$DATOSENCABEZADO.numero_identificacion_emp}<br /> Direcci&oacute;n: {$DATOSENCABEZADO.direccion_emp} <br />  {$DATOSENCABEZADO.ciudad_emp} </td>
                </tr>
            </table>
		</td>                    
    </tr>
    <tr>
        <td width="100%" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid; border-right:1px solid">
            <table width="100%" border="0">
                <tr>
                    <td width="100%" colspan="2" height="20" align="center"><strong>LIQUIDACION GUIAS NO. : {$DATOSENCABEZADO.consecutivo}</strong></td>
              	</tr>
				<tr>
                  	<td width="15%" height="20" align="left">Cliente :</td>
                  	<td width="85%" align="left">{$DATOSENCABEZADO.nombre_cliente}</td>
                </tr>
				<tr>
                  	<td width="15%" height="20" align="left">Fecha Inicial :</td>
                  	<td width="85%" align="left">{$DATOSENCABEZADO.fecha_inicial}</td>
                </tr>                
				<tr>
                  	<td width="15%" height="20" align="left">Fecha Final :</td>
                    <td width="85%" align="left">{$DATOSENCABEZADO.fecha_final}</td>
                </tr> 
				<tr>
                    <td width="15%" height="20" align="left">Valor :</td>
                    <td width="85%" align="left">{$DATOSENCABEZADO.valor|number_format:2:',':'.'}</td>
                </tr>
				<tr>
                    <td width="15%" height="20" align="left">Estado :</td>
                    <td width="85%" align="left">{$DATOSENCABEZADO.estado_liq}</td>
                </tr>                                                               
            </table>
		</td>                    
    </tr>
    <tr>
        <td height="20" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid">
        TOTAL DE GUIAS LIQUIDADAS : {$TOTAL.cantidad}
        </td>
	</tr>
    <tr style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid">
    	<td>
        	<table width="100%">
		        <td width="25%" height="20" align="center">DESCRIPCION</td>
                <td width="25%" height="20" align="center">CANTIDAD</td>
        		<td width="25%" height="20" align="center">VR. FACTURAR</td>
        		<td width="25%" height="20" align="center">SUBTOTAL</td>
			</table>
		</td>                            
    </tr>
    {foreach name=imputaciones from=$IMPUTACIONES item=i} 
    <tr style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid">
    	<td>
        	<table width="100%">
		        <td width="25%" height="20">&nbsp;{$i.descripcion}</td>
                <td width="25%" height="20" align="center">&nbsp;{$i.cantidad}</td>
        		<td width="25%" height="20" align="right" >&nbsp;{$i.valor_facturar|number_format:2:',':'.'}</td>
        		<td width="25%" height="20" align="right" >&nbsp;{$i.subtotal|number_format:2:',':'.'}</td>
			</table>
		</td>                            
    </tr>
    {/foreach}
	<tr>
        <td height="20" colspan="3" align="right" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid">TOTAL LIQUIDACI&Oacute;N : {$DATOSENCABEZADO.valor|number_format:2:',':'.'}</td>
    </tr>    
	<tr>
        <td height="20" colspan="3" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid">Valor a Cobrar : {$TOTALES} Pesos M/CTE </td>
    </tr>
	<tr>
        <td height="20" colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid">Elaborado Por: {$DATOSENCABEZADO.nombre_usuario}</td>
    </tr>
</table>           
</body>
</html>
