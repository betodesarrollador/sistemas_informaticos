<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        <div id="table_find" align="center">
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
        <table align="center">   
        {$FECHAREGISTRO}{$USUARIOID}{$FECHAACT}{$USUARIOACT}     
            <tr>
                <td><label>Codigo :</label></td>
                <td>{$PARAMID}</td>
                <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td>
                <td><label>Descripcion : </label></td>
                <td>{$DESCRIPCION}</td>
            </tr>
            <tr>
                <td><label>Prioridad : </label></td>
                <td>{$PRIORIDAD}</td>
                <td><label>Fase : </label></td>
                <td>{$FASEID}</td>
                <td><label>Fecha Inicial :</label></td>
                <td>{$FECHAINI}</td>
            </tr>
            <tr>
                <td><label>Fecha Final : </label></td>
                <td>{$FECHAFIN}</td>
                <td><label>Fecha Inicial Real : </label></td>
                <td>{$FECHAINIREAL}</td>
                 <td><label>Fecha Final Real : </label></td>
                <td>{$FECHAFINREAL}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
                <td> &nbsp;</td>
                <td id="adjuntover">&nbsp;</td>                
                <td><label>Adjunto max (4 MB):</label></td>
                <td id="fileUpload">{$ARCHIVO}</td>
            </tr>
            <tr>
              <td><label>Responsable :</label></td>
                <td>{$RESPONSABLEID}{$RESPONSABLE}</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$CERRAR}</td>
            </tr>
        </table>
    </fieldset>  
   
       
        <fieldset>
             
        {$GRIDActividad}
       
    </fieldset>
    <div id="divCierre">
			<form>
				<fieldset class="section">
					<table>       
                    <tr>
						<td><label>Fecha cierre real:</label></td>
						<td>{$FECHACIERREREAL}</td>
					</tr>
                    <tr>
						<td><label>Observaci&oacute;n:</label></td>
						<td>{$OBSERVACION}</td>
					</tr>
					<tr>
						<td colspan="2" align="center">{$CERRAR}</td>
					</tr>                    
					</table>
				</fieldset>
		</form>
    </div>
   
</body>
</html>