<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="/rotterdan/framework/css/bootstrap.css">
  {$CSSSYSTEM}
  {$TABLEGRIDCSS}   
  {$JAVASCRIPT}
  {$TABLEGRIDJS}  
  {$TITLETAB}  
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        {$FECHASTATIC}
        {$FORM1}
	    {$ENCABEZADOREGISTROID}{$LIQUIDACIONID}{$USUARIOID}{$USUARIO}
        <fieldset class="section">	
		  <legend>Datos Manifiesto</legend>	
	
	  <table width="80%" align="center">
	    <tr>
	      <td><label>N Manifiesto :</label></td><td>{$MANIFIESTO}{$MANIFIESTOID}</td>
	      <td><label>Fecha :</label></td><td>{$FECHA}</td>
	    </tr>
	    <tr>
	      <td><label>Tenedor :</label></td><td>{$TENEDOR}{$TENEDORID}</td>
	      <td><label>Vehiculo :</label></td><td>{$PLACA}{$PLACAID}</td>
	    </tr>
	    <tr>
	      <td><label>Origen :</label></td><td>{$ORIGEN}{$ORIGENID}</td>
	      <td><label>Destino :</label></td><td>{$DESTINO}{$DESTINOID}</td>
	    </tr>
	    <tr>
	      <td><label>Concepto:</label></td>
	      <td>{$CONCEPTO}</td>
	      <td valign="top"><label>Documento Contable:</label></td>
	      <td valign="top">{$DOCCONTABLE}</td>
          
	    </tr>
	    <tr>
	      <td valign="top"><label>Estado :</label></td>
	      <td valign="top">{$ESTADO}</td>
	      <td valign="top"><label>Observaciones :</label></td>
	      <td valign="top">{$OBSERVACIONES}</td>
        </tr>
	  </table>
	
	</fieldset>
		 
		 <fieldset class="section">
		 <legend>Liquidacion Descuentos</legend>
		   <table width="100%">
		     <tr>
			   <td>
                 <div align="center">
     		 	 <table id="tiempos_reg"  width="94%">
  				   <thead>
                   	<tr  class="title">
                   	<td colspan="8">TIEMPOS DESCARGUE </td>
                    </tr>
                   	<tr  class="title">
                   	<td>FECHA LLEGADA </td>
                    <td>HORA LLEGADA </td>
                   	<td>FECHA ENTRADA </td>
                    <td>HORA ENTRADA </td>
                   	<td>FECHA SALIDA </td>
                    <td>HORA SALIDA </td>
                    <td>CLIENTE </td>
                    <td>PLACA</td>                    
                    </tr>
				   </thead>					

                   <tbody>
					 <tr id="rowTiempos" class="rowTiempos">
					   <td width="18%" align="center" class="title">
	                        <input type="hidden"  name="tiempos" id="tiempos_clientes_remesas_id" value=""  />
                       		<input type="text" size="10" name="tiempos" id="fecha_llegada_descargue" value="" class="date required" />
                       </td>					 
					   <td width="18%" align="center" class="title"><input type="text" size="6" name="tiempos" id="hora_llegada_descargue" onkeyup = "separateTime(this,this.value)" value="" class="time required"  /></td>					 
					   <td width="16%" align="center" class="title"><input type="text" size="10" name="tiempos" id="fecha_entrada_descargue"  value="" class="date required"  /></td>					 
					   <td width="16%" align="center" class="title"><input type="text" size="6" name="tiempos" id="hora_entrada_descargue" onkeyup = "separateTime(this,this.value)" value="" class="time required"  /></td>			
                       <td width="16%" align="center" class="title"><input type="text" size="10" name="tiempos" id="fecha_salida_descargue" value="" class="date required"  /></td>					 
                       <td width="16%" align="center" class="title"><input type="text" size="6" name="tiempos" id="hora_salida_descargue"  onkeyup = "separateTime(this,this.value)" value="" class="time required"  /></td>					 

                       <td width="16%" align="center" class="title"><input type="text" size="15" name="tiempos" id="clientess" value="" class=""  readonly /></td>					 
                       <td width="16%" align="center" class="title"><input type="text" size="15" name="tiempos" id="placa" value="" class="" readonly /></td>					 

					 </tr>
                 	</tbody>
                 </table>
                
                
                 </div>
               
               	<div align="center">
     		 	 <table id="remesas_reg"  width="94%">
  				   <thead>
                   	<tr  class="title">
                   	<td>REMESA</td>
                    <td>CLIENTE</td>
                    <td>PRODUCTO</td>
                    <td>UNIDAD</td>
                    <td>CANT/GLS</td>
                    <td>PESO</td>
                    <td>VOLUMEN</td>
                    <td>TIPO LIQ</td>
                    <td>COSTO UNI</td>
                    <td>COSTO TOTAL</td>
                    </tr>
				   </thead>					

                   <tbody>
					 <tr id="rowRemesa" class="rowRemesa">
					   <td width="6%" align="center" class="title">
	                        <input type="hidden"  name="remesa" id="remesa_id" value=""  />
   	                        <input type="hidden"  name="remesa" id="estado" value=""  />
   	                        <input type="hidden"  name="remesa" id="valor_facturar" value=""  />                            
                       		<input type="text" size="7" name="remesa" id="numero_remesa" value="" class="" readonly />
                       </td>					 
					   <td width="15%" align="center" class="title"><input type="text" size="15" name="remesa" id="cliente" value="" class="" readonly /></td>					 
					   <td width="15%" align="center" class="title"><input type="text" size="15" name="remesa" id="producto" value="" class="" readonly /></td>					 
					   <td width="10%" align="center" class="title"><input type="text" size="6" name="remesa" id="unidad" value="" class="" readonly /></td>			
                       <td width="10%" align="center" class="title"><input type="text" size="5" name="remesa" id="cantidad" value="" class=""  /></td>					 
                       <td width="10%" align="center" class="title"><input type="text" size="5" name="remesa" id="peso" value="" class=""  /></td>					 
                       <td width="10%" align="center" class="title"><input type="text" size="5" name="remesa" id="peso_volumen" value="" class=""  /></td>					 
                       <td width="10%" align="center" class="title">
                           <select name="remesa" id="tipo_liquidacion" >
                             <option value="NULL">( Seleccione )</option>
                             <option value="G" >Cant/Gls</option>
                             <option value="P" >Peso</option>
                             <option value="V" >Volumen</option>		 
                             <option value="C" >Cupo</option>		 		 
                           </select>
                       
                       </td>					 
                       <td  class="title"><input type="text" name="remesa" id="valor_unidad_costo" class="numeric" size="10"  value=""/></td>          	 	 	 	 	 
                       <td  class="title"><input type="text" name="remesa" id="valor_costo"  class="numeric"   size="10"      value=""/></td>          	 	 	 	 	 	 

					 </tr>
					</tbody>
				</table>
                <table width="94%">                    
                    <tbody>                     
					 <tr class="title">
					   <td width="50%"  colspan="4" align="right"><b>TOTALES :</b></td>
					   <td width="8%">{$CANT_GAL}</td>
					   <td width="7%">{$CANT_PESO}</td>
					   <td width="7%">{$CANT_VOL}</td>
                       <td width="30%" colspan="2">&nbsp;</td>
					   <td width="10%">{$VALOR_GAL}</td>

					 </tr>                    
                 	</tbody>
                 </table>
				 </div>                
     		 
				 <div id="divLiquidacionDescu" align="center">
				  <table id="tableLiquidacionDescu" width="94%">
				   <thead>
					</thead>					
					<tbody>					
					
					 <tr id="rowDescuentos" class="rowDescuentos">
  					   <td class="title" align="center">Descuento</td>	 
					   <td class="content" align="center">
					     <input type="hidden" name="descuentos" id="descuentos_manifiesto_id" value="" />
					     <input type="hidden" name="descuentos" id="descuento_id" value="" />						 						 
					     <input type="text" name="descuentos" id="nombre" value="" size="37" disabled />
						 <input type="hidden" name="descuentos" id="calculo" value="">					   
					   </td>	 
					   <td colspan="4" class="content">
					     <input type="text" name="descuentos" id="valor" value="" class="" onKeyUp="calcularFlete();" />
                         <input type="hidden" name="descuentos" id="detalle_liquidacion_despacho_descu_id"  value="" />					   
					   </td>	 	 	 	 	 
					 </tr>
									
					 
					</tbody>
                 </table>
                 <table  width="94%">
                    <tbody>
					  <tr class="title">
					    <td  colspan="2" align="right"><b>TOTAL DESCUENTOS :</b></td>
					    <td colspan="4">
						 {$VALOR_DESCU}
						</td>
					  </tr>
                    </tbody>
				  </table>  				  

			  </div>			   	   			   
			   
			   </td>
			 </tr>
		   </table>
		 
		 </fieldset>
		 		 
		 <table align="center">
		   <tr>
		     <td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$REPORTAR}&nbsp;{$CONTABILIZAR}</td>
		   </tr>
		 </table>
		 
        
    
    <div>{$GRIDMANIFIESTOS}</div>
    {$FORM1END}
    </fieldset>
  </body>
</html>
