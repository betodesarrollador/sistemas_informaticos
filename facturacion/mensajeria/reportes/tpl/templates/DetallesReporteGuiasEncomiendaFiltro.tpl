<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   {$JAVASCRIPT}
   {$CSSSYSTEM}
</head>

<body> 
  <input  type="hidden" id="estado" value="{$estado_id}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
    <tr><td width="30%">&nbsp;</td><td width="30%" align="right">&nbsp;</td></tr> 
    <tr><td colspan="3">&nbsp;</td></tr>  
</table>  

<table align="center" id="encabezado"  width="90%">
  <tr>
    <th class="borderTop borderRight">USUARIO</th>
    <th class="borderTop borderRight">OFICINA</th>
    <th class="borderTop borderRight">DOCUMENTO</th>
    <th class="borderTop borderRight">NUMERO GUIA</th>
    <th class="borderTop borderRight">FECHA</th>
    <th class="borderTop borderRight">TIPO ENVIO</th>
    <th class="borderTop borderRight">ORIGEN</th>
    <th class="borderTop borderRight">DESTINO</th>
    <th class="borderTop borderRight">PESO</th>
    <th class="borderTop borderRight">CANTIDAD</th>
    <th class="borderTop borderRight">VALOR FLETE</th>
    <th class="borderTop borderRight">VALOR SEGURO</th>
    <th class="borderTop borderRight">VALOR OTROS</th>
    <th class="borderTop borderRight">VALOR DESCUENTO</th>
    <th class="borderTop borderRight">VALOR TOTAL</th>

</tr>
{foreach name=detalles from=$DETALLES item=i}

<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">

    <td class="borderTop borderRight" align="right">{$i.usuario}</td>  
    <td class="borderTop borderRight" align="right">{$i.oficina}</td>  
    <td class="borderTop borderRight" align="right">{$i.doc_usuario}</td>  
    <td class="borderTop borderRight" align="right">{$i.prefijo}-{$i.numero_guia}</td>  
    <td class="borderTop borderRight" align="right">{$i.fecha_guia}</td>  
    <td class="borderTop borderRight" align="right">{$i.tipo_envio}</td>  
    <td class="borderTop borderRight" align="right">{$i.origen}</td>  
    <td class="borderTop borderRight" align="right">{$i.destino}</td>  
    <td class="borderTop borderRight" align="right">{$i.peso}</td>  
    <td class="borderTop borderRight" align="right">{$i.cantidad}</td>  
    <td class="borderTop borderRight" align="right">{$i.valor_flete|number_format:0:",":"."}</td>  
    <td class="borderTop borderRight" align="right">{$i.valor_seguro|number_format:0:",":"."}</td>  
    <td class="borderTop borderRight" align="right">{$i.valor_otros|number_format:0:",":"."}</td>
    <td class="borderTop borderRight" align="right">{$i.valor_descuento|number_format:0:",":"."}</td> 
    <td class="borderTop borderRight" align="right">{$i.valor_total|number_format:0:",":"."}</td>
</tr>
{/foreach}  
</table>
</body>
</html>
