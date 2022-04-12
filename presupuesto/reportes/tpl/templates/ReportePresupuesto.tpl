<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
{$JAVASCRIPT}
{$CSSSYSTEM}     
{$TITLETAB}  
</head>
<body>	
		<fieldset>
    <legend>{$TITLEFORM}</legend>
		{$FORM1}    
  		<fieldset class="section">
        <table align="center">        
          <tbody>
          <tr>
            <td><label>Presupuesto: </label></td><td>{$PRESUPUESTOID}</td>
            <td>&nbsp;</td>
            <td><label for="enero">Enero</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="enero" id="enero" value="1" /></td>
            <td><label for="febrero">Febrero</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="febrero" id="febrero" value="1" /></td>
            <td><label for="marzo">Marzo</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="marzo" id="marzo" value="1" /></td>
            <td><label for="abril">Abril</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="abril" id="abril" value="1" /></td>
            <td><label for="mayo">Mayo</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="mayo" id="mayo" value="1" /></td>
            <td><label for="junio">Junio</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="junio" id="junio" value="1" /></td>
          </tr>
          <tr>
            <td><label for="todos">Todos</label></td>
            <td><input type="checkbox"  name="todos" id="todos" value="0" /></td>
            <td>&nbsp;</td>
            <td><label for="julio">Julio</label></td>                        
            <td><input type="checkbox"  class="mes_contable"  name="julio" id="julio" value="1" /></td>            
            <td><label for="agosto">Agosto</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="agosto" id="agosto" value="1" /></td>
            <td><label for="septiembre">Septiembre</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="septiembre" id="septiembre" value="1" /></td>
            <td><label for="octubre">Octubre</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="octubre" id="octubre" value="1" /></td>
            <td><label for="noviembre">Noviembre</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="noviembre" id="noviembre" value="1" /></td>
            <td><label for="diciembre">Diciembre</label></td>
            <td><input type="checkbox"  class="mes_contable"  name="diciembre" id="diciembre" value="1" /></br></td>
            
          </tr>
          <tr>            
            <td rowspan="3" colspan="16" align="center"> 
            <input type="button" name="consultar" id="consultar" value="Consultar" class="buttondefault" />{$IMPRIMIR}&nbsp;{$DESCARGAR}
            </td>            
          </tr>
          </tbody>
          </table>
     </fieldset>
	<table width="100%">   
		<div><iframe id="detallePresupuesto" class="editableGrid" style="height:650px"></iframe></div>
     </table>         
      {$FORM1END}
     </fieldset>
   

  </body></html>