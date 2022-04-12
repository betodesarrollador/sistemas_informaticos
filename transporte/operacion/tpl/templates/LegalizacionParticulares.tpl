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
	      <td><label>N Orden Particular :</label></td><td>{$MANIFIESTO}{$MANIFIESTOID}</td>
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
		 
		 <fieldset class="section">
		 <legend>Costos de Viaje</legend>
		   <table width="100%">
		     <tr>
			   <td>
     
		 
				 <div id="divLegalizacion" align="center">
				  <table id="tableLegalizacion" width="90%">
				   <thead>
					<tr>
					 <th width="103">ANTICIPO</th>	 
					 <th width="126">CONDUCTOR</th>	 
					 <th width="120">VALOR</th>	 	 	 	 	 
					</tr>
					</thead>
					
					<tbody>
					 <tr id="rowAnticipos">
  					   <td class="content" align="center">
					     <input type="hidden" name="anticipos" id="anticipos_particular_id" value="" />
					     <input type="text" name="anticipos" id="numero" value="" size="2" readonly />
					   </td>	 
					   <td class="content" align="center">
					     <input type="text" name="anticipos" id="conductor" value="" size="37" readonly />
						 <input type="hidden" name="anticipos" id="conductor_id" value="" />
					   </td>	 
					   <td class="content"><input type="text" name="anticipos" id="valor" value="" class="" readonly /></td>	 	 	 	 	 
					 </tr>
					  <tr class="title">
					    <td  colspan="2" align="right"><b>TOTAL ANTICIPOS :</b></td>
					    <td  ><input type="text" name="total_anticipos" id="total_anticipos" value="" readonly /></td>
					  </tr>
					<tr class="title">
					 <td width="103" align="center"><b>CONCEPTO</b></td>	 
					 <td width="126" align="center"><b>PROVEEDOR</b></td>	 
					 <td width="120" align="center"><b>VALOR</b></td>	 	 	 	 	 
					</tr>					  
					 <tr id="rowCostos">
					   <td class="content" align="center">
					    <select name="costos_viaje" id="detalle_parametros_legalizacion_id">
						  <option value="NULL">(... Seleccione ...)</option>
					    {foreach name=costosviaje from=$COSTOSVIAJE item=c}
						  <option value="{$c.detalle_parametros_legalizacion_id}">{$c.nombre_cuenta}</option>
					    {/foreach}
						</select>   					   
					   </td>	 
					   <td class="content" align="center">
					     <input type="text" name="costos_viaje" id="tercero" value="" size="37" />
					     <input type="hidden" name="costos_viaje" id="tercero_id" value="" size="37" />						 
					   </td>	 
					   <td class="content" valign="middle">
					     <input type="text" name="costos_viaje" id="valor" value="" size="17" />&nbsp;&nbsp;<input type="button" name="add" id="add" value=" + " />
					   </td>	 
					 </tr>	 	 	 	 
					 <tr class="title">
					  <td colspan="2" align="right"><b>TOTAL COSTOS VIAJE :</b></td>
					  <td><input type="text" id="total_costos_viaje" name="total_costos_viaje" value="" readonly /></td>
					 </tr>
                    <tr class="title">
					 <td align="right" colspan="2"><b>DIFERENCIA :</b></td>	 
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
		   <tr><td colspan="4">{$GUARDAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
		   </tr>
		 </table>
		 
		 
        {$FORM1END}
    </fieldset>
    
    <fieldset>
      {*{$GRIDIMPUESTOS}*}
    </fieldset>
    
  </body>
</html>
