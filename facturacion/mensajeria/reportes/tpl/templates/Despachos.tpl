<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Consolidado de Despachos - Online Tools™</title></head><body>
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
              <td width="27%"><label>Fecha Inicio:</label></td>
              <td width="73%">{$FECHAINICIO}</td>
            </tr>
            <tr>
              <td><label>Fecha Final: </label></td>
              <td>{$FECHAFINAL}</td>
            </tr>
          </table>
		  </fieldset>		  
		  </td>
          <td colspan="2">
		  <fieldset class="section">
		    {$OFICINAID}
		  </fieldset>		  
		  </td>
          <td>&nbsp;</td>
          <td colspan="2">
		   <fieldset class="section">
		    {$ESTADO}
		   </fieldset>
		  </td>
	    </tr>
	    <tr>
	      <td>PLACA</td>
	      <td colspan="2">CONDUCTOR</td>
	      <td>&nbsp;</td>
	      <td >DOCUMENTO</td>
	      <td ><label>Todos :</label>{$OPCIONESDOC}</td>          
         </tr>
	    <tr>
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
	      <td colspan="2">
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
	      <td colspan="2"> <fieldset class="section">{$DOCUMENTO} </fieldset></td>
         </tr>
        <tr>
	      <td colspan="6" align="center">
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