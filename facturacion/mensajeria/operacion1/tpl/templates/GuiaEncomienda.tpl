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
<!--    <div id="divSolicitudGuia"><iframe id="iframeSolicitudGuia"></iframe>
    </div> //-->
	<div id="table_find">
      <table align="center" width="100%">
        <tr>
          <td><label>Busqueda :</label></td><td>{$BUSQUEDA}</td>
<!--           <td align="right">{$IMPORTARSOLICITUD}&nbsp;</td>    -->
        </tr>
      </table>
    </div>
   {$ORIGENCOPIA}{$ORIGENCOPIAID}
   {$OFICINAIDSTATIC}{$FECHA}{$FORM1}{$DETALLESSID}{$TIMPRE}	
	<fieldset class="section">
    <legend>Informacion general</legend>
        <table align="center" width="95%">
          <tr>{$ID}{$CRM}{$FACTURADO}{$OFICINAID}{$USUARIOID}
            <td><label>Tipo Servicio:</label></td> <td>{$TIPOSERVICIOID}</td>
            <td><label>Tipo Envio:</label></td> <td>{$TIPOENVIOID}</td>
            <td><label>Fecha Guia:</label></td> <td>{$FECHAGUIA}{$HORAGUIA}</td>          
          </tr>
          <tr>
            <td><label>Guia No.:</label></td> <td>{$PREFIJO}-{$NUMEROGUIA}</td>
            <td><label>Forma Pago:</label></td> <td>{$FORMAPAGOID}</td>
            <td><label>Estado:</label></td> <td>{$ESTADOMENSAJERIAID}</td>
          </tr>
          <tr>          
          <tr >
            <td><label>Foto Cumplido:</label></td>
            <td colspan="5">{$FOTO_CUMPLIDO}</td>
          </tr> 		  	          
       </table>
    </fieldset>
    	<fieldset class="section">
		<legend>PRODUCTO</legend>
		<div align="center">
			<div >
				<table id="tableGuia" width="98%">
					<tr>
						<td width="350"><label>DICE CONTENER</label></td>
						<td width="350"><input type="hidden" name="item" id="item" value="1" /><input type="hidden" name="detalle_guia_encomienda_id" id="detalle_guia_encomienda_id" value=""/><input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value=""/>{$PRODUCTO}</td>
						<td><label>CANT.</label></td>
						<td width="200">{$CANTIDAD}</td>
						<td><label>PESO</label></td>
						<td>{$PESONETO}</td>
						<td><label>UNIDAD.</label></td>
						<td width="300">{$MEDIDAID}</td>
					</tr>
					<tr>
						<td><label>LARGO(cm)</label></td>
						<td>{$LARGO}</td>
						<td><label>ANCHO(cm)</label></td>
						<td>{$ANCHO}</td>
						<td><label>ALTO(cm)</label></td>
						<td>{$ALTO}</td> 
						<td><label>PESO VOL</label></td>
						<td>{$PESOVOLUMEN} Kg</td>
					</tr>
					<tr>
						<td><label>GUIA CLIENTE/BOLSA</label></td>
						<td>{$GUIACLIENTE}</td>
						<td><label>VR. DECLARADO</label></td>
						<td>{$VALORDECLARADO}</td>
						<td><label>OBSERVACION</label></td>
						<td>{$OBSERVACIONES}</td>
						<td>&nbsp;</th><td>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</fieldset>

	<fieldset class="section">
		<legend>Datos Envio</legend>
        <table align="center" width="100%">
		  <tr>           
           <td> <table align="center" width="90%">
                  <tr> <td colspan="2" align="center"><label>DATOS DEL REMITENTE</label></td> </tr>
				  <tr> <td><label>Documento:</label></td><td>{$DOCUMENTOREMITENTE}{$TIPOIDENTIFICACIONREMITENTEID}<span style="display:none;">{$TIPOIDENTIFICACIONID}</span></td> </tr>                                      
				  <tr> <td><label>Origen:</label></td> <td>{$ORIGEN}{$ORIGENID}</td> </tr>
				  <tr> <td><label>Nombre Remitente:</label></td> <td>{$REMITENTE}{$REMITENTEID}</td> </tr>
				  <tr> <td><label>Direccion:</label></td> <td>{$DIRECCIONREMITENTE}</td> </tr>
				  <tr> <td><label>Telefono:</label></td> <td>{$TELEFONOREMITENTE}</td> </tr>
				  <!-- <tr> <td><label>E-mail:</label></td> <td>{$CORREOREMITENTE}</td> </tr>                   -->
                  <tr> <td>&nbsp;</td><td>&nbsp;</td> </tr>
				</table>
			</td>
            <td> <table align="center" width="90%"> 
                  <tr> <td colspan="2" align="center"><label>DATOS DEL DESTINATARIO</label></td> </tr>
				  <tr> <td><label>Documento:</label></td> <td>{$DOCUMENTODESTINATARIO}{$TIPOIDENTIFICACIONDESTINATARIOID}</td> </tr>  
                  <tr> <td><label>Destino:</label></td> <td>{$DESTINO}{$DESTINOID}</td> </tr>
				  <tr> <td><label>Nombre Destinatario:</label></td> <td>{$DESTINATARIO}{$DESTINATARIOID}</td> </tr>                                                   
				  <tr> <td><label>Direccion:</label></td> <td>{$DIRECCIONDESTINATARIO}</td> </tr>
				  <tr> <td><label>Telefono:</label></td> <td>{$TELEFONODESTINATARIO}</td> </tr>
				  <!-- <tr> <td><label>E-mail:</label></td> <td>{$CORREODESTINATARIO}</td> </tr>                   -->
                   <tr> <td><label>Nombre Quien Recibe:</label></td> <td>{$RECIBE}</td> </tr>
				</table>
			</td>
			<td valign="top">
				<table align="center" width="90%">
				  <tr> <td colspan="2" align="center"><label>COSTOS DEL ENVIO</label></td> </tr>  
				  <tr> <td colspan="2" align="center">&nbsp;</td> </tr>         
				  <tr> <td><label>Valor Flete:</label></td><td>{$VFLETE}</td> </tr>
				  <tr> <td><label>Seguro (% Vr. Declarado):</label></td><td>{$VSEGURO}</td> </tr>
				  {*<tr> <td><label>Costo Manejo:</label></td><td>{$COSTOMANEJO}</td> </tr>*}                  
				  <tr> <td><label>Otros:</label></td><td>{$VOTROS}</td> </tr>
				  <tr> <td><label>VALOR TOTAL:</label></td><td>{$VTOTAL}</td> </tr>
		    	  <td colspan="2" align="center">&nbsp;</td> </tr>         
				  <tr> <td colspan="2" align="center">&nbsp;</td> </tr>                    
				</table>
			</td>
		  </tr>	
		</table>
		</fieldset>	
        {*
	<fieldset class="section">
        <legend>Observaciones</legend>
        <table align="center" width="70%">
          <tr> <td align="center" valign="top"><label>Observaciones:</label></td> <td>{$OBSERVACIONES}</td> </tr>
          <tr> <td align="center" valign="top"><label>Motivo Devolucion:</label></td> <td>{$MOTIVODEVOLUCIONID}</td> </tr>          
                    <tr> <td align="center" valign="top"><label>Fecha entrega:</label></td> <td>{$FECHAENTREGA}</td> </tr>
        </table>
        </table>
    </fieldset> 
           	*}
		<table align="center">
	      <tr>
	        <td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}</td>
          </tr>
      </table>
      {$FORM1END}
    </fieldset>
	
	<div id="rangoImp">
      <div align="center">
	    <p align="center">
	      <fieldset class="section">
		  <table id="tableGuia">
		    <tr> <td> <b>Desde:&nbsp;</b>{$RANGODESDE} <b>&nbsp;&nbsp;&nbsp;Hasta:&nbsp;</b>{$RANGOHASTA}&nbsp;&nbsp;&nbsp;<b>Formato: </b>{$FORMATO} </td> </tr>
		    <tr> <td> <b>Orden Servicio:&nbsp;</b>{$ORDENSERVICIO} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha Creaci&oacute;n Guias: </b>{$FECHAGUIACREA} </td> </tr>            
			 <tr> <td>&nbsp;</td> </tr>
			 <tr> <td align="center">{$PRINTCANCEL}{$PRINTOUT}</td> </tr>
		  </table>
          </fieldset>
		</p>
	  </div>
	</div>		
    
    <fieldset>
      {$GRIDGUIA}
    </fieldset>
	
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