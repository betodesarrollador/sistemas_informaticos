<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
	<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" /> 
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>
  <body>
	<fieldset>
        <legend><img src="../media/images/forms/rutas.png" height="48"></legend>
        <div id="table_find">
        <table align="center">
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>
		{$FORM1}
        <table align="center">
          <tr>
            <td><label>Nombre Ruta : </label></td><td>{$RUTA}{$RUTAID}</td>
            <td><label>Pasador vial : </label></td><td>{$PASADORVIAL}</td>
          </tr>
          <tr>
            <td><label>Origen : </label></td><td>{$ORIGEN}{$ORIGENID}</td>
            <td><label>Destino : </label></td><td>{$DESTINO}{$DESTINOID}</td>
          </tr>
          <tr>
            <td>&nbsp;</td><td>&nbsp;</td>
            <td><label>Estado : </label></td><td>{$ESTADORUTA}</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
        </table>
        <div align="right">
		  <img src="../../../seguimiento/parametros_modulo/media/images/forms/Earth-icon.png" id="renderMap" title="Actualizar Mapa"/>
		  <img src="../../../../framework/media/images/grid/save.png" id="saveDetallesRuta" title="Guardar Seleccionados"/>
		  <img src="../../../../framework/media/images/grid/no.gif" id="deleteDetallesRuta" title="Borrar Seleccionados"/>
		</div>
        <div><iframe id="detalleRuta" frameborder="0"></iframe></div>
			
        
      {$FORM1END}
    </fieldset>
    
    <fieldset>
	    <div id="map_canvas"></div>   
    </fieldset>
       
  </body>
</html>