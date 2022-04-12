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
        
       <table align="center" width="70%">
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <!--<td width="60%" align="center">{$EXCEL}&nbsp;</td>--> 
                            <td width="15%" align="right" ></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
		<fieldset>{$GRIDDESPACHO}</fieldset>
        
        {$FORM1END} 
        <div id="divTurno">
            <fieldset class="section">
                <form onSubmit="return false">
                    <table>
                        <tr>
                            <td><label>Alistamiento :</label></td>
                            <td><label>{$ALISTAMIENTOID}{$FECHAACTUALIZA}</label></td>
                        </tr>
                        <tr>
                            <td><label>Asignar Turno :</label></td>
                            <td><label>{$TURNO}</label></td>

                        </tr>
                        <tr>
                            <td><label>Observacion Asignar Turno :</label></td>
                            <td><label>{$OBSERVACION}{$USUARIO}</label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">{$ASIGNAR}</td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div>

        <div id="divMuelle">
            <fieldset class="section">
                <form onSubmit="return false">
                    <table>
                        <tr>
                            <td><label>Alistamiento :</label></td>
                            <td><label>{$ALISTAMIENTOID1}{$FECHAACTUALIZA}</label></td>
                        </tr>
                        <tr>
                            <td><label>Asignar Muelle :</label></td>
                            <td><label>{$MUELLEID}</label></td>
                        </tr>
                        <tr>
                            <td><label>Observacion Asignar Muelle :</label></td>
                            <td><label>{$OBSERVACIONMUELLE}{$USUARIO}</label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">{$ASIGNAR}</td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div>
	</fieldset>    
  </body>
</html>