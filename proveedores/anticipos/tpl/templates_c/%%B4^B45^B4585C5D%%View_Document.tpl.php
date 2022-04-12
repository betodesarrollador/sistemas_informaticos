<?php /* Smarty version 2.6.30, created on 2022-02-17 09:40:58
         compiled from View_Document.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'View_Document.tpl', 282, false),)), $this); ?>
<?php echo '
<style>
/* CSS Document */

   .tipoDocumento{
    font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	font-weight:bold;
	text-align:center
   }
   
   .numeroDocumento{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:18px;
	 font-weight:bold;
	 text-align:center;
   }
   
   .subtitulos{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
	 font-weight:bold;
   }
   
   .contenido{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
   }

   .borderTop{
     border-top:1px solid;
   }

   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#EAEAEA;
	 font-weight:bold;
	 text-align:center;
   }
   
   .fontBig{
     font-size:10px;
   }
   
   .infoGeneral{
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
	 text-align:center;
   }
   
   .cellTitle{
     background-color:#E6E6E6;
	 font-weight:bold;
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
   }
   
   .cellRight{
     border-right:1px solid;
	 border-bottom:1px solid;
 	 padding: 3px;
	 
   }
   .cellRightRed{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;	
 	 padding: 3px;
	 color:#F00;
	 
   }
   
   .cellLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 padding: 3px;
   }

   .cellCenter{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
   }

   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
     background-color:#E6E6E6;
	 font-weight:bold;
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 border-top:1px solid;	 
     background-color:#E6E6E6;
	 font-weight:bold;
   }
   
   body{
    padding:0px;
   }
   
   .content{
    font-weight:bold;
	font-size:12px;
	text-transform:uppercase;
   }

   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:1px;
   }

   .anulado{
	   width:500px;
	   margin-top:180px;
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
	   margin-top:400px;
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
	   margin-top:180px;
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
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .normal{
	   height:30px;
   }

</style>
'; ?>

	
<page orientation="portrait" >
	<?php if ($this->_tpl_vars['DATOSENCABEZADO']['estado_orden_compra'] == 'I'): ?>
        <div class="anulado">ANULADO</div>
        <div class="anulado1">ANULADO</div>
    <?php endif; ?>    
	<?php if ($this->_tpl_vars['DATOSENCABEZADO']['estado_orden_compra'] == 'L'): ?>
        <div class="realizado">LIQUIDADO</div>
        <div class="realizado1">LIQUIDADO</div>
    <?php endif; ?>    
    <div align="center">
	<table style="margin-left:15px; margin-top:30px;"  cellpadding="0" cellspacing="0" width="90%">
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
             						<td width="256" align="left" valign="top">
									    <img src="<?php echo $this->_tpl_vars['DATOSENCABEZADO']['logo']; ?>
" width="160" height="42" />									</td>
              						<td width="541" valign="top" align="center">
                                    	<strong>&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['razon_social_emp']; ?>
</strong><br />
                                        AGENCIA &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['nom_oficina']; ?>
<br />
                                        &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['tipo_identificacion_emp']; ?>
: &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['numero_identificacion_emp']; ?>

                                  </td>
           						  <td width="400" valign="top" align="right">
			  							<table cellspacing="0" cellpadding="0" align="right" width="100%">
                  							<tr >
                    							<td class="cellLeft borderTop tipoDocumento" width="200"><?php echo $this->_tpl_vars['DATOSENCABEZADO']['tipo_documento']; ?>
</td>
                  							    <td class="cellRight borderTop numeroDocumento" width="100"><?php echo $this->_tpl_vars['DATOSENCABEZADO']['consecutivo']; ?>
</td>
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
        			<tr>
          				<td>
							<table  border="0" width="100%" cellpadding="0" cellspacing="0">
  								<tr>
    								<td valign="top">
                                    	<table cellspacing="0" cellpadding="0" width="100%">
      										<tr>
                                                <td  class="cellLeft borderTop subtitulos">Fecha:</td>
                                                <td class="cellRight borderTop contenido">&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['fecha']; ?>
</td>
                                                <td class="cellRight borderTop subtitulos">Ciudad:</td>
                                                <td colspan="2" class="cellRight borderTop contenido">&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['ciudad_ofi']; ?>
</td>
                                          	</tr>
                                            
      										<tr>
                                                <td class="cellLeft subtitulos"><?php echo $this->_tpl_vars['DATOSENCABEZADO']['texto_tercero']; ?>
</td>
                                                <td class="cellRight contenido">&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['primer_nombre']; ?>
 &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['segundo_nombre']; ?>
 &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['primer_apellido']; ?>
 &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['segundo_apellido']; ?>
 &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['razon_social']; ?>
</td>
                                                <td class="cellRight subtitulos"><?php echo $this->_tpl_vars['DATOSENCABEZADO']['tipo_identificacion']; ?>
</td>
                                                <td class="cellRight contenido" colspan="2">&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['numero_identificacion']; ?>
 <?php if ($this->_tpl_vars['DATOSENCABEZADO']['digito_verificacion'] != ''): ?>-<?php endif; ?> &nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['digito_verificacion']; ?>
</td>
                                          	</tr>
                                            <tr>
                                                <td class="cellLeft subtitulos">Concepto</td>
                                                <td class="cellRight contenido" colspan="4">&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['concepto']; ?>
</td>
                                            </tr>
      										<tr>
                                                <td class="cellLeft subtitulos">Forma de Pago</td>
                                                <td colspan="2" class="cellRight contenido">&nbsp;<?php if (strlen ( trim ( $this->_tpl_vars['DATOSENCABEZADO']['formapago'] ) ) > 0): ?><?php echo $this->_tpl_vars['DATOSENCABEZADO']['formapago']; ?>
<?php else: ?>NINGUNA<?php endif; ?></td>
                                                <td class="cellRight subtitulos"><?php echo $this->_tpl_vars['DATOSENCABEZADO']['texto_soporte']; ?>
</td>
                                                <td class="cellRight contenido">&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['numero_soporte']; ?>
</td>
                                          	</tr>
                                            <tr>
                                                <td class="cellLeft subtitulos">Observaciones</td>
                                                <td colspan="4" class="cellRight contenido">&nbsp;<?php echo $this->_tpl_vars['DATOSENCABEZADO']['observaciones']; ?>
<?php echo $this->_tpl_vars['DATOSENCABEZADO']['observaciones1']; ?>
</td>
                                          	</tr>
   									  </table>                              		</td>
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
    	<tr>
      		<td>
				<table cellspacing="0" cellpadding="0" width="100%" border="0">
                
                    <tr align="center" >
                        <td  width="120"  class="cellTitleLeft" >CODIGO</td>
                        <td  width="117" class="cellTitleRight">TERCERO</td>
                        <td  width="30" class="cellTitleRight">CC</td>
                        <td  width="210" class="cellTitleRight">DETALLE</td>
                        <td  width="130" class="cellTitleRight">DEBITO</td>
                        <td  width="130" class="cellTitleRight">CREDITO</td>                        
                    </tr>
                    <?php $_from = $this->_tpl_vars['IMPUTACIONES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['imputaciones'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['imputaciones']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i']):
        $this->_foreach['imputaciones']['iteration']++;
?>                    
                    <tr>    
                        <td class="cellLeft contenido">&nbsp;<?php echo $this->_tpl_vars['i']['puc_cod']; ?>
</td>
                        <td class="cellRight contenido">&nbsp;<?php echo $this->_tpl_vars['i']['numero_identificacion']; ?>
</td>
                        <td class="cellRight contenido">&nbsp;<?php echo $this->_tpl_vars['i']['codigo_centro_costo']; ?>
</td>
                        <td class="cellRight contenido">&nbsp;<?php echo $this->_tpl_vars['i']['descripcion']; ?>
</td>
                        <td class="cellRight contenido">&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['i']['debito'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
                        <td class="cellRight contenido">&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['i']['credito'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>                                                
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
					<tr><td colspan="4">&nbsp;</td></tr>
                    <tr>    
                        <td class="cellTitleLeft" colspan="4" align="center"><b>SUMAS IGUALES</b></td>
                        <td class="cellRight borderTop">&nbsp;<b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL']['total_debito'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</b></td>
                        <td class="cellRight borderTop">&nbsp;<b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL']['total_credito'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</b></td>                                                
                    </tr>
				</table>
			</td>                    
		</tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>    
        
        <tr>
        	<td>
            	<table cellspacing="0" class="table_firmas" cellpadding="0" width="100%" border="0">
                	<tr>
                    	<td colspan="5" class="normal cellLeft cellRight borderTop" valign="top" align="center">
						  Valor en Letras: &nbsp;<?php echo $this->_tpl_vars['TOTALES']; ?>
 Pesos M/CTE
						</td>
                    </tr>
                	<tr>
                    	<td width="120" valign="bottom" align="center" class="cellLeft">
						  <?php echo $this->_tpl_vars['DATOSENCABEZADO']['modifica']; ?>
<br /><br />
						  Elabor&oacute;
						</td>
                        <td width="120" valign="bottom" align="center" class="cellRight">Revis&oacute;</td>
                        <td width="120" valign="bottom" align="center" class="cellRight">Aprob&oacute;</td>
                    	<td width="200" valign="bottom" class="cellRight">
                        	Recib&iacute;
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            C.C. / NIT
                        </td>
                        <td width="160" height="80" valign="bottom" class="cellRight" align="center">Huella</td>
                        
                    </tr>

                </table>
            </td>
        </tr>    
	</table>                   
	</div>
</page>