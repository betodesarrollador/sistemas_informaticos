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
      <table align="center" class="tableFilter">
	   <thead>
	    <tr align="center">
		  <td  align="left" valign="top"><label>PERIODO</label></td>
		  <td  align="left" valign="top"><label>CC</label></td>
	      <td  align="right"><label for="opciones_centros">Todos</label>{$CENTROSTODOS}&nbsp;</td>
        <td align="center" valign="top"><label>NIVEL</label></td>
	      <td align="center" valign="top"><label>DOC. CIERRE</label></td>
         </tr>
	   </thead>
	   <tbody>
	    <tr>
	      <td valign="top"><table border="0">
	        <tr>
	          <td ><label>DESDE </label></td>
	          <td >{$DESDE}</td>
	          </tr>
	        <tr>
	          <td><label>HASTA </label></td>
	          <td>{$HASTA}</td>
	          </tr>
          </table></td>
          <td colspan="2" valign="top">{$CENTROCOSTOID}{$OFICINAID}</td>
	      <td valign="top">
            {$NIVEL}
          </td>
          <td valign="top">
            {$OPCIERRE}
          </td>
         </tr>
		</tbody>
     </table>
	 </fieldset>
	 <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$DESCARGAR}</div>
  </fieldset>
  
  {$FORM1END}
    
  {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
  {$FORM2END}
       
  </body>
</html>