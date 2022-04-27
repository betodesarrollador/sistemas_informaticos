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
        
        {$FORM1}
		
		<fieldset class="section">		
        <table>
          <tr>
            <td><label>Empresa : </label></td>
            <td>{$EMPRESAID}{$PARAMETROLEGALIZACIONID}</td>
            <td><label>Oficina : </label></td>
            <td>{$OFICINAID}</td>
          </tr>        
          <tr>
            <td width="229" ><label>Documento Contable :</label></td>
            <td width="264" colspan="3">{$DOCUMENTOCONTABLE}</td>
          </tr>  
         </table>		 
		 </fieldset>
		 
		 <fieldset class="section">
		 <legend>Costos de Viaje</legend>
		   <table width="100%">
		     <tr>
			   <td>
     
		 
				 <div id="divProductos" align="center">
				  <table  id="tableRemesas" width="90%">
				   <thead>
					<tr>
					 <th width="103">CODIGO</th>	 
					 <th width="126">NOMBRE</th>	 
					 <th width="45">NATURALEZA</th>	 	 	 	 	 
					 <th width="42">&nbsp;</th>
					</tr>
					</thead>
					
					<tbody>
				
					<tr>
					 <td>
					   <input type="hidden" name="detalle_parametros_legalizacion_id" id="detalle_parametros_legalizacion_id" value="" />            
					   <input type="text" name="puc" size="15"  id="puc"  value="" class="required" />				   
					   <input type="hidden" name="puc_id"   id="puc_id"  value="" class="required" />				   					   
					 </td> 	 	 
					 <td><input type="text" name="nombre_cuenta" size="35" id="nombre_cuenta" value="" class="required" /></td>	 	 	 	 	 	 
					 <td>
					   <select name="naturaleza" id="naturaleza">
						 <option value="D">DEBITO</option>
						 <option value="C">CREDITO</option>
					   </select>
					 </td>	 	 	 	 	 
					 <td><a name="saveDetalleRemesa" href="javascript:void(0)"><img name="add" src="../../../framework/media/images/grid/add.png" /></a></td>
					</tr>   
					</tbody>
				  </table>
				  <table>
					<tr id="clon">
					 <td>
					   <input type="hidden" name="detalle_parametros_legalizacion_id" id="detalle_parametros_legalizacion_id" value="" />            
					   <input type="text" name="puc" size="15"  id="puc"  value="" class="required" />				   
					   <input type="hidden" name="puc_id"   id="puc_id"  value="" class="required" />				   					   
					 </td> 	 	 
					 <td><input type="text" name="nombre_cuenta" size="35" id="nombre_cuenta" value="" class="required" /></td>	 	 	 	 	 	 
					 <td>
					   <select name="naturaleza" id="naturaleza">
						 <option value="D">DEBITO</option>
						 <option value="C">CREDITO</option>
					   </select>
					 </td>	 	 	 	 	 
					 <td><a name="saveDetalleRemesa" href="javascript:void(0)"><img name="add" src="../../../framework/media/images/grid/add.png" /></a></td>
					</tr>  
				  </table>  

			  </div>			   	   			   
			   
			   </td>
			 </tr>
		   </table>
		 
		 </fieldset>
		 		 
		 <fieldset class="section">
		  <legend>Anticipos</legend>
		   <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$CONTRAPARTIDA}{$CONTRAPARTIDAID}</td>
			   <td><label>Nombre :</label></td>
               <td>{$NOMBRECONTRAPARTIDA}</td>			 
			   <td><label>Naturaleza :</label></td>
		       <td>{$NATURALEZACONTRAPARTIDA}</td>
			</tr>			 
		   </table>		   
		 </fieldset>
		 

		 <fieldset class="section">
		  <legend>Diferencia Anticipos Favor Conductor</legend>
		   <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$DIFERENCIACONDUCTOR}{$DIFERENCIACONDUCTORID}</td>
			   <td><label>Nombre :</label></td>
			   <td>{$NOMBREDIFERENCIACONDUCTOR}</td>
			   <td><label>Naturaleza :</label></td>
			   <td>{$NATURALEZADIFERENCIACONDUCTOR}</td>
			 </tr>
		   </table>		   
	     </fieldset>
		 
		 <fieldset class="section">
		  <legend>Diferencia Anticipos Favor Empresa</legend>
		   <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$DIFERENCIAEMPRESA}{$DIFERENCIAEMPRESAID}</td>
			   <td><label>Nombre :</label></td>
			   <td>{$NOMBREDIFERENCIAEMPRESA}</td>
			   <td><label>Naturaleza :</label></td>
			   <td>{$NATURALEZADIFERENCIAEMPRESA}</td>
			 </tr>
		   </table>		   
	     </fieldset>		 
		 
		 <table align="center">
		   <tr><td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td></tr>
		 </table>
		 
		 
        {$FORM1END}
    </fieldset>
    
    <fieldset>
      {$GRIDIMPUESTOS}
    </fieldset>
    
  </body>
</html>
