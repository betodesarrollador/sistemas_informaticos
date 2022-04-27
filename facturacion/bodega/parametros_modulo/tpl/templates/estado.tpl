<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
    <title>Crear Estados Producto</title>
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
                <td>{$NOMBRE}{$ESTADO_ID}</td>
                <td><label>Codigo Estado: </label></td>
                <td>{$CODIGO}{$USUARIO_ID}{$USUARIO_ACTUALIZA_ID}{$FECHA_ACTUALIZA}{$FECHA_REGISTRO}</td>                
            </tr>
            <tr>
                <td><label>Descripcion: </label></td>
                <td>{$DESCRIPCION}</td>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>               
            </tr>                             
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset>{$GRIDESTADO}</fieldset>
    {$FORM1END}
</body>
</html>