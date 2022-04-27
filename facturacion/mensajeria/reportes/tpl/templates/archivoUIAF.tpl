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
      <div id="table_find">
        <table>
         <tbody><tr>
           <td><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </tbody></table>
    </div>
	{$FORM1}	  
	  <table align="center">
	    {*<tr><td><label>Cliente :</label></td><td>{$CLIENTEID}</td></tr>*}
	    <tr><td><label>Periodo :</label></td><td>{$PERIODOSID}</td></tr>		
		<tr><td colspan="2" align="center"><input type="button" name="generar" id="generar" value="Generar Archivo >>" /></td></tr>
	  </table>    
      {$FORM1END}
    </fieldset>
    
  </body></html>