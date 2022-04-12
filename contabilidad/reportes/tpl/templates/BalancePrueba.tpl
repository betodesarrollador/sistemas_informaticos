<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
    {$TITLETAB}
</head>

<body>


    {$FORM1}
    <fieldset>
        <legend>{$TITLEFORM}</legend>

        <fieldset class="section">
            <table align="center" class="tableFilter" width="100%">
                <thead>
                    <tr>
                        <td><label>PERIODO</label></td>
                        <td><label>C.C</label></td>
                        <td><label>Todos</label>{$CENTROSTODOS}</td>
                        <td><label>DOC. CIERRE</label></td>
                        <td><label>TERCERO</label></td>

                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td><label>DESDE </label></td>
                                    <td>{$DESDE}</td>
                                </tr>
                                <tr>
                                    <td><label>HASTA </label></td>
                                    <td>{$HASTA}</td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top" colspan="2">{$CENTROCOSTOID}</td>
                        <td valign="top">{$OPCIERRE}</td>
                        <td valign="top">{$OPTERCERO}</td>
                        <td valign="top">{$TERCERO}{$TERCEROID}</td>

                    </tr>
                    
                    </table>

                    <table>

                    <tr>

                        <td><label>NIVEL</label></td>
                        <td>&emsp;&emsp;</td>
                        <td><label>CUENTAS</label><label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Todas</label>&emsp;{$ALLCUENTAS}</td>
                        <td colspan="6"><label>&emsp;&emsp;SUBCUENTAS</label><label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Todas</label>&emsp;{$ALLSUBCUENTAS}</td>
                        <td><label>AGRUPAR</label></td>
                    </tr>


                    <tr>
                        <td valign="top">
                            <select class="form-control" name="nivel" id="nivel" size="5" style="width:100px" class="inputdefault obligatorio">
                                {foreach name=nivel from=$NIVEL item=n}
                                <option value="{$n.value}">{$n.text}</option>
                                {/foreach}
                            </select>
                        </td>

                        <td>&emsp;</td>

                        <td colspan="5" valign="top" style="width:600px">{$CUENTASPUC}</td>

                        <td>&emsp;</td>

                        <td valign="top" style="width:500px">{$SUBCUENTASPUC}</td>

                        <td>
                            <table>

                                <tr>
                                    <td>{$NIVEL1}</td>
                                    <td><label>Nivel 1</label></td>
                                </tr>
                                <tr>
                                    <td>{$NIVEL2}</td>
                                    <td><label>Nivel 2</label></td>
                                </tr>
                                <tr>
                                    <td>{$NIVEL3}</td>
                                    <td><label>Nivel 3</label></td>
                                </tr>
                                <tr>
                                    <td>{$NIVEL4}</td>
                                    <td><label>Nivel 4</label></td>
                                </tr>
                                <tr>
                                    <td>{$NIVEL5}</td>
                                    <td><label>Nivel 5</label></td>
                                </tr>

                            </table>
                        </td>

                    </tr>

                </tbody>
            </table>
        </fieldset>
        <div align="center">{$GENERAR}&nbsp;{$EXCELF}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</div>
    </fieldset>

    {$FORM1END}

    {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
    {$FORM2END}

</body>

</html>