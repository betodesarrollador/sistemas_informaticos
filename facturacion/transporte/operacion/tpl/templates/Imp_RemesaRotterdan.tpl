{literal}
 <style>
   table tr td{
     font-size:14px;
   }
 </style>
{/literal}
{foreach name=remesas from=$DATOSREMESAS item=r}
<page orientation="portrait" backtop="14mm" backbottom="0mm" backleft="0mm" backright="0mm">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="900" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="60">&nbsp;</td>
          <td width="200" height="10" align="left" valign="bottom">{$r.fecha_remesa|substr:0:21}</td>
          <td width="60">&nbsp;</td>
          <td width="200" align="left" valign="bottom">{$r.oficina|substr:0:390} </td>
          <td width="200" align="center" valign="bottom">{$r.numero_remesa|substr:0:200}</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="10" align="left">{$r.remitente|substr:0:21}</td>
          <td>&nbsp;</td>
          <td colspan="2" align="left">{$r.origen|substr:0:390} </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="10" align="left">{$r.destinatario|substr:0:21}</td>
          <td>&nbsp;</td>
          <td colspan="2" align="left">{$r.destino|substr:0:390} </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="10" align="left">{$r.direccion_destinatario|substr:0:21}</td>
          <td>&nbsp;</td>
          <td colspan="2" align="left">{$r.telefono_destinatario|substr:0:390}</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>
	  <table width="900" border="0" cellpadding="0" cellspacing="0">
        <tr><td colspan="2" >&nbsp;</td></tr>
        <tr>
          <td width="55" align="left" height="2">{$r.detalles_remesa[0].cantidad}</td>
          <td width="60" align="left">{$r.detalles_remesa[0].peso}</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="330" align="left">&nbsp;&nbsp;&nbsp;{$r.detalles_remesa[0].referencia_producto}</td>
          <td width="330" align="left">{$r.detalles_remesa[0].guia_cliente}</td>
        </tr>
        <tr>
          <td width="55" align="left" height="2">{$r.detalles_remesa[1].cantidad}</td>
          <td width="60" align="left">{$r.detalles_remesa[1].peso}</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="330" align="left">&nbsp;&nbsp;&nbsp;{$r.detalles_remesa[1].referencia_producto}</td>
          <td width="330" align="left">{$r.detalles_remesa[1].guia_cliente}</td>
        </tr>
        <tr>
          <td width="55" align="left" height="2">{$r.detalles_remesa[2].cantidad}</td>
          <td width="60" align="left">{$r.detalles_remesa[2].peso}</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="330" align="left">&nbsp;&nbsp;&nbsp;{$r.detalles_remesa[2].referencia_producto}</td>
          <td width="330" align="left">{$r.detalles_remesa[2].guia_cliente}</td>
        </tr>
        <tr>
          <td width="55" align="left" height="2">{$r.detalles_remesa[3].cantidad}</td>
          <td width="60" align="left">{$r.detalles_remesa[3].peso}</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="330" align="left">&nbsp;&nbsp;&nbsp;{$r.detalles_remesa[3].referencia_producto}</td>
          <td width="330" align="left">{$r.detalles_remesa[3].guia_cliente}</td>
        </tr>
        <tr>
          <td width="55" align="left" height="2">{$r.detalles_remesa[4].cantidad}</td>
          <td width="60" align="left">{$r.detalles_remesa[4].peso}</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="330" align="left">&nbsp;&nbsp;&nbsp;{$r.detalles_remesa[4].referencia_producto}</td>
          <td width="330" align="left">{$r.detalles_remesa[4].guia_cliente}</td>
        </tr>
        <tr>
          <td width="55" align="left" height="2">{$r.detalles_remesa[5].cantidad}</td>
          <td width="60" align="left">{$r.detalles_remesa[5].peso}</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="330" align="left">&nbsp;&nbsp;&nbsp;{$r.detalles_remesa[5].referencia_producto}</td>
          <td width="330" align="left">{$r.detalles_remesa[5].guia_cliente}</td>
        </tr>
        <tr>
          <td width="55" align="left" height="2">{$r.detalles_remesa[6].cantidad}</td>
          <td width="60" align="left">{$r.detalles_remesa[6].peso}</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="65" align="center">&nbsp;</td>
          <td width="330" align="left">&nbsp;&nbsp;&nbsp;{$r.detalles_remesa[6].referencia_producto}</td>
          <td width="330" align="left">{$r.detalles_remesa[6].guia_cliente}</td>
        </tr>
      </table>
	  </td>
    </tr>
    <tr>
      <td>
	  <table width="900" border="0" cellpadding="0" cellspacing="0"> 
        <tr>
          <td width="100">&nbsp;</td>
          <td width="120" align="left">{$r.valor_unidad|substr:0:100}</td>
          <td width="50">&nbsp;</td>
          <td width="130" align="left">{$r.manifiesto|substr:0:100}</td>
          <td width="40">&nbsp;</td>
          <td width="330" align="left">{$r.placa|substr:0:100}</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="900" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="45" width="350">&nbsp;</td>
          <td headers="45" width="222" valign="top">{$r.observaciones}</td>
          <td headers="45" width="328" valign="top">RESP. {$r.oficina|substr:0:390}</td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</page>
{/foreach}