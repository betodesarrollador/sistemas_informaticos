<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  {$TITLETAB}    
  </head>
  <body>
  {$FORM1}
   <fieldset>
      <legend>{$TITLEFORM}</legend>   
  
     <fieldset class="section">
      <table align="center">
	    <tbody>
	     <tr>
           <td><label>Fecha Inicial:</label></td>
           <td>{$FECHAINICIAL}</td>
           <td><label>Fecha Final:</label></td>
           <td>{$FECHAFINAL}</td>
         </tr>
		</tbody>
     </table>
	 </fieldset>
	 <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}</div>
  </fieldset>
  
  {$FORM1END}
           
  </body>
</html>