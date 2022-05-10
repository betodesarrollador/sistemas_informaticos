<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
<link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
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
                </tr>
                <tr>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
        
    </fieldset>
    {$USUARIOSTATIC}
    {$FORM1}

    {$USUARIOID}
    {$FECHAREGISTRO}
    {$USUARIOACTUALIZA}
    {$FECHAACTUALIZA}

    <fieldset class="section">  
        <table align="center">        
            <tr>
                <td><label>Codigo :</label></td>
                <td>{$CODIGO}{$POSICIONID}</td>
                 <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td>  
            </tr>

             <tr>
                <td><label>Ubicación bodega: </label></td>
                <td>{$UBICACION}{$UBICACIONID}</td>      
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>      
            </tr> 

            
            <tr>
                <td><br><br><br></td>
            </tr>
            <tr>
                <td colspan="5" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    </fieldset>  
   
       
        <fieldset>
             
        {$GRIDPOSICION}
       
    </fieldset>
   
</body>
</html>