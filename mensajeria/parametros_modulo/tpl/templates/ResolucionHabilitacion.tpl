<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><b>Resolucion Habilitacion</b></title>
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
    <table align="center">
    <tr>
    <td id="celda_rangos">
    <fieldset class="section">
    <legend>EMPRESA</legend>
    <table width="100%">
    <tr><td><label>Empresa :</label></td><td colspan="3">{$EMPRESAS}{$HABILITACIONID}</td></tr>
    <tr><td><label>Codigo Empresa :</label></td><td>{$CODEMPRESA}</td></tr>									  					
    <tr><td><label>Regional :</label></td><td>{$CODIGOREGIONAL}</td></tr>
    </table>
    </fieldset>
    
    <fieldset class="section">
    <legend>RESOLUCI&Oacute;N MENSAJERIA
    </legend><table width="100%">
    <tr>
    <td><label>Habilitaci&oacute;n N°. </label></td><td>{$HABILITACION}</td>
    <td><label>Fecha :</label></td><td>{$FECHA}</td>
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
    <td><label>Rango Inicial Despacho:</label></td><td>{$INICIALURBANO}</td>
    <td><label>Rango Final Despacho:</label></td><td>{$FINALURBANO}</td>
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
    <legend>Guias
    </legend><table align="center">
    <tr>
    <td><label>Rango Inicial Guia:</label></td><td>{$INICIALREMESA}</td>
    <td><label>Rango Final Guia:</label></td><td>{$FINALREMESA}</td>
    </tr>
    <tr>
    <td><label>Asignados :</label></td>
    <td>{$ASIGNADOREMESA}</td>
    <td><label>Saldo :</label></td>
    <td>{$SALDOREMESA}</td>
    </tr>
    </table>
    </fieldset>            </td>
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