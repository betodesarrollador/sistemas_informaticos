<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <!--<input type="hidden" id="factura_id" value="{$factura_id}" />-->
  <table align="center" id="tableDetalles" width="98%">
  <thead>
      <tr>
        <th>CODIGO</th>
        <th>TERCERO</th>
        <th>CC</th>
        <th>DESCRIPCION</th>		
        <th>BASE</th>
        <th>DEBITO</th>
        <th>CREDITO</th>        
      </tr>
	</thead>
	<tbody>
  
	  {foreach name=detalles from=$DETALLES item=i}

    <tr>

        <td><input type="hidden" name="item_abono_id" value="{$i.item_abono_id}"/>
            <input type="hidden" name="abono_factura_id" value="{$i.abono_factura_id}"/>
            <input type="hidden" name="relacion_abono_id" value="{$i.relacion_abono_id}"/>
            <input type="hidden" name="puc_id" value="{$i.puc_id}" maxlength="10" size="10" />
            <input type="text" name="codigo_puc" value="{$i.codigo_puc}" maxlength="10" size="10" /></td>
        <td><input type="hidden" name="tercero_id" value="{$i.tercero_id}" maxlength="15" size="12" />
            <input type="text" name="numero_identificacion" value="{$i.numero_identificacion}" maxlength="15" size="12" /></td>
        <td><input type="hidden" name="centro_de_costo_id" value="{$i.centro_de_costo_id}" maxlength="15" size="12" />
            <input type="text" name="codigo_centro_costo" value="{$i.codigo_centro_costo}" maxlength="10" size="6" /></td>  
        <td><input type="text" name="desc_abono" value="{$i.desc_abono}" maxlength="45" size="35" /></td>
        <td><input type="text" name="base_abono" class="numeric" value="{$i.base_abono}" maxlength="15" size="12" readonly disabled /></td>      
        <td><input type="text" name="deb_item_abono" class="numeric" value="{$i.deb_item_abono}" maxlength="15" size="12" /></td>        
        <td><input type="text" name="cre_item_abono" class="numeric" value="{$i.cre_item_abono}" maxlength="15" size="12" /></td>

    </tr>
     
	  {/foreach}

	</tbody>
  </table>
  </body>

</html>