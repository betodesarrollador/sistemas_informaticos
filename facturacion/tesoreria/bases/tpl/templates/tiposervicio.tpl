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
        <table align="center" width="90%">
            <tr>
                <td><label>N&uacute;mero : </label></td>
                <td>{$BIENID}</td>
                <td><label>Tipo de Documento :</label></td>
                <td>{$DOCID} </td>
            </tr>
            <tr>
                <td><label>Agencia : </label></td>
                <td>{$AGENCIAID}</td>
                <td><label>Nombre Bien/Servicio :</label></td>
                <td>{$NOMBREBIEN}</td>                
            </tr>            
            <tr>
                <td valign="top"><label>Ingresa Centro Costo Manualmente :</label></td>
                <td valign="top">{$CENTROMANUAL}</td>
                <td valign="top"><label>Ingresa Valores Manualmente :</label></td>
                <td valign="top">{$VALORMANUAL}</td>
            </tr>
            <tr>
                <td valign="top"><label>Ingresa Tercero Manualmente :</label></td>
                <td valign="top">{$TERCEROMANUAL}</td>
                <td valign="top"><label>Ingresa Cuentas PUC Manualmente :</label></td>
                <td valign="top">{$PUCMANUAL}</td>
            </tr>
            <tr>
                <td valign="top"><label>Maneja Cheques :</label></td>
                <td colspan="3" valign="top">{$MANCHEQUE}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td width="90%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td  width="85%" align="left"><label>Configuraci&oacute;n de Cuentas Contables para Tipo de Servicio.</label></td>
                <td width="15%" align="right" >
                <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/> <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallepuc" title="Borrar Seleccionados"/>
                </td>
            </tr>
            <tr>
            	<td colspan="2"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
        </table> 
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDTIPOSERVICIO}</fieldset>   
</body>
</html>
