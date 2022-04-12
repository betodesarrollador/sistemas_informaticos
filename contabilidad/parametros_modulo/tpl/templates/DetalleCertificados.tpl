<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <div align="center">
  <input type="hidden" id="certificados_id" value="{$CERTIFICADOSID}" />
  <table id="tableDetalle" align="center">
   <thead>
    <tr>
     <th >PUC</th>
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>
    {foreach name=detalle from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="cuentas_certificado_id" id="cuentas_certificado_id" value="{$d.cuentas_certificado_id}" />
	   <input type="text" name="puc" value="{$d.nombre}" size="60" class="required" />
	   <input type="hidden" name="puc_id" value="{$d.puc_id}" class="required" />
      </td>
	 <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
    <tr>
	 <td>
	   <input type="hidden" name="cuentas_certificado_id" id="cuentas_certificado_id" value="" />
	   <input type="text" name="puc" value="" size="60" class="required" />
	   <input type="hidden" name="puc_id" value="" class="required" />
      </td>
	 <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>       
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	   <input type="hidden" name="cuentas_certificado_id" id="cuentas_certificado_id" value="" />
	   <input type="text" name="puc" value="" size="60" />
	   <input type="hidden" name="puc_id" value="" />
      </td>
	 <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>      
  </table>
  </div>
  </body>
</html>