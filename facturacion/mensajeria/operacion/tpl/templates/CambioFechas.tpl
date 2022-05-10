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
            <table align="center" width="100%">
                <tr>
                    <td><label>Busqueda :</label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
	</fieldset>
    {$OFICINAIDSTATIC}{$FECHA}{$FORM1}{$DETALLESSID}{$TIMPRE}{$OFICINAID}
    <fieldset class="section">
    <legend>Informaci&oacute;n Manifiesto</legend>
        <table align="center" width="60%">
            <tr>{$ID}
                <td><label>Nombre Remitente:</label></td><td>{$NOMREMITENTE}</td> 
                <td><label>Nombre Destinatario:</label></td><td>{$NOMDESTINATARIO}</td>        
            </tr>
              <tr>
                <td><label>Origen:</label></td><td>{$ORIGEN}{$ORIGENID}</td> 
                <td><label>Destino:</label></td><td>{$DESTINO}{$DESTINOID}</td>        
            </tr>	
             <tr>
                <td><label>Direcci&oacute;n Remitente:</label></td><td>{$DIREMITENTE}</td> 
                <td><label>Direcci&oacute;n destinatario:</label></td><td>{$DIDESTINATARIO}</td>        
            </tr> 
            <tr>
                <td><label>Telefono Remitente:</label></td><td>{$TELREMITENTE}</td> 
                <td><label>Telefono destinatario:</label></td><td>{$TELDESTINATARIO}</td>        
            </tr>  	                       		  	          
        </table>
    </fieldset>
     <fieldset class="section">
    <legend>Informaci&oacute;n Fechas</legend>
        <table align="center" width="100%">
            <tr>{$ID}
                <td><label>N&uacute;mero Guia :</label></td><td>{$GUIA}{$ID}</td> 
                <td><label>Tipo Guia :</label></td><td>{$TIPOMOSTRAR}{$TIPO}</td> 
                
                 <td><label>Estado Guia :</label></td><td>{$ESTADO}</td> 
                 <td><label>Fecha Guia :</label></td><td>{$FECHAGUIA}</td> 
                 <td><label>Fecha Manifiesto :</label></td><td>{$FECHAENVIO}</td> 
            </tr>
			<tr>
                <td><label>Fecha Bodega Puente:</label></td><td>{$FECHAPUENTE}</td>         
                <td><label>Fecha En Oficina:</label></td><td>{$FECHAOFCENTREGA}</td>
                <td><label>Hora En Oficina:</label></td><td>{$HORAOFCENTREGA}</td>     
                <td><label>Fecha Entrega:</label></td><td>{$FECHAENTREGA}</td>
                <td><label>Hora Entrega:</label></td><td>{$HORAENTREGA}</td>     
            </tr>             		  	                       		  	          
        </table>
    </fieldset>
		<table align="center">
	      <tr>
	        <td align="center">{$ACTUALIZAR}&nbsp;</td>
          </tr>
      </table>
      {$FORM1END}
    </fieldset>
	    
</body>
</html>