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
				 	<td><div><label>Placa :</label></td><td>&nbsp;{$PLACA}{$PLACAID}{$PROPIO}</div></td>
					<td>&nbsp;</td><td>&nbsp;</td>
                 </tr>   
			     <tr>
				 	<td><div><label>Conductor :</label></td><td>&nbsp;{$CONDUCTOR}{$CONDUCTORID}</div></td>
				 	<td><div><label>Doc Identificaci&oacute;n : </label></td><td>&nbsp;{$CONDUCTORIDENTIFICACION}</div></td>
                 </tr>   
			     <tr>
				 	<td><div><label>Tenedor :</label></td><td>&nbsp;{$TENEDOR}{$TENEDORID}</div></td>
				 	<td><div><label>Doc Identificaci&oacute;n : </label></td><td>&nbsp;{$TENEDORIDENTIFICACION}</div></td>
                 </tr>   

			  </table>
          </tr>
		  <tr>
		    <td colspan="5" align="center">
			  <fieldset class="section">
			    <legend>Anticipos Placa</legend>
			     <iframe width="100%" name="frameAnticiposPlaca" id="frameAnticiposPlaca" src=""></iframe>
			  </fieldset>
			  <fieldset class="section">
			    <legend>Devoluciones Placa</legend>
			     <iframe width="100%" height="110px" name="frameDevolucionesPlaca" id="frameDevolucionesPlaca" src=""></iframe>
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
