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
		<div id="table_find"><table><tr><td><label>Busqueda: </label></td><td>{$BUSQUEDA}</td></tr></table></div>    
        {$FORM1}
        <table align="center" width="95%">
           <tr>
               <td><label>Resolucion:</label></td>
               <td>{$RESOLUCION}{$FORMATOID}</td>
               <td><label>Fecha Resolucion:</label></td>
               <td>{$FECHA}</td>
               <td><label>Año Gravablele:</label></td>
               <td>{$ANO}</td>
               <td><label>Nit. Extranjeros</label></td><td>{$NIT_EXTRAN}</td>            
         </tr>
           <tr>
               <td><label>Tipo Formato:</label></td>
               <td>{$TIPO}</td>
               <td><label>Version:</label></td>
               <td>{$VERSION}</td>
               <td><label>Cuantia Minima:</label></td>
               <td>{$CUANMIN}</td>
               <td><label>Monto Ingresos PN:</label></td>
               <td>{$MONTOS}</td>           
           </tr>
          <tr>
               <td><label>Nit. Cuantias Menores:</label></td>
               <td>{$CUANMEN}</td>
               <td><label>Tipo Doc.:</label></td>
               <td>{$TIPDOC}</td>
               <td><label>Nombre Tercero:</label></td>
               <td>{$TERCERO}</td>
               <td><label>Monto Ingresos PJ:</label></td>
               <td>{$MONTOSPJ}</td>           
          </tr>
          <tr>
               <td><label>Tipo Medio:</label></td>
               <td>{$TIPOF}</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>           
          </tr>
            <tr>
                <td colspan="8" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
                            <td width="15%" align="right" >
                            <img src="../../../framework/media/images/grid/save.png" id="saveDetalle" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalle" title="Desactivar Seleccionados"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
		<table width="100%">
			<tr><td ><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table>        
		{$FORM1END}
	</fieldset>
	<fieldset>
	{$GRIDFORMATOSEXOGENA}
</fieldset>   
</body>
</html>
