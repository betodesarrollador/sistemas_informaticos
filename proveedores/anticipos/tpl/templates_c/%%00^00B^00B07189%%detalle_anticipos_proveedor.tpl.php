<?php /* Smarty version 2.6.30, created on 2022-02-17 09:40:58
         compiled from detalle_anticipos_proveedor.tpl */ ?>
<?php if ($this->_tpl_vars['sectionOficinasTree'] != 1): ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <?php echo $this->_tpl_vars['JAVASCRIPT']; ?>

        <?php echo $this->_tpl_vars['TABLEGRIDJS']; ?>

        <?php echo $this->_tpl_vars['CSSSYSTEM']; ?>
  <?php echo $this->_tpl_vars['TABLEGRIDCSS']; ?>
  <?php echo $this->_tpl_vars['TITLETAB']; ?>
 
    </head>

	<body>

   		<div align="center">
     		<table align="center" width="100%">
	  			<thead>
	   				<tr>
	     				<th>NUMERO</th>
                        <th>CONSECUTIVO</th>
		 				<th>FECHA EGRESO </th>
                        <th>TIPO ANTICIPO</th>
		 				<th>FORMA PAGO</th>
		 				<th>CUENTA</th>
		   				<th>PROVEEDOR</th>
		   				<th>VALOR</th>
		 				<th>N. SOPORTE </th>
                        <th>OBSERVACION</th>
		 				<th>GENERAR</th>
		 				<th>VER</th>		 
		 				<th>ANULAR</th>	
		 				<th>ELIMINAR</th>	                        	
					</tr>
	   			</thead>
	   			<tbody>
                <tr class="rowAnticipo" align="center">
                    <td>
                        <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="" />		 
                        <input type="hidden" name="anticipos_proveedor_id" id="anticipos_proveedor_id" value="" />
                        <input type="hidden" name="propio" id="propio" value="<?php echo $this->_tpl_vars['DATASERVICIO'][0]['propio']; ?>
" />                        
                        <input type="hidden" name="numero" id="numero" value="<?php echo $this->_tpl_vars['REGIS']; ?>
" /><?php echo $this->_tpl_vars['REGIS']; ?>
		   
                    </td>
                     <td>
                       <input type="text" name="consecutivo" id="consecutivo" class="" size="12" value="" readonly="readonly" />
                     </td>
                     <td><input type="text" name="fecha_egreso" id="fecha_egreso" value="<?php echo $this->_tpl_vars['FECHA']; ?>
" class="required date" size="14" /></td>
                     <td>
                       <select name="parametros_anticipo_proveedor_id" id="parametros_anticipo_proveedor_id" class="required" >
                         <option value="NULL">(... Seleccione ...)</option>
                         <?php $_from = $this->_tpl_vars['TIPOSANTICIPO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['formas_pago'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['formas_pago']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['f']):
        $this->_foreach['formas_pago']['iteration']++;
?>
                         <option value="<?php echo $this->_tpl_vars['f']['parametros_anticipo_proveedor_id']; ?>
" <?php if ($this->_tpl_vars['f']['parametros_anticipo_proveedor_id'] == $this->_tpl_vars['a']['parametros_anticipo_proveedor_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['f']['nombre']; ?>
</option>
                         <?php endforeach; endif; unset($_from); ?>
                       </select>			 
                     </td>
                     <td>
                       <select name="forma_pago" id="forma_pago_id" class="required" >
                         <option value="NULL">(... Seleccione ...)</option>
                         <?php $_from = $this->_tpl_vars['FORMASPAGO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['formas_pago'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['formas_pago']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['f']):
        $this->_foreach['formas_pago']['iteration']++;
?>
                         <option value="<?php echo $this->_tpl_vars['f']['forma_pago_id']; ?>
" <?php if ($this->_tpl_vars['f']['forma_pago_id'] == $this->_tpl_vars['a']['forma_pago_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['f']['nombre']; ?>
</option>
                         <?php endforeach; endif; unset($_from); ?>
                       </select>			 
                     </td>
                     <td>
                        <div id="divCuentaTipoPago"> 
                        <?php if (count ( $this->_tpl_vars['a']['cuentas_forma_pago'] ) > 0): ?>
                            <select name="select" id="select"  disabled>
                            <option value="NULL">(... Seleccione ...)</option>
                            <?php $_from = $this->_tpl_vars['a']['cuentas_forma_pago']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cuentas_forma_pago'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cuentas_forma_pago']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['c']):
        $this->_foreach['cuentas_forma_pago']['iteration']++;
?>
                                <option value="<?php echo $this->_tpl_vars['c']['value']; ?>
" <?php if ($this->_tpl_vars['c']['value'] == $this->_tpl_vars['a']['cuenta_tipo_pago_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['c']['text']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>			   
                            </select>
                        <?php else: ?>
                            <select name="select" id="select" disabled>
                            <option value="NULL">(... Seleccione ...)</option>
                            </select>
                        <?php endif; ?> 
                        </div>
                     </td>
     
                     
                     <td>
                        <input type="hidden" name="proveedor_id" id="proveedor_id" value="<?php echo $this->_tpl_vars['DATASERVICIO'][0]['proveedor_id']; ?>
"  />
                        <input readonly name="nombre" id="nombre" value="<?php echo $this->_tpl_vars['DATASERVICIO'][0]['nombre']; ?>
" size="28">
                        

                     </td>
                     
                    
                     <td><input type="text" class="required numeric" name="valor" id="valor" value="" /></td>
                     <td>
                       <input type="text" name="numero_soporte" id="numero_soporte" value="" />
                       <input type="hidden" name="proveedor_id" id="proveedor_id" value="<?php echo $this->_tpl_vars['DATASERVICIO'][0]['proveedor_id']; ?>
" />                        

                       <input type="hidden" name="placa" id="placa" value="<?php echo $this->_tpl_vars['DATASERVICIO'][0]['placa']; ?>
" />
                     </td>
                     <td>
                       <input type="text" name="observaciones" id="observaciones" value="" size="28" maxlength="90"  />
                     </td>
                     
                     <td><input type="checkbox" name="generarAnticipoPlaca"  /></td>
                     <td><input type="checkbox" name="ver"  disabled /></td>
                     <td><input type="checkbox" name="anular" disabled /></td>		   
					<td><input type="checkbox" name="eliminar" disabled /></td>		                        
                </tr>	     
	   
	   			<?php if (count ( $this->_tpl_vars['ANTICIPOS'] ) > 0): ?>
		 			<?php $_from = $this->_tpl_vars['ANTICIPOS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['anticipos'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['anticipos']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['a']):
        $this->_foreach['anticipos']['iteration']++;
?>
		   				<tr class="rowAnticipo" align="center">
			 				<td>
                                <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="<?php echo $this->_tpl_vars['a']['encabezado_registro_id']; ?>
" />		 
                                <input type="hidden" name="anticipos_proveedor_id" id="anticipos_proveedor_id" value="<?php echo $this->_tpl_vars['a']['anticipos_proveedor_id']; ?>
" />
                                <input type="hidden" name="numero" id="numero" value="<?php echo $this->_tpl_vars['a']['numero']; ?>
" /><?php echo $this->_tpl_vars['a']['numero']; ?>
			   
			   			 	</td>
                             <td>
                               <input type="text"  name="consecutivo" id="consecutivo" value="<?php echo $this->_tpl_vars['a']['consecutivo']; ?>
" <?php if ($this->_tpl_vars['a']['estado'] == 'A'): ?>style="color:#F00;"<?php endif; ?>  size="12" readonly />
                             </td>
   			 				 <td ><input type="text" name="fecha" id="fecha" value="<?php echo $this->_tpl_vars['a']['fecha']; ?>
" class="date" size="14" readonly /></td>
                             
                              <td>
                       <select name="parametros_anticipo_proveedor_id" id="parametros_anticipo_proveedor_id" class="required" >
                         <option value="NULL">(... Seleccione ...)</option>
                         <?php $_from = $this->_tpl_vars['TIPOSANTICIPO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['formas_pago'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['formas_pago']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['f']):
        $this->_foreach['formas_pago']['iteration']++;
?>
                         <option value="<?php echo $this->_tpl_vars['f']['parametros_anticipo_proveedor_id']; ?>
" <?php if ($this->_tpl_vars['f']['parametros_anticipo_proveedor_id'] == $this->_tpl_vars['a']['parametros_anticipo_proveedor_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['f']['nombre']; ?>
</option>
                         <?php endforeach; endif; unset($_from); ?>
                       </select>			 
                     </td>
                     <td>
                               <select name="forma_pago" id="forma_pago_id" <?php if (is_numeric ( $this->_tpl_vars['a']['encabezado_registro_id'] )): ?>disabled<?php endif; ?>>
                                 <option value="NULL">(... Seleccione ...)</option>
                                 <?php $_from = $this->_tpl_vars['FORMASPAGO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['formas_pago'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['formas_pago']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['f']):
        $this->_foreach['formas_pago']['iteration']++;
?>
                                 <option value="<?php echo $this->_tpl_vars['f']['forma_pago_id']; ?>
" <?php if ($this->_tpl_vars['f']['forma_pago_id'] == $this->_tpl_vars['a']['forma_pago_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['f']['nombre']; ?>
</option>
                                 <?php endforeach; endif; unset($_from); ?>
                               </select>			 
                             </td>
			 				 <td>
                             	<div id="divCuentaTipoPago"> 
                                <?php if (count ( $this->_tpl_vars['a']['cuentas_forma_pago'] ) > 0): ?>
                                    <select name="select" id="select" disabled>
                                    <option value="NULL">(... Seleccione ...)</option>
                                    <?php $_from = $this->_tpl_vars['a']['cuentas_forma_pago']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cuentas_forma_pago'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cuentas_forma_pago']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['c']):
        $this->_foreach['cuentas_forma_pago']['iteration']++;
?>
                                        <option value="<?php echo $this->_tpl_vars['c']['value']; ?>
" <?php if ($this->_tpl_vars['c']['value'] == $this->_tpl_vars['a']['cuenta_tipo_pago_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['c']['text']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>			   
                                    </select>
			   					<?php else: ?>
                                    <select name="select" id="select" disabled>
                                    <option value="NULL">(... Seleccione ...)</option>
                                    </select>
		     					<?php endif; ?> 
                                </div>
                             </td>
                             <td>
                             	 <input type="hidden" name="proveedor_id" id="proveedor_id" value="<?php echo $this->_tpl_vars['a']['proveedor_id']; ?>
"  />
	                             <input type="text" name="proveedor_id" id="proveedor" value="<?php echo $this->_tpl_vars['a']['proveedor']; ?>
" size="28" readonly />
                             </td>

                           
                             <td><input type="text" name="valor" id="valor" value="<?php echo $this->_tpl_vars['a']['valor']; ?>
" class="numeric" readonly /></td>
                             <td>
                               <input type="text" name="numero_soporte" id="numero_soporte" value="<?php echo $this->_tpl_vars['a']['numero_soporte']; ?>
" />
                               <input type="hidden" name="proveedor_id" id="proveedor_id" value="<?php echo $this->_tpl_vars['a']['proveedor_id']; ?>
" />                        
                               
                             </td>
                             <td>
                               <input type="text" name="observaciones" id="observaciones" value="<?php echo $this->_tpl_vars['a']['observaciones']; ?>
" size="28" maxlength="90"  readonly />
                             </td>
                             
			 				 <td><input type="checkbox" name="generarAnticipoPlaca" <?php if (is_numeric ( $this->_tpl_vars['a']['encabezado_registro_id'] )): ?>disabled<?php endif; ?> /></td>
			 				 <td><input type="checkbox" name="ver" title="ver" <?php if (! is_numeric ( $this->_tpl_vars['a']['encabezado_registro_id'] )): ?>disabled<?php endif; ?> /></td>
			 				 <td><input type="checkbox" name="anular" title="anular"  <?php if (! is_numeric ( $this->_tpl_vars['a']['encabezado_registro_id'] ) || $this->_tpl_vars['a']['estado'] == 'A'): ?>disabled<?php endif; ?> /></td>		   
			 				 <td><input type="checkbox" name="eliminar" title="eliminar"   /></td>		                                
						</tr>	     
					<?php endforeach; endif; unset($_from); ?>
	   			<?php endif; ?>
                
	   			</tbody>
	 		</table>
		</div>
	</body>
</html>

<?php endif; ?>