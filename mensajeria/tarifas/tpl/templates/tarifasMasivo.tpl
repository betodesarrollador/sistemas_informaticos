<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
                {$TARIFAID}
                <td><label>Tipo Servicio :</label></td>
                <td>{$TIPOMENSAJERIAID}</td>
                <td><label>Tipo Envio :</label></td>
                <td>{$TIPOENVIOID}</td>
                
            </tr>
            <tr>
                <td><label>Periodo :</label></td>
                <td colspan="3">{$PERIODO}</td>
            </tr>
            <tr>
                <td><label>Rango Inicial : </label></td>
                <td>{$RANGOINICIAL}</td>
                <td><label>Rango Final :</label></td>
                <td>{$RANGOFINAL}</td>
            </tr>
            <tr>
                <td><label>Vr. Min Declarado :</label></td>
                <td>{$VRMINDEC}</td>
                <td><label>Tasa Seguro :</label></td>
                <td>{$PORCSEG}</td>
            </tr>
            <tr>
                <td><label>Vr. Min Rango : </label></td>
                <td>{$VRRANGOMIN}</td>
                <td><label>Vr. Max Rango :</label></td>
                <td>{$VRRANGOMAX}</td>
            </tr>
            <tr>
                <td  colspan="4"align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$DUPLICAR}</td>
            </tr>
        </table>
        {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDTARIFASMASIVO}</fieldset>
    <div id="divDuplicar" style="display:none">
        <form>
            <table>              
                <tr>
                    <td><label>PERIODO BASE :</label></td>
                    <td>{$PERIODO}</td>
                </tr> 
                <tr>
                    <td><label>PERIODO FINAL :</label></td>
                    <td>{$PERIODOFIN}</td>
                </tr>           
                <tr>
                    <td colspan="2" align="center">{$DUPLICAR}</td>
                </tr>                    
            </table>
        </form>
    </div>        
</body>
</html>