<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   
  {$JAVASCRIPT}
 
  {$CSSSYSTEM} 
  
  {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
		 <div id="table_find"><table  align="center">
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
                <td><label>N&uacute;mero : </label></td>
                <td>{$BIENID}</td>
                <td><label>Nombre Bien/Servicio : </label></td>
                <td>{$NOMBREBIEN}</td>
            </tr>
            <tr>
                <td><label>Tipo Fuente : </label></td>
                <td>{$FUENTEID}</td>
                <td><label>Tipo de Documento : </label></td>
                <td>{$DOCID}</td>
            </tr>
            <tr>
                <td><label>Agencia : </label></td>
                <td>{$AGENCIAID}</td>
                <td><label>Reporta Cartera : </label></td>
                <td>{$REPORTACAR}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
                            <!--<td width="15%" align="right" >
                                <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallepuc" title="Desactivar Seleccionados"/>
                            </td>-->
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table width="100%">
	        <tr>
            	<td  width="85%" align="left"><label>Configuraci&oacute;n de Cuentas Contables para Tipo de Servicio</label></td>
                <td width="15%" align="right" >
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallepuc" title="Borrar Seleccionados"/>
                </td>
            
            </tr>
			<tr><td colspan="2"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table>
        
        <table width="100%">
	        <tr>
            	<td  align="left"><label>Configuraci&oacute;n de Cuentas Contables para Devoluci&oacute;n de Tipo de Servicio</label></td>
                <td><label>Tipo de Documento : </label></td>
                <td>{$DOCDEVID}</td>
                <td width="15%" align="right" >
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalledev" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalledev" title="Borrar Seleccionados"/>
                </td>
            
            </tr>
			<tr><td colspan="4"><iframe id="devolucion" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>

		</table>        
		    <!--  
              <table width="100%">
			<tr><td ><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table> --> 
        </fieldset> 
		{$FORM1END}
	</fieldset>
	<fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>   
</body>
</html>
