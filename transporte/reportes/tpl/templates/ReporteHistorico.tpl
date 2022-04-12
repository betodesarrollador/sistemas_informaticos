<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Reporte Historico - SI&amp;SI™</title></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  

   <fieldset>
   <legend>{$TITLEFORM}</legend>
	{$FORM1}
    <fieldset class="section">
   <table width="100%" align="center" class="tableFilter">    
        
        <tr>
          <td width="25%" align="center"><label>PERIODO :</label></td>
          <td width="50%" align="center"><label>POR :</label></td>
          <td width="25%" align="center"><label>OFICINA :</label></td>
        </tr>       
        <tr> 
            <td>
             <table width="60%" border="0" align="center">
             <tr>
                <td align="center"><label>Fecha Inicio :</label><br/>{$DESDE}<br/></td>        
              </tr>
             <tr>
                <td align="center"><label>Fecha Final :</label><br/>{$HASTA}<br/></td>
             </tr>             
             </table>
          </td>
             <td>
             <table width="100%" border="0" align="center">
             <tr>
               <td valign="top"><label>Vehiculo : </label><br/>{$SI_VEH}<br/>{$VEHICULO}{$VEHICULOID}</td>
               <td valign="top"><label>Conductor : </label><br/>{$SI_CON}<br/>{$CONDUCTOR}{$CONDUCTORID}</td>               
             </tr>
             <tr>
               <td valign="top"><label>Tenedor : </label><br/>{$SI_TEN}<br/>{$TENEDOR}{$TENEDORID}</td>
               <td valign="top"><label>Cliente : </label><br/>{$SI_CLI}<br/>{$CLIENTE}{$CLIENTEID}</td>
             </tr>
             </table>
             </td>
            <td>
            <table width="70%" border="0" align="center">
              <tr>
				<td valign="top" align="center"><label>Todos</label>{$ALLOFFICE}<br/>{$OFICINA}<br/></td>
              </tr>
            </table>    
			</td>            
           <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="20%"></td>
                            <td width="50%" align="center">{$GENERAR}{$IMPRIMIR} <input type="button" name="generar_excel" id="generar_excel" value="Generar Archivo Excel>>" /></td>
                            <td width="20%"></td>
                        </tr>
                    </table>
                </td>
            </tr>            
	  </table>
      </fieldset>
      <table width="100%">
			<tr><td colspan="3"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
	  </table>
    {$FORM1END}
    </fieldset></td>
   </body>
</html>