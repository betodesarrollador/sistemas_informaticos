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
                    <td>{$BUSQUEDA}{$CERTIF_TER}
                    </td>
                </tr>
            </table>
        </div>     
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center" class="tableFilter">
            <thead>
                <tr align="center">
                    <td align="left" valign="top"><label>CERTIFICADO</label></td>
                    <td align="center"><label>CUENTAS</label></td>
                    <td align="center" valign="top"><label>TERCEROS</label></td>
                    <td align="center" valign="top"><label>RANGO</label></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td valign="top">{$DOCUMENTOS}</td>
                    <td valign="top">{$PUCID}</td>
                    <td>
                        <table border="0">
                            <tr>
                                <td align="left" valign="top">{$OPTERCERO}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="bottom">{$TERCERO}{$TERCEROID}</td>
                            </tr>
                        </table>
					</td>
                    <td valign="top">
                    	<table border="0">
                            <tr>
                                <td width="50"><label>DESDE </label></td>
                                <td width="200">{$DESDE}</td>
                            </tr>
                            <tr>
                                <td><label>HASTA </label></td>
                                <td>{$HASTA}</td>
                            </tr>
                        </table>
					</td>
                </tr>
            </tbody>
        </table>
        <div align="center">{$GENERAR}</div>
    </fieldset>
    {$FORM1END}
    {$FORM2}
        <iframe id="frameReporte" name="frameReporte" src=""></iframe>
    {$FORM2END}
</body>
</html>