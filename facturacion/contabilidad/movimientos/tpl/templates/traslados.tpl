<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  {$TITLETAB}    
  </head>

  <body>

  {$FORM1}
   <fieldset>
      <legend>{$TITLEFORM}</legend>   
  
     <fieldset class="section">
      <table align="center" class="tableFilter" width="100%">
	   <thead>
	    <tr align="center">
	      <td align="left" valign="top" colspan="2">SELECCIONE DOCUMENTO</td>
	      <td align="left" valign="top" colspan="2">CUENTAS PUC</td>
	      <td align="left" valign="top" colspan="2">SELECCIONE FECHAS</td>          
	      <td align="left" valign="top" colspan="2">SELECCIONE TERCEROS</td>          

	    </tr>
	   </thead>
	   <tbody>
	    <tr>
          <td valign="top"><label>Tipo Doc.</label></td>
	      <td valign="top">{$DOCUMENTOS}</td>
          <td valign="top"><label>CUENTA ORIGEN</label></td>
	      <td valign="top">{$CUENTADESDE}{$CUENTADESDEID}</td>
          <td valign="top"><label>INICIAL </label></td>
          <td valign="top">{$DESDE}</td>
          <td valign="top"><label>MISMO TERCERO </label></td>
          <td align="left" valign="top">{$OPTERCERO}</td>
        </tr>   
	    <tr>
          <td valign="top"><label>Fecha Doc.</label></td>
	      <td valign="top">{$FECHADOC}</td>
          <td valign="top"><label>CUENTA DESTINO</label></td>
	      <td valign="top">{$CUENTAHASTA}{$CUENTAHASTAID}</td>
          <td valign="top"><label>FINAL </label></td>
          <td valign="top">{$HASTA}</td>
          <td valign="top"><label>CONTRA SOLO UN TERCERO </label></td>
          <td align="left" valign="top">{$TERCERO}{$TERCEROID}{$ENCABEZADOREG}</td>
        </tr>   
          
		</tbody>
     </table>
	 </fieldset>
	 <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{*{$EXPORT}*}</div>
  </fieldset>
  
  {$FORM1END}
    
  {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
  {$FORM2END}
       
  </body>
</html>