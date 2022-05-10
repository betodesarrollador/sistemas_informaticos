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
        <legend>{$TITLEFORM}</legend>

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
          	<td><label>C&oacute;digo : </label></td><td>{$REFERENCIAID}</td>
            <td><label>Nombre Punto : </label></td><td>{$NOMBRE}</td>
          </tr>  
          <tr>
          	<td><label>Tipo Punto : </label></td><td>{$TIPOREFERENCIA}</td>
            <td><label>Ciudad / Poblado : </label></td><td>{$UBICACION}{$UBICACIONID}</td>
		  </tr>
          <tr>	
            <td><label>Direcci&oacute;n : </label></td>
            <td>{$DIRECCION}</td>
            <td><label>No Movil : </label></td><td>{$MOVIL}</td>
          </tr>
          <tr>
            <td><label>Email : </label></td><td>{$EMAIL}</td>
            <td><label>No Avantel : </label></td><td>{$AVANTEL}</td>
          </tr>
          <tr>
          	<td><label>Observaci&oacute;n : </label></td><td>{$OBSERVACION}</td>
            <td><label>Contacto : </label></td><td>{$CONTACTO}</td>
          </tr>
          <tr>
	        <td><label title="Los valores deben ir separados por punto no por coma!!">Latitud : </label></td><td>{$X}</td>
            <td><label title="Los valores deben ir separados por punto no por coma!!">Longitud : </label></td>
			<td>{$Y}</td>
          </tr>
          <tr>
            <td><label>Mostrar en Impresion: </label></td>
            <td>{$IMPRIMIR}</td>
            <td><label>Estado : </label></td>
            <td>{$ESTADOPUESTO}</td>
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
    <fieldset>
    	
		{*
		<table>
        	<tr>
            	<td><label>Lat/Long : </label></td>
        		<td><div id="latlng"></div></td>
            </tr>
        </table>	
      <div id="map">
	    <div id="map_canvas"></div>  
    	<div id="crosshair"></div>
      </div>*}
    </fieldset>	
    
    <fieldset>{$GRIDPUESTOSCONTROL}</fieldset>
    
  </body>
</html>