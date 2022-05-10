<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
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
		  <td  align="left" valign="top"><label>CC</label></td>
	      <td  align="right"><label for="centros_todos">Todos</label>{$CENTROSTODOS}&nbsp;</td>
	      <td  align="left" valign="top"><label>DOCUMENTO</label></td>
	      <td  align="right"><label for="documentos_todos">Todos</label>{$DOCUMENTOSTODOS}&nbsp;&nbsp;</td>
	      <td align="center" valign="top"><label>TERCERO</label></td>
	      <td align="center" valign="top"><label>RANGO CUENTAS</label><br>Todas{$OPC_CUENTAS}</td>
	      <td align="center" valign="top"><label>FECHA</label></td>
	      <td align="center" valign="top"><label>AGRUPAR</label></td>
	    </tr>
	   </thead>
	   <tbody>
	    <tr>
	      <td valign="top" style="display:none">{$REPORTE}</td>
          <td colspan="2" valign="top">{$CENTROCOSTOID}{$OFICINAID}</td>
	      <td colspan="2" valign="top">{$DOCUMENTOS}</td>
	      <td><table border="0">
            <tr>
              <td align="left" valign="top">{$OPTERCERO}</td>
            </tr>
            <tr>
              <td align="left" valign="bottom">{$TERCERO}{$TERCEROID}</td>
            </tr>
          </table></td>
	      <td valign="top"><table border="0">
            <tr>
              <td width="50" valign="middle"><label>INICIAL </label></td>
              <td width="320">{$CUENTADESDE}{$CUENTADESDEID}</td>
            </tr>
            <tr>
              <td><label>FINAL</label></td>
              <td>{$CUENTAHASTA}{$CUENTAHASTAID}</td>
            </tr>
          </table></td>
	      <td valign="top"><table border="0">
            <tr>
              <td width="50"><label>DESDE </label></td>
              <td width="200">{$DESDE}</td>
            </tr>
            <tr>
              <td><label>HASTA </label></td>
              <td>{$HASTA}</td>
            </tr>
          </table></td>
	      <td valign="top">
		  <table border="0">
            <tr>
              <td><label>Tercero</label></td>
              <td><input type="radio" name="agrupar" id="defecto" value="defecto" checked /></td>
            </tr>
            <tr>
              <td><label>Cuenta</label></td>
              <td><input type="radio" name="agrupar" id="cuenta" value="cuenta" /></td>
            </tr>
          </table></td>
	    </tr>
      
      <tr>
      <td>
      <table>      
        <tr><br><br></tr>
        <tr>
          <td><label>ESTADO&emsp;&emsp;Todos&emsp;</label>{$ESTADOTODOS}</td>
          </tr>
        <tr>
          <td>{$ESTADO}</td>
          </tr>      
      </table>
      </td>
      <td colspan="2">
      <table>      
        <tr><br><br></tr>
        <tr>
          <td><label>MOSTRAR DECIMALES?</label></td>
          </tr>
        <tr>
          <td>{$DECIMALES}</td>
          </tr>      
      </table>
      </td>
      
      </tr>
      
		</tbody>
     </table>
	 </fieldset>
	 <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$EXPORT}</div>
  </fieldset>
  
  {$FORM1END}
    
  {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
  {$FORM2END}
       
  </body>
</html>