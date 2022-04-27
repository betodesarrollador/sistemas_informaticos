<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
 
  {$CSSSYSTEM}
  
  {$TITLETAB}  
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table  align="center">
                            <tr>
                            <td><label>Busqueda : </label></td>
                            </tr>
                            <tr>
                            <td>{$BUSQUEDA}</td>
                            </tr>
                            </table>
        </div>
        
        {$FORM1}
        <fieldset class="section">
        <table align="center">
          <tr>
            <td><label>No. Resoluci&oacute;n DIAN: </label></td><td>{$PARAMEID}{$RESOLUCION}</td>
            <td><label>Tipo: </label></td><td>{$TIPO}</td>
          </tr>
          <tr>
            <td><label>Fecha Resoluci&oacute;n DIAN: </label></td><td>{$FECHARES}</td>
            <td><label>Fecha Vencimiento: </label></td><td>{$FECHAVENRES}</td>
          </tr>
          <tr>
            <td><label>Prefijo: </label></td><td>{$PREFIJO}</td>
            <td><label>Tipo Factura: </label></td><td>{$TIPOFACT}</td>
          </tr>
          <tr>
            <td><label>Resoluci&oacute;n Electr&oacute;nica: </label></td><td>{$FACTELECT}</td>
            <td><label>Folios Restantes: </label></td><td>{$FOLIOSREST}</td>
            
          </tr>
          
          <tr>
            <td><label>Tipo Documento: </label></td><td>{$TIPODOC}</td>
            <td><label>Oficina: </label></td><td>{$OFICINA}</td>
          </tr>
          
          <tr>
            <td><label>Rango Inicial: </label></td><td>{$RANGOINICIAL}</td>
            <td><label>Rango Final: </label></td><td>{$RANGOFINAL}</td>
          </tr>

          <tr>
                <td><label>Fuente Facturaci&oacute;n : </label></td>
                <td>{$FUENTEFACTURACIONCOD}</td>
          </tr>
          
          <tr>
            <td><label>Observaci&oacute;n Uno: </label></td><td>{$OBSERUNO}</td>
            <td><label>Observaci&oacute;n Dos: </label></td><td>{$OBSERDOS}</td>
          </tr>

          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>
        {$FORM1END}
    </fieldset>
    
    <fieldset>
      <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    </fieldset>
    
  </body>
</html>
