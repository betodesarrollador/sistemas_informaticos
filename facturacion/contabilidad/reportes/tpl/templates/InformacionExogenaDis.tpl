<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Informacion exogena Distrital</title></head><body>
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
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
  <fieldset class="section"> 
	  <table align="center">
	    <tr><td><label>Periodo :</label></td><td>{$PERIODOID}</td></tr>
	    <tr><td><label>Formato :</label></td><td>{$FORMATOS}</td></tr>		
		<tr><td colspan="2" align="center"><input type="button" class="btn btn-primary" name="generar" id="generar" value="Generar Archivo >>" /></td></tr>
	  </table>
  </fieldset>    
      {$FORM1END}
    </fieldset>
    
  </body></html>