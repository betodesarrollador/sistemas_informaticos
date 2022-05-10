<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}  
  {$TITLETAB}    
  </head>

  <body>

    <fieldset>
    <legend>{$TITLEFORM}</legend>
	
    <div id="divSolicitudRemesa">
		<iframe id="iframeSolicitudRemesa"></iframe>
    </div>
	
    <div id="divOrdenCargueRemesa">
		<iframe id="iframeOrdenCargueRemesa"></iframe>
    </div>	
	
	<div id="table_find">
        <table align="center" width="100%">
         <tr>
           <td><label>Busqueda :</label></td><td>{$BUSQUEDA}</td><td align="right">{$IMPORTARORDENCARGUE}&nbsp;{$IMPORTARSOLICITUD}&nbsp;&nbsp;&nbsp;</td>
         </tr>
        </table>
    </div>

        {$OFICINAIDSTATIC} {$FECHA}{$ASEGURADORAIDSTATIC}{$NUMEROPOLIZASTATIC}{$FORM1}{$DETALLESSID}
		
	<fieldset class="section">
        <legend>Informacion general</legend>
        <table align="center" width="85%">
          <tr>
            <td><label>Tipo Remesa :</label></td>
            <td>{$TIPOREMESA}{$REMESAID}{$DETALLESSID}{$OFICINAID}</td>
            <td><label>Fecha Remesa :</label></td><td>{$FECHAREMESA}</td>
          </tr>
          <tr>
            <td><label>Remesa No. :</label></td>
            <td>{$NUMEROREMESA}{$DETALLEREMESAID}</td>
            <td><label>Solicitud Servicio :</label></td>
            <td>{$SOLICITUDID}</td>
          </tr>
          <tr>
            <td><label>Cliente :</label></td><td>{$CLIENTE}{$CLIENTEID}</td>
            <td><label>Contacto :</label></td>
            <td>{$CONTACTOS}</td>
          </tr>	  
          <tr>
            <td><label>Propietario Mercancia :</label></td>
            <td>
              {$PROPIETARIO}{$PROPIETARIOTXT}{$PROPIETARIOID}{$TIPOIDENTIFICACIONPROPIETARIO}{$NUMEROIDENTIFICACIONPROPIETARIO}            </td>
            <td><label>Clase Remesa  :</label></td>
            <td>{$CLASEREMESA}</td>			
          </tr>         
          <tr>
            <td><label>N. Remesa Padre :</label></td>
            <td>{$NUMEROREMESAPADRE}</td>
            <td><label>Estado :</label></td>
            <td>{$ESTADO}</td>
          </tr>			   
		</table>
    </fieldset>
		<fieldset class="section">
		<legend>Seguro de La Mercancia</legend>
		<table width="100%">
          <tr>
            <td><label>Amparada Por :</label></td>
            <td>{$AMPARADAPOR}</td>
            <td><label>Aseguradora :</label></td>
            <td>{$ASEGURADORAS}</td>
          </tr>
          <tr>
            <td><label>N° Poliza :</label></td>
            <td>{$NUMEROPOLIZA}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>		
		</table>
		</fieldset>		
		<fieldset class="section">
		<legend>Datos Remesa</legend>
		<table align="center" width="85%">
		  <tr>
		    <td>
				<table align="center" width="100%">
				  <tr>
					<td><label>Origen :</label></td><td>{$ORIGEN}{$ORIGENID}</td>
				  </tr>
				  <tr>
					<td><label>Remitente :</label></td>
					<td>{$REMITENTE}{$REMITENTEID}{$TIPOIDENTIFICACIONREMITENTEID}</td>
				  </tr>
				  <tr>
					<td><label>Documento :</label></td><td>{$DOCUMENTOREMITENTE}</td>
				  </tr>
				  <tr>
					<td><label>Direccion :</label></td><td>{$DIRECCIONORIGEN}</td>
				  </tr>
				  <tr>
					<td><label>Telefono :</label></td><td>{$TELEFONOORIGEN}</td>
				  </tr>
				  <tr>
				    <td><label>Dcto. Cliente  :</label></td>
				    <td>{$ORDENDESPACHO}</td>
			      </tr>
				</table>
			</td>
			<td>
				<table align="center" width="100%">
				  <tr>
					<td><label>Destino :</label></td><td>{$DESTINO}{$DESTINOID}</td>
				  </tr>
				  <tr>
					<td><label>Destinatario :</label></td><td>{$DESTINATARIO}{$DESTINATARIOID}{$TIPOIDENTIFICACIONDESTINATARIOID}</td>
				  </tr>
				  <tr>
					<td><label>Documento :</label></td><td>{$DOCUMENTODESTINATARIO}</td>
				  </tr>
				  <tr>
					<td><label>Direccion :</label></td><td>{$DIRECCIONDESTINO}</td>
				  </tr>
				  <tr>
					<td><label>Telefono :</label></td><td>{$TELEFONODESTINO}</td>
				  </tr>
				</table>
			</td>
		  </tr>	
		  </tr>
		</table>
		</fieldset>			

		<fieldset class="section">
		 <legend>Datos Producto</legend>
		 <table width="85%" align="center" >
           <tr>
             <td width="18%"><label>Codigo Producto  :</label></td>
             <td>{$PRODUCTOID}{$PRODUCTO}
             <label></label></td>
             <td><label>Producto : </label></td>
             <td>{$DESCRIPCIONPRODUCTO}</td>
           </tr>
           <tr>
             <td><label>Naturaleza :</label></td>
             <td width="32%">{$NATURALEZA}</td>
             <td width="21%"><label>Unidad Empaque :</label></td>
             <td>{$UNIDADEMPAQUE}</td>
           </tr>
           <tr>
             <td><label>Unidad Medida :</label></td>
             <td>{$UNIDADMEDIDA}</td>
             <td><label>Cantidad :</label></td>
             <td width="29%">{$CANTIDAD}</td>
           </tr>
           <tr>
             <td><label>Peso Neto :</label></td>
             <td>{$PESONETO}</td>
             <td><label>Valor Declarado :</label></td>
             <td>{$VALORDECLARADO}</td>
           </tr>
           <tr>
             <td valign="top"><label>Peso Volumen :</label></td>
             <td valign="top">{$PESOVOLUMEN}</td>
             <td valign="top"><label>Observaciones :</label></td>
             <td valign="top">{$OBSERVACIONES}</td>
           </tr>           
         </table>
		</fieldset>
				
		<fieldset class="section">
		 <legend>Hoja de Tiempos</legend>
		 <table width="100%">
		   <tr><td class="subSection" colspan="6">CARGUE{$HOJATIEMPOSID}</td></tr>
		   <tr>
		     <td><label>Horas Pactadas Cargue :</label></td>
			 <td>{$HORASPACTADASCARGUE}</td>
		     <td><label>Fecha LLegada :</label></td>
			 <td>{$FECHALLEGADALUGARCARGUE}</td>			 
		     <td><label>Hora LLegada :</label></td>
			 <td>{$HORALLEGADALUGARCARGUE}</td>			 			 
		   </tr>
		   <tr>
		     <td><label>Conductor :</label></td>
		     <td>{$CONDUCTORENTREGAHOJARUTA}{$CONDUCTORCARGUEID}</td>
		     <td><label>Fecha Salida :</label></td>
			 <td>{$FECHASALIDALUGARCARGUE}</td>			 
		     <td><label>Hora Salida :</label></td>
			 <td>{$HORASALIDALUGARCARGUE}</td>			 			 
		   </tr>			   
		   <tr>
		     <td><label>Quien Entrega :</label></td>
		     <td>{$ENTREGAHOJARUTA}</td>			 
		     <td><label>Cedula :</label></td>
			 <td colspan="3">{$CEDULAENTREGAHOJARUTA}</td>			 
		   </tr>		   
		   
		   <tr><td class="subSection" colspan="6">DESCARGUE</td></tr>
		   <tr>
		     <td><label>Horas Pactadas Descargue :</label></td>
			 <td>{$HORASPACTADASDESCARGUE}</td>
		     <td><label>Fecha LLegada :</label></td>
			 <td>{$FECHALLEGADADESCARGUE}</td>			 
		     <td><label>Hora LLegada :</label></td>
			 <td>{$HORALLEGADADESCARGUE}</td>			 			 
		   </tr>
		   <tr>
		     <td><label>Conductor :</label></td>
		     <td>{$CONDUCTORRECIBEHOJARUTA}{$CONDUCTORRECIBEHOJARUTAID}</td>
		     <td><label>Fecha Salida :</label></td>
			 <td>{$FECHASALIDADESCARGUE}</td>			 
		     <td><label>Hora Salida :</label></td>
			 <td>{$HORASALIDADESCARGUE}</td>			 			 
		   </tr>			   
		   <tr>
		     <td><label>Quien Recibe :</label></td>
		     <td>{$RECIBEHOJARUTA}</td>			 
		     <td><label>Cedula :</label></td>
			 <td colspan="3">{$CEDULARECIBEHOJARUTA}</td>			 
		   </tr>		   
		 </table>
        </fieldset>		
		
		{*
		<fieldset class="section">
		  <legend>Liquidacion</legend>
		  <table align="center">
		    <tr>		  
			  <td><label>Tipo Liquidacion :</label></td><td>{$TIPOLIQUIDACION}</td>
			  <td><label>Valor Unidad :</label></td><td>{$VALORUNIDADFACTURAR}</td>			  
			  <td><label>Valor Facturar:</label></td><td>{$VALORFACTURAR}</td>				  
			  <!--<td><label>Documento Cliente :</label></td>
		      <td>{$DOCUMENTOCLIENTE}</td>-->
		    </tr>
		  </table>
		</fieldset>		
		
		*}
		
		<table align="center">
	      <tr>
	        <td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$LIMPIAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}</td>
          </tr>
      </table>
      {$FORM1END}
    </fieldset>
	
	<div id="rangoImp">
      <div align="center">
	    <p align="center">
		  <b>Desde :&nbsp;</b>{$RANGODESDE} <b>&nbsp;&nbsp;&nbsp;Hasta :&nbsp;</b>{$RANGOHASTA}&nbsp;&nbsp;&nbsp;<b>Formato :</b>{$FORMATO}
		</p>
		<p align="center">{$PRINTCANCEL}{$PRINTOUT}</p>
	  </div>
	</div>		
    
    <fieldset>{$GRIDREMESAS}</fieldset>
	
<div id="divAnulacion">
  <form onSubmit="return false">
	<table>              
	  <tr>
		<td><label>Causal :</label></td>
		<td>{$CAUSALANULACIONID}</td>
	  </tr>
	  <tr>
		<td><label>Descripcion :</label></td>
		<td>{$OBSERVANULACION}</td>
	  </tr> 
	  <tr>
		<td colspan="2" align="center">{$ANULAR}</td>
	  </tr>                    
	</table>
  </form>
</div>	
	    
  </body>
</html>