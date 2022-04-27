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
        <table align="center">
            <tr>
                {$TARIFAID}{$OFICINA}{$USUARIO}

                <td><label>Tipo Envio :</label></td>
                <td>{$TIPOENVIOID}</td>

                <td><label>Valor minimo declarado paquete :</label></td>
                <td>{$VALORMINIMODECLARADOPAQ}</td>

                <td><label>Valor maximo declarado paquete :</label></td>
                <td>{$VALORMAXIMODECLARADOPAQ}</td>
            </tr>
            <tr>
                <td><label>Valor Minimo Declarado :</label></td>
                <td>{$VALORMINIMODECLARADO}</td>
                <td><label>Valor Maximo Declarado :</label></td>
                <td>{$VALORMAXIMODECLARADO}</td>
                <td><label>Tipo Servicio:</label></td>
                <td>{$TIPOSERVICIOID}</td>

            </tr>

            <tr>
                <td><label>Valor kilogramo inicial minimo :</label></td>
                <td>{$VALORKGINICIALMINIMO}</td>
                <td><label>Valor kilogramo inicial maximo :</label></td>
                <td>{$VALORKGINICIALMAXIMO}</td>
                <td><label>Valor kilogramo adicional minimo : </label></td>
                <td>{$VALORKGADICIONALMIN}</td>

            </tr>

            <tr>

                <td><label>Valor kilogramo adicional maximo : </label></td>
                <td>{$VALORKGADICIONALMAX}</td>
                <td><label>Periodo : </label></td>
                <td>{$PERIODO}</td>
                <td><label>Porcentaje seguro : </label></td>
                <td>{$PORCENTAJESEGURO}</td>

            </tr>

            <tr>
                <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$DUPLICAR}</td>
            </tr>
        </table>
        {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDTARIFASESPECIALES}</fieldset>
</body>

</html>