<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="ruta_id" value="{$RUTAID}" />
  <table align="center" id="tableDetalleRuta" width="98%">
    <thead>
      <tr>
        <th>ORDEN</th>
        <th>PUNTO 0 CIUDAD</th>
        {*<th>DISTANCIA (Km)</th>*}
        {*<th>TIEMPO (m)</th>*}
        <th>TIPO PUNTO</th>
        {*<th>REFERENCIA</th> *}
        <th width="2%">__</th>       
        <th>&nbsp;</th>
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$DETALLESRUTA item=d}
      <tr>
        <td><input type="text" name="orden_det_ruta" value="{$d.orden_det_ruta}" size="1" readonly="readonly" /><input type="hidden" name="detalle_ruta_id" value="{$d.detalle_ruta_id}" id="detalle_ruta_id_hidden" class="required" /></td>
        <td>
        	<input type="text" name="ubicacion" id="ubucacion" value="{$d.ubicacion}" size="70" />
        	<input name="ubicacion_id" id="ubicacion_hidden" type="hidden" value="{$d.ubicacion_id}"  />
            <input name="punto_referencia_id" id="punto_referencia_id" type="hidden" value="{$d.punto_referencia_id}" />
        </td>
        {*<td>
          <input type="text" name="distancia_det_ruta" value="{$d.distancia_det_ruta}" size="5" class="numeric required" />
          </td>*}
        {*<td>
          <input type="text" name="tiempo_det_ruta" value="{$d.tiempo_det_ruta}" size="5" class="numeric required" />
          </td>*}
       {* <td><input type="text" name="tiporef" value="{$d.tiporef}" class="required" readonly="readonly" /></td>*}
        <td>
          <input type="text" name="refe" value="{$d.refe}" class="required" size="27" readonly="readonly" />
          </td> 
		<td>
		  <a name="saveNewDetalle" href="javascript:void(0)" onClick="agregar(this)">
		   <img src="../../../framework/media/images/grid/add.png" />
		  </a>
		</td>               
        <td>
		 <a href="javascript:void(0)" onClick="deleteDetalleRuta(this)">
		  <img src="/roa/framework/media/images/grid/close.png" />
		 </a>
		</td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>	  
	  {/foreach}	
	</tbody>
  </table>



  <table>
  <tr id="clon">
	<td>
	<input type="text" name="orden_det_ruta" value="" size="1" readonly="readonly" /><input type="hidden" name="detalle_ruta_id" value="" />
   </td>
	<td>
	  <input type="text" name="ubicacion" id="ubicacion" size="70" />
	  <input name="ubicacion_id" id="ubicacion_hidden" type="hidden" value="" />
	  <input name="punto_referencia_id" id="punto_referencia_id" type="hidden" value="" />         
	</td>
	{*<td><input type="text" name="distancia_det_ruta" class="numeric required" size="5" /></td>
	<td><input type="text" name="tiempo_det_ruta" class="numeric required" size="5" /></td>
	<td><input type="text" name="tiporef" value="" class="required" readonly="readonly" /></td>   *}
	<td><input type="text" name="refe" value="" class="required" size="27" readonly="readonly" /></td> 
	<td><a name="saveNewDetalle" href="javascript:void(0)" onClick="agregar(this)"><img src="../../../framework/media/images/grid/add.png" /></a></td>                                
	<td><a href="javascript:void(0)" onClick="deleteDetalleRuta(this)"><img src="/roa/framework/media/images/grid/close.png" /></a></td>
	<td><input type="checkbox" name="procesar" /></td>
  </tr>
  </table>	 
  </body>
</html>