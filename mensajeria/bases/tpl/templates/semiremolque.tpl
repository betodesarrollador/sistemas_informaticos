<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Semi/Remolque</title>
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
        <table align="center" width="80%">
            <tr>
                <td><label>Plaqueta : </label></td>
                <td>{$PLACA}{$PLACAID}</td>
                {*<td><label>Color :</label></td>
                <td colspan="3">{$COLOR}{$COLORID}</td>*}
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td><label>Marca : </label></td>
                <td>{$MARCA}{$MARCAID}</td>
                <td><label>Modelo : </label></td>
                <td colspan="3">{$MODELO}</td>
            </tr>
            <tr>
                <td><label>Configuraci&oacute;n : </label></td>
                <td>{$TIPOSEMIRREMOLQUE}</td>
                <td><label>Carroceria : </label></td>
                <td colspan="3">{$CARROCERIA}</td>
            </tr>
            <tr>
                <td><label>Peso Vacio (Kg) : </label></td>
                <td>{$PESOVACIO}</td>
                <td><label>Capacidad de Carga : </label></td>
                <td>{$CAPACIDADCARGA}</td>
                <td><label>Unidad Capacidad :</label></td>
                <td>{$UNIDADCAPACIDADCARGA}</td>
            </tr>
            <tr>
                <td><label>Foto Lateral :</label></td>
                <td>{$IMAGENLATERAL}</td>
                <td><label>Foto Trasera :</label></td>
                <td colspan="3">{$IMAGENATRAS}</td>
            </tr>
            <tr>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
            </tr>	
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>			  	  
            <tr>
                <td><label>Nombre Tenedor : </label></td>
                <td colspan="5">{$NOMBRETENEDOR}{$IDENTIDADTENEDOR}</td>
            </tr>
            <tr>
                <td><label>Nombre Propietario : </label></td>
                <td colspan="5">{$NOMBREPROPIETARIO}{$IDENTIDADPROPIETARIO}</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDREMOLQUES}</fieldset>

</body>
</html>