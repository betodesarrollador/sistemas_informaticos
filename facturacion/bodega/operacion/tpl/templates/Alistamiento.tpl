<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8">
 <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
 {$JAVASCRIPT}
 {$TABLEGRIDJS}
 {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
</head>


<body>
	<fieldset>
    <legend>{$TITLEFORM}</legend>
    
    <div id="table_find">
      <table align="center">
       <tr>
         <td ><label>Busqueda : </label></td>
       </tr>
       <tr>
         <td>{$BUSQUEDA}</td>
       </tr>
     </table>
   </div>
   {$USUARIOSTATIC}  
   {$FECHASTATIC}  
   {$FORM1}
   {$USUARIOACTUALIZA}
   {$FECHAACTUALIZA}
   {$FECHAREGISTRO}
   <fieldset class="section">
    <table align="center">

      <tr>
        <td><label>No. Alistamiento : </label></td>
        <td>{$ALISTAMIENTO}{$USUARIO}</td>
        <td><label>Fecha: </label></td>
        <td>{$FECHA}</td>
      </tr>

     <tr>
      <td><label>Turno : </label></td>
      <td>{$TURNO}</td>
      <td><label>Muelle : </label></td>
      <td>{$MUELLE}</td>
    </tr>	
     <tr>
 
      <td><label>Estado : </label></td>
      <td colspan="2">{$ESTADO}</td>
    </tr>	
         
          <tr><td><br><br><br><br></td></tr>
          <tr>
           <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}</td>
         </tr>
       </table>


       <br><br>

       <div style="position:relative;  left:1200px" >
         <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesAlistamiento" title="Borrar Seleccionados"/>
       </div>
       <div  align="center" ><iframe id="DetalleAlistamiento" frameborder="0" ></iframe></div>

     </fieldset>
     <fieldset>{$GRIDTRASLADOS}</fieldset>
   </fieldset>

   {$FORM1END}
 <div id="divAnulacion">
  <form onSubmit="return false">
	<table>              
	  <tr>
		<td><label>Causal :</label></td>
		<td>{$CAUSALANULACIONID}</td>
	  </tr>
	  <tr>
		<td><label>Descripcion :</label></td>
		<td>{$OBSERVANULACION}</td>
	  </tr> 
	  <tr>
		<td colspan="2" align="center">{$ANULAR}</td>
	  </tr>                    
	</table>
  </form>
</div>	
 </body>
 </html>