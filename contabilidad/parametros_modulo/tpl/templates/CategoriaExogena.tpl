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
        <table align="center">
        <tr>
          <td><label>Busqueda : </label></td>
        </tr>
        <tr>
          <td>{$BUSQUEDA}</td>
        </tr>
        </table>
    </div>
    </fieldset>
    {$FORM1}{$CATEGORIAEXOGENAID}
    <fieldset class="section">
        <table align="center">		  
            <tr>
                <td><label>Codigo: </label></td>
                <td>{$CODIGO}</td>
            </tr>
            <tr>
                <td><label>Descripcion: </label></td>
                <td>{$DESCRIPCION}</td>            
            </tr>       
            <tr>
                <td><label>Estado: </label></td>
                <td><label>{$ESTADO}</label></td>
            </tr> 		  		  		   
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
    {$FORM1END}
    </fieldset>
</body>
</html>
