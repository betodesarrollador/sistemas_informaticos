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
		        
        {$FORM1}
        <table align="center" width="100%">
          <tr>
            <td align="center">
			  <table>
			     <tr>
				 <td><label>Tipo Anticipo :</label>&nbsp;{$TIPOANTICIPO}</td>
				 <td>
				   <div id="divManifiesto"><label>Manifiesto :</label>&nbsp;{$MANIFIESTO}{$MANIFIESTOID}</div>
				   <div id="divDespacho"><label>Despacho :</label>&nbsp;{$DESPACHO}{$DESPACHOID}</div>
				 </td>
			  </table>
          </tr>
		  <tr>
		    <td colspan="5" align="center">
			  <fieldset class="section">
			    <legend>Anticipos Manifiesto</legend>
			     <iframe width="100%" name="frameAnticipos" id="frameAnticipos" src=""></iframe>
			  </fieldset>
               <fieldset class="section">
                    <legend>Devoluciones </legend>
                     <iframe width="100%" height="110px" name="frameDevoluciones" id="frameDevoluciones" src=""></iframe>
                  </fieldset>
			</td>
				 
	      </tr>
		  <tr><td colspan="5" align="center"><div align="center"><span style="display:none;">{$ANULAR}{$BORRAR}</span>{$IMPRIMIR}&nbsp;{$LIMPIAR}</div></td></tr>
		  <tr>
		    <td colspan="5" align="center">
			  <fieldset class="section">
			    <legend>Registro contable{$ENCABEZADOREGISTROID}</legend>
			      <div><iframe width="100%" name="frameRegistroContable" id="frameRegistroContable" src=""></iframe></div>
			  </fieldset>			
			</td>
	      </tr>	  
		  
    </table>
		 
	    {$FORM1END}
    </fieldset>
    
  </body>
</html>
