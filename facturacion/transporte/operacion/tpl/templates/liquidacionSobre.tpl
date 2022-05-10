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
          <td><label>Lugar  Pago  : </label></td>
          <td>{$OFICINAID}</td>
	    </tr>
	    <tr>
	      <td><label>Documento Contable:</label></td>
	      <td>{$DOCCONTABLE}</td>
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
		 <legend>Liquidacion Sobre Flete</legend>
		   <table width="100%">
		     <tr>
			   <td>
     		 
				 <div id="divLiquidacionSobre" align="center">
				  <table id="tableLiquidacionSobre" width="90%">
				   <thead>
					</thead>					
					<tbody>					
					 
					  <tr class="title">
					    <td  colspan="2" align="right" valign="top"><b>VALOR SOBRE FLETE :</b></td>
					    <td width="17%" valign="top">
						  {$VALORSOBREFLETE}
						  <input type="hidden" name="detalle_liquidacion_valor_sobre_flete_id"  id="detalle_liquidacion_valor_sobre_flete_id" value="" />						 
						</td>
					    <td width="11%" align="right" valign="top"><b>OBSERVACION : </b></td>
					    <td width="28%" align="left">{$OBSERVACIONSOBREFLETE}</td>
					    <td width="5%">&nbsp;</td>
					  </tr>						 
			
					 <tr id="rowImpuestos" class="rowImpuestos">
					   <td width="6%" align="center" class="title">Impuesto</td>					 
  					   <td width="33%" align="center" class="content">
					     <input type="hidden" name="impuestos" id="impuestos_manifiesto_id" value="" />
					     <input type="hidden" name="impuestos" id="impuesto_id" value="" />				
					     <input type="hidden" name="impuestos" id="porcentaje" value="" />										 		 
					     <input type="hidden" name="impuestos" id="formula" value="" />										 		 						
					     <input type="hidden" name="impuestos" id="monto" value="" />	
					     <input type="hidden" name="impuestos" id="base" value="" />							 									 							                         <input type="text" name="impuestos" id="nombre" value="" size="37" disabled />					   
					   </td>	 	 
					   <td colspan="4" class="content">
					     <input type="text" name="impuestos" id="valor" value="" class="" disabled />
                         <input type="hidden" name="impuestos" id="detalle_liquidacion_despacho_sobre_id"  value="" />					   
					   </td>	 	 	 	 	 
					 </tr>
					 					 
					 <tr class="title">
					    <td  colspan="2" align="right"><b>VALOR NETO PAGAR :</b></td>
					    <td   >{$VALORNETO}</td>
                        <td colspan="3" align="left"><input type="button" name="calcularFlete" id="calcularFlete" value="Calcular" class="buttondefault"   /></td>
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
		     <td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}</td>
		   </tr>
		 </table>
		 
        
    
    <div>{$GRIDMANIFIESTOS}</div>
    {$FORM1END}
    </fieldset>
  </body>
</html>
