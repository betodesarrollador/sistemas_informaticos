<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Solicitud de Servicio - Online Tools™</title></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  

    <fieldset>
      <legend>{$TITLEFORM}</legend>
	{$FORM1}
    <fieldset class="section">
	  <table width="100%" align="center" class="tableFilter">
	   <thead>
	    <tr>
		  <td width="20%"><label>PERIODO</label></td>
		  <td width="15%"><label>PLACA</label></td>
		  <td width="23%"><label>CONDUCTOR</label></td>
		  <td width="20%"><label>OFICINA</label></td>
		  <td width="20%"><label>ESTADO</label></td>
	    </tr>
	    <tr>
	      <td>		  
		  <table width="100%" border="0">
            <tr>
              <td width="27%"><label>Fecha Inicio : </label></td>
              <td width="73%">{$FECHAINICIO}</td>
            </tr>
            <tr>
              <td><label>Fecha Final : </label></td>
              <td>{$FECHAFINAL}</td>
            </tr>
          </table>
		  </td>
          <td>
		  <table width="94%" border="0">
            <tr>
              <td>{$OPCIONESPLACA}</td>
            </tr>
            <tr>
              <td>{$PLACA}{$PLACAID}</td>
            </tr>
          </table>
		  </td>
          <td>
		  <table width="100%" border="0">
            <tr>
              <td>{$OPCIONESCONDUCTOR}</td>
            </tr>
            <tr>
              <td>{$CONDUCTOR}{$CONDUCTORID}</td>
            </tr>
          </table>
		  </td>
          <td><label>Todas :</label>{$OPCIONESOFICINA}<br>{$OFICINAID}</td>
          <td><label>Todos :</label>{$OPCIONESESTADO}<br>{$ESTADO}
		    
		  </td>
	    </tr>
	    <tr>
	      <td colspan="9" align="center">
            <input type="button" name="listar"  id="listar" value="Listar" />		  
		    <input type="button" name="generar" id="generar" value="Generar Excel" />
		  </td>
        </tr>
	   </thead>
    </table>
  </fieldset>		  
    {$FORM1END}
	
	  <iframe name="frameResult" id="frameResult" src="about:blank"></iframe>
    </fieldset>
    
  </body>
</html>