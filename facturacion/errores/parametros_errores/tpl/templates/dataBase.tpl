<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
     <link rel="stylesheet" href="sistemas_informaticos/bodega/bases/css/bootstrap1.css">
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

         <tr>
                <td><label>IP</label></td>
                <td colspan="2">&emsp;&emsp;{$IP}{$ID}&emsp;&emsp;</td>         
            </tr>      
           
            <tr>
                <td><label>BASE DE DATOS</label></td>
                <td>&emsp;&emsp;{$DATABASE}&emsp;&emsp;</td>
                <td><label>CONTRASE&Ntilde;A </label></td>
                <td>&emsp;&emsp;{$CONTRASENA}&emsp;&emsp;</td>            
            </tr> 
            <tr>
                 <td><label>ESTADO &emsp;&emsp;</label></td>
                <td><label>&emsp;&emsp;Activo {$ACTIVO}   Inactivo {$INACTIVO}{$TIPO}</label></td>        
                <td><label>USUARIO</label></td>
                <td>&emsp;&emsp;{$USUARIO}</td>    
            </tr> 

            <tr>
                <td><br><br></td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    </fieldset>  
   
       
        <fieldset>
             
        {$GRIDdataBase}
       
    </fieldset>
   
</body>
</html>