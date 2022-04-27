<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}  {$TABLEGRIDCSS}  {$TITLETAB} 
  </head>
  <body>   
  <td> <table align="center" width="50%">
  <tr> <td width="25%"><label>Departamento:</label></td> <td width="50%">{$DESTINO}{$DESTINOID}</td> </tr>	
  <tr> <td><label>Destino:</label></td> <td>{$DESTINO}{$DESTINOID}</td> </tr>	
  <tr> 
  <td><label>Fecha Guia:</label></td> <td>{$FECHAGUIA}</td>
  <td width="25%"><center>{$APLICAR}</center> </td> 
  </tr>	
  </table>
 
    <p>
      <input type="hidden" id="manifiesto_id" value="{$MANIFIESTOID}" />
    {$GRIDGuiaToMC}	
   
    </p>
    <center>{$DESPACHAR}</center>    
  </body>
</html>