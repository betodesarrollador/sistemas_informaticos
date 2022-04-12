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
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table width="100%">
        	<tr>
            	<td valign="top" width="20%">&nbsp;&nbsp;</td>
                <td valign="top" colspan="20%">&nbsp;&nbsp;</td> 
                <td valign="top" colspan="20%">&nbsp;&nbsp;</td> 
            	<td colspan="4" valign="bottom"width="40%"><font color="#FF0000" size="-1">Por favor digitar el numero de las remesas separadas por comas ( , )</font></td>
            </tr>
            <tr>
                <td valign="top" width="20%"><label>Desde:&nbsp;&nbsp;</label> {$DESDE}</td>
                <td valign="top" colspan="20%"><label>Hasta:&nbsp;&nbsp;</label> {$HASTA}</td> 
                <td valign="top" colspan="20%"><label>Solicitud:&nbsp;&nbsp;</label> {$SOLICITUD}</td> 
                <td valign="top" colspan="4" width="40%"><label>Remesas a Modificar:&nbsp;&nbsp;</label> {$NUMEROREMESAS}</td>       
            </tr>
        </table>
    </fieldset>
    {$SOLICITUDID}
    <fieldset class="section">
        <div align="center">{$GENERAR}{$CONTABILIZAR}{$GENERAREXCEL}{$IMPRIMIR}{$LIMPIAR}</div>
    </fieldset>
    <fieldset class="section">
        <iframe src="" id="frameDepreciados" name="frameDepreciados" height="300px"></iframe>
    </fieldset>
    {$FORM1END}
     <!--<div id="Renovarmarco" style="display:none">
      <div align="center">
	    <p align="center">
        <form onSubmit="return false">
	      <fieldset class="section">
		  <table id="tableGuia" width="100%">
          	<th colspan="5">Información Contrato</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td><label>Contrato No :</label></td>
                <td>{$CONSECUTIVORENUEVA}</td>
                <td colspan="2"><label>Fecha Contrato :</label></td>
                <td>{$FECHACONTRATORENUEVA}</td>
            </tr>
            <tr>
            	<td><label>Fecha Inicio :</label></td>
                <td>{$FECHAINICIO2}</td>
                <td colspan="2"><label>Fecha Final :</label></td>
                <td>{$FECHAFINAL2}</td>
            </tr>
            <tr>
                <td><label>Inmobiliaria :</label></td>
                <td colspan="4">{$CLIENTERENUEVA}</td>
            </tr>
            <tr>
                <td><label>Propietario :</label></td>
                <td colspan="4">{$PROPIETARIORENUEVA}</td>
            </tr>
            <tr>
                <td><label>Arrendatario :</label></td>
                <td colspan="4">{$ARRENDATARIORENUEVA}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <th colspan="5">Información Renovar</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
             	<td><label>Canon :</label></td>
                <td colspan="2">{$CANONRENUEVA}</td>
                <td><label>Administración :</label></td>
                <td>{$ADMINISTRACION}</td>
            </tr>
            <tr>
                <td><label>Fecha Inicio :</label></td>
                <td>{$FECHAINIRENOVACION}</td>
                <td colspan="2"><label>Fecha Final :</label></td>
                <td>{$FECHAFINRENOVACION}</td>
            </tr>           
			 <tr> <td>&nbsp;</td> </tr>
			 <tr> <td colspan="5" align="center">{$RENOVAR}</td>
            </tr>
		  </table>
          </fieldset>
          </form>
		</p>
	  </div>
	</div>
     <div id="Finalizarmarco" style="display:none">
      <div align="center">
	    <p align="center">
        <form onSubmit="return false">
	      <fieldset class="section">
		  <table id="tableGuia" width="100%">
          	<th colspan="5">Información Contrato</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td><label>Contrato No :</label></td>
                <!--<td>{$CONSECUTIVO2}</td>
                <td colspan="2"><label>Fecha Contrato :</label></td>
                <td>{$FECHACONTRATO}</td>
            </tr>
            <tr>
                <td><label>Inmobiliaria :</label></td>
                <td colspan="4">{$CLIENTEFINALIZA}</td>
            </tr>
            <tr>
                <td><label>Propietario :</label></td>
                <td colspan="4">{$PROPIETARIO}</td>
            </tr>
            <tr>
                <td><label>Arrendatario :</label></td>
                <td colspan="4">{$ARRENDATARIO}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <th colspan="5">Información Renovar</th>
            <tr><td>&nbsp;</td></tr>
          	<tr>
            	<td>&nbsp;</td>
                <td><label>Fecha Retiro :</label></td>
                <td colspan="3">{$FECHARETIRO}</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><label>Observación Retiro :</label></td>
                <td colspan="3">{$OBSERVACION}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>  
			 <tr> <td align="center" colspan="5">{$FINALIZAR}</td></tr>
		  </table>
          </fieldset>
          </form>
		</p>
	  </div>
	</div>-->
</body>
</html>