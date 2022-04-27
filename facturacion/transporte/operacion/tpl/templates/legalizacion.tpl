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

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        {$FECHASTATIC}
        {$FORM1}
	    {$LEGALIZACIONID}{$ENCABEZADOREGISTROID}{$USUARIOID}{$USUARIO}
        <fieldset class="section">	
		  <legend>Datos Despacho</legend>	
	
	  <table width="80%" align="center">
	    <tr>
	      <td><label>N Manifiesto :</label></td><td>{$MANIFIESTO}{$MANIFIESTOID}</td>
	      <td><label>Fecha :</label></td><td>{$FECHA}</td>
	    </tr>
	    <tr>
	      <td><label>Conductor :</label></td><td>{$CONDUCTOR}{$CONDUCTORID}</td>
	      <td><label>Vehiculo :</label></td><td>{$PLACA}{$PLACAID}</td>
	    </tr>
	    <tr>
	      <td><label>Origen :</label></td><td>{$ORIGEN}{$ORIGENID}</td>
	      <td><label>Destino :</label></td><td>{$DESTINO}{$DESTINOID}</td>
	    </tr>
	    <tr>
	      <td><label>Concepto:</label></td>
          <td colspan="3">{$CONCEPTO}</td>
        </tr>
	  </table>
	
	</fieldset>
		 <!-- inicio parte reportar cumplido-->	
		 <fieldset class="section">
		 <legend>TIEMPOS DESCARGUE</legend>
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
			   </td>
			 </tr>
		   </table>
		 
		 </fieldset>
 		 <!-- fin parte reportar cumplido-->
		 
		 <fieldset class="section">
		 <legend>Costos de Viaje</legend>
		   <table width="100%">
		     <tr>
			   <td>
     
		 
				 <div id="divLegalizacion" align="center">
				  <table id="tableLegalizacion" width="90%">
				   <thead>
					<tr>
					 <th width="50">ANTICIPO</th>	 
					 <th width="51">EGRESO</th>
					 <th width="126">CONDUCTOR</th>	 
					 <th width="120">VALOR</th>	 	 	 	 	 
					</tr>
					</thead>
					
					<tbody>
					 <tr id="rowAnticipos" class="rowAnticipos">
  					   <td align="center" class="content">
					     <input type="text" name="anticipos" id="anticipos_manifiesto_id" value="" />
					     <input type="text" name="anticipos" id="numero" value="" size="2" readonly />					   
					   </td>	 
					   <td align="center" class="content">
					     <input type="text" name="anticipos" id="consecutivo" value="" size="10" readonly />					   					
					   </td>
					   <td class="content" align="center">
					     <input type="text" name="anticipos" id="conductor" value="" size="37" readonly />
						 <input type="hidden" name="anticipos" id="conductor_id" value="" />					   </td>	 
					   <td class="content"><input type="text" name="anticipos" id="valor" value="" class="" readonly /></td>	 	 	 	 	 
					 </tr>
					  <tr class="title">
					    <td  colspan="3" align="right"><b>TOTAL ANTICIPOS :</b></td>
					    <td  ><input type="text" name="total_anticipos" id="total_anticipos" value="" readonly /></td>
					  </tr>
					<tr class="title">
					 <td width="103" colspan="2" align="center"><b>CONCEPTO</b></td>	 
					 <td width="126" align="center"><b>PROVEEDOR</b></td>	 
					 <td width="120" align="center"><b>VALOR</b></td>	 	 	 	 	 
					</tr>					  
					 <tr id="rowCostos" class="rowCostos">
					   <td colspan="2" align="center" class="content">
					    <select name="costos_viaje" id="detalle_parametros_legalizacion_id">
						  <option value="NULL">(... Seleccione ...)</option>
					    {foreach name=costosviaje from=$COSTOSVIAJE item=c}
						  <option value="{$c.detalle_parametros_legalizacion_id}">{$c.nombre_cuenta}</option>
					    {/foreach}
						</select>					   
                        </td>	 
					   <td class="content" align="center">
					     <input type="text" name="costos_viaje" id="tercero" value="" size="37" />
					     <input type="hidden" name="costos_viaje" id="tercero_id" value="" size="37" />					   </td>	 
					   <td class="content" valign="middle">
					     <input type="text" name="costos_viaje" id="valor" value="" size="17" />&nbsp;&nbsp;<input type="button" name="add" id="add" value=" + " />					   </td>	 
					 </tr>	 	 	 	 
					 <tr class="title">
					  <td colspan="3" align="right"><b>TOTAL COSTOS VIAJE :</b></td>
					  <td><input type="text" id="total_costos_viaje" name="total_costos_viaje" value="" readonly /></td>
					 </tr>
                    <tr class="title">
					 <td align="right" colspan="3"><b>DIFERENCIA :</b></td>	 
					 <td ><input type="text" name="diferencia" id="diferencia" value="" readonly /></td>	
                    </tr>
					</tbody>
				  </table>  				  

			  </div>			   	   			   
			   
			   </td>
			 </tr>
		   </table>
		 
		 </fieldset>
		 		 

		 
		 <table align="center">
		   <tr><td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$CONTABILIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$REPORTAR}</td>
		   </tr>
		 </table> 
        {$FORM1END}
		<div style="display:none" id="divDatosFrame"><iframe id="detalleFrameAnticipo" style="height:500px" frameborder="0"></iframe></div>
    	<div style="display:none">
    </fieldset>
    
    <fieldset>
      {*{$GRIDIMPUESTOS}*}
    </fieldset>
    
  </body>
</html>
