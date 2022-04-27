<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
  <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap.css">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>

  <body>
    
	<fieldset>
        <legend>{$TITLEFORM}</legend>
        <legend>&nbsp;</legend>
{$FORM1}        
        
		<fieldset>{$GRIDSalidaTurno}</fieldset>
        <fieldset>{$GRIDSalidaTurno1}</fieldset>
        
        {$FORM1END} 
        <div id="divAnulacion">
            <fieldset class="section">
                <form onSubmit="return false">
                    <table>
                        <tr>
                            <td><label>Enturnamiento :</label></td>
                            <td><label>{$ENTURNAMIENTOID}{$USUARIO}</label></td>
                        </tr>
                        <tr>
                            <td><label>Fecha Salida Turno :</label></td>
                            <td><label>{$FECHASALIDA}</label></td>
                        </tr>
                        <tr>
                            <td><label>Observacion Salida Turno :</label></td>
                            <td><label>{$OBSERVACION}{$ESTADO}</label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">{$SALIDA}</td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div>
	</fieldset>    
  </body>
</html>