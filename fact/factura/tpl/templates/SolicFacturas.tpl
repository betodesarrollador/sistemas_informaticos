<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}
  {$TABLEGRIDCSS}
  </head>

  <body>
    <input type="checkbox" onClick="checkAll(this);" id="checkAll" /><span style="font-size:12px; font-style: oblique; font-weight: bold; color:white">CHECK ALL</span>
    {$GRIDSolicFacturas}
	
    <center>{$ADICIONAR}</center>
    {$FUENTE}
	<input type="hidden" name="tipo_servicio" id="tipo_servicio" value="{$TIPOSERVICIO}" >
  </body>
</html>