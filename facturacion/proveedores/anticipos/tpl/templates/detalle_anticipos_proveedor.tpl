{if $sectionOficinasTree neq 1}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        {$JAVASCRIPT}
        {$TABLEGRIDJS}
        {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
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
                        <input type="hidden" name="propio" id="propio" value="{$DATASERVICIO[0].propio}" />                        
                        <input type="hidden" name="numero" id="numero" value="{$REGIS}" />{$REGIS}		   
                    </td>
                     <td>
                       <input type="text" name="consecutivo" id="consecutivo" class="" size="12" value="" readonly="readonly" />
                     </td>
                     <td><input type="text" name="fecha_egreso" id="fecha_egreso" value="{$FECHA}" class="required date" size="14" /></td>
                     <td>
                       <select name="parametros_anticipo_proveedor_id" id="parametros_anticipo_proveedor_id" class="required" >
                         <option value="NULL">(... Seleccione ...)</option>
                         {foreach name=formas_pago from=$TIPOSANTICIPO item=f}
                         <option value="{$f.parametros_anticipo_proveedor_id}" {if $f.parametros_anticipo_proveedor_id eq $a.parametros_anticipo_proveedor_id}selected{/if}>{$f.nombre}</option>
                         {/foreach}
                       </select>			 
                     </td>
                     <td>
                       <select name="forma_pago" id="forma_pago_id" class="required" >
                         <option value="NULL">(... Seleccione ...)</option>
                         {foreach name=formas_pago from=$FORMASPAGO item=f}
                         <option value="{$f.forma_pago_id}" {if $f.forma_pago_id eq $a.forma_pago_id}selected{/if}>{$f.nombre}</option>
                         {/foreach}
                       </select>			 
                     </td>
                     <td>
                        <div id="divCuentaTipoPago"> 
                        {if count($a.cuentas_forma_pago) > 0}
                            <select name="select" id="select"  disabled>
                            <option value="NULL">(... Seleccione ...)</option>
                            {foreach name=cuentas_forma_pago from=$a.cuentas_forma_pago item=c}
                                <option value="{$c.value}" {if $c.value eq $a.cuenta_tipo_pago_id}selected{/if}>{$c.text}</option>
                            {/foreach}			   
                            </select>
                        {else}
                            <select name="select" id="select" disabled>
                            <option value="NULL">(... Seleccione ...)</option>
                            </select>
                        {/if} 
                        </div>
                     </td>
     
                     
                     <td>
                        <input type="hidden" name="proveedor_id" id="proveedor_id" value="{$DATASERVICIO[0].proveedor_id}"  />
                        <input readonly name="nombre" id="nombre" value="{$DATASERVICIO[0].nombre}" size="28">
                        

                     </td>
                     
                    
                     <td><input type="text" class="required numeric" name="valor" id="valor" value="" /></td>
                     <td>
                       <input type="text" name="numero_soporte" id="numero_soporte" value="" />
                       <input type="hidden" name="proveedor_id" id="proveedor_id" value="{$DATASERVICIO[0].proveedor_id}" />                        

                       <input type="hidden" name="placa" id="placa" value="{$DATASERVICIO[0].placa}" />
                     </td>
                     <td>
                       <input type="text" name="observaciones" id="observaciones" value="" size="28" maxlength="90"  />
                     </td>
                     
                     <td><input type="checkbox" name="generarAnticipoPlaca"  /></td>
                     <td><input type="checkbox" name="ver"  disabled /></td>
                     <td><input type="checkbox" name="anular" disabled /></td>		   
					<td><input type="checkbox" name="eliminar" disabled /></td>		                        
                </tr>	     
	   
	   			{if count($ANTICIPOS) > 0}
		 			{foreach name=anticipos from=$ANTICIPOS item=a}
		   				<tr class="rowAnticipo" align="center">
			 				<td>
                                <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="{$a.encabezado_registro_id}" />		 
                                <input type="hidden" name="anticipos_proveedor_id" id="anticipos_proveedor_id" value="{$a.anticipos_proveedor_id}" />
                                <input type="hidden" name="numero" id="numero" value="{$a.numero}" />{$a.numero}			   
			   			 	</td>
                             <td>
                               <input type="text"  name="consecutivo" id="consecutivo" value="{$a.consecutivo}" {if $a.estado eq 'A'}style="color:#F00;"{/if}  size="12" readonly />
                             </td>
   			 				 <td ><input type="text" name="fecha" id="fecha" value="{$a.fecha}" class="date" size="14" readonly /></td>
                             
                              <td>
                       <select name="parametros_anticipo_proveedor_id" id="parametros_anticipo_proveedor_id" class="required" >
                         <option value="NULL">(... Seleccione ...)</option>
                         {foreach name=formas_pago from=$TIPOSANTICIPO item=f}
                         <option value="{$f.parametros_anticipo_proveedor_id}" {if $f.parametros_anticipo_proveedor_id eq $a.parametros_anticipo_proveedor_id}selected{/if}>{$f.nombre}</option>
                         {/foreach}
                       </select>			 
                     </td>
                     <td>
                               <select name="forma_pago" id="forma_pago_id" {if is_numeric($a.encabezado_registro_id) }disabled{/if}>
                                 <option value="NULL">(... Seleccione ...)</option>
                                 {foreach name=formas_pago from=$FORMASPAGO item=f}
                                 <option value="{$f.forma_pago_id}" {if $f.forma_pago_id eq $a.forma_pago_id}selected{/if}>{$f.nombre}</option>
                                 {/foreach}
                               </select>			 
                             </td>
			 				 <td>
                             	<div id="divCuentaTipoPago"> 
                                {if count($a.cuentas_forma_pago) > 0}
                                    <select name="select" id="select" disabled>
                                    <option value="NULL">(... Seleccione ...)</option>
                                    {foreach name=cuentas_forma_pago from=$a.cuentas_forma_pago item=c}
                                        <option value="{$c.value}" {if $c.value eq $a.cuenta_tipo_pago_id}selected{/if}>{$c.text}</option>
                                    {/foreach}			   
                                    </select>
			   					{else}
                                    <select name="select" id="select" disabled>
                                    <option value="NULL">(... Seleccione ...)</option>
                                    </select>
		     					{/if} 
                                </div>
                             </td>
                             <td>
                             	 <input type="hidden" name="proveedor_id" id="proveedor_id" value="{$a.proveedor_id}"  />
	                             <input type="text" name="proveedor_id" id="proveedor" value="{$a.proveedor}" size="28" readonly />
                             </td>

                           
                             <td><input type="text" name="valor" id="valor" value="{$a.valor}" class="numeric" readonly /></td>
                             <td>
                               <input type="text" name="numero_soporte" id="numero_soporte" value="{$a.numero_soporte}" />
                               <input type="hidden" name="proveedor_id" id="proveedor_id" value="{$a.proveedor_id}" />                        
                               
                             </td>
                             <td>
                               <input type="text" name="observaciones" id="observaciones" value="{$a.observaciones}" size="28" maxlength="90"  readonly />
                             </td>
                             
			 				 <td><input type="checkbox" name="generarAnticipoPlaca" {if is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
			 				 <td><input type="checkbox" name="ver" title="ver" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
			 				 <td><input type="checkbox" name="anular" title="anular"  {if not is_numeric($a.encabezado_registro_id) or $a.estado eq 'A'  }disabled{/if} /></td>		   
			 				 <td><input type="checkbox" name="eliminar" title="eliminar"   /></td>		                                
						</tr>	     
					{/foreach}
	   			{/if}
                
	   			</tbody>
	 		</table>
		</div>
	</body>
</html>

{/if}
