<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/sistemas_informaticos/framework/css/bootstrap.css">
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
        <table width="70%" align="center">
            <tr>
                <td><label>Empresa : </label></td>
                <td>{$EMPRESAID}{$PARAMETROANTICIPOID}</td>
                <td><label>Oficina : </label></td>
                <td>{$OFICINAID}</td>
            </tr>        
            <tr>
                <td><label>Documento Contable :</label></td>
                <td>{$DOCUMENTOCONTABLE}</td>
                <td><label>Cuenta Puc : </label></td>
                <td>{$PUC}{$PUCID}</td>
            </tr>
            <tr>
                <td><label>Nombre : </label></td>
                <td align="left">{$NOMBRE}</td>
                <td><label>Natutaleza : </label></td>
                <td align="left">{$NATURALEZA}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    
    </fieldset>
    {$GRIDIMPUESTOS}
    {$FORM1END}
</body>
</html>