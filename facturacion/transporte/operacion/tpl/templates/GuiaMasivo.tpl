<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Generar guia por lotes - Si &amp; Si</title></head><body>
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
          <tr>
           <td><label>Numero Solicitud : </label></td><td colspan="3">{$SOLICITUD}{$SOLICITUDID}</td>
          </tr>
		  
          <tr><td colspan="4">&nbsp;</td></tr>
          <tr><td colspan="4">{$BUSCAR}&nbsp;{$GUARDAR}&nbsp;</td></tr>
          
      </tbody>
      </table>
      
        <div><iframe id="detalleCamposArchivoCliente" class="editableGrid"></iframe></div>
      {$FORM1END}
    </fieldset>
    
  </body>
 </html>