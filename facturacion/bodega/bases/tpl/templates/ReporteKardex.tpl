<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/talpa/framework/css/bootstrap1.css">
   <title>Kardex - SI&SI™</title></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  

    <fieldset>
      <legend>{$TITLEFORM}</legend>
	{$FORM1}
	  <fieldset class="section">
	  <table width="50%" align="center" class="tableFilter">
	   <thead>
	    <tr>
		  <td width="10%"><label>PERIODO</label></td>
		  <td width="10%"><label>PRODUCTO</label></td>

	    </tr>
	    <tr>
	      <td>
		  <table width="100%" border="0">
            <tr>
              <td width="10%"><label>Fecha Inicio : </label></td>
              <td width="10%">{$FECHAINICIO}</td>
            </tr>
            <tr>
              <td><label>Fecha Final : </label></td>
              <td>{$FECHAFINAL}</td>
            </tr>
          </table>
		  </td>
          <td>
		  <table width="60%" border="0">
            <tr>
              <td>{$OPCIONESPRODUCTO}</td>
            </tr>
            <tr>
              <td>{$PRODUCTO}{$PRODUCTOID}</td>
            </tr>
          </table>
		  </td>
       
	    </tr>
	    <tr>
	      <td colspan="9" align="center">
            <input type="button" class="btn btn-primary" name="listar"  id="listar" value="Listar" />		  
		    <input type="button" class="btn btn-primary" name="generar" id="generar" value="Generar Excel" />
		  </td>
        </tr>
	   </thead>
    </table>
    {$FORM1END}
    </fieldset>
	  <iframe name="frameResult" id="frameResult" src="about:blank"></iframe>
    </fieldset>
    
  </body>
</html>