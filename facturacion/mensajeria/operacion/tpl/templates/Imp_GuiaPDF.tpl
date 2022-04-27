{literal}
<style>
*{
  font-family:Arial, Helvetica, sans-serif;
  font-size:11px;
  text-align:left; 
  color:#070457;
}

.title{
  font-size:14px;
  font-weight:bold;
  text-align:center;
}

.general{
  text-align:center;
}

.resolucion{
 text-align:right;
}

label{
font-weight:bold;
text-align:left;
float:left;
}

.producto{
  margin-top:15px;
}

.producto thead th{
 font-size:12px;
 font-weight:bold;
 text-align:center;
}

.producto tbody td{
 font-size:12px;
 text-align:center;
}

.guiageneral{
  border-top:1px solid #070457;   
  border-left:1px solid #070457;   
  border-right:1px solid #070457;   
  border-bottom:1px solid #070457;   
}

.productocelllefttop{
  font-weight:bold;
  border-bottom:1px solid #070457;   
}

.productocellrighttop{
  border-top:1px solid #070457;
  border-right:1px solid #070457;
  border-bottom:1px solid #070457;  
  font-weight:bold;
}

.productocellrightbottom{  
  border-right:1px solid #070457;
}

.productocellleftbottom{
  border-bottom:1px solid #070457;  
}

.productocelllefttop{
  border-top:1px solid #070457;
  font-weight:bold;  
}

.firmas{
 font-size:12px;
 font-weight:bold;
 text-align:center;
}


.saltopagina {
  page-break-after: always;
}

.numGuia{
 font-size:16px;
 color:#FF0000;
 font-weight:bold;
}

.divisionHoja{
 height:15px;
}

.tituloOficina{
  font-size:6px;
  font-weight:bold;
}

.tituloGuia{
  font-size:9px;
  font-weight:bold;
  text-align:center;
}

.firmaObserv{
  height:35px;
}

.productosGuia{
  height:100px;
}

.productosGuia td{
  vertical-align:top;
  color:#000000;
}

.content{
  color:#000000;
  font-size:12px;
}

.tituloGuia{
  font-size:9px;
}
</style>
{/literal}

{foreach name=guia from=$DATOSGUIA item=r}

<page orientation="portrait" backtop="5mm" backbottom="0mm" backleft="0mm" backright="0mm">
<nobreak>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
    <tr>
      <td width="750">
        <table  border="0" cellpadding="5" cellspacing="4" width="750" >
          <tr>
            <td width="196"><img src="{$r.logo}" height="40" width="150"></td>
            <td width="150" align="center"  >{$r.pagina_web}</td>
            <td width="70" align="center" class="tituloGuia" >SERVICIO<br>ENTREGA<br>INMEDIATA<br>
            GUIA</td>
            <td width="90" align="center" >{$r.fecha_guia} </td>
            <td width="170" align="right" >
			  <table>
			    <tr>
				 <td width="215" align="center">
				  <barcode type="C39" value="{$r.numero_guia_bar}" style="width:40mm; height:5mm"></barcode>
				 </td>
				</tr>
			  </table>
			</td>
          </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td>
      <table  border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td    class="guiageneral" width="750">
            <table  border="0" width="100%" >
                <tr>
                  <td width="50" >Origen :</td>
                  <td width="218" > {$r.origen|substr:0:32}</td>
                  <td width="50" >Destino :</td>
                  <td width="218" > {$r.destino|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Remitente :</td>
                  <td >{$r.remitente|substr:0:32}</td>
                  <td>Destinatario :</td>
                  <td >{$r.destinatario|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Direccion :</td>
                  <td >{$r.direccion_remitente|substr:0:32}</td>
                  <td>Direccion :</td>
                  <td >{$r.direccion_destinatario|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Telefono :</td>
                  <td >{$r.telefono_remitente|substr:0:32}</td>
                  <td>Telefono :</td>
                  <td >{$r.telefono_destinatario|substr:0:32}</td>
                </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td   class="guiageneral" width="750"  >
            <table align="center" border="0"  cellpadding="0" cellspacing="0" width="750" height="90">
              <tr >
                <td width="150" align="center">Referencia</td>                  
                <td width="100" align="center">Producto</td>                
                <td width="100" align="center">Cantidad</td>                             
                <td width="100" align="center">Peso</td>                   
                <td width="100" align="center">Guia Cliente</td>                                   
                <td width="200" align="center">Observaciones</td>                                                   
              </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[0].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[0].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[0].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[0].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[0].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[0].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[1].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[1].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[1].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[1].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[1].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[1].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[2].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[2].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[2].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[2].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[2].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[2].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[3].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[3].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[3].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[3].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[3].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[3].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[4].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[4].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[4].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[4].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[4].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[4].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[5].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[5].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[5].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[5].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[5].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[5].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[6].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[6].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[6].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[6].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[6].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[6].observaciones|substr:0:40}</td>                                                                     
                </tr>
            </table>            
            </td>
          </tr>
		  <tr>
          <td class="guiageneral" width="750">
		    <table width="750" cellpadding="0" cellspacing="0">
          <tr>
            <td width="400"  valign="top" >El destinatario: Recibi a conformidad</td>
            <td width="365" rowspan="3" valign="top">Observaciones:<br>
              {$r.observaciones|substr:0:40}<br>{$r.oficina_responsable}</td>
          </tr>
          <tr>
            <td height="30"  valign="top" >&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" >Nombre legible, C.C, Firma, Sello y Fecha. </td>
          </tr>			
			</table>
		  </td>
		  </tr>
      </table>
      </td>
    </tr>
	<tr><td align="center" class="tituloGuia">DESTINATARIO</td></tr>
</table>
<br /><br /><br />
<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
    <tr>
      <td width="750">
        <table  border="0" cellpadding="5" cellspacing="4" width="750" >
          <tr>
            <td width="196"><img src="{$r.logo}" height="40" width="150"></td>
            <td width="150" align="center"  >{$r.pagina_web}</td>
            <td width="70" align="center" class="tituloGuia">SERVICIO<br>ENTREGA<br>INMEDIATA<br>
            GUIA</td>
            <td width="90" align="center" >{$r.fecha_guia} </td>
            <td width="170" align="right" >
			  <table>
			    <tr>
				 <td width="215" align="center">
				  <barcode type="C39" value="{$r.numero_guia_bar}" style="width:40mm; height:5mm"></barcode>
				 </td>
				</tr>
			  </table>
			</td>
          </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td>
      <table  border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td    class="guiageneral" width="750">
            <table  border="0" width="100%" >
                <tr>
                  <td width="50" >Origen :</td>
                  <td width="218" > {$r.origen|substr:0:32}</td>
                  <td width="50" >Destino :</td>
                  <td width="218" > {$r.destino|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Remitente :</td>
                  <td >{$r.remitente|substr:0:32}</td>
                  <td>Destinatario :</td>
                  <td >{$r.destinatario|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Direccion :</td>
                  <td >{$r.direccion_remitente|substr:0:32}</td>
                  <td>Direccion :</td>
                  <td >{$r.direccion_destinatario|substr:0:32} </td>
                </tr>
                <tr>
                  <td>Telefono :</td>
                  <td >{$r.telefono_remitente|substr:0:32} </td>
                  <td>Telefono :</td>
                  <td >{$r.telefono_destinatario|substr:0:32} </td>
                </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td   class="guiageneral" width="750"  >
            <table align="center" border="0"  cellpadding="0" cellspacing="0" width="750" height="90">
              <tr >
                <td width="150" align="center">Referencia</td>                  
                <td width="100" align="center">Producto</td>                
                <td width="100" align="center">Cantidad</td>                             
                <td width="100" align="center">Peso</td>                   
                <td width="100" align="center">Guia Ciente</td>                                   
                <td width="200" align="center">Observaciones</td>                                                   
              </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[0].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[0].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[0].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[0].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[0].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[0].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[1].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[1].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[1].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[1].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[1].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[1].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[2].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[2].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[2].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[2].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[2].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[2].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[3].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[3].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[3].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[3].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[3].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[3].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[4].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[4].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[4].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[4].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[4].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[4].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[5].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[5].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[5].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[5].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[5].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[5].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[6].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[6].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[6].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[6].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[6].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[6].observaciones|substr:0:40}</td>                                                                     
                </tr>

            </table>            
            </td>
          </tr>
		  <tr>
          <td class="guiageneral" width="750">
		    <table width="750" cellpadding="0" cellspacing="0">
          <tr>
            <td width="400"  valign="top" >El destinatario: Recibi a conformidad</td>
            <td width="365" rowspan="3" valign="top">Observaciones:<br>
              {$r.observaciones|substr:0:40}<br>{$r.oficina_responsable}</td>
          </tr>
          <tr>
            <td height="30"  valign="top" >&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" >Nombre legible, C.C, Firma, Sello y Fecha. </td>
          </tr>			
			</table>
		  </td>
		  </tr>
      </table>
      </td>
    </tr>
	<tr><td align="center" class="tituloGuia">CLIENTE</td></tr>	
</table>
<br /><br /><br />
<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
    <tr>
      <td width="750">
        <table  border="0" cellpadding="5" cellspacing="4" width="750" >
          <tr>
            <td width="196"><img src="{$r.logo}" height="40" width="150"></td>
            <td width="150" align="center"  >{$r.pagina_web}</td>
            <td width="70" align="center" class="tituloGuia">SERVICIO<br>ENTREGA<br>INMEDIATA<br>GUIA</td>
            <td width="100" align="center" >{$r.fecha_guia} </td>
            <td width="90" align="right" >
			  <table>
			    <tr>
				 <td width="215" align="center">
				  <barcode type="C39" value="{$r.numero_guia_bar}" style="width:40mm; height:5mm"></barcode>
				 </td>
				</tr>
			  </table>
			</td>
          </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td>
      <table  border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td    class="guiageneral" width="750">
            <table  border="0" width="100%" >
                <tr>
                  <td width="50" >Origen:</td>
                  <td width="218" > {$r.origen|substr:0:32}</td>
                  <td width="50" >Destino:</td>
                  <td width="218" > {$r.destino|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Remitente:</td>
                  <td >{$r.remitente|substr:0:32}</td>
                  <td>Destinatario:</td>
                  <td >{$r.destinatario|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Direccion:</td>
                  <td >{$r.direccion_remitente|substr:0:32}</td>
                  <td>Direccion:</td>
                  <td >{$r.direccion_destinatario|substr:0:32}</td>
                </tr>
                <tr>
                  <td>Telefono:</td>
                  <td >{$r.telefono_remitente|substr:0:32}</td>
                  <td>Telefono:</td>
                  <td >{$r.telefono_destinatario|substr:0:32}</td>
                </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td   class="guiageneral" width="750"  >
            <table align="center" border="0"  cellpadding="0" cellspacing="0" width="750" height="90">
              <tr >
                <td width="150" align="center">Referencia</td>                  
                <td width="100" align="center">Producto</td>                
                <td width="100" align="center">Cantidad</td>                             
                <td width="100" align="center">Peso</td>                   
                <td width="100" align="center">Guia Ciente</td>                                   
                <td width="200" align="center">Observaciones</td>                                                   
              </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[0].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[0].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[0].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[0].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[0].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[0].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[1].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[1].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[1].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[1].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[1].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[1].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[2].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[2].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[2].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[2].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[2].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[2].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[3].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[3].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[3].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[3].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[3].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[3].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[4].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[4].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[4].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[4].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[4].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[4].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[5].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[5].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[5].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[5].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[5].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[5].observaciones|substr:0:40}</td>                                                                     
                </tr>
                <tr align="center">
                  <td height="10" align="center" >{$r.detalles_guia[6].descripcion_producto|substr:0:20}</td>                                
                  <td  align="center">{$r.detalles_guia[6].referencia_producto|substr:0:20}</td>
                  <td  align="center">{$r.detalles_guia[6].cantidad}</td>                                  
                  <td  align="center">{$r.detalles_guia[6].peso}</td>                                                    
                  <td  align="center">{$r.detalles_guia[6].guia_cliente}</td>
                  <td  align="center">{$r.detalles_guia[6].observaciones|substr:0:40}</td>                                                                     
                </tr>

            </table>            
            </td>
          </tr>
		  <tr>
          <td class="guiageneral" width="750">
		    <table width="750" cellpadding="0" cellspacing="0">
          <tr>
            <td width="400"  valign="top" >El destinatario: Recibi a conformidad</td>
            <td width="365" rowspan="3" valign="top">Observaciones:<br>
              {$r.observaciones|substr:0:40}<br>{$r.oficina_responsable}</td>
          </tr>
          <tr>
            <td height="30"  valign="top" >&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" >Nombre legible, C.C, Firma, Sello y Fecha. </td>
          </tr>			
			</table>
		  </td>
		  </tr>
      </table>
      </td>
    </tr>
	<tr><td align="center" class="tituloGuia">TRANSPORTADORA</td></tr>		
</table>
</nobreak>
</page> 
 
{/foreach}