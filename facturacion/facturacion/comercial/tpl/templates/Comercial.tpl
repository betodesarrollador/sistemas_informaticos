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

        <div id="table_find"><table  align="center">
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
        <table align="center">
          <tr>
            <td ><label>Tipo Identificacion : </label></td><td>{$TIPOIDENTIFICACION}{$TERCEROID}{$COMERCIALID}</td>
            <td><label>Tipo Contribuyente : </label></td><td>{$TIPOPERSONA}</td>
          </tr>
          <tr>
            <td><label>Numero Identificacion :</label></td><td align="left">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
          </tr>
          <tr id="filaApellidos">
            <td><label>Primer Apellido : </label></td><td align="left">{$PRIMERAPELLIDO}</td>
            <td><label>Segundo Apellido : </label></td><td align="left">{$SEGUNDOAPELLIDO}</td>
          </tr>
          <tr id="filaNombres">
            <td><label>Primer Nombre : </label></td><td>{$PRIMERNOMBRE}</td>
            <td><label>Otros Nombres : </label></td><td>{$OTROSNOMBRES}</td>
          </tr>
          <tr id="filaRazonSocial">            
          	<td><label>Razon Social : </label></td><td>{$RAZON_SOCIAL}</td>
            <td><label>Sigla : </label></td><td>{$SIGLA}</td>
          </tr>
          <tr>
            <td><label>Telefono : </label></td><td>{$TELEFONO}</td>
            <td><label>Movil : </label></td><td align="left">{$MOVIL}</td>
          </tr>
          <tr>
            <td><label>Telefax : </label></td><td>{$TELEFAX}</td>
            <td><label>Apartado A&eacute;reo : </label></td><td align="left">{$APARTADO}</td>
          </tr>

          <tr>
            <td><label>Ciudad Residencia : </label></td><td>{$UBICACION}{$UBICACIONID}</td>
            <td><label>Direccion : </label></td><td align="left">{$DIRECCION}</td>
          </tr>
          <tr>
            <td><label>Email :</label></td>
            <td align="left">{$EMAIL}</td>
            <td><label>Pagina Web : </label></td>
            <td>{$URL}</td>
          </tr>
          <tr>
            <td><label>Contacto :</label></td>
            <td align="left">{$CONTACT}</td>
            <td><label>Oficina: </label></td><td>{$OFICINAID}</td>
          </tr>

          <tr>
            <td><label>Autorretenedor : </label></td>
            <td>SI{$AUTORET_SI}NO{$AUTORET_NO}</td>
            <td><label>AutoReteica :</label></td>
            <td align="left">SI{$AGENTE_SI}NO{$AGENTE_NO}</td>
          </tr>

          <tr>
            <td><label>AutoCREE : </label></td>
            <td>SI{$RENTA_SI}NO{$RENTA_NO}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>            
          </tr>

          <tr>
            <td><label>Regimen : </label></td>
            <td>{$REGIMENID}</td>
            <td><label>Tipo de Cuenta :</label></td>
            <td align="left">{$TIPOCUENTA}</td>

          </tr>

          <tr>
            <td><label>N&uacute;mero de Cuenta : </label></td>
            <td>{$NUM_CUENTA}</td>
            <td><label>Entidad Bancaria :</label></td>
            <td align="left">{$BANCO}{$BANCOID}</td>

          </tr>
          <tr>
            <td><label>Estado : </label></td>
            <td align="left">A{$ACTIVO}I{$INACTIVO}</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>          
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          
          <tr>
          <td colspan="4"><div align="center">
     <table align="center">
	  <thead align="center">
	   <tr  >
	     <th align="center"><label>TIPO CLIENTE \ DIAS </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		
		 <th align="center"><label> 0 - 45</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		
		 <th align="center"><label>46 - 60</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		 <th align="center"><label>61 - 90 </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
         <th align="center"><label>91 - +</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		 
       </tr>
	   </thead>
	   
	   <tbody>
	  
		   <tr align="center" id="rowrecaudo">
			 
			<th><label>NUEVO</label></th>
			 <td >{$REC_RANGO1}</td>
			 <td>{$REC_RANGO2}</td>
			 <td>{$REC_RANGO3}</td>
			 <td>{$REC_RANGO4}</td>
			 </tr>	
             
             <tr align="center" id="rowcomision">
			 
			<th>
			  <label>MANTENIMIENTO</label>
			</th>
			 <td >{$FAC_RANGO1}</td>
			 <td>{$FAC_RANGO2}</td>
			 <td >{$FAC_RANGO3}</td>
			 <td >{$FAC_RANGO4}</td>
			 </tr>	     
		 
		  
		 
	   </tbody>
	 </table>
  </div></td>
  			</tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>
        {$FORM1END}
    </fieldset>
    
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
    
  </body>
</html>
body>
</html>
