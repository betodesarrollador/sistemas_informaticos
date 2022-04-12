<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
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
    {$USUARIOACTUALIZA}
    {$FECHAACTUALIZA}
    {$FECHAREGISTRO}
    <fieldset class="section">  
        <table align="center">        
            <tr>
                <td><label>No. :</label></td>
                <td>{$PARAMID}{$USUARIO}</td>
                <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td>            
            </tr>
            <tr>
            </tr> 

             <tr>
                <td><label>Bodega : </label></td>
                <td>{$BODEGA}{$BODEGAID}</td>                      
                <td><label>Codigo : </label></td>
                <td>{$CODIGO}</td>            
            </tr> 
             <tr>
                <td><label>Estado :</label></td>
                <td colspan="2">{$ESTADO}</td>
            </tr> 
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    </fieldset>  
   
       
        <fieldset>
             
        {$GRIDCrearMuelle}
       
    </fieldset>
   
</body>
</html>