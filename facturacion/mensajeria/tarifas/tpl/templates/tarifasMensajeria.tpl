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
                <td >{$PERIODO}</td>
                <td><label>Tasa Seguro :</label></td>
                <td>{$PORCSEG}</td>
                
            </tr>
            <tr>
                <td><label>Vr. Min Declarado sobre:</label></td>
                <td>{$VRMINDEC}</td>
                <td><label>Vr. Min Declarado paquete:</label></td>
                <td>{$VRMINDECPAQ}</td>
            </tr>
            <tr>
                <td><label>Vr. Max Declarado sobre:</label></td>
                <td>{$VRMAXDEC}</td>
                <td><label>Vr. Max Declarado paquete:</label></td>
                <td>{$VRMAXDECPAQ}</td>
            </tr>
            
            <tr id="vr_kg_ini">
                <td><label>Vr. Sobre Min : </label></td>
                <td>{$VRKGINICIALMIN}</td>
                <td><label>Vr. Kg. Inicial : </label></td>
                <td>{$VRKGINICIALMAX}</td>
            </tr>
            <tr id="vr_kg_fin">
                <td><label>Vr. Kg. Adicional Min :</label></td>
                <td>{$KGADICIONALMIN}</td>
                <td><label>Vr. Kg. Adicional Max :</label></td>
                <td>{$KGADICIONALMAX}</td>
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
    <fieldset>{$GRIDTARIFASMENSAJERIA}</fieldset>
    <div id="divDuplicar" style="display:none">
        <form>
            <table>       
                <tr>
                    <td><label>Tipo Servicio :</label></td>
                    <td>{$TIPOMENSAJERIAID}{$USUARIOID}</td>
                </tr>          
                <tr>
                    <td><label>Periodo Base :</label></td>
                    <td>{$PERIODO}</td>
                </tr> 
                <tr>
                    <td><label>Periodo Final :</label></td>
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