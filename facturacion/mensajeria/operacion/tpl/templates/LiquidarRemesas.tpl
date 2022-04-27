<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Solicitud de Servicio - Online Tools™</title></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  

    <fieldset>
      <legend>{$TITLEFORM}</legend>
      <div id="table_find">
        <table>
         <tbody><tr>
           <td><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </tbody></table>
    </div>

        {$OFICINAHIDDEN}
        {$OFICINAIDHIDDEN}
        {$FECHASTATIC}
	    {$FORM1}
		<fieldset class="section">
		<legend>Datos Despacho</legend>
        <table width="60%" align="center">
	    <tr>
	      <td width="12%"><label>Manifiesto / Despacho</label></td><td width="53%">{$MANIFIESTODESPACHO}{$MANIFIESTODESPACHOID}</td>
	      <td width="14%">&nbsp;</td><td width="21%">&nbsp;</td>
	    </tr>
	    <tr>
	      <td><label>Fecha :</label></td><td>{$FECHA}</td>
	      <td><label>Vehiculo :</label></td><td>{$PLACA}</td>
	    </tr>
	    <tr>
	      <td><label>Origen :</label></td><td>{$ORIGEN}</td>
	      <td><label>Destino :</label></td><td>{$DESTINO}</td>
	    </tr>
	  </table>
	  </fieldset>
	  
	  <fieldset class="section" style="display:none">
	  <legend>Parametros Liquidacion</legend>
		  <table align="center">
		    <tr>		  
			  <td><label>Tipo Liquidacion :</label></td><td>{$TIPOLIQUIDACION}</td>
			  <td><label>Valor Unidad :</label></td><td>{$VALORUNIDADFACTURAR}</td>			  
			  <td><label>Valor Facturar:</label></td><td>{$VALORFACTURAR}</td>				  
			</tr>
		  </table>	  
	  </fieldset>
	  
	  <div id="messages">&nbsp;</div>
      <div><iframe id="detalleLiquidacionRemesas" class="editableGrid"></iframe></div>
      
      {$FORM1END}
    </fieldset>
    
  </body></html>