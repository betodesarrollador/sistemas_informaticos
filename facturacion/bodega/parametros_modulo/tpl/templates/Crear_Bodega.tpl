<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
    <title>Crear Bodega</title>
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
            <table align="center">
                <tr>
                    <td><label>Busqueda :</label></td>
                </tr>
                <tr>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Nombre: </label></td>
                <td>{$NOMBRE}{$BODEGA_ID}</td>
                <td><label>Codigo Bodega: </label></td>
                <td>{$CODIGOBOD}{$USUARIO_ID}{$USUARIO_ACTUALIZA_ID}{$FECHA_ACTUALIZA}{$FECHA_REGISTRO}</td>                
            </tr>
            <tr>
                <td><label>Longitud: </label></td>
                <td>{$LONGITUD}</td>
                <td><label>Latitud: </label></td>
                <td>{$LATITUD}</td>                
            </tr>
            <tr>
                <td><label>Ubicacion: </label></td>
                <td>{$UBICACION}{$UBICACION_ID}</td>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
            </tr>                                  
        </table>
    </fieldset>
    <fieldset class="section">
        <table align="center">
        <tr>
             <td><label>Alto m: </label></td>
             <td>{$ALTO}</td>
             <td><label>Largo m: </label></td>
             <td>{$LARGO}</td>
             <td><label>Ancho m: </label></td>
             <td>{$ANCHO}</td>
        </tr>
        <tr>
             <td><label>Area m2: </label></td>
             <td>{$AREA}</td>
             <td><label>Volumen m3: </label></td>
             <td>{$VOLUMEN}</td>
        </tr>
         <tr>
                <td colspan="4">&nbsp;</td>
         </tr>
        <tr>
                <td colspan="8" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
        </tr>
        </table>
    </fieldset>
    <fieldset>{$GRIDBODEGA}</fieldset>
    {$FORM1END}
</body>
</html>