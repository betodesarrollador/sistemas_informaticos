<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
  
  <meta http-equiv="content-type" content="text/html; charset=utf-8">

</head><body>
{$JAVASCRIPT} {$TABLEGRIDJS} {$CSSSYSTEM} {$TABLEGRIDCSS} {$TITLETAB}
<fieldset> <legend>{$TITLEFORM}</legend>
<div id="table_find">
<table>
  <tbody>
    <tr>
      <td><label>Busqueda : </label></td>
      <td>{$BUSQUEDA}</td>
	  <td align="center"><h3><font color="#FF0000"><b>DESPACHOS URBANOS</b></font></h3></td>
    </tr>
  </tbody>
</table>
</div>
{$EMPRESAIDSTATIC}{$OFICINAIDSTATIC}{$FECHASTATIC}{$ASEGURADORASTATIC}{$POLIZASTATIC}{$VENCIMIENTOPOLIZASTATIC}
{$FORM1}
<fieldset> 

{$USUARIOID}{$USUARIOREGISTRA}{$USUARIONUMID}
<table align="center">
  <tbody>
    <tr>
      <td align="center">
      <fieldset class="section">
	  <legend>DESPACHO URBANO</legend>
      <table align="center">
        <tbody>
          <tr>
            <td><label>Despacho No. : </label></td>
            <td>{$MANIFIESTO}{$MANIFIESTOID}{$SERVICIOTRANSPORTE}{$UPDATEMANIFIESTO}{$OFICINAID}{$IDMOBILE}</td>
            <td><label>Fecha Despacho : </label></td>
            <td>{$FECHAMANIFIESTO}</td>
            <td><label>Fecha Estimada Entrega : </label></td>
            <td>{$FECHAENTREGA}</td>
          </tr>
          <tr>
            <td><label>Hora Estimada Entrega : </label></td>
            <td>{$HORAENTREGA}</td>
            <td><label>Modalidad :</label></td>
            <td>{$MODALIDAD}</td>
            <td><label>Origen : </label></td>
            <td>{$ORIGEN}{$ORIGENID}{$ORIGENDIVIPOLA}</td>
          </tr>
		  <tr>
            <td><label>Destino : </label></td>
            <td>{$DESTINO}{$DESTINOID}{$DESTINODIVIPOLA}</td>												  
            <td><label>Precinto :</label></td>
            <td>{$NUMEROPRECINTO}</td>
		    <td><label>Observaciones : </label></td>
		    <td rowspan="2">{$OBSERVACIONES}</td>
		  </tr>		  
          <tr>
            <td valign="top"><label>Estado : </label></td>
            <td valign="top">{$ESTADO}</td>
            <td valign="top"><label></label></td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            </tr>	  
        </tbody>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
      <td colspan="4" align="center">
      <fieldset class="section"> <legend>Datos Vehiculo</legend>
      <table>
        <tbody>
          <tr>
            <td><label>Placa :</label></td>
            <td>{$PLACAVEHICULO}{$PLACAVEHICULOID}{$PROPIO}{$REMOLQUE}{$PROPIETARIOREMOLQUE}{$TIPOIDENTIFICACIONPROPIETARIOREMOLQUE}{$DOCIDENTIFICACIONPROPIETARIOREMOLQUE}</td>
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
            <td><label>Serie N?? :</label></td>
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
            <td><label>Compa??ia de Seguros SOAT:</label></td>
            <td>{$ASEGURADORASOATVEHICULO}</td>
            <td><label>Vencimiento SOAT:</label></td>
            <td>{$VENCIMIENTOSOATVEHICULO}</td>
            <td><label>Placa Remolque :</label></td>
            <td>{$PLACAREMOLQUE}{$PLACAREMOLQUEID}</td>
          </tr>
        </tbody>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
      <td colspan="6" align="center">
      <fieldset class="section"> <legend>Datos Conductor</legend>
      <table align="center">
        <tbody>
          <tr>
            <td><label>Conductor :</label></td>
            <td>{$NOMBRECONDUCTOR}{$CONDUCTORID}</td>
            <td><label>Doc Identificacion :</label></td>
            <td>{$NUMEROIDENTIFICACION}</td>
            <td><label>Catg Licencia :</label></td>
            <td>{$LICENCIACONDUCTOR}{$CATEGORIALICENCIACONDUCTOR}</td>
          </tr>
          <tr>
            <td><label>Direccion :</label></td>
            <td>{$DIRECCIONCONDUCTOR}</td>
            <td><label>Telefono :</label></td>
            <td>{$TELEFONOCONDUCTOR}</td>
            <td><label>Ciudad :</label></td>
            <td>{$CIUDADCONDUCTOR}</td>
          </tr>
        </tbody>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
      <td colspan="6" align="center">
      <fieldset class="section"> <legend>Datos Propietario</legend>
      <table align="center">
        <tbody>
          <tr>
            <td><label>Propietario :</label></td>
            <td>{$PROPIETARIO}</td>
            <td><label>Doc Identificacion :</label></td>
            <td>{$DOCIDENTIFICACIONPROPIETARIO}</td>
            <td><label>Direccion :</label></td>
            <td>{$DIRECCIONPROPIETARIO}</td>
          </tr>
          <tr>
            <td><label>Telefono :</label></td>
            <td>{$TELEFONOPROPIETARIO}</td>
            <td><label>Ciudad :</label></td>
            <td colspan="3">{$CIUDADPROPIETARIO}{$TIPOIDENTIFICACIONPROPIETARIO}</td>
          </tr>
        </tbody>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
      <td colspan="6" align="center">
      <fieldset class="section"> <legend>Datos Tenedor</legend>
      <table align="center">
        <tbody>
          <tr>
            <td><label>Tenedor :</label></td>
            <td>{$TENEDOR}{$TENEDORID}</td>
            <td><label>Doc Identificacion :</label></td>
            <td>{$DOCIDENTIFICACIONTENEDOR}</td>
            <td><label>Direccion :</label></td>
            <td>{$DIRECCIONTENEDOR}</td>
          </tr>
          <tr>
            <td><label>Telefono :</label></td>
            <td>{$TELEFONOTENEDOR}</td>
            <td><label>Ciudad :</label></td>
            <td colspan="3">{$CIUDADTENEDOR}{$TIPOIDENTIFICACIONTENEDOR}</td>
          </tr>
        </tbody>
      </table>
      </fieldset>
	  
	  <fieldset class="section">
	    <legend>Datos Titular Despacho</legend>
		<table>
          <tr>
            <td><span style="vertical-align: top;">
              <label>Titular Despacho : </label>
            </span></td>
            <td><span style="vertical-align: top;">{$TITULAR}{$TITULARID}{$CIUDADTITULARDIVIPOLA}</span></td>
            <td style="vertical-align: top;"><label>Identificacion </label>
              <br></td>
            <td style="vertical-align: top;">{$NUMEROIDENTIFICACIONTITULAR}</td>
            <td style="vertical-align: top;"><label>Direccion : </label></td>
            <td style="vertical-align: top;">{$DIRECCIONTITULAR}</td>			
          </tr>
          <tr>
            <td style="vertical-align: top;"><label>Telefono :</label></td>
            <td style="vertical-align: top;">{$TELEFONOTITULAR}</td>	
			<td><label>Ciudad Titular :</label></td>		
			<td>{$CIUDADTITULAR}</td>		
			<td>&nbsp;</td>
			<td>&nbsp;</td>								
          </tr>			
		</table>
	  </fieldset>
      </td>
    </tr>
	<tr id="rowDTA">
	  <td>
	   {$DTAID}
	   <fieldset class="section"> <legend>Datos DTA</legend>
		  <table width="100%" border="0" align="center">
		    <tr>
			  <td><label>Cliente :</label></td>
			  <td>{$CLIENTE}{$CLIENTEID}</td>			  
			  <td><label>Fecha Consignacion :</label></td>
			  <td>{$FECHACONSIGNACION}</td>
			  <td><label>N. Formulario :</label></td>
			  <td>{$NUMEROFORMULARIO}</td>
		    </tr>
			<tr>
			  <td><label>N. Fecha Entrega :</label></td>
			  <td>{$FECHAENTREGADTA}</td>
			  <td><label>N. Contenedor :</label></td>
			  <td>{$NUMEROCONTENEDORDTA}</td>
			  <td><label>Naviera :</label></td>
			  <td>{$NAVIERA}</td>
			</tr>
			<tr>
			  <td><label>Tara :</label></td>
			  <td>{$TARA}</td>
			  <td><label>Tipo :</label></td>
			  <td>{$TIPO}</td>
			  <td><label>Numero Precinto :</label></td>
			  <td>{$NUMEROPRECINTO}</td>
			</tr>
			<tr>
			  <td><label>Codigo Producto :</label></td>
			  <td>{$CODIGO}</td>
			  <td><label>Producto : </label></td>
			  <td>{$PRODUCTO}{$PRODUCTOID}</td>
			  <td><label>Peso :</label></td>
			  <td>{$PESO}</td>
			</tr>	
			<tr>
			  <td><label>Responsable DIAN :</label></td>
			  <td>{$RESPONSABLEDIAN}</td>
			  <td><label>Responsable Empresa :</label></td>
			  <td>{$RESPONSABLEEMPRESA}</td>
			  <td><label>Observaciones :</label></td>
			  <td>{$OBSERVACIONESDTA}{$ESTADODTA}</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="3">&nbsp;</td>
		    </tr>
			<tr>
			 <td colspan="6" align="center">
			  <table width="100%" align="center">
			<tr>
			  <td><label>Imagen Formulario :</label></td>
			  <td>{$IMAGENFORMULARIO}</td>
			  <td><label>Foto Posterior :</label></td>
			  <td>{$FOTOPOSTERIOR}</td>
			</tr>
			<tr>
			  <td><label>Foto Lateral Derecha :</label></td>
			  <td>{$FOTOLATERALDERECHA}</td>
			  <td><label>Foto Lateral Izquierda :</label></td>
			  <td>{$FOTOLATERALIZQUIERDA}</td>
		    </tr>
			<tr>
			  <td><label>Foto Anterior :</label></td>
			  <td>{$FOTOANTERIOR}</td>
			  <td><label>Foto Precinto :</label></td>
			  <td>{$FOTOPRECINTO}</td>
		    </tr>
			  </table>			  </td>
			</tr>
		  </table>
	  </fieldset>
	  </td>
	</tr>
	<tr id="rowMANIFIESTO">
	  <td>
	   <fieldset class="section">
	    <legend>FOTOS DESPACHO</legend>
	     <table align="center" width="100%">
		   <tr>
		     <td><label>Precinto :</label></td>
			 <td>{$FOTOPRECINTONORMAL}</td>
			 <td><label>Amarres :</label></td>
			 <td>{$FOTOAMARRES}</td>
		   </tr>
		 </table>
	   </fieldset>
	  </td>
	</tr>	
    <tr>
      <td align="center">
	   <table width="98%" align="center">
	    <tr>
		 <td align="left">{$GUARDAR}</td>
		 <td align="right">{$SELECCIONARREMESAS}</td>
		</tr>
	  </table>
	  </td>
	</tr>
	<tr>
	  <td>
       <fieldset class="section" id="remesasManifestar"> 
	    <legend>REMESAS</legend>
        <iframe id="detalleDespacho" src=""></iframe> 
	   </fieldset>
      </td>
    </tr>
	<tr>
	  <td align="center">
		<fieldset class="section"  id="anticipos"> 
		  <legend>Anticipos</legend>  
		  
		  <table id="tableAnticipos">
		    <tr>
			  <td>
			    <label>Conductor :</label>
			  </td>
			  <td>
			    <input type="text" autocomplete="off" name="anticipo" id="conductor" value="" />
			    <input type="hidden" name="anticipo" id="conductor_id" value="" />				
			  </td>
			  <td><label>Valor :</label></td>
			  <td>
				<input type="hidden" name="anticipo" id="anticipos_despacho_id" value="" />
				<input type="hidden" name="anticipo" id="numero" value="" />
                <input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" />				
			  </td>		  			  
			  <td><input type="button" name="addAnticipo" id="addAnticipo" value=" + " /></td>
			</tr>
		    <tr id="clon">
			  <td>
			    <label>Conductor :</label>
			  </td>
			  <td>
			    <input type="text" autocomplete="off" name="anticipo" id="conductor" value="" />
			    <input type="hidden" name="anticipo" id="conductor_id" value="" />				
			  </td>
			  <td><label>Anticipo :</label></td>
			  <td>
				<input type="hidden" name="anticipo" id="anticipos_despacho_id" value="" />
				<input type="hidden" name="anticipo" id="numero" value="" />
                <input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" />				
			  </td>		  			  
			  <td><input type="button" name="addAnticipo" id="addAnticipo" value=" + " /></td>
			</tr>			
		  </table>
		  
		</fieldset>	  	  
		<fieldset class="section"  id="fletePactado"> 
		  <legend>Flete Pactado</legend>  
		  
		  <table id="tableFletePactado">
		    <tr id="rowValorFlete">
			  <td><label>Valor Flete :</label></td>
			  <td colspan="4">{$VALORFLETE}</td>
		    </tr>
			
			{foreach name=impuestos from=$IMPUESTOS item=i}
			<tr class="rowImpuestos">
              <td>
			    <input type="hidden" name="impuesto" id="impuestos_despachos_urbanos_id" value="" />
				<input type="hidden" name="impuesto" id="impuesto_id" value="{$i.impuesto_id}" />
				<input type="text" autocomplete="off" name="impuesto" id="nombre" value="{$i.nombre}" class="labelLiquidacion" size="30" disabled="disabled" />			              </td>
              <td colspan="4">
			    <input type="hidden" name="impuesto" id="base" value=""  />			  			  
			    <input type="text" autocomplete="off" name="impuesto" id="valor" class="numeric" value="" disabled="disabled" />			  
		      </td>
            </tr>
			{/foreach}					
			<tr id="ica" >
              <td>
              <input type="hidden" name="impuesto1" id="impuestos_despachos_urbanos_id" value="" />
              <select name="impuesto1" id="impuesto_id" class="required">
                <option value="">Seleccione</option>
              	{foreach name=impuestos1 from=$IMPUESTOS1 item=i}
                <option value="{$i.impuesto_id}" selected="{$i.impuesto_id}">{$i.nombre}</option>
			  	{/foreach}	
              </select>  
              </td>
              <td colspan="4">
			    <input type="hidden" name="impuesto1" id="base" value=""  />												  			
			    <input type="text" autocomplete="off" name="impuesto1" id="valor" class="numeric" value="" disabled="disabled" />			  
		      </td>
            </tr>	
			<tr id="valorNeto">
			  <td><label>Valor Neto Pagar :</label></td>
			  <td colspan="4">{$NETOPAGAR}</td>
		    </tr>
			
			{foreach name=descuentos from=$DESCUENTOS item=d}
			<tr class="rowDescuentos">
              <td>
			    <input type="hidden" name="descuento" id="descuentos_manifiesto_id" value="{$d.descuentos_manifiesto_id}" />
				<input type="hidden" name="descuento" id="descuento_id" value="{$d.descuento_id}" />
				<input type="text" autocomplete="off" name="descuento" id="nombre" value="{$d.descuento}" class="labelLiquidacion" size="30" disabled="disabled" />			  </td>
              <td colspan="4">
			    <input type="text" autocomplete="off" name="descuento" id="valor" class="numeric" value="0" {if $d.calculo eq 'P'}disabled{/if} />			 
			 </td>
            </tr>
			{/foreach}			
			
			<tr class="rowAnticipos">
			  <td>
			    <input type="hidden" name="anticipo" id="anticipos_despacho_id" value="" />
				<label class="labelLiquidacion" >Anticipo </label>
				<input type="hidden" name="anticipo" id="numero" value="1" class="labelLiquidacion"  />:			 
			  </td>  
			  <td><input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" /></td>
			  <td><label>Tenedor :</label></td>
			  <td>
			    <input type="text" autocomplete="off" name="anticipo" id="tenedor_anticipo" value="" size="35" />
				<input type="hidden" name="anticipo" id="tenedor_anticipo_id" value="" />		      
			  </td>		  
			  <td><input type="button" name="addAnticipoTercero" id="addAnticipoTercero" value=" + " /></td>
			</tr>			
			<tr id="rowSaldoPagar">
			  <td><label>Saldo por Pagar: </label></td>			
			  <td colspan="4">{$SALDOPAGAR}</td>
		    </tr>
			<tr id="fechaPagoSaldo">
			  <td><label>Fecha Pago Saldo :</label></td>
			  <td colspan="4">{$FECHAPAGOSALDO}{$LUGARPAGOSALDO}</td>
		    </tr>
			<tr>
			  <td><label>Lugar para pago del saldo :</label></td>
			  <td colspan="4">{$LUGARESSALDO}</td>
			</tr>
			<tr>
              <td><label>Cargue Pagado Por :</label></td>
              <td colspan="4">{$CARGUEPAGADOPOR}</td>
			</tr>
			<tr>
              <td><label>Descargue Pagado Por :</label></td>
              <td colspan="4">{$DESCARGUEPAGADOPOR}
              <input type="button" name="calcularFlete" id="calcularFlete" value="Calcular" class="buttondefault"   /></td>
          </tr>
		  </table>
		</fieldset>	  
	  </td>
	</tr>
  </tbody>
</table>
</fieldset>
<div align="center" id="divToolBarButtons">{$MANIFESTAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$CAUSAR}</div>

{$FORM1END} 
<div style="display:none" id="divDatosFrame"><iframe id="detalleFrameAnticipo" frameborder="0"></iframe></div>
<div style="display:none">
<table id="rowImpuestosClon">
{foreach name=impuestos from=$IMPUESTOS item=i}
<tr>
  <td>
	<input type="hidden" name="impuesto" id="impuestos_manifiesto_id" value="" />
	<input type="hidden" name="impuesto" id="impuesto_id" value="{$i.impuesto_id}" />
	<input type="text" autocomplete="off" name="impuesto" id="nombre" value="{$i.nombre}" class="labelLiquidacion" size="30" disabled="disabled" />			  </td>
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
    <input type="hidden" name="descuento" id="descuentos_manifiesto_id" value="{$d.descuentos_manifiesto_id}" />
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
	<input type="hidden" name="anticipo" id="anticipos_despacho_id" value="" />
	<label class="labelLiquidacion" >Anticipo </label>
	<input type="hidden" name="anticipo" id="numero" value="1" class="labelLiquidacion"  />:			 
  </td>  
  <td><input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" /></td>
  <td><label>Tenedor :</label></td>
  <td>
	<input type="text" autocomplete="off" name="anticipo" id="tenedor_anticipo" value="" size="35" />
	<input type="hidden" name="anticipo" id="tenedor_anticipo_id" value="" />		      
  </td>
  <td><input type="button" name="addAnticipoTercero" id="addAnticipoTercero" value=" + " /></td>
</tr>
</table>

<table>
<tr id="clonImpuestos">
  <td>
	<input type="hidden" name="impuesto" id="impuestos_manifiesto_id" value="" />
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
    <input type="hidden" name="descuento" id="descuentos_manifiesto_id" value="" />
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
	<input type="hidden" name="anticipo" id="anticipos_despacho_id" value="" />
	<label class="labelLiquidacion" >Anticipo </label>
	<input type="hidden" name="anticipo" id="numero" value="1" class="labelLiquidacion"  />:			 
  </td>  
  <td>
    <input type="text" autocomplete="off" name="anticipo" id="valor" class="numeric" value="" /> 
	  </td>
  <td><label>Tenedor :</label></td>
  <td>
	<input type="text" autocomplete="off" name="anticipo" id="tenedor_anticipo" value="" size="35" />
	<input type="hidden" name="anticipo" id="tenedor_anticipo_id" value="" />		      
  </td>
  <td><input type="button" name="addAnticipoTercero" id="addAnticipoTercero" value=" + " /></td>
</tr>	
</table>
</div>

<div id="divRemesas" style="display:none"> <iframe id="iframeRemesas"></iframe> </div>
<div id="divAnulacion">
  <form onSubmit="return false">
	<table>              
	  <tr>
		<td><label>Causal :</label></td>
		<td>{$CAUSALANULACIONID}</td>
	  </tr>
	  <tr>
		<td><label>Descripcion :</label></td>
		<td>{$OBSERVANULACION}</td>
	  </tr> 
	  <tr>
		<td colspan="2" align="center">{$ANULAR}</td>
	  </tr>                    
	</table>
  </form>
</div>

<div>{$GRIDDESPACHOS}</div>

</body>
</html>