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
        <table align="center" width="100%">
          <tr>
            <td><label>Numero Documento :</label></td>
            <td>{$NUMSOPORTE}{$PLANTESOID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$ENCABEZADOID}</td>
			<td>&nbsp;</td>  
            <td>&nbsp;</td>           
          </tr>
          <tr>
            <td><label>Tipo Servicio :</label></td>
            <td>{$TIPOBIENSERVICIOID}</td>
            <td><label>Fecha :</label></td>
            <td>{$FECHA}</td>
          </tr>
          <tr>
            <td><label>Proveedor : </label></td>
            <td>{$PROVEEDOR}{$PROVEEDORID}</td>
            <td><label>Nit / Identificaci&oacute;n :</label></td>
            <td>{$PROVEEDORNIT}</td>
          </tr>
          <tr>
            <td><label>Forma de Pago:</label></td>
            <td>{$FPAGO}</td>
            <td><label>Nº. Soporte/Cheque :</label></td>
            <td>{$CODFACPRO}</td>
          </tr>
          
          <tr>
            <td><label>CONCEPTO :</label></td>
            <td >{$CONCEPTO}</td>
            <td><label>Valor a Pagar:</label></td>
            <td>{$VALOR}</td>
          </tr>
          <tr>
            <td ><span id="cheques1"><label>RELACION CHEQUES: <img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar Cheques Pendientes de consignacion"/></label></span></td>
            <td ><span id="cheques2">{$CHEQUES}</span>{$CHEQUES_IDS}</td>
            <td><label>Estado:</label></td>
            <td>{$ESTADO}</td>
            
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><table width="100%">
              <tr>
                <td id="loading" width="15%">&nbsp;</td>
                <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}</td>
                <td width="15%" align="right" ><img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/></td>
                <td width="15%" align="right" > <input name="button2" type="button" class="buttonDetalle" id="deleteDetallesPlantillaTesoreria" value="Borrar Detalles" /></td>
              </tr>
            </table></td>
          </tr>
        </table>
		<table width="100%">
			<tr><td colspan="7"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
          	<tr>
                <td align="left" width="20%">&nbsp;</td>
                <td align="center" width="30%"><b>Ctrl+t = Tercero Ctrl+c=Concepto</b></td>
                <td align="right"  width="10%"></td>
                <td width="10%"><label>DEBITO :</label></td>
                <td width="10%"><span id="totalDebito">0</span></td>
                <td width="10%"><label>CREDITO:</label></td>
                <td width="10%"><span id="totalCredito">0</span></td>
                
            </tr>    
		</table>        
		{$FORM1END}
       <div id="divSolicitudCheques">
            <iframe id="iframeSolicitud"></iframe>
        </div>

	</fieldset>
	<fieldset>{$GRIDCAUSAR}</fieldset>   
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