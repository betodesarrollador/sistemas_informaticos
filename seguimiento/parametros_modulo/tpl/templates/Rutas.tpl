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
            <td><label>Nombre Ruta : </label></td><td colspan="3">{$RUTA}{$RUTAID}{$CANTIDAD}</td>
          </tr>
          <tr>
            <td><label>Origen : </label></td><td>{$ORIGEN}{$ORIGENID}</td>
            <td><label>Destino : </label></td><td>{$DESTINO}{$DESTINOID}</td>
          </tr>
          <tr>
            <td><label>Pasador vial : </label></td><td>{$PASADORVIAL}</td>
            <td><label>Distancia (Km) : </label></td><td>{$DISTANCIA}</td>
          </tr>
          <tr>
            <td>&nbsp;</td><td>&nbsp;</td>
            <td><label>Estado : </label></td><td>{$ESTADORUTA}</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
        </table><br>
        <div align="left">
		  <table width="100%">
		   <tr>
		     <td width="9%" align="left" id="messages">&nbsp;</td>
			 <td width="91%" align="right" id="toolbarDetails" >
			   <input type="button" name="renderMap"          id="renderMap" value="Actualizar Mapa">
               <input type="button" name="saveDetallesRuta"   id="saveDetallesRuta" value="Guardar Puntos Ruta">
             <input type="button" name="deleteDetallesRuta" id="deleteDetallesRuta" value="Borrar Seleccionados"></td>
	        </tr>
		 </table>
		</div>
        <div><iframe id="detalleRuta" frameborder="0" width="100%" height="400"></iframe></div>
        <div align="left">
		  <table width="100%">
		   <tr>
		     <td align="left">&nbsp;</td>
			 <td align="right" id="toolbarDetails">
		       <input type="button" name="renderMap"          id="renderMap" value="Actualizar Mapa">
		       <input type="button" name="saveDetallesRuta"   id="saveDetallesRuta" value="Guardar Puntos Ruta">		  
		       <input type="button" name="deleteDetallesRuta" id="deleteDetallesRuta" value="Borrar Seleccionados">			 
			 </td>
		   </tr>
		 </table>
		</div>		
			
        
      {$FORM1END}
    </fieldset>
    
    {*<fieldset>
	    <div id="map_canvas"  style="width:100%; height:650px;"></div>   
    </fieldset>*}
    
    <fieldset>{$GRIDRutas}</fieldset>
    
  </body>
</html>