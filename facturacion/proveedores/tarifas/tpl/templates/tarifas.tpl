<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
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
        <table align="center" width="95%">
            <tr>
                <td colspan="2">
                    <fieldset class="section" >
                        <table align="center" width="95%">
                            <tr>
                                <td><label>Origen  : </label></td>
                                <td colspan="2">{$TARIFASID}{$ORIGEN}{$ORIGENID}</td>
                                <td><label>Destino : </label></td>
                                <td colspan="2">{$DESTINO} {$DESTINOID}</td>
                            </tr>
                            <tr>  
                                <td><label>Tipo Vehiculo :</label></td>
                                <td align="left">{$CONFIGID}</td>
                                <td><label>Capacidad (Kl) :</label></td>
                                <td align="left">{$CAPACIDAD}</td>
                                <td><label>Periodo :</label></td>
                                <td>{$PERIODO}</td>
                            
                            </tr>
                        </table>        
                    </fieldset>
                </td>
            </tr>       
            <tr>
                <td width="65%" align="left">
                    <fieldset class="section" >
                        <table align="center" width="90%">
                            <tr> 
                                <td colspan="3"><label>Valor Flete</label></td>
                            </tr>
                            <tr> 
                                <td width="30%">&nbsp;</td>
                                <td width="35%"><label>M&iacute;nimo</label></td>
                                <td width="35%"><label>M&aacute;ximo</label></td>
                            </tr>
                            <tr> 
                                <td><label>Valor Cupo : </label>
                                </td><td align="left">{$CUPO}</td>
                                <td align="left">{$CUPOFIN}</td>
                            </tr>
                            <tr>
                                <td><label>Valor Tonelada : </label></td>
                                <td>{$TONELADA}</td>
                                <td>{$TONELADAFIN}</td>
                            </tr>
                            <tr>
                                <td><label>Valor Volumen (m3): </label></td>
                                <td>{$VOLUMEN}</td>
                                <td>{$VOLUMENFIN}</td>
                            </tr>
                            <tr>
                                <td><label>Valor Cantidad/Galones : </label></td>
                                <td>{$CANTIDAD}</td>
                                <td>{$CANTIDADFIN}</td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
                <td width="35%" valign="top">
                    <fieldset class="section" >
                        <table align="center"> 
                            <tr> 
                                <td colspan="2"><label>Porcentaje Anticipo Terceros</label></td>
                            </tr>
                            <tr>
                                <td><label>M&iacute;nimo</label></td>
                                <td><label>M&aacute;ximo</label></td>
                            </tr>
                            <tr>                                        
                                <td align="left">{$ANTINI}</td>
                                <td align="left">{$ANTFIN}</td>
                            </tr>
                        </table>
                        <br>
                        <table align="center"> 
                            <tr> 
                                <td colspan="2"><label>Valores (Absoluto) Anticipo Propios</label></td>
                            </tr>
                            <tr>
                                <td><label>M&iacute;nimo</label></td>
                                <td><label>M&aacute;ximo</label></td>
                            </tr>
                            <tr>                                        
                                <td align="left">{$ANTPROPIOINI}</td>
                                <td align="left">{$ANTPROPIOFIN}</td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>      
            <tr>
                <td colspan="2" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    
    </fieldset>
    <fieldset>{$GRIDTARIFAS}</fieldset>{$FORM1END}
</body>
</html>