
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <link rel="stylesheet" type="text/css" href="../../../framework/bootstrap-4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css" />
</head>
<body>	
<div style="padding-right: 2px; padding-left: 5px; padding-top: 5px;">
	{if $DATOSORDENFACTURA.estado eq 'I'}
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
    {/if}    

                <table cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td align="center">
                                <table>
                                   <tr>
                                        <td align="center"  width="300">
                                        <img src="{$PARAMETROS.logo}" width="120" height="90" />
                                        </td>
                                        <td width="300">
                                            <table style="border-collapse: collapse;" border="1" align="right">
                                                <tr>
                                                    {if $DATOSORDENFACTURA.fac_electronica eq 1}
                                                        <td align="center" class="cabeceras"><span><b>FACTURA ELECTR&Oacute;NICA<br>DE VENTA</b></span></td>
                                                    {else}
                                                        <td align="center" class="cabeceras"><span><b>FACTURA DE VENTA</b></span></td>
                                                    {/if}
                                                    
                                                    <td align="center"><span align="center"  style="font-size:18px;">{$DATOSORDENFACTURA.prefijo}{$DATOSORDENFACTURA.consecutivo_factura}</span></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" class="cabeceras1"><span><b>FECHA</b></span></td>
                                                    <td align="center" ><span class="content">&nbsp;{$DATOSORDENFACTURA.fecha|wordwrap:11:"<br />\n"}</span></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" class="cabeceras1"><span><b>VENCIMIENTO</b></span></td>
                                                    <td align="center" ><span class="content">&nbsp;{$DATOSORDENFACTURA.vencimiento}</span></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" class="cabeceras1"><span><b>FORMA DE PAGO</b></span></td>
                                                    <td align="center" ><span class="content">&nbsp;{$DATOSORDENFACTURA.forma_compra_venta}</span></td>
                                                </tr>   
                                            </table>
                                        </td>
                                        {if $DATOSORDENFACTURA.fac_electronica eq 1}
                                            <td  width="155" align="right">
                                            <img src="{$CODIGOQR}" width="125" height="125" />
                                                {if $DATOSORDENFACTURA.cufe eq ''}
                                                    <div class="dian">SIN APROBACION DIAN</div>
                                                {/if}
                                            </td>
                                        {/if}
                                    </tr>
                                    <tr>
                                        <td colspan="1" style="font-family: Arial, Helvetica, sans-serif;">
                                            {$PARAMETROS.observacion_encabezado|wordwrap:72:"<br />\n"}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
            
                        <tr>
                        <td><br></td>
                        </tr>

                        <tr>
                            <td style="text-align: center;">
                                <span style="font-size:10px;">{if $DATOSORDENFACTURA.tipo eq 1} Resoluci&oacute;n {else} Habilitaci&oacute;n {/if} Facturaci&oacute;n {if $DATOSORDENFACTURA.fac_electronica eq 1} Electr&oacute;nica {/if} DIAN {$DATOSORDENFACTURA.resolucion_dian}</span>
                                <span style="font-size:10px;">{$DATOSORDENFACTURA.rangos_factura}</span>
                            </td>
                        </tr>

                </table>
                <br>

            <table  border="1">
                <tr>
                    <td style="width: 49%;" class="cabeceras1">Datos del Emisor</td>
                    <td style="width: 49%;" class="cabeceras1">Adquiriente</td>
                </tr>
          
                <tr>
                    <td class="cabeceras2" style="width: 49%;">
                        <span style="font-weight: bold;">Razon social / Nombre: </span>{$DATOSORDENFACTURA.razon_social_emp}
                        <br />
                        <span style="font-weight: bold;">Nit / Numero identificacion: </span> {$DATOSORDENFACTURA.numero_identificacion_emp}
                        <br />
                        <span style="font-weight: bold;">Direccion: </span> {$DATOSORDENFACTURA.dir_oficina}&nbsp;-&nbsp;{$DATOSORDENFACTURA.ciudad_ofi}
                        <br />
                        <span style="font-weight: bold;">Telefono: </span> {$DATOSORDENFACTURA.tel_oficina}
                        <br />
                        <span style="font-weight: bold;">Correo: </span> {$DATOSORDENFACTURA.email_oficina}
                    </td>
                    <td class="cabeceras2" style="width: 49%;">
                        <span style="font-weight: bold;">Razon social / Nombre: </span>{$DATOSORDENFACTURA.primer_nombre} {$DATOSORDENFACTURA.segundo_nombre} {$DATOSORDENFACTURA.primer_apellido} {$DATOSORDENFACTURA.segundo_apellido} {$DATOSORDENFACTURA.razon_social}
                        <br />
                        <span style="font-weight: bold;">Nit / Numero identificacion: </span> {$DATOSORDENFACTURA.numero_identificacion} {if $DATOSORDENFACTURA.digito_verificacion neq ''}-{/if} {$DATOSORDENFACTURA.digito_verificacion}
                        <br />
                        <span style="font-weight: bold;">Direccion: </span> {$DATOSORDENFACTURA.direccion}&nbsp;-&nbsp;{$DATOSORDENFACTURA.ciudad}
                        <br />
                        <span style="font-weight: bold;">Telefono: </span> {$DATOSORDENFACTURA.telefono}
                        <br />
                        <span style="font-weight: bold;">Correo: </span> {$DATOSORDENFACTURA.email}
                    </td>
                </tr>
           
            </table>
            
            <br><br>

            <table cellspacing="0" cellpadding="0" border="0" style="width: 98%; padding-left:5px; padding-right:5px;"> 
                <tr>
                    <td height="120" class="fontBig" style="font-family: Arial, Helvetica, sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <p>Por concepto de : {$DATOSORDENFACTURA.observacion}</p>

                        {if $PARAMETROS.detalles_visibles eq 1}
                        <p>Seg&uacute;n relaci&oacute;n anexa</p>
                        {/if}
                        
                    </td>
                </tr>
            </table>

            {assign var="acumula_item" value="0"}
            <table cellspacing="0" cellpadding="0" border="1" width="98%">
            <br><br>
           
            {foreach name=puc_ordenfactura from=$PUC_ORDENFACTURA item=i}
            
                {if $i.tercero_bien_servicio_factura eq '0' and $i.ret_tercero_bien_servicio_factura eq '0' and $i.aplica_ingreso eq '0'}
                    <tr>
                        <td style="width:59%; font-family: Arial, Helvetica, sans-serif;">{if $acumula_item eq '0'}SON: {$VALORLETRAS} Pesos M/Cte{/if}&nbsp;</td>
                        {if $PARAMETROS.impuestos_visibles eq 1 || $PARAMETROS.impuestos_visibles eq 0 && $i.despuc_bien_servicio_factura eq 'TOTAL' || $PARAMETROS.impuestos_visibles eq 0 && $i.despuc_bien_servicio_factura eq 'SUBTOTAL' || $PARAMETROS.impuestos_visibles eq 0 && $i.despuc_bien_servicio_factura eq 'A COBRAR' }
                        <td  style="width:29%; text-align:right; font-family: Arial, Helvetica, sans-serif;" align="right">{$i.despuc_bien_servicio_factura}&nbsp;&nbsp;</td>
                        {/if}

                        {if $i.contra_bien_servicio_factura eq '0' and $i.natu_bien_servicio_factura eq 'D'}
                            {if $PARAMETROS.impuestos_visibles eq 1}
                            <td style="width:10%; font-family: Arial, Helvetica, sans-serif;">
                               {if $i.valor_liquida gt 0}{$i.valor_liquida|number_format:0:',':'.'}{else}{$i.valor|number_format:0:',':'.'}{/if}
                            </td>
                            {/if}
                        {else}
                            <td style="width:10%; font-family: Arial, Helvetica, sans-serif;">
                               {if $i.valor_liquida gt 0}{$i.valor_liquida|number_format:0:',':'.'}{else}{$i.valor|number_format:0:',':'.'}{/if}
                               
                            </td>
                        {/if}
                    </tr>
                {/if}
            
                {math assign="acumula_item" equation="x + y" x=$acumula_item y=1}
            
            {/foreach}
            <br><br>
            </table>
            
            <table border="0" cellspacing="0" cellpadding="0">
            
                <tr>
                    <td style="width: 98%;" class="cabeceras1">Observaciones:</td>
                </tr>
            
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
            
            <table style="padding-top:30px; padding-left:70px; padding-right:60px;" border="0" cellspacing="0" cellpadding="0">
                <tr>
                
                    <td> <br><br><br> </td>
                
                </tr>
            
                <tr>
                
                    <td>  ____________________________________  </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>  ____________________________________  </td>
                
                
                </tr>
            
                <tr>
                
                    <td style="font-family: Arial, Helvetica, sans-serif;">   FIRMA AUTORIZADA  </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="font-family: Arial, Helvetica, sans-serif;">   FIRMA Y SELLO ACEPTACION  </td>
                
                </tr>

                <tr>
                
                <td> <br><br><br> </td>
                
                </tr>
            
            </table>

            <table style="padding-top:30px; padding-left:40px; padding-right:40px;"">
                <tr>
                    <td>
                        <span class="fontsmall" style="text-align: center;">ES UNA FACTURA DE VENTA que para todos
                        sus efectos se asimila a una letra de cambio segun
                        los articulos 621, 773, 774 del Codigo de Comercio.
                        <br>Si la misma no se paga en la fecha de su vencimiento
                        se cobrara el interes corriente vigente.</span><br>
                    </td>
                </tr>
            </table>

            <div align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:10px;">
            <br>
            {$PARAMETROS.pie_pagina}
            {if $DATOSORDENFACTURA.fac_electronica eq 1}
                <br>
                <b>CUFE</b> : {$DATOSORDENFACTURA.cufe}
            {/if}
            </div>
            <br><br>
            <div align="left" style="font-family: Arial, Helvetica, sans-serif;">Elaborado Por : {$DATOSORDENFACTURA.elaborado}</div>

{if $PARAMETROS.detalles_visibles eq 1}
{if $DETALLES[0].fuente neq ''}

<page orientation="portrait" style="page-break-before:always;" >
       <table style="margin-left:15px; margin-top:30px;"   width="100%" border="0">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <table  border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="350" align="center" valign="top"><img src="{$PARAMETROS.logo}" width="120" height="90" /></td>
                        <td width="400" align="center"><span class="fontgrande">{$DATOSORDENFACTURA.razon_social_emp}</span><br /> <span class="fontsmall">{$DATOSORDENFACTURA.tipo_identificacion_emp} {$DATOSORDENFACTURA.numero_identificacion_emp}  </span></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><strong>ANEXO FACTURA DE VENTA No {$DATOSORDENFACTURA.consecutivo_factura}</strong></td></tr>
        </table>
        <div style="padding-left:5px">
         <table border="1" style="width:98%">
            
                <tr>
                    <td class="cabeceras"  colspan="1" style="width:9%"><b>CONCEPTO</b></td>
                    <td class="cabeceras1" colspan="18" style="width:89%"><span>{$DATOSORDENFACTURA.observacion|wordwrap:65:"<br />\n"}</span></td>
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
                                       <td style="width:auto" class="cabeceras" colspan="1"><span class="fontsmall_detalle"><b>ORDEN</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.fecha_orden eq 1}
                                       <td style="width:auto" class="cabeceras" colspan="1"><span class="fontsmall_detalle"><b>FECHA</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.descripcion_orden eq 1}
                                       <td style="width:auto" class="cabeceras" colspan="1"><span class="fontsmall_detalle"><b>DESCRIPCION</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.cantidad eq 1}
                                       <td style="width:auto" class="cabeceras" colspan="1"><span class="fontsmall_detalle"><b>CANTIDAD</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.valor_unitario eq 1}
                                       <td style="width:auto" class="cabeceras" colspan="1"><span class="fontsmall_detalle"><b>V/UNITARIO</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.valor_total eq 1}
                                       <td style="width:auto" class="cabeceras" {if $remesas > 0} colspan="15"{else} colspan="1" {/if}><span class="fontsmall_detalle"><b>V/TOTAL</b></span></td>
                                    {/if}  
                                </tr>
                                 {assign var="acumula_reme" value="0"}
                                 {foreach name=itemordenfactura from=$ITEMORDENFACTURA item=i} 
                                    {if $i.fuente neq 'Remesa'}   
                                        <tr> 
                                        {if $PARAMETROS.orden eq 1}
                                           <td style="width:auto" colspan="1"><span class="fontsmall_detalle">{$i.num_doc}</span></td>
                                        {/if}
                                        {if $PARAMETROS.fecha_orden eq 1}
                                           <td style="width:auto" colspan="1"><span class="fontsmall_detalle">{$i.fecha_doc}</span></td>
                                        {/if}
                                        {if $PARAMETROS.descripcion_orden eq 1}
                                           <td style="width:auto" colspan="1"><span class="fontsmall_detalle">{$i.descripcion}</span></td>
                                        {/if}
                                        {if $PARAMETROS.cantidad eq 1}
                                            <td style="width:auto" colspan="1"><span class="fontsmall_detalle">{$i.cantidades|number_format:0:',':'.'}&nbsp;</span></td>
                                        {/if} 
                                        {if $PARAMETROS.valor_unitario eq 1}
                                            <td style="width:auto" colspan="1"><span class="fontsmall_detalle">{$i.valor_unitario|number_format:0:',':'.'}</span></td>
                                        {/if}
                                        {if $PARAMETROS.valor_total eq 1}
                                        <td style="width:auto" {if $remesas > 0} colspan="15"{else} colspan="1" {/if}><span class="fontsmall_detalle">{$i.valor|number_format:0:',':'.'}</span></td>
                                        {/if}
                                        </tr>

                                          {math assign="acumula_reme" equation="x + y" x=$acumula_reme y=1}
         	
                                    {/if}
                                 {/foreach}
                                
                                <tr style="border-top:#000 solid 1px;">
                                    <td colspan="17" align="right">&nbsp;TOTAL ORDENES {$acumula_reme} &nbsp;</td>
                                </tr>
                                 {/if}

                                
                                {if $remesas > 0}
                                <tr align="center">
                                    {if $PARAMETROS.remesa eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>REMESA</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.fecha_remesa eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>FECHA</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.descripcion_remesa eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>DESCRIPCION</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.peso eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>PESO</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.placa eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>PLACA</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.origen eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>ORIGEN</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.pasador_vial eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>PASADOR VIAL</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.destino eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>DESTINO</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.doc_cliente eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>DOC CLIENTE</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.manifiesto eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>MANIFIESTO</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.valor_tonelada eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>V/TONELADA</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.descripcion_producto eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>DESC PRODUCTO</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.valor_declarado eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>V/DECLARADO</b></span></td>
                                    {/if}
                                     {if $PARAMETROS.cantidad_cargada eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>CANTIDAD</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.cantidad_producto eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>CANTIDAD</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.valor_unitario_remesa eq 1}
                                      <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>V/UNITARIO</b></span></td>
                                    {/if}
                                    {if $PARAMETROS.valor_total eq 1}
                                    <td style="width:auto" class="cabeceras"><span class="fontsmall_detalle"><b>V/TOTAL</b></span></td>
                                    {/if}
                                </tr>
                                 {assign var="acumula_reme" value="0"}
                                 {foreach name=itemordenfactura from=$ITEMORDENFACTURA item=i} 
                                    {if $i.fuente eq 'Remesa'}   
                                        <tr> 
                                        {if $PARAMETROS.remesa eq 1}
                                          <td style="width:auto" ><span class="fontsmall_detalle">{$i.no_remesa}</span></td>
                                        {/if}
                                        {if $PARAMETROS.fecha_remesa eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.fecha_doc}</span></td>
                                        {/if}
                                        {if $PARAMETROS.descripcion_remesa eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">Servicio de Transporte <br>Remesa No.&nbsp;{$i.no_remesa}</span></td>
                                        {/if}
                                        {if $PARAMETROS.peso eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.peso}</span></td>
                                        {/if}
                                        {if $PARAMETROS.placa eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.placa}</span></td>
                                        {/if}
                                        {if $PARAMETROS.origen eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.origen}</span></td>
                                        {/if}
                                        {if $PARAMETROS.pasador_vial eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.pasador_vial}</span></td>
                                        {/if}
                                        {if $PARAMETROS.destino eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.destino}</span></td>
                                        {/if}
                                        {if $PARAMETROS.doc_cliente eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.documento_cliente|wordwrap:20:"<br />\n"}</span></td>
                                        {/if}
                                        {if $PARAMETROS.manifiesto eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.manifiesto}</span></td>
                                        {/if}

                                        {if $PARAMETROS.valor_tonelada eq 1}
                                            <td style="width:auto"><span class="fontsmall_detalle">{if $i.tipo_liquidacion eq 'P'}{$i.valor_tonelada}{else}N/A{/if}</span></td>
                                        {/if}  
                                        {if $PARAMETROS.descripcion_producto eq 1}
                                           <td style="width:auto"><span class="fontsmall_detalle">{$i.descripcion_producto|wordwrap:20:"<br />\n"}</span></td>
                                        {/if}
                                        {if $PARAMETROS.valor_declarado eq 1}
                                           <td style="width:auto"><span class="fontsmall_detalle">{$i.valor_declarado}</span></td>
                                        {/if}
                                        {if $PARAMETROS.cantidad_cargada eq 1}
                                          <td style="width:auto"><span class="fontsmall_detalle">{$i.cantidad_cargada|number_format:0:',':'.'}&nbsp;</span></td>
                                        {/if}
                                        {if $PARAMETROS.cantidad_producto eq 1}
                                         <td style="width:auto"><span class="fontsmall_detalle">{$i.cantidades|number_format:0:',':'.'}&nbsp;</span></td>
                                        {/if} 

                                        {if $PARAMETROS.valor_unitario_remesa eq 1 && $i.fuente eq 'Remesa'}
                                            {if ($PARAMETROS.cantidad_cargada eq 1 || $PARAMETROS.peso eq 1)}
                                            <td class="auto">{$i.valor_unitario_total|number_format:0:',':'.'}</td>
                                            {else}
                                            <td class="auto">{$i.valor_unitario|number_format:0:',':'.'}</td>
                                            {/if}
                                        {/if}

                                         {if $PARAMETROS.valor_total eq 1}
                                            <td style="width:auto" ><span class="fontsmall_detalle">{$i.valor|number_format:0:',':'.'}</span></td>
                                        {/if}  

                                        </tr>

                                          {math assign="acumula_reme" equation="x + y" x=$acumula_reme y=1}
        
                                    {/if}
                                 {/foreach}
                                <tr style="border-top:#000 solid 1px;">
                                    <td colspan="17" align="right">&nbsp;TOTAL REMESAS {$acumula_reme} &nbsp;</td>
                                </tr>
                                {/if}         
                
        </table>
        </div>

    <table style="margin-top:30px; padding-left: 5px;" border="1" >
        <tr>
            <td style="width:50% font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>Son:</strong></td>
            <td style="width:50% font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>Obs:</strong></td>
        </tr>
        <tr>
            <td style="width:50% font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>{$VALORLETRAS1}</strong></td>
            <td style="width:50% font-size:10px; font-family: Arial, Helvetica, sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>        
	</table>

    <table style="margin-top:30px; padding-left: 5px;" border="0">
        <tr>
            <td style="width:50% font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>Elaboro:</strong></td>
            <td style="width:50% font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>{$DATOSORDENFACTURA.elaborado}</strong></td>
       </tr>
	</table>
    
    <table style="margin-top:20px; padding-left: 5px;" border="0">
        <tr>
           <td style="font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>Aprobo:</strong></td>
           <td style="font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>___________________________</strong></td>
           <td style="font-size:10px; font-family: Arial, Helvetica, sans-serif;"><strong>Recibio:</strong></td>
           <td><strong>___________________________</strong></td>
        </tr>
	</table>
	
</page>
{/if}
{/if}            
</div>
</body>