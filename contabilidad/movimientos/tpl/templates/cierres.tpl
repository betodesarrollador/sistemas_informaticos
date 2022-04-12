<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  {$TITLETAB}    
  </head>

  <body>

  
   <fieldset>
      <legend>{$TITLEFORM}</legend> 
      <div id="table_find">
        <table align="center">
        <tr>
          <td><label>Busqueda : </label></td>
        </tr>
        <tr>
          <td>{$BUSQUEDA}</td>
        </tr>
        </table>
        </div>  
  {$FORM1}
     <fieldset class="section">
      <table align="center" class="tableFilter" width="100%">
	   <thead>
	    <tr align="center">
	      <td align="left" valign="top" colspan="2">SELECCIONE DOCUMENTO</td>
	      <td align="left" valign="top" colspan="2">CENTRO COSTO</td>
	      <td align="left" valign="top" colspan="2">SELECCIONE FECHAS</td>          
	      <td align="left" valign="top" colspan="2">TERCEROS</td>           

	    </tr>
	   </thead>
	   <tbody>
	    <tr>
          <td valign="top"><label>Tipo Doc.</label></td>
	      <td valign="top">{$DOCUMENTOS}</td>
          <td valign="top"><label>TODOS LOS CENTROS</label></td>
	      <td valign="top">{$OPCENTRO}</td>
          <td valign="top"><label>INICIAL </label></td>
          <td valign="top">{$DESDE}</td>
          <td valign="top"><label>CON TERCEROS </label></td>
          <td align="left" valign="top">{$OPTERCERO}</td>
        </tr>   
	    <tr>
          <td valign="top"><label>Fecha Doc.</label></td>
	      <td valign="top">{$FECHADOC}</td>
          <td valign="top"><label>CENTRO COSTO</label></td>
	      <td valign="top">{$CENTROID}{$CENTRO}</td>
          <td valign="top"><label>FINAL </label></td>
          <td valign="top">{$HASTA}</td>
          <td valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;{$ENCABEZADOREG}</td>
        </tr>   
          
		</tbody>
     </table>
	 </fieldset>
	 <div align="center">{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}</div>
  </fieldset>
  
  {$FORM1END}
    
  {$FORM2}
    <iframe id="frameReporte" name="frameReporte" src=""></iframe>
  {$FORM2END}
       
    <div id="divAnulacion">
      <form>
        <table>       
          <tr>
            <td><label>Fecha / Hora :</label></td>
            <td>{$FECHALOG}</td>
          </tr>          
          <tr>
            <td><label>Causal :</label></td>
            <td>{$CAUSALESID}</td>
          </tr>
          <tr>
            <td><label>Descripcion :</label></td>
            <td>{$OBSERVACIONES}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$ANULAR}</td>
          </tr>                    
        </table>
      </form>
    </div>
       
  </body>
</html>