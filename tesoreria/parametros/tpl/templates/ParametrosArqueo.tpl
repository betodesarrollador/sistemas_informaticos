<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
		
		<fieldset class="section">		
        <table>
          <tr>
            <td><label>Empresa : </label></td>
            <td>{$EMPRESAID}{$PARAMETROLEGALIZACIONID}</td>
            <td><label>Oficina : </label></td>
            <td>{$OFICINAID}</td>
			<td><label>REPORTE DE COSTOS: </label></td>
            <td>{$CENTROCOSTO}</td>            
          </tr>        
         </table>		 
		 </fieldset>
		 
		 		 
		 <fieldset class="section">
	     <legend>Cuenta Caja</legend>
		  <table align="center">
		     <tr>
			   <td><label>Codigo Puc :</label></td>
			   <td>{$CONTRAPARTIDA}{$PUCID}</td>
			   <td><label>Nombre :</label></td>
               <td>{$NOMBREPUC}</td>			 
			   <td><label>Naturaleza :</label></td>
		       <td>{$NATURALEZAPUC}</td>
			</tr>			 
		   </table>		   
		 </fieldset>		 

		 <fieldset class="section">
	     <legend>Cuentas Informe Caja</legend>
		  <table align="center">
		     <tr>
			   <td><label>Codigo Puc 1 :</label></td>
			   <td>{$INICONTRAPARTIDA}{$INIPUCID}</td>
              </tr>
		     <tr>
			   <td><label>Codigo Puc 2 :</label></td>
			   <td>{$INI2CONTRAPARTIDA}{$INI2PUCID}</td>
              </tr>
		     <tr>
			   <td><label>Codigo Puc 3 :</label></td>
			   <td>{$INI3CONTRAPARTIDA}{$INI3PUCID}</td>
              </tr>
		     <tr>
			   <td><label>Codigo Puc 4 :</label></td>
			   <td>{$INI4CONTRAPARTIDA}{$INI4PUCID}</td>
              </tr>
		     <tr>
			   <td><label>Codigo Puc 5 :</label></td>
			   <td>{$INI5CONTRAPARTIDA}{$INI5PUCID}</td>
              </tr>
		     <tr>
			   <td><label>Codigo Puc 6 :</label></td>
			   <td>{$INI6CONTRAPARTIDA}{$INI6PUCID}</td>
              </tr>
              
		   </table>		   
		 </fieldset>		 
		 
   <table align="center">
		   <tr><td colspan="4">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td></tr>
		 </table>		 
		 
        {$FORM1END}
  </fieldset>
    
    <fieldset>
      {$GRIDPARAMETROSLEG}
    </fieldset>
    
  </body>
</html>
