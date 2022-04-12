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
        <table align="center">        
            <tr>
            <td><label>Codigo : </label></td>
                <td>{$ENTURNAMIENTOID}</td> 
                 <td><label>Placa : </label></td>
                <td>{$VEHICULOID}{$PLACA}</td> 
                <td><label>Muelle: </label></td>
                <td>{$MUELLE}{$MUELLEID}</td>  
            </tr>
             <tr>
                <td><label>Fecha:</label></td>
                <td>{$FECHA}</td>      
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>      
            </tr> 
            <!--<tr>
                <td colspan="6" align="center">&nbsp;{$ACTUALIZAR}&nbsp;{$SALIDA}&nbsp;{$BORRAR}&nbsp;</td>
            </tr>-->
        </table>
        <table width="100%">
            
            <td align="right"><a href="../../../framework/ayudas/ArchivoBaseNomina.xls" download="ArchivoBase"><img src="../../../framework/media/images/general/excel.png" width="25" height="25"/></a>&nbsp;&nbsp;{$ARCHIVO}</td>
            <td width="35%" align="right" >
                 {$GUARDAR}
                 {$LIMPIAR}   
                 <input type="button" id="deleteDetalle" class="btn btn-dark" value="Borrar Seleccionados" title="Borrar Seleccionados">
            </td>
			<tr>
            <td colspan="7">
            <iframe id="detallesEnturnamiento" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </td>
            </tr>
		</table>
    </fieldset> 
   <!-- <fieldset>
             
        {$GRIDENTURNAMIENTO}
       
    </fieldset>-->
    <div id="divAnulacion">
            <fieldset class="section">
                <form onSubmit="return false">
                    <table>
                        <tr>
                            <td><label>Fecha Salida :</label></td>
                            <td><label>{$FECHASALIDA}</label></td>
                        </tr>
                        <tr>
                            <td><label>Observacion:</label></td>
                            <td><label>{$OBSERVACION}{$USUARIOSTATIC}</label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">{$SALIDA}</td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div> 
   
       
        
   
</body>
</html>