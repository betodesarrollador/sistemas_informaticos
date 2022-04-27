{if $sectionOficinasTree neq 1}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}  
    {$TABLEGRIDCSS}  
    {$TITLETAB} 
</head>

<body>
    <div align="center">
        <table align="center" width="100%">
            <thead>
                <tr>
                    <th>N&Uacute;MERO</th>
                    <th>CONSECUTIVO</th>
                    <th>FECHA EGRESO </th>
                    <th>FORMA PAGO</th>
                    <th>CUENTA</th>
                    <th>TIPO DOC </th>
                    <th>TENEDOR</th>
                    <th>CONDUCTOR</th>
                    <th>ANT. A CONDUC</th>                    
                    <th>VALOR</th>
                    <th>N. SOPORTE </th>
                    <th>OBSERVACI&Oacute;N</th>
                    <th>GENERAR</th>
                    <th>VER</th>		 
                    <th>ANULAR</th>	
                    <!--<th>ELIMINAR</th>-->	                        	
                </tr>
            </thead>
            <tbody>
            <tr class="rowAnticipo" align="center">
                <td>
                    <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="" />		 
                    <input type="hidden" name="anticipos_placa_id" id="anticipos_placa_id" value="" />
                    <input type="hidden" name="propio" id="propio" value="{$DATASERVICIO[0].propio}" />                        
                    <input type="hidden" name="numero" id="numero" value="{$REGIS}" />{$REGIS}		   
                </td>
                 <td>
                   <input type="text" name="consecutivo" id="consecutivo" class="" readonly size="12" value=""  />
                 </td>
                 <td><input type="text" name="fecha_egreso" id="fecha_egreso" value="{$smarty.now|date_format:"%Y-%m-%d"}" class="required date" size="14" /></td>
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
                   <select name="tipo_doc" id="tipo_doc" >
                     <option value="NULL">(... Seleccione ...)</option>
                     {foreach name=tipo_doc from=$TIPODOC item=f}
                     <option value="{$f.tipo_documento_id}" >{$f.nombre}</option>
                     {/foreach}
                   </select>			 
                 </td>
                 {if $DATASERVICIO[0].propio eq 1}
                 <td>&nbsp;</td>
                 <td>
                    <input type="hidden" name="conductor_id" id="conductor_id" value="{$DATASERVICIO[0].conductor_id}"  />
                    <input type="hidden" readonly name="nombre" id="nombre" value="{$DATASERVICIO[0].nombre}" size="28">
                    <input type="hidden" name="tenedor_id" id="tenedor_id" value="{$DATASERVICIO[0].tenedor_id}"  />
                    <input type="hidden" readonly name="tenedor" id="tenedor" value="{$DATASERVICIO[0].tenedor}" size="28">

                 </td>
                 
                 {else}
                 <td>
                    <input type="hidden" name="conductor_id" id="conductor_id" value="{$DATASERVICIO[0].conductor_id}"  />
                    <input type="hidden" readonly name="nombre" id="nombre" value="{$DATASERVICIO[0].nombre}" size="28">
                    <input type="hidden" name="tenedor_id" id="tenedor_id" value="{$DATASERVICIO[0].tenedor_id}"  />
                    <input type="hidden" readonly name="tenedor" id="tenedor" value="{$DATASERVICIO[0].tenedor}" size="28">
                 </td>
                 <td>&nbsp;</td>
                 {/if}
				 <td><input type="checkbox" name="a_conductor" id="a_conductor" value="" {if is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
                 <td><input type="text" class="required numeric" name="valor" id="valor" value="" /></td>
                 <td>
                   <input type="text" name="numero_soporte" id="numero_soporte" value="" />
                   <input type="hidden" name="placa_id" id="placa_id" value="{$DATASERVICIO[0].placa_id}" />                        

                   <input type="hidden" name="placa" id="placa" value="{$DATASERVICIO[0].placa}" />
                 </td>
                 <td>
                   <input type="text" name="observaciones" id="observaciones" value="" size="28" maxlength="90"  />
                 </td>
                 
                 <td><input type="checkbox" name="generarAnticipoPlaca"  /></td>
                 <td><input type="checkbox" name="ver"  disabled /></td>
                 <td><input type="checkbox" name="anular" disabled /></td>		   
                <!--<td><input type="checkbox" name="eliminar" disabled /></td>	-->	                        
            </tr>	     
   
            {if count($ANTICIPOS) > 0}
                {foreach name=anticipos from=$ANTICIPOS item=a}
                    <tr class="rowAnticipo" align="center">
                        <td>
                            <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="{$a.encabezado_registro_id}" />		 
                            <input type="hidden" name="anticipos_placa_id" id="anticipos_placa_id" value="{$a.anticipos_placa_id}" />
                            <input type="hidden" name="numero" id="numero" value="{$a.numero}" />{$a.numero}			   
                        </td>
                         <td>
                           <input type="text"  name="consecutivo" id="consecutivo" value="{$a.consecutivo}" {if $a.estado eq 'A'}style="color:#F00;"{/if}  size="12" readonly />
                         </td>
                         <td ><input type="text" name="fecha" id="fecha" value="{$a.fecha}" class="date" size="14" readonly /></td>
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
                           <select name="tipo_doc" id="tipo_doc" {if is_numeric($a.encabezado_registro_id) }disabled{/if}>
                             <option value="NULL">(... Seleccione ...)</option>
                             {foreach name=tipo_doc from=$TIPODOC item=f}
                             <option value="{$f.tipo_documento_id}" {if $f.tipo_documento_id eq $a.tipo_docu}selected{/if}>{$f.nombre}</option>
                             {/foreach}
                           </select>			 
                         </td>
                         <td>
                             <input type="hidden" name="tenedor_id" id="tenedor_id" value="{$a.tenedor_id}"  />
                             <input type="text" name="tenedor_id" id="tenedor" value="{$a.tenedor}" size="28" readonly />
                         </td>

                         <td>
                             <input type="hidden" name="conductor_id" id="conductor_id" value="{$a.conductor_id}"  />
                             <input type="text" readonly name="nombre" id="nombre" value="{$a.conductor}" size="28">   
                          </td>
						 <td><input type="checkbox" name="a_conductor" id="a_conductor" value="{$a.a_conductor}" {if is_numeric($a.encabezado_registro_id) }disabled{/if}  /></td>                          
                         <td><input type="text" name="valor" id="valor" value="{$a.valor}" class="numeric" readonly /></td>
                         <td>
                           <input type="text" name="numero_soporte" id="numero_soporte" value="{$a.numero_soporte}" />
                           <input type="hidden" name="placa_id" id="placa_id" value="{$a.placa_id}" />                        
                           
                         </td>
                         <td>
                           <input type="text" name="observaciones" id="observaciones" value="{$a.observaciones}" size="28" maxlength="90"  readonly />
                         </td>
                         
                         <td><input type="checkbox" name="generarAnticipoPlaca" {if is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
                         <td><input type="checkbox" name="ver" title="ver" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
                         <td><input type="checkbox" name="anular" title="anular"  {if not is_numeric($a.encabezado_registro_id) or $a.estado eq 'A'  }disabled{/if} /></td>		   
                         <!--<td><input type="checkbox" name="eliminar" title="eliminar"   /></td>-->		                                
                    </tr>	     
                {/foreach}
            {/if}
            
            </tbody>
        </table>
    </div>
</body>
</html>

{/if}
