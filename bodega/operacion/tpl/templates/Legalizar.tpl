<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
    <link rel="stylesheet" href="sistemas_informaticos/bodega/operacion/css/bootstrap1.css">
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
        <table width="70%" align="center">        
            <tr>
                <td><label>Codigo :</label></td>
                <td>{$RECEPCIONID}</td>
                <td><label>Fecha:</label></td>
                <td>{$FECHA}</td>
            </tr>
            <tr>
                 <td><label>Placa: </label></td>
                <td>{$ENTURNAMIENTOID}{$PLACA}</td> 
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>       
            </tr>
            <tr>
                <td colspan="8" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td align="right" > 
                    <input type="button" id="saveDetalle" class="btn btn-dark" value="Legalizar Seleccionados" title="Legalizar Seleccionados">
                </td>
           </tr>
        </table>
        <tr>
            <td colspan="7">
            <iframe id="detallesLegalizar" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
        </tr> 
    </fieldset> 
    
        <fieldset>
             
        {$GRIDLEGALIZAR}
       
    </fieldset>
    <div id="divAnulacion">
            <fieldset class="section">
                <form onSubmit="return false">
                    <table>
                        <tr>
                            <td><label>Fecha Anulacion :</label></td>
                            <td><label>{$FECHAANULACION}</label></td>
                        </tr>
                        <tr>
                            <td><label>Observacion:</label></td>
                            <td><label>{$OBSERVACIONANULACION}{$USUARIOANULA}</label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">{$ANULAR}</td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div> 
   
</body>
</html>