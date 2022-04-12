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
		
			<table align="center" width="100%" border="1" id="tableDetalles" >
				 <thead>
                <tr>
					{assign var="k" value=$DETALLESENVIOS|@count}
					{assign var="k" value=$k+1}
					<input type="text" id="cliente_id" name="cliente_id" value="{$CLIENTEID}" hidden>
					<input type="text" id="tercero_id" name="tercero_id" value="{$TERCEROID}" hidden>
                    
					
					<th>Tipo Ruta</th>
					<th>Origen</th>
                    <th>Destino</th>
                    <th>Descuento</th>
                    
                    <th>Precio Unidad 1</th>  
                    <th>Hasta</th>                    
                    <th>Precio Unidad 2</th> 
                    
                    
					<th>Guardar</th>
                    <th></th>
				</tr>
                </thead>
                <tbody>
				 {foreach name=detalles from=$DETALLES item=i}
					<tr>
						<td>
                        <select  class="required" id="convencion_id" name="convencion_id" style="width: 100px;">
                        			<option value="NULL"  {if $i.convencion_id eq 'NULL' }selected{/if}>(SELECCIONE)</option>
                                    <option value="1"  {if $i.convencion_id eq '1' }selected{/if}>URBANA</option>
                                    <option value="3" {if $i.convencion_id eq '3' }selected{/if} >REEXPEDICION</option>
                                    <option value="5" {if $i.convencion_id eq '5' }selected{/if} >NACIONAL</option>
                            </select>
                        	
							
							<input type="hidden" id="rutas_especiales_id" name="rutas_especiales_id" value="{$i.rutas_especiales_id}" >                            
							
						</td>
                        <td><input type="text" name="origen" value="{$i.origen}" class="required" size="10" />
	        <input type="hidden" name="origen_id" value="{$i.origen_id}" class="required" /></td>
            <td><input type="text" name="destino" value="{$i.destino}" class="required" size="10" />
	        <input type="hidden" name="destino_id" value="{$i.destino_id}" class="required" /></td> 
            
						  <td>%<input type="text" size="3" maxlength="2" class="numeric" id="porcentaje" name="porcentaje" value="{if $i.porcentaje neq ''}{$i.porcentaje}{else}0{/if}" >
                            <select  class="required" id="tipo" name="tipo" style="width: 100px;">
                                    <option value="D"  {if $i.tipo eq 'D' }selected{/if}>DESCUENTO</option>
                                    <option value="I" {if $i.tipo eq 'I' }selected{/if} >INCREMENTO</option>
                            </select>
                            
						</td>
                        <td><input type="text" size="4" maxlength="12" class="numeric" id="precio1" name="precio1" value="{if $i.precio1 neq ''}{$i.precio1}{else}0{/if}" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="hasta" name="hasta" value="{if $i.hasta neq ''}{$i.hasta}{else}0{/if}" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="precio2" name="precio2" value="{if $i.precio2 neq ''}{$i.precio2}{else}0{/if}" ></td>

						<!--<td>
							<a name="saveDetalleTarifaCliente">
								<img id="guarda" name="guarda" src="../../../framework/media/images/grid/save.png" />
							</a>
						</td>-->
                         <td><a name="saveDetalleTarifaCliente"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
                         <td><input type="checkbox" name="procesar" /></td>
					</tr>
			{/foreach}
            <tr >
               		<td>
                        <select  class="required" id="convencion_id" name="convencion_id" style="width: 100px;">
                        			<option value="NULL" >(SELECCIONE)</option>
                                    <option value="1"  >URBANA</option>
                                    <option value="3"  >REEXPEDICION</option>
                                    <option value="5" >NACIONAL</option>
                            </select>
                        	
							
							<input type="hidden" id="rutas_especiales_id" name="rutas_especiales_id" value="" >                            
							
						</td>
                        <td><input type="text" name="origen" value="" class="required" size="10" />
	        <input type="hidden" name="origen_id" value="" class="required" /></td>
            <td><input type="text" name="destino" value="" class="required" size="10" />
	        <input type="hidden" name="destino_id" value="" class="required" /></td> 
            
						  <td>%<input type="text" size="3" maxlength="2" class="numeric" id="porcentaje" name="porcentaje" value="" >
                            <select  class="required" id="tipo" name="tipo" style="width: 100px;">
                                    <option value="D"  {if $i.tipo eq 'D' }selected{/if}>DESCUENTO</option>
                                    <option value="I" {if $i.tipo eq 'I' }selected{/if} >INCREMENTO</option>
                            </select>
                            
						</td>
                        <td><input type="text" size="4" maxlength="12" class="numeric" id="precio1" name="precio1" value="" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="hasta" name="hasta" value="" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="precio2" name="precio2" value="" ></td>

						<!--<td>
							<a name="saveDetalleTarifaCliente">
								<img id="guarda" name="guarda" src="../../../framework/media/images/grid/save.png" />
							</a>
						</td>-->
                         <td><a name="saveDetalleTarifaCliente"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
                         <td><input type="checkbox" name="procesar" /></td>
					</tr>
			</tbody></table>
            
		<table align="center" width="100%" border="1"  >
				  <tr id="clon">
               		<td>
                        <select  class="required" id="convencion_id" name="convencion_id" style="width: 100px;">
                        			<option value="NULL" >(SELECCIONE)</option>
                                    <option value="1"  >URBANA</option>
                                    <option value="3"  >REEXPEDICION</option>
                                    <option value="5" >NACIONAL</option>
                            </select>
                        	
							
							<input type="hidden" id="rutas_especiales_id" name="rutas_especiales_id" value="" >                            
							
						</td>
                        <td><input type="text" name="origen" value="" class="required" size="10" />
	        <input type="hidden" name="origen_id" value="" class="required" /></td>
            <td><input type="text" name="destino" value="" class="required" size="10" />
	        <input type="hidden" name="destino_id" value="" class="required" /></td> 
            
						  <td>%<input type="text" size="3" maxlength="2" class="numeric" id="porcentaje" name="porcentaje" value="" >
                            <select  class="required" id="tipo" name="tipo" style="width: 100px;">
                                    <option value="D"  {if $i.tipo eq 'D' }selected{/if}>DESCUENTO</option>
                                    <option value="I" {if $i.tipo eq 'I' }selected{/if} >INCREMENTO</option>
                            </select>
                            
						</td>
                        <td><input type="text" size="4" maxlength="12" class="numeric" id="precio1" name="precio1" value="" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="hasta" name="hasta" value="" ></td>
						<td><input type="text" size="4" maxlength="12" class="numeric" id="precio2" name="precio2" value="" ></td>

						<!--<td>
							<a name="saveDetalleTarifaCliente">
								<img id="guarda" name="guarda" src="../../../framework/media/images/grid/save.png" />
							</a>
						</td>-->
                         <td><a name="saveDetalleTarifaCliente"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
                         <td><input type="checkbox" name="procesar" /></td>
					</tr>
			<!--foreach-->
			</table>
	</body>
</html>