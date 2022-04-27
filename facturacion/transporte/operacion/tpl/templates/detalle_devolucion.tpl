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
   {if count($ANTICIPOSCRUCE)>0}
     <table align="center" width="100%">
	  <thead>
	   <tr>
	     <th>NUMERO</th>
         <th>ANTICIPO DEVOLVER</th>
         <th>CONSECUTIVO</th>
         <th>FECHA DOC </th>
         <th>TIPO DOC </th>
		 <th>FORMA PAGO</th>         
		 <th>CUENTA</th>         
		 <th>TENEDOR</th>         
	   	 <th>CONDUCTOR</th>
		 <th>VALOR</th>
		 <th>N. SOPORTE </th>
		 <th>FECHA {if $TIPOREG eq 'MC'}MC{else}DU{/if}</th>
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
                {if $TIPOREG eq 'MC'}
                	<input type="hidden" name="anticipos_manifiesto_id" id="anticipos_manifiesto_id" value="" />
                {else}
                	<input type="hidden" name="anticipos_despacho_id" id="anticipos_despacho_id" value="" />
                {/if}		 
                
                <input type="hidden" name="propio" id="propio" value="{$DATASERVICIO[0].propio}" />                        
                <input type="hidden" name="numero" id="numero" value="{$REGIS}" />{$REGIS}		   
            </td>
             <td>
              {if $TIPOREG eq 'MC'}
               <select name="sub_anticipos_manifiesto_id" id="sub_anticipos_manifiesto_id" class="required"  >
                 <option value="NULL">(... Seleccione ...)</option>
                 {foreach name=tipo_doc from=$ANTICIPOSCRUCE item=f}
                 <option value="{$f.anticipos_manifiesto_id}" >{$f.consecutivo}</option>
                 {/foreach}
               </select>			
			   {else}                
               <select name="sub_anticipos_despacho_id" id="sub_anticipos_despacho_id" class="required"  >
                 <option value="NULL">(... Seleccione ...)</option>
                 {foreach name=tipo_doc from=$ANTICIPOSCRUCE item=f}
                 <option value="{$f.anticipos_despacho_id}" >{$f.consecutivo}</option>
                 {/foreach}
               </select>
               {/if}			
               
             </td>
            
             <td>
               <input type="text" name="consecutivo" id="consecutivo"  size="12" value=""  />
             </td>
             <td><input type="text" name="fecha_egreso" id="fecha_egreso" value="" class="date" size="14" /></td>
             <td>
               <select name="tipo_doc" id="tipo_doc" >
                 <option value="NULL">(... Seleccione ...)</option>
                 {foreach name=tipo_doc from=$TIPODOC item=f}
                 <option value="{$f.tipo_documento_id}" >{$f.nombre}</option>
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

             <td><input type="text" class="required numeric" name="valor" id="valor" value="" /></td>
             <td>
               <input type="text" name="numero_soporte" id="numero_soporte" value="" />
               <input type="hidden" name="placa_id" id="placa_id" value="{$DATASERVICIO[0].placa_id}" />                        

               <input type="hidden" name="placa" id="placa" value="{$DATASERVICIO[0].placa}" />
             </td>
              <td>{$DATASERVICIO[0].fecha}</td>
             <td>
               <input type="text" name="observaciones" id="observaciones" value="" size="28" maxlength="90"  />
             </td>
            {if $TIPOREG eq 'MC'}
	             <td><input type="checkbox" name="generarAnticipoManifiesto"  /></td>
             {else}
	             <td><input type="checkbox" name="generarAnticipoDespacho"  /></td>
             
             {/if}
             <td><input type="checkbox" name="ver"  disabled /></td>
             <td><input type="checkbox" name="anular" disabled /></td>		   
            <td><input type="checkbox" name="eliminar" disabled /></td>		                        
        </tr>	     
	   
	   {if count($ANTICIPOS) > 0}
		 {foreach name=anticipos from=$ANTICIPOS item=a}
		   <tr class="rowAnticipo" align="center">
			 <td>
			   <input type="hidden" name="encabezado_registro_id" id="encabezado_registro_id" value="{$a.encabezado_registro_id}" />		 
			   <input type="hidden" name="anticipos_manifiesto_id" id="anticipos_manifiesto_id" value="{$a.anticipos_manifiesto_id}" />
			   <input type="hidden" name="numero" id="numero" value="{$a.numero}" />			   
			   {$a.numero}			 
             </td>
             <td>
               <select name="sub_anticipos_manifiesto_id" id="sub_anticipos_manifiesto_id" {if is_numeric($a.encabezado_registro_id) }disabled{/if}  >
                 <option value="NULL">(... Seleccione ...)</option>
                 {foreach name=tipo_doc from=$ANTICIPOSCRUCE item=f}
                 <option value="{$f.anticipos_manifiesto_id}" {if $f.anticipos_manifiesto_id eq $a.sub_anticipos_manifiesto_id}selected{/if}>{$f.consecutivo}</option>
                 {/foreach}
               </select>			 
             </td>
             
             <td>
               <input type="text"  name="consecutivo" id="consecutivo" class="required" value="{$a.consecutivo}" {if $a.estado eq 'A'}style="color:#F00;"{/if}  size="12"  />
             </td>
			 <td ><input type="text" name="fecha_egreso" id="fecha_egreso" value="{$a.fecha_egreso}" class="date" size="14"  /></td>
             <td>
               <select name="tipo_doc" id="tipo_doc" {if is_numeric($a.encabezado_registro_id) }disabled{/if}>
                 <option value="NULL">(... Seleccione ...)</option>
                 {foreach name=tipo_doc from=$TIPODOC item=f}
                 <option value="{$f.tipo_documento_id}" {if $f.tipo_documento_id eq $a.tipo_docu}selected{/if}>{$f.nombre}</option>
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
		   	 <td><input type="hidden" name="tenedor" id="tenedor_id" value="{$a.tenedor_id}"  />{$a.tenedor}</td>
			 <td><input type="hidden" name="conductor" id="conductor_id" value="{$a.conductor_id}"  />{$a.conductor}</td>
			 <td><input type="hidden" name="valor" id="valor" value="{$a.valor}" />{$a.valor|number_format:0:',':'.'}</td>
			 <td>
			   <input type="text" name="numero_soporte" id="numero_soporte" value="{$a.numero_soporte}" />
			 </td>
			 <td>{$DATASERVICIO[0].fecha}</td>
             <td>
                <input type="text" name="observaciones" id="observaciones" value="{$a.observaciones}" size="28" maxlength="90"  />
             </td>

			 <td><input type="checkbox" name="generarAnticipoManifiesto" {if is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
			 <td><input type="checkbox" name="ver" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
			 <td><input type="checkbox" name="anular" title="anular" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
             <td><input type="checkbox" name="eliminar" title="eliminar"   /></td>			   
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
               <select name="sub_anticipos_despacho_id" id="sub_anticipos_despacho_id" {if is_numeric($a.encabezado_registro_id) }disabled{/if}  >
                 <option value="NULL">(... Seleccione ...)</option>
                 {foreach name=tipo_doc from=$ANTICIPOSCRUCE item=f}
                 <option value="{$f.anticipos_despacho_id}" {if $f.anticipos_despacho_id eq $a.sub_anticipos_despacho_id}selected{/if}>{$f.consecutivo}</option>
                 {/foreach}
               </select>			 
             </td>
             
             <td>
               <input type="text"  name="consecutivo" id="consecutivo" value="{$a.consecutivo}" {if $a.estado eq 'A'}style="color:#F00;"{/if}  size="12"  />
             </td>
   			 <td ><input type="text" name="fecha_egreso" id="fecha_egreso" value="{$a.fecha_egreso}" class="date" size="14"  /></td>
             <td>
               <select name="tipo_doc" id="tipo_doc" {if is_numeric($a.encabezado_registro_id) }disabled{/if}>
                 <option value="NULL">(... Seleccione ...)</option>
                 {foreach name=tipo_doc from=$TIPODOC item=f}
                 <option value="{$f.tipo_documento_id}" {if $f.tipo_documento_id eq $a.tipo_docu}selected{/if}>{$f.nombre}</option>
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
			 <td><input type="hidden" name="tenedor" id="tenedor_id" value="{$a.tenedor_id}"  />{$a.tenedor}</td>
		   	 <td><input type="hidden" name="conductor" id="conductor_id" value="{$a.conductor_id}"  />{$a.conductor}</td>
			 <td><input type="hidden" name="valor" id="valor" value="{$a.valor}" />{$a.valor|number_format:0:',':'.'}</td>
			 <td><input type="text" name="numero_soporte" id="numero_soporte" value="{$a.numero_soporte}" /></td>
			 <td>{$DATASERVICIO[0].fecha}</td>
             <td>
                <input type="text" name="observaciones" id="observaciones" value="{$a.observaciones}" size="28" maxlength="90"  />
             </td>
			 <td><input type="checkbox" name="generarAnticipoDespacho" {if is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
			 <td><input type="checkbox" name="ver" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>
			 <td><input type="checkbox" name="anular" title="anular" {if not is_numeric($a.encabezado_registro_id) }disabled{/if} /></td>		   	     
			 <td><input type="checkbox" name="eliminar" title="eliminar"   /></td>		  		   
            
            </tr>	                  
		 {/foreach}
	   
	   {/if}	   
	   
	   </tbody>
	 </table>
    {else}
        No se pueden Generar devoluciones, debido a que no existen anticipos
    {/if}
  </div>
  </body>
</html>
	
{/if}