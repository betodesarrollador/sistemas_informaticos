<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$CSSSYSTEM}
		{$TABLEGRIDCSS}
		{$JAVASCRIPT}
		{$TABLEGRIDJS}
		{$TITLETAB}
	</head>
	<body>
		<fieldset>
			<legend>{$TITLEFORM}</legend>
			<div id="table_find">
				<table>
					<tr>
						<td><label>Busqueda: </label></td>
						<td>{$BUSQUEDA}</td>
					</tr>
				</table>
			</div>
			{$FORM1}
			<fieldset class="section">
				<legend>Datos Cierre</legend>
				<table width="80%" align="center">
                    <tr>
                        <td><label>Consecutivo: </label></td>
                        <td>{$LIQUIDACIONID}{$CONSECUTIVO}{$OFICINAID}{$USUARIOID}{$FECHA_REG}{$ENCABEZADOID}</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
                    </tr>
                    <tr>
						<td><label>Forma Pago: </label></td>
						<td>{$PAGO}</td>
						<td><label>Tipo Documento: </label></td>
						<td>{$DOCID}</td>
                    </tr>
					<tr>
						<td><label>Desde: </label></td><td>{$DESDE}</td>
						<td><label>Hasta: </label></td><td>{$HASTA}</td>
					</tr>
					<tr>
                        <td><label>Valor: </label></td>
                        <td>{$VALOR}</td>
                        <td><label>Estado: </label></td>
                        <td>{$ESTADO}</td>
                        
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</fieldset>
			<table align="center">
				<tr>
					<td colspan="4">{$GUARDAR}&nbsp;{$IMPRIMIR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}</td>
				</tr>
			</table>
			<fieldset class="section" > 
	    		<legend>REMESAS CONTADO</legend>
                {$IMPORTARSOLICITUD}
       	 		<iframe id="detalleLiquidacion" src=""></iframe> 
	   		</fieldset>
			<div id="divOrdenServicio">
				<iframe id="iframeOrdenServicio" style="height: 370px;"></iframe>
			</div>
            
			{$FORM1END}
		</fieldset>
        <div>{$GRIDMANIFIESTOS}</div>
        <div id="divAnulacion">
          <form onSubmit="return false">
            <table>              
              <tr>
                <td><label>Descripci&oacute;n Anulaci&oacute;n:</label></td>
                <td>{$OBSERVANULACION}</td>
              </tr> 
              <tr>
                <td colspan="2" align="center">{$ANULAR}</td>
              </tr>                    
            </table>
          </form>
        </div>
        
	</body>
</html>