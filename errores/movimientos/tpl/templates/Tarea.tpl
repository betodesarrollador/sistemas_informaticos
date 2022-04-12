<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
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
        <div id="table_find" align="center">
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
            {$FECHAREGISTRO}{$USUARIOID}{$FECHAACT}{$USUARIOACT}{$ACTA_ID}
            <tr>
                <td><label>Tipo tarea:</label></td>
                <td>{$TIPO_TAREA_ID}</td>
            </tr>

            <tr>
                <td><label>C&oacute;digo:</label></td>
                <td>{$PARAMID}</td>
                <td><label>Nombre: </label></td>
                <td>{$NOMBRE}</td>
                <td><label>Cliente:</label></td>
                <td><label style="margin: 0;">Todos</label> {$ALLCLIENTES}<br />{$CLIENTE_ID}</td>
            </tr>
            <tr>
                <td colspan="3"><label>Email para envio de finalizacion de tarea  (concatenar con ';' en caso de enviar a mas de un cliente)</label></td>
                <td colspan="3">{$EMAIL_CLIENTE}</td>
            </tr>

            <tr>
                <td><label>Fecha Inicial:</label></td>
                <td>{$FECHAINI}</td>
                <td><label>Fecha Final: </label></td>
                <td>{$FECHAFIN}</td>
                <td><label>Prioridad: </label></td>
                <td>{$PRIORIDAD}</td>

            </tr>
            <tr>
                <td><label>Fecha Inicial Real: </label></td>
                <td>{$FECHAINIREAL}</td>

                <td><label>Fecha Final Real: </label></td>
                <td>{$FECHAFINREAL}</td>
                <td><label>Responsable:</label></td>
                <td>{$RESPONSABLEID}{$RESPONSABLE}</td>

            </tr>
            <tr>
                <td><label>Descripcion: </label></td>
                <td colspan="5">{$DESCRIPCION}</td>
            </tr>

            <tr>
                <td><label>Estado: </label></td>
                <td>{$ESTADO}</td>
                <td><label>Asiganada por: </label></td>
                <td>{$CREADOR}{$CREADORID}</td>
                <td><label>Adjunto max (4 MB):</label></td>
                <td id="fileUpload" colspan="3">{$ARCHIVO}</td>

            </tr>
            <tr>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>
                    <div id="adjuntover"></div>
                </td>
            </tr>
            <tr>
                <td><br></td>

            </tr>
            <tr>
                <td colspan="6" align="center">
                    {$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$CERRAR}&nbsp;{$ENVIAR_EMAIL_FINALIZACION}&nbsp;{$ENVIAR_EMAIL_INICIO}</td>
            </tr>
        </table>
    </fieldset>

    {$FORM1END}

    <fieldset>

        {$GRIDTarea}

    </fieldset>
    <div id="divCierre">
        <form>
            <fieldset class="section">
                <table>
                    <tr>
                        <td><label>Fecha cierre real:</label></td>
                        <td>{$FECHACIERREREAL}</td>
                    </tr>
                    <tr>
                        <td><label>Observaci&oacute;n:</label></td>
                        <td>{$OBSERVACION}</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">{$CERRAR}</td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>

</body>

</html>