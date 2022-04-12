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
    <legend>{$TITLEFORMS}</legend>
    <div id="divSolicitudRemesa"><iframe id="iframeSolicitudRemesa"></iframe>
    </div>
	<div id="table_find">
      <table align="center" width="100%"><tr><td><label>Busqueda :</label></td><td>{$BUSQUEDA}</td><td align="right">{$IMPORTARSOLICITUD}&nbsp;&nbsp;&nbsp;</td></tr></table>
    </div>

   {$OFICINAIDSTATIC} {$FECHA}{$ASEGURADORAIDSTATIC}{$NUMEROPOLIZASTATIC}{$FECHAVENCEPOLIZASTATIC}{$FORM1}{$DETALLESSID}		
	<fieldset class="section">
        <legend>Informacion general</legend>
        <table align="center" width="85%">
          <tr>
            <td><label>Tipo Remesa :</label></td>
            <td>{$TIPOREMESA}{$REMESAID}{$OFICINAID}{$FECHAREGISTRO}</td>
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
              {$PROPIETARIO}{$PROPIETARIOTXT}{$PROPIETARIOID}{$TIPOIDENTIFICACIONPROPIETARIO}{$NUMEROIDENTIFICACIONPROPIETARIO}			</td>
            <td><label>Planilla : </label></td>
            <td>{$PLANILLA}</td>
          </tr>  
		  
          <tr >
            <td><label>Clase Remesa  :</label></td>
            <td>{$CLASEREMESA}</td>
            <td><label>Remesa Padre :</label></td>
            <td>{$NUMEROREMESAPADRE}</td>
          </tr> 
		  
		  
          <tr >
            <td><label>Fecha Recogida :</label></td>
            <td>{$FECHARECOGIDA}</td>
            <td><label>Hora Recogida :</label></td>
            <td>{$HORARECOGIDA}</td>
          </tr>
          <tr >
            <td><label>Reportar :</label></td>
            <td>{$NACIONAL}</td>
            <td><label>Estado :</label></td>
            <td>{$ESTADO}</td>
          </tr>
          <tr >
            <td><label>Planilla(s):</label></td>
            <td>{$MANIFIESTOS}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td><label>Fecha Vencimiento :</label></td>
            <td>{$FECHAVENCEPOLIZA}</td>
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
					<td><label>Remitente :</label></td>
					<td>{$REMITENTE}{$REMITENTEID}{$TIPOIDENTIFICACIONREMITENTEID}</td>
				  </tr>
				  <tr>
					<td><label>Origen :</label></td><td>{$ORIGEN}{$ORIGENID}</td>
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
				    <td><label>Orden Despacho : </label></td>
				    <td>{$ORDENDESPACHO}</td>
			      </tr>
				</table>
			</td>
			<td>
				<table align="center" width="100%">
				  <tr>
					<td><label>Destinatario :</label></td>
					<td>{$DESTINATARIO}{$DESTINATARIOID}{$TIPOIDENTIFICACIONDESTINATARIOID}</td>
				  </tr>
				  <tr>
					<td><label>Destino :</label></td><td>{$DESTINO}{$DESTINOID}</td>
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
		 <legend>PRODUCTOS</legend>

         <div align="center">            
		 
			 <div id="divProductos">
			  <table  id="tableRemesas">
			   <thead>
				<tr>
				 <th width="103">REFERENCIA</th>	 
				 <th width="126">DESCRIPCION</th>	 
				 <th width="45">CANT</th>	 	 	 	 	 
				 <th width="56">PESO</th>	 	 
				 <th width="59">VALOR</th>	 	 	 	 	 	 	 
				 <!--<th width="64">LARGO</th>
				 <th width="61">ANCHO</th>
				 <th width="53">ALTO</th>-->
				 <th width="56">PESO VOL</th>
				 <th width="73">ORDEN DESPACHO </th>	 	 	 	 	 	 	 
				 <th width="144">OBSERV</th>	 	 	 	 	 	 	 	 
				 <th width="42">&nbsp;</th>
				</tr>
				</thead>
				
				<tbody>
			
				<tr>
				 <td>
				   <input type="hidden" name="item" id="item" value="1" />            				 				 
				   <input type="hidden" name="detalle_remesa_id" id="detalle_remesa_id" value="" />            
				   <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value="" />	   
				   <input size="30" type="text" name="referencia_producto"   id="referencia_producto"  value="" class="required" />				   
				 </td> 	 	 
				 <td><input type="text" name="descripcion_producto_detalle" id="descripcion_producto_detalle" size="20" value=""  /></td>
				 <td><input type="text" name="cantidad_detalle"  id="cantidad_detalle" size="10" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 
				 <td><input type="text" name="peso_detalle"  id="peso_detalle" size="10" value="" class="required numeric saltoscrolldetalle" /></td>	 
				 <td><input type="text" name="valor_detalle" size="15" id="valor_detalle" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 	 	 	 
				 <!--<td><input type="text" name="largo" size="2" id="largo" value="" class="numeric saltoscrolldetalle" /></td>
				 <td><input type="text" name="ancho" size="2" id="ancho" value="" class="numeric saltoscrolldetalle" /></td>
				 <td><input type="text" name="alto" size="2" id="alto" value="" class="numeric saltoscrolldetalle" /></td>-->	 
				 <td><input type="text" name="peso_volumen_detalle"  id="peso_volumen_detalle" size="10" value="" class="required numeric saltoscrolldetalle" /></td>	 	  	 
				 <td><input type="text" name="guia_cliente" id="guia_cliente" value="" class="saltoscrolldetalle" /></td>	 	 	 
				 <td><input type="text" name="observaciones" id="observaciones" value="" class="saltoscrolldetalle" /></td>	 	 	 	 	 
				 <td><a name="saveDetalleRemesa" href="javascript:void(0)"><img name="add" src="../../../framework/media/images/grid/add.png" /></a></td>
				</tr>   
				</tbody>
			  </table>
			  <table>
				<tr id="clon">
				 <td>
				   <input type="hidden" name="item" id="item" value="" />            				 				 
				   <input type="hidden" name="detalle_remesa_id" id="detalle_remesa_id" value="" />            
				   <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value="" />	   
				   <input type="text" name="referencia_producto" size="30"  id="referencia_producto"  value="" class="required" />				   
				 </td> 	 	 
				 <td><input type="text" name="descripcion_producto_detalle" id="descripcion_producto_detalle" size="20" value=""  /></td>
				 <td><input type="text" name="cantidad_detalle"  id="cantidad_detalle" size="10" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 
				 <td><input type="text" name="peso_detalle"  id="peso_detalle" size="10" value="" class="required numeric saltoscrolldetalle" /></td>	 
				 <td><input type="text" name="valor_detalle" size="15" id="valor_detalle" value="" class="required numeric saltoscrolldetalle" /></td>	 	 	 	 	 	 
				 <!--<td><input type="text" name="largo" size="2" id="largo" value="" class="numeric saltoscrolldetalle" /></td>
				 <td><input type="text" name="ancho" size="2" id="ancho" value="" class="numeric saltoscrolldetalle" /></td>
				 <td><input type="text" name="alto" size="2" id="alto" value="" class="numeric saltoscrolldetalle" /></td>-->	 
				 <td><input type="text" name="peso_volumen_detalle"  id="peso_volumen_detalle" size="10" value="" class="required numeric saltoscrolldetalle" /></td>	 	  	 
				 <td><input type="text" name="guia_cliente" id="guia_cliente" value="" class="saltoscrolldetalle" /></td>	 	 	 
				 <td><input type="text" name="observaciones" id="observaciones" value="" class="saltoscrolldetalle" /></td>	 	 	 	 	 
				 <td><a name="saveDetalleRemesa" href="javascript:void(0)"><img name="add" src="../../../framework/media/images/grid/add.png" /></a></td>
				</tr>
			  </table>  
		   </div>
	    </div>

		</fieldset>

		<fieldset class="section">
		 <legend>Datos Producto</legend>
		 <table width="85%" align="center" id="dataProducto" >
           <tr>
             <td width="18%"><label>Producto  :</label></td>
             <td width="32%" colspan="3">{$PRODUCTOID}{$PRODUCTO}&nbsp;
			 <img id="reloadListProductos" src="../../../framework/media/images/grid/load.png" style="cursor:pointer" /></td>
           </tr>
           <tr>
             <td><label>Naturaleza :</label></td>
             <td>{$NATURALEZA}</td>
             <td><label>Unidad Empaque :</label></td>
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
		  <legend>Liquidacion</legend>
		  <table align="center">
		    <tr>		  
			  <td><label>Tipo Liquidacion :</label></td><td>{$TIPOLIQUIDACION}</td>
			  <td><label>Valor Unidad :</label></td><td>{$VALORUNIDADFACTURAR}</td>			  
			  <td><label>Valor Facturar:</label></td><td>{$VALORFACTURAR}</td>				  
			</tr>
		  </table>
		</fieldset>		
		
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
		  <table>
		    <tr>
			  <td>
			    <b>Desde :&nbsp;</b>{$RANGODESDE} <b>&nbsp;&nbsp;&nbsp;Hasta :&nbsp;</b>{$RANGOHASTA}&nbsp;&nbsp;&nbsp;<b>Formato :</b>{$FORMATO}
			  </td>
			 </tr>
			 <tr><td colspan="2">&nbsp;</td></tr>
			 <tr>
			   <td align="center">{$PRINTCANCEL}{$PRINTOUT}</td>
			 </tr>
		  </table>
		</p>
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