<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>  
<meta http-equiv="content-type" content="text/html; charset=utf-8">
{$JAVASCRIPT} {$TABLEGRIDJS} {$CSSSYSTEM} {$TABLEGRIDCSS} {$TITLETAB}
</head>
<body>
<fieldset> <legend>{$TITLEFORM}</legend>
<div id="table_find">
<table>
  <tbody>
    <tr>
      <td><label>Busqueda : </label></td>
      <td>{$BUSQUEDA}</td>
	  <td align="center"><h3><font color="#FF0000"><b>ENTREGAS MENSAJERIA</b></font></h3></td>	  
    </tr>
  </tbody>
</table>
</div>
<fieldset>

<p>{$EMPRESAIDSTATIC}{$OFICINAIDSTATIC}{$FECHASTATIC}
  {$FORM1} 
  {$USUARIOID}{$OFICINAID}{$USUARIOREGISTRA}{$USUARIONUMID}</p>
<table align="center" width="95%">
  <tbody>
    <tr>
      <td align="center">
      <fieldset class="section">
	  <legend>ENTREGAS MENSAJERIA</legend>
      <table width="90%" >
        <tbody>
          <tr>
            <td><label>Fecha :</label></td><td>{$FECHA}</td>
            <td><label>Mensajero:</label></td><td>{$PROVEEDOR}{$PROVEEDORID}{$ENTREGAID}</td>
          </tr>
          <tr>
            <td><label>Observaciones :</label></td><td>{$OBSERVACIONES}</td>
       	   <td><label>Estado :</label></td><td>{$ESTADO}</td>
      	  </tr>    
        </tbody>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
    	<td>
            <fieldset class="section">
             <legend>GUIAS ENTREGADAS</legend>
    
             <div align="center">            
             
                 <div id="divProductos">
                     <span style="float:left; color:#F00; margin-left:20px; margin-top:2px;" id="mensaje_alerta">&nbsp;</span>
                     <div id="texto">
                     	Codigo de Barras:<input type="text"  name="codigo_barras1" id="codigo_barras1" />
                     </div>
                  <table  id="tableEntrega">
                   <thead>
                    <tr>
                     <th width="60">No GUIA</th>	 
                     <th width="150">REMITENTE</th>	 	 	 	 	 
                     <th width="150">DESTINATARIO</th>	 	 	 	 	 
                     <th width="200">DESCRIPCION PRODUCTO</th>	 	 	 	 	 
                     <th width="80">PESO</th>	 	 	 	 	 	 	 	 	 
                     <th width="80">CANTIDAD</th> 	
                    </tr>
                    </thead>
                    
                    <tbody>
                
                    <tr class="rowGuias">
                     <td>
                       <input type="hidden" name="guia_id" id="guia_id" value="" />  				 				           	   
                       <input size="8" type="text" name="guia_dev"   id="guia_dev"  value="" class="required" readonly />				   
                     </td> 
                     <td><input type="text" name="remitente"  id="remitente" size="30" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	                      
                     <td><input type="text" name="destinatario"  id="destinatario" size="30" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	                      
                     <td><input type="text" name="descripcion_producto"  id="descripcion_producto" size="60" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	 
                     <td><input type="text" name="peso"  id="peso" size="10" value="" class="required numeric saltoscrolldetalle" readonly /></td>	  	 	 	 	 	 
                     <td><input type="text" name="cantidad" id="cantidad"  size="10"  value="" class="saltoscrolldetalle" readonly /></td>
                    </tr>   
                    <tr class="rowGuias" id="clon"  >
                     <td> 
                      <input type="hidden" name="guia_id" id="guia_id" value=""/> 				 				           	   
                       <input size="8" type="text" name="guia_dev"   id="guia_dev"  value="" class="required" readonly />				   
                     </td> 
                     <td><input type="text" name="remitente"  id="remitente" size="30" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	                      
                     <td><input type="text" name="destinatario"  id="destinatario" size="30" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	                      
                     <td><input type="text" name="descripcion_producto"  id="descripcion_producto" size="60" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	 
                     <td><input type="text" name="peso"  id="peso" size="10" value="" class="required numeric saltoscrolldetalle" readonly /></td>	  	 	 	 	 	 
                     <td><input type="text" name="cantidad" id="cantidad"  size="10"  value="" class="saltoscrolldetalle" readonly /></td>
                    </tr>
                    </tbody>
                  </table>  
               </div>
              </div>
    
            </fieldset>
        
        </td>
	</tr>        
    <tr>
      <td align="center">
	   <table width="100%" align="center">
	    <tr>
        	<td><div align="center" >{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}</div></td>
        </tr>    
	  </table>
	  </td>
	</tr>
    </tbody>
  </table>
{$FORM1END} 

<div id="divGuia" style="display:none;" style="height:400px;" > <iframe id="iframeGuia" style="height:400px;"></iframe> </div>

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

<div>{$GRIDENTREGA}</div>

</body>
</html>