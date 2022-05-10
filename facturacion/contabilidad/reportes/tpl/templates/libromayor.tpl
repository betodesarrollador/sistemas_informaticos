<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  </head>
  <body>
  {$FORM1}
	  <table align="center">
	    <tr>
		  <td><label>REPORTE:</label></td>
		  <td align="right">{$REPORTE}</td>
	      <td colspan="2" align="right">
		    <span id="empresaReporte">{$EMPRESASID}</span>
		    <span id="oficinaReporte"></span>
		    <span id="centroCostoReporte"></span>		  </td>
        </tr>	
	    <tr>
		  <td><label>NIVEL:</label></td>
		  <td align="right">{$NIVEL}</td>
		  <td><label>TERCERO:</label></td>
	      <td align="right">{$TERCERO}</td>
	    </tr>
	    <tr>
		  <td><label>CORTE :</label><label></label></td>
		  <td align="right">{$CORTE}</td>
		  <td>&nbsp;</td>
	      <td align="right">{$GENERAR}</td>
	    </tr>					  
	  </table>
  {$FORM1END}
    
  {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
  {$FORM2END}
       
  </body>
</html>