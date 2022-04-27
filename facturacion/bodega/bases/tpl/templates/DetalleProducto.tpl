<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>

   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="sistemas_informaticos/bodega/bases/css/bootstrap1.css">

  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

<body>
    <div align="center">
    <input type="hidden" id="producto_id" value="{$PRODUCTOID}" />
    <table id="tableDetalle" align="center" class="table" style="width: 610px;">
        <thead>
            <tr>
                <th colspan="4" style="text-align: center">PRECIO DE COMPRA</th>                
            </tr>
             <tr>
                <th colspan="1" style="text-align: center">CONCEPTO</th>   
                <th colspan="1" style="text-align: center">VALOR</th>  
                 <th style="text-align: center">FECHA</th>   
                 <th style="text-align: center">GUARDAR</th>            
            </tr>

           
        </thead>
    	<tbody> 
    		{foreach name=detalle_solicitud from=$DETALLES item=d} 
        	<tr>        
                <td>Ultimo Costo</td>
                
                <input type="hidden" name="detalle_precios_id" id="detalle_precios_id" value="{$d.detalle_precios_id}"/>
                <td><input type="text" name="valor" id="valor" align="right" value="{$d.valor}" class="default" /></td> 
                <td><input type="date" name="fecha"  value="{$d.fecha}" class="dtp"/></td>
                <td><a name="saveDetalleCosto"><img src="sistemas_informaticos/framework/media/images/grid/save.png" /></a></td>
            <tr>
                <td>Costo 1</td>      
               <td><input type="text" name="valor" id="valor" align="right" value="{$d.valor_ult1}" class="default" /></td>
               <td><input type="date" name="fecha"  value="{$d.fecha_ult1}" class="dtp"/></td>
                <td></td>      
        	</tr>  
            <tr>
                <td>Costo 2</td>      
                <td><input type="text" name="valor" id="valor" align="right" value="{$d.valor_ult2}" class="default" /></td>
                <td><input type="date" name="fecha"  value="{$d.fecha_ult2}" class="dtp"/></td>
                <td></td>    
            </tr>
            <tr>
                <td>Costo 3</td>      
                <td><input type="text" name="valor" id="valor" align="right" value="{$d.valor_ult3}" class="default" /></td>
                <td><input type="date" name="fecha"  value="{$d.fecha_ult3}" class="dtp"/></td>
                <td></td>     
            </tr>  
        {/foreach}
           
        </tbody>
    </table>
    <table id="tableDetalle" align="center" class="table" style="width: 610px;">
        <thead>
            <tr>
                <th style="text-align: center" colspan="4">PRECIOS DE VENTA</th>              
            </tr>
            <tr>
                <th style="text-align: center" colspan="1">CONCEPTO</th>
                <th style="text-align: center" colspan="1">VALOR</th> 
                <th style="text-align: center" >FECHA</th> 
                <th style="text-align: center">GUARDAR</th>                  
            </tr>
           
        </thead>
        <tbody> 
        	{foreach name=detalle_solicitud from=$DETALLES item=d}
            <tr>        
                <td>Precio Regular</td>
                
                <input type="hidden" name="detalle_precios_id" id="detalle_precios_id" value="{$d.detalle_precios_id}" />
                <td><input type="text" name="valor" id="valor_venta1" align="right" title="valor_venta" value="{$d.valor_venta1}" class="default" /></td> 
                <td><input type="date" name="fecha"  value="{$d.fecha}" class="dtp"/></td>
                <td><a name="saveDetalleVenta"><img src="sistemas_informaticos/framework/media/images/grid/save.png" /></a></td>
            <tr>
                <td>Precio Especial</td>    
                <input type="hidden" name="detalle_precios_id" id="detalle_precios_id" value="{$d.detalle_precios_id}" />  
                <td><input type="text" name="valor" id="valor_venta2" align="right" title="valor_venta" value="{$d.valor_venta2}" class="default" /></td>
                <td><input type="date" name="fecha"  value="{$d.fecha}" class="dtp"/></td>
                <td><a name="saveDetalleVenta"><img src="sistemas_informaticos/framework/media/images/grid/save.png" /></a></td>      
            </tr>  
            
             {/foreach}
                
        </tbody>
    </table>
    </div>
</body>
</html>