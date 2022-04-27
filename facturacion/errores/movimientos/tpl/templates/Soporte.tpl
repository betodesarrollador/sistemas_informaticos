<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap.css">
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
        <table align="center">   
        {$FECHAREGISTRO}{$USUARIOID}{$FECHAACT}{$USUARIOACT}     
            <tr>
                <td><label>Codigo :</label></td>
                <td>{$PARAMID}</td>
                <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td>
                <td><label>Descripcion : </label></td>
                <td>{$DESCRIPCION}</td>
            </tr>
            <tr>
                <td><label>Cliente: </label></td>
                <td>{$CLIENTEID}{$CLIENTE}</td>
                <td><label>Fecha Inicial : </label></td>
                <td>{$FECHAINI}</td>
                <td><label>Fecha Final: </label></td>
                <td>{$FECHAFIN}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    </fieldset>  
   
       
        <fieldset>
             
        {$GRIDSoporte}
       
    </fieldset>
   
</body>
</html>