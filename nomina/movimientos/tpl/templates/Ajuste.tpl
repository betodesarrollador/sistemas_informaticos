<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>


    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    <script src="../../../framework/js/moment.min.js"></script>
</head>

<body>
    {$JAVASCRIPT}

    {$CSSSYSTEM}

    {$TITLETAB}

    <fieldset>
        <legend>{$TITLEFORM}</legend>
        <div id="table_find">
            <table align="center">
                <tbody>
                    <tr>
                        <td><label>Busqueda Empleado: </label></td>
                        <td>{$BUSQUEDAEMPLEADO}</td>
                    </tr>

                </tbody>
            </table>
        </div>

        {$OFICINAHIDDEN}
        {$OFICINAIDHIDDEN}
        {$FECHASTATIC}
        {$FORM1}
        <fieldset class="section">
            <legend>Liquidacion Nomina</legend>
            <div>
                <table align="center" width="30%">
                    <tbody>
                        <tr>
                            <td><label>Lista Liquidacion novedad:</label></td>
                            <td>{$LISTALIQUIDACIONNOVEDAD}</td>
                            <td rowspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <fieldset class="section">
                <table align="center" width="75%">
                    <tbody>
                        <tr>
                            <td><label>Liquidacion Novedad No. : </label></td>
                            <td>{$CONSECUTIVO}{$LIQUIDACIONID}{$USUARIO_ID}{$FECHAREG}{$CONSECUTIVONOM}{$PARAMETRONOMINAELECTRONICA}</td>
                        </tr>
                        <tr>
                            <td><label>Fecha Inicial : </label></td>
                            <td>{$FECHAINI}</td>
                            <td><label>Fecha Final : </label></td>
                            <td>{$FECHAFIN}</td>
                        </tr>

                        <tr>
                            <td><label>Aplica a: </label></td>
                            <td>{$EMPLEADOS}</td>
                            <td><label> Centro: </label></td>
                            <td>{$CENTRO_DE_COSTO}</td>
                        </tr>
                        <tr>

                            <td><label>Periodicidad: </label></td>
                            <td>{$PERIODICIDAD}</td>
                            <td><label> Area : </label></td>
                            <td>{$AREAS}</td>
                        </tr>
                        <tr>
                            <td><label>Empleado: </label></td>
                            <td>{$CONTRATO}{$CONTRATOID}</td>
                            <td><label>Estado: </label></td>
                            <td>{$ESTADO}</td>

                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                {$AJUSTAR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZARDIF}&nbsp;{$PREVISUAL}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <div><iframe id="detalleAjusteNovedad" class="editableGrid"></iframe></div>
        </fieldset>

        {$FORM1END}
    </fieldset>

    
</body>

</html>