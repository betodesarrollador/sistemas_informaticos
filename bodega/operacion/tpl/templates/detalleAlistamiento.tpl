<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01//EN""http://www.w3.org/TR/html4/strict.dtd">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8">
 {$JAVASCRIPT}
 {$CSSSYSTEM}
 {$ALISTAMIENTOSID}
</head>

<body>
 
  <table align="center" id="tableDetalleAlistamiento" width="100%">
    <thead>
      <tr>
        <th>CANTIDAD</th>
        <th>PRODUCTO</th>
        <th>SERIAL</th>
        <!--<th>ENTRADA</th>-->
        <th>UBICACION BODEGA</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
    </thead>


    <tbody>

      {foreach name=detallesAlistamiento from=$DETALLESALISTAMIENTOS item=i}
      <tr>
         <td>  <input type="text"   name="cantidad"                    id="cantidad"                    value="{$i.cantidad}"       class="required numeric" style="text-align:center" /> 
               <input type="hidden" name="alistamiento_salida_detalle_id"                  id="alistamiento_salida_detalle_id"               value="{$i.alistamiento_salida_detalle_id}" /></td>
         <td> <input type="text"    name="producto"               id="producto"                value="{$i.producto}" class="required" style="text-align:center"/><input        type="hidden"  name="producto_id"   id="producto_id"   value="{$i.producto_id}" /></td>

         <td> <input type="text"    name="serial"              id="serial"              value="{$i.serial}"  class="required" style="text-align:center" /> </td>
          <!--<td> <input type="text"    name="entrada"               id="entrada"                value="{$i.entrada}" class="required" style="text-align:center"/><input        type="hidden"  name="entrada_id"   id="entrada_id"   value="{$i.entrada_id}" /></td> -->

         <td> <input type="text"    name="ubicacion_bodega"               id="ubicacion_bodega"                value="{$i.ubicacion_bodega}" class="required"/><input        type="hidden"  name="ubicacion_bodega_id"   id="ubicacion_bodega_id"   value="{$i.ubicacion_bodega_id}" /></td> 

         <td> <a name="saveDetalleAlistamiento"   onclick="saveDetalleAlistamiento(this);">  <img src="../../../framework/media/images/grid/save.png" /></a> </td>
         <td> <a name="deleteDetalleAlistamiento" onclick="deleteDetalleAlistamiento(this);"><img src="../../../framework/media/images/grid/no.gif" /></a> </td>

         <td><input type="checkbox" name="procesar" /></td>

      </tr> 	  
      
      {/foreach}

       <tr>
         <td>  <input  type="text"    name="cantidad"                    id="cantidad"                   value="" style="text-align:center" class="required numeric"/> 
         <input        type="hidden"  name="alistamiento_salida_detalle_id"   id="alistamiento_salida_detalle_id"  value="" /></td>
         <td> <input type="text"    name="producto"               id="producto"                value="" class="required" style="text-align:center"/><input        type="hidden"  name="producto_id"   id="producto_id"   value="" /></td>

         <td>  <input  type="text"    name="serial"              id="serial"             value="" style="text-align:center" class="required"/> </td>

         <!-- <td> <input type="text"    name="entrada"               id="entrada"                value="" class="required" style="text-align:center"/><input        type="hidden"  name="entrada_id"   id="entrada_id"   value="" /></td> -->

         <td>   <input type="text"    name="ubicacion_bodega"               id="ubicacion_bodega"                value="" class="required"/><input        type="hidden"  name="ubicacion_bodega_id"   id="ubicacion_bodega_id"   value="" /></td>

         <td> <a name="saveDetalleAlistamiento"   onclick="saveDetalleAlistamiento(this);">  <img src="../../../framework/media/images/grid/save.png" /></a> </td>
         <td> <a name="deleteDetalleAlistamiento" onclick="deleteDetalleAlistamiento(this);"><img src="../../../framework/media/images/grid/no.gif" /></a> </td>

         <td><input type="checkbox" name="procesar" /></td>

      </tr> 

    </tbody>
  </table>


 <table width="98%" align="center">
 
      <tr id="clon">
          <td>  <input  type="text"    name="cantidad"                   id="cantidad"                    value="" style="text-align:center" class="required numeric"/> 
         <input        type="hidden"  name="alistamiento_salida_detalle_id"   id="alistamiento_salida_detalle_id"   value="" /></td>
         <td> <input type="text"    name="producto"               id="producto"                value="" class="required" style="text-align:center"/><input        type="hidden"  name="producto_id"   id="producto_id"   value="" /></td>

         <td>  <input  type="text"    name="serial"              id="serial"              value="" style="text-align:center" class="required" /> </td>

        <!--  <td> <input type="text"    name="entrada"               id="entrada"                value="" class="required" style="text-align:center"/><input        type="hidden"  name="entrada_id"   id="entrada_id"   value="" /></td>  -->

         <td>   <input type="text"    name="ubicacion_bodega"               id="ubicacion_bodega"                value="" class="required"/><input        type="hidden"  name="ubicacion_bodega_id"   id="ubicacion_bodega_id"   value="" /></td>

         <td> <a name="saveDetalleAlistamiento"   onclick="saveDetalleAlistamiento(this);">  <img src="../../../framework/media/images/grid/save.png" /></a> </td>
         <td> <a name="deleteDetalleAlistamiento" onclick="deleteDetalleAlistamiento(this);"><img src="../../../framework/media/images/grid/no.gif" /></a> </td>

         <td><input type="checkbox" name="procesar" /></td>

      </tr>	 
    </table>


  </body>
  </html>