{literal}
<style >
/* CSS Document */

   table tr td{
      font-size:12px;
	  font-family:Arial, Helvetica, sans-serif;
	  background-image:"../../../framework/media/images/general/FondoFianza.png";
   }
     
   .title{
     background-color:#CCC;
	 font-weight:bold;
	 text-align:center;
	 border-bottom:#000 1px solid;
	 border-top:#000 2px solid;
   }
   
   .fontBig{
     font-size:10px;
   }
   
  .fontBig5{
     font-size:10px;
   }

   
   .infoGeneral{
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
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;	
 	 padding: 3px;
	 
   }
   .cellRightRed{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;	
 	 padding: 3px;
	 color:#F00;
	 
   }
   
   .cellLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:left;
	 padding: 3px;
   }

   .cellCenter{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 text-align:center;
   }

   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
     background-color:#999999;
	 font-weight:bold;
	 text-align:center;	   
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 border-top:1px solid;	 
     background-color:#999999;
	 font-weight:bold;
	 text-align:center;	 
   }
   
   body{
    padding:0px;
   }
   
   .content{
    font-weight:bold;
	font-size:13px;
	text-align:center;
	text-transform:uppercase;
   }

   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:120px;
   }
   .anulado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.2;
	   filter:alpha(opacity=40);
   }

   .anulado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.2;
	   filter:alpha(opacity=40);
   }
   .realizado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.2;
	   filter:alpha(opacity=40);
   }

   .realizado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.2;
	   filter:alpha(opacity=40);
   }

	.fontsmall{
		font-size:14px;
	}
	.fontgrande{
		font-size:17px;
		font-weight:bold
	}
</style>
{/literal}
<body background="../../../framework/media/images/general/FondoFianza.png" style="background-image:../../../framework/media/images/general/FondoFianza.png">

{foreach name=datos_solicitud from=$DATOSSOLICITUD item=d}
<div style="page-break-before:auto">
<table style="margin-left:80px; margin-top:20px; margin-right:25px" width="650"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <table width="650" border="0">
                <tr>
                    <td width="325" align="left"><img src="../../../framework/media/images/general/FondoFianza.png" width="180" height="172"/></td>
                    <td width="325" align="right" valign="top"><img src="../../../framework/media/images/varios/logo.jpg" width="200" height="90"/></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="right"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr align="justify" class="fontBig5">
                    <td colspan="2"><div align="justify">{$d.ciudad_oficina}, {$fecha_hoy_texto}<br /><br /><br /><br />

                    Se&ntilde;or (a)<br />
                   
                    <strong>{$d.nombre_arrendatario} <br />
                    {$d.dir_arrendatario}<br />
                    {$d.ciudad_arrendatario} - {$d.depto_arrendatario}<br /><br /><br /></strong>

					Respetado Se&ntilde;or (a)<br /><br /><br />
					<p align="justify">Comedidamente nos permitimos informarle que hemos recibido reporte de mora por parte de la entidad  {$d.cliente} y con ello la autorizaci&oacute;n de realizar el cobro pre jur&iacute;dico y jur&iacute;dico de los c&aacute;nones de arrendamiento adeudados por usted en calidad de {$d.tipo_persona_arrendatario} del inmueble ubicado en {$d.direccion_inmueble} administrado por esta arrendadora. Siendo as&iacute; los valores adeudados corresponden a {$d.tipo_mora} de {$meses_mora_desde} / {$meses_mora_hasta}.</p>
					<p align="justify">Le recordamos que si realiza el pago en la Inmobiliaria antes del d&iacute;a {$fecha_texto}, no se generaran gastos de gesti&oacute;n de cobro por parte de la afianzadora. Por lo anterior, si supera esta fecha y no se ha realizado el pago, deber&aacute; realizarlo en Fianzacr&eacute;dito Central, con un incremento de gesti&oacute;n de cobro, el cual ser&aacute; informado de nuestra parte dicha obligaci&oacute;n deber&aacute; depositarla en  la CUENTA CORRIENTE 07916120229 BANCOLOMBIA o CUENTA CORRIENTE  322804329 BANCO OCCIDENTE. Una vez efectuado el pago&nbsp; notificar al WhatsApp n&uacute;mero  315 638 88 00 o correo  electr&oacute;nico coordinadorcartera@fianzacredito.com.co.</p>
					<p align="justify">De acuerdo con lo estipulado en la Ley 1266 de 2008 Art. 12 y la cl&aacute;usula de autorizaci&oacute;n del contrato de arrendamiento de la referencia, nos permitimos informarle que en caso de no obtener el pago de las sumas adeudadas, procederemos a efectuar el reporte negativo, tanto al arrendatario como de los deudores solidarios a las centrales de informaci&oacute;n (Datacr&eacute;dito y Cifin) a los veinte (20) d&iacute;as calendarios de emitida esta comunicaci&oacute;n, para evitar lo anterior lo invitamos a ponerse  al d&iacute;a en su (s) obligaci&oacute;n (es).</p>
					<p align="justify">En caso de requerir informaci&oacute;n adicional puede comunicarse en Ibagu&eacute; al tel&eacute;fono 2703560, 2703556 o 315 638 8800, al correo coordinadorcartera@fianzacredito.com.co   o en nuestra oficina ubicada en la {$d.direccion_empresa}. Que con gusto ser&aacute; atendido(a). Si ya se encuentra al d&iacute;a con su obligaci&oacute;n, por favor haga caso omiso de esta comunicaci&oacute;n.<br /><br /><br /></p>
				    Atentamente,<br /><br /><br /><br />
                    <img src="../../../framework/media/images/general/FirmaFianza.png" width="180" height="72"/><br />
                  	DEPARTAMENTO DE CARTERA
                  </div></td>	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td width="300" align="right">Recuerde que el adecuado manejo  de su (s) obligaci&oacute;n (es) es su mejor referencia comercial y financiera.</td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
                <tr>
                    <td style="border-top:#000 2px solid;">&nbsp;</td>
                </tr>    
    <tr>
      <td align="center">
       Ibagu&eacute;, Cra. 6A # 60-68 Piso 2  * Tels.  (8) 2741619 � 3156388800 <br>
		www.fianzacredito.com.co * info@fianzacredito.com.co
 
      </td>                    
    </tr>
    <tr>
        <td>        
            
        </td>
    </tr>                                    
    <tr>
        <td valign="top">

        </td>
    </tr>    
</table>
</div>
{if $d.deudor >0}
<div style="page-break-before:auto">  
<table style="margin-left:80px; margin-top:20px; margin-right:25px" width="650"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <table width="650" border="0">
                <tr>
                    <td width="325" align="left"><img src="../../../framework/media/images/general/FondoFianza.png" width="180" height="172"/></td>
                    <td width="325" align="right" valign="top"><img src="../../../framework/media/images/varios/logo.jpg" width="200" height="90"/></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="right"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr align="justify" class="fontBig5">
                    <td colspan="2"><div align="justify">{$d.ciudad_oficina}, {$fecha_hoy_texto}<br /><br /><br /><br />

                    Se&ntilde;or (a)<br />
                   
                    <strong>{$d.nombre_codeudor} <br />
                    {$d.dir_codeudor}<br />
                    {$d.ciudad_codeudor} - {$d.depto_codeudor}<br /><br /><br /></strong>

					Respetado Se&ntilde;or (a)<br /><br /><br />
					<p align="justify">Comedidamente nos permitimos informarle que hemos recibido reporte de mora por parte de la entidad  {$d.cliente} y con ello la autorizaci&oacute;n de realizar el cobro pre jur&iacute;dico y jur&iacute;dico de los c&aacute;nones de arrendamiento adeudados por usted en calidad de {$d.tipo_persona_deudor} del inmueble ubicado en {$d.direccion_inmueble} administrado por esta arrendadora. Siendo as&iacute; los valores adeudados corresponden a {$d.tipo_mora} de {$meses_mora_desde} / {$meses_mora_hasta}.</p>
					<p align="justify">Le recordamos que si realiza el pago en la Inmobiliaria antes del d&iacute;a {$fecha_texto}, no se generaran gastos de gesti&oacute;n de cobro por parte de la afianzadora. Por lo anterior, si supera esta fecha y no se ha realizado el pago, deber&aacute; realizarlo en Fianzacr&eacute;dito Central, con un incremento de gesti&oacute;n de cobro, el cual ser&aacute; informado de nuestra parte dicha obligaci&oacute;n deber&aacute; depositarla en  la CUENTA CORRIENTE 07916120229 BANCOLOMBIA o CUENTA CORRIENTE  322804329 BANCO OCCIDENTE. Una vez efectuado el pago&nbsp; notificar al WhatsApp n&uacute;mero  315 638 88 00 o correo  electr&oacute;nico coordinadorcartera@fianzacredito.com.co.</p>
					<p align="justify">De acuerdo con lo estipulado en la Ley 1266 de 2008 Art. 12 y la cl&aacute;usula de autorizaci&oacute;n del contrato de arrendamiento de la referencia, nos permitimos informarle que en caso de no obtener el pago de las sumas adeudadas, procederemos a efectuar el reporte negativo, tanto al arrendatario como de los deudores solidarios a las centrales de informaci&oacute;n (Datacr&eacute;dito y Cifin) a los veinte (20) d&iacute;as calendarios de emitida esta comunicaci&oacute;n, para evitar lo anterior lo invitamos a ponerse  al d&iacute;a en su (s) obligaci&oacute;n (es).</p>
					<p align="justify">En caso de requerir informaci&oacute;n adicional puede comunicarse en Ibagu&eacute; al tel&eacute;fono 2703560, 2703556 o 315 638 8800, al correo coordinadorcartera@fianzacredito.com.co   o en nuestra oficina ubicada en la {$d.direccion_empresa}. Que con gusto ser&aacute; atendido(a). Si ya se encuentra al d&iacute;a con su obligaci&oacute;n, por favor haga caso omiso de esta comunicaci&oacute;n.<br /><br /><br /></p>
				    Atentamente,<br /><br /><br /><br />
                    <img src="../../../framework/media/images/general/FirmaFianza.png" width="180" height="72"/><br />
                  	DEPARTAMENTO DE CARTERA
                  </div></td>	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td width="300" align="right">Recuerde que el adecuado manejo  de su (s) obligaci&oacute;n (es) es su mejor referencia comercial y financiera.</td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
                <tr>
                    <td style="border-top:#000 2px solid;">&nbsp;</td>
                </tr>    
    <tr>
      <td align="center">
       Ibagu&eacute;, Carrera 5 36-50 Of. 301  * Tels.  (8) 2703560 � 2703556 � 3156388800 <br>
Neiva, Carrera 6 # 6 � 70 oficina 203 Edificio San Pedro * Tels. (8) 8719837 - 3174280082<br>
www.fianzacredito.com.co * info@fianzacredito.com.co
 
      </td>                    
    </tr>
    <tr>
        <td>        
            
        </td>
    </tr>                                    
    <tr>
        <td valign="top">

        </td>
    </tr>    
</table>
</div>
{/if}
{if $d.deudor1 >0}
<div style="page-break-before:auto">  
<table style="margin-left:80px; margin-top:20px; margin-right:25px" width="650"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <table width="650" border="0">
                <tr>
                    <td width="325" align="left"><img src="../../../framework/media/images/general/FondoFianza.png" width="180" height="172"/></td>
                    <td width="325" align="right" valign="top"><img src="../../../framework/media/images/varios/logo.jpg" width="200" height="90"/></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="right"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr align="justify" class="fontBig5">
                    <td colspan="2"><div align="justify">{$d.ciudad_oficina}, {$fecha_hoy_texto}<br /><br /><br /><br />

                    Se&ntilde;or (a)<br />
                   
                    <strong>{$d.nombre_codeudor1} <br />
                    {$d.dir_codeudor1}<br />
                    {$d.ciudad_codeudor1} - {$d.depto_codeudor1}<br /><br /><br /></strong>

					Respetado Se&ntilde;or (a)<br /><br /><br />
					<p align="justify">Comedidamente nos permitimos informarle que hemos recibido reporte de mora por parte de la entidad  {$d.cliente} y con ello la autorizaci&oacute;n de realizar el cobro pre jur&iacute;dico y jur&iacute;dico de los c&aacute;nones de arrendamiento adeudados por usted en calidad de {$d.tipo_persona_deudor} del inmueble ubicado en {$d.direccion_inmueble} administrado por esta arrendadora. Siendo as&iacute; los valores adeudados corresponden a {$d.tipo_mora} de {$meses_mora_desde} / {$meses_mora_hasta}.</p>
					<p align="justify">Le recordamos que si realiza el pago en la Inmobiliaria antes del d&iacute;a {$fecha_texto}, no se generaran gastos de gesti&oacute;n de cobro por parte de la afianzadora. Por lo anterior, si supera esta fecha y no se ha realizado el pago, deber&aacute; realizarlo en Fianzacr&eacute;dito Central, con un incremento de gesti&oacute;n de cobro, el cual ser&aacute; informado de nuestra parte dicha obligaci&oacute;n deber&aacute; depositarla en  la CUENTA CORRIENTE 07916120229 BANCOLOMBIA o CUENTA CORRIENTE  322804329 BANCO OCCIDENTE. Una vez efectuado el pago&nbsp; notificar al WhatsApp n&uacute;mero  315 638 88 00 o correo  electr&oacute;nico coordinadorcartera@fianzacredito.com.co.</p>
					<p align="justify">De acuerdo con lo estipulado en la Ley 1266 de 2008 Art. 12 y la cl&aacute;usula de autorizaci&oacute;n del contrato de arrendamiento de la referencia, nos permitimos informarle que en caso de no obtener el pago de las sumas adeudadas, procederemos a efectuar el reporte negativo, tanto al arrendatario como de los deudores solidarios a las centrales de informaci&oacute;n (Datacr&eacute;dito y Cifin) a los veinte (20) d&iacute;as calendarios de emitida esta comunicaci&oacute;n, para evitar lo anterior lo invitamos a ponerse  al d&iacute;a en su (s) obligaci&oacute;n (es).</p>
					<p align="justify">En caso de requerir informaci&oacute;n adicional puede comunicarse en Ibagu&eacute; al tel&eacute;fono 2703560, 2703556 o 315 638 8800, al correo coordinadorcartera@fianzacredito.com.co   o en nuestra oficina ubicada en la {$d.direccion_empresa}. Que con gusto ser&aacute; atendido(a). Si ya se encuentra al d&iacute;a con su obligaci&oacute;n, por favor haga caso omiso de esta comunicaci&oacute;n.<br /><br /><br /></p>
				    Atentamente,<br /><br /><br /><br />
                    <img src="../../../framework/media/images/general/FirmaFianza.png" width="180" height="72"/><br />
                  	DEPARTAMENTO DE CARTERA
                  </div></td>	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td width="300" align="right">Recuerde que el adecuado manejo  de su (s) obligaci&oacute;n (es) es su mejor referencia comercial y financiera.</td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
                <tr>
                    <td style="border-top:#000 2px solid;">&nbsp;</td>
                </tr>    
    <tr>
      <td align="center">
       Ibagu&eacute;, Carrera 5 36-50 Of. 301  * Tels.  (8) 2703560 � 2703556 � 3156388800 <br>
Neiva, Carrera 6 # 6 � 70 oficina 203 Edificio San Pedro * Tels. (8) 8719837 - 3174280082<br>
www.fianzacredito.com.co * info@fianzacredito.com.co
 
      </td>                    
    </tr>
    <tr>
        <td>        
            
        </td>
    </tr>                                    
    <tr>
        <td valign="top">

        </td>
    </tr>    
</table>
</div>
{/if}
{if $d.deudor2 >0}
<div style="page-break-before:auto">  
<table style="margin-left:80px; margin-top:20px; margin-right:25px" width="650"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <table width="650" border="0">
                <tr>
                    <td width="325" align="left"><img src="../../../framework/media/images/general/FondoFianza.png" width="180" height="172"/></td>
                    <td width="325" align="right" valign="top"><img src="../../../framework/media/images/varios/logo.jpg" width="200" height="90"/></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="right"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr align="justify" class="fontBig5">
                    <td colspan="2"><div align="justify">{$d.ciudad_oficina}, {$fecha_hoy_texto}<br /><br /><br /><br />

                    Se&ntilde;or (a)<br />
                   
                    <strong>{$d.nombre_codeudor2} <br />
                    {$d.dir_codeudor2}<br />
                    {$d.ciudad_codeudor2} - {$d.depto_codeudor2}<br /><br /><br /></strong>

					Respetado Se&ntilde;or (a)<br /><br /><br />
					<p align="justify">Comedidamente nos permitimos informarle que hemos recibido reporte de mora por parte de la entidad  {$d.cliente} y con ello la autorizaci&oacute;n de realizar el cobro pre jur&iacute;dico y jur&iacute;dico de los c&aacute;nones de arrendamiento adeudados por usted en calidad de {$d.tipo_persona_deudor} del inmueble ubicado en {$d.direccion_inmueble} administrado por esta arrendadora. Siendo as&iacute; los valores adeudados corresponden a {$d.tipo_mora} de {$meses_mora_desde} / {$meses_mora_hasta}.</p>
					<p align="justify">Le recordamos que si realiza el pago en la Inmobiliaria antes del d&iacute;a {$fecha_texto}, no se generaran gastos de gesti&oacute;n de cobro por parte de la afianzadora. Por lo anterior, si supera esta fecha y no se ha realizado el pago, deber&aacute; realizarlo en Fianzacr&eacute;dito Central, con un incremento de gesti&oacute;n de cobro, el cual ser&aacute; informado de nuestra parte dicha obligaci&oacute;n deber&aacute; depositarla en  la CUENTA CORRIENTE 07916120229 BANCOLOMBIA o CUENTA CORRIENTE  322804329 BANCO OCCIDENTE. Una vez efectuado el pago&nbsp; notificar al WhatsApp n&uacute;mero  315 638 88 00 o correo  electr&oacute;nico coordinadorcartera@fianzacredito.com.co.</p>
					<p align="justify">De acuerdo con lo estipulado en la Ley 1266 de 2008 Art. 12 y la cl&aacute;usula de autorizaci&oacute;n del contrato de arrendamiento de la referencia, nos permitimos informarle que en caso de no obtener el pago de las sumas adeudadas, procederemos a efectuar el reporte negativo, tanto al arrendatario como de los deudores solidarios a las centrales de informaci&oacute;n (Datacr&eacute;dito y Cifin) a los veinte (20) d&iacute;as calendarios de emitida esta comunicaci&oacute;n, para evitar lo anterior lo invitamos a ponerse  al d&iacute;a en su (s) obligaci&oacute;n (es).</p>
					<p align="justify">En caso de requerir informaci&oacute;n adicional puede comunicarse en Ibagu&eacute; al tel&eacute;fono 2703560, 2703556 o 315 638 8800, al correo coordinadorcartera@fianzacredito.com.co   o en nuestra oficina ubicada en la {$d.direccion_empresa}. Que con gusto ser&aacute; atendido(a). Si ya se encuentra al d&iacute;a con su obligaci&oacute;n, por favor haga caso omiso de esta comunicaci&oacute;n.<br /><br /><br /></p>
				    Atentamente,<br /><br /><br /><br />
                    <img src="../../../framework/media/images/general/FirmaFianza.png" width="180" height="72"/><br />
                  	DEPARTAMENTO DE CARTERA
                  </div></td>	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td width="300" align="right">Recuerde que el adecuado manejo  de su (s) obligaci&oacute;n (es) es su mejor referencia comercial y financiera.</td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
                <tr>
                    <td style="border-top:#000 2px solid;">&nbsp;</td>
                </tr>    
    <tr>
      <td align="center">
       Ibagu&eacute;, Carrera 5 36-50 Of. 301  * Tels.  (8) 2703560 � 2703556 � 3156388800 <br>
Neiva, Carrera 6 # 6 � 70 oficina 203 Edificio San Pedro * Tels. (8) 8719837 - 3174280082<br>
www.fianzacredito.com.co * info@fianzacredito.com.co
 
      </td>                    
    </tr>
    <tr>
        <td>        
            
        </td>
    </tr>                                    
    <tr>
        <td valign="top">

        </td>
    </tr>    
</table>
</div>
{/if}
{if $d.deudor3 >0}
<div style="page-break-before:auto">  
<table style="margin-left:80px; margin-top:20px; margin-right:25px" width="650"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <table width="650" border="0">
                <tr>
                    <td width="325" align="left"><img src="../../../framework/media/images/general/FondoFianza.png" width="180" height="172"/></td>
                    <td width="325" align="right" valign="top"><img src="../../../framework/media/images/varios/logo.jpg" width="200" height="90"/></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="right"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr align="justify" class="fontBig5">
                    <td colspan="2"><div align="justify">{$d.ciudad_oficina}, {$fecha_hoy_texto}<br /><br /><br /><br />

                    Se&ntilde;or (a)<br />
                   
                    <strong>{$d.nombre_codeudor3} <br />
                    {$d.dir_codeudor3}<br />
                    {$d.ciudad_codeudor3} - {$d.depto_codeudor3}<br /><br /><br /></strong>

					Respetado Se&ntilde;or (a)<br /><br /><br />
					<p align="justify">Comedidamente nos permitimos informarle que hemos recibido reporte de mora por parte de la entidad  {$d.cliente} y con ello la autorizaci&oacute;n de realizar el cobro pre jur&iacute;dico y jur&iacute;dico de los c&aacute;nones de arrendamiento adeudados por usted en calidad de {$d.tipo_persona_deudor} del inmueble ubicado en {$d.direccion_inmueble} administrado por esta arrendadora. Siendo as&iacute; los valores adeudados corresponden a {$d.tipo_mora} de {$meses_mora_desde} / {$meses_mora_hasta}.</p>
					<p align="justify">Le recordamos que si realiza el pago en la Inmobiliaria antes del d&iacute;a {$fecha_texto}, no se generaran gastos de gesti&oacute;n de cobro por parte de la afianzadora. Por lo anterior, si supera esta fecha y no se ha realizado el pago, deber&aacute; realizarlo en Fianzacr&eacute;dito Central, con un incremento de gesti&oacute;n de cobro, el cual ser&aacute; informado de nuestra parte dicha obligaci&oacute;n deber&aacute; depositarla en  la CUENTA CORRIENTE 07916120229 BANCOLOMBIA o CUENTA CORRIENTE  322804329 BANCO OCCIDENTE. Una vez efectuado el pago&nbsp; notificar al WhatsApp n&uacute;mero  315 638 88 00 o correo  electr&oacute;nico coordinadorcartera@fianzacredito.com.co.</p>
					<p align="justify">De acuerdo con lo estipulado en la Ley 1266 de 2008 Art. 12 y la cl&aacute;usula de autorizaci&oacute;n del contrato de arrendamiento de la referencia, nos permitimos informarle que en caso de no obtener el pago de las sumas adeudadas, procederemos a efectuar el reporte negativo, tanto al arrendatario como de los deudores solidarios a las centrales de informaci&oacute;n (Datacr&eacute;dito y Cifin) a los veinte (20) d&iacute;as calendarios de emitida esta comunicaci&oacute;n, para evitar lo anterior lo invitamos a ponerse  al d&iacute;a en su (s) obligaci&oacute;n (es).</p>
					<p align="justify">En caso de requerir informaci&oacute;n adicional puede comunicarse en Ibagu&eacute; al tel&eacute;fono 2703560, 2703556 o 315 638 8800, al correo coordinadorcartera@fianzacredito.com.co   o en nuestra oficina ubicada en la {$d.direccion_empresa}. Que con gusto ser&aacute; atendido(a). Si ya se encuentra al d&iacute;a con su obligaci&oacute;n, por favor haga caso omiso de esta comunicaci&oacute;n.<br /><br /><br /></p>
				    Atentamente,<br /><br /><br /><br />
                    <img src="../../../framework/media/images/general/FirmaFianza.png" width="180" height="72"/><br />
                  	DEPARTAMENTO DE CARTERA
                  </div></td>	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td width="300" align="right">Recuerde que el adecuado manejo  de su (s) obligaci&oacute;n (es) es su mejor referencia comercial y financiera.</td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
                <tr>
                    <td style="border-top:#000 2px solid;">&nbsp;</td>
                </tr>    
    <tr>
      <td align="center">
       Ibagu&eacute;, Carrera 5 36-50 Of. 301  * Tels.  (8) 2703560 � 2703556 � 3156388800 <br>
Neiva, Carrera 6 # 6 � 70 oficina 203 Edificio San Pedro * Tels. (8) 8719837 - 3174280082<br>
www.fianzacredito.com.co * info@fianzacredito.com.co
 
      </td>                    
    </tr>
    <tr>
        <td>        
            
        </td>
    </tr>                                    
    <tr>
        <td valign="top">

        </td>
    </tr>    
</table>
</div>
{/if}
{if $d.deudor4 >0}
<div style="page-break-before:auto">  
<table style="margin-left:80px; margin-top:20px; margin-right:25px" width="650"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <table width="650" border="0">
                <tr>
                    <td width="325" align="left"><img src="../../../framework/media/images/general/FondoFianza.png" width="180" height="172"/></td>
                    <td width="325" align="right" valign="top"><img src="../../../framework/media/images/varios/logo.jpg" width="200" height="90"/></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="right"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr align="justify" class="fontBig5">
                    <td colspan="2"><div align="justify">{$d.ciudad_oficina}, {$fecha_hoy_texto}<br /><br /><br /><br />

                    Se&ntilde;or (a)<br />
                   
                    <strong>{$d.nombre_codeudor4} <br />
                    {$d.dir_codeudor4}<br />
                    {$d.ciudad_codeudor4} - {$d.depto_codeudor4}<br /><br /><br /></strong>

					Respetado Se&ntilde;or (a)<br /><br /><br />
					<p align="justify">Comedidamente nos permitimos informarle que hemos recibido reporte de mora por parte de la entidad  {$d.cliente} y con ello la autorizaci&oacute;n de realizar el cobro pre jur&iacute;dico y jur&iacute;dico de los c&aacute;nones de arrendamiento adeudados por usted en calidad de {$d.tipo_persona_deudor} del inmueble ubicado en {$d.direccion_inmueble} administrado por esta arrendadora. Siendo as&iacute; los valores adeudados corresponden a {$d.tipo_mora} de {$meses_mora_desde} / {$meses_mora_hasta}.</p>
					<p align="justify">Le recordamos que si realiza el pago en la Inmobiliaria antes del d&iacute;a {$fecha_texto}, no se generaran gastos de gesti&oacute;n de cobro por parte de la afianzadora. Por lo anterior, si supera esta fecha y no se ha realizado el pago, deber&aacute; realizarlo en Fianzacr&eacute;dito Central, con un incremento de gesti&oacute;n de cobro, el cual ser&aacute; informado de nuestra parte dicha obligaci&oacute;n deber&aacute; depositarla en  la CUENTA CORRIENTE 07916120229 BANCOLOMBIA o CUENTA CORRIENTE  322804329 BANCO OCCIDENTE. Una vez efectuado el pago&nbsp; notificar al WhatsApp n&uacute;mero  315 638 88 00 o correo  electr&oacute;nico coordinadorcartera@fianzacredito.com.co.</p>
					<p align="justify">De acuerdo con lo estipulado en la Ley 1266 de 2008 Art. 12 y la cl&aacute;usula de autorizaci&oacute;n del contrato de arrendamiento de la referencia, nos permitimos informarle que en caso de no obtener el pago de las sumas adeudadas, procederemos a efectuar el reporte negativo, tanto al arrendatario como de los deudores solidarios a las centrales de informaci&oacute;n (Datacr&eacute;dito y Cifin) a los veinte (20) d&iacute;as calendarios de emitida esta comunicaci&oacute;n, para evitar lo anterior lo invitamos a ponerse  al d&iacute;a en su (s) obligaci&oacute;n (es).</p>
					<p align="justify">En caso de requerir informaci&oacute;n adicional puede comunicarse en Ibagu&eacute; al tel&eacute;fono 2703560, 2703556 o 315 638 8800, al correo coordinadorcartera@fianzacredito.com.co   o en nuestra oficina ubicada en la {$d.direccion_empresa}. Que con gusto ser&aacute; atendido(a). Si ya se encuentra al d&iacute;a con su obligaci&oacute;n, por favor haga caso omiso de esta comunicaci&oacute;n.<br /><br /><br /></p>
				    Atentamente,<br /><br /><br /><br />
                    <img src="../../../framework/media/images/general/FirmaFianza.png" width="180" height="72"/><br />
                  	DEPARTAMENTO DE CARTERA
                  </div></td>	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td width="300" align="right">Recuerde que el adecuado manejo  de su (s) obligaci&oacute;n (es) es su mejor referencia comercial y financiera.</td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
                <tr>
                    <td style="border-top:#000 2px solid;">&nbsp;</td>
                </tr>    
    <tr>
      <td align="center">
       Ibagu&eacute;, Carrera 5 36-50 Of. 301  * Tels.  (8) 2703560 � 2703556 � 3156388800 <br>
Neiva, Carrera 6 # 6 � 70 oficina 203 Edificio San Pedro * Tels. (8) 8719837 - 3174280082<br>
www.fianzacredito.com.co * info@fianzacredito.com.co
 
      </td>                    
    </tr>
    <tr>
        <td>        
            
        </td>
    </tr>                                    
    <tr>
        <td valign="top">

        </td>
    </tr>    
</table>
</div>
{/if}
{/foreach}
</body>