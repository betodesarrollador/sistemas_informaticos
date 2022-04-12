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
        <legend><img src="../media/images/forms/form_aproba_noc.png" height="48"></legend>

        <div id="table_find">
        <table align="center">
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>
		{$FORM1}
         <fieldset class="section"><legend>Formulario de Aprobaci&oacute;n Tr&aacute;fico Nocturno</legend>
        <table align="center">
          <tr>
            <td><label>Referencia No : </label></td>
            <td>{$NUMERO}{$TRAFICOID}{$TRAFICONOCID}</td>
		    <td><label>Fecha :</label></td>
			<td>{$FECHA}</td>
		    <td><label>Agencia :</label></td>
			<td>{$AGENCIA}</td>
          </tr>
          <tr>
            <td><label>Placa : </label></td>
            <td>{$PLACA}</td>
		    <td><label>Marca :</label></td>
			<td>{$MARCA}</td>
		    <td><label>Color :</label></td>
			<td>{$COLOR}</td>
          </tr>
          <tr>
            <td><label>Link GPS : </label></td>
            <td>{$LINKGPS}</td>
		    <td><label>Usuario GPS :</label></td>
			<td>{$USUARIOGPS}</td>
		    <td><label>Clave GPS :</label></td>
			<td>{$CLAVEGPS}</td>
          </tr>
          <tr>
            <td><label>Conductor : </label></td>
            <td>{$CONDUCTOR}</td>
		    <td><label>M&oacute;vil :</label></td>
			<td>{$CELULAR}</td>
		    <td><label>Categor&iacute;a:</label></td>
			<td>{$CATEGORIA}</td>
          </tr>

          <tr>
            <td><label>Origen : </label></td><td>{$ORIGEN}</td>
            <td><label>Destino : </label></td><td>{$DESTINO}</td>
            <td><label>Transito Nocturno : </label></td>
            <td>{$NOCTURNO}</td>
          </tr>

          <tr>
            <td><label>Ruta : </label></td><td>{$RUTAS}</td>          
            <td><label>Fecha Salida : </label></td><td>{$FECHAINI}</td>
            <td><label>Hora Salida : </label></td><td>{$HORAINI}</td>
            
          </tr>
          <tr>
            <td><label>Escolta Recibe : </label></td>
            <td>{$ESCOLTARECIBE}</td>
		    <td><label>Escolta Entrega :</label></td>
			<td>{$ESCOLTAENTREGA}</td>
            <td><label>Estado : </label></td><td>{$ESTADO}</td>
          </tr>
          <tr>
            <td><label>Autorizar Nocturno : </label></td>
            <td>{$AUTORIZAR}</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
          </tr>

          <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
          </tr>
          <tr>
          	<td colspan="6" align="center">&nbsp;{$ACTUALIZAR}&nbsp;{$LIMPIAR}</td>
          </tr>
        </table>
        </fieldset>
        <div align="right">
		  <img src="/roa/seguimiento/parametros_modulo/media/images/forms/Earth-icon.png" id="renderMap" title="Actualizar Mapa"/>
	  </div>
        
      {$FORM1END}
    </fieldset>
    
    <fieldset>
	    <div id="map_canvas" style="width:100%; height:350px"></div>   
    </fieldset>
    
  </body>
</html>