<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>

  <body>
    <div>{$TITLEFORM}</div>	
  
	<fieldset>

        <div id="table_find">
        <table align="center">
         <tr>
           <td ><label>Busqueda : </label></td>
           <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>
		{$OFICINAIDSTATIC}{$USUARIOIDSTATIC}{$FECHAINGRESOSTAT}
		{$FORM1}
        <table align="center" width="95%">
        	<tr>
            	<td>
                    <fieldset class="section"><legend>Datos del Servicio</legend>
                    <table align="center" width="98%">
                      <tr>
                        <td><label>Seguimiento : </label></td><td>{$SEGUIMIENTOID}{$SERVICIOTRANSPORTE}{$OFICINAID}{$USUARIOID}{$FECHAINGRESO}</td>
                        <td><label>Documento Cliente :</label></td>
                        <td colspan="2">{$DOCUMENTOCLIENTE}</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><label>Fecha :</label></td><td>{$FECHA}</td>
                        <td><label>Estado : </label></td><td>{$ESTADO}</td>
                        <td><label>Tipo : </label></td><td>{$TIPO}</td>
                      </tr>
                      <tr>
                        <td><label> Cliente : </label></td><td>{$CLIENTE}{$CLIENTEID}</td>
                        <td><label> Identificaci&oacute;n : </label></td><td>{$CLIENTENIT}</td>
                        <td><label>Contactos :</label></td>
                        <td>{$CONTACTOS}</td>
                      </tr>
                      <tr>
                        <td><label>Direcci&oacute;n : </label></td><td>{$CLIENTEDIR}</td>
                        <td><label>Tel&eacute;fono :</label></td><td>{$CLIENTETEL}</td>
                        <td><label>M&oacute;vil : </label></td><td>{$CLIENTEMOV}</td>
                      </tr>

                      <tr>
                        <td><label>Origen : </label></td><td>{$ORIGEN}{$ORIGENID}</td>
                        <td><label>Destino : </label></td><td>{$DESTINO}{$DESTINOID}</td>
                        <td><label>Observaciones : </label></td>
                        <td rowspan="2">{$OBSERVACIONES}</td>
                      </tr>
                      <tr>
                        <td><label>Fecha Estimada Salida : </label></td>
                        <td>{$FECHASALIDA}</td>
                        <td><label>Hora Estimada Salida : </label></td>
                        <td>{$HORASALIDA}</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>
				</td>
			</tr>
            <tr>
            	<td>                          
                  <fieldset class="section"> <legend>Datos Vehiculo</legend>
                  <table>
                    <tbody>
                      <tr>
                        <td><label>Placa :</label></td>
                        <td>{$PLACAVEHICULO}{$PLACAVEHICULOID}{$PROPIO}</td>
                        <td><label>Marca :</label></td>
                        <td>{$MARCAVEHICULO}</td>
                        <td><label>Linea :</label></td>
                        <td>{$LINEAVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Modelo :</label></td>
                        <td>{$MODELOVEHICULO}</td>
                        <td><label>Modelo Repotenciado :</label></td>
                        <td>{$MODELOREPOTENCIADOVEHICULO}</td>
                        <td><label>Serie N° :</label></td>
                        <td>{$SERIEVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Color :</label></td>
                        <td>{$COLORVEHICULO}</td>
                        <td><label>Tipo de Carroceria :</label></td>
                        <td>{$CARROCERIAVEHICULO}</td>
                        <td><label>Registro Nal Carga :</label></td>
                        <td>{$REGISTRONALCARGAVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Configuracion :</label></td>
                        <td>{$CONFIGURACIONVEHICULO}</td>
                        <td><label>Peso Vacio :</label></td>
                        <td>{$PESOVACIOVEHICULO}</td>
                        <td><label>Numero Poliza SOAT:</label></td>
                        <td>{$NUMEROSOATVEHICULO}</td>
                      </tr>
                      <tr>
                        <td><label>Compañia de Seguros SOAT:</label></td>
                        <td>{$ASEGURADORASOATVEHICULO}</td>
                        <td><label>Vencimiento SOAT:</label></td>
                        <td>{$VENCIMIENTOSOATVEHICULO}</td>
                        <td><label>Placa Remolque :</label></td>
                        <td>{$REMOLQUE}{$PLACAREMOLQUE}{$PLACAREMOLQUEID}</td>
                      </tr>
                    </tbody>
                  </table>
                  </fieldset>
				</td>
			</tr>
            <tr>
            	<td>
                  <fieldset class="section"> <legend>Datos Conductor</legend>
                  <table align="center">
                    <tbody>
                      <tr>
                        <td><label>Conductor :</label></td>
                        <td>{$NOMBRECONDUCTOR}{$CONDUCTORID}</td>
                        <td><label>Doc Identificacion :</label></td>
                        <td>{$NUMEROIDENTIFICACION}</td>
                        <td><label>Direccion :</label></td>
                        <td>{$DIRECCIONCONDUCTOR}</td>
                      </tr>
                      <tr>
                        <td><label>Telefono :</label></td>
                        <td>{$TELEFONOCONDUCTOR}</td>
                        <td><label>M&oacute;vil :</label></td>
                        <td>{$MOVILCONDUCTOR}</td>
                        <td><label>Correo :</label></td>
                        <td>{$CORREOCONDUCTOR}</td>

                      </tr>
                      <tr>
                        <td><label>Ciudad :</label></td>
                        <td>{$CIUDADCONDUCTOR}</td>
                        <td><label>Catg Licencia :</label></td>
                        <td>{$CATEGORIALICENCIACONDUCTOR}</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>

                    </tbody>
                  </table>
                  </fieldset>
				</td>
			</tr>
			<tr>
			  <td>
			    <fieldset class="section">
				  <legend>Liquidacion</legend>
				  <table align="center">
				    <tr><td><label>Valor Facturar :</label></td><td>{$VALORFACTURAR}</td></tr>
				  </table>
				</fieldset>
			  </td>
			</tr>
			<tr>
			  <td align="center">
				<fieldset class="section">
				  <legend>Flete Pactado</legend>
				  
				   <table id="tableFletePactado">
						<tr id="rowValorFlete">
						  <td><label>Valor Flete :</label></td>
						  <td>{$VALORFLETE}</td>
						  <td colspan="3">&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						
						{foreach name=impuestos from=$IMPUESTOS item=i}
						<tr class="rowImpuestos">
						  <td>
							<input type="hidden" name="impuesto" id="impuestos_particular_id" value="" />
							<input type="hidden" name="impuesto" id="impuesto_id" value="{$i.impuesto_id}" />
							<input type="text" autocomplete="off" name="impuesto" id="nombre" value="{$i.nombre}" class="labelLiquidacion" size="30" disabled="disabled" />			              </td>
						  <td>
							<input type="hidden" name="impuesto" id="base" value=""  />			  			  
							<input type="text" autocomplete="off" name="impuesto" id="valor" class="numeric" value="" disabled="disabled" />						  </td>
						  <td colspan="3">&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						{/foreach}					
						
						<tr id="valorNeto">
						  <td><label>Valor Neto Pagar :</label></td>
						  <td>{$NETOPAGAR}</td>
						  <td colspan="3">&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						
						{foreach name=descuentos from=$DESCUENTOS item=d}
						<tr class="rowDescuentos">
						  <td>
							<input type="hidden" name="descuento" id="descuentos_particular_id" value="{$d.descuentos_particular_id}" />
							<input type="hidden" name="descuento" id="descuento_id" value="{$d.descuento_id}" />
							<input type="text" autocomplete="off" name="descuento" id="nombre" value="{$d.descuento}" class="labelLiquidacion" size="30" disabled="disabled" />			  </td>
						  <td>
							<input type="text" autocomplete="off" name="descuento" id="valor" class="numeric" value="0" {if $d.calculo eq 'P'}disabled{/if} />						 </td>
						  <td colspan="3">&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						{/foreach}			
						
						<tr class="rowAnticipos">
						  <td>
							<input type="hidden" name="anticipo" id="anticipos_particular_id" value="" />
							<label class="labelLiquidacion" >Anticipo </label>
							<input type="hidden" name="anticipo" id="numero" value="1" class="labelLiquidacion"  />:						 
						  </td>  
						  <td><input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" /></td>
						  <td><label>Conductor :</label></td>
						  <td>
							<input type="text" autocomplete="off" name="anticipo" id="conductor_anticipo" value="" size="35" />
							<input type="hidden" name="anticipo" id="conductor_anticipo_id" value="" />						  
						  </td>		  
						  <td><label>Entrega :</label></td>
						  <td>
						    <select name="anticipo" id="entrega">
							  <option value="C">Cliente Empresa</option>
							  <option value="E">Empresa Conductor</option>
							</select>
						  </td>							
						  <td><input type="button" name="addAnticipoTercero" id="addAnticipoTercero" value=" + " /></td>
						</tr>			
						<tr id="rowSaldoPagar">
						  <td><label>Saldo por Pagar: </label></td>			
						  <td>{$SALDOPAGAR}</td>
						  <td colspan="5"><input type="button" name="calcularFlete" id="calcularFlete" value="Calcular" class="buttondefault"   /></td>
					    </tr>
					  </table>	  
				</fieldset>	
				
			  </td>
			</tr>	
			<tr>                                      	                      
            	<td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
            </tr>
      	</table>
      {$FORM1END}
    </fieldset>
	
				<div style="display:none">
				
					<table id="rowImpuestosClon">
					{foreach name=impuestos from=$IMPUESTOS item=i}
					<tr>
					  <td>
						<input type="hidden" name="impuesto" id="impuestos_particular_id" value="" />
						<input type="hidden" name="impuesto" id="impuesto_id" value="{$i.impuesto_id}" />
						<input type="text" autocomplete="off" name="impuesto" id="nombre" value="{$i.nombre}" class="labelLiquidacion" size="30" disabled="disabled" />			  
					  </td>
					  <td colspan="4">
						<input type="hidden" name="impuesto" id="base" value=""  />			  			    
						<input type="text" autocomplete="off" name="impuesto" id="valor" class="numeric" value="" disabled="disabled" />			  
				      </td>
					</tr>
					{/foreach}
					</table>
					
					<table id="rowDescuentosClon">
					{foreach name=descuentos from=$DESCUENTOS item=d}
					<tr>
					  <td>
						<input type="hidden" name="descuento" id="descuentos_particular_id" value="{$d.descuentos_particular_id}" />
						<input type="hidden" name="descuento" id="descuento_id" value="{$d.descuento_id}" />
						<input type="text" autocomplete="off" name="descuento" id="nombre" value="{$d.descuento}" class="labelLiquidacion" size="30" disabled="disabled" />			  
					  </td>
					  <td colspan="4">
						<input type="text" autocomplete="off" name="descuento" id="valor" class="numeric" value="0" {if $d.calculo eq 'P'}disabled{/if} />			 
					  </td>
					</tr>
					{/foreach}	
					</table>
					
					<table id="rowAnticiposClon">
					<tr>
					  <td>
						<input type="hidden" name="anticipo" id="anticipos_particular_id" value="" />
						<label class="labelLiquidacion" >Anticipo </label>
						<input type="hidden" name="anticipo" id="numero" value="1" class="labelLiquidacion"  />:					  </td>  
					  <td><input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" /></td>
					  <td><label>Conductor :</label></td>
					  <td>
						<input type="text" autocomplete="off" name="anticipo" id="conductor_anticipo" value="" size="35" />
						<input type="hidden" name="anticipo" id="conductor_anticipo_id" value="" />					  </td>
					  <td><label>Entrega :</label></td>
					  <td><select name="anticipo" id="entrega">
                        <option value="C">Cliente Empresa</option>
                        <option value="E">Empresa Conductor</option>
                      </select></td>
					  <td><input type="button" name="addAnticipoTercero" id="addAnticipoTercero" value=" + " /></td>
					</tr>
					</table>				
				
					<table>
					<tr id="clonImpuestos">
					  <td>
						<input type="hidden" name="impuesto" id="impuestos_particular_id" value="" />
						<input type="hidden" name="impuesto" id="impuesto_id" value="" />
						<input type="text" autocomplete="off" name="impuesto" id="nombre" value="" class="labelLiquidacion" size="30" disabled="disabled" />			  
					  </td>
					  <td colspan="4">
						<input type="hidden" name="impuesto" id="base" value=""  />			  			      
						<input type="text" autocomplete="off" name="impuesto" id="valor" class="numeric" value="" disabled="disabled" />			  
				      </td>
					</tr>
					</table>
					
					<table>
					<tr id="clonDescuentos">
					  <td>
						<input type="hidden" name="descuento" id="descuentos_particular_id" value="" />
						<input type="hidden" name="descuento" id="descuento_id" value="" />
						<input type="text" autocomplete="off" name="descuento" id="nombre" value="" class="labelLiquidacion" size="30" disabled="disabled" />			  
					  </td>
					  <td colspan="4">
						<input type="text" autocomplete="off" name="descuento" id="valor" class="numeric" value="0" {if $d.calculo eq 'P'}disabled{/if} />			 
					  </td>
					</tr>
					</table>
					
					<table>
					<tr id="clonAnticipos">
					  <td>
						<input type="hidden" name="anticipo" id="anticipos_particular_id" value="" />
						<label class="labelLiquidacion" >Anticipo </label>
						<input type="hidden" name="anticipo" id="numero" value="1" class="labelLiquidacion"  />:					  </td>  
					  <td>
						<input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" />					  </td>
					  <td><label>Conductor :</label></td>
					  <td>
						<input type="text" autocomplete="off" name="anticipo" id="conductor_anticipo" value="" size="35" />
						<input type="hidden" name="anticipo" id="conductor_anticipo_id" value="" />					  </td>
					  <td><label>Entrega :</label></td>
					  <td><select name="anticipo" id="entrega">
                        <option value="C">Cliente Empresa</option>
                        <option value="E">Empresa Conductor</option>
                      </select></td>
					  <td><input type="button" name="addAnticipoTercero" id="addAnticipoTercero" value=" + " /></td>
					</tr>	
					</table>
				</div>	
	
    <fieldset>{$GRIDSeguimiento}</fieldset>
    <div id="divAnulacion">
      <form>
        <table>       
          <tr>
            <td><label>Fecha / Hora :</label></td>
            <td>{$FECHALOG}{$USUARIOANULID}</td>
          </tr>          
          <tr>
            <td><label>Descripcion :</label></td>
            <td>{$DESCRIPCIONANULACION}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$ANULAR}</td>
          </tr>                    
        </table>
      </form>
    </div>	
    
  </body>
</html>