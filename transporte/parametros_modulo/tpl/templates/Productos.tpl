<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <div align="center">
  <table id="tableSolicitudServicios" width="97%" align="center">
   <thead>
    <tr>
     <th>CODIGO</th>	
     <th>DESCRIPCION ESTANDAR</th>
     <th>DESCIPCION EMPRESA</th>          
     <th>MOSTRAR EN REMESAR</th>    
	 <th>GUARDAR</th>           	 
    </tr>
    </thead>
    
    <tbody>

    {foreach name=productos from=$PRODUCTOS item=p}
    <tr>
	 <td>
	   <input type="hidden" name="producto_id" id="producto_id" value="{$p.producto_id}" />
	   <input type="text" name="codigo" id="codigo" value="{$p.codigo}" readonly /></td>
     <td>
	   <input type="text" autocomplete="off" name="producto" id="producto" value="{$p.producto}" class="required" size="50" readonly />
	 </td>
     <td>
	   <input type="text" autocomplete="off" name="producto_empresa" id="producto_empresa" value="{$p.producto_empresa}" class="required" size="50"  />
	 </td>
	 <td><input type="checkbox" name="mostrar" id="mostrar" {if $p.mostrar}checked{/if} /></td>  
	 <td><img name="guardar" id="guardar" src="../../../framework/media/images/grid/save.png" /></td>
	</tr>
	{/foreach}     
	
	</tbody> 

  </table>
  </div>
  </body>
</html>