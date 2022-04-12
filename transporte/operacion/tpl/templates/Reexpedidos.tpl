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
            <img src="../media/images/forms/reexpedido.png" height="45">
        </legend>

        <div id="table_find">
        <table>
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>

		{$FORM1}
        <table align="center">
          <tr>
            <td><label>Remesa No. : </label></td><td>{$NUMEROREMESA}{$REMESAID}</td>
            <td><label>Reexpedido No : </label></td><td>{$REEXPEDIDO}{$REEXPEDIDOID}</td>
          </tr>
          <tr>
            <td><label>Fecha : </label></td><td>{$FECHA}</td>
            <td><label>Proveedor : </label></td><td>{$PROVEEDOR}{$PROVEEDORID}</td>
          </tr>
          <tr>
            <td><label>Origen : </label></td><td>{$ORIGEN}{$ORIGENID}</td>
            <td><label>Destino : </label></td><td>{$DESTINO}{$DESTINOID}</td>
          </tr>
          <tr>
            <td><label>Guia Proveedor : </label></td><td>{$GUIAPROVEEDOR}</td>
            <td><label>Valor : </label></td><td>{$VALOR}</td>
          </tr>
          <tr>
            <td><label>Observaciones : </label></td><td colspan="3">{$OBSERVACIONES}</td>
          </tr>
          <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
          </tr>

	      <tr>
	        <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
      </table>
      {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDREEXPEDIDOS}</fieldset>
    
  </body>
</html>