<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Reporte Rendimiento - SI&amp;SI™</title>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  
    <link rel="stylesheet" href="sistemas_informaticos/bodega/bases/css/bootstrap1.css">
</head>
<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
    </fieldset>
    {$FORM1}
       
 <fieldset class="section">
    <table class="tableFilter" align="center">
        <div id="general">
            <thead>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td ><label>Fecha Inicio</label></td>
                                <td >{$FECHAINICIO}&emsp;</td>
                            </tr>
                            <tr>
                                <td ><label>Fecha Final</label></td>
                                <td >{$FECHAFINAL}&emsp;</td>
                            </tr>
                        </table>

                    </td>  
                    <td>
                        <table width="100%">
                            <tr>
                                 <td width="5%"><label>Desarrollador&emsp;</label></td> 
                                 <td width="5%">{$CLIENTE}{$USUARIOID}</td>   
                            </tr>
                        </table>

                    </td>  
                </tr>
                <tr>
                    <td colspan="7" align="center"><br>{$LISTAR}&emsp;&emsp;{$GENERAR}</td>
                </tr>
            </thead>
        </div>
    </table>
</fieldset>
<iframe name="frameResult" id="frameResult" src="about:blank"></iframe>
{$FORM1END}    
</body>
</html>