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
        
        {$FORM1}{$PARAMETROID}
		
		<fieldset class="section">
		  <legend>Firmas</legend>
		  <table width="100%">
          <tr>
            <td><label>Representante :</label></td>
            <td>{$REPRESENTANTE}</td>
            <td ><label>Cargo : </label></td>
            <td>{$REPRESENTANTECARGO}</td>            
            <td><label>Cedula : </label></td>
            <td>{$REPRESENTANTECEDULA}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr> 			  
          <tr>
            <td><label>Revisor:</label></td>
            <td>{$REVISOR}</td>
            <td ><label>Cargo : </label></td>
            <td>{$REVISORCARGO}</td>            
            <td><label>Cedula : </label></td>
            <td>{$REVISORCEDULA}</td>
            <td><label>N&deg; Tarjeta : </label></td>
            <td>{$REVISORTARJETAPROFESIONAL}</td>
          </tr>
          <tr>
            <td><label>Contador:</label></td>
            <td>{$CONTADOR}</td>
            <td ><label>Cargo : </label></td>
            <td>{$CONTADORCARGO}</td>            
            <td><label>Cedula : </label></td>
            <td>{$CONTADORCEDULA}</td>
            <td><label>N&deg; Tarjeta : </label></td>
            <td>{$CONTADORTARJETAPROFESIONAL}</td>
          </tr>			  
		  </table>
		</fieldset>
		
		<fieldset class="section">
		  <legend>Cuentas Utilidad/Perdida</legend>
		
        <table align="center">		  		    
		  <tr>
		    <td><label>Utilidad Ejercicio</label></td>
			<td>{$UTILIDAD}{$UTILIDADID}</td>
			<td><label>Perdida Ejercicio</label></td>
			<td>{$PERDIDA}{$PERDIDAID}</td>
		  </tr>
		  <tr>
		    <td><label>Utilidad Cierre</label></td>
			<td>{$UTILIDADCIERRE}{$UTILIDADCIERREID}</td>
			<td><label>Perdida Cierre</label></td>
			<td>{$PERDIDACIERRE}{$PERDIDACIERREID}</td>
		  </tr>		  
        </table>
		 
    </fieldset>
		 
            <p align="center">{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</p>
		 
       
    
    <fieldset>
    <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    </fieldset>
     {$FORM1END}
    </fieldset>
    
  </body>
</html>
