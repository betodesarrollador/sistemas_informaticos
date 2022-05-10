<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Solicitud de Servicio - SI&amp;SI</title>
   {if $HISTORICO eq 'SI'}
   <link media='screen' type='text/css' href='../../../framework/css/generalDetalle.css?random=1690648896' rel='stylesheet' />
   {/if}
</head>
<body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  
	{if $HISTORICO neq 'SI'}
    <fieldset>
    <legend>{$TITLEFORM}</legend>
        <div id="table_find">
            <table>
                <tbody>
                    <tr>
                        <td><label>Busqueda : </label></td>
                        <td>{$BUSQUEDA}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    {$OFICINAHIDDEN}
    {$OFICINAIDHIDDEN}
    {$FECHASTATIC}
    </fieldset>
	{$FORM1}
    <fieldset class="section">
    <legend>Informaci&oacute;n general</legend>
        <table align="center" width="90%">
            <tbody>
                <tr>
                    <td><label>Solicitud No. : </label></td>
                    <td>{$SOLICITUDID}</td>
                    <td><label>Tipo :</label></td>
                    <td>{$PAQUETEO}</td>
                    <td><label>Oficina :</label></td>
                    <td>{$OFICINAID}</td>
                </tr>
                <tr>
                    <td><label>Fecha :</label></td>          
                    <td>{$FECHASOLICITUD}</td>
                    <td><label>Fecha Entrega :</label></td>          
                    <td>{$FECHASSFINAL}</td>
                </tr>
                <tr>
                    <td><label>Cliente : </label></td>
                    <td>{$CLIENTE}{$CLIENTEID}</td>
                    <td><label>Contacto : </label></td>
                    <td>{$CONTACTOID}</td>
                    <td id="tipo_servicio"><label>Tipo Servicio : </label></td>
                    <td id="tipo_servicio1">{$TIPOSERVICIO}</td>
                </tr>
                <tr>
                    <td><label>Valor Facturar :</label></td>          
                    <td>{$VALORFACTURAR}</td>
                    <td><label>Valor Costo :</label></td>          
                    <td>{$VALORCOSTO}</td>
                    <td><label>Tipo Liquidaci&oacute;n :</label></td>          
                    <td>{$TIPOLIQ}</td>		
                </tr>
                <tr id="fechas_recogidas">
                    <td><label>Fecha Recogida : </label></td>
                    <td>{$FECHARECOGIDA}</td>
                    <td><label>Hora Recogida : </label></td>
                    <td colspan="3">{$HORARECOGIDA}</td>
                </tr>
                <tr style="display:none">
                    <td><label>Fecha Entrega : </label></td>
                    <td>{$FECHAENTREGA}</td>
                    <td><label>Hora Entrega : </label></td>
                    <td colspan="3">{$HORAENTREGA}</td>
                </tr>
                <tr>
                    <td ><label>Observaciones : </label></td>
			        <td colspan="5">{$OBSERVACIONES}</td>

         		</tr>
                <tr>
			        <td colspan="6">&nbsp;</td>

         		</tr>
	      		<tr>
                	<td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}</td>
				</tr>
	      		<tr>
	        		<td colspan="6"  align="left"><span id="historico_val" style="display:none;"><label>Historico Valores</label><div><iframe id="detalleTarifa" class="editableGrid"></iframe></div></span></td>
          		</tr>
			</tbody>
		</table>
	</fieldset>
    <fieldset class="section">  
        <table id="toolbar">
            <tbody>
                <tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetallesSoliServi" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesSoliServi" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload">{$ARCHIVOSOLICITUD}</td>
                </tr>               
            </tbody>
		</table>
        <div>
        	<iframe id="detalleSoliServi" class="editableGrid"></iframe>
		</div>
	</fieldset>
    {$FORM1END}
    </fieldset>
    {else}
        <table id="tableSolicitudServicios" width="99%">
            <thead>
                <tr>
                    <th>FECHA</th>	
                    <th>VALOR COSTO TONELADA</th>
                    <th>VALOR FACTURAR TONELADA</th>          
                </tr>  
            </thead>
            <tbody>
                {foreach name=array_historico from=$ARRAY_HISTORICO item=d}
                    <tr>
                        <td>{$d.fecha}</td>
                        <td>{$d.valor_costo|number_format:0:",":"."}</td>
                        <td>{$d.valor_facturar|number_format:0:",":"."}</td>
                    </tr>
                {/foreach}                     
            </tbody>        
        </table>  
{/if}    
</body>
</html>