<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="cliente_id" value="{$CLIENTEID}" />
  <table align="center" id="tableContactos">
    <thead>
      <tr>
        <th>NOMBRE</th>
        <th>CARGO</th>
        <th>DIRECCION</th>
        <th>TELEFONO</th>
        <th>MOVIL</th>
        <th>EMAIL</th>
        <th>ESTADO</th>
        <th>&nbsp;</th>
        <th><input type="checkbox" id="checkedAll"></th>
      </tr>
	</thead>
	<tbody>
	  {foreach name=detalles from=$CONTACTOS item=d}
      <tr>
        <td><input type="hidden" name="contacto_id" value="{$d.contacto_id}" /><input type="text" name="nombre_contacto" value="{$d.nombre_contacto}" class="alphanum_space required" /></td>
        <td><input type="text" name="cargo_contacto" value="{$d.cargo_contacto}" class="alphanum_space required" /></td>
        <td><input type="text" name="dir_contacto" value="{$d.dir_contacto}" class="alphanum_space required" /></td>
        <td><input type="text" name="tel_contacto" value="{$d.tel_contacto}" class="numeric required" /></td>
        <td><input type="text" name="cel_contacto" value="{$d.cel_contacto}" class="numeric required" /></td>
        <td><input type="text" name="email_contacto" value="{$d.email_contacto}" class="email required" /></td>
        <td><input type="text" name="estado_contacto" id="estado_contacto" value="{$d.estado_contacto}" /><input type="hidden" name="estado_contacto_id" value="{$d.estado_contacto_id}" id="estado_contacto_hidden" class="numeric required" /></td>
        <td><a name="saveContacto"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>	  
	  {/foreach}	
      <tr>
        <td><input type="hidden" name="contacto_id" value="" /><input type="text" name="nombre_contacto" class="alphanum_space required"/></td>
        <td><input type="text" name="cargo_contacto" class="alphanum_space required"/></td>
        <td><input type="text" name="dir_contacto" class="alphanum_space required"/></td>
        <td><input type="text" name="tel_contacto" class="numeric required"/></td>
        <td><input type="text" name="cel_contacto" class="numeric required"/></td>
        <td><input type="text" name="email_contacto" class="email required"/></td>
        <td><input type="text" name="estado_contacto" id="estado_contacto" /><input type="hidden" name="estado_contacto_id" id="estado_contacto_hidden" class="numeric required"/></td>
        <td><a name="saveContacto"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>
      <tr id="clon">
        <td><input type="hidden" name="contacto_id" value="" /><input type="text" name="nombre_contacto" class="alphanum_space required"/></td>
        <td><input type="text" name="cargo_contacto" class="alphanum_space required"/></td>
        <td><input type="text" name="dir_contacto" class="alphanum_space required"/></td>
        <td><input type="text" name="tel_contacto" class="numeric required"/></td>
        <td><input type="text" name="cel_contacto" class="numeric required"/></td>
        <td><input type="text" name="email_contacto" class="email required"/></td>
        <td><input type="text" name="estado_contacto" id="estado_contacto" /><input type="hidden" name="estado_contacto_id" id="estado_contacto_hidden" class="numeric required"/></td>
        <td><a name="saveContacto"><img src="/roa/framework/media/images/grid/save.png" /></a></td>
        <td><input type="checkbox" name="procesar" /></td>
      </tr>	  
	</tbody>
  </table>
  </body>
</html>