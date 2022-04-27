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
    </fieldset>
    {$FORM1}{$CERTIFICADOSID}
    <fieldset class="section">
        <table align="center">		  
            <tr>
                <td><label>Nombre :</label></td>
                <td>{$NOMBRE}</td>
            </tr>
            <tr>
                <td><label>Entidad : </label></td>
                <td>{$ENTIDAD}</td>            
            </tr>       
            <tr>
                <td><label>Decreto : </label></td>
                <td>{$DECRETO}</td>
            </tr>
            <tr>
                <td><label># Inicial Certificado :</label></td>
                <td>{$NUMERO}</td>
            </tr> 
            <tr>
                <td><label>Estado :</label></td>
                <td><label>A{$ACTIVO}I{$INACTIVO}{$TIPO}</label></td>
            </tr> 
            <tr>
            	<td colspan="2">&nbsp;</td>
			</tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
        <table id="toolbar">
            <tbody>
                <tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload">{$ARCHIVOSOLICITUD}</td>
                </tr>               
            </tbody>
        </table>		 
        <div>
        	<iframe name="detalleCertificados" id="detalleCertificados" src="about:blank"></iframe>
		</div>		 
   
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
     {$FORM1END}
    </fieldset>
</body>
</html>
