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
		
        <div id="table_find">
        <table align="center">
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
            <td  ><label>Empresa :</label></td>
            <td >{$EMPRESAID}{$FORMULA}</td>
            <td ><label>Codigo : </label></td>
            <td >{$PUC}{$PUCID}{$IMPUESTOID}</td>
          </tr>
          <tr>
            <td><label>Nombre : </label></td>
            <td align="left">{$NOMBRE}</td>
            <td><label>Descripcion : </label></td>
            <td align="left">{$DESCRIPCION}</td>
          </tr>
          <tr>
            <td rowspan="2"><label>Sucursal : </label></td>
            <td rowspan="2">{$OFICINAID}</td>
            <td><label>Tipo Impuesto : </label></td>
            <td>{$EXENTOS}</td>
          </tr>
          <tr>
            <td id="ubica"><label>Ubicaci&oacute;n: </label></td>
            <td>{$UBICACION}{$UBICACIONID}</td>
          </tr>
          
          <tr>
            <td><label>Sub C&oacute;digo: </label></td>
            <td>{$SUBCODIGO}</td>
            <td><label>Naturaleza : </label></td>
            <td>{$NATURALEZA}</td>
          </tr>
           <tr>
           <td><label>Para Terceros : </label></td>
            <td>{$PARATERCEROS}</td>
            <td><label>Ayuda :</label></td>
            <td rowspan="2">{$AYUDA}</td>
          </tr>   
          <tr>
            <td><label>Estado : </label></td>
            <td>{$ESTADO}</td>
            <td>&nbsp;</td>
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
		  <tr>
			<td colspan="4" align="right">
			<table id="toolbar" width="100%">
              <tbody>
                <tr>
                  <td width="89%" id="messages"><div>&nbsp;</div></td>
                  <td width="11%" id="detailToolbar" align="right">
				  <img src="../../../framework/media/images/grid/save.png" id="saveDetallesSoliServi" title="Guardar Seleccionados"> 
				  <img src="../../../framework/media/images/grid/no.gif" id="deleteDetallesSoliServi" title="Borrar Seleccionados"> </td>
                </tr>
              </tbody>
		    </table></td>
		  </tr>
		  <tr>
		    <td colspan="4" align="center"><iframe width="100%" name="frameImpuestos" id="frameImpuestos" src=""></iframe></td>
	      </tr>
    </table>
		 <fieldset>
	     {$FORM1END}
    </fieldset>
    
    <fieldset>
    <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    </fieldset>

   
    
  </body>
</html>
