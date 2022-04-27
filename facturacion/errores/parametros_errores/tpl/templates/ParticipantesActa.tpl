<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <div align="center" class="panel panel-primary">
  <input type="hidden" id="acta_id" value="{$ACTAID}" />
  <table id="tableDetalle" align="center">
   <thead>
    <tr>
     <th>Participante</th>
     <th>Tipo Participante</th>
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>
      {foreach name=detalle_solicitud from=$DETALLES item=d}
      <tr>
        <td>
            <input type="hidden" name="participantes_actas_id" id="participantes_actas_id" value="{$d.participantes_actas_id}" />
            <input type="text" name="participante" value="{$d.participante}" size="83%" class="required" />
        </td>
        <td>
          <select name="tipo_participante" class="required">
            <option value="NULL">(... Seleccione ...)</option>
            <option value="C" {if $d.tipo_participante eq 'C'}selected{/if}>CLIENTE</option>	   
            <option value="P" {if $d.tipo_participante eq 'P'}selected{/if}>PROVEEDOR</option>	   		 
          </select>
        </td>
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>     
      </tr>   
      {/foreach}
      <tr>
        <td>
          <input type="hidden" name="participantes_actas_id" id="participantes_actas_id" value="" />
          <input type="text" name="participante" value="" size="83%" class="required" />
        </td>
        <td>
          <select name="tipo_participante" class="required">
            <option value="NULL">(... Seleccione ...)</option>
            <option value="C">CLIENTE</option>	   
            <option value="P">PROVEEDOR</option>	   		 
          </select>
        </td>
        <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>     
      </tr>       
	  </tbody>
  </table>
  <table>
    <tr id="clon">
      <td>
        <input type="hidden" name="participantes_actas_id" id="participantes_actas_id" value="" />
          <input type="text" name="participante" value="" size="83%" />
      </td>
      <td>
        <select name="tipo_participante" class="required">
          <option value="NULL">(... Seleccione ...)</option>
          <option value="C">CLIENTE</option>	   
          <option value="P">PROVEEDOR</option>	   		 
        </select>
      </td>
      <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
      <td><input type="checkbox" name="procesar" /></td>     
    </tr>      
  </table>
  </div>
  </body>
</html>