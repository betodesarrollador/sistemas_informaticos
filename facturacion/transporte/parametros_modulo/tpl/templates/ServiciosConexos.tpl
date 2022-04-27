<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>
  
  
  <body>
	<fieldset>
        <legend>
			<img src="../media/images/forms/parametros_modulo.png" height="45">
            <img src="../media/images/forms/servicios_conexos.png" height="45">
        </legend>

        <div id="table_find">
        <table align="center">
         <tr>
           <td><label>Busqueda :</label></td><td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}{$SERVICONEXID}
        <table align="center">
          <tr>
            <td><label>Empresa :</label></td><td colspan="2">{$EMPRESAS}</td>
          </tr>
          <tr>
            <td><label>Agencia :</label></td><td colspan="2">{$AGENCIA}</td>
          </tr>
          <tr>
            <td><label>Servicio o Recurso :</label></td><td colspan="2">{$SERVICONEX}</td>
          </tr>
          <tr>
	        <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center"><div style="width:130px"><label>FACTURACION</label></div></td>
          </tr>
          <tr>
            <td align="center"><div style="width:110px"><label>Cuenta Ingresos</label></div></td>
            <td align="center"><div style="width:110px"><label>Cuenta x Cobrar</label></div></td>
            <td align="center"><div style="width:110px"><label>Impuestos</label></div></td>
          </tr>
          <tr>
            <td>{$PUCINGRESO}{$PUCINGRESOID}</td>
            <td>{$PUCCXC}{$PUCCXCID}</td>
            <td></td>
          </tr>
          <tr>
	        <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center"><div style="width:130px"><label>PROVEEDORES</label></div></td>
          </tr>
          <tr>
            <td align="center"><div style="width:110px"><label>Cuenta Costo</label></div></td>
            <td align="center"><div style="width:110px"><label>Cuenta x Pagar</label></div></td>
            <td align="center"><div style="width:110px"><label>Impuestos</label></div></td>
          </tr>
          <tr>
            <td>{$PUCCOSTO}{$PUCCOSTOID}</td>
            <td>{$PUCCXP}{$PUCCXPID}</td>
            <td></td>
          </tr>
          <tr>
	        <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><label>Estado del Servicio o Recurso</label></td>
          </tr>
          <tr>
            <td colspan="3" align="right">{$ESTADO}</td>
          </tr>
          <tr>
	        <td colspan="3">&nbsp;</td>
          </tr>

	      <tr>
	        <td colspan="3" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
      
      
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDServiciosConexos}</fieldset>
    
  </body>
</html>