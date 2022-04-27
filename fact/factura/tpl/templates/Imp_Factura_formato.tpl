<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <link rel="stylesheet" href="../../../framework/bootstrap-4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>	
<page orientation="portrait" >
	{if $DATOSORDENFACTURA.estado eq 'I'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
    {/if}    
	{if $DATOSORDENFACTURA.estado eq 'C'}
        <div class="realizado">CONTABILIZADA</div>
        <div class="realizado1">CONTABILIZADA</div>
    {/if}    

	<table style="margin-left:45px; margin-top:5px;"   cellpadding="0" cellspacing="0">
    	<tr>
      		<td align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            					      <tr>
                                	<td width="50%" align="center">
                                    <img src="{$PARAMETROS.logo}" width="180  " height="100" /><br><br>
                                    {$PARAMETROS.observacion_encabezado}
                                  </td>
                                  <td class="auto" align="left">
                                      <table class="table table-bordered" align="center" width="100%">
                                            <tr>
                                             {if $DATOSORDENFACTURA.fac_electronica eq 1}
                                                <td align="center" class="cabeceras" colspan="2"><span><b>FACTURA ELECTR&Oacute;NICA DE VENTA</b></span></td>
                                             {else}
                                              <td align="center" class="cabeceras" colspan="2"><span><b>FACTURA DE VENTA</b></span></td>
                                             {/if}
                                                <td align="center"  ><span align="center" class="content" style="font-size:18px;">{$DATOSORDENFACTURA.prefijo}{$DATOSORDENFACTURA.consecutivo_factura}</span></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="cabeceras1" colspan="2" ><span><b>FECHA</b></span></td>
                                                <td align="center" ><span class="content">&nbsp;{$DATOSORDENFACTURA.fecha}</span></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="cabeceras1" colspan="2" ><span><b>VENCIMIENTO</b></span></td>
                                                <td align="center" ><span class="content">&nbsp;{$DATOSORDENFACTURA.vencimiento}</span></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="cabeceras1" colspan="2" ><span><b>FORMA DE PAGO</b></span></td>
                                                <td align="center" colspan="2"><span class="content">&nbsp;{$DATOSORDENFACTURA.forma_compra_venta}</span></td>
                                            </tr>   
                                      </table>
                                    </td>
                                    {if $DATOSORDENFACTURA.fac_electronica eq 1}
                                    <td width="20%" style="text-align: center;">
                                       <img src="{$CODIGOQR}" width="135" height="135" />
                                       {if $DATOSORDENFACTURA.cufe eq ''}
                                            <div class="dian">SIN APROBACION DIAN</div>
                                        {/if} 
                                    </td>
                                    {/if}
                               </tr>
                                <tr>
                                   <td style="text-align: center;" colspan="3">
                                     <span class="fontsmall">{if $DATOSORDENFACTURA.tipo eq 1} Resoluci&oacute;n {else} Habilitaci&oacute;n {/if} Facturaci&oacute;n {if $DATOSORDENFACTURA.fac_electronica eq 1} Electr&oacute;nica {/if} DIAN {$DATOSORDENFACTURA.resolucion_dian}</span>
                                     <span class="fontsmall">{$DATOSORDENFACTURA.rangos_factura}</span>
                                   </td>
                                </tr>
          					</table>
            	      
							      <table class="table table-bordered" cellspacing="0" width="100%" cellpadding="0">
                              <thead class="table-secondary">
                                        <th class="cabeceras1">Datos del Emisor</th>
                                        <th class="cabeceras1">Adquiriente</th>
                              </thead>
                              <tbody>
                                    <tr>
      									                  	<td  align="left" valign="top" width="50%">
                                                <span class="content">Razon social / Nombre: </span>{$DATOSORDENFACTURA.razon_social_emp}
                                                <br /> 
                                                <span class="content">Nit / Numero identificacion: </span> {$DATOSORDENFACTURA.numero_identificacion_emp}
                                                <br />
                                                <span class="content">Direccion: </span> {$DATOSORDENFACTURA.dir_oficina}&nbsp;-&nbsp;{$DATOSORDENFACTURA.ciudad_ofi}
                                                <br />
                                                <span class="content">Telefono: </span> {$DATOSORDENFACTURA.tel_oficina}
                                                <br />
                                                <span class="content">Correo: </span> {$DATOSORDENFACTURA.email_oficina}
                                            </td> 
                                            <td  align="left" valign="top" width="50%">
                                                <span class="content">Razon social / Nombre: </span>{$DATOSORDENFACTURA.primer_nombre} {$DATOSORDENFACTURA.segundo_nombre} {$DATOSORDENFACTURA.primer_apellido} {$DATOSORDENFACTURA.segundo_apellido} {$DATOSORDENFACTURA.razon_social}
                                                <br /> 
                                                <span class="content">Nit / Numero identificacion: </span> {$DATOSORDENFACTURA.numero_identificacion} {if $DATOSORDENFACTURA.digito_verificacion neq ''}-{/if} {$DATOSORDENFACTURA.digito_verificacion}
                                                <br />
                                                <span class="content">Direccion: </span> {$DATOSORDENFACTURA.direccion}&nbsp;-&nbsp;{$DATOSORDENFACTURA.ciudad}
                                                <br />
                                                <span class="content">Telefono: </span> {$DATOSORDENFACTURA.telefono}
                                                <br />
                                                <span class="content">Correo: </span> {$DATOSORDENFACTURA.email}
                                            </td> 
                                    </tr> 
                                </tbody>                                 
    						    </table>   
                    	  
                  <table class="table" width="100%">
                    
                    {assign var="cantidad_items" value="0"}
                    {math assign="cantidad_items" equation="x + y" x=$DATOSORDENFACTURA.cantidad_remesas y=$DATOSORDENFACTURA.cantidad_ordenes}
                  
                      <tr>
                          <td align="left" valign="top" height="150" colspan="4" class="fontBig">&nbsp;&nbsp;&nbsp;&nbsp;
                            <p>Por concepto de : {$DATOSORDENFACTURA.observacion}</p>

                              {if $PARAMETROS.detalles_visibles eq 1}
                              <p>Seg&uacute;n relaci&oacute;n anexa</p>
                              {/if}

                          </td>
                      </tr>
                      
                 </table>
                   {assign var="acumula_item" value="0"}
                            <table class="table table-bordered" cellspacing="0" cellpadding="0" border="0" width="100%">
                                {foreach name=puc_ordenfactura from=$PUC_ORDENFACTURA item=i}   

                                    {if $i.tercero_bien_servicio_factura eq '0' and $i.ret_tercero_bien_servicio_factura eq '0' and $i.aplica_ingreso eq '0'}              
                                    <tr>    
                                        <td style="border-left:#000 1px solid; width:auto;">{if $acumula_item eq '0'}SON: {$VALORLETRAS} Pesos M/Cte{/if}&nbsp;</td>
                                         {if $PARAMETROS.impuestos_visibles eq 1 || $PARAMETROS.impuestos_visibles eq 0 && $i.despuc_bien_servicio_factura eq 'TOTAL' || $PARAMETROS.impuestos_visibles eq 0 && $i.despuc_bien_servicio_factura eq 'SUBTOTAL' || $PARAMETROS.impuestos_visibles eq 0 && $i.despuc_bien_servicio_factura eq 'A COBRAR' }
                                        <td colspan="2" align="right">{$i.despuc_bien_servicio_factura}&nbsp;&nbsp;</td>
                                        {/if}
                                        {if $i.contra_bien_servicio_factura eq '0' and $i.natu_bien_servicio_factura eq 'D'}
                                            {if $PARAMETROS.impuestos_visibles eq 1}
                                            <td class="cellRightRed">
                                            <div align="right">{if $i.valor_liquida gt 0}{$i.valor_liquida|number_format:0:',':'.'}{else}{$i.valor|number_format:0:',':'.'}{/if}
                                            </div>
                                            </td>
                                            {/if}
                                        {else}
                                            <td class="cellRight">
                                            <div align="right">{if $i.valor_liquida gt 0}{$i.valor_liquida|number_format:0:',':'.'}{else}{$i.valor|number_format:0:',':'.'}{/if}
                                            </div>
                                            </td>
                                        {/if} 
                                    </tr>
                                    {/if}

                                    {math assign="acumula_item" equation="x + y" x=$acumula_item y=1}

                                {/foreach}
                            </table>       
      
                      
                            <table class="table table-bordered" cellspacing="0" width="100%" cellpadding="0">
                                <thead class="table-secondary">
                                    <th class="auto cabeceras1"><div align="left">&nbsp;Observaciones:</div></th>
                                </thead>
                                <tbody>
                                {if $PARAMETROS.observacion_uno eq 1}
                                    <tr>
                                        <td>{$DATOSORDENFACTURA.observacion1}</td>
                                    </tr>
                                {/if}
                                {if $PARAMETROS.observacion_dos eq 1}
                                    <tr>
                                        <td>{$DATOSORDENFACTURA.observacion2}</td>
                                    </tr>
                                {/if}
                                   <tr>
                                        <td>{$DATOSORDENFACTURA.observacion_factura}</td>
                                   </tr>
                                
                            </table>

                            <table class="table table-bordered" cellspacing="0" width="100%" cellpadding="0">
                                <tr>
                                    <td width="15%" valign="bottom" align="center"><br><br>
                                        ____________________________________
                                        FIRMA AUTORIZADA 
                                        
                                    
                                    </td>
                                    <td width="15%" valign="bottom" align="center"><br><br>
                                        ____________________________________ 
                                        FIRMA Y SELLO ACEPTACION
                                    
                                    </td>
                                    <td width="65%" valign="top">
                                        <span class="fontsmall">ESTA ES UNA FACTURA DE VENTA que para todos
                                        sus efectos se asimila a una letra de cambio segun
                                        los articulos 621, 773, 774 del Codigo de Comercio.
                                        Si la misma no se paga en la fecha de su vencimiento
                                        se cobrara el interes corriente vigente. </span>                       
                                    </td> 
                                </tr>
                            </table>
		   	          
                  <div align="center">
                                {$PARAMETROS.pie_pagina}
                                {if $DATOSORDENFACTURA.fac_electronica eq 1}
                                <br>
                                <b>CUFE</b> : {$DATOSORDENFACTURA.cufe}
                                {/if}
                            </div>
                <div align="left">Elaborado Por : {$DATOSORDENFACTURA.elaborado}</div>
            </td>
        </tr>
	</table>  
</page>
{if $PARAMETROS.detalles_visibles eq 1}
{if $DETALLES[0].fuente neq ''}

<page orientation="portrait" style="display: block; page-break-before: always !important; position: relative;" >
    <table style="margin-left:15px; margin-top:30px;"   width="100%" border="0">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <table  border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="350" align="center" valign="top"><img src="{$PARAMETROS.logo}" width="120" height="90" /></td>
                        <td width="600" valign="top" align="center"><span class="fontgrande">{$DATOSORDENFACTURA.razon_social_emp}</span><br /> <span class="fontsmall">{$DATOSORDENFACTURA.tipo_identificacion_emp} {$DATOSORDENFACTURA.numero_identificacion_emp}  </span></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><strong>ANEXO FACTURA DE VENTA No {$DATOSORDENFACTURA.consecutivo_factura}</strong></td></tr>
        
	</table><br />
     
	<table class="table table-bordered table-striped"width="100%" border="1"   cellpadding="0" cellspacing="0">
	
            <tr>
                <td class="cabeceras" colspan="2"><b>CONCEPTO</b></td>
                <td colspan="18" class="cabeceras1"><span class="content">{$DATOSORDENFACTURA.observacion}</span></td>
            </tr>
    {assign var="remesas" value="0"}
                                 {assign var="ordenes" value="0"}

                                 {foreach name=itemordenfactura from=$ITEMORDENFACTURA item=i} 
                                    {if $i.remesa_id > 0}
                                        {assign var="remesas" value="1"}
                                    {/if}

                                    {if $i.orden_servicio_id > 0}
                                        {assign var="ordenes" value="1"}
                                    {/if}

                                     {if $i.orden_servicio_id eq '' && $i.remesa_id eq ''}
                                        {assign var="ordenes" value="1"}
                                    {/if}
                                    
                                 {/foreach}

                                {if $ordenes > 0}
                                <tr align="center">
                                    {if $PARAMETROS.orden eq 1}
                                       <td class="cabeceras" colspan="1"><b>ORDEN</b></td>
                                    {/if}
                                    {if $PARAMETROS.fecha_orden eq 1}
                                       <td class="cabeceras" colspan="1"><b>FECHA</b></td>
                                    {/if}
                                    {if $PARAMETROS.descripcion_orden eq 1}
                                       <td class="cabeceras" colspan="1"><b>DESCRIPCION</b></td>
                                    {/if}
                                    {if $PARAMETROS.cantidad eq 1}
                                       <td class="cabeceras" colspan="1"><b>CANTIDAD</b></td>
                                    {/if}
                                    {if $PARAMETROS.valor_unitario eq 1}
                                       <td class="cabeceras" colspan="1"><b>V/UNITARIO</b></td>
                                    {/if}
                                    {if $PARAMETROS.valor_total eq 1}
                                       <td class="cabeceras" colspan="100%"><b>V/TOTAL</b></td>
                                    {/if}  
                                </tr>
                                 {assign var="acumula_reme" value="0"}
                                 {foreach name=itemordenfactura from=$ITEMORDENFACTURA item=i} 
                                    {if $i.fuente neq 'Remesa'}   
                                        <tr> 
                                        {if $PARAMETROS.orden eq 1}
                                           <td class="auto" colspan="1">{$i.num_doc}</td>
                                        {/if}
                                        {if $PARAMETROS.fecha_orden eq 1}
                                           <td class="auto" colspan="1">{$i.fecha_doc}</td>
                                        {/if}
                                        {if $PARAMETROS.descripcion_orden eq 1}
                                           <td class="auto" colspan="1">{$i.descripcion}</td>
                                        {/if}
                                        {if $PARAMETROS.cantidad eq 1}
                                            <td class="auto" colspan="1">{$i.cantidades|number_format:0:',':'.'}&nbsp;</td>
                                        {/if} 
                                        {if $PARAMETROS.valor_unitario eq 1}
                                            <td class="auto" colspan="1">{$i.valor_unitario|number_format:0:',':'.'}</td>
                                        {/if}
                                        {if $PARAMETROS.valor_total eq 1}
                                        <td class="auto" colspan="100%"><div align="right">{$i.valor|number_format:0:',':'.'}</div></td>
                                        {/if}
                                        </tr>

                                          {math assign="acumula_reme" equation="x + y" x=$acumula_reme y=1}
         	
                                    {/if}
                                 {/foreach}
                                <tr style="border-top:#000 solid 1px;">
                                    <td colspan="12" align="right">&nbsp;TOTAL ORDENES {$acumula_reme} &nbsp;</td>
                                </tr>
                                 {/if}

                                
                                {if $remesas > 0}
                                <tr align="center">
                                    {if $PARAMETROS.remesa eq 1}
                                      <td class="cabeceras"><b>REMESA</b></td>
                                    {/if}
                                    {if $PARAMETROS.fecha_remesa eq 1}
                                      <td class="cabeceras"><b>FECHA</b></td>
                                    {/if}
                                    {if $PARAMETROS.descripcion_remesa eq 1}
                                      <td class="cabeceras"><b>DESCRIPCION</b></td>
                                    {/if}
                                    {if $PARAMETROS.peso eq 1}
                                      <td class="cabeceras"><b>PESO</b></td>
                                    {/if}
                                    {if $PARAMETROS.placa eq 1}
                                      <td class="cabeceras"><b>PLACA</b></td>
                                    {/if}
                                    {if $PARAMETROS.origen eq 1}
                                      <td class="cabeceras"><b>ORIGEN</b></td>
                                    {/if}
                                    {if $PARAMETROS.pasador_vial eq 1}
                                      <td class="cabeceras"><b>PASADOR VIAL</b></td>
                                    {/if}
                                    {if $PARAMETROS.destino eq 1}
                                      <td class="cabeceras"><b>DESTINO</b></td>
                                    {/if}
                                    {if $PARAMETROS.doc_cliente eq 1}
                                      <td class="cabeceras"><b>DOC CLIENTE</b></td>
                                    {/if}
                                    {if $PARAMETROS.manifiesto eq 1}
                                      <td class="cabeceras"><b>MANIFIESTO</b></td>
                                    {/if}
                                    {if $PARAMETROS.valor_tonelada eq 1}
                                      <td class="cabeceras"><b>V/TONELADA</b></td>
                                    {/if}
                                    {if $PARAMETROS.descripcion_producto eq 1}
                                      <td class="cabeceras"><b>DESC PRODUCTO</b></td>
                                    {/if}
                                    {if $PARAMETROS.valor_declarado eq 1}
                                      <td class="cabeceras"><b>V/DECLARADO</b></td>
                                    {/if}
                                     {if $PARAMETROS.cantidad_cargada eq 1}
                                      <td class="cabeceras"><b>CANTIDAD</b></td>
                                    {/if}
                                    {if $PARAMETROS.cantidad_producto eq 1}
                                      <td class="cabeceras"><b>CANTIDAD</b></td>
                                    {/if}
                                    {if $PARAMETROS.valor_unitario_remesa eq 1}
                                      <td class="cabeceras"><b>V/UNITARIO</b></td>
                                    {/if}
                                    {if $PARAMETROS.valor_total eq 1}
                                    <td class="cabeceras"><b>V/TOTAL</b></td>
                                    {/if}
                                </tr>
                                 {assign var="acumula_reme" value="0"}
                                 {foreach name=itemordenfactura from=$ITEMORDENFACTURA item=i} 
                                    {if $i.fuente eq 'Remesa'}   
                                        <tr> 
                                        {if $PARAMETROS.remesa eq 1}
                                          <td class="auto" >{$i.no_remesa}</td>
                                        {/if}
                                        {if $PARAMETROS.fecha_remesa eq 1}
                                          <td class="auto">{$i.fecha_doc}</td>
                                        {/if}
                                        {if $PARAMETROS.descripcion_remesa eq 1}
                                          <td class="auto">Servicio de Transporte&nbsp;-&nbsp;Remesa No.&nbsp;{$i.no_remesa}</td>
                                        {/if}
                                        {if $PARAMETROS.peso eq 1}
                                          <td class="auto">{$i.peso}</td>
                                        {/if}
                                        {if $PARAMETROS.placa eq 1}
                                          <td class="auto">{$i.placa}</td>
                                        {/if}
                                        {if $PARAMETROS.origen eq 1}
                                          <td class="auto">{$i.origen}</td>
                                        {/if}
                                        {if $PARAMETROS.pasador_vial eq 1}
                                          <td class="auto">{$i.pasador_vial}</td>
                                        {/if}
                                        {if $PARAMETROS.destino eq 1}
                                          <td class="auto">{$i.destino}</td>
                                        {/if}
                                        {if $PARAMETROS.doc_cliente eq 1}
                                          <td class="auto">{$i.documento_cliente}</td>
                                        {/if}
                                        {if $PARAMETROS.manifiesto eq 1}
                                          <td class="auto">{$i.manifiesto}</td>
                                        {/if}

                                        {if $PARAMETROS.valor_tonelada eq 1}
                                            <td class="auto">{if $i.tipo_liquidacion eq 'P'}{$i.valor_tonelada}{else}N/A{/if}</td>
                                        {/if}  
                                        {if $PARAMETROS.descripcion_producto eq 1}
                                           <td class="auto">{$i.descripcion_producto}</td>
                                        {/if}
                                        {if $PARAMETROS.valor_declarado eq 1}
                                           <td class="auto">{$i.valor_declarado}</td>
                                        {/if}
                                        {if $PARAMETROS.cantidad_cargada eq 1}
                                          <td class="auto">{$i.cantidad_cargada|number_format:0:',':'.'}&nbsp;</td>
                                        {/if}
                                        {if $PARAMETROS.cantidad_producto eq 1}
                                         <td class="auto">{$i.cantidades|number_format:0:',':'.'}&nbsp;</td>
                                        {/if} 

                                        {if $PARAMETROS.valor_unitario_remesa eq 1 && $i.fuente eq 'Remesa'}
                                            {if ($PARAMETROS.cantidad_cargada eq 1 || $PARAMETROS.peso eq 1)}
                                            <td class="auto">{$i.valor_unitario_total|number_format:0:',':'.'}</td>
                                            {else}
                                            <td class="auto">{$i.valor_unitario|number_format:0:',':'.'}</td>
                                            {/if}
                                        {/if}

                                         {if $PARAMETROS.valor_total eq 1}
                                            <td class="auto" ><div align="right">{$i.valor|number_format:0:',':'.'}</div></td>
                                        {/if}  

                                        </tr>

                                          {math assign="acumula_reme" equation="x + y" x=$acumula_reme y=1}
        
                                    {/if}
                                 {/foreach}
                                    <tr style="border-top:#000 solid 1px;">
                                        <td colspan="12" align="right">&nbsp;TOTAL REMESAS {$acumula_reme} &nbsp;</td>
                                    </tr>
                                {/if}         
    </table>

    <table class="table table-bordered"  style="margin-top:30px;"   width="100%" border="1" cellspacing="0">
        <tr><td width="50%"><strong>Son:</strong></td><td width="50%"><strong>Obs:</strong></td></tr>
        <tr><td ><strong>{$VALORLETRAS1}</strong></td><td >&nbsp;</td></tr>        
	</table>

    <table  class="table table-bordered" style="margin-top:30px;"   width="100%" border="0">
        <tr><td><strong>Elaboro:</strong></td><td><strong>{$DATOSORDENFACTURA.elaborado}</strong></td></tr>
	</table>
    
    <table class="table table-bordered"  style="margin-top:20px;"   width="100%" border="0">
        <tr><td><strong>Aprobo:</strong></td><td><strong>___________________________</strong></td><td><strong>Recibio:</strong></td><td><strong>___________________________</strong></td></tr>
	</table>
    
    
</page>
{/if}
{/if}
</body>
