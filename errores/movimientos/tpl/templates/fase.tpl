<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
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
        {$FECHASTATIC}{$USUARIOID}{$USUARIOSTATIC}{$FECHAACTUALIZA}
    </fieldset>
    {$FORM1}
    <fieldset class="section">  
        <table align="center">        
            <tr>
                <td><label>Fase :</label></td>
                <td>{$FASEID}</td>
            </tr>
            <tr>
                <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td> 
                <td><label>Fecha Registro : </label></td>
                <td>{$FECHAREGISTRO}</td>           
            </tr> 

            <tr>
                <td><label>Fecha Inicio Programada : </label></td>
                <td>{$FECHAINICIOPROGRAMADA}</td> 
                <td><label>Fecha Inicio Real : </label></td>
                <td>{$FECHAINICIOREAL}</td> 
            </tr> 

            <tr>

                <td><label>Fecha Fin Programada : </label></td>
                <td>{$FECHAFINPROGRAMADA}</td>  
                <td><label>Fecha Fin Real : </label></td>
                <td>{$FECHAFINREAL}</td>      
            </tr>  

            <tr>
               <td><label> Proyecto :</label></td>
               <td>{$PROYECTOID} </td>

               <td><label>Usuario :</label></td>
               <td>{$USUARIO}</td>
           </tr>
           <tr>
            <td><label>Estado :</label></td>
            <td><label>Abierta {$ABIERTA}   Cerrada {$CERRADA}</label></td> 
            <td ><label  style='color:red;  font-family: cursive;
            font-size: 100%' id='label_mensaje' ></label></td>

        </tr>
        <tr>
           <td>{$USUARIOCIERREID} </td>
           <td>{$USUARIOACTUALIZAID} </td>
           <td>{$USUARIOID} </td>
       </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$CERRAR}</td>
    </tr>
</table>
</fieldset>  


<fieldset>

    {$GRIDFASE}

</fieldset>

</body>
</html>