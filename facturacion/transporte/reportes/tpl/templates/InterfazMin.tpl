<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
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
          <tbody>
		  <tr>
            <td><label>Desde : </label></td>
            <td>{$DESDE}</td>
	        </tr>
		  <tr>
		    <td><label>Hasta:</label></td>
		    <td>{$HASTA}</td>
		    </tr>
		  <tr>
            <td><label>Tipo Documento:</label></td>
		    <td>{$TIPO}</td>
		    </tr> 
		    <td colspan="2"><input type="button" name="generar" id="generar" value="Generar Archivo txt >>" /> <input type="button" name="generar_excel" id="generar_excel" value="Generar Archivo Excel>>" /></td>
		    </tr>
      </tbody>
      </table>    
      {$FORM1END}
    </fieldset>
    
  </body></html>