<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Solicitud de Servicio - Online Tools™</title></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}  

    <fieldset>
      <legend>{$TITLEFORM}</legend>

        {$OFICINAHIDDEN}
        {$OFICINAIDHIDDEN}

	    {$FORM1}
        <table align="center">
          <tbody>
          <tr>
            <td><label>Cliente : </label></td><td colspan="3">{$CLIENTE}{$CLIENTEID}</td>
          </tr>
		  
          <tr><td colspan="4">&nbsp;</td></tr>
      </tbody>
      </table>
      
        <div><iframe id="detalleCamposArchivoCliente" class="editableGrid"></iframe></div>
        <div align="right">{$GUARDAR}</div>
      {$FORM1END}
    </fieldset>
    
  </body>
 </html>