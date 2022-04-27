<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
 
  {$CSSSYSTEM} 
  
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
               <td><label>Nombre formato :</label></td>
               <td>{$NOMBRE_FORMATO}</td>
               <td><label>Version:</label></td>
               <td>{$VERSION}</td>
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
               <td><label>Cuantia Minima:</label></td>
               <td>{$CUANMIN}</td>
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
                           
                            <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$DUPLICAR}&nbsp;{$GENERAR}</td>
                            <td width="15%" align="right" >
                            <img src="../../../framework/media/images/grid/save.png" id="saveDetalle" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalle" title="Desactivar Seleccionados"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <fieldset>
        
		<table width="100%">
    
			<tr><td ><div id="messages">&nbsp;</div></td></tr>
			<tr><td ><iframe id="detalles" style="height: 900px;"></iframe></td></tr>
		</table>        
		
	<fieldset>
	<button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    <div id="divDuplicar" style="display:none;">
      <form>
        <table>              
          <tr>
            <td><label>Formato Base:</label></td>
            <td colspan="3">{$FORMABASE}</td>
          </tr> 
          <tr>
            <td><label>Resoluci&oacute;n:</label></td>
            <td>{$RESOL_N}</td>
            <td><label>Fecha Resol.:</label></td>
            <td>{$FECHA_N}</td>
          </tr>           
          <tr>
            <td><label>Versi&oacute;n:</label></td>
            <td>{$VERSION_N}</td>
            <td><label>A&ntilde;o Gravable:</label></td>
            <td>{$ANO_N}</td>
            
          </tr>           
          <tr>
            <td><label>Tipo Formato:</label></td>
            <td>{$TIPO_N}</td>
            <td><label>Cuant&iacute;a Minima:</label></td>
            <td>{$CUANMIN_N}</td>
            
          </tr>           
          
          <tr>
            <td colspan="2" align="center">{$DUPLICAR}</td>
          </tr>                    
        </table>
      </form>
    </div>        
    
</fieldset> 
{$FORM1END}
	</fieldset>  
</body>
</html>
