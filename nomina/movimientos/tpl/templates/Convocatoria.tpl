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
    <legend> {$TITLEFORM} </legend>
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
    {$CONVID}
    <fieldset class="section"> 
        <table align="center">
            <tr>
                <td><label>Fecha de Apertura : </label></td>
                <td>{$FAPERTURA}</td>
            </tr>
            <tr>
                <td><label>Fecha de Cierre : </label></td>
                <td>{$FCIERRE}</td>
            </tr>
            <tr>
                <td><label>Cargo :</label></td>
                <td>{$CARGO}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
        <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    {$FORM1END}
    </fieldset>

</body>
</html>
