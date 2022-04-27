<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        {$FORM1}

         <fieldset class="section">
        
        <table align="center" width="90%">
            <tr>
                <td><label>DEPARTAMENTO</label></td>            
                <td>{$DEPARTAMENTO}{$DEPARTAMENTOID}</td>
                <td colspan="2"><label>CLIENTE</label></td>            
            </tr>            
            <tr>
                <td><label>DESTINO</label></td>            
                <td>{$DESTINO}{$DESTINOID}</td>
                <td colspan="2">{$CLIENTE}{$CLIENTEID}</td>       
            </tr>
            <tr>
                <td><label>FECHA</label></td>            
                <td>{$FECHAGUIA}</td>
                <td>{$APLICAR}</td>    
                <td>{$LIMPIAR}{$REEXPEDIDOID}</td>             
            </tr>
        </table>
        </fieldset>
		<table width="100%">
			<tr><td colspan="7"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0" style="height:200px;"></iframe></td></tr>
		</table>   
    <center>{$DESPACHAR}</center>        
		{$FORM1END}
	</fieldset>   
 
</body>
</html>