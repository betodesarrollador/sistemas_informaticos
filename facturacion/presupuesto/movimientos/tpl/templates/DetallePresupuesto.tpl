<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <form name="detallePresupuesto" action="DetallePresupuestoClass.php" method="post" target="_self">
  <input type="hidden" id="presupuesto_id" value="{$PRESUPUESTOID}" />
  <table id="tablePresupuesto" width="100%">
   <thead>
    <tr>
     <th>QUITAR</th>
     <th>CUENTA</th>	
     <th>CODIGO</th>
     <th>ENERO</th>
     <th>FEBRERO</th>          
     <th>MARZO</th>               	 
     <th>ABRIL</th>               
     <th>MAYO</th>               
     <th>JUNIO</th>          
     <th>JULIO</th>                    
     <th>AGOSTO</th>         
     <th>SEPTIEMBRE</th>         	 
     <th>OCTUBRE</th>                                         
     <th>NOVIEMBRE</th>                                   
     <th>DICIEMBRE</th>                              
     <th>TOTAL</th>  
     <th><input type="checkbox" id="checkedAll"></th>
    </tr>
    </thead>
    
    <tbody>
    
     {assign var="totalEnero"      value="0"}	
     {assign var="totalFebrero"    value="0"}
     {assign var="totalMarzo"      value="0"}
     {assign var="totalAbril"      value="0"}
     {assign var="totalMayo"       value="0"}
     {assign var="totalJunio"      value="0"}
     {assign var="totalJulio"      value="0"} 
     {assign var="totalAgosto"     value="0"}
     {assign var="totalSeptiembre" value="0"}
     {assign var="totalOctubre"    value="0"}                         
     {assign var="totalNoviembre"  value="0"}                                                 
     {assign var="totalDiciembre"  value="0"}
     {assign var="total"           value="0"}          
    

    {foreach name=detalle from=$DETALLES item=d}
    
     <tr class="presupuesto">
      <td><img src="../../../framework/media/images/grid/close.png"  style="cursor:pointer" onclick="deleteRow(this,{$d.detalle_presupuesto_id})" /></td>
      <td>
       <input name="puc_id" type="hidden"  value="{$d.puc_id}" class="detalle_presupuesto" />      
       <input name="cuenta" type="text"    value="{$d.nombre_cuenta}" size="40" readonly />
      </td>     
      <td>{$d.codigo_puc}</td>
      <td><input name="enero"        type="text"      value="{$d.enero}" class="numeric detalle_presupuesto" /></td>	
      <td><input name="febrero"      type="text"      value="{$d.febrero}" class="numeric detalle_presupuesto" /></td>
      <td><input name="marzo"        type="text"      value="{$d.marzo}" class="numeric detalle_presupuesto" /></td>          
      <td><input name="abril"        type="text"      value="{$d.abril}" class="numeric detalle_presupuesto" /></td>               	 
      <td><input name="mayo"         type="text"      value="{$d.mayo}" class="numeric detalle_presupuesto" /></td>               
      <td><input name="junio"        type="text"      value="{$d.junio}" class="numeric detalle_presupuesto" /></td>               
      <td><input name="julio"        type="text"      value="{$d.julio}" class="numeric detalle_presupuesto" /></td>          
      <td><input name="agosto"       type="text"      value="{$d.agosto}" class="numeric detalle_presupuesto" /></td>                    
      <td><input name="septiembre"   type="text"      value="{$d.septiembre}" class="numeric detalle_presupuesto" /></td>         
      <td><input name="octubre"      type="text"      value="{$d.octubre}" class="numeric detalle_presupuesto" /></td>         	 
      <td><input name="noviembre"    type="text"      value="{$d.noviembre}" class="numeric detalle_presupuesto" /></td>                                         
      <td><input name="diciembre"    type="text"      value="{$d.diciembre}" class="numeric detalle_presupuesto" /></td>                                                                 
      <td><input name="total_cuenta" type="text"      value="{$d.total_cuenta}" class="numeric detalle_presupuesto" /></td> 
      <td><input type="checkbox" name="procesar" /></td>         
     </tr>
     
     
     
     {assign var="totalEnero"      value="`$totalEnero+$d.enero`"}
     {assign var="totalFebrero"    value="`$totalFebrero+$d.febrero`"}
     {assign var="totalMarzo"      value="`$totalMarzo+$d.marzo`"}
     {assign var="totalAbril"      value="`$totalAbril+$d.abril`"}
     {assign var="totalMayo"       value="`$totalMayo+$d.mayo`"}
     {assign var="totalJunio"      value="`$totalJunio+$d.junio`"}
     {assign var="totalJulio"      value="`$totalJulio+$d.julio`"}
     {assign var="totalAgosto"     value="`$totalAgosto+$d.agosto`"}
     {assign var="totalSeptiembre" value="`$totalSeptiembre+$d.septiembre`"}
     {assign var="totalOctubre"    value="`$totalOctubre+$d.octubre`"}
     {assign var="totalNoviembre"  value="`$totalNoviembre+$d.noviembre`"}
     {assign var="totalDiciembre"  value="`$totalDiciembre+$d.diciembre`"}
     {assign var="total"           value="`$total+$d.total_cuenta`"}
    
    {/foreach}  
    </tbody>
    <tfoot> 
     <tr>
     <td>&nbsp;</td>
     <td align="right" colspan="2">Totales</td>     
     <td><input id="total_enero"        type="text" value="{$totalEnero|number_format:0:",":"."}" readonly /></td>	
     <td><input id="total_febrero"      type="text" value="{$totalFebrero|number_format:0:",":"."}" readonly /></td>
     <td><input id="total_marzo"        type="text" value="{$totalMarzo|number_format:0:",":"."}" readonly /></td>
     <td><input id="total_abril"        type="text" value="{$totalAbril|number_format:0:",":"."}" readonly /></td>
     <td><input id="total_mayo"         type="text" value="{$totalMayo|number_format:0:",":"."}" readonly /></td>
     <td><input id="total_junio"        type="text" value="{$totalJunio|number_format:0:",":"."}" readonly /></td>
     <td><input id="total_julio"        type="text" value="{$totalJulio|number_format:0:",":"."}" readonly /></td> 
     <td><input id="total_agosto"       type="text" value="{$totalAgosto|number_format:0:",":"."}" readonly /></td>
     <td><input id="total_septiembre"   type="text" value="{$totalSeptiembre|number_format:0:",":"."}" readonly /></td>
     <td><input id="total_octubre"      type="text" value="{$totalOctubre|number_format:0:",":"."}" readonly /></td>                         
     <td><input id="total_noviembre"    type="text" value="{$totalNoviembre|number_format:0:",":"."}" readonly /></td>                                                 
     <td><input id="total_diciembre"    type="text" value="{$totalDiciembre|number_format:0:",":"."}" readonly /></td>
     <td><input id="total"              type="text" value="{$total|number_format:0:",":"."}" /></td>  
     <td><input type="checkbox" name="procesar" /></td>             
    </tr>  
    </tfoot>  
  </table>
  </form>
  </body>
</html>