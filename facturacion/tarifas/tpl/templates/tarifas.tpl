<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   
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
            <td><label>Origen  : </label></td><td>{$TARIFASID}{$ORIGEN}{$ORIGENID}</td>
            <td><label>Destino : </label></td><td>{$DESTINO} {$DESTINOID}</td>
          </tr>
          <tr>
            <td><label>Tipo Veh&iacute;culo :</label></td>
            <td align="left">{$VEHICULOID}</td>
            <td><label>Periodo</label></td>
            <td>{$PERIODO}</td>
          </tr>
          <tr>
            <td><label>Valor Cupo Inicial  : </label></td><td align="left">{$CUPO}</td>
            <td><label>Valor Cupo Final : </label></td><td align="left">{$CUPOFIN}</td>
          </tr>
          <tr>
            <td><label>Valor Tonelada Inicial : </label></td><td>{$TONELADA}</td>
            <td><label>Valor Tonelada Final : </label></td><td>{$TONELADAFIN}</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          
          <tr>
            <td><label>Valor Volumen (m3) Inicial : </label></td><td>{$VOLUMEN}</td>
            <td><label>Valor Volumen (m3) Final : </label></td><td>{$VOLUMENFIN}</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
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
         
         <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
        {$FORM1END}
    </fieldset>
    
  </body>
</html>
