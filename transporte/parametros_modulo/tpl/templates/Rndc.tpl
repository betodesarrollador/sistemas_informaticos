<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <title>Envio RNDC  </title> 
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
        <table align="center">
          <tr>
            <td id="celda_rangos">
			
			<fieldset class="section">
			  <legend>ENVIO WEBSERVICE</legend>
			  <table width="100%">
				<tr><td><label>Activar Envio Informaci&oacute;n RNDC :</label></td><td >{$ACTIVOENVIO}{$RNDCID}</td></tr>
				<tr><td><label>Activar Filtro de Impresi&oacute;n Manifiesto :</label></td><td>{$ACTIVOIMPRESION}</td></tr>									  					
			  </table>
			</fieldset>
			</td>
          </tr>
	      <tr>
	        <td align="center">{$ACTUALIZAR}</td>
          </tr>
      </table>
      {$FORM1END}
    </fieldset>
    
  </body>
</html>