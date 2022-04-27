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
                <td><label>Codigo Despacho : </label></td>
                <td>{$DESPACHOID}</td> 
                <td><label>Codigo alistamiento : </label></td>
                <td>{$ALISTAMIENTOID}</td> 
                <td><label>Fecha:</label></td>
                <td>{$FECHA}</td>  
            </tr>
            <br>
             <tr>
                <td><label>Turno :</label></td>
                <td>{$TURNO}</td>
                <td><label>Muelle: </label></td>
                <td>{$MUELLE}{$MUELLEID}</td>
                 <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>               
            </tr> 
        </table>
         </fieldset> 
         <fieldset class="section">
         <table align="center">
             <tr>
                <td><label>Placa : </label></td>
                <td>{$VEHICULOID}{$PLACA}</td> 
                <td><label>Marca : </label></td>
                <td>{$MARCAID}{$MARCA}</td> 
                 <td><label>Tipo Vehiculo : </label></td>
                <td>{$TIPOVEHICULOID}</td>  
            </tr>
            <tr>
                <td><label>Color : </label></td>
                <td>{$COLORID}{$COLOR}</td> 
                <td><label>Soat : </label></td>
                <td>{$SOAT}</td> 
                 <td><label>Tecnomecanica : </label></td>
                <td>{$TECNOMECANICA}</td>  
            </tr>
             <tr>
                <td><label>Nombre Conductor : </label></td>
                <td>{$NOMBRECONDUCTOR}</td> 
                <td><label>Cedula Conductor: </label></td>
                <td>{$CEDULACONDUCTOR}</td> 
                 <td><label>Telefono Conductor : </label></td>
                <td>{$TELCONDUCTOR}</td>  
            </tr>
            <tr>
                <td><label>Telefono Ayudante : </label></td>
                <td>{$TELAYUDANTE}</td>   
            </tr>
             <tr>
                <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <table width="100%">
            <tr>
                <td align="right" > 
                    <input type="button" id="saveDetalle" class="btn btn-dark" value="Despachar Seleccionados" title="Despachar Seleccionados">
                </td>
           </tr>
        </table>
         </table>
            <tr>
                <td colspan="7">
                <iframe id="detallesDespacho" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </td>
            </tr> 
        </fieldset>
    <fieldset>
             
        {$GRIDDESPACHO}
       
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
                            <td><label>{$OBSERVACION}{$USUARIOSTATIC}</label></td>
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