{if $sectionOficinasTree neq 1}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
        <table>
          <tr>
            <td width="229" ><label>Empresa   :</label></td>
            <td width="295">{$EMPRESAS}{$MESID}</td>
            <td width="179"><label>Oficina :</label></td>
            <td width="199">{$OFICINA}</td>
          </tr>
          <tr>
            <td><label>Periodo : </label></td>
            <td align="left">{$PERIODOS}</td>
            <td ><label>Mes Numero:</label></td>
            <td align="left">{$MES}</td>
          </tr>
          <tr>
            <td><label>Mes Texto : </label></td>
            <td align="left">{$NOMBRE}</td>
            <td><label>Fecha Inicio :</label></td>
            <td>{$FECHAINICIO}</td>
          </tr>
          <tr>
            <td><label>Fecha Final : </label></td>
            <td align="left">{$FECHAFINAL}</td>
            <td><label>Estado :</label></td>
            <td>{$ESTADO}</td>
          </tr>          
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
        {$FORM1END}
    </fieldset>
    
    <fieldset>
      {$GRIDMESCONTABLE}
    </fieldset>

  </body>
</html>
	
{/if}