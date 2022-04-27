{if $sectionOficinasTree neq 1}
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
    <legend>{$TITLEFORM}</legend>
    <div id="table_find">
        <table align="center">
        <tr>
          <td><label>Busqueda : </label></td>
        </tr>
        <tr>
          <td>{$BUSQUEDA}</td>
        </tr>
        </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
    <table width="95%" align="center">
        <tr>
            <td width="229" ><label>Empresa   :</label></td>
            <td width="295">{$EMPRESAS}{$MESID}</td>
            <td width="179"><label>Oficina :</label></td>
            <td width="199">{$OFICINA}</td>
        </tr>
        <tr>
            <td><label>Periodo : </label></td>
            <td align="left">{$PERIODOS}</td>
            <td><label>Mes N&uacute;mero :</label></td>
            <td align="left">{$MES}</td>
        </tr>
        <tr>
            <td><label>Mes Texto : </label></td>
            <td align="left" colspan="1">{$NOMBRE}</td>
        </tr>
        <tr>
            <td><label>Fecha Inicio :</label></td>
            <td>{$FECHAINICIO}</td>
            <td><label>Fecha Final : </label></td>
            <td align="left">{$FECHAFINAL}</td>
        </tr>          
        <tr>
            <td><label>Mes Trece :</label></td>
            <td>{$MESTRECE}</td>
            <td><label>Estado :</label></td>
            <td>{$ESTADO}</td>
        </tr>          
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
        </tr>
    </table>
   
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
     {$FORM1END}
    </fieldset>

</body>
</html>
{/if}