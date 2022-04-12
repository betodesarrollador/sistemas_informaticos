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
	    {$LEGALIZACIONID}{$ENCABEZADOREGISTROID}{$USUARIOID}{$USUARIO}{$OFICINAID}{$BANDERA}
        <fieldset class="section">	
		  <legend>Datos Legalizacion	
	
	  </legend><table width="80%" align="center">
	    <tr>
	      <td><label>N Documento :</label></td>
	      <td>{$NUMERODOCUMENTO}</td>
	      <td><label>Fecha :</label></td><td>{$FECHA}{$TIPO_DOC}</td>
	    </tr>
	    <tr>
	      <td><label>Concepto:</label></td>
          <td>{$CONCEPTO}</td>
	      <td><label>Estado</label></td>
          <td>{$ESTADO}</td>          
        </tr>
	  </table>	
	</fieldset>	
    
    <fieldset class="section">
    <legend>Costos de Legalización</legend>
    <table width="100%">
    <tr> 
    <td>		 
    <div id="divLegalizacion" align="center">
    <table id="tableLegalizacion" width="90%">

    <thead>
      <tr>
        <th width="103" colspan="2" align="center"><b>CONCEPTO</b></th>	 
        <th width="126" align="center"><b>PROVEEDOR</b></th>
        <th width="126" align="center"><b>DETALLE</b></th>
        <th width="76" align="center"><b>FECHA</b></th>
        <th width="95" align="center"><b>CENTRO COSTO</b></th>	 
        <th width="135" align="center"><b>VALOR</b></th> 	 	 	 	 
      </tr>
    </thead>
       	
    <tbody>
      <tr id="rowCostos" class="rowCostos">
        <td colspan="2" align="left" class="content">
          <select style="width:200px;" name="costos_legalizacion_caja" id="detalle_parametros_legalizacion_caja_id">
          <option value="NULL">(... Seleccione ...)</option>
          {foreach name=costoslegalizacion from=$COSTOSLEGALIZACION item=c}
          <option value="{$c.detalle_parametros_legalizacion_caja_id}">{$c.nombre_cuenta}</option>
          {/foreach}
          </select>					   
        </td>	 
        <td class="content" align="center">
          <input type="text" name="costos_legalizacion_caja" id="tercero" value="" size="40" />
          <input type="hidden" name="costos_legalizacion_caja" id="tercero_id" value="" size="40" />	
        </td>	
        <td class="content" valign="middle">            
          <input type="text" name="costos_legalizacion_caja" id="detalle_costo" value="" size="30" />
        </td>	
        <td class="content" valign="middle">            
          <input type="text" name="costos_legalizacion_caja" id="fecha" value="" size="12" class="date" />
        </td>	

        <td align="left" class="content">
          <select name="costos_legalizacion_caja" id="centro_de_costo_id" style="width:130px;">
          <option value="NULL">(... Seleccione ...)</option>
          {foreach name=centrocosto from=$CENTROCOSTO item=c}
          <option value="{$c.centro_de_costo_id}">{$c.nombre}</option>
          {/foreach}
          </select>					   
        </td>                 
        <td class="content" valign="middle">            
          <input type="text" name="costos_legalizacion_caja" id="valor" class="numeric" value="" size="12" style="text-align:right;"/>
          <input type="button" name="add" id="add" value=" + " />
        </td>	 
      </tr>	
      
      	      
      <tr class="title">
        <td colspan="5" align="right"><b>TOTAL COSTOS LEGALIZACIÓN :</b></td>
        <td><input type="text" id="total_costos_legalizacion_caja" name="total_costos_legalizacion_caja" value="" readonly /></td>
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
		     <td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$LEGALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$ANULAR}</td>
		   </tr>
		 </table>		 
        {$FORM1END}
    </fieldset>    
    <fieldset> {$GRIDLEGALIZACIONCAJA} </fieldset> 
    <div id="divAnulacion">
      <form>
        <table>       
          <tr>
            <td><label>Fecha / Hora :</label></td>
            <td>{$FECHALOG}{$ANULUSUARIOID}{$ANULOFICINAID}</td>
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
