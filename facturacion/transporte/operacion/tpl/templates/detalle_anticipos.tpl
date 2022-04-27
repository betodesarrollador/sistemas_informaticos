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
		 {if $DATASERVICIO[0].propio}

		   <th>CONDUCTOR</th>
		 {else}
		   <th>TENEDOR</th>
		 {/if}
         <th>ANT. A CONDUC</th>                    
		 <th>VALOR</th>
		 <th>FECHA {if count($ANTICIPOS) > 0}MC{else}DU{/if}</th>
		 <th>FORMA PAGO</th>
		 <th>CUENTA</th>
         <th>TERCERO</th>
		 <th>N. SOPORTE </th>
		 <th>TIPO DESCUENTO</th>
		 <th>VLR DESCUENTO</th>
		 <th>FECHA EGRESO </th>
		 <th>GENERAR</th>
		 <th>VER</th>		 
		 <th>ANULAR</th>
       </tr>
	   </thead>
	   
	   <tbody>
	   
	   {if count($ANTICIPOS) > 0}
		 {foreach name=anticipos from=$ANTICIPOS item=a}
		   <tr class="rowAnticipo" align="center">
			 <td>
			   <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="{$a.encabezado_registro_id}" />		 
			   <input type="hidden" name="anticipos_manifiesto_id" id="anticipos_manifiesto_id" value="{$a.anticipos_manifiesto_id}" />
			   <input type="hidden" name="numero" id="numero" value="{$a.numero}" />			   
			   {$a.numero}			 </td>
             <td>
               <input type="text"  name="consecutivo" id="consecutivo" value="{$a.consecutivo}" readonly {if $a.estado eq 'A'} disabled style="color:#F00;"{/if}  size="12"  />
             </td>
			 
			 {if $DATASERVICIO[0].propio eq 1}
			   <td><input type="hidden" name="conductor" id="conductor_id" value="{$a.conductor_id}"  />{$a.conductor}</td>
			 {else}
			   <td><input type="hidden" name="tenedor" id="tenedor_id" value="{$a.tenedor_id}"  />{$a.tenedor}</td>
			 {/if}
			 <td><input type="checkbox" name="a_conductor" id="a_conductor" value="" {if is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>             
			 <td><input type="hidden" name="valor" id="valor" value="{$a.valor}" />{$a.valor}</td>
			 <td>{$DATASERVICIO[0].fecha}</td>
			 <td>
			   <select name="forma_pago" id="forma_pago_id" {if $a.estado eq 'A'} disabled{/if} {if is_numeric($a.encabezado_registro_id) }disabled{/if}>
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
             	<div id="divTerceroTipoPago"> 
                {if count($a.tercero_forma_pago) > 0}
			   		<select name="select" id="select" disabled>
                    	<option value="NULL">(... Seleccione ...)</option>
				   		{foreach name=tercero_forma_pago from=$a.tercero_forma_pago item=c}
			     			<option value="{$c.value}" {if $c.value eq $a.tercero_contrapartida}selected{/if}>{$c.text}</option>
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
			   <input type="text" name="numero_soporte" id="numero_soporte" value="{$f.numero_soporte}" {if $a.estado eq 'A'} disabled{/if} />
			 </td>



			<td>
				   <select name="tipo_descuento" id="tipo_descuento" {if $a.estado eq 'A'} disabled{/if} {if is_numeric($a.encabezado_registro_id) }disabled{/if}>
					 <option value="NULL">(... Seleccione ...)</option>
					 {foreach name=tipo_descuento from=$TIPODESCUENTO item=t}
					 <option value="{$t.value}" {if $t.value eq $a.tipo_descuento_id}selected{/if}>{$t.text}</option>
					 {/foreach}
				   </select>
			</td>
			<td>
			   <input type="text" name="valor_descuento" id="valor_descuento" value="{$a.valor_descuento}" {if $a.estado eq 'A'} disabled{/if}/>
			</td>



			
			 <td id="fecha_egreso">{$a.fecha_egreso}</td>
			 <td><input type="checkbox" name="generarAnticipoManifiesto" {if is_numeric($a.encabezado_registro_id) }disabled{/if} {if $a.estado eq 'A'} disabled{/if}/></td>
			 <td><input type="checkbox" name="ver" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
			 <td><input type="checkbox" name="anular" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} {if $a.estado eq 'A'} disabled{/if}/></td>
			 </tr>	     
		 {/foreach}
	   {/if}
	   
	   {if count($ANTICIPOSDESPACHO) > 0}
	   
		 {foreach name=anticipos from=$ANTICIPOSDESPACHO item=a}
		   <tr class="rowAnticipo">
			 <td align="center">
			   <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="{$a.encabezado_registro_id}" />		 
			   <input type="hidden" name="anticipos_despacho_id" id="anticipos_despacho_id" value="{$a.anticipos_despacho_id}" />
			   <input type="hidden" name="numero" id="numero" value="{$a.numero}" />			   			   
			   {$a.numero}			 
              </td>
              
               <td>
               <input type="text"  name="consecutivo" id="consecutivo" value="{$a.consecutivo}" readonly {if $a.estado eq 'A'} disabled style="color:#F00;"{/if}  size="12"  />
             </td>
			 
 			  {if $DATASERVICIO[0].propio eq 1}
			  	<td><input type="hidden" name="conductor" id="conductor_id" value="{$a.conductor_id}"  />{$a.conductor}</td>
			  {else}
			   	<td><input type="hidden" name="tenedor" id="tenedor_id" value="{$a.tenedor_id}"  />{$a.tenedor}</td>
              {/if}
			  <td><input type="checkbox" name="a_conductor" id="a_conductor" value="" {if is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>              
			  <td><input type="hidden" name="valor" id="valor" value="{$a.valor}" />{$a.valor}</td>
			  <td>{$DATASERVICIO[0].fecha}</td>
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
			    	<select name="cuenta_tipo_pago" id="cuenta_tipo_pago" disabled>
                    	<option value="NULL">(... Seleccione ...)</option>
				   		{foreach name=cuentas_forma_pago from=$a.cuentas_forma_pago item=c}
			     			<option value="{$c.value}" {if $c.value eq $a.cuenta_tipo_pago_id}selected{/if}>{$c.text}</option>
				   		{/foreach}			   
		       		</select>
			   	{else}
                  <select name="cuenta_tipo_pago" id="cuenta_tipo_pago" disabled>
                    <option value="NULL">(... Seleccione ...)</option>
                  </select>
		     	{/if} 
                </div>
              </td>
              <td>
             	<div id="divTerceroTipoPago"> 
                {if count($a.tercero_forma_pago) > 0}
			   		<select name="select" id="select" disabled>
                    	<option value="NULL">(... Seleccione ...)</option>
				   		{foreach name=tercero_forma_pago from=$a.tercero_forma_pago item=c}
			     			<option value="{$c.value}" {if $c.value eq $a.tercero_contrapartida}selected{/if}>{$c.text}</option>
				   		{/foreach}			   
				 
		       		</select>
			    {else}
  					<select name="select" id="select" disabled>
			    		<option value="NULL">(... Seleccione ...)</option>
			  		</select>
		     	{/if} 
                </div>
              
              </td>
			 <td><input type="text" name="numero_soporte" id="numero_soporte" value="{$f.numero_soporte}" /></td>




			 <td>
				   <select name="tipo_descuento" id="tipo_descuento" {if $a.estado eq 'A'} disabled{/if} {if is_numeric($a.encabezado_registro_id) }disabled{/if}>
					 <option value="NULL">(... Seleccione ...)</option>
					 {foreach name=tipo_descuento from=$TIPODESCUENTO item=t}
					 <option value="{$t.value}" {if $t.value eq $a.tipo_descuento_id}selected{/if}>{$t.text}</option>
					 {/foreach}
				   </select>
			 </td>
			 <td>
			   <input type="text" name="valor_descuento" id="valor_descuento" value="{$a.valor_descuento}" {if $a.estado eq 'A'} disabled{/if}/>
			 </td>



			 
			 <td id="fecha_egreso">{$a.fecha_egreso}</td>
			 <td><input type="checkbox" name="generarAnticipoDespacho" {if is_numeric($a.encabezado_registro_id) }disabled{/if} {if $a.estado eq 'A'} disabled{/if}/></td>
			 <td><input type="checkbox" name="ver" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
             <td><input type="checkbox" name="anular" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} {if $a.estado eq 'A'} disabled{/if}/></td>
			</tr>	     
		 {/foreach}
	   {/if}	   
	   </tbody>
	 </table>
  </div>
  </body>
</html>
{/if}