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
         <fieldset class="section"><legend>Formulario de Tr&aacute;fico</legend>
        <table align="center">
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
            <td><label>Referencia No : </label></td>
            <td>{$NUMERO}{$TRAFICOID}</td>
		    <td><label>Fecha :</label></td>
			<td>{$FECHA}</td>
		    <td><label>Agencia :</label></td>
			<td>{$AGENCIA}</td>
          </tr>
          <tr>
            <td><label>Aprobacion Min. No : </label></td>
            <td>{$APROB_MIN}</td>
		    <td><label>Fecha Aprob. Min:</label></td>
			<td>{$FECHA_APROB_MIN}</td>
		     <td><label>Frecuencia llamadas : </label></td>
                <td>{$FRECUENCIA}</td>
          </tr>

          <tr>
            <td><label>Origen : </label></td><td>{$ORIGEN}</td>
            <td><label>Destino : </label></td><td>{$DESTINO}</td>
            <td><label>Transito Nocturno : </label></td>
            <td>{$NOCTURNO}</td>
          </tr>

          <tr>
            <td><label>Ruta : </label>{$RUTAHIDDEN}</td><td>{$RUTAS}</td>          
            <td><label>Fecha Salida : </label></td><td>{$FECHAINI}</td>
            <td><label>Hora Salida : </label></td><td>{$HORAINI}</td>
            
          </tr>

          <tr>
            <td><label>Escolta Recibe: </label></td>
            <td>{$ESCOLTARECIBE}{$ESCOLTARECIBEID}</td>
		    <td><label>Escolta Entrega:</label></td>
			<td>{$ESCOLTAENTREGA}{$ESCOLTAENTREGAID}</td>
            <td><label>Estado: </label></td><td>{$ESTADO}{$ESTADOHIDDEN}</td>
          </tr>
          <tr>
	        <td valign="top"><label>Observaciones Viaje: </label></td>
	        <td valign="top" colspan="5">{$CLIENTES}</td>
          </tr>
          <tr>
	        <td valign="top"><label>Notas del Controlador: </label></td>
	        <td valign="top" colspan="5">{$NOTACONTROLADOR}</td>
          <td>{$GUARDARNOTA}</td>
          </tr>
          <tr>
	        <td colspan="6" align="center"><div id="divDetalleRemesas"  >
	      <iframe id="iframeDetalleRemesas" width="800" height="100"></iframe>
      </div></td>
          </tr>
          <tr>
          	<td colspan="6" align="center" >&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$PASARURBANO}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$REGRESARTRAFICO}</td>
          </tr>
        </table>
        </fieldset>
        
    <div align="right">
        	<table width="100%">
            	<tr>
				    <td id="messages">&nbsp;</td>
		  			<td id="toolbarDetails" align="right">					
					 <input type="button" id="cambio_ruta" value="Adicionar Puntos Ruta" />
					 {*<input type="button" id="renderMap" value="Actualizar Mapa" />*}
					 <input type="button" id="saveDetallesSeguimiento"   value="Guardar Puntos Selecc.." />
					 <input type="button" id="deleteDetallesSeguimiento" value="Borrar Puntos Selecc.." />
				    </td>
              </tr>
			</table>                    
	   </div>
        <div><span id="mensaje_alert">Para proceder a realizar trafico, debe diligenciar los datos del encabezado y hacer click en el boton Actualizar</span><iframe id="detalleSeguimiento" frameborder="0"></iframe></div>
			
        
      {$FORM1END}
      <div id="divSolicitudRemesasEdit">
	      <iframe id="iframeSolicitudEdit"></iframe>
      </div>

      <div id="divCambioRuta">
	      <iframe id="iframeCambioRuta"></iframe>
      </div>

    </fieldset>
    
    {*<fieldset>
	    <div id="map_canvas" style="width:100%; height:650px;"></div>   
    </fieldset>*}

    <div id="divAnulacion">
      <form>
        <table>       
          <tr>
            <td><label>Fecha / Hora :</label></td>
            <td>{$FECHALOG}{$ANULUSUARIOID}</td>
          </tr>          
          <tr>
            <td><label>Causal :</label></td>
            <td>{$CAUSALESID}</td>
          </tr>
          <tr>
            <td><label>Descripcion :</label></td>
            <td>{$OBSERVACIONES}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$ANULAR}</td>
          </tr>                    
        </table>
      </form>
    </div>
    
  </body>
</html>