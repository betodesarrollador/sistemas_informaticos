<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>  
<meta http-equiv="content-type" content="text/html; charset=utf-8">
{$JAVASCRIPT} {$TABLEGRIDJS} {$CSSSYSTEM} {$TABLEGRIDCSS} {$TITLETAB}
</head>
<body>
<fieldset> <legend>{$TITLEFORM}</legend>
<div id="table_find">
<table>
  <tbody>
    <tr>
      <td><label>Busqueda : </label></td>
      <td>{$BUSQUEDA}</td>
	  <td align="center"><h3><font color="#FF0000"><b>MANIFIESTO MENSAJERIA</b></font></h3></td>	  
    </tr>
  </tbody>
</table>
</div>
<fieldset>

<p>{$EMPRESAIDSTATIC}{$OFICINAIDSTATIC}{$FECHASTATIC}
  {$FORM1} 
  {$USUARIOID}{$OFICINAID}{$USUARIOREGISTRA}{$USUARIONUMID}</p>
<table align="center" width="95%">
  <tbody>
    <tr>
      <td align="center">
      <fieldset class="section">
	  <legend>MANIFIESTO</legend>
      <table align="center">
        <tbody>
          <tr>
            <td><label>Manifiesto No :</label></td><td>{$REEXPEDIDO}{$REEXPEDIDOID}{$UPDATEREEXPEDIDO}</td>
            <td><label>Fecha :</label></td><td>{$FECHA}</td>
          </tr>
          <tr>
            <td><label>Origen :</label></td><td>{$ORIGEN}{$ORIGENID}</td>
            <td><label>Destino :</label></td><td>{$DESTINO}{$DESTINOID}</td>
          </tr>  
          <tr>
            <td><label>Mensajero :</label></td><td>{$PROVEEDOR}{$PROVEEDORID}</td>
            <td><label>Observaciones :</label></td><td>{$OBSERVACIONES}</td>
          </tr>
          <tr>
            <td><label>Estado :</label></td><td>{$ESTADO}</td>
          </tr>                 
        </tbody>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
      <td align="center">
	   <table width="100%" align="center">
	    <tr>
		 <td align="left">{$CONTINUAR}</td>
		 <td align="right">{$SELECCIONARGUIAS}</td>
		</tr>
	  </table>
	  </td>
	</tr>
    <tr>
      <td>
        <fieldset class="section" id="guiaReexpedido"> 
          <legend>GUIAS</legend>
          <iframe id="detalleReexpedido" src=""></iframe>
          </fieldset>
        </td>
      </tr>        
</table>
</fieldset>

<div align="center" id="divToolBarButtons">{$DESPACHAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$EXCEL}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}</div>

{$FORM1END} 

<div id="divGuia" style="display:none;" style="height:400px;" > <iframe id="iframeGuia" style="height:400px;"></iframe> </div>

<div id="divAnulacion">
  <form onSubmit="return false">
	<table>              
	  <tr>
		<td><label>Causal :</label></td>
		<td>{$CAUSALANULACIONID}</td>
	  </tr>
	  <tr>
		<td><label>Descripcion :</label></td>
		<td>{$OBSERVANULACION}</td>
	  </tr> 
	  <tr>
		<td colspan="2" align="center">{$ANULAR}</td>
	  </tr>                    
	</table>
  </form>
</div>

<div>{$GRIDREEXPEDIDOS}</div>

</body>
</html>