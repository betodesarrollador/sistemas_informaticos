<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css"> 
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
		<div id="table_find">
        <table align="center">
        <tr>
        <td><label>Busqueda : </label></td>
        </tr>
         <tr>
        <td>{$BUSQUEDA}</td>
        </tr>
        </table>
        </div>    
        {$FORM1}
        <fieldset class="section">
        <table align="center" width="90%">
		    <tr>
			  <td><label>Causaci&oacute;n:<label></td>
			  <td >{$NUMSOPORTE}{$CAUSARID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$NPAGOS}{$ENCABEZADOID}</td>
			  <td><label>Estado:<label></td>
			  <td >{$ESTADO}</td>
                  
			</tr>
            <tr style="display: none;">
                <td><label>Fuente : </label></td>
                <td>{$FUENTEID}{$FUENTE}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><label>Fecha Factura: </label></td>
                <td>{$FECHAFACPRO}</td>
                <td><label>Fecha Vencimiento: </label></td>
                <td>{$VENCEFACPRO}</td>
            </tr>

            <tr>
                <td><label>Comercial: </label></td>
                <td>
	                {$COMERCIAL}{$COMERCIALID}
                 </td>
                <td><label>Nit / Identificaci&oacute;n : </label></td>
                <td>{$PROVEEDORNIT}</td>
            </tr>
            <tr>
                <td><label>Buscar: </label></td>
                <td ><img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar" />{$CONCEPTO}{$CONCEPTOITEMS}</td>
                <td><label>CONCEPTO: </label></td>
                <td >{$CONCEPTOFAC}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td >&nbsp;</td>
                <td><label>Valor : </label></td>
                <td>{$VALOR}</td>
            </tr>

            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
                            <td width="15%" align="right" >
                                <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
		<table width="100%">
			<tr><td colspan="7"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
          	<tr>
                <td align="left" width="20%">{$CONTABILIZAR}</td>
                <td align="center" width="30%"><b>Ctrl+t = Tercero Ctrl+c=Concepto</b></td>
                <td align="right"  width="10%"></td>
                <td width="10%"><label>DEBITO :</label></td>
                <td width="10%"><span id="totalDebito">0</span></td>
                <td width="10%"><label>CREDITO:</label></td>
                <td width="10%"><span id="totalCredito">0</span></td>
                
            </tr>    
		</table>        
		{$FORM1END}
        <div id="divSolicitudFacturas">
            <iframe id="iframeSolicitud" style="height: 310px;"></iframe>
        </div>
                  
	</fieldset>
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
