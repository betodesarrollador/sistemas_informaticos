<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>  
<meta http-equiv="content-type" content="text/html; charset=utf-8">
{$JAVASCRIPT} {$TABLEGRIDJS} {$CSSSYSTEM} {$TABLEGRIDCSS} {$TITLETAB}
</head>
<body>
<fieldset> <legend>{$TITLEFORM}</legend><fieldset>

<p>{$EMPRESAIDSTATIC}{$OFICINAIDSTATIC}{$FECHASTATIC}
  {$FORM1} 
  {$USUARIOID}{$OFICINAID}{$USUARIOREGISTRA}{$USUARIONUMID}</p>
<table align="center" width="95%">
  <tbody>
    <tr>
    	<td>
            <fieldset class="section">
             <legend>CAMBIO ESTADO GUIA MENSAJERIA (Vuelve a estado Tr&aacute;nsito, Solo si esta en estado Devoluci&oacute;n o Entrega</legend>
    
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
                     <th width="110">REMITENTE</th>	 	 	 	 	 
                     <th width="110" >DESTINATARIO</th>	 	 	 	 	 
                     <th width="170">DESCRIPCION PRODUCTO</th>	 	 	 	 	 
                     <th width="80">PESO</th>	 	 	 	 	 	 	 	 	 
                     <th width="80">CANTIDAD</th> 	
                     <th width="80">ESTADO ANTERIOR</th> 	
                    </tr>
                    </thead>
                    
                    <tbody>
                
                    <tr class="rowGuias">
                     <td>
                       <input type="hidden" name="guia_id" id="guia_id" value="" />  				 				           	   
                       <input size="8" type="text" name="guia_dev"   id="guia_dev"  value="" class="required" readonly />				   
                     </td> 
                     <td><input type="text" name="remitente"  id="remitente" size="20" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	                      
                     <td><input type="text" name="destinatario"  id="destinatario" size="20" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	                      
                     <td><input type="text" name="descripcion_producto"  id="descripcion_producto" size="40" value="" class="required saltoscrolldetalle" readonly /></td>	 	 	 
                     <td><input type="text" name="peso"  id="peso" size="10" value="" class="required numeric saltoscrolldetalle" readonly /></td>	  	 	 	 	 	 
                     <td><input type="text" name="cantidad" id="cantidad"  size="10"  value="" class="saltoscrolldetalle" readonly /></td>
                     <td><input type="text" name="estado_anterior" id="estado_anterior"  size="15"  value="" class="saltoscrolldetalle" readonly /></td>
                     
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
                     <td><input type="text" name="estado_anterior" id="estado_anterior"  size="15"  value="" class="saltoscrolldetalle" readonly /></td>
                     
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
        	<td><div align="center" >{*{$GUARDAR}*}&nbsp;{*{$ACTUALIZAR}*}&nbsp;{$IMPRIMIR}&nbsp;{*{$ANULAR}*}&nbsp;{$LIMPIAR}</div></td>
        </tr>    
	  </table>
	  </td>
	</tr>
    </tbody>
  </table>
{$FORM1END} 

</body>
</html>