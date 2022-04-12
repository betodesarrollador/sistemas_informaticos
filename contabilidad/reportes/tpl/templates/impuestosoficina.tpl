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
        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
        <table>
          <tr>
            <td width="229" ><label>Empresa : </label></td>
            <td width="264">{$EMPRESAID}{$IMPUESTOOFICINAID}</td>
            <td width="210"><label>Oficina : </label></td>
            <td width="241">{$OFICINAID}</td>
          </tr>        
          <tr>
            <td width="229" ><label>Nombre :</label></td>
            <td width="264">{$NOMBRE}</td>
            <td width="210"><label>Codigo : </label></td>
            <td width="241">{$PUC}{$IMPUESTOID}</td>
          </tr>
          <tr>
            <td><label>Descripcion : </label></td>
            <td align="left">{$DESCRIPCION}</td>
            <td><label>Aplica : </label></td>
            <td align="left">{$TIPOUBICACION}</td>
          </tr>
          <tr>
            <td><label>Ubicacion : </label></td>
            <td>{$UBICACION}</td>
            <td><label>Porcentaje : </label></td>
            <td>{$PORCENTAJE}</td>
          </tr>
          <tr>
            <td><label>Formula : </label></td>
            <td>{$FORMULA}</td>
            <td><label>Naturaleza : </label></td>
            <td>{$NATURALEZA}</td>
          </tr>
          <tr>
            <td><label>Actividad Economica : </label></td><td>{$ACTIVIDADECONOMICA}</td>
            <td><label>Estado</label></td>
            <td align="left">{$ESTADO}</td>
          </tr>
          
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
        {$FORM1END}
    </fieldset>
    
    <fieldset>
      {$GRIDIMPUESTOS}
    </fieldset>
    
  </body>
</html>
