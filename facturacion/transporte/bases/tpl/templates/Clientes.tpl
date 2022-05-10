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
        <div id="table_find">
            <table>
                <tr>
                    <td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
	</fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center" width="90%">
            <tr>
                <td colspan="4"><label>1. IDENTIFICACI&Oacute;N</label></td>
            </tr>
            <tr>
                <td ><label>Tipo Identificaci&oacute;n : </label></td>
                <td>{$TIPOIDENTIFICACION}{$TERCEROID}{$CLIENTEID}{$REMITENTEID}</td>
                <td><label>Tipo Contribuyente : </label></td>
                <td>{$TIPOPERSONA}</td>
            </tr>
            <tr>
                <td><label>N&uacute;mero Identificaci&oacute;n :</label></td>
                <td align="left" colspan="3">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
            </tr>
            <tr id="filaApellidos">
                <td><label>Primer Apellido : </label></td>
                <td align="left">{$PRIMERAPELLIDO}</td>
                <td><label>Segundo Apellido : </label></td>
                <td align="left">{$SEGUNDOAPELLIDO}</td>
            </tr>
            <tr id="filaNombres">
                <td><label>Primer Nombre : </label></td>
                <td>{$PRIMERNOMBRE}</td>
                <td><label>Otros Nombres : </label></td>
                <td>{$OTROSNOMBRES}</td>
            </tr>
            <tr id="filaRazonSocial"> 
                <td><label>Raz&oacute;n Social : </label></td>
                <td>{$RAZON_SOCIAL}</td>
                <td><label>Sigla : </label></td>
                <td>{$SIGLA}</td>
            </tr>
            <tr>
                <td><label>Telefono : </label></td>
                <td>{$TELEFONO}</td>
                <td><label>Movil : </label></td>
                <td align="left">{$MOVIL}</td>
            </tr>
            <tr>
                <td><label>Telefax : </label></td>
                <td>{$TELEFAX}</td>
                <td><label>Apartado A&eacute;reo : </label></td>
                <td align="left">{$APARTADO}</td>
            </tr>
            <tr>
                <td><label>Direcci&oacute;n : </label></td>
                <td align="left">{$DIRECCION}</td>
                <td><label>Direcci&oacute;n Correspondencia : </label></td>
                <td>{$CORRESPON}</td>
            </tr>
            <tr>
                <td><label>C&oacute;digo Postal: </label></td>
                <td align="left">{$ZONAPOSTAL}</td>
                <td><label>Ciudad Residencia : </label></td>
                <td>{$UBICACION}{$UBICACIONID}</td>
            </tr>   
            <tr>
                <td><label>Email :</label></td>
                <td align="left">{$EMAIL}</td>
                <td><label>P&aacute;gina Web : </label></td>
                <td>{$URL}</td>
            </tr>
            <tr>
                <td><label>Contacto :</label></td>
                <td align="left">{$CONTACT}</td>
                <td><label>Registro Mercantil : </label></td>
                <td>{$REGISTROM}</td>
            </tr>
            <tr>
                <td><label>Camara de Comercio :</label></td>
                <td align="left">{$CCOMERCIO}</td>
            </tr>
            <tr>
                <td ><label>Contado : </label></td>
                <td >{$CONTADO}</td>
                <td><label>Contra Entrega : </label></td>
                <td align="left">{$CONTRA}</td>
            </tr>          
            <tr>
                <td align="left"><label>Cuenta Corriente : </label></td>
                <td align="left">{$CUENTA}</td>
                <td><label>Estado : </label></td>
                <td align="left">{$ESTADO}</td>
            </tr>
            <tr>
                <td><label>Fecha Creaci&oacute;n : </label></td>
                <td>{$FECHA}</td>
                <td align="right"><label>Fecha Ultima Verificaci&oacute;n Lista Clinton </label></td>
                <td>{$ULTIMACLINTON}</td>
            </tr>
            <tr>
                <td align="right"><label>Tipo Liquidaci&oacute;n : </label></td>
                <td>{$TIPOLIQUIDACION}</td>
                <td align="right"><label>Liquidaci&oacute;n Peso/Unidad : </label></td>
                <td>{$PESOUNIDAD}</td>
            </tr> 
            <tr>
                <td>&nbsp;</td>
                <td><label>D&iacute;as de Vencimiento Facturacion (en dias):</label></td>
                <td align="left">{$DIASVENCIMIENTO}</td> 
                <td>&nbsp;</td>
            </tr>        
        </table>
    </fieldset>          
    <fieldset class="section" id="legal">
        <table align="center" width="90%">          
            <tr>
                <td colspan="4"><label>2. INFORMACI&Oacute;N LEGAL (Solo personas Jur&iacute;dicas)</label></td>
            </tr>
            <tr>
                <td colspan="4"><label>Socios- Para Sociedades An&oacute;nimas Relacione los Miembros de la Junta Directiva</label></td>
            </tr>
            <tr>
                <td colspan="4" align="right">
                <img src="../../../framework/media/images/grid/save.png" id="saveDetallesoc" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesoc" title="Borrar Seleccionados"/>
                <iframe id="socios" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </td>
            </tr>
            <tr>
                <td colspan="4"><label>Representante Legal</label></td>
            </tr>
            <tr>
                <td><label>Nombres y Apellidos : </label></td>
                <td>{$REPRELEG}</td>
                <td><label>Identificaci&oacute;n :</label></td>
                <td align="left">{$REPRELEGID}</td>
            </tr>
            <tr>
                <td><label>Direcci&oacute;n : </label></td>
                <td>{$DIRREPRELEG}</td>
                <td><label>Ciudad :</label></td>
                <td align="left">{$REPUBICACION}{$REPUBICACIONID}</td>
            </tr>
            <tr>
                <td><label>Capital Social : </label></td>
                <td>{$CAPITAL}</td>
                <td><label>Descripci&oacute;n Actividad :</label></td>
                <td align="left">{$DESACTIVIDAD}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section" id="tributaria">
        <table align="center" width="80%">  
            <tr>
                <td colspan="4"><label>3. INFORMACI&Oacute;N TRIBUTARIA</label></td>
            </tr>
            <tr>
                <td><label>Autorretenedor : </label></td>
                <td><label>SI{$AUTORET_SI}NO{$AUTORET_NO}</label></td>
                <td><label>Agente Reteica :</label></td>
                <td align="left"><label>SI{$AGENTE_SI}NO{$AGENTE_NO}</label></td>
            </tr>
            <tr>
                <td><label>R&eacute;gimen: </label></td>
                <td >{$REGIMENID}</td>
                <td><label>C&oacute;digo CIIU: </label></td>
                <td>{$CODIGOCIIU}</td>
            </tr>
            <tr>
            	<td colspan="4"><iframe id="obligaciones" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section" id="operativas">
        <table align="center"  width="90%">           
            <tr>
                <td colspan="4"><label>4. INFORMACI&Oacute;N OPERATIVA</label></td>
            </tr>
            <tr>
                <td colspan="4"><label>Personal que realiza directamente la operaci&oacute;n</label></td>
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
        <table align="center"  width="90%">  
            <tr>
                <td colspan="4"><label>5. INFORMACI&Oacute;N FINANCIERA</label></td>
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
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
    </fieldset>  
    <fieldset class="section" id="comercial">
        <table align="center" width="90%">  
            <tr>
                <td colspan="6"><label>6. ASESOR COMERCIAL</label></td>
            </tr>
            <tr>
                <td colspan="4" align="right">
                <img src="../../../framework/media/images/grid/save.png" id="saveDetallecom" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallecom" title="Borrar Seleccionados"/>
                <iframe id="comerciales" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </td>
            </tr>
            <!-- <tr>
                <td><label>Asesor Comercial :</label></td>
                <td align="left">{$COMERCIALID}{$COMERCIAL}</td>
                <td><label>Tipo Comision : </label></td>
                <td>{$TIPO_COMISION}</td>
            </tr>
            <tr>
                <td><label>Porc. Comision :</label></td>
                <td align="left">{$COMISION}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>-->
        </table>
    </fieldset>  
    <fieldset class="section" id="tarifas">
        <table align="center" width="90%">  
            <tr>
                <td colspan="4"><label>7. INFORMACI&Oacute;N TARIFAS</label></td>
            </tr>
            <tr>
                <td colspan="4"><label>Tarifas Paqueteo</label></td>
            </tr>
            <tr>
                <td colspan="4" align="right">
                <!-- <img src="../../../framework/media/images/grid/save.png" id="saveDetalletarifa" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalletarifa" title="Borrar Seleccionados"/>-->
                <iframe id="tarifa" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </td>
            </tr>
            <tr>
                <td colspan="4"><label>Rutas Especiales</label></td>
            </tr>
            <tr>
                <td colspan="4" align="right">
                <!-- <img src="../../../framework/media/images/grid/save.png" id="saveDetalletarifa" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalletarifa" title="Borrar Seleccionados"/>-->
                <iframe id="rutasespeciales" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </td>
            </tr>
        </table>
    </fieldset>  
    <fieldset class="section" id="tarifasm">
        <table align="center" width="90%">  
            <tr>
                <td colspan="4"><label>7. INFORMACION TARIFAS</label></td>
            </tr>
            <tr>
                <td colspan="4"><label>Tarifas Masivo</label></td>
            </tr>
            <tr>
                <td colspan="4" align="right">
                <!-- <img src="../../../framework/media/images/grid/save.png" id="saveDetalletarifa" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalletarifa" title="Borrar Seleccionados"/>-->
                <iframe id="tarifam" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </td>
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
