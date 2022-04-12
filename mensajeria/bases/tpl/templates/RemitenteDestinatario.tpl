<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
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
    {$FORM1}{$REMITENTEDESTINATARIOID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Cliente :</label></td>
                <td colspan="3">{$CLIENTEID}</td>
            </tr>
            <tr>
                <td align="center" colspan="4"><p><b><u>Datos Destinatario</u></b></p></td>
            </tr> 		  
            <tr>
                <td><label>Numero Identificaci&oacute;n :</label></td>
                <td>{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
                <td ><label>Tipo Identificaci&oacute;n : </label></td>
                <td>{$TIPOIDENTIFICACION}{$TERCEROID}</td>            
            </tr>       
            <tr>
                <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td>
                <td><label>Direcci&oacute;n :</label></td>
                <td>{$DIRECCION}</td>
            </tr>
            <tr id="filaApellidos">
                <td><label>Primer Apellido  : </label></td>
                <td>{$PRIMERAPELLIDO}</td>
                <td><label>Segundo Apellido  :</label></td>
                <td>{$SEGUNDOAPELLIDO}</td>
            </tr>  		    
            <tr>
                <td><label>Telefono : </label></td>
                <td>{$TELEFONO}</td>
                <td><label>Ciudad :</label></td>
                <td>{$CIUDAD}{$CIUDADID}</td>
            </tr> 
            <tr>
                <td><label>Estado:</label></td>
                <td colspan="3">{$ESTADO}{$TIPO}</td>
            </tr>		  		  		          
            <tr>
                <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDTERCEROS}</fieldset>

</body>
</html>
