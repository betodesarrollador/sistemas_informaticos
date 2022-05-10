<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Reporte Aprobacion Despachos - SI&amp;SI™</title></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  

    <fieldset>
      <legend>{$TITLEFORM}</legend>
	{$FORM1}
	  <table width="92%" align="center" class="tableFilter">
	   <thead>
	    <tr>
		  <td width="20%">PERIODO</td>
		  <td width="15%">PLACA</td>
		  <td width="23%">CONDUCTOR</td>
		  <td width="1%">&nbsp;</td>
		  <td width="6%">OFICINA</td>
		  <td width="14%"><label>Todas :</label>{$OPCIONESOFICINA}</td>
		  <td width="1%">&nbsp;</td>
		  <td width="6%">ESTADO</td>
	      <td width="14%"><label>Todos :</label>{$OPCIONESESTADO}</td>
	    </tr>
	    <tr>
	      <td>
		  <fieldset class="section">
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
		  </fieldset>		  
		  </td>
          <td>
		  <fieldset class="section">
		  <table width="94%" border="0">
            <tr>
              <td>{$OPCIONESPLACA}</td>
            </tr>
            <tr>
              <td>{$PLACA}{$PLACAID}</td>
            </tr>
          </table>
		  </fieldset>
		  </td>
          <td>
		  <fieldset class="section">
		  <table width="100%" border="0">
            <tr>
              <td>{$OPCIONESCONDUCTOR}</td>
            </tr>
            <tr>
              <td>{$CONDUCTOR}{$CONDUCTORID}</td>
            </tr>
          </table>
		  </fieldset>		  
		  </td>
          <td>&nbsp;</td>
          <td colspan="2">
		  <fieldset class="section">
		    {$OFICINAID}
		  </fieldset>		  
		  </td>
          <td>&nbsp;</td>
          <td colspan="2">{$ESTADO}</td>
	    </tr>
	    <tr>
	      <td colspan="9" align="center">
            <input type="button" name="listar"  id="listar" value="Listar" />		  
		    <input type="button" name="generar" id="generar" value="Generar Excel" />
		  </td>
        </tr>
	   </thead>
    </table>
    {$FORM1END}
	
	  <iframe name="frameResult" id="frameResult" src="about:blank"></iframe>
    </fieldset>
    
  </body>
</html>