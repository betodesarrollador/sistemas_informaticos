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
  	{$FORM1}
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        <fieldset class="section">
        <table align="center">
          <tr>
          	<td colspan="4">1. IDENTIFICAC&Oacute;N</td>
          </tr>
          <tr>
            <td ><label>Tipo Identificacion : </label></td><td>{$TIPOIDENTIFICACION}{$TERCEROID}{$CLIENTEID}{$REMITENTEID}</td>
            <td><label>Tipo Contribuyente : </label></td><td>{$TIPOPERSONA}</td>
          </tr>
          <tr>
            <td><label>Numero Identificacion :</label></td><td align="left">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
          </tr>
          <tr id="filaApellidos">
            <td><label>Primer Apellido : </label></td><td align="left">{$PRIMERAPELLIDO}</td>
            <td><label>Segundo Apellido : </label></td><td align="left">{$SEGUNDOAPELLIDO}</td>
          </tr>
          <tr id="filaNombres">
            <td><label>Primer Nombre : </label></td><td>{$PRIMERNOMBRE}</td>
            <td><label>Otros Nombres : </label></td><td>{$OTROSNOMBRES}</td>
          </tr>
         <tr id="filaRazonSocial"> 
            <td><label>Razon Social : </label></td><td>{$RAZON_SOCIAL}</td>
            <td><label>Sigla : </label></td><td>{$SIGLA}</td>
          </tr>
          <tr>
            <td><label>Telefono : </label></td><td>{$TELEFONO}</td>
            <td><label>Movil : </label></td><td align="left">{$MOVIL}</td>
          </tr>
          <tr>
            <td><label>Telefax : </label></td><td>{$TELEFAX}</td>
            <td><label>Apartado A&eacute;reo : </label></td><td align="left">{$APARTADO}</td>
          </tr>

          <tr>
            <td><label>Direcci&oacute;n : </label></td><td align="left">{$DIRECCION}</td>
            <td><label>Direcci&oacute;n Correspondencia : </label></td><td>{$CORRESPON}</td>
          </tr>
          <tr>
            <td><label>Ciudad Residencia : </label></td><td>{$UBICACION}{$UBICACIONID}</td>
            <td><label>Email :</label></td><td align="left">{$EMAIL}</td>
          </tr>
          <tr>
            <td><label>P&aacute;gina Web : </label></td><td>{$URL}</td>
            <td><label>Contacto :</label></td><td align="left">{$CONTACT}</td>
          </tr>
          <tr>
            <td><label>Registro Mercantil : </label></td><td>{$REGISTROM}</td>
            <td><label>Camara de Comercio :</label></td><td align="left">{$CCOMERCIO}</td>
          </tr>
          <tr>
            <td><label>Estado : </label></td>
            <td align="left">{$ESTADO}</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>          
          
		</table>
        </fieldset>          
		<fieldset class="section" id="legal">
		<table align="center">          
          <tr>
          	<td colspan="4">2. INFORMACION LEGAL (Solo personas Jur&iacute;dicas)</td>
          </tr>
          <tr>
            <td colspan="4">Socios- Para Sociedades Anónimas relacione los Miembros de la Junta Directiva</td>
          </tr>
          <tr>
            <td colspan="4" align="right">
                <img src="../../../framework/media/images/grid/save.png" id="saveDetallesoc" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesoc" title="Borrar Seleccionados"/>
                <iframe id="socios" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
          </tr>
          <tr>
            <td colspan="4">Representante Legal</td>
          </tr>
          <tr>
            <td><label>Nombres y Apellidos : </label></td><td>{$REPRELEG}</td>
            <td><label>Identificaci&oacute;n :</label></td><td align="left">{$REPRELEGID}</td>
          </tr>
          <tr>
            <td><label>Direcci&oacute;n : </label></td><td>{$DIRREPRELEG}</td>
            <td><label>Ciudad :</label></td><td align="left">{$REPUBICACION}{$REPUBICACIONID}</td>
          </tr>

          <tr>
            <td><label>Capital Social : </label></td><td>{$CAPITAL}</td>
            <td><label>Descripci&oacute;n Actividad :</label></td><td align="left">{$DESACTIVIDAD}</td>
          </tr>
		</table>
        </fieldset>
        <fieldset class="section" id="tributaria">
        <table align="center">  
          <tr>
          	<td colspan="4">3. INFORMACION TRIBUTARIA</td>
          </tr>
          <tr>
            <td><label>Autorretenedor : </label></td>
            <td>SI{$AUTORET_SI}NO{$AUTORET_NO}</td>
            <td><label>Agente Reteica :</label></td>
            <td align="left">SI{$AGENTE_SI}NO{$AGENTE_NO}</td>
          </tr>

          <tr>
            <td><label>Regimen : </label></td>
            <td>{$REGIMENID}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		</table>
        </fieldset>
        <fieldset class="section" id="operativas">
        <table align="center">           
          <tr>
          	<td colspan="4">4. INFORMACION OPERATIVA</td>
          </tr>
          <tr>
            <td colspan="4">Personal que realiza directamente la operaci&oacute;n</td>
          </tr>
          
          <tr>
            <td colspan="4" align="right">
                <img src="../../../framework/media/images/grid/save.png" id="saveDetalleope" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalleope" title="Borrar Seleccionados"/>
            	<iframe id="operativa" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
          </tr>
          <tr>
            <td><label>Origen de Recursos :</label></td>
            <td colspan="3">{$RECURSOS}</td>
          </tr>
        </table>
        </fieldset>
        <fieldset class="section" id="financiera">
        <table align="center">  
          <tr>
          	<td colspan="4">5. INFORMACION FINANCIERA</td>
          </tr>
          
          <tr>
            <td><label>Tipo de Cuenta :</label></td>
            <td align="left">{$TIPOCUENTA}</td>
            <td><label>N&uacute;mero de Cuenta : </label></td>
            <td>{$NUM_CUENTA}</td>
          </tr>
          <tr>
            <td><label>Entidad Bancaria :</label></td>
            <td align="left">{$BANCOID}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		</table>
        </fieldset>  
        <table align="center">        
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
        
    </fieldset>
    {$FORM1END}
    <fieldset>{$GRIDCLIENTES}</fieldset>
    
  </body>
</html>
