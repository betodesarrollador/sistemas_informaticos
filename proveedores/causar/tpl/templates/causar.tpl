<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap.css"> 
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
        <legend>Informaci&oacute;n</legend>
        <table align="center" width="90%">
		    <tr>
			  <td width="10%"><label>Causacion :</label></td>
			  <td>{$NUMSOPORTE}{$CAUSARID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$ESTADO}{$NPAGOS}{$ENCABEZADOID}{$BIENID}{$VALORFACT}{$IMPDOCCONTABLE}</td>
			  <td><label>Documento soporte (Equivalente):</label></td>
              <td>{$EQUIVALENTE}</td>  
            </tr>
            <tr>
                <td><label>Fuente : </label></td>
                <td width="35%">{$FUENTEID}</td>
                <td width="10%">
                	<span id="VACIO3"><label></label></span>
                	<span id="OC3"><label>No Factura Proveedor :  </label></span>
                   	<span id="MC3"></span>
					<span id="DU3"></span>  
                    <span id="NN3"><label>Tipo Servicio : </label></span>                      
                </td>
                <td width="35%">
   	                <span id="VACIO4"></span>
                	<span id="OC4">{$FACPRO}{$SERVICIOID}</span>
                	<span id="MC4"></span>   
                	<span id="DU4"></span>
                    <span id="NN4">{$SERV_NN}</span>                                        
                </td>
            </tr>
            <tr>
                <td><label>Fecha Factura : </label></td>
                <td>{$FECHAFACPRO}</td>
                <td><label>Dias Vencimiento : </label></td>
                <td>{$DIASVENCE}&nbsp;{$VENCEFACPRO}</td>
            </tr>

            <tr>
                <td><label>Proveedor : </label></td>
                <td>
	                <span id="VACIO0">{$PROVEEDORVACIO}</span>
                	<span id="OC0">{$PROVEEDOROC}</span>
                	<span id="MC0">{$PROVEEDORMC}</span>
                    <span id="DU0">{$PROVEEDORDU}</span>
                    <span id="NN0">{$PROVEEDORNN}</span>
                 </td>
                <td><label>Nit / Identificaci&oacute;n : </label></td>
                <td>{$PROVEEDORNIT}{$TERCEROID}{$PROVEEDORID}</td>
            </tr>
            <tr>
                <td>
                	<span id="VACIO1"><label>No : </label></span>
                	<span id="OC1"><label>Orden de Compra : </label></span>
                   	<span id="MC1"><label>Manifiesto de carga : </label></span>
					<span id="DU1"><label>Despacho Urbano : </label></span>
                    <span id="NN1"><label>No Factura Proveedor: </label></span>                       
                </td>
                <td>
	                <span id="VACIO2">{$IDVACIO}</span>                
                	<span id="OC2">{$ORDENID} {$ORDEN}<img src="../../../framework/media/images/grid/magb.png" id="BuscarOrdenes" title="Buscar Ordenes Liquidadas Proveedor"/></span>
                    <span id="MC2">{$MANIFIESTOID}</span>{$LIQUIDAID}
                    <span id="DU2">{$DESPACHOID}</span>
                    <span id="NN2">{$FACPRONN}</span> 
                 </td>
                <td><label>Valor : </label></td>
                <td>{$VALOR}</td>
            </tr>
            <tr>
                <td><label>CONCEPTO : </label></td>
                <td colspan="3">{$CONCEPTO}</td>
            </tr>
			<tr>
                <td valign="top"><label>Scan Factura : </label></td>
                <td valign="top">{$FACTURASCAN}</td>
                <td valign="top"><label>Estado: </label></td>
                <td valign="top">{$ESTADO1}</td>
                
            </tr>
			<tr>
               <td valign="top"><label>Anticipos a Cruzar : </label>&nbsp;<img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar Facturas Pendientes Proveedor"/></td>
                <td valign="top">{$ANTICIPOS}{$ANTICIPOSCRUZAR}{$VALANTICIPOSCRUZAR}</td>
            	<td ><label>Archivo plano :</label></td>
              <td valign="top">{$ARCHIVO}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="5%">&nbsp;</td>
                            <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}</td>
                            <td width="25%" align="right" >
                    				<!--/* <input type="button" id="saveDetallepuc"   value="Guardar Selecc.." />
									 <input type="button" id="deleteDetallepuc" value="Borrar Selecc.." />*/-->
                                     <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallepuc" title="Borrar Seleccionados"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
	</fieldset>
    <fieldset class="section">
		<table width="100%">
			<tr><td colspan="8"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
          	<tr>
                <td align="center" width="30%"><b>Ctrl+t = Tercero Ctrl+c=Concepto</b></td>
                <td align="right"  width="10%"></td>
                <td ><label>DEBITO :</label></td>
                <td ><span id="totalDebito">0</span></td>
                <td><label>CREDITO:</label></td>
                <td ><span id="totalCredito">0</span></td>
                <td><label>DIFERENCIA:</label></td>
                <td><span id="totalDiferencia">0</span></td>   
                
            </tr>    
		</table>        
	</fieldset>        
	
    
	</fieldset>
	<fieldset>{$GRIDCAUSAR}</fieldset>{$FORM1END}  
    
    <div id="divSolicitudFacturas">
            <iframe id="iframeSolicitud" height="300px"></iframe>
        </div> 
         <div id="divSolicitudOrdenes">
            <iframe id="iframeOrden" height="300px"></iframe>
        </div> 
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
