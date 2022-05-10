<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
   
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        {$FORM1}
         <fieldset class="section">
            <div class="form-row">
            <div class="form-group col-sm-2">
                <label>PERIODO</label>
                <label>Desde:{$DESDE}</label> 
                <label>Hasta:{$HASTA}</label> 
            </div>
            <div class="form-group col-sm-3">
                <label>CLIENTE</label><br><br>
                {$SI_CLI}<br />{$CLIENTE}{$CLIENTEID}
            </div>
            <div class="form-group col-sm-3">
                <label>COMERCIAL</label><br><br>
                {$SI_COM}<br />{$COMERCIAL}{$COMERCIALID}
            </div>
            <div class="form-group col-sm-2">
                <label>OFICINA</label><br>
                Todas: {$ALLOFFICE}<br />{$OFICINA}
            </div>
            <div class="form-group col-sm-2">
                <label>TIPO DE REPORTE</label>
                <label>{$TIPO}</label>
                <label id="saldo_pendiente">SALDO PENDIENTE</label>
                <label>{$SALDO}</label>
                <label id="saldos_corte">SALDOS CON CORTE</label>
                <label>{$SALDOS}</label>
                <label id="fecha_cortes">FECHA CORTE</label>
                <label>{$FECHACORTE}</label>
            </div>
        </div>
        </fieldset>
        <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GENERAR}&nbsp;{$DESCARGAR}&nbsp;{$EXCEL}&nbsp;{$IMPRIMIR}&nbsp;{$ENVIAR}</td>
                            <td width="15%" align="right" ></td>
                        </tr>
                    </table>
                    <br>
        <fieldset class="section">
		<table width="100%">
			<tr><td colspan="7"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table>  
        </fieldset>      
		{$FORM1END}
	</fieldset>
    
</body>
</html>
