<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
 
  {$CSSSYSTEM}
  
  {$TITLETAB}  
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
		
		<fieldset class="section">		
        <table>
          <tr>
            <td><label>Empresa : </label></td>
            <td>{$EMPRESAID}{$PARAMETROLIQUIDACIONID}</td>
            <td><label>Oficina : </label></td>
            <td>{$OFICINAID}</td>
          </tr>        
          <tr>
            <td width="229" ><label>Documento Contable :</label></td>
            <td width="264" colspan="3">{$DOCUMENTOCONTABLE}</td>
          </tr>  
         </table>		 
		 </fieldset>		 		 		  

		 <fieldset class="section">
		  <legend>Valor Comision</legend>
		   <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$FLETEPACTADO}{$FLETEPACTADOID}</td>
			   <td><label>Naturaleza :</label></td>
			   <td>{$NATURALEZAFLETEPACTADO}</td>
			 </tr>
		   </table>		   
	     </fieldset>
		 
		 <fieldset class="section">
		  <legend>Retencion 1</legend>
		   <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$SOBREFLETE}{$SOBREFLETEID}</td>
			   <td><label>Naturaleza :</label></td>
			   <td>{$NATURALEZASOBREFLETE}</td>
			 </tr>
		   </table>		   
	     </fieldset>		 
		 
		 <fieldset class="section">
		  <legend>Retencion 2</legend>
		   <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$ANTICIPO}{$ANTICIPOID}</td>			 
			   <td><label>Naturaleza :</label></td>
		       <td>{$NATURALEZAANTICIPO}</td>
			</tr>			 
		   </table>		   
		 </fieldset>		 
		 
		 <fieldset class="section">
		  <legend>Comisiones por Pagar</legend>
		   <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$SALDOPAGAR}{$SALDOPAGARID}</td>
			   <td><label>Naturaleza :</label></td>
			   <td>{$NATURALEZASALDOPAGAR}</td>
			 </tr>
		   </table>		   
	     </fieldset>		 
		 
		 <table align="center">
		   <tr><td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td></tr>
		 </table>
		 
		 
        {$FORM1END}
    </fieldset>
    
    <fieldset>
	<button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    </fieldset>
    
  </body>
</html>
