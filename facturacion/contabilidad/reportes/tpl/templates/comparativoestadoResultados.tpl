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
		  <td align="center" valign="top" style="display:none">REPORTE</td>
		  <td  align="center" valign="top"><label>FECHAS PERIODO 1</label></td>
      <td  align="center" valign="top"><label>FECHAS PERIODO 2</label></td>
	      <td  align="right" valign="top">
		    <table width="100%">
			  <tr>
			    <td width="50%"><label>CC</label>
                <label for="centros_todos"></label></td>
				  <td><label for="centros_todos">Todos</label>{$CENTROSTODOS}</td>
			  </tr>
			</table>
		  </td>
	      <td align="center" valign="top" style="display:none"><label>TERCERO</label></td>
	      <td align="center" valign="top"><label>NIVEL CUENTAS</label></td>
         </tr>
	   </thead>
	   <tbody>
	    <tr>
	      <td valign="top" style="display:none">{$REPORTE}</td>
          <td valign="top">
            <table border="0">
              <tr>
                <td><label>DESDE </label></td>
                <td>{$DESDE1}</td>
              </tr>
              <tr>
                <td><label>HASTA</label></td>
                <td>{$HASTA1}</td>
              </tr>
            </table>
          </td>
          <td valign="top">
            <table border="0">
              <tr>
                <td><label>DESDE </label></td>
                <td>{$DESDE2}</td>
              </tr>
              <tr>
                <td><label>HASTA</label></td>
                <td>{$HASTA2}</td>
              </tr>
            </table>
          </td>
	      <td valign="top" align="right">{$CENTROCOSTOID}{$OFICINAID}</td>
	      <td align="center" style="display:none">
          <table border="0" align="center">
            <tr>
              <td align="left" valign="top">{$OPTERCERO}</td>
            </tr>
            <tr>
              <td align="left" valign="bottom">{$TERCERO}{$TERCEROID}</td>
            </tr>
          </table></td>
	      <td valign="top" align="center">{$NIVEL}</td>
         </tr>
		</tbody>
     </table>
	 </fieldset>
	 <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$DESCARGAR}</div>
  </fieldset>
  
  {$FORM1END}
    
  {$FORM2}
    <iframe id="frameReporte" name="frameReporte"></iframe>
  {$FORM2END}
       
  </body>
</html>