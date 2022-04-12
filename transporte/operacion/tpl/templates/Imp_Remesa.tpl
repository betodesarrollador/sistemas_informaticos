<html>
 <head>
  <title>Impresion Remesa</title>
    {$JAVASCRIPT}
	{literal}
	<style>
	*{
	  font-family:Arial, Helvetica, sans-serif;
	  font-size:11px;
	  color:#070457;
	}
	
    .saltopagina {
      page-break-after: always;
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
	
	.remesageneral{
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
	
	.numRemesa{
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
	
	.tituloRemesa{
	  font-size:9px;
	  font-weight:bold;
	  text-align:center;
	}
	
	.firmaObserv{
	  height:35px;
	}
	
	.productosRemesa{
	  height:100px;
	}
	
	.productosRemesa td{
	  vertical-align:top;
	  color:#000000;
	}
	
	.content{
	  color:#000000;
	  font-size:12px;
	}
	
   .anulado{
      color:#003366;
	  font-size:70px;
   }	
	</style>
	{/literal}
</head>

<body>
	{foreach name=remesas from=$DATOSREMESAS item=r}
	
	 {if $r.estado eq 'AN'}	<div style="position:relative"><div style="position:absolute; top:40%; left:15%" class="anulado">REMESA ANULADA</div>{/if}
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="top:0px">
		<tr>
		  <td width="100%">
			<table  border="0" cellpadding="5" cellspacing="4" width="100%" >
			  <tr>
				<td width="289">&nbsp;</td>
				<td width="216" align="center"  >{$r.pagina_web}</td>
				<td width="104" align="center" >SERVICIO<br>ENTREGA<br>INMEDIATA<br>REMESA</td>
				<td width="320" align="center" >{$r.fecha_remesa} </td>
				<td width="50" align="right" ><div id="bcTarget_{$r.numero_remesa}">{$r.numero_remesa}</div></td>
			  </tr>
		  </table>
		  </td>
		</tr>
		<tr>
		  <td>
		  <table  border="0" cellpadding="0" cellspacing="0" >
			  <tr>
				<td    class="remesageneral" width="100%">
				<table  border="0" width="100%" >
					<tr>
					  <td width="59" >Origen:</td>
					  <td width="340" > {$r.origen|substr:0:32}</td>
					  <td width="87" >Destino :</td>
					  <td width="325" > {$r.destino|substr:0:32}</td>
					  <td width="87">Codigo :</td>
					  <td width="166">{$r.codigo|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Remitente: </td>
					  <td >{$r.remitente|substr:0:32}</td>
					  <td>Destinatario : </td>
					  <td >{$r.destinatario|substr:0:32}</td>
					  <td>Naturaleza :</td>
					  <td>{$r.naturaleza|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Direccion :</td>
					  <td >{$r.direccion_remitente|substr:0:32}</td>
					  <td>Direccion : </td>
					  <td >{$r.direccion_destinatario|substr:0:32} </td>
					  <td>Medida :</td>
					  <td>{$r.medida|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Telefono : </td>
					  <td >{$r.telefono_remitente|substr:0:32} </td>
					  <td>Telefono : </td>
					  <td >{$r.telefono_destinatario|substr:0:32} </td>
					  <td>Empaque :</td>
					  <td>{$r.empaque|substr:0:15}</td>
					</tr>
				</table>
				</td>
			  </tr>
			  <tr>
				<td   class="remesageneral" width="100%"  >
				<table align="center" border="0"  cellpadding="0" cellspacing="0" width="100%" height="90">
				  <tr >
					<td width="150" align="center">Referencia</td>                  
					<td width="100" align="center">Producto</td>                
					<td width="100" align="center">Cantidad</td>                             
					<td width="100" align="center">Peso</td>                   
					<td width="100" align="center">Guia Cliente</td>                                   
					<td width="200" align="center">Observaciones</td>                                                   
				  </tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[0].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[1].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[2].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[3].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[4].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[5].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[6].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].observaciones}</td>                                                                     
					</tr>
	
				</table>            
				</td>
			  </tr>
			  <tr>
			  <td class="remesageneral" width="100%">
				<table width="100%" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="400"  valign="top" >El destinatario: Recibi a conformidad</td>
				<td width="365" rowspan="3" valign="top"><div>Observaciones:</div><div align="center">{$r.observaciones}&nbsp;&nbsp;{$r.oficina_responsable}</div></td>
			  </tr>
			  <tr>
				<td height="45"  valign="top" >&nbsp;</td>
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
		<tr>
		  <td align="center"><b>TRANSPORTADORA</b></td>
		</tr>
	</table>
	</div>
	<br><br>
	<div style="position:relative">
    {if $r.estado eq 'A'}<div style="position:absolute; top:40%; left:15%" class="anulado">REMESA ANULADA</div>{/if}
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr>
		  <td width="100%">
			<table  border="0" cellpadding="5" cellspacing="4" width="100%" >
			  <tr>
				<td width="289"><img src="{$r.logo}" height="45" width="200"></td>
				<td width="216" align="center"  >{$r.pagina_web}</td>
				<td width="104" align="center" >SERVICIO<br>ENTREGA<br>INMEDIATA<br>REMESA</td>
				<td width="320" align="center" >{$r.fecha_remesa} </td>
				<td width="50" align="right" ><div id="bcTarget_{$r.numero_remesa}">{$r.numero_remesa}</div></td>
			  </tr>
		  </table>
		  </td>
		</tr>
		<tr>
		  <td>
		  <table  border="0" cellpadding="0" cellspacing="0" >
			  <tr>
				<td    class="remesageneral" width="100%">
				<table  border="0" width="100%" >
					<tr>
					  <td width="59" >Origen:</td>
					  <td width="340" > {$r.origen|substr:0:32}</td>
					  <td width="87" >Destino :</td>
					  <td width="325" > {$r.destino|substr:0:32}</td>
					  <td width="87">Codigo :</td>
					  <td width="166">{$r.codigo|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Remitente: </td>
					  <td >{$r.remitente|substr:0:32}</td>
					  <td>Destinatario : </td>
					  <td >{$r.destinatario|substr:0:32}</td>
					  <td>Naturaleza :</td>
					  <td>{$r.naturaleza|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Direccion :</td>
					  <td >{$r.direccion_remitente|substr:0:32}</td>
					  <td>Direccion : </td>
					  <td >{$r.direccion_destinatario|substr:0:32} </td>
					  <td>Medida :</td>
					  <td>{$r.medida|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Telefono : </td>
					  <td >{$r.telefono_remitente|substr:0:32} </td>
					  <td>Telefono : </td>
					  <td >{$r.telefono_destinatario|substr:0:32} </td>
					  <td>Empaque :</td>
					  <td>{$r.empaque|substr:0:15}</td>
					</tr>
				</table>
				</td>
			  </tr>
			  <tr>
				<td   class="remesageneral" width="100%"  >
				<table align="center" border="0"  cellpadding="0" cellspacing="0" width="100%" height="90">
				  <tr >
					<td width="150" align="center">Referencia</td>                  
					<td width="100" align="center">Producto</td>                
					<td width="100" align="center">Cantidad</td>                             
					<td width="100" align="center">Peso</td>                   
					<td width="100" align="center">Guia Cliente</td>                                   
					<td width="200" align="center">Observaciones</td>                                                   
				  </tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[0].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[1].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[2].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[3].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[4].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[5].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[6].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].observaciones}</td>                                                                     
					</tr>
	
				</table>            
				</td>
			  </tr>
			  <tr>
			  <td class="remesageneral" width="100%">
				<table width="100%" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="400"  valign="top" >El destinatario: Recibi a conformidad</td>
				<td width="365" rowspan="3" valign="top"><div>Observaciones:</div><div align="center">{$r.observaciones}&nbsp;&nbsp;{$r.oficina_responsable}</div></td>
			  </tr>
			  <tr>
				<td height="45"  valign="top" >&nbsp;</td>
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
		<tr>
		  <td align="center"><b>CLIENTE</b></td>
		</tr>
	</table>
	</div>
	<br><br><br>
	<div style="position:relative">
    {if $r.estado eq 'A'}<div style="position:absolute; top:40%; left:15%" class="anulado">REMESA ANULADA</div>{/if}	
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr>
		  <td width="100%">
			<table  border="0" cellpadding="5" cellspacing="4" width="100%" >
			  <tr>
				<td width="289"><img src="{$r.logo}" height="45" width="200"></td>
				<td width="216" align="center"  >{$r.pagina_web}</td>
				<td width="104" align="center" >SERVICIO<br>ENTREGA<br>INMEDIATA<br>REMESA</td>
				<td width="320" align="center" >{$r.fecha_remesa} </td>
				<td width="50" align="right" ><div id="bcTarget_{$r.numero_remesa}">{$r.numero_remesa}</div></td>
			  </tr>
		  </table>
		  </td>
		</tr>
		<tr>
		  <td>
		  <table  border="0" cellpadding="0" cellspacing="0" >
			  <tr>
				<td    class="remesageneral" width="100%">
				<table  border="0" width="100%" >
					<tr>
					  <td width="59" >Origen:</td>
					  <td width="340" > {$r.origen|substr:0:32}</td>
					  <td width="87" >Destino :</td>
					  <td width="325" > {$r.destino|substr:0:32}</td>
					  <td width="87">Codigo :</td>
					  <td width="166">{$r.codigo|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Remitente: </td>
					  <td >{$r.remitente|substr:0:32}</td>
					  <td>Destinatario : </td>
					  <td >{$r.destinatario|substr:0:32}</td>
					  <td>Naturaleza :</td>
					  <td>{$r.naturaleza|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Direccion :</td>
					  <td >{$r.direccion_remitente|substr:0:32}</td>
					  <td>Direccion : </td>
					  <td >{$r.direccion_destinatario|substr:0:32} </td>
					  <td>Medida :</td>
					  <td>{$r.medida|substr:0:15}</td>
					</tr>
					<tr>
					  <td>Telefono : </td>
					  <td >{$r.telefono_remitente|substr:0:32} </td>
					  <td>Telefono : </td>
					  <td >{$r.telefono_destinatario|substr:0:32} </td>
					  <td>Empaque :</td>
					  <td>{$r.empaque|substr:0:15}</td>
					</tr>
				</table>
				</td>
			  </tr>
			  <tr>
				<td   class="remesageneral" width="100%"  >
				<table align="center" border="0"  cellpadding="0" cellspacing="0" width="100%" height="90">
				  <tr >
					<td width="150" align="center">Referencia</td>                  
					<td width="100" align="center">Producto</td>                
					<td width="100" align="center">Cantidad</td>                             
					<td width="100" align="center">Peso</td>                   
					<td width="100" align="center">Guia Cliente</td>                                   
					<td width="200" align="center">Observaciones</td>                                                   
				  </tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[0].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[0].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[1].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[1].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[2].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[2].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[3].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[3].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[4].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[4].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[5].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[5].observaciones}</td>                                                                     
					</tr>
					<tr align="center">
					  <td height="10" align='left' >&nbsp;&nbsp;{$r.detalles_remesa[6].referencia_producto}</td>                                
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].descripcion_producto}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].cantidad}</td>                                  
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].peso}</td>                                                    
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].guia_cliente}</td>
					  <td  >&nbsp;&nbsp;{$r.detalles_remesa[6].observaciones}</td>                                                                     
					</tr>
	
				</table>            
				</td>
			  </tr>
			  <tr>
			  <td class="remesageneral" width="100%">
				<table width="100%" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="400"  valign="top" >El destinatario: Recibi a conformidad</td>
				<td width="365" rowspan="3" valign="top"><div>Observaciones:</div><div align="center">{$r.observaciones}&nbsp;&nbsp;{$r.oficina_responsable}</div></td>
			  </tr>
			  <tr>
				<td height="45"  valign="top" >&nbsp;</td>
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
		<tr>
		  <td align="center"><b>DESTINATARIO</b></td>
		</tr>		
	</table>			
	{if $r.estado eq 'AN'}	</div>{/if}
	<script>renderBarCode('{$r.numero_remesa}')</script>	 
    {if count($DATOSREMESAS) > 0}<br class="saltopagina" />{/if}
	{/foreach}

</body>
</html>