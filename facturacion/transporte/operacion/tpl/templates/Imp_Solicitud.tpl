{literal}
<style>
/* CSS Document */

   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#F2F2F2;
	 font-weight:bold;
	 text-align:center;
	 border-top:1px solid;
	 border-right:1px solid;
	 border-left:1px solid;
	 border-bottom:1px solid;
   }
   
   .fontBig{
     font-size:16px;
   }
   
   .fontsmall{
   	font-size:10px;
	   
   }
   .infogeneral{
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
	 text-align:center;
   }
   
   .cellTitle{
     background-color:#999999;
	 font-weight:bold;
	 text-align:center;
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
   }
   
   .cellRight{
     font-weight:bold;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;	 
	 
   }
   
   .cellLeft{
	  font-weight:bold;  
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;
   }


   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 font-size:13px;
	 text-align:left;
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 font-size:13px;
	 text-align:left;	 
   }
   
   body{
    padding:0px;
   }
   .contec_center{
    font-weight:bold;
	font-size:12px;
	text-align:center;
	text-transform:uppercase;
   }
   .content{
    font-weight:bold;
	font-size:12px;
	text-align:left;
	text-transform:uppercase;
   }

   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:100px;
   }
   .encabezado{
	   width:740px;
	   text-align:justify;
	   font-size:14px;
	
   }
   .anulado{
	   width:500px;
	   margin-top:280px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

   .anulado1{
	   width:500px;
	   margin-top:490px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .anulado2{
	   width:500px;
	   margin-top:750px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   
   .realizado{
	   width:500px;
	   margin-top:280px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

   .realizado1{
	   width:500px;
	   margin-top:490px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

   .realizado1{
	   width:500px;
	   margin-top:750px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

</style>
{/literal}
	
<page orientation="portrait" >
	{if $DATOSORDENCARGUE.estado eq 'A'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
        <div class="anulado2">ANULADO</div>
    {/if}    
	{if $DATOSORDENCARGUE.estado eq 'R'}
        <div class="realizado">REALIZADO</div>
        <div class="realizado1">REALIZADO</div>
        <div class="realizado2">REALIZADO</div>
    {/if}    
    
	<table style="margin-left:15px; margin-top:30px;"  cellpadding="0" cellspacing="0">
    	<tr>
      		<td align="center">
            	<table width="100%" border="0">
        			<tr>
          				<td></td>
        			</tr>
        			<tr>
          				<td>
                        	<table  border="0" cellpadding="0" cellspacing="0" width="100%">
            					<tr>
             						<td width="242" align="left" valign="top">
                                    	<img src="{$DATOSORDENCARGUE.logo}" width="160" height="40" />                                       
                                    </td>
              						<td width="240" valign="top" align="center">
                                        <span class="fontsmall">{$DATOSORDENCARGUE.razon_social}<br />{$DATOSORDENCARGUE.tipo_identificacion_emp} {$DATOSORDENCARGUE.numero_identificacion_emp}<br />
                                      {$DATOSORDENCARGUE.dir_oficna}<br />Tel&eacute;fonos: {$DATOSORDENCARGUE.tel_oficina}. Ciudad: {$DATOSORDENCARGUE.ciudad_ofi} </span>
                                    </td>
              						<td width="33" align="center" valign="top">&nbsp;</td>
              						<td width="180" valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right">
                  							<tr >
                    							<td  class="title">
                                                	<strong class="fontBig">SOLICITUD
                                                	DE SERVICIO No</strong>
                                                </td>
                  							</tr>
                  							<tr >
                    							<td class="infogeneral">{$DATOSORDENCARGUE.solicitud_id}</td>
                  							</tr>
                  							<tr >
                    							<td  class="title">OFICINA</td>
                  							</tr>
                  							<tr>
                    							<td class="infogeneral">{$DATOSORDENCARGUE.nom_oficina}</td>
                  							</tr>
                  							<tr>
                    							<td class="title">Fecha Expedici&oacute;n</td>
                  							</tr>
                  							<tr>
                    							<td class="infogeneral">{$DATOSORDENCARGUE.fecha_ss}</td>
                  							</tr>

              							</table>
                                  	</td>
            					</tr>
          					</table>
                  		</td>
        			</tr>
                    <tr>
                    	<td>&nbsp;</td>
                    </tr>
                   
      			</table>
			</td>
        </tr>
        <tr>
		  <td>
		    <table width="100%" style="margin-left:15px; margin-top:30px;">
			 <tr>
			   <td align="left" class="title">CLIENTE </td>
			   <td class="cellRight" style="border-top:1px solid" colspan="3">&nbsp;{$DATOSORDENCARGUE.cliente_nombre}</td>
			 </tr>
             <tr>
                <td class="title">REMITENTE</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.remitente}</td>
                <td class="title">DIRECCION REMITENTE</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.telefono_remitente}</td>
             </tr>
             <tr>
                <td class="title">TEL REMITENTE</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.direccion_remitente}</td>
                <td class="title">CIUDAD REMITENTE</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.ciudad_remitente}</td>
             </tr>
             
             <tr>
                <td class="title">DESTINATARIO</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.destinatario}</td>
                <td class="title">DIRECCION DESTINATARIO</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.telefono_destinatario}</td>
             </tr>
             <tr>
                <td class="title">TEL DESTINATARIO</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.direccion_destinatario}</td>
                <td class="title">CIUDAD DESTINATARIO</td>
                <td class="cellRight" style="border-top:1px solid">&nbsp;{$DATOSORDENCARGUE.ciudad_destinatario}</td>
             </tr>
             
             
			 </table>
		  </td>
		</tr>
		
		<tr>
		  <td>
		    <table width="100%" style="margin-left:15px; margin-top:30px;">
			 <tr>
			   <td class="title" align="left">OBSERVACIONES</td>
			   <td class="cellRight" style="border-top:1px solid" width="80%">&nbsp;{$DATOSORDENCARGUE.observaciones}</td>
			 </tr>
             <tr>
			   <td class="title" align="left">VALORES ADICIONALES</td>
			   <td class="cellRight" style="border-top:1px solid" width="80%">&nbsp;{$DATOSORDENCARGUE.valores_complementarios}</td>
			 </tr>
             <tr>
			   <td class="title" align="left">DESCRIPCION ADICIONALES</td>
			   <td class="cellRight" style="border-top:1px solid" width="80%">&nbsp;{$DATOSORDENCARGUE.descrip_val_comp}</td>
			 </tr>
			 </table>
		  </td>
		</tr>
       
	</table>                   
</page>