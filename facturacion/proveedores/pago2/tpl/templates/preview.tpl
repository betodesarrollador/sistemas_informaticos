<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   {$CSSSYSTEM}
  </head>

  <body>
		{$FORM1}
        <table align="center" width="90%" id="encabezadoMovimientoContable">
          <tr>
            <td><label>Consecutivo : </label></td>
            <td>{$CONSECUTIVO}</td>
            <td><label>Empresa : </label></td>
            <td>{$EMPRESA}</td>
            <td><label>Oficina : </label></td>
            <td>{$OFICINA}</td>
          </tr>
          <tr>
            <td><label>Fecha : </label></td>
            <td>{$FECHA}</td>
            <td><label>Documento :</label></td>
            <td>{$DOCUMENTO}</td>
            <td><label>Forma Pago  :</label></td>
            <td>{$FPAGO}</td>
          </tr>
          <tr>
            <td><label>Valor :</label></td>
            <td>{$VALOR}</td>
            <td><label>{$TEXTOSOPORTE}</label></td>
            <td>{$NUMSOPORTE}</td>
            <td><label>Cpto :</label></td>
            <td rowspan="2" valign="top">{$CONCEPTO}</td>
          </tr> 
          <tr>
            <td>{$TEXTOTERCERO}</td>
            <td>{$TERCERO}</td>
            <td>Codigo:</td>
            <td colspan="2">{$PUC}
            <label></label></td>
          </tr>           
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>                                                  
        </table>
                
    <table align="center" width="90%" border="1">
    <thead>
      <tr align="center">
        <th>CODIGO</th>
        <th>TERCERO</th>
        <th>DESCRIPCION</th>
        <th>CENTRO DE COSTO</th>
        <th>BASE</th>
        <th>DEBITO</th>
        <th>CREDITO</th>        
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$IMPUTACIONES item=i}
      <tr>
        <td>{$i.puc}</td>
        <td>{$i.tercero}</td>
        <td>{$i.descripcion}</td>
        <td>{$i.centro_de_costo}</td>
        <td>{$i.base}</td>
        <td>{$i.debito}</td>        
        <td>{$i.credito}</td>
      </tr> 
	  {/foreach}	
	</tbody>
  </table>
       
  </body>
</html>