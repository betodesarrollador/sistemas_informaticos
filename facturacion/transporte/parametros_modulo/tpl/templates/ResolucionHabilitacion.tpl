<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Resolucion Habilitaci&oacute;n</title> 
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
                    <td><label>Busqueda :</label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td id="celda_rangos">
                    <fieldset class="section">
                    <legend>EMPRESA</legend>
                        <table width="100%">
                            <tr>
                                <td><label>Empresa :</label></td>
                                <td colspan="3">{$EMPRESAS}{$HABILITACIONID}</td>
                            </tr>
                            <tr>
                                <td><label>Codigo Empresa :</label></td>
                                <td>{$CODEMPRESA}</td>
                            </tr>									  					
                            <tr>
                                <td><label>Regional :</label></td>
                                <td>{$CODIGOREGIONAL}</td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset class="section">
                    <legend>RESOLUCI&Oacute;N TRANSPORTE</legend>
                        <table width="100%">
                            <tr>
                                <td><label>Habilitaci&oacute;n No. </label></td>
                                <td>{$HABILITACION}</td>
                                <td><label>Fecha :</label></td>
                                <td>{$FECHA}</td>
                            </tr>
                        </table>			  
                    </fieldset>
                    <fieldset class="section">
                    <legend>RESOLUCI&Oacute;N DTA</legend>
                        <table width="100%">
                            <tr>
                                <td><label>Resoluci&oacute;n No.</label></td>
                                <td colspan="3">{$NUMRESOLUCION}</td>
                                <td><label>Fecha  :</label></td>
                                <td>{$FECHARESOLUCION}</td>
                                <td><label>Codigo Aduanero :</label></td>
                                <td>{$CODADUANERO}</td>
                            </tr>
                        </table>
                    </fieldset>			
                    <fieldset class="section">
                    <legend>MANIFIESTOS</legend>
                        <table align="center">
                            <tr>
                                <td><label>Rango Inicial :</label></td>
                                <td>{$INICIAL}</td>
                                <td><label>Rango Final :</label></td>
                                <td>{$FINAL}</td>
                            </tr>
                            <tr>
                                <td><label>Asignados :</label></td>
                                <td>{$ASIGNADO}</td>
                                <td><label>Saldo :</label></td>
                                <td>{$SALDO}</td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset class="section">
                    <legend>Despachos Urbanos</legend>
                        <table align="center">
                            <tr>
                                <td><label>Rango Inicial Despacho :</label></td>
                                <td>{$INICIALURBANO}</td>
                                <td><label>Rango Final Despacho :</label></td>
                                <td>{$FINALURBANO}</td>
                            </tr>
                            <tr>
                                <td><label>Asignados :</label></td>
                                <td>{$ASIGNADODESPACHO}</td>
                                <td><label>Saldo :</label></td>
                                <td>{$SALDODESPACHO}</td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset class="section">
                    <legend>Remesas</legend>
                        <table align="center">
                            <tr>
                                <td><label>Rango Inicial Remesa :</label></td>
                                <td>{$INICIALREMESA}</td>
                                <td><label>Rango Final Remesa :</label></td>
                                <td>{$FINALREMESA}</td>
                            </tr>
                            <tr>
                                <td><label>Asignados :</label></td>
                                <td>{$ASIGNADOREMESA}</td>
                                <td><label>Saldo :</label></td>
                                <td>{$SALDOREMESA}</td>
                            </tr>
                        </table>
                    </fieldset>
				</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDResolucionHabilitacion}</fieldset>

</body>
</html>