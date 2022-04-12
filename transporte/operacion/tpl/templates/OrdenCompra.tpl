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
			<img src="../media/images/forms/operacion.png" height="45">
            <img src="../media/images/forms/orden_compra.png" height="45">
        </legend>

        <div id="table_find">
        <table align="center">
         <tr>
           <td><label>Busqueda :</label></td><td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}{$ORDENID}
        <table align="center">
          <tr>
            <td><label>Num. Orden :</label></td><td>{$ORDEN}</td>
          </tr>
          <tr>
            <td><label>Empresa :</label></td><td colspan="3">{$EMPRESAS}</td>
          </tr>
          <tr>
            <td><label>Agencia :</label></td><td colspan="3">{$AGENCIA}</td>
          </tr>
          <tr>
            <td><label>Servicio Complementario :</label></td><td>{$SERVICONEX}</td>
            <td><label>Fecha :</label></td><td>{$FECHA}</td>
          </tr>
          <tr>
            <td><label>Proveedor :</label></td><td>{$PROVEEDOR}{$PROVEEDORID}</td>
            <td><label>Nit/Doc :</label></td><td>{$PROVEEDORDOC}</td>
          </tr>
          <tr>
            <td><label>Direccion :</label></td><td>{$DIRECCION}</td>
            <td><label>Telefono :</label></td><td>{$TELEFONO}</td>
          </tr>
          <tr>
	        <td colspan="4">&nbsp;</td>
          </tr>

	      <tr>
	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
      
      
        <div align="right">
		  <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados"/>
		  <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados"/>
		</div>
        
      <div><iframe id="detalleOrdenCompra"></iframe></div>
      
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDOrdenCompra}</fieldset>
    
  </body>
</html>