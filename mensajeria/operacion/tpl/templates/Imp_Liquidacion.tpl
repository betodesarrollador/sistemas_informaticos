<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Liquidacion Manifiesto</title>
{$CSSSYSTEM}
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="71%" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid"><table width="100%" border="0">
      <tr>
        <td width="160"><img src="{$DATOSENCABEZADO.logo}" width="160" height="42" /></td>
        <td width="386" align="center"><strong>{$DATOSENCABEZADO.razon_social_emp}</strong><br />
          &nbsp;{$DATOSENCABEZADO.tipo_identificacion_emp}: &nbsp;{$DATOSENCABEZADO.numero_identificacion_emp} </td>
      </tr>
    </table></td>
    <td width="29%" align="center" style="border-top:1px solid; border-right:1px solid; border-bottom:1px solid">
	<table width="100%" border="0">
	  <tr><td colspan="2" align="center">LIQUIDACION</td></tr>
      <tr>
        <td >Numero : </td>
        <td >{$DATOSENCABEZADO.consecutivo}</td>
      </tr>
      <tr>
        <td>Fecha : </td>
        <td>{$DATOSENCABEZADO.fecha}</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; padding:8px">
	<table width="90%" border="0">
      <tr>
        <td width="12%">A Favor de : </td>
        <td width="40%">{$DATOSENCABEZADO.primer_nombre} &nbsp;{$DATOSENCABEZADO.segundo_nombre} &nbsp;{$DATOSENCABEZADO.primer_apellido} &nbsp;{$DATOSENCABEZADO.segundo_apellido} &nbsp;{$DATOSENCABEZADO.razon_social}</td>
        <td width="12%">Planilla : </td>
        <td width="36%">{$DATOSENCABEZADO.consecutivo}</td>
        </tr>
      <tr>
        <td>Nit : </td>
        <td>{$DATOSENCABEZADO.numero_identificacion} {if $DATOSENCABEZADO.digito_verificacion neq ''}-{/if} &nbsp;{$DATOSENCABEZADO.digito_verificacion}</td>
        <td>Fecha Planilla : </td>
        <td>{$DATOSENCABEZADO.fecha_planilla}</td>
        </tr>

      <tr>
        <td>Placa Vehiculo: </td>
        <td>{$DATOSENCABEZADO.placa}</td>
        <td>Origen : </td>
        <td>{$DATOSENCABEZADO.origen}</td>
        </tr>
      <tr>
        <td>Conductor : </td>
        <td>{$DATOSENCABEZADO.conductor}</td>
        <td>Destino : </td>
        <td>{$DATOSENCABEZADO.destino}</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid">
	<table cellspacing="0" cellpadding="0" width="90%" border="0" align="center" style="margin-top:8px; margin-bottom:8px">
      <tr align="center" >
        <td  width="210" >CONCEPTO</td>
        <td  width="130" >DEBITO</td>
        <td  width="130" >CREDITO</td>
      </tr>
      {foreach name=imputaciones from=$IMPUTACIONES item=i}                    
      
      {if $i.debito > 0 or $i.credito > 0}
      <tr>
          <td >&nbsp;{$i.descripcion}</td>
        <td align="right" >&nbsp;{if $i.debito > 0} {$i.debito|number_format:2:',':'.'}{/if}</td>
        <td align="right" >&nbsp;{if $i.credito > 0}{$i.credito|number_format:2:',':'.'}{/if}</td>
      </tr>
      {/if}
      {/foreach}
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" >&nbsp;</td>
    <td align="right" >&nbsp;<b>{$TOTAL.total_debito|number_format:2:',':'.'}</b></td>
    <td align="right" >&nbsp;<b>{$TOTAL.total_credito|number_format:2:',':'.'}</b></td>
  </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; padding:5px">
	 Valor a Pagar Beneficiario : {$TOTALES} Pesos M/CTE 
	</td>
  </tr>
  <tr>
    <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; padding:5px">Observaciones : </td>
  </tr>
  <tr>
    <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; padding:5px">
	<table width="90%" border="0" align="center">
      <tr>
        <td width="50%"><table width="200" border="0" align="center">
          <tr>
            <td><br />_______________________________________________</td>
          </tr>
          <tr>
            <td align="center">BENEFICIARIO</td>
          </tr>
        </table></td>
        <td width="50%"><table width="200" border="0" align="center">
          <tr>
            <td><br />____________________________________________</td>
          </tr>
          <tr>
            <td align="center">FIRMA</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
