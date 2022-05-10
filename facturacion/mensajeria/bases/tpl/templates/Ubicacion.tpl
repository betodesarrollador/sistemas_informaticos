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
        <legend><img src="../media/images/forms/ubicacion.png" height="48"></legend>

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
            <td><label>Pais : </label></td><td>{$PAIS}</td>
            <td>&nbsp;</td><td>&nbsp;</td>
          </tr>
          <tr>
            <td><label>Departamento : </label></td><td>{$DEPTO}</td>
            <td><label>Ubicacion : </label></td><td>{$UBICACION}{$UBICACIONID}</td>
          <tr>
          <tr>
            <td><label>Latitud : </label></td><td>{$LATITUD}</td>
            <td><label>Longitud : </label></td><td>{$LONGITUD}</td>
          <tr>
          <tr>
            <td><label>Tipo de Envio: </label></td><td>{$TIPOENVIOID}</td>
            <td><label>Area Metropolitana de: </label></td><td>{$METROPOLITANA}{$METROPOLITANAID}</td>
          <tr>
          <tr>
			<td><label>Estado Mensajeria: </label></td><td>{$ESTADOMENSAJERIA}</td>
	        <td>&nbsp;</td>
          </tr>

	      <tr>
	        <td colspan="4" align="center">{*{$GUARDAR}&nbsp;*}{$ACTUALIZAR}&nbsp;{*{$BORRAR}&nbsp;*}{$LIMPIAR}</td>
          </tr>
      </table>
      {$FORM1END}  
    </fieldset>
	
    <fieldset>
    	<table>
        	<tr>
            	<td><label>Lat/Long : </label></td>
        		<td><div id="latlng"></div></td>
            </tr>
        </table>	
      <div id="map">
	    <div id="map_canvas"></div>  
    	<div id="crosshair"></div>
      </div>
    </fieldset>	
	
    <fieldset>{$GRIDUBICACION}</fieldset>	
    
  </body>
</html>