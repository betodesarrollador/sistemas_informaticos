<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    {$JAVASCRIPT}

    {$CSSSYSTEM}
  
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
    {$INCAPACIDADID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Nombre: </label></td>
                <td>{$NOMBRE}</td>
                <td><label>Tipo: </label></td>
                <td>{$TIPO}</td>
            </tr>
            <tr>
                <td><label>Pago Parcial?: </label></td>
                <td>{$DESCUENTO}</td>
                <td><label>D&iacute;a: </label></td>
                <td>{$DIA}</td>
            </tr>            
            <tr>
                <td><label>Porcentaje: </label></td>
                <td>{$PORCENTAJE}</td>
                <td><label>Aplica diagnostico: </label></td>
                <td>{$DIAGNOSTICO}</td>
                
            </tr> 
            <tr>
                <td><label>Base Salarial: </label></td>
                <td>{$BASESALARIAL}</td>
                <td><label>Relacion nomina electronica: </label></td>
                <td>{$TIPONOMINAELECTRONICA}</td>
            </tr>             
            <tr>
                <td><label>Estado: </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
        
        <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button
        
    {$FORM1END}
    </fieldset>
   

</body>
</html>
