{if $sectionOficinasTree neq 1}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  
  {$CSSSYSTEM}  
  
  {$TITLETAB} 
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

         <div id="table_find">
        <table align="center">
        <tr>
          <td><label>Busqueda : </label></td>
        </tr>
        <tr>
          <td>{$BUSQUEDA}</td>
        </tr>
        </table>
        </div>
        
        {$FORM1}
        <fieldset class="section">
        <table>
          <tr>
            <td width="229" ><label>Empresa   :</label></td>
            <td width="295">{$EMPRESAS}{$PERIODOSID}</td>
            <td width="179"><label>Fecha Cierre : </label></td>
            <td width="199">{$FECHACIERRE}</td>
          </tr>
          <tr>
            <td><label>A&ntilde;o   :</label></td>
            <td align="left">{$ANIO}</td>
            <td ><label>Estado :</label></td>
            <td align="left">{$ESTADO}</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$REPLICAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>
        
    
    <fieldset>
    
    <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    </fieldset>
    {$FORM1END}
    </fieldset>

  </body>
</html>
	
{/if}